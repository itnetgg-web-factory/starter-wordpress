# Guide administrateur : déploiements, incidents et restauration

Pour la personne qui assure le support technique du site. Ce guide complète le [guide utilisateur](guide-utilisateur.md), destiné au client, et renvoie à [`deploiement.md`](deploiement.md) (transport FTPS, configuration) et aux README du [thème](../themes/webfactory-blocks/README.md) et de l'[extension formulaire](../plugins/webfactory-formulaire/README.md).

Les commandes `gh` s'exécutent depuis la copie locale du dépôt du site, en remplaçant `<dépôt>` par `itnetgg-web-factory/<nom-du-site>`. Les commandes `wp` (WP-CLI) s'exécutent en SSH sur l'hébergement, depuis le dossier du site ; chez o2switch, SSH n'est ouvert qu'aux adresses IP autorisées dans cPanel.

## Qui détient quoi

| Élément | Où il vit | Qui le modifie | Comment il revient en arrière |
|---|---|---|---|
| Thème, extension et mu-plugins maison | Git, puis déployés en FTPS | Le support, par pull request | Pull request d'annulation |
| Pages, articles, styles globaux, menus, réglages | Base de données | Le client (pages) et l'administrateur | Révisions WordPress, sinon JetBackup |
| Images et documents | `wp-content/uploads/` | Le client | JetBackup |
| Extensions tierces (The SEO Framework) | Installées depuis WordPress.org | L'administrateur | Version précédente ou JetBackup |
| `wp-config.php` (base, clés, SMTP) | Serveur uniquement | L'administrateur | JetBackup |

Un déploiement ne touche qu'à la première ligne. Une composition insérée dans une page est copiée dans la base : modifier le thème ne change pas les pages existantes.

## Comptes et droits

- **Client : rôle Éditeur**, jamais Administrateur. Il modifie pages, articles et médias, mais n'a accès ni aux extensions, ni aux thèmes, ni à l'éditeur de site, ni aux réglages. Cela protège le site et la mise en page.
- **Support : rôle Administrateur**, compte nominatif, mot de passe fort rangé dans le coffre.
- **Claude Code** : intervient par WP-CLI en SSH, avec une clé propre au compte d'hébergement du client. Aucune passerelle IA (Novamira, MCP) n'est installée sur le site.
- Un compte qui n'a plus d'usage est supprimé, en réattribuant ses contenus à un autre compte.

## Comprendre le circuit d'une modification de code

| Étape | Ce qui se passe |
|---|---|
| Pull request | Contrôles communs : format (`editorconfig`) et secrets (`gitleaks`) |
| Fusion dans `main` | Job **Déploiement (préproduction)**, environnement GitHub `staging` |
| Envoi FTPS | `lftp mirror` de chaque thème et extension maison, puis des mu-plugins maison ; chaque fichier part sous un nom provisoire puis est renommé |
| Témoin | `wp-content/webfactory-deploiement.txt` (commit, date) : à la requête suivante, le mu-plugin `webfactory-deploiement` vide le cache des compositions |
| Vérification | Accueil en HTTP 200 et feuille de style du thème servie dans la version du dépôt |

Les fichiers PHP sont relus par OPcache au plus 60 s après l'envoi. Changer `Version` dans `style.css` à chaque évolution du thème rend la vérification probante.

## Résoudre un déploiement en échec

```bash
gh run list -R <dépôt> --branch main --limit 3
gh run view <run> -R <dépôt> --log-failed
```

| Erreur dans le job « Déploiement » | Cause | Solution |
|---|---|---|
| `Login incorrect` ou `530` | Mot de passe FTP changé ou compte supprimé | Recréer le mot de passe dans cPanel (Comptes FTP), puis `gh secret set FTP_PASSWORD --env staging -R <dépôt>` (saisi au clavier) |
| `Certificate verification` ou `certificate` | `FTP_HOST` ne correspond pas au certificat du serveur | Utiliser le nom du serveur couvert par le certificat (chez o2switch, `<serveur>.o2switch.net`), pas le domaine du site |
| `Connection timed out` | Port 21 fermé ou incident de l'hébergeur | Réessayer plus tard ; si cela persiste, vérifier le port depuis un runner (voir `deploiement.md`) |
| `Access failed: 550` | Dossier absent ou droits insuffisants | Vérifier que le répertoire du compte FTP est bien `wp-content` du site |
| Vérification : version pas encore servie | OPcache ou cache de pages | Attendre 1 minute et relancer ; vider le cache de pages s'il y en a un |
| Vérification : HTTP 500 | Erreur PHP introduite par le code | Lire le journal PHP (voir plus bas), puis annuler par pull request |

Relancer uniquement le job en échec, sans nouvelle fusion :

```bash
gh run rerun <run> -R <dépôt> --failed
```

## Résoudre un incident sur le site

| Symptôme | Cause probable | Solution |
|---|---|---|
| « Il y a eu une erreur critique sur ce site » | Erreur PHP fatale | WordPress envoie à l'e-mail d'administration un lien de **mode de récupération** qui désactive l'élément fautif. Sinon, lire le journal PHP. En urgence, renommer le dossier de l'extension fautive en FTP (`plugins/<extension>` en `plugins/<extension>.off`) |
| Une modification du thème n'apparaît pas sur un modèle ou l'en-tête | Le modèle ou la partie a été personnalisé dans l'éditeur de site : la version en base prime sur le fichier du thème | Apparence › Éditeur › Modèles (ou Compositions › Parties de modèle) › élément › **Réinitialiser**, après avoir vérifié que la personnalisation peut être perdue |
| Une composition modifiée n'apparaît pas dans l'éditeur | Cache des compositions | Vérifier le témoin de déploiement ; à défaut, incrémenter `Version` dans `style.css` |
| Bloc « contient du contenu inattendu ou non valide » | Contenu édité en HTML ou bloc maison modifié | Proposer **Tenter la récupération du bloc** ; sinon rétablir une révision |
| Le site apparaît dans les moteurs de recherche alors qu'il ne devrait pas | Option de visibilité réactivée, par exemple après une restauration complète | Réglages › Lecture › **Demander aux moteurs de recherche de ne pas indexer ce site**, puis vérifier la balise `noindex` |

### Formulaire de contact : messages non reçus

1. Vérifier les courriers indésirables du destinataire.
2. Faire un envoi de test depuis la page, avec un vrai navigateur. Un envoi sans navigateur identifié est rejeté par o2switch avant WordPress (404) : ce n'est pas une panne.
3. cPanel › **Suivi de la livraison** : le message est-il parti, refusé ou mis en attente ?
4. Si la délivrabilité est mauvaise : configurer l'envoi SMTP authentifié (constantes `WEBFACTORY_SMTP_*` dans `wp-config.php`, voir `mu-plugins/webfactory-smtp.php`) avec une boîte du domaine, et vérifier SPF et DKIM.
5. Un visiteur bloqué par « Trop de messages envoyés » a dépassé 5 envois en 10 minutes ; « La page a expiré » signale un jeton de plus de 12 à 24 h, souvent dû à un cache de pages : exclure la page du formulaire du cache.

## Consulter les journaux

| Quoi | Où |
|---|---|
| Contrôles d'une pull request | GitHub › Pull requests › *Checks*, ou `gh pr checks <n> -R <dépôt>` |
| Déploiements | GitHub › Actions, ou `gh run view <run> -R <dépôt> --log` ; commit déployé dans `wp-content/webfactory-deploiement.txt` |
| Erreurs PHP | Fichier `error_log` à la racine du site ; cPanel › Métriques › **Erreurs** |
| Erreurs WordPress détaillées | Temporairement, dans `wp-config.php` : `WP_DEBUG` et `WP_DEBUG_LOG` à `true`, `WP_DEBUG_DISPLAY` à `false` ; journal dans `wp-content/debug.log`. **Remettre à `false` et supprimer le journal après diagnostic** : il peut contenir des données personnelles |
| Santé du site | Outils › Santé du site (versions, modules PHP, HTTPS) |
| E-mails envoyés | cPanel › Suivi de la livraison |

Ne jamais copier un mot de passe, un jeton ou le contenu de `wp-config.php` dans un ticket, un message ou un fichier du dépôt. GitHub masque les secrets dans les journaux (`***`).

## Restaurer une version précédente

| Situation | Méthode | Délai |
|---|---|---|
| Le client a abîmé une page | **Révisions WordPress** : éditeur › Page › Révisions › **Rétablir cette révision** | Immédiat |
| Une évolution du code pose problème | **Pull request d'annulation** : sur GitHub, ouvrir la pull request fusionnée, *Revert*, puis fusionner une fois les contrôles au vert. Le déploiement remet l'ancien code | 3 à 5 minutes |
| Une image ou un fichier a été supprimé | **JetBackup 5** › Sauvegardes de fichiers › *Changer les fichiers* : cocher **uniquement** le fichier, puis *Restaurer* | Quelques minutes |
| Base de données endommagée | **JetBackup 5** › Sauvegardes de bases de données › restaurer la base du site | Quelques minutes |
| Site entier inutilisable | **JetBackup 5** : restauration des fichiers et de la base du site | 10 à 30 minutes |

**Attention aux restaurations complètes** : elles écrasent tout ce qui a changé depuis la sauvegarde (contenus du client, réglages, extensions mises à jour). Constaté le 17/11/2026 : après une restauration du site entier, l'option « ne pas indexer » était revenue à son ancien état. Après une restauration, revérifier : visibilité pour les moteurs, version de PHP, extensions actives, dernier commit déployé (témoin), puis redéployer `main` si le code restauré est plus ancien :

```bash
gh run rerun <dernier run de main> -R <dépôt>
```

Avant toute mise en production ou mise à jour majeure : sauvegarde fichiers + base dans JetBackup, et téléchargement de la sauvegarde de la base.

## Mises à jour

| Quoi | Comment |
|---|---|
| WordPress, versions mineures (sécurité) | Automatiques ; un e-mail est envoyé à l'adresse d'administration |
| WordPress, versions majeures | À la main, après sauvegarde, d'abord en préproduction |
| Extensions tierces | À la main, après sauvegarde ; lire le journal des modifications |
| Thème et extensions maison | Uniquement par Git et déploiement ; jamais modifiés sur le serveur |
| PHP | Sélecteur PHP de cPanel, après vérification de compatibilité ; revérifier les modules (OPcache) |

## Prévenir les incidents

- Rappeler au client les trois règles du guide utilisateur, en particulier **Prévisualiser** avant **Enregistrer** et **dupliquer** plutôt que créer.
- Après chaque déploiement important, vérifier qu'une page modifiée par le client est restée identique.
- Tester la restauration d'un fichier dans JetBackup au moins une fois par an.
- Noter dans le coffre la date de création du mot de passe FTP de déploiement et le changer au moins une fois par an.
- Garder le site de préproduction non indexé, et la production indexée : le vérifier à chaque mise en ligne.

# Déploiement du code par GitHub Actions

Le job `deploy` de `.github/workflows/ci.yml` publie **le code maison** sur le WordPress de préproduction après chaque fusion dans `main`, en **FTPS** (FTP chiffré par TLS, certificat vérifié).

Pourquoi pas SSH : o2switch filtre SSH par adresse IP et les adresses des runners GitHub varient (connexion refusée, constaté le 19/11/2026). FTPS passe, avec un compte FTP limité au dossier `wp-content` du site : il ne voit ni la base, ni `wp-config.php`, ni le reste de l'hébergement.

## Ce qui est déployé, ce qui ne l'est jamais

| Déployé (depuis Git) | Jamais touché |
|---|---|
| `themes/<thème>/` : chaque thème maison, dans son propre dossier | Base de données : pages, articles, réglages, styles globaux, menus |
| `plugins/<extension>/` : chaque extension maison, dans son propre dossier | `wp-content/uploads/` : médias du client |
| `mu-plugins/*.php` : fichiers maison uniquement, sans suppression des autres | Cœur WordPress, `wp-config.php` |
| | Autres thèmes et extensions, dont celles installées par le client |

Une composition insérée dans une page est copiée dans la base : déployer une nouvelle version du thème ne modifie pas les pages existantes. Les modèles et parties modifiés par le client dans l'éditeur de site sont eux aussi en base et prennent le pas sur les fichiers du thème.

## Étapes du job

1. Attente des contrôles communs (format, secrets).
2. `lftp mirror -R --delete --overwrite` de chaque dossier de code maison, sans les fichiers Markdown ; envoi des fichiers maison de `mu-plugins/` sans suppression des autres. Chaque fichier est envoyé sous un nom provisoire (`.depot-*`) puis renommé : aucun fichier n'est absent pendant le déploiement. Un envoi interrompu laisse au pire un fichier provisoire, supprimé au déploiement suivant.
3. Dépôt d'un témoin `wp-content/webfactory-deploiement.txt` (commit et date). Le mu-plugin `webfactory-deploiement` le détecte à la requête suivante et vide le cache des compositions (sinon les compositions modifiées n'apparaissent qu'au changement de version du thème).
4. Vérification : accueil en HTTP 200 et feuille de style du thème servie dans la version du dépôt (jusqu'à 6 essais espacés de 15 s).

Les fichiers PHP sont relus par OPcache au plus 60 s après le déploiement.

## Configuration (environnement GitHub `staging`, limité à `main`)

| Nom | Type | Contenu |
|---|---|---|
| `FTP_PASSWORD` | Secret | Mot de passe du compte FTP de déploiement (créé et saisi par Gérard) |
| `FTP_HOST` | Variable | Serveur FTP, nom couvert par son certificat TLS (chez o2switch : le nom du serveur, par exemple `<serveur>.o2switch.net`) |
| `FTP_USER` | Variable | Compte FTP de déploiement, par exemple `deploiement@<domaine>` |
| `PUBLIC_SITE_URL` | Variable | Adresse publique du site, sans `/` final |

Le compte FTP est créé dans cPanel (Comptes FTP), avec pour répertoire le dossier `wp-content` du site et un mot de passe fort.

## Premier déploiement d'un site

1. Créer le compte FTP de déploiement dans cPanel, limité au dossier `wp-content` du site (par Gérard).
2. Créer le secret (par Gérard) : `gh secret set FTP_PASSWORD --env staging -R <dépôt>`, mot de passe saisi au clavier.
3. Créer les variables, limiter `staging` à `main`.
5. Activer sur le site les extensions maison déployées (une seule fois).
6. Fusionner une pull request : le déploiement part automatiquement.

## Revenir en arrière

Annuler le commit fautif par une pull request (`git revert`) : la fusion redéploie la version précédente du code. Les contenus ne sont pas concernés. Pour une restauration complète (fichiers et base), utiliser JetBackup (voir la procédure d'o2switch).

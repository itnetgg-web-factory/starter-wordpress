# Déploiement du code par GitHub Actions

Le job `deploy` de `.github/workflows/ci.yml` publie **le code maison** sur le WordPress de préproduction après chaque fusion dans `main`.

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
2. Connexion SSH avec une clé réservée au déploiement ; empreinte du serveur vérifiée (`StrictHostKeyChecking yes`).
3. `rsync --delete` de chaque dossier de code maison, droits 755/644, sans les fichiers Markdown.
4. Vidage du cache des compositions de WordPress (sinon les compositions modifiées n'apparaissent qu'au changement de version du thème).
5. Vérification : accueil en HTTP 200 et feuille de style du thème servie dans la version du dépôt.

Les fichiers PHP sont relus par OPcache au plus 60 s après le déploiement.

## Configuration (environnement GitHub `staging`, limité à `main`)

| Nom | Type | Contenu |
|---|---|---|
| `SSH_PRIVATE_KEY` | Secret | Clé privée de déploiement (ed25519, sans phrase de passe), propre au site |
| `SSH_HOST` | Variable | Serveur SSH de l'hébergement |
| `SSH_USER` | Variable | Compte SSH |
| `SSH_KNOWN_HOSTS` | Variable | Ligne `known_hosts` du serveur (`ssh-keyscan -t ed25519 <serveur>`), empreinte contrôlée à la main |
| `WP_PATH` | Variable | Chemin absolu de l'installation WordPress |
| `PUBLIC_SITE_URL` | Variable | Adresse publique du site, sans `/` final |

La clé publique de déploiement est importée puis **autorisée** dans cPanel (Accès SSH > Gérer les clés SSH).

## Premier déploiement d'un site

1. Générer la clé : `ssh-keygen -t ed25519 -N "" -C "github-actions <site> deploiement" -f deploy_<site>`.
2. Importer et autoriser `deploy_<site>.pub` dans cPanel.
3. Créer le secret (par Gérard) : `gh secret set SSH_PRIVATE_KEY --env staging -R <dépôt> < deploy_<site>`, puis supprimer la clé privée locale.
4. Créer les variables, limiter `staging` à `main`.
5. Activer sur le site les extensions maison déployées (une seule fois).
6. Fusionner une pull request : le déploiement part automatiquement.

## Revenir en arrière

Annuler le commit fautif par une pull request (`git revert`) : la fusion redéploie la version précédente du code. Les contenus ne sont pas concernés. Pour une restauration complète (fichiers et base), utiliser JetBackup (voir la procédure d'o2switch).

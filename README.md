# starter-wordpress

Modèle de la **filière A** de l'usine `itnetgg-web-factory` : WordPress + Gutenberg, blocs personnalisés, hébergement o2switch, déploiement du code via GitHub Actions.

> État : thème blocs `webfactory-blocks`, compositions métier, formulaire de contact maison, envoi SMTP et déploiement par GitHub Actions (WordPress 3/3).

## Pour qui

Sites où le client veut modifier lui-même ses mises en page, blogs à plusieurs rédacteurs, boutiques WooCommerce. Le client édite dans WordPress, sans IA ni accès au code.

## Pile technique

| Composant | Choix |
|---|---|
| CMS | WordPress |
| Éditeur | Gutenberg, compositions métier, blocs maison si nécessaire |
| Thème | [`webfactory-blocks`](themes/webfactory-blocks/README.md), thème blocs autonome |
| Assistance IA | Novamira, **uniquement en développement et préproduction**, jamais sur un site client en production |
| Hébergement | o2switch (préproduction), hébergement du client (production) |
| CI/CD | GitHub Actions, déploiement SSH/SFTP |

## Ce qui est versionné, ce qui ne l'est pas

| Dans Git | Hors Git |
|---|---|
| Thème, extensions et mu-plugins développés pour le site | Cœur WordPress, `wp-config.php` |
| Configuration non secrète | Base de données, médias (`uploads/`) |
| Scripts de build et de déploiement | Secrets, sauvegardes, extensions installées par le client |

Un déploiement de code ne doit jamais écraser les contenus, médias ou extensions gérés par le client.

## Structure

```
themes/webfactory-blocks/        thème du site (voir son README)
plugins/webfactory-formulaire/   bloc « Formulaire de contact » (voir son README)
mu-plugins/webfactory-smtp.php   envoi des e-mails par SMTP, configuré dans wp-config.php
docs/deploiement.md              déploiement par GitHub Actions
```

## Extensions

Un site démarre sans extension tierce. Chaque ajout est justifié (besoin, coût, maintenance, alternative native).

| Extension | Origine | Rôle |
|---|---|---|
| Webfactory Formulaire | Maison (ce dépôt) | Formulaire de contact |
| Webfactory SMTP (mu-plugin) | Maison (ce dépôt) | Envoi des e-mails par SMTP |
| The SEO Framework | WordPress.org, installée sur le site | Descriptions, aperçus pour les réseaux sociaux, plan du site |
| Novamira | Développement et préproduction uniquement | Accès de Claude Code ; jamais en production |

Les extensions tierces ne sont pas versionnées : elles s'installent et se mettent à jour depuis WordPress.

## Déploiement

Après chaque fusion dans `main`, GitHub Actions publie le code maison sur la préproduction, sans toucher aux contenus. Voir [`docs/deploiement.md`](docs/deploiement.md).

## Créer un projet client depuis ce modèle

Voir la procédure dans [`socle`](https://github.com/itnetgg-web-factory/socle/blob/main/docs/nouveau-projet-client.md).

## Conventions

Voir [`socle/docs/conventions.md`](https://github.com/itnetgg-web-factory/socle/blob/main/docs/conventions.md).

# starter-wordpress

Modèle de la **filière A** de l'usine `itnetgg-web-factory` : WordPress + Gutenberg, blocs personnalisés, hébergement o2switch, déploiement du code via GitHub Actions.

> État : thème blocs `webfactory-blocks` et compositions métier (WordPress 2/3). Formulaire de contact maison et déploiement GitHub Actions à venir (WordPress 3/3).

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
themes/webfactory-blocks/  thème du site (voir son README)
plugins/<extension>/       extensions maison (blocs personnalisés), à venir
mu-plugins/                réglages imposés, à venir
```

## Extensions

Un site démarre sans extension tierce. Chaque ajout est justifié (besoin, coût, maintenance, alternative native). Prévu par défaut : une extension SEO légère. Novamira uniquement en développement et préproduction.

## Créer un projet client depuis ce modèle

Voir la procédure dans [`socle`](https://github.com/itnetgg-web-factory/socle/blob/main/docs/nouveau-projet-client.md).

## Conventions

Voir [`socle/docs/conventions.md`](https://github.com/itnetgg-web-factory/socle/blob/main/docs/conventions.md).

# CLAUDE.md : starter-wordpress

Modèle public de la filière WordPress + Gutenberg. N'y écrire aucune information propre à un client, à un compte ou à un hébergement.

## Règles

- Conventions communes : https://github.com/itnetgg-web-factory/socle/blob/main/docs/conventions.md
- Branche `feature/*`, pull request, fusion par squash. Jamais de commit direct sur `main`.
- Ne versionner que le code développé pour le site : thème, extensions et mu-plugins maison. Jamais la base, les médias, `wp-config.php` ni les secrets.
- Un déploiement de code ne doit pas écraser les contenus, médias ou extensions gérés par le client.
- Novamira sert uniquement en développement et préproduction. Ne jamais l'installer ni l'utiliser sur un site client en production.
- Respecter les standards de code WordPress (indentation par tabulations en PHP).

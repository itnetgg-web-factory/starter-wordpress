# Extension webfactory-formulaire

Bloc **Formulaire de contact** (`webfactory/formulaire-contact`) : nom, e-mail, téléphone facultatif, message.

## Principes

- **Aucun message conservé sur le site** : chaque envoi part par e-mail, puis rien n'est stocké. Rien à purger, pas de base de contacts à déclarer.
- **Sans JavaScript côté visiteur** : envoi classique vers `admin-post.php`, puis retour sur la page avec un message de confirmation ou d'erreur.
- **Accessible** : étiquettes visibles, champs obligatoires annoncés, erreurs listées en tête et reliées à chaque champ, saisie conservée en cas d'erreur.
- **Anti-spam discret, sans captcha** : jeton de sécurité, champ piège invisible, délai minimal de 3 s, 5 envois au plus par adresse IP en 10 minutes (adresse hachée). Un robot détecté reçoit un faux succès et rien n'est envoyé.
- **Pas d'injection d'en-têtes** : nom nettoyé avant d'être placé dans `Reply-To`.

## Réglages

| Quoi | Où |
|---|---|
| Texte du bouton, mention sous le formulaire | Réglages du bloc dans l'éditeur |
| Destinataire | E-mail d'administration du site, ou constante `WEBFACTORY_FORMULAIRE_DESTINATAIRE` dans `wp-config.php`, ou filtre `webfactory_formulaire_destinataire` |
| Envoi par SMTP | mu-plugin `webfactory-smtp` et ses constantes dans `wp-config.php` |

## À savoir

- Le jeton de sécurité est valable 12 à 24 heures : en cas de **cache de pages**, exclure la page du formulaire du cache.
- Chez o2switch, un envoi sans navigateur identifié est rejeté avant WordPress (réponse 404) : c'est une protection de l'hébergeur, sans effet pour les visiteurs.

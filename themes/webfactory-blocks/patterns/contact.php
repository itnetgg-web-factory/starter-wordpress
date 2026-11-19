<?php
/**
 * Title: Contact : coordonnées et prise de contact
 * Slug: webfactory-blocks/contact
 * Categories: webfactory, contact
 * Keywords: contact, coordonnées, adresse, téléphone, e-mail, formulaire
 * Description: Coordonnées (adresse, téléphone, e-mail, horaires) et formulaire de contact (extension Webfactory Formulaire).
 * Viewport Width: 1400
 *
 * @package webfactory-blocks
 */

?>
<!-- wp:group {"metadata":{"name":"Contact"},"anchor":"contact","align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div id="contact" class="wp-block-group alignfull" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">
<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">Nous contacter</h2>
<!-- /wp:heading -->
<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|50","top":"var:preset|spacing|40"},"margin":{"top":"var:preset|spacing|50"}}}} -->
<div class="wp-block-columns alignwide" style="margin-top:var(--wp--preset--spacing--50)">
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Coordonnées</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Nom de l’entreprise<br>1 rue de l’Exemple<br>00000 Ville</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p>Téléphone : <a href="tel:+33100000000">01 00 00 00 00</a><br>E-mail : <a href="mailto:contact@example.com">contact@example.com</a></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"style":{"color":{"text":"var:preset|color|muted"}}} -->
<p class="has-text-color" style="color:var(--wp--preset--color--muted)">Du lundi au vendredi, de 9 h à 18 h.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->
<!-- wp:column {"className":"is-style-carte"} -->
<div class="wp-block-column is-style-carte">
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Écrivez-nous</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Décrivez votre projet en quelques lignes : nous vous répondons sous deux jours ouvrés.</p>
<!-- /wp:paragraph -->
<!-- wp:webfactory/formulaire-contact /-->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->

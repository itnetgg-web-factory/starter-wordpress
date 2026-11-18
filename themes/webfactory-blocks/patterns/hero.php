<?php
/**
 * Title: Hero : titre, accroche et boutons
 * Slug: webfactory-blocks/hero
 * Categories: webfactory, banner
 * Keywords: accueil, bandeau, hero, titre
 * Description: Grand bandeau d’ouverture de page, sur la couleur principale.
 * Viewport Width: 1400
 *
 * @package webfactory-blocks
 */

?>
<!-- wp:group {"metadata":{"name":"Hero"},"align":"full","className":"is-style-section-principale","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained","contentSize":"860px"}} -->
<div class="wp-block-group alignfull is-style-section-principale" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">
<!-- wp:heading {"textAlign":"center","level":1} -->
<h1 class="wp-block-heading has-text-align-center">Votre activité, présentée simplement</h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"align":"center","fontSize":"large"} -->
<p class="has-text-align-center has-large-font-size">Une phrase qui dit ce que vous faites, pour qui, et ce qui vous distingue.</p>
<!-- /wp:paragraph -->
<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|50"}}}} -->
<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--50)">
<!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#contact">Demander un devis</a></div>
<!-- /wp:button -->
<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="#prestations">Voir les prestations</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->

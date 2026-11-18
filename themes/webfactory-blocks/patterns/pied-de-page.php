<?php
/**
 * Title: Pied de page
 * Slug: webfactory-blocks/pied-de-page
 * Categories: footer
 * Block Types: core/template-part/footer
 * Inserter: no
 * Description: Nom du site, slogan, menu de pied de page et mentions.
 *
 * @package webfactory-blocks
 */

?>
<!-- wp:group {"align":"full","className":"is-style-section-sombre","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|50"},"margin":{"top":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-section-sombre" style="margin-top:0;padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--50)">
<!-- wp:group {"align":"wide","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"top"}} -->
<div class="wp-block-group alignwide">
<!-- wp:group {"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group">
<!-- wp:site-title {"level":0} /-->
<!-- wp:site-tagline /-->
</div>
<!-- /wp:group -->
<!-- wp:navigation {"overlayMenu":"never","ariaLabel":"Liens utiles","layout":{"type":"flex","orientation":"vertical"}} -->
<!-- wp:navigation-link {"label":"Mentions légales","url":"/mentions-legales/","kind":"custom"} /-->
<!-- wp:navigation-link {"label":"Politique de confidentialité","url":"/politique-de-confidentialite/","kind":"custom"} /-->
<!-- wp:navigation-link {"label":"Contact","url":"/#contact","kind":"custom"} /-->
<!-- /wp:navigation -->
</div>
<!-- /wp:group -->
<!-- wp:paragraph {"align":"wide","fontSize":"small","style":{"spacing":{"margin":{"top":"var:preset|spacing|50"}}}} -->
<p class="alignwide has-small-font-size" style="margin-top:var(--wp--preset--spacing--50)">© <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

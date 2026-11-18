<?php
/**
 * Title: Galerie d’images
 * Slug: webfactory-blocks/galerie
 * Categories: webfactory, gallery
 * Keywords: galerie, photos, images, réalisations
 * Description: Titre de section et galerie de trois colonnes, à remplir avec vos images.
 * Viewport Width: 1400
 *
 * @package webfactory-blocks
 */

?>
<!-- wp:group {"metadata":{"name":"Galerie"},"anchor":"galerie","align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div id="galerie" class="wp-block-group alignfull" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">
<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">Nos réalisations</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"align":"center","style":{"color":{"text":"var:preset|color|muted"}}} -->
<p class="has-text-align-center has-text-color" style="color:var(--wp--preset--color--muted)">Quelques images de notre travail. Pensez à décrire chaque image dans son texte alternatif.</p>
<!-- /wp:paragraph -->
<!-- wp:gallery {"columns":3,"linkTo":"none","sizeSlug":"large","align":"wide","style":{"spacing":{"margin":{"top":"var:preset|spacing|50"},"blockGap":{"top":"var:preset|spacing|30","left":"var:preset|spacing|30"}}}} -->
<figure class="wp-block-gallery alignwide has-nested-images columns-3 is-cropped" style="margin-top:var(--wp--preset--spacing--50)"></figure>
<!-- /wp:gallery -->
</div>
<!-- /wp:group -->

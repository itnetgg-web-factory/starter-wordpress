<?php
/**
 * Plugin Name: Webfactory Déploiement
 * Description: Après un déploiement du code par GitHub Actions, vide le cache des compositions des thèmes. Le déploiement dépose un témoin (wp-content/webfactory-deploiement.txt) contenant le commit publié.
 * Version: 0.1.0
 * Author: itnetgg-web-factory
 * License: GPL-2.0-or-later
 *
 * @package webfactory-deploiement
 */

defined( 'ABSPATH' ) || exit;

/**
 * Vide le cache des compositions quand le témoin de déploiement change.
 * Coût par requête : une lecture de date de fichier et une option déjà chargée.
 */
function webfactory_deploiement_verifier() {
	$temoin = WP_CONTENT_DIR . '/webfactory-deploiement.txt';
	if ( ! is_readable( $temoin ) ) {
		return;
	}

	$date = (string) filemtime( $temoin );
	if ( get_option( 'webfactory_deploiement_temoin' ) === $date ) {
		return;
	}

	foreach ( wp_get_themes() as $theme ) {
		$theme->delete_pattern_cache();
	}
	update_option( 'webfactory_deploiement_temoin', $date, true );
}
add_action( 'init', 'webfactory_deploiement_verifier', 1 );

<?php
/**
 * Webfactory Blocks : fonctions du thème.
 *
 * Le thème se limite à la présentation. Les contenus (textes, images, tarifs)
 * restent dans la base WordPress et ne sont jamais écrasés par un déploiement.
 *
 * @package webfactory-blocks
 */

defined( 'ABSPATH' ) || exit;

/**
 * Réglages du thème : feuille de style de l'éditeur, suppression des compositions distantes.
 */
function webfactory_blocks_setup() {
	add_editor_style( 'style.css' );

	// Les compositions viennent du thème uniquement, pas du répertoire public de WordPress.org.
	remove_theme_support( 'core-block-patterns' );
}
add_action( 'after_setup_theme', 'webfactory_blocks_setup' );

add_filter( 'should_load_remote_block_patterns', '__return_false' );

/**
 * Charge la feuille de style du thème sur le site public.
 */
function webfactory_blocks_enqueue_styles() {
	wp_enqueue_style(
		'webfactory-blocks-style',
		get_stylesheet_uri(),
		array(),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'webfactory_blocks_enqueue_styles' );

/**
 * Catégorie qui regroupe les compositions métier dans l'éditeur.
 */
function webfactory_blocks_pattern_categories() {
	register_block_pattern_category(
		'webfactory',
		array(
			'label'       => __( 'Sections du site', 'webfactory-blocks' ),
			'description' => __( 'Sections prêtes à l’emploi : hero, prestations, tarifs, galerie, témoignages, contact.', 'webfactory-blocks' ),
		)
	);
}
add_action( 'init', 'webfactory_blocks_pattern_categories' );

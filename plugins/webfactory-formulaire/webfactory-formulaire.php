<?php
/**
 * Plugin Name: Webfactory Formulaire
 * Description: Bloc « Formulaire de contact » de l'usine itnetgg-web-factory : accessible, sans JavaScript côté visiteur, anti-spam discret, envoi par e-mail sans conservation des messages.
 * Version: 0.1.0
 * Requires at least: 6.7
 * Requires PHP: 8.1
 * Author: itnetgg-web-factory
 * License: GPL-2.0-or-later
 * Text Domain: webfactory-formulaire
 *
 * @package webfactory-formulaire
 */

defined( 'ABSPATH' ) || exit;

const WEBFACTORY_FORMULAIRE_ACTION        = 'webfactory_formulaire';
const WEBFACTORY_FORMULAIRE_DELAI_MINIMUM = 3;  // Secondes : un humain met plus longtemps à remplir le formulaire.
const WEBFACTORY_FORMULAIRE_ENVOIS_MAX    = 5;  // Envois par adresse IP sur la période ci-dessous.
const WEBFACTORY_FORMULAIRE_PERIODE       = 600; // Secondes.

/**
 * Enregistre le bloc à partir de block.json.
 */
function webfactory_formulaire_enregistrer_bloc() {
	register_block_type( __DIR__ );
}
add_action( 'init', 'webfactory_formulaire_enregistrer_bloc' );

/**
 * Adresse qui reçoit les messages : constante de wp-config.php, sinon e-mail d'administration.
 *
 * @return string
 */
function webfactory_formulaire_destinataire() {
	$destinataire = defined( 'WEBFACTORY_FORMULAIRE_DESTINATAIRE' ) ? WEBFACTORY_FORMULAIRE_DESTINATAIRE : get_option( 'admin_email' );

	return (string) apply_filters( 'webfactory_formulaire_destinataire', $destinataire );
}

/**
 * Lit l'état transmis après un envoi (succès, ou erreurs et valeurs saisies).
 *
 * @return array{statut: string, erreurs: array<string, string>, valeurs: array<string, string>}
 */
function webfactory_formulaire_etat() {
	$etat = array(
		'statut'  => '',
		'erreurs' => array(),
		'valeurs' => array(),
	);

	// Lecture seule d'un paramètre d'affichage : pas de nonce nécessaire.
	$statut = isset( $_GET['formulaire'] ) ? sanitize_key( wp_unslash( $_GET['formulaire'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( ! in_array( $statut, array( 'succes', 'erreur' ), true ) ) {
		return $etat;
	}
	$etat['statut'] = $statut;

	$jeton = isset( $_GET['formulaire_jeton'] ) ? sanitize_key( wp_unslash( $_GET['formulaire_jeton'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( 'erreur' === $statut && '' !== $jeton ) {
		$donnees = get_transient( 'webfactory_formulaire_' . $jeton );
		if ( is_array( $donnees ) ) {
			$etat['erreurs'] = $donnees['erreurs'] ?? array();
			$etat['valeurs'] = $donnees['valeurs'] ?? array();
			delete_transient( 'webfactory_formulaire_' . $jeton );
		}
	}

	return $etat;
}

/**
 * Redirige vers la page du formulaire avec un statut.
 *
 * @param string               $retour  Adresse de la page du formulaire.
 * @param string               $statut  « succes » ou « erreur ».
 * @param array<string,string> $erreurs Erreurs par champ.
 * @param array<string,string> $valeurs Valeurs saisies, réaffichées en cas d'erreur.
 */
function webfactory_formulaire_rediriger( $retour, $statut, $erreurs = array(), $valeurs = array() ) {
	$arguments = array( 'formulaire' => $statut );

	if ( 'erreur' === $statut ) {
		$jeton = strtolower( wp_generate_password( 20, false, false ) );
		set_transient(
			'webfactory_formulaire_' . $jeton,
			array(
				'erreurs' => $erreurs,
				'valeurs' => $valeurs,
			),
			10 * MINUTE_IN_SECONDS
		);
		$arguments['formulaire_jeton'] = $jeton;
	}

	$adresse = remove_query_arg( array( 'formulaire', 'formulaire_jeton' ), $retour );
	wp_safe_redirect( add_query_arg( $arguments, $adresse ) . '#formulaire-contact', 303 );
	exit;
}

/**
 * Traite l'envoi du formulaire (visiteurs connectés ou non).
 */
function webfactory_formulaire_traiter() {
	$retour = isset( $_POST['retour'] ) ? esc_url_raw( wp_unslash( $_POST['retour'] ) ) : '';
	$retour = '' !== $retour ? wp_validate_redirect( $retour, home_url( '/' ) ) : home_url( '/' );

	if ( ! isset( $_POST['webfactory_formulaire_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['webfactory_formulaire_nonce'] ) ), WEBFACTORY_FORMULAIRE_ACTION ) ) {
		webfactory_formulaire_rediriger( $retour, 'erreur', array( 'general' => __( 'La page a expiré. Rechargez-la, puis envoyez à nouveau votre message.', 'webfactory-formulaire' ) ) );
	}

	// Robots : champ piège rempli ou envoi trop rapide. On simule un succès, sans rien envoyer.
	$piege = isset( $_POST['site_internet'] ) ? sanitize_text_field( wp_unslash( $_POST['site_internet'] ) ) : '';
	$debut = isset( $_POST['debut'] ) ? absint( $_POST['debut'] ) : 0;
	if ( '' !== $piege || ( time() - $debut ) < WEBFACTORY_FORMULAIRE_DELAI_MINIMUM ) {
		webfactory_formulaire_rediriger( $retour, 'succes' );
	}

	// Limite d'envois par adresse IP (adresse hachée, jamais conservée en clair).
	$ip        = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	$cle_limit = 'webfactory_formulaire_ip_' . md5( $ip . wp_salt( 'nonce' ) );
	$compteur  = (int) get_transient( $cle_limit );
	if ( $compteur >= WEBFACTORY_FORMULAIRE_ENVOIS_MAX ) {
		webfactory_formulaire_rediriger( $retour, 'erreur', array( 'general' => __( 'Trop de messages envoyés en peu de temps. Réessayez dans quelques minutes.', 'webfactory-formulaire' ) ) );
	}

	$valeurs = array(
		'nom'       => isset( $_POST['nom'] ) ? sanitize_text_field( wp_unslash( $_POST['nom'] ) ) : '',
		'email'     => isset( $_POST['email'] ) ? sanitize_text_field( wp_unslash( $_POST['email'] ) ) : '',
		'telephone' => isset( $_POST['telephone'] ) ? sanitize_text_field( wp_unslash( $_POST['telephone'] ) ) : '',
		'message'   => isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '',
	);

	$erreurs = array();
	if ( '' === $valeurs['nom'] || mb_strlen( $valeurs['nom'] ) > 100 ) {
		$erreurs['nom'] = __( 'Indiquez votre nom (100 caractères au maximum).', 'webfactory-formulaire' );
	}
	// Saisie conservée telle quelle pour être corrigée ; seule une adresse valide est utilisée.
	if ( ! is_email( $valeurs['email'] ) || sanitize_email( $valeurs['email'] ) !== $valeurs['email'] ) {
		$erreurs['email'] = __( 'Indiquez une adresse e-mail valide, par exemple nom@exemple.fr.', 'webfactory-formulaire' );
	}
	if ( '' !== $valeurs['telephone'] && ! preg_match( '/^[0-9 +().-]{6,20}$/', $valeurs['telephone'] ) ) {
		$erreurs['telephone'] = __( 'Le numéro de téléphone ne peut contenir que des chiffres, des espaces et les signes + ( ) . -', 'webfactory-formulaire' );
	}
	if ( '' === $valeurs['message'] || mb_strlen( $valeurs['message'] ) > 5000 ) {
		$erreurs['message'] = __( 'Écrivez votre message (5 000 caractères au maximum).', 'webfactory-formulaire' );
	}
	if ( $erreurs ) {
		webfactory_formulaire_rediriger( $retour, 'erreur', $erreurs, $valeurs );
	}

	set_transient( $cle_limit, $compteur + 1, WEBFACTORY_FORMULAIRE_PERIODE );

	// Nom nettoyé pour l'en-tête Reply-To : ni retour à la ligne, ni chevrons, ni guillemets.
	$nom_entete = trim( preg_replace( '/[\r\n<>"]+/', ' ', $valeurs['nom'] ) );
	$sujet      = sprintf(
		/* translators: 1: nom du site, 2: nom de l'expéditeur. */
		__( '[%1$s] Nouveau message de %2$s', 'webfactory-formulaire' ),
		wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ),
		$nom_entete
	);
	$corps      = implode(
		"\n",
		array(
			sprintf( __( 'Nom : %s', 'webfactory-formulaire' ), $valeurs['nom'] ),
			sprintf( __( 'E-mail : %s', 'webfactory-formulaire' ), $valeurs['email'] ),
			sprintf( __( 'Téléphone : %s', 'webfactory-formulaire' ), '' !== $valeurs['telephone'] ? $valeurs['telephone'] : '-' ),
			sprintf( __( 'Page : %s', 'webfactory-formulaire' ), $retour ),
			'',
			$valeurs['message'],
		)
	);
	$entetes    = array( sprintf( 'Reply-To: %s <%s>', $nom_entete, $valeurs['email'] ) );

	if ( ! wp_mail( webfactory_formulaire_destinataire(), $sujet, $corps, $entetes ) ) {
		webfactory_formulaire_rediriger( $retour, 'erreur', array( 'general' => __( 'Le message n’a pas pu être envoyé. Réessayez plus tard ou contactez-nous par téléphone.', 'webfactory-formulaire' ) ), $valeurs );
	}

	webfactory_formulaire_rediriger( $retour, 'succes' );
}
add_action( 'admin_post_nopriv_' . WEBFACTORY_FORMULAIRE_ACTION, 'webfactory_formulaire_traiter' );
add_action( 'admin_post_' . WEBFACTORY_FORMULAIRE_ACTION, 'webfactory_formulaire_traiter' );

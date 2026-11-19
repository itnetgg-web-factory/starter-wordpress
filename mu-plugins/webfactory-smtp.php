<?php
/**
 * Plugin Name: Webfactory SMTP
 * Description: Envoie les e-mails du site par un serveur SMTP authentifié, si wp-config.php le configure. Sans configuration, WordPress garde son envoi habituel.
 * Version: 0.1.0
 * Author: itnetgg-web-factory
 * License: GPL-2.0-or-later
 *
 * Constantes à définir dans wp-config.php (jamais dans Git) :
 *   WEBFACTORY_SMTP_HOST     Serveur SMTP, par exemple mail.exemple.fr
 *   WEBFACTORY_SMTP_PORT     465 (SSL) ou 587 (STARTTLS)
 *   WEBFACTORY_SMTP_USER     Compte de messagerie
 *   WEBFACTORY_SMTP_PASSWORD Mot de passe du compte
 *   WEBFACTORY_SMTP_FROM     Adresse d'expédition (par défaut : le compte)
 *   WEBFACTORY_SMTP_FROM_NAME Nom d'expéditeur (par défaut : nom du site)
 *
 * @package webfactory-smtp
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'WEBFACTORY_SMTP_HOST' ) || ! defined( 'WEBFACTORY_SMTP_USER' ) || ! defined( 'WEBFACTORY_SMTP_PASSWORD' ) ) {
	return;
}

/**
 * Configure PHPMailer pour l'envoi SMTP authentifié et chiffré.
 *
 * @param PHPMailer\PHPMailer\PHPMailer $mailer Instance utilisée par wp_mail().
 */
function webfactory_smtp_configurer( $mailer ) {
	$port = defined( 'WEBFACTORY_SMTP_PORT' ) ? (int) WEBFACTORY_SMTP_PORT : 465;

	$mailer->isSMTP();
	$mailer->Host       = WEBFACTORY_SMTP_HOST; // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
	$mailer->Port       = $port; // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
	$mailer->SMTPAuth   = true; // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
	$mailer->Username   = WEBFACTORY_SMTP_USER; // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
	$mailer->Password   = WEBFACTORY_SMTP_PASSWORD; // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
	$mailer->SMTPSecure = 465 === $port ? 'ssl' : 'tls'; // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
	$mailer->SMTPDebug  = 0; // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
}
add_action( 'phpmailer_init', 'webfactory_smtp_configurer' );

/**
 * Adresse d'expédition alignée sur le compte SMTP (indispensable pour SPF et DKIM).
 *
 * @return string
 */
function webfactory_smtp_expediteur() {
	return defined( 'WEBFACTORY_SMTP_FROM' ) ? WEBFACTORY_SMTP_FROM : WEBFACTORY_SMTP_USER;
}
add_filter( 'wp_mail_from', 'webfactory_smtp_expediteur' );

/**
 * Nom d'expéditeur.
 *
 * @return string
 */
function webfactory_smtp_nom_expediteur() {
	return defined( 'WEBFACTORY_SMTP_FROM_NAME' ) ? WEBFACTORY_SMTP_FROM_NAME : wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES );
}
add_filter( 'wp_mail_from_name', 'webfactory_smtp_nom_expediteur' );

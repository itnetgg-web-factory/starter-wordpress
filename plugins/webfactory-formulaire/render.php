<?php
/**
 * Rendu du bloc « Formulaire de contact ».
 *
 * @package webfactory-formulaire
 *
 * @var array $attributes Attributs du bloc.
 */

defined( 'ABSPATH' ) || exit;

$etat    = webfactory_formulaire_etat();
$erreurs = $etat['erreurs'];
$valeurs = $etat['valeurs'];
$retour  = get_permalink() ? get_permalink() : home_url( '/' );

$champs = array(
	'nom'       => array(
		'label'        => __( 'Nom', 'webfactory-formulaire' ),
		'type'         => 'text',
		'obligatoire'  => true,
		'autocomplete' => 'name',
		'aide'         => '',
	),
	'email'     => array(
		'label'        => __( 'E-mail', 'webfactory-formulaire' ),
		'type'         => 'email',
		'obligatoire'  => true,
		'autocomplete' => 'email',
		'aide'         => __( 'Format : nom@exemple.fr', 'webfactory-formulaire' ),
	),
	'telephone' => array(
		'label'        => __( 'Téléphone (facultatif)', 'webfactory-formulaire' ),
		'type'         => 'tel',
		'obligatoire'  => false,
		'autocomplete' => 'tel',
		'aide'         => '',
	),
	'message'   => array(
		'label'        => __( 'Message', 'webfactory-formulaire' ),
		'type'         => 'textarea',
		'obligatoire'  => true,
		'autocomplete' => '',
		'aide'         => '',
	),
);
?>
<div <?php echo get_block_wrapper_attributes( array( 'id' => 'formulaire-contact' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<?php if ( 'succes' === $etat['statut'] ) : ?>
		<p class="webfactory-formulaire__message webfactory-formulaire__message--succes" role="status">
			<?php esc_html_e( 'Merci, votre message a bien été envoyé. Nous vous répondons rapidement.', 'webfactory-formulaire' ); ?>
		</p>
	<?php elseif ( $erreurs ) : ?>
		<div class="webfactory-formulaire__message webfactory-formulaire__message--erreur" role="alert">
			<p><strong><?php esc_html_e( 'Le message n’a pas été envoyé :', 'webfactory-formulaire' ); ?></strong></p>
			<ul>
				<?php foreach ( $erreurs as $champ => $texte ) : ?>
					<li>
						<?php if ( isset( $champs[ $champ ] ) ) : ?>
							<a href="#wf-<?php echo esc_attr( $champ ); ?>"><?php echo esc_html( $texte ); ?></a>
						<?php else : ?>
							<?php echo esc_html( $texte ); ?>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>

	<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" novalidate>
		<p class="webfactory-formulaire__obligatoire"><?php esc_html_e( 'Les champs marqués d’un astérisque (*) sont obligatoires.', 'webfactory-formulaire' ); ?></p>

		<?php foreach ( $champs as $nom => $champ ) : ?>
			<?php
			$id          = 'wf-' . $nom;
			$decrit_par  = array();
			$valeur      = $valeurs[ $nom ] ?? '';
			$en_erreur   = isset( $erreurs[ $nom ] );
			if ( $champ['aide'] ) {
				$decrit_par[] = $id . '-aide';
			}
			if ( $en_erreur ) {
				$decrit_par[] = $id . '-erreur';
			}
			$attributs = sprintf(
				'id="%1$s" name="%2$s"%3$s%4$s%5$s%6$s',
				esc_attr( $id ),
				esc_attr( $nom ),
				$champ['obligatoire'] ? ' required aria-required="true"' : '',
				$champ['autocomplete'] ? ' autocomplete="' . esc_attr( $champ['autocomplete'] ) . '"' : '',
				$decrit_par ? ' aria-describedby="' . esc_attr( implode( ' ', $decrit_par ) ) . '"' : '',
				$en_erreur ? ' aria-invalid="true"' : ''
			);
			?>
			<div class="webfactory-formulaire__champ">
				<label for="<?php echo esc_attr( $id ); ?>">
					<?php echo esc_html( $champ['label'] ); ?>
					<?php if ( $champ['obligatoire'] ) : ?>
						<span aria-hidden="true">*</span>
					<?php endif; ?>
				</label>
				<?php if ( $champ['aide'] ) : ?>
					<span class="webfactory-formulaire__aide" id="<?php echo esc_attr( $id . '-aide' ); ?>"><?php echo esc_html( $champ['aide'] ); ?></span>
				<?php endif; ?>
				<?php if ( $en_erreur ) : ?>
					<span class="webfactory-formulaire__erreur-champ" id="<?php echo esc_attr( $id . '-erreur' ); ?>"><?php echo esc_html( $erreurs[ $nom ] ); ?></span>
				<?php endif; ?>
				<?php if ( 'textarea' === $champ['type'] ) : ?>
					<textarea <?php echo $attributs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- échappé ci-dessus. ?> rows="6" maxlength="5000"><?php echo esc_textarea( $valeur ); ?></textarea>
				<?php else : ?>
					<input type="<?php echo esc_attr( $champ['type'] ); ?>" <?php echo $attributs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- échappé ci-dessus. ?> value="<?php echo esc_attr( $valeur ); ?>">
				<?php endif; ?>
			</div>
		<?php endforeach; ?>

		<div class="webfactory-formulaire__piege" aria-hidden="true">
			<label for="wf-site-internet"><?php esc_html_e( 'Ne pas remplir ce champ', 'webfactory-formulaire' ); ?></label>
			<input type="text" id="wf-site-internet" name="site_internet" value="" tabindex="-1" autocomplete="off">
		</div>

		<input type="hidden" name="action" value="<?php echo esc_attr( WEBFACTORY_FORMULAIRE_ACTION ); ?>">
		<input type="hidden" name="retour" value="<?php echo esc_url( $retour ); ?>">
		<input type="hidden" name="debut" value="<?php echo esc_attr( (string) time() ); ?>">
		<?php wp_nonce_field( WEBFACTORY_FORMULAIRE_ACTION, 'webfactory_formulaire_nonce', false ); ?>

		<div class="wp-block-buttons">
			<div class="wp-block-button">
				<button type="submit" class="wp-block-button__link wp-element-button"><?php echo esc_html( $attributes['boutonTexte'] ); ?></button>
			</div>
		</div>

		<?php if ( ! empty( $attributes['mention'] ) ) : ?>
			<p class="webfactory-formulaire__mention"><?php echo esc_html( $attributes['mention'] ); ?></p>
		<?php endif; ?>
	</form>
</div>

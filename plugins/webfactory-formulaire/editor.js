/**
 * Éditeur du bloc « Formulaire de contact ».
 * Sans étape de build : JavaScript natif et paquets globaux de WordPress.
 * L'aperçu est rendu par le serveur (render.php), comme sur le site public.
 */
( function ( wp ) {
  const el = wp.element.createElement;
  const Fragment = wp.element.Fragment;
  const useBlockProps = wp.blockEditor.useBlockProps;
  const InspectorControls = wp.blockEditor.InspectorControls;
  const PanelBody = wp.components.PanelBody;
  const TextControl = wp.components.TextControl;
  const TextareaControl = wp.components.TextareaControl;
  const Disabled = wp.components.Disabled;
  const ServerSideRender = wp.serverSideRender;

  wp.blocks.registerBlockType( 'webfactory/formulaire-contact', {
    edit: function ( props ) {
      const attributes = props.attributes;
      const setAttributes = props.setAttributes;

      return el(
        Fragment,
        null,
        el(
          InspectorControls,
          null,
          el(
            PanelBody,
            { title: 'Réglages du formulaire' },
            el( TextControl, {
              __nextHasNoMarginBottom: true,
              __next40pxDefaultSize: true,
              label: 'Texte du bouton',
              value: attributes.boutonTexte,
              onChange: function ( value ) {
                setAttributes( { boutonTexte: value } );
              },
            } ),
            el( TextareaControl, {
              __nextHasNoMarginBottom: true,
              label: 'Mention sous le formulaire',
              help: 'Indiquez à quoi servent les informations envoyées.',
              value: attributes.mention,
              onChange: function ( value ) {
                setAttributes( { mention: value } );
              },
            } )
          )
        ),
        el(
          'div',
          useBlockProps(),
          el(
            Disabled,
            null,
            el( ServerSideRender, {
              block: 'webfactory/formulaire-contact',
              attributes: attributes,
            } )
          )
        )
      );
    },
    save: function () {
      return null;
    },
  } );
} )( window.wp );

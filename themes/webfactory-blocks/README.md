# Thème webfactory-blocks

Thème blocs **autonome** de la filière WordPress : ni thème enfant, ni copie modifiée d'un thème officiel. Twenty Twenty-Five a servi de référence pour l'organisation (réglages globaux dans `theme.json`, modèles, styles de section, compositions en PHP).

## Principe

- **Le thème porte la présentation, WordPress porte le contenu.** Une composition insérée dans une page est copiée dans la base : le client la modifie librement, et un déploiement du thème ne l'écrase jamais.
- **Charte verrouillée** : le client choisit parmi la palette, les tailles de texte et les styles de section du thème. Couleurs et tailles libres sont désactivées.
- **Compositions maison uniquement** : celles du cœur et du répertoire public de WordPress.org sont désactivées.

## Contenu

| Élément | Fichiers | Rôle |
|---|---|---|
| Réglages globaux | `theme.json` | Palette, typographie (police système, sans service tiers), espacements, largeurs, styles des blocs |
| Styles de section | `styles/sections/` | Section claire, couleur principale, sombre ; carte et carte mise en avant |
| Modèles | `templates/` | Index, archive, page, **page sans titre** (accueil et pages composées), article, recherche, 404 |
| Parties | `parts/` | En-tête (nom du site, menu principal), pied de page |
| Compositions | `patterns/` | Hero, prestations, tarifs, galerie, témoignages, contact, page d'accueil complète, pied de page |
| Compléments CSS | `style.css` | Focus visible, cibles tactiles, prix, mouvement réduit |

Palette vérifiée : tout texte courant a un contraste d'au moins 4,5:1 sur son fond.

## Créer une page d'accueil

1. Pages > Ajouter : choisir la composition **Page d'accueil complète**.
2. Dans les réglages de la page, choisir le modèle **Page sans titre**.
3. Remplacer les textes d'exemple, ajouter les images de la galerie (avec leur texte alternatif).
4. Réglages > Lecture : définir cette page comme page d'accueil.

Les sections s'ajoutent aussi une à une : bouton **+**, onglet **Compositions**, catégorie **Sections du site**.

## Points d'attention

- **Caches après déploiement** : WordPress met en cache la liste des compositions du thème selon son numéro de version, et OPcache revalide les fichiers PHP toutes les 60 s sur o2switch. Après un déploiement, incrémenter `Version` dans `style.css` ou vider le cache des compositions.
- **Formulaire de contact** : la composition « Contact » utilise le bloc de l'extension maison `webfactory-formulaire`, à activer sur chaque site.
- **Pied de page** : liens vers `/mentions-legales/` et `/politique-de-confidentialite/`, pages à créer sur chaque site.

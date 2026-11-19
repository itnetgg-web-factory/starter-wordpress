# Guide utilisateur : modifier votre site

Ce guide explique comment modifier les textes, les images et les tarifs de votre site WordPress, ajouter une prestation ou une section, et revenir en arrière en cas d'erreur. Aucune connaissance technique n'est nécessaire.

## Les trois règles à retenir

1. **Ce que vous enregistrez est en ligne immédiatement.** Sur une page déjà publiée, le bouton **Enregistrer** met le site à jour tout de suite. Pour une modification importante, cliquez d'abord sur **Prévisualiser**.
2. **Pour ajouter un élément, dupliquez un élément existant.** Une nouvelle prestation, une formule ou un témoignage créés par duplication gardent exactement la même mise en forme que les autres (voir [Ajouter une prestation, une formule, un témoignage](#ajouter-une-prestation-une-formule-un-témoignage)).
3. **Une erreur n'est jamais définitive.** WordPress garde toutes les versions de vos pages : vous pouvez revenir à la précédente (voir [Revenir à une version précédente](#revenir-à-une-version-précédente)). Si vous êtes bloqué, arrêtez-vous et contactez votre prestataire.

## Se connecter

1. Ouvrez l'adresse de votre site suivie de `/wp-admin/`. Par exemple : `https://www.votre-site.fr/wp-admin/`.
2. Saisissez votre **identifiant** (ou votre adresse e-mail) et votre **mot de passe**, puis cliquez sur **Se connecter**.
3. Mot de passe perdu : cliquez sur **Mot de passe oublié ?** sous le formulaire ; un lien de réinitialisation vous est envoyé par e-mail.

Votre compte permet de modifier les pages, les articles et les images. Les menus **Apparence** et **Extensions** n'apparaissent pas : c'est voulu, ils relèvent de votre prestataire.

## Modifier une page

1. Dans le menu de gauche, ouvrez **Pages**, puis cliquez sur le titre de la page. Depuis le site, quand vous êtes connecté, le lien **Modifier la page** de la barre noire en haut fait la même chose.
2. Cliquez dans un texte et tapez directement. Pour naviguer dans une longue page, le bouton **Vue d'ensemble du document** (en haut à gauche) liste toutes les sections.
3. Pour coller un texte venu de Word ou d'un e-mail, utilisez `Ctrl` + `Maj` + `V` (Windows) ou `Cmd` + `Maj` + `V` (Mac) : le texte est collé sans sa mise en forme d'origine.

### Les sections de la page d'accueil

| Section | Ce que vous y modifiez |
|---|---|
| Hero (bandeau d'ouverture) | Titre principal, phrase d'accroche, texte des deux boutons |
| Prestations | Titre, introduction, et pour chaque carte : nom, description, liste des livrables |
| Formules et tarifs | Pour chaque formule : nom, prix, période, description, avantages |
| Réalisations (galerie) | Images et leur texte alternatif |
| Témoignages | Citations et nom des clients |
| Contact | Adresse, téléphone, e-mail, horaires ; le formulaire se règle à part (voir plus bas) |

Le titre principal du bandeau d'ouverture est le titre le plus important de la page pour les moteurs de recherche : gardez-le court et parlant.

### Ajouter une prestation, une formule, un témoignage

1. Cliquez dans la carte à copier (par exemple la prestation « Conseil »).
2. Dans la petite barre d'outils qui apparaît, cliquez sur l'icône tout à gauche (**Sélectionner le bloc parent**) jusqu'à ce que **toute la carte** soit entourée.
3. Ouvrez le menu **Options** (les trois points `⋮`), puis cliquez sur **Dupliquer**.
4. Modifiez les textes de la copie. Pour changer sa place, utilisez les flèches **Déplacer à gauche** ou **Déplacer à droite** de la barre d'outils.

Pour supprimer une carte : sélectionnez-la entièrement de la même façon, puis **Options** › **Supprimer**.

Sur ordinateur, quatre cartes tiennent sur une ligne ; au-delà, préférez une deuxième section. Sur téléphone, les cartes s'affichent l'une sous l'autre.

### Ajouter une section

1. Cliquez sur le bouton **+** (**Outil d'insertion de bloc**) en haut à gauche.
2. Ouvrez l'onglet **Compositions**, puis la catégorie **Sections du site**.
3. Cliquez sur la section voulue : elle s'ajoute dans la page, avec des textes d'exemple à remplacer.

## Remplacer une image

1. Cliquez sur l'image, puis sur **Remplacer** dans la barre d'outils. Choisissez une image de la **Médiathèque** ou envoyez un fichier depuis votre ordinateur.
2. Formats acceptés : JPEG, PNG ou WebP, de préférence moins de 2 Mo. WordPress crée lui-même les tailles adaptées aux écrans.
3. Avant l'envoi, donnez à votre fichier un nom simple, sans espaces ni caractères spéciaux : `atelier-printemps.jpg` plutôt que `Photo atelier (2) !.jpg`.
4. Dans la colonne de droite, remplissez le **Texte alternatif** : une courte phrase qui décrit l'image pour les personnes malvoyantes et les moteurs de recherche. Exemple : « Atelier de poterie baigné de lumière ». Une image purement décorative peut être marquée comme telle (**Marquer l'image comme étant décorative**).

Pour ajouter des images à la galerie, cliquez sur la galerie, puis sur **Ajouter** dans sa barre d'outils.

## Le formulaire de contact

- Les messages des visiteurs arrivent **par e-mail** à l'adresse convenue avec votre prestataire. Ils ne sont pas conservés sur le site.
- Pensez à vérifier de temps en temps votre dossier de courriers indésirables.
- En cliquant sur le formulaire dans l'éditeur, la colonne de droite permet de changer le **texte du bouton** et la **mention** affichée sous le formulaire. Les champs eux-mêmes ne se modifient pas.
- Ne supprimez pas le formulaire : demandez à votre prestataire si vous souhaitez le déplacer.

## Le référencement (SEO)

Sous le contenu de chaque page, l'encadré **Réglages SEO** permet de préciser comment la page apparaît dans les moteurs de recherche :

- **Méta titre** : le titre affiché dans les résultats de recherche (environ 60 caractères).
- **Méta description** : le court résumé affiché sous ce titre (environ 155 caractères). Sans saisie, il est rédigé automatiquement à partir du début de la page.

Les onglets **Réseaux sociaux** et **Visibilité** sont réservés à des besoins particuliers : demandez conseil avant de les modifier.

## Enregistrer et publier

- **Page déjà publiée** : cliquez sur **Prévisualiser** pour voir le résultat dans un nouvel onglet, puis sur **Enregistrer**. La modification est en ligne aussitôt.
- **Nouvelle page** : le premier bouton est **Publier**. Tant que vous ne publiez pas, la page reste un brouillon invisible des visiteurs ; vous pouvez l'enregistrer comme brouillon et y revenir plus tard.
- WordPress enregistre aussi automatiquement votre travail en cours toutes les minutes : en cas de coupure, il vous propose de récupérer la dernière sauvegarde automatique.

## Vérifier le résultat

1. Cliquez sur **Voir la page**, ou ouvrez votre site dans un nouvel onglet.
2. Si l'ancienne version s'affiche encore, rechargez la page :
    - sur ordinateur : `Ctrl` + `Maj` + `R` (Windows) ou `Cmd` + `Maj` + `R` (Mac) ;
    - sur téléphone : tirez la page vers le bas.
3. Vérifiez votre modification sur ordinateur et, si possible, sur téléphone.

## Revenir à une version précédente

1. Ouvrez la page dans l'éditeur.
2. Dans la colonne de droite, onglet **Page**, cliquez sur **Révisions** (le nombre de versions enregistrées est indiqué).
3. Le curseur en haut de l'écran permet de parcourir les versions : à gauche l'ancienne, à droite la nouvelle, les différences sont surlignées.
4. Sur la version souhaitée, cliquez sur **Rétablir cette révision**. La page est remise en ligne dans cet état. La version que vous quittez reste disponible dans les révisions.

## Ce qu'il vaut mieux éviter

- Supprimer les pages **Mentions légales** et **Politique de confidentialité** : elles sont obligatoires et reliées au pied de page.
- Envoyer des images très lourdes (photos d'appareil de plus de 5 Mo) : elles ralentissent le site. Réduisez-les avant l'envoi.
- Écrire des textes entiers en majuscules, en couleur ou soulignés : la mise en forme du site est déjà réglée pour être lisible par tous.
- Créer des comptes pour d'autres personnes sans en parler à votre prestataire.

## En cas de problème

Contactez votre prestataire en indiquant :

- la page concernée et ce que vous vouliez faire (par exemple : « ajouter une formule dans Formules et tarifs ») ;
- le message affiché, idéalement avec une capture d'écran ;
- l'heure approximative.

Ne tentez pas de réparer en supprimant et recréant la page : les révisions permettent presque toujours de revenir en arrière sans rien perdre.

**Contact** : *(à compléter pour chaque client : nom, e-mail, téléphone, horaires)*

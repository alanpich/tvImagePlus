<?php
/**
 * Default Lexicon Entries for Image+
 *
 * @package imageplus
 * @subpackage lexicon
 */
$_lang['imageplus'] = 'Image+';
$_lang['imageplus.editor_title'] = 'Éditeur Image+';
$_lang['imageplus.alt_text'] = 'Texte de l’attribut Alt';
$_lang['imageplus.caption'] = 'Légende';
$_lang['imageplus.credits'] = 'Crédits';
/** Input options render **/
$_lang['imageplus.input_section'] = 'Options d’Image+';
$_lang['imageplus.input_section_desc'] = 'Les options suivantes pourraient être remplacées par des paramètres de contexte/système. Veuillez lire la <a href="https://jako.github.io/ImagePlus/usage/#contextsystem-settings" target="_blank"> documentation </a> pour connaître les clés appropriées dans les paramètres du contexte/système.';
$_lang['imageplus.selectConfig'] = 'Tailles cibles/ratios d’aspect prédéfinis';
$_lang['imageplus.selectConfig_desc'] = 'Sélectionnez un rapport taille/aspect cible prédéfini. Les définitions peuvent être créées dans les paramètres du système.';
$_lang['imageplus.selectConfigForce'] = 'Obligation de fixer des tailles cibles/ratios d’aspect prédéfinis';
$_lang['imageplus.selectConfigForce_desc'] = 'Forcé de sélectionner un rapport taille/aspect de la culture prédéfini. Les définitions peuvent être créées dans les paramètres du système.';
$_lang['imageplus.targetwidth'] = 'Largeur (minimale) de la cible';
$_lang['imageplus.targetwidth_desc'] = '(Facultatif, entier) La largeur ciblée de l’image en sortie. L’image téléchargée devrait avoir cette largeur minimale.';
$_lang['imageplus.targetheight'] = 'Hauteur (minimale) de la cible';
$_lang['imageplus.targetheight_desc'] = '(Facultatif, entier) La hauteur ciblée de l’image en sortie. L’image téléchargée devrait avoir cette hauteur minimale.';
$_lang['imageplus.targetRatio'] = 'Aspect ratio cible';
$_lang['imageplus.targetRatio_desc'] = '(Facultatif, Float) Les proportions ciblée de l’image en sortie, valeur de type float. Si la hauteur et la largeur de la cible sont définies, cette valeur est ignorée.';
$_lang['imageplus.thumbnailWidth'] = 'Largeur miniature';
$_lang['imageplus.thumbnailWidth_desc'] = '(Optionnel, entier) Largeur de la miniature dans le panneau de variable de modèle (TV).';
$_lang['imageplus.allowAltTag'] = 'Afficher le champ tag alt';
$_lang['imageplus.allowAltTag_desc'] = 'Permettre à l’utilisateur à entrer un titre/tag alt pour l’image.';
$_lang['imageplus.allowCaption'] = 'Afficher le champ de légende';
$_lang['imageplus.allowCaption_desc'] = 'Permettre à l’utilisateur d’entrer une légende pour l’image.';
$_lang['imageplus.allowCredits'] = 'Afficher le champ de crédits';
$_lang['imageplus.allowCredits_desc'] = 'Permettre à l’utilisateur d’entrer un crédit pour l’image.';
/** Output options render **/
$_lang['imageplus.phpThumbParams'] = 'Paramètres phpThumb additionnels';
$_lang['imageplus.phpThumbParams_desc'] = 'Ajoutez des filtres additionnels pour phpThumb. La documentation est disponible <a href="http://phpthumb.sourceforge.net/demo/docs/phpthumb.readme.txt" target="_blank">ici</a>.';
$_lang['imageplus.outputChunk'] = 'Chunk d’affichage';
$_lang['imageplus.outputChunk_desc'] = 'Sélectionnez le chunk utilisé pour afficher le résultat de la TV. Laissez vide pour obtenir l’URL brute du résultat.';
$_lang['imageplus.generateUrl'] = 'Génère l’URL de la miniature';
$_lang['imageplus.generateUrl_desc'] = '(Optionnel) L’URL de la miniature n’est peut-être pas nécessaire, si vous générez la miniature dans le chunk de sortie (exemple par un filtre pthumb).';
$_lang['imageplus.generateUrl_desc_warning'] = 'Vous devez activer cette option lorsque vous ne spécifiez pas de morceau de sortie dans les options de sortie ou lorsque vous utilisez le caractère de remplacement [[+url]] dans le morceau de sortie spécifié. Sinon, l’image n’est pas recadrée/redimensionnée et le chemin d’accès à l’image originale est renvoyé.';
/** Placeholder descriptions */
$_lang['imageplus.placeholder.url'] = 'URL de l’image de miniature';
$_lang['imageplus.placeholder.alt'] = 'Texte de l’attribut Alt';
$_lang['imageplus.placeholder.width'] = 'Largeur de l’image miniature (ignorée quand 0)';
$_lang['imageplus.placeholder.height'] = 'Hauteur de l’image miniature (ignorée quand 0)';
$_lang['imageplus.placeholder.source.src'] = 'Chemin de l’image source';
$_lang['imageplus.placeholder.source.width'] = 'Largeur de l’image source';
$_lang['imageplus.placeholder.source.height'] = 'Hauteur de l’image source';
$_lang['imageplus.placeholder.crop.width'] = 'Largeur de l’image source recadrée';
$_lang['imageplus.placeholder.crop.height'] = 'Hauteur de l’image source recadrée';
$_lang['imageplus.placeholder.crop.x'] = 'Position recadrage en x de l’image source';
$_lang['imageplus.placeholder.crop.y'] = 'Position recadrage en y de l’image source';
$_lang['imageplus.placeholder.options'] = 'chaîne d’option phpThumb pour générer l’image miniature';
$_lang['imageplus.placeholder.crop.options'] = 'chaîne d’option de recadrage phpThumb pour générer l’image miniature';
$_lang['imageplus.error.image_too_small.title'] = 'Image trop petite';
$_lang['imageplus.error.image_too_small.msg'] = 'L’image sélectionnée est trop petite pour être utilisé ici. Veuillez sélectionner une image différente.';
$_lang['imageplus.error.image_not_found.title'] = 'Image non trouvée';
$_lang['imageplus.error.image_not_found.msg'] = 'L’image est introuvable et ne peut être recadrée. Veuillez sélectionner une image différente.';

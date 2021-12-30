<?php
/**
 * Default Lexicon Entries for Image+
 *
 * @package imageplus
 * @subpackage lexicon
 */
$_lang['imageplus'] = 'Image+';
$_lang['imageplus.editor_title'] = 'Image+ Editor';
$_lang['imageplus.alt_text'] = 'Alt text';
$_lang['imageplus.caption'] = 'Legenda';
$_lang['imageplus.credits'] = 'Credite';
/** Input options render **/
$_lang['imageplus.input_section'] = 'Image+ Options';
$_lang['imageplus.input_section_desc'] = 'Următoarele opțiuni pot fi înlocuite de setările de context/sistem. Vă rugăm să citiți documentația <a href="https://jako.github.io/ImagePlus/usage/#contextsystem-settings" target="_blank">documentația</a> pentru tastele corespunzătoare din setările de context/sistem.';
$_lang['imageplus.selectConfig'] = 'Dimensiuni țintă predefinite/raporturi de aspect';
$_lang['imageplus.selectConfig_desc'] = 'Selectați un raport predefinit de dimensiune/aspect țintă. Definițiile ar putea fi create în setările sistemului.';
$_lang['imageplus.selectConfigForce'] = 'Dimensiuni țintă predefinite forțate/raporturi de aspect';
$_lang['imageplus.selectConfigForce_desc'] = 'Selectare forțată a unei dimensiuni predefinite a culturii/raport de aspect. Definițiile ar putea fi create în setările sistemului.';
$_lang['imageplus.targetwidth'] = 'Lățimea țintă (minimă)';
$_lang['imageplus.targetwidth_desc'] = '(Opțional, număr întreg) Lățimea țintă pentru imaginea de ieșire. Imaginea încărcată trebuie să aibă această lățime minimă.';
$_lang['imageplus.targetheight'] = 'Înălțimea țintă (minimă)';
$_lang['imageplus.targetheight_desc'] = '(Opțional, număr întreg) Înălțimea țintă pentru imaginea de ieșire. Imaginea încărcată trebuie să aibă această înălțime minimă.';
$_lang['imageplus.targetRatio'] = 'Raportul de aspect țintă';
$_lang['imageplus.targetRatio_desc'] = '(Opțional, float) Raportul de aspect țintă pentru imaginea de ieșire ca valoare float. În cazul în care înălțimea țintă și lățimea țintă sunt stabilite, această valoare este ignorată.';
$_lang['imageplus.thumbnailWidth'] = 'Lățimea miniaturii';
$_lang['imageplus.thumbnailWidth_desc'] = '(Opțional, număr întreg) Lățimea miniaturii imaginii din panoul de variabile al șablonului.';
$_lang['imageplus.allowAltTag'] = 'Afișați câmpul Alt Tag';
$_lang['imageplus.allowAltTag_desc'] = 'Permiteți utilizatorului să introducă un titlu/un etichet pentru imagine.';
$_lang['imageplus.allowCaption'] = 'Afișați câmpul de legendă';
$_lang['imageplus.allowCaption_desc'] = 'Permiteți utilizatorului să introducă o legendă pentru imagine.';
$_lang['imageplus.allowCredits'] = 'Afișați câmpul Credite';
$_lang['imageplus.allowCredits_desc'] = 'Permite utilizatorului să introducă un credit pentru imagine.';
/** Output options render **/
$_lang['imageplus.phpThumbParams'] = 'Parametrii suplimentari phpThumb';
$_lang['imageplus.phpThumbParams_desc'] = 'Adăugați filtre suplimentare etc. pentru phpThumb. Documentația poate fi găsită <a href="http://phpthumb.sourceforge.net/demo/docs/phpthumb.readme.txt" target="_blank">aici</a>.';
$_lang['imageplus.outputChunk'] = 'Output Chunk';
$_lang['imageplus.outputChunk_desc'] = 'Selectați o bucată pentru ieșirea TV. Lăsați gol pentru ieșirea în format raw url.';
$_lang['imageplus.generateUrl'] = 'Generarea URL-ului degetului mare';
$_lang['imageplus.generateUrl_desc'] = '(Opțional) Adresa URL a thumbnail-ului poate să nu fie necesară dacă generați thumbnail-ul în fișierul de ieșire, de exemplu, printr-un filtru de ieșire pthumb.';
$_lang['imageplus.generateUrl_desc_warning'] = 'Trebuie să activați această opțiune atunci când nu specificați o bucată de ieșire în opțiunile de ieșire sau atunci când folosiți simbolul de poziție [[+url]] în bucată de ieșire specificată. În caz contrar, imaginea nu este decupată/redimensionată și se returnează calea originală a imaginii.';
/** Placeholder descriptions */
$_lang['imageplus.placeholder.url'] = 'URL-ul imaginii în miniatură';
$_lang['imageplus.placeholder.alt'] = 'Alt text';
$_lang['imageplus.placeholder.width'] = 'Lățimea imaginii miniaturale (ignorată când este 0)';
$_lang['imageplus.placeholder.height'] = 'Înălțimea imaginii miniaturale (ignorată dacă este 0)';
$_lang['imageplus.placeholder.source.src'] = 'Cale de acces la imaginea sursă';
$_lang['imageplus.placeholder.source.width'] = 'Lățimea imaginii sursă';
$_lang['imageplus.placeholder.source.height'] = 'Înălțimea imaginii sursă';
$_lang['imageplus.placeholder.crop.width'] = 'Lățimea de tăiere a imaginii sursă';
$_lang['imageplus.placeholder.crop.height'] = 'Înălțimea de tăiere a imaginii sursă';
$_lang['imageplus.placeholder.crop.x'] = 'Poziția x de tăiere a imaginii sursă';
$_lang['imageplus.placeholder.crop.y'] = 'Poziția y de tăiere a imaginii sursă';
$_lang['imageplus.placeholder.options'] = 'phpThumb șir de opțiuni pentru a genera imaginea miniaturală';
$_lang['imageplus.placeholder.crop.options'] = 'phpThumb crop șir de opțiuni pentru generarea imaginii thumbnail';
$_lang['imageplus.error.image_too_small.title'] = 'Imagine prea mică';
$_lang['imageplus.error.image_too_small.msg'] = 'Imaginea selectată este prea mică pentru a fi utilizată aici. Vă rugăm să selectați o altă imagine.';
$_lang['imageplus.error.image_not_found.title'] = 'Imaginea nu a fost găsită';
$_lang['imageplus.error.image_not_found.msg'] = 'Imaginea nu a fost găsită și nu poate fi decupată. Vă rugăm să selectați o altă imagine.';

<?php
$_lang['imageplus'] = 'Image+';
$_lang['imageplus.editor_title'] = 'Image+ Szerkesztő';
$_lang['imageplus.alt_text'] = 'Alt text';
$_lang['imageplus.caption'] = 'Felirat';
$_lang['imageplus.credits'] = 'Hitelek';
/** Input options render **/
$_lang['imageplus.section'] = 'Image+ Options';
$_lang['imageplus.section_desc'] = 'A következő beállítások felülírhatók a kontextus/rendszer beállításaival. Kérjük, olvassa el a <a href="https://jako.github.io/ImagePlus/usage/" target="_blank">dokumentációt</a> a megfelelő kulcsokért a kontextus/rendszerbeállításokban.';
$_lang['imageplus.selectConfig'] = 'Előre meghatározott célméretek/aspektusarányok';
$_lang['imageplus.selectConfig_desc'] = 'Válasszon ki egy előre meghatározott célméret/szögarányt. A definíciókat a rendszerbeállításokban lehet létrehozni.';
$_lang['imageplus.selectConfigForce'] = 'Kényszerített előre meghatározott célméretek/aspektusarányok';
$_lang['imageplus.selectConfigForce_desc'] = 'Kényszerített választás egy előre meghatározott termésméret/szögarány. A definíciókat a rendszerbeállításokban lehet létrehozni.';
$_lang['imageplus.targetwidth'] = 'Új szélesség';
$_lang['imageplus.targetwidth_desc'] = '(Választható, egész szám) A kimeneti kép célszélessége. A feltöltött képnek ezzel a minimális szélességgel kell rendelkeznie.';
$_lang['imageplus.targetheight'] = 'Új magasság';
$_lang['imageplus.targetheight_desc'] = '(Választható, egész szám) A kimeneti kép célmagassága. A feltöltött képnek ezzel a minimális magassággal kell rendelkeznie.';
$_lang['imageplus.targetRatio'] = 'A cél képarány';
$_lang['imageplus.targetRatio_desc'] = '(Választható, Float) A kimeneti kép céloldali képaránya float értékként. Ha a célmagasság és a célszélesség be van állítva, ez az érték figyelmen kívül marad.';
$_lang['imageplus.thumbnailWidth'] = 'Miniatűr szélesség';
$_lang['imageplus.thumbnailWidth_desc'] = '(Választható, egész szám) A kép miniatűr szélessége a sablon változó panelen.';
$_lang['imageplus.allowAltTag'] = 'Alt tag megengedése';
$_lang['imageplus.allowAltTag_desc'] = 'Lehetővé teszi a felhasználó számára a kép címének/alt-tagjének megadását.';
$_lang['imageplus.allowCaption'] = 'Felirat mező megjelenítése';
$_lang['imageplus.allowCaption_desc'] = 'Lehetővé teszi a felhasználó számára a kép feliratának megadását.';
$_lang['imageplus.allowCredits'] = 'Mutasd a kreditek mezőt';
$_lang['imageplus.allowCredits_desc'] = 'Lehetővé teszi a felhasználó számára, hogy megadja a kép kreditpontját.';
/** Output options render **/
$_lang['imageplus.phpThumbParams'] = 'További phpThumb paraméterek';
$_lang['imageplus.phpThumbParams_desc'] = 'További szűrők stb. hozzáadása a phpThumbhoz. A dokumentáció megtalálható <a href="http://phpthumb.sourceforge.net/demo/docs/phpthumb.readme.txt" target="_blank">itt</a>.';
$_lang['imageplus.outputChunk'] = 'Kimeneti chunk';
$_lang['imageplus.outputChunk_desc'] = 'Válasszon ki egy darabot a tv-kimenethez. Hagyja üresen a nyers url kimenethez.';
$_lang['imageplus.generateUrl'] = 'Hüvelykujj URL generálása';
$_lang['imageplus.generateUrl_desc'] = '(Választható) A thumb url-re talán nincs szükség, ha a kimeneti csomagban, azaz egy pthumb kimeneti szűrővel generálod a miniatűr képet.';
$_lang['imageplus.generateUrl_desc_warning'] = 'Ezt az opciót akkor kell aktiválnod, ha nem adsz meg kimeneti egységet a kimeneti beállítások között, vagy ha a [[+url]] helyőrzőt használod a megadott kimeneti egységben. Ellenkező esetben a képet nem vágja le/méretezi, és az eredeti kép elérési útvonalát adja vissza.';
/** Placeholder descriptions */
$_lang['imageplus.placeholder.url'] = 'A miniatűr kép URL címe';
$_lang['imageplus.placeholder.alt'] = 'Alt text';
$_lang['imageplus.placeholder.width'] = 'A miniatűr kép szélessége (0 esetén figyelmen kívül hagyva)';
$_lang['imageplus.placeholder.height'] = 'A miniatűr kép magassága (0 esetén figyelmen kívül hagyva)';
$_lang['imageplus.placeholder.source.src'] = 'A forráskép elérési útvonala';
$_lang['imageplus.placeholder.source.width'] = 'A forráskép szélessége';
$_lang['imageplus.placeholder.source.height'] = 'A forráskép magassága';
$_lang['imageplus.placeholder.crop.width'] = 'A forráskép vágási szélessége';
$_lang['imageplus.placeholder.crop.height'] = 'A forráskép vágási magassága';
$_lang['imageplus.placeholder.crop.x'] = 'A forráskép x pozíciójának kivágása';
$_lang['imageplus.placeholder.crop.y'] = 'A forráskép y pozíciójának vágása';
$_lang['imageplus.placeholder.options'] = 'phpThumb opció string a miniatűr kép létrehozásához';
$_lang['imageplus.placeholder.crop.options'] = 'phpThumb crop opció string a miniatűr kép létrehozásához';
$_lang['imageplus.error.image_too_small.title'] = 'Túl kicsi kép';
$_lang['imageplus.error.image_too_small.msg'] = 'A kiválasztott kép túl kicsi ahhoz, hogy itt felhasználható legyen. Kérjük, válasszon másik képet.';
$_lang['imageplus.error.image_not_found.title'] = 'Kép nem található';
$_lang['imageplus.error.image_not_found.msg'] = 'A képet nem találtuk, és nem lehet levágni. Kérjük, válasszon másik képet.';
/** System settings **/
$_lang['area_imageplus'] = 'Image+';
$_lang['setting_imageplus.debug'] = 'Debug';
$_lang['setting_imageplus.debug_desc'] = 'Naplózza a hibakeresési információkat a MODX hibanaplójában.';
$_lang['setting_imageplus.select_config'] = 'Előre meghatározott termésméretek/szögarányok';
$_lang['setting_imageplus.select_config_desc'] = 'Létrehozhat előre definiált vágási méret/szögarányokat, amelyek a sablonváltozó beállításaiban választhatók.';
$_lang['setting_imageplus.force_config'] = 'Előre meghatározott méret/arányok kikényszerítése';
$_lang['setting_imageplus.force_config_desc'] = 'Előre meghatározott méret/szögarányok használatának kikényszerítése.';
/** System settings grid */
$_lang['setting_imageplus.configname'] = 'Name';

<?php
$output = '';
$additional = '';

if($options[xPDOTransport::PACKAGE_ACTION] = xPDOTransport::ACTION_UPGRADE){
    $output =   '<h2>Warning: Image+ v3 is NOT compatible with v2.x</h2>
                         <p style="font-weight: bold; margin:1em 0; text-align:center">
                          Image+ v3 is not backward compatible with v2.x.<br />
                          Any existing Image+ TVs will break spectaculary.
                         </p>';
}

switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
    case xPDOTransport::ACTION_UPGRADE:

    if($options['release'] == 'alpha' || $options['release'] == 'beta'){
        $output .= '<h2>Warning: This is a beta release</h2>
                   <p style="margin:1em 0; text-align:center">This means that it is still not yet stable enough to be fully released,
                    and may contain undiscovered bugs or lack features planned for the final release.</p>
                   <p style="margin:1em 0; font-size:0.8em; text-align:center">Please log any bugs on
                   <a href="https://github.com/alanpich/tvImagePlus/issues?milestone=2" target="_blank" title="Image+ Issue Tracker">GitHub</a></p>
                    '.$additional.'
                    <p style="margin:1em 0; text-align:center"><strong><blink>You have been warned</blink></strong><br /></p>';
    };
    break;

    case xPDOTransport::ACTION_UNINSTALL:
        break;
}



return $output;
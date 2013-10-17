<?php
$output = '';
$additional = '';
if($options[xPDOTransport::PACKAGE_ACTION] = xPDOTransport::ACTION_UPGRADE){
    $additional = '<p>The upgrade script included in this package aims to
                      transform TV values from v2.x to the new v3 spec. Due
                      to bugs in the 2.x code, not all transformations go
                      successfully. Please be careful, and log any issues on
                      <a href="https://github.com/alanpich/tvImagePlus/issues?milestone=2" target="new">GitHub</a><br /></p>';
}

switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
    case xPDOTransport::ACTION_UPGRADE:

    if($options['release'] == 'alpha' || $options['release'] == 'beta'){
        $output = '<h2>Warning: This is not a stable package!</h2>
                   <p>This version of <strong>Image+</strong> is a pre-release beta<br /></p>
                   <p>This means that it is still not considered stable enough to be a public release,
                    and may contain bugs, minefields, razor blades and other nasties, and it is not
                    advised to install it onto a production server.<br /></p>
                    '.$additional.'
                    <p><strong>You have been warned</strong><br /></p>';
    };
    break;

    case xPDOTransport::ACTION_UNINSTALL:
        break;
}



return $output;
<?php
/**
 * Copyright 2013 by Alan Pich <alan.pich@gmail.com>
 *
 * This file is part of tvImagePlus
 *
 * tvImagePlus is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * tvImagePlus is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * tvImagePlus; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
 * Suite 330, Boston, MA 02111-1307 USA
 *
 * @package tvImagePlus
 * @author Alan Pich <alan.pich@gmail.com>
 * @copyright Alan Pich 2013
 */

require dirname(__FILE__) . '/build.config.php';
require PKG_ROOT . 'config.core.php';
Tools::StartTimer();


// Create modx & package instance -----------------------------------------------------------------
$modx = Tools::loadModxInstance();
$builder = new modPackageBuilder($modx);
$builder->createPackage(PKG_NAMESPACE, PKG_VERSION, PKG_RELEASE);



// Register Namespace -----------------------------------------------------------------------------
$builder->registerNamespace(PKG_NAMESPACE, false, true, '{core_path}components/' . PKG_NAMESPACE . '/');



// Create the plugin object -----------------------------------------------------------------------
include PKG_BUILD . 'data/transport.plugin.ImagePlus.php';



// Package core and assets directories ------------------------------------------------------------
$modx->log(modX::LOG_LEVEL_INFO, 'Packaging core & assets directories...');
$vehicle->resolve('file',array(
    'source' => PKG_ASSETS,
    'target' => "return MODX_ASSETS_PATH . 'components/';",
));
$vehicle->resolve('file',array(
    'source' => PKG_CORE,
    'target' => "return MODX_CORE_PATH . 'components/';",
));



// Add in installer scripts as resolvers
$modx->log(modX::LOG_LEVEL_INFO,'Adding install/upgrade scripts...');
$vehicle->resolve('php',array(
    'source' => PKG_BUILD.'data/transport.resolver.php',
));
$builder->putVehicle($vehicle);



// Add documentation ------------------------------------------------------------------------------
$modx->log(modX::LOG_LEVEL_INFO, 'Adding documentation...');
$builder->setPackageAttributes(
    array(
        'license' => file_get_contents(PKG_CORE.'docs/LICENSE'),
        'readme' => Tools::parseReadmeTpl(PKG_CORE.'docs/README.tpl'),
        'changelog' => file_get_contents(PKG_CORE.'docs/CHANGELOG'),
        'setup-options' => array(
            'source' => PKG_BUILD.'data/transport.options.php',
        ),
    )
);



// Create transport package -----------------------------------------------------------------------
$modx->log(modX::LOG_LEVEL_INFO, 'Packing component for transport...');
$builder->pack();



// Copy transport package back to PKG_ROOT --------------------------------------------------------
$zipFile = PKG_NAMESPACE.'-'.PKG_VERSION.'-'.PKG_RELEASE.'.transport.zip';
$zipPath = MODX_CORE_PATH.'packages/'. $zipFile;
copy($zipPath,PKG_ROOT.$zipFile);



// Build process finished -------------------------------------------------------------------------
$totalTime= sprintf("%2.4f s", Tools::stopTimer());
$modx->log(modX::LOG_LEVEL_INFO,"Package ".PKG_NAME.' '.PKG_VERSION.'-'.PKG_RELEASE." built in {$totalTime}");


exit;
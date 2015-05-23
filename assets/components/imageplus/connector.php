<?php
/**
 * Copyright 2013 by Alan Pich <alan.pich@gmail.com>
 *
 * This file is part of ImagePlus
 *
 * ImagePlus is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * ImagePlus is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * ImagePlus; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
 * Suite 330, Boston, MA 02111-1307 USA
 *
 * @package imageplud
 * @author Alan Pich <alan.pich@gmail.com>
 * @copyright Alan Pich 2013
 */

/**
 * MGR Connector
 *
 * @package imageplus
 * @copyright Alan Pich 2012
 */
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
require_once MODX_CONNECTORS_PATH . 'index.php';

$corePath = $modx->getOption('imageplus.core_path', null, $modx->getOption('core_path') . 'components/imageplus/');
$imageplus = $modx->getService('imageplus', 'ImagePlus', $corePath . 'model/imageplus/', array(
    'core_path' => $corePath
));

// Load up some lexiconzzzz
$modx->lexicon->load('imageplus:default');

// Handle request 
$modx->request->handleRequest(array(
    'processors_path' => $imageplus->getOption('processorsPath'),
    'location' => ''
));

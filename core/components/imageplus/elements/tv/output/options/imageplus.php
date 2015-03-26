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
 * @package imageplus
 * @author Alan Pich <alan.pich@gmail.com>
 * @copyright Alan Pich 2013
 */

/** @var \modX $modx */
$root = $modx->getOption('imageplus.core_path',null,$modx->getOption('core_path').'components/imageplus/');
if(!class_exists('ImagePlus')){ require $root.'imageplus.class.php'; };
$helper = new ImagePlus($modx);

$modx->lexicon->load('imageplus:default');
$a = print_r($this->getProperties(),1);

$modx->controller->setPlaceholder('t_width',$a);
$modx->controller->setPlaceholder('imagepluslexicon',json_encode($helper->config['lexicon']));
$modx->controller->setPlaceholder('imageplus',$helper);
$modx->controller->addLexiconTopic('imageplus:default');


return $modx->smarty->fetch($root.'elements/tv/output/tpl/imageplus.options.tpl');

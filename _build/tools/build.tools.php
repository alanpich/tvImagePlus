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


/**
 * Class Tools
 *
 * Helpful tools to clean up the transport build file
 *
 */
class Tools {

    protected static $_startTime;

    /**
     * Start a timer
     */
    public static function startTimer(){
        self::$_startTime = microtime(true);
    }

    /**
     * Stop the timer and return time
     * @return float
     */
    public static function stopTimer(){
        $now = microtime(true);
        return $now - self::$_startTime;
    }


    public static function loadModxInstance(){
        require_once MODX_CORE_PATH . 'model/modx/modx.class.php';
        $modx= new modX();
        $modx->initialize('mgr');
        echo XPDO_CLI_MODE ? '' : '<pre>';
        $modx->setLogLevel(modX::LOG_LEVEL_INFO);
        $modx->setLogTarget('ECHO');
        $modx->loadClass('transport.modPackageBuilder','',false, true);
        return $modx;
    }


    /**
     * Parse the smarty readme tpl for packaging
     * @param string $path Path to tpl
     * @return string
     */
    public static function parseReadmeTpl( $path ){
        global $modx;
        $modx->getService('smarty','smarty.modSmarty');

        $modx->smarty->assign('date',date("jS M Y g:ia"));
        $modx->smarty->assign('version',PKG_VERSION.' '.PKG_RELEASE);
        $modx->smarty->assign('commit',PKG_COMMIT);
        $readme = $modx->smarty->fetch($path);
        return $readme;
    }//


    /**
     * Get currect git commit id
     * @param string repoRoot Path to repository root
     * @return string commit hash
     */
    function getGitCommitId( $repoRoot ){
        // Check git exists
        $whichGit = `which git`;
        if(empty($whichGit)){ return ''; };

        // Check we're in a git repo
        $gitFolder = str_replace('//','/',$repoRoot.'/.git');
        if( ! is_dir($gitFolder) ){ return ''; };

        //
        $test = shell_exec("cd $repoRoot; git rev-parse HEAD;");
        return trim($test);
    }//




}

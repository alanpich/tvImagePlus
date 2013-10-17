<?php
namespace ImagePlus\Install;

use modX;
use xPDOQuery;
use xPDO;


/**
 * Class UpgradeController
 *
 * Handles running of upgrade scripts depending on the
 * previous version installed vs the new version. Will run
 * all relevant upgrade scripts in the correct order up until
 * the latest version
 *
 * @example
 *  $upgrader = new UpgradeController($modx,'mypackagename');
 *  $upgrader->setScriptDirectory("/path/to/install/scripts/");
 *  $upgrader->run();
 *
 * @package ImagePlus\Install
 */
class UpgradeController
{
    /**
     * Current version of package installed
     *
     * @var Version
     */
    protected $installedVersion;
    /**
     * The new version being installed
     *
     * @var Version
     */
    protected $newVersion;
    /**
     * Is this the first package version to be installed on this MODX
     *
     * @var bool
     */
    protected $firstInstall = false;
    /**
     * MODX instance we're installing to
     *
     * @var \modX
     */
    protected $modx;
    /**
     * Name of package
     *
     * @var string
     */
    protected $pkgName;
    /**
     * Path to directory containing upgrade scripts
     *
     * @var string
     */
    protected $scriptDir;
    /**
     * Has the scripts dir been searched yet?
     *
     * @var bool
     */
    protected $scriptDirSearched = false;
    /**
     * All install/update scripts that were found in scriptDir
     *
     * @var array
     */
    protected $scripts = array();


    /**
     * Constructor
     *
     * @param modX   $modx    MODX Instance
     * @param string $pkgName Name of package
     */
    public function __construct(\modX $modx, $pkgName)
    {
        $this->modx = $modx;
        $this->pkgName = $pkgName;
        $this->modx->getPackage('transport.modTransportPackage');

        if (!$this->isFirstInstall()) {
            $this->installedVersion = $this->getInstalledVersion();
            $this->newVersion = $this->getNewVersion();
        } else {
            // Cheat
            $this->installedVersion = new Version('0.0.0');
            $this->newVersion = $this->getInstalledVersion();
        }
    }


    /**
     * Sets the path to a directory containing the upgrade scripts
     *
     * @param string $path Absolute path to directory
     */
    public function setScriptDirectory($path)
    {
        $this->scriptDir = rtrim($path, '/') . '/';
        $this->findScripts();
    }


    /**
     * Run the upgrade process
     *
     * @throws Exception
     * @return bool
     */
    public function run()
    {
        set_time_limit(0);

        if(!$this->scriptDirSearched)
            throw new Exception("Scripts not loaded. You need to setScriptDirectory() before you run()");


        $this->modx->log(xPDO::LOG_LEVEL_WARN,"Upgrading Image+ from v{$this->installedVersion} to v{$this->newVersion}");

        $this->modx->log(xPDO::LOG_LEVEL_ERROR,"Scripts: ".print_r($this->scripts,1));

        try {
            foreach ($this->scripts as $versionStr => $tasks) {
                $V = new Version($versionStr);
                if ($V->isGreaterThan($this->installedVersion)) {
                    $this->modx->log(xPDO::LOG_LEVEL_WARN,"Running install script for $versionStr");
                    $this->runScript($tasks['install']);
                    if (!$this->firstInstall) {
                        $this->modx->log(xPDO::LOG_LEVEL_WARN,"Running upgrade script to $versionStr");
                        $this->runScript($tasks['upgrade']);
                    }
                }
            }
        } catch (Exception $E){
            $this->modx->log(xPDO::LOG_LEVEL_ERROR,$E->getMessage());
            return false;
        }
        return true;
    }

    /**
     * Checks to see if this is the first version of package
     * installed on this modx instance
     *
     * @return bool
     */
    protected function isFirstInstall()
    {
        $this->firstInstall = $this->modx->getCount(
                'modTransportPackage',
                array(
                    'package_name' => $this->pkgName
                )
            ) <= 1;

        return $this->firstInstall;
    }

    /**
     * Returns the currently-installed version
     *
     * @return Version
     */
    protected function getInstalledVersion()
    {
        /** @var xPDOQuery $q */
        $q = $this->modx->newQuery(
            'modTransportPackage',
            array(
                'package_name' => $this->pkgName
            )
        );
        $q->sortby('updated', 'DESC');
        $q->limit(1, 1);
        $collection = $this->modx->getCollection('modTransportPackage', $q);
        if (count($collection) < 1) {
            return null;
        }
        $package = array_shift($collection);
        $version = $package->get('version_major') . '.' . $package->get('version_minor') . '.' . $package->get(
                'version_patch'
            );
        if (strlen($package->get('release'))) {
            $version .= '.' . $package->get('release');
        }
        return new Version($version);
    }

    /**
     * Returns the version to be installed
     *
     * @return Version
     */
    protected function getNewVersion()
    {
        /** @var xPDOQuery $q */
        $q = $this->modx->newQuery(
            'modTransportPackage',
            array(
                'package_name' => $this->pkgName
            )
        );
        $q->sortby('updated', 'DESC');
        $q->limit(1);
        $package = array_shift($this->modx->getCollection('modTransportPackage', $q));
        $version = $package->get('version_major') . '.' . $package->get('version_minor') . '.' . $package->get(
                'version_patch'
            );
        if (strlen($package->get('release'))) {
            $version .= '.' . $package->get('release');
        }
        return new Version($version);
    }


    /**
     * Search the scriptDir for scripts to be run
     *
     * @throws Exception
     */
    protected function findScripts()
    {
        $path = $this->scriptDir;
        if (!$dh = opendir($path)) {
            throw new Exception("Upgrade script dir does not exist or could not be opened - {$path}");
        }

        $files = array();

        while (false !== ($file = readdir($dh))) {
            if (is_dir($file)) {
                continue;
            }
            if ($file == '.' || $file == '..') {
                continue;
            }
            if (preg_match('/^((?:upgrade|install)\\.\\d+\\.\\d+\\.\\d+\\.php)$/', $file)) {
                $files[] = $file;
            }
        }

        // Parse selected files and prepare
        foreach ($files as $script) {
            $bits = explode('.', $script, 2);
            $task = $bits[0];
            $versionStr = str_replace('.php', '', $bits[1]);

            $this->scripts[$versionStr][$task] = $this->scriptDir . $script;
        }

        ksort($this->scripts);
        $this->scriptDirSearched = true;
    }


    /**
     * Runs a script file at $path
     *
     * @param string $path Path to script file
     * @throws Exception
     */
    protected function runScript($path)
    {
        echo "Running $path\n";
        $class = include($path);
        $script = new $class($this->modx);
        if(!$script instanceof Script)
            throw new Exception("Install/Upgrade scripts should extend ImagePlus\Installer\Script");

        $script->process();
    }
}
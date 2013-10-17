<?php
namespace ImagePlus\Install;

/**
 * Represents a release version
 *
 * @package ImagePlus\Install
 */
class Version
{
    /** Regular Expression used to parse a version string */
    const REGEX = "/^v?([\\d]+).([\\d]+).([\\d]+)(?:$|\\.(.*))/";


    /** @var  int */
    public $major = 0;
    /** @var  int */
    public $minor = 0;
    /** @var  int */
    public $patch = 0;
    /** @var  string */
    public $release = '';

    /**
     * Constructor
     *
     * @param string $versionString
     */
    public function __construct($versionString = '')
    {
        if (strlen($versionString)) {
            $this->setFromString($versionString);
        }
    }

    /**
     * Parses a string using
     *
     * @param $versionString
     * @throws Exception
     */
    public function setFromString($versionString)
    {
        $versionString = str_replace('-','.',$versionString);
        $parsed = array();
        preg_match(self::REGEX, $versionString, $parsed);

        if (count($parsed) < 4 || count($parsed) > 5) {
            throw new Exception("Invalid version string $versionString");
        }


        $this->major = (int)$parsed[1];
        $this->minor = (int)$parsed[2];
        $this->patch = (int)$parsed[3];
        if (isset($parsed[4])) {
            $this->release = $parsed[4];
        }
    }


    /**
     * Test if versions match (excluding release string)
     *
     * @param string|Version $otherVersion Version to compare with
     * @return bool
     */
    public function isSame($otherVersion)
    {
        if (is_string($otherVersion)) {
            $otherVersion = new static($otherVersion);
        }
        return (
               $this->major == $otherVersion->major
            && $this->minor == $otherVersion->minor
            && $this->patch == $otherVersion->patch
        );
    }

    /**
     * Compare this version with another and return true if this version
     * is lower than the compared one
     *
     * @param string|Version $otherVersion The version to compare to
     * @return bool
     */
    public function isLessThan($otherVersion)
    {
        if (is_string($otherVersion)) {
            $otherVersion = new static($otherVersion);
        }

        if($this->isSame($otherVersion))
            return false;

        if ($this->major < $otherVersion->major) {
            return true;
        }
        if ($this->major > $otherVersion->major) {
            return false;
        }

        if ($this->minor < $otherVersion->minor) {
            return true;
        }
        if ($this->minor > $otherVersion->minor) {
            return false;
        }

        if ($this->patch < $otherVersion->patch) {
            return true;
        }
        if ($this->patch > $otherVersion->patch) {
            return false;
        }
        return false;
    }


    /**
     * Test if this version is greater than another version
     *
     * @param string|Version $otherVersion Version to compare with
     * @return bool
     */
    public function isGreaterThan($otherVersion)
    {
        if (is_string($otherVersion)) {
            $otherVersion = new static($otherVersion);
        }

        if($this->isSame($otherVersion))
            return false;

        if ($this->major > $otherVersion->major) {
            return true;
        }
        if ($this->major < $otherVersion->major) {
            return false;
        }

        if ($this->minor > $otherVersion->minor) {
            return true;
        }
        if ($this->minor < $otherVersion->minor) {
            return false;
        }

        if ($this->patch > $otherVersion->patch) {
            return true;
        }
        if ($this->patch < $otherVersion->patch) {
            return false;
        }
        return false;
    }


    /**
     * Output version as string
     *
     * @return string
     */
    public function __toString()
    {
        $v = "{$this->major}.{$this->minor}.{$this->patch}";
        if (strlen($this->release)) {
            $v .= ".{$this->release}";
        }
        return $v;
    }


}
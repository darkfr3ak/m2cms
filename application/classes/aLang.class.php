<?php
/**
 * Language management class
 *
 * @author agrafix
 */
class aLang {
	/**
	 * saves ini section that is used
	 *
	 * @var string
	 */
	var $section = "";
 
	/**
	 * saves current language
	 *
	 * @var string
	 */
	var $lang = "";
 
	/**
	 * where do i find the language inis
	 *
	 * @var string
	 */
	var $path = "application/language/";
 
	/**
	 * parsed ini array
	 *
	 * @var array
	 */
	var $parsed = array();
 
	/**
	 * setup the class
	 *
	 * @param string $section
	 * @param string $language
	 * @param string $path
	 */
	function aLang($section, $language, $path="") {
            $this->section = $section;
            $this->lang = $language;
 
            if (!empty($path)) {
                $this->path = $path;
            }
 
            $this->parse();
	}
 
	/**
	 * parse the language file
	 *
	 */
	function parse() {
		$filename = $this->path.$this->lang.".ini";
		$cachedata = $this->path.$this->lang.".cachedata";
		$cachearray = $this->path.$this->lang.".cachearray";
 
		if (!file_exists($filename)) {
			die("aLang Error: Language File for $this->lang doesn't exist!");
		}
 
		// caching system
		$ini_size = filesize($filename);
 
		if (file_exists($cachedata) && file_exists($cachearray)) {
			$cachesize = implode ('', file ($cachedata));
 
			if ($ini_size != $cachesize) { // reparse
				$this->reparse($filename);
			}
			else { // load from cache
				$serialized = base64_decode(implode('', file($cachearray)));
				$this->parsed = unserialize($serialized);
			}
		}
		else { // reparse
			$this->reparse($filename);
		}
	}
 
	/**
	 * parse ini file and write cache
	 *
	 * @param string $fname
	 */
	function reparse($fname) {
		$this->parsed = parse_ini_file($fname, true);
		$ini_size = filesize($fname);
 
		$fp = @fopen($this->path.$this->lang.".cachedata", "w+");
		@fwrite($fp, $ini_size);
		@fclose($fp);
 
		$fp = @fopen($this->path.$this->lang.".cachearray", "w+");
		@fwrite($fp, base64_encode(serialize($this->parsed)));
		@fclose($fp);
	}
 
	/**
	 * grab translation
	 *
	 * @param string $varname
	 * @return string
	 */
	function get($varname) {
		if (!isset($this->parsed[$this->section][$varname])) {
			die("aLang Error: $this->section[$varname] not found!");
		}
		return $this->parsed[$this->section][$varname];
	}
 
	/**
	 * grab translation out of specified section
	 *
	 * @param string $section
	 * @param string $varname
	 * @return string
	 */
	function grab($section, $varname) {
            if (!isset($this->parsed[$section][$varname])) {
                die("aLang Error: $section[$varname] not found!");
            }
 
            return $this->parsed[$section][$varname];
	}
}
?>

<?php

/* 
 * Copyright (C) 2014 darkfr3ak <info at darkfr3ak.de>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

ob_start();
ini_set('session.use_trans_sid', false);
ini_set('session.use_only_cookies', true);
ini_set('url_rewriter.tags', '');
ini_set("display_errors", "on");
header("Content-type:text/html; charset=utf-8"); 
error_reporting(E_ALL ^ E_NOTICE);

define("DS", DIRECTORY_SEPARATOR);
define("SITE_ROOT", str_replace($DOCUMENT_ROOT, "", dirname($PHP_SELF)));
define("THEME", "default");

// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once(SITE_ROOT."application/libraries/PasswordCompatibility.lib.php");
}

/**
 * Autoloader
 * 
 * @author Mark Young <hello@sparky-san.com>
 * @link http://www.sparky-san.com
 * 
 */

function application_autoloader($class) {
    $class_filename = $class.'.class.php';
    $lib_filename = $class.'.lib.php';
    $class_root = dirname(__FILE__);
    $cache_file = "{$class_root}/cache/classpaths.cache";
    $cache_folder = "{$class_root}/cache/";
    $path_cache = (file_exists($cache_file)) ? unserialize(file_get_contents($cache_file)) : array();
    
    if (!file_exists($cache_folder)) { mkdir($cache_folder); }
    
    if (!is_array($path_cache)) { $path_cache = array(); }
    
    if (array_key_exists($class, $path_cache)) {
        /* Load class using path from cache file (if the file still exists) */
        if (file_exists($path_cache[$class])) { require_once $path_cache[$class]; }

    } else {
        /* Determine the location of the file within the $class_root and, if found, load and cache it */
        $directories = new RecursiveDirectoryIterator($class_root);
        foreach(new RecursiveIteratorIterator($directories) as $file) {
            if ($file->getFilename() == $class_filename || $file->getFilename() == $lib_filename) {
                $full_path = $file->getRealPath();
                $path_cache[$class] = $full_path;                        
                require_once $full_path; 
                break;
            }
        }
    }

    $serialized_paths = serialize($path_cache);
    if ($serialized_paths != $path_cache) { file_put_contents($cache_file, serialize($path_cache)); }
}

spl_autoload_register('application_autoloader');

HTTP::init();

$LS = new LoginSystem();
$LS->site_root = SITE_ROOT;
<?php

/**
 * Class Autoloader
 *
 * Simple PSR-0 autoloader
 */
class Autoloader
{
    /**
     * Holds the registered PSR-0 directories
     *
     * @var array
     */
    protected static $directories = array();

    /**
     * @param string $sourceFile
     */
    public static function init( $sourceFile = null )
    {
        // Make sure we have a source file
        if (is_null($sourceFile)) {
            $sourceFile = __DIR__ . DIRECTORY_SEPARATOR . 'psr0-directories.json';
        }

        // Fetch the registered paths
        if (file_exists($sourceFile)) {
            $directories = json_decode(file_get_contents($sourceFile));
            foreach ($directories as $directory) {
                self::register($directory);
            }
            unset($directory);
        }
    }

    /**
     * Register a (relative) path as PSR-0 directory
     *
     * @param $path
     */
    public static function register( $path )
    {
        // Handle relative paths
        if (substr($path, 0, 1) !== DIRECTORY_SEPARATOR) {
            $bt = debug_backtrace();
            $bt = array_shift($bt);
            $path = rtrim(realpath(dirname($bt['file']) . DIRECTORY_SEPARATOR . $path), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        }

        // Register the directory
        self::$directories[]=$path;
    }

    /**
     * @param string $className
     */
    public static function run($className)
    {
        // Build filename for class
        $fileNames = array(
            str_replace("\\", DIRECTORY_SEPARATOR, $className) . '.php',
            str_replace("\\", DIRECTORY_SEPARATOR, strtolower($className)) . '.class.inc'
        );

        // Loop through directories & name types
        foreach (self::$directories as $directory) {
            foreach ($fileNames as $name) {
                // Include & bail if the file exists
                $filename = $directory . DIRECTORY_SEPARATOR . $name;
                if (file_exists($filename)) {
                    include $filename;
                    return;
                }
            }
        }
    }
}

// Initialize the loader
Autoloader::init();
spl_autoload_register(array("\\Autoloader","run"));

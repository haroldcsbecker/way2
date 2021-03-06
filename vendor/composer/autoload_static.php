<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0124fec62cc951b56aec1d7e9fc404f5
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Service\\' => 8,
        ),
        'C' => 
        array (
            'Config\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Service\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Config\\' => 
        array (
            0 => __DIR__ . '/../..' . '/config',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0124fec62cc951b56aec1d7e9fc404f5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0124fec62cc951b56aec1d7e9fc404f5::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}

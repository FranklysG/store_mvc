<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb6482a19629862fe42f327c2713dc16c
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb6482a19629862fe42f327c2713dc16c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb6482a19629862fe42f327c2713dc16c::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}

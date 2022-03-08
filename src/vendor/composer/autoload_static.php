<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit40237af39a0dc65aa96b61ac71045e56
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
            0 => __DIR__ . '/../..' . '/Classes',
        ),
    );

    public static $classMap = array (
        'App\\DB' => __DIR__ . '/../..' . '/Classes/DB.php',
        'App\\User' => __DIR__ . '/../..' . '/Classes/User.php',
        'App\\Util' => __DIR__ . '/../..' . '/Classes/Utils.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit40237af39a0dc65aa96b61ac71045e56::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit40237af39a0dc65aa96b61ac71045e56::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit40237af39a0dc65aa96b61ac71045e56::$classMap;

        }, null, ClassLoader::class);
    }
}

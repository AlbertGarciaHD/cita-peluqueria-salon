<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit33995127d7475bc442d51efd160231a2
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
        'M' => 
        array (
            'Model\\' => 6,
            'Middleware\\' => 11,
            'MVC\\' => 4,
        ),
        'C' => 
        array (
            'Controllers\\' => 12,
            'Classes\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
        'Model\\' => 
        array (
            0 => __DIR__ . '/../..' . '/models',
        ),
        'Middleware\\' => 
        array (
            0 => __DIR__ . '/../..' . '/middleware',
        ),
        'MVC\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
        'Controllers\\' => 
        array (
            0 => __DIR__ . '/../..' . '/controllers',
        ),
        'Classes\\' => 
        array (
            0 => __DIR__ . '/../..' . '/classes',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit33995127d7475bc442d51efd160231a2::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit33995127d7475bc442d51efd160231a2::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit33995127d7475bc442d51efd160231a2::$classMap;

        }, null, ClassLoader::class);
    }
}

<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitbe6bca9c4b77626fed664cdb88e89ecb
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitbe6bca9c4b77626fed664cdb88e89ecb::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitbe6bca9c4b77626fed664cdb88e89ecb::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitbe6bca9c4b77626fed664cdb88e89ecb::$classMap;

        }, null, ClassLoader::class);
    }
}

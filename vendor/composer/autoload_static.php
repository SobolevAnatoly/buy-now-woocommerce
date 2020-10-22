<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9212e9bcc2941b5dd7cca1f7b7d20a4d
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Testcorp\\BuyNow\\' => 16,
        ),
        'P' => 
        array (
            'Premmerce\\SDK\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Testcorp\\BuyNow\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Premmerce\\SDK\\' => 
        array (
            0 => __DIR__ . '/..' . '/premmerce/wordpress-sdk/src',
        ),
    );

    public static $classMap = array (
        'Premmerce\\SDK\\V2\\FileManager\\FileManager' => __DIR__ . '/..' . '/premmerce/wordpress-sdk/src/V2/FileManager/FileManager.php',
        'Premmerce\\SDK\\V2\\Notifications\\AdminNotifier' => __DIR__ . '/..' . '/premmerce/wordpress-sdk/src/V2/Notifications/AdminNotifier.php',
        'Premmerce\\SDK\\V2\\Plugin\\PluginInterface' => __DIR__ . '/..' . '/premmerce/wordpress-sdk/src/V2/Plugin/PluginInterface.php',
        'Testcorp\\BuyNow\\Admin\\Admin' => __DIR__ . '/../..' . '/src/Admin/Admin.php',
        'Testcorp\\BuyNow\\BuyNowPlugin' => __DIR__ . '/../..' . '/src/BuyNowPlugin.php',
        'Testcorp\\BuyNow\\Frontend\\Frontend' => __DIR__ . '/../..' . '/src/Frontend/Frontend.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9212e9bcc2941b5dd7cca1f7b7d20a4d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9212e9bcc2941b5dd7cca1f7b7d20a4d::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit9212e9bcc2941b5dd7cca1f7b7d20a4d::$classMap;

        }, null, ClassLoader::class);
    }
}

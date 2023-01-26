<?php

declare(strict_types=1);

use Adapter\PhpSpreadsheetAdapter;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator, \Symfony\Component\DependencyInjection\ContainerBuilder $container): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load('App\\', __DIR__ . '/../src/')
        ->exclude([
            __DIR__ . '/../src/DependencyInjection/',
            __DIR__ . '/../src/Entity/',
            __DIR__ . '/../src/Kernel.php'
        ]);

//    $container->register('phpspreedsheet', PhpSpreadsheetAdapter::class)
//        ->addArgument($container->get('env')->)
//        ->addMethodCall('setPhpSpreedsheetLib', [\PhpOffice\PhpSpreadsheet\IOFactory::load('filename')], true);
};

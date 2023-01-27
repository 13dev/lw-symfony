<?php

declare(strict_types=1);

use App\Infra\Adapter\SpreadsheetAdapter;
use App\Infra\Iterator\SpreadsheetIterator;
use App\Infra\Repository\ServerRepository;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator, \Symfony\Component\DependencyInjection\ContainerBuilder $container,): void {
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

    $filename = $container->getParameter('kernel.project_dir') . '/public/LeaseWeb_servers_filters_assignment.xlsx';


//    $services->set('data', IOFactory::class)
//        ->call('load', [$filename], true)
//        ->private();

    $services->set(SpreadsheetAdapter::class)
        ->args([$filename]);

};

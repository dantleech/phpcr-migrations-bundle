<?php
/*
 * This file is part of the <package> package.
 *
 * (c) 2011-2015 Daniel Leech 
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DTL\Bundle\PhpcrMigrations\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class PhpcrMigrationsExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $container->setParameter('phpcr_migrations.version_node_name', $config['version_node_name']);

        $paths = $config['paths'];

        foreach ($container->getParameter('kernel.bundles') as $bundleFqn) {
            $reflection = new \ReflectionClass($bundleFqn);
            $path = dirname($reflection->getFileName());
            $migrationsPath = $path . '/Resources/phpcr-migrations';

            if (file_exists($migrationsPath)) {
                $paths[] = $migrationsPath;
            }
        }

        $container->setParameter('phpcr_migrations.paths', $paths);
        $loader->load('services.xml');
    }
}

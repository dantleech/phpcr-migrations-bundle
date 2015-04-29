<?php

/*
 * This file is part of the PHPCR Migrations package
 *
 * (c) Daniel Leech <daniel@dantleech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use DTL\Bundle\PhpcrMigrations\PhpcrMigrationsBundle;
use DTL\Bundle\PhpcrMigrations\Tests\Resources\Bundle\OneTestBundle\OneTestBundle;
use DTL\Bundle\PhpcrMigrations\Tests\Resources\Bundle\TwoTestBundle\TwoTestBundle;
use Symfony\Cmf\Component\Testing\HttpKernel\TestKernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends TestKernel
{
    public function configure()
    {
        $this->requireBundleSets(array(
            'default',
            'phpcr_odm',
        ));

        $this->addBundles(array(
            new PhpcrMigrationsBundle(),
            new OneTestBundle(),
            new TwoTestBundle(),
        ));
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->import(CMF_TEST_CONFIG_DIR . '/default.php');
        $loader->import(CMF_TEST_CONFIG_DIR . '/phpcr_odm.php');
        $loader->load(__DIR__ . '/config/config.yml');
    }
}

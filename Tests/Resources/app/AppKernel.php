<?php

use Symfony\Cmf\Component\Testing\HttpKernel\TestKernel;
use Symfony\Component\Config\Loader\LoaderInterface;
use DTL\Bundle\PhpcrMigrations\Tests\Resources\Bundle\OneTestBundle\OneTestBundle;
use DTL\Bundle\PhpcrMigrations\Tests\Resources\Bundle\TwoTestBundle\TwoTestBundle;
use DTL\Bundle\PhpcrMigrations\PhpcrMigrationsBundle;
use Doctrine\Bundle\PHPCRBundle\DoctrinePHPCRBundle;

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
        $loader->import(CMF_TEST_CONFIG_DIR.'/default.php');
        $loader->import(CMF_TEST_CONFIG_DIR.'/phpcr_odm.php');
        $loader->load(__DIR__.'/config/config.yml');
    }
}

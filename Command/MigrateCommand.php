<?php
/*
 * This file is part of the <package> package.
 *
 * (c) 2011-2015 Daniel Leech 
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DTL\Bundle\PhpcrMigrations\Command;

use Symfony\Component\Console\Command\Command;
use DTL\PhpcrMigrations\VersionStorage;
use DTL\PhpcrMigrations\VersionFinder;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use DTL\PhpcrMigrations\Migrator;
use PHPCR\SessionInterface;
use DTL\PhpcrMigrations\MigratorFactory;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MigrateCommand extends Command
{
    private $factory;
    private $container;

    public function __construct(
        MigratorFactory $factory,
        ContainerInterface $container
    )
    {
        parent::__construct();
        $this->factory = $factory;
        $this->container = $container;
    }

    public function configure()
    {
        $this->setName('phpcr:migrations:migrate');
        $this->addArgument('to', InputArgument::OPTIONAL, 'Migrate to this version');
        $this->setDescription('Migrate the content repository between versions');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $to = $input->getArgument('to');
        $migrator = $this->factory->getMigrator();

        foreach ($migrator->getVersions() as $version) {
            if ($version instanceof ContainerAwareInterface) {
                $version->setContainer($this->container);
            }
        }

        $migrator->migrate($to, $output);
    }
}

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

class InitializeCommand extends Command
{
    private $factory;

    public function __construct(
        MigratorFactory $factory
    )
    {
        parent::__construct();
        $this->factory = $factory;
    }

    public function configure()
    {
        $this->setName('phpcr:migrations:initialize');
        $this->setDescription('Initialize the migration versions');
        $this->setHelp(<<<EOT
This command will add all of the found versions to the version database without executing them.

This should only be performed on a content repository which has not yet had any migrations applied
to it and which is in the latest state.
EOT
        );
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->factory->getMigrator()->initialize();
    }
}

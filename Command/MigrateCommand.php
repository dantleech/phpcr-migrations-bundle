<?php

/*
 * This file is part of the PHPCR Migrations package
 *
 * (c) Daniel Leech <daniel@dantleech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DTL\Bundle\PhpcrMigrations\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MigrateCommand extends ContainerAwareCommand
{
    private $factory;
    private $actions = array(
        'up', 'down', 'top', 'bottom',
    );

    public function configure()
    {
        $this->setName('phpcr:migrations:migrate');
        $this->addArgument('to', InputArgument::OPTIONAL, sprintf(
            'Version name to migrate to, or an action: "<comment>%s</comment>"',
            implode('</comment>", "<comment>', $this->actions)
        ));
        $this->setDescription('Migrate the content repository between versions');
        $this->setHelp(<<<EOT
Migrate to a specific version or perform an action.

By default it will migrate to the latest version:

    $ %command.full_name%

You can migrate to a specific version (either in the "past" or "future"):

    $ %command.full_name% 201504011200

Or specify an action

    $ %command.full_name% <action>

Action can be one of:

- <comment>up</comment>: Migrate one version up
- <comment>down</comment>: Migrate one version down
- <comment>top</comment>: Migrate to the latest version
- <comment>bottom</comment>: Revert all migrations

EOT
        );
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->factory = $this->getContainer()->get('phpcr_migrations.migrator_factory');

        $to = $input->getArgument('to');
        $migrator = $this->factory->getMigrator();

        foreach ($migrator->getVersions() as $version) {
            if ($version instanceof ContainerAwareInterface) {
                $version->setContainer($this->getContainer());
            }
        }

        $migrator->migrate($to, $output);
    }
}

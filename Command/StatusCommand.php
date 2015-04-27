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

class StatusCommand extends Command
{
    private $versionStorage;
    private $finder;

    public function __construct(
        VersionStorage $versionStorage,
        VersionFinder $finder
    )
    {
        parent::__construct();
        $this->versionStorage = $versionStorage;
        $this->finder = $finder;
    }

    public function configure()
    {
        $this->setName('phpcr:migrations:status');
        $this->setDescription('Show the current migration status');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $versionCollection = $this->finder->getCollection();
        $executedVersions = (array) $this->versionStorage->getPersistedVersions();
        $currentVersion = $this->versionStorage->getCurrentVersion();

        $table = new Table($output);
        $table->setHeaders(array(
            '', 'Version', 'Date', 'Migrated', 'Path',
        ));

        foreach ($versionCollection->getAllVersions() as $versionName => $versionClass) {
            $reflection = new \ReflectionClass($versionClass);
            $table->addRow(array(
                $versionName == $currentVersion ? '*' : '',
                $versionName,
                $this->getDate($versionName),
                in_array($versionName, $executedVersions) ? '<info>YES</info>' : '<comment>NO</comment>',
                substr($reflection->getFileName(), strlen(getcwd()) + 1),
            ));
        }

        $table->render();

        if ($currentVersion) {
            $output->writeln(sprintf('<info>Current:</info> %s (%s)', $currentVersion, $this->getDate($currentVersion)));
        } else {
            $output->writeln('<info>No migrations have been executed</info>');
        }
    }

    private function getDate($versionName)
    {
        return date('Y-m-d H:i', strtotime(substr($versionName, 1)));
    }
}


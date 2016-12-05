<?php

/*
 * This file is part of the PHPCR Migrations package
 *
 * (c) Daniel Leech <daniel@dantleech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DTL\Bundle\PhpcrMigrations\Tests\Functional;

class MigrateCommandTest extends BaseTestCase
{
    /**
     * It should migrate all the unexecuted migrators.
     */
    public function testMigrateToLatest()
    {
        $this->executeCommand('phpcr_migrations.command.migrate', array());

        $versionNodes = $this->session->getNode('/jcr:migrations')->getNodes();
        $this->assertCount(5, $versionNodes);
    }

    /**
     * It should upgrade to a given version.
     */
    public function testUpgradeTo()
    {
        $tester = $this->executeCommand('phpcr_migrations.command.migrate', array('to' => '201401011300'));
        $display = $tester->getDisplay();

        $this->assertContains('Upgrading 1 version', $display);

        $versionNodes = $this->session->getNode('/jcr:migrations')->getNodes();
        $this->assertCount(1, $versionNodes);
    }

    /**
     * It should downgrade to a given version.
     */
    public function testUpgradeRevertTo()
    {
        $tester = $this->executeCommand('phpcr_migrations.command.migrate', array());
        $tester = $this->executeCommand('phpcr_migrations.command.migrate', array('to' => '201501011200'));
        $display = $tester->getDisplay();

        $this->assertContains('Reverting 3 version', $display);

        $versionNodes = $this->session->getNode('/jcr:migrations')->getNodes();
        $this->assertCount(2, $versionNodes);
    }
}

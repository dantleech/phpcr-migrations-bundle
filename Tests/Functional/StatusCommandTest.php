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

class StatusCommandTest extends BaseTestCase
{
    /**
     * It should list all of the migrations.
     */
    public function testShowAll()
    {
        $tester = $this->executeCommand('phpcr_migrations.command.status', array());
        $display = $tester->getDisplay();

        $this->assertContains('No migrations have been executed', $display);
    }

    /**
     * It should show the current version.
     */
    public function testShowCurrentVersion()
    {
        $tester = $this->executeCommand('phpcr_migrations.command.migrate', array('to' => '201501011500'));
        $tester = $this->executeCommand('phpcr_migrations.command.status', array());
        $display = $tester->getDisplay();

        $this->assertContains('201501011500', $display);
    }
}

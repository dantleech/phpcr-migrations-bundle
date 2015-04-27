<?php
/*
 * This file is part of the <package> package.
 *
 * (c) 2011-2015 Daniel Leech 
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DTL\Bundle\PhpcrMigrations\Tests\Functional;

use Symfony\Component\Console\Tester\CommandTester;
use DTL\Bundle\PhpcrMigrations\Tests\Functional\BaseTestCase;

class StatusCommandTest extends BaseTestCase
{
    /**
     * It should list all of the migrations
     */
    public function testShowAll()
    {
        $tester = $this->executeCommand('phpcr_migrations.command.status', array());
        $display = $tester->getDisplay();

        $this->assertContains('No migrations have been executed', $display);
    }

    /**
     * It should show the current version
     */
    public function testShowCurrentVersion()
    {
        $tester = $this->executeCommand('phpcr_migrations.command.migrate', array('to' => '201501011500'));
        $tester = $this->executeCommand('phpcr_migrations.command.status', array());
        $display = $tester->getDisplay();

        $this->assertContains('201501011500', $display);
    }
}

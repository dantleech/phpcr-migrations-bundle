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

use Symfony\Cmf\Component\Testing\Functional\BaseTestCase as CmfBaseTestCase;
use Symfony\Component\Console\Tester\CommandTester;

abstract class BaseTestCase extends CmfBaseTestCase
{
    public function setUp()
    {
        $this->db('PHPCR')->purgeRepository();
        $this->session = $this->getContainer()->get('doctrine_phpcr.default_session');

        if ($this->session->nodeExists('/jcr:migrations')) {
            $this->session->getNode('/jcr:migrations')->remove();
            $this->session->save();
        }
    }

    protected function executeCommand($serviceId, $arguments)
    {
        $command = $this->getContainer()->get($serviceId);
        $tester = new CommandTester($command);
        $tester->execute($arguments);

        return $tester;
    }
}

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
use Symfony\Cmf\Component\Testing\Functional\BaseTestCase as CmfBaseTestCase;

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


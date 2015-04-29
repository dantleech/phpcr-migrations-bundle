<?php

/*
 * This file is part of the PHPCR Migrations package
 *
 * (c) Daniel Leech <daniel@dantleech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use PHPCR\Migrations\VersionInterface;
use PHPCR\SessionInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Version201401011300 implements VersionInterface, ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function up(SessionInterface $session)
    {
        if (!$this->container) {
            throw new \Exception('This Version class implements ContainerAwareInterface but no container has been set.');
        }
        $session->getRootNode()->addNode('camel');
    }

    public function down(SessionInterface $session)
    {
        $session->getRootNode()->getNode('camel')->remove();
    }
}

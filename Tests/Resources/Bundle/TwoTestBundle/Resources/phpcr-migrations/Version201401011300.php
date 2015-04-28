<?php

use PHPCR\SessionInterface;
use DTL\PhpcrMigrations\VersionInterface;
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

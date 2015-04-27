<?php

use PHPCR\SessionInterface;
use DTL\PhpcrMigrations\VersionInterface;

class Version201501011500 implements VersionInterface
{
    public function up(SessionInterface $session)
    {
        $session->getNode('/camel')->addNode('dan');
    }

    public function down(SessionInterface $session)
    {
        $session->getNode('/camel')->getNode('dan')->remove();
    }
}

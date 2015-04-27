<?php

use PHPCR\SessionInterface;
use DTL\PhpcrMigrations\VersionInterface;

class Version201501011212 implements VersionInterface
{
    public function up(SessionInterface $session)
    {
        $session->getNode('/hello')->addNode('world');
    }

    public function down(SessionInterface $session)
    {
        $session->getNode('/hello')->getNode('world')->remove();
    }
}

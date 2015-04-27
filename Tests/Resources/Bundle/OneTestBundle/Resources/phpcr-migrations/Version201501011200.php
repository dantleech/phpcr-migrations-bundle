<?php

use PHPCR\SessionInterface;
use DTL\PhpcrMigrations\VersionInterface;

class Version201501011200 implements VersionInterface
{
    public function up(SessionInterface $session)
    {
        $session->getRootNode()->addNode('hello');
    }

    public function down(SessionInterface $session)
    {
        $session->getRootNode()->getNode('hello')->remove();
    }
}

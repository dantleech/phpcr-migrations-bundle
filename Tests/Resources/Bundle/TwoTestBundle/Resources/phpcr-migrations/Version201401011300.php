<?php

use PHPCR\SessionInterface;
use DTL\PhpcrMigrations\VersionInterface;

class Version201401011300 implements VersionInterface
{
    public function up(SessionInterface $session)
    {
        $session->getRootNode()->addNode('camel');
    }

    public function down(SessionInterface $session)
    {
        $session->getRootNode()->getNode('camel')->remove();
    }
}

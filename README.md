PHPCR Migrations Bundle
=======================

This library provides a Symfony integration for the [PHPCR migrations
library](https://github.com/dantleech/phpcr-migrations).

This version has been archived
==============================

This bundle has been renamed to [phpcr/phpcr-migrations-bundle](https://github.com/phpcr/phpcr-migrations-bundle).
We recommend to update your dependencies to get the latest version.

`dantleech/phpcr-migrations-bundle` will remain available to not break existing installations, but
is no longer maintained.

Configuration
-------------

Configure the path to your migrations:

````yaml
# app/config.yml
phpcr_migrations:
    paths: [%kernel.root_dir%/phpcr-migrations]
````

Or the bundle will automatically pick up any migrations in the
`Resources/phpcr-migrations` folder in any bundles registered in the kernel.

Creating migrations
-------------------

First create two new migration files:

````php
<?php
// app/phpcr-migrations/Version201501011200.php

use PHPCR\SessionInterface;
use PHPCR\Migrations\VersionInterface;

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
````

and

````php
<?php
// app/phpcr-migrations/Version201501011212.php

use PHPCR\SessionInterface;
use PHPCR\Migrations\VersionInterface;

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
````

Migration status
----------------

Note that migration MUST be named as follows: `VersionYYYMMDDHHSS`. If they
are not so-named, they will not be detected. The timestamp SHOULD be the
current date (in this example `2015/01/01 12:00`).

Now execute the `phpcr:migrations:status` command:

````bash
$ php app/console phpcr:migrations:status
+--+---------------+------------------+----------+----------------------------------------------+
|  | Version       | Date             | Migrated | Path                                         |
+--+---------------+------------------+----------+----------------------------------------------+
|  | 201501011200 | 2015-01-01 12:00 | NO       | app/phpcr-migrations/Version201501011200.php |
|  | 201501011212 | 2015-01-01 12:12 | NO       | app/phpcr-migrations/Version201501011212.php |
+--+---------------+------------------+----------+----------------------------------------------+
No migrations have been executed
````

Executing migrations
--------------------

Now we can run the migrations:

````bash
$ php app/console phpcr:migrations:migrate
Upgrading 2 version(s):
 + [1/2]: 201501011200
 + [2/2]: 201501011212
````

This should run the two migrations, your status should not look like this:

Reverting
---------

You can now revert back to the first version as follows:

````bash
$ php app/console phpcr:migrations:migrate 201501011200
Reverting 1 version(s):
 - [1/4]: V201501011212
````

Actions
-------

In addition to specifying versions you can specify actions:

````bash
$ php app/console phpcr:migrations:migrate up
Upgrading 1 version(s):
 - [1/4]: V201501011212
````

Actions are:

- `up`: Upgrade one version
- `down`: Revert one version
- `top`: Migrate to the latest version
- `bottom`: Revert all migrations

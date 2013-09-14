---
layout: master
title: Building from Source
---

For some people, stable public releases just aren't enough. If you are one of those
who would rather cling onto the bleeding edge of progress, you can also build your
own transport package from the source code hosted on GitHub, ensuring you get all the
latest features ~~and unresolved bugs~~!

### Requirements
------------------
* A local installation of MODX Revolution 2.2.4+
* PHP Command Line (`php-cli`) in your path

### Instructions
------------------

#### Clone the git repository
````bash
git clone https://github.com/alanpich/tvImagePlus.git
````

#### Move into the new directory
````bash
cd tvImagePlus
````

#### Create config.core.php from example
````bash
cp config.core.sample.php config.core.php
````

#### Edit config.core.php to point to local MODX installation
````php
<?php
/* ... ~ line 3 */
define('MODX_BASE_PATH', '/path/to/my/local/modx/');
````

#### Execute the build script
````bash
php ./_build/build.transport.php
````

You will now have a newly-generated transport package zip file in the tvImagePlus directory.
This package can then be copied to the `core/packages` folder of a MODX installation and
installed in the same way as any other packages.
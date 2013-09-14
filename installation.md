---
layout: master
title: Installation
---

### Regular installation

Install Image+ via the MODx Package Manager, or download it from <http://modx.com/extras/package/imageplustvinput>


### Building from source
A Transport Package installer for Image+ can be built using an existing MODx installation (no changes made to the installation) and this repository. To build the transport package:

1. Copy `config.core.sample.php` to `config.core.php`
2. Edit `config.core.php` and edit line 3 to point to your local MODx install:
   `define('MODX_BASE_PATH', '/path/to/my/local/modx/');`
3. Execute `_build/build.transport.php` in a command prompt
4. Transport Package will be created in the root directory of the repository
5. Copy transport packages to `/path/to/my/local/modx/core/packages`
6. In the MODx manager, go to System/Package Management and choose 'Search locally for packages'
7. tvImagePlus will appear in the list. Click 'Install'

````php
<?php
echo "Hello World"; die();

````
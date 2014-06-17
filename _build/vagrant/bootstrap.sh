#!/usr/bin/env bash

##
# Run the Vagrant MODX utility to set up a modx installation for us
#
cd /home/vagrant/modx-utils && git pull origin master && cd
php /home/vagrant/modx-utils/install.php

##
# Run our own, project-specific, provisioning
#
ln -s /vagrant/core/components/tvimageplus /var/www/modx/core/components/tvimageplus
ln -s /vagrant/assets/components/tvimageplus /var/www/modx/assets/components/tvimageplus
php /vagrant/_build/vagrant/bootstrap.php

chown -R vagrant:vagrant /var/www/modx

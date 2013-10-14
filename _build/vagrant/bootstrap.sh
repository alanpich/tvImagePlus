#!/usr/bin/env bash

sudo apt-get update;
sudo apt-get install curl php5-curl -y
sudo service apache2 restart

php /vagrant/_build/vagrant/bootstrap.php > /dev/null
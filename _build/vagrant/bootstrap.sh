#!/usr/bin/env bash

sudo apt-get update;
sudo apt-get install curl php5-curl -y
sudo service apache2 restart

php /home/vagrant/vagrant-bootstrap/bootstrap.php > /dev/null

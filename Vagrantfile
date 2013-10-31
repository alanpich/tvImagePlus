### Vagrant Development Environment for tvImagePlus
#===============================================================================
#
#   Brings up a testing server ready to use that will run at http://localhost:8881
#
#   phpMyAdmin can be accessed at http://localhost:8881/phpmyadmin
#       username: root
#       password: password
#
#   SSH into the box by running the command `vagrant ssh` from the project root
#
#   MODx manager login is at http://localhost:8080/manager
#       username: admin
#       password: password
#

#### Configure Vagrant ==========================================================
###=============================================================================
Vagrant.configure("2") do |config|

    config.vm.define :vagrant do |vbox_config|

        ## Box Definition ######################################################
        vbox_config.vm.box = "modx-2.3-precise64"
#        vbox_config.vm.box_url = "http://vagrant.alanpich.com/modx-2.2.7-precise32.box"
        config.vm.provision :shell, :path => "_build/vagrant/bootstrap.sh"

        ## Network Binding #####################################################
        config.vm.network :forwarded_port, host: 8080, guest: 80

        ## Shared Folders ######################################################
        vbox_config.vm.synced_folder "./core/components/tvimageplus", "/var/www/modx/core/components/tvimageplus"
        vbox_config.vm.synced_folder "./assets/components/tvimageplus", "/var/www/modx/assets/components/tvimageplus"

    end

end
### Vagrant Development Environment for MODX ImagePlus v3.0
#===============================================================================
#
#   Brings up a testing server ready to use that will run at http://localhost:8881
#
#   phpMyAdmin can be accessed at http://10.10.10.40/pma
#       username: root
#       password: password
#
#   SSH into the box by running the command `vagrant ssh` from the project root
#
#   MODx manager login is at http://10.10.10.40/manager
#       username: admin
#       password: password
#

#### Configure Vagrant ==========================================================
###=============================================================================
Vagrant.configure("2") do |config|

    config.vm.define :vagrant do |vbox_config|

        ## Box Definition ######################################################
        vbox_config.vm.box = "alanpich/ubuntu-modx"
        config.vm.provision :shell, :path => "_build/vagrant/bootstrap.sh"

        ## Network Binding #####################################################
        config.vm.network "private_network", ip: "10.10.10.40"

        ## Shared Folders ######################################################
#        vbox_config.vm.synced_folder "./core/components/tvimageplus", "/var/www/modx/core/components/tvimageplus"
#        vbox_config.vm.synced_folder "./assets/components/tvimageplus", "/var/www/modx/assets/modx/components/tvimageplus"

    end

end

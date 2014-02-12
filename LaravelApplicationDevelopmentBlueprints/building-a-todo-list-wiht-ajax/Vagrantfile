# -*- mode: ruby -*-
# vi: set ft=ruby :

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
    config.vm.box = "precise32"

    config.vm.box_url = "http://files.vagrantup.com/precise32.box"

    config.vm.network :forwarded_port, guest: 80, host: 8080

    config.vm.provision :shell, :path => "install.sh"

    # config.vm.synced_folder ".", "/vagrant", :mount_options => ["dmode=777", "fmode=666"]
  config.vm.synced_folder "./app/storage", "/vagrant/app/storage", :mount_options => ["dmode=777", "fmode=666"]
  config.vm.synced_folder "./public/uploaded-files", "/vagrant/public/uploaded-files", :mount_options => ["dmode=777", "fmode=666"]

    # If true, then any SSH connections made will enable agent forwarding.
    # Default value: false
    # config.ssh.forward_agent = true

    # Share an additional folder to the guest VM. The first argument is
    # the path on the host to the actual folder. The second argument is
    # the path on the guest to mount the folder. And the optional third
    # argument is a set of non-required options.
    # config.vm.synced_folder "../data", "/vagrant_data"
end


# http://forums.laravel.io/viewtopic.php?pid=10023#p10023
# egrep "^User|^Group|^SuexecUserGroup" /etc/apache2/apache2.conf /etc/apache2/sites-available/*.conf
# https://github.com/10up/varying-vagrant-vagrants/blob/master/Vagrantfile
# There's a constraint from VirtualBox on vagrant that does not allow you to set permissions for the synced folder from inside the guest OS
# http://stackoverflow.com/questions/18648547/laravel-4-permissions-on-a-vagrant-box-with-puppet

Blackfire Workshop VM
=====================

This little tool aims to build a ready-to-run VM for the Blackfire workshop.

Pre-requisite / Installation
----------------------------

Make sure you have installed
[Vagrant](https://www.vagrantup.com/docs/installation/) and
[Virtualbox](https://www.virtualbox.org/wiki/Downloads) on your computer.

Make sure you have the `vbguest` plugin installed by running

`vagrant plugin install vagrant-vbguest`

Building / Running the VM
-------------------------

Do a `make up` in this directory.

SSH
---

A `vagrant ssh` will let you SSH into the VM.

You will be logged as `vagrant`, but you need to log as the `blackfire` user.

login: `blackfire`
password: `blackfire`

A `sudo su - blackfire` will log you in the machine.

Customizing the VM
------------------

The provisionning script is `provisionning.sh`. This script is run once when
building the VM. This script is run as root.

Destroying the VM
-----------------

Do a `make destroy`.

Exporting the VM
----------------

You will need to do that from Virtualbox itself.

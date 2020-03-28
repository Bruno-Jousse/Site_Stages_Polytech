# Recherche stages effectués pour Polytech Clermont
Ce projet a été réalisé dans le cadre du projet de 3ème année d'école d'ingénieur à l'ISIMA. Il s'agit d'un site web réalisé pour Polytech-Clermont. Il a été réalisé en utilisant le framework Symfony et avec les langages PHP, HTML, CSS et JavaScript. Ce site a pour but de permettre : 
- Aux étudiants de Polytech-Clermont de voir les stages effectués les années précédentes qui correspondent à leur formation,
- Les responsables de stage peuvent ajouter des stages à partir de fichier CSV ou XLS exportés depuis Konosys,
- Les administrateurs peuvent ajouter, modifier, supprimer facilement les données de stage,
- Les observateurs ont accès à tous les stages pour effectuer des statistiques.

## Installation

Prérequis: 
- PHP 7
- Git
- Xampp/Lampp
- Composer

Une fois les prérequis installés, il faut lancer le serveur Apache et la base de données MySQL de Xampp (ou Lampp).
Puis dans un terminal comprenant les commandes git (ex: Git Bash):
````shell script
git clone https://github.com/Bruno-Jousse/Site_Stages_Polytech.git
cd Sites_Stages_Polytech

# Il faut modifier la variable DATABASE_URL dans .env pour quelle corresponde aux identifiants de votre BD
vi .env
# Attention à ne pas push ce fichier si vous n'utilisez pas une BD locale de test (ajouter le fichier dans .gitignore)
vi .gitignore

php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
php -S 127.0.0.1:8000 -t public &

# Le site est maintenant accessible à l'adresse: localhost:8000
````

Exemple d'installation complète à partir d'une machine virtuelle Linux Ubuntu:

Prérequis:
- VMWare Workstation Player (https://my.vmware.com/fr/web/vmware/free#desktop_end_user_computing/vmware_workstation_player/15_0)
- Une image Linux comme Ubuntu (par exemple: https://www.osboxes.org/ubuntu/#ubuntu-19-10-vmware, avec comme username:osboxes et password:osboxes.org)

Démarches:
- Lancer VMWare Workstation et créer une nouvelle VM
- Dans "Network Adapter", sélectionner "NAT"
- Ajouter l'image Linux soit à partir d'une image .iso en allant dans CD/DVD (SATA)
- Soit à partir d'une image Linux .vmdk en supprimant le Hard Disk existant puis en créant un nouveau Hard Disk avec pour Disk File le .vmdk
- Lancer la VM
- Ouvrir un terminal et lancer les commandes suivantes (si elles ne fonctionnent pas il faut attendre la fin des mise à jour journalières):

````shell script
sudo apt install net-tools

sudo wget https://downloadsapachefriends.global.ssl.fastly.net/7.3.0/xampp-linux-x64-7.3.0-0-installer.run?from_af=true

mv xampp-linux-x64-7.3.0-0-installer.run?from_af=true xampp-linux-x64-7.3.0-0-installer.run

sudo chmod +x xampp-linux-x64-7.3.0-0-installer.run

sudo /opt/lampp/lampp start

sudo apt install git

git clone https://github.com/Bruno-Jousse/Site_Stages_Polytech.git

cd Site_Stages_Polytech

sudo apt install php7.3-cli
sudo apt-get install php-xml
sudo apt-get install php-gd
sudo apt-get install php-mbstring
sudo apt-get install php-intl
sudo apt-get install php-mysql

sudo apt install composer

wget https://get.symfony.com/cli/installer -O - | bash

composer install

# Il faut modifier la variable DATABASE_URL dans .env pour quelle corresponde aux identifiants de votre BD
vi .env
# Attention à ne pas push ce fichier si vous n'utilisez pas une BD locale de test (ajouter le fichier dans .gitignore)
vi .gitignore

./opt/lampp/bin/mysqladmin --user=myRootUsername password "myRootPassword"

php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force

php -S 127.0.0.1:8000 -t public &

# Le site est maintenant accessible à l'adresse: localhost:8000
````

## Documentation

La documentation se situe dans le répertoire docs
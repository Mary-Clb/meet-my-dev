# MEET MY DEV

Symfony project for CSI training - Meeting web application between companies & developers

# Prérequis
- Composer
- Symfony CLI

# Comment installer

Installer (décommenter) ces extentions dans votre php.ini
-  `pdo_mysql`
-  `intl`

Renseignez les bonnes informations de connection à la base de données dans le fichier `.env`

# Commandes a lancer | Dans votre invite de commande, se mettre dans le dossier du projet

- `composer install`
- `php bin/console doctrine:database:create`
- `php bin/console doctrine:fixtures:load`

# Lancez le serveur 

- `symfony serve`

# Utilisation

- L'utilisateur admin de base peut se connecter avec les indentifiants et mots de passe très sécurisés : `admin` et `admin`
- Il peut depuis cette interface gérer les utilisateurs ainsi que les différentes entités.
- Il y'a déja des faux utilisateurs enregistrés ainsi que quelques spécialités et activités.


----------------------------------------------------------------------


# Prerequisites
-Composer
-Symfony CLI

#How to Install

Install (uncomment) the following extensions in your php.ini file:

- `pdo_mysql`
- `intl`

Provide the correct database connection information in the .env file.

# Commands to Run | In your command prompt, navigate to the project directory
- `composer install`
- `php bin/console doctrine:database:create`
- `php bin/console doctrine:fixtures:load`

# Start the Server
- `symfony serve`
 
# Usage

- The default admin user can log in using the highly secure credentials: `admin` and `admin`.
- From this interface, the admin can manage users and various entities.
- There are already some fake registered users, as well as a few specialties and activities.

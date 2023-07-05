# MEET MY DEV

Symfony project for CSI training - Meeting web application between companies & developers

# Prérequis
- Composer
- Symfony CLI

# Comment installer

Installer (décommenter) ces extentions dans votre php.ini
-  `pdo_mysql`
-  `intl`

Renseignez les bonnes informations de connection à la base de données `MySQL` dans le fichier `.env`

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

- Un utilisateur peut créer son compte depuis la page login sur laquelle il arrive en ouvrant le site.
- Une fois connecté, il peut faire des recherches sur les profils existants en cherchant une chaine de caractères dans plusieurs 
    champs comme la présentation ou les spécialités/activités des personnes.
- Les utilisateurs peuvent modifier leur profil depuis leur page `profil` accessible depuis le menu déroulant en haut a droite.


----------------------------------------------------------------------


# Prerequisites
- Composer
- Symfony CLI

#How to Install

Install (uncomment) the following extensions in your php.ini file:

- `pdo_mysql`
- `intl`

Provide the correct  `MySQL` database connection information in the `.env` file.

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
- A user can create their account from the login page, which they arrive at upon opening the website.
- Once logged in, they can search for existing profiles by searching for a string of characters in various fields such as the bio or the specialties/activities of the individuals.
- Users can edit their profile from their `profile` page, accessible from the dropdown menu in the top right corner.
# Healtheat

Healteat est un diététicien en ligne, permettant au utilisateur de générer des programmes alimentaires en fonction de leurs informations personnelles.

Le site permet, après avoir rentré ses informations personnelles, de pouvoir suivre différents programmes alimentaires générés automatiquements, et d'avoir l'évolutions de ses différentes informations tel que le poids.

Réalisé dans le cadre de l'UE [LifProjet](http://perso.univ-lyon1.fr/fabien.rico/site/projet:2019:pri:start)

## Installation

Si composer n'est pas installé :

```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```
Voir la page de [Composer](https://getcomposer.org/download/)

Si yarn n'est pas installé :

```bash
sudo apt-get install yarn
```

Pour installer le docker contenant notre site web, après avoir git clone : 

```bash
cd apps/my-symfony-app
composer install
composer require encore
sudo yarn install
```

Pour lancer le site :

```bash
cd ../..
docker-compose up
```

Le site est hebergé sur [localhost](https://localhost:8081)

## Organisation du code

### Modèle

Tout le code du modèle ce trouve dans le dossier /src

* On y trouve plusieurs sous dossiers :
    * /Entity pour les entitées utilisées notamment pour faire le lien avec la base de donnée
    * /Repository pour les dépot permettant de récupéré dans la base de donnée les informations des entités correspondantes
    * /Migrations pour les migrations qui s'effectue lors de la commande ```php bin/console doctrine:migrations:migrate ```
    * /Form pour les formulaires, dans notre cas le formulaire d'inscription et celui lié au informations personnelles
    * /Data pour les données provenant du scraping en format csv
    * /Command pour les commandes ajoutées, dans notre cas la commande ```php bin/console csv:import``` qui permet d'importer les fichiers csv dans la base de données

### Controller

* Les controllers se trouvent dans le fichier /src/controller.

On y trouve deux controllers differents :
    * HealtheatController, qui contient toutes les fonctions qui permettent de faire fonctionner le site.
    * SecurityController, qui s'occupe de la partie sécurité de notre site, dans notre cas qui contient la partie connexion / - inscription

### Vue

* Les pages html.twig sont toutes stockées dans le dossier /templates, qui contient plusieurs chose : 
    * Le fichier twig base.html.twig, qui est la base de la vue de notre site
    * Un sous dossier /healtheat qui contient tout les templates du site, affichés en fonction de la vue
    * Un sous dossier /security qui contient les templates de la partie sécurité de notre site
# Healtheat

Healteat est un diététicien en ligne, permettant au utilisateur de générer des programmes alimentaires en fonction de leurs informations personnelles.

## Installation

Pour installer le docker contenant notre site web :

```bash
docker composer up
```

Ensuite, il

## Organisation du code

### Modèle

Tout le code du modèle ce trouve dans le dossier /src

* On y trouve plusieurs sous dossiers :
    * /Entity pour les entitées utilisées notamment pour faire le lien avec la base de donnée
    * /Repository pour les dépot permettant de récupéré dans la base de donnée les informations des entités correspondantes
    * /Migrations pour les migrations qui s'effectue lors de la commande ```php bin/console doctrine:migrations:migrate ```
    * /Form pour les formulaires, dans notre cas le formulaire d'inscription et celui lié au informations personnelles
    * /Data pour les données provenant du scraping en format csv
    * /Command pour les commandes ajoutées, dans notre cas la commande ```php bin/console csv:import``` qui permet d'importer les fichiers csv

### Controller

Les controller se trouvent dans le fichier /src/controller.

* On y trouve deux controller differents :
    * HealtheatController, qui contient toutes les fonctions qui permettent de faire fonctionner le site.
    * SecurityController, qui s'occupe de la partie sécurité de notre site, dans notre cas qui contient la partie connexion / - inscription

### Vue

* Les pages html.twig sont toutes stockées dans le dossier /templates, qui contient plusieurs chose : 
    * Le fichier twig base.html.twig, qui est la base de la vue de notre site
    * Un sous dossier /healtheat qui contient tout les templates du site, affichés en fonction de la vue
    * Un sous dossier /security qui contient les templates de la partie sécurité de notre site

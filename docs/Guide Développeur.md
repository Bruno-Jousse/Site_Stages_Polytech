# Guide Développeur

## Technologies et langages

Nous avons utilisé le framework Symfony. Les langages sont PHP, HTML, CSS et JavaSCript.
Le serveur est un serveur Apache et la base de données de la MySQL. Pour le mettre en place nous avons utilisé Xampp.

## Arborescence de l'application

L'arborescence de l'application est celle classique pour un projet Symfony.
Les dossiers principaux sont les suivants:
- config: Contient les configurations de Symfony et des bundles,
- docs: Dossier que nous avons créé qui contient la documentation (guide, diagrammes, vues),
- public: Contient les ressources utilisées pour le front-end (fichiers JavaScript, CSS et les images),
- src: Contient les fichiers .php décrivants tout le back-end de l'application
    - Controller: Fichiers décrivant la route de l'application et recevant les requêtes. Ils appellent le Modèle et la Vue adéquate et effectue des opérations de contrôle,
    - Entity: Fichiers décrivant les objets modélisant ceux de la base de données et que l'on manipule directement en PHP,
    - Form: Fichiers décrivant les formulaires,
    - Migrations: Fichiers permettant de générer la base de données et de la mettre à jour (Ensemble des opérations SQL générant la base de données),
    - Repository:  Fichiers permettant d'effectuer des opérations SQL sur la base de données en PHP
- templates: Contient les fichiers Twig permettant l'affichage des pages webs (front-end),
- .env: Contient les variables d'environnement partageables,
- .env.local: A créer en local, 

## Installation

Voir le fichier README.md à la racine du projet.
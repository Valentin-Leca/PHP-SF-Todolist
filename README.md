# Symfony Insight Analyse

[Disponible ici](https://insight.symfony.com/projects/6c144d03-fdd2-49f5-bab9-7ac3211e3701/analyses/25?status=commit)


## PHP-SF-TO DO & CO

- Montées de versions
- Implémentation de nouvelles fonctionnalités
- Correction de quelques anomalies
- Implémentation de tests automatisés.


## Outils Requis :

PHP version >= 8.1

Composer version >= 2.3.5

Symfony CLI version >= 5.4.8

WampServer

MySQL version >= 8.0.29

PHPMyAdmin >= 5.2.0

## Installation :

Ouvrez une interface de commande et cloner le repository dans un dossier `git clone
https://github.com/Valentin-Leca/PHP-SF-Todolist.git`

Se placer à la racine du projet et faire un `composer install` pour installer tous
les bundles associés au projet présent dans le fichier composer.lock

Faites une copie de votre fichier .env que vous renommez en `.env.local` et modifiez
la partie `DATABASE_URL` avec vos informations de base de données (nom utilisateur,
mdp, nom de la bdd ...).

Faire la commande `php bin/console doctrine:schema:create` pour créer la base de
donnée.

Lancer la commande `symfony console doctrine:fixtures:load` pour créer les données de
test (Customers, Users, Phones).

Une fois ces étapes réalisées, lancer WampServer puis faites `symfony serve -d` en
ligne de commande à la racine du projet.

(Page d'accueil : `https://127.0.0.1:8000`)

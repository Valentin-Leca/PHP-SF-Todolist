# Guide de Contribution

## Commencement : 

Bienvenue dans le projet ! Pour commencer, vous devrez installer les dépendances du projet et configurer
votre environnement local.

Les instructions d'installation et de configuration se trouvent dans le fichier README.md à la racine du projet.
Veuillez suivre attentivement ces instructions<br/> pour vous assurer que le projet est correctement configuré
et que toutes les dépendances sont installées.

Une fois que vous avez terminé le processus d'installation et de configuration, vous devriez être prêt à commencer
à contribuer au projet. 

## Nom des branches : 

- Catégorie

Une branche git doit commencer par une catégorie. Choisissez-en un : feature, bugfix, hotfix, ou test.

- Référence

Après la catégorie, il devrait y avoir un "/" suivi de la référence de l'issue/ticket sur lequel vous travaillez.
S'il n'y a pas de référence, ajoutez simplement "no-ref".

- Description

Après la référence, il devrait y avoir un autre "/" suivi d'une description qui résume le but de cette branche
spécifique. Cette description doit être courte.
<br/>Par défaut, vous pouvez utiliser le titre du problème/ticket sur lequel vous travaillez. Remplacez simplement
n'importe quel caractère spécial par "-".

Pour résumer, suivez ce modèle lors de la création de branches :
````
git branch <catégorie/référence/description>
````

## Nom des Commits :

- Catégorie

Un message de validation doit commencer par une catégorie de changement. Vous pouvez à peu près utiliser les
4 catégories suivantes pour tout : feat, fix, refactor, and chore.<br/>

feat est pour ajouter une nouvelle fonctionnalité<br/>
fix est pour corriger un bug<br/>
refactor sert à modifier le code à des fins de performance ou de commodité (par exemple, la lisibilité)<br/>
chore est pour tout le reste (rédaction de documentation, formatage, ajout de tests, nettoyage de code inutile etc...)<br/>
Après la catégorie, il devrait y avoir un ":" annonçant la description du commit.

- Déclaration(s)

Après les deux-points, la description du commit doit consister en de courtes déclarations décrivant les modifications.<br/>
Les instructions doivent être séparées d'elles-mêmes par un ";".<br/>

Pour résumer, suivez ce modèle lors de vos commits :
````
git commit -m '<catégorie : faire quelque chose ; faire d'autres choses>'
````

## Tests avec PHPUnit

Pour lancer les tests unitaires et fonctionnels, utilisez cette commande.<br/>

````
vendor/bin/phpunit --coverage-html public/test-coverage
````

Cela va générer des html analysant le taux de couverture de code avec tous les détails permettant d'améliorer les tests.


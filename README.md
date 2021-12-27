# Memory

Le projet consistait à réaliser le jeu Memory en HTML/PHP/JS. Memory est un jeu de mémoire dont l'objectif est de trouver toutes les paires le plus rapidement possible. Ce projet dans son ensemble consistait à réaliser ce jeu de manière à pouvoir l'utiliser comme support pédagogique. C'est donc un projet technique et pédagogique.

# Table des matières
1. Contenu du projet
   -
2. [Example2](#example2)
3. [Third Example](#third-example)


## Contenu du projet
Ce projet contient : 
 - les **dossiers** du projet **technique**
 - le **diagramme de classe** du projet (à la racine)
 - ce fichier **README.md**
   ## Readme
    Ce fichier README.md est une documentation qui aborde les 2 aspects du projet :
    -  la partie **technique**
    -  la partie **gestion**
 
 ## Aspect Technique
 Cette partie expose : 
  1. l'**architecture** du projet et le son fonctionnement général
  2. le fonctionnement général du **code** et choix technique. En effet, quelque soit le projet, il arrive que plusieurs solutions techniques permettent la réalisation d'une même fonctionnalité. Nous détailleront les différents choix possibles ainsi que la solution adoptée.
  
###L'architecture
Cette application web est développée en adoptant l'architecture MVC (model view controller). Cette architecture facilite l'organisation des fichiers leurs roles. Elle est lié à la Programmation Orienté Objet. Elle contient 4 éléments et les échangent entre eux sont définis : 
- ####Le routeur
  - Il appelle la fonction associé à l'url. Cette fonction se trouve dans un controller.
- le dossier Controller
  - Un controller est une classe contenant différentes fonctions. Ces fonctions peuvent avoir différentes utilisations. Soit elles appellent des fonctions du Model afin d'échanger avec la base de donnée. Soit elles affichent une template de View contenant le code HTML. Soit les deux à la fois en récupérant des données en base (à l'aide du Model) et en le insérant dans la template (View)
- ####Le dossier Model
  - Contient généralement deux objets associées, l'entité et son manager. Une entité qui contient des attributs. Un Objet correspond à une table dans la base de donnée. Le deuxième objet est le manager qui possèdent les fonctions qui permettent les échanges aevc la base de données spécifique à cette objet. En effet, plusieurs entités dans un même projet n'ont pas toutes les mêmes fonctions.
- ####Le dossier View
  - C'est un dossier dans lequel se trouve les templates de l'application dont le code HTML est affiché par le navigateur. 
- ####Exemple du fonctionnement de l'architecture dans ce projet pour l'url index.php : 


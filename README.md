# Memory

Le projet consistait à réaliser le jeu Memory en HTML/PHP/JS. Memory est un jeu de mémoire dont l'objectif est de trouver toutes les paires le plus rapidement possible. Ce projet dans son ensemble était à réaliser ce jeu de manière à pouvoir l'utiliser comme support pédagogique. C'est donc un projet technique et pédagogique.

# Table des matières
1. [Contenu du projet](##Contenu du projet)
   -
2. [Example2](#example2)
3. [Third Example](#third-example)


## Contenu du projet
Vous trouverez dans le projet : 
 - les **dossiers technique** dans lequel il y a le code source.
 - le **diagramme de class** (à la racine du projet)
 - ce fichier **README.md**
 
   ## Readme
    Ce fichier README.md est une documentation qui aborde les 2 aspects du projet :
    -  la partie **technique**
    -  la partie **gestion**
 
 ## Aspect Technique
 Cette partie expose : 
  1. l'**architecture** du site et son fonctionnement général
  2. le fonctionnement général du **code** et les choix techniques. En effet, dans la programmation, il arrive que plusieurs solutions techniques permettent la réalisation d'une seule et même fonctionnalité. Nous détailleront les différents choix possibles ainsi que la solution adoptée.
  
###L'architecture
Cette application web est développée en adoptant l'architecture MVC (Model View Controller). Cette architecture facilite l'organisation des fichiers ainsi que leurs rôles. Elle est liée à la POO (Programmation Orienté Objet). Elle contient 4 éléments et les échangent entre eux sont prédéfinis : 
- ####Le routeur
  - Le routeur appelle la fonction associé à l'url en récupérant le paramètre action. pour se faire, il recherche dans tous les Controllers une fonction possédant ce nom.
- ####Le dossier Controller
  - Un controller est une class contenant différentes fonctions. Ces fonctions peuvent avoir différentes utilisations. Il se peut elles appellent des fonctions du Model afin d'échanger avec la base de donnée (un ajout, une récupération, une modification ou une suppression). Elle peut aussi afficher une template provenant du dossier View contenant le code HTML. Dans le pluspart des cas, les deux à la fois, en récupérant des données en base (à l'aide du Model) et en les insérant dans la template (View)
- ####Le dossier Model
  - Le dossier Model contient généralement des paires d'objets associées: l'entité et son manager. Une entité possède les attributs de la class et les fonctions permettant la récupération ou l'ajout d'une donnée d'un attribut. Une Entité correspond à une table dans la base de donnée. Le deuxième Objet est le Manager qui possèdent les fonctions qui rendent possible les échanges avec la base de données spécifique à cette objet. En effet, plusieurs entités dans un même projet n'ont pas toutes les mêmes fonctions.
- ####Le dossier View
  - C'est le dossier dans lequel se trouve les templates de l'application dont le code HTML est affiché par le navigateur. 
- ####Exemple du fonctionnement de l'architecture dans ce projet pour l'url "index.php" :
  Cet url ne possède pas de paramètre "action". Le routeur vas donc appelé la fonction index() de la class HomeController :
<pre>
  if (<i><b>!empty($_GET['action'])</b></i>) {
      $action = $_GET['action'];
      if (method_exists($controllerFirst, $action)) {
          $controllerFirst->$action();
      } elseif (method_exists($controllerSecond, $action)) {
          $controllerSecond->$action();
      }
  } else {
      <i><b>$controllerFirst->index();</b></i>
  }
</pre>


  La fonction index() appelle la fonction "GetAll" de la class GameManager pour récupérer les temps des parties enregistrés en base. Le controller traite ces données dans le but de renvoyer un tableau avec les 5 meilleurs temps et le nom du joueur associé :
  <pre>
   $managerGame = new <i><b>GameManager()</b></i>;
   $managerUser = new UserManager();
          
  $allScores = <i><b>$managerGame->getAll()</b></i>; // Récupération de l'attribut gameTime des parties jouées
      if ($allScores) {
          sort($allScores); // Trie du tableau

          $bestScore = [];
          for ($i = 0; $i < 5; $i++) {  // On souhaite uniquement les 5 meilleurs scores
              if($i > count($allScores) - 1) continue; // Si le nombre total de partie est inférieur à 5
              $game = $managerGame->getByTime($allScores[$i]["gameTime"]); // Récupérer la partiedans la bdd à partir du temps
              $user = $managerUser->getByGame($game->id()); // Récupérer le joueur à partir de l'objet partie

              // Modification du format de l'affichage pour le temps
              $aTime = explode(".", $game->gameTime() / 60);
              $sec = $game->gameTime() % 60;
              $time = "0" . $aTime[0] . '"' . ($sec < 10 ? "0".$sec : $sec );

              // Tableau contenant les données (joueur, temps) des 5 meilleurs jeux
              <i><b>$bestScore[]</b></i> = [
                  "pseudo" => $user->name(),
                  "time" => $time,
              ];
          }
      }
  </pre>
  
  Par la suite, La fonction index() "require" le template associé à la base d'acceuil qui se trouve dans le dossier View. Le template affiche les meilleurs scores en utilisant le tableau créer dans la fonction du controller : 
  -Appel du template
  <pre>
   require('view/indexView.php');
  </pre>

  -Dans le template, on boucle sur le tableau $bestScore créer dans le controller: 
```
     <?php if ($bestScore) : ?>
      <i><b><?php foreach ($bestScore as $key => $score) : ?></b></i> <!-- Boucle sur les 5 meilleurs scores -->
          <div class="score <?php if ($key == 0) : ?> frstRank <?php elseif ($key == 1) : ?> scdRank <?php elseif ($key == 2) : ?> trdRank <?php endif; ?>"> <!-- Changement de la classe selon la position dans le classement-->
              <div class="dataRank pseudoRank"><?= htmlspecialchars($score["pseudo"]); ?></div>
              <div class="dataRank timeRank"><?= $score["time"]; ?></div>
          </div>
      <?php endforeach; ?>
    <?php else : ?>
      <div class="notRank">Soyez le premier à jouer</div>
    <?php endif; ?>
```

###Fonctionnement de l'application
Il était certe possible de réaliser ce projet sur une seul page. Néanmoins, le fonctionnement du routeur est plus compréhensible et explicable dans le cas où le site possède plusieur page. De plus, la quasi-totalité des applications web avec une base de donnée ont plus d'une page.
   
 - ####Page d'accueil
   On a vu dans [Exemple du fonctionnement de l'architecture](#Exemple du fonctionnement de l'architecture dans ce projet pour l'url "index.php") comment fonctionne techniquement l'application sur l'url index.php. En plus d'afficher les meilleurs scores, il y a un formulaire que l'utilisateur rempli avant de commencer à jouer. 
 
 - #### Page du jeu
   Après avoir validé le formulaire, l'utilisateur est automatiquement dirigé vers la page du jeu. Elle affiche le nom du joueur, le plateau de jeu, le chronomètre qui se lance automatiquement au début de la partie et la barre de progression qui se rempli en fonction du temps.
   
   Plusieurs choix étaient possibles pour l'affichage des cartes :
  - Soit deux div dans la boucle for, une étant la carte grise et l'autre celle de l'image. A l'aide du CSS, on cache une des deux div. Lors du clique sur l'image on inverse les classes CSS à l'aide d'un code en JS. La div affiliée au fruit apparaît alors que la div associée à la carte grise disparaît. 
  - Soit une div affichant la carte grise. Lors du clique et en utilisant le JSON contenant tous les fruits, on change l'attribut src de la div par le nom du fruit. 
  
  Le premier est certe plus simple, en revanche les JSON sont très souvent utilisé dans le développement web, que le développeur soit FullStack ou BackEnd ou FrontEnd, il est important de savoir maitriser ce type d'objet. C'est donc dans un but pédagogique et non technique que cette solution fût adoptée.
  
  Lors du click la fonction onClickManage est appelé, si c'est le premier click, un objet "firstClickImg" est créée contenant le nom de l'image et son numéro. Lors du deuxième click, l'image est comparée avec l'image de "firstClickImg". Si le nom est différent et le numéro est identique (l'utilisateur a cliqué deux fois sur la même carte), les cartes sont retournées sinon elles restent afficher et on bloque le click sur ces div en enlevant la class imageClick. 
  Un compteur de click est comparé à chaque click avec le nombre de fruit totaux. S'ils sont égaux, la partie est terminée. 
  Une barre de progression prendre en considération la contrainte temps du jeu. La partie est perdu si la barre est rempli. 
  
  lorsque l'utilisateur gagne, la fonction addGame() de l'objet GameController est appelée. Elle crée une nouvelle Game en base et un nouvel User relié au Game. Par la suite, cette fonction redirige l'utulisateur à la page d'accueil en modifiant l'url HTTP.
  
 ## Aspect Gestion du projet
 La partie Gestion est tout aussi importante que la partie technique d'un projet. Elle permet de rendre la réalisation du projet la plus fluide possible en évitant de modifier des fonctionnalités existantes ou de travailler sur des éléments qui ne seront pas utilisés finalement. GitHub propose, en plus de pouvoir sauvegarder son projet, de préparer et gérer son projet. 
 Cette partie expose : 
 
 - Le diagramme de classe
 - La création des Issues
 - La création du Project
 - La création des Branches et des Pull Requests
  
   ### Le diagramme de classe
   Ce diagramme est un schéma utilisé pour présenter les différentes entités du projet ainsi que les relations entre elles.
   Deux Entités se trouvent dans ce projet : Game et User. 
   Une Troisième entité appelé Cartes était réalisable. L'inconvéniant était la modification de ses éléments. Dans l'état du projet, une boucle est effectué afin de créer un tableau avec les noms des images, cette boucle est donc effectué pour chaque nouvelle partie. En revanche si l'on modifie les cartes ou on en ajoute, l'application s'adaptera à ce changement. Alors que si le tableau se trouve en base, il faudra en plus de modifier les cartes au niveau du projet, modifier le tableau en base.
   ### Les Issues
   Ci dessous le lien des issues de ce projet : 
      https://github.com/Doudou-A/Memory/issues?q=is%3Aissue+is%3Aclosed
   Chaque issues correspond à une étape du projet. Il est conseillé de toute les répertorier avant de commencer à coder. Vous pourrez trouver.
   
   ### Le projet
   Ci-dessous le project Github du projet : 
   https://github.com/Doudou-A/Memory/projects/1
   Ce tableau permet de rattaché les tâches aux développeurs ainsi que de visualiser rapidement l'avancé du projet. Il se divise habituellement en 3 colonnes : 
   - ToDo : les tâches a effectué
   - InProgress : les tâches sont assignées et commencées
   -Done : lorsque la tâche est terminée
   
   ### Les Branches et les Pull Requests
   Ci-dessous les différentes branches du projet qui ont été cloturer lors du Pull Request :
   https://github.com/Doudou-A/Memory/pulls?q=is%3Apr+is%3Aclosed
   Le système de branche à pour avantage de travailler à plusieurs sur le même projet en même sans créer de gêne entre les développeurs. Chaque développeur possède a une branche dans laquelle il peut se concentre sur la réalisation de la tâche ou d'un débug sans qu'un autre développeur intervient sur les mêmes fichiers et créer des conflit lors du Pull Request.
   Le PullRequest est effectué lorsque le développeur a terminer sa tâche. Les fichiers modifiés écrasent les fichiers antérieurs de la branche Principale. Il est possible de fermer une issue en commentant le pull request par son ID. Le chef de projet pourra donc immédiatement savoir quel était l'ojectif de cette tâche.
   
   
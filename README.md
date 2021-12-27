# Memory

Le projet consistait à réaliser le jeu Memory en HTML/PHP/JS. Memory est un jeu de mémoire dont l'objectif est de trouver toutes les paires le plus rapidement possible. Ce projet dans son ensemble était à réaliser ce jeu de manière à pouvoir l'utiliser comme support pédagogique. C'est donc un projet technique et pédagogique.

# Table des matières
- [Contenu du projet Git](#contenu)
   - [Readme](#readme)
1. [Aspect Technique](#technique)
    - [Architecture](#achitecture)
      - [Routeur](#routeur)
      - [Controller](#controller)
      - [Model](#model)
      - [View](#view)
      - [Exemple](#exemple)
    - [Fonctionnement](#fonctionnement)
      - [Page d'accueil](#accueil)
      - [Page du jeu](#jeu)
2. [Aspect Gestion](#gestion)
   - [Diagramme de classe](#diagramme)
   - [Issues](#issues)
   - [Project](#project)
   - [Branche/PullRequest](#branche)

## Contenu du projet <a name="contenu"></a>
Vous trouverez dans le projet : 
 - les **dossiers technique** dans lequel il y a le code source.
 - le **diagramme de class** (à la racine du projet)
 - ce fichier **README.md**
 
   ## Readme <a name="readme"></a>
    Ce fichier README.md est une documentation qui aborde les 2 aspects du projet :
    -  la partie **technique**
    -  la partie **gestion**
 
 ## Aspect Technique <a name="technique"></a>
 Cette partie expose : 
  1. l'**architecture** du site et son fonctionnement général
  2. le fonctionnement général du **code** et les choix techniques. En effet, dans la programmation, il arrive que plusieurs solutions techniques permettent la réalisation d'une seule et même fonctionnalité. Nous détailleront les différents choix possibles ainsi que la solution adoptée.
  
### L'architecture <a name="architecture"></a>
Cette application web est développée en adoptant l'architecture MVC (Model View Controller). Cette architecture facilite l'organisation des fichiers ainsi que leurs rôles. Elle est liée à la POO (Programmation Orienté Objet). Elle contient 4 éléments et les échangent entre eux sont prédéfinis : 
- #### Le routeur <a name="routeur"></a>
  - Le routeur appelle la fonction associé à l'url en récupérant le paramètre action. pour se faire, il recherche dans tous les Controllers une fonction possédant ce nom.
- #### Le dossier Controller <a name="controller"></a>
  - Un controller est une class contenant différentes fonctions. Ces fonctions peuvent avoir différentes utilisations. Il se peut elles appellent des fonctions du Model afin d'échanger avec la base de donnée (un ajout, une récupération, une modification ou une suppression). Elle peut aussi afficher une template provenant du dossier View contenant le code HTML. Dans le pluspart des cas, les deux à la fois, en récupérant des données en base (à l'aide du Model) et en les insérant dans la template (View)
- #### Le dossier Model <a name="model"></a>
  - Le dossier Model contient généralement des paires d'objets associées: l'entité et son manager. Une entité possède les attributs de la class et les fonctions permettant la récupération ou l'ajout d'une donnée d'un attribut. Une Entité correspond à une table dans la base de donnée. Le deuxième Objet est le Manager qui possèdent les fonctions qui rendent possible les échanges avec la base de données spécifique à cette objet. En effet, plusieurs entités dans un même projet n'ont pas toutes les mêmes fonctions.
- #### Le dossier View <a name="view"></a>
  - C'est le dossier dans lequel se trouve les templates de l'application dont le code HTML est affiché par le navigateur. 
- #### Exemple du fonctionnement de l'architecture dans ce projet pour l'url "index.php" : <a name="Exemple"></a>
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

### Fonctionnement de l'application <a name="fonctionnement"></a>
Il était certe possible de réaliser ce projet sur une seul page. Néanmoins, le fonctionnement du routeur est plus compréhensible et explicable dans le cas où le site possède plusieur page. De plus, la quasi-totalité des applications web avec une base de donnée ont plus d'une page.
   
 - #### Page d'accueil <a name="accueil"></a>
   On a vu dans [Exemple du fonctionnement de l'architecture](#Exemple du fonctionnement de l'architecture dans ce projet pour l'url "index.php") comment fonctionne techniquement l'application sur l'url index.php. En plus d'afficher les meilleurs scores, il y a un formulaire que l'utilisateur rempli avant de commencer à jouer. 
 
 - #### Page du jeu <a name="jeu"></a>
   Après avoir validé le formulaire, l'utilisateur est automatiquement dirigé vers la page du jeu. Elle affiche le nom du joueur, le plateau de jeu, le chronomètre qui se lance automatiquement au début de la partie et la barre de progression qui se rempli en fonction du temps.
   
   Plusieurs choix étaient possibles pour l'affichage des cartes :
  - Soit deux balises <img/> dans la boucle for, une étant la carte grise et l'autre celle de l'image. A l'aide du CSS, on cache une des deux balises. Lors du clique sur l'image on inverse les classes CSS à l'aide d'un code en JS. La balise affiliée au fruit apparaît alors que la balise associée à la carte grise disparaît. 
  - Soit une div affichant la carte grise. Lors du clique et en utilisant le JSON contenant tous les fruits, on change l'attribut "src" de la balise <img/> par le nom du fruit. 
  
    Le premier est certe plus simple, en revanche les JSON sont très souvent utilisé dans le développement web, que le développeur soit FullStack, BackEnd ou FrontEnd, il est important de savoir maitriser ce type d'objet. C'est donc dans un but pédagogique et non technique que cette solution fût adoptée.
  
    Lors du click sur l'image, la fonction onClickManage() est appelé, si c'est le premier click, un objet "firstClickImg" est créée contenant le nom de l'image et son numéro. Lors du deuxième click, les informations de la deuxième image est comparée avec les informations de "firstClickImg". Si le nom est différent ou que le numéro est identique (l'utilisateur a cliqué deux fois sur la même carte), les cartes sont retournées. Dans le cas ou le nom est identique et le numéro différent, elles restent affichées et on bloque le click sur ces balises en enlevant la class imageClick. 
   A chaque click, un compteur de click est incrémenté et comparé avec le nombre de fruit totaux. S'ils sont égaux, la partie est terminée. 
  Une barre de progression permet de à l'utilisateur de prendre en considération la contrainte temps du jeu. La partie est perdu si la barre est remplie. 
  
    Lorsque l'utilisateur gagne, la fonction addGame() de l'objet GameController est appelée. Elle crée une nouvelle Game en base et un nouvel User relié au Game. Par la suite, cette fonction redirige l'utilisateur à la page d'accueil en modifiant l'url HTTP.
  
 ## Aspect Gestion du projet <a name="gestion"></a>
 La partie Gestion est tout aussi importante que la partie technique d'un projet. Elle rend la réalisation du projet fluide en évitant de modifier des fonctionnalités existantes ou de travailler sur des éléments qui ne seront pas utilisés finalement. GitHub propose, en plus de pouvoir sauvegarder son projet, de le préparer et gérer. 
 Cette partie expose : 
 
 - Le diagramme de classe
 - La création des Issues
 - La création du Project
 - La création des Branches et des Pull Requests
  
   ### Le diagramme de classe <a name="diagramme"></a>
   Ce diagramme est un schéma utilisé pour présenter les différentes entités du projet ainsi que les relations entre elles dans de la base de donnée.
   Deux Entités se trouvent dans ce projet : Game et User. 
   Une Troisième entité appelée Cartes était réalisable. L'inconvéniant était la modification de ses éléments. Dans l'état du projet, une boucle est effectuée afin de créer un tableau avec les noms des images, cette boucle est donc exécutée à chaque nouvelle partie. En revanche si on modifie les cartes ou qu'on en ajoute, l'application s'adaptera à ce changement. Alors que si le tableau se trouve en base, il faudra, en plus d'apporter des modifications dans les dossiers, modifier le tableau en base.
   ### Les Issues <a name="issue"></a>
   Ci dessous le lien des issues de Memory : 
      https://github.com/Doudou-A/Memory/issues?q=is%3Aissue+is%3Aclosed
   Chaque issue correspond à une étape du projet. Il est conseillé de toute les répertorier avant de commencer à coder.
   
   ### Le Project <a name="project"></a>
   Ci-dessous le project Github de Memory : 
   https://github.com/Doudou-A/Memory/projects/1
   A l'aide de ce tableau, les tâches sont reliées aux développeurs. Le chef de projet peut rapidement visualiser l'avancement du projet. Il se divise habituellement en 3 colonnes : 
   - ToDo : les tâches à effectuer
   - InProgress : les tâches sont assignées et commencées
   -Done : les tâches sont finalisées
   
   ### Les Branches et les Pull Requests <a name="branche"></a>
   Ci-dessous les branches du projet Memory qui ont été :
   https://github.com/Doudou-A/Memory/branches
   Ci-dessous les différentes branches du projet qui ont été :
   https://github.com/Doudou-A/Memory/pulls?q=is%3Apr+is%3Aclosed
   Le système de branche à pour avantage de travailler à plusieurs sur la même application en même temps sans créer de gêne entre les développeurs. Chaque développeur créer une branche dans laquelle il peut se concentrer sur la réalisation de la tâche ou du débugage sans qu'un autre développeur intervient sur les mêmes fichiers.
   Le PullRequest est effectué lorsque le développeur a terminé sa tâche. Les fichiers modifiés écrasent les fichiers antérieurs de la branche Principale. Les fichiers non modifiés ne sont pas écrasés. Il est possible de fermer une issue en commentant le pull request par son ID. Le chef de projet pourra donc immédiatement savoir quel était l'ojectif de cette tâche.
   
# Compte rendu agora 4 : symfony
Groupe Réda – Célina – Théo – Guenael - Mathieu

# Contexte 

La MJC AGORA de Libreville est une association d’éducation populaire de type loi 1901 qui a pour but de favoriser l’épanouissement de la personne par l’accès à l’éducation et à la culture pour tous. La MJC AGORA symbolise ce carrefour où convergent l’expression artistique, le numérique la musique, les danses, le bien-être et les sports ainsi que de nombreuses autres découvertes culturelles. Elle adapte ses projets aux attentes d’une société en constante évolution. Favoriser les démarches de projets jeunes, renforcer le vivre ensemble et les liens intergénérationnels sont des valeurs chères pour cette association. La MJC AGORA possède l’accréditation Service Volontaire Européen, les agréments jeunesse et sport, et est affiliée à la FFMJC (Fédération Française des Maisons des Jeunes et de la Culture), FRMJC(Fédération Régionale des Maisons des Jeunes et de la Culture), FFE (Fédération Française des Echecs) et à la FFRS (Fédération Française de Roller & Skateboard)

# Objectifs du projets et finalité 
La MJC Agora souhaite procéder à une refonte complète de son site web, poursuivant un double objectif : Un site web front-office destiné au grand public Une application back-office dédiée à l’administration du site Priorité au développement back-office Étant donné que le contenu affiché sur le site public sera intégralement géré via l’interface d’administration, le développement de l’application back-office AgoraBo constitue la première phase du projet. Cette application permettra d’administrer l’ensemble des informations relatives aux activités culturelles, artistiques et sportives, ainsi qu’aux intervenants et membres de la MJC. Elle devra notamment inclure : Les opérations CRUD Des fonctionnalités de recherche simples et efficaces Calendrier de réalisation Le développement du site web public Agora interviendra dans un deuxième temps, une fois le back-office AgoraBo mis en service.

# Trello



# Repo github
https://github.com/masdonte/agora


# Diagramme de classe

```plantuml
@startuml


class Genre{
  - idGenre : int
  - libGenre : int 
  - creerGenres():
  - supprimerGenres():
  - ajouterGenres():
  - modifierGenres():


}
class Pegi {
  - idPegi : int 
  - ageLimite : int 
  - descPegi : string 
  - creerPegis():
  - supprimerPegis():
  - ajouterPegis():
  - modifierPegis():

}

class Plateforme {
  - idPlateforme : int 
  - libPlateforme : string  
  - creerPlateforme():
  - supprimerPlateforme():
  - ajouterPlateforme():
  - modifierPlateforme():

}
class Marque {
- idMarque : int 
- nomMarque : string 
  - creerMarques():
  - supprimerMarques():
  - ajouterMarques():
  - modifierMarques():

}

class Jeu_video {
- refjeu : int
- nom : string 
- prix : int 
- dateParution : int 
- nombreJeux : int 
- idGenre
- idPegi
- idPlateforme
- idMarque
}

class Participants {
- idParticipants : int 
- prenom : string 
- nom : int 
- dateNaissance : date
- numeroPhone : int 
- pseudo : string 
}

class Tournois {
- idTournois : int 
- idParticipants : int 
}







Participants "1.." -- "0.." Tournois : estInscrit >
Genre "1" -- "0.." Jeu_video : a
Plateforme "1" -- "0.." Jeu_video : a


Marque "1" -- "0.." Jeu_video : a
Pegi "1" -- "0.." Jeu_video : a






@enduml
```

# Technologies utilisés

PHP : Langage serveur utilisé pour la logique applicative, avec PDO (PHP Data Objects) pour
un accès sécurisé à la base de données MySQL via des requêtes préparées.
Ainsi que le modèle MVC (modèle vue contrôleur) et le tout en programmation orienté objet.

MySQL : Système de gestion de base de données relationnelle permettant de stocker les différentes entités (genres, plateformes, marques, etc.).

HTML/CSS : Technologies dédiées à la structure et au style des pages. L'application s'appuie sur une charte graphique définie l'aide d'un template Bootstrap (Dashio de TemplateMag),
framework CSS open source sous licence MIT.

JavaScript/ Utilisés pour l'interactivité côté client (animations, gestion dynamique des
formulaires), principalement via les composants du framework Bootstrap

Twig est un moteur de template qui a été créé par SensioLabs, les créateurs du framework
Symfony.
On le retrouve nativement dans les frameworks Symfony et Drupal8, mais il peut être installé
sur la majorité des frameworks ainsi que dans un environnement PHP.

Symfony est un ensemble de composants PHP ainsi qu'un framework MVC libre écrit en PHP.
Il fournit des fonctionnalités modulables et adaptables qui permettent de faciliter et d’accélérer
le développement d'un site web.



# Mission 1 
Afin de passer totalement le projet sous Symfony, nous avons utilisé le composant Doctrine, qui est un logiciel d'ORM.

On a du l'installer avec composer graçe à cette commande dans le terminal du projet : 
composer require symfony/orm-pack


Nous avons ensuite créer une base de donnée à travers doctrine dans le php graçe à cette commande : 
php bin/console doctrine:data:create
Avec cet commande, une nouvelle base de donnée est creer dans la doctrine à travers symfony.

On va aussi créer un  nouveau compte dans le base de donnée : 
![alt text](image-15.png)
qui aura comme identifiant adminagora et comme mot de passe Agora1234! On lui accordera différent droit, comme la suppression, modifier, ajouter...etc.

Il a fallut ensuite reconfigurer le .env et remplacer la database_url : 
![alt text](image.png)

On peut donc constater que nous avons rajouter le nom de la base de donnée qui est agoraorm et le mot de passe et l'identifiant pour accéder à la base de donnée.


Il a fallut créer les entités dans la base de donnée directement dans le terminal du projet dans le php. Pour créer une entité il faut utiliser cet commande là : 
php/bin/console make:entity 
![
](image-1.png)
 ensuite nous donnant le nom de l'entité, avec ses spécifications ( le nom de la table, le type...)
 
 Suite à cela, symfony va générer le fichier suivant : 
 src/Repository/GenreRepository.php 
 ![alt text](image-2.png)
 Voici ce qui contient dans ce fichier : 
 ![alt text](image-12.png)
 Un repository est une classe qui permet de faire des requêtes sur une table (par l'intérmédiaire de l'entité associée) de la base de données.

 la doctrine ajoutera automatiquement dans la base de donnée l'entité avec sa table et ses spécifications mais il faut faire une commande pour que cela soi pousser.

Il faut ensuite lancer la migration :
php bin/console make:migration 
Qui sert à pousser vers les entités créer dans la base de donnée. Qui créer un fichier migration.
![alt text](image-3.png)
Il faut refaire une nouvelle commande de migration pour etre sur que cela est bien pousser dans la base de donnée : 
php bin/console doctrine:migrations:migrate
![alt text](image-13.png)
![alt text](image-14.png)
La commande a bien pousser dans la base de donnée.
La table genre a bien été rajouter automatiquement.

# Mission 3 : mise en place d'une relation many to one avec le composant Doctrine

Dans cet mission, nous avons donc créer les relations entre les entités. 

Pour cela, nous avons donc créer une entité tournoi : 
php bin/console make:entity
![alt text](image-4.png)
![alt text](image-5.png)
Lors de la création d'une entité, 2 fichiers sont créer : 
src/Entity/Tournoi.php
src/Repository/TournoiRepository.php 

Toute les spécifications de l'entité est demander : qu'elle est son nom, le nom de la table qui seront comprit à l'intérieur, la propiété...etc
Le fichier tournoi est créer dans le src/entity/tournoi.php

Nous allons ensuite mettre en relation tournois et catégorie tournois. Pour cela, nous allons recréer une entité : 
php bin/console make:entity CatTournois
![alt text](image-6.png)
Avec toutes ces spécifications.
Le fichier a été créer dans src/Entity/CatTournois.php

A partit de là, nous allons donc créer la relation entre tournois et catégorie tournois, pour cela nous allons relancer la commande php bin/console make:entity
Lorsque l'on va choisir le type, nous allons écrire relation : 
![alt text](image-8.png)
 Qui ensuite nous demandera qui soit en relation avec qu'elle entité qu'on dira : CatTournois. 
 ![alt text](image-9.png)
Par la suite, il faudra choisir le type de relation : 
![alt text](image-7.png)
Ici, nous allons choisir ManyToOne, qui veut dire que catégorie tournois et plusieurs tournois.
 Les fichier Tournoi.php et catTournois.php on été remise à niveau et les relations on été rajouter  : 
 ![alt text](image-10.png)
 On peut voir à la ligne 27 dans la fichier tournoi.php que l'ORM a bien ajouté la ligne qui est en relation avec CatTournois : 
 #[ORM\ManyToOne(inversebBy: 'tournois')]
 private ?carTournois $categorie = null;

Dans le fichier CatTournoi.php de meme : 
![alt text](image-11.png)
#[ORM\OneToMany(targetEntity: Tournoi::class, mappedBy: 'categorie)]
private Collection $tournois;

On peut constater que dans les deux fichiers, tous les spécifications des tables sont détaillés, c'est-à-dire que toutes les commandes qu'on a saisi dans le terminal , on les retrouve dans ce fichier.

Un attribut a aussi été rajouté avec son getter et son setter qui ne désigne pas un id mais un objet de la classe Categorie dans le fichier tournoi.

Dans le fichier catTournois, 3 méthodes ont été ajoutées getTournois(), addTournoi(), removeT(). 

A chaque fin de créationd d'entité, il faut toujours faire la migration pour pouvoir pousser dans la base de donnée , alors il faut refaire ses commandes : 
php bin/console make:migration 
php bin/console doctrine:migrations:migrate

Nous allons ensuite faire la génération du CRUD , qui sera la vue, dans l'interface dans le site internet pour tournoi et catégorie tournoi, pour cela , une commande à utiliser qui est : 
php bin/console make:crud Tournoi

Qui créera le controller et toutes les fichiers de tournoi : 
![alt text](image-16.png)

La meme chose pour CatTournois : 
![alt text](image-17.png)

Lorsqu'on se rend dans le site internet, l'interface de tournois et catégorie tournoi on été créer : 
![alt text](image-18.png)
Toutes les attributs qu'on a créer 
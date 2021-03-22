##Compte utilisateur:

####Compte user
login: barnabe123   
password: barnabe123

####Compte admin
login: admin2  
password: admin2


###Quelles sont les fonctionnalités principales du Symfony CLI ?

cela permet d'installer des composants pour un projet


###Quelles relations existent entre les entités (Many To One/Many To Many/...) ? Faire un schéma de la base de données.

![schema BDD](https://media.discordapp.net/attachments/755326178817998882/815880645762875403/unknown.png)

###Expliquer ce qu'est le fichier .env

Le fichier .env contient les variables d environnement.

###Expliquer pourquoi il faut changer le connecteur à la base de données
car il faut changer le mot de passe et l'identifiant pour que celui en local et celui en production soit différent

###Expliquer l'intérêt des migrations d'une base de données

Les migrations permettent de faire du versionning sur la base de données. La version est stocké dans le dossier migration a la racine du projet.

###Faire une recherche sur les différentes solutions disponibles pour l'administration dans Symfony

###Travail préparatoire : Qu'est-ce que EasyAdmin ?

EasyAdmin permet de réaliser des pages d'administration back-end sur une application symphony

###Pourquoi doit-on implémenter des méthodes to string dans nos entités?

les méthodes to string sont nécessaire pour pouvoir utiliser les entités dans le dashboard.

###Qu'est-ce que le ParamConverter ? À quoi sert le Doctrine Param Converter ?

Cela sert a convertir les paramètres de la requete en objet

###Qu'est-ce qu'un formulaire Symfony ?

C'est un formulaire qui utilise des champs d'une ou plusieurs entités

###Quels avantages offrent l'usage d'un formulaire ?

Les formulaires symphony sont rapide et facile à utiliser

###Quelles sont les différentes personalisations de formulaire qui peuvent être faites dans Symfony ?

Dans Symfony, tous sont des «types de formulaires»:

 - un seul champ de formulaire <input type="text">TextType
 - un groupe de plusieurs champs HTML utilisés pour saisir une adresse postale(par exemple PostalAddressType);
 - un ensemble <form>avec plusieurs champs pour éditer un profil d'utilisateur(par exemple UserProfileType).

###Définir les termes suivants : Encoder, Provider, Firewall, Access Control, Role, Voter

##Encoder

Encoder permet de chiffrer.

##Provider

Provider permet de gérer les sessions(authentification)

##Firewall

Firewall permet de restreindre certains informations de l'application.Ces restrictions peuvent se faire en fonction: d'un chemin, d'un hôte, d'une méthode HTTP, d'un service.
Le firewall est utile lors de l'authentification.

##Access Control

Access Control permet de restreindre certaines pages de l'application.

## Role

permet d'attribuer des roles au utilisateur

## Voter

Voter permet de gérer les permissions

###Qu'est-ce que FOSUserBundle ? Pourquoi ne pas l'utiliser ?

FOSUserBundle permet de gerer les utilisateurs. Celui ci est un bundle de symphony.
On ne l'utilise pas car les utilisateurs sont deja gérer.

###Définir les termes suivants : Argon2i, Bcrypt, Plaintext, BasicHTTP

##Argon2i
Ca permet de crypter une chaine de caractère(mdp, etc...)

##Bcrypt

Bcrypt est une fonction de hachage. Meme utilité que Argon2i

##Plaintext

Plaintext est une option pour les encoders qui met les données "en clair". Il est donc nécessaire de le changer par un algorithme de hachage ou de cryptage.

##BasicHTTP

Cela permet de valider les authentification HTTP

###Expliquer le principe de hachage.

Le hachage est une manière de crypter des données, c'est-à-dire que cela permet de rendre non lisible une donnée.

###Faire un schema expliquant quelle méthode est appelée dans quel ordre dans le LoginFormAuthenticator . Définir l'objectif de chaque méthodes du fichier.

##Méthode 1: supports

la méthode supports permet de vérifier que l'utilisateur envoie une demande d'authentification

##Méthode 2: getCredentials

la méthode getCredentials est utilisé si la méthode supports return true.Celle-ci retourne l'username, le mot de passe et un token.

##Méthode 3: getUser

la méthode getUser utilise les informations renvoyé par la méthode getCredentials. Cell-ci permet de retourner un Utilisateur.

##Méthode 4: checkCredentials

Si la méthode getUser retourne un utilisateur, la methode checkCredentials permet de vérifier le mot de passe.

##À quoi sert un service dans Symfony ? Avez-vous déjà utilisé des services dans ce projet ? Si oui, lesquels ? Définir les termes suivant : Dependency Injection, Service, Autowiring, Container

Nous avons utilisé des services pour l'envoi de mail

##Dependency Injection

Le composant DependencyInjection implémente un conteneur de services compatible qui vous permet de standardiser et de centraliser la façon dont les objets sont construits dans votre application.Le composant DependencyInjection implémente un conteneur de services compatible PSR-11 qui vous permet de standardiser et de centraliser la façon dont les objets sont construits dans votre application.

##Service

Un service est une classe dans laquel on instancie des méthodes.

##Autowiring

l'autowiring vous permet de gérer les services dans le container avec une configuration minimale

##Container

Un Container permet de rendre un service plus facile a utiliser et favorise une architecture forte, en y proposant le choix des arguments

###À quoi sert le validateur ? Dans quel contexte peut-on valider des données ?

le validateur sert a mettre des contraintes a des champs d'un formulaire.
La validation se fait lors de la validation des données ou de la modification des données.

###Quels sont les différentes parties du Serializer et à quoi servent-elles ?

le normalizer sert a comparer des textes.

Les 3 principaux normalizers

ObjectNormalizer : il utilise le composant pour accéder aux propriétés de l’objet. 
GetSetMethodNormalizer : il utilise les getter/setter de l’objet. 
PropertyNormalizer : il utilise PHP reflexion pour accéder aux propriétés de l’objet. 

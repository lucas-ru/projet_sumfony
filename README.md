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

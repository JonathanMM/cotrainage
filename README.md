# Cotrainage

* Auteur : JonathanMM
* Licence : GPL 3+
* Description : Site permettant à des personnes d'indiquer le train qu'ils vont prendre et ainsi pouvoir se retrouver dedans. Inscription réservé aux étudiants de l'ENSSAT.

## Pré-requis

* Serveur web (testé sur apache2 avec php5.x dessus)
* Base de données MySQL

## Installation

1. Executer install.sql sur votre base de données MySQL

2. Insérer les identifiants de connexion à votre base de données dans le fichier config.inc.php

3. Enjoy :)

## Notas

* Il se peut qu'il reste des http://cotrainage.nocle.fr en dur dans le code. C'est mal, je sais.
* Ce script a été écrit en 2012, ne l'oubliez pas :)
* Initialement, ce site est prévu uniquement pour les gens de l'ENSSAT. Ainsi, lors d'une inscription, le login de l'utilisateur sert à connaître son adresse mail et ainsi lui envoyer un mail pour valider son inscription.
* Aucune maintenance n'est prévu pour ce code, vous l'utilisez donc à vos risques et périls. Néanmoins, si des gens veulent modifier le code et l'améliorer, n'hésitez pas, forkez le ;) Si des choses sont utiles, je pourrais envisager de les remonter dans la branche master :)
Installation:

- installer les vendors avec la commande: composer install
- le point d'entré de l'application est le fichier "index.php" qui se trouve dans le dossier "web".
  il es  conseil de creer un hôte virtuel pointant sur ce dossier pour plus de praticité
- L'application nécessite le module appache "mod_rewrite" pour fonctionner


Utilisation:

- récupération des infos d'un adhérent : /api/user/{id}
- récupération de la liste des adhérents: /api/users
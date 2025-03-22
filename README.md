# Plugin Moodle : local_ws_mod_get_instanceid

Ce plugin ajoute un webservice à Moodle qui permet de récupérer l'ID d'instance et le type de module à partir d'un ID de module de cours (cmid).

## Licence
MIT License
Copyright (c) 2025 Maxime Cruzel
March 2025

## Installation

1. Copiez le contenu de ce dossier dans le répertoire `local/ws_mod_get_instanceid` de votre installation Moodle
2. Connectez-vous à votre site Moodle en tant qu'administrateur
3. Allez dans Administration du site > Notifications
4. Suivez les instructions pour installer le plugin

## Utilisation du webservice

### Nom du webservice
`local_ws_mod_get_instanceid_get_instance`

### Paramètres
- `cmid` (int) : ID du module de cours

### Retour
Le webservice retourne un objet JSON contenant :
- `instanceid` (int) : ID de l'instance du module
- `modulename` (string) : Nom du type de module (ex: quiz, assign)

### Exemple de réponse
```json
{
    "instanceid": 45,
    "modulename": "quiz"
}
```

## Sécurité
- Le webservice nécessite une authentification
- L'utilisateur doit avoir la capacité `moodle/course:view` pour utiliser le webservice
- Les paramètres sont validés et assainis
- Les exceptions sont gérées de manière appropriée

## Tests
Le plugin inclut des tests unitaires qui couvrent :
- La récupération d'un module de cours valide
- La gestion des modules de cours invalides
- La gestion des permissions utilisateur

Pour exécuter les tests :
1. Assurez-vous que PHPUnit est installé
2. Exécutez la commande : `php admin/tool/phpunit/cli/init.php`
3. Puis : `vendor/bin/phpunit local_ws_mod_get_instanceid/tests/external_test.php`

## Versions
- Version actuelle : 2024032102
- Compatible avec Moodle 4.1 et supérieur 
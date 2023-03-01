#  README

### Récupération du projet :

- Cloner le projet
- 2 branchs main et develop selon les besoins se déplacer sur la branch develop ```git checkout develop```
- Une fois sur la branch shouhaitée on installe les composants ```composer install```

### Créer la BDD :
-Copier le fichier .env et le renomer .env.local

Dans le .env.local :
  - Commenter la ligne: ```DATABASE_URL="postgresql://app:!ChangeMe!@127.0.0.1:5432/app?serverVersion=15&charset=utf8"```
  
  - Décommenter la ligne: ```DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=8&charset=utf8mb4```
  
  - Remplacer les données entre [ ] par vos identifiants : ```DATABASE_URL="mysql://[USERNAME]:[PASSWORD]@127.0.0.1:3306/[NOMDELABDD]?serverVersion=[VERSION_DE_LA_BDD]8&charset=utf8mb4```
    - [USERNAME] = votre username adminer
    
    - [PASSWORD] = votre password adminer
    
    - [NOMDELABDD] = à vous de choisir c'est le nom que vous donnez à la bdd 
    
    - [VERSION_DE_LA_BDD] = vous le trouvez sur adminer sa sera normalement ```mariadb-10.3.25```
    
  - Lancer la création de la BDD lancer la commande : ```php bin/console doctrine:database:create```
  
  - Lancer la migration création des tables : ```php bin/console doctrine:migrations:migrate```
  
  - Générer les données avec la commande : ```php bin/console doctrine:fixtures:load```
  
  - Conection serveur : ```php -S 0.0.0.0:8080 -t public```
  
### Api Doc : 

- Pour voire la doc de l'api : /api/doc

- Connection à la doc pour pouvoir test les routes :

  - route /api/login_check -> try it out -> Execute
  
  - Copier le token généré
  
  - Revenir sur le haut de la page cliquer sur Authorize tapez "bearer [copier votre token] -> Authorize
  vous pouvez tester vos routes mtn directement sur la doc!

### Mise à jour de la BDD (si vous aviez déja créé la bdd) :

- Supprimer les fichiers de migrations

- Drop toutes les tables de la base de donnée

- migration : ```php bin/console make:migration``` ensuite ```php bin/console doctrine:migrations:migrate```

- Dans /config/service.yaml commenter 

```php
  App\EventListener\UserScoreListener:
      tags:
          -
              name: 'doctrine.orm.entity_listener'
              event: 'postPersist'
              entity: 'App\Entity\Game'
              method: "calculUserScore"
  App\EventListener\UserNumberGameListener:
      tags:
          -
              name: 'doctrine.orm.entity_listener'
              event: 'postPersist'
              entity: 'App\Entity\Game'
              method: "addUserNumberGame"
  acme_api.event.authentication_success_listener:
      class: App\EventListener\AuthenticationSuccessListener
      tags:
          - { name: kernel.event_listener, event: lexik_jwt_authentication.on_authentication_success, method: onAuthenticationSuccessResponse }
```

- Charger les fixtures : ```php bin/console doctrine:fixtures:load```

- Décommenter le bloque commenté avant de lancer les fixtures
  
### Création de la clé JWT :

- Pour générer la clef : ```php bin/console lexik:jwt:generate-keypair```

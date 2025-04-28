<p align="center"><img src="https://phenix.mindcity-rp.fr/storage/img/GlobalFull.png" alt="Logo"></p>

Cette application est dédié au site web de l'association RP Phenix, sur le serveur Mindcity

Le site web et l’hébergement sont créé et maintenu par ImLacy_, en cas de question, de bug ou de réclamation, merci de la contacter (via discord)

Le site ou l’hébergement ne sont pas géré ou affilié avec Mindcity.
## Informations

Prérequis :
- PHP 8.x
- ClamAV
- CronJob
- Serveur MySQL

Technologies :
- Laravel
- MySQL
- Tailwind
- Larascord

Rank :
- 0 : Tout le monde
- 5 : Membre de l’association
- 6 : Organisation des courses
- 10 : Administration
- 15 : Président.e



Statut des pari :
- 0 : En attente du paiement du parieur
- 1 : En attente du résultat de la course
- 2 : Perdu : En attente du paiement du parieur
- 3 : Perdu
- 4 : Victoire - En attente du paiement du parieur
- 5 : Victoire - En attente du paiement de l’org
- 6 : Victoire - Paiement effectué

## Mettre en place son environment dev : 
- composer install
- npm install
- Créer une app discord
- Rentrer le Client ID et Client Secret dans le .env (`LARASCORD_CLIENT_ID` et `LARASCORD_CLIENT_SECRET`)
- Indiquer l'URL de redirection sur l'app discord (URL_APP/discord/callback)
- Ajouter votre config MySQL dans le .env
- Pour un env dev
  - `APP_ENV` en `local`
  - `APP_DEBUG` en `true`
  - `CLAMAV_SKIP_VALIDATION` en `true`
- php artisan migrate
- php artisan key:generate
- php artisan storage:link

Pour lancer le serveur web :
- php artisan serve

## Bug connu

- 


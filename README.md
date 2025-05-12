# CY_Click-journeY_NJS
## **************CY Tech - CY_Click-journeY**************
## **************CY_Click-journeY-MOMIJI Travel**************

### ***Projet-semestre2 - PréIng2***
### **Bienvenue dans notre programme**


## Sommaire
1. [Description du projet](#description-du-projet)
2. [Structure](#structure)
3. [Langages](#langages)
4. [Installation](#installation)
5. [Fonctionnalités du site](#fonctionnalités-du-site)
6. [Auteurs](#auteurs)

## Description du projet     
Le projet Click-journeY est un site web développé pour l'agence Momiji Travel, spécialisée dans les voyages au Japon en saison d’automne. Il propose des séjours préconfigurés de 10 jours, permettant aux voyageurs de choisir 2 régions sur 3 et d'adapter certains aspects. Les clients peuvent choisir parmi plusieurs circuits prédéfinis, axés sur 3 grandes régions et thèmes différents : culture & temples, gastronomie & traditions et détente & bien-être.

## Structure  
Le projet est divisé en plusieurs phases : 
1. **`Phase 1`** : Développement de l'interface utilisateur en HTML et CSS
2. **`Phase 2`** : Mise en place du backend (PHP, base de données)  
3. **`Phase 3`** : Ajout des fonctionnalités interactives avec JavaScript
4. **`Phase 4`** : Requêtes asynchrones pour optimiser l’expérience utilisateur  

## Langages    

[HTML]: https://img.shields.io/badge/HTML-E34F26?style=for-the-badge&logo=html5&logoColor=white
[HTML-url]: https://developer.mozilla.org/fr/docs/Web/HTML

[![HTML][HTML]][HTML-url]

[css]: https://img.shields.io/badge/css-1572B6?style=for-the-badge&logo=css3&logoColor=white&color=blue
[css-url]: https://developer.mozilla.org/fr/docs/Web/CSS/Reference

[![css][css]][css-url]

[php]: https://img.shields.io/badge/PHP-777BB4?logo=php&logoColor=white
[php-url]: https://developer.mozilla.org/fr/docs/Glossary/PHP

[![php][php]][php-url]

[javascript]: https://shields.io/badge/JavaScript-F7DF1E?logo=JavaScript&logoColor=000&style=flat-square
[javascript-url]: https://developer.mozilla.org/fr/docs/Web/JavaScript

[![javascript][javascript]][javascript-url]



## Installation  
#  Prérequis
Un environnement serveur local installé **WAMP Server** sur votre machine (alternative comme XAMPP)  
PHP inclus dans l'environnement serveur  

1. Téléchargement et installation WAMP Server  
   + Téléchargez **WAMP Server** depuis le site officiel et installez-le sur votre machine.
   + Ouvrez le peanneau de contrôle de WAMP et démarrez Apache.  
2. Configuration de la base de données  
   + Ouvre
3. Configuration du projet
   + Placez le dossier du projet dans le répertoire `www` de WAMP : 

1. Télécharger le fichier ZIP du projet depuis GitHub. 
2. Extraire le contenu du fichier ZIP dans un dossier de votre choix (de préférence présentation)
Extraire le contenu du fichier ZIP dans un dossier de votre choix.
Extraire les 

## Fonctionnalités du site     
**`index.html`** : Page d'accueil présentant les principales informations et attractions du site  
**`biblio.h`** : interface d'administration permettant de gérer les utilisateurs, les réser  
**`login_form.html`** : formulaire de connexion pour les utilisateurs et administrateurs  
**`sign_up.html`** : formulaire d'inscription pour créer un compte utilisateur  
**`tour.html`** : page listant les circuits touristiques diponibles avec descriptions et liens vers les détails des voyages  
**`presentation.html`** : présentation de l'agence, ses valeurs et recherche de circuits par thème   
**`users.json`** : données des utilisateurs  
schedule.json : informations sur les circuits et horaires
**`assets`** contient les fichiers CSS et les images utilisées sur nos pages  



## Arborescence du projet

```
📁 MomijiTravel_Phase2
├── 📁 all_tour_details
│   ├── 📄 nav.php
│   ├── 📄 tour_kansai_tohoku_culture.php
│   ├── 📄 tour_kansai_tohoku_detente.php
│   ├── 📄 tour_kansai_tohoku_food.php
│   ├── 📄 tour_kanto_kansai_culture.php
│   ├── 📄 tour_kanto_kansai_detente.php
│   ├── 📄 tour_kanto_kansai_food.php
│   ├── 📄 tour_kanto_tohoku_culture.php
│   ├── 📄 tour_kanto_tohoku_detente.php
│   └── 📄 tour_kanto_tohoku_food.php
│
├── 📁 assets
│   ├── 📁 css
│   │   └── 📄 styles.css
│   └── 📁 images
│       └── 📄 (images)
│
├── 📁 functions
│   └── 📄 functions.php
│
├── 📁 uploads
│   └── 📄 (uploads)
│
├── 📄 admin_page.php
├── 📄 edit_client.php
├── 📄 edit_reservation.php
├── 📄 footer.php
├── 📄 getapikey.php
├── 📄 index.php
├── 📄 login_form.php
├── 📄 logout.php
├── 📄 modify_reservation.php
├── 📄 nav.php
├── 📄 payment.php
├── 📄 payment_return.php
├── 📄 presentation.php
├── 📄 profil.php
├── 📄 result_tour.php
├── 📄 schedule.json
├── 📄 search.php
├── 📄 sign_up.php
├── 📄 tour.php
├── 📄 tour_details.php
├── 📄 users.json
├── 📄 view_client.php
└── 📄 view_reservation.php
```



## Auteurs    
- **Hamshigaa JEKUMAR** - hamshij05  
- **Thuy Tran NGUYEN** - thfennesty  
- **Elsa SANCHEZ** - elsw3

----Projet développé dans le cadre d'un projet universitaire----

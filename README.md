# Projet SymfonySecurite

## Installation

1.Clonez le projet depuis Github 
```bash
SSH : git clone git@github.com:LeRueHein/DevSecSymfony.git
HTTPS : git clone https://github.com/LeRueHein/DevSecSymfony.git
```

2.Créer le .env
```bash
APP_ENV=dev
APP_SECRET=rzeyuiryzeuryezuiyr
DATABASE_URL="sqlsrv://user:password@localhost/DevSecSymfony"
```

3.Installez les dépendances
```bash
composer install 
```

4.Créer la base de donnée avec le script SQL script.sql présent à la racine du
projet

5.Lancer cette commande qui démarra  le serveur 

```bash
symfony server:start
```
<?php 

// Constante du mode de l'application
// dev : variables utilisées en local
// prod : pour le déploiement de l'api en production
define("MODE", "prod");

switch (MODE) {
    case "dev":
        // Configuration BD en local
        $_ENV['host'] = 'localhost';
        $_ENV['username'] = 'root';
        $_ENV['database'] = 'libapi';
        $_ENV['password'] = 'mysql';
        break;
    
    case "prod":
        // Configuration BD pour Heroku
        $_ENV['host'] = 'us-cdbr-east-03.cleardb.com';
        $_ENV['username'] = 'b5ca43976743b6';
        $_ENV['database'] = 'heroku_85142f7d498789b';
        $_ENV['password'] = '3fba289e';
        break;
};




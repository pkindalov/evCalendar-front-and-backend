<?php
    //Load config
    require_once 'config/config.php';

    //Load Helpers
    require_once 'helpers/url_helper.php';
    require_once 'helpers/session_helper.php';
    require_once 'helpers/data_helper.php';
    require_once 'helpers/dates_helper.php';
    require_once 'helpers/google_charts_helper.php';
    require_once 'helpers/query_helpers.php';

    //Load libraries
    // require_once 'libraries/Core.php';
    // require_once 'libraries/Controller.php';
    // require_once 'libraries/Database.php';
    
    //Autoload Core libraries
    spl_autoload_register(function($className){
        require_once 'libraries/' . $className .'.php';
    });
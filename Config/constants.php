<?php

define("PROJECT_FOLDER", "/BufeteAbogados/");
define("DOCUMENT_ROOT", $_SERVER["DOCUMENT_ROOT"] . PROJECT_FOLDER );

define("APP_CONFIG", DOCUMENT_ROOT . "Config/" );
define("APP_CONTROLLERS", DOCUMENT_ROOT . "Controller/" );
define("APP_MODELS", DOCUMENT_ROOT . "Model/" );
define("APP_VIEWS", DOCUMENT_ROOT . "Vistas/" );
define("APP_WEBROOT", DOCUMENT_ROOT . "webroot/" );

define("BASE_URL", "http://". $_SERVER["SERVER_NAME"] . ":" .$_SERVER["SERVER_PORT"] . PROJECT_FOLDER );
define("CONTROLLER_PATH", BASE_URL . "Controller/" );
define("VIEWS_PATH", BASE_URL . "Vistas/" );
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


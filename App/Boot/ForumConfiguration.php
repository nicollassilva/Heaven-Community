<?php

namespace App\Boot;

use App\Languages\GetLanguage;
use Exception;

abstract class ForumConfiguration {
    public static $forumAddress = 'http://localhost/';
    public static $forumName = 'Heaven Fórum';
    public static $forumTitle = 'Uma cobertura completa do mundo dos games!';
    public static $forumDescription = 'Conteúdos sobre Transformice, Minecraft, World of WarCraft, Mu Online, Habbo Hotel, DDTank, Programação, Design e outras coisas!';
    public static $forumTwitter = '@YourTwitterHere';
    public static $forumKeywords = 'Habbo, Habblet, Jogos, CMS, Pixel, Tutoriais, PunBB, DDTank, Counter Strike, CrossFire, Grand Chase, Mu Online, Fóruns, Forumeiros, rpg, mmorpg forum, jogos mmorpg, ficheiros mmorpg, desenvolvimento';

    public static $forumEnvironments = ['development', 'production'];
    public static $forumMode = 'development';
    
    public static $forumMailDebugger = false;
    public static $forumMaintenance = false;
    
    public static $uploadFolder = 'uploads/';
    public static $forumLanguage = 'BR'; // BR, US, FR, IT, ES

    public static $router;

    public static function setMode()
    {
        if (!empty(self::$forumMode) && is_string(self::$forumMode) && in_array(self::$forumMode, self::$forumEnvironments)) {
            switch(self::$forumMode) {
                case 'development':
                    error_reporting(E_ALL);
                    ini_set("display_errors", 1);
                    break;
                case 'production':
                    error_reporting(0);
                    ini_set("display_errors", 0);
                    break;
                default:
                    error_reporting(0);
                    ini_set("display_errors", 0);
                    break;
            }
        } else {
            throw new Exception(self::getEnvironmentText());
        }
    }

    public static function getEnvironmentText()
    {
        $language = GetLanguage::get('enviroments_string_error');
        if(is_string($language) && mb_strlen($language) > 1 && $language != 'enviroments_string_error') {
            return $language;
        } else {
            throw new Exception("The configured language file was not found. Check the settings again.");
        }
    }

    public static function setRoutes(Object $routes)
    {
        self::$router = $routes;
    }

    public static function getRouter(String $routerName, Array $options = [])
    {
        if(is_object(self::$router) && null !== self::$router->route($routerName)) {
            return self::$router->route($routerName, $options);
        } else {
            return null;
        }
    }
}
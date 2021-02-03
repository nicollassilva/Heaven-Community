<?php

namespace App\Boot;

use App\Languages\GetLanguage;
use Exception;

abstract class ForumConfiguration {
    public static $forumAddress = 'http://localhost/';
    public static $forumName = 'Heaven Fórum';
    public static $forumTitle = 'Uma cobertura completa do mundo dos games!';
    public static $forumDescription = 'Conteúdos sobre Transformice, Minecraft, World of WarCraft, Mu Online, Habbo Hotel, DDTank, Programação, Design e outras coisas!';

    public static $forumEnvironments = ['development', 'production'];
    public static $forumMode = 'development';
    public static $forumMaintenance = false;
    public static $forumMaintenanceTime = 0;
    public static $uploadFolder = 'uploads/';
    public static $forumLanguage = 'BR'; // BR, US, FR, IT, ES

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
}
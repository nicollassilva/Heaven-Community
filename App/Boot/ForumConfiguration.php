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
    public static $tinyMCEKey = 'et5b6yxzcgtyjs7byjph9vhgl0uemwyli2mu3rm0atqjb0tl'; /** Your key for TinyMCE Editor */
    
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

    public static function formatTime($time)
    {
        $etime = time() - $time;
		if ($etime < 1) {
			return '1 segundo';
		} else {
			$a = array(
				365 * 24 * 60 * 60  =>  'ano',
				30 * 24 * 60 * 60  =>  'mês',
				24 * 60 * 60  =>  'dia',
				60 * 60  =>  'hora',
				60  =>  'minuto',
				1  =>  'segundo'
			);

			$a_plural = array(
				'ano'   => 'anos',
				'mês'  => 'meses',
				'dia'    => 'dias',
				'hora'   => 'horas',
				'minuto' => 'minutos',
				'segundo' => 'segundos'
			);

			foreach ($a as $secs => $str) {
				$d = $etime / $secs;
				if ($d >= 1) {
					$r = round($d);
					return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str);
				}
			}
		}
    }

    public static function getTagForTopic(String $type = 'normal')
    {
        switch ($type) {
            case 'request':
                $languageTag = GetLanguage::get('new_topic_request');
                break;
            case 'help':
                $languageTag = GetLanguage::get('new_topic_help');
                break;
            case 'cms':
                $languageTag = 'CMS';
                break;
            case 'pack':
                $languageTag = 'PACK';
                break;
            default:
                $languageTag = 'normal';
                break;
        }

        return $type != 'normal' ? "<span class=\"topic-{$type}\">{$languageTag}</span>" : '';
    }
}
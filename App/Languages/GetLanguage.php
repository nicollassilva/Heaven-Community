<?php

namespace App\Languages;

use App\Boot\ForumConfiguration;

abstract class GetLanguage {
    public static function readArchiveLanguage(): ?Object
    {
        $completePath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Languages' . DIRECTORY_SEPARATOR . ForumConfiguration::$forumLanguage . '.json';
        if (file_exists($completePath)) {
            $file = file_get_contents($completePath);
            $file = json_decode($file);
        } else {
            return null;
        }

        return $file;
    }
    
    public static function get(String $external_texts): ?String
    {
        return self::readArchiveLanguage() && isset(self::readArchiveLanguage()->$external_texts) ? 
            self::readArchiveLanguage()->$external_texts : (!isset(self::readArchiveLanguage()->$external_texts) ? $external_texts : '');
    }
}
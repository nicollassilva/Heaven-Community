<?php

namespace App\Core\Utils;

use Ramsey\Uuid\Uuid;
use App\{
    Core\Utils\BaseModel,
    Boot\ForumConfiguration as Configuration
};

class BaseApiModel extends BaseModel {
    protected $uploadTypes = [
        'arts', 'profiles'
    ];
    protected $baseToUpload = "../Public/";

    /**
     * @param string $tableName
     * @param string $primaryKey
     */
    public function __construct(String $tableName, String $primaryKey)
    {
        if(empty($tableName) || empty($primaryKey))
            return;

        parent::__construct($tableName, $primaryKey);
    }

    /**
     * @param string $typeUpload
     * @param array $document
     * @return string|bool
     */
    public function upload(String $typeUpload, Array $document, $audio = false)
    {
        $directory = $this->getDirectoryToUpload($typeUpload);

        if(isset($document["tmp_name"]) && $document["tmp_name"] != '') {
            preg_match((!$audio ? "/\.(gif|bmp|png|jpg|jpeg){1}$/i" : "/\.(mp4|mp3|mpeg3|wma){1}$/i"), $document["name"], $ext);
            $documentName = str_replace("/s{1}$/", '', $typeUpload) . "-" . (Uuid::uuid1())->toString() . "." . $ext[1];
            $imagePath = $directory . $documentName;
            
            return move_uploaded_file($document["tmp_name"], $imagePath) ? $documentName : false;
        } else {
            return false;
        }
    }

    /**
     * @param string $typeDocument
     * @return string|null
     */
    public function getDirectoryToUpload(String $typeDocument = '')
    {
        if(!empty($typeDocument) && in_array($typeDocument, $this->uploadTypes)) {
            return $this->directoryBase() . $typeDocument . "/";
        } else {
            return $this->directoryBase() . 'images/';
        }
    }

    /**
     * @return string
     */
    public function directoryBase()
    {
        return $this->baseToUpload . Configuration::$uploadFolder;
    }

    public function unlinkFile(Array $file)
    {
        $path = $this->getDirectoryToUpload($file[0]);
        $document = $path . $file[1];
        if(file_exists($document)) {
            unlink($document);
        }
    }

    public function getPage(Array $data, Int $limit)
    {
        return isset($data['page']) && is_numeric($data['page']) && $data['page'] != '1' && $data['page'] != '0' ? ($data['page'] * $limit) - $limit : 0;
    }

    public function alwaysArray($array)
    {
        return is_array($array) && count($array) > 0 && !isset($array[0]) ? [$array] : $array;
    }
}
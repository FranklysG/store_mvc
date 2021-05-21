<?php

namespace App\lib\util;

class Upload {

    private $name;
    private $ext;
    private $type;
    private $tmpName;
    private $error;
    private $size;

    public function __construct($files){
        $arq = pathinfo($files['name']);
        $this->name = $arq['filename'];
        $this->ext = $arq['extension'];
        $this->type = $files['type'];
        $this->tmpName = $files['tmp_name'];
        $this->error = $files['error'];
        $this->size = $files['size'];
    }

    public function getBaseName(){
        $ext = !strlen($this->ext)?: '.'.$this->ext;
        return $this->name.$ext;
    }

    public function uploaded($dir){
        if($this->error != 0){ return false;}
        $path = $dir.'/'.$this->getBaseName();
        move_uploaded_file($this->tmpName, $path);
    }
}
<?php

namespace App\lib\util;

class Upload {

    private $name;
    private $ext;
    private $type;
    private $tmpName;
    private $error;
    private $size;

    /**
     * passando os atributos da imagem enviada no construtor
     */
    public function __construct($files){
        $arq = pathinfo($files['name']);
        $this->name = $arq['filename'];
        $this->ext = $arq['extension'];
        $this->type = $files['type'];
        $this->tmpName = $files['tmp_name'];
        $this->error = $files['error'];
        $this->size = $files['size'];
    }

    /**
     * arrumando o nome da imagem com a extensão 
     */
    public function getBaseName(){
        $ext = !strlen($this->ext)?: '.'.$this->ext;
        return $this->name.$ext;
    }

    /**
     * carrega a imagem para outra pasta da aplicação 
     * se der erro na imagem ou alguma coisa do upload 
     * ele já retorna false
     */
    public function uploaded($dir){
        if($this->error != 0){ return false;}
        $path = $dir.'/'.$this->getBaseName();
        move_uploaded_file($this->tmpName, $path);
    }
}
<?php

namespace App\model;
use \App\database\Connection;
use \PDO;
use \PDOStatement;

class Pokemon{

    const TABLENAME = 'pokemon';
    const PRIMARYKEY = 'id';
    const IDPOLICY = 'max';

    public $id;
    public $name;
    public $url;
    public $type;
    public $created_at;

    /**
     * funçaõ responsavel por mandar o pokemon para classe de conexão 
     * pra salvar na tabela
     * @return boolean
     */
    public function store($attributes = []){
        $object = new Connection(self::TABLENAME);
        $this->id = $object->onSave($attributes);

        return true;
    }

    /**
     * função resposavel por retornar os objetos do banco .
     * @param $where 
     * @param $order 
     * @param $limit 
     */
    public static function load($where = null, $order = null, $limit = null){
        return (new Connection(self::TABLENAME))->onReload($where,$order,$limit);
    }

}
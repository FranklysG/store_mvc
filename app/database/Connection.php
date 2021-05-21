<?php

namespace App\database;
use \PDO;
use \PDOException;

class Connection{

    const HOST = 'localhost';
    const PORT = '';
    const USER = 'root';
    const NAME = 'pokedex';
    const PASS = '';
    const PREP = '1';
    
    private $transaction;
    private $table;
    

    public function __construct($table = null){
       $this->table = $table;
       $this->transaction();
    }

    public function transaction(){
        try {
            $this->transaction = new PDO('mysql:host='.self::HOST.';dbname='.self::NAME,self::USER,self::PASS);
            $this->transaction->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOExeption $e) {
            $this->transaction->rollback();
            die('ERROR: '.$e->getMessage());
        }
    }

    public function close(){
        try {
            
        } catch (PDOExeption $e) {
            die('ERROR: '.$e->getMessage());
        }
    }
    
    public function execute($sql, $param = []){
        try {
            $object = $this->transaction->prepare($sql);
            $object->execute($param);
            return $object->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOExeption $e) {
            die('ERROR: '.$e->getMessage());
        }
    }

    public function onSave($attributes = []){
        try {
            $keys  = array_keys($attributes);
            $values = array_pad([], count($keys), '?');
            $sql = 'INSERT INTO '.$this->table.' ( '.implode(',',$keys).' ) VALUES ( '.implode(',',$values).' ) ';
            $this->execute($sql, array_values($attributes));
            return $this->transaction->lastInsertId();
        } catch (PDOExeption $e) {
            die('ERROR: '.$e->getMessage());
        }
    }

    public function onEdit($where, $attributes){
        try {
            $keys  = array_keys($attributes);
            $sql = 'UPDATE '.$this->table.' SET '.implode('=?,',$keys).'=? WHERE '.$where;
            $this->execute($sql, array_values($attributes));
            return $this->transaction->lastInsertId();
        } catch (PDOExeption $e) {
            die('ERROR: '.$e->getMessage());
        }
    }




    public function onReload($where = null, $order = null, $limit = null){
        try {
            $where = strlen($where)? ' WHERE '.$where: ''; 
            $order = strlen($order)? ' ORDER BY '.$order: ''; 
            $limit = strlen($limit)? ' LIMIT '.$limit: ''; 
            $sql = 'SELECT * FROM '.$this->table.$where.$order.$limit;
            return $this->execute($sql);
        } catch (PDOExeption $e) {
            die('ERROR: '.$e->getMessage());
        }
    }

    public function onDelete($id){
        try {
            $sql = 'DELETE FROM '.$this->table.' WHERE id = '.$id;
            return $this->execute($sql);
        } catch (PDOExeption $e) {
            die('ERROR: '.$e->getMessage());
        }
    }
}
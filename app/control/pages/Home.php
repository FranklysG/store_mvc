<?php 

namespace App\control\pages;

use App\lib\util\PokemonColors;
use App\lib\util\AppUtil;
use App\view\View;
use App\model\Pokemon;

class Home extends Page{

    /**
     * Retorna o conteudo da home
     * @return String
     */
    public static function getHome(){
        (!isset($_POST['register']))?: self::insert($_POST);
        (!isset($_GET['onDelete']))?: self::delete($_GET);
        if(isset($_GET['onEdit'])){
            $content = self::edit($_GET['onEdit']);
        }else{ 
            $content = View::render('pages/home', array(
                'title' => 'Home',
                'register' => '<div class="row my-4 px-5">'.View::render('pages/register', array('function' => 'register')).'</div>',
                'contentPokemon' => '<div class="row my-4 px-5">'.self::getPokemon().'</div>',
                'contentMyPokemon' => '<div class="row my-4 px-5">'.self::getMyPokemon().'</div>'
            ));
        }
       
        return parent::getPage('Home', $content);
        
    }

    /**
     * função responsavelpor buscar os pokemons da api
     * @return String
     */
    public static function getPokemon(){
        $limit = 6;
        $offset = 0;
        $url = "https://pokeapi.co/api/v2/pokemon?offset=".$offset."&limit=".$limit;
        $pokemons = AppUtil::url_get_contents($url);
        $objects = $pokemons->results;
        $dataString = '';
        foreach ($objects as $key => $value) {
            $nameType = '';
            $img = "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/";
            $attributes = AppUtil::url_get_contents($value->url);
            $img .= $attributes->id.'.png';
            $peso = $attributes->weight;
            $altura = $attributes->height;
            $types = $attributes->types;
            foreach ($types as $type) {
               $nameType .= $type->type->name;
               break;
            }
            $dataString .= View::render('pages/pokemon', array(
                'id' => 'api',
                'name' => $value->name,
                'type' => $nameType,
                'img' => $img,
                'peso' => $peso,
                'altura' => $altura,
                'color' => PokemonColors::replaceColor($nameType)
            ));
        }
       
        return $dataString;
    }

    public static function getMyPokemon(){
        $dataString = '';
        $objects = Pokemon::load();
        foreach ($objects as $value) {
            $dataString .= View::render('pages/pokemon', array(
                'id' => $value->id,
                'name' => $value->name,
                'type' => $value->type,
                'img' => $value->url,
                'peso' => $value->peso,
                'altura' => $value->altura,
                'color' => PokemonColors::replaceColor($value->type)
            ));
        }

        return $dataString;
    }

    public static function edit($param){
        $objects = Pokemon::load($param);
        $dataString = '';
        foreach ($objects as $value) {
            $dataString = View::render('pages/register', array(
                'function' => 'onUpdate',
                'id' => $value->id,
                'name' => $value->name,
                'type' => $value->type,
                'img' => $value->url,
                'peso' => $value->peso,
                'altura' => $value->altura
            ));
        }
        // var_dump($dataString);exit;
        return $dataString;
    }

    public static function insert($param){
        if(isset($param['register'])){
            unset($param['register']);
            $object = new Pokemon;
            $object->store($param);
            header('Location: index.php');
        }
    }

    public static function update($param){
        if(isset($param['onUpdate'])){
            $object = new Pokemon;
            $object->edit($param['onEdit']);
            header('Location: index.php');
        }
    }

    public static function delete($param){
        if(isset($param['onDelete'])){
            $object = new Pokemon;
            $object->delete($param['onDelete']);
            header('Location: index.php');
        }
    }
}
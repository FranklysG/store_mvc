<?php 

namespace App\control\pages;

use App\lib\util\PokemonColors;
use App\lib\util\AppUtil;
use App\lib\util\Upload;

use App\view\View;

use App\model\Pokemon;
use App\model\Banner;

class Home extends Page{

    /**
     * Retorna o conteudo da home
     */
    public static function getHome(){
        self::sendImage($_FILES);
        (!isset($_GET['register']))?: self::insert($_GET);
        (!isset($_GET['onDelete']))?: self::delete($_GET);
        (!isset($_GET['onUpdate']))?: self::update($_GET);
        (isset($_GET['onEdit']))?
            $content = self::edit($_GET['onEdit'])
        : 
            $content = View::render('pages/home', array(
                'title' => 'Home',
                'register' => View::render('pages/register', array('function' => 'register', 'id' => '', 'name' => '', 'peso' => '', 'altura' => '')),
                'upload' => View::render('pages/upload'),
                'contentPokemon' => self::getPokemon(),
                'contentMyPokemon' => self::getMyPokemon()
            ));
        ;
       
        return parent::getPage('Home', $content);
        
    }

    /**
     * função responsavelpor buscar os pokemons da api
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
                'color' => PokemonColors::replaceColor($nameType),
                'classButton' => 'd-none' 
            ));
        }
       
        return $dataString;
    }

    /**
     * carrega os pokemons que estão cadastrados na base de dados
     */
    public static function getMyPokemon(){
        $dataString = '';
        $objects = Pokemon::load();
        foreach ($objects as $value) {
            $dataString .= View::render('pages/pokemon', array(
                'id' => $value->id,
                'name' => $value->name,
                'type' => $value->type,
                'img' => 'tmp/pokemonSiluete.png',
                'peso' => $value->peso,
                'altura' => $value->altura,
                'color' => PokemonColors::replaceColor($value->type),
                'classButton' => 'd-inline-block'
            ));
        }

        return $dataString;
    }

    /**
     * responsavel por salvar o nome da imagem no banco e transferir a 
     * imagem pra pasta tmp
     */
    public static function sendImage($files){
        if(!empty($files)){
            $object = new Upload($files['image']);
            $object->uploaded('tmp');

            $img = new Banner;
            $img->store(array(
                'name' => $files['image']['name']
            ));

            header('Location: /store_mvc');
        }

    }

    /**
     * função responsavel por carregar obejeto do banco de dados
     * no form passando o id do registro
     */
    public static function edit($param){
        $objects = Pokemon::load('id = '.$param);
        if(!empty($objects)){
            $dataString = '';
            foreach ($objects as $value) {
                $dataString = View::render('pages/register', array(
                    'function' => 'onUpdate',
                    'id' => $value->id,
                    'name' => $value->name,
                    'type' => $value->type,
                    'img' => $value->url,
                    'peso' => $value->peso,
                    'altura' => $value->altura,
                    'classForm' => 'myForm'
                ));
            }}else{
                $dataString = View::render('pages/error', array());
            }
        return $dataString;
    }

    /**
     * função responsavel por inserir um registro no banco
     */
    public static function insert($param){
        if(isset($param['register'])){
            unset($param['register']);
            $object = new Pokemon;
            $object->store($param);
            header('Location: index.php');
        }
    }

    /**
     * Função responsavel por atualizar um registro no banco 
     */
    public static function update($param){
        if(isset($param['onUpdate'])){
            unset($param['onUpdate']);
            $object = new Pokemon;
            $object->edit('id = '.$param['id'], $param);
            header('Location: index.php');
        }
    }

    /**
     * função responsavel por deltar o registro do banco 
     * passando o id do registro a ser deletado
     */
    public static function delete($param){
        if(isset($param['onDelete'])){
            $object = new Pokemon;
            $object->delete($param['onDelete']);
            header('Location: index.php');
        }
    }
}
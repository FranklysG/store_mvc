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
        // $object = Pokemon::load();
        $content = View::render('pages/home', array(
            'title' => 'Home',
            'content' => '<div class="row my-4 px-5">'.self::getPokemon().'</div>'
        ));

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
}
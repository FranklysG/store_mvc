<?php

namespace App\lib\util;

class PokemonColors{
    
    /**
     * função responsavel por dar o replace nas cores do tipo dos pokemons
     * @param $args tipo do pokemon => grass/ fire
     */
    public static function replaceColor($args){
        $color = [
            'default' => '#c2c2c2',
            'bug' => '#88960e',
            'dark' => '#402f25',
            'dragon' => '#725bda',
            'eletric' => '#e79302',
            'fairy' => '#e08ee0',
            'fighting' => '#642512',
            'fire' => '#d02903',
            'flying' => '#5d73d4',
            'ghost' => '#5a5aab',
            'grass' => '#73c235',
            'ground' => '#cead53',
            'ice' => '#6cd2f5',
            'normal' => '#c5c0b7',
            'poison' => '#8d408e',
            'psychic' => '#ee5088',
            'rock' => '#b69e54',
            'steel' => '#b2b2c2',
            'water' => '#3698fb',
        ];
        return $color[$args];
    }
}
<?php

namespace App\View;

class View{

    /**
     * responsavel por retornar o conteudo da view
     */
    private static function getContentView($view){
        $file = __DIR__.'/../resources/'.$view.'.html';
        return (!file_exists($file))?:file_get_contents($file);
    }

    /**
     * responsavel por redenrizar a view
     */
    public static function render($view, $args = []){
        $contentView = self::getContentView($view);
        
        $key = array_keys($args);
        $key = array_map(function($value){
            return '{{'.$value.'}}';
        },$key);
        return str_replace($key,array_values($args),$contentView) ;
    }
}
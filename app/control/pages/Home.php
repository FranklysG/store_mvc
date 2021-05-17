<?php 

namespace App\control\pages;

use App\view\View;
use App\model\Pokemon;

class Home extends Page{

    /**
     * Retorna o conteudo da home
     * @return String
     */
    public static function getHome(){
        $object = Pokemon::load();
        print_r($object);

        $content = View::render('pages/home', array(
            'title' => 'Teste de si MVC',
            'content' => 'Opa comandante'
        ));

        return parent::getPage('Home', $content);
    }
}
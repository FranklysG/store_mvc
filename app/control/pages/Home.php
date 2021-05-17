<?php 

namespace App\control\pages;

use App\view\View;
use App\model\entity\User;

class Home extends Page{

    /**
     * Retorna o conteudo da home
     * @return String
     */
    public static function getHome(){
        $objUser = new User;
        $content = View::render('pages/home', array(
            'title' => $objUser->name,
            'content' => $objUser->title,
        ));

        return parent::getPage('Home', $content);
    }
}
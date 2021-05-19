<?php 

namespace App\control\pages;

use App\view\View;

class Page{

    /**
     * Retorna o conteudo do header 
     * @return String
     */
    private static function getHeader(){
        return View::render('pages/header');
    }

     /**
     * Retorna o conteudo do Footer
     * @return String
     */
    private static function getFooter(){
        return View::render('pages/footer');
    }

    /**
     * Retorna o conteudo da Pagina 
     * @param String $title
     * @param Array $content
     * @return String
     */
    public static function getPage($title, $content = []){
        return View::render('pages/page', array(
            'title' => $title,
            'header' => self::getHeader(),
            'content' => $content,
            'footer' => self::getFooter()
        ));
    }

}
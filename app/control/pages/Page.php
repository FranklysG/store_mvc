<?php 

namespace App\control\pages;

use App\view\View;
use App\model\Banner;
class Page{

    /**
     * Retorna o conteudo do header 
     */
    private static function getHeader(){
        return View::render('pages/header');
    }

     /**
     * Retorna o conteudo do Footer
     */
    private static function getFooter(){
        return View::render('pages/footer');
    }

     /**
     * Reposavel por carregar o ultimo banner cadastrado no banco
     * e carregar-lo no slid 
     */
    private static function getBanner(){
        $object = Banner::load(null, 'created_at DESC', '1');
        (isset($object))? $object = array_shift($object)->name : $object = '';
        return $object;
    }

    /**
     * Responsavel por construir uma pagina com os elementos ja carregados
     * header, slid e footer
     */
    public static function getPage($title, $content = []){
        return View::render('pages/page', array(
            'title' => $title,
            'header' => self::getHeader(),
            'banner' => self::getBanner(),
            'content' => $content,
            'footer' => self::getFooter()
        ));
    }

}
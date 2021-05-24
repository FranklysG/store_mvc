<?php

require __DIR__.'/vendor/autoload.php';
use App\control\pages\Home;

// $url = str_replace("/store_mvc/?page=", "", $_SERVER["REQUEST_URI"]);
// $content = '';

// switch ($url) {
//     case 'sobre':
//         $content = 'sobre';
//         break;
//     default:
//         $content = Home::getHome();
//         break;
// }

echo Home::getHome();
<?php

//require_once __DIR__ . '/vendor/autoload.php';
ini_set('allow_url_fopen',1);
switch (@parse_url($_SERVER['REQUEST_URI'])['path']) {
    case '/':
        require 'index.php';
        break;
    case '/index':
        require 'index.php';
        break;
    case '/index.php':
        require 'index.php';
        break;
    case '/registro':
        require 'registro.php';
        break;
     case '/registro.php':
        require 'registro.php';
        break;
    case '/logout':
        require 'logout.php';
        break;
     case '/logout.php':
        require 'logout.php';
        break;
    case '/home-admin/homeadmin.php':
        require __DIR__.'/home-admin/homeadmin.php';
        break;
    case '/home-admin/listar-todo.php':
        require __DIR__.'/home-admin/listar-todo.php';
        break;
    case '/home-admin/observar-consulta.php':
        require __DIR__.'/home-admin/observar-consulta.php';
        break;
    case '/home-admin/ver-consulta.php':
        require __DIR__.'/home-admin/ver-consulta.php';
        break;
    case '/home-doctor/atender-perro.php':
        require __DIR__.'/home-doctor/atender-perro.php';
        break;
    case '/home-doctor/homedoctor.php':
        require __DIR__.'/home-doctor/homedoctor.php';
        break;
    case '/home-doctor/listar-perros.php':
        require __DIR__.'/home-doctor/listar-perros.php';
        break;
    case '/home-doctor/localizar_perro.php':
        require __DIR__.'/home-doctor/localizar_perro.php';
        break;
    case '/home-normal/comprobar_consulta.php':
        require __DIR__.'/home-normal/comprobar_consulta.php';
        break;
    case '/home-normal/consultar_perro.php':
        require __DIR__.'/home-normal/consultar_perro.php';
        break;
    case '/home-normal/eliminar_perro.php':
        require __DIR__.'/home-normal/eliminar_perro.php';
        break;
    case '/home-normal/home.php':
        require __DIR__.'/home-normal/home.php';
        break;
    case '/home-normal/registrar_perro.php':
        require __DIR__.'/home-normal/registrar_perro.php';
        break; 
    default:
        http_response_code(404);
        echo @parse_url($_SERVER['REQUEST_URI'])['path'];
        exit('Not Found');
}


?>
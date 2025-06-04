<?php

session_start(); //Inicia a sessão

require_once '../controller/GlicemiaController.php'; // Importa o controlador

// Declaração de variáveis globais
$lista = [];
$mensagem = "";

$uri = $_SERVER['REQUEST_URI'];
$path = parse_url($uri, PHP_URL_PATH);
$rota = trim($path, '/');

switch ($rota) {

    case "":
        require "../view/menu.php";
        break;

    case 'glicemia':
        (new GlicemiaController())->index();
        break;

    case 'glicemia/create':
        (new GlicemiaController())->create();
        break;

    case 'glicemia/edit':
        (new GlicemiaController())->edit();
        break;

    case 'glicemia/store':
        (new GlicemiaController())->store();
        break;

    default:
        echo "erro 404 - rota não localizada";
}

<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start(); // Inicia a sessão

// Controllers
require_once '../controller/GlicemiaController.php';
require_once '../controller/PacienteController.php';
require_once '../controller/MedicoController.php';

// Models
require_once '../model/Glicemia.php';
require_once '../model/Paciente.php';
require_once '../model/Medico.php';

// Declaração de variáveis globais
$lista = [];
$mensagem = "";

$uri = $_SERVER['REQUEST_URI'];
$path = parse_url($uri, PHP_URL_PATH);
$rota = trim($path, '/');

switch ($rota) {

    // Página inicial
    case "":
        require "../view/menu.php";
        break;

    // Rotas Glicemia
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

    case 'glicemia/delete':
        (new GlicemiaController())->delete();
        break;

    case 'glicemia/relatorio':
        (new GlicemiaController())->relatorio();
        break;

    // Rotas Paciente
    case 'paciente':
        (new PacienteController())->index();
        break;

    case 'paciente/create':
        (new PacienteController())->create();
        break;

    case 'paciente/edit':
        (new PacienteController())->edit();
        break;

    case 'paciente/store':
        (new PacienteController())->store();
        break;

    case 'paciente/delete':
        (new PacienteController())->delete();
        break;

    // Rotas Médico
    case 'medico':
        (new MedicoController())->index();
        break;

    case 'medico/create':
        (new MedicoController())->create();
        break;

    case 'medico/edit':
        (new MedicoController())->edit();
        break;

    case 'medico/store':
        (new MedicoController())->store();
        break;

    case 'medico/delete':
        (new MedicoController())->delete();
        break;

    // Rota não encontrada
    default:
        echo "Erro 404 - rota não localizada";
        break;
}

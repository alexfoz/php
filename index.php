<?php
session_start(); //Inicia a sessão
require_once 'controllers/FormController.php'; // Importa o controlador

$controller = new FormController();// Cria uma instância do controlador
$controller->handleRequest(); // Chama o método para tratar a requisição
?>
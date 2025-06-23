<?php
    session_start();
    include_once "../conexao/Conexao.php";
    include_once "../model/Cliente.php";
    include_once "../dao/ClienteDAO.php";

    $cliente = new Cliente();
    $clienteDAO = new ClienteDAO();

if (isset($_POST['acao']) && $_POST['acao'] === 'CADASTRAR') {
    

    $cliente->setNome_completo($_POST['nome_completo']);
    $cliente->setGenero($_POST['genero']);
    $cliente->setCpf($_POST['cpf']);
    $cliente->setRg($_POST['rg']);

    
    var_dump($cliente);

    
    $clienteDAO->inserir($cliente);

    header("Location: ../../view/informacoes/dados.php");
}

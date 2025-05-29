<?php
session_start();
/* @Autor: Dalker Pinheiro
Classe Controller */

include_once "../conexao/Conexao.php";
include_once "../model/Usuario.php";
include_once "../dao/UsuarioDAO.php";


$usuario = new Usuario();
$usuarioDAO = new UsuarioDAO();


$u = filter_input_array(INPUT_POST);

// Verifica se pesquisaram alguma coisa.
if (isset($_GET['pesquisa']) && !empty($_GET['pesquisa'])) {
    $usuarios = $usuarioDAO->buscar("id_user", $_GET['pesquisa']);
} else {
    $usuarios = $usuarioDAO->listarTodos();
}


//se a operação for gravar entra nessa condição
if (isset($_POST['acao']) && ($_POST['acao'] == "CADASTRAR")) {

    $usuario->setNome($u['nome']);

    $usuario->setIdade($u['idade']);

    $usuario->setSenha($u['senha']);

    $usuario->setEmail($u['email']);

    $usuario->setTelefone($u['telefone']);

    $usuario->setSexo($u['sexo']);

    $usuario->setTipo($u['tipo']);
    $usuarioDAO->inserir($usuario);

    header("Location: ../../view/login/index.html");
} else if (isset($_POST['acao']) && ($_POST['acao'] == "LOGAR")) {

    $usuario->setEmail($u['email']);

    $usuario->setSenha($u['senha']);

    $usuarioDAO->logar($usuario);

    header("Location: ../../view/paginaInicial/index.php");
} else if (isset($_POST['acao']) && ($_POST['acao'] == "DESLOGAR")) {


    session_start();
    session_unset();
    session_destroy();

    header("Location: ../../view/login/index.html");
    exit;

}
// se a requisição for editar 
else if (isset($_POST['acao']) && ($_POST['acao'] == "ATUALIZAR")) {

    $user = $usuarioDAO->carregar($_SESSION['id_user']);

    $usuario->setId_user($user['id_user']);

    $usuario->setNome($user['nome']);

    $usuario->setIdade($user['idade']);

    $usuario->setTelefone($user['telefone']);

    $usuario->setEmail($user['email']);

    $usuario->setSenha($user['senha']);

    $usuario->setSexo($user['sexo']);

    $usuario->setTipo($user['tipo']);

    $usuario->setDesc($u['descricao']);

    if ($usuarioDAO->atualizar($usuario)) {
        $_SESSION['tipo'] = $usuario->getTipo();
        $_SESSION['id_user'] = $usuario->getId_user();
        $_SESSION['email'] = $usuario->getEmail();
        $_SESSION['nome'] = $usuario->getNome();
        $_SESSION['descricao'] = $usuario->getDesc();
        var_dump($user);
        header("Location: ../../view/paginaInicial/index.php");
    }

    //header("Location: ../../view/paginaInicial/index.php");
}
// se a requisição for deletar
else if (isset($_GET['deletar'])) {

    $usuario->setId_user($_GET['deletar']);

    $usuarioDAO->deletar($usuario);

    header("Location: ../../usuario.php?msg=apagado");

} else if (isset($_POST['acao']) && $_POST['acao'] == "BuscarTipo") {

    $tipo = $_POST['tipo'];

    require_once '../dao/UsuarioDAO.php'; // ajuste o caminho conforme

    $usuarioDAO = new UsuarioDAO();
    $usuarios = $usuarioDAO->buscarTipo($tipo);

    echo json_encode($usuarios);
    exit;
}
else {
    header("Location: ../../usuario.php?msg=erro1");
}


<?php
session_start();
/* @Autor: Dalker Pinheiro
Classe Controller */

include_once "../conexao/Conexao.php";
include_once "../model/Usuario.php";
include_once "../model/Aluno.php";
include_once "../dao/AlunoDAO.php";
include_once "../model/Personal.php";
include_once "../dao/PersonalDAO.php";
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

    if ($usuarioDAO->verificarDuplicado($u['email'], $u['telefone'])) {
        $_SESSION['erro_cadastro'] = "Já existe um usuário com este e-mail ou telefone.";
        header("Location: ../../view/cadastro/index.php?erro=usuario%existente");
        exit;
    } else {
    $usuario->setNome($u['nome']);

    $usuario->setIdade($u['idade']);

    $usuario->setSenha($u['senha']);

    $usuario->setEmail($u['email']);

    $usuario->setTelefone($u['telefone']);

    $usuario->setSexo($u['sexo']);

    $usuario->setTipo($u['tipo']);
    $idUsuario = $usuarioDAO->inserir($usuario);

    if ($u['tipo'] === 'aluno') {
        $aluno = new Aluno();
        $aluno->setId_user($idUsuario);
        $alunoDAO = new AlunoDAO();
        $alunoDAO->inserir($aluno);

    } elseif ($u['tipo'] === 'personal') {
        $personal = new Personal();
        $personal->setId_user($idUsuario);
        $personal->setCertf($u['certificacao']);
        $personal->setEspecialidade($u['especialidade']);
        $personalDAO = new PersonalDAO();
        $personalDAO->inserir($personal);
        
    }

    header("Location: ../../view/login/index.php");
}
} else if (isset($_POST['acao']) && ($_POST['acao'] == "LOGAR")) {

    if ($usuarioDAO->verificarEmail($u['email'])) {
        $_SESSION['erro_login'] = "Não existe usuário com esse email";
        header("Location: ../../view/login/index.php?erro=usuarioinexistente");
        exit;
    } else if($usuarioDAO->verificarCredenciais($u['email'], $u['senha'])){
        $_SESSION['erro_login'] = "Não existe usuário com esses dados";
        header("Location: ../../view/login/index.php?erro=dadosincorretos");
        exit;
    }
    $usuario->setEmail($u['email']);
    $usuario->setSenha($u['senha']);
    $usuarioDAO->logar($usuario);

    header("Location: ../../view/paginaInicial/index.php");
} else if (isset($_POST['acao']) && ($_POST['acao'] == "DESLOGAR")) {


    session_start();
    session_unset();
    session_destroy();

    header("Location: ../../view/login/index.php");
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


}
// se a requisição for deletar
else if (isset($_GET['deletar'])) {

    $usuario->setId_user($_GET['deletar']);

    $usuarioDAO->deletar($usuario);

    header("Location: ../../usuario.php?msg=apagado");

} else if (isset($_POST['acao']) && $_POST['acao'] == "BuscarTipo") {

    $tipo = $_POST['tipo'];

    require_once '../dao/UsuarioDAO.php'; 

    $usuarioDAO = new UsuarioDAO();
    $usuarios = $usuarioDAO->buscarTipo($tipo);

    echo json_encode($usuarios);
    exit;
}
else {
    header("Location: ../../usuario.php?msg=erro1");
}


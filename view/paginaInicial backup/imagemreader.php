<?php
require_once '../../app/dao/Imagem_usuarioDAO.php'; // ajuste o caminho conforme seu projeto

if (isset($_GET['id_user'])) {
    $id_user = $_GET['id_user'];

    $dao = new Imagem_usuarioDAO();
    $imagem = $dao->carregar($id_user);

    if ($imagem && !empty($imagem['imagem'])) {
        header("Content-Type: " . $imagem['tipo']); // ex: image/png
        echo $imagem['imagem']; // imprime os dados binários da imagem
        exit;
    }
}

// Se não encontrar ou der erro, mostra uma imagem padrão
header("Content-Type: image/png");
readfile("../../imagens/imagem_padrao.png"); // ajuste o caminho da imagem padrão
exit; ?>
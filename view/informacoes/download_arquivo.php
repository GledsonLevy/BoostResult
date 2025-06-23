<?php
    
    include("../../app/conexao/Conexao.php");
    include("../../app/dao/ArquivoDAO.php");
    include("../../app/model/Arquivo.php");

    if (!isset($_GET['id_arq'])) {
        die('Arquivo não especificado.');
    }

    $id_arq = (int) $_GET['id_arq'];

    $arquivoDAO = new ArquivoDAO();
    $arquivo = $arquivoDAO->carregar($id_arq);

    if (!$arquivo) {
        die('Arquivo não encontrado.');
    }

    header('Content-Description: File Transfer');
    header('Content-Type: ' . $arquivo['tipo']);
    header('Content-Disposition: attachment; filename="' . basename($arquivo['nome']) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . strlen($arquivo['arq']));

    echo $arquivo['arq'];
    exit;


?>
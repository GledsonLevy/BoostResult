<?php
// ATENÇÃO: Este é o novo arquivo PHP chamado carregar_mensagens.php
// Salve este código como carregar_mensagens.php na mesma pasta do index.php

session_start();

include("../../app/conexao/Conexao.php");
include("../../app/dao/MensagemDAO.php");
include("../../app/dao/ChatDAO.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['acao'] === 'carregar_mensagens') {
    $id_solicitacao = $_POST['id_solicitacao'] ?? null;

    if (!$id_solicitacao) {
        http_response_code(400);
        echo json_encode(["erro" => "ID de solicitação não fornecido"]);
        exit;
    }

    $chatDao = new ChatDAO();
    $mensagemDao = new MensagemDAO();

    $chat = $chatDao->carregarPorSolicitacao($id_solicitacao);
    $mensagens = $chat ? $mensagemDao->listarMensagensPorChat($chat['id_chat']) : [];

    $dados = [];
    foreach ($mensagens as $msg) {
        $dados[] = [
            'id_msg' => $msg['id_msg'],
            'remetente' => $msg['remetente'],
            'texto' => $msg['texto'],
            'data' => $msg['data_msg']
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($dados);
    exit;
}
?>
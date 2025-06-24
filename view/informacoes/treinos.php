<?php
session_start();
include("../../app/conexao/Conexao.php");
include("../../app/dao/ArquivoDAO.php");
include("../../app/model/Arquivo.php");
include("../../app/dao/SolicitacaoDAO.php");
include("../../app/model/Solicitacao.php");
include("../../app/dao/PersonalDAO.php");
include("../../app/model/Personal.php");
include("../../app/dao/UsuarioDAO.php");
include("../../app/model/Usuario.php");

$usuarioDAO = new UsuarioDAO();
$arquivoDAO = new ArquivoDAO();
$personalDAO = new PersonalDAO();
$solicitacaoDAO = new SolicitacaoDAO();

$idAluno = $_GET['arquivos_aluno'] ?? null;


$solicitacoesRecebidas = $solicitacaoDAO->carregarAlunosSol($idAluno, "ativa");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Arquivos das Solicitações</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="estilo.css">
</head>
<body class="p-3 bg-black" style="background-color: #121212 !important;">
    <div class="container mt-4">

        <div class="row g-4">
            <?php if (!empty($solicitacoesRecebidas)): ?>
                <?php foreach ($solicitacoesRecebidas as $solicitacao): ?>
                    <?php 
                        $idSolicitacao = $solicitacao['id_solicitacao'];
                        $personal = $personalDAO->carregarPorId($solicitacao['id_personal']);
                        $personalUser = $usuarioDAO->carregar($personal['id_user']);
                        $arquivos = $arquivoDAO->listarPorSolicitacao($idSolicitacao);
                        if (empty($arquivos)) continue; // pula se não tiver arquivos
                    ?>
                    <div class="col-12">
                        <div class="card shadow-sm mb-4 bg-dark">
                            <div class="card-header p-2 text-white" style="background-color: #269126 !important;">
                                Enviados por: <?= htmlspecialchars($personalUser['nome']) ?>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <?php foreach ($arquivos as $arquivo): ?>
                                        <div class="col-md-4">
                                            <div class="card h-100 border border-0">
                                                <div class="card-body d-flex flex-column justify-content-between bg-dark">
                                                    <h5 class="card-title text-white"><?= htmlspecialchars($arquivo['nome']) ?></h5>
                                                    <p class="card-text  text-white">
                                                        Tipo: <?= htmlspecialchars($arquivo['tipo']) ?><br>
                                                        Tamanho: <?= round(strlen($arquivo['arq']) / 1024, 2) ?> KB
                                                    </p>
                                                    <a href="download_arquivo.php?id_arq=<?= $arquivo['id_arq'] ?>" class="p-2 text-white mt-auto"style="background-color: #269126 !important;">Baixar</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-info">Nenhuma solicitação ativa encontrada para este aluno.</div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

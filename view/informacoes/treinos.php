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
</head>
<body class="p-3 bg-white">
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
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-primary text-white">
                                Enviados por: <?= htmlspecialchars($personalUser['nome']) ?>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <?php foreach ($arquivos as $arquivo): ?>
                                        <div class="col-md-4">
                                            <div class="card h-100">
                                                <div class="card-body d-flex flex-column justify-content-between">
                                                    <h5 class="card-title"><?= htmlspecialchars($arquivo['nome']) ?></h5>
                                                    <p class="card-text text-muted">
                                                        Tipo: <?= htmlspecialchars($arquivo['tipo']) ?><br>
                                                        Tamanho: <?= round(strlen($arquivo['arq']) / 1024, 2) ?> KB
                                                    </p>
                                                    <a href="download_arquivo.php?id_arq=<?= $arquivo['id_arq'] ?>" class="btn btn-primary mt-auto">Baixar</a>
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

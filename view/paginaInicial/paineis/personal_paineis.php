<div class="solicitacao-panel" id="solicitacao-panel">
    
    <div class="solicitacao-header d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Solicitações Recebidas</h3>
        <button class="close-btn" id="close-solicitacao-btn">&times;</button>
    </div>

    <div class="solicitacao-body p-3">
        <?php if (isset($solicitacoesRecebidas) && !empty($solicitacoesRecebidas)) { ?>
            
            <?php foreach($solicitacoesRecebidas as $sol){ 
                $alunoLog = $alunoDao->carregarPorId($sol['id_aluno']);
                $userAluno = $usuarioDAO->carregar($alunoLog['id_user']);
                $nomeAluno = $userAluno['nome'];
            ?>
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title mb-1"><?= $nomeAluno ?></h6>
                    <p class="card-text text-light mb-2">Status: <strong><?= $sol['status'] ?></strong></p>

                    <div class="d-flex gap-2 justify-content-end"> <!-- Flex container -->
                        <form action="../../app/controller/SolicitacaoController.php" method="POST">
                            <input type="hidden" name="id_solicitacao" value="<?= $sol['id_solicitacao'] ?>">
                            <input type="hidden" name="status" value="ativa">
                            <button class="btn btn-success btn-sm" type="submit" name="editar" value="editar">Aceitar</button>
                        </form>

                        <form action="../../app/controller/SolicitacaoController.php" method="POST">
                            <input type="hidden" name="deletar" value="<?= $sol['id_solicitacao'] ?>">
                            <button class="btn btn-danger btn-sm" type="submit">Remover</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php } ?>
        <?php } else { ?>
            <div class="alert alert-info">Nenhuma solicitação recebida.</div>
        <?php } ?>
    </div>
</div>

<div class="chats-panel offcanvas-panel card p-4 shadow-lg" id="chats-panel" style="max-width: 600px;">
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
        <h3 class="mb-0 fw-bold">Bate-papo</h3>
        <button class="btn-close" id="close-chats-btn" aria-label="Fechar"></button>
    </div>
    <div class="row g-4">
        <?php foreach ($solicitacaoAlunoList as $solicitacaoAluno): 
            $alunoLog = $alunoDao->carregarIdAluno($solicitacaoAluno['id_aluno']);
            $aluno = $usuarioDAO->carregar($alunoLog['id_user']);
        ?>
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3 gap-3">
                            <img 
                                src="../../view/paginaInicial/imagemreader.php?id_user=<?= $aluno['id_user'] ?>" 
                                alt="avatar" 
                                class="rounded-circle" 
                                style="width: 64px; height: 64px; object-fit: cover; border: 2px solid #0d6efd;"
                                onerror="this.onerror=null; this.src='https://www.w3schools.com/howto/img_avatar.png';"
                            >
                            <h5 class="card-title mb-0 flex-grow-1"><?= htmlspecialchars($aluno['nome']) ?></h5>
                            <button 
                                class="btn btn-secondary btn-open-chats rounded-circle d-flex align-items-center justify-content-center" 
                                title="Iniciar conversa"
                                style="width: 48px; height: 48px; padding: 0;"
                                data-id-solicitacao="<?= $solicitacaoAluno['id_solicitacao'] ?>" 
                                data-id-destinatario="<?= $aluno['id_user'] ?>" 
                                data-id-remetente="<?= $_SESSION['id_user'] ?>"
                                data-nome="<?= htmlspecialchars($aluno['nome']) ?>"
                            >
                                <i class="bi bi-chat-dots fs-3"></i>
                            </button>
                        </div>

                        <p class="text-muted mb-3"><strong>Status:</strong> <?= htmlspecialchars($solicitacaoAluno['status']) ?></p>

                        <form class="arquivo-form" action="../../app/controller/ArquivoController.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id_solicitacao" value="<?= $solicitacaoAluno['id_solicitacao'] ?>">

                            <div class="row g-2 align-items-center">
                                <div class="col-12 col-sm-8">
                                    <div class="input-group">
                                        <label class="input-group-text" for="arquivo_<?= $solicitacaoAluno['id_solicitacao'] ?>">
                                            <i class="bi bi-upload"></i>
                                        </label>
                                        <input type="file" class="form-control arquivo-input" id="arquivo_<?= $solicitacaoAluno['id_solicitacao'] ?>" name="arquivo" required>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <button type="submit" name="enviar_arquivo" class="btn btn-success w-100">
                                        <i class="bi bi-send"></i> Enviar Treino
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="alunos-panel offcanvas-panel card p-4 shadow-lg" id="alunos-panel" style="max-width: 600px;">
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
        <h3 class="mb-0 fw-bold">Meus Alunos</h3>
        <button class="btn-close" id="close-alunos-btn" aria-label="Fechar"></button>
    </div>
    <div class="row g-4">
        <?php foreach ($solicitacaoAlunoList as $solicitacaoAluno): 
            $alunoLog = $alunoDao->carregarIdAluno($solicitacaoAluno['id_aluno']);
            $aluno = $usuarioDAO->carregar($alunoLog['id_user']);
        ?>
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3 gap-3">
                            <img 
                                src="../../view/paginaInicial/imagemreader.php?id_user=<?= $aluno['id_user'] ?>" 
                                alt="avatar" 
                                class="rounded-circle" 
                                style="width: 64px; height: 64px; object-fit: cover; border: 2px solid #0d6efd;"
                                onerror="this.onerror=null; this.src='https://www.w3schools.com/howto/img_avatar.png';"
                            >
                            <h5 class="card-title mb-0 flex-grow-1"><?= htmlspecialchars($aluno['nome']) ?></h5>
                            <form action="../../app/controller/SolicitacaoController.php" method="GET">
                                <input type="hidden" name="deletar" value="<?= $solicitacaoAluno['id_solicitacao'] ?>">
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-trash"></i> Remover Aluno
                                </button>
                            </form>
                        </div>

                        <p class="text-muted mb-3"><strong>Status:</strong> <?= htmlspecialchars($solicitacaoAluno['status']) ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
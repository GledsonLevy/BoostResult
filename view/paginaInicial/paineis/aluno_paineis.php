<div class="solicitacao-panel" id="solicitacao-panel">
    <div class="solicitacao-header d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Solicitações</h3>
        <button class="close-btn" id="close-solicitacao-btn">&times;</button>
    </div>

    <div class="solicitacao-body p-3">
        <?php if (isset($solicitacoesRecebidas) && !empty($solicitacoesRecebidas)) { ?>
            <?php foreach($solicitacoesRecebidas as $sol){ 
                $personalLog = $personalDao->carregarPorId($sol['id_personal']);
                $userPersonal = $usuarioDAO->carregar($personalLog['id_user']);
                $nomePersonal = $userPersonal['nome'];
            ?>
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title mb-1"><?= $nomePersonal ?></h6>
                    <p class="card-text text-light mb-2">Status: <strong><?= $sol['status'] ?></strong></p>
                    <form action="../../app/controller/SolicitacaoController.php" method="POST" class="d-flex justify-content-end">
                        <input type="hidden" name="deletar" value="<?= $sol['id_solicitacao'] ?>">
                        <button class="btn btn-danger btn-sm" type="submit">Cancelar</button>
                    </form>
                </div>
            </div>
            <?php } ?>
        <?php } else { ?>
            <div class="alert alert-info">Nenhuma solicitação na sua lista.</div>
        <?php } ?>
    </div>
</div>

<div class="chats-panel offcanvas-panel card p-4 shadow-lg" id="chats-panel" style="max-width: 600px;">
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
        <h3 class="mb-0 fw-bold">Bate-papo</h3>
        <button class="btn-close" id="close-chats-btn" aria-label="Fechar"></button>
    </div>
    <div class="row g-4">
        <?php foreach ($solicitacaoPersonalList as $solicitacaoPersonal): 
            $personalLog = $personalDao->carregarPorId($solicitacaoPersonal['id_personal']);
            $personal = $usuarioDAO->carregar($personalLog['id_user']);
        ?>
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3 gap-3">
                            <img 
                                src="../../view/paginaInicial/imagemreader.php?id_user=<?= $personal['id_user'] ?>" 
                                alt="avatar" 
                                class="rounded-circle" 
                                style="width: 64px; height: 64px; object-fit: cover; border: 2px solid #0d6efd;"
                                onerror="this.onerror=null; this.src='https://www.w3schools.com/howto/img_avatar.png';"
                            >
                            <h5 class="card-title mb-0 flex-grow-1"><?= htmlspecialchars($personal['nome']) ?></h5>
                            <button 
                                class="btn btn-secondary btn-open-chats rounded-circle d-flex align-items-center justify-content-center" 
                                title="Iniciar conversa"
                                style="width: 48px; height: 48px; padding: 0;"
                                data-id-solicitacao="<?= $solicitacaoPersonal['id_solicitacao'] ?>" 
                                data-id-destinatario="<?= $personal['id_user'] ?>" 
                                data-id-remetente="<?= $_SESSION['id_user'] ?>"
                                data-nome="<?= htmlspecialchars($personal['nome']) ?>"
                            >
                                <i class="bi bi-chat-dots fs-3"></i>
                            </button>
                        </div>

                        <p class="text-muted mb-3"><strong>Status:</strong> <?= htmlspecialchars($solicitacaoPersonal['status']) ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="personais-panel offcanvas-panel card p-4 shadow-lg" id="personais-panel" style="max-width: 600px;">
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
        <h3 class="mb-0 fw-bold">Meus Personais</h3>
        <button class="btn-close" id="close-personais-btn" aria-label="Fechar"></button>
    </div>
    <div class="row g-4">
        <?php foreach ($solicitacaoPersonalList as $solicitacaoPersonal): 
            $personalLog = $personalDao->carregarPorId($solicitacaoPersonal['id_personal']);
            $personal = $usuarioDAO->carregar($personalLog['id_user']);
        ?>
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3 gap-3">
                            <img 
                                src="../../view/paginaInicial/imagemreader.php?id_user=<?= $personal['id_user'] ?>" 
                                alt="avatar" 
                                class="rounded-circle" 
                                style="width: 64px; height: 64px; object-fit: cover; border: 2px solid #0d6efd;"
                                onerror="this.onerror=null; this.src='https://www.w3schools.com/howto/img_avatar.png';"
                            >
                            <h5 class="card-title mb-0 flex-grow-1"><?= htmlspecialchars($personal['nome']) ?></h5>
                            <form action="../../app/controller/SolicitacaoController.php" method="GET">
                                <input type="hidden" name="deletar" value="<?= $solicitacaoPersonal['id_solicitacao'] ?>">
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-trash"></i> Remover Personal
                                </button>
                            </form>
                        </div>

                        <p class="text-muted mb-3"><strong>Status:</strong> <?= htmlspecialchars($solicitacaoPersonal['status']) ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
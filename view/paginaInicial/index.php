<?php
session_start();
include("../../app/conexao/Conexao.php");
include("../../app/dao/UsuarioDAO.php");
include("../../app/model/Usuario.php");
include("../../app/dao/PersonalDAO.php");
include("../../app/model/Personal.php");
include("../../app/dao/AlunoDAO.php");
include("../../app/model/Aluno.php");
include("../../app/dao/Imagem_usuarioDAO.php");
include("../../app/model/Imagem_usuario.php");
include("../../app/dao/SolicitacaoDAO.php");
include("../../app/model/Solicitacao.php");
include("../../app/dao/ChatDAO.php");
include("../../app/model/Chat.php");
include("../../app/dao/MensagemDAO.php");
include("../../app/model/Mensagem.php");

function console_log($msg) {
    echo "<script>console.log(" . json_encode($msg) . ");</script>";
}

$usuarioDAO = new UsuarioDAO();


$solicitacaoDAO = new SolicitacaoDAO();
$personalDao = new PersonalDao();
$alunoDao = new AlunoDao();
$chatDao = new ChatDAO();
$mensagemDao = new MensagemDAO();
$imagemDao = new Imagem_usuarioDAO();

//criar um header caso a session não possua nada
console_log($_SESSION);
if($_SESSION['tipo'] == "personal"){
    $userPersonal = $personalDao->buscarIdPersonal($_SESSION['id_user']);
    $solicitacoesRecebidas = $solicitacaoDAO->carregarPersonaisSol($userPersonal, "solicitada");
    $solicitacaoAlunoList = $solicitacaoDAO->carregarPersonaisSol($userPersonal, "ativa");
    
}
if($_SESSION['tipo'] == "aluno"){
    $personais = $usuarioDAO->buscarTipo('personal');
    $userAluno = $alunoDao->buscarIdAluno($_SESSION['id_user']);
    $solicitacoesRecebidas = $solicitacaoDAO->carregarAlunosSol($userAluno, "solicitada");
    $solicitacaoPersonalList = $solicitacaoDAO->carregarAlunosSol($userAluno, "ativa");
    console_log($solicitacaoPersonalList);
}


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BoostResult</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <button class="menu-toggle" onclick="toggleSidebar()">☰</button>
    <?php if ($_SESSION['tipo'] == 'aluno') { ?>
        <div class="solicitacao-panel" id="solicitacao-panel">
            <div class="solicitacao-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Solicitações</h4>
                <button class="close-btn" id="close-solicitacao-btn">&times;</button>
            </div>

            <div class="solicitacao-body p-3">
                <?php if (isset($solicitacoesRecebidas) && !empty($solicitacoesRecebidas)) { ?>
                    <h5 class="mb-3 text-primary">Solicitações Recebidas</h5>
                    <?php foreach($solicitacoesRecebidas as $sol){ 
                        $personalLog = $personalDao->carregarPorId($sol['id_personal']);
                        $userPersonal = $usuarioDAO->carregar($personalLog['id_user']);
                        $nomePersonal = $userPersonal['nome'];
                    ?>
                    <div class="card mb-3 shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title mb-1"><?= $nomePersonal ?></h6>
                            <p class="card-text text-muted mb-2">Status: <strong><?= $sol['status'] ?></strong></p>
                            <form action="../../app/controller/SolicitacaoController.php" method="POST" class="d-flex justify-content-end">
                                <input type="hidden" name="id_solicitacao" value="<?= $sol['id_solicitacao'] ?>">
                                <input type="hidden" name="status" value="ativa">
                                <button class="btn btn-success btn-sm" type="submit" name="editar" value="editar">Aceitar</button>
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
                <h3 class="mb-0 fw-bold text-primary" id="batpapo" style="color: #269126 !important;">Bate-papo</h3>
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
                                        style="width: 64px; height: 64px; object-fit: cover;"
                                        onerror="this.onerror=null; this.src='https://www.w3schools.com/howto/img_avatar.png';"
                                    >
                                    <h5 class="card-title mb-0 flex-grow-1"><?= htmlspecialchars($personal['nome']) ?></h5>
                                    <button 
                                        class="btn btn-primary btn-open-chats rounded-circle d-flex align-items-center justify-content-center" style="background-color: #269126 !important;" 
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
                <h3 class="mb-0 fw-bold text-primary">Meus Personais</h3>
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
                                        style="width: 64px; height: 64px; object-fit: cover; border: 2px solid #269126;"
                                        onerror="this.onerror=null; this.src='https://www.w3schools.com/howto/img_avatar.png';"
                                    >
                                    <h5 class="card-title mb-0 flex-grow-1"><?= htmlspecialchars($personal['nome']) ?></h5>
                                    <form action="../../app/controller/SolicitacaoController.php" method="GET">
                                        <input type="hidden" name="deletar" value="<?= $solicitacaoPersonal['id_solicitacao'] ?>">
                                        <button type="submit" class="btn btn-outline-danger btn-sm" id="remover-personal-btn">
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

    <?php } ?>

    

    
<?php if ($_SESSION['tipo'] == 'personal') { ?>
    <div class="solicitacao-panel" id="solicitacao-panel">
        <div class="solicitacao-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Solicitações</h4>
            <button class="close-btn" id="close-solicitacao-btn">&times;</button>
        </div>

        <div class="solicitacao-body p-3">
            <?php if (isset($solicitacoesRecebidas) && !empty($solicitacoesRecebidas)) { ?>
                <h5 class="mb-3 text-primary">Solicitações Recebidas</h5>
                <?php foreach($solicitacoesRecebidas as $sol){ 
                    $alunoLog = $alunoDao->carregarPorId($sol['id_aluno']);
                    $userAluno = $usuarioDAO->carregar($alunoLog['id_user']);
                    $nomeAluno = $userAluno['nome'];
                ?>
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title mb-1"><?= $nomeAluno ?></h6>
                        <p class="card-text text-muted mb-2">Status: <strong><?= $sol['status'] ?></strong></p>
                        <form action="../../app/controller/SolicitacaoController.php" method="POST" class="d-flex justify-content-end">
                            <input type="hidden" name="id_solicitacao" value="<?= $sol['id_solicitacao'] ?>">
                            <input type="hidden" name="status" value="ativa">
                            <button class="btn btn-success btn-sm" type="submit" name="editar" value="editar">Aceitar</button>
                        </form>
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
            <h3 class="mb-0 fw-bold text-primary">Bate-papo</h3>
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
                                    style="width: 64px; height: 64px; object-fit: cover; border: 2px solid #269126;"
                                    onerror="this.onerror=null; this.src='https://www.w3schools.com/howto/img_avatar.png';"
                                >
                                <h5 class="card-title mb-0 flex-grow-1"><?= htmlspecialchars($aluno['nome']) ?></h5>
                                <button 
                                    class="btn btn-primary btn-open-chats rounded-circle d-flex align-items-center justify-content-center" 
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
            <h3 class="mb-0 fw-bold text-primary">Meus Alunos</h3>
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
                                    style="width: 64px; height: 64px; object-fit: cover; border: 2px solid #269126;"
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
<?php } ?>

    <div class="chat-panel" id="chat-panel" style="display: none;">
        <div class="chat-header">
            <span id="receberNomeUsuario">Nome do Usuário</span>
            <button class="close-btn" id="close-chat-btn">&times;</button>
        </div>

        <div class="chat-body" id="interacao-conteudo">
            <!-- mensagens geradas dinamicamente -->
        </div>

        <form class="chat-input" action="../../app/controller/MensagemController.php" method="POST">
            <input type="text" name="mensagem" placeholder="Digite sua mensagem..." required>
            <input type="hidden" name="destinatario" id="destinatario_id">
            <input type="hidden" name="remetente" id="remetente_id">
            <input type="hidden" name="solicitacao_id" id="solicitacao_id">
            <input type="hidden" name="acao" value="INSERIR">
            <button><i class="bi bi-send-fill"></i></button>
        </form>
    </div>

    <div class="sidebar">
        <ul>
                <?php
                if ($_SESSION['tipo_usuario'] == "admin") {
                    echo "<li id='alunos-btn'>Alunos</li>";
                    echo "<li id='personais-btn'>Personais</li>";
                } else {

                    if($_SESSION['tipo'] == "aluno"){
                        echo "<li id='personais-btn'>Personais</li>";
                        echo "<li id='chats-btn'>Bate-papo</li>";
                        echo "<li id='solicitacao-btn'>Solicitações</li>";
                    }else{
                        echo "<li id='alunos-btn'>Alunos</li>";
                        echo "<li id='chats-btn'>Bate-papo</li>";
                        echo "<li id='solicitacao-btn'>Solicitações</li>";
                    }
                }

                ?>
            <form method="POST" action="../../app/controller/UsuarioController.php">
                <button type="submit" name="acao" value="DESLOGAR" id="sair">Sair</button>
            </form>
        </ul>
    </div>

    <div class="main">
        <div class="profile">
            <form action="../../app/controller/imagem_usuarioController.php" method="POST" enctype="multipart/form-data">
                <label for="fileUpload">
                    <div class="cover">
                    </div>
                </label>
                <input type="file" name="foto" accept="image/*" style="display:none;"
                    onchange="this.form.submit();">
            </form>
            <form action="../../app/controller/imagem_usuarioController.php" method="POST" enctype="multipart/form-data">
                <label for="fileUpload">
                    <div class="avatar" style="cursor:pointer;">
                        <img src="../../view/paginaInicial/imagemreader.php?id_user=<?php echo $_SESSION['id_user']; ?>" 
                            alt="avatar" width="150" 
                            onerror="this.onerror=null; this.src='https://www.w3schools.com/howto/img_avatar.png';">
                        <span class="emoji"><img src="../../imagens/icongaleria.png" alt=""></span>
                    </div>
                </label>
                <?php 
                    $imagem = $imagemDao->carregar($_SESSION['id_user']);
                    if (!empty($imagem) && !empty($imagem['imagem'])) {
                        echo '<input type="hidden" name="editar" value="Editar">';
                    } else {
                        echo '<input type="hidden" name="cadastrar" value="Cadastrar">';
                    }
                ?>
                <input type="hidden" name="id_user" value="<?php echo $_SESSION['id_user']; ?>">
                <input type="file" id="fileUpload" name="imagem" accept="image/*" style="display:none;" onchange="this.form.submit();">
            </form>
            
            <div class="profile-info">
                <h1 id="nomeConta">
                    <?php echo $_SESSION['nome']; ?>
                </h1>
                <p id="tipoConta">
                    <?php echo $_SESSION['tipo']; ?>

                </p>
                <p>
                    <?php
                    if ($_SESSION['descricao'] == "") {
                        echo 'Adicione uma bio!';
                    } else {
                        echo $_SESSION['descricao'];
                    }
                    ?>
                </p>
                <button type="button" class="secondary btn-sm border-0" data-toggle="modal" data-target="#modalExemplo"
                    id="botaoBio">
                    Modificar bio
                </button>

            </div>

            <div>
    <!-- Botões -->
    <div class="button-container transition">
    <?php if ($_SESSION['tipo'] == 'aluno') {
            $idAluno = $alunoDao->buscarIdAluno($_SESSION['id_user']);
            if (!$idAluno) {
                console_log("ID do aluno não encontrado!");
                $idAluno = 0;
            }
        ?>
            <button id="button1" onclick="loadPage('../informacoes/treinos.php?arquivos_aluno=<?=$idAluno ?>', this)">Meus Treinos</button>
            <button id="button2" onclick="loadPage('../informacoes/medidas.php', this)">Medidas</button>
        <?php }?>
    <button id="button3" onclick="loadPage('../informacoes/dados.php', this)">Dados Pessoais</button>

    <div id="underline-indicator"></div>
</div>

<iframe id="conteudo-iframe" src=""></iframe>

</div>

        </div>
    </div>
<?php if($_SESSION['tipo'] == 'aluno'){ ?>
    <div class="right-sidebar">
        <div class="Users">
            <br>
            <h3>Personais Em Destaque</h3>
            <br>
            <?php foreach($personais as $personal){ 
                        $personalLog = $personalDao->carregar($personal['id_user']);
                        $alunoLog = $alunoDao->buscar('id_user', $_SESSION['id_user']);
                ?>
                <div class="user">
                    
                        
                    
                    <img src="../../view/paginaInicial/imagemreader.php?id_user=<?php echo $personal['id_user']?>" 
                            alt="avatar" width="150" id="imgAvatar"
                            onerror="this.onerror=null; this.src='https://www.w3schools.com/howto/img_avatar.png';">
                    <span><?=$personal['nome']?></span>
        
                        <form action="../../app/controller/SolicitacaoController.php" method="POST">
                            <input type="hidden" name="id_personal" value="<?=$personalLog['id_personal'] ?>">
                            <input type="hidden" name="id_aluno" value="<?=$alunoLog['id_aluno'] ?>">
                            <input type="hidden" name="status" value="solicitada">
                            <button type="submit" name="cadastrar" value="cadastrar">Solicitar</button>
                        </form>
                    
                </div>
            <?php } ?>
            
        </div>
    </div>
<?php } ?>
    <!-- Modal -->
    <div class="modal fade" id="modalExemplo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Mudar Descrição</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <form action="../../app/controller/UsuarioController.php" method="POST">
                        <label for="descricao">Descrição</label><br>
                        <textarea id="descricao" name="descricao" autofocus></textarea><br><br>
                        <button type="submit" name="acao" value="ATUALIZAR"
                            class="btn btn-secondary">Atualizar</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</body>
<script src="script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
    crossorigin="anonymous"></script>
</html>
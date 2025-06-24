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
    <?php
    if ($_SESSION['tipo'] == 'aluno') {
        include('paineis/aluno_paineis.php');
    } else if ($_SESSION['tipo'] == 'personal') {
        include('paineis/personal_paineis.php');
    }
    ?>

    <div class="chat-panel" id="chat-panel" style="display: none;">
        <div class="chat-header">
            <span id="receberNomeUsuario">Nome do Usuário</span>
            <button class="close-btn" id="close-chat-btn">&times;</button>
        </div>

        <div class="chat-body" id="interacao-conteudo">
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

                <iframe id="conteudo-iframe" src="" style="width: 100%; height: 600px; border: none; margin-top: 20px;"></iframe>
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

    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
        crossorigin="anonymous"></script>
</body>
</html>
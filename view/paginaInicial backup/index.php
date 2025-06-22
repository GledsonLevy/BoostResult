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
$personais = $usuarioDAO->buscarTipo('personal');

$solicitacaoDAO = new SolicitacaoDAO();
$personalDao = new PersonalDao();
$alunoDao = new AlunoDao();
$chatDao = new ChatDAO();
$mensagemDao = new MensagemDAO();

$mensagens = [];
$chat = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_solicitacao'], $_POST['id_user'])) {
    $id_solicitacao = $_POST['id_solicitacao'];
    $id_user = $_POST['id_user'];
    $nome = $_POST['nome'] ?? 'Aluno';

    
    $chat = $chatDao->carregarPorSolicitacao($id_solicitacao);
    console_log("chat");
    console_log($chat);

    if ($chat) {
        
        $mensagens = $mensagemDao->listarMensagensPorChat($chat['id_chat']);
        console_log("mensagens");
        console_log($mensagens);
    }
}


//criar um header caso a session não possua nada
console_log($_SESSION);
if($_SESSION['tipo'] == "personal"){
    $userPersonal = $personalDao->buscarId('id_personal', $_SESSION['id_user']);
    $solicitacoesRecebidas = $solicitacaoDAO->carregarPersonaisSol($userPersonal['id_personal'], "solicitada");
    $solicitacaoAlunoList = $solicitacaoDAO->carregarPersonaisSol($userPersonal['id_personal'], "ativa");
    console_log("solicitação aluno list:");
    console_log($solicitacaoAlunoList);
}


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BoostResult</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
         body {
            font-family: sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
            margin: 0;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .lista-personais {
            max-width: 600px;
            margin: auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            padding: 0;
            overflow: hidden;
        }

        .personal {
            display: flex;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #eee;
        }
        .alunos {
            display: flex;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        .alunos:last-child {
            border-bottom: none;
        }

        .alunos img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
        }

        .personal:last-child {
            border-bottom: none;
        }

        .personal img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
        }

        .nome {
            font-size: 18px;
            color: #333;
        }

        .mensagem {
            text-align: center;
            color: #888;
            padding: 20px;
        }
    </style>
</head>

<body>
    
    <div class="personais-panel" id="personais-panel">
        <button class="close-btn" id="close-personais-btn">X</button>
        <div class="message">
            <?php foreach($personais as $personal){ ?>
                <div class="personal" onclick="abrirModal(this.id)" id="<?=$personal['id_user']?>" value="<?=$personal['nome']?>">
                    <div class="nome"><?=$personal['nome']?></div>
                </div>

            <?php } ?>
        </div>
    </div>

    

    <div class="solicitacao-panel" id="solicitacao-panel">
        <button class="close-btn" id="close-solicitacao-btn">X</button>
        <div class="message">
            <?php if (isset($solicitacoesRecebidas) && !empty($solicitacoesRecebidas)) { ?>
                    <h3>Solicitações Recebidas</h3>
                    <?php foreach($solicitacoesRecebidas as $sol){ 
                        $alunoLog = $alunoDao->carregar($sol['id_aluno']);
                        $userAluno = $usuarioDAO->carregar($alunoLog['id_user']);
                        $nomeAluno = $userAluno['nome'];
                        console_log("sol:");
                        console_log($sol);

                    ?>
                        <div class="alunos">
                            <div class="nome"><div class="nome"><?= $nomeAluno ?></div></div>
                            <div class="nome">Status: <?=$sol['status']?></div>
                            <form action="../../app/controller/SolicitacaoController.php" method="POST">
                                <input type="hidden" name="id_solicitacao" value="<?=$sol['id_solicitacao']?>">
                                <input type="hidden" name="status" value="ativa">
                                <button class="action" type="submit" name="editar" value="editar">Aceitar</button>
                            </form>
                        </div>
                    <?php } ?>
            <?php } else { ?>
                <div class="mensagem">Nenhuma solicitação recebida.</div>
            <?php } ?>
        </div>
    </div>

    <div class="alunos-panel" id="alunos-panel">
        <button class="close-btn" id="close-alunos-btn">X</button>
        <div class="message">
            <?php foreach($solicitacaoAlunoList as $solicitacaoAluno): 
                $alunoLog = $alunoDao->carregarIdAluno($solicitacaoAluno['id_aluno']);
                $aluno = $usuarioDAO->carregar($alunoLog['id_user']);
            ?>
                <button 
                    class="alunos" 
                    data-id-solicitacao="<?= $solicitacaoAluno['id_solicitacao'] ?>" 
                    data-id-user="<?= $aluno['id_user'] ?>" 
                    data-nome="<?= htmlspecialchars($aluno['nome']) ?>"
                >
                    <div class="nome"><?= htmlspecialchars($aluno['nome']) ?></div>
                    <div class="nome"><?= htmlspecialchars($solicitacaoAluno['status']) ?></div>
                </button>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="chat-panel" id="chat-panel" style="display: none;">
        <button class="close-btn" id="close-chat-btn">X</button>
        <h2 id="receberNomeUsuario"></h2>

        <div class="chat">
            <div class="interacao-panel" id="interacao-panel">
                <div class="interacao-conteudo" id="interacao-conteudo">
                    <!-- Mensagens vão aqui via JS -->
                </div>

                <form class="interacao-input" action="../../app/controller/MensagemController.php" method="POST">
                    <input type="text" name="mensagem" placeholder="Digite sua mensagem..." required>
                    <input type="hidden" name="destinatario_id" id="destinatario_id">
                    <input type="hidden" name="solicitacao_id" id="solicitacao_id">
                    <button name="cadastrar" value="cadastrar">Enviar</button>
                </form>
            </div>
        </div>
    </div>

    <div class="sidebar">
        <ul>

            <li>Minha Conta</li>
            
                <?php

                if ($_SESSION['tipo_usuario'] == "admin") {
                    echo "<li id='alunos-btn'>Alunos</li>";
                    echo "<li id='personais-btn'>Personais</li>";
                } else {

                    if($_SESSION['tipo'] == "aluno"){
                        echo "<li id='personais-btn'>Personais</li>";
                    }else{
                        echo "<li id='alunos-btn'>Alunos</li>";
                        echo "<li id='solicitacao-btn'>Solicitações</li>";
                    }
                }

                ?>
            
            <li id="mensagens-btn">Mensagens</li>
            <li>Suporte</li>
            <form method="POST" action="../../app/controller/UsuarioController.php">
                <button type="submit" name="acao" value="DESLOGAR" id="sair">Sair</button>
            </form>
            <li>
                <button id="toggleDarkMode" class="btn btn-sm btn-dark">Modo Escuro</button>
            </li>
        </ul>
    </div>

    <div class="main">
        <div class="profile">
            <form action="../../app/controller/imagem_usuarioController.php" method="POST" enctype="multipart/form-data">
                <label for="fileUpload">
                    <div class="cover">
                        <img src="https://preview.redd.it/34mmdb3oo42d1.png?auto=webp&s=5b038c9df7e574ce5b88b9664471e7bd83fc94ca"
                            alt="Clique para enviar uma imagem" width="150" id="imgCover">
                        <span class="emoji"><img src="../../imagens/icongaleria.png" alt=""></span>
                    </div>
                </label>
                <input type="file" name="foto" accept="image/*" style="display:none;"
                    onchange="this.form.submit();">
            </form>
            <form action="../../app/controller/imagem_usuarioController.php" method="POST" enctype="multipart/form-data">
                <label for="fileUpload">
                    <div class="avatar">
                        <img src="../../view/exibir_imagem.php?id_user=<?php echo $_SESSION['id_user']; ?>" alt="Clique para enviar uma imagem" width="150" id="imgAvatar">
                            alt="Clique para enviar uma imagem" width="150" id="imgAvatar">
                        <span class="emoji"><img src="../../imagens/icongaleria.png" alt=""></span>
                    </div>
                </label>
                <input type="hidden" name="cadastrar" value="Cadastrar">
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

            <div class="button-container">
                <button onclick="loadPageAndHighlight(this, 'informacoes/treinos.php')" id="button1">Meus
                    Treinos</button>
                <button onclick="loadPageAndHighlight(this, 'informacoes/medidas.php')" id="button2">Medidas</button>
                <button onclick="loadPageAndHighlight(this, 'informacoes/dados.php')" id="button3">Dados
                    Pessoais</button>
                <div id="underline-indicator"></div>
            </div>

        </div>
    </div>

    <div class="right-sidebar">
        <div class="Users">
            <br>
            <h3>Personais Em Destaque</h3>
            <br>
            <div class="user">
                <img src="https://pbs.twimg.com/profile_images/875391618634977280/-UYcaL0-_400x400.jpg" alt="">
                <span>LUAN PINTO</span>
                <button>Perfil</button>
            </div>
            <?php foreach($personais as $personal){ ?>
                <div class="user">
                    <img src="https://pbs.twimg.com/profile_images/875391618634977280/-UYcaL0-_400x400.jpg" alt="">
                    <span><?=$personal['nome']?></span>
                    <?php if($_SESSION['tipo'] == 'aluno'){ 
                        $personalLog = $personalDao->carregar($personal['id_user']);
                        console_log("array personal:");
                        console_log($personalLog);
                        $alunoLog = $alunoDao->buscar('id_user', $_SESSION['id_user']);
                        
                        console_log("id_aluno:");
                        console_log($alunoLog);
                    ?> 
                        <form action="../../app/controller/SolicitacaoController.php" method="POST">
                            <input type="hidden" name="id_personal" value="<?=$personalLog['id_personal'] ?>">
                            <input type="hidden" name="id_aluno" value="<?=$alunoLog['id_aluno'] ?>">
                            <input type="hidden" name="status" value="solicitada">
                            <button type="submit" name="cadastrar" value="cadastrar">Solicitar</button>
                        </form>
                    <?php } ?>
                </div>
            <?php } ?>
            
                
                
            
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalExemplo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Mudar Descrição</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="../../app/controller/UsuarioController.php" method="POST">
                        <label for="descricao">Descrição</label><br>
                        <textarea id="descricao" name="descricao" autofocus></textarea><br><br>
                        <button type="submit" name="acao" value="ATUALIZAR"
                            class="secondary btn-sm border-0">Atualizar</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
    crossorigin="anonymous"></script>
<script src="script.js">
</script>

</html>
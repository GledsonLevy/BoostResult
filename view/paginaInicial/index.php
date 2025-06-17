<?php
session_start();
include("../../app/conexao/Conexao.php");
include("../../app/dao/UsuarioDAO.php");
include("../../app/model/Usuario.php");

$usuarioDAO = new UsuarioDAO();
$alunos = $usuarioDAO->buscarTipo('aluno');
$personais = $usuarioDAO->buscarTipo('personal');


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
    <div class="mensagens-panel" id="mensagens-panel">
        <button class="close-btn" id="close-mensagens-btn">X</button>
        <h2>Mensagens</h2>
        <div class="message">
            <button class="messageButton" id="chat-btn">
            </button>
        </div>
    </div>

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

    <div class="alunos-panel" id="alunos-panel">
        <button class="close-btn" id="close-alunos-btn">X</button>
        <div class="message">
            <?php foreach($alunos as $aluno){ ?>
                <div class="alunos" onclick="abrirModal(this.id)" id="<?=$aluno['id_user']?>" value="<?=$aluno['nome']?>">
                    <div class="nome"><?=$aluno['nome']?></div>
                </div>

            <?php } ?>
        </div>
    </div>

    <div class="chat-panel" id="chat-panel">
        <button class="close-btn" id="close-chat-btn">X</button>
        <h2 id="receberNomeUsuario"></h2>
        <div class="chat">
            <div class="interacao-panel" id="interacao-panel">
                <div class="interacao-conteudo" id="interacao-conteudo">
                    </div>
                <form class="interacao-input" action="../../app/controller/MensagemController.php"
                    method="POST">
                    <input type="text" id="mensagem" name="mensagem" placeholder="Digite sua mensagem...">
                    <input type="text" id="destinatario_id" name="destinatario_id" value="<?=$aluno['id_user']?>">
                    <button id="enviar-msg" name="acao" value="INSERIR">Enviar</button>
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

                    echo ($_SESSION['tipo'] == "aluno") ? "<li id='personais-btn'>Personais</li>" : "<li id='alunos-btn'>Alunos</li>";
                }

                ?>
            
            <li id="mensagens-btn">Mensagens</li>
            <li>Suporte</li>
            <form method="post" action="../../app/controller/UsuarioController.php">
                <button type="submit" name="acao" value="DESLOGAR" id="sair">Sair</button>
            </form>
            <li>
                <button id="toggleDarkMode" class="btn btn-sm btn-dark">Modo Escuro</button>
            </li>
        </ul>
    </div>

    <div class="main">
        <div class="profile">
            <form action="../../app/controller/imagem_usuarioController.php" method="post"
                enctype="multipart/form-data">
                <label for="fileUpload">
                    <div class="cover">
                        <img src="https://preview.redd.it/34mmdb3oo42d1.png?auto=webp&s=5b038c9df7e574ce5b88b9664471e7bd83fc94ca"
                            alt="Clique para enviar uma imagem" width="150" id="imgCover">
                        <span class="emoji"><img src="../../imagens/icongaleria.png" alt=""></span>
                    </div>
                </label>
                <input type="file" id="fileUpload" name="foto" accept="image/*" style="display:none;"
                    onchange="this.form.submit();">
            </form>
            <form action="../../app/controller/imagem_usuarioController.php" method="post"
                enctype="multipart/form-data">
                <label for="fileUpload">
                    <div class="avatar">
                        <img src="https://dimensaosete.com.br/static/7fc311549694666167a49cdb0fb1293c/2493a/gojo.webp"
                            alt="Clique para enviar uma imagem" width="150" id="imgAvatar">
                        <span class="emoji"><img src="../../imagens/icongaleria.png" alt=""></span>
                    </div>
                </label>
                <input type="file" id="fileUpload" name="foto" accept="image/*" style="display:none;"
                    onchange="this.form.submit();">
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
            <div class="user">
                <img src="https://pbs.twimg.com/profile_images/875391618634977280/-UYcaL0-_400x400.jpg" alt="">
                <span>LUISAO</span>
                <button>Perfil</button>
            </div>
            <div class="user">
                <img src="https://pbs.twimg.com/profile_images/875391618634977280/-UYcaL0-_400x400.jpg" alt="">
                <span>DAVI</span>
                <button>Perfil</button>
            </div>
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
<script src="script.js"></script>

</html>
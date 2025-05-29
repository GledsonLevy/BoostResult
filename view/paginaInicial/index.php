<?php
session_start();
if (!isset($_SESSION['nome']) || !isset($_SESSION['tipo'])) {
    header("Location: ../../index.php");
    exit();
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
    
</head>

<body>
    <div class="mensagens-panel" id="mensagens-panel">
        <button class="close-btn" id="close-mensagens-btn">X</button>
        <h2>Mensagens</h2>
        <div class="message">
            <button class="messageButton" id="chat-btn">
                <img src="imagem.jpg" alt="">
                <div class="sender">Luan Pinto</div>
                <div class="text">Oi, como você está?</div>
            </button>
        </div>
    </div>

    <div class="personais-panel" id="personais-panel">
        <button class="close-btn" id="close-mensagens-btn">X</button>
        <div class="message">
            <iframe src="personais/personais.php" frameborder="0"></iframe>
        </div>
    </div>

    <div class="chat-panel" id="chat-panel">
        <button class="close-btn" id="close-chat-btn">X</button>
        <h2>Chat</h2>
        <div class="chat">
            funcionando
        </div>
    </div>
    <div class="sidebar">
        <ul>

            <li>Minha Conta</li>
            <li>
                <?php

                if ($_SESSION['tipo_usuario'] == "admin") {
                    echo 'Alunos';
                    echo "<li id='personais-btn'>Personais</li>";
                } else {

                    echo ($_SESSION['tipo'] == "aluno") ? "<li id='personais-btn'>Personais</li>" : 'Alunos';
                }

                ?>
            </li>
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

            <iframe id="myIframe" src="https://www.example.com"></iframe>
        </div>
    </div>

    <div class="right-sidebar">
        <div class="Users">
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Pesquisar..." />
                <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
                </svg>
            </div>
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
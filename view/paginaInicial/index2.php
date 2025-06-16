<?php
session_start();
$destinatario = 22;
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
                <button class="btn-content" data-target="#treinos">Meus Treinos</button>
                <button class="btn-content" data-target="#medidas">Medidas</button>
                <button class="btn-content" data-target="#dados">Dados Pessoais</button>
                <div id="underline-indicator"></div>
            </div>

            <div id="conteudo-principal" style="margin-top:20px;">
                <div id="treinos" class="content-tab">
                    <h3>Meus Treinos</h3>
                    <p>Aqui vão as informações de treinos...</p>
                </div>
                <div id="medidas" class="content-tab" style="display:none;">
                    <h3>Medidas</h3>
                    <p>Aqui vão as informações de medidas...</p>
                </div>
                <div id="dados" class="content-tab" style="display:none;">
                    <h3>Dados Pessoais</h3>
                    <p>Aqui vão os dados pessoais do usuário...</p>
                </div>
            </div>

        </div>
    </div>

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

<script>
    $(document).ready(function(){
        $('.btn-content').click(function(){
            var target = $(this).data('target');
    
            
            $('.content-tab').hide();
    
           
            $(target).show();
    

            $('.btn-content').removeClass('active');
            $(this).addClass('active');
    
            var pos = $(this).position();
            $('#underline-indicator').css({left: pos.left, width: $(this).outerWidth()});
        });
    
        $('.btn-content').first().click();
    });
</script>

</html>
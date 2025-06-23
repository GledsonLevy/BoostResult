<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro do Cliente</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="dados">
        <h2>Dados Cadastrais</h2>
        <div class="bio-item"><span class="label">Nome:</span> <?php echo $_SESSION['nome_completo']; ?></div>
        <div class="bio-item"><span class="label">Gênero:</span> <?php echo $_SESSION['genero']; ?></div>
        <div class="bio-item"><span class="label">CPF:</span> <?php echo $_SESSION['cpf']; ?></div>
        <div class="bio-item"><span class="label">RG:</span> <?php echo $_SESSION['rg']; ?></div>
        <button type="button" class="secondary btn-sm border-0" data-toggle="modal" data-target="#modalExemplo" id="botaoBio">
            Modificar
        </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalExemplo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-container">
                        <h2>Atualizar Cadastro</h2>
                        <form method="post" action="../../app/controller/ClienteController.php">
                            <label>Nome Completo:</label>
                            <input type="text" name="nome_completo" placeholder="Ex: João da Silva">

                            <label>Gênero:</label>
                            <select name="genero">
                                <option value="">Selecione</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Feminino">Feminino</option>
                                <option value="Outro">Outro</option>
                            </select>

                            <label>CPF:</label>
                            <input type="text" name="cpf" placeholder="Ex: 000.000.000-00">

                            <label>RG:</label>
                            <input type="text" name="rg" placeholder="Ex: 12.345.678-9">

                            <button type="submit" name="acao" value="CADASTRAR">Salvar</button>
                        </form>
                    </div>
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
</html>

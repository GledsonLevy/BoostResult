<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Dados</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="bio-container">
    <h2>Informações Físicas</h2>
    <div class="bio-item"><span class="label">Altura:</span> <?php echo $_SESSION['altura']; ?> m</div>
    <div class="bio-item"><span class="label">Peso:</span> <?php echo $_SESSION['peso']; ?> kg</div>
    <div class="bio-item"><span class="label">IMC:</span> <?php echo $_SESSION['imc']; ?></div>
    <div class="bio-item"><span class="label">Última Atualização:</span> <?php echo $_SESSION['data_dados']; ?></div>
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
                    <div class="form-container">
                        <h2>Adicione seus dados</h2>
                        <form method="post" action="../../app/controller/Registro_dadoController.php">
                            <label>Altura (em metros):</label>
                            <input type="text" name="altura" required placeholder="Ex: 1.75">

                            <label>Peso (kg):</label>
                            <input type="text" name="peso" required placeholder="Ex: 70.5">

                            <label>IMC:</label>
                            <input type="text" name="imc" required placeholder="Ex: 23.0">

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
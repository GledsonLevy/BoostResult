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

        <?php
            $campos = ['nome_completo', 'genero', 'cpf', 'rg'];
            $temTodosOsDados = true;

            foreach ($campos as $campo) {
                if (empty($_SESSION[$campo])) {
                    $temTodosOsDados = false;
                    break;
                }
            }

            if ($temTodosOsDados):
        ?>
            <div class="bio-item"><span class="label">Nome:</span> <?php echo $_SESSION['nome_completo']; ?></div>
            <div class="bio-item"><span class="label">Gênero:</span> <?php echo $_SESSION['genero']; ?></div>
            <div class="bio-item"><span class="label">CPF:</span> <?php echo $_SESSION['cpf']; ?></div>
            <div class="bio-item"><span class="label">RG:</span> <?php echo $_SESSION['rg']; ?></div>
        <?php else: ?>
            <div class="alert alert-warning">
                Algumas informações estão faltando. Por favor, clique em "Modificar" para completar seus dados.
            </div>
        <?php endif; ?>

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

                            <label>CPF:</label>
                            <input type="text" name="cpf" id="cpf" placeholder="Ex: 000.000.000-00" maxlength="14">

                            <label>RG:</label>
                            <input type="text" name="rg" id="rg" placeholder="Ex: 12.345.678-9" maxlength="12   ">

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


    <script>
    function aplicarMascaraCPF(cpf) {
        cpf = cpf.replace(/\D/g, ''); // Remove tudo que não for número
        cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
        cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
        cpf = cpf.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        return cpf;
    }

    function aplicarMascaraRG(rg) {
        rg = rg.replace(/\D/g, '');
        rg = rg.replace(/(\d{2})(\d)/, '$1.$2');
        rg = rg.replace(/(\d{3})(\d)/, '$1.$2');
        rg = rg.replace(/(\d{3})(\d{1})$/, '$1-$2');
        return rg;
    }

    document.getElementById('cpf').addEventListener('input', function () {
        this.value = aplicarMascaraCPF(this.value);
    });

    document.getElementById('rg').addEventListener('input', function () {
        this.value = aplicarMascaraRG(this.value);
    });
</script>

</html>

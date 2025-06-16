<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" type="text/css" href="css/muli-font.css">
    <link rel="stylesheet" type="text/css" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="css/style.css"/>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <?php
        session_start();
        $mensagem = '';

        if (!empty($_SESSION['erro_login'])) {
            $mensagem = $_SESSION['erro_login'];
            unset($_SESSION['erro_login']);
        }
    ?>

    <div id="particles-js"></div>

    <!-- scripts -->
    <script src="../../particles.js-master/particles.js"></script>
    <script src="../../particles.js-master/demo/js/app.js"></script>

    <!-- stats.js -->
    <script src="../../particles.js-master/demo/js/lib/stats.js"></script>
    <script>
    var count_particles, stats, update;
    stats = new Stats;
    stats.setMode(0);
    stats.domElement.style.position = 'absolute';
    stats.domElement.style.left = '0px';
    stats.domElement.style.top = '0px';
    document.body.appendChild(stats.domElement);
    count_particles = document.querySelector('.js-count-particles');
    update = function() {
        stats.begin();
        stats.end();
        if (window.pJSDom[0].pJS.particles && window.pJSDom[0].pJS.particles.array) {
        count_particles.innerText = window.pJSDom[0].pJS.particles.array.length;
        }
        requestAnimationFrame(update);
    };
    requestAnimationFrame(update);
    </script>

<div class="page-content">

        <div id="alert-msg" class="alert alert-warning alert-dismissible position-fixed start-50 translate-middle-x" style="top: 10%; display: none; z-index: 1055;" role="alert">
            <strong>Error!</strong> 
            <button id="closeAlert" type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    
        <div class="wizard-v2-content">
            <div id="autoCarousel" class="carousel slide col-md-6 d-none d-md-block" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active wizard-image" data-bs-interval="10000" style="background: url('https://i.pinimg.com/736x/05/e9/bc/05e9bc4d1609cdbd2a1211d13b43d63f.jpg') center center no-repeat;"></div>
                    <div class="carousel-item wizard-image " data-bs-interval="10000" style="background: url('https://i.pinimg.com/736x/40/3e/ef/403eef5689cce38dab70baeba696566b.jpg') center center no-repeat;"></div>
                    <div class="carousel-item wizard-image" data-bs-interval="10000" style="background: url('https://i.pinimg.com/736x/b9/7c/87/b97c8775fb72f6cb9964ce41a0997d62.jpg') center center no-repeat;"></div>
                </div>
            </div>
            
            <div class="wizard-form col-12 col-md-6">
    
                <div class="wizard-header">
                    <h3>Log in</h3>
                    <p>Acesse sua conta em nossa plataforma.</p>
                </div>
                <form id="formCadastro" class="form-register" action="../../app/controller/UsuarioController.php" method="POST">
                    <div id="form-total">

                        <section id="session" class="session">
                            <div class="inner">
                                <div class="form-row">
                                    <div  class="form-holder form-holder-2">
                                        <input type="email" placeholder="Email" name="email" class="form-control" id="email">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-holder form-holder-2">
                                        <input type="password" placeholder="Senha" name="senha" class="form-control" id="senha">
                                        <button type="button"
                                        class="btn btn-sm btn-outline-secondary toggle-password"
                                        data-target="senha"
                                        style="position:absolute; right:10px; top:50%; transform:translateY(-50%); z-index: 2;">👁</button>
                                    </div>
                                </div>
                                
                            </div>
                        </section>   
                        <div class="actions clearfix form-row">
                            <ul role="menu" aria-label="Pagination" class="form-holder">
                                <li id="botaoNext" aria-hidden="false" aria-disabled="false"><a href="#next"
                                        role="menuitem">Próxima</a></li>
                                <li id="botaoFinish" class="buttonaction" aria-hidden="true" style="display: none;"><a
                                        href="#finish" role="menuitem">Logar</a></li>
                                <input type="hidden" name="acao" value="LOGAR">
                                </ul>
                                <a href="../cadastro/index.php" class="form-holder link-redir">Não possui uma conta?</a>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>

</div>

<!-- SCRIPTS -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/jquery.steps.js"></script>
<script src="js/jquery-ui.min.js"></script>

<script>
    var itemAtual = 1;
    let contError = 0;

    
    function showErrorMsg($input, mensagem, tipo) {
        const $alertMsg = $('#alert-msg');

        if ($input != null) {
            clearErrorMsg($input);
            if (tipo === 'danger') {
                $input.addClass('error-input');
            }
        }

        let titulo;
        $alertMsg.removeClass('alert-success alert-danger alert-warning alert-info');
        $alertMsg.addClass(`alert alert-${tipo}`);

        if (contError > 1) {
            $alertMsg.html(`<strong>Atenção:</strong> Verifique os dados do formulário!`);
        } else {
            titulo = tipo === 'success' ? 'Sucesso!' :
                     tipo === 'danger' ? 'Atenção!' :
                     tipo === 'info' ? 'Informação:' : 'Atenção!';
            $alertMsg.html(`<strong>${titulo}</strong> ${mensagem}`);
        }

        $alertMsg.fadeIn();
        setTimeout(() => {
            $alertMsg.fadeOut();
            contError = 0;
        }, 4000);
    }

    function clearErrorMsg($input) {
        $input.removeClass('error-input');
    }

    $(document).ready(function () {
        const $alertMsg = $('#alert-msg');

        
        var mensagem = <?php echo json_encode($mensagem); ?>;

        
        if (mensagem != '') {
            console.log("Tipo da mensagem:", typeof mensagem);
            console.log("Conteúdo exato:", mensagem);
            console.log("Length:", mensagem.length);
            showErrorMsg(null, mensagem, 'danger');
        }

        $('#botaoFinish').on('click', function () {
            if (validarCampos()) {
                $('#formCadastro').submit();
            }
        });

        $('#botaoFinish').show();

        $('.toggle-password').on('click', function () {
            const targetId = $(this).data('target');
            const $input = $('#' + targetId);
            const tipoAtual = $input.attr('type');
            $input.attr('type', tipoAtual === 'password' ? 'text' : 'password');
        });

        function validarCampos() {
            let valido = true;
            const $email = $('#email');
            const $senha = $('#senha');

            clearErrorMsg($email);
            clearErrorMsg($senha);

            if (!$email.val().trim()) {
                contError++;
                showErrorMsg($email, 'Digite um valor válido', 'danger');
                valido = false;
            } else if (!/^\S+@\S+\.\S+$/.test($email.val())) {
                contError++;
                showErrorMsg($email, 'Formato de email inválido', 'danger');
                valido = false;
            }

            if (!$senha.val()) {
                contError++;
                showErrorMsg($senha, 'Senha é obrigatória', 'danger');
                valido = false;
            } else if ($senha.val().length < 6) {
                contError++;
                showErrorMsg($senha, 'Senha deve ter pelo menos 6 caracteres', 'danger');
                valido = false;
            }

            return valido;
        }
    });
</script>


	

</body>
</html>

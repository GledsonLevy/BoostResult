<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Cadastro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" type="text/css" href="css/muli-font.css">
    <link rel="stylesheet" type="text/css"
        href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="css/style.css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>



<body>

   <?php
        session_start();
        $mensagem = '';

        if (!empty($_SESSION['erro_cadastro'])) {
            $mensagem = $_SESSION['erro_cadastro'];
            unset($_SESSION['erro_cadastro']);
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
        update = function () {
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

        <div id="alert-msg" class="alert alert-warning alert-dismissible position-fixed start-50 translate-middle-x hidden" style="top: 10%; display: none; z-index: 1055;" role="alert">
            <strong>Error!</strong> 
            <button id="closeAlert" type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="wizard-v2-content">

            <div id="autoCarousel" class="carousel slide col-md-6 d-none d-md-block" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active wizard-image" data-bs-interval="10000"
                        style="background: url('https://i.pinimg.com/736x/05/e9/bc/05e9bc4d1609cdbd2a1211d13b43d63f.jpg') center center no-repeat;">
                    </div>
                    <div class="carousel-item wizard-image " data-bs-interval="10000"
                        style="background: url('https://i.pinimg.com/736x/40/3e/ef/403eef5689cce38dab70baeba696566b.jpg') center center no-repeat;">
                    </div>
                    <div class="carousel-item wizard-image" data-bs-interval="10000"
                        style="background: url('https://i.pinimg.com/736x/b9/7c/87/b97c8775fb72f6cb9964ce41a0997d62.jpg') center center no-repeat;">
                    </div>
                </div>
            </div>

            <div class="wizard-form col-12 col-md-6">

                <div class="wizard-header">
                    <h3>Cadastro</h3>
                    <p>Tenha um perfil em nossa plataforma.</p>
                </div>
                <form id="formCadastro" class="form-register" action="../../app/controller/UsuarioController.php"
                    method="POST">
                    <div class="steps clearfix">
                        <ul role="tablist" class="tabletitle">
                            <li id="num1" role="tab" class="first" aria-disabled="false" aria-selected="true">
                                <a id="form-total-t-0" href="#form-total-h-0" aria-controls="form-total-p-0"
                                    class="tabletitle navbutton">
                                    <span class="number">1</span>
                                </a>
                            </li>
                            <li id="num2" role="tab" class="" aria-disabled="true">
                                <a id="form-total-t-1" href="#form-total-h-1" aria-controls="form-total-p-1"
                                    class="tabletitle navbutton">
                                    <span class="number">2</span>
                                </a>
                            </li>
                            <li id="num3" role="tab" class="last" aria-disabled="true">
                                <a id="form-total-t-2" href="#form-total-h-2" aria-controls="form-total-p-2"
                                    class="tabletitle navbutton">
                                    <span class="number">3</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div id="form-total">

                        <section id="session1" class="session">
                            <div class="inner">
                                <div class="form-row">
                                    <div class="form-holder form-holder-2">
                                        <input type="text" placeholder="Nome" name="nome" class="form-control"
                                            id="nome">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-holder">
                                        <input type="date" placeholder="Data de Nascimento" name="idade" id="data">
                                    </div>
                                    <div class="form-holder">
                                        <select name="sexo" id="sexo" class="form-control">
                                            <option value="" selected disabled style="display:none;">Sexo</option>
                                            <option value="masculino">Masculino</option>
                                            <option value="feminino">Feminino</option>
                                            <option value="pnd">Prefiro não dizer</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </section>


                        <section id="session2" class="session">
                            <div class="inner">
                                <div class="form-row">
                                    <div class="form-holder">
                                        <input type="email" placeholder="Email" name="email" class="form-control"
                                            id="email">
                                    </div>
                                    <div class="form-holder">
                                        <input type="tel" placeholder="Telefone" name="telefone" class="form-control"
                                            id="telefone" maxlength="15">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-holder position-relative">
                                        <div class="input-group-container" style="position: relative;">
                                            <input type="password" name="senha" id="senha" class="form-control"
                                                style="padding-right: 40px;" placeholder="Senha">
                                            <button type="button"
                                                class="btn btn-sm btn-outline-secondary toggle-password"
                                                data-target="senha"
                                                style="position:absolute; right:10px; top:50%; transform:translateY(-50%);">👁</button>
                                        </div>

                                    </div>
                                    <div class="form-holder position-relative">
                                        <div class="input-group-container" style="position: relative;">
                                            <input type="password" placeholder="Confirmar Senha" class="form-control"
                                                id="confirmar-senha" style="padding-right: 40px;">
                                            <button type="button"
                                                class="btn btn-sm btn-outline-secondary toggle-password"
                                                data-target="confirmar-senha"
                                                style="position:absolute; right:10px; top:50%; transform:translateY(-50%); z-index: 2;">👁</button>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </section>

                        <div class="session-wrapper">

                            <section id="session3" class="session session-inner">
                                <div class="inner">
                                    <div class="form-row">
                                        <div class="form-holder option-select ">
                                            <label class="option active" id="aluno-option">
                                                <input type="radio" name="tipo" value="aluno" checked />
                                                Aluno
                                            </label>
                                        </div>
                                        <div class="form-holder option-select">
                                            <label class="option" id="personal-option">
                                                <input type="radio" name="tipo" value="personal" />
                                                Personal
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </section>

                        </div>


                    </div>
                    </section>

                    <section id="session4" class="session session-inner hidden">
                        <div class="inner">
                            <span class="modal-close" id="modal-close">&times;</span>
                            <div class="drag-handle">Dados necessários</div>

                            <div class="form-row">
                                <div class="form-holder form-holder-2">
                                    <input type="text" placeholder="Certificação(CREF) 000000-G/UF " name="certificacao"
                                        class="form-control" id="certificacao">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-holder">
                                    <input type="text" placeholder="Especialidade(Opcional)" name="especialidade"
                                        class="form-control" id="especialidade">
                                </div>
                                <li id="modal-btn" class="form-holder button-model buttonaction btn d-flex"
                                    aria-hidden="false" aria-disabled="false"><a href="#next" role="menuitem">Avançar
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                                        </svg></a></li>
                            </div>

                        </div>
                    </section>
                    <div class="actions clearfix form-row">

                        <ul role="menu" aria-label="Pagination" class="form-holder">
                            <li id="botaoNext" aria-hidden="false" aria-disabled="false"><a href="#next"
                                    role="menuitem">Próximo</a></li>
                            <li id="botaoFinish" class="buttonaction" aria-hidden="true" style="display: none;"><a
                                    href="#finish" role="menuitem">Cadastrar</a></li>
                            <input type="hidden" name="acao" value="CADASTRAR">
                        </ul>
                        <a href="../login/index.php"  class="form-holder link-redir">Já possui uma conta? Entre já.</a>
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
    
    let contError = 0;

    function showErrorMsg($input, mensagem, tipo) {
        const $alertMsg = $('#alert-msg');

        if ($input != null) {
            clearErrorMsg($input);
            if (tipo === 'danger') {
                $input.addClass('error-input');
            }
        }

        let titulo = tipo === 'success' ? 'Sucesso!' :
                     tipo === 'danger' ? 'Atenção!' :
                     tipo === 'info' ? 'Informação:' :
                     'Atenção!';

        $alertMsg.removeClass('alert-success alert-danger alert-warning alert-info');
        $alertMsg.addClass(`alert alert-${tipo}`);

        if (contError > 1) {
            $alertMsg.html(`<strong>Atenção:</strong> Verifique os dados do formulário!`);
        } else {
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
        
        const $telefone = $('#telefone');
        const $alertMsg = $('#alert-msg');
        const $modalClose = $('#modal-close');
        const $modalBtn = $('#modal-btn');

        let itemAtual = 1;
        contError = 0;

        $alertMsg.hide();
        $('#session4').hide();

        
        var mensagem = <?php echo json_encode($mensagem); ?>;
        if (mensagem != '') {
            showErrorMsg(null, mensagem, 'danger');
        }

        
        $telefone.on('input', function () {
            let v = $(this).val().replace(/\D/g, '');
            if (v.length > 11) v = v.slice(0, 11);
            if (v.length > 6) {
                $(this).val(`(${v.slice(0, 2)}) ${v.slice(2, 7)}-${v.slice(7)}`);
            } else if (v.length > 2) {
                $(this).val(`(${v.slice(0, 2)}) ${v.slice(2)}`);
            } else if (v.length > 0) {
                $(this).val(`(${v}`);
            }
        });

        
        $modalClose.on('click', function () {
            $('#session4').hide();
            $('input[value="aluno"]').prop('checked', true).closest('label').addClass('active');
            $('input[value="personal"]').closest('label').removeClass('active');
        });

        $modalBtn.on('click', function () {
            if (validarCamposEtapa4()) {
                $('#session4').hide();
            }
        });

      
        function mudarPaginacao() {
            switch (itemAtual) {
                case 1:
                    $('#num1').addClass('current');
                    $('#num2, #num3').removeClass('current');
                    $('#session1').show();
                    $('#session2, #session3, #session4').hide();
                    $('#botaoFinish').hide();
                    $('#botaoNext').show();
                    break;

                case 2:
                    if (!validarCamposEtapa1()) {
                        itemAtual = 1;
                        return;
                    }
                    $('#num2').addClass('current');
                    $('#num1, #num3').removeClass('current');
                    $('#session2').show();
                    $('#session1, #session3, #session4').hide();
                    $('#botaoFinish').hide();
                    $('#botaoNext').show();
                    break;

                case 3:
                    if (!validarCamposEtapa2()) {
                        itemAtual = 2;
                        return;
                    }
                    $('#num3').addClass('current');
                    $('#num1, #num2').removeClass('current');

                    if ($('input[name="tipo"]:checked').val() === 'personal') {
                        $('#session4').css('display', 'flex');
                    } else {
                        $('#session4').hide();
                    }

                    $('#session3').show();
                    $('#session1, #session2').hide();
                    $('#botaoFinish').show();
                    $('#botaoNext').hide();
                    break;
            }
        }

        mudarPaginacao();

       
        $('#botaoNext').on('click', function () {
            itemAtual++;
            mudarPaginacao();
        });

        $('#botaoFinish').on('click', function () {
            $('#session3').show();
            if (validarCamposEtapa3()) {
                $('#formCadastro').submit();
            }
        });

        $('.navbutton').on('click', function () {
            itemAtual = parseInt($(this).find('.number').text());
            mudarPaginacao();
        });


        $('.toggle-password').on('click', function () {
            const targetId = $(this).data('target');
            const $input = $('#' + targetId);
            const tipoAtual = $input.attr('type');
            $input.attr('type', tipoAtual === 'password' ? 'text' : 'password');
        });

     
        $('.option').on('click', function () {
            $('.option').removeClass('active');
            $(this).addClass('active');
            $(this).find('input').prop('checked', true);

            const tipoSelecionado = $(this).find('input').val();
            if (tipoSelecionado === 'aluno') {
                $('#session4').hide();
            } else if (tipoSelecionado === 'personal' && itemAtual === 3) {
                $('#session4').css('display', 'flex');
            }
        });

        function calculateAge(dateString) {
            const today = new Date();
            const birthDate = new Date(dateString);
            let age = today.getFullYear() - birthDate.getFullYear();
            const m = today.getMonth() - birthDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            return age;
        }

        function validarCamposEtapa1() {
            let valido = true;
            const $nome = $('#nome');
            const $data_nasc = $('#data');
            const $sexo = $('#sexo');

            clearErrorMsg($nome);
            clearErrorMsg($data_nasc);
            clearErrorMsg($sexo);

            if (!$nome.val().trim()) {
                contError++;
                showErrorMsg($nome, 'Nome é obrigatório', 'danger');
                valido = false;
            }

            if (!$data_nasc.val()) {
                contError++;
                showErrorMsg($data_nasc, 'Data inválida', 'danger');
                valido = false;
            } else {
                const age = calculateAge($data_nasc.val());
                if (age < 5 || age > 120) {
                    contError++;
                    showErrorMsg($data_nasc, 'Idade inválida', 'danger');
                    valido = false;
                }
            }

            if (!$sexo.val()) {
                contError++;
                showErrorMsg($sexo, 'Selecione uma opção', 'danger');
                valido = false;
            }

            return valido;
        }

        function validarCamposEtapa2() {
            let valido = true;
            const $email = $('#email');
            const $senha = $('#senha');
            const $confirmarSenha = $('#confirmar-senha');

            clearErrorMsg($email);
            clearErrorMsg($telefone);
            clearErrorMsg($senha);
            clearErrorMsg($confirmarSenha);

            if (!$email.val().trim()) {
                contError++;
                showErrorMsg($email, 'Email é obrigatório', 'danger');
                valido = false;
            } else if (!/^\S+@\S+\.\S+$/.test($email.val())) {
                contError++;
                showErrorMsg($email, 'Formato de email inválido', 'danger');
                valido = false;
            }

            if (!$telefone.val().trim()) {
                contError++;
                showErrorMsg($telefone, 'Telefone é obrigatório', 'danger');
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

            if (!$confirmarSenha.val()) {
                contError++;
                showErrorMsg($confirmarSenha, 'Confirmação de senha é obrigatória', 'danger');
                valido = false;
            } else if ($senha.val() !== $confirmarSenha.val()) {
                contError++;
                showErrorMsg($confirmarSenha, 'As senhas não coincidem', 'danger');
                valido = false;
            }

            return valido;
        }

        function validarCamposEtapa3() {
            const tipoSelecionado = $('input[name="tipo"]:checked').val();
            if (tipoSelecionado === 'personal') {
                return validarCamposEtapa4();
            }
            return true;
        }

        function validarCamposEtapa4() {
            let valido = true;
            const $certificacao = $('#certificacao');
            clearErrorMsg($certificacao);

            const regexCREF = /^\d{4,6}-[A-Z]\/[A-Z]{2}$/;

            if (!$certificacao.val().trim()) {
                contError++;
                showErrorMsg($certificacao, 'Certificação (CREF) é obrigatória', 'danger');
                valido = false;
            } else if (!regexCREF.test($certificacao.val().trim())) {
                contError++;
                showErrorMsg($certificacao, 'Formato inválido. Exemplo: 123456-G/SP', 'danger');
                valido = false;
            }

            return valido;
        }
    });
</script>

    




</body>

</html>
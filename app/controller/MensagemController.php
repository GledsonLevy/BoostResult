<?php   
    session_start();
    
    include_once "../conexao/Conexao.php";
    include_once "../model/Mensagem.php";
    include_once "../dao/MensagemDAO.php";


    $mensagem = new Mensagem();
    $mensagemDAO	= new MensagemDAO();


    $m= filter_input_array(INPUT_POST);

    // Verifica se pesquisaram alguma coisa.
    if(isset($_GET['pesquisa'])&&!empty($_GET['pesquisa'])){
      $mensagems = $mensagemDAO->buscar("id_msg",$_GET['pesquisa']);  
    }
    else{
      $mensagems = $mensagemDAO->listarTodos(); 
    }



    if (isset($_POST['acao']) && $_POST['acao'] == "INSERIR") {
    // Pegando o texto da mensagem (do POST via JS)
    $textoMensagem = filter_var($_POST['texto'] ?? '', FILTER_SANITIZE_STRING);

    // Pegando o ID do destinatário (do POST via JS)
    $destinatario = filter_var($_POST['destinatario'] ?? '', FILTER_SANITIZE_NUMBER_INT);

    // Pegando o ID do chat (se ele também for enviado via POST pelo JS ou de outra fonte)
    // Se o id_chat for de um campo oculto, pegue ele do $_POST também.
    // Ex: <input type="hidden" id="chat-id-hidden" value="<?php echo $id_chat_php;

    // Pegando o remetente da sessão (usuário logado)
    $remetente = $_SESSION['id_user'] ?? '';

    // Validações básicas:
    if (empty($remetente) || empty($destinatario) || empty($textoMensagem)) {
        // Redireciona com erro se algum dado essencial estiver faltando
        header("Location: ../../mensagem.php?msg=erro_dados_faltando");
        exit();
    }

    // Atribuindo os valores ao objeto Mensagem
    // id_msg: Se for auto-incrementável no BD, não precisa setar.
    // $mensagem->setId_msg(null); // Ou um ID gerado

    $mensagem->setRemetente($remetente);
    $mensagem->setDestinatario($destinatario);
    $mensagem->setTexto($textoMensagem);
    $mensagem->setData(date('Y-m-d H:i:s')); // Data e hora atuais (definida no PHP)

    // Chamando o DAO para inserir
    if ($mensagemDAO->inserir($mensagem)) {
        // Sucesso na inserção
        header("Location: ../../mensagem.php?msg=adicionado");
        exit();
    } else {
        // Erro na inserção
        header("Location: ../../mensagem.php?msg=erro_insercao");
        exit();
    }
}
    // se a requisição for editar
    else if(isset($_POST['editar'])){

        $mensagem->setId_msg($m['id_msg']); 

		$mensagem->setId_chat($m['id_chat']); 

		$mensagem->setRemetente($m['remetente']); 

		$mensagem->setTexto($m['texto']); 

		$mensagem->setData($m['data']);
        $mensagemDAO->atualizar($mensagem);

        header("Location: ../../mensagem.php?msg=editado");
    }
    // se a requisição for deletar
    else if(isset($_GET['deletar'])){

        $mensagem->setId_msg($_GET['deletar']);

        $mensagemDAO->deletar($mensagem);

        header("Location: ../../mensagem.php?msg=apagado");
    }else{
        header("Location: ../../mensagem.php?msg=erro");
    }

   
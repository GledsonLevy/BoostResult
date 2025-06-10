<?php   
    session_start();
    
    include_once "../conexao/Conexao.php";
    include_once "../model/Mensagem.php";
    include_once "../dao/MensagemDAO.php";


    $mensagem = new Mensagem();
    $mensagemDAO	= new MensagemDAO();

    header('Content-Type: application/json');
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
    // Pegando o ID do remetente
    $remetente = $_SESSION['id_user'] ?? null;
    // Pegando o ID do destinatário (do POST via JS)
    $destinatario = filter_var($_POST['destinatario'] ?? '', FILTER_SANITIZE_NUMBER_INT);

    // Pegando o remetente da sessão (usuário logado) - Já definido acima
    // $remetente = $_SESSION['id_user'] ?? ''; // Esta linha se torna redundante aqui

    // Validações básicas:
    // A validação de $remetente já foi feita no início do script.
    if (empty($destinatario) || empty($textoMensagem)) {
        // Retorna JSON para o JS em vez de redirecionar
        echo json_encode(['status' => 'error', 'message' => 'Dados essenciais faltando para inserir a mensagem.']);
        exit();
    }

    // Atribuindo os valores ao objeto Mensagem
    // id_msg: Se for auto-incrementável no BD, não precisa setar.
    // $mensagem->setId_msg(null); // Ou um ID gerado

    $mensagem->setRemetente($remetente); // Usa o $remetente obtido da sessão
    $mensagem->setDestinatario($destinatario);
    $mensagem->setTexto($textoMensagem);
    $mensagem->setData(date('Y-m-d H:i:s')); // Data e hora atuais (definida no PHP)

    // Chamando o DAO para inserir
    if ($mensagemDAO->inserir($mensagem)) {
        // Sucesso na inserção - Retorna JSON
        echo json_encode(['status' => 'success', 'message' => 'Mensagem enviada com sucesso!']);
        exit();
    } else {
        // Erro na inserção - Retorna JSON
        echo json_encode(['status' => 'error', 'message' => 'Erro ao inserir mensagem no banco de dados.']);
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

   
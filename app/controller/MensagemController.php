MensagemController.php
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
  
    $textoMensagem = filter_var($_POST['texto'] ?? '', FILTER_SANITIZE_STRING);
  
    $remetente = $_SESSION['id_user'] ?? null;

    $destinatario = filter_var($_POST['destinatario'] ?? '', FILTER_SANITIZE_NUMBER_INT);

    if (empty($destinatario) || empty($textoMensagem)) {
        echo json_encode(['status' => 'error', 'message' => 'Dados essenciais faltando para inserir a mensagem.']);
        exit();
    }


    $mensagem->setRemetente($remetente); 
    $mensagem->setDestinatario($destinatario);
    $mensagem->setTexto($textoMensagem);
    $mensagem->setData(date('Y-m-d H:i:s')); 

    
    if ($mensagemDAO->inserir($mensagem)) {
        
        echo json_encode(['status' => 'success', 'message' => 'Mensagem enviada com sucesso!']);
        exit();
    } else {
     
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

   
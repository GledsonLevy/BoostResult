<<<<<<< HEAD
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

		$dataHoraAtual = date('Y-m-d H:i:s');

		$mensagem->setId_chat(20); 

		$mensagem->setRemetente($_SESSION['id_user']); 

		$mensagem->setTexto($m['mensagem']); 
        
		$mensagem->setData( $dataHoraAtual);

        $mensagem->setDestinatario($m['destinatario_id']); 

        var_dump($mensagem);
        $mensagemDAO->inserir($mensagem);
    
}
    // se a requisição for editar
    else if(isset($_POST['editar'])){

=======
<?php   

    /* @Autor: Dalker Pinheiro
    Classe Controller */
    
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


    //se a operação for gravar entra nessa condição
    if(isset($_POST['cadastrar'])){

>>>>>>> parent of 272164f (Merge branch 'main' of https://github.com/GledsonLevy/BoostResult)
        $mensagem->setId_msg($m['id_msg']); 
		$mensagem->setId_chat($m['id_chat']); 
		$mensagem->setRemetente($m['remetente']); 
		$mensagem->setTexto($m['texto']); 
		$mensagem->setData($m['data']);
        $mensagemDAO->inserir($mensagem);

        header("Location: ../../mensagem.php?msg=adicionado");
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

   
<?php   

    /* @Autor: Dalker Pinheiro
    Classe Controller */
    
    include_once "../conexao/Conexao.php";
    include_once "../model/Solicitacao.php";
    include_once "../dao/SolicitacaoDAO.php";
    include "../dao/ChatDao.php";
    include "../model/Chat.php";


    $solicitacao = new Solicitacao();
    $solicitacaoDAO	= new SolicitacaoDAO();


    $s= filter_input_array(INPUT_POST);

    // Verifica se pesquisaram alguma coisa.
    if(isset($_GET['pesquisa'])&&!empty($_GET['pesquisa'])){
      $solicitacaos = $solicitacaoDAO->buscar("id_solicitacao",$_GET['pesquisa']);  
    }
    else{
      $solicitacaos = $solicitacaoDAO->listarTodos(); 
    }


    //se a operação for gravar entra nessa condição
    if(isset($_POST['cadastrar'])){

		$solicitacao->setId_aluno($s['id_aluno']); 

		$solicitacao->setId_personal($s['id_personal']); 

		$solicitacao->setData(date('Y-m-d H:i:s')); 

		$solicitacao->setStatus($s['status']);
        $solicitacaoDAO->inserir($solicitacao);

        header("Location: ../../solicitacao.php?msg=adicionado");
    } 
    // se a requisição for editar
    else if(isset($_POST['editar'])){

        $chatDao = new ChatDAO();
        $chatDao->inserir($s['id_solicitacao']);
      
        $solicitacaoDAO->atualizar($s['id_solicitacao'], $s['status']);

        header("Location: ../../solicitacao.php?msg=editado");
    }
    // se a requisição for deletar
    else if(isset($_GET['deletar'])){

        $solicitacao->setId_solicitacao($_GET['deletar']);

        $solicitacaoDAO->deletar($solicitacao);

        header("Location: ../../view/paginaInicial/index.php?msg=apagado");
    }else{
        header("Location: ../../solicitacao.php?msg=erro");
    }

   
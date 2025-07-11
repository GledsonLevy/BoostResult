<?php   
    session_start();
    /* @Autor: Dalker Pinheiro
    Classe Controller */
    
    include_once "../conexao/Conexao.php";
    include_once "../model/Registro_dado.php";
    include_once "../dao/Registro_dadoDAO.php";


    $registro_dado = new Registro_dado();
    $registro_dadoDAO	= new Registro_dadoDAO();

    date_default_timezone_set('America/Sao_Paulo');
    $r= filter_input_array(INPUT_POST);

    // Verifica se pesquisaram alguma coisa.
    if(isset($_GET['pesquisa'])&&!empty($_GET['pesquisa'])){
      $registro_dados = $registro_dadoDAO->buscar("id_dados",$_GET['pesquisa']);  
    }
    else{
      $registro_dados = $registro_dadoDAO->listarTodos(); 
    }


    //se a operação for gravar entra nessa condição
    if(isset($_POST['acao']) && ($_POST['acao'] == "CADASTRAR")){

		$registro_dado->setId_aluno($_SESSION['id_aluno']); 

		$registro_dado->setAltura($r['altura']); 

        $registro_dado->setData(date("Y-m-d H:i:s")); 

		$registro_dado->setPeso($r['peso']); 

		$registro_dado->setImc($r['imc']);

        $registro_dadoDAO->inserir($registro_dado);

        header("Location: ../../view/informacoes/medidas.php");
    } 
    // se a requisição for editar
    else if(isset($_POST['editar'])){

        $registro_dado->setId_dados($r['id_dados']); 

		$registro_dado->setId_aluno($r['id_aluno']); 

		$registro_dado->setAltura($r['altura']); 

		$registro_dado->setData($r['data']); 

		$registro_dado->setPeso($r['peso']); 

		$registro_dado->setImc($r['imc']);
        $registro_dadoDAO->atualizar($registro_dado);

        header("Location: ../../registro_dado.php?msg=editado");
    }
    // se a requisição for deletar
    else if(isset($_GET['deletar'])){

        $registro_dado->setId_dados($_GET['deletar']);

        $registro_dadoDAO->deletar($registro_dado);

        header("Location: ../../registro_dado.php?msg=apagado");
    }else{
        header("Location: ../../registro_dado.php?msg=erro");
    }

   
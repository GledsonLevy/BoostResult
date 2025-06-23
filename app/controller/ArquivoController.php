<?php   

    /* @Autor: Dalker Pinheiro
    Classe Controller */
    
    include_once "../conexao/Conexao.php";
    include_once "../model/Arquivo.php";
    include_once "../dao/ArquivoDAO.php";


    $arquivo = new Arquivo();
    $arquivoDAO	= new ArquivoDAO();


    $a= filter_input_array(INPUT_POST);

    // Verifica se pesquisaram alguma coisa.
    if(isset($_GET['pesquisa'])&&!empty($_GET['pesquisa'])){
      $arquivos = $arquivoDAO->buscar("id_arq",$_GET['pesquisa']);  
    }
    else{
      $arquivos = $arquivoDAO->listarTodos(); 
    }


    //se a operação for gravar entra nessa condição
    if (isset($_POST['enviar_arquivo']) && isset($_FILES['arquivo'])) {
        $id_solicitacao = $_POST['id_solicitacao'];
        $file = $_FILES['arquivo'];

        $nome = $file['name'];
        $tipo = $file['type'];
        $conteudo = file_get_contents($file['tmp_name']);

        $arquivo->setId_solicitacao($id_solicitacao);
        $arquivo->setNome($nome);
        $arquivo->setArq($conteudo); // binário
        $arquivo->setTipo($tipo);

        $arquivoDAO->inserir($arquivo);
        header("Location: ../../view/paginaInicial/index.php?msg=arquivo_enviado");
        exit;
    }
    // se a requisição for editar
    else if(isset($_POST['editar'])){

        $arquivo->setId_arq($a['id_arq']); 

		$arquivo->setId_msg($a['id_msg']); 

		$arquivo->setNome($a['nome']); 

		$arquivo->setArq($a['arq']); 

		$arquivo->setTipo($a['tipo']);
        $arquivoDAO->atualizar($arquivo);

        header("Location: ../../arquivo.php?msg=editado");
    }
    // se a requisição for deletar
    else if(isset($_GET['deletar'])){

        $arquivo->setId_arq($_GET['deletar']);

        $arquivoDAO->deletar($arquivo);

        header("Location: ../../arquivo.php?msg=apagado");
    }else{
        header("Location: ../../arquivo.php?msg=erro");
    }

   
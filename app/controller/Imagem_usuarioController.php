<?php   

    /* @Autor: Dalker Pinheiro
    Classe Controller */
    
    include_once "../conexao/Conexao.php";
    include_once "../model/Imagem_usuario.php";
    include_once "../dao/Imagem_usuarioDAO.php";


    $imagem_usuario = new Imagem_usuario();
    $imagem_usuarioDAO	= new Imagem_usuarioDAO();


    $i= filter_input_array(INPUT_POST);

    // Verifica se pesquisaram alguma coisa.
    if(isset($_GET['pesquisa'])&&!empty($_GET['pesquisa'])){
      $imagem_usuarios = $imagem_usuarioDAO->buscar("id_img",$_GET['pesquisa']);  
    }
    else{
      $imagem_usuarios = $imagem_usuarioDAO->listarTodos(); 
    }

    if(isset($_POST['cadastrar'])){

        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === 0) {
            $imagem_usuario->setId_user($i['id_user']);
            $imagem_usuario->setNome_arquivo($_FILES['imagem']['name']);
            $imagem_usuario->setTipo($_FILES['imagem']['type']);
            $imagem_usuario->setImagem(file_get_contents($_FILES['imagem']['tmp_name']));
            $imagem_usuarioDAO->inserir($imagem_usuario);
            header("Location: ../../view/paginaInicial/index.php?msg=adicionado");
        }else {
            header("Location: ../../view/paginaInicial/index.php?msg=erro_imagem");
        }
            
    } 
    // se a requisição for editar
    else if (isset($_POST['editar'])) {
        $i = $imagem_usuarioDAO->carregar($_POST['id_user']);
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === 0) {
            $imagem_usuario->setId_img($i['id_img']);
            $imagem_usuario->setId_user($_POST['id_user']);
            $imagem_usuario->setNome_arquivo($_FILES['imagem']['name']);

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $tipo = finfo_file($finfo, $_FILES['imagem']['tmp_name']);
            finfo_close($finfo);

            $imagem_usuario->setTipo($tipo);
            $imagem_usuario->setImagem(file_get_contents($_FILES['imagem']['tmp_name']));

            $imagem_usuarioDAO->atualizar($imagem_usuario);

            header("Location: ../../view/paginaInicial/index.php?msg=atualizada");
        } else {
            header("Location: ../../view/paginaInicial/index.php?msg=erro_arquivo");
        }
    }

    // se a requisição for deletar
    else if(isset($_GET['deletar'])){

        $imagem_usuario->setId_img($_GET['deletar']);

        $imagem_usuarioDAO->deletar($imagem_usuario);

        header("Location: ../../imagem_usuario.php?msg=apagado");
    }
    else{
        header("Location: ../../view/paginaInicial/index.php?msg=erro");
    }


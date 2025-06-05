<?php

	/* @Autor: Dalker Pinheiro
	   Classe DAO */
	   
class MensagemDAO{

	//Carrega um elemento pela chave primária
	public function carregar($id_msg){
        try {
			$sql = 'SELECT * FROM mensagem WHERE id_msg = :id_msg';
			$consulta = Conexao::getConexao()->prepare($sql);
			$consulta->bindValue(":id_msg",$id_msg);
			$consulta->execute();
			return ($consulta->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print "Erro ao carregar Mensagem <br>" . $e . '<br>';
        }
	}

	//Lista todos os elementos da tabela
	public function listarTodos(){
        try {
			$sql = 'SELECT * FROM mensagem';
			$consulta = Conexao::getConexao()->prepare($sql);
			$consulta->execute();
			return ($consulta->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print "Erro ao listar Mensagems <br>" . $e . '<br>';
        }
	}
	
	//Lista todos os elementos da tabela listando ordenados por uma coluna específica
	public function listarTodosOrgenandoPor($coluna){
        try {
			$sql = 'SELECT * FROM mensagem ORDER BY '.$coluna;
			$consulta = Conexao::getConexao()->prepare($sql);
			$consulta->execute();
			return ($consulta->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print "Erro ao listar Mensagems <br>" . $e . '<br>';
        }
	}
	
	
	//Busca elementos da tabela
	public function buscar($coluna, $valor){
        try {
			$sql = 'SELECT * FROM mensagem WHERE id_msg LIKE :valor';
			$consulta = Conexao::getConexao()->prepare($sql);
			$consulta->bindValue(":valor",$valor);
			$consulta->execute();
			return ($consulta->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print "Erro ao listar Mensagems <br>" . $e . '<br>';
        }
	}
	
	//Apaga um elemento da tabela
	public function deletar(Mensagem $mensagem){
        try {
			$sql = 'DELETE FROM mensagem WHERE id_msg = :chave';
			$consulta = Conexao::getConexao()->prepare($sql);
			$consulta->bindValue(":chave",$mensagem->getid_msg());
			$consulta->execute();
        } catch (Exception $e) {
            print "Erro ao deletar Mensagem <br>" . $e . '<br>';
        }
	}
	
	//Insere um elemento na tabela
	public function inserir(Mensagem $mensagem){
        try {
			$sql = 'INSERT INTO mensagem (id_msg, remetente, destinatario, texto, data_msg) VALUES (:id_msg, :remetente, :destinatario, :texto, :data_msg)';
			$consulta = Conexao::getConexao()->prepare($sql);
			$consulta->bindValue(':id_msg',$mensagem->getId_msg()); 

			$consulta->bindValue(':remetente',$mensagem->getRemetente()); 

			$consulta->bindValue(':destinatario',$mensagem->getDestinatario()); 

			$consulta->bindValue(':texto',$mensagem->getTexto()); 

			$consulta->bindValue(':data_msg',$mensagem->getData());
			$consulta->execute();
			return true;
        } catch (Exception $e) {
            print "Erro ao inserir Mensagem <br>" . $e . '<br>';
        }
	}
	
	//Atualiza um elemento na tabela
	//Atualiza um elemento na tabela
public function atualizar(Mensagem $mensagem){
    try {
        // Removi id_chat (se não for para ser atualizado), usei data_msg e removi id_msg do SET
        $sql = 'UPDATE mensagem SET remetente = :remetente, destinatario = :destinatario, texto = :texto, data_msg = :data_msg WHERE id_msg = :id_msg';
        $consulta = Conexao::getConexao()->prepare($sql);
        
        $consulta->bindValue(':remetente',$mensagem->getRemetente()); 
        $consulta->bindValue(':destinatario',$mensagem->getDestinatario()); // Adicionado destinatario, já que está no model
        $consulta->bindValue(':texto',$mensagem->getTexto()); 
        $consulta->bindValue(':data_msg',$mensagem->getData()); // Usando 'data_msg' para consistência
        $consulta->bindValue(':id_msg',$mensagem->getId_msg()); // Usado apenas no WHERE

        $consulta->execute();        
        return true; // Retorne true em caso de sucesso, para ser consistente com o inserir
    } catch (Exception $e) {
        print "Erro ao atualizar Mensagem <br>" . $e . '<br>';
        return false; // Retorne false em caso de erro
    }
}
}
<?php
require_once 'Registro_dadoDAO.php';
require_once 'ClienteDAO.php';

/* @Autor: Dalker Pinheiro
	  Classe DAO */
class UsuarioDAO
{

	//Carrega um elemento pela chave primária
	public function carregar($id_user)
	{
		try {
			$sql = 'SELECT * FROM usuario WHERE id_user = :id_user';
			$consulta = Conexao::getConexao()->prepare($sql);
			$consulta->bindValue(":id_user", $id_user);
			$consulta->execute();
			return ($consulta->fetch(PDO::FETCH_ASSOC));
		} catch (Exception $e) {
			print "Erro ao carregar Usuario <br>" . $e . '<br>';
		}
	}

	//Lista todos os elementos da tabela
	public function listarTodos()
	{
		try {
			$sql = 'SELECT * FROM usuario';
			$consulta = Conexao::getConexao()->prepare($sql);
			$consulta->execute();
			return ($consulta->fetchAll(PDO::FETCH_ASSOC));
		} catch (Exception $e) {
			print "Erro ao listar Usuarios <br>" . $e . '<br>';
		}
	}

	public function buscarPersonaisPorNome($nome)
	{
		try {
			$sql = "SELECT * FROM usuario WHERE tipo = 'personal' AND nome LIKE :nome ORDER BY nome";
			$consulta = Conexao::getConexao()->prepare($sql);
			$consulta->bindValue(':nome', "%$nome%", PDO::PARAM_STR);
			$consulta->execute();
			return $consulta->fetchAll(PDO::FETCH_ASSOC);
		} catch (Exception $e) {
			print "Erro ao buscar usuários por nome: <br>" . $e . "<br>";
			return [];
		}
	}

	//Busca elementos da tabela
	public function buscar($coluna, $valor)
	{
		try {
			$sql = "SELECT * FROM usuario WHERE id_user = :valor";
			$consulta = Conexao::getConexao()->prepare($sql);
			$consulta->bindValue(":valor", $valor);
			$consulta->execute();
			return ($consulta->fetch(PDO::FETCH_ASSOC));
		} catch (Exception $e) {
			print "Erro ao listar Usuarios <br>" . $e . '<br>';
		}
	}

	//Buscar usuários de tipos específicos
	public function buscarTipo($tipo)
	{
		try {
            $sql = 'SELECT * FROM usuario WHERE tipo LIKE :tipo';
            $consulta = Conexao::getConexao()->prepare($sql);
            $consulta->bindValue(':tipo', '%' . $tipo . '%');
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
             return ['error' => 'Erro ao acessar o banco de dados: ' . $e->getMessage()];
        }
	}

	//Apaga um elemento da tabela
	public function deletar(Usuario $usuario)
	{
		try {
			$sql = 'DELETE FROM usuario WHERE id_user = :chave';
			$consulta = Conexao::getConexao()->prepare($sql);
			$consulta->bindValue(":chave", $usuario->getid_user());
			$consulta->execute();
		} catch (Exception $e) {
			print "Erro ao deletar Usuario <br>" . $e . '<br>';
		}
	}
	
	public function inserir(Usuario $usuario)
	{
		try {
			$conexao = Conexao::getConexao();

			$sqlVerificar = 'SELECT COUNT(*) FROM usuario';
			$consultaVerificar = $conexao->prepare($sqlVerificar);
			$consultaVerificar->execute();
			$numUsuarios = $consultaVerificar->fetchColumn();

		
			$sql = 'INSERT INTO usuario (nome, idade, telefone, email, senha, sexo, tipo, tipo_usuario) 
					VALUES (:nome, :idade, :telefone, :email, :senha, :sexo, :tipo, :tipo_usuario)';

			
			if ($numUsuarios == 0) {
				$consultaAdmin = $conexao->prepare($sql);
				$consultaAdmin->bindValue(':nome', 'Admin');
				$consultaAdmin->bindValue(':idade', date('Y-m-d')); 
				$consultaAdmin->bindValue(':telefone', '(00)00000-0000');
				$consultaAdmin->bindValue(':email', 'admin@admin.com');
				$consultaAdmin->bindValue(':senha', sha1(md5('admin123')));
				$consultaAdmin->bindValue(':sexo', 'n');
				$consultaAdmin->bindValue(':tipo', 'admin');
				$consultaAdmin->bindValue(':tipo_usuario', 'sistema');
				$consultaAdmin->execute();
			}

			$tipoUsuario = 'cliente';

			$consulta = $conexao->prepare($sql);
			$consulta->bindValue(':nome', $usuario->getNome());
			$consulta->bindValue(':idade', $usuario->getIdade());
			$consulta->bindValue(':telefone', $usuario->getTelefone());
			$consulta->bindValue(':email', $usuario->getEmail());
			$consulta->bindValue(':senha', sha1(md5($usuario->getSenha())));
			$consulta->bindValue(':sexo', $usuario->getSexo());
			$consulta->bindValue(':tipo', $usuario->getTipo());
			$consulta->bindValue(':tipo_usuario', $tipoUsuario);
			$consulta->execute();

			return $conexao->lastInsertId();

		} catch (Exception $e) {
			print "Erro ao inserir Usuario <br>" . $e->getMessage() . '<br>';
		}
	}

	public function pegarIdAluno($id_user) {
	try {
		$sql = 'SELECT * FROM aluno WHERE id_user = :id_user';
		$consulta = Conexao::getConexao()->prepare($sql);
		$consulta->bindValue(":id_user", $id_user);
		$consulta->execute(); // Adicione isso!
		if ($consulta->rowCount() > 0) {
			$dadosUsuario = $consulta->fetch(PDO::FETCH_ASSOC);
			$_SESSION['id_aluno'] = $dadosUsuario['id_aluno'];
		}
	} catch (Exception $e) {
		print "Erro ao buscar ID do aluno <br>" . $e . '<br>';
	}
}

	public function logar(Usuario $usuario)
	{
		$clienteDAO = new ClienteDAO();
		$registro = new Registro_dadoDAO();
		try {
			$sql = 'SELECT * FROM usuario WHERE email = :email AND senha = :senha';
			$consulta = Conexao::getConexao()->prepare($sql);
			$consulta->bindValue(":email", $usuario->getEmail());
			$consulta->bindValue(":senha", sha1(md5($usuario->getSenha())));
			$consulta->execute();
			if ($consulta->rowCount() > 0) {
				$dadosUsuario = $consulta->fetch(PDO::FETCH_ASSOC);
				$_SESSION['tipo'] = $dadosUsuario['tipo'];
				$_SESSION['id_user'] = $dadosUsuario['id_user'];
				$_SESSION['sexo'] = $dadosUsuario['sexo'];
				$_SESSION['email'] = $dadosUsuario['email'];
				$_SESSION['nome'] = $dadosUsuario['nome'];
				$_SESSION['tipo_usuario'] = $dadosUsuario['tipo_usuario'];
				$_SESSION['descricao'] = $dadosUsuario['descricao'];
			}

			$this->pegarIdAluno($_SESSION['id_user']);
			$registro->pegarUltimosDadosAluno($_SESSION['id_aluno']);
			$clienteDAO->pegarUltimosDadosCliente($_SESSION['id_aluno'], $_SESSION['id_user']);
			
		} catch (Exception $e) {
			print "Erro ao inserir Usuario <br>" . $e . '<br>';
		}
	}

	public function atualizar(Usuario $usuario)
	{
		try {
			$sql = 'UPDATE usuario SET nome = :nome, idade = :idade, telefone = :telefone, email = :email, senha = :senha, sexo = :sexo, tipo = :tipo, descricao = :descricao WHERE id_user = :id_user';
			$consulta = Conexao::getConexao()->prepare($sql);
			$consulta->bindValue(':id_user', $usuario->getId_user());

			$consulta->bindValue(':nome', $usuario->getNome());

			$consulta->bindValue(':idade', $usuario->getIdade());

			$consulta->bindValue(':telefone', $usuario->getTelefone());

			$consulta->bindValue(':email', $usuario->getEmail());

			$consulta->bindValue(':senha', $usuario->getSenha());

			$consulta->bindValue(':sexo', $usuario->getSexo());

			$consulta->bindValue(':tipo', $usuario->getTipo());

			$consulta->bindValue(':descricao', $usuario->getDesc());
			
			$consulta->execute();
			return true;
		} catch (Exception $e) {
			print "Erro ao atualizar Usuario <br>" . $e . '<br>';
		}
	}

	public function verificarDuplicado($email, $telefone) {
		$sql = "SELECT COUNT(*) FROM usuario WHERE email = :email OR telefone = :telefone";
		$consulta = Conexao::getConexao()->prepare($sql);
		$consulta->bindValue(':email', $email);
		$consulta->bindValue(':telefone', $telefone);
		$consulta->execute();
		$quantidade = $consulta->fetchColumn();

		return $quantidade > 0; 
	}

	public function verificarCredenciais($email, $senha) {
		$sql = "SELECT COUNT(*) FROM usuario WHERE email = :email AND senha = :senha";
		$consulta = Conexao::getConexao()->prepare($sql);
		$consulta->bindValue(':email', $email);
		$consulta->bindValue(':senha', sha1(md5($senha)));
		$consulta->execute();
		$quantidade = $consulta->fetchColumn();

		return $quantidade == 0; 
	}

	public function verificarEmail($email) {
		$sql = "SELECT COUNT(*) FROM usuario WHERE email = :email";
		$consulta = Conexao::getConexao()->prepare($sql);
		$consulta->bindValue(':email', $email);
		$consulta->execute();
		$quantidade = $consulta->fetchColumn();

		return $quantidade == 0; 
	}
}
<?php

class ClienteDAO {
    public function pegarUltimosDadosCliente($id_aluno, $id_user) {
    try {
        $sql = 'SELECT * FROM clientes 
                WHERE id_aluno = :id_aluno OR id_user = :id_user
                ORDER BY id_cliente DESC 
                LIMIT 1';

        $consulta = Conexao::getConexao()->prepare($sql);
        $consulta->bindValue(":id_aluno", $id_aluno);
        $consulta->bindValue(":id_user", $id_user);
        $consulta->execute();

        if ($consulta->rowCount() > 0) {
            $dados = $consulta->fetch(PDO::FETCH_ASSOC);

            $_SESSION['nome_completo'] = $dados['nome_completo'];
            $_SESSION['genero']        = $dados['genero'];
            $_SESSION['cpf']           = $dados['cpf'];
            $_SESSION['rg']            = $dados['rg'];
            $_SESSION['telefone']      = $dados['telefone'];
            $_SESSION['email']         = $dados['email'];
        }
    } catch (Exception $e) {
        echo "Erro ao buscar dados do cliente <br>" . $e->getMessage() . '<br>';
    }
}



    public function inserir(Cliente $cliente) {
    try {
        $sql = "INSERT INTO clientes 
                (nome_completo, genero, cpf, rg, id_aluno, id_user)
                VALUES (:nome_completo, :genero, :cpf, :rg, :id_aluno, :id_user)";

        $con = Conexao::getConexao()->prepare($sql);
        $con->bindValue(":nome_completo", $cliente->getNome_completo());
        $con->bindValue(":genero", $cliente->getGenero());
        $con->bindValue(":cpf", $cliente->getCpf());
        $con->bindValue(":rg", $cliente->getRg());
        $con->bindValue(":id_aluno", $_SESSION['id_aluno']);
        $con->bindValue(":id_user", $_SESSION['id_user']);

        $resultado = $con->execute();

        // Pega os dados atualizados depois de inserir
        $this->pegarUltimosDadosCliente($_SESSION['id_aluno'], $_SESSION['id_user']);

        return $resultado;
    } catch (Exception $e) {
        echo "Erro ao inserir cliente: " . $e->getMessage();
        return false;
    }
}

}

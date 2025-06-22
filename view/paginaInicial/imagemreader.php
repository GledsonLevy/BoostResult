<?php
include("../../app/conexao/Conexao.php");

function carregar($id_user) {
    try {
        $sql = 'SELECT * FROM imagem_usuario WHERE id_user = :id_user';
        $consulta = ConexaoBinaria::getConexao()->prepare($sql);
        $consulta->bindValue(":id_user", $id_user);
        $consulta->execute();
        return $consulta->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        error_log("Erro ao carregar imagem_usuario: " . $e->getMessage());
        return null;
    }
}

if (isset($_GET['id_user'])) {
    $id_user = intval($_GET['id_user']);
    $imagemData = carregar($id_user);

    if ($imagemData && !empty($imagemData['imagem'])) {
        // Define corretamente o tipo da imagem (image/png, image/jpeg etc)
        header("Content-Type: " . $imagemData['tipo']);
        
        // Evita qualquer saída extra
        ob_clean(); // limpa qualquer buffer de saída
        flush();     // força envio dos headers
        
        // Exibe a imagem binária
        echo $imagemData['imagem'];
    } else {
        http_response_code(404);
        echo "Imagem não encontrada.";
    }
} else {
    http_response_code(400);
    echo "ID do usuário não informado.";
}
?>

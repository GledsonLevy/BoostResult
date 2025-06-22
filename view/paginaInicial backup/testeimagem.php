<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="../../app/controller/imagem_usuarioController.php" method="POST"
                enctype="multipart/form-data">
                <label for="fileUpload">
                    <div class="avatar">
                        <img src="https://dimensaosete.com.br/static/7fc311549694666167a49cdb0fb1293c/2493a/gojo.webp"
                            alt="Clique para enviar uma imagem" width="150" id="imgAvatar">
                        <span class="emoji"><img src="../../imagens/icongaleria.png" alt=""></span>
                    </div>
                </label>
                <input type="file" id="fileUpload" name="imagem" accept="image/*" style="display:none;"
                    onchange="this.form.submit();">
                <input type="hidden" name="cadastrar" value="Cadastrar">
                <input type="hidden" name="id_user" value="46">
            </form>
</body>
</html>
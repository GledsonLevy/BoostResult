<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Personais</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
            margin: 0;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .lista-personais {
            max-width: 600px;
            margin: auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            padding: 0;
            overflow: hidden;
        }

        .alunos {
            display: flex;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        .alunos:last-child {
            border-bottom: none;
        }

        .alunos img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
        }

        .nome {
            font-size: 18px;
            color: #333;
        }

        .mensagem {
            text-align: center;
            color: #888;
            padding: 20px;
        }
    </style>
</head>
<body>

    <h1>Lista de Alunos</h1>

    <div class="lista-personais" id="listaPersonais">
        <div class="mensagem">Carregando...</div>
    </div>

    <script>
    window.addEventListener('DOMContentLoaded', () => {
        fetch('../../app/controller/UsuarioController.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                acao: 'BuscarTipo',
                tipo: 'aluno'
            })
        })
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('listaPersonais');
            container.innerHTML = ''; // limpa

            if (data.error) {
                container.innerHTML = `<div class="mensagem">${data.error}</div>`;
                return;
            }

            if (!Array.isArray(data) || data.length === 0) {
                container.innerHTML = `<div class="mensagem">Nenhum alunos encontrado.</div>`;
                return;
            }

            data.forEach(usuario => {
                const item = document.createElement('div');
                item.classList.add('alunos');

                item.innerHTML = `
                    
                    <div class="nome">${usuario.nome}</div>
                `;

                container.appendChild(item);
            });
        })
        .catch(err => {
            document.getElementById('listaPersonais').innerHTML =
                `<div class="mensagem">Erro ao carregar dados.</div>`;
            console.error(err);
        });
    });
    </script>

</body>
</html>

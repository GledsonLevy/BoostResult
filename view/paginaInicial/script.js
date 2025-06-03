// Função para movimentar a underline entre os botões
function loadPageAndHighlight(button, url) {
    // Atualiza o conteúdo do iframe
    document.getElementById('myIframe').src = url;

    // Obtém a underline e os elementos do botão
    const underline = document.getElementById('underline-indicator');
    const rect = button.getBoundingClientRect();
    const containerRect = button.parentElement.getBoundingClientRect();

    // Aplica a posição e o tamanho da underline
    underline.style.width = rect.width + "px";
    underline.style.left = (rect.left - containerRect.left) + "px";

    // Ativa a transição (apenas se não for o botão inicial)
    setTimeout(() => {
        button.parentElement.classList.add('transition');
    }, 10); // Atrasar um pouco para garantir que a transição funcione

    // Adiciona uma classe para que a transição ocorra depois de clicar em um botão
    document.querySelectorAll('.button-container button').forEach(btn => {
        btn.classList.remove('active'); // Remove a classe "active" dos outros botões
    });
    button.classList.add('active'); // Adiciona a classe "active" ao botão clicado
}

// Adiciona a underline no botão 1 ao carregar a página
window.onload = function () {
    const firstButton = document.getElementById('button1');
    loadPageAndHighlight(firstButton, 'informacoes/treinos.php'); // URL padrão ao carregar
};

// Abrir painel de mensagens
document.getElementById('mensagens-btn').addEventListener('click', function () {
    const panel = document.getElementById('mensagens-panel');
    panel.classList.toggle('open');
});

document.getElementById('personais-btn').addEventListener('click', function () {
    document.getElementById('personais-panel').classList.add('open');
});

document.getElementById('close-personais-btn').addEventListener('click', function () {
    document.getElementById('personais-panel').classList.remove('open');
});

document.getElementById('alunos-btn').addEventListener('click', function () {
    document.getElementById('alunos-panel').classList.add('open');
});

document.getElementById('close-alunos-btn').addEventListener('click', function () {
    document.getElementById('alunos-panel').classList.remove('open');
});

// Fechar painel de mensagens
document.getElementById('close-mensagens-btn').addEventListener('click', function () {
    document.getElementById('mensagens-panel').classList.remove('open');
    document.getElementById('chat-panel').classList.remove('open');
});

// Abrir painel de chat ao clicar em uma mensagem
document.getElementById('chat-btn').addEventListener('click', function () {
    document.getElementById('chat-panel').classList.add('open');
});

// Fechar painel de chat
document.getElementById('close-chat-btn').addEventListener('click', function () {
    document.getElementById('chat-panel').classList.remove('open');
});


document.getElementById("toggleDarkMode").addEventListener("click", function () {
    document.body.classList.toggle("dark-mode");

    const btn = document.getElementById("toggleDarkMode");

    if (document.body.classList.contains("dark-mode")) {
        localStorage.setItem("modo", "escuro");
        btn.textContent = "Modo Claro ☀️";
        document.getElementById("toggleDarkMode").style.backgroundColor = "#FAFAFA";
        document.getElementById("toggleDarkMode").style.color = "#000";
    } else {
        localStorage.setItem("modo", "claro");
        btn.textContent = "Modo Escuro 🌙";
        document.getElementById("toggleDarkMode").style.backgroundColor = "#000";
        document.getElementById("toggleDarkMode").style.color = "#FAFAFA";
    }
});

// Ao carregar a página, aplica o modo salvo e ajusta o texto do botão

window.addEventListener("load", function () {
    const btn = document.getElementById("toggleDarkMode");
    if (localStorage.getItem("modo") === "escuro") {
        document.body.classList.add("dark-mode");
        btn.textContent = "Modo Claro ☀️";
        document.getElementById("toggleDarkMode").style.backgroundColor = "#FAFAFA";
        document.getElementById("toggleDarkMode").style.color = "#000";
    } else {
        btn.textContent = "Modo Escuro 🌙";
        document.getElementById("toggleDarkMode").style.backgroundColor = "#000";
        document.getElementById("toggleDarkMode").style.color = "#FAFAFA";
    }
});

 document.addEventListener('DOMContentLoaded', function() {
        const sendMessageButton = document.getElementById('enviar-msg');
        const messageInput = document.getElementById('mensagem');
        
        // Obtenha o elemento do campo oculto do destinatário
        const destinatarioIdHidden = document.getElementById('destinatario-id-hidden');

        sendMessageButton.addEventListener('click', function() {
            const messageText = messageInput.value.trim();

            if (messageText === '') {
                alert('Por favor, digite uma mensagem antes de enviar.');
                return;
            }
            
            // Pegue o ID do destinatário do campo oculto
            const destinatarioId = destinatarioIdHidden.value;

            // Verificação básica para garantir que o ID não está vazio
            if (!destinatarioId) {
                console.error('Erro: ID do destinatário não encontrado no campo oculto.');
                alert('Não foi possível enviar a mensagem. Tente novamente mais tarde.');
                return;
            }

            const formData = new FormData();
            formData.append('acao', 'INSERIR');
            formData.append('texto', messageText);
            formData.append('destinatario', destinatarioId); // Adicionando o ID do destinatário ao POST

            // Certifique-se de que o 'id_chat' também seja enviado se for necessário para a lógica do chat
            // Se o id_chat também for um campo oculto, você faria o mesmo processo:
            // const chatIdHidden = document.getElementById('chat-id-hidden');
            // const chatId = chatIdHidden.value;
            // formData.append('id_chat', chatId);

            // Ajuste esta URL para o caminho correto do seu MensagemController.php
            fetch('../../app/controller/MensagemController.php', { // Ex: './backend/controllers/MensagemController.php'
                method: 'POST',
                body: formData
            })
            .then(response => response.text()) // Ou .json() se o PHP retornar JSON
            .then(data => {
                console.log(data); // Exibe a resposta do script PHP no console
                messageInput.value = ''; // Limpa o campo de entrada
                // Lógica para atualizar a interface do usuário após o envio da mensagem
            })
            .catch(error => {
                console.error('Erro ao enviar mensagem:', error);
                alert('Falha ao enviar mensagem.');
            });
        });

        // Opcional: Enviar mensagem com a tecla Enter
        messageInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault(); // Evita que o Enter quebre linha ou submeta o formulário
                sendMessageButton.click(); // Simula o clique no botão
            }
        });
    });
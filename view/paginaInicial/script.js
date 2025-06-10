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
    const destinatarioIdHidden = document.getElementById('destinatario-id-hidden');
    const interacaoConteudo = document.getElementById('interacao-conteudo');
    const closeChatBtn = document.getElementById('close-chat-btn'); // Botão de fechar chat (opcional)

    // Função para carregar e exibir as mensagens
    function carregarMensagens() {
        const destinatarioId = destinatarioIdHidden.value;

        // Verifica se o ID do destinatário está disponível
        if (!destinatarioId) {
            console.error('Erro: ID do destinatário não encontrado para carregar mensagens.');
            return;
        }

        const formData = new FormData();
        formData.append('acao', 'CARREGAR_MENSAGENS');
        formData.append('destinatario', destinatarioId); // Envia o destinatário para o PHP

        fetch('../../app/controller/MensagemController.php', { // Ajuste este caminho se necessário
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                // Se a resposta não for OK (ex: erro 500 no servidor)
                throw new Error('Erro de rede ou servidor: ' + response.statusText);
            }
            return response.json(); // Esperamos uma resposta JSON
        })
        .then(data => {
            if (data.status === 'error') {
                console.error('Erro ao carregar mensagens:', data.message);
                // alert('Erro ao carregar mensagens: ' + data.message); // Opcional: exibir para o usuário
                return;
            }

            // Se o data for um array de mensagens, continue
            const messages = data; // PHP agora envia diretamente o array de mensagens formatado

            interacaoConteudo.innerHTML = ''; // Limpa as mensagens existentes antes de recarregar
            messages.forEach(message => {
                const messageDiv = document.createElement('div');
                messageDiv.classList.add('message-item');

                // Usa a flag 'is_mine' enviada pelo PHP para classificar a mensagem
                if (message.is_mine) {
                    messageDiv.classList.add('sent');
                } else {
                    messageDiv.classList.add('received');
                }

                // Formata a data e hora
                const dataHora = new Date(message.data_msg);
                const hora = dataHora.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                const data = dataHora.toLocaleDateString('pt-BR'); // Formato DD/MM/YYYY

                messageDiv.innerHTML = `
                    <div class="message-content">${message.texto}</div>
                    <div class="message-info">
                        <span class="message-time">${hora}</span>
                        <span class="message-date">${data}</span>
                    </div>
                `;
                interacaoConteudo.appendChild(messageDiv);
            });

            // Rolagem automática para o final do chat
            interacaoConteudo.scrollTop = interacaoConteudo.scrollHeight;
        })
        .catch(error => {
            console.error('Erro na requisição para carregar mensagens:', error);
            // alert('Falha ao carregar mensagens. Verifique a conexão.'); // Opcional: exibir para o usuário
        });
    }

    // Event listener para o botão de enviar mensagem
    sendMessageButton.addEventListener('click', function() {
        const messageText = messageInput.value.trim();

        if (messageText === '') {
            alert('Por favor, digite uma mensagem antes de enviar.');
            return;
        }

        const destinatarioId = destinatarioIdHidden.value;

        if (!destinatarioId) {
            console.error('Erro: ID do destinatário não encontrado.');
            alert('Não foi possível enviar a mensagem. Tente novamente mais tarde.');
            return;
        }

        const formData = new FormData();
        formData.append('acao', 'INSERIR');
        formData.append('texto', messageText);
        formData.append('destinatario', destinatarioId);
        // O ID do remetente NÃO É ENVIADO pelo JS, é pego da sessão no PHP

        fetch('../../app/controller/MensagemController.php', { // Ajuste este caminho se necessário
            method: 'POST',
            body: formData
        })
        .then(response => response.json()) // Esperamos uma resposta JSON (status e message)
        .then(data => {
            console.log(data); // Exibe a resposta do script PHP
            if (data.status === 'success') {
                messageInput.value = ''; // Limpa o campo de entrada
                //carregarMensagens(); // Recarrega as mensagens para exibir a nova
            } else {
                alert('Erro ao enviar mensagem: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Erro na requisição para enviar mensagem:', error);
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

    // Opcional: Event listener para o botão de fechar o chat
    if (closeChatBtn) {
        closeChatBtn.addEventListener('click', function() {
            const chatPanel = document.getElementById('chat-panel');
            if (chatPanel) {
                chatPanel.style.display = 'none'; // Ou remova-o, ou use um fade-out
            }
        });
    }

    // Carrega as mensagens assim que a página é carregada
    //carregarMensagens();

    // Opcional: Atualizar mensagens periodicamente (a cada 3 segundos, por exemplo)
    // setInterval(carregarMensagens, 3000); // Descomente para ativar a atualização automática
});
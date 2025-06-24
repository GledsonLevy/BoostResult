document.addEventListener("DOMContentLoaded", function () {
    // Variáveis globais
    let dadosAluno = {};
    let intervaloMensagens = null;
    let ultimaMensagemId = null;
    
    // Elementos DOM frequentemente acessados
    const chatPanel = document.getElementById('chat-panel');
    const conteudoIframe = document.getElementById('conteudo-iframe');
    const interacaoConteudo = document.getElementById('interacao-conteudo');
    const toggleDarkMode = document.getElementById('toggleDarkMode');

    // Inicialização
    const button = document.getElementById('button3');
    

    // Função para atualizar mensagens
    function atualizarMensagens() {
        if (!dadosAluno.id_solicitacao) return;

        fetch("carregar_mensagens.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams({
                id_solicitacao: dadosAluno.id_solicitacao,
                acao: "carregar_mensagens"
            })
        })
        .then(res => res.json())
        .then(mensagens => {
            const container = document.getElementById("interacao-conteudo");

            // Verifica se há novas mensagens
            const novaUltima = mensagens.length > 0 ? mensagens[mensagens.length - 1].id_msg : null;
            if (novaUltima === ultimaMensagemId) return; // Não atualiza se não mudou

            ultimaMensagemId = novaUltima;
            container.innerHTML = "";

            let html = "";
            mensagens.forEach(msg => {
                const classe = (msg.remetente == dadosAluno.id_destinatario) ? "mensagem-recebida" : "mensagem-enviada";
                html += `
                    <div class="mensagem ${classe}">
                        <div class="texto">${msg.texto}</div>
                        <div class="data"><small>${msg.data}</small></div>
                    </div>`;
            });
            container.innerHTML = html;

            container.scrollTo({ top: container.scrollHeight, behavior: "smooth" });
        })
        .catch(err => console.error("Erro ao atualizar mensagens:", err));
    }

    // Função para carregar páginas no iframe
    window.loadPage = function (url, button) {
        const iframe = document.getElementById('conteudo-iframe');
        const underline = document.getElementById('underline-indicator');
        const buttons = document.querySelectorAll('.button-container button');

        // Força reload sempre (mesma URL inclusive)
        iframe.src = url.includes('?') ? url + '&_t=' + Date.now() : url + '?_t=' + Date.now();

        // Remover destaque dos outros botões
        buttons.forEach(btn => btn.classList.remove('Underline'));

        // Adicionar destaque ao botão atual
        button.classList.add('Underline');

        // Mover a underline para o botão clicado
        const rect = button.getBoundingClientRect();
        const containerRect = button.parentElement.getBoundingClientRect();
        underline.style.width = rect.width + 'px';
        underline.style.left = (rect.left - containerRect.left) + 'px';
    };

    loadPage('../informacoes/dados.php', button);

    // Funções para abrir modais
    window.abrirModal = function (id) {
        document.getElementById('chats-panel')?.classList.remove('open');
        document.getElementById('chat-panel').classList.add('open');
        document.getElementById('alunos-panel')?.classList.remove('open');
        document.getElementById('personais-panel')?.classList.remove('open');
        const elemento = document.getElementById(id);
        const nome = elemento?.getAttribute('value');
        document.getElementById("receberNomeUsuario").innerHTML = nome;
    };

    window.abrirModalChat = function (nome) {
        document.getElementById('chat-panel').classList.add('open');
        document.getElementById('chats-panel')?.classList.toggle('open');
        document.getElementById('alunos-panel')?.classList.remove('open');
        document.getElementById('personais-panel')?.classList.remove('open');
        document.getElementById('receberNomeUsuario').textContent = nome;
    };

    // Event Listeners - Chat
    document.querySelectorAll(".btn-open-chats").forEach(button => {
        button.addEventListener("click", function () {
            const id_solicitacao = this.dataset.idSolicitacao;
            const id_destinatario = this.dataset.idDestinatario;
            const id_remetente = this.dataset.idRemetente;
            const nome = this.dataset.nome;
            
            dadosAluno = { id_solicitacao, id_destinatario, id_remetente };
            atualizarMensagens();

            // Atualiza a cada 3 segundos
            if (intervaloMensagens) clearInterval(intervaloMensagens);
            intervaloMensagens = setInterval(atualizarMensagens, 3000);

            // Abre o painel com os dados
            document.getElementById("chat-panel").style.display = "block";
            document.getElementById("destinatario_id").value = id_destinatario;
            document.getElementById("remetente_id").value = id_remetente;
            document.getElementById("solicitacao_id").value = id_solicitacao;
            abrirModalChat(nome);
        });
    });

    document.querySelector(".interacao-input")?.addEventListener("submit", function (e) {
        e.preventDefault();
        const form = e.target;
        const mensagem = form.mensagem.value.trim();
        if (!mensagem) return;

        const formData = new URLSearchParams(new FormData(form));

        fetch(form.action, {
            method: "POST",
            body: formData
        })
        .then(res => res.text())
        .then(() => {
            form.mensagem.value = "";
            atualizarMensagens();
        })
        .catch(err => console.error("Erro ao enviar mensagem:", err));
    });

    document.getElementById('close-chat-btn')?.addEventListener('click', function () {
        document.getElementById('chat-panel').style.display = "none";
        if (intervaloMensagens) clearInterval(intervaloMensagens);
    });

    // Event Listeners - Painéis
    document.getElementById('personais-btn')?.addEventListener('click', function () {
        document.getElementById('personais-panel').classList.add('open');
    });

    document.getElementById('close-personais-btn')?.addEventListener('click', function () {
        document.getElementById('personais-panel').classList.remove('open');
    });

    document.getElementById('alunos-btn')?.addEventListener('click', function () {
        document.getElementById('alunos-panel').classList.add('open');
    });

    document.getElementById('close-alunos-btn')?.addEventListener('click', function () {
        document.getElementById('alunos-panel').classList.remove('open');
    });

    document.getElementById('solicitacao-btn')?.addEventListener('click', function () {
        document.getElementById('solicitacao-panel').classList.add('open');
    });

    document.getElementById('close-solicitacao-btn')?.addEventListener('click', function () {
        document.getElementById('solicitacao-panel').classList.remove('open');
    });

    document.getElementById('chats-btn')?.addEventListener('click', function () {
        document.getElementById('chats-panel').classList.add('open');
    });

    document.getElementById('close-chats-btn')?.addEventListener('click', function () {
        document.getElementById('chats-panel').classList.remove('open');
    });

    // Event Listeners - Formulários
    document.querySelectorAll(".arquivo-form").forEach(form => {
        const inputFile = form.querySelector(".arquivo-input");
        const labelBtn = form.querySelector(".btn-selecionar");
        const nomeArquivo = form.querySelector(".nome-arquivo");

        // Clique no label dispara o seletor
        labelBtn?.addEventListener("click", () => inputFile.click());

        // Atualiza o nome exibido ao selecionar o arquivo
        inputFile?.addEventListener("change", () => {
            if (inputFile.files.length > 0) {
                nomeArquivo.textContent = inputFile.files[0].name;
            } else {
                nomeArquivo.textContent = "";
            }
        });
    });
    
});

  function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    sidebar.classList.toggle('open');
  }

function updateUnderline() {
  const activeBtn = document.querySelector('.button-container .Underline');
  const underline = document.getElementById('underline-indicator');
  
  if (activeBtn && underline) {
    const btnRect = activeBtn.getBoundingClientRect();
    const containerRect = activeBtn.parentElement.getBoundingClientRect();
    
    underline.style.width = `${btnRect.width}px`;
    underline.style.left = `${btnRect.left - containerRect.left}px`;
  }
}

// Reposiciona ao clicar em qualquer botão
document.querySelectorAll('.button-container button').forEach(btn => {
  btn.addEventListener('click', (e) => {
    document.querySelectorAll('.button-container button').forEach(b => b.classList.remove('Underline'));
    e.target.classList.add('Underline');
    updateUnderline();
  });
});

// Reposiciona quando redimensiona a janela
window.addEventListener('resize', updateUnderline);

// Inicializa na primeira carga
window.addEventListener('load', updateUnderline);
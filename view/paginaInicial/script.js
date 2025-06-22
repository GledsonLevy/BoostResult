document.addEventListener("DOMContentLoaded", function () {
    let dadosAluno = {}; // Variável global
    let intervaloMensagens = null; // Intervalo para auto refresh
    let ultimaMensagemId = null; // ID da última mensagem exibida

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
                console.log("importante:");
                console.log('msg');
                console.log(msg);
                console.log("daodos");
                console.log(dadosAluno);
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

    document.querySelectorAll(".alunos").forEach(button => {
        button.addEventListener("click", function () {
            const id_solicitacao = this.dataset.idSolicitacao;
            const id_destinatario = this.dataset.idDestinatario; // Corrigido aqui
            const id_remetente = this.dataset.idRemetente; // Opcional, se quiser guardar
            console.log("solicitação:" ,id_solicitacao);
            console.log("destinatario:" ,id_destinatario);
            console.log("remetente:" ,id_remetente);
            dadosAluno = { id_solicitacao, id_destinatario, id_remetente };
            console.log(dadosAluno);
            atualizarMensagens();

            // Atualiza a cada 3 segundos
            if (intervaloMensagens) clearInterval(intervaloMensagens);
            intervaloMensagens = setInterval(atualizarMensagens, 3000);

            // Abre o painel com os dados
            document.getElementById("chat-panel").style.display = "block";
            document.getElementById("destinatario_id").value = id_destinatario;
            document.getElementById("remetente_id").value = id_remetente;
            document.getElementById("solicitacao_id").value = id_solicitacao;
            abrirModalChat();
        });
    });

    

    document.querySelector(".interacao-input")?.addEventListener("submit", function (e) {
        console.log('tentativa de envio');
        e.preventDefault();
        const form = e.target;
        const mensagem = form.mensagem.value.trim();
        console.log(mensagem);
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

    function loadPageAndHighlight(button, url) {
        const iframe = document.getElementById('myIframe');
        if (iframe) iframe.src = url;

        const underline = document.getElementById('underline-indicator');
        const container = button.closest('.button-container');

        if (underline && container) {
            const rect = button.getBoundingClientRect();
            const containerRect = container.getBoundingClientRect();

            underline.style.width = rect.width + "px";
            underline.style.left = (rect.left - containerRect.left) + "px";

            setTimeout(() => {
                container.classList.add('transition');
            }, 10);

            container.querySelectorAll('button').forEach(btn => {
                btn.classList.remove('active');
            });

            button.classList.add('active');
        }
    }

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

    document.getElementById('close-mensagens-btn')?.addEventListener('click', function () {
        document.getElementById('mensagens-panel').classList.remove('open');
        document.getElementById('chat-panel').classList.remove('open');
    });

    document.getElementById('chat-btn')?.addEventListener('click', function () {
        document.getElementById('chat-panel').classList.add('open');
    });

    document.getElementById("toggleDarkMode")?.addEventListener("click", function () {
        document.body.classList.toggle("dark-mode");

        const btn = document.getElementById("toggleDarkMode");

        if (document.body.classList.contains("dark-mode")) {
            localStorage.setItem("modo", "escuro");
            btn.textContent = "Modo Claro ☀️";
            btn.style.backgroundColor = "#FAFAFA";
            btn.style.color = "#000";
        } else {
            localStorage.setItem("modo", "claro");
            btn.textContent = "Modo Escuro 🌙";
            btn.style.backgroundColor = "#000";
            btn.style.color = "#FAFAFA";
        }
    });

    const btn = document.getElementById("toggleDarkMode");
    if (localStorage.getItem("modo") === "escuro") {
        document.body.classList.add("dark-mode");
        btn.textContent = "Modo Claro ☀️";
        btn.style.backgroundColor = "#FAFAFA";
        btn.style.color = "#000";
    } else {
        btn.textContent = "Modo Escuro 🌙";
        btn.style.backgroundColor = "#000";
        btn.style.color = "#FAFAFA";
    }

    window.abrirModal = function (id) {
        document.getElementById('chat-panel').classList.add('open');
        document.getElementById('mensagens-panel')?.classList.toggle('open');
        document.getElementById('alunos-panel')?.classList.remove('open');
        document.getElementById('personais-panel')?.classList.remove('open');
        const elemento = document.getElementById(id);
        const nome = elemento?.getAttribute('value');
        document.getElementById("receberNomeUsuario").innerHTML = nome;
    };

    window.abrirModalChat = function () {
        document.getElementById('chat-panel').classList.add('open');
        document.getElementById('mensagens-panel')?.classList.toggle('open');
        document.getElementById('alunos-panel')?.classList.remove('open');
        document.getElementById('personais-panel')?.classList.remove('open');
    };
});

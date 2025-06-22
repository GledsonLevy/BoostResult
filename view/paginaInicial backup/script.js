document.addEventListener("DOMContentLoaded", function () {
    // Aqui dentro, TODO o seu código:let dadosAluno = {}; // Variável global

    document.querySelectorAll(".alunos").forEach(button => {
        button.addEventListener("click", function () {
            const id_solicitacao = this.dataset.idSolicitacao;
            const id_user = this.dataset.idUser;
            const nome = this.dataset.nome;

            dadosAluno = { id_solicitacao, id_user, nome };

            fetch("carregar_mensagens.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: new URLSearchParams({
                    id_solicitacao,
                    acao: "carregar_mensagens"
                })
            })
            .then(res => res.json())
            .then(mensagens => {
                // Limpa e popula o painel de mensagens
                const container = document.getElementById("mensagens-lista");
                container.innerHTML = "";
                mensagens.forEach(msg => {
                    const div = document.createElement("div");
                    div.classList.add("mensagem");
                    div.innerHTML = `<strong>${msg.remetente}:</strong> ${msg.texto}`;
                    container.appendChild(div);
                });

                // Abre o painel com os dados
                document.getElementById("receberNomeUsuario").innerText = nome;
                document.getElementById("destinatario_id").value = id_user;
                abrirModalChat();
            })
            .catch(err => console.error("Erro ao carregar mensagens:", err));
        });
    });

    
    // Função underline
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

    // Painéis
    /*document.getElementById('mensagens-btn')?.addEventListener('click', function () {
        document.getElementById('mensagens-panel').classList.toggle('open');
    });*/

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

    document.getElementById('close-chat-btn')?.addEventListener('click', function () {
        document.getElementById('chat-panel').classList.remove('open');
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

    // Aplicar modo salvo
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

    // Abrir modal do chat com nome do usuário
    window.abrirModal = function (id) {
        document.getElementById('chat-panel').classList.add('open');
        document.getElementById('mensagens-panel').classList.toggle('open');
        document.getElementById('alunos-panel').classList.remove('open');
        document.getElementById('personais-panel').classList.remove('open');
        const elemento = document.getElementById(id);
        const nome = elemento?.getAttribute('value');
        document.getElementById("receberNomeUsuario").innerHTML = nome;
    };

     window.abrirModalChat = function() {
    
        document.getElementById('chat-panel').classList.add('open');
        document.getElementById('mensagens-panel')?.classList.toggle('open');
        document.getElementById('alunos-panel')?.classList.remove('open');
        document.getElementById('personais-panel')?.classList.remove('open');
    };
});

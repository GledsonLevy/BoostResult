document.addEventListener("DOMContentLoaded", function () {
    // Aqui dentro, TODO o seu código:
    
    // Função underline
    function loadPageAndHighlight(button, url) {
        document.getElementById('myIframe').src = url;
        const underline = document.getElementById('underline-indicator');
        const rect = button.getBoundingClientRect();
        const containerRect = button.parentElement.getBoundingClientRect();

        underline.style.width = rect.width + "px";
        underline.style.left = (rect.left - containerRect.left) + "px";

        setTimeout(() => {
            button.parentElement.classList.add('transition');
        }, 10);

        document.querySelectorAll('.button-container button').forEach(btn => {
            btn.classList.remove('active');
        });
        button.classList.add('active');
    }

    // Painéis
    document.getElementById('mensagens-btn')?.addEventListener('click', function () {
        document.getElementById('mensagens-panel').classList.toggle('open');
    });

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

     window.abrirModalChat = function(dadosAluno) {
    // dadosAluno já é um objeto JS com as infos do PHP
        console.log(dadosAluno);
       /* document.getElementById('chat-panel').classList.add('open');
        document.getElementById('mensagens-panel')?.classList.toggle('open');
        document.getElementById('alunos-panel')?.classList.remove('open');
        document.getElementById('personais-panel')?.classList.remove('open');

        document.getElementById("receberNomeUsuario").innerHTML = dadosAluno.nome;
        document.getElementById("destinatario_id").value = dadosAluno.id_user;

        const solicitacaoInput = document.getElementById("solicitacao_id");
        if (solicitacaoInput) {
            solicitacaoInput.value = dadosAluno.id_solicitacao;
        }

        const chatBox = document.getElementById("interacao-conteudo");
        chatBox.innerHTML = "Carregando mensagens...";

        fetch("../../app/controller/carregarMensagens.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `id_user=${dadosAluno.id_user}&id_solicitacao=${dadosAluno.id_solicitacao}`
        })
        .then(response => response.text())
        .then(html => {
            chatBox.innerHTML = html;
        })
        .catch(error => {
            chatBox.innerHTML = "Erro ao carregar mensagens.";
            console.error(error);
        }); */
};
});

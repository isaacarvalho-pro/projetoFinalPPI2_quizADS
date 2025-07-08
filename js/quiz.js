let perguntas = [];
let indice = 0;
let acertos = 0;
let respostasUsuario = [];

$(document).ready(function () {
    carregarPerguntas();

    $('#btn-proxima').click(function () {
        const resposta = $('input[name="opcao"]:checked').val();
        if (resposta === undefined) {
            alert("Selecione uma opção.");
            return;
        }

        const pergunta = perguntas[indice];
        const correta = pergunta.correta;

        respostasUsuario.push({
            pergunta_id: pergunta.id,
            resposta_usuario: parseInt(resposta),
            correta: parseInt(resposta) === parseInt(correta)
        });

        if (parseInt(resposta) === parseInt(correta)) {
            acertos++;
        }

        indice++;
        if (indice < perguntas.length) {
            mostrarPergunta();
        } else {
            finalizarQuiz();
        }
    });
});

function carregarPerguntas() {
    $.get('php/perguntas.php', function (data) {
        perguntas = JSON.parse(data);
        perguntas = perguntas.sort(() => Math.random() - 0.5); // aleatoriza
        mostrarPergunta();
    });
}

function mostrarPergunta() {
    $('#resultado').hide();
    $('#btn-proxima').show();

    const p = perguntas[indice];
    $('#pergunta-texto').text(p.pergunta);

    $('#form-opcoes').html(`
        <label><input type="radio" name="opcao" value="1"> ${p.op1}</label><br>
        <label><input type="radio" name="opcao" value="2"> ${p.op2}</label><br>
        <label><input type="radio" name="opcao" value="3"> ${p.op3}</label><br>
        <label><input type="radio" name="opcao" value="4"> ${p.op4}</label><br>
    `);
}

function finalizarQuiz() {
    $('#btn-proxima').hide();
    $('#form-opcoes').hide();
    $('#pergunta-texto').hide();

    const total = perguntas.length;
    const porcentagem = Math.round((acertos / total) * 100);

    $('#resultado').html(`
        <h3>Resultado</h3>
        <p>Você acertou ${acertos} de ${total} perguntas.</p>
        <p>Pontuação: ${porcentagem}%</p>
    `).show();

    // Enviar respostas completas ao servidor
    $.post('php/responder.php', {
        respostas: JSON.stringify(respostasUsuario),
        total: total,
        acertos: acertos
    });
}

$(document).ready(function () {
    carregarPerguntas();

    $('#form-nova-pergunta').submit(function (e) {
        e.preventDefault();

        $.post('php/admin/add_pergunta.php', $(this).serialize(), function (resposta) {
            alert(resposta);
            $('#form-nova-pergunta')[0].reset();
            carregarPerguntas();
        });
    });
});

function carregarPerguntas() {
    $.get('php/admin/listar_perguntas.php', function (dados) {
        const perguntas = JSON.parse(dados);
        let html = '';

        perguntas.forEach(p => {
            html += `
                <div class="pergunta-item">
                    <strong>${p.pergunta}</strong><br>
                    1) ${p.op1} <br>
                    2) ${p.op2} <br>
                    3) ${p.op3} <br>
                    4) ${p.op4} <br>
                    Correta: ${p.correta} <br>
                            <button onclick="editarPergunta(${p.id})">Editar</button>
                    <button onclick="deletarPergunta(${p.id})">Excluir</button>
                    <hr>
                </div>
            `;
        });

        $('#lista-perguntas').html(html);
    });
}

function deletarPergunta(id) {
    if (confirm("Tem certeza que deseja excluir esta pergunta?")) {
        $.post('php/admin/deletar_pergunta.php', { id: id }, function (resposta) {
            alert(resposta);
            carregarPerguntas();
        });
    }
}

function editarPergunta(id) {
    $.get(`php/admin/listar_perguntas.php`, function (dados) {
        const perguntas = JSON.parse(dados);
        const p = perguntas.find(item => item.id == id);

        if (!p) return alert("Pergunta não encontrada.");

        const form = $('#form-editar-pergunta');
        form.find('input[name="id"]').val(p.id);
        form.find('input[name="pergunta"]').val(p.pergunta);
        form.find('input[name="op1"]').val(p.op1);
        form.find('input[name="op2"]').val(p.op2);
        form.find('input[name="op3"]').val(p.op3);
        form.find('input[name="op4"]').val(p.op4);
        form.find('select[name="correta"]').val(p.correta);

        $('#form-editar').show();
    });
}

$('#form-editar-pergunta').submit(function (e) {
    e.preventDefault();

    $.post('php/admin/editar_pergunta.php', $(this).serialize(), function (resposta) {
        alert(resposta);
        $('#form-editar-pergunta')[0].reset();
        $('#form-editar').hide();
        carregarPerguntas();
    });
});


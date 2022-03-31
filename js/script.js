$(document).ready(function () {
    //inicializar page
    let beneficiarios = [];
    let tblBeneficiarios = $('#tblBeneficiarios');
    let qtd = document.getElementById('qtd');
    let btnJsonLink = document.getElementById('btnJsonLink');
    let btnReset = document.getElementById('btnReset');
    tblBeneficiarios.hide();
    btnReset.style.display = 'none';
    btnJsonLink.style.display = 'none';
    let idade = document.getElementById('bIdade');
    idade.onkeypress = function (e) {
        if (e.keyCode < 48 || e.keyCode > 57) {
            e.preventDefault();
        }
    };
    qtd.innerHTML = "Quantidade de beneficiários: " + beneficiarios.length;


    //Enviar dados para JSON
    function SendJson(beneficiarios) {
        $.ajax({
            url: '/controllers/createJson.php',
            type: 'POST',
            data: {
                beneficiarios: beneficiarios,
                amount: beneficiarios.length
            },
            success: function (data) {
                $('#mensagens').html('');
                btnJsonLink.style.display = 'block';
                //change json link href to data
                $('#jsonlink').attr('href', data);
                $('#jsonlink').focus();
            }
        })
    }


    //fill table with data
    function BuildTable(data) {
        let total = 0;
        let tbody = document.getElementById('tbody');
        tbody.innerHTML = "";
        for (let i = 0; i < data.length; i++) {
            let b = JSON.parse(data[i]);

            let row = document.createElement('tr');
            let cell = document.createElement('td');
            cell.innerHTML = b.nome;
            row.appendChild(cell);
            cell = document.createElement('td');
            cell.innerHTML = b.idade;
            row.appendChild(cell);
            cell = document.createElement('td');
            cell.innerHTML = b.plano.nome;
            row.appendChild(cell);
            cell = document.createElement('td');
            cell.innerHTML = b.valor.toFixed(2).replace('.', ',');
            total += b.valor;
            row.appendChild(cell);
            tbody.appendChild(row);
            let btn = document.createElement('button');
            cell = document.createElement('td');
            btn.innerHTML = "Delete";
            btn.className = 'btn btn-danger btn-block w-100 btn btn-outline-danger d-flex align-items-center justify-content-center align-self-center';
            btn.innerHTML = '<p class="text-center">Deletar</p>';
            btn.onclick = function () {
                if(confirm('Deseja realmente deletar este beneficiário?')){
                    let index = beneficiarios.indexOf(b);
                    beneficiarios.splice(index, 1);
                    $("#res").html(BuildTable(beneficiarios));
                    if(beneficiarios.length === 0){
                        btnReset.style.display = 'none';
                        tblBeneficiarios.hide();
                        btnJsonLink.style.display = 'none';
                    }
                    btnReset.style.display = 'block';
                    SendJson(beneficiarios);
                    qtd.innerHTML = "Quantidade de beneficiários: " + beneficiarios.length;
                    btnReset.style.display = 'block';
                    btnJsonLink.style.display = 'block';
                }
            };
            row.appendChild(btn);
        }
        let row = document.createElement('tr');
        let cell = document.createElement('td');
        cell.innerHTML = "Total";
        row.appendChild(cell);
        row.style.fontWeight = 'bold';
        row.style.fontSize = '20px';
        row.className = 'bg-success';
        cell = document.createElement('td');
        cell.innerHTML = "";
        row.appendChild(cell);
        cell = document.createElement('td');
        cell.innerHTML = "";
        row.appendChild(cell);
        cell = document.createElement('td');
        cell.innerHTML = total.toFixed(2).replace('.', ',');
        row.appendChild(cell);
        tbody.appendChild(row);
        return tbody;
    }

    //Limpar Array
    $('#btnReset').click(function () {
        beneficiarios = [];
        qtd.innerHTML = "Quantidade de beneficiários: " + beneficiarios.length;
        tblBeneficiarios.hide();
        btnJsonLink.style.display = 'none';
    });

    //insert a Beneficiario to list of beneficiarios
    $("#FormBeneficiario").submit(function (e) {
        e.preventDefault();
        let nome = document.getElementById('bNome').value;
        let idade = document.getElementById('bIdade').value;
        idade = idade.replace(/\D/g, '');
        let plano = document.getElementById('bPlano').value;
        if(plano > 6){
            $("#mensagens").html("<div class='alert alert-danger' role='alert'>Plano inválido, recarregue a página.</div>");
            return;
        }
        if (nome === '' || idade === '' || plano === '') {
            $("#mensagens").html("<div class='alert alert-danger' role='alert'>Preencha todos os campos</div>");
            return;
        }
        let beneficiario = {
            nome: nome,
            idade: idade,
            plano: plano
        };
        $.ajax({
            url: '/controllers/newBeneficiario.php',
            type: 'POST',
            data: {
                beneficiario: beneficiario,
                beneficiarios: beneficiarios
            },
            success: function (data) {
                if (data === false) {
                    $("#mensagens").html('<div class="alert alert-danger" role="alert">Plano Não existe</div>');
                } else {
                    beneficiarios.push(data);
                    qtd.innerHTML = "Quantidade de beneficiários: " + beneficiarios.length;
                    //format as table
                    $("#res").html(BuildTable(beneficiarios));
                    tblBeneficiarios.show();
                    btnReset.style.display = 'block';
                    SendJson(beneficiarios);
                }
            },
            beforeSend: function () {
                $("#mensagens").html("<div class='spinner-border text-white' role='status'><span class='sr-only'></span></div>");
            },
        })
    });
});

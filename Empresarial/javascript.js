const delay = (delayInms) => {
    return new Promise(resolve => setTimeout(resolve, delayInms)); // instancia uma função basica de Tempo_parado do JS, n mexer 
};

function passou(){ //
    document.getElementById('botao').style.fontSize='120%'
    document.getElementById('botao').style.border='1px solid black'
}
function npassou(){
    document.getElementById('botao').style.fontSize='13px'
    document.getElementById('botao').style.border='1px solid black'
}
function pg(){ // manda na url o HTTPS que vc quiser
    window.location.assign("http://localhost/projetinho/Cadastrar.html")
}

document.addEventListener('DOMContentLoaded',function(){
    const urlParams = new URLSearchParams(window.location.search);
    const aconteceu = urlParams.get('aconteceu'); // n mexer
    
    if (aconteceu === 'incorrect'){ // erro pro login 
        errop.textContent = 'senha incorreta';
        errop.style.padding='5px';
        errop.style.backgroundColor='rgb(180,0,0)';
        errop.style.borderRadius='5px';
        setTimeout(() => {
        // espera 2 segundos e faz oq estiver dentro da funcao 
        errop.textContent = '';
        errop.style.padding='0%';
        }, 2000);
        setTimeout(()=>{
            window.location.assign("http://localhost:8080/TCC-main/escola/cadescola.php")
        },2000)

    }else if (aconteceu === 'nexist'){ // erro pro cadastro
        
        // setTimeout(()=>{
        //     window.location.assign("http://localhost:8080/TCC-main/escola/cadescola.php")
        // },2500)
    }else if (aconteceu === 'tiponexist'){
        $("#teste").empty()
        $("#teste").append("<div class='alert alert-danger d-flex align-items-center mt-2 ms-2 me-2' role='alert'><svg class='bi flex-shrink-0 me-2' style='height: 30px !important; width: 40px !important;' role='img' aria-label='Danger:'><use xlink:href='#exclamation-triangle-fill'/></svg><div>Selecione um tipo de campeonato!</div></div>");
        $("#teste").fadeOut(2500);
        setTimeout(()=>{
            window.location.assign("http://localhost:8080/TCC-main/escola/cadescola.php")
        },2500)
    }
    else if (aconteceu === 'removido'){
        $("#teste").empty()
        $("#teste").append("<div class='alert alert-success d-flex align-items-center mt-2 ms-2 me-2' role='alert'><svg class='bi flex-shrink-0 me-2' style='height: 30px !important; width: 40px !important;' role='img' aria-label='Success:'><use xlink:href='#check-circle-fill'/></svg><div>Campeonato removido com sucesso!</div>");
        //$("#teste").append("<div class='alert alert-primary d-flex align-items-center mt-2 ms-2 me-2' role='alert'><svg class='bi flex-shrink-0 me-2' style='height: 30px !important; width: 40px !important;' role='img' aria-label='Info:'><use xlink:href='#info-fill'/></svg><div>Campeonato removido com sucesso!</div>");
        $("#teste").fadeOut(2500);
        setTimeout(()=>{
            window.location.assign("http://localhost:8080/TCC-main/escola/cadescola.php")
        },2500)
    }else if (aconteceu === 'criado'){
        $("#teste").empty()
        $("#teste").append("<div class='alert alert-success d-flex align-items-center mt-2 ms-2 me-2' role='alert'><svg class='bi flex-shrink-0 me-2' style='height: 30px !important; width: 40px !important;' role='img' aria-label='Success:'><use xlink:href='#check-circle-fill'/></svg><div>Campeonato criado com sucesso!</div>");
        $("#teste").fadeOut(2500);
        setTimeout(()=>{
            window.location.assign("http://localhost:8080/TCC-main/php/escola/cadescola.php")
        },2500)
    }
});

async function entrar() {
    let Login = document.getElementById('Login').value;
    let senha = document.getElementById('senha').value;
    let response = await fetch(`../Banco/LOGIN.php`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ Login, senha })
    });
    let data = await response.json();
    if (data.status === true) {
        window.location.assign('http://localhost:8080/TCC-main/php/escola/cadescola.php')
    } else {
        $("#aviso").show();
        $("#aviso").html("<div class='alert alert-danger' role='alert'><span class='material-icons'>error</span> Erro: "+data.message+"</div>");
        $("#aviso").fadeOut(2500);
    }
}

async function Cadastrar() {
    
    let Nome = $('input[name=Nome]').val();
    let Data = $('input[name=Data]').val();
    let Tipo = $('select[name=Tipo]').val();
    let Quantidade = $('input[name=Quantidade]').val();
    let Nome_Time = $('input[Nome_Time]').val();
    let Serie = $('input[Serie]').val();

    // Pega todos os inputs com name="Nome_jogador" e armazena os valores em um vetor usando jQuery
    let jogadores = [];
    $('.jogador').each(function() {
        let nome = $(this).find('input[name="jogador_nome"]').val().trim();
        let altura = $(this).find('input[name="jogador_altura"]').val().trim();
        let idade = $(this).find('input[name="jogador_idade"]').val().trim();

        if (nome && altura && idade) {
            let jogador = {
                nome: nome,
                altura: parseFloat(altura),
                idade: parseInt(idade)
            };
            jogadores.push(jogador);
        }
    });
    console.log(jogadores); 


    let dados_enviar = {
        Nome: Nome,
        Data: Data,
        Tipo: Tipo,
        Quantidade: Quantidade,
        Jogadores: jogadores,
        Nome_Time: Nome_Time,
        Serie: Serie
    }

    console.log(dados_enviar)
    /*
    let response = await fetch(`../../Banco/CADASTRAR_CAMP.php`,{
        method: 'POST',
        headers:{
            'Content-type': 'aplication/json'
        },
        body: JSON.stringify(dados_enviar)
    })
    let data = await response.json();
    if (data.status === true){
    }else {
        $("#aviso").show();
        $("#aviso").html("<div class='alert alert-danger' role='alert'><span class='material-icons'>error</span> Erro: "+data.message+"</div>");
        $("#aviso").fadeOut(2500);
    }*/
}

var num2 =1;

function addjogador(){
    $(document).off('click','.btn-primary').on('click', '.btn-primary', function () {
        // Encontra o modal mais próximo
        let modal = $(this).closest('.modal');
        // Conta os inputs dentro do modal
        let numeroInputs = modal.find('input[type="text"]').length;

        if (numeroInputs >= 15) {
            alert("Já existem 7 jogadores cadastrados. Não é possível adicionar mais.");
        } else {
            modal.find('.modal-body').append(`
                <div class='mb-3 row jogador'>
                    <div class="col">
                        <input type="text" class="form-control" name="jogador_nome" placeholder="Digite o nome">
                    </div>
                    <div class="col">
                        <input type="number" class="form-control" name="jogador_altura" placeholder="Digite a altura">
                    </div>
                    <div class="col">
                        <input type="number" class="form-control" name="jogador_idade" placeholder="Digite a idade">
                    </div>
                </div>
            `);
        }
    });
}

function ProximoPasso() {
    let quantidadeTimes = +$("input[name='Quantidade']").val(); // o '+' na frente faz com que ele seja interpretado como um inteiro
    for (let i = 1; i <= quantidadeTimes; i++) {
        let botaoVoltar = `<button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#Cadatrar_jogadores${i - 1}">voltar</button>`;
        let botaoProximo = `<button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#Cadatrar_jogadores${i + 1}">próximo</button>`;
        let botaoAddJogador = `<button class="btn btn-primary" onclick="addjogador()">Adicionar jogador</button>`;
        let botaoCadastrarFinal = `<button class="btn btn-success" onclick="Cadastrar()">Cadastrar</button>`;
        let txt = 'Informações dos jogadores.';
        // Monta os botões dependendo do modal
        let botoesFooter = "";
    
        if (i === 1) {
            // Primeiro modal — sem voltar
            botoesFooter = `${botaoProximo} ${botaoAddJogador}`;

        } else if (i === quantidadeTimes) {
            // Último modal — sem próximo, com botão final
            botoesFooter = `${botaoVoltar} ${botaoAddJogador} ${botaoCadastrarFinal}`;
       
        } else {
            // Modais intermediários
            botoesFooter = `${botaoVoltar} ${botaoProximo} ${botaoAddJogador}`;

        }
    
        $("#ModalCad3").append(`
            <div class="modal" id="Cadatrar_jogadores${i}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                    <h1 class="modal-title fs-5" id="LabelCadJog${i}">Cadastrar Jogadores/Time ${i}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>    
                    </div>
                    <div class="modal-body" id="ModCad${i}">
                        <div class="mb-3">
                        <label for="Nome_Time" class="col-form-label">Digite o nome do time</label><span> Exemplo (3°B ou 3° info A)</span>
                        <input type="text" class="form-control" name="Nome_Time" placeholder="Digite o nome do time...">
                        </div>
                        <div class="mb-3">
                        <label for="Serie" class="col-form-label">Digite a série do time</label>
                        <input type="text" class="form-control" name="Serie" placeholder="Digite a série do time...">
                        </div>
                        <div class="mb-3 jogador row">
                            <p class="col-form-label">${txt}</p>
                            <div class="col input-group">
                                <input type="text" class="form-control" name="jogador_nome" placeholder="Nome...">
                            </div>
                            <div class="col">
                                <input type="number" class="form-control" name="jogador_altura" placeholder="Altura...">
                            </div>
                            <div class="col">
                                <input type="number" class="form-control" name="jogador_idade" placeholder="Idade...">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        ${botoesFooter}
                    </div>
                </div>
                </div>
            </div>
        `);
    }
    
    $("#exampleModal").modal('hide');
    console.log(num2)
    $("#Cadatrar_jogadores" + num2).modal('show');
    num2++;
}

// const { NOME, ENDERECO } = data[0];
// $("#select").append(`<option value="{nome}">{endereco}</option`);
// let options = DataTransfer.filter((item) => item.ativo === 'S');
// $("#select").html(options);

// const exampleModal = document.getElementById('exampleModal')
// if (exampleModal) {
//   exampleModal.addEventListener('show.bs.modal', event => {
//     // Button that triggered the modal
//     const button = event.relatedTarget
//     // Extract info from data-bs-* attributes
//     const recipient = button.getAttribute('data-bs-whatever')
//     // If necessary, you could initiate an Ajax request here
//     // and then do the updating in a callback.

//     // Update the modal's content.
//     const modalTitle = exampleModal.querySelector('.modal-title')
//     const modalBodyInput = exampleModal.querySelector('.modal-body input')

//     modalTitle.textContent = `New message to ${recipient}`
//     modalBodyInput.value = recipient
//   })
// }
// async function cadastrar(){
//     console.log('passo1')
//     let response  = await fetch(`../escola/cadastrar.php`);
//     console.log('passou')
//     let data = await response.json();
//     console.log(data);
// }

// if (window.jQuery) {
//     console.log("jQuery está OK");
// } else {
//     console.log("jQuery NÃO carregou");
// }
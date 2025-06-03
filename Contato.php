<?php

$Nome       = $_POST['Nome'];
$Telefone   = $_POST['Telefone'];
$Email      = $_POST['Email'];
$Assunto    = $_POST['Assunto'];
$From       = 'mateust.modesto@gmail.com';
$nome_cliente = "[Nome do Cliente]"; // Substitua com o nome real do cliente
$whatsapp_numero = "(XX) XXXXX-XXXX"; // Substitua pelo número real do WhatsApp
$site_url = "http://www.seusite.com.br"; // Substitua pelo URL do seu site

$email_mensagem = "
    <html>
    <head>
        <title>Seu interclasse mais organizado começa aqui! ⚽📊</title>
    </head>
    <body>
        <p>Olá $nome_cliente!</p>
        <p>Primeiramente, muito obrigado por entrar em contato com a gente! 😊<br>
        É um prazer saber que você está interessado em organizar seu interclasse com mais praticidade e eficiência.</p>
        
        <p>Aqui na <strong>InterHub</strong>, você consegue gerenciar tudo de forma simples e rápida:</p>
        <ul>
            <li>✅ Criar campeonatos</li>
            <li>✅ Adicionar times e jogadores</li>
            <li>✅ Fazer sorteios automáticos de grupos e partidas</li>
            <li>✅ Acompanhar toda a organização direto do site</li>
        </ul>

        <p>Assim que fecharmos o contrato, a gente cria um acesso exclusivo pra você começar a usar todos esses recursos com liberdade total! 🚀</p>
        
        <p>Temos dois planos disponíveis:</p>
        <ul>
            <li>💳 <strong>Plano Anual:</strong> R$ 100,00 (acesso por 12 meses)</li>
            <li>💳 <strong>Plano Mensal:</strong> R$ 50,00 (acesso por 30 dias)</li>
        </ul>
        
        <p>Se quiser seguir com a contratação ou tiver alguma dúvida, é só responder este e-mail ou chamar a gente no WhatsApp 📲 pelo número que está aqui embaixo. Estamos prontos pra te ajudar! 😉</p>
        
        <p>Um abraço,<br>
        <strong>Lucas Biral</strong><br>
        <strong>InterHub</strong></p>
        
        <p>📞 WhatsApp: $whatsapp_numero</p>
        <p>🌐 <a href=\"$site_url\">$site_url</a></p>
    </body>
    </html>
";

// Defina o endereço de e-mail de destino
$email_destino = "cliente@exemplo.com"; // Substitua pelo e-mail real do cliente

// Assunto do e-mail
$assunto = "Seu interclasse mais organizado começa aqui! ⚽📊";

// Cabeçalhos necessários para enviar um e-mail em HTML
$cabecalhos = "MIME-Version: 1.0" . "\r\n";
$cabecalhos .= "Content-type: text/html; charset=UTF-8" . "\r\n";
$cabecalhos .= "From: contato@interhub.com.br" . "\r\n";  // Substitua pelo seu e-mail de envio
$cabecalhos .= "Reply-To: contato@interhub.com.br" . "\r\n";  // Substitua pelo seu e-mail de resposta

// Envia o e-mail
if(mail($email_destino, $assunto, $email_mensagem, $cabecalhos)) {
    echo "E-mail enviado com sucesso!";
} else {
    echo "Falha ao enviar o e-mail.";
}

echo $Nome.'</br>';
echo $Email.'</br>';
echo $Telefone.'</br>';
echo $Assunto.'</br>';

$headers    = "MIME-Version: 1.1\n";
$headers    .= "Content-type: text/html; charset=utf-8\n";
$headers    .= "From: Teste Site <$From>\n";
$headers    .= "Return-Path: $From\n";
$headers    .= "Reply-to: $Email\n";

mail($Email, $Mensagem, $headers, $From);

?>
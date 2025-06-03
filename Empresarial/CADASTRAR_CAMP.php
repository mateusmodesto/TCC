<?php
session_start();
require_once "../conexao.php";

if (!isset($_SESSION['login'])) {
    header('Location: ../login.php');
    exit();
}
// cadastrar o campeonato, depois cadastrar o nome, série e a FKID_CAMP nos times e por fim os jogadores altura, idade, nome e FKID_TIME
function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Pega o JSON enviado via POST
$input = file_get_contents('php://input');
$data = json_decode($input, true);

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Methods: POST');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Max-Age: 86400');

if (
    empty($data['Nome']) || 
    empty($data['Tipo']) || 
    empty($data['Nome_Time']) || 
    empty($data['Serie']) || 
    empty($data['Quantidade']) || 
    empty($data['Data']) || 
    empty($data['Jogadores']) || 
    !is_array($data['Jogadores'])
) {
    echo json_encode([
        'status' => false,
        'message' => 'Todos os campos são obrigatórios e jogadores devem ser uma lista.'
    ]);
    exit;
}

try {
    $nome = test_input($data['Nome']);
    $tipo = test_input($data['Tipo']);
    $quantidade = (int) $data['Quantidade'];
    $data_campeonato = test_input($data['Data']);

    // Insere o campeonato
    $stmt = $con->prepare("INSERT INTO campeonato (nome, tipo, quantidade, data) VALUES (?, ?, ?, ?)");
    if (!$stmt) throw new Exception("Erro ao preparar a query do campeonato: " . $con->error);

    $stmt->bind_param("ssis", $nome, $tipo, $quantidade, $data_campeonato);

    if (!$stmt->execute()) {
        throw new Exception("Erro ao executar a query do campeonato: " . $stmt->error);
    }

    // Pega o ID do campeonato inserido
    $campeonato_id = $stmt->insert_id;
    $stmt->close();
    
    // insere os times
    $stmt_time = $con->prepare("INSERT INTO times (FKID_CAMP, NOME, SERIE) VALUES (?, ?, ?)");
    if (!$stmt_time) throw new Exception("Erro ao preparar a query do time: " . $con->error);

    $nome_time = test_input($data['Nome_Time']);
    $serie = test_input($data['Serie']);

    $stmt_time->bind_param("iss", $campeonato_id, $nome_time, $serie);

    if (!$stmt_time->execute()) {
        throw new Exception("Erro ao executar a query do time: " . $stmt_time->error);
    }

    $time_id = $stmt_time->insert_id;
    $stmt_time->close();

    // Insere os jogadores
    $stmt_jogador = $con->prepare("INSERT INTO jogadores (FKID_TIME, NOME, IDADE, ALTURA) VALUES (?, ?, ?, ?)");
    if (!$stmt_jogador) throw new Exception("Erro ao preparar a query dos jogadores: " . $con->error);

    foreach ($data['Jogadores'] as $jogador_str) {
        // Exemplo do formato: "Jogador: Guilherme Baraldi; 15; 1.60;"
        // Extrai o nome, idade e altura
        if (preg_match('/Jogador:\s*(.*?);\s*(\d+);\s*([\d\.]+);/', $jogador_str, $matches)) {
            $nome_jogador = test_input($matches[1]);
            $idade = (int)$matches[2];
            $altura = (float)$matches[3];

            $stmt_jogador->bind_param("isid", $time_id, $nome_jogador, $idade, $altura);
            if (!$stmt_jogador->execute()) {
                throw new Exception("Erro ao inserir jogador $nome_jogador: " . $stmt_jogador->error);
            }
        } else {
            // Caso o formato do jogador esteja errado
            throw new Exception("Formato inválido no jogador: $jogador_str");
        }
    }

    $stmt_jogador->close();
    $con->close();

    echo json_encode([
        'status' => true,
        'message' => 'Campeonato e jogadores cadastrados com sucesso!'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'status' => false,
        'message' => 'Erro: ' . $e->getMessage()
    ]);
    exit;
}
?>

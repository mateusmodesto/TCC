<?php
session_start();
require_once "../conexao.php";

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if(empty($data['Login']) || empty($data['senha'])){
        echo json_encode(array('message' => 'Dados faltando!', 'status' => false));
        exit();
    }

    try{
        $senha = test_input($data['senha']);
        $login = test_input($data['Login']);

        $stm = $con->prepare("SELECT * FROM `escolas` WHERE NOME = ? AND SENHA = ?");

        if ($stm === false){
            die("variavel prepare() falhou" . htmlspecialchars($con->error));
        }

        $stm->bind_param("ss",$login,$senha); // nome de usuário como parametro para a consulta ("s" significa que é para ser tratado com uma string)
        $stm->execute();
        $result = $stm->get_result();

        if ($result === false){
            die("variavel get_result() falhou" . htmlspecialchars($con->error));
        }

        if ($result->num_rows > 0){
            while($user = $result->fetch_assoc()){
                if($senha == $user['SENHA']){
                    $_SESSION['login'] = $login;
                    echo json_encode(array('status' => true));
                    exit();
                }
            }
        }
        else{
            echo json_encode(array('message' => 'Senha ou usuário incorretos!', 'status' => false));
            exit();
        }
        $stm->close();
        $con->close();
    }
    catch (Exception $Ex){
        echo json_encode(array('message' => 'Erro ao selecionar dados da escola '.$Ex, 'status' => false));
        exit();
    }
}else{
    echo json_encode(array('message' => 'Método de requisição inválido!', 'status' => false));
    exit();
}
?>
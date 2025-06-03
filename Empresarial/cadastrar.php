<?php

session_start();
require_once "../../conexao.php";

if(!isset($_SESSION['login'])){
     header('Location: ../login.php');
     exit();
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// ini_set('display_errors',1);
// error_reporting(E_ALL);

if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    try{
        $Nome = test_input($_POST['Nome']);
        $Tipo = test_input($_POST['Tipo']);
        $Quantidade = test_input($_POST['Quantidade']);
        $Data = test_input($_POST['Data']);
        
        if($Tipo == null){
            header('Location: cadescola.php?aconteceu=tiponexist');
            exit(); // pique o return do JS
        }

        $sql = "SELECT ID_ESCOLA FROM escolas WHERE NOME = '".$_SESSION['login']."'";
        $result = $con->query($sql);
        if (!$result) {
            throw new Exception("Erro ao preparar a query: " . $con->error);
        }
        $row = $result->fetch_assoc();
        $ID_ESCOLA = $row['ID_ESCOLA'];

        // Agora insira os dados no campeonato com o ID_ESCOLA recuperado
        
        $sql_insert = "INSERT INTO campeonato (FKID_ESCOLAS, NOME, TIPO, QUANTIDADE, DATA) VALUES (?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql_insert);
        if (!$stm) {
            throw new Exception("Erro ao preparar a query: " . $con->error);
        }
        $stmt->bind_param("issis", $ID_ESCOLA, $Nome, $Tipo, $Quantidade, $Data);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            header('Location: cadescola.php?aconteceu=criado');
        } else {
            echo "Erro ao cadastrar!";
        }
        $stmt->close();
        $con->close();
    }
    catch (Exception $Ex){
        print("Erro na inserção: ".$Ex);
    }

}else{
    echo 'Request method is not POST!';
}
?>
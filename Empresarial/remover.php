<?php
session_start();
require_once "../../conexao.php";
if(!isset($_SESSION['login'])){
     header('Location: ../login.php');
     exit();
}
else{
    try{
        $remover = $_POST['remover'];
        $delete = "DELETE FROM campeonato WHERE ID_CAMP = ?";
        $stmt = $con->prepare($delete);
        $stmt->bind_param("s", $remover);
        $stmt->execute();
        header('Location: cadescola.php?aconteceu=removido');
    }
    catch(Exception $ex){
        echo $ex;
    }
}
?>
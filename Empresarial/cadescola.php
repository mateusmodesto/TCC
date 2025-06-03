<?php
session_start();
require "../../conexao.php";
date_default_timezone_set('America/Sao_Paulo'); // passa como Horário local o de São Paulo

if(!isset($_SESSION['login'])){
     header('Location: ../login.php');
     exit();
}
  try{
    $stmt=$con->prepare("SELECT a.*, DATE_FORMAT(a.DATA, '%d/%m/%Y') AS Data_format from campeonato a 
    join escolas b on a.FKID_ESCOLAS = b.ID_ESCOLA 
    where b.NOME = '".$_SESSION['login']."' order by ID_CAMP desc;");
    $stmt->execute();
    $campeonatos=$stmt->get_result();
    $dados = [];
    if($campeonatos->num_rows>=1){
      while ($row = mysqli_fetch_assoc($campeonatos)) {
        $dados[] = $row; 
      }
    }
  }
  catch (Exception $Ex) {
      echo $Ex;
  }
?>
<!DOCTYPE html>
<html lang='pt-br'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='shortcut icon' href='../../Imagens/campeonato.png' type='Icon'>
    <!-- Link Bootstrap -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH' crossorigin='anonymous'>
    <title>Campeonatos</title>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js'></script>
    <script src="../../javascript.js?a=<?php echo time() ?>"></script>
</head>
<body class='bg-secondary'>
    <nav class='navbar navbar-expand-lg bg-dark border-bottom border-body' data-bs-theme='dark'>
    <div class='container-fluid'>
      <div class='collapse navbar-collapse' id='navbarColor01'>
        <ul class='navbar-nav me-auto mb-2 mb-lg-0'>
          <li class='nav-item'>
            <a class='nav-link' aria-current='page' href='../index.php'>Home</a>
          </li>
          <li class='nav-item'>
            <a class='nav-link' href='../../sair.php'>Sair</a>
          </li>
        </ul>
      </div>
    </div>
        <button class='btn btn-outline-success me-3' data-bs-toggle='modal' data-bs-target='#exampleModal'>Criar</button>
        <button class='btn btn-outline-danger me-4' data-bs-toggle='modal' data-bs-target='#alterar'>Remover</button>
    </nav>

    <!-- Alert-->
    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
      <symbol id="info-fill" viewBox="0 0 16 16">
        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
      </symbol>
      <symbol id="check-circle-fill" viewBox="0 0 16 16">
        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
      </symbol>
      <symbol id="exclamation-triangle-fill" viewBox="0 0 16 16">
        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
      </symbol>
    </svg>
    <div id="teste">
    </div>

    <!-- Tabela com os campeonatos -->
    <h1 class='text-center mt-4 mb-5'> Campeonatos da Escola: <?php echo htmlspecialchars($_SESSION['login']) ?></h1>
      <?php
      if($campeonatos->num_rows>=1){
        echo "<div class='container'>
        <div class='row justify-content-center'>";
foreach ($dados as $row) {
    echo "
    <div class='col-md-4 mb-4'>
        <div class='card h-100'>
            <div class='card-body'>
                <h5 class='card-title'>ID: ".htmlspecialchars($row['ID_CAMP'])."</h5>
                <p class='card-text'><strong>Nome:</strong> ".htmlspecialchars($row['NOME'])."</p>
                <p class='card-text'><strong>Quantidade:</strong> ".htmlspecialchars($row['QUANTIDADE'])."</p>
                <p class='card-text'><strong>Data:</strong> ".$row['Data_format']."</p>
                <p class='card-text'><strong>Tipo:</strong> ".htmlspecialchars($row['TIPO'])."</p>
                <!--
                <form action='../index.php' method='POST'>
                    <input type='hidden' name='ID_CAMP' value='".htmlspecialchars($row['ID_CAMP'])."'>
                    <button type='submit' class='btn btn-outline-secondary w-100'>Informações</button>
                </form>
                -->
            </div>
        </div>
    </div>";
}
echo "</div></div>";
} else {
    echo '
    <div class="card" style="width: 22rem; margin:auto;">
        <div class="card-body">
            <h5 class="card-title">Nenhum campeonato cadastrado</h5>
            <p class="card-text">Deseja criar um campeonato!? Basta clicar em "Criar" no menu lateral direito superior!</p>
        </div>
    </div>';
}

      ?>
    <!-- Modal Cadastrar-->
    <div class='modal' id='exampleModal' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
    <div class='modal-dialog modal-dialog-centered'>
      <div class='modal-content'>
        <div class='modal-header'>
          <h1 class='modal-title fs-5' id='exampleModalLabel'>Criar Campeonato</h1>
          <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
        </div>
        <div class='modal-body'>
            <div class='mb-3'>
              <label for='recipient-name' class='col-form-label'>Nome:</label>
              <input type='text' class='form-control' name='Nome' placeholder="Digite o nome do campeonato..." required>
            </div>
            <div class='mb-3'>
              <label for='recipient-name' class='col-form-label'>Tipo:</label>
              <select id='Tipo' name='Tipo' class='form-control' required>
                <option value='Empyt' selected disabled> - </option>
                <option value='Copa'> Copa </option>
                <option value='Mata-Mata'> Mata-Mata </option>
              </select>
            </div>
            <div class='mb-3'>
              <label for='recipient-name' class='col-form-label'>Quantidade de Times:</label>
              <input type='number' class='form-control' name='Quantidade' id='recipient-name' placeholder="Digite a quantidade de times..." step='2' min='2' max='20' required>
            </div>
            <div class='mb-3'>
              <label for='recipient-name' class='col-form-label'>Data:</label>
              <input type='date' class='form-control' name='Data' id='recipient-name' min="<?php echo date('Y-m-d'); ?>" maxlength="10" required>
            </div>
        </div>
        <div class='modal-footer'>
          <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
          <a id='cad_new_camp' class='btn btn-primary' onclick='ProximoPasso()'>Proximo passo</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Cadastrar PT-3 -->
   <div id="ModalCad3"> </div>

  <!-- Modal Remover-->
  <div class='modal fade' id='alterar' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
    <div class='modal-dialog modal-dialog-centered'>
      <div class='modal-content'>
        <div class='modal-header'>
          <h1 class='modal-title fs-5' id='exampleModalLabel'>Remover Campeonato</h1>
          <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
        </div>
        <div class='modal-body'>
        <form method='POST' action='remover.php'>
            <div class='mb-3'>
              <label for='recipient-name' class='col-form-label'>Selecione o Campeonato para remover:</label>
              <?php
                echo "<select id='Tipo' name='remover' class='form-control'>";
                foreach ($dados as $row) {
                  echo '<option value="' . htmlspecialchars($row['ID_CAMP']) . '">' . htmlspecialchars($row['NOME']) . '</option>';
                }
                echo '</select>'; 
              ?>
            </div>
        </div>
        <div class='modal-footer'>
          <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
          <button id='cad_new_camp' type='submit' class='btn btn-primary'>Remover</button>
          </form>
        </div>
      </div>
    </div>
  </div>

<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz' crossorigin='anonymous'></script>
</body>
</html>
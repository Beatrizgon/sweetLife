<?php
include 'db_connect.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro - Sweet Life</title>
  <link rel="shortcut icon" href="img/SFLogo.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="css/Cadastro.css">
</head>

<body>
  <nav class="navbar col-12 position-relative navbar-expand-lg navbar-light bg-light border border-dark"
    style="z-index: 999;">
    <div class="container-fluid col-11 m-auto">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <figure><a href="index.php">
          <img src="img/SFLogo.png" id="Logo">
        </a>
      </figure>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="index.php" style="color: rgb(0, 0, 0) ">Início</a>
          </li>
      </div>
  </nav><br><br><br><br>
  <div id="successMessage" class="text-success" style="display: none; font-weight: bold; margin-top: 10px;"></div>

  <div id="main-container">
    <h1>Cadastre-se</h1>
    <form id="register-form" method="post" action="Cadastro.php">
      <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $nome = $_POST['nome'];
        $dataNasc = $_POST['dataNasc'];
        $nomeMat = $_POST['nomeMat'];
        $cpf = $_POST['cpf'];
        $email = $_POST['email'];
        $cel = $_POST['cel'];
        $tel = $_POST['tel'];
        $cep = $_POST['cep'];
        $rua = $_POST['rua'];
        $bairro = $_POST['bairro'];
        $uf = $_POST['uf'];
        $comp = $_POST['comp'];
        $genero = $_POST['genero'];
        $username = $_POST['username'];
        $password = $_POST['password'];


        $perfil = "comum";

        $sql = "INSERT INTO cadastrados (nome, dataNasc, nomeMat, cpf, email, cel, tel, cep, rua, bairro, uf, comp, genero, perfil, username, password) 
                VALUES ('$nome', '$dataNasc', '$nomeMat', '$cpf', '$email', '$cel', '$tel', '$cep', '$rua', '$bairro', '$uf', '$comp', '$genero', '$perfil', '$username', '$password')";

        if ($conn->query($sql) === TRUE) {

          echo "Cadastro realizado com sucesso!";

          echo "<script>
                    setTimeout(function(){
                        window.location.href = 'Login.php';
                    }, 2000); // Redireciona após 2 segundos
                  </script>";
          exit();
        } else {
          echo "Erro: " . $sql . "<br>" . $conn->error;
        }
      }

      ?>
      <div class="half-box spacing">
        <label for="nome">Nome completo</label>
        <input type="text" name="nome" id="nome" placeholder="Digite seu nome" data-required data-min-length="15" data-max-length="80">
      </div>
      <div class="half-box">
        <label for="dataNasc">Data de Nascimento</label>
        <input type="date" name="dataNasc" id="dataNasc" data-required>
      </div>
      <div class="half-box spacing">
        <label for="nomeMat">Nome Materno</label>
        <input type="text" name="nomeMat" id="nomeMat" placeholder="Digite o nome da sua mãe" data-required data-min-length="15" data-max-length="80">
      </div>
      <div class="half-box">
        <label for="cpf">CPF</label>
        <input type="text" name="cpf" id="cpf" placeholder="Digite seu CPF" oninput="validarCPF(this)" maxlength="14" data-required>
      </div>

      <div class="half-box spacing">
        <label for="email">E-mail</label>
        <input type="email" name="email" id="email" placeholder="Digite seu e-mail" data-email-validate>
      </div>
      <div class="half-box">
        <label for="cel">Telefone Celular</label>
        <input type="tel" name="cel" id="cel" placeholder="+55 (xx) xxxxxxxxx" onkeydown="ajustaCelular(this)"
          onkeypress="ajustaCelular(this)" onkeyup="ajustaCelular(this)" maxlength="18" data-required>
      </div>

      <div class="half-box spacing">
        <label for="tel">Telefone Fixo</label>
        <input type="tel" name="tel" id="tel" placeholder="+55 (xx) xxxxxxxx" onkeydown="ajustaTelefone(this)"
          onkeypress="ajustaTelefone(this)" onkeyup="ajustaTelefone(this)" maxlength="16" required data-required>
      </div>
      <div class="half-box">
        <label for="cep">CEP</label>
        <input type="text" name="cep" id="cep" placeholder="Digite seu CEP" onblur="preencherEndereco(this)" data-required>
      </div>
      <div class="half-box spacing">
        <label for="rua">Rua</label>
        <input type="text" name="rua" id="rua" placeholder="Digite sua Rua" data-required>
      </div>
      <div class="half-box">
        <label for="bairro">Bairro</label>
        <input type="text" name="bairro" id="bairro" placeholder="Digite seu Bairro" data-required>
      </div>

      <div class="half-box spacing">
        <label for="uf">UF</label>
        <input type="text" name="uf" id="uf" placeholder="Digite seu UF" data-required>
      </div>
      <div class="half-box">
        <label for="comp">Complemento</label>
        <input type="text" name="comp" id="comp">
      </div>
      <div class="half-box spacing">
        <label for="genero">Gênero</label>
        <select name="genero">
          <option value=""></option>
          <option value="Feminino">Feminino</option>
          <option value="Masculino">Masculino</option>
          <option value="Outro">Outro</option>
        </select>
      </div>
      <div class="half-box">
        <label for="usarname">Login</label>
        <input type="text" name="username" id="username" placeholder="Crie um nome de Login" maxlength="6" data-max-length="6" data-required>
      </div>
      <div class="half-box spacing">
        <label for="senha">Senha</label>
        <input type="password" name="password" id="password" placeholder="Ex:A1234567" minlength="8" maxlength="8" data-password-validate data-required>
      </div>
      <div class="half-box">
        <label for="passconfirmation">Confirmação de senha</label>
        <input type="password" name="passconfirmation" id="passwordconfirmation" placeholder="Digite novamente sua senha" data-equal="password" maxlength="8" data-required>
      </div>

      <div id="successMessage" class="text-success" style="font-weight: bold; margin-top: 10px;">
        <?php if (!empty($message)) {
          echo $message;
        } ?>
      </div>

      <div class="full-box spacing">
        <input id="btn-submit" type="submit" value="Registrar" onclick="cadastrar()">
      </div>
      <div class="full-box">
        <input id="btn-reset" type="reset" value="Limpar">
      </div>
    </form>
    <div class="conta">
      <h3>Já tem uma conta? <a href="Login.php">Entre agora!</a></h3>
    </div>
  </div>
  <p class="error-validation template" style="color: red;"></p>
  <script src="JS.js"></script>

</body>

</html>
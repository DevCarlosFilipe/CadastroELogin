<?php

session_start();

// Função para verificar se o usuário já foi cadastrado
function findUserName ($nome, $conn) {
    $query = "SELECT * FROM users WHERE nome = :nome";
    $find = $conn->prepare($query);
    $find->bindParam(':nome', $nome, PDO::PARAM_STR);
    $find->execute();

    if ($find->rowCount() == 1) {
        return true;
    } else {
        return false;
    }

}
// Função de cadastro
function cadUser($nome, $senha, $color) {
    // Criando conexão com Banco de Dados
    include_once "conn.php";

    if (findUserName($nome, $conn)) {
        return false;
    }
    //Tratando Parametro senha
    $senha = SHA1($senha);

    // Query de inserir itens na tabela
    $query = "INSERT INTO users (nome, senha, color) VALUES (:nome, :senha, :color)";

    // Atribuindo variáveis e aplicando ao banco de dados
    $cad_user = $conn->prepare($query);
    $cad_user->bindParam(':nome', $nome, PDO::PARAM_STR);
    $cad_user->bindParam(':senha', $senha, PDO::PARAM_STR);
    $cad_user->bindParam(':color', $color, PDO::PARAM_STR);
    $cad_user->execute();

    return true;
}

// Função de Login
function loginUser ($nome, $senha) {
    //Tratando Parametro senha
    $senha = SHA1($senha);

    // Criando conexão com Banco de Dados
    include_once "conn.php";

    // Query de Login
    $query = "SELECT * FROM users WHERE nome = :nome and senha = :senha";
    $log_user = $conn->prepare($query);
    $log_user->bindParam(':nome', $nome, PDO::PARAM_STR);
    $log_user->bindParam(':senha', $senha, PDO::PARAM_STR);
    $log_user->execute();
    
    if ($log_user->rowCount() == 1) {
        while ($line = $log_user->fetch(PDO::FETCH_ASSOC)) {
            $_SESSION['id'] = $line['id'];
            $_SESSION['nome'] = $line['nome'];
            $_SESSION['color'] = $line['color'];
        }
        return true;
    } else {
        return false;
    }

}

$varPost = new stdClass;
$varPost->error = "Error 505. Contate o DEV";

if ($_POST) {
    // definindo os envios de POST
    $varPost->type = filter_input(INPUT_POST, 'typeIn', FILTER_UNSAFE_RAW);
    $varPost->nome = filter_input(INPUT_POST, 'nome', FILTER_UNSAFE_RAW);
    $varPost->senha = filter_input(INPUT_POST, 'senha', FILTER_UNSAFE_RAW);

    // Separando tipo de requisição do usuário
    if ($varPost->type == "signup") {
        $varPost->color = filter_input(INPUT_POST, 'color', FILTER_UNSAFE_RAW);

        // Verificando se o cadastro foi efetuado
        if(cadUser($varPost->nome, $varPost->senha, $varPost->color)) {
            $varPost->error = 0;
        } else {
            $varPost->error = "Nome de usuário já existe.";
        }
    } elseif ($varPost->type == "logout") {
        session_unset();
        session_destroy();
        header("Location: ../index.html");
    } else {
        // Verificando se o Login foi efetuado
        if (loginUser($varPost->nome, $varPost->senha)) {
            $varPost->error = 0;
        } else {
            $varPost->error = "Usuário o senha incorreta. Tente novamente";
        }
    }
} else {
    // Caso o usuário chegue sem o envio de POST
    $varPost->retorno = "Você provavelmente não deveria está aqui, retorne antes que eu capture seu IP, pilantra! 😒";
}

// Retorno em JSON para o FrontEnd interpretar o retorno
echo json_encode($varPost);



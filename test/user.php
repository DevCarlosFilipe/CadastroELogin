<?php
session_start();
$user = "Anonimo";
$color = "red";

if (!empty($_SESSION)) {
    $user = $_SESSION['nome'];
    $color = $_SESSION['color'];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous" />

    <link rel="stylesheet" href="src/css/style.css" />
    <title><?= "Bem-vindo, " . SHA1($user) ?></title>
</head>

<body>
    <main>
        <h1><?= "Bem-vindo(a), " . $user ?></h1>
        <p>Sua cor favorita: </p>
        <div style="
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: <?= $color ?>;
        "></div>
        <form action="data/backend.php" method="post">
            <input type="hidden" name="typeIn" value="logout">
            <button class="btn btn-danger">Sair</button>
        </form>
        <a href="/test">← Voltar</a>
    </main>

</body>

</html>
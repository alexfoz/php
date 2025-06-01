<?php

session_start();
$data = $_REQUEST['data'] ?? "";
$valor = $_REQUEST['valor'] ?? "";
$hora = $_REQUEST['hora'] ?? "";
if (!empty($_REQUEST['data'])) {
    $data = $_REQUEST['data'];
}
if (!empty($_REQUEST['valor'])) {
    $valor = $_REQUEST['valor'];
}
if (!empty($_REQUEST['hora'])) {
    $hora = $_REQUEST['hora'];
}
if (!empty($data) && !empty($valor) && !empty($hora)) {

    $dados = $_SESSION["dados"] ?? [];
    
    $dados[] = [
        "data" => $data,
        "valor" => $valor,
        "hora" => $hora
    ];

    $_SESSION["dados"] = $dados;

    echo "cadastrado com sucesso!";
}
?>

<form action="" method="POST">
    <p>Data: <input type="text" name="data" value="<?php echo htmlspecialchars($data) ?>"></p>
    <p>Valor: <input type="text" name="valor" value="<?php echo htmlspecialchars($valor) ?>"></p>
    <p>Hora: <input type="text" name="hora" value="<?php echo htmlspecialchars($hora) ?>"></p>
    <p>Preencha os campos acima e clique em cadastrar.</p>
    <p>Os dados serão armazenados na sessão e poderão ser consultados posteriormente.</p>
    <p>Para consultar os dados cadastrados, clique no link abaixo.</p>
    <p><input type="submit" value="Cadastrar"></p>
</form>
<a href="consultar.php">Consultar</a>
<?php
// Exibir os dados cadastrados, se houver
if (isset($_SESSION["dados"]) && !empty($_SESSION["dados"])) {
    echo "<h2>Dados Cadastrados:</h2>";
    foreach ($_SESSION["dados"] as $dado) {
        echo "Data: " . htmlspecialchars($dado["data"]) . ", Valor: " . htmlspecialchars($dado["valor"]) . ", Hora: " . htmlspecialchars($dado["hora"]) . "<br>";
    }
} else {
    echo "<p>Nenhum dado cadastrado.</p>";
}
// Limpar os dados da sessão, se necessário
// if (isset($_REQUEST['limpar'])) {
//     unset($_SESSION["dados"]);
//     echo "<p>Dados limpos.</p>";
// }
// Limpar os dados da sessão, se necessário
if (isset($_REQUEST['limpar'])) {
    unset($_SESSION["dados"]);
    echo "<p>Dados limpos.</p>";
}
?>
<form action="" method="POST">
    <input type="hidden" name="limpar" value="1">
    <input type="submit" value="Limpar Dados">
</form>

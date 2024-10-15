<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "homehub";

// Cria uma nova conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verifica se os dados foram enviados via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe e valida os dados do formulário
    $name = isset($_POST['name']) ? trim($_POST['name']) : null;
    $phone_number = isset($_POST['phone_number']) ? trim($_POST['phone_number']) : null;
    $email = isset($_POST['email']) ? trim($_POST['email']) : null;
    $password = isset($_POST['password']) ? password_hash(trim($_POST['password']), PASSWORD_BCRYPT) : null;
    $cep = isset($_POST['cep']) ? trim($_POST['cep']) : null;

    // Debug: exibe os dados recebidos
    echo "<pre>";
    var_dump($_POST);
    echo "</pre>";

    // Verifica se todos os campos foram preenchidos
    if (empty($name) || empty($phone_number) || empty($email) || empty($password) || empty($cep)) {
        echo "Por favor, preencha todos os campos.";
        exit;
    }

    // Prepara a instrução SQL
    $stmt = $conn->prepare("INSERT INTO usuarios (name, phone_number, email, password, cep) VALUES (?, ?, ?, ?, ?)");

    // Verifica se a preparação foi bem-sucedida
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    // Associa os parâmetros
    $stmt->bind_param("sssss", $name, $phone_number, $email, $password, $cep);

    // Executa a instrução SQL
    if ($stmt->execute()) {
        header("Location: acc_created.html");
        exit;
    } else {
        echo "Erro: " . $stmt->error;
    }

    // Fecha a instrução e

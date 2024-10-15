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
    $email = isset($_POST['email']) ? trim($_POST['email']) : null;
    $password = isset($_POST['password']) ? trim($_POST['password']) : null;

    // Verifica se todos os campos foram preenchidos
    if (empty($email) || empty($password)) {
        echo "Por favor, preencha todos os campos.";
        exit;
    }

    // Verifica se o e-mail existe
    $stmt = $conn->prepare("SELECT id, password FROM USERS WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 0) {
        echo "E-mail não encontrado.";
        $stmt->close();
        $conn->close();
        exit;
    }

    $stmt->bind_result($id, $hashed_password);
    $stmt->fetch();
    $stmt->close();

    // Verifica a senha
    if (!password_verify($password, $hashed_password)) {
        echo "Senha incorreta.";
        $conn->close();
        exit;
    }

    // Se a senha estiver correta, inicia a sessão e redireciona
    session_start();
    $_SESSION['user_id'] = $id;
    header("Location: ../complete_registration.html"); // Redirecione para uma página protegida
    exit;
}

$conn->close();
?>

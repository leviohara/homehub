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
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $phone_number = isset($_POST['phone_number']) ? trim($_POST['phone_number']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? password_hash(trim($_POST['password']), PASSWORD_BCRYPT) : '';
    $cep = isset($_POST['cep']) ? trim($_POST['cep']) : '';

    // Prepara e executa a inserção de dados no banco
    $stmt = $conn->prepare("INSERT INTO USERS (name, phone_number, email, password, cep) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $phone_number, $email, $password, $cep);

    if ($stmt->execute()) {
        echo "Cadastro realizado com sucesso!";
        // MANTER SESSAO DO USUARIO COM OS DADOS DO BD
        // session_start();
        // $_SESSION['user_id'] = $user['id'];
        // $_SESSION['user_firstname'] = $user['firstname'];
        // $_SESSION['user_lastname'] = $user['lastname'];
        // $_SESSION['user_email'] = $user['email'];
        // $_SESSION['user_birthdate'] = $user['birthdate'];
        // $_SESSION['user_gender'] = $user['gender'];
        
        header("Location: ../login.html"); // Falta adicionar o sleep 


    } else {
        echo "Erro ao cadastrar: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "homehub";

//USER             session_start();


// Cria uma nova conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verifica se os dados foram enviados via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe e valida os dados do formulário
    $first_name = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
    $last_name = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
    $dob = isset($_POST['dob']) ? trim($_POST['dob']) : '';
    $cpf = isset($_POST['cpf']) ? trim($_POST['cpf']) : '';
    $street = isset($_POST['street']) ? trim($_POST['street']) : '';
    $complement = isset($_POST['complement']) ? trim($_POST['complement']) : '';
    $neighborhood = isset($_POST['neighborhood']) ? trim($_POST['neighborhood']) : '';
    $state = isset($_POST['state']) ? trim($_POST['state']) : '';
    $country = isset($_POST['country']) ? trim($_POST['country']) : '';

    // Prepara e executa a inserção de dados no banco
    $stmt = $conn->prepare("INSERT INTO USERS (first_name, last_name, dob, cpf, street, complement, neighborhood, state, country) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");//TROCAR POR UPDATE
    $stmt->bind_param("sssssssss", $first_name, $last_name, $dob, $cpf, $street, $complement, $neighborhood, $state, $country);

    if ($stmt->execute()) {
        header("Location: ../success.html"); // Redireciona para uma página de sucesso
        

        exit();
    } else {
        echo "Erro ao completar o cadastro: " . $stmt->error;
        echo "Cadastro realizado com sucesso!";

    }

    $stmt->close();
}

$conn->close();
?>

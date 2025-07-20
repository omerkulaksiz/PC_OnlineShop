<?php
session_start();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "webtech";

$conn = new mysqli($servername, $username, $password, $database);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = isset($_POST['loginEmail']) ? $conn->real_escape_string($_POST['loginEmail']) : '';
    $passwort = isset($_POST['loginPassword']) ? $_POST['loginPassword'] : '';

    if ($email === '' || $passwort === '') {
        header("Location: register.html?tab=login&error=Bitte+geben+Sie+E-Mail+und+Passwort+ein");
        exit;
    }

    $stmt = $conn->prepare("SELECT id, passwort FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($userId, $hashedPassword);
        $stmt->fetch();
        if (password_verify($passwort, $hashedPassword)) {
            $_SESSION['user_id'] = $userId;
            $stmt->close();
            $conn->close();
            header("Location: ../bestellung/gehause.php");
            exit;
        }
    }
    $stmt->close();
    header("Location: register.html?tab=login&error=Login+fehlgeschlagen");
    $conn->close();
    exit;
}
$conn->close();
?>
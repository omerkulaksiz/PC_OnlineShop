<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$servername = "127.0.0.1";
$username = "root";
$password = "3112";
$database = "webtech";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    header("Location: vorlage.html?tab=register&error=Verbindung+zur+Datenbank+fehlgeschlagen");
    exit;
}

// Only handle POST requests (registration)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Collect and sanitize input
    $anrede = isset($_POST['anrede']) ? $conn->real_escape_string($_POST['anrede']) : '';
    $vorname = isset($_POST['vorname']) ? $conn->real_escape_string($_POST['vorname']) : '';
    $nachname = isset($_POST['nachname']) ? $conn->real_escape_string($_POST['nachname']) : '';
    $email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : '';
    $firmenname = isset($_POST['firmenname']) && $_POST['firmenname'] !== '' ? $conn->real_escape_string($_POST['firmenname']) : null;
    $strasse = isset($_POST['strasse']) ? $conn->real_escape_string($_POST['strasse']) : '';
    $plz = isset($_POST['plz']) ? $conn->real_escape_string($_POST['plz']) : '';
    $passwortRaw = isset($_POST['registerPassword']) ? $_POST['registerPassword'] : '';
    $passwortRepeatRaw = isset($_POST['registerPasswordRepeat']) ? $_POST['registerPasswordRepeat'] : '';

    if ($passwortRaw !== $passwortRepeatRaw) {
        header("Location: vorlage.html?tab=register&error=Die+Passw%C3%B6rter+stimmen+nicht+%C3%BCberein");
        exit;
    }

    $passwort = password_hash($passwortRaw, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO user (anrede, vorname, nachname, email, firmenname, zusatz, plz, passwort) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $zusatz = $strasse; 
    $stmt->bind_param("ssssssss", $anrede, $vorname, $nachname, $email, $firmenname, $zusatz, $plz, $passwort);

    if ($stmt->execute()) {
        header("Location: vorlage.html?tab=login&success=Registrierung+erfolgreich.+Sie+k%C3%B6nnen+sich+jetzt+anmelden.");
    } else {
        header("Location: vorlage.html?tab=register&error=Fehler+beim+Speichern%3A+" . urlencode($stmt->error));
    }
    $stmt->close();
} else {
    header("Location: vorlage.html?tab=register&error=Ung%C3%BCltige+Anfrage");
}

$conn->close();
exit;
?>


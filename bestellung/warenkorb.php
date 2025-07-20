<?php
session_start();

function formatPrice($price) {
    return number_format((float)$price, 2, ',', '.');
}

if (!isset($_SESSION['user_id'])) {
    header("Location: ../register/register.html?tab=login&error=Bitte+melden+Sie+sich+an");
    exit;
}

// DB für Adressdaten
$conn = new mysqli("127.0.0.1", "root", "", "webtech");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$stmt = $conn->prepare("SELECT CONCAT(vorname, ' ', nachname) as name, firmenname, zusatz, plz FROM user WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();
$conn->close();

// Gesamtpreis berechnen
$total = 0;
if (isset($_SESSION['gehause']['preis'])) $total += (float)$_SESSION['gehause']['preis'];
if (isset($_SESSION['cpu']['preis'])) $total += (float)$_SESSION['cpu']['preis'];
if (isset($_SESSION['ram']['preis'])) $total += (float)$_SESSION['ram']['preis'];
if (!empty($_SESSION['zubehor'])) {
    foreach ($_SESSION['zubehor'] as $item) {
        $total += (float)$item['preis'];
    }
}

// Bestellung speichern (ohne Zubehör in DB, nur Komponenten und Adresse)
if (isset($_POST['submit_order'])) {
    $_SESSION['user_adresse'] = $user;

    // Zubehör als JSON speichern
    $zubehor_json = !empty($_SESSION['zubehor']) ? json_encode($_SESSION['zubehor']) : null;

    // DB-Verbindung neu öffnen (weil vorher geschlossen)
    $conn = new mysqli("127.0.0.1", "root", "", "webtech");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO bestellungen (
        user_id, gehaeuse_typ, cpu_model, ram_groesse, zubehor_json, gesamtpreis, kunde_name, kunde_firma, kunde_zusatz, kunde_plz
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param(
        "issisdssss",
        $_SESSION['user_id'],
        $_SESSION['gehause']['typ'],
        $_SESSION['cpu']['model'],
        $_SESSION['ram']['size'],
        $zubehor_json,
        $total,
        $user['name'],
        $user['firmenname'],
        $user['zusatz'],
        $user['plz']
    );

    if ($stmt->execute()) {
        $orderId = $conn->insert_id;
        $stmt->close();
        $conn->close();
        header("Location: pdf.php?order_id=" . $orderId);
        exit;
    } else {
        echo "Fehler beim Speichern der Bestellung: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warenkorb - Mustermann IT-Systeme</title>
    <link rel="stylesheet" href="/bootstrap5.3/css/bootstrap.min.css">
</head>
<body>


    <main>
        
        <div class="container py-4">
             <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <span class="navbar-brand h1">Mustermann GmbH</span>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="/index.html">Startseite</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">IT-Schulungen</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Online-Shop</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  Service
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item" href="#">Hardware-Support</a></li>
                  <li><a class="dropdown-item" href="#">Software-Support</li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item" href="#">Impressum</a></li>
                  <li><a class="dropdown-item" href="#">Datenschutz</a></li>
                </ul>
              </li>
            </ul>
            <form class="d-flex">
              <input class="form-control me-2" type="search" placeholder="Suche" aria-label="Search">
              <button class="btn btn-outline-dark" type="submit"><img src="/bootstrap5.3/icons/search.svg"></button>
            </form>
          </div>
        </div>
      </nav>
            <h2>Ihre Bestellung</h2>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Komponente</th>
                            <th>Details</th>
                            <th>Preis</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($_SESSION['gehause'])): ?>
                        <tr>
                            <td>Gehäuse</td>
                            <td><?php echo htmlspecialchars($_SESSION['gehause']['typ']); ?></td>
                            <td><?php echo formatPrice($_SESSION['gehause']['preis']); ?> €</td>
                        </tr>
                        <?php endif; ?>

                        <?php if(isset($_SESSION['cpu'])): ?>
                        <tr>
                            <td>CPU</td>
                            <td><?php echo htmlspecialchars($_SESSION['cpu']['model']); ?></td>
                            <td><?php echo formatPrice($_SESSION['cpu']['preis']); ?> €</td>
                        </tr>
                        <?php endif; ?>

                        <?php if(isset($_SESSION['ram'])): ?>
                        <tr>
                            <td>RAM</td>
                            <td><?php echo htmlspecialchars($_SESSION['ram']['size']); ?> GB</td>
                            <td><?php echo formatPrice($_SESSION['ram']['preis']); ?> €</td>
                        </tr>
                        <?php endif; ?>

                        <?php if(!empty($_SESSION['zubehor'])): ?>
                            <?php foreach($_SESSION['zubehor'] as $item): ?>
                            <tr>
                                <td>Zubehör</td>
                                <td><?php echo htmlspecialchars($item['name']); ?></td>
                                <td><?php echo formatPrice($item['preis']); ?> €</td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <tr class="table-active">
                            <td colspan="2"><strong>Gesamtpreis</strong></td>
                            <td><strong><?php echo formatPrice($total); ?> €</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <table class="table">
                <tr>
                    <td colspan="2">Lieferadresse:</td>
                    <td>
                        <?php echo htmlspecialchars($user['name']); ?><br>
                        <?php if (!empty($user['firmenname'])): ?>
                            <?php echo htmlspecialchars($user['firmenname']); ?><br>
                        <?php endif; ?>
                        <?php if (!empty($user['zusatz'])): ?>
                            <?php echo htmlspecialchars($user['zusatz']); ?><br>
                        <?php endif; ?>
                        <?php echo htmlspecialchars($user['plz']); ?>
                    </td>
                </tr>
            </table>

            <div class="mt-4">
                <form method="post">
                    <a href="zubehor.php" class="btn btn-secondary">Zurück</a>
                    <button type="submit" name="submit_order" class="btn btn-success">Bestellen</button>
                    <a href="/index.html" class="btn btn-warning">Abbrechen</a>
                </form>
            </div>
        </div>
        <script src="/bootstrap5.3/js/bootstrap.bundle.min.js"></script>
    </main>
</body>
</html>
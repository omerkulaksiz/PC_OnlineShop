<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../register/register.html?tab=login&error=Bitte+melden+Sie+sich+an");
    exit;
}

// Get CPU max RAM from previous step (assuming it's stored in session)
$maxRam = isset($_SESSION['selected_cpu_max_ram']) ? $_SESSION['selected_cpu_max_ram'] : 128; // default to 128 if not set

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['ram'] = [
        'size' => $_POST['ramSize'],
        'preis' => $_POST['ramPrice']
    ];
    header('Location: zubehor.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mustermann IT-Systeme</title>
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

        <div class="container py-4">
        <h3>Schritt 4 von 5: RAM</h3>
        <div class="container mt-4 mb-4 border">
            <form method="post" action="">
                <input type="hidden" name="ramPrice" id="ramPriceHidden">
                <div class="mb-3">
                    <label for="ramSize" class="form-label mt-3">RAM-Größe wählen (4 - <?php echo $maxRam; ?> GB)</label>
                    <input type="range" class="form-range" id="ramSize" 
                           min="4" max="<?php echo $maxRam; ?>" step="4" value="4"
                           oninput="updateRamInfo(this.value)">
                    <div class="mt-2">
                        <p>Gewählte Größe: <span id="selectedRam">4</span> GB</p>
                        <p>Preis: <span id="ramPrice">3.20</span> €</p>
                    </div>
                </div>
                <a href="cpu.php" class="btn btn-secondary me-2">Zurück</a>
                <button type="submit" class="btn btn-success mb-3">Weiter</button>
            </form>
        </div>
        <a href="index.html" class="btn btn-warning">Abbruch und zurück zur Startseite</a>
    </div>

    <script>
        function updateRamInfo(value) {
            const selectedRam = document.getElementById('selectedRam');
            const ramPrice = document.getElementById('ramPrice');
            
            // Update displayed RAM size
            selectedRam.textContent = value;
            
            // Calculate and update price (0.80€ per GB)
            const price = (value * 0.80).toFixed(2);
            ramPrice.textContent = price;
            document.getElementById('ramPriceHidden').value = price;
        }
    </script>

    <script src="/bootstrap5.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
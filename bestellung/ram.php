<?php
session_start();

// Debug output at the very start
error_log("RAM Page - Session CPU data: " . print_r($_SESSION['cpu'] ?? 'not set', true));

// Check if user is logged in and CPU is selected with max_ram
if (!isset($_SESSION['user_id']) || !isset($_SESSION['cpu']['max_ram'])) {
    header("Location: ../register/register.html?tab=login&error=Bitte+wählen+Sie+zuerst+eine+CPU");
    exit;
}

// Get max RAM directly from CPU session data and ensure it's an integer
$maxRam = (int)$_SESSION['cpu']['max_ram'];

// Debug output
error_log("RAM Page - Max RAM value: " . $maxRam);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedRam = (int)$_POST['ramSize'];
    
    // Validate RAM selection
    if ($selectedRam < 4 || $selectedRam > $maxRam || $selectedRam % 4 !== 0) {
        header("Location: ram.php?error=Ungültige+RAM-Auswahl");
        exit;
    }

    $_SESSION['ram'] = [
        'size' => $selectedRam,
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
            <form method="post">
                <input type="hidden" name="ramSize" id="ramSizeInput">
                <input type="hidden" name="ramPrice" id="ramPriceInput">
                <div class="mb-3">
                    <label for="ramSlider" class="form-label mt-3">RAM-Größe wählen (4 - <?php echo $maxRam; ?> GB)</label>
                    <input type="range" class="form-range" id="ramSlider" 
                           name="ramSize"
                           min="4" 
                           max="<?php echo $maxRam; ?>" 
                           step="4" 
                           value="4"
                           oninput="updateRamInfo(this.value)">
                    <div class="mt-2">
                        <p>Gewählte Größe: <span id="selectedRam">4</span> GB</p>
                        <p>Preis: <span id="priceDisplay">3.20</span> €</p>
                    </div>
                </div>
                <a href="cpu.php" class="btn btn-secondary mb-2">Zurück</a>
                <button type="submit" class="btn btn-success mb-2">Weiter</button>
            </form>
        </div>
        <a href="/index.html" class="btn btn-warning">Abbruch und zurück zur Startseite</a>
    </div>

    <script>
        // Get max RAM from PHP and ensure it's a number
        const maxRam = parseInt('<?php echo $maxRam; ?>');
        
        // Debug output
        console.log('CPU data:', <?php echo json_encode($_SESSION['cpu'] ?? null); ?>);
        console.log('Max RAM value:', maxRam);

        function updateRamInfo(value) {
            value = parseInt(value);
            
            // Ensure value is within bounds and multiple of 4
            value = Math.min(Math.max(4, value), maxRam);
            value = Math.floor(value / 4) * 4;
            
            // Update displays
            document.getElementById('selectedRam').textContent = value;
            document.getElementById('ramSizeInput').value = value;
            document.getElementById('ramSlider').value = value;
            
            // Calculate and update price
            const price = (value * 0.80).toFixed(2);
            document.getElementById('ramPriceInput').value = price;
            document.getElementById('priceDisplay').textContent = price;
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            const slider = document.getElementById('ramSlider');
            
            // Set the maximum value for the slider
            slider.max = maxRam;
            console.log('Initial slider max:', slider.max);
            
            // Set initial value and update display
            slider.value = 4;
            updateRamInfo(4);
        });
    </script>

    <script src="/bootstrap5.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
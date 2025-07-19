<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../register/register.html?tab=login&error=Bitte+melden+Sie+sich+an");
    exit;
}

// Database connection
$servername = "127.0.0.1";
$username = "root";
$password = "3112";
$database = "webtech";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch AMD CPUs
$amdQuery = "SELECT cpu_bz, cpu_preis, cpu_mram FROM cpu WHERE cpu_hs = 'AMD' ORDER BY cpu_preis";
$amdResult = $conn->query($amdQuery);

// Fetch Intel CPUs
$intelQuery = "SELECT cpu_bz, cpu_preis, cpu_mram FROM cpu WHERE cpu_hs = 'Intel' ORDER BY cpu_preis";
$intelResult = $conn->query($intelQuery);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cpu_model'])) {
        $_SESSION['cpu'] = [
            'model' => $_POST['cpu_model'],
            'preis' => $_POST['cpu_preis'],
            'max_ram' => $_POST['cpu_mram']
        ];
        header('Location: ram.php');
        exit;
    }
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

        <h3>Schritt 3 von 5: CPU</h3>
       <div class="container mt-4 mb-4 border">
<form method="post" action="">
    <div class="mb-3">
        <label class="form-label">Wählen Sie eine CPU-Marke:</label>
        <div>
            <input type="radio" class="btn-check" name="cpu_brand" id="amd" value="amd" autocomplete="off" onclick="showCPUs('amd')">
            <label class="btn btn-outline-primary" for="amd">AMD</label>
            <input type="radio" class="btn-check" name="cpu_brand" id="intel" value="intel" autocomplete="off" onclick="showCPUs('intel')">
            <label class="btn btn-outline-primary" for="intel">Intel</label>
        </div>
    </div>

    <div id="amd-cpus" style="display:none;">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>CPU</th>
                    <th>Preis</th>
                    <th>max Ram</th>
                    <th>Auswählen</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $amdResult->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['cpu_bz']); ?></td>
                    <td><?php echo htmlspecialchars($row['cpu_preis']); ?> €</td>
                    <td><?php echo htmlspecialchars($row['cpu_mram']); ?> GB</td>
                    <td>
                        <input type="radio" name="cpu_model" value="<?php echo htmlspecialchars($row['cpu_bz']); ?>">
                        <input type="hidden" name="cpu_preis" value="<?php echo htmlspecialchars($row['cpu_preis']); ?>">
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div id="intel-cpus" style="display:none;">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>CPU</th>
                    <th>Preis</th>
                    <th>max Ram</th>
                    <th>Auswählen</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $intelResult->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['cpu_bz']); ?></td>
                    <td><?php echo htmlspecialchars($row['cpu_preis']); ?> €</td>
                    <td><?php echo htmlspecialchars($row['cpu_mram']); ?> GB</td>
                    <td>
                        <input type="radio" name="cpu_model" value="<?php echo htmlspecialchars($row['cpu_bz']); ?>">
                        <input type="hidden" name="cpu_preis" value="<?php echo htmlspecialchars($row['cpu_preis']); ?>">
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <a href="gehause.php" class="btn btn-secondary me-2">Zurück</a>
    <button type="submit" class="btn btn-success mb-3" style="display: none;" id="buybtn">Weiter</button>
</form>

<script>
function showCPUs(brand) {
    document.getElementById('amd-cpus').style.display = (brand === 'amd') ? 'block' : 'none';
    document.getElementById('intel-cpus').style.display = (brand === 'intel') ? 'block' : 'none';
    const buyButton = document.getElementById('buybtn');
    buyButton.style.display = 'block';
}


</script>

        </div>
<button class="btn btn-warning">Abbruch und zurück zur Startseite</button>
</body>
</html>

<?php
$conn->close();
?>
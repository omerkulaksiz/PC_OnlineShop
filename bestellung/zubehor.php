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

// Fetch accessories from database
$query = "SELECT z_id, z_name, z_bs, z_kategorie, z_preis, z_bild FROM zubehor ORDER BY z_kategorie, z_name";
$result = $conn->query($query);

// Group items by category
$categories = [];
while ($row = $result->fetch_assoc()) {
    $categories[$row['z_kategorie']][] = $row;
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

            <h3>Schritt 5 von 5: Zubehör</h3>
            <div class="container mt-4 mb-4 border p-3">
                <form method="post" action="warenkorb.php">
                    <?php foreach ($categories as $category => $items): ?>
                        <h4 class="mt-4 mb-3"><?php echo htmlspecialchars($category); ?></h4>
                        <div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
                            <?php foreach ($items as $item): ?>
                                <div class="col">
                                    <div class="card h-100">
                                        <img src="/<?php echo htmlspecialchars($item['z_bild']); ?>" 
                                             class="card-img-top" 
                                             alt="<?php echo htmlspecialchars($item['z_name']); ?>"
                                             style="height: 200px; object-fit: contain; padding: 10px;">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo htmlspecialchars($item['z_name']); ?></h5>
                                            <p class="card-text"><?php echo htmlspecialchars($item['z_bs']); ?></p>
                                            <p class="card-text">
                                                <strong>Preis: <?php echo number_format($item['z_preis'], 2, ',', '.'); ?> €</strong>
                                            </p>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" 
                                                       name="selected_items[<?php echo $item['z_id']; ?>]" 
                                                       value="<?php echo $item['z_preis']; ?>" 
                                                       id="item_<?php echo $item['z_id']; ?>">
                                                <input type="hidden" name="item_names[<?php echo $item['z_id']; ?>]" 
                                                       value="<?php echo htmlspecialchars($item['z_name']); ?>">
                                                <label class="form-check-label" for="item_<?php echo $item['z_id']; ?>">
                                                    Auswählen
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-success">Zum Warenkorb</button>
                        <a href="index.html" class="btn btn-warning ms-2">Abbruch und zurück zur Startseite</a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script src="/bootstrap5.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
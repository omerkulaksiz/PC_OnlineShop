<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../register/register.html?tab=login&error=Bitte+melden+Sie+sich+an");
    exit;
}

// Initialize total
$total = 0;

// Add gehäuse price
if (isset($_SESSION['gehause']['preis'])) {
    $total += (float)$_SESSION['gehause']['preis'];
}

// Add CPU price
if (isset($_SESSION['cpu']['preis'])) {
    $total += (float)$_SESSION['cpu']['preis'];
}

// Add RAM price
if (isset($_SESSION['ram']['preis'])) {
    $total += (float)$_SESSION['ram']['preis'];
}

// Handle zubehor selection
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['zubehor'] = [];
    if (isset($_POST['selected_items'])) {
        foreach ($_POST['selected_items'] as $id => $preis) {
            $_SESSION['zubehor'][] = [
                'id' => $id,
                'name' => $_POST['item_names'][$id],
                'preis' => (float)$preis
            ];
            $total += (float)$preis;
        }
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
                                    <li><a class="dropdown-item" href="#">Software-Support</a></li>
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
                            <td><?php echo number_format($_SESSION['gehause']['preis'], 2, ',', '.'); ?> €</td>
                        </tr>
                        <?php endif; ?>

                        <?php if(isset($_SESSION['cpu'])): ?>
                        <tr>
                            <td>CPU</td>
                            <td><?php echo htmlspecialchars($_SESSION['cpu']['model']); ?></td>
                            <td><?php echo number_format($_SESSION['cpu']['preis'], 2, ',', '.'); ?> €</td>
                        </tr>
                        <?php endif; ?>

                        <?php if(isset($_SESSION['ram'])): ?>
                        <tr>
                            <td>RAM</td>
                            <td><?php echo htmlspecialchars($_SESSION['ram']['size']); ?> GB</td>
                            <td><?php echo number_format($_SESSION['ram']['preis'], 2, ',', '.'); ?> €</td>
                        </tr>
                        <?php endif; ?>

                        <?php if(isset($_SESSION['zubehor'])): ?>
                            <?php foreach($_SESSION['zubehor'] as $item): ?>
                            <tr>
                                <td>Zubehör</td>
                                <td><?php echo htmlspecialchars($item['name']); ?></td>
                                <td><?php echo number_format($item['preis'], 2, ',', '.'); ?> €</td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <tr class="table-active">
                            <td colspan="2"><strong>Gesamtpreis</strong></td>
                            <td><strong><?php echo number_format($total, 2, ',', '.'); ?> €</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <a href="zubehor.php" class="btn btn-secondary">Zurück</a>
                <button class="btn btn-success">Bestellen</button>
                <a href="index.html" class="btn btn-warning">Abbrechen</a>
            </div>
        </div>

        <script src="/bootstrap5.3/js/bootstrap.bundle.min.js"></script>
    </main>
</body>
</html>
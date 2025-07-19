<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../register/register.html?tab=login&error=Bitte+melden+Sie+sich+an");
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['gehause'])) {
    $_SESSION['gehause'] = [
        'typ' => $_POST['gehause'],
        'preis' => $_POST['preis']
    ];
    header('Location: cpu.php');
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

        <h3>Schritt 2 von 5: Gehäuse</h3>
       <div class="container mt-4 mb-4 border">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>Bild</th>
                        <th>Gehäuse Typ</th>
                        <th>Preis</th>
                        <th>Auswahl</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><img src="/img/products/maxi.png" alt="Gehäuse 1" class="img-fluid" style="width: 160px; min-height:200px"></td>
                        <td>Maxi Tower</td>
                        <td>89,99 €</td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="gehause" value="Maxi Tower">
                                <input type="hidden" name="preis" value="89.99">
                                <button type="submit" class="btn btn-primary">Auswählen</button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4"><hr class="border border-secondary"></td>
                    </tr>
                    <tr>
                        <td><img src="/img/products/midi.png" alt="Gehäuse 2" class="img-fluid" style="width: 160px; min-height:200px"></td>
                        <td>Midi Tower</td>
                        <td>59,99 €</td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="gehause" value="Midi Tower">
                                <input type="hidden" name="preis" value="59.99">
                                <button type="submit" class="btn btn-primary">Auswählen</button>
                            </form>
                        </td>
                    </tr>
                    <tr >
                        <td colspan="4"><hr class="border border-secondary"></td>
                    </tr>
                    <tr>
                        <td><img src="/img/products/desktop.png" alt="Gehäuse 3" class="img-fluid" style="width: 160px; min-height:200px"></td>
                        <td>Mini Tower</td>
                        <td>49,99 €</td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="gehause" value="Mini Tower">
                                <input type="hidden" name="preis" value="49.99">
                                <button type="submit" class="btn btn-primary">Auswählen</button>
                            </form>
                        </td>
                    </tr>
                </tbody>

            
            </table>



        </div>
<button class="btn btn-warning">Abbruch und zurück zur Startseite</button>
</body>
</html>
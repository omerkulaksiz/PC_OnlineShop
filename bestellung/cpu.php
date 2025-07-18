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
                <tr>
                    <td>AMD Ryzen 5 5600X</td>
                    <td>200 €</td>
                                        <td>32 GB</td>

                    <td><input type="radio" name="cpu_model" value="AMD Ryzen 5 5600X"></td>
                </tr>
                <tr>
                    <td>AMD Ryzen 7 5800X</td>
                    <td>320 €</td>
                                        <td>32 GB</td>

                    <td><input type="radio" name="cpu_model" value="AMD Ryzen 7 5800X"></td>
                </tr>
                <tr>
                    <td>AMD Ryzen 9 5900X</td>
                    <td>450 €</td>
                                        <td>32 GB</td>

                    <td><input type="radio" name="cpu_model" value="AMD Ryzen 9 5900X"></td>
                </tr>
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
                <tr>
                    <td>Intel Core i5-12600K</td>
                    <td>230 €</td>
                                        <td>32 GB</td>

                    <td><input type="radio" name="cpu_model" value="Intel Core i5-12600K"></td>
                </tr>
                <tr>
                    <td>Intel Core i7-12700K</td>
                    <td>350 €</td>
                                        <td>32 GB</td>

                    <td><input type="radio" name="cpu_model" value="Intel Core i7-12700K"></td>
                </tr>
                <tr>
                    <td>Intel Core i9-12900K</td>
                    <td>500 €</td>
                    <td>32 GB</td>
                    <td><input type="radio" name="cpu_model" value="Intel Core i9-12900K"></td>
                    
                </tr>

            </tbody>
        </table>
    </div>

    <button type="submit" class="btn btn-success mb-3" style="display: none;" id="buybtn">Kaufen</button>
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
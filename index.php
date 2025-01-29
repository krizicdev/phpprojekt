<?php include 'header.php'; ?>

<!-- Modern Hero Section -->
<div class="hero mb-5">
  <div class="overlay"></div>
  <div class="hero-content text-white">
    <h1>Dobrodošli na Designo. Nekretnine</h1>
    <p class="lead">
      Pronađite savršenu nekretninu za vas uz moderan i jednostavan pregled ponude.
    </p>
    <a href="offer.php" class="btn btn-hero text-white">Pregled ponude</a>
  </div>
</div>

<!-- Najnoviji oglasi -->
<h3 class="mb-4">Najnoviji oglasi</h3>
<div class="row">
  <?php
  // Dohvat par posljednjih odobrenih oglasa
  $sql = "SELECT ads.*, users.email, users.phone 
          FROM ads 
          JOIN users ON ads.user_id = users.id
          WHERE ads.status='approved'
          ORDER BY ads.created_at DESC 
          LIMIT 3";
  $result = $conn->query($sql);

  if($result && $result->num_rows > 0) {
    while($ad = $result->fetch_assoc()) {
      echo '<div class="col-md-4 mb-4">
              <div class="card h-100">
                <img src="uploads/'.$ad['image'].'" class="card-img-top" height="200" 
                     style="object-fit:cover;" alt="Slika oglasa">
                <div class="card-body">
                  <h5 class="card-title">'.$ad['title'].'</h5>
                  <p class="card-text">'.substr($ad['description'], 0, 80).'...</p>
                  <p class="text-muted">Grad: '.$ad['city'].' | Cijena: '.$ad['price'].' EUR | Površina: '.$ad['area'].' m²</p>
                </div>
              </div>
            </div>';
    }
  } else {
    echo '<p>Nema dostupnih oglasa.</p>';
  }
  ?>
</div>

<?php include 'footer.php'; ?>
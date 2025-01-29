<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8">
  <title>Designo. Nekretnine</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

  <!-- Font Awesome (neobavezno) -->
  <script src="https://kit.fontawesome.com/YOUR_FONTAWESOME_KIT.js" crossorigin="anonymous"></script>

  <!-- Custom CSS -->
  <link rel="stylesheet" href="modern.css">

  <!-- Meta tag za responzivnost (ako već nije dodan) -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="bg-light text-dark">
  <nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
    <div class="container-fluid px-5">
      <a class="navbar-brand logo-text fw-bold text-dark" href="index.php">
        Designo. Nekretnine
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
              data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" 
              aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link px-3" href="offer.php">Ponuda</a></li>
          <li class="nav-item"><a class="nav-link px-3" href="about.php">O nama</a></li>
          <li class="nav-item"><a class="nav-link px-3" href="contact.php">Kontakt</a></li>
  
          
          <?php if(isset($_SESSION['user_id'])): ?>
            <?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
              <li class="nav-item"><a class="nav-link px-3" href="check_ads.php">Provjera</a></li>
            <?php else: ?>
              <li class="nav-item">
                <a class="nav-link px-3" href="add_ad.php">Predaj oglas</a>
              </li>
              <li class="nav-item">
                <a class="nav-link px-3" href="profile.php">Moj profil</a>
              </li>
            <?php endif; ?>
            <li class="nav-item"><a class="nav-link px-3" href="logout.php">Odjava</a></li>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link px-3" href="login.php">
                <i class="fa-solid fa-user-circle"></i> Login/Registracija
              </a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container py-4">
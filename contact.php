<?php
include 'header.php';
?>

<!-- Hero / Banner sekcija s jednobojnom pozadinom -->
<div class="py-5 text-center bg-light">
  <h1 class="fw-bold">Kontaktirajte nas</h1>
  <p class="lead mb-0">Uvijek smo tu za Vas</p>
</div>

<div class="container my-5">
  <!-- Kontakt info sekcija (3 stupca) -->
  <div class="row g-4 text-center mb-5">
    <!-- Kartica - Naša adresa -->
    <div class="col-md-4">
      <div style="background-color: #11212d; color: #fff; padding: 1.5rem; border-radius: .3rem;">
        <i class="fa-solid fa-location-dot fa-2x mb-2"></i>
        <h5 class="fw-semibold mt-2">Naša adresa</h5>
        <p class="mb-0">
          Feurdova ulica 34, Zagreb
     
        </p>
      </div>
    </div>
    <!-- Kartica - Telefon -->
    <div class="col-md-4">
      <div style="background-color: #11212d; color: #fff; padding: 1.5rem; border-radius: .3rem;">
        <i class="fa-solid fa-phone fa-2x mb-2"></i>
        <h5 class="fw-semibold mt-2">Telefon</h5>
        <p class="mb-0">+385 1 234 5678</p>
      </div>
    </div>
    <!-- Kartica - E-mail -->
    <div class="col-md-4">
      <div style="background-color: #11212d; color: #fff; padding: 1.5rem; border-radius: .3rem;">
        <i class="fa-solid fa-envelope fa-2x mb-2"></i>
        <h5 class="fw-semibold mt-2">E-mail</h5>
        <p class="mb-0">info@designo.hr</p>
      </div>
    </div>
  </div>

  <!-- Forma za upit (bez border-a) -->
  <div class="row mb-5">
    <div class="col-md-8 mx-auto">
      <!-- Maknut 'border' klasu -->
      <div class="p-4 bg-white rounded-3">
        <h3 class="fw-semibold mb-3">Pošaljite upit</h3>
        <form action="" method="POST" class="row g-3">
          <div class="col-md-6">
            <label for="name" class="form-label">Ime i Prezime</label>
            <input
              type="text"
              class="form-control"
              id="name"
              name="name"
              required
            >
          </div>
          <div class="col-md-6">
            <label for="email" class="form-label">E-mail</label>
            <input
              type="email"
              class="form-control"
              id="email"
              name="email"
              required
            >
          </div>
          <div class="col-12">
            <label for="message" class="form-label">Poruka</label>
            <textarea
              class="form-control"
              id="message"
              name="message"
              rows="4"
              required
            ></textarea>
          </div>
          <div class="col-12 text-end">
            <!-- Gumb s bojom #11212d -->
            <button
              type="submit"
              name="submit_contact"
              class="btn"
              style="background-color: #11212d; color: #fff;"
            >
              Pošalji
            </button>
          </div>
        </form>

        <?php
        if (isset($_POST['submit_contact'])) {
          // Upis u bazu, slanje emaila itd. prema vašim potrebama
          echo "<div class='alert alert-success mt-3'>Vaš upit je zaprimljen!</div>";
        }
        ?>
      </div>
    </div>
  </div>

  <!-- Opcionalno: Google mapa lokacije (bez sjena) -->
  <div class="ratio ratio-16x9 mt-5 border rounded-3">
    <iframe
      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2781.6437466731353!2d15.97553657634776!3d45.81269787664214!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4765d6f8b7dddddd%3A0xf8d44173ffdba989!2sZagreb!5e0!3m2!1shr!2shr!4v1234567890"
      style="border:0;"
      allowfullscreen=""
      loading="lazy"
    >
    </iframe>
  </div>
</div>

<?php
include 'footer.php';
?>
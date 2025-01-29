<?php 
include 'header.php';

if(!isset($_SESSION['user_id']) || (isset($_SESSION['is_admin']) && $_SESSION['is_admin']==1)) {
  // Not logged in or is admin -> redirect
  header("Location: index.php");
  exit;
}

if(isset($_POST['submit_ad'])){
  $title       = $_POST['title'];
  $description = $_POST['description'];
  $city        = $_POST['city'];
  $price       = $_POST['price'];
  $area        = $_POST['area'];
  $user_id     = $_SESSION['user_id'];

  // Image upload
  $imageName = "";
  if(!empty($_FILES['image']['name'])){
    $targetDir = "uploads/";
    if(!is_dir($targetDir)){
      mkdir($targetDir, 0777, true);
    }
    $imageName = time()."_".basename($_FILES['image']['name']);
    $targetFile = $targetDir . $imageName;
    move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
  }

  // Insert into DB (status=pending by default)
  $stmt = $conn->prepare("
    INSERT INTO ads (user_id, title, description, city, price, area, image, status) 
    VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')
  ");
  $stmt->bind_param("isssdis", $user_id, $title, $description, $city, $price, $area, $imageName);
  $stmt->execute();

  // Also append to XML
  $xmlFile = 'ads.xml';
  if(!file_exists($xmlFile)){
    // Create root element
    $xmlContent = '<?xml version="1.0" encoding="UTF-8"?><ads></ads>';
    file_put_contents($xmlFile, $xmlContent);
  }
  $xml = simplexml_load_file($xmlFile);
  $ad = $xml->addChild('ad');
  $ad->addChild('title', $title);
  $ad->addChild('description', $description);
  $ad->addChild('city', $city);
  $ad->addChild('price', $price);
  $ad->addChild('area', $area);
  $ad->addChild('image', $imageName);
  $xml->asXML($xmlFile);

  $message = "Oglas predan na provjeru. Čekajte odobrenje administratora.";
}
?>

<div class="row justify-content-center">
  <div class="col-md-6">
    <h2 class="my-4">Predaj oglas</h2>
    <?php if(isset($message)) echo "<div class='alert alert-success'>$message</div>"; ?>
    <form method="POST" action="" enctype="multipart/form-data">
      <div class="mb-3">
        <label>Naslov</label>
        <input type="text" class="form-control" name="title" required>
      </div>
      <div class="mb-3">
        <label>Opis</label>
        <textarea class="form-control" name="description" rows="3" required></textarea>
      </div>
      <div class="mb-3">
        <label>Grad</label>
        <select class="form-select" name="city" required>
          <option value="">-- Odaberite grad --</option>
          <option>Zagreb</option>
          <option>Split</option>
          <option>Rijeka</option>
          <option>Osijek</option>
          <option>Zadar</option>
          <option>Pula</option>
          <!-- Additional cities -->
        </select>
      </div>
      <div class="mb-3">
        <label>Cijena (EUR)</label>
        <input type="number" class="form-control" name="price" required>
      </div>
      <div class="mb-3">
        <label>Površina (m²)</label>
        <input type="number" class="form-control" name="area" required>
      </div>
      <div class="mb-3">
        <label>Slika</label>
        <input type="file" class="form-control" name="image" required>
      </div>
      <button type="submit" name="submit_ad" style="background-color: #11212d; color: #fff; border-color: #11212d;" class="btn btn-primary">Predaj oglas</button>
    </form>
  </div>
</div>

<?php include 'footer.php'; ?>
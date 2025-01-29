<?php
include 'header.php';

$filterCity   = isset($_GET['filter_city']) ? $_GET['filter_city'] : '';
$filterPrice  = isset($_GET['filter_price']) ? (int)$_GET['filter_price'] : 0;
$filterArea   = isset($_GET['filter_area']) ? (int)$_GET['filter_area'] : 0;

// Build the query with optional filters
$query = "SELECT ads.*, users.email, users.phone 
          FROM ads
          JOIN users ON ads.user_id = users.id 
          WHERE ads.status='approved'";

if($filterCity){
  $query .= " AND city='$filterCity'";
}
if($filterPrice){
  $query .= " AND price <= $filterPrice";
}
if($filterArea){
  $query .= " AND area >= $filterArea";
}

$result = $conn->query($query);
?>

<h2 class="my-4">Ponuda</h2>
<form action="" method="GET" class="row mb-4">
  <div class="col-md-3">
    <label>Grad</label>
    <select class="form-select" name="filter_city">
      <option value="">Svi gradovi</option>
      <option value="Zagreb" <?php if($filterCity=='Zagreb') echo 'selected'; ?>>Zagreb</option>
      <option value="Split" <?php if($filterCity=='Split') echo 'selected'; ?>>Split</option>
      <option value="Rijeka" <?php if($filterCity=='Rijeka') echo 'selected'; ?>>Rijeka</option>
      <option value="Osijek" <?php if($filterCity=='Osijek') echo 'selected'; ?>>Osijek</option>
      <option value="Zadar" <?php if($filterCity=='Zadar') echo 'selected'; ?>>Zadar</option>
      <option value="Pula" <?php if($filterCity=='Pula') echo 'selected'; ?>>Pula</option>
    </select>
  </div>
  <div class="col-md-3">
    <label>Maksimalna cijena (EUR)</label>
    <input type="number" class="form-control" name="filter_price" value="<?php echo $filterPrice; ?>">
  </div>
  <div class="col-md-3">
    <label>Minimalna površina (m²)</label>
    <input type="number" class="form-control" name="filter_area" value="<?php echo $filterArea; ?>">
  </div>
  <div class="col-md-3 d-flex align-items-end">
    <button type="submit" style="background-color: #11212d; color: #fff; border-color: #11212d;" class="btn btn-primary w-100">Filtriraj</button>
  </div>
</form>

<div class="row">
  <?php
  if($result && $result->num_rows > 0){
    while($ad = $result->fetch_assoc()){
      echo '<div class="col-md-4 mb-4">
              <div class="card h-100">
                <img src="uploads/'.$ad['image'].'" class="card-img-top" height="200" style="object-fit:cover;" alt="Slika oglasa">
                <div class="card-body">
                  <h5 class="card-title">'.$ad['title'].'</h5>
                  <p class="card-text">'.substr($ad['description'],0,100).'...</p>
                  <p>Grad: '.$ad['city'].' | Cijena: '.$ad['price'].' EUR | Površina: '.$ad['area'].' m²</p>
                  <hr>
                  <p>Kontakt: '.$ad['email'].' / '.$ad['phone'].'</p>
                </div>
              </div>
            </div>';
    }
  } else {
    echo '<p>Nema oglasa za prikaz.</p>';
  }
  ?>
</div>

<?php include 'footer.php'; ?>
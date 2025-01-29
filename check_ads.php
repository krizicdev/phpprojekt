<?php 
include 'header.php';

if(!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1){
  // Not admin
  header("Location: index.php");
  exit;
}

// Approve or reject logic
if(isset($_GET['approve'])){
  $adId = $_GET['approve'];
  $conn->query("UPDATE ads SET status='approved' WHERE id=$adId");
  header("Location: check_ads.php");
  exit;
}

if(isset($_GET['reject'])){
  $adId = $_GET['reject'];
  $conn->query("DELETE FROM ads WHERE id=$adId");
  header("Location: check_ads.php");
  exit;
}

// Fetch ads with status=pending
$sql = "SELECT ads.*, users.email, users.phone 
        FROM ads 
        JOIN users ON ads.user_id = users.id
        WHERE ads.status='pending'";
$result = $conn->query($sql);

?>
<h2 class="my-4">Provjera oglasa (Administrator)</h2>
<table class="table table-bordered">
  <thead>
    <tr>
      <th>Naslov</th>
      <th>Opis</th>
      <th>Korisnik</th>
      <th>Grad</th>
      <th>Cijena</th>
      <th>Površina (m²)</th>
      <th>Akcija</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    if($result && $result->num_rows > 0){
      while($ad = $result->fetch_assoc()){
        echo "<tr>
                <td>{$ad['title']}</td>
                <td>".substr($ad['description'],0,50)."...</td>
                <td>{$ad['email']} / {$ad['phone']}</td>
                <td>{$ad['city']}</td>
                <td>{$ad['price']}</td>
                <td>{$ad['area']}</td>
                <td>
                  <a href='?approve={$ad['id']}' class='btn btn-success me-2'>✔</a>
                  <a href='?reject={$ad['id']}' class='btn btn-danger'>✘</a>
                </td>
              </tr>";
      }
    } else {
      echo "<tr><td colspan='7'>Nema oglasa za provjeru.</td></tr>";
    }
    ?>
  </tbody>
</table>

<?php include 'footer.php'; ?>
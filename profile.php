<?php
include 'header.php';

if(!isset($_SESSION['user_id'])){
  header('Location: login.php');
  exit;
}

// Fetch user info
$user_id = $_SESSION['user_id'];
$userQ   = $conn->query("SELECT * FROM users WHERE id='$user_id'");
$user    = $userQ->fetch_assoc();

// Change password
if(isset($_POST['change_password'])){
  $oldPass = $_POST['old_password'];
  $newPass = $_POST['new_password'];
  if(password_verify($oldPass, $user['password'])){
    $newHashed = password_hash($newPass, PASSWORD_BCRYPT);
    $conn->query("UPDATE users SET password='$newHashed' WHERE id='$user_id'");
    $msg = "Lozinka uspješno promijenjena.";
  } else {
    $error = "Stara lozinka nije točna.";
  }
}

// If admin, show admin options
if($user['is_admin'] == 1 && isset($_GET['delete_user'])){
  $deleteUserId = $_GET['delete_user'];
  // Prevent self-deletion in this example
  if($deleteUserId != $user_id){
    $conn->query("DELETE FROM users WHERE id='$deleteUserId'");
  }
}

// If user wants to delete an ad
if(isset($_GET['delete_ad'])){
  $adId = $_GET['delete_ad'];
  // Check if user owns the ad or if admin
  if($_SESSION['is_admin'] == 1){
    $conn->query("DELETE FROM ads WHERE id='$adId'");
  } else {
    // normal user -> must verify ownership
    $conn->query("DELETE FROM ads WHERE id='$adId' AND user_id='$user_id'");
  }
  header('Location: profile.php');
  exit;
}

?>
<h2 class="my-4">Moj profil</h2>
<?php if(isset($msg)) echo "<div class='alert alert-success'>$msg</div>"; ?>
<?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
<div class="row">
  <div class="col-md-6">
    <h4>Moji podaci</h4>
    <p>Ime: <?php echo $user['first_name']; ?></p>
    <p>Prezime: <?php echo $user['last_name']; ?></p>
    <p>E-mail: <?php echo $user['email']; ?></p>
    <p>Mobitel: <?php echo $user['phone']; ?></p>
    <hr>
    <h5>Promjena lozinke</h5>
    <form method="POST">
      <div class="mb-3">
        <label>Stara lozinka</label>
        <input type="password" class="form-control" name="old_password" required>
      </div>
      <div class="mb-3">
        <label>Nova lozinka</label>
        <input type="password" class="form-control" name="new_password" required>
      </div>
      <button type="submit" name="change_password" style="background-color: #11212d; color: #fff; border-color: #11212d;" class="btn btn-primary">Promijeni lozinku</button>
    </form>
  </div>
  <div class="col-md-6">
    <?php if($user['is_admin'] == 1): ?>
      <h4>Administrator opcije</h4>
      <a href="?show=users" class="btn btn-secondary my-2">Korisnici</a>
      <a href="?show=ads" class="btn btn-secondary my-2">Oglasi</a>
      <hr>
      <?php 
      if(isset($_GET['show']) && $_GET['show'] == 'users'){
        // Show list of users
        $allUsers = $conn->query("SELECT * FROM users WHERE id != '$user_id'");
        echo "<h5>Popis korisnika</h5>";
        echo "<table class='table table-bordered'><tr><th>Ime i Prezime</th><th>Email</th><th>Mobitel</th><th>Akcija</th></tr>";
        while($row = $allUsers->fetch_assoc()){
          echo "<tr>
                  <td>{$row['first_name']} {$row['last_name']}</td>
                  <td>{$row['email']}</td>
                  <td>{$row['phone']}</td>
                  <td><a href='?show=users&delete_user={$row['id']}' class='btn btn-danger btn-sm'>Obriši</a></td>
                </tr>";
        }
        echo "</table>";
      }
      if(isset($_GET['show']) && $_GET['show'] == 'ads'){
        // Show all ads
        $allAds = $conn->query("SELECT ads.*, users.email 
                                FROM ads 
                                JOIN users ON ads.user_id = users.id");
        echo "<h5>Popis oglasa</h5>";
        echo "<table class='table table-bordered'><tr><th>Naslov</th><th>Status</th><th>Korisnik</th><th>Akcija</th></tr>";
        while($row = $allAds->fetch_assoc()){
          echo "<tr>
                  <td>{$row['title']}</td>
                  <td>{$row['status']}</td>
                  <td>{$row['email']}</td>
                  <td><a href='?show=ads&delete_ad={$row['id']}' class='btn btn-danger btn-sm'>Obriši</a></td>
                </tr>";
        }
        echo "</table>";
      }
      ?>
    <?php else: ?>
      <h4>Moji oglasi</h4>
      <?php
      $myAds = $conn->query("SELECT * FROM ads WHERE user_id='$user_id'");
      if($myAds->num_rows > 0){
        echo "<table class='table table-bordered'>
                <tr><th>Naslov</th><th>Status</th><th>Akcija</th></tr>";
        while($ad = $myAds->fetch_assoc()){
          echo "<tr>
                  <td>{$ad['title']}</td>
                  <td>{$ad['status']}</td>
                  <td><a href='?delete_ad={$ad['id']}' class='btn btn-danger btn-sm'>Obriši</a></td>
                </tr>";
        }
        echo "</table>";
      } else {
        echo "<p>Nemate predanih oglasa.</p>";
      }
      ?>
    <?php endif; ?>
  </div>
</div>

<?php include 'footer.php'; ?>
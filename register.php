<?php 
include 'header.php'; 

if(isset($_SESSION['user_id'])){
  // Already logged in
  header("Location: profile.php");
  exit;
}

if(isset($_POST['submit_register'])){
  $fname    = $_POST['fname'];
  $lname    = $_POST['lname'];
  $email    = $_POST['email'];
  $phone    = $_POST['phone'];
  $password = $_POST['password'];

  // Check if email already exists
  $checkQuery = $conn->prepare("SELECT * FROM users WHERE email=?");
  $checkQuery->bind_param("s", $email);
  $checkQuery->execute();
  $result = $checkQuery->get_result();
  if($result->num_rows > 0){
    $error = "E-mail je već registriran!";
  } else {
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $insertQuery = $conn->prepare("
      INSERT INTO users (first_name, last_name, email, phone, password, is_admin) 
      VALUES (?, ?, ?, ?, ?, 0)
    ");
    $insertQuery->bind_param("sssss", $fname, $lname, $email, $phone, $hashedPassword);

    if($insertQuery->execute()){
      // Registration successful
      header("Location: login.php");
      exit;
    } else {
      $error = "Nešto je pošlo po zlu. Pokušajte ponovo.";
    }
  }
}
?>

<div class="row justify-content-center">
  <div class="col-md-6">
    <h2 class="my-4">Registracija</h2>
    <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="POST" action="">
      <div class="mb-3">
        <label>Ime</label>
        <input type="text" class="form-control" name="fname" required>
      </div>
      <div class="mb-3">
        <label>Prezime</label>
        <input type="text" class="form-control" name="lname" required>
      </div>
      <div class="mb-3">
        <label>E-mail</label>
        <input type="email" class="form-control" name="email" required>
      </div>
      <div class="mb-3">
        <label>Mobitel</label>
        <input type="text" class="form-control" name="phone" required>
      </div>
      <div class="mb-3">
        <label>Lozinka</label>
        <input type="password" class="form-control" name="password" required>
      </div>
      <button type="submit" name="submit_register" style="background-color: #11212d; color: #fff; border-color: #11212d;" class="btn btn-primary">Registriraj se</button>
    </form>
  </div>
</div>

<?php include 'footer.php'; ?>
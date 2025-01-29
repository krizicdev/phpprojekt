<?php 
include 'header.php'; 

if(isset($_SESSION['user_id'])){
  // Already logged in
  header("Location: profile.php");
  exit;
}

if(isset($_POST['submit_login'])){
  $email    = $_POST['email'];
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $res = $stmt->get_result();

  if($res && $res->num_rows > 0){
    $user = $res->fetch_assoc();
    // Verify password
    if(password_verify($password, $user['password'])){
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['is_admin'] = $user['is_admin'];
      header("Location: profile.php");
      exit;
    }
  }
  $error = "Neispravni podaci za prijavu!";
}

?>

<div class="row justify-content-center">
  <div class="col-md-6">
    <h2 class="my-4">Prijava</h2>
    <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="POST" action="">
      <div class="mb-3">
        <label>E-mail</label>
        <input type="email" class="form-control" name="email" required>
      </div>
      <div class="mb-3">
        <label>Lozinka</label>
        <input type="password" class="form-control" name="password" required>
      </div>
      <button type="submit" name="submit_login"  style="background-color: #11212d; color: #fff; border-color: #11212d;" class="btn btn-primary">Prijavi se</button>
    </form>
    <p class="mt-3">Nemate račun? <a href="register.php" style="color: #4a5c6a;">Registrirajte se</a></p>
  </div>
</div>

<?php include 'footer.php'; ?>
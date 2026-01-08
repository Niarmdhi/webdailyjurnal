<?php
session_start();
require_once "koneksi.php"; 

$error_message = "";

// jika sudah login
if (isset($_SESSION['username'])) {
    header("Location: admin.php");
    exit;
}

// proses login
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['user'];
    $password = md5($_POST['pass']); // sesuai database kamu

    $stmt = $koneksi->prepare(
        "SELECT username FROM user WHERE username=? AND password=?"
    );
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $_SESSION['username'] = $data['username'];
        header("Location: admin.php");
        exit;
    } else {
        $error_message = "Username atau password salah!";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Journal Nia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="journal.svg">
</head>

<body class="bg-danger-subtle">
<div class="container mt-5 pt-5">
  <div class="row">
    <div class="col-12 col-sm-8 col-md-6 m-auto">
      <div class="card border-0 shadow rounded-5">
        <div class="card-body">

          <div class="text-center mb-3">
            <i class="bi bi-person-circle display-4"></i>
            <p class="mb-0">My Daily Journal</p>
            <hr>
          </div>

          <?php if ($error_message != "") { ?>
            <div class="alert alert-danger text-center rounded-4 py-2">
              <?= $error_message ?>
            </div>
          <?php } ?>

          <form method="post">
            <input type="text" name="user" class="form-control my-3 rounded-4" placeholder="Username" required>
            <input type="password" name="pass" class="form-control my-3 rounded-4" placeholder="Password" required>
            <div class="d-grid">
              <button class="btn btn-danger rounded-4">Login</button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>

<?php 
include $_SERVER['DOCUMENT_ROOT'].'/LibrarySys/classes/User.php';

$db = new DBconn();

session_start();

$user = new User($db->getConnection());

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user->user_name = $_POST['user_name'];
    $user->password = $_POST['password'];

    if ($user->login('user_name','password')) {
        $_SESSION['id'] = $user->id;
        $_SESSION['user_name'] = $user->user_name;
        header("Location: welcome.php");
        exit;
    } else {
        $login_error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
</head>
<body>
  <div class="container p-5 card mt-5">
      <form method="POST" action="">
      <h2>Login</h2>
      <?php
      if (isset($login_error)) {
          echo "<p style='color:red;'>$login_error</p>";
      }
      ?>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Username</label>
        <input type="text" class="form-control" name="user_name" id="exampleInputEmail1" required>
      </div>
      <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" class="form-control" name="password" id="exampleInputPassword1" required>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</body>
</html> 



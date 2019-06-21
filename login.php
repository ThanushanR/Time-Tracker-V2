<?php
session_start();
include 'database_config_dashboard.php';

if (isset($_SESSION["type"])) {
  header("location:index.php");
}

$message = '';

if (isset($_POST["login"])) {
  if ($_POST["user_email"] == null || $_POST["user_password"] == null) {
    $message = "<div class='alert alert-warning' role='alert'> Email address/Password cannot be empty </div>";
  } else {
    $query = "
	SELECT * FROM USER
		WHERE user_email = :user_email
	";
    $statement = $connect->prepare($query);
    $statement->execute(
      array(
        'user_email' => $_POST["user_email"],
      )
    );
    $count = $statement->rowCount();
    if ($count > 0) {
      $result = $statement->fetchAll();
      foreach ($result as $row) {
        if ($row['user_status'] == 'Active') {
          if (password_verify($_POST["user_password"], $row["user_password"])) {

            $_SESSION['type']      = $row['user_type'];
            $_SESSION['user_id']   = $row['user_id'];
            $_SESSION['user_name'] = $row['user_name'];
            header("location:index.php");
          } else {

            $message = "<div class='alert alert-warning' role='alert'> Wrong Password </div>";

          }
        } else {
          $message = "<div class='alert alert-warning' role='alert'> Account Disabled </div>";
        }
      }
    } else {
      $message = "<div class='alert alert-warning' role='alert'> Wrong email Address </div>";
    }
  }

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
    integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous" />
  <title>PULSE</title>
</head>

<body>

  <p></p>
  <p></p>


  <div class="container">
    <div class="card mx-auto" style="width: 20rem;">
      <img class="card-img-top mx-auto" src="./images/login.png" alt="Card image cap" style="width:60%;" />
      <div class="card-body">

        <form method="POST">

          <?php echo $message; ?>
          <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
              placeholder="Enter email" name="user_email" />
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password"
              name="user_password" />
          </div>

          <button type="submit" name="login" class="btn btn-primary"><i class="fa fa-lock"></i> &nbsp;Login</button>

        </form>
      </div>
      <?php
if(isset($_GET["newpwd"])){
    if($_GET["newpwd"]=="passwordupdated"){
        echo '<p class ="signupsucess">Your password has been reset! Now you can login </p>';
    }
}
?>
      <div class="card-footer"><a href="resetPassword.php">Forget Password ?</a></div>

    </div>
  </div>

</body>

</html>
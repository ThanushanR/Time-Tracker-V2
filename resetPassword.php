
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
    <div class="wrapper-main">
        <Section class="section-default">
            <h1> Reset your password </h1>
<p> An e-mail will be send to you with instructions on how to reset your password. </p>
<form action="includes/reset-request.inc.php" method="post">
    <input type="text" name="email" placeholder="Enter your e-mail address...">
    <button type="submit" name="reset-request-submit">Receive new password by email </button>

        </Section>
    </div>
</form>
<?php
if(isset($_GET["reset"])){
    if($_GET["reset"]=="success"){
        echo '<p class ="signupsucess">Check your e-mail!</p>';
    }
}
?>
</body>

</html>

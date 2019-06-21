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
            <?php
$selector = $_GET["selector"];
$validator = $_GET["validator"];

if(empty($selector) || empty($validator)){
    echo "could not validate your request !";
}else{
    if(ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false){
?>

            <form action="includes/resetPassword.inc.php" method="post">
                <input type="hidden" name="selector" value="<?php echo $selector; ?>" />
                <input type="hidden" name="validator" value="<?php echo $validator; ?>" />
                <input type="password" name="pwd" placeholder="Enter your password ..." />
                <input type="password" name="pwd-repeat" placeholder="Repeat new password ..." />
                <button type="submit" name="reset-password-submit">reset Password</button>

            </form>
            <?php

    }
}

?>

</body>

</html>
<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
if (isset($_POST["reset-request-submit"])) {
    $selector = bin2hex(random_bytes(8));
    $token    = random_bytes(32);
   print_r($selector, $token);
    $url = "http://localhost/SGIC-Time-Tracker-v1/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);

    $expires = date("U") + 1800;
    include('../database_mysqli_assign_company.php');

    $userEmail = $_POST["email"];
    $sql       = "DELETE FROM pwdReset WHERE pwdResetEmail=?";
    $stmt      = mysqli_stmt_init($connect);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "There was an error!";
        exit();
    } else {
        mysqli_stmt_bind_param($stmt,"s",$userEmail);
        mysqli_stmt_execute($stmt);
    }
    $sql="INSERT INTO pwdReset (pwdResetEmail,PWdResetSelector,pwdResetToken,pwdResetExpires) VALUES(?,?,?,?);";
    $stmt      = mysqli_stmt_init($connect);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "There was an error!";
        exit();
    } else {
        $hashedToken =password_hash($token,PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt,"ssss",$userEmail,$selector,$hashedToken,$expires);
        mysqli_stmt_execute($stmt);
    }
    mysqli_stmt_close($stmt);
    mysqli_close($connect);

// Load Composer's autoloader
require '../phpmailer/vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 1;                                       // Enable verbose debug output
    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Host       = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'samuelgnanamhrm@gmail.com';                     // SMTP username
    $mail->Password   = 'SGIC123456';                               // SMTP password
    $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('samuelgnanamhrm@gmail.com', 'TIME TRACKER PASSWORD RESET');
    $mail->addAddress ($userEmail, 'Thiru Tech');
    $Body ='<p> We recieved a password reset request. The link to reset your password is below if it is not 
    make this request, you can ignore this email </p>';

    $Body .='<p>Here is your password reset link : </br>';
    $Body.='<a href ="'.$url.'">'.$url.'</a></P>';
    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Reset your password for SGIC Time Tracker';
    $mail->Body    = $Body;
    $mail->AltBody = strip_tags($Body);

    $mail->send();
    header("location:../resetPassword.php?reset=success");
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
    // $to =$userEmail;

    // $subject = 'Reset your password for SGIC Time Tracker';
    // $message ='<p> We recieved a password reset request. The link to reset your password is below if it is not 
    // make this request, you can ignore this email </p>';

    // $message .='<p>Here is your password reset link : </br>';
    // $message.='<a href ="'.$url.'">'.$url.'</a></P>';

    // $headers ="From: thiru <samuelgnanamhrm@gmail.com>\r\n";
    // $headers .="Reply-To:<samuelgnanamhrm@gmail.com>\r\n";
    // $headers .="Content-type: text/html\r\n";

    // mail($to,$subject,$message,$headers);
    // header("Location:../resetPassword.php?reset=success");

     

} else {
    header("location:../index.php");
}
?>
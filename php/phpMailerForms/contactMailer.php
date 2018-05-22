<?php

    require '../PHPMailer/PHPMailerAutoload.php';

    $mail = new PHPMailer;

    // Get the form fields, removes html tags and whitespace.
    $name = strip_tags(trim($_POST["name"]));
    $name = str_replace(array("\r","\n"),array(" "," "),$name);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);


    $message = trim($_POST["message"]);


    $mail->isMail();                               
    $mail->Host = gethostbyname("smtp.gmail.com");
    $mail->SMTPAuth = false;                               // Enable SMTP authentication
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                    // TCP port to connect to

    // Check the data.
    if (empty($name) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: /index.php?csuccess=-1#contact");
        exit;
    }

    $mail->setFrom($email, $name);
    $mail->addAddress('travesia@gmail.com', 'Travesia');     // Add a recipient

    $mail->Subject = $name .. " les ha mandado un email";

    // Build the email content.
    $email_content = "Nombre: $name\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Mensaje:\n$message\n";

    $mail->Body    = $email_content;

    if(!$mail->send()) {
        header("Location: http://travesia/?csuccess=-1#contact");                           //usar pagina de verdad
        exit;
    } else {
        header("Location: http://travesia.com/?csuccess=1#contact");
    }


?>
<?php
$errors = [];


function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["fio"])) {
        $errors[] = "ФІО обов'язкове для заповнення";
    } else {
        $fio = test_input($_POST["fio"]);
    }

    if (empty($_POST["company"])) {
        $errors[] = "Компанія обов'язкова для заповнення";
    } else {
        $company = test_input($_POST["company"]);
    }

    if (empty($_POST["email"])) {
        $errors[] = "Email обов'язковий для заповнення";
    } else {
        $email = test_input($_POST["email"]);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Неправильний формат email";
        }
    }

    if (empty($_POST["phone"])) {
        $errors[] = "Телефон обов'язковий для заповнення";
    } else {
        $phone = test_input($_POST["phone"]);
    }

    $text = test_input($_POST["text"]);

    if (!isset($_POST["agree"])) {
        $errors[] = "Необхідно погодитись з умовами";
    }


    if (empty($errors)) {
        $to = 'tetiana.kubyshkina@am-bits.com, oleh.chaus@am-bits.com, sales@am-bits.dev ';
        $subject = 'Нова заявка із сайту';
        $message = "ФІО: $fio\n";
        $message .= "Компанія: $company\n";
        $message .= "Email: $email\n";
        $message .= "Телефон: $phone\n\n";
        $message .= "Повідомлення: $text\n";

        $headers = "From: sender@example.com\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=utf-8\r\n";

        if (mail($to, $subject, $message, $headers)) {
            $success_message = "OK";
        } else {
            $errors[] = "Помилка при надсиланні листа. Будь ласка, спробуйте пізніше.";
        }
    }
}
?>
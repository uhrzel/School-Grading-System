<?php

require('../classes/PHPMailer/PHPMailerAutoload.php');
require('../autoload.php');

$student = new Student;

if ($student->isLoggedIn()) {
    Redirect::to('index.php?page=dashboard');
}

if (Input::exists()) {
    $validate = new Validate;
    $validation = $validate->check($_POST, [
        'email' => [
            'display' => 'Email',
            'required' => true,
            'email' => true
        ]
    ]);

    if ($validation->passed()) {
        try {
            $res = $student->findBy('email', Input::get('email'))->first();

            if ($res) {
                Session::put('verify_id', $res->id);
                Redirect::to('reset-password.php');
            } else {
                Session::flash('error', 'Email not found!');
            }
        } catch (Exception $e) {
            Session::flash('error', 'Something went wrong!' . $e->getMessage());
        }
    } else {
        Session::flash('error', $validation->errors()[0]);
    }
}

?>

<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        Email
    </title>

    <link rel="shortcut icon" type="image/png" href="../assets/images/favicon.ico?">
    <link href="../assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

</head>

<body class="vh-100">
    <div class="authincation">
        <div class="container d-flex align-items-center justify-content-center" style="height: 100vh;">
            <div class="authincation-content mx-auto shadow rounded" style="width: 400px;">
                <div class="auth-form py-4 text-center">

                    <i class="fas fa-mail-bulk fa-5x text-primary"></i>

                    <h4 class="my-4 text-uppercase fw-bold">
                        Enter your email to verify your account
                    </h4>

                    <?= Session::display_session_msg() ?>

                    <form method="POST" class="mt-4">
                        <div class="mb-3">
                            <input type="text" class="form-control border-secondary" placeholder="Email" name="email" value="<?= Input::get('email') ?>">
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary btn-block text-uppercase">
                                    Submit
                                </button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/vendor/global/global.min.js"></script>
    <script src="../assets/vendor/chart.js/Chart.bundle.min.js"></script>
    <script src="../assets/vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>
</body>

</html>
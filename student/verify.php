<?php

require('../classes/PHPMailer/PHPMailerAutoload.php');
require('../autoload.php');

if (!Session::exists('verify_email') || !Session::exists('verify_parents_email')) {
   Redirect::to('login.php');
}

$student = new Student;

$s = $student->findBy('email', Session::get('verify_email'))->first();

if ($s->status === 'verified') {
   Redirect::to('index.php?page=dashboard');
}

$otp = new Otp;

if (Input::exists()) {
   $validate = new Validate;
   $validation = $validate->check($_POST, [
      'otp' => [
         'display' => 'OTP',
         'required' => true,
         'min' => 6,
         'max' => 6
      ],
      'parents_otp' => [
         'display' => 'Parents OTP',
         'required' => true,
         'min' => 6,
         'max' => 6
      ],
   ]);

   if ($validation->passed()) {
      try {
         $res = $otp->findBy('otp_code', Input::get('otp'));

         if ($res) {
            // Update student status to verified
            $student->update($s->id, [
               'status' => 'verified',
               'parents_otp' => ''
            ]);

            $email = new Email;
            $email->send(Session::get('verify_email'), 'Account Verified', 'Your account has been verified.');

            Session::delete('verify_email');
            Session::delete('verify_parents_email');
            Session::flash('success', 'Your account has been verified. You can now login.');
            header('refresh: 3; url=login.php');
         } else {
            Session::flash('error', 'Invalid OTP code.');
         }
      } catch (Exception $e) {
         Session::flash('error', $e->getMessage());
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
      Verify OTP
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

               <i class="fas fa-user-check fa-5x text-primary"></i>

               <h4 class="my-4 text-uppercase fw-bold text-primary">
                  Verify OTP
               </h4>

               <!-- <h6 class="fw-bold text-primary">
                  </h6> -->

               <?= Session::display_session_msg() ?>

               <form method="POST">
                  <?= Session::exists('verify_email') ? Session::get('verify_email') : '' ?>

                  <div class="mb-3">
                     <input type="text" class="form-control border-secondary" placeholder="OTP" name="otp">
                  </div>
                  <br>
                  <?= Session::exists('verify_parents_email') ? Session::get('verify_parents_email') : '' ?>
                  <div class="mb-3">
                     <input type="text" class="form-control border-secondary" placeholder="Parents OTP" name="parents_otp">
                  </div>
                  <button type="submit" class="btn btn-primary btn-block">Verify</button>
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
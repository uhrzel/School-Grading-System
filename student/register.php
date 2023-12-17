<?php

require('../classes/PHPMailer/PHPMailerAutoload.php');
error_reporting(0);
require('../autoload.php');

$student = new Student;
$course = new Course;

if(Input::exists()){
   $validate = new Validate;
   $validation = $validate->check($_POST, [
      'email' => [
            'display' => 'Email',
            'required' => true,
            'unique' => 'students',
            'valid_email' => true
      ],
      'parents_email' => [
            'display' => 'Parents Email',
            'required' => true,
            'unique' => 'students',
            'valid_email' => true
      ],
      'id_number' => [
            'display' => 'ID Number',
            'required' => true,
            'unique' => 'students',
            'min' => 5,
            'max' => 7
      ],
      'first_name' => [
            'display' => 'First Name',
            'required' => true,
            'min' => 2,
            'max' => 50
      ],
      'last_name' => [
            'display' => 'Last Name',
            'required' => true,
            'min' => 2,
            'max' => 50
      ],
      'course_id' => [
            'display' => 'Course',
            'required' => true
      ],
      'password' => [
            'display' => 'Password',
            'required' => true,
            'min' => 6
      ],
      'confirm_password' => [
            'display' => 'Confirm Password',
            'required' => true,
            'matches' => 'password'
      ]
   ]);

   if($validation->passed()){
      try{
         $otp = new Otp();
         $otp_code = rand(100000, 999999);
         $parents_otp_code = rand(100000, 999999);
         $student->create([
            'email' => Input::get('email'),
            'parents_email' => Input::get('parents_email'),
            'id_number' => Input::get('id_number'),
            'first_name' => Input::get('first_name'),
            'last_name' => Input::get('last_name'),
            'course_id' => Input::get('course_id'),
            'password' => Input::get('password'),
            'parents_otp' => $parents_otp_code
         ]);
         
         $otp->create([
               'student_id' => $student->lastInsertId(),
               'otp_code' => $otp_code
         ]);

         $body = '<p>Hi '.Input::get('first_name').' '.Input::get('last_name').',</p>
                  <p>Your OTP Code is <b>'.$otp_code.'</b></p>
                  <p>Password: '.Input::get('password').'</p>
                  <p>Thank you!</p>';

         $parents_body = '<p>Hi '.Input::get('first_name').' '.Input::get('last_name').',</p>
                  <p>Your Parents OTP Code is <b>'.$parents_otp_code.'</b></p>
                  <p>Password: '.Input::get('password').'</p>
                  <p>Thank you!</p>';

         $mail = new Email();
         $mail->send(Input::get('email'), 'Student OTP Code', $body);
         $mail->send(Input::get('parents_email'), 'Student Parents OTP Code', $parents_body);
         
         Session::flash('success', 'Registration successful. Please check your email for your OTP code.');
         Session::put('verify_email', Input::get('email'));
         Session::put('verify_parents_email', Input::get('parents_email'));
         header('refresh: 2; url=verify.php');
      }catch(Exception $e){
         Session::flash('error', $e->getMessage());
      }
   }else{
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

   <title>Registration</title>

   <link rel="shortcut icon" type="image/png" href="../assets/images/favicon.ico?">
   <link href="../assets/css/style.css" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

</head>

<body class="vh-100">
   <div class="authincation">
      <div class="container d-flex align-items-center justify-content-center" style="height: 100vh;">
         <div class="authincation-content mx-auto shadow rounded" style="width: 400px; margin-top: 100px;">
            <div class="auth-form py-4 text-center">

               <i class="fas fa-user-plus fa-3x text-primary"></i>

               <h4 class="my-4 text-uppercase fw-bold text-primary">
                  Student
               </h4>

               <?= Session::display_session_msg() ?>

               <form method="POST">
                  <div class="mb-3">
                     <input type="number" class="form-control border-secondary" placeholder="ID Number" name="id_number" id="id_number" value="<?= Input::get('id_number') ?>">
                  </div>
                  <div class="mb-3">
                     <input type="text" class="form-control border-secondary" placeholder="First Name" name="first_name" id="first_name" value="<?= Input::get('first_name') ?>">
                  </div>
                  <div class="mb-3">
                     <input type="text" class="form-control border-secondary" placeholder="Last Name" name="last_name" id="last_name" value="<?= Input::get('last_name') ?>">
                  </div>
                  <div class="mb-3">
                     <input type="text" class="form-control border-secondary" placeholder="Email" name="email" id="email" value="<?= Input::get('email') ?>">
                  </div>
                  <div class="mb-3">
                     <input type="text" class="form-control border-secondary" placeholder="Parents Email" name="parents_email" id="parents_email" value="<?= Input::get('parents_email') ?>">
                  </div>
                  <div class="mb-3">
                     <select name="course_id" id="course_id" class="form-control border-secondary">
                        <option disabled hidden selected value="">Select Course</option>
                        <?php
                           $courses = $course->findAll();
                           foreach($courses as $course){
                              echo '<option value="'.$course->id.'">'.$course->course_code . ' - ' . $course->course_description.'</option>';
                           }
                        ?>
                     </select>
                  </div>
                  <div class="mb-3">
                     <input type="password" class="form-control border-secondary" placeholder="Password" name="password" id="password">
                  </div>
                  <div class="mb-3">
                     <input type="password" class="form-control border-secondary" placeholder="Confirm Password" name="confirm_password" id="confirm_password">
                  </div>
                  <div class="text-center mt-4">
                     <button type="submit" class="btn btn-primary btn-block text-uppercase" name="register" id="register">
                        Register
                     </button>
                  </div>
               </form>
               <a href="login.php" class="btn btn-link text-center mt-3 p-0 mb-0">Login</a>
            </div>
         </div>
      </div>
   </div>
   <script src="../assets/vendor/global/global.min.js"></script>
   <script src="../assets/vendor/chart.js/Chart.bundle.min.js"></script>
   <script src="../assets/vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>
</body>

</html>
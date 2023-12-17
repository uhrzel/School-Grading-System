<?php

require('../autoload.php');

$teacher = new Teacher;

if ($teacher->isLoggedIn()) {
   Redirect::to('index.php?page=dashboard');
}

if (Input::exists()) {
   $validate = new Validate;
   $validation = $validate->check($_POST, [
      'username' => [
         'display' => 'Username',
         'required' => true,
      ],
      'password' => [
         'display' => 'Password',
         'required' => true,
         'min' => 3,
         'max' => 20
      ]
   ]);

   if ($validation->passed()) {
      try {
         $res = $teacher->login(Input::get('username'), Input::get('password'));
         if ($res) {
            Session::flash('success', 'You are now logged in!');
            Redirect::to('index.php?page=dashboard');
         } else {
            Session::flash('error', 'Invalid username or password!');
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

   <title>Log In</title>

   <link rel="shortcut icon" type="image/png" href="../assets/images/favicon.ico?">
   <link href="../assets/css/style.css" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <link rel="icon" type="image/png" href="../assets/images/basic_logo.png" />
</head>

<body class="vh-100">
   <div class="authincation">
      <div class="container d-flex align-items-center justify-content-center" style="height: 100vh;">
         <div class="authincation-content mx-auto shadow rounded" style="width: 400px;">
            <div class="auth-form py-4 text-center">

               <i class="fas fa-chalkboard-teacher fa-5x text-primary"></i>

               <h4 class="my-4 text-uppercase fw-bold">
                  Teacher
               </h4>

               <?= Session::display_session_msg() ?>

               <form method="POST" class="mt-4">
                  <div class="mb-3">
                     <input type="text" class="form-control border-secondary" placeholder="Teacher Username" name="username" id="username" value="<?= Input::get('username') ?>">
                  </div>
                  <div class="mb-3">
                     <input type="password" class="form-control border-secondary" placeholder="Password" name="password" id="password">
                  </div>
                  <div class="text-center mt-4">
                     <button type="submit" class="btn btn-primary btn-block text-uppercase">
                        Login
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
<?php

require('../classes/PHPMailer/PHPMailerAutoload.php');
require('../autoload.php');

$student = new Student;

if(!Session::exists('verify_id')){
    Redirect::to('login.php');
}

$res = $student->findById(Session::get('verify_id'));

if(Input::exists()){
    $validate = new Validate;
    $validation = $validate->check($_POST, [
        'password' => [
            'display' => 'Password',
            'required' => true,
            'min' => 3,
            'max' => 20
        ],
         'confirm_password' => [
               'display' => 'Confirm Password',
               'required' => true,
               'matches' => 'password'
         ]
    ]);

    if($validation->passed()){
        try{
            $student->update(Session::get('verify_id'), [
                'password' => Input::get('password')
            ]);

            Session::flash('success', 'Password reset successfully!');
            Redirect::to('login.php');
        }catch(Exception $e){
            Session::flash('error', 'Something went wrong!' . $e->getMessage());
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

   <title>
      Reset Password
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

               <i class="fas fa-user-circle fa-5x text-primary"></i>

               <h4 class="my-4 text-uppercase fw-bold">
                  Reset Password
               </h4>

               <?= Session::display_session_msg() ?>

               <form method="POST" class="mt-4">
                  <!-- echo Session::get('verify_email'); -->
                  <?php if(Session::exists('verify_id')): ?>
                     <div class="mb-3">
                        <input type="email" class="form-control border-secondary" placeholder="Email" name="email" id="email" value="<?= $res->email ?>" readonly>
                     </div>
                  <?php endif; ?>
                  <div class="mb-3">
                     <input type="password" class="form-control border-secondary" placeholder="Password" name="password" id="password">
                  </div>
                  <div class="mb-3">
                     <input type="password" class="form-control border-secondary" placeholder="Confirm Password" name="confirm_password" id="confirm_password">
                  </div>
                  <div class="text-center mt-4">
                     <button type="submit" class="btn btn-primary btn-block text-uppercase">
                        Reset Password
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
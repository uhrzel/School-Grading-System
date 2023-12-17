<?php

$student = new Student();
$course = new Course();

$students = $student->findAll('ORDER BY last_name ASC');
$courses = $course->findAll('ORDER BY id DESC');

if(isset($_POST['create_student'])){
    $validate = new Validate();
    $validation = $validate->check($_POST, [
        'course_id' => [
            'display' => 'Course',
            'required' => true
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
        'parents_email' => [
            'display' => 'Parents Email',
            'required' => true,
            'unique' => 'students',
            'valid_email' => true
        ],
        'email' => [
            'display' => 'Email',
            'required' => true,
            'unique' => 'students',
            'valid_email' => true
        ],
        'password' => [
            'display' => 'Password',
            'required' => true,
            'min' => 6
        ],
    ]);

    if($validation->passed()){
        try{
            $otp = new Otp();
            $otp_code = rand(100000, 999999);
            $parents_otp_code = rand(100000, 999999);

            $student->create([
                'course_id' => Input::get('course_id'),
                'id_number' => Input::get('id_number'),
                'parents_email' => Input::get('parents_email'),
                'email' => Input::get('email'),
                'password' => Input::get('password'),
                'first_name' => Input::get('first_name'),
                'last_name' => Input::get('last_name'),
                'parents_otp' => $parents_otp_code,
            ]);

            $otp->create([
                'student_id' => $student->lastInsertId(),
                'otp_code' => $otp_code
            ]);

            $body = '<p>Hi '.Input::get('first_name').' '.Input::get('last_name').',</p>
                    <p>Your OTP Code is <b>'.$otp_code.'</b></p>
                    <p>ID Number: '.Input::get('id_number').'</p>
                    <p>Email: '.Input::get('email').'</p>
                    <p>Password: '.Input::get('password').'</p>
                    <p>Thank you!</p>';

            $parents_body = '<p>Hello Parent of '.Input::get('first_name').' '.Input::get('last_name').',</p>
                    <p>Your OTP Code is <b>'.$parents_otp_code.'</b></p>
                    <p>ID Number: '.Input::get('id_number').'</p>
                    <p>Email: '.Input::get('email').'</p>
                    <p>Password: '.Input::get('password').'</p>
                    <p>Thank you!</p>';

            $mail = new Email();
            $mail->send(Input::get('email'), 'Student OTP Code', $body);
            $mail->send(Input::get('parents_email'), 'Student OTP Code', $parents_body);
            
            Session::flash('success', 'Student successfully added. Please check your email for the OTP Code.');
            echo '<script>window.location.href = "?page=students";</script>';
        }catch(Exception $e){
            Session::flash('error', $e->getMessage());
        }
    } else {
        Session::flash('error', $validation->errors()[0]);
        echo '<script>window.location.href = "?page=students";</script>';
    }
}

?>

<div class="container-fluid">

    <div class="card shadow">
        <div class="card-header">
            <h5 class="card-title">
                Student List (<?= count($students); ?>)
            </h5>

            <div class="float-end">
            <a href="javascript:history.back()" class="btn btn-primary btn-sm">
                    <i class="fas fa-arrow-left"></i>
                    Back
                </a>
                <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                    data-bs-target="#createStudentModal">
                    <i class="fas fa-plus"></i>
                    Add Student
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered datatable" style="width: 100%">
                    <thead>
                        <tr>
                            <th>ID Number</th>
                            <th>Name</th>
                            <th>Course</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($students as $s): ?>
                        <tr>
                            <td><?= $s->id_number; ?></td>
                            <td><?= $s->last_name . ', ' . $s->first_name; ?></td>
                            <td>
                                <?php
                                    $c = $course->findById($s->course_id);
                                    echo $c->course_code . ' - ' . $c->course_description;
                                ?>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="?page=student&id=<?= $s->id?>" class="dropdown-item">
                                                <i class="fas fa-eye"></i>
                                                View
                                            </a>
                                        </li>
                                        <li>
                                            <a href="delete.php?table=students&id=<?= $s->id?>" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this student?')">
                                                <i class="fas fa-trash"></i>
                                                Delete
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="createStudentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="createStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="createStudentModalLabel">
                    <i class="fas fa-plus-circle"></i>
                    Add Student
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <label class="mb-1" for="course_id">Course</label>
                    <select class="form-select" name="course_id" id="course_id" required>
                        <option selected hidden disabled>Select Course</option>
                        <?php foreach($courses as $c): ?>
                        <option value="<?= $c->id; ?>"><?= $c->course_code . ' - ' . $c->course_description; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label class="mb-1 mt-3" for="id_number">ID Number</label>
                    <input type="number" class="form-control" name="id_number" id="id_number" required
                        placeholder="e.g. 2019030001">
                    <label class="mb-1 mt-3" for="first_name">First Name</label>
                    <input type="text" class="form-control" name="first_name" id="first_name" required
                        placeholder="e.g. Juan">
                    <label class="mb-1 mt-3" for="last_name">Last Name</label>
                    <input type="text" class="form-control" name="last_name" id="last_name" required
                        placeholder="e.g. Dela Cruz">
                    <label class="mb-1 mt-3" for="parents_email">Parents Email</label>
                    <input type="email" class="form-control" name="parents_email" id="parents_email" required
                        placeholder="e.g. parents@gmail.com">
                    <label class="mb-1 mt-3" for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" required
                        placeholder="e.g. sample@gmail.com">
                    <label class="mb-1 mt-3" for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password" required
                        placeholder="e.g. ********">
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary btn-block" name="create_student">
                            <i class="fas fa-plus-circle"></i>
                            Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php

$teacher = new Teacher();
$course = new Course();

$teachers = $teacher->findAll('ORDER BY last_name ASC');
$courses = $course->findAll('ORDER BY id DESC');

if (isset($_POST['create_teacher'])) {
    $validate = new Validate();
    $validation = $validate->check($_POST, [
        'username' => [
            'display' => 'Username',
            'required' => true,
            'unique' => 'teachers',
            'min' => 6,
            'max' => 50
        ],
        'email' => [
            'display' => 'Email',
            'required' => true,
            'unique' => 'teachers',
            'valid_email' => true
        ],
        'password' => [
            'display' => 'Password',
            'required' => true,
            'min' => 6
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
        ]
    ]);

    if ($validation->passed()) {
        try {
            $teacher->create([
                'username' => Input::get('username'),
                'email' => Input::get('email'),
                'password' => Input::get('password'),
                'first_name' => Input::get('first_name'),
                'last_name' => Input::get('last_name')
            ]);

            $otp = new OTP();
            $otp_code = rand(100000, 999999);
            $otp->create([
                'teacher_id' => $teacher->lastInsertId(),
                'otp_code' => $otp_code
            ]);

            $body = '<p>Hi ' . Input::get('first_name') . ' ' . Input::get('last_name') . ',</p>
                    <p>Your OTP Code is <b>' . $otp_code . '</b></p>
                    <p>Password: ' . Input::get('password') . '</p>
                    <p>Thank you!</p>';

            $mail = new Email();
            $mail->send(Input::get('email'), 'Teacher OTP Code', $body);

            Session::flash('success', 'Teacher successfully added. Please check your email for the OTP Code.');
        } catch (Exception $e) {
            Session::flash('error', 'Something went wrong.' . $e->getMessage());
        }
    } else {
        Session::flash('error', $validation->errors()[0]);
    }
    echo '<script>window.location.href = "?page=teachers";</script>';
}
?>

<div class="container-fluid">

    <div class="card shadow">
        <div class="card-header">
            <h5 class="card-title">
                Teacher List (<?= count($teachers); ?>)
            </h5>

            <div class="float-end">
                <a href="javascript:history.back()" class="btn btn-primary btn-sm">
                    <i class="fas fa-arrow-left"></i>
                    Back
                </a>
                <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createTeacherModal">
                    <i class="fas fa-plus"></i>
                    Add Teacher
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered datatable" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <?php foreach ($teachers as $t) : ?>
                        <tr>
                            <td><?= $t->last_name . ', ' . $t->first_name; ?></td>
                            <td>
                                <div class="dropdown">
                                    <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="?page=teacher&id=<?= $t->id ?>" class="dropdown-item">
                                                <i class="fas fa-eye"></i>
                                                View
                                            </a>
                                        </li>
                                        <li>
                                            <a href="delete.php?table=teachers&id=<?= $t->id ?>" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this teacher?')">
                                                <i class="fas fa-trash"></i>
                                                Delete
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="createTeacherModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createTeacherModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="createTeacherModalLabel">
                    <i class="fas fa-plus-circle"></i>
                    Add Teacher
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <label class="mb-1" for="username">Username</label>
                    <input type="text" class="form-control" name="username" id="username" required placeholder="e.g. jdelacruz">
                    <label class="mb-1 mt-3" for="first_name">First Name</label>
                    <input type="text" class="form-control" name="first_name" id="first_name" required placeholder="e.g. Juan">
                    <label class="mb-1 mt-3" for="last_name">Last Name</label>
                    <input type="text" class="form-control" name="last_name" id="last_name" required placeholder="e.g. Dela Cruz">
                    <label class="mb-1 mt-3" for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" required placeholder="e.g. sample@gmail.com">
                    <label class="mb-1 mt-3" for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password" required placeholder="e.g. ********">
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary btn-block" name="create_teacher">
                            <i class="fas fa-plus-circle"></i>
                            Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
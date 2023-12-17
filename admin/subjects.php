<?php

$subject = new Subject();
$course = new Course();
$subjects = $subject->findAll('ORDER BY id DESC');
$courses = $course->findAll();

?>

<div class="container-fluid">

    <div class="card shadow">
        <div class="card-header">
            <h5 class="card-title">
                Subject List (<?= count($subjects); ?>)
            </h5>

            <div class="float-end">
            <a href="javascript:history.back()" class="btn btn-primary btn-sm">
                    <i class="fas fa-arrow-left"></i>
                    Back
                </a>
                <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createSubjectModal">
                    <i class="fas fa-plus"></i>
                    Add Subject
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered datatable" style="width: 100%">
                <thead>
                    <tr>
                        <th>Subject Code</th>
                        <th>Course</th>
                        <th>Action</th>
                    </tr>
                </thead>
                    <?php foreach($subjects as $c): ?>
                    <tr>
                        <td><?= $c->subject_code; ?></td>
                        <td><?= $course->findById($c->course_id)->course_code; ?></td>
                        <td>
                            <div class="dropdown">
                                <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="?page=subject&id=<?= $c->id?>" class="dropdown-item">
                                            <i class="fas fa-eye"></i>
                                            View
                                        </a>
                                    </li>
                                    <li>
                                        <a href="delete.php?table=subjects&id=<?= $c->id?>" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this student?')">
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

<div class="modal fade" id="createSubjectModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="createSubjectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createSubjectModalLabel">
                        <i class="fas fa-plus-circle"></i>
                        Add Subject
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                
                    <?php
                        if(isset($_POST['create_subject'])){
                            try{
                                if($subject->subject_code_exists(Input::get('subject_code'), Input::get('course_id'))){
                                    Session::flash('error', 'Subject code already exists!');
                                    echo "<script>window.location.href = '?page=subjects';</script>";
                                }else{
                                    $subject->create([
                                        'course_id' => Input::get('course_id'),
                                        'subject_code' => Input::get('subject_code'),
                                        'subject_description' => Input::get('subject_description'),
                                        'subject_units' => Input::get('subject_units')
                                    ]);
                                    Session::flash('success', 'Subject successfully added!');
                                    echo '<script>window.location.href = "?page=subjects";</script>';
                                }
                            }catch(Exception $e){
                                Session::flash('error', $e->getMessage());
                            }
                        }
                    ?>

                    <form method="POST">
                        <label class="mb-1" for="course_id">Course</label>
                        <select name="course_id" id="course_id" class="form-select" required>
                            <option selected hidden disabled value="">Select Course</option>
                            <?php foreach($courses as $c): ?>
                                <option value="<?= $c->id; ?>"><?= $c->course_code; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label class="mb-1 mt-3" for="subject_code">Subject Code</label>
                        <input type="text" class="form-control" name="subject_code" id="subject_code"
                            required placeholder="e.g. BSIT">
                        <label class="mb-1 mt-3" for="subject_description">Subject Description</label>
                        <input type="text" class="form-control" name="subject_description" id="subject_description"
                            required placeholder="e.g. Bachelor of Science in Information Technology">
                        <label class="mb-1 mt-3" for="subject_units">Subject Units</label>
                        <input type="number" class="form-control" name="subject_units" id="subject_units"
                            required placeholder="e.g. 3">
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary btn-block"
                                name="create_subject">
                                <i class="fas fa-plus-circle"></i>
                                Create
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
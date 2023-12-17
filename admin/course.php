<?php

$course = new Course();
$subject = new Subject();
$student = new Student();

if(!Input::get('id') || !$course->findById(Input::get('id'))){
    echo '<script>window.location.href = "?page=courses";</script>';
}

$c = $course->findById(Input::get('id'));

$subjects = $subject->findAll("WHERE course_id = {$c->id} ORDER BY subject_code ASC");

$students = $student->findAll("WHERE course_id = {$c->id} ORDER BY last_name ASC");

?>

<div class="container-fluid">

    <div class="card shadow">
        <div class="card-header">
            <h5 class="card-title">
                <?= $c->course_code . ' - ' . $c->course_description; ?>
            </h5>

            <div class="float-end">

                <a href="javascript:history.back()" class="btn btn-primary btn-sm">
                    <i class="fas fa-arrow-left"></i>
                    Back
                </a>

            </div>
        </div>
        <div class="card-body">

            <div class="custom-tab-1">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#course_subject"><i
                                class="fas fa-file-lines me-2"></i> Subject</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#course_student"><i
                                class="fas fa-users me-2"></i> Student</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#course_details">
                            <i class="fas fa-book me-2"></i> Information</a>
                    </li>
                </ul>
                <div class="tab-content">

                    <div class="tab-pane fade active show" id="course_subject">
                        <div class="table-responsive">
                            <h4 class="fw-bold my-3">
                                Overall Total Subjects (<?= count($subjects); ?>)
                            </h4>
                            <table class="table table-hover table-bordered datatable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Subject Code</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($subjects as $s): ?>
                                    <tr>
                                        <td><?= $s->subject_code; ?></td>
                                        <td>
                                            <a href="?page=subject&id=<?=$s->id?>" class="btn btn-info">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            </table>
                        </div>                        
                    </div>

                    <div class="tab-pane fade" id="course_student">
                        <div class="table-responsive">
                            <h4 class="fw-bold my-3">
                                Overall Total Students (<?= count($students); ?>)
                            </h4>
                            <table class="table table-hover table-bordered datatable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID Number</th>
                                    <th>Student Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($students as $s): ?>
                                    <tr>
                                        <td><?= $s->id_number; ?></td>
                                        <td><?= $s->first_name . ' ' . $s->last_name; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            </table>
                        </div>  
                    </div>

                    <div class="tab-pane fade" id="course_details" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="course_code">Course Code</label>
                                            <input type="text" class="form-control" id="course_code" name="course_code"
                                                value="<?= $c->course_code; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="course_description">Course Description</label>
                                            <input type="text" class="form-control" id="course_description"
                                                name="course_description" value="<?= $c->course_description; ?>"
                                                disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="course_year">Year</label>
                                            <input type="text" class="form-control" id="course_year" name="course_year"
                                                value="4" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="course_subjects">Total Subjects</label>
                                            <input type="text" class="form-control" id="course_subjects"
                                                name="course_subjects" value="<?= count($subjects); ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="course_units">Total Units</label>
                                            <input type="text" class="form-control" id="course_units" name="course_units"
                                                value="<?= $subject->get_total_units(); ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="course_students">Total Students</label>
                                            <input type="text" class="form-control" id="course_students"
                                                name="course_students" value="<?= count($students); ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>
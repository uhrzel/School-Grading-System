<?php

$subject = new Subject();
$course = new Course();
$student = new Student();
$teacher = new Teacher();
$student_subject = new StudentSubject();

if(!Input::get('id') || !$subject->findById(Input::get('id'))){
    echo '<script>window.location.href = "?page=subjects";</script>';
}

$s = $subject->findById(Input::get('id'));

$c = $course->findById($s->course_id);

$students = $student_subject->findAll("WHERE subject_id = {$s->id} ORDER BY student_id ASC");

$teachers = $student_subject->findAll("WHERE subject_id = {$s->id} ORDER BY teacher_id ASC");

?>

<div class="container-fluid">

    <div class="card shadow">
        <div class="card-header">
            <h5 class="card-title">
                <?= $s->subject_code . ' - ' . $s->subject_description; ?>
            </h5>

            <div class="float-end">

            <a href="javascript:history.back()" class="btn btn-primary btn-sm">
                    <i class="fas fa-arrow-left"></i>
                    Back
                </a>

                <div class="dropdown">
                    <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-bs-toggle="dropdown">
                        <?php if($s->status == 'open'): ?>
                        Close
                        <?php else: ?>
                        Open
                        <?php endif;?>
                        <i class="fas fa-ellipsis-v"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <?php if($s->status == 'open'): ?>
                        <li>
                            <a href="change_status.php?action=open&id=<?=$s->id;?>" class="dropdown-item"
                                onclick="return confirm('Are you sure you want to open status')">
                                Open
                            </a>
                        </li>
                        <?php else: ?>
                        <li>
                            <a href="change_status.php?action=close&id=<?=$s->id;?>" class="dropdown-item"
                                onclick="return confirm('Are you sure you want to close status')">
                                Close
                            </a>
                        </li>
                        <?php endif;?>
                    </ul>
                </div>

            </div>
        </div>
        <div class="card-body">

            <div class="custom-tab-1">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#subject_students"><i
                                class="fas fa-file-lines me-2"></i> Student</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#subject_teachers"><i
                                class="fas fa-users me-2"></i> Teachers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#subject_details">
                            <i class="fas fa-book me-2"></i> Information</a>
                    </li>
                </ul>
                <div class="tab-content">

                    <div class="tab-pane fade active show" id="subject_students">
                        <div class="table-responsive">
                            <h4 class="fw-bold my-3">
                                Overall Total Students (<?= count($students); ?>)
                            </h4>
                            <table class="table table-hover table-bordered datatable" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID Number</th>
                                        <th>Name</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($students as $st): ?>
                                    <?php
                                    $st_details = $student->findById($st->student_id);
                                    ?>
                                    <tr>
                                        <td><?= $st_details->id_number; ?></td>
                                        <td><?= $st_details->first_name . ' ' . $st_details->last_name; ?></td>

                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="subject_teachers">
                        <div class="table-responsive">
                            <h4 class="fw-bold my-3">
                                Overall Total Teachers (<?= count($teachers); ?>)
                            </h4>
                            <table class="table table-hover table-bordered datatable" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($teachers as $te): ?>
                                    <?php
                                    $te_details = $teacher->findById($te->teacher_id);
                                    ?>
                                    <tr>
                                        <td><?= $te_details->first_name . ' ' . $te_details->last_name; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="subject_details" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="subject_code">Subject Code</label>
                                            <input type="text" class="form-control" id="subject_code"
                                                name="subject_code" value="<?= $s->subject_code; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="subject_description">Subject Description</label>
                                            <input type="text" class="form-control" id="subject_description"
                                                name="subject_description" value="<?= $s->subject_description; ?>"
                                                disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="subject_units">Subject Units</label>
                                            <input type="text" class="form-control" id="subject_units"
                                                name="subject_units" value="<?= $s->subject_units; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <input type="text" class="form-control" id="status" name="status"
                                                value="<?= $s->status; ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="created_at">Created At</label>
                                            <input type="text" class="form-control" id="created_at" name="created_at"
                                                value="<?= $s->created_at; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="course_id">Course</label>
                                            <input type="text" class="form-control" id="course_id" name="course_id"
                                                value="<?= $c->course_code . ' - ' . $c->course_description; ?>"
                                                disabled>
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
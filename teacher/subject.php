<?php

$subject = new Subject();
$course = new Course();
$student = new Student();
$curriculum = new Curriculum();
$student_subject = new StudentSubject();

if(!Input::get('id') || !$subject->findById(Input::get('id'))){
    echo '<script>window.location.href = "?page=dashboard";</script>';
}

$s = $subject->findById(Input::get('id'));

$c = $course->findById($s->course_id);

$students = $student_subject->findAll('INNER JOIN students ON students.id = student_subjects.student_id WHERE student_subjects.subject_id = ' . $s->id);

?>

<div class="container-fluid">

    <div class="card shadow">
        <div class="card-header">
            <h5 class="card-title">
                <?= $s->subject_code . ' - ' . $s->subject_description; ?>
            </h5>

            <div class="float-end">
                
                <?php if($s->status == 'open'): ?>
                    <span class="badge bg-success">Open</span>
                <?php else: ?>
                    <span class="badge bg-danger">Closed</span>
                <?php endif;?>

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
                                        <th>Name</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($students as $st): ?>
                                        <tr>
                                            <td><?= $student->get_full_name($st->student_id); ?></td>
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
                                            <label for="subject_description">Subject Description</label>
                                            <input type="text" class="form-control" id="subject_description"
                                                name="subject_description" value="<?= $s->subject_description; ?>"
                                                disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="subject_units">Subject Units</label>
                                            <input type="text" class="form-control" id="subject_units"
                                                name="subject_units" value="<?= $s->subject_units; ?>" disabled>
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
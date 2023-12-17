<?php

$subject = new Subject();
$course = new Course();
$student = new Student();
$teacher = new Teacher();
$student_subject = new StudentSubject();
$curriculum = new Curriculum();

if(!Input::get('id') || !$student->findById(Input::get('id'))){
    echo '<script>window.location.href = "?page=dashboard";</script>';
}

$s = $student->findById(Input::get('id'));

$c = $course->findById($s->course_id);

$subjects = $student_subject->findAll('WHERE student_id = ' . Input::get('id'));

$teachers = $student_subject->findAll("WHERE subject_id = {$s->id} ORDER BY teacher_id ASC");

?>

<div class="container-fluid">

    <div class="card shadow">
        <div class="card-header">
            <h5 class="card-title">
                <?= $s->first_name . ' ' . $s->last_name; ?> - <?= $c->course_code?>
            </h5>

            <div class="float-end d-flex">

                <a href="javascript:history.back()" class="btn btn-primary btn-sm">
                    <i class="fas fa-arrow-left"></i>
                    Back
                </a>

                <div class="dropdown">
                    <?php if($s->status == 'pending'): ?>
                    <a href="javascript:void(0)" class="btn btn-danger btn-sm" data-bs-toggle="dropdown">
                        <?= ucfirst($s->status); ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="update_status.php?table=students&id=<?= $s->id; ?>&status=active">
                                <i class="fas fa-check"></i>
                                Activate
                            </a>
                        </li>
                    </ul>
                    <?php else: ?>
                    <a href="javascript:void(0)" class="btn btn-success btn-sm" data-bs-toggle="dropdown">
                        Active
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="update_status.php?table=students&id=<?= $s->id; ?>&status=pending">
                                <i class="fas fa-times"></i>
                                Deactivate
                            </a>
                        </li>
                    </ul>
                    <?php endif; ?>
                </div>

            </div>
        </div>
        <div class="card-body">

            <div class="custom-tab-1">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#student_sub"><i
                                class="fas fa-file-lines me-2"></i> Subject</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#student_info">
                            <i class="fas fa-book me-2"></i> Information</a>
                    </li>
                </ul>
                <div class="tab-content">

                    <div class="tab-pane fade active show" id="student_sub">
                        <div class="table-responsive">
                            <h4 class="fw-bold my-3">
                                Overall Total Subject (<?= count($subjects); ?>)
                            </h4>
                            <table class="table table-hover table-bordered datatable" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Subject Code</th>
                                        <th>Teacher</th>
                                        <th>School Year</th>
                                        <th>Session</th>
                                        <th>Year Level</th>
                                        <th>Geade</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($subjects as $st): ?>
                                    <tr>
                                        <td><?= $subject->findById($st->subject_id)->subject_code; ?></td>
                                        <td><?= $teacher->get_full_name($st->teacher_id); ?></td>
                                        <td><?= $curriculum->findById($st->curriculum_id)->curriculum_school_year; ?></td>
                                        <td><?= $curriculum->findById($st->curriculum_id)->curriculum_session; ?></td>
                                        <td><?= $curriculum->findById($st->curriculum_id)->curriculum_year_level; ?></td>
                                        <td><?= ($st->grade == null) ? 'N/A' : $st->grade; ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <a href="javascript:void(0)" class="btn btn-primary btn-sm"
                                                    data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                    <a href="delete.php?table=student_subjects&id=<?= $st->id; ?>&student_id=<?=$s->id;?>" class="dropdown-item">
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

                    <div class="tab-pane fade" id="student_info" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="text" class="form-control" id="email" name="email"
                                                value="<?= $s->email; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="full_name">Full Name</label>
                                            <input type="text" class="form-control" id="full_name" name="full_name"
                                                value="<?= $s->first_name . ' ' . $s->last_name; ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="id_number">ID Number</label>
                                            <input type="text" class="form-control" id="id_number" name="id_number"
                                                value="<?= $s->id_number; ?>" disabled>
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
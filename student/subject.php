<?php

$subject = new Subject();
$teacher = new Teacher();
$curriculum = new Curriculum();
$course = new Course();
$student_subject = new StudentSubject();

if(!Input::get('id') || !$student_subject->findById(Input::get('id'))){
    echo '<script>window.location.href = "?page=dashboard";</script>';
}

$ss = $student_subject->findById(Input::get('id'));

$s = $subject->findById($ss->subject_id);

$t = $teacher->findById($ss->teacher_id);

$c = $curriculum->findById($ss->curriculum_id);

$co = $course->findById($s->course_id);

?>

<div class="container-fluid">

    <div class="card shadow">
        <div class="card-header">
            <span class="badge bg-primary">
                <?= $s->subject_code; ?>
            </span>
            <div class="float-end">
                <a href="javascript:history.back()" class="btn btn-primary btn-sm">
                    <i class="fas fa-arrow-left"></i>
                    Back
                </a>

                <!-- <div class="dropdown">
                    <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-bs-toggle="dropdown">
                        <i class="fas fa-ellipsis-v"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="delete.php?table=subjects&id=<?= $ss->id?>" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this subject?')">
                                <i class="fas fa-trash"></i>
                                Delete
                            </a>
                        </li>
                    </ul>
                </div> -->
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card shadow">
                <div class="card-header">
                    <span class="badge bg-primary">
                        <b>Grade :</b> <?= ($ss->grade == null) ? 'N/A' : $ss->grade; ?>
                    </span>
                    <span class="badge bg-primary">
                        <b>Status :</b> <?= ($s->status == 'close') ? 'Closed' : 'Open'; ?>
                    </span>
                </div>
                <div class="card-body">
                    <p class="card-text mb-0">
                        <b>Units :</b>
                        <?php if($s->subject_units == '1'): ?>
                        <?= $s->subject_units; ?> Unit
                        <?php else: ?>
                        <?= $s->subject_units; ?> Units
                        <?php endif; ?>
                    </p>
                    <p class="card-text mb-0">
                        <b>Description :</b>
                        <?= $s->subject_description; ?>
                    </p>
                    <p class="card-text mb-0">
                        <b>Teacher :</b>
                        <?= $t->first_name . ' ' . $t->last_name; ?>
                    </p>
                    <p class="card-text mb-0">
                        <b>Year Level :</b>
                        <?= $c->curriculum_year_level . ' - ' . $c->curriculum_session; ?>
                    </p>
                    <p class="card-text mb-0">
                        <b>School Year :</b>
                        <?= $c->curriculum_school_year; ?>
                    </p>
                    <p class="card-text mb-0">
                        <b>Course :</b>
                        <?= $co->course_code . ' - ' . $co->course_description; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>
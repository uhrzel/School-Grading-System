<?php

$student = new Student;
$teacher = new Teacher;

$students = $student->findAll('ORDER BY id DESC');
$teachers = $teacher->findAll('ORDER BY id DESC');

$course = new Course();
$subject = new Subject();
$curriculum = new Curriculum();
$student_subjects = new StudentSubject();

$ss = $student_subjects->findAll('ORDER BY id DESC');

?>

<div class="container-fluid">

    <div class="row invoice-card-row">
        <div class="col-sm-6">
            <a class="card bg-warning invoice-card text-decoration-none" href="?page=students">
                <div class="card-body d-flex">
                    <div class="me-3">
                        <i class="fas fa-user-graduate fs-30 text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-white invoice-num">
                            <?= count($students); ?>
                        </h2>
                        <span class="text-white fs-18">
                            Students
                        </span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6">
            <a class="card bg-success invoice-card text-decoration-none" href="?page=teachers">
                <div class="card-body d-flex">
                    <div class="me-3">
                        <i class="fas fa-chalkboard-teacher fs-30 text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-white invoice-num">
                            <?= count($teachers); ?>
                        </h2>
                        <span class="text-white fs-18">
                            Teachers
                        </span>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header">
            <h5 class="card-title">
                Recently Graded Students <span class="badge bg-primary"><?= count($ss); ?></span>
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered datatable" style="width: 100%">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Subject</th>
                        <th>School Year</th>
                        <th>Year Level</th>
                        <th>Session</th>
                        <th>Grade</th>
                        <th>Course</th>
                    </tr>
                </thead>
                    <?php foreach($ss as $s): ?>
                        <?php $sub = $subject->get_subject_info($s->subject_id); ?>
                        <tr>
                            <td><?= $student->get_full_name($s->student_id); ?></td>
                            <td><?= $subject->get_subject_code($s->subject_id); ?></td>
                            <td><?= $curriculum->get_curriculum_info($s->curriculum_id)->curriculum_school_year; ?></td>
                            <td><?= $curriculum->get_curriculum_info($s->curriculum_id)->curriculum_year_level; ?></td>
                            <td><?= $curriculum->get_curriculum_info($s->curriculum_id)->curriculum_session; ?></td>
                            <td><?= ($s->grade == null) ? 'N/A' : $s->grade; ?></td>
                            <td><?= $course->get_course_info($sub->course_id)->course_code; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>

</div>
<?php

$student_subjects = new StudentSubject();

$subject = new Subject();

$course = new Course();

$student = new Student();

$curriculum = new Curriculum();

$teacher = new Teacher();

if(!Input::get('id')) {
    Redirect::to('index.php');
}

$ss = $student_subjects->findAll('WHERE teacher_id = ' . Input::get('id'));

$t = $teacher->findById(Input::get('id'));

?>

<div class="container-fluid">
    
    <div class="row invoice-card-row">
        <div class="col-sm-12">
            <a class="card bg-warning invoice-card text-decoration-none" href="javascript:void(0)">
                <div class="card-body d-flex mx-auto">
                    <div class="me-3">
                        <i class="fas fa-chalkboard-teacher fs-30 text-white"></i>
                    </div>
                    <div class="text-center">
                        <h2 class="text-white invoice-num">
                            <?= $t->first_name . ' ' . $t->last_name ?>
                        </h2>
                        <span class="text-white fs-18">
                            Subjects : <?= count($ss) ?>
                        </span>
                    </div>
                </div>
            </a>
        </div>
        <!-- <div class="col-sm-4">
            <a class="card bg-success invoice-card text-decoration-none" href="?page=teachers">
                <div class="card-body d-flex">
                    <div class="me-3">
                        <i class="fas fa-user-graduate fs-30 text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-white invoice-num">
                            0
                        </h2>
                        <span class="text-white fs-18">
                            Overall Students
                        </span>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-sm-4">
            <a class="card bg-info invoice-card text-decoration-none" href="?page=teachers">
                <div class="card-body d-flex">
                    <div class="me-3">
                        <i class="fas fa-book-open fs-30 text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-white invoice-num">
                            0
                        </h2>
                        <span class="text-white fs-18">
                            Course
                        </span>
                    </div>
                </div>
            </a>
        </div> -->
    </div>

    <div class="card">
    <div class="card-body">
    <div class="table-responsive">
        <table class="table table-hover table-bordered datatable" style="width:100%;">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Student</th>
                    <th>Year Level</th>
                    <th>Session</th>
                    <th>School Year</th>
                    <th>Grade</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($ss as $s): ?>
                    <?php $cur = $curriculum->get_curriculum_info($s->curriculum_id); ?>
                <tr>
                    <td><?= $subject->get_subject_code($s->subject_id) ?></td>
                    <td><?= $student->get_full_name($s->student_id) ?></td>
                    <td><?= $cur->curriculum_year_level ?></td>
                    <td><?= $cur->curriculum_session ?></td>
                    <td><?= $cur->curriculum_school_year ?></td>
                    <td><?= ($s->grade == 0) ? 'N/A' : $s->grade ?></td>
                    <td>
                        <div class="dropdown">
                            <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="?page=add-grade&id=<?= $s->id?>" class="dropdown-item">
                                        <i class="fas fa-plus"></i>
                                        Grade
                                    </a>
                                    <a href="delete.php?table=student_subjects&id=<?= $s->id?>" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this subject?')">
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
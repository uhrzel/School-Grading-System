<?php

$course = new Course();
$courses = $course->findAll('ORDER BY id DESC');

?>

<div class="container-fluid">

    <div class="card shadow">
        <div class="card-header">
            <h5 class="card-title">
                Curriculum
            </h5>

            <div class="float-end">
                <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createCurriculumModal">
                    <i class="fas fa-plus"></i>
                    Add
                </a>
            </div>
        </div>
    </div>

    <div class="row invoice-card-row">
        <div class="col-sm-12">
            <a class="card bg-warning invoice-card text-decoration-none" href="javascript:void(0)" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createCourseModal">
                <div class="card-body d-flex">
                    <div class="me-3">
                        <i class="fas fa-plus-circle fs-30 text-white"></i>
                    </div>
                    <div>
                        <h5 class="text-white invoice-num">
                            Add Curriculum
                        </h5>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header">
            <h5 class="card-title">
                Course List (<?= count($courses); ?>)
            </h5>

            <div class="float-end">
                <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createCourseModal">
                    <i class="fas fa-plus"></i>
                    Add Course
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered datatable" style="width: 100%">
                <thead>
                    <tr>
                        <th>Course Code</th>
                        <th>Course Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                    <?php foreach($courses as $c): ?>
                    <tr>
                        <td><?= $c->course_code; ?></td>
                        <td><?= $c->course_description; ?></td>
                        <td>
                            <a href="?page=course&id=<?= $c->id; ?>" class="btn btn-primary btn-sm">View</a>
                        </td>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>

</div>
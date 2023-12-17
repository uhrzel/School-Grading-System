<?php

$course = new Course();
$courses = $course->findAll('ORDER BY id DESC');

?>

<div class="container-fluid">

    <div class="card shadow">
        <div class="card-header">
            <h5 class="card-title">
                Course List (<?= count($courses); ?>)
            </h5>

            <div class="float-end">
            <a href="javascript:history.back()" class="btn btn-primary btn-sm">
                    <i class="fas fa-arrow-left"></i>
                    Back
                </a>
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
                            <div class="dropdown">
                                <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="?page=course&id=<?= $c->id?>" class="dropdown-item">
                                            <i class="fas fa-eye"></i>
                                            View
                                        </a>
                                    </li>
                                    <li>
                                        <a href="delete.php?table=courses&id=<?= $c->id?>" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this course?')">
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
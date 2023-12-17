<?php

$curriculum = new Curriculum();
$curriculums = $curriculum->findAll('ORDER BY id DESC');

?>

<div class="container-fluid">

    <div class="card shadow">
        <div class="card-header">
            <h5 class="card-title">
                Curriculum List (<?= count($curriculums); ?>)
            </h5>

            <div class="float-end">
                <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                    data-bs-target="#createCurriculumModal">
                    <i class="fas fa-plus"></i>
                    Add Curriculum
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered datatable" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Curriculum Code</th>
                            <th>Curriculum Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <?php foreach($curriculums as $c): ?>
                    <tr>
                        <td><?= $c->curriculum_code; ?></td>
                        <td><?= $c->curriculum_description; ?></td>
                        <td>
                            <a href="?page=curriculum&id=<?= $c->id; ?>" class="btn btn-primary btn-sm">View</a>
                        </td>
                        <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="createCurriculumModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="createCurriculumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="createCurriculumModalLabel">
                    <i class="fas fa-plus-circle"></i>
                    Add Curriculum
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <?php
                        if(isset($_POST['create_course'])){
                            try{
                                $course = new Course();
                                $course->create([
                                    'course_code' => Input::get('course_code'),
                                    'course_description' => Input::get('course_description')
                                ]);
                                
                                Session::flash('success', 'Course created successfully!');
                                echo '<script>window.location.href = "?page=courses";</script>';
                            }catch(Exception $e){
                                Session::flash('error', $e->getMessage());
                            }
                        }
                    ?>

                <form method="POST">
                    <label class="mb-1" for="course_code">Course Code</label>
                    <input type="text" class="form-control" name="course_code" id="course_code" required
                        placeholder="e.g. BSIT">
                    <label class="mb-1 mt-3" for="course_description">Course Description</label>
                    <input type="text" class="form-control" name="course_description" id="course_description" required
                        placeholder="e.g. Bachelor of Science in Information Technology">
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary btn-block" name="create_course">
                            <i class="fas fa-plus-circle"></i>
                            Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
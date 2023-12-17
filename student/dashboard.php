<?php

$curriculum = new Curriculum();
$curriculums = $curriculum->findAll('WHERE student_id = '.Session::get('student').' ORDER BY curriculum_year_level DESC');

?>

<div class="container-fluid">

    <div class="card shadow">
        <div class="card-header">
            <h5 class="card-title">
                Curriculum (<?= count($curriculums); ?>)
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
        <?php foreach($curriculums as $curriculum): ?>
        <div class="col-sm-12">
            <a class="card bg-info shadow invoice-card text-decoration-none" href="?page=curriculum&id=<?= $curriculum->id; ?>">
                <div class="card-body">
                    <h2 class="text-white invoice-num">
                        <?php
                        if($curriculum->curriculum_year_level == '1st Year'){
                            echo 'First Year';
                        }elseif($curriculum->curriculum_year_level == '2nd Year'){
                            echo 'Second Year';
                        }elseif($curriculum->curriculum_year_level == '3rd Year'){
                            echo 'Third Year';
                        }elseif($curriculum->curriculum_year_level == '4th Year'){
                            echo 'Fourth Year';
                        }
                        ?>
                    </h2>
                    <span class="text-white fs-18">
                        <?= $curriculum->curriculum_session; ?>
                    </span>
                    <p class="text-white fs-18 mb-0">
                        <?= $curriculum->curriculum_school_year; ?>
                    </p>
                </div>
            </a>
        </div>
        <?php endforeach; ?>
    </div>

</div>
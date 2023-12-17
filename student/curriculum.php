<?php

$student_subject = new StudentSubject();
$curriculum = new Curriculum();
$course = new Course();
$subject = new Subject();
$teacher = new Teacher();

if(!Input::get('id') || !$curriculum->findById(Input::get('id'))){
    echo '<script>window.location.href = "?page=dashboard";</script>';
}

$cur = $curriculum->findById(Input::get('id'));

$subjects = $student_subject->findAll("WHERE curriculum_id = {$cur->id} ORDER BY subject_id ASC");

$teachers = $teacher->findAll();
$_subjects = $subject->findAll('WHERE course_id = ' . $s->course_id);

?>

<div class="container-fluid">

    <div class="card shadow">
        <div class="card-header">
            <span class="badge bg-primary">
                <?php if($cur->curriculum_year_level == '1st Year'): ?>
                First Year
                <?php elseif($cur->curriculum_year_level == '2nd Year'): ?>
                Second Year
                <?php elseif($cur->curriculum_year_level == '3rd Year'): ?>
                Third Year
                <?php elseif($cur->curriculum_year_level == '4th Year'): ?>
                Fourth Year
                <?php endif; ?>
                <br>
                <?= $cur->curriculum_session; ?>
            </span>
            <div class="float-end">

                <div class="dropdown">
                    <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-bs-toggle="dropdown">
                        <i class="fas fa-ellipsis-v"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="delete.php?table=curriculums&id=<?= $cur->id?>" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this curriculum?')">
                                <i class="fas fa-trash"></i>
                                Delete
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card-header">
            <h5 class="card-title">
                Subjects (<?= count($subjects); ?>)
            </h5>

            <div class="float-end">
                <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                    data-bs-target="#createSubjectModal">
                    <i class="fas fa-plus"></i>
                    Add
                </a>
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Subject Code</th>
                        <th>Teacher</th>
                        <th>Grade</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($subjects as $s): ?>
                        <?php
                            $sub = $subject->findById($s->subject_id);
                        ?>
                    <tr>
                        <td><?= $sub->subject_code; ?></td>
                        <td><?php
                        $t = $teacher->findById($s->teacher_id);
                        echo $t->first_name . ' ' . $t->last_name;
                        ?></td>
                        <td>
                            <?php $ss = $student_subject->findById($s->id); ?>
                            <?php if($ss->grade == null): ?>
                                <span class="badge bg-danger">Not Graded</span>
                            <?php else: ?>
                                <span class="badge bg-success"><?= $ss->grade; ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="dropdown">
                                <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="?page=subject&id=<?= $s->id?>" class="dropdown-item">
                                            <i class="fas fa-eye"></i>
                                            View
                                        </a>
                                    </li>
                                    <li>
                                        <a href="delete.php?table=student_subjects&id=<?= $s->id?>&cur_id=<?=$cur->id?>" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this subject?')">
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

    <div class="modal fade" id="createSubjectModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="createSubjectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createSubjectModalLabel">
                        <i class="fas fa-plus-circle"></i>
                        Add Subject
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <?php
                        if(isset($_POST['create_subject'])){
                            try{
                                if($student_subject->findByTeacherAndSubject(Input::get('teacher_id'), Input::get('subject_id'), $cur->id)){
                                    Session::flash('error', 'Teacher already assigned to this subject.');
                                    echo '<script>window.location.href = "index.php?page=curriculum&id=' . $cur->id . '";</script>';
                                }else{
                                    $student_subject->create([
                                        'student_id' => Session::get('student'),
                                        'teacher_id' => Input::get('teacher_id'),
                                        'subject_id' => Input::get('subject_id'),
                                        'curriculum_id' => $cur->id
                                    ]);
                                    Session::flash('success', 'Subject added successfully.');
                                    echo '<script>window.location.href = "index.php?page=curriculum&id=' . $cur->id . '";</script>';
                                }
                            }catch(Exception $e){
                                Session::flash('error', $e->getMessage());
                            }
                        }
                    ?>

                    <form method="POST">
                        <label class="mb-1" for="teacher_id">Teacher</label>
                        <select class="form-select mb-3" name="teacher_id" id="teacher_id" required>
                            <option selected disabled hidden value="">Select Teacher</option>
                            <?php foreach($teachers as $t): ?>
                            <option value="<?= $t->id; ?>"><?= $t->first_name . ' ' . $t->last_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label class="mb-1" for="subject_id">Subject</label>
                        <select class="form-select mb-3" name="subject_id" id="subject_id" required>
                            <option selected disabled hidden value="">Select Subject</option>
                            <?php foreach($_subjects as $s): ?>
                            <option value="<?= $s->id; ?>"><?= $s->subject_code . ' - ' . $s->subject_description; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary btn-block" name="create_subject">
                                <i class="fas fa-plus-circle"></i>
                                Add
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
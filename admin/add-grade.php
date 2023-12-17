<?php

$student_subjects = new StudentSubject();

$subject = new Subject();

$student = new Student();

$curriculum = new Curriculum();

if(!Input::get('id') || !$student_subjects->findById(Input::get('id'))){
    echo '<script>window.location.href = "?page=dashboard";</script>';
}

$ss = $student_subjects->findById(Input::get('id'));

$s = $subject->findById($ss->subject_id);

$st = $student->findById($ss->student_id);

$cur = $curriculum->findById($ss->curriculum_id);

if(Input::exists()){
    $student_subjects->update($ss->id, [
        'grade' => Input::get('grade')
    ]);

    Session::flash('success', 'Grade has been added successfully!');
    echo '<script>window.location.href = "?page=add-grade&id=' . $ss->id . '";</script>';
}

?>

<div class="container-fluid">

    <div class="card shadow border-0">
        <div class="card-header">
            <h3 class="card-title">Add Grade</h3>

            <div class="float-end">
                <a href="javascript:history.back()" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i>
                    Back
                </a>
            </div>
        </div>
        <div class="card-body">
            <p class="card-title">
            Subject: <?= $s->subject_code; ?>
            </p>
            <p class="card-title">
            Student: <?= $st->first_name . ' ' . $st->last_name; ?>
            </p>
            <p class="card-title">
            School Year: <?= $cur->curriculum_school_year; ?>
            </p>
            <p class="card-title">
            Year Level: <?= $cur->curriculum_year_level; ?>
            </p>
            <p class="card-title">
            Session: <?= $cur->curriculum_session; ?>
            </p>
            <p class="card-title">
            Grade: <?= ($ss->grade) ? $ss->grade : 'N/A'; ?>
            </p>

            <hr>

            <form method="POST" class="form">
                <label for="grade">Grade</label>
                <input type="number" name="grade" id="grade" class="form-control border-primary" value="<?= Input::get('grade') ?>" required placeholder="Enter grade here...">
                <br>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

</div>
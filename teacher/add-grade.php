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

    <div class="card">
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

            <form method="POST" class="bg-light p-3 shadow">
                <label for="grade">Grade</label>
                <input type="number" name="grade" id="grade" class="form-control" required>
                <br>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

</div>
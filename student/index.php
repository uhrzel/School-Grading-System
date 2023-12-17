<?php

require('../classes/PHPMailer/PHPMailerAutoload.php');
require('../autoload.php');

$page = (isset($_GET['page'])) ? $_GET['page'] : 'dashboard';

$student = new Student;

if ($page == 'logout' || !$student->isLoggedIn()) {
    $student->logout();
    Redirect::to('login.php');
} else {
    $s = $student->find(Session::get('student'))->first();
}

$title = ucwords($page);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        <?= $title ?> | <?= Config::get('app/name') ?>
    </title>

    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="../assets/images/favicon.ico?">

    <link href="../assets/vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/vendor/nouislider/nouislider.min.css">
    <link href="../assets/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- Style css -->
    <link href="../assets/css/style.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="../assets/images/basic_logo.png" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet">
</head>

<body>

    <div id="preloader">
        <div class="waviy">
            <span style="--i:1">L</span>
            <span style="--i:2">o</span>
            <span style="--i:3">a</span>
            <span style="--i:4">d</span>
            <span style="--i:5">i</span>
            <span style="--i:6">n</span>
            <span style="--i:7">g</span>
            <span style="--i:8">.</span>
            <span style="--i:9">.</span>
            <span style="--i:10">.</span>
        </div>
    </div>


    <div id="main-wrapper">

        <div class="nav-header">
            <a href="index.php" class="brand-logo">
                <img src="../assets/images/basic_logo.png" class="logo-abbr" width="53" height="53" alt="g">

                <img src="../assets/images/text_logo.png" class="brand-title" width="124px" height="33px" alt="grado">
            </a>
            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>

        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="dashboard_bar">
                                <?= $title ?>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <div class="dlabnav">
            <div class="dlabnav-scroll">
                <ul class="metismenu" id="menu">
                    <li class="dropdown header-profile">
                        <a class="nav-link shadow" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle fa-2x"></i>
                            <div class="header-info">
                                <span class="font-w600">
                                    <b>
                                        <?= $s->first_name . ' ' . $s->last_name ?>
                                    </b></span>
                                <p class="fs-12 mb-0">
                                    <?= $s->email ?>
                                </p>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item ai-icon" href="?page=logout" role="button">
                                <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg>
                                <span class="ms-2">Logout </span>
                            </a>
                        </div>
                    </li>
                    <li>
                        <a href="index.php?dashboard" class="ai-icon" aria-expanded="false">
                            <i class="flaticon-025-dashboard"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <!-- <li>
                        <a href="?page=report" class="ai-icon" aria-expanded="false">
                            <i class="fas fa-file-alt"></i>
                            <span class="nav-text">Report</span>
                        </a>
                    </li> -->
                </ul>
            </div>
        </div>

        <div class="content-body">

            <?php

            Session::display_session_msg();

            if (in_array($page, Config::get('pages')) && file_exists($page . '.php')) {
                include($page . '.php');
            } else {
                include('404.php');
            }

            ?>

        </div>
    </div>


    <div class="modal fade" id="createCurriculumModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createCurriculumModalLabel" aria-hidden="true">
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
                    if (isset($_POST['create_curriculum'])) {
                        try {
                            $curriculum = new Curriculum();
                            $curriculum->create([
                                'student_id' => Session::get('student'),
                                'curriculum_year_level' => Input::get('curriculum_year_level'),
                                'curriculum_session' => Input::get('curriculum_session'),
                                'curriculum_school_year' => Input::get('curriculum_school_year')
                            ]);

                            Session::flash('success', 'Curriculum created successfully!');
                            echo '<script>window.location.href = "?page=dashboard";</script>';
                        } catch (Exception $e) {
                            Session::flash('error', $e->getMessage());
                        }
                    }
                    ?>

                    <form method="POST">
                        <label class="mb-1" for="curriculum_year_level">Year Level</label>
                        <div class="input-group mb-3">
                            <select class="form-select" name="curriculum_year_level" id="curriculum_year_level">
                                <option selected disabled hidden value="">Select</option>
                                <option value="1st Year">1st Year</option>
                                <option value="2nd Year">2nd Year</option>
                                <option value="3rd Year">3rd Year</option>
                                <option value="4th Year">4th Year</option>
                            </select>
                        </div>
                        <label class="mb-1" for="curriculum_session">Session</label>
                        <div class="input-group mb-3">
                            <select class="form-select" name="curriculum_session" id="curriculum_session">
                                <option selected disabled hidden value="">Select</option>
                                <option value="First Semester">First Semester</option>
                                <option value="Second Semester">Second Semester</option>
                                <option value="Summer">Summer</option>
                            </select>
                        </div>
                        <label class="mb-1" for="curriculum_school_year">School Year</label>
                        <div class="input-group mb-3">
                            <select class="form-select" name="curriculum_school_year" id="curriculum_school_year">
                                <option selected disabled hidden value="">Select</option>
                                <?php
                                for ($i = 2010; $i <= 2030; $i++) {
                                    echo '<option value="' . $i . ' - ' . ($i + 1) . '">' . $i . ' - ' . ($i + 1) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary btn-block" name="create_curriculum">
                                <i class="fas fa-plus-circle"></i>
                                Create
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/vendor/global/global.min.js"></script>
    <script src="../assets/vendor/chart.js/Chart.bundle.min.js"></script>
    <script src="../assets/vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>

    <script src="../assets/vendor/apexchart/apexchart.js"></script>
    <script src="../assets/vendor/nouislider/nouislider.min.js"></script>
    <script src="../assets/vendor/datatables/js/jquery.dataTables.min.js"></script>


    <script src="../assets/js/custom.min.js"></script>
    <script src="../assets/js/dlabnav-init.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.datatable').DataTable();
        });
    </script>

</body>

</html>
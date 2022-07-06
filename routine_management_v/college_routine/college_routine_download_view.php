<?php $this->load->view($this->config->item('theme_uri') . 'layout/header_view'); ?>
<?php $this->load->view($this->config->item('theme_uri') . 'layout/left_menu_view'); ?>
<!-- Content Wrapper. Contains page content -->
<style type="text/css">
    .tablebody {
        padding: 0 30px;
    }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Routine Management System v1.0
        </h1>
        <ol class="breadcrumb">
            <li><a href="dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <!--        <li class="active">Publications</li>-->
            <li class="active">List of routine</li>
        </ol>
    </section>
    <br>
    <?php if ($msg = $this->session->userdata('success')) { ?>
        <div class="alert alert-dismissible alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong><?php echo $msg; ?></strong>
            <?php unset($_SESSION['success']); ?>
        </div>
    <?php } ?>
    <?php if ($msg = $this->session->userdata('error')) { ?>
        <div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong><?php echo $msg; ?></strong>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php } ?>
    <!-- Main content -->
    <?php echo form_open('admin/routine_management_c/college_routine/College_download_routine'); ?>
    <div class="row" style="padding: 5px;">
        <div class="col-sm-4">
            <label>Academic Session</label><span class="text-danger">*</span>
            <select class="form-control" name="academic_year" id="academic_year">
                <option value="">--Select Academic Session--</option>
                <option value="3" <?php echo set_select('academic_year', 3, False); ?>>
                    2021
                </option>

            </select>
            <span class="text-danger"><?php echo form_error('academic_year'); ?></span>
        </div>
        <div class="col-sm-4">
            <label>Discipline</label><span class="text-danger">*</span>
            <select class="form-control" name="discipline_type" id="discipline_type">
                <option value="">--Select Discipline --</option>
                <?php foreach ($discipline as $discipline) { ?>
                    <option value="<?php echo $discipline['course_id_pk'] ?>" <?php echo set_select('discipline_type', $discipline['course_id_pk'], False); ?>>
                        <?php echo $discipline['course_name'] ?>
                    </option>
                <?php } ?>
            </select>
            <span class="text-danger"><?php echo form_error('discipline_type'); ?></span>
        </div>
        <div class="col-sm-4">
            <label>Year</label><span class="text-danger">*</span>
            <select class="form-control" name="stud_year" id="stud_year">
                <option value="">--Select Year --</option>
                <?php foreach ($year as $year) { ?>
                    <option value="<?php echo $year['id'] ?>" <?php echo set_select('stud_year', $year['id'], False); ?>>
                        <?php echo $year['description'] ?>
                    </option>
                <?php } ?>
            </select>
            <span class="text-danger"><?php echo form_error('stud_year'); ?></span>
        </div>
        <div class="col-sm-4">
            <label>Semester</label><span class="text-danger">*</span>
            <select class="form-control" name="semester" id="semester">
                <option value="">--Select Semester --</option>
                <?php foreach ($semester as $semester) { ?>
                    <option value="<?php echo $semester['id'] ?>" <?php echo set_select('semester', $semester['id'], False); ?>><?php echo $semester['description'] ?>
                    </option>
                <?php } ?>
            </select>
            <span class="text-danger"><?php echo form_error('semester'); ?></span>
        </div>
        <div class="col-sm-4">
            <label>Routine Mode</label><span class="text-danger">*</span>
            <select class="form-control" name="routine_mode" id="routine_mode">
                <option value="">--Select Routine Mode--</option>
                <option value="0" <?php echo set_select('routine_mode', '0', False); ?>>Offline</option>
                <option value="1" <?php echo set_select('routine_mode', '1', False); ?>>Offline/Online</option>
            </select>
            <span class="text-danger"><?php echo form_error('routine_mode'); ?></span>
        </div>
    </div>
    <center><button type="submit" class="btn btn-success"> <i class="fa fa-search"></i> Search</button></center>
    <?php echo form_close(); ?>
    <br>
    <?php if (count(@$routine_details) > 0) { ?>
        <!---===============================:: Form Start From Here ::========================================-->
        <table class="table table-bordered table-striped">
            <thead class="bg-primary">
                <tr align="center">
                    <td colspan="9">

                        <b>Polytechnic Name:
                            <?php echo get_College_name($this->session->userdata('stake_details_id_fk')); ?>|| Discipline Name :
                            <?php echo get_discipline_name(@$forwardlist['discipline_type']); ?>|| Academic Year :
                            <?php echo get_academic_session_name(@$forwardlist['academic_year']); ?> ||Semester :
                            <?php echo get_semester_name(@$forwardlist['semester']); ?></b>
                    </td>
                </tr>
                <tr>
                    <th style="vertical-align: middle; text-align:center;">Days</th>
                    <?php foreach (@$period_time as $pt) { ?>

                        <th width="250px;" style="font-size:10px;">
                            <center><?php echo @$pt['period_start_time']; ?> <br><i>to</i><br> <?php echo @$pt['period_end_time']; ?></center>
                        </th>
                    <?php } ?>
                </tr>
            </thead>

            <tbody>
                <?php
                $i = 1;
                $j = 1;
                $day = array(1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday', 4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday', 7 => 'Sunday');
                foreach ($routine_details as $key => $value) { ?>

                    <?php if ($j == 1) { ?>
                        <tr>
                            <td align="center" style="font-weight: bold;"><?php echo $day[$value['days_id_fk']] ?></td>
                        <?php } ?>

                        <td width="250px;" style="font-size:10px;font-weight:bold;">

                            <p align="center"> <?php echo $value['subject_description']; ?></p>
                            <p align="center">
                                <?php
                                $subject = array_column($value['subject'], 'practical_sub');
                                echo implode(',', $subject);
                                ?>
                            </p>
                            <p align="center"> <?php echo $value['periodtype']; ?> </p>
                            <p align="center"> <?php echo $value['room_no']; ?></p>
                            <p align="center">
                                <?php
                                foreach ($value['teacher'] as $key => $teacher_name) {
                                    echo $teacher_name['first_name'] . ' ' . $teacher_name['midle_name'] . ' ' .  $teacher_name['last_name'];
                                }
                                ?>
                            </p>
                            <!-- <button class="btn btn-success btn-xs" disabled style="margin-top:50px;"><?php echo $value['routine_online_status'] == '1' ? "Offline & Online" : "Offline"; ?></button> -->
                        </td>



                        <?php

                        $j++;
                        if ($j == count($period_time) + 1) {
                            echo '</tr>';
                            $j = 1;
                        }
                        ?>
                    <?php ++$i;;
                } ?>



            </tbody>
        </table>

        </table>
        <?php echo form_open('admin/routine_management_c/college_routine/College_download_routine/downloadRoutineaspdf'); ?>
        <input type="hidden" name="discipline_type" value="<?php echo $forwardlist['discipline_type']; ?>">
        <input type="hidden" name="stud_year" value="<?php echo $forwardlist['stud_year']; ?>">
        <input type="hidden" name="semester" value="<?php echo $forwardlist['semester']; ?>">
        <input type="hidden" name="routine_mode" value="<?php echo $forwardlist['routine_mode']; ?>">
        <input type="hidden" name="academic_year" value="<?php echo $forwardlist['academic_year']; ?>">
        <center><button class="btn btn-info" type="submit"><i class="fa fa-download"></i> <b>Download Routine</b></button></center>
        <?php echo form_close(); ?>
        <!---===============================:: Form End Here ::========================================-->
    <?php } else { ?>
		
    <?php } ?>
</div>
</div>
<?php $this->load->view($this->config->item('theme_uri') . 'layout/footer_view'); ?>
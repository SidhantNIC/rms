<?php $this->load->view($this->config->item('theme_uri') . 'layout/header_view'); ?>
<?php $this->load->view($this->config->item('theme_uri') . 'layout/left_menu_view'); ?>
<script src="<?php echo base_url('admin/assets/js/bootstrap-datepicker.min.js'); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('admin/assets/css/bootstrap-datepicker3.min.css');  ?>">
<style type="text/css">
    .td {
        font-weight: 15px;
    }

    .p {
        font-weight: 15px;
    }

    td {
        font-size: 10px;
        font-weight: bold;


    }
</style>
<!-- Content Wrapper. Contains page content -->
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
    <?php echo form_open('admin/routine_management_c/employee_routine/Employee_routine_list/employeeWeeklysubmission'); ?>
    <div class="row" style="padding: 5px;">
        <div class="col-sm-4">
            <label>Academic Year</label><span class="text-danger">*</span>
            <select class="form-control" name="academic_year" id="academic_year">
                <option value="">--Select Academic Year --</option>
                <?php foreach ($all_academic_year as $ay) { ?>
                    <option value="<?php echo $ay['academic_year_id_pk'] ?>" <?php echo set_select('academic_year', $ay['academic_year_id_pk'], False); ?>>
                        <?php echo $ay['academic_year_description'] ?>
                    </option>
                <?php } ?>
            </select>
            <span class="text-danger"><?php echo form_error('academic_year'); ?></span>
        </div>
        <div class="col-sm-4">
            <label>Discipline</label><span class="text-danger">*</span>
            <select class="form-control" name="discipline_id" id="discipline_id">
                <option value="">--Select Discipline --</option>
                <?php foreach ($all_course as $ac) { ?>
                    <option value="<?php echo $ac['course_id_pk'] ?>" <?php echo set_select('discipline_id', $ac['course_id_pk'], False); ?>><?php echo $ac['course_name'] ?>
                    </option>
                <?php } ?>
            </select>
            <span class="text-danger"><?php echo form_error('discipline_id'); ?></span>
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
        <div class="col-sm-3">
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
		 <div class="col-sm-3">
            <label>Polytechnic Name</label><span class="text-danger">*</span>
            <select class="form-control" name="college_name" id="college_name">
                <option value="">--Select Semester --</option>
                <?php foreach ($college_name as $cn) { ?>
                    <option value="<?php echo $cn['college_id_pk'] ?>" <?php echo set_select('college_name', $cn['college_id_pk'], False); ?>><?php echo $cn['college_name'] ?>
                    </option>
                <?php } ?>
            </select>
            <span class="text-danger"><?php echo form_error('college_name'); ?></span>
        </div>
		<div class="col-sm-3">
				<label>Section</label><span class="text-danger">*</span>
				<select class="form-control" name="section_name" id="section_name">
					<option value="">--Please Select Section --</option>
					<?php foreach($section_data as $sd) { ?>
					<option value="<?php echo $sd['section_id_pk'] ?>"
						<?php echo set_select('sd', $sd['section_id_pk'], False); ?>>
						<?php echo $sd['section_name']?></option>
					<?php } ?>
				</select>
				<span class="text-danger"><?php echo form_error('section_name'); ?></span>
            </div>
        <div class="col-sm-3">
            <button type="submit" class="btn btn-warning btn-block" style="margin-top:23px;"><b><i class="fa fa-search"></i> Search</b></button></center>
        </div>
    </div>
    <?php echo form_close(); ?>
	
	
    <!---===============================:: Form Start From Here ::========================================-->

    <?php if (@$countresult > 0) { ?>
        <table class="table table-bordered table-striped">
            <thead class="bg-primary">
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
                <tr>
                    <td>
                        <p align="center">Monday</p>
                    </td>

                    <?php
					
                    $period_no = array_column($monday, 'period_no');
                    for ($i = 1; $i <= count($period_time); $i++) {

                        if (in_array($i, $period_no)) {

                            $mondays = $monday[array_search($i, $period_no)]; ?>

                            <td>
							
                                <p align="center"><?php echo $mondays['routine_unique_id']; ?></p>
								<p align="center">
									<?php 
										//echo $mondays['section_id_fk']; 
										if($mondays['section_id_fk']=='1'){
											echo"Section A";
										}elseif($mondays['section_id_fk']=='2'){
											echo"Section B";
										}else{
											echo"No Section";
										}
									?>
								</p>
                                <p align="center"><?php echo $mondays['room_no']; ?></p>
                                <p align="center"><?php echo $mondays['periodtype']; ?></p>
                                <p align="center"><?php echo @get_theory_subeject_name($mondays['subject_id_fk']); ?></p>
                                
								<p align="center">
                                    <?php
									$tmp = array();
                                    foreach ($mondays['teacher'] as $key => $teacher_name) {
										
										array_push($tmp,$teacher_name['employee_id']);
                                        echo $teacher_name['first_name'] . ' ' . $teacher_name['midle_name'] . ' ' .  $teacher_name['last_name'];
                                    }
									
                                    ?>
                                </p>
                                <p align="center">
                                    <?php
                                    foreach ($mondays['subject'] as $key => $subject_name) {
                                        echo @get_practical_subeject_name($subject_name['subject_id']);
                                    }
                                    ?>
                                </p>
                                <center>
									<?php if(in_array($this->session->userdata('stake_details_id_fk'),$tmp)) { ?>
                                    <a href="javascript:void(0)" class="class_execution_data" rel="<?php echo md5($mondays['routine_manage_id_pk']); ?>">
                                        <button class="btn btn-success btn-xs"><b>Class Execution</b></button></a>
									<?php }else{ ?>
								
									<?php } ?>

                                </center>
								
								
                            </td>

                    <?php } else {
                            echo '
                           <td>
                              <span class="text-danger" align="center"><b>No Routine</b></span>
                           </td>
                        ';
                        }
                    } ?>
                </tr>

                <tr>
                    <td>
                        <p align="center">Tuesday</p>
                    </td>

                    <?php
                    $period_no = array_column($tuesday, 'period_no');
                    for ($i = 1; $i <= count($period_time); $i++) {

                        if (in_array($i, $period_no)) {

                            $tuesdays = $tuesday[array_search($i, $period_no)]; ?>

                            <td>
                                <p align="center"><?php echo $tuesdays['routine_unique_id']; ?></p>
								<p align="center">
									<?php 
										//echo $tuesdays['section_id_fk']; 
										if($tuesdays['section_id_fk']=='1'){
											echo"Section A";
										}elseif($tuesdays['section_id_fk']=='2'){
											echo"Section B";
										}else{
											echo"No Section";
										}
									?>
								</p>
                                <p align="center"><?php echo $tuesdays['room_no']; ?></p>
                                <p align="center"><?php echo $tuesdays['periodtype']; ?></p>
                                <p align="center"><?php echo @get_theory_subeject_name($tuesdays['subject_id_fk']); ?></p>
                                <p align="center">
                                    <?php
									$tmp = array();
                                    foreach ($tuesdays['teacher'] as $key => $teacher_name) {
										array_push($tmp,$teacher_name['employee_id']);
                                        echo $teacher_name['first_name'] . ' ' . $teacher_name['midle_name'] . ' ' .  $teacher_name['last_name'];
                                    }
									
                                    ?>
                                </p>
                                <p align="center">
                                    <?php
                                    foreach ($tuesdays['subject'] as $key => $subject_name) {
										
                                        echo @get_practical_subeject_name($subject_name['subject_id']);
                                    }
                                    ?>
                                </p>
								<center>
								<?php if(in_array($this->session->userdata('stake_details_id_fk'),$tmp)) { ?>
                                    <a href="javascript:void(0)" class="class_execution_data" rel="<?php echo md5($tuesdays['routine_manage_id_pk']); ?>">
                                        <button class="btn btn-success btn-xs"><b>Class Execution</b></button></a>
								<?php }else{ ?>
								
								<?php } ?>
                                </center>
                            </td>

                    <?php } else {
                            echo '
                           <td>
                               <span class="text-danger" align="center"><b>No Routine</b></span>
                           </td>
                        ';
                        }
                    } ?>
                </tr>

                <tr>
                    <td>
                        <p align="center">Wednesday</p>
                    </td>

                    <?php
                    $period_no = array_column($wednesday, 'period_no');
                    for ($i = 1; $i <= count($period_time); $i++) {

                        if (in_array($i, $period_no)) {

                            $wednesdays = $wednesday[array_search($i, $period_no)]; ?>

                            <td>
                                <p align="center"><?php echo $wednesdays['routine_unique_id']; ?></p>
								
								<p align="center">
									<?php 
										//echo $tuesdays['section_id_fk']; 
										if($wednesdays['section_id_fk']=='1'){
											echo"Section A";
										}elseif($wednesdays['section_id_fk']=='2'){
											echo"Section B";
										}else{
											echo"No Section";
										}
									?>
								</p>
								
                                <p align="center"><?php echo $wednesdays['room_no']; ?></p>
                                <p align="center"><?php echo $wednesdays['periodtype']; ?></p>
                                <p align="center"><?php echo @get_theory_subeject_name($wednesdays['subject_id_fk']); ?></p>
                                <p align="center">
                                    <?php
									$tmp = array();
                                    foreach ($wednesdays['teacher'] as $key => $teacher_name) {
										array_push($tmp,$teacher_name['employee_id']);
                                        echo $teacher_name['first_name'] . ' ' . $teacher_name['midle_name'] . ' ' .  $teacher_name['last_name'];
                                    }
                                    ?>
                                </p>
                                <p align="center">
                                    <?php
                                    foreach ($wednesdays['subject'] as $key => $subject_name) {
                                        echo @get_practical_subeject_name($subject_name['subject_id']);
                                    }
                                    ?>
                                </p>
								<center>
								<?php if(in_array($this->session->userdata('stake_details_id_fk'),$tmp)) { ?>
                                    <a href="javascript:void(0)" class="class_execution_data" rel="<?php echo md5($wednesdays['routine_manage_id_pk']); ?>">
                                        <button class="btn btn-success btn-xs"><b>Class Execution</b></button></a>
								<?php } else { ?>
								
								<?php } ?>
                                </center>
                            </td>

                    <?php } else {
                            echo '
                           <td>
                               <span class="text-danger" align="center"><b>No Routine</b></span>
                           </td>
                        ';
                        }
                    } ?>
                </tr>

                <tr>
                    <td>
                        <p align="center">Thrusday</p>
                    </td>

                    <?php
                    $period_no = array_column($thrusday, 'period_no');
                    for ($i = 1; $i <= count($period_time); $i++) {

                        if (in_array($i, $period_no)) {

                            $thrusdays = $thrusday[array_search($i, $period_no)]; ?>

                            <td>
                                <p align="center"><?php echo $thrusdays['routine_unique_id']; ?></p>
								<p align="center">
									<?php 
										//echo $tuesdays['section_id_fk']; 
										if($thrusdays['section_id_fk']=='1'){
											echo"Section A";
										}elseif($thrusdays['section_id_fk']=='2'){
											echo"Section B";
										}else{
											echo"No Section";
										}
									?>
								</p>
                                <p align="center"><?php echo $thrusdays['room_no']; ?></p>
                                <p align="center"><?php echo $thrusdays['periodtype']; ?></p>
                                <p align="center"><?php echo @get_theory_subeject_name($thrusdays['subject_id_fk']); ?></p>
                                <p align="center">
                                    <?php
									$tmp = array();
                                    foreach ($thrusdays['teacher'] as $key => $teacher_name) {
										array_push($tmp,$teacher_name['employee_id']);
                                        echo $teacher_name['first_name'] . ' ' . $teacher_name['midle_name'] . ' ' .  $teacher_name['last_name'];
                                    }
                                    ?>
                                </p>
                                <p align="center">
                                    <?php
                                    foreach ($thrusdays['subject'] as $key => $subject_name) {
                                        echo @get_practical_subeject_name($subject_name['subject_id']);
                                    }
                                    ?>
                                </p>
								<center>
								<?php if(in_array($this->session->userdata('stake_details_id_fk'),$tmp)) { ?>
                                    <a href="javascript:void(0)" class="class_execution_data" rel="<?php echo md5($thrusdays['routine_manage_id_pk']); ?>">
                                        <button class="btn btn-success btn-xs"><b>Class Execution</b></button></a>
							    <?php } else { ?>
								
								<?php } ?>
                                </center>
                            </td>

                    <?php } else {
                            echo '
                           <td>
                               <span class="text-danger" align="center"><b>No Routine</b></span>
                           </td>
                        ';
                        }
                    } ?>
                </tr>


                <tr>
                    <td>
                        <p align="center">Fridays</p>
                    </td>

                    <?php
                    $period_no = array_column($friday, 'period_no');
                    for ($i = 1; $i <= count($period_time); $i++) {

                        if (in_array($i, $period_no)) {

                            $fridays = $friday[array_search($i, $period_no)]; ?>

                            <td>
                                <p align="center"><?php echo $fridays['routine_unique_id']; ?></p>
								<p align="center">
									<?php 
										//echo $tuesdays['section_id_fk']; 
										if($fridays['section_id_fk']=='1'){
											echo"Section A";
										}elseif($fridays['section_id_fk']=='2'){
											echo"Section B";
										}else{
											echo"No Section";
										}
									?>
								</p>
                                <p align="center"><?php echo $fridays['room_no']; ?></p>
                                <p align="center"><?php echo $fridays['periodtype']; ?></p>
                                <p align="center"><?php echo @get_theory_subeject_name($fridays['subject_id_fk']); ?></p>
                                <p align="center">
                                    <?php
									$tmp = array();
                                    foreach ($fridays['teacher'] as $key => $teacher_name) {
										array_push($tmp,$teacher_name['employee_id']);
                                        echo $teacher_name['first_name'] . ' ' . $teacher_name['midle_name'] . ' ' .  $teacher_name['last_name'];
                                    }
                                    ?>
                                </p>
                                <p align="center">
                                    <?php
                                    foreach ($fridays['subject'] as $key => $subject_name) {
                                        echo @get_practical_subeject_name($subject_name['subject_id']);
                                    }
                                    ?>
                                </p>
								<center>
								<?php if(in_array($this->session->userdata('stake_details_id_fk'),$tmp)) { ?>
                                    <a href="javascript:void(0)" class="class_execution_data" rel="<?php echo md5($fridays['routine_manage_id_pk']); ?>">
                                        <button class="btn btn-success btn-xs"><b>Class Execution</b></button></a>
								<?php } else { ?>
								
								<?php } ?>
                                </center>
                            </td>

                    <?php } else {
                            echo '
                           <td>
                               <span class="text-danger" align="center"><b>No Routine</b></span>
                           </td>
                        ';
                        }
                    } ?>
                </tr>

                <tr>
                    <td>
                        <p align="center">Saturday</p>
                    </td>

                    <?php
                    $period_no = array_column($saturday, 'period_no');
                    for ($i = 1; $i <= count($period_time); $i++) {

                        if (in_array($i, $period_no)) {

                            $saturdays = $saturday[array_search($i, $period_no)]; ?>

                            <td>
                                <p align="center"><?php echo $saturdays['routine_unique_id']; ?></p>
								<p align="center">
									<?php 
										//echo $tuesdays['section_id_fk']; 
										if($saturday['section_id_fk']=='1'){
											echo"Section A";
										}elseif($saturday['section_id_fk']=='2'){
											echo"Section B";
										}else{
											echo"No Section";
										}
									?>
								</p>
								<?php if($saturdays['period_type_fk']!=4){ ?>
                                <p align="center"><?php echo $saturdays['room_no']; ?></p>
								<?php } ?>
                                <p align="center"><?php echo $saturdays['periodtype']; ?></p>
                                
                                
								<?php if($saturdays['period_type_fk']!=4){ ?>
								<p align="center"><?php echo @get_theory_subeject_name($saturdays['subject_id_fk']); ?></p>
								<p align="center">
                                    <?php
									$tmp = array();
                                    foreach ($saturdays['teacher'] as $key => $teacher_name) {
										array_push($tmp,$teacher_name['employee_id']);
                                        echo $teacher_name['first_name'] . ' ' . $teacher_name['midle_name'] . ' ' .  $teacher_name['last_name'];
                                    }
                                    ?>
                                </p>
                                <p align="center">
                                    <?php
                                    foreach ($saturdays['subject'] as $key => $subject_name) {
                                        echo @get_practical_subeject_name($subject_name['subject_id']);
                                    }
                                    ?>
                                </p>
								<center>
								<?php if(in_array($this->session->userdata('stake_details_id_fk'),$tmp)) { ?>
                                    <a href="javascript:void(0)" class="class_execution_data" rel="<?php echo md5($saturdays['routine_manage_id_pk']); ?>">
                                        <button class="btn btn-success btn-xs"><b>Class Execution</b></button></a>
								<?php } else { ?>
								
								<?php } ?>
                                </center>
								<?php } ?>
								
                            </td>

                    <?php } else {
                            echo '
                           <td>
                               <span class="text-danger" align="center"><b>No Routine</b></span>
                           </td>
                        ';
                        }
                    } ?>
                </tr>
            </tbody>
        </table>
    <?php } else { ?>
    <?php } ?>


    <!---===============================:: Form End Here ::========================================-->
</div>
<!---------------------------- Modal for Revart Back Result to SSC ----------------------->
<div id="myResultbacknew" class="modal fade bg-success" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title modal_title"><b>Class Execution</b></h4>
            </div>
            <div class="modal-body modal_revart_back_body">
            </div>
            <div class="modal-footer">
                <span class="show_revart_back_btn_dtls"></span>
                <button type="button" class="btn btn-danger frwd_btn_no close_btn" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!---------------------------- Modal for Revart Back Result to SSC---------------------->


<?php $this->load->view($this->config->item('theme_uri') . 'layout/footer_view'); ?>
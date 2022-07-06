<?php $this->load->view($this->config->item('theme_uri').'layout/header_view'); ?>
<?php $this->load->view($this->config->item('theme_uri').'layout/left_menu_view'); ?>
<script src="<?php echo base_url('admin/assets/js/bootstrap-datepicker.min.js'); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('admin/assets/css/bootstrap-datepicker3.min.css');  ?>">
<style type="text/css">
    .td{
    font-weight:15px;
    } 
	.p{
		font-weight:15px;
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
    <?php if($msg = $this->session->userdata('success')){ ?>
    <div class="alert alert-dismissible alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><?php echo $msg; ?></strong>
        <?php  unset($_SESSION['success']); ?>
    </div>
    <?php } ?>
    <?php if($msg = $this->session->userdata('error')){ ?>
    <div class="alert alert-dismissible alert-danger">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><?php echo $msg; ?></strong>
        <?php  unset($_SESSION['error']); ?>
    </div>
    <?php } ?>
    <!-- Main content -->
    <?php echo form_open('admin/routine_management_c/employee_routine/Employee_routine_list/classExecutionroutinelist'); ?>
    <div class="row" style="padding: 5px;">
        <div class="col-sm-4">
            <label>Academic Year</label><span class="text-danger">*</span>
            <select class="form-control" name="academic_year" id="academic_year">
                <option value="">--Select Academic Year --</option>
                <?php foreach($all_academic_year as $ay) { ?>
                <option value="<?php echo $ay['academic_year_id_pk'] ?>" <?php echo set_select('academic_year', $ay['academic_year_id_pk'], False); ?>>
                    <?php echo $ay['academic_year_description']?>
                </option>
                <?php } ?>
            </select>
            <span class="text-danger"><?php echo form_error('academic_year'); ?></span>
        </div>
		<div class="col-sm-4">
            <label>Discipline</label><span class="text-danger">*</span>
            <select class="form-control" name="discipline_id" id="discipline_id">
                <option value="">--Select Discipline --</option>
                <?php foreach($all_course as $ac) { ?>
                <option value="<?php echo $ac['course_id_pk'] ?>"
                    <?php echo set_select('discipline_id', $ac['course_id_pk'], False); ?>><?php echo $ac['course_name']?>
                </option>
                <?php } ?>
            </select>
            <span class="text-danger"><?php echo form_error('discipline_id'); ?></span>
        </div>
        <div class="col-sm-4">
            <label>Year</label><span class="text-danger">*</span>
            <select class="form-control" name="stud_year" id="stud_year">
                <option value="">--Select Year --</option>
                <?php foreach($year as $year) { ?>
                <option value="<?php echo $year['id'] ?>" <?php echo set_select('stud_year', $year['id'], False); ?>>
                    <?php echo $year['description']?>
                </option>
                <?php } ?>
            </select>
            <span class="text-danger"><?php echo form_error('stud_year'); ?></span>
        </div>
        <div class="col-sm-4">
            <label>Semester</label><span class="text-danger">*</span>
            <select class="form-control" name="semester" id="semester">
                <option value="">--Select Semester --</option>
                <?php foreach($semester as $semester) { ?>
                <option value="<?php echo $semester['id'] ?>"
                    <?php echo set_select('semester', $semester['id'], False); ?>><?php echo $semester['description']?>
                </option>
                <?php } ?>
            </select>
            <span class="text-danger"><?php echo form_error('semester'); ?></span>
        </div>
		
		
		 <div class="col-sm-4">
            <label>Polytechnic Name</label><span class="text-danger">*</span>
            <select class="form-control" name="polytechnic_name" id="polytechnic_name">
                <option value="">--Select Semester --</option>
                <?php foreach($college_name as $cn) { ?>
                <option value="<?php echo $cn['college_id_pk'] ?>"
                    <?php echo set_select('polytechnic_name', $cn['college_id_pk'], False); ?>><?php echo $cn['college_name']; ?>
                </option>
                <?php } ?>
            </select>
            <span class="text-danger"><?php echo form_error('polytechnic_name'); ?></span>
        </div>
		
		<div class="col-sm-4">
			<button type="submit" class="btn btn-warning btn-block" style="margin-top:23px;"><b><i class="fa fa-search"></i> Search</b></button>
		</div>
    </div>
    
    <?php echo form_close(); ?>
    <br>
    <div class="table-responsive" style="padding: 10px;">
        <?php if($this->input->post()){ ?>
        <?php  if(@sizeof($result)>0){ ?>
        <table id="example1" class="table table-bordered table-striped custom_table" cellspacing="0" cellpadding="1">
            <tr align="center">
            </tr>
            <tr>
                <th>Day</th>
                <?php foreach($period_time as $pt){ ?>
                <th>
                    <?php echo @$pt['period_start_time']; ?> - <?php echo @$pt['period_end_time']; ?>
                </th>
                <?php } ?>
            </tr>
            <!--.............................Monday..............................-->
            <tr>
                <td><b>Monday</b></td>
                <?php foreach($mondays as $monday) { ?>
                <td>
                    <p style="font-weight:15px"><?php  $faculty_details = getEmployeeids(@$monday['routine_manage_id_pk']); ?></p>
					
                    <?php if(in_array($this->session->userdata('stake_details_id_fk'), $faculty_details)) { ?>
                    <p> <?php if(@$monday['period_type_fk'] == '1'){?>
                        <?php echo get_theory_subeject_name(@$monday['subject_id_fk']); ?>
                        <?php } ?>
                    </p>
                    <p>
                        <?php if(@$monday['period_type_fk'] == '2'){?>
                        <?php $faculty_details = get_subject_name_usingid(@$monday['routine_manage_id_pk']); 
                            foreach ($faculty_details as  $value) {
                            echo get_practical_subeject_name($value['subject_id']).',&nbsp;';
                            }
                            ?>
                        <?php } ?>
                    </p>
                    <p><?php $faculty_details = get_employee_name_usingid(@$monday['routine_manage_id_pk']); 
                        foreach ($faculty_details as  $value) {
                           echo $value['first_name'].$value['midle_name'].$value['last_name'].',&nbsp;';
                        }
                        ?>
                    </p>
                    <p> <?php echo @$monday['room_no']; ?> </p>
                    <p> <b><?php echo @get_period_type_name(@$monday['period_type_fk']); ?></b></p>
					
					<?php if($monday['status_code']=='4'){ ?>
                    <center><button class="btn btn-success"
                        onclick="showExecution(<?php echo @$monday['routine_manage_id_pk']; ?>,<?php echo @$monday['period_no']; ?>);">Class
                        Execution</button>
                    </center>
					<?php }else{ ?>
					<button class="btn btn-warning btn-sm" disabled>Routine Not Yet Approved</button>
					<?php } ?>
                </td>
                <?php }else{ ?>
                <center><span class="text-danger">No Routine Assigned</span></center>
                <?php } ?>
                <?php } ?>
            </tr>
            <!--.............................Tuesday..............................-->
            <tr>
                <td><b>Tuesday</b></td>
                <?php foreach($tuesdays as $tuesday) { ?>
                <td>
                    <p><?php  $faculty_details = getEmployeeids(@$tuesday['routine_manage_id_pk']); ?></p>
                    <?php if(in_array($this->session->userdata('stake_details_id_fk'), $faculty_details)) { ?>
                    <p> <?php if(@$tuesday['period_type_fk'] == '1'){?>
                        <?php echo get_theory_subeject_name(@$tuesday['subject_id_fk']); ?>
                        <?php } ?>
                    </p>
                    <p>
                        <?php if(@$tuesday['period_type_fk'] == '2'){?>
                        <?php $faculty_details = get_subject_name_usingid(@$tuesday['routine_manage_id_pk']); 
                            foreach ($faculty_details as  $value) {
                            echo get_practical_subeject_name($value['subject_id']).',&nbsp;';
                            }
                            ?>
                        <?php } ?>
                    </p>
                    <p><?php $faculty_details = get_employee_name_usingid(@$tuesday['routine_manage_id_pk']); 
                        foreach ($faculty_details as  $value) {
                           echo $value['first_name'].$value['midle_name'].$value['last_name'].',&nbsp;';
                        }
                        ?>
                    </p>
                    <p> <?php echo @$tuesday['room_no']; ?> </p>
                    <p> <b><?php echo @get_period_type_name(@$tuesday['period_type_fk']); ?></b></p>
                    <?php if($tuesday['status_code']=='4'){ ?>
                    <center><button class="btn btn-success"
                        onclick="showExecution(<?php echo @$tuesday['routine_manage_id_pk']; ?>,<?php echo @$tuesday['period_no']; ?>);">Class
                        Execution</button>
                    </center>
					<?php }else{ ?>
					<button class="btn btn-warning btn-sm" disabled>Routine Not Yet Approved</button>
					<?php } ?>
                </td>
                <?php }else{ ?>
                <center><span class="text-danger">No Routine Assigned</span></center>
                <?php } ?>
                <?php } ?>
            </tr>
                 <!--.............................Wednesday..............................-->
            <tr>
                <td><b>Wednesday</b></td>
                <?php foreach($wednesdays as $wednesday) { ?>
                <td>
                    <p><?php  $faculty_details = getEmployeeids(@$wednesday['routine_manage_id_pk']); ?></p>
                    <?php if(in_array($this->session->userdata('stake_details_id_fk'), $faculty_details)) { ?>
                    <p> <?php if(@$wednesday['period_type_fk'] == '1'){?>
                        <?php echo get_theory_subeject_name(@$wednesday['subject_id_fk']); ?>
                        <?php } ?>
                    </p>
                    <p>
                        <?php if(@$wednesday['period_type_fk'] == '2'){?>
                        <?php $faculty_details = get_subject_name_usingid(@$wednesday['routine_manage_id_pk']); 
                            foreach ($faculty_details as  $value) {
                            echo get_practical_subeject_name($value['subject_id']).',&nbsp;';
                            }
                            ?>
                        <?php } ?>
                    </p>
                    <p><?php $faculty_details = get_employee_name_usingid(@$wednesday['routine_manage_id_pk']); 
                        foreach ($faculty_details as  $value) {
                           echo $value['first_name'].$value['midle_name'].$value['last_name'].',&nbsp;';
                        }
                        ?>
                    </p>
                    <p> <?php echo @$wednesday['room_no']; ?> </p>
                    <p> <b><?php echo @get_period_type_name(@$wednesday['period_type_fk']); ?></b></p>
                   <?php if($wednesday['status_code']=='4'){ ?>
                    <center><button class="btn btn-success"
                        onclick="showExecution(<?php echo @$wednesday['routine_manage_id_pk']; ?>,<?php echo @$wednesday['period_no']; ?>);">Class
                        Execution</button>
                    </center>
					<?php }else{ ?>
					<button class="btn btn-warning btn-sm" disabled>Routine Not Yet Approved</button>
					<?php } ?>
                </td>
                <?php }else{ ?>
                <center><span class="text-danger">No Routine Assigned</span></center>
                <?php } ?>
                <?php } ?>
            </tr>
            <!--.............................Thrusday..............................-->
            <tr>
                <td><b>Thrusday</b></td>
                <?php foreach($thrusdays as $thrusday) { ?>
                <td>
                    <p><?php  $faculty_details = getEmployeeids(@$thrusday['routine_manage_id_pk']); ?></p>
                    <?php if(in_array($this->session->userdata('stake_details_id_fk'), $faculty_details)) { ?>
                    <p> <?php if(@$thrusday['period_type_fk'] == '1'){?>
                        <?php echo get_theory_subeject_name(@$thrusday['subject_id_fk']); ?>
                        <?php } ?>
                    </p>
                    <p>
                        <?php if(@$thrusday['period_type_fk'] == '2'){?>
                        <?php $faculty_details = get_subject_name_usingid(@$thrusday['routine_manage_id_pk']); 
                            foreach ($faculty_details as  $value) {
                            echo get_practical_subeject_name($value['subject_id']).',&nbsp;';
                            }
                            ?>
                        <?php } ?>
                    </p>
                    <p><?php $faculty_details = get_employee_name_usingid(@$thrusday['routine_manage_id_pk']); 
                        foreach ($faculty_details as  $value) {
                           echo $value['first_name'].$value['midle_name'].$value['last_name'].',&nbsp;';
                        }
                        ?>
                    </p>
                    <p> <?php echo @$thrusday['room_no']; ?> </p>
                    <p> <b><?php echo @get_period_type_name(@$thrusday['period_type_fk']); ?></b></p>
                    <?php if($thrusday['status_code']=='4'){ ?>
                    <center><button class="btn btn-success"
                        onclick="showExecution(<?php echo @$thrusday['routine_manage_id_pk']; ?>,<?php echo @$thrusday['period_no']; ?>);">Class
                        Execution</button>
                    </center>
					<?php }else{ ?>
					<button class="btn btn-warning btn-sm" disabled>Routine Not Yet Approved</button>
					<?php } ?>
                </td>
                <?php }else{ ?>
                <center><span class="text-danger">No Routine Assigned</span></center>
                <?php } ?>
                <?php } ?>
            </tr>
             <!--.............................Friday..............................-->
            <tr>
                <td><b>Friday</b></td>
                <?php foreach($fridays as $friday) { ?>
                <td>
                    <p><?php  $faculty_details = getEmployeeids(@$friday['routine_manage_id_pk']); ?></p>
                    <?php if(in_array($this->session->userdata('stake_details_id_fk'), $faculty_details)) { ?>
                    <p> <?php if(@$friday['period_type_fk'] == '1'){?>
                        <?php echo get_theory_subeject_name(@$friday['subject_id_fk']); ?>
                        <?php } ?>
                    </p>
                    <p>
                        <?php if(@$friday['period_type_fk'] == '2'){?>
                        <?php $faculty_details = get_subject_name_usingid(@$friday['routine_manage_id_pk']); 
                            foreach ($faculty_details as  $value) {
                            echo get_practical_subeject_name($value['subject_id']).',&nbsp;';
                            }
                            ?>
                        <?php } ?>
                    </p>
                    <p><?php $faculty_details = get_employee_name_usingid(@$friday['routine_manage_id_pk']); 
                        foreach ($faculty_details as  $value) {
                           echo $value['first_name'].$value['midle_name'].$value['last_name'].',&nbsp;';
                        }
                        ?>
                    </p>
                    <p> <?php echo @$friday['room_no']; ?> </p>
                    <p> <b><?php echo @get_period_type_name(@$friday['period_type_fk']); ?></b></p>
                    <?php if($friday['status_code']=='4'){ ?>
                    <center><button class="btn btn-success"
                        onclick="showExecution(<?php echo @$friday['routine_manage_id_pk']; ?>,<?php echo @$friday['period_no']; ?>);">Class
                        Execution</button>
                    </center>
					<?php }else{ ?>
					<button class="btn btn-warning btn-sm" disabled>Routine Not Yet Approved</button>
					<?php } ?>
                </td>
                <?php }else{ ?>
                <center><span class="text-danger">No Routine Assigned</span></center>
                <?php } ?>
                <?php } ?>
                <!--.............................Friday..............................-->
            <tr>
                <td><b>Saturday</b></td>
                <?php foreach($saturdays as $saturday) { ?>
                <td>
                    <p><?php  $faculty_details = getEmployeeids(@$saturday['routine_manage_id_pk']); ?></p>
                    <?php if(in_array($this->session->userdata('stake_details_id_fk'), $faculty_details)) { ?>
                    <p> <?php if(@$saturday['period_type_fk'] == '1'){?>
                        <?php echo get_theory_subeject_name(@$saturday['subject_id_fk']); ?>
                        <?php } ?>
                    </p>
                    <p>
                        <?php if(@$saturday['period_type_fk'] == '2'){?>
                        <?php $faculty_details = get_subject_name_usingid(@$saturday['routine_manage_id_pk']); 
                            foreach ($faculty_details as  $value) {
                            echo get_practical_subeject_name($value['subject_id']).',&nbsp;';
                            }
                            ?>
                        <?php } ?>
                    </p>
                    <p><?php $faculty_details = get_employee_name_usingid(@$saturday['routine_manage_id_pk']); 
                        foreach ($faculty_details as  $value) {
                           echo $value['first_name'].$value['midle_name'].$value['last_name'].',&nbsp;';
                        }
                        ?>
                    </p>
                    <p> <?php echo @$saturday['room_no']; ?> </p>
                    <p> <b><?php echo @get_period_type_name(@$saturday['period_type_fk']); ?></b></p>
                    <?php if($saturday['status_code']=='4'){ ?>
                    <center><button class="btn btn-success"
                        onclick="showExecution(<?php echo @$saturday['routine_manage_id_pk']; ?>,<?php echo @$saturday['period_no']; ?>);">Class
                        Execution</button>
                    </center>
					<?php }else{ ?>
					<button class="btn btn-warning btn-sm" disabled>Routine Not Yet Approved</button>
					<?php } ?>
                </td>
                <?php }else{ ?>
                <center><span class="text-danger">No Routine Assigned</span></center>
                <?php } ?>
                <?php } ?>
            </tr>
        </table>
        <?php }else{ ?>
        <table id="example1" class="table table-bordered table-striped custom_table">
            <tr align="center">
                <td colspan="10"><span class="text-danger">!!! No Record Found !!!</span></td>
            </tr>
        </table>
        <?php } } ?>
    </div>
</div>
<!--.............................Modal.......................-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><b>Class Execution</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span class="text-danger" align="justify">Note:If the classes has been taken on otherthan scheduled date
                and time that should be mention in reason</span>
                <center><button class="btn btn-success" id="msgprint" style="display: none;"></button></center>
				<center><button class="btn btn-danger" id="msgprintdanger" style="display: none;"></button></center>
                <input type="hidden" name="routine_id" id="revertId">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Date</label>
                        <!-- <input type="text" name="date" id="datepicker6" class="form-control"autocomplete="off" readonly placeholder="Please Select the date"> -->
                        <div class="input-group date" data-provide="datepicker" raedonly>
                            <input type="text" class="form-control" id="datepicker6"
                                placeholder="Please Select Execution Date" readonly="">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Class Execution</label>
                        <select class="form-control" id="class_execution_yes_no" onchange="showbox();">
                            <option value="">-- Select Execution --</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="rouitne_id_exe" id="rouitne_id_exe">
                <input type="hidden" name="periodnoexe" id="periodnoexe">
                <div class="col-sm-12 textar" style="display: none;">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Topic Coverd</label> <span class="text-danger">(Maximum 255 Character Allowed (*))</span>
                        <textarea class="form-control" id="class_execution_yes" name="revert_remarks" rows="3"
                            placeholder="Please Enter Revert Reason..." required maxlength="255"></textarea>
                    </div>
                </div>
                <div class="col-sm-12 textar">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Remarks (Maximum 255 Character Allowed)</label>
                        <textarea class="form-control" id="remarks" name="remarks" rows="3"
                            placeholder="Please Enter Revert Reason..." required maxlength="255"></textarea>
                    </div>
                </div>
				    <div class="col-sm-12 textar">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Total No Of Students Registered In The Class</label>
                        <input type="text" class="form-control registerd_class" name="registerd_class" id="registerd_class" placeholder="Total No Of Students Registered In The Class">
                    </div>
                </div>
				    <div class="col-sm-12 textar">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Number Of Students Attended the class</label>
                        <input type="text" class="form-control" name="attended_class" id="attended_class" placeholder="Enter Number Of Students Attended the class">
                    </div>
                </div>
                <div class="col-sm-12 class_execution_reason" style="display: none;">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Class Execution Reason</label> <span
                            class="text-danger">*</span>
                        <select class="form-control" id="class_execution_no">
                            <option value="">--Select Reason--</option>
                            <?php foreach($all_reason as $all_reason){ ?>
                            <option value="<?php echo $all_reason['reason_master_id_pk'];  ?>">
                                <?php echo $all_reason['reason_master_description'];  ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <br>
            <div class="modal-footer" style="margin-top: 15px;">
                <button type="button" class="btn btn-secondary closebtn" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="submitRevert();">Submit</button>
            </div>
        </div>
    </div>
</div>
<!--............................................-->
<script type="text/javascript">
    function showExecution(x,y) {
        var rouitneid = x;
        var periodno =  y;
        $.ajax({
            url: "<?php echo base_url('admin/routine_management_c/employee_routine/Employee_routine_list/executionListmodal') ?>",
            data: {
                rouitneid: rouitneid,
                periodno:periodno
            },
            method: "GET",
            dataType: 'JSON',
            success: function(response) {
                $("#rouitne_id_exe").val(response.rouitneid);
                $("#periodnoexe").val(response.periodno);
                $('#exampleModal').modal('show');
            }
        });
    }
    
    function showbox() {
        var class_execution_yes_no = $("#class_execution_yes_no").val();
        if (class_execution_yes_no == '1') {
            $(".textar").show();
            $(".class_execution_reason").hide();
			//$(".registerd_class").val('required');
        }
        if (class_execution_yes_no == '0') {
            $(".class_execution_reason").show();
            $(".textar").hide();
			
        }
    }
    
    function submitRevert() {
      
        var date = $("#datepicker6").val();
        var class_execution_yes_no = $("#class_execution_yes_no").val();
        var class_execution_yes = $("#class_execution_yes").val();
        var class_execution_no = $("#class_execution_no").val();
        var remarks = $("#remarks").val();
        var rouitne_id_exe = $("#rouitne_id_exe").val();
        var periodnoexe = $("#periodnoexe").val();
		var registerd_class = $("#registerd_class").val();
		var attended_class = $("#attended_class").val();
    
        if (date == '') {
            alert("Please Select a date");
            $("#date").focus();
            return false;
        }
        if (class_execution_yes_no == '') {
            alert("Please Select Anyone From Class Execution");
            $("#class_execution").focus();
            return false;
        }
		
		if(class_execution_yes_no =='1'){
			if(registerd_class==''){
				 alert("Please Enter Total No Of Register Student");
				 return false;
			}
			if(attended_class==''){
				 alert("Please Enter Total No Of Attended Student");
				 return false;
			}
		}
		
		
		
		
        $.ajax({
            url: "<?php echo base_url('admin/routine_management_c/employee_routine/Employee_routine_list/executionClass') ?>",
            data: {
                date: date,
                class_execution_yes_no: class_execution_yes_no,
                class_execution_yes: class_execution_yes,
                class_execution_no: class_execution_no,
                remarks: remarks,
                rouitne_id_exe: rouitne_id_exe,
                periodnoexe: periodnoexe,
				registerd_class:registerd_class,
				attended_class:attended_class
            },
            method: "GET",
            dataType: 'JSON',
            success: function(response) {
                // console.log(response);
                // return false;
                $("#msgprint").show();
                $("#msgprint").html(response.msg);
    
            }
        });
    }
    
    $(".closebtn").click(function() {
        window.location.href = "routine_management_c/employee_routine/Employee_routine_list";
    })
</script>
<?php $this->load->view($this->config->item('theme_uri').'layout/footer_view'); ?>
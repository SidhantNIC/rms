<?php $this->load->view($this->config->item('theme_uri').'layout/header_view'); ?>
<?php $this->load->view($this->config->item('theme_uri').'layout/left_menu_view'); ?>
<!-- Content Wrapper. Contains page content -->
<style type="text/css">
   .tablebody{
   padding:0 30px;
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
   <?php echo form_open('admin/routine_management_c/college_routine/College_routine_list/forwardList'); ?>
   <div class="row" style="padding: 5px;">
      <div class="col-sm-3">
         <label>Academic Session</label><span class="text-danger">*</span>
         <select class="form-control" name="academic_year" id="academic_year">
            <option value="">--Select Academic Session--</option>
            <?php foreach($all_academic_year as $all_academic_year) { ?>
            <option value="<?php echo $all_academic_year['academic_year_id_pk']?>"
               <?php echo set_select('academic_year', $all_academic_year['academic_year_id_pk'], False); ?>>
               <?php echo $all_academic_year['academic_year_description']?>
            </option>
            <?php } ?>
         </select>
         <span class="text-danger"><?php echo form_error('academic_year'); ?></span>
      </div>
      <div class="col-sm-3">
         <label>Discipline</label><span class="text-danger">*</span>
         <select class="form-control" name="discipline_type" id="discipline_type">
            <option value="">--Select Discipline --</option>
            <?php foreach($discipline as $discipline) { ?>
            <option value="<?php echo $discipline['course_id_pk'] ?>"
               <?php echo set_select('discipline_type', $discipline['course_id_pk'], False); ?>>
               <?php echo $discipline['course_name']?>
            </option>
            <?php } ?>
         </select>
         <span class="text-danger"><?php echo form_error('discipline_type'); ?></span>
      </div>
      <div class="col-sm-3">
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
      <div class="col-sm-3">
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
   </div>
   <center><button type="submit" class="btn btn-success">Search</button></center>
   <?php echo form_close(); ?>
   <br>
   <?php if($this->input->post()) { ?>
   <div class="tablebody">
      <div class="table-responsive">


         <?php if(sizeof($result)>0){ ?>
         <table class="table table-bordered table-striped">
            <thead class="bg-primary">
               <tr align="center">
                  <th colspan="9">
                     <b>Academic Session :
                     <?php echo get_academic_session_name(@$forwardlist['academic_year']); ?>|| Year :
                     <?php echo get_year_master_name(@$forwardlist['stud_year']); ?>|| Discipline :
                     <?php echo get_discipline_name(@$forwardlist['discipline_type']); ?> ||Semester :
                     <?php echo get_semester_name(@$forwardlist['semester']); ?></b>
                  </th>
               </tr>
               <tr>
                  <th>Day</th>
                  <?php foreach($period_time as $pt){ ?>
                  <th>
                     <?php echo @$pt['period_start_time']; ?> - <?php echo @$pt['period_end_time']; ?>
                  </th>
                  <?php } ?>
               </tr>
            </thead>
            <tbody>
               <!--.............................Monday..............................-->
               <tr>
                  <td><b>Monday</b></td>
                  <?php foreach($mondays as $monday) { ?>
                  <td>
                     <p> <?php if(@$monday['period_type_fk'] == '1'){?>
                        <?php echo get_theory_subeject_name(@$monday['subject_id_fk']); ?>
                        <?php }else{ ?>
						 <?php echo @get_tutorial_subeject_name(@$monday['subject_id_fk']); ?>
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
                  </td>
                  <?php } ?>
               </tr>
               <!--.............................Tuesday..............................-->
               <tr>
                  <td><b>Tuesday</b></td>
                  <?php foreach($tuesdays as $tuesday) { ?>
                  <td>
                     <p> <?php if(@$tuesday['period_type_fk'] == '1'){?>
                        <?php echo get_theory_subeject_name(@$tuesday['subject_id_fk']); ?>
                         <?php }else{ ?>
						 <?php echo @get_tutorial_subeject_name(@$tuesday['subject_id_fk']); ?>
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
                     <p><?php echo @$tuesday['room_no']; ?> </p>
                     <p> <b><?php echo @get_period_type_name(@$tuesday['period_type_fk']); ?></b></p>
                  </td>
                  <?php } ?>
               </tr>
               <!--.............................Wednesday..............................-->
               <tr>
                  <td><b>Wednesday</b></td>
                  <?php foreach($wednesdays as $wednesday) { ?>
                  <td>
                     <p> <?php if(@$wednesday['period_type_fk'] == '1'){?>
                        <?php echo get_theory_subeject_name(@$wednesday['subject_id_fk']); ?>
                        <?php }else{ ?>
						 <?php echo @get_tutorial_subeject_name(@$wednesday['subject_id_fk']); ?>
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
                     <p><?php echo @$wednesday['room_no']; ?> </p>
                     <p> <b><?php echo @get_period_type_name(@$wednesday['period_type_fk']); ?></b></p>
                  </td>
                  <?php } ?>
               </tr>
               <!--.............................Thrusday..............................-->
               <tr>
                  <td><b>Thursday</b></td>
                  <?php foreach($thrusdays as $thrusday) { ?>
                  <td>
                     <p> <?php if(@$thrusday['period_type_fk'] == '1'){?>
                        <?php echo get_theory_subeject_name(@$thrusday['subject_id_fk']); ?>
                        <?php }else{ ?>
						 <?php echo @get_tutorial_subeject_name(@$thrusday['subject_id_fk']); ?>
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
                     <p><?php echo @$thrusday['room_no']; ?> </p>
                     <p> <b><?php echo @get_period_type_name(@$thrusday['period_type_fk']); ?></b></p>
                  </td>
                  <?php } ?>
               </tr>
               <!--.............................Friday..............................-->
               <tr>
                  <td><b>Friday</b></td>
                  <?php foreach($fridays as $friday) { ?>
                  <td>
                     <p> <?php if(@$friday['period_type_fk'] == '1'){?>
                        <?php echo get_theory_subeject_name(@$friday['subject_id_fk']); ?>
                        <?php }else{ ?>
						 <?php echo @get_tutorial_subeject_name(@$friday['subject_id_fk']); ?>
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
                     <p><?php echo @$friday['room_no']; ?> </p>
                     <p> <b><?php echo @get_period_type_name(@$friday['period_type_fk']); ?></b></p>
                  </td>
                  <?php } ?>
               </tr>
               <!--.............................Saturday..............................-->
               <tr>
                  <td><b>Saturday</b></td>
                  <?php foreach($saturdays as $saturday) { ?>
                  <td>
                     <p> <?php if(@$saturday['period_type_fk'] == '1'){?>
                        <?php echo get_theory_subeject_name(@$saturday['subject_id_fk']); ?>
                        <?php }else{ ?>
						 <?php echo @get_tutorial_subeject_name(@$saturday['subject_id_fk']); ?>
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
                     <p><?php echo @$saturday['room_no']; ?> </p>
                     <p> <b><?php echo @get_period_type_name(@$saturday['period_type_fk']); ?></b></p>
                  </td>
                  <?php } ?>
               </tr>
            </tbody>
         </table>


      <?php }else{ ?>
          <table id="example1" class="table table-bordered table-striped custom_table">
         <tr align="center">
            <td colspan="10"><span class="text-danger">!!! No Record Found !!!</span></td>
         </tr>
      </table>
      <?php } ?>

      <?php echo form_open('admin/routine_management_c/college_routine/College_routine_list/approveallfRoutine'); ?>
        <?php
    if($this->input->post()){ 
     $totalforwardlist = sizeof(@$result);
     for($i=0;$i<$totalforwardlist;$i++){
     ?>
        <input type="hidden" name="forwardid[]" value="<?php echo $result[$i]['routine_manage_id_pk']; ?>">
        <?php
    }
    }
    ?>
        <center>
            <button type="submit" class="btn btn-warning"
                onclick="return confirm('Do you want to approve routine list?');">Approved</button>
            <a href="<?php echo base_url('admin/routine_management_c/college_routine/College_routine_list/checkOverlaping');?>" <button
                class="btn btn-info" type="button">Check Overlaping</button></a>
        </center>
        <?php echo form_close(); ?>
        <br>


   <br>
      </div>
   </div>
   <?php } ?>
</div>
</div>
<?php $this->load->view($this->config->item('theme_uri').'layout/footer_view'); ?>
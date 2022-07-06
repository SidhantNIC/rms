<?php $this->load->view($this->config->item('theme_uri') . 'layout/header_view'); ?>
<?php $this->load->view($this->config->item('theme_uri') . 'layout/left_menu_view'); ?>
<!-- Content Wrapper. Contains page content -->
<style type="text/css">
   .tablebody {
      padding: 0 30px;
   }
    p {
      font-size: 10px;
      font-weight: bold;
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
   <?php echo form_open('admin/routine_management_c/routine/Routine_add/routineForwardlist_new'); ?>
   <div class="row" style="padding: 5px;">
      <div class="col-sm-4">
         <label>Academic Session</label><span class="text-danger">*</span>
         <select class="form-control" name="academic_year" id="academic_year">
            <option value="">--Select Academic Session--</option>
            <?php foreach ($all_academic_year as $all_academic_year) { ?>
               <option value="<?php echo $all_academic_year['academic_year_id_pk'] ?>" <?php echo set_select('academic_year', $all_academic_year['academic_year_id_pk'], False); ?>>
                  <?php echo $all_academic_year['academic_year_description'] ?>
               </option>
            <?php } ?>
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
         <label>Routine Status</label><span class="text-danger">*</span>
         <select class="form-control" name="routine_mode" id="routine_mode">
            <option value="">--Select Routine Status --</option>
			<option value="1" <?php echo set_select('routine_mode', 1); ?>>Created</option>
			<option value="2" <?php echo set_select('routine_mode', 2); ?>>Forwarded</option>
			<option value="4" <?php echo set_select('routine_mode', 4); ?>>Approved</option>
         </select>
         <span class="text-danger"><?php echo form_error('routine_mode'); ?></span>
      </div>
	  <div class="col-sm-2">
         <label>Section</label><span class="text-danger">*</span>
         <select class="form-control" name="section_name_s" id="section_name">
            <option value="">--Select Section --</option>
			<?php foreach ($section_data as $sd) { ?>
               <option value="<?php echo $sd['section_id_pk'] ?>" <?php echo set_select('section_name_s', $sd['section_id_pk'], False); ?>><?php echo $sd['section_name'] ?>
               </option>
            <?php } ?>
         </select>
         <span class="text-danger"><?php echo form_error('section_name'); ?></span>
      </div>
      <div class="col-sm-2">
         <button type="submit" class="btn btn-success btn-block" style="margin-top:25px;"> <b><i class="fa fa-search"></i> Search</b></button>
      </div>
   </div>

   <?php echo form_close(); ?>
   <br>
   <?php if (count($countresult) > 0) { ?>
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
                           <p align="center"><?php echo $mondays['room_no']; ?></p>
                           <p align="center"><?php echo $mondays['periodtype']; ?></p>
						   
						   <?php if($mondays['period_type_fk']!=4){ ?>
                           <p align="center"><?php echo @get_theory_subeject_name($mondays['subject_id_fk']); ?></p>
                           <p align="center">
                              <?php
                              foreach ($mondays['teacher'] as $key => $teacher_name) {
                                 echo $teacher_name['first_name'] . ' ' . $teacher_name['midle_name'] . ' ' .  $teacher_name['last_name'];
                              }
                              ?>
                           </p>
                           <p align="center">
                              <?php
                              foreach ($mondays['subject'] as $key => $subject_name) {
                                 echo ($subject_name['subject_description']);
                              }
                              ?>
                           </p>
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
                           <p align="center"><?php echo $tuesdays['room_no']; ?></p>
                           <p align="center"><?php echo $tuesdays['periodtype']; ?></p>
						   <?php if($tuesdays['period_type_fk']!=4){ ?>
                           <p align="center"><?php echo @get_theory_subeject_name($tuesdays['subject_id_fk']); ?></p>
                           <p align="center">
                              <?php
                              foreach ($tuesdays['teacher'] as $key => $teacher_name) {
                                 echo $teacher_name['first_name'] . ' ' . $teacher_name['midle_name'] . ' ' .  $teacher_name['last_name'];
                              }
                              ?>
                           </p>
                           <p align="center">
                              <?php
                              foreach ($tuesdays['subject'] as $key => $subject_name) {
                                  echo ($subject_name['subject_description']);
                              }
                              ?>
                           </p>
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
                           <p align="center"><?php echo $wednesdays['room_no']; ?></p>
                           <p align="center"><?php echo $wednesdays['periodtype']; ?></p>
						   <?php if($wednesdays['period_type_fk']!=4){ ?>
                           <p align="center"><?php echo @get_theory_subeject_name($wednesdays['subject_id_fk']); ?></p>
                           <p align="center">
                              <?php
                              foreach ($wednesdays['teacher'] as $key => $teacher_name) {
                                 echo $teacher_name['first_name'] . ' ' . $teacher_name['midle_name'] . ' ' .  $teacher_name['last_name'];
                              }
                              ?>
                           </p>
                           <p align="center">
                              <?php
                              foreach ($wednesdays['subject'] as $key => $subject_name) {
                                   echo ($subject_name['subject_description']);
                              }
                              ?>
                           </p>
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
                           <p align="center"><?php echo $thrusdays['room_no']; ?></p>
                           <p align="center"><?php echo $thrusdays['periodtype']; ?></p>
						   <?php if($thrusdays['period_type_fk']!=4){ ?>
                           <p align="center"><?php echo @get_theory_subeject_name($thrusdays['subject_id_fk']); ?></p>
                           <p align="center">
                              <?php
                              foreach ($thrusdays['teacher'] as $key => $teacher_name) {
                                 echo $teacher_name['first_name'] . ' ' . $teacher_name['midle_name'] . ' ' .  $teacher_name['last_name'];
                              }
                              ?>
                           </p>
                           <p align="center">
                              <?php
                              foreach ($thrusdays['subject'] as $key => $subject_name) {
                                   echo ($subject_name['subject_description']);
                              }
                              ?>
                           </p>
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
                           <p align="center"><?php echo $fridays['room_no']; ?></p>
                           <p align="center"><?php echo $fridays['periodtype']; ?></p>
						   <?php if($fridays['period_type_fk']!=4){ ?>
                           <p align="center"><?php echo @get_theory_subeject_name($fridays['subject_id_fk']); ?></p>
                           <p align="center">
                              <?php
                              foreach ($fridays['teacher'] as $key => $teacher_name) {
                                 echo $teacher_name['first_name'] . ' ' . $teacher_name['midle_name'] . ' ' .  $teacher_name['last_name'];
                              }
                              ?>
                           </p>
                           <p align="center">
                              <?php
                              foreach ($fridays['subject'] as $key => $subject_name) {
                                   echo ($subject_name['subject_description']);
                              }
                              ?>
                           </p>
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
                           <p align="center"><?php echo $saturdays['room_no']; ?></p>
                           <p align="center"><?php echo $saturdays['periodtype']; ?></p>
						   <?php if($saturdays['period_type_fk']!=4){ ?>
                           <p align="center"><?php echo @get_theory_subeject_name($saturdays['subject_id_fk']); ?></p>
                           <p align="center">
                              <?php
                              foreach ($saturdays['teacher'] as $key => $teacher_name) {
                                 echo $teacher_name['first_name'] . ' ' . $teacher_name['midle_name'] . ' ' .  $teacher_name['last_name'];
                              }
                              ?>
                           </p>
                           <p align="center">
                              <?php
                              foreach ($saturdays['subject'] as $key => $subject_name) {
                                   echo ($subject_name['subject_description']);
                              }
                              ?>
                           </p>
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

         </table>
    <!---===============================:: Form End Here ::========================================-->
      <center>
		<?php if($forwardlist['routine_mode'] =='1') { ?>
         <?php echo form_open('admin/routine_management_c/routine/Routine_add/getRoutinefor'); ?>
         <?php
         $totalforwardlist = sizeof(@$countresult);
         for ($i = 0; $i < $totalforwardlist; $i++) {
         ?>
            <input type="hidden" name="forwardid[]" value="<?php echo $countresult[$i]['routine_manage_id_pk']; ?>">
         <?php } ?>
         <button class="btn btn-warning" type="submit" style="margin-right:15px;"><i class="fa fa-share"></i> <b>Forward Routine</b></button>
         <?php echo form_close(); ?>
		 
		<?php }else {  ?>
		  <?php echo form_open('admin/routine_management_c/routine/Routine_add/downlaodRoutinepdf'); ?>
            <input type="hidden" name="discipline_type" value="<?php echo ($forwardlist['discipline_type']); ?>">
            <input type="hidden" name="semester" value="<?php echo ($forwardlist['semester']); ?>">
            <input type="hidden" name="academic_year" value="<?php echo ($forwardlist['academic_year']); ?>">
            <input type="hidden" name="stud_year" value="<?php echo ($forwardlist['stud_year']); ?>">
            <input type="hidden" name="routine_mode" value="<?php echo ($forwardlist['routine_mode']); ?>">
            <input type="hidden" name="section_name_s" value="<?php echo ($forwardlist['section_name_s']); ?>">
            <center><button class="btn btn-info" type="submit"><i class="fa fa-download"></i> <b>Download Routine</b></button></center>
            <?php echo form_close(); ?>
		<?php } ?>
      </center>



      <!---===============================:: Form End Here ::========================================-->
   <?php } else { ?>

   <?php } ?>
   <br>
</div>
</div>
<?php $this->load->view($this->config->item('theme_uri') . 'layout/footer_view'); ?>

<script type="text/javascript">
   $(".forward_details").click(function() {
      $.ajax({
         url: "<?php echo base_url('dmin/routine_management_c/routine/Routine_add/getRoutinefor'); ?>",
         data: {},
         method: "GET",
         success: function(response) {

         }
      });
   });
</script>
<h4>Routine Management System v1.0</h4>
<table id="example1" class="table table-bordered table-striped custom_table" cellspacing="0" cellpadding="1" style="border-color:gray;" border="1">
         <tr align="center">
            <td colspan="9"><b>Academic Session :
               <?php echo get_academic_session_name(@$academic_year); ?>|| Year :
               <?php echo get_year_master_name(@$stud_year); ?>|| Discipline :
               <?php echo get_discipline_name(@$discipline_type); ?> ||Semester :
               <?php echo get_semester_name(@$semester); ?></b>
            </td>
         </tr>


         <tr>
            <th><b>Days</b></th>
            <?php foreach($period_time as $pt){ ?>
               <th style="font-size: 12px;">
               <?php echo  @$pt['period_start_time']."-".@$pt['period_end_time']; ?>
            </th>
            <?php } ?>
         </tr>
         <!--...................................Monday................................-->

         <tr>
            <td><b>Monday</b></td>
             <?php foreach($mondays as $monday) { ?>
               <td style="font-size: 12px;">
                <p>
               <?php if(@$monday['period_type_fk'] == '1'){?>
               <?php echo @get_theory_subeject_name(@$monday['subject_id_fk']); ?>
               <?php } ?>
             </p>
             <p>
               <?php if(@$monday['period_type_fk'] == '2'){?>
               <?php $faculty_details = @get_subject_name_usingid(@$monday['routine_manage_id_pk']); 
                  foreach ($faculty_details as  $value) {
                  echo @get_practical_subeject_name($value['subject_id']).',&nbsp;';
                  }
                  ?>
               <?php } ?>
             </p>
               <p><?php $faculty_details = @get_employee_name_usingid(@$monday['routine_manage_id_pk']); 
                  foreach ($faculty_details as  $value) {
                     echo $value['first_name'].$value['midle_name'].$value['last_name'].',&nbsp;';
                  }
                  ?>
                 </p>
                  <p><?php echo @$monday['room_no']; ?></p>
                  
                 <p> <b><?php echo @get_period_type_name(@$monday['period_type_fk']); ?></b></p>
               </td>
               
             <?php } ?>
         </tr>
         <!--...................................Tuesday................................-->
        <tr>
            <td><b>Tuesday</b></td>
             <?php foreach($tuesdays as $tuesday) { ?>
               <td style="font-size: 12px;">
                <p>
               <?php if(@$tuesday['period_type_fk'] == '1'){?>
               <?php echo @get_theory_subeject_name(@$tuesday['subject_id_fk']); ?>
               <?php } ?>
             </p>
             <p>
               <?php if(@$tuesday['period_type_fk'] == '2'){?>
               <?php $faculty_details = @get_subject_name_usingid(@$tuesday['routine_manage_id_pk']); 
                  foreach ($faculty_details as  $value) {
                  echo @get_practical_subeject_name($value['subject_id']).',&nbsp;';
                  }
                  ?>
               <?php } ?>
             </p>
               <p><?php $faculty_details = @get_employee_name_usingid(@$tuesday['routine_manage_id_pk']); 
                  foreach ($faculty_details as  $value) {
                     echo $value['first_name'].$value['midle_name'].$value['last_name'].',&nbsp;';
                  }
                  ?>
           </p>
                <p><?php echo @$tuesday['room_no']; ?></p>
                  <p>
                  <b><?php echo @get_period_type_name(@$tuesday['period_type_fk']); ?></b></p>
               </td>
               
             <?php } ?>
         </tr>
          <!--...................................Wednesday................................-->
        <tr>
            <td><b>Wednesday</b></td>
             <?php foreach($wednesdays as $wednesday) { ?>
               <td style="font-size: 12px;">
                <p>
                     <?php if(@$wednesday['period_type_fk'] == '1'){?>
               <?php echo @get_theory_subeject_name(@$wednesday['subject_id_fk']); ?>
               <?php } ?>
             </p>
             <p>
               <?php if(@$wednesday['period_type_fk'] == '2'){?>
               <?php $faculty_details = @get_subject_name_usingid(@$wednesday['routine_manage_id_pk']); 
                  foreach ($faculty_details as  $value) {
                  echo @get_practical_subeject_name($value['subject_id']).',&nbsp;';
                  }
                  ?>
               <?php } ?>
             </p>
               <p><?php $faculty_details = @get_employee_name_usingid(@$wednesday['routine_manage_id_pk']); 
                  foreach ($faculty_details as  $value) {
                     echo $value['first_name'].$value['midle_name'].$value['last_name'].',&nbsp;';
                  }
                  ?>
         </p>
         <p>
                <?php echo @$wednesday['room_no']; ?></p>
                  <p>
                  <b><?php echo @get_period_type_name(@$wednesday['period_type_fk']); ?></b>
                </p>
               </td>
               
             <?php } ?>
         </tr>
         <!--...................................Thrusday................................-->
        <tr>
            <td><b>Thrusdays</b></td>
             <?php foreach($thrusdays as $thrusday) { ?>
               <td style="font-size: 12px;">
                <p>
                     <?php if(@$thrusday['period_type_fk'] == '1'){?>
               <?php echo @get_theory_subeject_name(@$thrusday['subject_id_fk']); ?>
               <?php } ?>
             </p>
             <p>
               <?php if(@$thrusday['period_type_fk'] == '2'){?>
               <?php $faculty_details = @get_subject_name_usingid(@$thrusday['routine_manage_id_pk']); 
                  foreach ($faculty_details as  $value) {
                  echo @get_practical_subeject_name($value['subject_id']).',&nbsp;';
                  }
                  ?>
               <?php } ?>
             </p>
               <p><?php $faculty_details = @get_employee_name_usingid(@$thrusday['routine_manage_id_pk']); 
                  foreach ($faculty_details as  $value) {
                     echo $value['first_name'].$value['midle_name'].$value['last_name'].',&nbsp;';
                  }
                  ?>
                  </p>
                  <p><?php echo @$thrusday['room_no']; ?></p>
                <p>
                  <b>Period Type:<?php echo @get_period_type_name(@$thrusday['period_type_fk']); ?></b></p>
               </td>
               
             <?php } ?>
         </tr>
         <!--...................................Friday................................-->
        <tr>
            <td><b>Friday</b></td>
             <?php foreach($fridays as $friday) { ?>
              
               <td style="font-size: 12px;">
                <p>
                     <?php if(@$friday['period_type_fk'] == '1'){?>
               <?php echo @get_theory_subeject_name(@$friday['subject_id_fk']); ?>
               <?php } ?>
             </p>
             <p>
               <?php if(@$friday['period_type_fk'] == '2'){?>
               <?php $faculty_details = @get_subject_name_usingid(@$friday['routine_manage_id_pk']); 
                  foreach ($faculty_details as  $value) {
                  echo @get_practical_subeject_name($value['subject_id']).',&nbsp;';
                  }
                  ?>
               <?php } ?>
             </p>
             <p>
               <?php $faculty_details = @get_employee_name_usingid(@$friday['routine_manage_id_pk']); 
                  foreach ($faculty_details as  $value) {
                     echo $value['first_name'].$value['midle_name'].$value['last_name'].',&nbsp;';
                  }
                  ?>
                  </p>
                  <p><?php echo @$friday['room_no']; ?></p>
                
                  <p><b>Period Type:<?php echo @get_period_type_name(@$friday['period_type_fk']); ?></b></p>
               </td>
               
             <?php } ?>
         </tr>
         <!--...................................Saturday................................-->
        <tr>
            <td><b>Saturday</b></td>
             <?php foreach($saturdays as $saturday) { ?>
               <td style="font-size: 12px;">
                <p>
                     <?php if(@$saturday['period_type_fk'] == '1'){?>
               <?php echo @get_theory_subeject_name(@$saturday['subject_id_fk']); ?>
               <?php } ?>
             </p>
             <p>
               <?php if(@$saturday['period_type_fk'] == '2'){?>
               <?php $faculty_details = @get_subject_name_usingid(@$saturday['routine_manage_id_pk']); 
                  foreach ($faculty_details as  $value) {
                  echo @get_practical_subeject_name($value['subject_id']).',&nbsp;';
                  }
                  ?>
               <?php } ?>
             </p>
               <p><?php $faculty_details = @get_employee_name_usingid(@$saturday['routine_manage_id_pk']); 
                  foreach ($faculty_details as  $value) {
                     echo $value['first_name'].$value['midle_name'].$value['last_name'].',&nbsp;';
                  }
                  ?>
                  </p>
                  <p>
                  <?php echo @$saturday['room_no']; ?>
                  </p>
                  <p>
                  <b>Period Type:<?php echo @get_period_type_name(@$saturday['period_type_fk']); ?></b>
                </p>
               </td>
               
             <?php } ?>
         </tr>
      </table>
   
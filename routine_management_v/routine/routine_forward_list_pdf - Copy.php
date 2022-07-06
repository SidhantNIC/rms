<table id="example1" class="table table-bordered table-striped custom_table" cellspacing="0" cellpadding="1">
    <tr align="center" style="text-align: center;">
        <td colspan="9">Academic Session :
            <?php echo get_academic_session_name(@$academic_year['academic_year']); ?>||Year :
            <?php echo get_year_master_name(@$stud_year['stud_year']); ?>||Semester :
            <?php echo get_semester_name(@$semester['semester']); ?></td>
    </tr>
    <tr>
        <th style="border-bottom:1px solid balck;">Days</th>
        <th style="border-bottom:1px solid balck;">Period <?php echo @$result[0]['period_no']; ?></th>
        <th style="border-bottom:1px solid balck;">Period <?php echo @$result[1]['period_no']; ?></th>
        <th style="border-bottom:1px solid balck;">Period <?php echo @$result[2]['period_no']; ?></th>
        <th style="border-bottom:1px solid balck;">Period <?php echo @$result[3]['period_no']; ?></th>
        <th style="border-bottom:1px solid balck;">Period <?php echo @$result[4]['period_no']; ?></th>
        <th style="border-bottom:1px solid balck;">Period <?php echo @$result[5]['period_no']; ?></th>
        <th style="border-bottom:1px solid balck;">Period <?php echo @$result[6]['period_no']; ?></th>
        <th style="border-bottom:1px solid balck;">Period <?php echo @$result[7]['period_no']; ?></th>
    </tr>
    <tr>
        <td style="border-right:1px solid black;"><?php echo get_days_master_name(@$result[0]['days_id_fk']); ?></td>
        <!--.........1St............-->
        <td style="border-right:1px solid black;">
            Period Time: <?php echo @$result[0]['period_start_time']; ?>/
            <?php echo @$result[0]['period_end_time']; ?><br>
            <?php if(@$result[0]['period_type_fk'] == '1'){?>
            Subject:<?php echo get_theory_subeject_name(@$result[0]['subject_id_fk']); ?>
            <?php } ?>
            <?php if(@$result[0]['period_type_fk'] == '2'){?>
            Subject:<?php $faculty_details = get_subject_name_usingid(@$result[0]['routine_manage_id_pk']); 
            foreach ($faculty_details as  $value) {
              echo get_practical_subeject_name($value['subject_id']).'||';
            }
            ?>
            <?php } ?>
            <br>Faculty:<?php $faculty_details = get_employee_name_usingid(@$result[0]['routine_manage_id_pk']); 
            foreach ($faculty_details as  $value) {
               echo $value['first_name'].$value['midle_name'].$value['last_name'].'||';
            }
            ?>
            <br>
            Room No:<?php echo @$result[0]['room_no']; ?>
            <br>
            Period Type:<?php echo @get_period_type_name(@$result[0]['period_type_fk']); ?>
        </td>
        <!--..........2nd...............-->
        <td style="border-right:1px solid black;">
            Period Time: <?php echo @$result[1]['period_start_time']; ?>/
            <?php echo @$result[1]['period_end_time']; ?><br>
            <?php if(@$result[1]['period_type_fk'] == '1'){?>
            Subject:<?php echo get_theory_subeject_name(@$result[1]['subject_id_fk']); ?>
            <?php } ?>
            <?php if(@$result[1]['period_type_fk'] == '2'){?>
            Subject:<?php $faculty_details = get_subject_name_usingid(@$result[1]['routine_manage_id_pk']); 
            foreach ($faculty_details as  $value) {
              echo get_practical_subeject_name($value['subject_id']).'||';
            }
            ?>
            <?php } ?>
            <br>Faculty:<?php $faculty_details = get_employee_name_usingid(@$result[1]['routine_manage_id_pk']); 
            foreach ($faculty_details as  $value) {
               echo $value['first_name'].$value['midle_name'].$value['last_name'].'||';
            }
            ?>
            <br>
            Room No:<?php echo @$result[1]['room_no']; ?>
            <br>
            Period Type:<?php echo @get_period_type_name(@$result[1]['period_type_fk']); ?>
        </td>
        <!--.......3Rd.......-->
        <td style="border-right:1px solid black;">
            Period Time: <?php echo @$result[2]['period_start_time']; ?>/
            <?php echo @$result[2]['period_end_time']; ?><br>
            <?php if(@$result[2]['period_type_fk'] == '1'){?>
            Subject:<?php echo get_theory_subeject_name(@$result[2]['subject_id_fk']); ?>
            <?php } ?>
            <?php if(@$result[2]['period_type_fk'] == '2'){?>
            Subject:<?php $faculty_details = get_subject_name_usingid(@$result[2]['routine_manage_id_pk']); 
            foreach ($faculty_details as  $value) {
              echo get_practical_subeject_name($value['subject_id']).'||';
            }
            ?>
            <?php } ?>
            <br>Faculty:<?php $faculty_details = get_employee_name_usingid(@$result[2]['routine_manage_id_pk']); 
            foreach ($faculty_details as  $value) {
               echo $value['first_name'].$value['midle_name'].$value['last_name'].'||';
            }
            ?>
            <br>
            Room No:<?php echo @$result[2]['room_no']; ?>
            <br>
            Period Type:<?php echo @get_period_type_name(@$result[2]['period_type_fk']); ?>
        </td>
        <!--.......4Th...............-->
        <td style="border-right:1px solid black;">
            Period Time: <?php echo @$result[3]['period_start_time']; ?>/
            <?php echo @$result[3]['period_end_time']; ?><br>
            <?php if(@$result[3]['period_type_fk'] == '1'){?>
            Subject:<?php echo get_theory_subeject_name(@$result[3]['subject_id_fk']); ?>
            <?php } ?>
            <?php if(@$result[3]['period_type_fk'] == '2'){?>
            Subject:<?php $faculty_details = get_subject_name_usingid(@$result[3]['routine_manage_id_pk']); 
            foreach ($faculty_details as  $value) {
              echo get_practical_subeject_name($value['subject_id']).'||';
            }
            ?>
            <?php } ?>
            <br>Faculty:<?php $faculty_details = get_employee_name_usingid(@$result[3]['routine_manage_id_pk']); 
            foreach ($faculty_details as  $value) {
               echo $value['first_name'].$value['midle_name'].$value['last_name'].'||';
            }
            ?>
            <br>
            Room No:<?php echo @$result[3]['room_no']; ?>
            <br>
            Period Type:<?php echo @get_period_type_name(@$result[3]['period_type_fk']); ?>
        </td>
        <!--....5th.......-->
        <td style="border-right:1px solid black;">
            Period Time: <?php echo @$result[4]['period_start_time']; ?>/
            <?php echo @$result[4]['period_end_time']; ?><br>
            <?php if(@$result[4]['period_type_fk'] == '1'){?>
            Subject:<?php echo get_theory_subeject_name(@$result[1]['subject_id_fk']); ?>
            <?php } ?>
            <?php if(@$result[4]['period_type_fk'] == '2'){?>
            Subject:<?php $faculty_details = get_subject_name_usingid(@$result[4]['routine_manage_id_pk']); 
            foreach ($faculty_details as  $value) {
              echo get_practical_subeject_name($value['subject_id']).'||';
            }
            ?>
            <?php } ?>
            <br>Faculty:<?php $faculty_details = get_employee_name_usingid(@$result[4]['routine_manage_id_pk']); 
            foreach ($faculty_details as  $value) {
               echo $value['first_name'].$value['midle_name'].$value['last_name'].'||';
            }
            ?>
            <br>
            Room No:<?php echo @$result[4]['room_no']; ?>
            <br>
            Period Type:<?php echo @get_period_type_name(@$result[4]['period_type_fk']); ?>
        </td>
        <!--.......6th..............-->
        <td style="border-right:1px solid black;">
            Period Time: <?php echo @$result[5]['period_start_time']; ?>/
            <?php echo @$result[5]['period_end_time']; ?><br>
            <?php if(@$result[5]['period_type_fk'] == '1'){?>
            Subject:<?php echo get_theory_subeject_name(@$result[5]['subject_id_fk']); ?>
            <?php } ?>
            <?php if(@$result[5]['period_type_fk'] == '2'){?>
            Subject:<?php $faculty_details = get_subject_name_usingid(@$result[5]['routine_manage_id_pk']); 
            foreach ($faculty_details as  $value) {
              echo get_practical_subeject_name($value['subject_id']).'||';
            }
            ?>
            <?php } ?>
            <br>Faculty:<?php $faculty_details = get_employee_name_usingid(@$result[5]['routine_manage_id_pk']); 
            foreach ($faculty_details as  $value) {
               echo $value['first_name'].$value['midle_name'].$value['last_name'].'||';
            }
            ?>
            <br>
            Room No:<?php echo @$result[5]['room_no']; ?>
            <br>
            Period Type:<?php echo @get_period_type_name(@$result[5]['period_type_fk']); ?>
        </td>
        <!--.......7th..............-->
        <td style="border-right:1px solid black;">
            Period Time: <?php echo @$result[6]['period_start_time']; ?>/
            <?php echo @$result[6]['period_end_time']; ?><br>
            <?php if(@$result[6]['period_type_fk'] == '1'){?>
            Subject:<?php echo get_theory_subeject_name(@$result[6]['subject_id_fk']); ?>
            <?php } ?>
            <?php if(@$result[6]['period_type_fk'] == '2'){?>
            Subject:<?php $faculty_details = get_subject_name_usingid(@$result[6]['routine_manage_id_pk']); 
            foreach ($faculty_details as  $value) {
              echo get_practical_subeject_name($value['subject_id']).'||';
            }
            ?>
            <?php } ?>
            <br>Faculty:<?php $faculty_details = get_employee_name_usingid(@$result[6]['routine_manage_id_pk']); 
            foreach ($faculty_details as  $value) {
               echo $value['first_name'].$value['midle_name'].$value['last_name'].'||';
            }
            ?>
            <br>
            Room No:<?php echo @$result[6]['room_no']; ?>
            <br>
            Period Type:<?php echo @get_period_type_name(@$result[6]['period_type_fk']); ?>
        </td>
        <!--.......8th..............-->
        <td style="border-right:1px solid black;">
            Period Time: <?php echo @$result[7]['period_start_time']; ?>/
            <?php echo @$result[7]['period_end_time']; ?><br>
            <?php if(@$result[7]['period_type_fk'] == '1'){?>
            Subject:<?php echo get_theory_subeject_name(@$result[7]['subject_id_fk']); ?>
            <?php } ?>
            <?php if(@$result[7]['period_type_fk'] == '2'){?>
            Subject:<?php $faculty_details = get_subject_name_usingid(@$result[7]['routine_manage_id_pk']); 
            foreach ($faculty_details as  $value) {
              echo get_practical_subeject_name($value['subject_id']).'||';
            }
            ?>
            <?php } ?>
            <br>Faculty:<?php $faculty_details = get_employee_name_usingid(@$result[7]['routine_manage_id_pk']); 
            foreach ($faculty_details as  $value) {
               echo $value['first_name'].$value['midle_name'].$value['last_name'].'||';
            }
            ?>
            <br>
            Room No:<?php echo @$result[7]['room_no']; ?>
            <br>
            Period Type:<?php echo @get_period_type_name($result[7]['period_type_fk']); ?>
        </td>
    </tr>
    <!--.....|||||||||||||||||||||||||||||||||||.................One Day Finnished.............................||||||||||||||||||||||||||..-->
       <tr>
        <td style="border-right:1px solid black;"><?php echo get_days_master_name(@$result[0]['days_id_fk']); ?></td>
        <!--.........1St............-->
        <td style="border-right:1px solid black;">
            Period Time: <?php echo @$result[0]['period_start_time']; ?>/
            <?php echo @$result[0]['period_end_time']; ?><br>
            <?php if(@$result[0]['period_type_fk'] == '1'){?>
            Subject:<?php echo get_theory_subeject_name(@$result[0]['subject_id_fk']); ?>
            <?php } ?>
            <?php if(@$result[0]['period_type_fk'] == '2'){?>
            Subject:<?php $faculty_details = get_subject_name_usingid(@$result[0]['routine_manage_id_pk']); 
            foreach ($faculty_details as  $value) {
              echo get_practical_subeject_name($value['subject_id']).'||';
            }
            ?>
            <?php } ?>
            <br>Faculty:<?php $faculty_details = get_employee_name_usingid(@$result[0]['routine_manage_id_pk']); 
            foreach ($faculty_details as  $value) {
               echo $value['first_name'].$value['midle_name'].$value['last_name'].'||';
            }
            ?>
            <br>
            Room No:<?php echo @$result[0]['room_no']; ?>
            <br>
            Period Type:<?php echo @get_period_type_name(@$result[0]['period_type_fk']); ?>
        </td>
        <!--..........2nd...............-->
        <td style="border-right:1px solid black;">
            Period Time: <?php echo @$result[1]['period_start_time']; ?>/
            <?php echo @$result[1]['period_end_time']; ?><br>
            <?php if(@$result[1]['period_type_fk'] == '1'){?>
            Subject:<?php echo get_theory_subeject_name(@$result[1]['subject_id_fk']); ?>
            <?php } ?>
            <?php if(@$result[1]['period_type_fk'] == '2'){?>
            Subject:<?php $faculty_details = get_subject_name_usingid(@$result[1]['routine_manage_id_pk']); 
            foreach ($faculty_details as  $value) {
              echo get_practical_subeject_name($value['subject_id']).'||';
            }
            ?>
            <?php } ?>
            <br>Faculty:<?php $faculty_details = get_employee_name_usingid(@$result[1]['routine_manage_id_pk']); 
            foreach ($faculty_details as  $value) {
               echo $value['first_name'].$value['midle_name'].$value['last_name'].'||';
            }
            ?>
            <br>
            Room No:<?php echo @$result[1]['room_no']; ?>
            <br>
            Period Type:<?php echo @get_period_type_name(@$result[1]['period_type_fk']); ?>
        </td>
        <!--.......3Rd.......-->
        <td style="border-right:1px solid black;">
            Period Time: <?php echo @$result[2]['period_start_time']; ?>/
            <?php echo @$result[2]['period_end_time']; ?><br>
            <?php if(@$result[2]['period_type_fk'] == '1'){?>
            Subject:<?php echo get_theory_subeject_name(@$result[2]['subject_id_fk']); ?>
            <?php } ?>
            <?php if(@$result[2]['period_type_fk'] == '2'){?>
            Subject:<?php $faculty_details = get_subject_name_usingid(@$result[2]['routine_manage_id_pk']); 
            foreach ($faculty_details as  $value) {
              echo get_practical_subeject_name($value['subject_id']).'||';
            }
            ?>
            <?php } ?>
            <br>Faculty:<?php $faculty_details = get_employee_name_usingid(@$result[2]['routine_manage_id_pk']); 
            foreach ($faculty_details as  $value) {
               echo $value['first_name'].$value['midle_name'].$value['last_name'].'||';
            }
            ?>
            <br>
            Room No:<?php echo @$result[2]['room_no']; ?>
            <br>
            Period Type:<?php echo @get_period_type_name(@$result[2]['period_type_fk']); ?>
        </td>
        <!--.......4Th...............-->
        <td style="border-right:1px solid black;">
            Period Time: <?php echo @$result[3]['period_start_time']; ?>/
            <?php echo @$result[3]['period_end_time']; ?><br>
            <?php if(@$result[3]['period_type_fk'] == '1'){?>
            Subject:<?php echo get_theory_subeject_name(@$result[3]['subject_id_fk']); ?>
            <?php } ?>
            <?php if(@$result[3]['period_type_fk'] == '2'){?>
            Subject:<?php $faculty_details = get_subject_name_usingid(@$result[3]['routine_manage_id_pk']); 
            foreach ($faculty_details as  $value) {
              echo get_practical_subeject_name($value['subject_id']).'||';
            }
            ?>
            <?php } ?>
            <br>Faculty:<?php $faculty_details = get_employee_name_usingid(@$result[3]['routine_manage_id_pk']); 
            foreach ($faculty_details as  $value) {
               echo $value['first_name'].$value['midle_name'].$value['last_name'].'||';
            }
            ?>
            <br>
            Room No:<?php echo @$result[3]['room_no']; ?>
            <br>
            Period Type:<?php echo @get_period_type_name(@$result[3]['period_type_fk']); ?>
        </td>
        <!--....5th.......-->
        <td style="border-right:1px solid black;">
            Period Time: <?php echo @$result[4]['period_start_time']; ?>/
            <?php echo @$result[4]['period_end_time']; ?><br>
            <?php if(@$result[4]['period_type_fk'] == '1'){?>
            Subject:<?php echo get_theory_subeject_name(@$result[1]['subject_id_fk']); ?>
            <?php } ?>
            <?php if(@$result[4]['period_type_fk'] == '2'){?>
            Subject:<?php $faculty_details = get_subject_name_usingid(@$result[4]['routine_manage_id_pk']); 
            foreach ($faculty_details as  $value) {
              echo get_practical_subeject_name($value['subject_id']).'||';
            }
            ?>
            <?php } ?>
            <br>Faculty:<?php $faculty_details = get_employee_name_usingid(@$result[4]['routine_manage_id_pk']); 
            foreach ($faculty_details as  $value) {
               echo $value['first_name'].$value['midle_name'].$value['last_name'].'||';
            }
            ?>
            <br>
            Room No:<?php echo @$result[4]['room_no']; ?>
            <br>
            Period Type:<?php echo @get_period_type_name(@$result[4]['period_type_fk']); ?>
        </td>
        <!--.......6th..............-->
        <td style="border-right:1px solid black;">
            Period Time: <?php echo @$result[5]['period_start_time']; ?>/
            <?php echo @$result[5]['period_end_time']; ?><br>
            <?php if(@$result[5]['period_type_fk'] == '1'){?>
            Subject:<?php echo get_theory_subeject_name(@$result[5]['subject_id_fk']); ?>
            <?php } ?>
            <?php if(@$result[5]['period_type_fk'] == '2'){?>
            Subject:<?php $faculty_details = get_subject_name_usingid(@$result[5]['routine_manage_id_pk']); 
            foreach ($faculty_details as  $value) {
              echo get_practical_subeject_name($value['subject_id']).'||';
            }
            ?>
            <?php } ?>
            <br>Faculty:<?php $faculty_details = get_employee_name_usingid(@$result[5]['routine_manage_id_pk']); 
            foreach ($faculty_details as  $value) {
               echo $value['first_name'].$value['midle_name'].$value['last_name'].'||';
            }
            ?>
            <br>
            Room No:<?php echo @$result[5]['room_no']; ?>
            <br>
            Period Type:<?php echo @get_period_type_name(@$result[5]['period_type_fk']); ?>
        </td>
        <!--.......7th..............-->
        <td style="border-right:1px solid black;">
            Period Time: <?php echo @$result[6]['period_start_time']; ?>/
            <?php echo @$result[6]['period_end_time']; ?><br>
            <?php if(@$result[6]['period_type_fk'] == '1'){?>
            Subject:<?php echo get_theory_subeject_name(@$result[6]['subject_id_fk']); ?>
            <?php } ?>
            <?php if(@$result[6]['period_type_fk'] == '2'){?>
            Subject:<?php $faculty_details = get_subject_name_usingid(@$result[6]['routine_manage_id_pk']); 
            foreach ($faculty_details as  $value) {
              echo get_practical_subeject_name($value['subject_id']).'||';
            }
            ?>
            <?php } ?>
            <br>Faculty:<?php $faculty_details = get_employee_name_usingid(@$result[6]['routine_manage_id_pk']); 
            foreach ($faculty_details as  $value) {
               echo $value['first_name'].$value['midle_name'].$value['last_name'].'||';
            }
            ?>
            <br>
            Room No:<?php echo @$result[6]['room_no']; ?>
            <br>
            Period Type:<?php echo @get_period_type_name(@$result[6]['period_type_fk']); ?>
        </td>
        <!--.......8th..............-->
        <td style="border-right:1px solid black;">
            Period Time: <?php echo @$result[7]['period_start_time']; ?>/
            <?php echo @$result[7]['period_end_time']; ?><br>
            <?php if(@$result[7]['period_type_fk'] == '1'){?>
            Subject:<?php echo get_theory_subeject_name(@$result[7]['subject_id_fk']); ?>
            <?php } ?>
            <?php if(@$result[7]['period_type_fk'] == '2'){?>
            Subject:<?php $faculty_details = get_subject_name_usingid(@$result[7]['routine_manage_id_pk']); 
            foreach ($faculty_details as  $value) {
              echo get_practical_subeject_name($value['subject_id']).'||';
            }
            ?>
            <?php } ?>
            <br>Faculty:<?php $faculty_details = get_employee_name_usingid(@$result[7]['routine_manage_id_pk']); 
            foreach ($faculty_details as  $value) {
               echo $value['first_name'].$value['midle_name'].$value['last_name'].'||';
            }
            ?>
            <br>
            Room No:<?php echo @$result[7]['room_no']; ?>
            <br>
            Period Type:<?php echo @get_period_type_name($result[7]['period_type_fk']); ?>
        </td>
    </tr>
    <!--\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\............End...........................\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\-->
</table>
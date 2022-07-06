<?php $this->load->view($this->config->item('theme_uri').'layout/header_view'); ?>
<?php $this->load->view($this->config->item('theme_uri').'layout/left_menu_view'); ?>
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script> -->
    
   
<style>
#note_div{
        color: #F00;
        font-size: 12px;
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
        <li class="active">Routine Create</li>
      </ol>
    </section>

    <!-- Main content -->
    <?php if($msg = $this->session->userdata('success')){ ?>
            <div class="alert alert-dismissible alert-success">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong><?php echo $msg; ?></strong> 
            </div>
            <?php } ?>

            <?php if($msg = $this->session->userdata('error')){ ?>
            <div class="alert alert-dismissible alert-danger">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong><?php echo $msg; ?></strong> 
            </div>
            <?php } ?>
        <section class="content">       
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Create Routine</h3>
                </div>
                <?php echo form_open('admin/routine/Routine_add'); ?>
                <!--...........Form Start...........-->
                <div class="row" style="padding: 5px;">
                   
                    <div class="col-sm-4">
                        <label>Academic Session</label><span class="text-danger text-lg">*</span>
                        <select class="form-control" name="academic_year" id="academic_year">
                            <option value="">--Please Select Academic Session--</option>
                            <?php foreach($all_academic_year as $all_academic_year) { ?>
                            <option value="<?php echo $all_academic_year['academic_year_id_pk']?>" <?php echo set_select('academic_year', $all_academic_year['academic_year_id_pk'], False); ?>><?php echo $all_academic_year['academic_year_description']?></option>
                         <?php } ?>
                        </select>
                        <span class="text-danger"><?php echo form_error('academic_year'); ?></span>
                    </div>

                     <div class="col-sm-4">
                        <label>Year</label><span class="text-danger">*</span>
                        <select class="form-control" name="stud_year" id="stud_year" onchange="getSemester(this.value);">
                            <option value="">--Please Select Year --</option>
                            <?php foreach($year as $year) { ?>
                            <option value="<?php echo $year['id'] ?>" <?php echo set_select('stud_year', $year['id'], False); ?>><?php echo $year['description']?></option>
                         <?php } ?>
                        </select>
                         <span class="text-danger"><?php echo form_error('stud_year'); ?></span>
                    </div>

                    <div class="col-sm-4">
                        <label>Semester</label><span class="text-danger">*</span>
                        <select class="form-control" name="semester" id="semester">
                            <option value="">--Please Select Semester --</option>
                           <!--  <?php foreach($semester as $semester) { ?>
                            <option value="<?php echo $semester['id'] ?>" <?php echo set_select('semester', $semester['id'], False); ?>><?php echo $semester['description']?></option>
                         <?php } ?> -->
                        </select>
                        <span class="text-danger"><?php echo form_error('semester'); ?></span>
                    </div>

                    
                </div>
            
            <br>
                    <div class="row" style="padding: 5px;">

                        <div class="col-sm-4">
                        <label>Discipline</label><span class="text-danger">*</span>
                        <select class="form-control" name="discipline_type" id="discipline_type">
                            <option value="">--Please Select Discipline --</option>
                            <?php foreach($discipline as $discipline) { ?>
                            <option value="<?php echo $discipline['course_id_pk'] ?>" <?php echo set_select('discipline_type', $discipline['course_id_pk'], False); ?>><?php echo $discipline['course_name']?></option>
                         <?php } ?>
                        </select>
                        <span class="text-danger"><?php echo form_error('discipline_type'); ?></span>
                    </div>


                        <div class="col-sm-4">
                        <label>Days</label><span class="text-danger text-lg">*</span>
                        <select class="form-control" name="days_name" id="days_name">
                            <option value="">--Please Select Days--</option>
                            <?php foreach($all_days as $all_days) { ?>
                            <option value="<?php echo $all_days['id']?>"  <?php echo set_select('days_name', $all_days['id'], False); ?>><?php echo $all_days['description']?></option>
                         <?php } ?>
                       
                        </select>
                        <span class="text-danger"><?php echo form_error('days_name'); ?></span>
                    </div>
                        <div class="col-sm-4">
                        <label>Period No</label><span class="text-danger">*</span>
                        <select class="form-control" name="period_no" id="period_no" onchange="getPeriodTime(this.value);">
                            <option value="">--Please Select Period No --</option>
                            <?php foreach($period_no as $period_no) { ?>
                            <option value="<?php echo $period_no['id']?>" <?php echo set_select('period_no', $period_no['id'], False); ?> ><?php echo $period_no['description']?></option>
                         <?php } ?>
                        </select>
                        <span class="text-danger"><?php echo form_error('period_no'); ?></span>
                    </div>

                   

                     
                </div>
                <br>
                <div class="row" style="padding: 5px;">
                  

                         <div class="col-sm-4">
                        <label>Period (Start Time)</label><span class="text-danger">*</span>
                        <input type="text" name="period_start_time" class="form-control" id="period_start_time" placeholder="Please Select Period Start Time" autocomplete="off" value="" >
                        <span class="text-danger"><?php echo form_error('period_start_time'); ?></span>
                        
                    </div>
                    <div class="col-sm-4">
                         <label>Period (End Time)</label><span class="text-danger">*</span>
                        <input type="text" name="period_end_time" class="form-control" id="period_end_time" placeholder="Please Select Period End Time" autocomplete="off"  value="">
                        <span class="text-danger"><?php echo form_error('period_end_time'); ?></span>
                    </div>
                    
                    <div class="col-sm-4">
                        <label>Period Type</label><span class="text-danger">*</span>
                        <select class="form-control" name="period_type" id="period_type" onchange="disableField(this.value);">
                            <option value="">--Please Select Period Type --</option>
                            <?php foreach($period_type as $period_type) { ?>
                            <option value="<?php echo $period_type['id']?>" <?php echo set_select('period_type', $period_type['id'], False); ?>> <?php echo $period_type['description'] ?></option>
                         <?php } ?>
                        </select>
                        <span class="text-danger"><?php echo form_error('period_type'); ?></span>
                    </div>

                    

                     
                </div>
                <br>
                <div class="row recess" style="padding: 5px;" >
                    <div class="col-sm-4">
                        <label>Room No</label><span class="text-danger">*</span>
                        <input type="text" name="room_no" class="form-control" id="room_no" placeholder="Please Enter The Room No" autocomplete="off" value="<?php echo set_value('room_no'); ?>">
                        <span class="text-danger"><?php echo form_error('room_no'); ?></span>
                    </div>

                     <div class="col-sm-4 theory" style="display: none;">
                        <label>Tehory Subject</label><span class="text-danger">*</span>
                        <select class="form-control" name="subj_name" id="subj_name">
                            <option value="">--Please Select Subject --</option>
                        </select>
                        <span class="text-danger"><?php echo form_error('subj_name'); ?></span>
                    </div>

                    <div class="col-sm-4 practical" style="display:none;">
                        <label>Practical Subject</label><span class="text-danger">*</span>
                        <select class="form-control practical1" name="prac_subj_name[]" id="practical" multiple="multiple">
                            <option value="">--Please Select Subject --</option>
                        </select>
                        <span class="text-danger"><?php echo form_error('prac_subj_name[]'); ?></span>
                    </div>
                   
                    <div class="col-sm-4 multiple">
                        <label>Teacher / Faculty Name</label><span class="text-danger">*</span>

                        <select name="emp_id[]" multiple="multiple" class="form-control 4colactive" id="emp_id" size="3" style="border-radius: 4px !important;">
                           
                            <?php foreach($all_emp as $emp){?>
                                    <option value="<?php echo $emp['emp_basic_id_pk'];?>"<?php echo set_select('emp_id',$emp['emp_basic_id_pk']);?> <?php echo set_select('emp_id', $emp['emp_basic_id_pk'], False); ?>><?php  echo $emp['first_name'];?> <?php  echo $emp['midle_name'];?> <?php  echo $emp['last_name'];?></option>
                                    <?php } ?>
                        </select> 
                        <span class="text-danger"><?php echo form_error('emp_id[]'); ?></span>
                    </div>
                   
                </div>
                
                     
                
                <br>
                <center><button class="btn btn-success addDtata" type="submit">Submit</button></center>
                <br>
                <?php echo form_close(); ?>


                <!--...........Form End.............-->
            </div>
            


        </section>
  </div>

<script>
$( document ).ready(function() {
  
    $('.practical1').multiselect({
        placeholder: 'Select Practical Subject'
    });
    $('#emp_id').multiselect({
        placeholder: 'Select Teacher / Faculty Name'
    });
});
</script>
<?php $this->load->view($this->config->item('theme_uri').'layout/footer_view'); ?>



<script type="text/javascript">
$(document).ready(function(){
    $('input.timepicker1').timepicker({ });
    $('input.timepicker2').timepicker({ });

});
</script>

<script type="text/javascript">
   function disableField(x){
   
    var period_type = x;
        if(period_type !='3'){
            $.ajax({
            url:"<?php echo base_url('admin/routine/Routine_add/getPeriodtypedata'); ?>",
            data:{period_type:period_type},
            method:"GET",
            success:function(response){
                //console.log(response);
                $("#subj_name").html(response);
                $(".practical").hide();
                $(".theory").show();
            }
        });
    }
    if(period_type =='2'){
            var $elem = $('.practical1');
            $.ajax({
            url:"<?php echo base_url('admin/routine/Routine_add/getPeriodtypedata'); ?>",
            data:{period_type:period_type},
            method:"GET",
            success:function(response){
                //console.log(response);
                $elem.html(response);
                $elem.multiselect('reload');
                $(".theory").hide();
                $(".practical").show();
            }
        });
    }
       if(period_type == '3'){
           $(".recess").hide();
           $('.multiple').hide();
        }else{
           $(".recess").show();
           $('.multiple').show(); 
        }
    }

    function getSemester(semesterid){
        var semestedid = semesterid;
        $.ajax({
            url:"<?php echo base_url('admin/routine/Routine_add/getSemesterdata'); ?>",
            data:{semestedid:semestedid},
            method:"GET",
            success:function(response){
                $("#semester").html(response);
            }
        });
    }
</script>
<script type="text/javascript">
    function getPeriodTime(period_no){
        var period_no  = period_no;
        $.ajax({
            url:"<?php echo base_url('admin/routine/Routine_add/getPeriodtimedata'); ?>",
            data:{period_no:period_no},
            method:"GET",
            dataType:"json",
            success:function(response){
                $("#period_start_time").val(response[0].period_start_time);
                $("#period_end_time").val(response[0].period_end_time);
            }
        });
    }
</script>
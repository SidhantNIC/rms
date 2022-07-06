<?php $this->load->view($this->config->item('theme_uri').'layout/header_view'); ?>
<?php $this->load->view($this->config->item('theme_uri').'layout/left_menu_view'); ?>
<style>
    #note_div {
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
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Update Routine</h3>
            </div>
            <?php echo form_open('admin/routine_management_c/college_routine/College_routine_list/editRoutine/'.$routine_id); ?>
            <!--...........Form Start...........-->
            <input type="hidden" name="routine_id_fk" value="<?php echo $all_details[0]['routine_manage_id_pk']; ?>">
            <input type="hidden" name="status_code" value="<?php echo $all_details[0]['status_code']; ?>" id="statusid">
            <div class="row" style="padding: 5px;">
                <div class="col-sm-4">
                    <label>Routine Id</label>
                    <input type="text" name="routine_unique_id"
                        value="<?php echo $all_details[0]['routine_unique_id']?>" readonly class="form-control">
                </div>
                <div class="col-sm-4">
                    <label>Academic Session</label><span class="text-danger text-lg">*</span>
                    <select class="form-control" name="academic_year" id="academic_year" readonly>
                        <option value="">--Please Select Academic Session--</option>
                        <?php foreach($all_academic_year as $all_academic_year) { ?>
                        <option value="<?php echo $all_academic_year['academic_year_id_pk']?>"
                            <?php echo ($all_details[0]['academic_year_id_pk']==$all_academic_year['academic_year_id_pk'])?'selected':'' ?>>
                            <?php echo $all_academic_year['academic_year_description']?>
                        </option>
                        <?php } ?>
                    </select>
                    <span class="text-danger"><?php echo form_error('academic_year'); ?></span>
                </div>
                <div class="col-sm-4">
                    <label>Year</label><span class="text-danger">*</span>
                    <?php if($all_details[0]['status_code'] == '4'){ ?>
                    <select class="form-control" onchange="getSemester(this.value);" readonly>
                        <option value="">--Please Select Year --</option>
                        <?php foreach($year as $year) { ?>
                        <option value="<?php echo $year['id']?>"
                            <?php echo ($all_details[0]['year_id_fk']==$year['id'])?'selected':'' ?> disabled>
                            <?php echo $year['description']?>
                        </option>
                        <?php } ?>
                        <input type="hidden" name="stud_year" value="<?php echo $all_details[0]['year_id_fk']; ?>" id="stud_year">
                    </select>
                    <?php }else{ ?>
                    <select class="form-control" name="stud_year" id="stud_year" onchange="getSemester(this.value);">
                        <option value="">--Please Select Year --</option>
                        <?php foreach($year as $year) { ?>
                        <option value="<?php echo $year['id']?>"
                            <?php echo ($all_details[0]['year_id_fk']==$year['id'])?'selected':'' ?>>
                            <?php echo $year['description']?>
                        </option>
                        <?php } ?>
                    </select>
                    <?php } ?>
                    <span class="text-danger"><?php echo form_error('stud_year'); ?></span>
                </div>
            </div>
            <br>
            <div class="row" style="padding: 5px;">
                <div class="col-sm-4 semester_hide">
                    <label>Semester</label><span class="text-danger">*</span>
                    <?php if($all_details[0]['status_code'] == '4'){ ?>
                    <select class="form-control" readonly>
                        <option value="">--Please Select Semester --</option>
                        <?php foreach($semester as $semester) { ?>
                        <option value="<?php echo $semester['id']?>" disabled
                            <?php echo ($all_details[0]['sem_id']==$semester['id'])?'selected':'' ?> disabled>
                            <?php echo $semester['description']?>
                        </option>
                        <?php } ?>
                    </select>
                    <input type="hidden" name="semester" value="<?php echo $all_details[0]['sem_id']; ?>" id="semester">
                    <?php }else{ ?>
                    <select class="form-control" name="semester" id="semester">
                        <option value="">--Please Select Semester --</option>
                        <?php foreach($semester as $semester) { ?>
                        <option value="<?php echo $semester['id']?>"
                            <?php echo ($all_details[0]['sem_id']==$semester['id'])?'selected':'' ?>>
                            <?php echo $semester['description']?>
                        </option>
                        <?php } ?>
                    </select>
                    <?php } ?>
                    <span class="text-danger"><?php echo form_error('semester'); ?></span>
                </div>
                <div class="col-sm-4">
                    <label>Discipline Type</label><span class="text-danger">*</span>
                    <?php if($all_details[0]['status_code'] == '4'){ ?>
                    <select class="form-control" id="discipline_type" readonly>
                        <option value="">--Please Select Discipline Type --</option>
                        <?php foreach($discipline as $discipline) { ?>
                        <option value="<?php echo $discipline['course_id_pk']?>"
                            <?php echo ($all_details[0]['course_id_pk']==$discipline['course_id_pk'])?'selected':'' ?>
                            disabled><?php echo $discipline['course_name']?></option>
                        <?php } ?>
                    </select>
                    <input type="hidden" name="discipline_type" value="<?php echo $all_details[0]['course_id_pk']; ?>"
                        id="discipline">
                    <?php }else{ ?>
                    <select class="form-control" name="discipline_type" id="discipline_type">
                        <option value="">--Please Select Discipline Type --</option>
                        <?php foreach($discipline as $discipline) { ?>
                        <option value="<?php echo $discipline['course_id_pk']?>"
                            <?php echo ($all_details[0]['course_id_pk']==$discipline['course_id_pk'])?'selected':'' ?>>
                            <?php echo $discipline['course_name']?>
                        </option>
                        <?php } ?>
                    </select>
                    <?php } ?>
                    <span class="text-danger"><?php echo form_error('discipline_type'); ?></span>
                </div>
                <div class="col-sm-4">
                    <label>Days</label><span class="text-danger text-lg">*</span>
                    <?php if($all_details[0]['status_code'] == '4'){ ?>
                    <select class="form-control" id="days_name" readonly>
                        <option value="">--Please Select Days--</option>
                        <?php foreach($all_days as $all_days) { ?>
                        <option value="<?php echo $all_days['id']?>"
                            <?php echo ($all_details[0]['days_id']==$all_days['id'])?'selected':'' ?> disabled>
                            <?php echo $all_days['description']?>
                        </option>
                        <?php } ?>
                    </select>
                    <input type="hidden" name="days_name" value="<?php echo $all_details[0]['days_id']; ?>">
                    <?php }else{ ?>
                    <select class="form-control" name="days_name" id="days_name">
                        <option value="">--Please Select Days--</option>
                        <?php foreach($all_days as $all_days) { ?>
                        <option value="<?php echo $all_days['id']?>"
                            <?php echo ($all_details[0]['days_id']==$all_days['id'])?'selected':'' ?>>
                            <?php echo $all_days['description']?>
                        </option>
                        <?php } ?>
                    </select>
                    <?php } ?>
                    <span class="text-danger"><?php echo form_error('days_name'); ?></span>
                </div>
            </div>
            <br>
            <div class="row" style="padding: 5px;">
                <div class="col-sm-4">
                    <label>Period No</label><span class="text-danger">*</span>
                    <?php if($all_details[0]['status_code'] == '4'){ ?>
                    <select class="form-control" id="period_no" onchange="getPeriodTime(this.value);" readonly>
                        <option value="">--Please Select Period No --</option>
                        <?php foreach($period_no as $period_no) { ?>
                        <option value="<?php echo $period_no['id']?>"
                            <?php echo ($all_details[0]['period_no_id']==$period_no['id'])?'selected':'' ?> disabled>
                            <?php echo $period_no['description']?>
                        </option>
                        <?php } ?>
                    </select>
                    <input type="hidden" name="period_no" value="<?php echo $all_details[0]['period_no_id']; ?>">
                    <?php }else{ ?>
                    <select class="form-control" name="period_no" id="period_no" onchange="getPeriodTime(this.value);">
                        <option value="">--Please Select Period No --</option>
                        <?php foreach($period_no as $period_no) { ?>
                        <option value="<?php echo $period_no['id']?>"
                            <?php echo ($all_details[0]['period_no_id']==$period_no['id'])?'selected':'' ?>>
                            <?php echo $period_no['description']?>
                        </option>
                        <?php } ?>
                    </select>
                    <?php } ?>
                    <span class="text-danger"><?php echo form_error('period_no'); ?></span>
                </div>
                <div class="col-sm-4">
                    <label>Period (Start Time)</label><span class="text-danger">*</span>
                    <input type="text" name="period_start_time" class="form-control timepicker1" id="period_start_time"
                        placeholder="Please Select Period Start Time" autocomplete="off"
                        value="<?php echo ($all_details[0]['period_start_time']); ?>" readonly>
                    <span class="text-danger"><?php echo form_error('period_start_time'); ?></span>
                </div>
                <div class="col-sm-4">
                    <label>Period (End Time)</label><span class="text-danger">*</span>
                    <input type="text" name="period_end_time" class="form-control timepicker1" id="period_end_time"
                        placeholder="Please Select Period End Time" autocomplete="off"
                        value="<?php echo ($all_details[0]['period_end_time']); ?>" readonly>
                    <span class="text-danger"><?php echo form_error('period_end_time'); ?></span>
                </div>
            </div>
            <br>
            <div class="row" style="padding: 5px;">
                <div class="col-sm-4">
                    <label>Period Type</label><span class="text-danger">*</span>
                    <?php if($all_details[0]['status_code'] == '4'){ ?>
                    <select class="form-control" name="period_type" id="period_type"
                        onchange="disableFields(this.value);">
                        <option value="">--Please Select Period Type --</option>
                        <?php foreach($period_type as $period_type) { ?>
                        <option value="<?php echo $period_type['id']?>"
                            <?php echo ($all_details[0]['period_type_id']==$period_type['id'])?'selected':'' ?>>
                            <?php echo $period_type['description']?>
                        </option>
                        <?php } ?>
                    </select>
                    <?php }else{ ?>
                    <select class="form-control" name="period_type" id="period_type"
                        onchange="disableField(this.value);">
                        <option value="">--Please Select Period Type --</option>
                        <?php foreach($period_type as $period_type) { ?>
                        <option value="<?php echo $period_type['id']?>"
                            <?php echo ($all_details[0]['period_type_id']==$period_type['id'])?'selected':'' ?>>
                            <?php echo $period_type['description']?>
                        </option>
                        <?php } ?>
                    </select>
                    <?php } ?>
                    <span class="text-danger"><?php echo form_error('period_type'); ?></span>
                </div>
                <div class="col-sm-4 room_hide">
                    <label>Room No</label><span class="text-danger">*</span>
                    <input type="text" name="room_no" class="form-control" id="room_no"
                        placeholder="Please Enter The Room No" autocomplete="off"
                        value="<?php echo $all_details[0]['room_no']; ?>">
                    <span class="text-danger"><?php echo form_error('room_no'); ?></span>
                </div>
                <div class="col-sm-4 theory" style="display: none;">
                    <label>Theory Subject</label><span class="text-danger">*</span>
                    <select class="form-control" name="subj_name" id="subj_name">
                        <option value="">--Please Select Subject --</option>
                        <?php foreach($subject as $subject){ ?>
                        <option value="<?php echo $subject['subject_code']?>"
                            <?php echo ($all_details[0]['subject_id_fk']==$subject['subject_code'])?'selected':'' ?>>
                            <?php echo $subject['subject_description']?>
                        </option>
                        <?php } ?>
                    </select>
                    <span class="text-danger"><?php echo form_error('subj_name'); ?></span>
                </div>
                <div class="col-sm-4 practical" style="display:none;">
                    <label>Practical Subject</label><span class="text-danger">*</span>
                    <select class="form-control practical1" name="prac_subj_name[]" id="practical" multiple="multiple">
                        <?php foreach($prac_subject as $prac_subject){ ?>
                        <option value="<?php echo $prac_subject['subject_code']?>"
                            <?php echo in_array($prac_subject['subject_code'], $subject_details_ids)?'selected':'' ?>>
                            <?php echo $prac_subject['subject_description']?>
                        </option>
                        <?php } ?>
                    </select>
                    <span class="text-danger"><?php echo form_error('prac_subj_name[]'); ?></span>
                </div>
            </div>
            <br>
         <div class="row" style="padding: 5px;">
                <div class="col-sm-4 multiple">
                    <label>Teacher / Faculty Name</label><span class="text-danger">*</span>
                    <select name="emp_id[]" multiple="multiple" class="form-control 4colactive" id="emp_id">
                        <?php foreach($final_emp_list_data as $emp){ ?>
                        <option value="<?php echo $emp['emp_basic_id_pk'];?>"
                            <?php echo in_array($emp['emp_basic_id_pk'], $employee_details_ids)?'selected':'' ?>>
                            <?php  echo $emp['first_name'];?> <?php  echo $emp['midle_name'];?>
                            <?php  echo $emp['last_name'];?>
                        </option>
                        <?php } ?>
                    </select>
                    <span class="text-danger"><?php echo form_error('emp_id[]'); ?></span>
                </div>
            </div>
            <center><button class="btn btn-success addDtata" type="submit">Update</button></center>
            <br>
            <?php echo form_close(); ?>
            <!--...........Form End.............-->
        </div>
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
    </section>
</div>
<?php $this->load->view($this->config->item('theme_uri').'layout/footer_view'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        var period_type = $('select[name=period_type] option').filter(':selected').val()
        if (period_type == '3' ||period_type == '4' ) {
            $(".multiple").hide();
            $(".room_hide").hide();
        }
        if (period_type == '1') {
            $(".theory").show();
        }
        if (period_type == '2') {
            $(".practical").show();
        }
        $('.practical1').multiselect({
            placeholder: 'Select Practical Subject'
        });
    
        $('#emp_id').multiselect({
            placeholder: 'Select Teacher / Faculty Name'
        });
    
    });
</script>
<script type="text/javascript">
    function disableField() {
        var discipline_type = $('select[name=discipline_type] option').filter(':selected').val()
        var semester = $('select[name=semester] option').filter(':selected').val()
        var period_type = $('select[name=period_type] option').filter(':selected').val()
    
    
    
        if (period_type == '1') {
            $.ajax({
                url: "<?php echo base_url('admin/routine_management_c/college_routine/College_routine_list/getPeriodtypedata'); ?>",
                data: {
                    discipline_type: discipline_type,
                    semester: semester,
                    period_type: period_type
                },
                method: "GET",
                success: function(response) {
                    //console.log(response);
                    $("#subj_name").html(response);
                    $(".practical").hide();
                    $(".theory").show();
                }
            });
        }
        if (period_type == '2') {
            var $elem = $('.practical1');
            $.ajax({
                url: "<?php echo base_url('admin/routine_management_c/college_routine/College_routine_list/getPeriodtypedata'); ?>",
                data: {
                    discipline_type: discipline_type,
                    semester: semester,
                    period_type: period_type
                },
                method: "GET",
                success: function(response) {
                    //console.log(response);
                    $elem.html(response);
                    $elem.multiselect('reload');
                    $(".theory").hide();
                    $(".practical").show();
                }
            });
        }
        if (period_type == '3') {
            $(".recess").hide();
            $('.multiple').hide();
            $(".theory").hide();
            $(".practical").hide();
            $(".room_hide").hide();
    
        } else {
            $(".recess").show();
            $('.multiple').show();
            $(".theory").show();
            $(".practical").show();
            $(".room_hide").show();
        }
    }
    
    function getSemester(semesterid) {
        var semestedid = semesterid;
        $.ajax({
            url: "<?php echo base_url('admin/routine_management_c/college_routine/College_routine_list/getSemesterdata'); ?>",
            data: {
                semestedid: semestedid
            },
            method: "GET",
            success: function(response) {
                //console.log(response);
                $("#semester").html(response);
            }
        });
    }
</script>
<script type="text/javascript">
    function getPeriodTime(period_no) {
        var period_no = period_no;
        $.ajax({
            url: "<?php echo base_url('admin/routine_management_c/college_routine/College_routine_list/getPeriodtimedata'); ?>",
            data: {
                period_no: period_no
            },
            method: "GET",
            dataType: "json",
            success: function(response) {
                $("#period_start_time").val(response[0].period_start_time);
                $("#period_end_time").val(response[0].period_end_time);
            }
        });
    }
    
    $(".addDtata").click(function() {
        var emp_count = $('#emp_id :selected').length
        var prac_sub_count = $('#practical :selected').length
        if (emp_count > 6) {
            alert("You Can Select Maximum Six Teachear / Faculty Name");
            return false;
        }
    
        if (prac_sub_count > 2) {
            alert("You Can Select Maximum Two Practical Subjects");
            return false;
        }
    
    });
    
    function disableFields(){
        var semester = $("#semester").val();
        var discipline = $("#discipline").val();
        var period_type = $('select[name=period_type] option').filter(':selected').val();
    
        if (period_type == '1') {
            $.ajax({
                url: "<?php echo base_url('admin/routine_management_c/college_routine/College_routine_list/getPeriodtypedata'); ?>",
                data: {
                    discipline_type: discipline,
                    semester: semester,
                    period_type: period_type
                },
                method: "GET",
                success: function(response) {
                    
                    $("#subj_name").html(response);
                    $(".practical").hide();
                    $(".theory").show();
                }
            });
        }
        if (period_type == '2') {
            var $elem = $('.practical1');
            $.ajax({
                url: "<?php echo base_url('admin/routine_management_c/college_routine/College_routine_list/getPeriodtypedata'); ?>",
                data: {
                    discipline_type: discipline,
                    semester: semester,
                    period_type: period_type
                },
                method: "GET",
                success: function(response) {
                    
                    $elem.html(response);
                    $elem.multiselect('reload');
                    $(".theory").hide();
                    $(".practical").show();
                }
            });
        }
        if (period_type == '3' || period_type == '4') {
            $(".recess").hide();
            $('.multiple').hide();
            $(".theory").hide();
            $(".practical").hide();
            $(".room_hide").hide();
    
        } else {
            $(".recess").show();
            $('.multiple').show();
            $(".theory").show();
            $(".practical").show();
            $(".room_hide").show();
        }
        
        
    }
</script>
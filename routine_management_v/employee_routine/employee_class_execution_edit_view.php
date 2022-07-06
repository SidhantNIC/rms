<?php $this->load->view($this->config->item('theme_uri').'layout/header_view'); ?>
<?php $this->load->view($this->config->item('theme_uri').'layout/left_menu_view'); ?>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">
        <h3>Routine Management System v1.0</h3>

        <?php echo form_open('admin/routine_management_c/employee_routine/Employee_class_execution_list/classExecutionupdate/'.$execution_id); ?>
        <div class="row">
        <input type="hidden" name="execution_id" value="<?php echo $execution_details[0]['excecution_id_pk']; ?>">
        <input type="hidden" name="routine_details_id_fk" value="<?php echo $execution_details[0]['routine_details_id_fk']; ?>">
        <input type="hidden" name="employee_id_fk" value="<?php echo $execution_details[0]['employee_id_fk']; ?>">
        <input type="hidden" name="college_id_fk" value="<?php echo $execution_details[0]['college_id_fk']; ?>">
            <div class="col-sm-4">
                <label>Semester</label>
                <input type="text" class="form-control" value="<?php echo get_semester_name($execution_details[0]['semester_id_fk']); ?>"
                    readonly>
            </div>
            <div class="col-sm-4">
                <label>Discipline</label>
                <input type="text" class="form-control" value="<?php echo get_discipline_name($execution_details[0]['discipline_id_fk']); ?>"
                    readonly>
            </div>
            <div class="col-sm-4">
                <label>Period Start Time</label>
                <input type="text" class="form-control"
                    value="<?php echo $execution_details[0]['period_start_time']; ?>" readonly>
            </div>
            <div class="col-sm-4">
                <label>Period End Time</label>
                <input type="text" class="form-control" value="<?php echo $execution_details[0]['period_end_time']; ?>"
                    readonly>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Date</label>
                    <div class="input-group date" data-provide="datepicker" raedonly>
                        <input type="text" class="form-control" id="datepicker6" name="class_execution_date"
                            placeholder="Please Select Execution Date" readonly=""
                            value="<?php echo $execution_details[0]['class_execution_date']; ?>">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <label>Class Execution</label>
                <select class="form-control" name="class_execution" id="class_execution" onchange="changeMode(this.value);">
                    <option value="">-- Select Class Execution --</option>
                    <option value="1" <?php if($execution_details[0]['topic_coverd'] =='1'){ ?>selected <?php } ?>>Yes
                    </option>
                    <option value="0" <?php  if($execution_details[0]['topic_coverd'] =='0'){ ?>selected <?php } ?>>No
                    </option>
                </select>
            </div>

            <div class="col-sm-6 topic_coverded">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Topic Coverd</label> <span class="text-danger">*</span>
                    <textarea class="form-control" id="topic_coverd" name="topic_coverd" rows="3"
                        placeholder="Please Enter Revert Reason..."><?php echo $execution_details[0]['topic_coverd_desc']; ?></textarea>
                </div>
            </div>

            <div class="col-sm-6 topic_coverded">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Remarks</label> <span class="text-danger">*</span>
                    <textarea class="form-control" id="remarks" name="remarks" rows="3"
                        placeholder="Please Enter Revert Reason..."><?php echo $execution_details[0]['remarks']; ?></textarea>
                </div>
            </div>

            <div class="col-sm-6 reson">
                <label>Class Execution Reason</label>
                <select class="form-control" name="class_execution_reason" id="class_execution_reason">
                    <option value="">-- Select Class Execution Reason --</option>
                    <?php foreach($reason_deatils as $rd) { ?>
                    <option value="<?php echo $rd['reason_master_id_pk']; ?>" <?php echo ($execution_details[0]['topic_coverd_desc_no']==$rd['reason_master_id_pk'])?'selected':'' ?>>
                        <?php echo $rd['reason_master_description']; ?></option>
                    <?php }  ?>
                </select>
            </div>


        </div>

        <br>
        <center><button class="btn btn-warning" type="submit">Update</button></center>
        <?php echo form_close(); ?>


    </section>
</div>
<?php $this->load->view($this->config->item('theme_uri').'layout/footer_view'); ?>
<!--.............................Modal.......................-->
<script>
$(document).ready(function() {
    $('#datepicker').datepicker();
    var class_execution  = $('select[name=class_execution] option').filter(':selected').val();
    if(class_execution == '0'){
        $(".topic_coverded").hide();
    }else{
        $(".reson").hide();
    }
});
function changeMode(id){
    var executionid = id;
    if(executionid == '0'){
        $(".topic_coverded").hide();
        $(".reson").show();
    }else{
        $(".reson").hide();
        $(".topic_coverded").show();
    }
}
</script>
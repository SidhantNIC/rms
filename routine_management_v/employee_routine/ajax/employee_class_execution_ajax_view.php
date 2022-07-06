<style>
    .star {
        color: #F00;
        font-size: 18px;
    }
</style>

<?php if (isset($code)) { ?>
    <?php if ($code == '1') {
        $class = 'alert-success';
    } else {
        $class = 'alert-warning';
    } ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert <?php echo $class; ?> text-center">
                <span><b><?php echo $msg; ?></b></span>
            </div>
        </div>
    </div>
<?php } else { ?>
    <?php echo form_open(base_url('admin/routine_management_c/employee_routine/Employee_routine_list/confirm_result_revart'), array('id' => 'clg_reject_routine_form')) ?>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Date</label>
                <div class="input-group date" data-provide="datepicker" raedonly>
                    <input type="text" class="form-control" id="datepicker6" placeholder="Please Select Execution Date" readonly="" name="execution_date">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </div>
                </div>
            </div>
            <span class="text-danger"><?php echo form_error('execution_date'); ?></span>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Class Execution</label>
                <select class="form-control execution_status" id="class_execution_yes_no" onchange="getExecutionstatus(this.value);" name="class_execution_cnfrm">
                    <option value="">-- Select Execution --</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>
            <span class="text-danger"><?php echo form_error('class_execution_cnfrm'); ?></span>
        </div>
        <div class="col-sm-12 textar" style="display: none;">
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Topic Coverd</label> <span class="text-danger">(Maximum 255 Character Allowed (*))</span>
                <textarea class="form-control" id="class_execution_yes" name="revert_remarks" rows="3" placeholder="Please Enter Revert Reason..." required maxlength="255"></textarea>
            </div>
            <span class="text-danger"><?php echo form_error('revert_remarks'); ?></span>
        </div>
        <div class="col-sm-12 textar">
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Remarks (Maximum 255 Character Allowed)</label>
                <textarea class="form-control" id="remarks" name="remarks" rows="3" placeholder="Please Enter Revert Reason..." required maxlength="255"></textarea>
            </div>
        </div>
        <div class="col-sm-12 textar">
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Total No of Students Registered In The Class</label>
                <input type="text" class="form-control registerd_class" name="registerd_class" id="registerd_class" placeholder="Total No Of Students Registered In The Class">
            </div>
            <span class="text-danger"><?php echo form_error('registerd_class'); ?></span>
        </div>
        <div class="col-sm-12 textar">
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Number of Students Attended the class</label>
                <input type="text" class="form-control" name="attended_class" id="attended_class" placeholder="Enter Number Of Students Attended the class">
            </div>
            <span class="text-danger"><?php echo form_error('attended_class'); ?></span>
        </div>
        <div class="col-sm-12 class_execution_reason" style="display: none;">
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Class Execution Reason</label> <span class="text-danger">*</span>
                <select class="form-control" id="class_execution_no" name="class_execution_reason">
                    <option value="">--Select Reason--</option>
                    <?php foreach ($all_reason as $all_reason) { ?>
                        <option value="<?php echo $all_reason['reason_master_id_pk'];  ?>">
                            <?php echo $all_reason['reason_master_description'];  ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>


    </div>
     <input type="hidden" name="routine_hash" id="clg_hash" value="<?php echo ($routine_id); ?>">
     <input type="hidden" name="routine_id_fk" value="<?php echo ($routine_details_data['routine_manage_id_pk']); ?>">
     <input type="hidden" name="period_no" value="<?php echo ($routine_details_data['period_no']); ?>">
	 <input type="hidden" name="college_id_fk_exe" value="<?php echo $routine_details_data['college_id_fk'];  ?>">
	 <input type="hidden" name="days_id_fk" value="<?php echo $routine_details_data['days_id_fk'];  ?>">
    <?php echo form_close(); ?>
<?php } ?>
<?php if ($this->input->method(TRUE) == 'POST') { ?>
    <?php if (isset($code) && $code == 1) { ?>
        <script type="text/javascript">
            $(document).ready(function(evt) {

                var clg_hash = "<?php echo md5($routine_dtls[0]['routine_id_pk']); ?>";
                $(".confirm_reject_emp").remove();
                //$("#wationg_approved_btn_"+clg_hash).remove();
                //                $("#reject_"+clg_hash).remove();
                //$("#approved").show();
                //$("#clg_temp_status_approved_"+clg_hash).html('Approved');
            });
        </script>
    <?php } ?>
    <?php if (isset($code) && $code == 0) { ?>
        <script type="text/javascript">
            $(document).ready(function(evt) {
                var clg_hash = "<?php echo md5($routine_dtls[0]['routine_id_pk']); ?>";
                $(".confirm_reject_emp").remove();
            });
        </script>
    <?php } ?>
<?php } ?>

<script type="text/javascript">
    function getExecutionstatus(x){
        var execution_value = x;
        if(execution_value == 1){
            $(".class_execution_reason").hide();
            $(".textar").show();
        }else{
             $(".class_execution_reason").show();
             $(".textar").hide();
        }
    }
	
	$(".confirm_result_revart_back").click(function(){
		var registerd_class = $("#registerd_class").val();
		var attended_class = $("#attended_class").val();
		var class_execution_yes_no = $("#class_execution_yes_no").val();
		if(class_execution_yes_no=='1'){
			if(parseInt(registerd_class)< parseInt(attended_class)){
			alert("No Of Students Attended the class should be equal or less than the number of registered students");
			return false;
			}
		}
		
	});
</script>
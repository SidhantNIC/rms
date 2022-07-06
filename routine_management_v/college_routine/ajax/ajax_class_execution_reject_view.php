<style>
	.star{
		color: #F00;
		font-size : 18px;
	}
</style>
<div class="col-sm-12">
	<div class="col-sm-12">
    	<ul class="list-group">
<!--        	<li class="list-group-item active">Basic Details</li>-->
           <li class="list-group-item">Date: <b><?php echo $revert_data[0]['class_execution_date']; ?></b></li>
            <li class="list-group-item">Topic Coverd: <b><?php echo $revert_data[0]['topic_coverd_desc']; ?></b></li>
            <li class="list-group-item">Reason: <b><?php echo $revert_data[0]['topic_coverd_desc_no']; ?></b></li>
            
        </ul>
    </div>
</div>

<?php if(isset($code)){ ?>
    <?php if($code == '1'){ $class = 'alert-success'; } else{ $class = 'alert-warning'; }?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert <?php echo $class; ?> text-center">
                <span><b><?php echo $msg; ?></b></span>
            </div>
        </div>
    </div>
<?php } else{?>
	<?php echo form_open(base_url('admin/routine_management_c/college_routine/College_routine_execution_list/confirm_reject_routine'), array('id'=>'clg_reject_routine_form'))?>
        <div class="row">
        	<div class="col-md-12">
                <div class="form-group <?php echo (form_error('approve_revirt_dec') != '') ? 'has-error' : false;?>">
                    <label>Rejec Remarks (within 255 character)</label><span class="star">*</span>
                    <textarea name="approve_revirt_dec" id="approve_revirt_dec" class="form-control" placeholder="Remarks" maxlength="255" style="height:100px;"><?php echo set_value('approve_revirt_dec'); ?></textarea>
                    <?php echo form_error('approve_revirt_dec'); ?>
                </div>
            </div>
            <!-- <div class="col-sm-12">
                <span style="color:#F00; font-size:16px; font-weight:bold;">Does this routine reject ?</span>
            </div> -->
        </div>
        <input type="hidden" name="routine_hash" id="clg_hash" value="<?php echo $routine_manage_id_hash;?>">
    <?php echo form_close(); ?>
<?php } ?>
<?php if($this->input->method(TRUE) == 'POST'){ ?>
	<?php if(isset($code) && $code == 1){ ?>
		<script type="text/javascript">
        $(document).ready(function(evt){
				
                var clg_hash = "<?php echo md5($routine_dtls[0]['routine_id_pk']); ?>";
				$(".confirm_reject_emp").remove();
				//$("#wationg_approved_btn_"+clg_hash).remove();
//                $("#reject_"+clg_hash).remove();
                //$("#approved").show();
				//$("#clg_temp_status_approved_"+clg_hash).html('Approved');
            });
        </script>
	<?php } ?>
    <?php if(isset($code) && $code == 0){ ?>
		<script type="text/javascript">
        $(document).ready(function(evt){
                var clg_hash = "<?php echo md5($routine_dtls[0]['routine_id_pk']); ?>";
				$(".confirm_reject_emp").remove();
            });
        </script>
	<?php } ?>
<?php } ?>
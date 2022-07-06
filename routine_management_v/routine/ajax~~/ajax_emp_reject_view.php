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
            <li class="list-group-item">Name: <b><?php echo $emp_dtls[0]['first_name']; ?></b></li>
            
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
	<?php echo form_open(base_url('admin/admin_college_employee/admin_college_employee/confirm_reject_emp'), array('id'=>'clg_reject_emp_form'))?>
        <div class="row">
        	<div class="col-md-12">
                <div class="form-group <?php echo (form_error('approve_revirt_dec') != '') ? 'has-error' : false;?>">
                    <label>Remarks (within 255 character)</label><span class="star">*</span>
                    <textarea name="approve_revirt_dec" id="approve_revirt_dec" class="form-control" placeholder="Remarks" maxlength="255" style="height:100px;"><?php echo set_value('approve_revirt_dec'); ?></textarea>
                    <?php echo form_error('approve_revirt_dec'); ?>
                </div>
            </div>
            <div class="col-sm-12">
                <span style="color:#F00; font-size:16px; font-weight:bold;">Does this emp reject ?</span>
            </div>
        </div>
        <input type="hidden" name="clg_hash" id="clg_hash" value="<?php echo md5($emp_dtls[0]['emp_basic_id_pk']);?>">
    <?php echo form_close(); ?>
<?php } ?>
<?php if($this->input->method(TRUE) == 'POST'){ ?>
	<?php if(isset($code) && $code == 1){ ?>
		<script type="text/javascript">
        $(document).ready(function(evt){
				
                var clg_hash = "<?php echo md5($emp_dtls[0]['emp_basic_id_pk']); ?>";
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
                var clg_hash = "<?php echo md5($emp_dtls[0]['emp_basic_id_pk']); ?>";
				$(".confirm_reject_emp").remove();
            });
        </script>
	<?php } ?>
<?php } ?>
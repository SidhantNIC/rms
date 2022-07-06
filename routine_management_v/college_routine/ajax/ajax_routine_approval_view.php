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
            <li class="list-group-item">Days: <b><?php echo $revert_data[0]['days_desc']; ?></b></li>
            <li class="list-group-item">Academic Session: <b><?php echo $revert_data[0]['academic_year_description']; ?></b></li>
         <!--    <li class="list-group-item">Routine Date: <b><?php echo $revert_data[0]['rouitne_date']; ?></b></li> -->
            
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
	<?php echo form_open(base_url('admin/routine_management_c/college_routine/College_routine_list/confirm_approval_routine'), array('id'=>'admin_result_revart'))?>
        <div class="row">
        	<div class="col-md-12">
                <div class="form-group <?php echo (form_error('approve_revirt_dec') != '') ? 'has-error' : false;?>">
                    <label>Remarks (within 255 character)</label><span class="star">*</span>
                    <textarea name="approve_revirt_dec" id="approve_revirt_dec" class="form-control" placeholder="Remarks" maxlength="255" style="height:100px;"><?php echo set_value('approve_revirt_dec'); ?></textarea>
                    <?php echo form_error('approve_revirt_dec'); ?>
                </div>
            </div>
            
        </div>
        <input type="hidden" name="routine_manage_id_hash" id="routine_manage_id_hash" value="<?php echo $routine_manage_id_hash;?>">
    <?php echo form_close(); ?>
<?php } ?>






<?php if($this->input->method(TRUE) == 'POST'){ ?>
    <?php if(isset($code) && $code == 1){ ?>
        <script type="text/javascript">
        $(document).ready(function(evt){
                
                var batch_id_hash = "<?php echo $routine_manage_id_hash; ?>";
                $(".confirm_result_revart_back").remove();
                $("#approve_sc_btn_"+batch_id_hash).parent().parent().remove();
                //$("#tp_status_"+batch_id_hash).html('Waiting for Final Approval');
            });
        </script>
    <?php } ?>
    <?php if(isset($code) && $code == 0){ ?>
        <script type="text/javascript">
        $(document).ready(function(evt){
                var batch_id_hash = "<?php echo $routine_manage_id_hash; ?>";
                $(".confirm_result_revart_back").remove();
            });
        </script>
    <?php } ?>
<?php } ?>


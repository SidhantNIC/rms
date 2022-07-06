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
              <?php  unset($_SESSION['success']); ?> 
            </div>
            <?php } ?>

            <?php if($msg = $this->session->userdata('error')){ ?>
            <div class="alert alert-dismissible alert-danger">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong><?php echo $msg; ?></strong> 
               <?php  unset($_SESSION['error']); ?> 
            </div>
            <?php } ?>
        <section class="content">       
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Add Routine Time</h3>
                </div>
                <?php echo form_open('admin/routine_management_c/routine/Routine_add_time'); ?>
                <!--...........Form Start...........-->
                
            <br>
                    <div class="row" style="padding: 5px;">
                        <div class="col-sm-4">
                        <label>Period No</label><span class="text-danger">*</span>
                        <select class="form-control" name="period_no" id="period_no">
                            <option value="">--Please Select Period No --</option>
                            <?php foreach($period_no as $period_no) { ?>
                            <option  value="<?php echo $period_no['id']?>"
                                <?php echo set_select('period_no', $period_no['id'],False); ?>>
                            <?php echo $period_no['description']?></option>
                         <?php } ?>
                        </select>
                        <span class="text-danger"><?php echo form_error('period_no'); ?></span>
                    </div>

                        <div class="col-sm-4">
                        <label>Period (Start Time)</label><span class="text-danger">*</span>
                        <input type="text" name="period_start_time" class="form-control timepicker1" id="period_start_time" placeholder="Please Select Period Start Time" autocomplete="off" value="<?php echo @$postData['period_start_time']; ?>">
                        <span class="text-danger"><?php echo form_error('period_start_time'); ?></span>
                      
                    </div>
                    <div class="col-sm-4">
                         <label>Period (End Time)</label><span class="text-danger">*</span>
                        <input type="text" name="period_end_time" class="form-control timepicker2" id="period_end_time" placeholder="Please Select Period End Time" autocomplete="off" value="<?php echo @$postData['period_end_time']; ?>">
                        <span class="text-danger"><?php echo form_error('period_end_time'); ?></span>
                    </div>
                
                    

                     
                </div>
                <br>
                
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
  $('#datepicker').datepicker();
});
</script>
<?php $this->load->view($this->config->item('theme_uri').'layout/footer_view'); ?>



<script type="text/javascript">
$(document).ready(function(){
    $('input.timepicker1').timepicker({ 
        timeFormat: 'HH:mm:ss p'
     });
    $('input.timepicker2').timepicker({ 
        timeFormat: 'HH:mm:ss p'
    });

});
</script>


<script type="text/javascript">
    
    $(".addDtata").click(function(){
      //  var emp_id = $('#emp_id > option:selected');
        var time = $("#period_start_time").val();
        var time2 = $("#period_end_time").val();
        var period_end_time = $("#period_end_time").val();
         

        //var time = $("#starttime").val();
        var hours = Number(time.match(/^(\d+)/)[1]);
        var minutes = Number(time.match(/:(\d+)/)[1]);
        
        var sHourstotal = (hours *  3600);
        var sMinutestotal = (minutes * 60);
        var totalStarttime = (sHourstotal) + (sMinutestotal);
        var hours2 = Number(time2.match(/^(\d+)/)[1]);
        var minutes2 = Number(time2.match(/:(\d+)/)[1]);
        var eHourstotal = (hours2 *  3600);
        var eMinutestotal = (minutes2 * 60);
        var totalEndtime = (eHourstotal) + (eMinutestotal);

        if(totalStarttime == totalEndtime ){
            alert("End Time Always Grater Than Start Time");
            return false;
        }
        else if(totalStarttime > totalEndtime){
            alert("End Time Always Grater Than Start Time");
            return false;
        }
        else{
            return true;
        }
     });
</script>
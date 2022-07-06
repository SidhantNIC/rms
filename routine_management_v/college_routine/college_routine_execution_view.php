<?php $this->load->view($this->config->item('theme_uri').'layout/header_view'); ?>
<?php $this->load->view($this->config->item('theme_uri').'layout/left_menu_view'); ?>
<script src="<?php echo base_url('admin/assets/js/bootstrap-datepicker.min.js'); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('admin/assets/css/bootstrap-datepicker3.min.css');?>">
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
            <li class="active">List of routine</li>
        </ol>
    </section>
    <br>
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
    <!-- Main content Start-->
    <section class="content">




        <?php echo form_open('admin/routine_management_c/college_routine/College_routine_execution_list'); ?>
        <div class="row">
            <div class="col-sm-3">
                <label>From Date</label>
                <div class="input-group date" data-provide="datepicker" raedonly>
                    <input type="text" class="form-control" name="date" id="date" placeholder="Please Select From Date"
                        readonly="" value="<?php echo $this->input->post('date'); ?>">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <label>To Date</label>
                <div class="input-group date" data-provide="datepicker" raedonly>
                    <input type="text" class="form-control" name="to_date" placeholder="Please Select To Date"
                        readonly="" value="<?php echo $this->input->post('to_date'); ?>" id="to_date">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </div>
                </div>
            </div>




            <div class="col-sm-3">
                <label>Teacher / Faculty Name</label>
                <select class="form-control" name="emp_id">
                    <option value="">--Select Teacher / Faculty Name--</option>
                    <?php foreach($all_emp as $emp){?>
                    <option value="<?php echo $emp['emp_basic_id_pk'];?>"
                        <?php echo set_select('emp_id',$emp['emp_basic_id_pk']);?>
                        <?php echo set_select('emp_id', $emp['emp_basic_id_pk'], False); ?>>
                        <?php  echo $emp['first_name'];?> <?php  echo $emp['midle_name'];?>
                        <?php  echo $emp['last_name'];?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-sm-3">
                <label>Status</label>
                <select class="form-control" id="type" name="type">
                    <option value="">--Select Type--</option>
                    <option value="4" <?php echo set_select('type','4');?>>Approve</option>
                    <option value="5" <?php echo set_select('type','5');?>>Pending</option>
                    <option value="6" <?php echo set_select('type','6');?>>Reject</option>
                </select>
            </div>
        </div>
        <br>
        <center><button class="btn btn-success searchbtn" type="submit">Search</button></center>

        <br>


        <?php echo form_close(); ?>
        <br>


        <?php echo form_open('admin/routine_management_c/college_routine/College_routine_execution_list/approveAllexecution'); ?>
        <button class="btn btn-success" type="submit" onclick="return confirm('Do you want to Approved all routine?');"
            style="position: relative;left: 10px;" type="submit">Approve All</button>
        <br>
        <div class="table-responsive" style="padding: 10px;">
            <table id="example1" class="table table-bordered table-hover custom_table">
                <thead>
                    <tr align="center">
                        <th>All <input type="checkbox" name="" id="checkAll" class="checkbox"></th>
                        <th># </th>
                        <th>Faculty Name</th>
                        <th>Date</th>
                        <th>Semester</th>
                        <th>Discipline</th>
                        <th>Topic Coverd</th>
                        <th>Remarks</th>
                        <th>Reason</th>
                        <th>Period Time</th>
                        <th>Status</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; foreach($all_execution as $all_execution) {?>
                    <tr align="center">

                        <td>

                            <?php if($all_execution['status_code_fk']=='4' || $all_execution['status_code_fk']=='1' ||$all_execution['status_code_fk']=='3'||$all_execution['status_code_fk']=='6') { ?>

                            <?php }else{ ?>
                            <input type="checkbox" name="routine_id[]"
                                value="<?php echo $all_execution['excecution_id_pk']; ?>">
                            <?php } ?>
                        </td>
                        <td><?php echo $offset + $i.'.'; ?></td>
                        <td><?php echo $all_execution['first_name'].$all_execution['midle_name'].$all_execution['last_name']; ?>
                        </td>
                        <td><?php echo $all_execution['class_execution_date']; ?></td>
                        <td><?php echo @get_semester_name($all_execution['semester_id_fk']); ?></td>
                        <td><?php echo @get_discipline_name($all_execution['discipline_id_fk']); ?></td>
                        <td>
                            <?php if($all_execution['topic_coverd'] =='1') { ?>
                            <button class="btn btn-info" type="button" onclick="viewTopiccoverd(<?php echo $all_execution['excecution_id_pk']; ?>)">View</button>
                        <?php }else{ ?>
                             <button class="btn btn-info" type="button"  disabled>View</button>
                        <?php } ?>
                        </td>
                        <td><?php echo $all_execution['remarks']; ?></td>
                        <td><?php echo @get_reason_master_name($all_execution['topic_coverd_desc_no']); ?></td>
                        <td><?php echo $all_execution['period_start_time']; ?>-<?php echo $all_execution['period_end_time']; ?>
                        </td>


                        <td>
                            <button class="btn btn-warning"
                                disabled><?php echo $all_execution['process_description']; ?></button>
                        </td>
                        <td>
                            <?php if($all_execution['status_code_fk']=='6') { ?>
                            <a href="<?php echo base_url('admin/routine_management_c/college_routine/College_routine_execution_list/acceptExecution')?>/<?php echo md5($all_execution['excecution_id_pk']);?>"
                                onclick="return confirm('Do you want to approve this routine?');"><button
                                    class="btn btn-danger" disabled="" type="button">Rejected</button></a>
                            <?php } ?>

                            <?php if($all_execution['status_code_fk']=='4') { ?>
                            <a href="<?php echo base_url('admin/routine_management_c/college_routine/College_routine_execution_list/rejectExecution')?>/<?php echo md5($all_execution['excecution_id_pk']);?>"
                                onclick="return confirm('Do you want to reject this routine?');"><button
                                    class="btn btn-success" disabled="" type="button">Approved</button></a>

                            <?php } ?>

                            <?php if($all_execution['status_code_fk']=='5') { ?>
                            <a href="<?php echo base_url('admin/routine_management_c/college_routine/College_routine_execution_list/acceptExecution')?>/<?php echo md5($all_execution['excecution_id_pk']);?>"
                                onclick="return confirm('Do you want to approve this routine?');"><button
                                    class="btn btn-success" type="button" type="button">Approve</button></a>


                            <a href="javascript:void(0)" rel="<?php echo md5($all_execution['excecution_id_pk']); ?>"
                                class="btn btn-danger revart_back_result"
                                id="result_revert_btn_<?php echo $all_execution['excecution_id_pk']; ?>"
                                type="button">Reject</a>

                            <?php } ?>

                        </td>


                    </tr>
                    <?php $i++; } ?>
                </tbody>
            </table>
            <?php echo form_close(); ?>

            <?php  echo $page_links; ?>


    </section>
    <!-- Main content End -->

</div>

<?php $this->load->view($this->config->item('theme_uri').'layout/footer_view'); ?>
<script type="text/javascript">
$("#checkAll").click(function() {
    $('input:checkbox').not(this).prop('checked', this.checked);
});
</script>
<!---------------------------- Modal for Revart Back Result to SSC ----------------------->
<div id="myResultback" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title modal_title">Revart Back</h4>
            </div>
            <div class="modal-body modal_revart_back_body">
            </div>
            <div class="modal-footer">
                <span class="show_revart_back_btn_dtls"></span>
                <button type="button" class="btn btn-default frwd_btn_no close_btn" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!---------------------------- Modal for Revart Back Result to SSC---------------------->
<!--.............................Modal.......................-->

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><b>Topic Coverd Details</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
				<div class="col-sm-12 textar">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Topic Coverd</label> <span class="text-danger">*</span>
                        <textarea class="form-control" id="class_execution_yes" rows="3"
                            placeholder="Please Enter Revert Reason..." required readonly=""></textarea>
                    </div>
				</div>
				<div class="col-sm-12">
					<div class="form-group">
					<label>Student Registerd</label>
					<input type="text"  class="form-control total_registerd_studnet" disabled>

					</div>
				</div>
				<div class="col-sm-12">
					<div class="form-group">
					<label>Studnet Attend</label>
					<input type="text"  class="form-control total_attend_studnet" disabled>

					</div>
				</div>
				
                
                
            </div>
            <br>
            <div class="modal-footer" style="margin-top: 15px;">
                <!-- <button type="button" class="btn btn-secondary closebtn" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="submitRevert();">Submit</button> -->
            </div>
        </div>
    </div>
</div>
<!--............................................-->
<!---------------------------- Modal for Display the topic coverd---------------------->
<script type="text/javascript">
      $(".close_btn").click(function(){
      window.location = 'routine_management_c/college_routine/College_routine_execution_list';
    });

function viewTopiccoverd(topic_id){
       var topic_id = topic_id;
           $.ajax({
            url:"<?php echo base_url('admin/routine_management_c/college_routine/College_routine_execution_list/viewTopic')?>",
            data:{topic_id,topic_id},
            method:"GET",
			dataType:"json",
            success:function(response){
				//console.log(response);
				//return false;
                $("#class_execution_yes").val(response.topic_coverd_desc);
				$(".total_registerd_studnet").val(response.total_no_studnets_registerd);
				$(".total_attend_studnet").val(response.total_no_of_students_attends);
                $("#exampleModal").modal('show');
            }
           });
    }

    

</script>
<?php $this->load->view($this->config->item('theme_uri').'layout/header_view'); ?>
<?php $this->load->view($this->config->item('theme_uri').'layout/left_menu_view'); ?>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->

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
    <!-- Main content -->
    <section class="content">
        <h3>Routine Management System v1.0</h3>
        <div class="table-responsive">
            <table class="table table-bordered table-hover custom_table">
                <tr align="center">
                    <th>SL.No</th>
                    <th>Class Execution Date</th>
                    <th>Class Executed</th>
                    <th>Topic Covered</th>
                    <th>Remarks</th>
                    <th>Class Not Executed (Reason)</th>
                    <th>Reject Reason</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <?php $i=1; foreach($class_execution as $class_execution) { ?>
                <tr align="center">
                    <td><?php echo ($offset+$i); ?></td>
                    <td><?php echo $class_execution['class_execution_date']; ?></td>
                    <td><?php  if($class_execution['topic_coverd'] == '1'){ ?> Yes<?php }else{ ?>NO<?php } ?></td>
                    <td> <?php if($class_execution['topic_coverd'] =='1') { ?>
                            <button class="btn btn-info" type="button" onclick="viewTopiccoverd(<?php echo $class_execution['excecution_id_pk']; ?>)">View</button>
                        <?php }else{ ?>
                             <button class="btn btn-info" type="button"  disabled>View</button>
                        <?php } ?></td>
                    <td><?php echo $class_execution['remarks']; ?></td>
                    <td><?php echo $class_execution['reason_master_description']; ?></td>
                    <td><?php echo $class_execution['reject_remarks']; ?></td>
                    <td><button class="btn btn-success" disabled><?php echo $class_execution['process_description']; ?></button></td>
                   
                    <td>
                    <?php if($class_execution['status_code_fk']=='5'){?>
                    <a href="<?php echo base_url('admin/routine_management_c/employee_routine/Employee_class_execution_list/classExecutionupdate')?>/<?php echo md5($class_execution['excecution_id_pk']);?>"><button
                                class="btn btn-warning">Edit</button></a>
                    <?php }else{ ?>
                    <button class="btn btn-warning" disabled>Edit</button>
                    <?php } ?>
                    </td>
                    
                </tr>
                <?php $i++; }  ?>
            </table>
        </div>
        <?php echo $page_links; ?>

    </section>
</div>
<?php $this->load->view($this->config->item('theme_uri').'layout/footer_view'); ?>
<!--.............................Modal.......................-->
<!-- Modal -->
<!--.............................Modal.......................-->

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><b>Topic Covered Details</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <div class="col-sm-12 textar">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Topic Covered</label> <span class="text-danger">*</span>
                        <textarea class="form-control" id="class_execution_yes" rows="3"
                            placeholder="Please Enter Revert Reason..." required readonly=""></textarea>
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
<script type="text/javascript">
    function viewTopiccoverd(topic_id){
       var topic_id = topic_id;
           $.ajax({
            url:"<?php echo base_url('admin/routine_management_c/employee_routine/Employee_class_execution_list/viewTopic')?>",
            data:{topic_id,topic_id},
            method:"GET",
            success:function(response){
                $("#class_execution_yes").html(response);
                $("#exampleModal").modal('show');
            }
           });
    }
</script>
<!--............................................-->
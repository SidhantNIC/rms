<?php $this->load->view($this->config->item('theme_uri').'layout/header_view'); ?>
<?php $this->load->view($this->config->item('theme_uri').'layout/left_menu_view'); ?>
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
    <!-- Main content -->
    <?php echo form_open('admin/routine_management_c/routine/Routine_add/allApproverevertroutine'); ?>
    <?php for($i=0; $i<sizeof($all_emp_list); $i++) {?>
        <input type="hidden" name="revert_id_list[]" value="<?php echo $all_emp_list[$i]['routine_manage_id_pk']; ?>">
    <?php } ?>
    <button class="btn btn-info" onclick="return confirm('Please Check, Before Send all the routines?');" type="submit" style="position:relative;left:10px;">Forward All</button>
    <?php echo form_close(); ?>
    <div class="table-responsive" style="padding: 10px;">
        <table id="example1" class="table table-bordered table-striped custom_table">
            <thead>
                <tr align="center">
                    <th>#</th>
                    <th>Routine Id</th>
                    <th>Days</th>
                    <th>Period No</th>
                    <th>Room</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Period Type</th>
                    <th>Current Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <?php if(sizeof($all_emp_list) !='0') {?>
            <tbody>
                <?php $i=1; foreach($all_emp_list as $all_emp_list) {?>
                <tr align="center">
                    <td><?php echo ($offset+$i).'.'; ?></td>
                    <td><?php echo $all_emp_list['routine_unique_id']; ?></td>
                    <td><?php echo $all_emp_list['days_desc']; ?></td>
                    <td><?php echo get_period_no_name($all_emp_list['period_no']); ?></td>
                    <td><?php echo $all_emp_list['room_no']; ?></td>
                    <td><?php echo $all_emp_list['period_start_time']; ?></td>
                    <td><?php echo $all_emp_list['period_end_time']; ?></td>
                    <td><?php echo $all_emp_list['period_type_desc']; ?></td>
                    <td>
                        <button class="btn btn-primary"
                            disabled=""><?php echo $all_emp_list['process_description']; ?></button>
                    </td>
                    <td>
                        <?php if($all_emp_list['status_code'] == '1' || $all_emp_list['status_code'] == '3'){?>

                        <a
                            href="<?php echo base_url('admin/routine_management_c/routine/Routine_add/viewRoutinedetails')?>/<?php echo md5($all_emp_list['routine_manage_id_pk']);?>/<?php echo md5($all_emp_list['period_type_fk']);?>"><button
                                class="btn btn-success">View</button></a>&nbsp;&nbsp;


                        <a
                            href="<?php echo base_url('admin/routine_management_c/routine/Routine_add/editRoutine')?>/<?php echo md5($all_emp_list['routine_manage_id_pk']);?>"><button
                                class="btn btn-warning">Edit</button></a>&nbsp;&nbsp;

                        <a href="<?php echo base_url('admin/routine_management_c/routine/Routine_add/forwardRoutine')?>/<?php echo md5($all_emp_list['routine_manage_id_pk']);?>" onclick="return confirm('Do you want to forward this routine to Principal?');"><button class="btn btn-primary">Forward</button></a>


                        <?php } ?>



                        <?php if($all_emp_list['status_code'] == '2' || $all_emp_list['status_code'] == '4' ){?>
                        <a
                            href="<?php echo base_url('admin/routine_management_c/routine/Routine_add/viewRoutinedetails')?>/<?php echo md5($all_emp_list['routine_manage_id_pk']);?>/<?php echo md5($all_emp_list['period_type_fk']);?>"><button
                                class="btn btn-success">View</button></a>&nbsp;&nbsp;
                        <?php } ?>


                    </td>
                </tr>
                <?php $i++;} ?>
            </tbody>
            <?php }else{ ?>
            <tr>
                <td colspan="10" align="center"><span class="text-danger"><b>!! No Record Found !!</b></span></td>
            </tr>
            <?php } ?>
        </table>
        <?php echo $page_links; ?>
    </div>



</div>






<?php $this->load->view($this->config->item('theme_uri').'layout/footer_view'); ?>
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
    
    <!-- Main content -->

  
   
    

    <div class="table-responsive" style="padding: 10px;">
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
    <div class="alert alert-dismissible alert-warning">
        <button type="button" class="close" data-dismiss="alert" >&times;</button>
        <strong>
            1)If click on the button of "Delete Routine & Time" then entire routine of all semester and all discipline will be deleted with selected Period Time. 
           
            <br>2 )If click on the button of "Delete Only Time" then selected Period Time will be deleted, if no any routine available.
        </strong>
        
    </div>
        <table id="example1" class="table table-bordered table-striped custom_table">
            <thead>
                <tr>
                   
                    <th align="center">#</th>
					<th align="center">Period Name</th>
                    <th align="center">Period Start Time</th>
                    <th align="center">Period End Time</th>
                    <th align="center">Action</th>
                </tr>
            </thead>
             <tbody>
                <?php $i=1; foreach ($routine_time_period as $rtp) { ?>
                   <tr align="center">
                    <td><?php echo $i; ?></td>
					<td><?php echo @get_period_no_name($rtp['period_no_fk']); ?></td>
                    <td><?php echo $rtp['period_start_time']; ?></td>
                    <td><?php echo $rtp['period_end_time']; ?></td>
                    <td>
                         <a href="<?php echo base_url('admin/routine_management_c/routine/Deleteroutine_time/deletePeriodtimeroutine')?>/<?php echo md5($rtp['period_start_time']);?>/<?php echo md5($rtp['period_end_time']);?>" onclick="return confirm('Do you want delete Routine times & Routines?');"><button
                                class="btn btn-danger btn-xs">Delete Routines & Period Times <i class="fa fa-trash"></i></button></a>

                        <a href="<?php echo base_url('admin/routine_management_c/routine/Deleteroutine_time/deleteOnlytimes')?>/<?php echo md5($rtp['period_start_time']);?>/<?php echo md5($rtp['period_end_time']);?>" onclick="return confirm('Do you want to delete Only Routine Times?');"><button
                                class="btn btn-danger btn-xs">Delete Only Period Times <i class="fa fa-trash"></i></button></a>

                    </td>
                   </tr>
               <?php $i++; } ?>
            </tbody>
        </table>
   
    </div>
</div>
<?php $this->load->view($this->config->item('theme_uri').'layout/footer_view'); ?>

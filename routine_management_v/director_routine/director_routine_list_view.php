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
            <li><a href="dashboard"><i class="fa fa-dashboard"></i> Routine</a></li>
            <!--        <li class="active">Publications</li>-->
            <li class="active">List of routines</li>
        </ol>
    </section>
    <!-- Main content -->
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






    <div class="table-responsive" style="padding: 10px;">
        <table id="example1" class="table table-bordered table-striped custom_table">
            <thead>
                <tr align="center">
                    <th>#</th>
                    <th>College Name</th>
                    <th>Total No Of Routine Create</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php $i=1; foreach($routine_list_view as $rlv){ ?>
                <tr align="center">
                    <td><?php echo $offset+$i.'.'; ?></td>
                    <td><?php echo ($rlv['college_name']); ?></td>
                    <td><a href="<?php echo base_url('admin/routine_management_c/director_routine/Director_routine_list/viewRoutinelistcollegewise')?>/<?php echo md5($rlv['college_id_fk']);?>"><button class="btn btn-warning"> <i class="fa fa-eye"></i>
                            &nbsp;<?php echo $rlv['count']; ?></button></a></td>
                    
                </tr>
                <?php $i++; } ?>
            </tbody>
            <?php echo form_close(); ?>
        </table>
        <?php echo $page_links; ?>
    </div>
</div>
<script>
$(document).ready(function() {
    $('#datepicker').datepicker();
});
</script>
<?php $this->load->view($this->config->item('theme_uri').'layout/footer_view'); ?>

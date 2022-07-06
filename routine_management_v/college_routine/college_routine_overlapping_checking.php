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
    <div class="table-responsive" style="padding: 10px;">
        <table id="example1" class="table table-bordered table-hover custom_table">
            <thead>
                <tr align="center">

                    <th>#</th>
                    <th>Routine Id</th>
                    <th>Days</th>
                    <th>Period No</th>
                    <th>Room</th>
                    <th>Year</th>
                    <th>Semester</th>
                    <th>Period Time</th>
                    <th>Period Type</th>
                    <th>Stream / Disciple</th>
                    <th>Employee Name</th>
                </tr>
            </thead>
            <?php if(sizeof($result)>0) { ?>
            <tbody>
                <?php $i=1; foreach($result as $rs){ ?>
                <tr align="center">
                    <td><?php echo $i; ?></td>
                    <td><?php echo $rs['routine_unique_id']; ?></td>
                    <td><?php echo get_days_master_name($rs['days_id_fk']); ?></td>
                    <td><?php echo get_period_no_name($rs['period_no']); ?></td>
                    <td><?php echo $rs['room_no']; ?></td>
                    <td><?php echo get_year_master_name($rs['year_id_fk']); ?></td>
                    <td><?php echo get_semester_name($rs['semester_id_fk']); ?></td>
                    <td><?php echo $rs['period_start_time']." || ".$rs['period_end_time']; ?></td>
                    <td><?php echo get_period_type_name($rs['period_type_fk']); ?></td>
                    <td><?php echo get_discipline_name($rs['discipline_id_fk']); ?></td>
                    <td>
                    <?php 
                    $faculty_details = get_Employeee_name($rs['employee_id']);
                    foreach ($faculty_details as  $value) {
                        echo $value['first_name'].$value['midle_name'].$value['last_name'];
                     }
                    ?>
                    </td>
                </tr>
                <?php $i++; } ?>
            </tbody>
            <?php }else{ ?>
            <tbody>
                <tr>
                    <td colspan="11"><span class="text-danger"><b>
                                <center>!!! No Record Found !!!</center>
                            </b></span></td>
                </tr>
            </tbody>
            <?php } ?>

        </table>

    </div>
    <?php echo form_open('admin/routine/Routine_add/getRoutinefor'); ?>
    
</div>
<?php $this->load->view($this->config->item('theme_uri').'layout/footer_view'); ?>
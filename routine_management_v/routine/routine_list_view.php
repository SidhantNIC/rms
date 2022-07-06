<?php $this->load->view($this->config->item('theme_uri') . 'layout/header_view'); ?>
<?php $this->load->view($this->config->item('theme_uri') . 'layout/left_menu_view'); ?>
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
        <?php if ($msg = $this->session->userdata('success')) { ?>
            <div class="alert alert-dismissible alert-success">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong><?php echo $msg; ?></strong>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php } ?>

        <?php if ($msg = $this->session->userdata('error')) { ?>
            <div class="alert alert-dismissible alert-danger">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong><?php echo $msg; ?></strong>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php } ?>
        <p><span style="font-size: 20px;color:red;font-weight:bold;">Note : Routine Can Easily Be Serached Using This Below Fields, Select Anyone or Select all to search.</span></p>
        <?php echo form_open('admin/routine_management_c/routine/Routine_add/routine_list'); ?>
        <div class="row" style="padding: 5px;">
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Routine Id</label>
                    <input type="text" name="routine_unique_id" placeholder="Enter Routine Id" class="form-control" value="<?php echo set_value('routine_unique_id'); ?>">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-gropup">
                    <label>Days</label>
                    <select class="form-control" name="days_name" id="days_name">
                        <option value="">-- Select Days--</option>
                        <?php foreach ($all_days as $all_days) { ?>
                            <option value="<?php echo $all_days['id'] ?>" <?php echo set_select('days_name', $all_days['id']) ?>>
                                <?php echo $all_days['description'] ?></option>
                        <?php } ?>
                    </select>
                    <span class="text-danger"><?php echo form_error('days_name'); ?></span>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Stream / Discipline</label>
                    <select class="form-control" name="discipline_type" id="discipline_type">
                        <option value="">-- Select Discipline Type --</option>
                        <?php foreach ($discipline as $discipline) { ?>
                            <option value="<?php echo $discipline['course_id_pk'] ?>" <?php echo set_select('discipline_type', $discipline['course_id_pk']) ?>>
                                <?php echo $discipline['course_name'] ?></option>
                        <?php } ?>
                    </select>
                    <span class="text-danger"><?php echo form_error('discipline_type'); ?></span>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Year</label>
                    <select class="form-control" name="stud_year" id="stud_year">
                        <option value="">-- Select Year --</option>
                        <?php foreach ($year as $year) { ?>
                            <option value="<?php echo $year['id'] ?>" <?php echo set_select('stud_year', $year['id']) ?>>
                                <?php echo $year['description'] ?></option>
                        <?php } ?>
                    </select>
                    <span class="text-danger"><?php echo form_error('stud_year'); ?></span>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Semester</label>
                    <select class="form-control" name="semester" id="semester">
                        <option value="">--Please Select Semester --</option>
                        <?php foreach ($semester as $semester) { ?>
                            <option value="<?php echo $semester['id'] ?>" <?php echo set_select('semester', $semester['id']) ?>>
                                <?php echo $semester['description'] ?></option>
                        <?php } ?>
                    </select>
                    <span class="text-danger"><?php echo form_error('semester'); ?></span>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Teacher / Faculty Name</label>
                    <select class="form-control" name="emp_id" id="emp_id">
                        <option value="">--Select Teacher / Faculty Name --</option>
                        <?php foreach ($all_emp as $emp) { ?>
                            <option value="<?php echo $emp['emp_basic_id_pk']; ?>" <?php echo set_select('emp_id', $emp['emp_basic_id_pk']); ?> <?php echo set_select('emp_id', $emp['emp_basic_id_pk'], False); ?>>
                                <?php echo $emp['first_name']; ?> <?php echo $emp['midle_name']; ?> <?php echo $emp['last_name']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label>Period No</label>
                    <select class="form-control" name="period_no" id="period_no">
                        <option value="">--Select Period No --</option>
                        <?php foreach ($period_no as $period_no) { ?>
                            <option value="<?php echo $period_no['id'] ?>" <?php echo set_select('period_no', $period_no['id']) ?>>
                                <?php echo $period_no['description'] ?></option>
                        <?php } ?>
                    </select>
                    <span class="text-danger"><?php echo form_error('semester'); ?></span>
                </div>
            </div>
			 <div class="col-sm-2">
				 <label>Section</label><span class="text-danger">*</span>
				 <select class="form-control" name="section_name_s" id="section_name">
					<option value="">--Select Section --</option>
					<?php foreach ($section_data as $sd) { ?>
					   <option value="<?php echo $sd['section_id_pk'] ?>" <?php echo set_select('section_name_s', $sd['section_id_pk'], False); ?>><?php echo $sd['section_name'] ?>
					   </option>
					<?php } ?>
				 </select>
         <span class="text-danger"><?php echo form_error('section_name'); ?></span>
      </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <button class="btn btn-warning btn-block" style="margin-top: 24px;"><b><i class="fa fa-search"></i> Search Routine</b></button>
                </div>
            </div>

        </div>


        <?php echo form_close(); ?>
        <br>
        <table id="example1" class="table table-bordered table-striped custom_table">
            <thead>
                <tr align="center">
                    <th>#</th>
                    <th>Routine Id</th>
                    <th>Days</th>
                    <th>Period No</th>
                    <th>Section</th>
                    <th>Room</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Period Type</th>
                    <th>Current Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <?php if (sizeof($all_emp_list) != '0') { ?>
                <tbody>
                    <?php $i = 1;
                    foreach ($all_emp_list as $all_emp_list) { ?>
                        <tr align="center">
                            <td><?php echo ($offset + $i) . '.'; ?></td>
                            <td><?php echo $all_emp_list['routine_unique_id']; ?></td>
                            <td><?php echo $all_emp_list['days_desc']; ?></td>
                            <td><?php echo get_period_no_name($all_emp_list['period_no']); ?></td>
                            <td><?php echo $all_emp_list['sectiondata']; ?></td>
                            <td><?php echo $all_emp_list['room_no']; ?></td>
                            <td><?php echo $all_emp_list['period_start_time']; ?></td>
                            <td><?php echo $all_emp_list['period_end_time']; ?></td>
                            <td><?php echo $all_emp_list['period_type_desc']; ?></td>
                            <td>
                                <button class="btn btn-primary btn-xs" disabled=""><?php echo $all_emp_list['process_description']; ?></button>
                            </td>
                            <td>
                                <?php if ($all_emp_list['status_code'] == '1' || $all_emp_list['status_code'] == '3') { ?>

                                    <a href="<?php echo base_url('admin/routine_management_c/routine/Routine_add/viewRoutinedetails') ?>/<?php echo md5($all_emp_list['routine_manage_id_pk']); ?>/<?php echo md5($all_emp_list['period_type_fk']); ?>"><button class="btn btn-success btn-xs"><i class="fa fa-eye"></i> <b>View</b></button></a>


                                    <a href="<?php echo base_url('admin/routine_management_c/routine/Routine_add/editRoutine') ?>/<?php echo md5($all_emp_list['routine_manage_id_pk']); ?>"><button class="btn btn-warning btn-xs"><b><i class="fa fa-edit"></i> Edit</b></button></a>&nbsp;&nbsp;

                                    <!--  <a href="<?php echo base_url('admin/routine_management_c/routine/Routine_add/forwardRoutine') ?>/<?php echo md5($all_emp_list['routine_manage_id_pk']); ?>" onclick="return confirm('Do you want to forward this routine to Principal?');"><button class="btn btn-primary">Forward</button></a> -->


                                <?php } ?>



                                <?php if ($all_emp_list['status_code'] == '2' || $all_emp_list['status_code'] == '4') { ?>
                                    <a href="<?php echo base_url('admin/routine_management_c/routine/Routine_add/viewRoutinedetails') ?>/<?php echo md5($all_emp_list['routine_manage_id_pk']); ?>/<?php echo md5($all_emp_list['period_type_fk']); ?>"><button class="btn btn-success btn-xs"><b><i class="fa fa-eye"></i> View</b></button></a>
                                <?php } ?>

                                <?php if ($all_emp_list['status_code'] == '1') { ?>
                                    <a href="<?php echo base_url('admin/routine_management_c/routine/Routine_add/deleteRoutine') ?>/<?php echo md5($all_emp_list['routine_manage_id_pk']); ?>" onclick="return confirm('Do you want to delete this routine ?');"><button class="btn btn-danger btn-xs"><b><i class="fa fa-trash"> Delete</i></b></button></a>
                                <?php } ?>

                            </td>
                        </tr>
                    <?php $i++;
                    } ?>
                </tbody>
            <?php } else { ?>
                <tr>
                    <td colspan="10" align="center"><span class="text-danger"><b>!! No Record Found !!</b></span></td>
                </tr>
            <?php } ?>
        </table>
        <?php echo $page_links; ?>
    </div>



</div>






<?php $this->load->view($this->config->item('theme_uri') . 'layout/footer_view'); ?>
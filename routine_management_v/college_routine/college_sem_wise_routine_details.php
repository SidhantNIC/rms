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
    <!-- Main content -->
    <div class="row" style="padding: 10px;">
        <?php echo form_open('admin/routine_management_c/college_routine/mis_of_rms/Sem_wise_routine_details'); ?>
        <div class="col-sm-5">
            <label>Name Of Discipline</label><span class="text-danger">*</span>
            <select class="form-control select2" name="discipline_name" id="discipline_name">
                <option value="">--Select Discipline Name--</option>
                <?php foreach ($discipline_name as $dn) { ?>
                    <option value="<?php echo $dn['course_id_pk']; ?>" <?php echo set_select('discipline_name', $dn['course_id_pk'], False); ?>>
                        <?php echo ($dn['course_name']); ?></option>
                <?php } ?>
            </select>
            <span class="text-danger"><?php echo form_error('discipline_name'); ?></span>
        </div>
        <div class="col-sm-5">
            <label>Academic Session</label><span class="text-danger">*</span>
            <select class="form-control select2" name="academic_session">
                <option value="">--Select Academic Session--</option>
                <?php foreach ($academic_session as $as) { ?>
                    <option value="<?php echo $as['academic_year_id_pk']; ?>" <?php echo set_select('academic_session', $as['academic_year_id_pk'], False); ?>>
                        <?php echo $as['academic_year_description']; ?></option>
                <?php } ?>
            </select>
            <span class="text-danger"><?php echo form_error('academic_session'); ?></span>
        </div>
        <div class="col-sm-2" style="margin-top:25px;">
            <button class="btn btn-warning btn-block"><i class="fa fa-search"></i> Search</button>
        </div>
        <?php echo form_close();  ?>

    </div>

    <div class="table-responsive" style="padding: 10px;">
        <table id="example1" class="table table-bordered table-striped custom_table">
            <thead>
                <tr align="center">
                    <th>#</th>
                    <th>Discipline</th>
                    <th>Sem-1</th>
                    <th>Sem-2</th>
                    <th>Sem-3</th>
                    <th>Sem-4</th>
                    <th>Sem-5</th>
                    <th>Sem-6</th>
                </tr>
            </thead>
            <?php if (@sizeof($semester_result) > 0) { ?>
                <tbody>
                    <?php $i = 1;
                    foreach (@$semester_result as $sr) { ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td style="font-size:12px;"><?php echo ($sr['course_name']); ?></td>
                            <td>
                                <?php if ($sr['status_code'] == '4' && $sr['semester1'] > 0) { ?>

                                    <a href="<?php echo base_url('admin/mis_of_routine/Routine_mis/getRoutinedetails'); ?>/<?php echo md5($sr['college_id_fk']) ?>/<?php echo md5($sr['discipline_id_fk']); ?>/<?php echo md5($sr['academic_year_fk']); ?>/1/<?php echo md5($sr['status_code']); ?>"><button class="btn btn-success btn-xs">Approved (<?php echo $sr['semester1']; ?>)</button></a>

                                <?php } else if ($sr['status_code'] == '3' && $sr['semester1'] > 0) { ?>
                                    <a href="<?php echo base_url('admin/mis_of_routine/Routine_mis/getRoutinedetails'); ?>/<?php echo md5($sr['college_id_fk']) ?>/<?php echo md5($sr['discipline_id_fk']); ?>/<?php echo md5($sr['academic_year_fk']); ?>/1/<?php echo md5($sr['status_code']); ?>"><button class="btn btn-danger btn-xs">Revert (<?php echo $sr['semester1']; ?>)</button></a>
                                <?php } else if ($sr['status_code'] == '2' && $sr['semester1'] > 0) { ?>

                                    <a href="<?php echo base_url('admin/mis_of_routine/Routine_mis/getRoutinedetails'); ?>/<?php echo md5($sr['college_id_fk']) ?>/<?php echo md5($sr['discipline_id_fk']); ?>/<?php echo md5($sr['academic_year_fk']); ?>/1/<?php echo md5($sr['status_code']); ?>"><button class="btn btn-warning btn-xs">Forwarded (<?php echo $sr['semester1']; ?>)</button></a>
                                <?php } else if ($sr['status_code'] == '1' && $sr['semester1'] > 0) {  ?>

                                    <a href="<?php echo base_url('admin/mis_of_routine/Routine_mis/getRoutinedetails'); ?>/<?php echo md5($sr['college_id_fk']) ?>/<?php echo md5($sr['discipline_id_fk']); ?>/<?php echo md5($sr['academic_year_fk']); ?>/1/<?php echo md5($sr['status_code']); ?>"><button class="btn btn-primary btn-xs">Cretated (<?php echo $sr['semester1']; ?>)</button></a>
                                <?php } else { ?>
                                    <button class="btn btn-info btn-xs" disabled>Not Created</button>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if ($sr['status_code'] == '4' && $sr['semester2'] > 0) { ?>
                                    <a href="<?php echo base_url('admin/mis_of_routine/Routine_mis/getRoutinedetails'); ?>/<?php echo md5($sr['college_id_fk']) ?>/<?php echo md5($sr['discipline_id_fk']); ?>/<?php echo md5($sr['academic_year_fk']); ?>/2/<?php echo md5($sr['status_code']); ?>"><button class="btn btn-success btn-xs">Approved (<?php echo $sr['semester2']; ?>)</button></a>
                                <?php } else if ($sr['status_code'] == '3' && $sr['semester2'] > 0) { ?>
                                    <a href="<?php echo base_url('admin/mis_of_routine/Routine_mis/getRoutinedetails'); ?>/<?php echo md5($sr['college_id_fk']) ?>/<?php echo md5($sr['discipline_id_fk']); ?>/<?php echo md5($sr['academic_year_fk']); ?>/2/<?php echo md5($sr['status_code']); ?>"><button class="btn btn-danger btn-xs">Revert (<?php echo $sr['semester2']; ?>)</button></a>
                                <?php } else if ($sr['status_code'] == '2' && $sr['semester2'] > 0) { ?>
                                    <a href="<?php echo base_url('admin/mis_of_routine/Routine_mis/getRoutinedetails'); ?>/<?php echo md5($sr['college_id_fk']) ?>/<?php echo md5($sr['discipline_id_fk']); ?>/<?php echo md5($sr['academic_year_fk']); ?>/2/<?php echo md5($sr['status_code']); ?>"><button class="btn btn-warning btn-xs">Forwarded (<?php echo $sr['semester2']; ?>)</button></a>
                                <?php } else if ($sr['status_code'] == '1' && $sr['semester2'] > 0) {  ?>
                                    <a href="<?php echo base_url('admin/mis_of_routine/Routine_mis/getRoutinedetails'); ?>/<?php echo md5($sr['college_id_fk']) ?>/<?php echo md5($sr['discipline_id_fk']); ?>/<?php echo md5($sr['academic_year_fk']); ?>/2/<?php echo md5($sr['status_code']); ?>"><button class="btn btn-primary btn-xs">Cretated (<?php echo $sr['semester2']; ?>)</button></a>
                                <?php } else { ?>
                                    <button class="btn btn-info btn-xs" disabled>Not Created</button>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if ($sr['status_code'] == '4' && $sr['semester3'] > 0) { ?>
                                    <a href="<?php echo base_url('admin/mis_of_routine/Routine_mis/getRoutinedetails'); ?>/<?php echo md5($sr['college_id_fk']) ?>/<?php echo md5($sr['discipline_id_fk']); ?>/<?php echo md5($sr['academic_year_fk']); ?>/3/<?php echo md5($sr['status_code']); ?>"><button class="btn btn-success btn-xs">Approved (<?php echo $sr['semester3']; ?>)</button></a>
                                <?php } else if ($sr['status_code'] == '3' && $sr['semester3'] > 0) { ?>
                                    <a href="<?php echo base_url('admin/mis_of_routine/Routine_mis/getRoutinedetails'); ?>/<?php echo md5($sr['college_id_fk']) ?>/<?php echo md5($sr['discipline_id_fk']); ?>/<?php echo md5($sr['academic_year_fk']); ?>/3/<?php echo md5($sr['status_code']); ?>"><button class="btn btn-danger btn-xs">Revert (<?php echo $sr['semester3']; ?>)</button></a>
                                <?php } else if ($sr['status_code'] == '2' && $sr['semester3'] > 0) { ?>
                                    <a href="<?php echo base_url('admin/mis_of_routine/Routine_mis/getRoutinedetails'); ?>/<?php echo md5($sr['college_id_fk']) ?>/<?php echo md5($sr['discipline_id_fk']); ?>/<?php echo md5($sr['academic_year_fk']); ?>/3/<?php echo md5($sr['status_code']); ?>"><button class="btn btn-warning btn-xs">Forwarded (<?php echo $sr['semester3']; ?>)</button></a>
                                <?php } else if ($sr['status_code'] == '1' && $sr['semester3'] > 0) {  ?>
                                    <a href="<?php echo base_url('admin/mis_of_routine/Routine_mis/getRoutinedetails'); ?>/<?php echo md5($sr['college_id_fk']) ?>/<?php echo md5($sr['discipline_id_fk']); ?>/<?php echo md5($sr['academic_year_fk']); ?>/3/<?php echo md5($sr['status_code']); ?>"><button class="btn btn-primary btn-xs">Cretated (<?php echo $sr['semester3']; ?>)</button></a>
                                <?php } else { ?>
                                    <button class="btn btn-info btn-xs" disabled>Not Created</button>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if ($sr['status_code'] == '4' && $sr['semester4'] > 0) { ?>
                                    <a href="<?php echo base_url('admin/mis_of_routine/Routine_mis/getRoutinedetails'); ?>/<?php echo md5($sr['college_id_fk']) ?>/<?php echo md5($sr['discipline_id_fk']); ?>/<?php echo md5($sr['academic_year_fk']); ?>/4/<?php echo md5($sr['status_code']); ?>"><button class="btn btn-success btn-xs">Approved (<?php echo $sr['semester4']; ?>)</button></a>
                                <?php } else if ($sr['status_code'] == '3' && $sr['semester4'] > 0) { ?>
                                    <a href="<?php echo base_url('admin/mis_of_routine/Routine_mis/getRoutinedetails'); ?>/<?php echo md5($sr['college_id_fk']) ?>/<?php echo md5($sr['discipline_id_fk']); ?>/<?php echo md5($sr['academic_year_fk']); ?>/4/<?php echo md5($sr['status_code']); ?>"><button class="btn btn-danger btn-xs">Revert (<?php echo $sr['semester4']; ?>)</button></a>
                                <?php } else if ($sr['status_code'] == '2' && $sr['semester4'] > 0) { ?>
                                    <a href="<?php echo base_url('admin/mis_of_routine/Routine_mis/getRoutinedetails'); ?>/<?php echo md5($sr['college_id_fk']) ?>/<?php echo md5($sr['discipline_id_fk']); ?>/<?php echo md5($sr['academic_year_fk']); ?>/4/<?php echo md5($sr['status_code']); ?>"><button class="btn btn-warning btn-xs">Forwarded (<?php echo $sr['semester4']; ?>)</button></a>
                                <?php } else if ($sr['status_code'] == '1' && $sr['semester4'] > 0) {  ?>
                                    <a href="<?php echo base_url('admin/mis_of_routine/Routine_mis/getRoutinedetails'); ?>/<?php echo md5($sr['college_id_fk']) ?>/<?php echo md5($sr['discipline_id_fk']); ?>/<?php echo md5($sr['academic_year_fk']); ?>/4/<?php echo md5($sr['status_code']); ?>"><button class="btn btn-primary btn-xs">Cretated (<?php echo $sr['semester4']; ?>)</button></a>
                                <?php } else { ?>
                                    <button class="btn btn-info btn-xs" disabled>Not Created</button>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if ($sr['status_code'] == '4' && $sr['semester5'] > 0) { ?>
                                    <a href="<?php echo base_url('admin/mis_of_routine/Routine_mis/getRoutinedetails'); ?>/<?php echo md5($sr['college_id_fk']) ?>/<?php echo md5($sr['discipline_id_fk']); ?>/<?php echo md5($sr['academic_year_fk']); ?>/5/<?php echo md5($sr['status_code']); ?>"><button class="btn btn-success btn-xs">Approved (<?php echo $sr['semester5']; ?>)</button></a>
                                <?php } else if ($sr['status_code'] == '3' && $sr['semester5'] > 0) { ?>
                                    <a href="<?php echo base_url('admin/mis_of_routine/Routine_mis/getRoutinedetails'); ?>/<?php echo md5($sr['college_id_fk']) ?>/<?php echo md5($sr['discipline_id_fk']); ?>/<?php echo md5($sr['academic_year_fk']); ?>/5/<?php echo md5($sr['status_code']); ?>"><button class="btn btn-danger btn-xs">Revert (<?php echo $sr['semester5']; ?>)</button></a>
                                <?php } else if ($sr['status_code'] == '2' && $sr['semester5'] > 0) { ?>
                                    <a href="<?php echo base_url('admin/mis_of_routine/Routine_mis/getRoutinedetails'); ?>/<?php echo md5($sr['college_id_fk']) ?>/<?php echo md5($sr['discipline_id_fk']); ?>/<?php echo md5($sr['academic_year_fk']); ?>/5/<?php echo md5($sr['status_code']); ?>"><button class="btn btn-warning btn-xs">Forwarded (<?php echo $sr['semester5']; ?>)</button></a>
                                <?php } else if ($sr['status_code'] == '1' && $sr['semester5'] > 0) {  ?>
                                    <a href="<?php echo base_url('admin/mis_of_routine/Routine_mis/getRoutinedetails'); ?>/<?php echo md5($sr['college_id_fk']) ?>/<?php echo md5($sr['discipline_id_fk']); ?>/<?php echo md5($sr['academic_year_fk']); ?>/5/<?php echo md5($sr['status_code']); ?>"><button class="btn btn-primary btn-xs">Cretated (<?php echo $sr['semester5']; ?>)</button></a>
                                <?php } else { ?>
                                    <button class="btn btn-info btn-xs" disabled>Not Created</button>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if ($sr['status_code'] == '4' && $sr['semester6'] > 0) { ?>
                                    <a href="<?php echo base_url('admin/mis_of_routine/Routine_mis/getRoutinedetails'); ?>/<?php echo md5($sr['college_id_fk']) ?>/<?php echo md5($sr['discipline_id_fk']); ?>/<?php echo md5($sr['academic_year_fk']); ?>/6/<?php echo md5($sr['status_code']); ?>"><button class="btn btn-success btn-xs">Approved (<?php echo $sr['semester6']; ?>)</button></a>
                                <?php } else if ($sr['status_code'] == '3' && $sr['semester6'] > 0) { ?>
                                    <a href="<?php echo base_url('admin/mis_of_routine/Routine_mis/getRoutinedetails'); ?>/<?php echo md5($sr['college_id_fk']) ?>/<?php echo md5($sr['discipline_id_fk']); ?>/<?php echo md5($sr['academic_year_fk']); ?>/6/<?php echo md5($sr['status_code']); ?>"><button class="btn btn-danger btn-xs">Revert (<?php echo $sr['semester6']; ?>)</button></a>
                                <?php } else if ($sr['status_code'] == '2' && $sr['semester6'] > 0) { ?>
                                    <a href="<?php echo base_url('admin/mis_of_routine/Routine_mis/getRoutinedetails'); ?>/<?php echo md5($sr['college_id_fk']) ?>/<?php echo md5($sr['discipline_id_fk']); ?>/<?php echo md5($sr['academic_year_fk']); ?>/6/<?php echo md5($sr['status_code']); ?>"><button class="btn btn-warning btn-xs">Forwarded (<?php echo $sr['semester6']; ?>)</button></a>
                                <?php } else if ($sr['status_code'] == '1' && $sr['semester6'] > 0) {  ?>
                                    <a href="<?php echo base_url('admin/mis_of_routine/Routine_mis/getRoutinedetails'); ?>/<?php echo md5($sr['college_id_fk']) ?>/<?php echo md5($sr['discipline_id_fk']); ?>/<?php echo md5($sr['academic_year_fk']); ?>/6/<?php echo md5($sr['status_code']); ?>"><button class="btn btn-primary btn-xs">Cretated (<?php echo $sr['semester6']; ?>)</button></a>
                                <?php } else { ?>
                                    <button class="btn btn-info btn-xs" disabled>Not Created</button>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php $i++;
                    }  ?>
                </tbody>
            <?php } else { ?>
                <tbody>
                    <tr>
                        <td colspan="9">
                            <b class="text-danger">
                                <center>!!! No Routine Found, Please Select Another Options !!!</center>
                            </b>
                        </td>
                    </tr>
                </tbody>
            <?php } ?>
        </table>
    </div>
</div>
<?php $this->load->view($this->config->item('theme_uri') . 'layout/footer_view'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        $(".select2").select2();
        $("#poly_name").on("change", function() {
            var poly_id = $("#poly_name").val();
            $.ajax({
                url: "mis_of_routine/Routine_mis/displyPolywisedisciplinenamesemwisereport",
                data: {
                    poly_id: poly_id
                },
                method: "GET",
                success: function(response) {
                    $("#discipline_name").html(response);
                }
            });
        });

    });
</script>
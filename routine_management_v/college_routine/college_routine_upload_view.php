<?php $this->load->view($this->config->item('theme_uri').'layout/header_view'); ?>
<?php $this->load->view($this->config->item('theme_uri').'layout/left_menu_view'); ?>
<!-- Content Wrapper. Contains page content -->
<style type="text/css">
.tablebody {
    padding: 0 30px;
}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Routine Management System v1.0
        </h1>
        <ol class="breadcrumb">
            <li><a href="dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <!--        <li class="active">Publications</li>-->
            <li class="active">Uploade Routine</li>
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
    <?php echo form_open_multipart('admin/routine_management_c/college_routine/College_download_routine/uploadRoutine'); ?>
    <div class="row" style="padding: 5px;">
        <div class="col-sm-4">
            <label>Academic Session</label><span class="text-danger">*</span>
            <select class="form-control" name="academic_year" id="academic_year">
                <option value="">--Select Academic Session--</option>
                <?php foreach($all_academic_year as $all_academic_year) { ?>
                <option value="<?php echo $all_academic_year['academic_year_id_pk']?>"
                    <?php echo set_select('academic_year', $all_academic_year['academic_year_id_pk'], False); ?>>
                    <?php echo $all_academic_year['academic_year_description']?>
                </option>
                <?php } ?>
            </select>
            <span class="text-danger"><?php echo form_error('academic_year'); ?></span>
        </div>
        <div class="col-sm-4">
            <label>Discipline</label><span class="text-danger">*</span>
            <select class="form-control" name="discipline_type" id="discipline_type">
                <option value="">--Select Discipline --</option>
                <?php foreach($discipline as $discipline) { ?>
                <option value="<?php echo $discipline['course_id_pk'] ?>"
                    <?php echo set_select('discipline_type', $discipline['course_id_pk'], False); ?>>
                    <?php echo $discipline['course_name']?>
                </option>
                <?php } ?>
            </select>
            <span class="text-danger"><?php echo form_error('discipline_type'); ?></span>
        </div>
        <div class="col-sm-4">
            <label>Year</label><span class="text-danger">*</span>
            <select class="form-control" name="stud_year" id="stud_year">
                <option value="">--Select Year --</option>
                <?php foreach($year as $year) { ?>
                <option value="<?php echo $year['id'] ?>" <?php echo set_select('stud_year', $year['id'], False); ?>>
                    <?php echo $year['description']?>
                </option>
                <?php } ?>
            </select>
            <span class="text-danger"><?php echo form_error('stud_year'); ?></span>
        </div>
        <div class="col-sm-4">
            <label>Semester</label><span class="text-danger">*</span>
            <select class="form-control" name="semester" id="semester">
                <option value="">--Select Semester --</option>
                <?php foreach($semester as $semester) { ?>
                <option value="<?php echo $semester['id'] ?>"
                    <?php echo set_select('semester', $semester['id'], False); ?>><?php echo $semester['description']?>
                </option>
                <?php } ?>
            </select>
            <span class="text-danger"><?php echo form_error('semester'); ?></span>
        </div>
        <div class="col-sm-4">
            <label>Routine Mode</label><span class="text-danger">*</span>
            <select class="form-control" name="routine_mode" id="routine_mode">
                <option value="">--Select Routine Mode--</option>
                <option value="1"  <?php echo set_select('routine_mode','1', False); ?>>Offline</option>
                <option value="2" <?php echo set_select('routine_mode','2', False); ?>>Offline/Online</option>
            </select>
            <span class="text-danger"><?php echo form_error('routine_mode'); ?></span>
        </div>
        <div class="col-sm-4">
        <label>Upload Routine</label><span class="text-danger">*</span>
            <input type="file" name="routine_pdf" class="form-control">
            <span class="text-danger"><?php echo form_error('routine_pdf'); ?></span>
        </div>
    </div>
    <center><button type="submit" class="btn btn-success"> <i class="fa fa-upload"></i> Upload Routine</button></center>
    <?php echo form_close(); ?>
   
    <div class="table-responsive" style="padding: 10px;">
        <table id="example1" class="table table-bordered table-hover custom_table">
            <thead>
                <tr align="center">

                    <th>#</th>
                    <th>Academic Session</th>
                    <th>Discipline</th>
                    <th>Year</th>
                    <th>Semester</th>
                    <th>Routine Mode</th>
                    <th>Routine</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1; foreach($rouitne_download_details as $value){ ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $value['academic_year_description']; ?></td>
                        <td><?php echo $value['course_name']; ?></td>
                        <td><?php echo $value['year']; ?></td>
                        <td><?php echo $value['description']; ?></td>
                        <td><?php echo $value['routine_mode'] =='1'? "Offline":"Online / Offline"; ?></td>
                        <td><span class="text-danger">Download</span></td>
                        <td>
                            <?php if($value['active_status']=='1') { ?>
                                <a href="admin/routine_management_c/college_routine/College_download_routine/uploadRoutine/1"><button class="btn btn-warning">Active</button></a>
                            <?php }else{ ?>
                                <button class="btn btn-danger">Inactive</button>
                            <?php } ?>
                        </td>
                        
                   </tr>
                <?php }?>
            
            </tbody>
        </table>
 
</div>
</div>
<?php $this->load->view($this->config->item('theme_uri').'layout/footer_view'); ?>
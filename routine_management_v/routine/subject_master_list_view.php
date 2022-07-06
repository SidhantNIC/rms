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
 <?php echo form_open('admin/routine_management_c/routine/Subject_master/Subject_list'); ?>
    <div class="row" style="padding: 5px;">
        <div class="col-sm-4">
            <label>Discipline Name</label>
             <select class="form-control select2" name="course_name" id="course_name">
                            <option value="">--Please Select Discipline --</option>
                            <?php foreach($discipline as $discipline) { ?>
                            <option  value="<?php echo $discipline['course_id_pk']?>"
                                <?php echo set_select('course_name', $discipline['course_id_pk'],False); ?>>
                            <?php echo $discipline['course_name']?></option>
                         <?php } ?>
                        </select>
            <span class="text-danger"><?php echo form_error('course_name'); ?></span>
        </div>
        <div class="col-sm-4">
            <label>Semester</label>
                 <select class="form-control select2" name="semester" id="semester">
                            <option value="">--Please Select Discipline --</option>
                            <?php foreach($semester as $semester) { ?>
                            <option  value="<?php echo $semester['id']?>"
                                <?php echo set_select('semester', $semester['id'],False); ?>>
                            <?php echo $semester['description']?></option>
                         <?php } ?>
                        </select>
            <span class="text-danger"><?php echo form_error('semester'); ?></span>
        </div>
        <div class="col-sm-3">
            <label>Subject Type</label>
            <select class="form-control select2" name="subject_type" id="subject_type">
                            <option value="">--Select Subject Type--</option>
                            <option value="1" <?php echo set_select('subject_type',1,False); ?>>Theory</option>
                            <option value="2" <?php echo set_select('subject_type',2,False); ?>>Practical</option>
							<option value="5" <?php echo set_select('subject_type',5,False); ?>>Tutorial</option>
                        </select>
            <span class="text-danger"><?php echo form_error('subject_type'); ?></span>
        </div>
		<div class="col-sm-1">
			<button class="btn btn-success" style="margin-top:23px;"> <i class="fa fa-search"></i> Search</button>
		</div>
    </div>
   
        <?php echo form_close(); ?>
    

    <div class="table-responsive" style="padding: 10px;">
        <?php if($this->input->post()) { ?>
        <table id="example1" class="table table-bordered table-striped custom_table">
            <thead>
                <tr>
                    <th>#</th>
                    <th align="center">Subject Code</th>
                    <th align="center">Subject Name</th>
                    <th align="center">Action</th>
                </tr>
            </thead>
             <tbody>
                <?php $i=1; foreach ($subject_details as $sd) { ?>
                   <tr align="center">
                    <td><?php echo $i; ?></td>
                    <td><?php echo $sd['subject_description']; ?></td>
                    <td><?php echo $sd['subject_code']; ?></td>
                    <td>
                        <a href="javascript:void(0)" rel="<?php echo md5($sd['discipline_id_pk']); ?>"
                            class="btn btn-warning revart_back_result btn-xs"
                            id="result_revert_btn_<?php echo md5($sd['discipline_id_pk']); ?>"
                            type="button"> <b><i class="fa fa-edit"></i> Edit </b></a>
							
							<a href="routine_management_c/routine/Subject_master/deleteSubject/<?php echo md5($sd['discipline_id_pk']); ?>" class="btn btn-danger btn-xs"><b><i class="fa fa-trash"></i> Delete</b></a>
                    </td>
                   </tr>
               <?php $i++; } ?>
            </tbody>
        </table>
    <?php } ?>
    </div>
</div>
<?php $this->load->view($this->config->item('theme_uri').'layout/footer_view'); ?>
<!---------------------------- Modal for Revart Back Result to SSC ----------------------->
<div id="myResultback" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title modal_title"><b>Edit Subject Name</b></h4>
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
<script type="text/javascript">
    $(".close_btn").click(function(){
        window.location='routine_management_c/routine/Subject_master/Subject_list';
    });
	
	$(".select2").select2();
</script>
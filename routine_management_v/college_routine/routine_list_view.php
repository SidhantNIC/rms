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
    <?php echo form_open('admin/routine_management_c/college_routine/College_routine_list'); ?>
    <div class="row" style="padding: 5px;">
        <!-- <div class="col-sm-4">
      <label>Date</label>
      <div class="input-group date" data-provide="datepicker" raedonly>
                  <input type="text" class="form-control" name="date" placeholder="Please Select Date" readonly="" value="<?php echo $this->input->post('date'); ?>">
                  <div class="input-group-addon">
                      <span class="glyphicon glyphicon-calendar"></span>
                  </div>
              </div>
    </div> -->
		<div class="col-sm-3">
		<label>Academic Year</label>
			<select class="form-control" name="academic_session" id="academic_session">
				<option value="">--Select Academic Session--</option>
				<?php foreach($academic_year_data as $ayd) { ?>
					<option value="<?php echo $ayd['academic_year_id_pk']?>" <?php echo set_select('academic_session',$ayd['academic_year_id_pk'])?>>
                    <?php echo $ayd['academic_year_description']?></option>
				<?php } ?>
			</select>
		</div>
        <div class="col-sm-3">
            <label>Days</label>
            <select class="form-control" name="days_name" id="days_name">
                <option value="">--Please Select Days--</option>
                <?php foreach($all_days as $all_days) { ?>
                <option value="<?php echo $all_days['id']?>" <?php echo set_select('days_name',$all_days['id'])?>>
                    <?php echo $all_days['description']?></option>
                <?php } ?>
            </select>
            <span class="text-danger"><?php echo form_error('days_name'); ?></span>
        </div>
	
        <div class="col-sm-3">
            <label>Stream / Discipline</label>
            <select class="form-control" name="discipline_type" id="discipline_type">
                <option value="">--Please Select Discipline Type --</option>
                <?php foreach($discipline as $discipline) { ?>
                <option value="<?php echo $discipline['course_id_pk']?>"
                    <?php echo set_select('discipline_type',$discipline['course_id_pk'])?>>
                    <?php echo $discipline['course_name']?></option>
                <?php } ?>
            </select>
            <span class="text-danger"><?php echo form_error('discipline_type'); ?></span>
        </div>
        <div class="col-sm-3">
            <label>Year</label>
            <select class="form-control" name="stud_year" id="stud_year">
                <option value="">--Please Select Year --</option>
                <?php foreach($year as $year) { ?>
                <option value="<?php echo $year['id']?>" <?php echo set_select('stud_year',$year['id'])?>>
                    <?php echo $year['description']?></option>
                <?php } ?>
            </select>
            <span class="text-danger"><?php echo form_error('stud_year'); ?></span>
        </div>
        <div class="col-sm-3">
            <label>Semester</label>
            <select class="form-control" name="semester" id="semester">
                <option value="">--Please Select Semester --</option>
                <?php foreach($semester as $semester) { ?>
                <option value="<?php echo $semester['id']?>" <?php echo set_select('semester',$semester['id'])?>>
                    <?php echo $semester['description']?></option>
                <?php } ?>
            </select>
            <span class="text-danger"><?php echo form_error('semester'); ?></span>
        </div>
        <div class="col-sm-2">
            <label>Teacher / Faculty Name</label>
            <select class="form-control" name="emp_id" id="emp_id">
                <option value="">--Please Select Teacher / Faculty Name --</option>
                <?php foreach($all_emp as $emp){?>
                <option value="<?php echo $emp['emp_basic_id_pk'];?>"
                    <?php echo set_select('emp_id',$emp['emp_basic_id_pk']);?>
                    <?php echo set_select('emp_id', $emp['emp_basic_id_pk'], False); ?>>
                    <?php  echo $emp['first_name'];?> <?php  echo $emp['midle_name'];?> <?php  echo $emp['last_name'];?>
                </option>
                <?php } ?>
            </select>
        </div>
        <div class="col-sm-2">
            <label>Period No</label>
            <select class="form-control" name="period_no" id="period_no">
                <option value="">--Please Select Period No --</option>
                <?php foreach($period_no as $period_no) { ?>
                <option value="<?php echo $period_no['id']?>" <?php echo set_select('period_no',$period_no['id'])?>>
                    <?php echo $period_no['description']?></option>
                <?php } ?>
            </select>
            <span class="text-danger"><?php echo form_error('semester'); ?></span>
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
		<button class="btn btn-warning btn-block" style="margin-top:23px;"><b><i class="fa fa-search"> Search</i></b></button>
		</div>
    </div>
    <br>
   
    <?php echo form_close(); ?>
    <br>



    <?php echo form_open('admin/routine_management_c/college_routine/College_routine_list/checkBoxsubmit'); ?>

    <button class="btn btn-success" onclick="return confirm('Do you want to approve this routines?');"
        style="position: relative;left: 10px;">Approve All</button>

    <div class="table-responsive" style="padding: 10px;">
        <table id="example1" class="table table-bordered table-hover custom_table">
            <thead class="bg-primary">
                <tr align="center">
                    <th>All <input type="checkbox" name="" id="checkAll" class="checkbox"></th>
                    <th>#</th>
                    <th>Routine Id</th>
                    <th>Days</th>
                    <th>Stream / Disciple</th>
                    <th>Year</th>
                    <th>Section</th>
                    <th>Semester</th>
                    <th>Period No</th>
                    <th>Staus</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                <?php $i=1; foreach($all_emp_list as $all_emp_list) {?>
                <tr align="center">

                    <td>
                        <?php if($all_emp_list['status_code']=='4' || $all_emp_list['status_code']=='1' ||$all_emp_list['status_code']=='3') { ?>

                        <?php }else{ ?>
                        <input type="checkbox" name="routine_id[]"
                            value="<?php echo $all_emp_list['routine_manage_id_pk']; ?>">
                        <?php } ?>
                    </td>
                    <td><?php echo $offset+$i.'.'; ?></td>
                    <td><?php echo $all_emp_list['routine_unique_id']; ?></td>
                    <td><?php echo $all_emp_list['days_desc']; ?></td>
                    <td><?php echo $all_emp_list['course_name']; ?></td>
                    <td><?php echo $all_emp_list['year_desc']; ?></td>
                    <td><?php echo $all_emp_list['sectiondata']; ?></td>
                    <td><?php echo $all_emp_list['sem_desc']; ?></td>
                    <td><?php echo $all_emp_list['period_no_desc']; ?></td>
                    <td>
                        <?php if($all_emp_list['status_code']  == '3'){?>
                        <button class="btn btn-danger btn-xs"
                            disabled><?php echo $all_emp_list['process_description']; ?></button>
                        <?php }else if($all_emp_list['status_code']  == '4'){ ?>
                        <button class="btn btn-success btn-xs"
                            disabled><?php echo $all_emp_list['process_description']; ?></button>
                        <?php }else{ ?>
                        <button class="btn btn-warning btn-xs"
                            disabled><?php echo $all_emp_list['process_description']; ?></button>
                        <?php } ?>
                    </td>
                    <td>
                        <?php if($all_emp_list['status_code'] =='1' || $all_emp_list['status_code'] =='3' || $all_emp_list['status_code'] =='4') { ?>
                        <a
                            href="<?php echo base_url('admin/routine_management_c/college_routine/College_routine_list/viewRoutinedetails')?>/<?php echo md5($all_emp_list['routine_manage_id_pk']);?>"><button
                                class="btn btn-warning btn-xs" type="button"><b><i class="fa fa-eye"></i> View</b></button></a>
                        <?php } ?>
                        <?php if($all_emp_list['status_code'] =='2') { ?>
                        <a
                            href="<?php echo base_url('admin/routine_management_c/college_routine/College_routine_list/viewRoutinedetails')?>/<?php echo md5($all_emp_list['routine_manage_id_pk']);?>"><button
                                class="btn btn-warning btn-xs" type="button"><b><i class="fa fa-eye"></i> View</b></button></a>
                        <a href="<?php echo base_url('admin/routine_management_c/college_routine/College_routine_list/approveRoutinelists')?>/<?php echo md5($all_emp_list['routine_manage_id_pk']);?>"
                            onclick="return confirm('Do you want to approve this routine?');"><button
                                class="btn btn-success btn-xs" type="button"><b><i class="fa fa-check"></i> Approve</b></button></a>
                        <a href="javascript:void(0)" rel="<?php echo md5($all_emp_list['routine_manage_id_pk']); ?>"
                            class="btn btn-danger btn-xs revart_back_result"
                            id="result_revert_btn_<?php echo md5($all_emp_list['routine_manage_id_pk']); ?>"
                            type="button"><b><i class="fa fa-reply"></i> Revert</b></a>
                        <?php } ?>
						<?php if($all_emp_list['status_code'] == '4'){?>     
                            <a href="<?php echo base_url('admin/routine_management_c/college_routine/College_routine_list/editRoutine')?>/<?php echo md5($all_emp_list['routine_manage_id_pk']);?>"><button
                                class="btn btn-primary btn-xs" type="button"><b><i class="fa fa-edit"></i> Edit</b></button></a>
                        <?php } ?>
                    </td>
                </tr>
                <?php $i++ ;} ?>
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
<script type="text/javascript">

</script>

<script type="text/javascript">
$(".close_btn").click(function() {
    window.location.href = 'routine_management_c/college_routine/College_routine_list';
});

$("#checkAll").click(function() {
    $('input:checkbox').not(this).prop('checked', this.checked);
});
</script>
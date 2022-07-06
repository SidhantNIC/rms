<?php $this->load->view($this->config->item('theme_uri').'layout/header_view'); ?>
<?php $this->load->view($this->config->item('theme_uri').'layout/left_menu_view'); ?>
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script> -->
<style>
  #note_div{
  color: #F00;
  font-size: 12px;
  }
</style>
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
      <li class="active">Routine Create</li>
    </ol>
  </section>
  <!-- Main content -->
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
  <section class="content">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Add Subject</h3>
      </div>
      <?php echo form_open('admin/routine_management_c/routine/Subject_master'); ?>
      <!--...........Form Start...........-->
      <br>
      <div class="row" style="padding: 5px;">
        <div class="col-sm-4">
          <label>Discipline</label><span class="text-danger">*</span>
          <select class="form-control select2" name="course_name" id="course_name">
            <option value="">--Please Select Discipline --</option>
            <?php foreach($discipline as $discipline) { ?>
			<option  value="<?php echo $discipline['course_id_pk']; ?>"
				<?php echo set_select('course_name', $discipline['course_id_pk'],false); ?>>
			<?php echo $discipline['course_name']; ?></option>
            <?php } ?>
          </select>
          <span class="text-danger"><?php echo form_error('course_name'); ?></span>
        </div>
        <div class="col-sm-4">
          <label>Semester</label><span class="text-danger">*</span>
          <select class="form-control" name="semester" id="semester">
            <option value="">--Please Select Semester --</option>
            <?php foreach($semester as $semester) { ?>
            <option  value="<?php echo $semester['id']?>"
              <?php echo set_select('semester', $semester['id'],False); ?>>
              <?php echo $semester['description']?>
            </option>
            <?php } ?>
          </select>
          <span class="text-danger"><?php echo form_error('semester'); ?></span>
        </div>
        <div class="col-sm-4">
          <label>Subject Type</label><span class="text-danger">*</span>
          <select class="form-control" name="subject_type" id="subject_type">
            <option value="">--Select Subject Type--</option>
            <option value="1" <?php echo set_select('subject_type',1,False); ?>>Theory</option>
            <option value="2" <?php echo set_select('subject_type',2,False); ?>>Practical</option>
			<option value="5" <?php echo set_select('subject_type',5,False); ?>>Tutorial</option>
          </select>
          <span class="text-danger"><?php echo form_error('subject_type'); ?></span>
        </div>
        <div class="col-sm-4">
          <label>Subject Code</label><span class="text-danger">*</span>
          <input type="text" name="subject_code" placeholder="Please Enter Subject Code" autocomplete="off" class="form-control" value="<?php echo $last_subject_code[0]['subject_code'] + 1; ?>" readonly>
          <span class="text-danger"><?php echo form_error('subject_code'); ?></span>
        </div>
        <div class="col-sm-4">
          <label>Subject Name</label><span class="text-danger">*</span>
          <input type="text" name="subject_name" placeholder="Please Enter Subject Name" autocomplete="off" class="form-control" value="<?php echo set_value('subject_name'); ?>">
          <span class="text-danger"><?php echo form_error('subject_name'); ?></span>
        </div>
      </div>
      <br>
    </div>
    <br>
    <center><button class="btn btn-success addDtata" type="submit">Submit</button></center>
    <br>
    <?php echo form_close(); ?>
    <!--...........Form End.............-->
</div>
</section>
</div>
<script>
  $( document ).ready(function() {
	  $(".select2").select2();
    $('#datepicker').datepicker();
  });
</script>
<?php $this->load->view($this->config->item('theme_uri').'layout/footer_view'); ?>
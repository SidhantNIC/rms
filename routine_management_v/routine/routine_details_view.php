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
        <li class="active">Routine </li>
        <li class="active">Routine  Details</li>
      </ol>
    </section>

    <!-- Main content -->
	    <section class="content">		
			<div class="box box-primary">
		        <div class="box-header with-border">
		          <h3 class="box-title">Routine  Details</h3>
		        </div>
		        <!-- /.box-header -->
		        
		        <!-- Alert area start -->
		        <?php if(isset($alert)){ ?>
	            	<?php if($success == '1'){ $class = 'alert-success'; $_POST = array(); } else{ $class = 'alert-warning'; }?>
	                <div class="col-md-12">
		                <div class="alert <?php echo $class; ?>">
		                    <span><b><?php print_r($alert); ?></b></span>
		                </div>
	                </div>
            	<?php } ?>	
		        <!-- Alert area end -->
		        
		        <!-- form start -->
		       <?php //print_r($_POST) ?>
		       <?php ///echo $this->input->post('notice_title'); ?>
		        <?php //echo form_open_multipart('admin/college_downloads/upload_document','autocomplete="off"'); ?>
		        <div class="box-body">
		        	<h4 class="box-title">Routine Details</h4>
		        	<div class="col-md-12">
	               		<div class="col-md-3">
		            		<div class="form-group">
		              			<label for="upload_title">Employee Name</label>		              			
		              		</div>
		            	</div>
		            	<div class="col-md-3">
		            		<div class="form-group">
		              			<?php echo $routine_details[0]['first_name'] ?> <?php echo $routine_details[0]['midle_name'] ?> <?php echo $routine_details[0]['last_name'] ?>
		            		</div>
		            	</div>

		            	<div class="col-md-3">
		            		<div class="form-group">
		              			<label for="upload_title">Day</label>		              			
		              		</div>
		            	</div>
		            	<div class="col-md-3">
		            		<div class="form-group">
		              			<?php echo $routine_details[0]['days_name'] ?> 
		            		</div>
		            	</div>                    	
		            </div>

		            <div class="col-md-12">
	               		<div class="col-md-3">
		            		<div class="form-group">
		              			<label>Class</label>		              			
		              		</div>
		            	</div>
		            	<div class="col-md-3">
		            		<div class="form-group">
		              			<?php echo $routine_details[0]['class_name'] ?>
		            		</div>
		            	</div>

		            	<div class="col-md-3">
		            		<div class="form-group">
		              			<label>Period No</label>		              			
		              		</div>
		            	</div>
		            	<div class="col-md-3">
		            		<div class="form-group">
		              			<?php echo $routine_details[0]['period_no'] ?> 
		            		</div>
		            	</div>                    	
		            </div>


		            <div class="col-md-12">
	               		<div class="col-md-3">
		            		<div class="form-group">
		              			<label>Period Start Time</label>		              			
		              		</div>
		            	</div>
		            	<div class="col-md-3">
		            		<div class="form-group">
		              			<?php echo $routine_details[0]['period_start_time'] ?>
		            		</div>
		            	</div>

		            	<div class="col-md-3">
		            		<div class="form-group">
		              			<label>Period End Time</label>		              			
		              		</div>
		            	</div>
		            	<div class="col-md-3">
		            		<div class="form-group">
		              			<?php echo $routine_details[0]['period_end_time'] ?> 
		            		</div>
		            	</div>                    	
		            </div>

		            <div class="col-md-12">
	               		<div class="col-md-3">
		            		<div class="form-group">
		              			<label>Period Type</label>		              			
		              		</div>
		            	</div>
		            	<div class="col-md-3">
		            		<div class="form-group">
		              			<?php echo $routine_details[0]['period_type'] ?>
		            		</div>
		            	</div>

		            	<div class="col-md-3">
		            		<div class="form-group">
		              			<label>Year</label>		              			
		              		</div>
		            	</div>
		            	<div class="col-md-3">
		            		<div class="form-group">
		              			<?php echo $routine_details[0]['stud_year'] ?> 
		            		</div>
		            	</div>                    	
		            </div>


		            <div class="col-md-12">
	               		<div class="col-md-3">
		            		<div class="form-group">
		              			<label>Semester</label>		              			
		              		</div>
		            	</div>
		            	<div class="col-md-3">
		            		<div class="form-group">
		              			<?php echo $routine_details[0]['semester'] ?>
		            		</div>
		            	</div>

		            	<div class="col-md-3">
		            		<div class="form-group">
		              			<label>Subject Name</label>		              			
		              		</div>
		            	</div>
		            	<div class="col-md-3">
		            		<div class="form-group">
		              			<?php echo $routine_details[0]['subj_name'] ?> 
		            		</div>
		            	</div>     
						<div class="col-md-3">
		            		<div class="form-group">
		              			<label>Section Name</label>		              			
		              		</div>
		            	</div>
		            	<div class="col-md-3">
		            		<div class="form-group">
		              			<?php echo $routine_details[0]['section_name'] ?> 
		            		</div>
		            	</div>      						
		            </div>



		          

		            
		            
                    <div></div>
		          </div>



		          <!-- /.box-body -->
		      	
                
<!--		        </form>-->
		      </div>
	    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php $this->load->view($this->config->item('theme_uri').'layout/footer_view'); ?>
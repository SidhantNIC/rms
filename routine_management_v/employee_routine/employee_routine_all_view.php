<?php $this->load->view($this->config->item('theme_uri').'layout/header_view'); ?>
<?php $this->load->view($this->config->item('theme_uri').'layout/left_menu_view'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Routine List
      </h1>
      <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i> Routine</a></li>
<!--        <li class="active">Publications</li>-->
        <li class="active">List of routine</li>
      </ol>
    </section>
    <br>
    <?php if($msg = $this->session->userdata('success')){ ?>
            <div class="alert alert-dismissible alert-success">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong><?php echo $msg; ?></strong> 
            </div>
            <?php } ?>

            <?php if($msg = $this->session->userdata('error')){ ?>
            <div class="alert alert-dismissible alert-danger">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong><?php echo $msg; ?></strong> 
            </div>
            <?php } ?>
    <!-- Main content Start-->
    <section class="content">   
      <div class="box box-primary">
        <div class="box-header with-border">
              <h3 class="box-title"> <a href="<?php echo base_url('admin/routine_management_c/employee_routine/Employee_routine_list/'); ?>" class="btn btn-primary btn-xs activate">Back</a><!-- Employee Profile --></h3>
              <h3 class="box-title"></h3>
            </div>
            <div class="table-responsive">          
                  <table class="table table-bordered table-hover custom_table">
                    <tr>
                      <th colspan="4">Routine Details</th>
                    </tr>
                    <tr>
                        <td nowrap style="font-weight: bold; width: 25%;">Routine Id</td>
                       <td><?php echo $routine[0]['routine_unique_id']; ?></td>
                        <td nowrap style="font-weight: bold; width: 25%;">Academic Session</td>
                        <td><?php echo $routine[0]['academic_year_description'];?></td>
                      </tr>
                     <tr>
                        <td nowrap style="font-weight: bold; width: 25%;">Teacher / Faculty Name</td>
                       <td><?php echo $routine[0]['first_name']. $routine[0]['midle_name']. $routine[0]['last_name'] ?></td>
                        <td nowrap style="font-weight: bold; width: 25%;">Days</td>
                        <td><?php echo $routine[0]['days_desc']; ?></td>
                      </tr>
                                           <tr>
                        <td nowrap style="font-weight: bold; width: 25%;">Period No</td>
                        <td><?php echo $routine[0]['period_no_desc']; ?></td>
                        <td nowrap style="font-weight: bold; width: 25%;" >Period Start Time</td>
                        <td><?php echo $routine[0]['period_start_time']; ?></td>
                      </tr>
                                           <tr>
                        <td nowrap style="font-weight: bold; width: 25%;">Period End Time</td>
                        <td><?php echo $routine[0]['period_end_time']; ?></td>
                        <td nowrap style="font-weight: bold; width: 25%;">Period Type</td>
                        <td><?php echo $routine[0]['period_type_desc']; ?></td>
                      </tr>
                                           <tr>
                        <td nowrap style="font-weight: bold; width: 25%;">Room No</td>
                        <td><?php echo $routine[0]['room_no']; ?></td>
                        <td nowrap style="font-weight: bold; width: 25%;">Discipline Type</td>
                        <td><?php echo $routine[0]['course_name']; ?></td>
                      </tr>
                        <tr>
                        <td nowrap style="font-weight: bold; width: 25%;">Year</td>
                        <td><?php echo $routine[0]['year_desc']; ?></td>
                        <td nowrap style="font-weight: bold; width: 25%;">Semester</td>
                        <td><?php echo $routine[0]['sem_desc']; ?></td>
                      </tr>
                      <tr>
                        <td nowrap style="font-weight: bold; width: 25%;">Subject</td>
                        <td>

                          <?php echo $routine[0]['subject_desc']; ?>
                            
                          <?php foreach($practical_sub as $ps) { ?>
                            <?php echo get_practical_subeject_name($ps['subject_id']).', '; ?>
                          <?php } ?>
                          </td>
                      </tr>
                     

                  </table>
                </div>
                <br>
                
    </section>
    <!-- Main content End -->
  	 
  </div>
 



       
        


<?php $this->load->view($this->config->item('theme_uri').'layout/footer_view'); ?>  
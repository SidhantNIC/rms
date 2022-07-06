<?php $this->load->view($this->config->item('theme_uri').'layout/header_view'); ?>
<?php $this->load->view($this->config->item('theme_uri').'layout/left_menu_view'); ?>

<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker3.min.css" > -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">
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
        <?php echo form_open('admin/routine_management_c/employee_routine/Employee_routine_list'); ?>
        <div class="row">

            <div class="col-sm-4">
                <label>Days</label>
                <select class="form-control" name="days_name" id="days_name">
                    <option value="">--Please Select Days--</option>
                    <?php foreach($all_days as $all_days) { ?>
                    <option value="<?php echo $all_days['id']?>" <?php echo set_select('days_name',$all_days['id'])?>>
                        <?php echo $all_days['description']?></option> <?php } ?>
                </select>
                <span class="text-danger"><?php echo form_error('days_name'); ?></span>
            </div>
            <div class="col-sm-4">
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
            <div class="col-sm-4">
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
            <div class="col-sm-4">
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

            <!-- <div class="col-sm-4">
    <label>Period</label>
    <select class="form-control" name="period_no" id="period_no">
                            <option value="">--Please Select Period No --</option>
                            <?php foreach($period_no as $period_no) { ?>
                            <option value="<?php echo $period_no['id']?>"><?php echo $period_no['description']?></option>
                         <?php } ?>
                        </select>
                        <span class="text-danger"><?php echo form_error('period_no'); ?></span>
  </div> -->
        </div>
        <br>
        <center><button class="btn btn-success">Search</button></center>
        <?php echo form_close(); ?>

        <div class="table-responsive" style="padding: 10px;">
            <table id="example1" class="table table-bordered table-hover custom_table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Routine Id</th>
                        <th>Days</th>
                        <th>Stream / Discipline</th>
                        <th>Year</th>
                        <th>Semester</th>
                        <th>Period</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; foreach($emp_details_view as $emp_details_view){  ?>
                    <tr>
                        <td><?php echo $offset + $i; ?></td>
                        <td><?php echo $emp_details_view['routine_unique_id'];  ?></td>
                        <td><?php echo $emp_details_view['days_desc'];  ?></td>
                        <td><?php echo $emp_details_view['course_name'];  ?></td>
                        <td><?php echo $emp_details_view['year_desc'];  ?></td>
                        <td><?php echo $emp_details_view['sem_desc'];  ?></td>

                        <td><?php echo $emp_details_view['period_type_desc'];  ?></td>


                        <td>

                           

                             <a href="<?php echo base_url('admin/routine_management_c/employee_routine/Employee_routine_list/viewAllroutine')?>/<?php echo md5($emp_details_view['routine_manage_id_pk']);?>"><button
                                class="btn btn-warning">View</button></a>


                            <?php if($emp_details_view['status_code'] == '4') {?>
                            <button class="btn btn-success"
                                onclick="showExecution(<?php echo $emp_details_view['routine_manage_id_pk'] ?> );">Class
                                Execution</button>
                            <?php } ?>

                        </td>
                    </tr>
                    <?php $i++; }  ?>
                </tbody>
            </table>
            <?php echo $page_links; ?>
        </div>
    </section>
</div>

<!--.............................Modal.......................-->

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><b>Class Execution</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <span class="text-danger" align="justify">Note:If the classes has been taken on otherthan scheduled date and time that should be mention in reason</span>
                <center><button class="btn btn-success" id="msgprint" style="display: none;"></button></center>
                <input type="hidden" name="routine_id" id="revertId">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Date</label>
                        <!-- <input type="text" name="date" id="datepicker6" class="form-control"autocomplete="off" readonly placeholder="Please Select the date"> -->
                        <div class="input-group date" data-provide="datepicker" raedonly>
                            <input type="text" class="form-control" id="datepicker6"
                                placeholder="Please Select Execution Date" readonly="">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Class Execution</label>
                        <select class="form-control" id="class_execution_yes_no" onchange="showbox();">
                            <option value="">-- Select Execution --</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>

                <input type="hidden" name="rouitne_id_exe" id="rouitne_id_exe">

                <div class="col-sm-12 textar" style="display: none;">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Topic Coverd</label> <span class="text-danger">*</span>
                        <textarea class="form-control" id="class_execution_yes" name="revert_remarks" rows="3"
                            placeholder="Please Enter Revert Reason..." required></textarea>
                    </div>
                </div>
                <div class="col-sm-12 textar">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Remarks</label>
                        <textarea class="form-control" id="remarks" name="remarks" rows="3"
                            placeholder="Please Enter Revert Reason..." required></textarea>
                    </div>
                </div>
                <div class="col-sm-12 class_execution_reason" style="display: none;">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Class Execution Reason</label> <span
                            class="text-danger">*</span>
                        <select class="form-control" id="class_execution_no">
                            <option value="">--Select Reason--</option>
                            <?php foreach($all_reason as $all_reason){ ?>
                            <option value="<?php echo $all_reason['reason_master_id_pk'];  ?>">
                                <?php echo $all_reason['reason_master_description'];  ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <br>
            <div class="modal-footer" style="margin-top: 15px;">
                <button type="button" class="btn btn-secondary closebtn" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="submitRevert();">Submit</button>
            </div>
        </div>
    </div>
</div>
<!--............................................-->
<script type="text/javascript">
function showExecution(x) {
    var rouitneid=x;

    $.ajax({
        url:"<?php echo base_url('admin/routine_management_c/employee_routine/Employee_routine_list/executionListmodal') ?>",
        data:{rouitneid:rouitneid},
        method:"GET",
        success:function(response){
           $("#rouitne_id_exe").val(response);
           $('#exampleModal').modal('show');
        }
    });
}

function showbox() {
    var class_execution_yes_no = $("#class_execution_yes_no").val();
    if (class_execution_yes_no == '1') {
        $(".textar").show();
        $(".class_execution_reason").hide();
    }
    if (class_execution_yes_no == '0') {
        $(".class_execution_reason").show();
        $(".textar").hide();
    }
}

function submitRevert() {
    //alert("1HII");
    var date = $("#datepicker6").val();
    var class_execution_yes_no = $("#class_execution_yes_no").val();
    var class_execution_yes = $("#class_execution_yes").val();
    var class_execution_no = $("#class_execution_no").val();
    var remarks = $("#remarks").val();
    var rouitne_id_exe  = $("#rouitne_id_exe").val();

    if (date == '') {
        alert("Please Select a date");
        $("#date").focus();
        return false;
    }
    if (class_execution_yes_no == '') {
        alert("Please Select Anyone From Class Execution");
        $("#class_execution").focus();
        return false;
    }
    $.ajax({
        url: "<?php echo base_url('admin/routine_management_c/employee_routine/Employee_routine_list/executionClass') ?>",
        data: {
            date: date,
            class_execution_yes_no: class_execution_yes_no,
            class_execution_yes: class_execution_yes,
            class_execution_no: class_execution_no,
            remarks: remarks,
            rouitne_id_exe: rouitne_id_exe
        },
        method: "GET",
        dataType: 'JSON',
        success: function(response) {
            // console.log(response);
            // return false;
            $("#msgprint").show();
            $("#msgprint").html(response.msg);
            
        }
    });
}

$(".closebtn").click(function(){
        window.location.href = "routine_management_c/employee_routine/Employee_routine_list";
})
</script>

<script>
$(document).ready(function() {
    $('#datepicker').datepicker();
});
</script>
<?php $this->load->view($this->config->item('theme_uri').'layout/footer_view'); ?>
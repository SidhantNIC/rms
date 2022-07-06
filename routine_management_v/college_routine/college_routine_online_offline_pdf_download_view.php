<h1>Routine Management System</h1>
<h2>Polytechnic Name: <?php echo get_College_name($this->session->userdata('stake_details_id_fk')); ?> </h2>
<table id="example1" class="table table-bordered table-striped custom_table" cellspacing="0" cellpadding="1" style="border-color:gray;" border="1">
    <thead class="bg-primary">
        <tr align="center">
            <td colspan="9">
                <center>
                    <b> Discipline Name :
                        <?php echo get_discipline_name(@$forwardlist['discipline_type']); ?>|| Academic Year :
                        <?php echo get_academic_session_name(@$forwardlist['academic_year']); ?> ||Semester :
                        <?php echo get_semester_name(@$forwardlist['semester']); ?></b>
                </center>
            </td>
        </tr>
        <tr>
            <th style="vertical-align: middle; text-align:center;">Days</th>
            <?php foreach (@$period_time as $pt) { ?>

                <th width="250px;">
                    <center><?php echo @$pt['period_start_time']; ?> <br><i>to</i><br> <?php echo @$pt['period_end_time']; ?></center>
                </th>
            <?php } ?>
        </tr>
    </thead>

    <tbody>
        <?php
        $i = 1;
        $j = 1;
        $day = array(1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday', 4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday', 7 => 'Sunday');
        foreach ($routine_details as $key => $value) { ?>

            <?php if ($j == 1) { ?>
                <tr>
                    <td align="center" style="font-weight: bold;"><?php echo $day[$value['days_id_fk']] ?></td>
                <?php } ?>

                <td width="250px;">
                    <center>
                        <p align="center"> <?php echo $value['subject_description']; ?></p>
                        <p align="center">
                            <?php
                            $subject = array_column($value['subject'], 'practical_sub');
                            echo implode(',', $subject);
                            ?>
                        </p>
                        <p align="center"> <?php echo $value['periodtype']; ?> </p>
                        <p align="center"> <?php echo $value['room_no']; ?></p>
                        <p align="center">
                            <?php
                            foreach ($value['teacher'] as $key => $teacher_name) {
                                echo $teacher_name['first_name'] . ' ' . $teacher_name['midle_name'] . ' ' .  $teacher_name['last_name'];
                            }
                            ?>
                        </p>
                    </center>
                    <!-- <button class="btn btn-success btn-xs" disabled style="margin-top:50px;"><?php echo $value['routine_online_status'] == '1' ? "Offline & Online" : "Offline"; ?></button> -->
                </td>



                <?php

                $j++;
                if ($j == count($period_time) + 1) {
                    echo '</tr>';
                    $j = 1;
                }
                ?>
            <?php ++$i;;
        } ?>



    </tbody>
</table>
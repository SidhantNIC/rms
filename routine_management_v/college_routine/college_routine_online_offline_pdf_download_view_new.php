<table id="example1" class="table table-bordered table-striped custom_table" cellspacing="0" cellpadding="1" style="border-color:gray;" border="1">
    <thead class="bg-primary">
        <tr align="center">

            <td colspan="9">
                <center>
                    <b>Polytechnic Name:
                        <?php echo $this->session->userdata('stake_holder_details'); ?>|| Discipline Name :
                        <?php echo get_discipline_name(@$forwardlist['discipline_type']); ?>|| Academic Year :
                        <?php echo get_academic_session_name(@$forwardlist['academic_year']); ?> ||Semester :
                        <?php echo get_semester_name(@$forwardlist['semester']); ?></b>
                </center>
            </td>

        </tr>

        <tr>
            <th style="vertical-align: middle; text-align:center;">Days</th>
            <?php foreach (@$period_time as $pt) { ?>

                <th width="250px;" style="font-size:10px;">
                    <center><?php echo @$pt['period_start_time']; ?> <br><i>to</i><br> <?php echo @$pt['period_end_time']; ?></center>
                </th>
            <?php } ?>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td>
                <p align="center">Monday</p>
            </td>

            <?php
            $period_no = array_column($monday, 'period_no');
            for ($i = 1; $i <= count($period_time); $i++) {

                if (in_array($i, $period_no)) {

                    $mondays = $monday[array_search($i, $period_no)]; ?>

                    <td>
                        <center>
                            <p align="center"><?php echo $mondays['routine_unique_id']; ?></p>
                            <p align="center"><?php echo $mondays['room_no']; ?></p>
                            <p align="center"><?php echo $mondays['periodtype']; ?></p>
                            <p align="center">
                                <?php
                                foreach ($mondays['teacher'] as $key => $teacher_name) {
                                    echo $teacher_name['first_name'] . ' ' . $teacher_name['midle_name'] . ' ' .  $teacher_name['last_name'];
                                }
                                ?>
                            </p>
                            <p align="center"><?php echo @get_theory_subeject_name($mondays['subject_id_fk']); ?></p>
                            <p align="center">
                                <?php
                                foreach ($mondays['subject'] as $key => $subject_name) {
                                    echo ($subject_name['subject_description']);
                                }
                                ?>
                            </p>
                        </center>
                    </td>

            <?php } else {

                    echo '
                           <td><center>
                              <span class="text-danger" align="center"><b>No Routine</b></span></center>
                           </td>
                       ';
                }
            } ?>
        </tr>

        <tr>
            <td>
                <p align="center">Tuesday</p>
            </td>

            <?php
            $period_no = array_column($tuesday, 'period_no');
            for ($i = 1; $i <= count($period_time); $i++) {

                if (in_array($i, $period_no)) {

                    $tuesdays = $tuesday[array_search($i, $period_no)]; ?>

                    <td>
                        <center>
                            <p align="center"><?php echo $tuesdays['routine_unique_id']; ?></p>
                            <p align="center"><?php echo $tuesdays['room_no']; ?></p>
                            <p align="center"><?php echo $tuesdays['periodtype']; ?></p>
                            <p align="center">
                                <?php
                                foreach ($tuesdays['teacher'] as $key => $teacher_name) {
                                    echo $teacher_name['first_name'] . ' ' . $teacher_name['midle_name'] . ' ' .  $teacher_name['last_name'];
                                }
                                ?>
                            </p>
                            <p align="center"><?php echo @get_theory_subeject_name($tuesdays['subject_id_fk']); ?></p>
                            <p align="center">
                                <?php
                                foreach ($tuesdays['subject'] as $key => $subject_name) {
                                    echo ($subject_name['subject_description']);
                                }
                                ?>
                            </p>
                        </center>
                    </td>

            <?php } else {
                    echo '
                           <td><center>
                               <span class="text-danger" align="center"><b>No Routine</b></span></center>
                           </td>
                        ';
                }
            } ?>
        </tr>

        <tr>
            <td>
                <p align="center">Wednesday</p>
            </td>

            <?php
            $period_no = array_column($wednesday, 'period_no');
            for ($i = 1; $i <= count($period_time); $i++) {

                if (in_array($i, $period_no)) {

                    $wednesdays = $wednesday[array_search($i, $period_no)]; ?>

                    <td>
                        <center>
                            <p align="center"><?php echo $wednesdays['routine_unique_id']; ?></p>
                            <p align="center"><?php echo $wednesdays['room_no']; ?></p>
                            <p align="center"><?php echo $wednesdays['periodtype']; ?></p>

                            <p align="center">
                                <?php
                                foreach ($wednesdays['teacher'] as $key => $teacher_name) {
                                    echo $teacher_name['first_name'] . ' ' . $teacher_name['midle_name'] . ' ' .  $teacher_name['last_name'];
                                }
                                ?>
                            </p>
                            <p align="center"><?php echo @get_theory_subeject_name($wednesdays['subject_id_fk']); ?></p>
                            <p align="center">
                                <?php
                                foreach ($wednesdays['subject'] as $key => $subject_name) {
                                    echo ($subject_name['subject_description']);
                                }
                                ?>
                            </p>
                    </td>
                    </center>

            <?php } else {
                    echo '
                           <td><center>
                               <span class="text-danger" align="center"><b>No Routine</b></span></center>
                           </td>
                        ';
                }
            } ?>
        </tr>

        <tr>
            <td>
                <p align="center">Thrusday</p>
            </td>

            <?php
            $period_no = array_column($thrusday, 'period_no');
            for ($i = 1; $i <= count($period_time); $i++) {

                if (in_array($i, $period_no)) {

                    $thrusdays = $thrusday[array_search($i, $period_no)]; ?>

                    <td>
                        <center>
                            <p align="center"><?php echo $thrusdays['routine_unique_id']; ?></p>
                            <p align="center"><?php echo $thrusdays['room_no']; ?></p>
                            <p align="center"><?php echo $thrusdays['periodtype']; ?></p>
                            <p align="center">
                                <?php
                                foreach ($thrusdays['teacher'] as $key => $teacher_name) {
                                    echo $teacher_name['first_name'] . ' ' . $teacher_name['midle_name'] . ' ' .  $teacher_name['last_name'];
                                }
                                ?>
                            </p>
                            <p align="center"><?php echo @get_theory_subeject_name($thrusdays['subject_id_fk']); ?></p>
                            <p align="center">
                                <?php
                                foreach ($thrusdays['subject'] as $key => $subject_name) {
                                    echo ($subject_name['subject_description']);
                                }
                                ?>
                            </p>
                        </center>
                    </td>

            <?php } else {
                    echo '
                           <td><center>
                               <span class="text-danger" align="center"><b>No Routine</b></span></center>
                           </td>
                        ';
                }
            } ?>
        </tr>


        <tr>
            <td>
                <p align="center">Fridays</p>
            </td>

            <?php
            $period_no = array_column($friday, 'period_no');
            for ($i = 1; $i <= count($period_time); $i++) {

                if (in_array($i, $period_no)) {

                    $fridays = $friday[array_search($i, $period_no)]; ?>

                    <td>
                        <center>
                            <p align="center"><?php echo $fridays['routine_unique_id']; ?></p>
                            <p align="center"><?php echo $fridays['room_no']; ?></p>
                            <p align="center"><?php echo $fridays['periodtype']; ?></p>

                            <p align="center">
                                <?php
                                foreach ($fridays['teacher'] as $key => $teacher_name) {
                                    echo $teacher_name['first_name'] . ' ' . $teacher_name['midle_name'] . ' ' .  $teacher_name['last_name'];
                                }
                                ?>
                            </p>
                            <p align="center"><?php echo @get_theory_subeject_name($fridays['subject_id_fk']); ?></p>
                            <p align="center">
                                <?php
                                foreach ($fridays['subject'] as $key => $subject_name) {
                                    echo ($subject_name['subject_description']);
                                }
                                ?>
                            </p>
                        </center>
                    </td>

            <?php } else {
                    echo '
                           <td>
                               <center><span class="text-danger" align="center"><b>No Routine</b></span></center>
                           </td>
                        ';
                }
            } ?>
        </tr>

        <tr>
            <td>
                <p align="center">Saturday</p>
            </td>

            <?php
            $period_no = array_column($saturday, 'period_no');
            for ($i = 1; $i <= count($period_time); $i++) {

                if (in_array($i, $period_no)) {

                    $saturdays = $saturday[array_search($i, $period_no)]; ?>

                    <td>
					<center>
                        <p align="center"><?php echo $saturdays['routine_unique_id']; ?></p>
                        <p align="center"><?php echo $saturdays['room_no']; ?></p>
                        <p align="center"><?php echo $saturdays['periodtype']; ?></p>

                        <p align="center">
                            <?php
                            foreach ($saturdays['teacher'] as $key => $teacher_name) {
                                echo $teacher_name['first_name'] . ' ' . $teacher_name['midle_name'] . ' ' .  $teacher_name['last_name'];
                            }
                            ?>
                        </p>
                        <p align="center"><?php echo @get_theory_subeject_name($saturdays['subject_id_fk']); ?></p>
                        <p align="center">
                            <?php
                            foreach ($saturdays['subject'] as $key => $subject_name) {
                                echo ($subject_name['subject_description']);
                            }
                            ?>
                        </p>
                    </td>
					</center>

            <?php } else {
                    echo '
                           <td>
                               <center><span class="text-danger" align="center"><b>No Routine</b></span></center>
                           </td>
                        ';
                }
            } ?>
        </tr>
    </tbody>
</table>
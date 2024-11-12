<?php
global $conn;
include 'config1.php';

$suid = $_SESSION['uid'] ?? null;
if (!$suid) {
    die("User not logged in.");
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <h1 class="page-header">Reports</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-lg-12">
            <form action="" method="GET" class="form-inline" data-toggle="validator">
                <div class="form-group">
                    <label for="course" class="control-label">Course:</label>
                    <?php
                    $query_course = "SELECT course.name, course.id FROM course 
                             INNER JOIN user_course ON user_course.id = course.id 
                             WHERE user_course.uid = :suid ORDER BY course.name";
                    $sub = $conn->prepare($query_course);
                    $sub->bindParam(':suid', $suid, PDO::PARAM_INT);
                    $sub->execute();
                    $rsub = $sub->fetchAll(PDO::FETCH_ASSOC);

                    echo "<select id='course' name='course' class='form-control' title='Select course' required='required'>";
                    foreach ($rsub as $course) {
                        $selected = ($_GET['course'] ?? '') == $course['id'] ? "selected='selected'" : '';
                        echo "<option value='{$course['id']}' {$selected}>{$course['name']}</option>";
                    }
                    echo "</select>";
                    ?>
                </div>

                <div class="form-group">
                    <label for="sdate" class="control-label">From:</label>
                    <input type="date" id="sdate" name="sdate" class="form-control" placeholder="Start Date" value="<?php echo $_GET['sdate'] ?? ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="edate" class="control-label">To:</label>
                    <input type="date" id="edate" name="edate" class="form-control" placeholder="End Date" value="<?php echo $_GET['edate'] ?? ''; ?>" required>
                </div>

                <input type="hidden" name="page" value="reports">
                <input type="submit" class="btn btn-info" name="submit" value="Load Student" title="Load Student">
            </form>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <p>&nbsp;</p>
            <div class="report-data">
                <?php
                if (isset($_GET['submit']) && !empty($_GET['sdate']) && !empty($_GET['edate'])) {
                    $sdate = strtotime($_GET['sdate']);
                    $edate = strtotime($_GET['edate']);
                    $t = time();

                    if ($sdate < $t && $edate < $t && $edate >= $sdate) {
                        $selsub = $_GET['course'];

                        $query_student = "SELECT student.sid, student.name, student.rollno 
                              FROM student 
                              INNER JOIN student_course ON student.sid = student_course.sid 
                              WHERE student_course.id = :selsub ORDER BY student.sid";
                        $stu = $conn->prepare($query_student);
                        $stu->bindParam(':selsub', $selsub, PDO::PARAM_INT);
                        $stu->execute();
                        $rstu = $stu->fetchAll(PDO::FETCH_ASSOC);

                        echo "<table class='table table-striped table-hover reports-table'>";
                        echo "<thead><tr><th>Roll No</th><th>Name</th>";

                        for ($k = $sdate; $k <= $edate; $k += 86400) {
                            $weekday = strtolower(date("l", $k));
                            if ($weekday != "saturday" && $weekday != "sunday") {
                                echo "<th>" . date('d-m-Y', $k) . "</th>";
                            }
                        }
                        echo "<th>Present/Total</th>";
                        echo "<th>Precentage</th>";;
                        echo "</tr>";
                        echo "</thead>";
                        echo "</tbody>";

                        for($i=0;$i<count($rstu);$i++)
					{
						$present=0;
						$absent=0;
						$totlec=0;
						$perc=0;
						echo"<tr><td><h6>".$rstu[$i]['rollno']."</h6></td>";
						echo "<td><h5>".$rstu[$i]['name']."</h5></td>";
						$dsid=$rstu[$i]['sid'];

						for($j=$sdate;$j<=$edate;$j=$j+86400)
						{

							$weekday= date("l", $j );
							$currentDate = date('Y-m-d', $j);
							$normalized_weekday = strtolower($weekday);
							 if(($normalized_weekday!="saturday") && ($normalized_weekday!="sunday"))
							 {


								 $sql = "SELECT sid ,ispresent FROM attendance WHERE sid=$dsid AND
								 id=$selsub AND date=$j AND $suid=uid ";
								$stmt = $conn->prepare($sql);
								$stmt->execute();
								$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
								if(!empty($result)){
								//print_r($result);
									$totlec++;
									if($result[0]['ispresent']==1)
									{
										$present++;
										echo"<td><span class='text-success'>Present</span></td>";
									}
									else
									{
										echo"<td><span class='text-danger'>Absent</span></td>";
										$absent++;
									}
								}else
								{
									echo "<td><a href='index.php?course=" . $selsub . "&date=" . $currentDate . "'>TakeAttendance</a></td>";
								}
							}
						}
						if($totlec!=0)
							$perc=round((($present*100)/$totlec), 2);
						else
							$perc=0;
						echo"<td><strong>".$present."</strong>/".$totlec."</td>";
						echo"<td>".$perc."&nbsp;%</td>";
						echo"</tr>";

					}
					echo "</tbody>";
					echo "</table>";
				}else
				{
					print '<div class="alert alert-dismissible alert-danger">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>Sorry!</strong>Please enter correct date range.
              </div>';
				}

				}else{
					 // echo"<h3>Please enter detail</h3>";
				}
                ?>
            </div>
        </div>
    </div>
</div>

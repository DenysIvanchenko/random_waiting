<?php
require_once("db.php");

$setting_sql = "SELECT * FROM setting";
$setting_result = $conn->query($setting_sql);
$set_mins = 600; //waiting time
$array = $setting_result->fetch_array();
$set_mins = $array['waiting_time'] * 1;

$progress_sql = "SELECT * FROM checkserver";
$progress_result = $conn->query($progress_sql);
$check_progress = $progress_result->fetch_array();
$progressFlag = $check_progress['progress'];
// print_r($set_mins);die();
if ($_POST['flag'] == 'pushFirstStep') {
    if ($_POST['step'] == 0 && $progressFlag == "no") {
        $progressingNowSql = "UPDATE checkserver SET progress='yes' WHERE id='1'";
        $conn->query($progressingNowSql);
        $sql = "SELECT * FROM pool_list WHERE step='" . $_POST['step'] . "'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            $poolActive = array();
            $connectNumber = array();
            while ($row = $result->fetch_assoc()) {
                array_push($poolActive, $row['id']);
                if (($_POST['date'] - $set_mins) > $row['date']) {
                    if (count($connectNumber) < 2) {
                        array_push($connectNumber, $row['id']);
                    }
                }
            }
            $poolActive = array_merge(array_diff($poolActive, $connectNumber));
            $existSql = "SELECT * FROM pool_list WHERE step=1";
            $existResult = $conn->query($existSql);
            if (count($connectNumber) == 2 && $existResult->num_rows == 0) {
                if (count($poolActive) > 1) {
                    $rand_key = array_rand($poolActive, 1);
                    $firstVal = $poolActive[$rand_key];
                    array_splice($poolActive, $rand_key, 1);
                    $rand_key1 = array_rand($poolActive, 1);
                    $secondVal = $poolActive[$rand_key1];
                    if ($firstVal != $secondVal) {
                        $updatesql1 = "UPDATE pool_list SET step=1 ,`order_num`=1, date='" . $_POST['date'] . "' WHERE id='" . $connectNumber[0] . "'";
                        $conn->query($updatesql1);
                        $updatesql2 = "UPDATE pool_list SET step=1 ,`order_num`=2, date='" . $_POST['date'] . "' WHERE id='" . $firstVal . "'";
                        $conn->query($updatesql2);
                        $updatesql3 = "UPDATE pool_list SET step=1 ,`order_num`=3, date='" . $_POST['date'] . "' WHERE id='" . $connectNumber[1] . "'";
                        $conn->query($updatesql3);
                        $updatesql4 = "UPDATE pool_list SET step=1 ,`order_num`=4, date='" . $_POST['date'] . "' WHERE id='" . $secondVal . "'";
                        $conn->query($updatesql4);
                        $dup_sql = "SELECT * FROM pool_list WHERE step=1 AND order_num=2";
                        $duplicate_result = $conn->query($dup_sql);
                        if ($duplicate_result->num_rows > 1) {
                            $dupuniqueflag = true;
                            while ($irow = $duplicate_result->fetch_assoc()) {
                                if ($dupuniqueflag) {
                                    $dupUpdate = "UPDATE pool_list SET step=0 ,`order_num`=0 WHERE id='" . $irow['id'] . "'";
                                    $conn->query($dupUpdate);
                                }
                                $dupuniqueflag = false;
                            }
                        }
                        $dup_sql2 = "SELECT * FROM pool_list WHERE step=1 AND order_num=4";
                        $duplicate_result2 = $conn->query($dup_sql2);
                        if ($duplicate_result2->num_rows > 1) {
                            $dupuniqueflag2 = true;
                            while ($irow = $duplicate_result2->fetch_assoc()) {
                                if ($dupuniqueflag2) {
                                    $dupUpdate = "UPDATE pool_list SET step=0 ,`order_num`=0 WHERE id='" . $irow['id'] . "'";
                                    $conn->query($dupUpdate);
                                }
                                $dupuniqueflag2 = false;
                            }
                        }
                    }
                } else if (count($poolActive) == 1) {
                    $updatesql1 = "UPDATE pool_list SET step=1 ,`order_num`=1, date='" . $_POST['date'] . "' WHERE id='" . $connectNumber[0] . "'";
                    $conn->query($updatesql1);
                    $updatesql2 = "UPDATE pool_list SET step=1 ,`order_num`=2, date='" . $_POST['date'] . "' WHERE id='" . $poolActive[0] . "'";
                    $conn->query($updatesql2);
                    $updatesql3 = "UPDATE pool_list SET step=1 ,`order_num`=3, date='" . $_POST['date'] . "' WHERE id='" . $connectNumber[1] . "'";
                    $conn->query($updatesql3);
                    $updatesql4 = "INSERT INTO pool_list (number, date, step, order_num)
                                VALUES ('HOST', '" . $_POST['date'] . "', 1, 4)";
                    $conn->query($updatesql4);
                } else if (count($poolActive) == 0) {
                    $updatesql1 = "UPDATE pool_list SET step=1 ,`order_num`=1, date='" . $_POST['date'] . "' WHERE id='" . $connectNumber[0] . "'";
                    $conn->query($updatesql1);
                    $updatesql2 = "INSERT INTO pool_list (number, date, step, order_num)
                                VALUES ('HOST', '" . $_POST['date'] . "', 1, 2)";
                    $conn->query($updatesql2);
                    $updatesql3 = "UPDATE pool_list SET step=1 ,`order_num`=3, date='" . $_POST['date'] . "' WHERE id='" . $connectNumber[1] . "'";
                    $conn->query($updatesql3);
                    $updatesql4 = "INSERT INTO pool_list (number, date, step, order_num)
                                VALUES ('HOST', '" . $_POST['date'] . "', 1, 4)";
                    $conn->query($updatesql4);
                }
            }
        }
        $progressingNowSqls = "UPDATE checkserver SET progress='no' WHERE id='1'";
        $conn->query($progressingNowSqls);
        $dupuniqueflag = true;
        $dupuniqueflag2 = true;
        exit("ok");
    } else {
        exit("try again");
    }
} else if ($_POST['flag'] == 'getData') {
    $sql = "SELECT * FROM pool_list WHERE step!=0 AND step!=6";
    $result = $conn->query($sql);
    $return = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($return, $row);
        }
    }
    print_r(json_encode($return));
    exit();
} else if ($_POST['flag'] == "countUp") {
    $progress_sql2 = "SELECT * FROM checkserver";
    $progress_result2 = $conn->query($progress_sql2);
    $check_progress2 = $progress_result2->fetch_array();
    $progressFlag2 = $check_progress2['countup_progress'];
    if ($progressFlag2 == "no") {
        $progressingNowSql2 = "UPDATE checkserver SET progress='yes' WHERE id='1'";
        $conn->query($progressingNowSql2);
        $step = $_POST['step'] * 1 + 1;
        if ($step != 6) {
            if ($step == 5) {
                $tb_sql = "SELECT * FROM table_num";
                $tb_result = $conn->query($tb_sql);
                $array = $tb_result->fetch_array();
                $left = $array['left_num'] * 1;
                $right = $array['right_num'] * 1;
                if ($left == 9) {
                    $left_num = 0;
                    $right_num = 1;
                } else if ($left == 0) {
                    $left_num = 1;
                    $right_num = 2;
                } else {
                    $left_num = 2 + $left;
                    $right_num = 2 + $right;
                }
                $tableNumupdatesql = "UPDATE table_num SET left_num='" . $left_num . "' , right_num='" . $right_num . "' WHERE id='1'";
                $conn->query($tableNumupdatesql);
            }
            $existSql = "SELECT * FROM pool_list WHERE step='" . $step . "'";
            $existResult = $conn->query($existSql);
            if ($existResult->num_rows == 0) {
                $updatesql1 = "UPDATE pool_list SET step='" . $step . "' WHERE step='" . $_POST['step'] . "'";
                $conn->query($updatesql1);
            }
        } else {
            $updatesql1 = "UPDATE pool_list SET step='" . $step . "' , date='" . $_POST['date'] . "' WHERE step='" . $_POST['step'] . "'";
            $conn->query($updatesql1);
        }
        $progressingNowSql3 = "UPDATE checkserver SET progress='no' WHERE id='1'";
        $conn->query($progressingNowSql3);
    }
} else if ($_POST['flag'] == "setTableNum") {
    $tb_sql2 = "SELECT * FROM table_num";
    $tb_result2 = $conn->query($tb_sql2);
    $arrayRes = $tb_result2->fetch_array();
    exit(json_encode($arrayRes));
} else if ($_POST['flag'] == "setting") {
    $updatesql1 = "UPDATE setting SET waiting_time='" . $_POST['waiting_time'] . "' , countdown_time='" . $_POST['countdown_time'] . "' WHERE id='1'";
    $conn->query($updatesql1);
    echo "success";
} else if ($_POST['flag'] == "setting_getdata") {
    $sql = "SELECT * FROM setting";
    $result = $conn->query($sql);
    print_r(json_encode($result->fetch_array()));
    exit();
} else if ($_POST['flag'] == "clear") {
    $sql = "TRUNCATE TABLE `pool_list`";
    $conn->query($sql);
    $sql1 = "TRUNCATE TABLE `table_num`";
    $conn->query($sql1);
    $insertSql = "INSERT INTO table_num (left_num, right_num)
    VALUES (0, 1)";
    $conn->query($insertSql);
    echo "success";
} else if ($_POST['flag'] == "getCountdown") {
    $sql = "SELECT * FROM setting";
    $result = $conn->query($sql);
    print_r(json_encode($result->fetch_array()));
    exit();
} else if ($_POST['flag'] == "getTableNum") {
    $sql = "SELECT * FROM table_num";
    $result = $conn->query($sql);
    print_r(json_encode($result->fetch_array()));
    exit();
}

<?php
require_once("db.php");

$setting_sql = "SELECT * FROM setting";
$setting_result = $conn->query($setting_sql);
$set_mins = 600; //waiting time

$array = $setting_result->fetch_array(); 
$set_mins = $array['waiting_time']*1;

// print_r($set_mins);die();
if ($_POST['flag'] == 'pushFirstStep') {
    if ($_POST['step'] == 0) {
        $sql = "SELECT * FROM pool_list WHERE step='" . $_POST['step'] . "'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            $poolActive = array();
            $connectNumber = 0;
            while ($row = $result->fetch_assoc()) {
                array_push($poolActive, $row['id']);
                if (($_POST['date'] - $set_mins) > $row['date']) {
                    $connectNumber = $row['id'];
                }
            }
            $existSql = "SELECT * FROM pool_list WHERE step=1";
            $existResult = $conn->query($existSql);
            $flag = true;
            if ($connectNumber && count($poolActive) > 1) {
                while ($flag) {
                    $rand_key = array_rand($poolActive, 1);
                    if ($poolActive[$rand_key] != $connectNumber) {
                        $flag = false;
                    }
                }
                if ($existResult->num_rows == 0) {
                    $updatesql1 = "UPDATE pool_list SET step=1 ,`order_num`=1, date='" . $_POST['date'] . "' WHERE id='" . $connectNumber . "'";
                    $updatesql2 = "UPDATE pool_list SET step=1 ,`order_num`=2, date='" . $_POST['date'] . "' WHERE id='" . $poolActive[$rand_key] . "'";
                    $conn->query($updatesql1);
                    $conn->query($updatesql2);
                }
            } else {
                if ($existResult->num_rows == 0) {
                    $updatesql1 = "UPDATE pool_list SET step=1 ,`order_num`=1, date='" . $_POST['date'] . "' WHERE id='" . $connectNumber . "'";
                    $conn->query($updatesql1);
                }
            }
        }
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
    $step = $_POST['step'] * 1 + 1;
    if ($step != 6) {
        $existSql = "SELECT * FROM pool_list WHERE step='" . $step . "'";
        $existResult = $conn->query($existSql);
        if ($existResult->num_rows == 0) {
            $updatesql1 = "UPDATE pool_list SET step='" . $step . "' , date='" . $_POST['date'] . "' WHERE step='" . $_POST['step'] . "'";
            $conn->query($updatesql1);
        }
    } else {
        $updatesql1 = "UPDATE pool_list SET step='" . $step . "' , date='" . $_POST['date'] . "' WHERE step='" . $_POST['step'] . "'";
        $conn->query($updatesql1);
    }
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
    echo "success";
} else if ($_POST['flag'] == "getCountdown") {
    $sql = "SELECT * FROM setting";
    $result = $conn->query($sql);
    print_r($result->fetch_array()['countdown_time']);
    exit();
} 

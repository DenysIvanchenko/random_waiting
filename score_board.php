<?php
require_once("db.php");
if ($_POST) {
    if ($_POST['guest_number'] && $_POST['date']) {   //when enter, save
        $existSql = "SELECT * FROM pool_list WHERE number='" . $_POST['guest_number'] . "'";
        $existResult = $conn->query($existSql);
        if ($existResult->num_rows == 0) {
            $sql = "INSERT INTO pool_list (number, date, step, order_num)
            VALUES ('" . $_POST['guest_number'] . "', '" . $_POST['date'] . "', 0, 0)";
            if ($conn->query($sql) === TRUE) {
                //echo "enter ok";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            exit("exist");
        }

        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Score board</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <!-- <link href="assets/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="container">

        <h2 class="text-center display-1 fw-bolder" style="color:white;">
            <!-- <div href="#" class="typewrite" data-period="2000" data-type='[ "ARENA.", "I love ARENA." ]'>
                <span class="wrap"></span>
            </div> -->
            ARENA
        </h2>

        <div class="row mt-1 top">
            <div class="col-xs-6 col-sm-6 col-lg-6 col-md-6 text-white rounded-3 top_layer" style="background-color:#FF4D99;width:48%;">
                <span class="display-5" style="float: right;font-weight:500;">TABLE<br> <span class="table_num" style="float:right;"></span></span>
                <span class="top_rows_layer display-1"><span id="top_step_first_order">READY TO</span><br> <span id="top_step_second_order">PLAY</span></span>
            </div>
            <div style="width:4%;">
                <div class="start rounded-3 text-white display-2">DÉMARRER</div>
            </div>
            <div class="col-xs-6 col-sm-6 col-lg-6 col-md-6 text-white rounded-3 top_layer_right" style="background-color:#FF4D99;width:48%;text-align:right;">
                <span class=" display-5" style="float: left;font-weight:500;">TABLE<br> <span class="table_num_right" style="float:left;"></span></span>
                <span class="top_rows_layer display-1"><span id="top_step_first_order_right">READY TO</span><br> <span id="top_step_second_order_right">PLAY</span></span>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-5 col-sm-5 col-lg-5 col-md-5 text-white rounded-3" style="background-color:#009CDA;">
                <span class="rows_layer display-6"><span id="fourth_step_first_order">READY TO</span><br> <span id="fourth_step_second_order">PLAY</span></span>
            </div>
            <div class="col-xs-2 col-sm-2 col-lg-2 col-md-2 text-center time_div">
                <span class="display-4 timing fourth_time text-white">WAIT</span>
            </div>
            <div class="col-xs-5 col-sm-5 col-lg-5 col-md-5 text-white rounded-3" style="background-color:#009CDA;text-align:right;">
                <span class="rows_layer display-6"><span id="fourth_step_first_order_right">READY TO</span><br> <span id="fourth_step_second_order_right">PLAY</span></span>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-4 col-sm-4 col-lg-4 col-md-4 text-white rounded-3" style="background-color:#004884;">
                <span class="rows_layer display-6"><span id="third_step_first_order">READY TO</span><br> <span id="third_step_second_order">PLAY</span></span>
            </div>
            <div class="col-xs-4 col-sm-4 col-lg-4 col-md-4 text-center time_div">
                <span class="display-4 timing third_time text-white">WAIT</span>
            </div>
            <div class="col-xs-4 col-sm-4 col-lg-4 col-md-4 text-white rounded-3" style="background-color:#004884;text-align:right;">
                <span class="rows_layer display-6"><span id="third_step_first_order_right">READY TO</span><br> <span id="third_step_second_order_right">PLAY</span></span>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-3 col-sm-3 col-lg-3 col-md-3 text-white rounded-3" style="background-color:#009CDA;">
                <span class="rows_layer second_step"><span id="second_step_first_order">READY TO</span><br> <span id="second_step_second_order">PLAY</span></span>
            </div>
            <div class="col-xs-6 col-sm-6 col-lg-6 col-md-6 text-center time_div">
                <span class="display-4 timing second_time text-white">WAIT</span>
            </div>
            <div class="col-xs-3 col-sm-3 col-lg-3 col-md-3 text-white rounded-3" style="background-color:#009CDA;text-align:right;">
                <span class="rows_layer second_step"><span id="second_step_first_order_right">READY TO</span><br> <span id="second_step_second_order_right">PLAY</span></span>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-2 col-sm-2 col-lg-2 col-md-2 text-white rounded-3" style="background-color:#004884;">
                <span class="rows_layer first_step"><span id="first_step_first_order">READY TO</span><br> <span id="first_step_second_order">PLAY</span></span>
            </div>
            <div class="col-xs-8 col-sm-8 col-lg-8 col-md-8 text-center time_div">
                <span class="display-4 timing first_time text-white">WAIT</span>
            </div>
            <div class="col-xs-2 col-sm-2 col-lg-2 col-md-2 text-white rounded-3" style="background-color:#004884;text-align:right;">
                <span class="rows_layer first_step"><span id="first_step_first_order_right">READY TO</span><br> <span id="first_step_second_order_right">PLAY</span></span>
            </div>
        </div>
    </div>

    <script src="assets/js/main.js?v2203"></script>
    <script>
        //made by vipul mirajkar thevipulm.appspot.com
        var TxtType = function(el, toRotate, period) {
            this.toRotate = toRotate;
            this.el = el;
            this.loopNum = 0;
            this.period = parseInt(period, 10) || 2000;
            this.txt = '';
            this.tick();
            this.isDeleting = false;
        };

        TxtType.prototype.tick = function() {
            var i = this.loopNum % this.toRotate.length;
            var fullTxt = this.toRotate[i];

            if (this.isDeleting) {
                this.txt = fullTxt.substring(0, this.txt.length - 1);
            } else {
                this.txt = fullTxt.substring(0, this.txt.length + 1);
            }

            this.el.innerHTML = '<span class="wrap">' + this.txt + '</span>';

            var that = this;
            var delta = 200 - Math.random() * 100;

            if (this.isDeleting) {
                delta /= 2;
            }

            if (!this.isDeleting && this.txt === fullTxt) {
                delta = this.period;
                this.isDeleting = true;
            } else if (this.isDeleting && this.txt === '') {
                this.isDeleting = false;
                this.loopNum++;
                delta = 500;
            }

            setTimeout(function() {
                that.tick();
            }, delta);
        };

        window.onload = function() {
            var elements = document.getElementsByClassName('typewrite');
            for (var i = 0; i < elements.length; i++) {
                var toRotate = elements[i].getAttribute('data-type');
                var period = elements[i].getAttribute('data-period');
                if (toRotate) {
                    new TxtType(elements[i], JSON.parse(toRotate), period);
                }
            }
            // INJECT CSS
            var css = document.createElement("style");
            css.type = "text/css";
            css.innerHTML = ".typewrite > .wrap { border-right: 0.08em solid #fff}";
            document.body.appendChild(css);
        };
      
    </script>
</body>

</html>
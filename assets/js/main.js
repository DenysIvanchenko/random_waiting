$(document).ready(function () {
    var setMins = 300; //count down time
    $.post(
        "server.php",{
            flag: "getCountdown"
        },
        function(res) {
            console.log(res);
            setMins = res*1;  
        }
    );
    pushFirstStep();
    setInterval(function () {
        pushFirstStep();
    }, 8000);
    function pushFirstStep() {
        $.post(
            "server.php",
            {
                step: 0,
                date: Math.floor(Date.now() / 1000),
                flag: "pushFirstStep"
            }, function (res) {
                getData();
            }
        );
    }
    function timeCount(that, step) {
        const myInterval = setInterval(function () {
            var time = that['date'] * 1 + setMins - Math.floor(Date.now() / 1000);
            if (time < 1) {
                clearInterval(myInterval);
                //count up number
                setCountUp(step);

            }
            var timeVal = getMin(time);
            if (step == 1) {
                $(".first_time").text(timeVal);
            } else if (step == 2) {
                $(".second_time").text(timeVal);
            } else if (step == 3) {
                $(".third_time").text(timeVal);
            } else if (step == 4) {
                $(".fourth_time").text(timeVal);
            }
        }, 1000);
    }
    function getData() {
        $.post(
            "server.php",
            {
                flag: "getData"
            }, function (res) {
                console.log(res);
                if (res.length > 0) {
                    for (var i = 0; i < res.length; i++) {
                        var number = res[i]['number'];
                        if (number.length == 1) {
                            number = "000" + number;
                        } else if (number.length == 2) {
                            number = "00" + number;
                        } else if (number.length == 3) {
                            number = "0" + number;
                        }
                        if (res[i]['step'] == 1) {
                            if (res[i]['order_num'] == 1) {
                                timeCount(res[i], 1);
                                $("#first_step_first_order").text(number);
                                $("#first_step_first_order_right").text(number);
                                // $("#first_step_second_order").text("HOST");
                                // $("#first_step_second_order_right").text("HOST");
                            } else if (res[i]['order_num'] == 2) {
                                $("#first_step_second_order").text(number);
                                $("#first_step_second_order_right").text(number);
                            }

                        } else if (res[i]['step'] == 2) {
                            if (res[i]['order_num'] == 1) {
                                timeCount(res[i], 2);
                                $("#second_step_first_order").text(number);
                                $("#second_step_first_order_right").text(number);
                                // $("#second_step_second_order").text("HOST");
                                // $("#second_step_second_order_right").text("HOST");
                            } else if (res[i]['order_num'] == 2) {
                                $("#second_step_second_order").text(number);
                                $("#second_step_second_order_right").text(number);
                            }

                        } else if (res[i]['step'] == 3) {
                            if (res[i]['order_num'] == 1) {
                                timeCount(res[i], 3);
                                $("#third_step_first_order").text(number);
                                $("#third_step_first_order_right").text(number);
                                // $("#third_step_second_order").text("HOST");
                                // $("#third_step_second_order_right").text("HOST");
                            } else if (res[i]['order_num'] == 2) {
                                $("#third_step_second_order").text(number);
                                $("#third_step_second_order_right").text(number);
                            }

                        }
                        else if (res[i]['step'] == 4) {
                            if (res[i]['order_num'] == 1) {
                                timeCount(res[i], 4);
                                $("#fourth_step_first_order").text(number);
                                $("#fourth_step_first_order_right").text(number);
                                // $("#fourth_step_second_order").text("HOST");
                                // $("#fourth_step_second_order_right").text("HOST");
                            } else if (res[i]['order_num'] == 2) {
                                $("#fourth_step_second_order").text(number);
                                $("#fourth_step_second_order_right").text(number);
                            }

                        } else if (res[i]['step'] == 5) {
                            timeCount(res[i], 5);
                            if (res[i]['order_num'] == 1) {
                                $("#top_step_first_order").text(number);
                                $("#top_step_first_order_right").text(number);
                                // $("#top_step_second_order").text("HOST");
                                // $("#top_step_second_order_right").text("HOST");
                            } else if (res[i]['order_num'] == 2) {
                                $("#top_step_second_order").text(number);
                                $("#top_step_second_order_right").text(number);
                            }
                            var random_tb = Math.ceil(Math.random()*10);
                            $(".table_num").text(random_tb);
                            $(".table_num_right").text(random_tb);

                        }
                    }
                }
            }, "json"
        );
    }
    function getMin(timeP) {
        var min = Math.floor(timeP / 60);
        var sec = timeP % 60;
        min = (min < 10) ? "0" + min : min;
        sec = (sec < 10) ? "0" + sec : sec;
        return min + ":" + sec;
    }
    function setCountUp(step) {
        $.post(
            "server.php",
            {
                step: step,
                date: Math.floor(Date.now() / 1000),
                flag: "countUp"
            }, function (res) {
                if (step == 1) {
                    $(".first_time").text("WAIT");
                    $("#first_step_first_order").text("READY TO");
                    $("#first_step_first_order_right").text("READY TO");
                    $("#first_step_second_order").text("PLAY");
                    $("#first_step_second_order_right").text("PLAY");
                } else if (step == 2) {
                    $(".second_time").text("WAIT");
                    $("#second_step_first_order").text("READY TO");
                    $("#second_step_first_order_right").text("READY TO");
                    $("#second_step_second_order").text("PLAY");
                    $("#second_step_second_order_right").text("PLAY");
                } else if (step == 3) {
                    $(".third_time").text("WAIT");
                    $("#third_step_first_order").text("READY TO");
                    $("#third_step_first_order_right").text("READY TO");
                    $("#third_step_second_order").text("PLAY");
                    $("#third_step_second_order_right").text("PLAY");
                } else if (step == 4) {
                    $(".fourth_time").text("WAIT");
                    $("#fourth_step_first_order").text("READY TO");
                    $("#fourth_step_first_order_right").text("READY TO");
                    $("#fourth_step_second_order").text("PLAY");
                    $("#fourth_step_second_order_right").text("PLAY");
                } else if (step == 5) {
                    $("#top_step_first_order").text("READY TO");
                    $("#top_step_first_order_right").text("READY TO");
                    $("#top_step_second_order").text("PLAY");
                    $("#top_step_second_order_right").text("PLAY");
                }
                getData();
            }
        );
    }
});
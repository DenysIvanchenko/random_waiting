<!DOCTYPE html>
<html lang="en">

<head>
    <title>Setting</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
</head>

<body>

    <div class="container">
        <div class="jumbotron">
            <div class="row">
                <div class="col-sm-4 col-lg-3 col-md-3"></div>
                <div class="col-sm-4 col-lg-6 col-md-6">
                    <h2>Setting</h2>
                    <div id="enter_form">
                        <div class="form-group">
                            <label for="waiting_time">Guest pool list waiting seconds:</label>
                            <input type="number" max="1000" class="form-control" id="waiting_time">
                        </div>
                        <div class="form-group">
                            <label for="countdown_time">Count down seconds:</label>
                            <input type="number" max="1000" class="form-control" id="countdown_time">
                        </div>
                        <br>
                        <button type="button" id="save" class="btn btn-primary">Save</button>
                        <button type="button" id="format" class="btn btn-danger">Clear</button>
                    </div>
                </div>
                <div class="col-sm-4 col-lg-3 col-md-3"></div>
            </div>
        </div>

    </div>
    <script>
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "3000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        $("#save").click(function() {
            save();
        });
        $("#format").click(function(){
            if (confirm("Really clear the data?")){
                $.post(
                    "server.php", {
                        flag: "clear"
                    },
                    function(res) {
                        console.log(res);
                        if (res == "success") {
                            toastr.success("Cleared success.");
                        }
                    }
                );
            }
        });
        getData();

        function save() {
            $.post(
                "server.php", {
                    waiting_time: $("#waiting_time").val(),
                    countdown_time: $("#countdown_time").val(),
                    flag: "setting"
                },
                function(res) {
                    console.log(res);
                    if (res == "success") {
                        //
                        toastr.success("Success.");
                    }
                    getData();
                }
            );
        }

        function getData() {
            $.post(
                "server.php", {
                    flag: "setting_getdata"
                },
                function(res) {
                    $("#waiting_time").val(res.waiting_time);
                    $("#countdown_time").val(res.countdown_time);
                }, "json"
            );
        }
    </script>
</body>

</html>
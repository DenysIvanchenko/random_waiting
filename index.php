<!DOCTYPE html>
<html lang="en">

<head>
    <title>Enter</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="container">
        <div class="jumbotron">
            <div class="row">
                <div class="col-sm-4 col-lg-3 col-md-3"></div>
                <div class="col-sm-4 col-lg-6 col-md-6">
                    <h2>Enter Guest Number</h2>
                    <div id="enter_form">
                        <div class="form-group">
                            <label for="number"></label>
                            <input type="number" max="1000" class="form-control" id="number" placeholder="0001~1000" name="guest_number">
                        </div><br>
                        <button type="button" id="confirm" class="btn btn-primary">Confirm</button>
                    </div>
                </div>
                <div class="col-sm-4 col-lg-3 col-md-3"></div>
            </div>
        </div>

    </div>
    <script>
        $("#confirm").click(function() {
            if ($("[name=guest_number]").val() > 1000 && $("[name=guest_number]").val() >= 1) {
                alert("Please input 1~1000");
            } else {
                add();
            }
        });
        $("#number").keypress(function(event) {
            if (event.keyCode == 13) {
                add();
            }
        });

        function add() {
            $.post(
                "score_board.php", {
                    guest_number: $("[name=guest_number]").val(),
                    date: Math.floor(Date.now() / 1000)
                },
                function(res) {
                    location.href="score_board.php";
                }
            );
        }
    </script>
</body>

</html>
<?php include 'header.php';?>

<body id="login_register">
    <?php include 'nav-bar.php';?>
    <div class="container" >

      <form class="form-signin" role="form" name="login" method="post">
        <h3 align="center" >Please Sign In</h3>

        <div class="form-group">
            <input type="text" name="user" class="form-control flat" placeholder="UCID or Username" required autofocus>
        </div>

        <div class="form-group">
            <input type="password" name="pass" class="form-control flat" placeholder="Password" required>
        </div>

        <label class="checkbox" for="checkbox1">
            <input type="checkbox" name="njit" value="true" data-toggle="checkbox" >
            <span style="color: #1ABC9C;">NJIT login?</span>
        </label>

        <button class="btn btn-embossed btn-primary btn-block" type="submit">Sign in</button>
        <div id="flash" style="color: white;"></div>
    </form>

</div> <!-- /container -->


    <script type="text/javascript" src="js/amalgation.min.js"></script>
    <script type="text/javascript">
    $('form').submit(function(e) {
        e.preventDefault();
        var request = {};
        var formArr = $(this).serializeArray();

        for (var i in formArr) {
            request[formArr[i].name] = formArr[i].value;
        }
        console.log(request);

        $.ajax({
            type: "POST",
            url: "http://web.njit.edu/~jdl38/application_server/app.php/auth",
            data: JSON.stringify(request),
            dataType: "json",

            success: function(data,stat,xhr) {
                console.log("Success: ",data);
                $('#flash').html(data['message']);
            },
            error: function(xhr,stat,err) {
                if (err.status === 401) {
                    console.log("Unauthorized");
                    $('#flash').html("Unauthorized");
                }
            },
        });
    });
    </script>
</body>
</html>

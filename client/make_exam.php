<?php include 'header.php';?>

<body id="login_register">
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

    <div class="row" style="position:absolute; bottom: 20px; width: 80%;">
        <div class="col-md-4">
            <a class="btn btn-hg btn-primary" href="register.php">Register Here!</a>
        </div>
        <div class="col-md-4">
            <a class="btn btn-hg btn-primary" href="make_question.php">Make Questions Here!</a>
        </div>
    </div>

</div> <!-- /container -->


    <script type="text/javascript" src="js/amalgation.min.js"></script>
    <script type="text/javascript">
    $('form').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "<?php echo $APP_SERVER_BASE_URL; ?>/auth",
            data: $('form').serialize(),
            success: function(data,stat,xhr) {
                console.log("Success: ",data);
                $('#flash').html(data['message']);
            },
            error: function(xhr,stat,err) {
                console.log("Fail: ", err);
            },
            dataType: "json"
        });
    });
    </script>
</body>
</html>

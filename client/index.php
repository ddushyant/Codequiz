<?php
$APP_SERVER_BASE_URL = "http://web.njit.edu/~jdl38/application_server/app.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<!-- images/favicon.ico -->">

    <title>CodeQuiz</title>

    <!-- Bootstrap core CSS -->
    <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">

    <!-- Loading Flat UI -->
    <link href="css/flat-ui.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="http://getbootstrap.com/assets/js/ie-emulation-modes-warning.js"></script>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="http://getbootstrap.com/assets/js/ie10-viewport-bug-workaround.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
  </head>

  <body>
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
    </div>
  <div class="row" style="position:absolute; bottom: 20px; width: 80%;">
    <div class="col-md-4">
      <a class="btn btn-hg btn-primary" href="register.php">
        Register Here!
    </a>
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

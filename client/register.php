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

    <div class="container">

        <form class="form-signin" role="form" name="login" method="post" >
            <h3 align="center" >Fill Out This Form</h3>

            <div class="form-group">
                <input type="text" name="user" class="form-control flat" placeholder="Enter Your Cool Username Here..">
            </div>
            
            <div class="form-group">
                <input type="password" name="pass" class="form-control flat" placeholder="Password">
            </div>

            <div class="form-group">
                <input type="password" name="pass" class="form-control flat" placeholder="Confirm Your Password">
            </div>

            <label class="radio">
              <input type="radio" name="sorp" value="1" data-toggle="radio">
              Professor
            </label>

            <label class="radio">
              <input type="radio" name="sorp" value="2" data-toggle="radio" checked>
              Student
            </label>

          <button class="btn btn-embossed btn-primary btn-block" type="submit">Register</button>
          <div id="flash" style="color: white;"></div>
        </form>

  <div class="row" style="position:absolute; bottom: 20px; width: 80%;">
    <div class="col-md-4">
      <a class="btn btn-hg btn-primary" href="index.php">
        Sign In Here!
    </a>
</div>
</div>

</div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- Load JS here for greater good =============================-->
    <script type="text/javascript" src="js/amalgation.min.js"></script>
    <script type="text/javascript">
    $('form').submit(function(e) {
        e.preventDefault();
        console.log($('form').serialize());
        $.ajax({
            type: "POST",
            url: "<?php echo $APP_SERVER_BASE_URL; ?>/register",
            data: $('form').serialize(),
            success: function(data,stat,xhr) {
                $('#flash').html(data['message']);
            },
            error: function(xhr,stat,err) {
                console.log("err", err);
            },
            dataType: "json"
        });
    });
    </script>
</body>
</html>

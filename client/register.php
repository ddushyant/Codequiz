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

      <h3 align="center">Fill Out This Form</h3>
      <form class="form-signin" role="form" name="login" action="http://localhost:3000/app.php/auth" method="post">
        <input type="text" name="user" class="form-control flat" placeholder="Enter Your Cool Username Here..">
        <input type="password" name="pass" class="form-control flat" placeholder="Password">
        <input type="password" name="pass" class="form-control flat" placeholder="Confirm Your Password">

        <button class="btn btn-embossed btn-primary btn-block" type="submit">Register</button>
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
    <script src="js/jquery-1.8.3.min.js"></script>
    <script src="js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="js/jquery.ui.touch-punch.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-select.js"></script>
    <script src="js/bootstrap-switch.js"></script>
    <script src="js/flatui-checkbox.js"></script>
    <script src="js/flatui-radio.js"></script>
    <script src="js/jquery.tagsinput.js"></script>
    <script src="js/jquery.placeholder.js"></script>
    <script type="text/javascript">
        $('form').submit(function(e) {
            e.preventDefault();
            console.log("POSTING!");
            console.log($('form').serialize());
            $.ajax({
                type: "POST",
                url: "http://localhost:3000/app.php/register",
                data: $('form').serialize(),
                success: function(data,stat,xhr) {console.log("SUCCESS");console.log(stat);console.log(data);},
                error: function(xhr,stat,err) {console.log("FAIL");console.log(err);},
                dataType: "json"
            });
        });
    </script>
  </body>
</html>

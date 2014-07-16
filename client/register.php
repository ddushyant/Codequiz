<?php include 'header.php';?>

  <body id="login_register">
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
          <a class="btn btn-hg btn-primary" href="index.php">Sign In Here!</a>
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

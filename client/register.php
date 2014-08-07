<?php include 'header.php';?>

  <body id="login_register">
    <?php include 'nav-bar.php';?>
    <div class="container">
        <form class="form-signin" role="form" name="login" method="post" >
            <h3 align="center" >Fill Out This Form</h3>

            <div class="form-group">
                <input type="text" name="user" class="form-control flat" placeholder="Enter Your Cool Username Here..">
            </div>
            
            <div class="form-group">
                <input type="password" name="pass1" class="form-control flat" placeholder="Password">
            </div>

            <div class="form-group">
                <input type="password" name="pass2" class="form-control flat" placeholder="Confirm Your Password">
            </div>

            <label class="radio">
              <input type="radio" name="sorp" value="instructor" data-toggle="radio">
              Instructor
            </label>

            <label class="radio">
              <input type="radio" name="sorp" value="student" data-toggle="radio" checked>
              Student
            </label>

          <button class="btn btn-embossed btn-primary btn-block" type="submit">Register</button>
          <div id="flash" style="color: white;"></div>
        </form>

</div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- Load JS here for greater good =============================-->
    <script type="text/javascript" src="js/amalgation.min.js"></script>
    <script type="text/javascript">
    $('form').submit(function(e) {
      e.preventDefault();

      var account_type = $("form input[type='radio']:checked").val();
      var user = $("form input[name='user']").val();
      var pass1 = $("form input[name='pass1']").val();
      var pass2 = $("form input[name='pass2']").val();

      var validate_flag = true;

      if (pass1 !== pass2) {
        validate_flag = false;
        alert("Passwords don't match");
      }

      if (user.length === 0 || pass1.length === 0 || pass2.length === 0) {
        validate_flag = false;
        alert("Must fill out all fields");
      }

      if (validate_flag) {
        var request = {
          "user":user,
          "pass":pass1,
          "account_type":account_type
        };
        console.log(request);

          $.ajax({
              type: "POST",
              url: "http://web.njit.edu/~jdl38/application_server/app.php/register",
              data: JSON.stringify(request),
              contentType: "application/json; charset=utf-8",
              dataType: "json",
              success: function(data,stat,xhr) {
                $('#flash').html(data['message']);
                window.location.replace("http://web.njit.edu/~arm32/client");
              },
              error: function(xhr,stat,err) {
                  console.log("err", err);
              },
          });
      }
  });

    </script>
</body>
</html>

<?php include 'header.php';?>

<body id="login_register">
    <div class="container" >
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>Title</th>
                    <th>Spec</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="table-data-elem"><button style="btn">Add</button></td>
                </tr>
                <tr>
                    <td class="table-data-elem"><button style="btn">Add</button></td>
                </tr>
                <tr>
                    <td class="table-data-elem"><button style="btn">Add</button></td>
                </tr>
                <tr>
                    <td class="table-data-elem"><button style="btn">Add</button></td>
                </tr>
                <tr>
                    <td class="table-data-elem"><button style="btn">Add</button></td>
                </tr>
                <tr>
                    <td class="table-data-elem"><button style="btn">Add</button></td>
                </tr>
                <tr>
                    <td class="table-data-elem"><button style="btn">Add</button></td>
                </tr>
                <tr>
                    <td class="table-data-elem"><button style="btn">Add</button></td>
                </tr>
                <tr>
                    <td class="table-data-elem"><button style="btn">Add</button></td>
                </tr>
                <tr>
                    <td class="table-data-elem"><button style="btn">Add</button></td>
                </tr>
            </tbody>
        </table>
        <ul class="pager">
          <li class="previous"><a href="#">&larr; Prev</a></li>
          <li class="next"><a href="#">Next &rarr;</a></li>
      </ul>

      <div id="exam-body" class="">
        DYNAMICALLY UPDATING FORM HERE!
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

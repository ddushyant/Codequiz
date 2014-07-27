<?php include('header.php'); ?>

<body>
<?php include('nav-bar.php'); ?>
    <div class="container" >

        <div class="row">
            <!-- END SELECT BOX REPLACEMENT -->
            <div class="col-8">
                <table class="qtable">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Link</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="row1">
                            <td class="table-data-elem"></td>
                            <td class="table-data-elem"></td>
                        </tr>
                        <tr id="row2">
                            <td class="table-data-elem"></td>
                            <td class="table-data-elem"></td>
                        </tr>
                        <tr id="row3">
                            <td class="table-data-elem"></td>
                            <td class="table-data-elem"></td>
                        </tr>
                        <tr id="row4">
                            <td class="table-data-elem"></td>
                            <td class="table-data-elem"></td>
                        </tr>
                        <tr id="row5">
                            <td class="table-data-elem"></td>
                            <td class="table-data-elem"></td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <div class="btn-group">
                  <button id="prev" class="btn">&larr; Prev</button>
                  <button id="next" class="btn">Next &rarr;</button>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript" src="js/amalgation.min.js"></script>
<script>

var exams;
function setup() {
  for (var i = 1; i < 6; i++) {
    if (exams.length >0) {
      var tr = $('#row' + i.toString());
      var td = $(tr).find("td");
      $(td[0]).text(exams[0].title);
      $(td[1]).html("<a href='http://web.njit.edu/~arm32/client/take_exam.php?exam_id="+exams[0].id.toString()+"'>Exam " + exams[0].id.toString() + "</a>");
      exams.shift();
    }else {
      console.log("NO EXAMS");
      break;
    }
  }
}
    $.ajax({
      type: "GET",
      url: "http://web.njit.edu/~jdl38/application_server/app.php/exam?n=20",
      dataType: "json",
      xhrFields: {
        withCredentials: true
      },
      success: function(d) {
        exams = d['exams'];
        console.log(exams);
        setup();
      },
        error: function(e) {
          console.warn("Could not retrieve data");
      }
    });


</script>
</body>
</html>


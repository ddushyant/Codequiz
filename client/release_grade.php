<?php include('header.php'); ?>


<body>
    <?php include('nav-bar.php');?>
    <div class="container" >
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                <table class="qtable">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Exam</th>
                            <th>Grade</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-2">
            </div>
        </div>
    </div>  <!-- container -->
    <script type="text/javascript" src="js/amalgation.min.js"></script>
<script>
    $.ajax({
        type: "GET",
        url: "http://web.njit.edu/~jdl38/application_server/app.php/grade",
        dataType: "json",
        success: function(d) {
            var results = d['pending_results'];
            console.log(results);
            $('tbody').find("tr").each(function(i) {
                if (results.length) {
                    var r = results.pop();
                    var tds = $(this).find("td");
                    $(tds[0]).text(r.username);
                    $(tds[1]).text(r.exam_title);
                    $(tds[2]).text(r.score + " / " + r.total);
                    var btn = $("<button>");
                    btn.addClass("release");
                    btn.data("student",r.student_id);
                    btn.data("exam", r.exam_id);
                    btn.data("taken_at", r.taken_at);
                    btn.text("Release");
                    $(tds[3]).html(btn);
                    register_handlers();
                }
            });
        },
        error: function(e) {
            console.log("ERRPR");
        }
    });

    function register_handlers() {
        $('tr').unbind('click').on('click', '.release', function(e) {
            var request = {
                student: $(this).data("student"),
                exam: $(this).data("exam"),
                taken_at: $(this).data("taken_at"),
            };
            var self = $(this);
            $.ajax({
                type: "PATCH",
                url: "http://web.njit.edu/~jdl38/application_server/app.php/grade",
                data: JSON.stringify(request),
                dataType: "json",
                success: function(d) {
                    // JON FIX THIS
                    console.log(d);
                    $('tbody').append("<tr><td></td><td></td><td></td></tr>");
                    self.parent().parent().remove();
                },
                error: function(e) {
                    $('tbody').append("<tr><td></td><td></td><td></td></tr>");
                    self.parent().parent().remove();
                }
            });
        });
    }
</script> 
<?php include('footer.php');?>
</body>
</html>

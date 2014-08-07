<?php include 'header.php';?>

<body>
<?php include 'nav-bar.php';?>
    <div class="container" >
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                <table class="qtable">
                    <thead>
                        <tr>
                        <th>
                        Exam
                        </th>
                        <th>
                        Score
                        </th>
                        <th>
                        Date Taken
                        </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
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
    </div>
<script type="text/javascript" src="js/amalgation.js"></script>
<script>
        $.ajax({
            type: "GET",
            url: "http://web.njit.edu/~jdl38/application_server/app.php/grade",
            dataType: "json",
            success: function(d) {
                var results = d['grades'];
                var grades = [];
                results.forEach(function() {
                    grades.push([]);
                });

                $('tbody').find("tr").each(function(i) {
                    if (results.length) {
                        var r = results.pop();
                        var tds = $(this).find("td");
                        var uri = "review.php" + "?exam=" + r.exam_id + "&taken_at=" + r.taken_at;
                        $(tds[0]).html(
                            "<a href='http://web.njit.edu/~arm32/client/" 
                            + (uri)
                            + "'>" 
                            + r.exam_title 
                            + "</a>"
                        );
                        $(tds[1]).text(r.score + " / " + r.total);
                        $(tds[2]).text(r.taken_at);
                    }
                });
            },
            error: function(e) {
                console.log("ERROR",e);
            }
        }); 
    </script>

    <?php include('footer.php');?>
</body>
</html>

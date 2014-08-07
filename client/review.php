<?php include('header.php'); ?>
<body>
    <style>
        pre{
            height: auto;
        }
        hr{
            border-color: black;
            border-width: 3px;
        }
    </style>
    <?php include('nav-bar.php');?>
    <div class="container" >
        <ol id="review">
        </ol>
    </div>
    <script src="js/amalgation.js"></script>

<script>
        var params = {
            taken_at: "<?php echo $_GET['taken_at']; ?>",
        };

        $.ajax({
            type: "GET",
            url: "http://web.njit.edu/~jdl38/application_server/app.php/examreview/<?php echo $_GET['exam']?>",
            data: params,
            dataType: "json",
            success: function(d) {
                var review = $('#review');
                var examanswers = d['examanswers'];
                examanswers.forEach(function(e,i,a) {
                    var answer_li = $("<li>");
                    var display_span0 = $("<p>");
                    var display_span1 = $("<p>");
                    var display_span2 = $("<p>");
                    var display_span3 = $("<p>");
                    var display_span4 = $("<p>");

                    var on_errors = e.answer.split("ERR:");

                    if (on_errors.length === 2) {
                        e.answer = on_errors[0];
                    }
                    display_span0.html("<strong>You were:</strong><br>&nbsp;" + (e.correct === "1" ? "Correct&nbsp;<span class='fui-check'></span>": "Not Correct&nbsp;<span class='fui-cross'></span>"));
                    display_span1.html("<strong>Question:</strong><br>&nbsp;" + e.spec);
                    display_span2.html("<strong>You Answered:</strong>&nbsp;<pre style='background-color:" + (e.correct === "1" ? "#2ECC71" : "#FBB") + "'><code>" + e.answer + "</code></pre>");
                    display_span3.html("<strong>Correct Answer:</strong>&nbsp;<pre style='background-color: #2ECC71'><code>" + e.correct_answer + "</code></pre>");
                    display_span4.html("<strong>Feedback:</strong>&nbsp;<pre><code>" + e.feedback + '</code></pre><hr>');

                    answer_li.append(display_span1);
                    answer_li.append(display_span0);
                    answer_li.append(display_span2);
                    answer_li.append(display_span3);
                    answer_li.append(display_span4);

                    if (on_errors.length === 2 && on_errors[1].replace(/ /g,'').length) {
                        var display_span5 = $("<p>");
                        display_span5.html("<strong>Errors:</strong><br>&nbsp;<pre><code>" + on_errors[1] + "</code></pre>");
                        answer_li.append(display_span5);
                    }
                    review.append(answer_li);
                });
            },
            error: function(e) {
            }
        });
    </script>
    <?php include('footer.php');?>
</body>

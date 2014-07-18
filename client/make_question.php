<?php include 'header.php';?>

<body>

    <div class="container">

        <form class="question-form" role="form" name="question_maker" method="post" >
            <h3 align="center" >Exam Question Form</h3>

            <div class="form-group">
                <input type="text" name="question_title" class="form-control flat" placeholder="Enter Question Title...">
            </div>
            
            <div class="form-group">
            <textarea class="form-control flat" name="question_body" rows="3" placeholder="Enter Question Body..."></textarea>
            </div>

            <div class="btn-group form-group">
                <div class="dropdown">
                  <button class="btn dropdown-toggle btn-info" data-toggle="dropdown"><span id="lang">Select Language</span><span class="caret"></span></button>
                  <span class="dropdown-arrow"></span>
                  <ul id="sub" name="subject" class="dropdown-menu">
                    <li><a href="#">Javascript</a></li>
                    <li><a href="#">Python</a></li>
                    <li><a href="#">Java</a></li>
                  </u>
                </div>
            </div>

            <div class="btn-group form-group">
                <div class="dropdown">
                  <button class="btn dropdown-toggle btn-info" data-toggle="dropdown"><span id="subject">Select Subject</span><span class="caret"></span></button>
                  <span class="dropdown-arrow"></span>
                  <ul id="sub" name="subject" class="dropdown-menu">
                    <li><a href="#">Variables</a></li>
                    <li><a href="#">Syntax</a></li>
                    <li><a href="#">Classes</a></li>
                  </u>
                </div>
            </div>

            <div class="btn-group form-group">
				<div class="dropdown">
					<button class="btn dropdown-toggle btn-info" data-toggle="dropdown"><span id="select">Select Question Type</span><span class="caret"></span></button>
					<span class="dropdown-arrow"></span>
                    <ul class="dropdown-menu">
						<li><a href="#" id="action-1" value="multi">Multiple Choice</a></li>
						<li><a href="#" id="action-2" value="true-false">True/False</a></li>
						<li><a href="#" id="action-3" value="open">Open Ended Question</a></li>
						<li><a href="#" id="action-4" value="coding">Coding Question</a></li>
					</ul>
				</div>
			</div>

			<div id="mult">
			</div>

          <button class="btn btn-embossed btn-primary btn-block" type="submit">Submit Question</button>
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

        $(".dropdown-menu li a").click(function(){

          $(this).parents(".btn-group").find('#lang').text($(this).text());
          $(this).parents(".btn-group").find('#lang').val($(this).text());
          $(this).parents(".btn-group").find('#select').text($(this).text());
          $(this).parents(".btn-group").find('#select').val($(this).text());
          $(this).parents(".btn-group").find('#subject').text($(this).text());
          $(this).parents(".btn-group").find('#subject').val($(this).text());

        });

	    jQuery("#action-1").click(function(e){
	    	$("#mult").html("");
			$("#mult").append('<div class="form-group"><input type="text" name="mult_answer" class="form-control flat" placeholder="Enter Correct Answer Here" required autofocus></div>');
			$("#mult").append('<div class="form-group"><input type="text" name="opt1" class="form-control flat" placeholder="Option 1" required></div>');
			$("#mult").append('<div class="form-group"><input type="text" name="opt2" class="form-control flat" placeholder="Option 2" required autofocus></div>');
			$("#mult").append('<div class="form-group"><input type="text" name="opt3" class="form-control flat" placeholder="Option 3" required></div>'); 
            $("#mult").append("<input id='qtype' type='hidden' name='qtype' value='multi'>");
		});

	    jQuery("#action-2").click(function(e){
	    	$("#mult").html("");
            $("#mult").append('<label class="radio checked"><span class="icons"><span class="first-icon fui-radio-unchecked"></span><span class="second-icon fui-radio-checked"></span></span><input type="radio" name="group1" value="True" data-toggle="radio" checked>Answer is True</label>');
            $("#mult").append('<label class="radio"><span class="icons"><span class="first-icon fui-radio-unchecked"></span><span class="second-icon fui-radio-checked"></span></span><input type="radio" name="group1" value="False" data-toggle="radio">Answer is False</label>');
            $("#mult").append("<input id='qtype' type='hidden' name='qtype' value='true-false'>");
		});

		jQuery("#action-3").click(function(e){
			$("#mult").html("");
			$("#mult").append('<div class="form-group"><input type="text" name="open_answer" class="form-control flat" placeholder="Enter Correct Answer Here" required autofocus></div>');
            $("#mult").append("<input id='qtype' type='hidden' name='qtype' value='open'>");
		});

		jQuery("#action-4").click(function(e){
			$("#mult").html("");
	        $("#mult").append('<div class="form-group"><input type="text" name="code_answer" class="form-control flat" placeholder="Enter the Desired Output" required autofocus></div>');
            $("#mult").append("<input id='qtype' type='hidden' name='qtype' value='coding'>");
		});
	</script>

	 <script type="text/javascript">
    $('form').submit(function(e) {
        e.preventDefault();

        var request = {};

        var acc = [];
        var obj = {};

        $("#mult input:not([type='radio'],[type='hidden'])").each(function(iter) {
            

            obj = {
                'answer_key' : iter,
                'answer_value' : this.value
            };
            
            
            acc.push(obj);
        });

        var group1 = $("#mult input[name='group1']:checked");

        if (group1.length > 0) {
            acc.push({
                "answer_key":"tf",
                "answer_value":group1.val()
            });
        }

        var qtype = $('#qtype');

        request['title'] = $("form input[name='question_title']").val();
        request['body'] = $("form textarea[name='question_body']").val();
        request['language'] = $("form span[id='lang']").text().toLowerCase();
        request['subject'] = $("form span[id='subject']").text().toLowerCase();
        request['qtype'] = qtype.val();
        request['answers'] = acc;


        $.ajax({
            type: 'POST',
            url: '/test.php',
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            data: JSON.stringify(request),
            success: function(data,stat,xhr) {
                $('#flash').html(data['message']);
            },
            error: function(xhr,stat,err) {
                console.log("err", err);
            },
        });


    });
    </script>
   
</body>
</html>

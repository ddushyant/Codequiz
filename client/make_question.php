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

            <div class="form-group">
				<div class="btn-group">
					<button class="btn dropdown-toggle btn-info" data-toggle="dropdown">Select Question Type</button>
					<ul class="dropdown-menu">
						<li><a href="#" id="action-1">Multiple Choice</a></li>
						<li><a href="#" id="action-2">True/False</a></li>
						<li><a href="#" id="action-3">Open Ended Question</a></li>
						<li><a href="#" id="action-4">Coding Question</a></li>
					</ul>
				</div>
			</div>

			<div id="mult">

			</div>

			<!-- <div id="torf" style="display: none;">
				<label class="radio">
				  <input type="radio" name="group1" value="1" data-toggle="radio" checked>
				  <span style="color:white">Answer is True</span>
				</label>

				<label class="radio">
				  <input type="radio" name="group1" value="2" data-toggle="radio">
				  <span style="color:white">Answer is False</span>
				</label>
			</div>

			<div id="openq" style="display: none;">
				<div class="form-group">
		            <input type="text" name="open_answer" class="form-control flat" placeholder="Enter Correct Answer Here" required autofocus>
		        </div>
			</div>

			<div id="codeq" style="display: none;">
				<div class="form-group">
		            <input type="text" name="code_answer" class="form-control flat" placeholder="Enter the Desired Output" required autofocus>
		        </div>
			</div> -->

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

    	var mult = document.getElementById("mult");
    	var torf = document.getElementById("torf");
    	var openq = document.getElementById("openq");
    	var codeq = document.getElementById("codeq");

	    jQuery("#action-1").click(function(e){
	    	$("#mult").html("");
			$("#mult").append('<div class="form-group"><input type="text" name="mult_answer" class="form-control flat" placeholder="Enter Correct Answer Here" required autofocus></div>');
			$("#mult").append('<div class="form-group"><input type="text" name="opt1" class="form-control flat" placeholder="Option 1" required></div>');
			$("#mult").append('<div class="form-group"><input type="text" name="opt2" class="form-control flat" placeholder="Option 2" required autofocus></div>');
			$("#mult").append('<div class="form-group"><input type="text" name="opt3" class="form-control flat" placeholder="Option 3" required></div>'); 
		});

	    jQuery("#action-2").click(function(e){
	    	$("#mult").html("");
	    	$("#mult").append('<label class="radio"><input type="radio" name="group1" value="1" data-toggle="radio" checked><span style="color:white">Answer is True</span></label><label class="radio"><input type="radio" name="group1" value="2" data-toggle="radio"><span style="color:white">Answer is False</span></label>');
		});

		jQuery("#action-3").click(function(e){
			$("#mult").html("");
			$("#mult").append('<div class="form-group"><input type="text" name="open_answer" class="form-control flat" placeholder="Enter Correct Answer Here" required autofocus></div>');
		});

		jQuery("#action-4").click(function(e){
			$("#mult").html("");
	        $("#mult").append('<div class="form-group"><input type="text" name="code_answer" class="form-control flat" placeholder="Enter the Desired Output" required autofocus></div>');
		});
	</script>

	 <script type="text/javascript">
    $('form').submit(function(e) {
        e.preventDefault();
        console.log($('form').serialize());
        $.ajax({
            type: "POST",
            url: "http://localhost:3000/app.php/questionmaker",
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

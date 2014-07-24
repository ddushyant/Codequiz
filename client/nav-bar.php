<?php
	function curPageURL() {
		$pageURL = 'http';

		if ($_SERVER["HTTPS"] == "on") {
			$pageURL .= "s";
		}

		$pageURL .= "://";

		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}

		return $pageURL;
	}
?>

<?php
	function curPageName() {
		return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
	}

	$user_name = 'Arthur Maciejewicz';
	$viz1 = 'inline';
	$home_url = '/index.php';

	if (curPageName() == 'index.php'){ 
		$first_li_class = 'active';
		$viz2 = 'none';
		$home_url = '/make_exam.php';
	} else { 
		$first_li_class = 'none'; 
	}
	if (curPageName() == 'register.php'){ 
		$second_li_class = 'active';
		$viz2 = 'none';
		$home_url = '/make_exam.php';
	} else { 
		$second_li_class = 'none'; 
	}
	if (curPageName() == 'make_exam.php'){ 
		$exam_li_class = 'active';
		$viz1 = 'none';
	} else { 
		$exam_li_class = 'none';
	}
	if (curPageName() == 'make_question.php'){ 
		$question_li_class = 'active';
		$viz1 = 'none';
	} else { 
		$question_li_class = 'none';
	}
?>

<nav class="navbar navbar-inverse nav-bar-placement" role="navigation">
	<div class="navbar-header">
	    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-01">
	      <span class="sr-only">Toggle navigation</span>
	    </button>
   		<a class="navbar-brand" href="<?echo $home_url ?>">CodeQuiz</a>
  	</div>
  	<div class="collapse navbar-collapse">
		<ul class="nav navbar-nav" style="display:<?echo $viz1 ?>;">           
			<li class="<?echo $first_li_class;?>"><a href="/index.php">Login</a></li>
			<li class="<?echo $second_li_class;?>"><a href="/register.php">Register</a></li>
		</ul>
		<ul class="nav navbar-nav" style="display:<?echo $viz2 ?>;">           
			<li class="<?echo $exam_li_class;?>"><a href="/make_exam.php">Make Exam</a></li>
			<li class="<?echo $question_li_class;?>"><a href="/make_question.php">Make Question</a></li>
		</ul>
		<p class="navbar-text navbar-right">Signed in as <a class="navbar-link" href="#"><?echo $user_name ?></a></p>
	</div>
</nav>
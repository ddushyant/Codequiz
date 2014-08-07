<?php
	function curPageName() {
		return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
  }

  $url = "http://web.njit.edu/~arm32/client";

	$viz1 = 'inline';
	$home_url = $url . '/index.php';

	if (curPageName() == 'index.php'){ 
		$first_li_class = 'active';
        $viz2 = 'none';
        $viz3 = 'none';
		$home_url = $url . '/index.php';
	} else { 
		$first_li_class = 'none'; 
    }

	if (curPageName() == 'register.php'){ 
		$second_li_class = 'active';
        $viz2 = 'none';
        $viz3 = 'none';
		$home_url = $url. '/index.php';
	} else { 
		$second_li_class = 'none'; 
    }

    if (curPageName() == 'make_exam.php' || curPageName() == 'dash_instructor.php'){ 

        if(curPageName() == 'dash_instructor.php') { 
            $exam_li_class = 'none';
        } else { 
            $exam_li_class = 'active';
        }

        $viz1 = 'none';
        $viz3 = 'none';
		$home_url = $url. '/dash_instructor.php';
        $user_name = 'You are signed in as an Instructor';
	} else { 
		$exam_li_class = 'none';
    }

	if (curPageName() == 'make_question.php'){ 
		$question_li_class = 'active';
        $viz1 = 'none';
        $viz3 = 'none';
        $user_name = 'You are signed in as an Instructor';
        $home_url = $url. '/dash_instructor.php';
	} else { 
		$question_li_class = 'none';
    }

    /* I EDITED THIS JON TAKE NOTE! -- Arthur */
    if (curPageName() === "release_grade.php") {
        $grades_li_class = 'active';
        $viz1 = 'none';
        $viz3 = 'none';
        $user_name = 'You are signed in as an Instructor';
        $home_url = $url. '/dash_instructor.php';
    }else {
        $grades_li_class = "none";
    }

  if(curPageName() == 'show_exam.php' || curPageName() == 'dash_student.php'){
    if(curPageName()== 'dash_student.php'){ $show_li_class = 'none';
    } else { $show_li_class = 'active';}
    $review = 'none';
    $viz1 = 'none';
    $viz2 = 'none';
  	$user_name = 'You are signed in as a Student';
    $home_url = $url. '/dash_student.php';
  } else {
    $graded_li_class = 'none';
  }
  if(curPageName() == 'graded.php'){
    $graded_li_class = 'active';
    $review = 'none';
    $viz1 = 'none';
    $viz2 = 'none';
  	$user_name = 'You are signed in as a Student';
    $home_url = $url. '/dash_student.php';
  } else {
    $take_li_class = 'none';
  }
  if(curPageName() == 'take_exam.php'){
    $graded_li_class = 'none';
    $review = 'none';
    $viz1 = 'none';
    $viz2 = 'none';
  	$user_name = 'You are signed in as a Student';
    $home_url = $url. '/dash_student.php';
  } else {
    $take_li_class = 'none';
  }
  if(curPageName() == 'review.php'){
    $review_li_class = 'active';
    $viz1 = 'none';
    $viz2 = 'none';
  	$user_name = 'You are signed in as a Student';
    $home_url = $url. '/dash_student.php';
  } else {
    $review_li_class = 'none';
  }
?>

<nav class="navbar navbar-inverse nav-bar-placement" role="navigation">
	<div class="navbar-header">
	    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-01">
	      <span class="sr-only">Toggle navigation</span>
	    </button>
      <a class="navbar-brand" href="<?php echo $home_url; ?>">CodeQuiz</a>
  	</div>
  	<div class="collapse navbar-collapse">
		<ul class="nav navbar-nav" style="display:<?php echo  $viz1 ?>;">           
    <li class="<?php echo $first_li_class;?>"><a href="<?php echo $url ?>/index.php">Login</a></li>
    <li class="<?php echo $second_li_class;?>"><a href="<?php echo $url ?>/register.php">Register</a></li>
		</ul>
		<ul class="nav navbar-nav" style="display:<?php  echo $viz2 ?>;">           
    <li class="<?php echo $exam_li_class;?>"><a href="<?php echo $url ?>/make_exam.php">Make Exam</a></li>
    <li class="<?php echo $question_li_class;?>"><a href="<?php echo $url ?>/make_question.php">Make Question</a></li>
    <li class="<?php echo $grades_li_class;?>"><a href="<?php echo $url ?>/release_grade.php">Release Grade</a></li>
		</ul>
		<ul class="nav navbar-nav" style="display:<?php  echo $viz3 ?>;">           
    <li class="<?php echo $show_li_class;?>"><a href="<?php echo $url ?>/show_exam.php">Take Exam</a></li>
    <li class="<?php echo $graded_li_class;?>"><a href="<?php echo $url ?>/graded.php">Graded Exam</a></li>
    <li class="<?php echo $review_li_class;?>" style="display: <?php echo $review ?>"><a href="<?php echo $url ?>/review.php">Review Exams</a></li>
		</ul>
        
        <?php if($viz2 ==='none' && $viz3 === 'none') : ?>
        <?php else : ?>
            <button id="logout" class="btn btn-default btn-sm" style="float:right; margin-top: 7px;">Log Out</button>
        <?php endif; ?>

        <p class="navbar-text navbar-right" style="margin-right: 10px;"><?php echo $user_name ?></p>
	</div>
</nav>

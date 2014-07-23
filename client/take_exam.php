<?php include('header.php'); ?>

<body>
    <?php include 'nav-bar.php';?>
    <div id="fill-question" class="row" style="display:none">
    	<input placeholder="Fill in the blank"></input>
    </div>

    <div id="coding-question" class="row" style="display:none">
    	Code
    	<textarea placeholder="write code here"></textarea>
    </div>

	<div id="multiple-question" class="row" style="display:none">
		<div class="col-xs-3">
          <label class="radio checked">
            <span class="icons"><span class="first-icon fui-radio-unchecked"></span><span class="second-icon fui-radio-checked"></span></span><input name="optionsRadios1" id="optionsRadios1" value="option1" data-toggle="radio" type="radio">
            Radio is off
          </label>
          <label class="radio">
            <span class="icons"><span class="first-icon fui-radio-unchecked"></span><span class="second-icon fui-radio-checked"></span></span><input name="optionsRadios1" id="optionsRadios2" value="option1" data-toggle="radio" type="radio">
            Radio is on
          </label>
        </div>

    </div>
<br><br><br><br>
    <div id="truefalse-question" class="row" style="display:none">
    	True False<br><br>
    	<div class="col-xs-3">
          <label class="radio checked">
            <span class="icons"><span class="first-icon fui-radio-unchecked"></span><span class="second-icon fui-radio-checked"></span></span><input name="optionsRadios2" id="optionsRadios3" value="option2" data-toggle="radio" type="radio">
            Radio is off
          </label>
          <label class="radio">
            <span class="icons"><span class="first-icon fui-radio-unchecked"></span><span class="second-icon fui-radio-checked"></span></span><input name="optionsRadios2" id="optionsRadios4" value="option2" data-toggle="radio" type="radio">
            Radio is on
          </label>
        </div>
    </div>

    <h3>Take Exams Here</h3>

    <form id="exam">
    	<br><br><br><br>
    	<button id="prev" type="button">Prev</button>
    	<button id="next" type="button">Next</button>
    </form>

    <script type="text/javascript" src="js/amalgation.js"></script>

    <script>
    var RangeIterator,
    __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

    RangeIterator = (function() {
    	function RangeIterator(min, max, shift) {
    		this.min = min;
    		this.max = max;
    		this.shift = shift;
    		this.decrement = __bind(this.decrement, this);
    		this.increment = __bind(this.increment, this);
    		this.curidx = 0;
    	}

    	RangeIterator.prototype.increment = function() {
    		if (this.curidx + this.shift <= this.max) {
    			return this.curidx += this.shift;
    		}else {
    			return this.curidx;
    		}
    	};

    	RangeIterator.prototype.decrement = function() {
    		if (this.curidx - this.shift >= this.min) {
    			return this.curidx -= this.shift;
    		}else {
    			return this.curidx;
    		}
    	};

    	RangeIterator.prototype.val = function() {
    		return this.curidx;
    	}

    	return RangeIterator;

    })();


    var exam_data = {
    	"status": "success",
    	"message": "",
    	"title":"My first exam",
    	"questions": [{
    		"title": "Bee Stings",
    		"spec": "Float like a butterfly, sting like a: ____",
    		"qtype": "fill",
    		"weight": 5,
    		"id": 5,
    		"feedback": "",
    		"answers": [{
    			"answer_key": "A",
    			"answer_value": "Bee",
    			"correct": true
    		}]
    	}, {
    		"title": "Knee Socks",
    		"spec": "Which of these is the name of the Arctic Monkeys lead singer?",
    		"qtype": "multiple",
    		"weight": 5,
    		"id": 5,
    		"feedback": "",
    		"answers": [{
    			"answer_key": "A",
    			"answer_value": "Jared Leto",
    			"correct": false
    		}, {
    			"answer_key": "A",
    			"answer_value": "Axton Lee",
    			"correct": false
    		}, {
    			"answer_key": "A",
    			"answer_value": "I don't know, I forget his name",
    			"correct": true
    		}, {
    			"answer_key": "A",
    			"answer_value": "Foobar Jamaica",
    			"correct": false
    		}, ]
    	},

    	]
    };

    var fill_question_miniform = $('#fill-question');
    var coding_question_miniform = $('#coding-question');
    var multiple_question_miniform = $('#multiple-question');
    var truefalse_question_miniform = $('#truefalse-question');

    var exam = $('#exam');
    var questions = exam_data['questions'];

    var cur_idx = new RangeIterator(0, questions.length - 1, 1);

    $('#next').click(function(e) {
    	cur_idx.increment();
    });

    $('#prev').click(function(e) {
    	cur_idx.decrement();
    });


    exam_data['questions'].forEach( function (question, idx, questions) {
    	var dup;
    	miniform_id = question['qtype'];
    	switch(miniform_id) {
    		case "fill":
    			dup = fill_question_miniform.clone();
    			break;
    		case "multiple":
    			dup = multiple_question_miniform.clone();
    			break;
    		case "coding":
    			dup = coding_question_miniform.clone();
    			break;
    		case "truefalse":
    			dup = coding_question_miniform.clone();
    			break;
    		default:
    			// ignore
    			break;
    	}

    	dup.attr('id','');
    	dup.attr('style','');

    	exam.prepend(dup);

    });
    	
    </script>


    

    
</body>
</html>
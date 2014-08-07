<?php include('header.php'); ?>

<?php if (isset($_GET['exam_id'])): ?>
<style>
textarea {
  height: 600px;
  width: 100%;
  max-width: 100%;
  white-space: pre;
}
</style>
<body>
    <?php include 'nav-bar.php';?>
    <div id="fill-question" class="row" style="display:none" data-questiontype="fill">
    	<input name="answer" placeholder="Fill in the blank"></input>
    </div>

    <div id="coding-question" class="row" style="display:none" data-questiontype="coding">
      <table class="table table-bordered table-striped">
        <thead>
          <tr><th>Input</th><th>Output</th></tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    	<textarea name="answer" placeholder="write code here"></textarea>
    </div>

	<div id="multiple-question" class="row" style="display:none" data-questiontype="multiple">
		<div class="col-8">
          <label class="radio checked">
            <span class="icons"><span class="first-icon fui-radio-unchecked"></span><span class="second-icon fui-radio-checked"></span></span><input name="optionsRadios1" id="optionsRadios1" value="option1" data-toggle="radio" type="radio">
          </label>
          <label class="radio">
            <span class="icons"><span class="first-icon fui-radio-unchecked"></span><span class="second-icon fui-radio-checked"></span></span><input name="optionsRadios1" id="optionsRadios2" value="option1" data-toggle="radio" type="radio">
          </label>
          <label class="radio">
            <span class="icons"><span class="first-icon fui-radio-unchecked"></span><span class="second-icon fui-radio-checked"></span></span><input name="optionsRadios1" id="optionsRadios1" value="option1" data-toggle="radio" type="radio">
          </label>
          <label class="radio">
            <span class="icons"><span class="first-icon fui-radio-unchecked"></span><span class="second-icon fui-radio-checked"></span></span><input name="optionsRadios1" id="optionsRadios1" value="option1" data-toggle="radio" type="radio">
          </label>
        </div>
    </div>
    <div id="true-false-question" class="row" style="display:none" data-questiontype="true-false">
    	<div class="col-xs-3">
          <label class="radio checked">
            <span class="icons"><span class="first-icon fui-radio-unchecked"></span><span class="second-icon fui-radio-checked"></span></span><input name="optionsRadios2" id="optionsRadios3" value="true" data-toggle="radio" type="radio">
          True
          </label>
          <label class="radio">
            <span class="icons"><span class="first-icon fui-radio-unchecked"></span><span class="second-icon fui-radio-checked"></span></span><input name="optionsRadios2" id="optionsRadios4" value="false" data-toggle="radio" type="radio">
            False
          </label>
        </div>
    </div>
  <div class="col-xs-6 col-md-4">
    <button id="prev" style="float: right" type="button" class="btn">Prev</button>
  </div>
  <div class="col-xs-6 col-md-4">
<div class="progress">
  <div id="progress-bar" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
    0%
  </div>
</div>
<div id="question">
</div>
  </div>
  <div class="col-xs-6 col-md-4">
    <button id="next" type="button" class="btn">Next</button>
  </div>

    <script type="text/javascript" src="js/amalgation.js"></script>

<script>
  $.valHooks.textarea = {
    get: function( elem ) {
    return elem.value.replace( /\r?\n/g, "\r\n" );
  }};

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


    var Queue;

    Queue = (function () {
        function Queue() {
            this._size = 0;
            this._storage = [];
        }

        Queue.prototype.push = function (elem) {
            this._size++;
            return this._storage.push(elem);
        };

        Queue.prototype.pop = function () {
            if (this._size > 0) {
                this._size--;
                this._storage.shift();
            }
            return null;
        };

        Queue.prototype.front = function () {
            if (this._size > 0) {
                return this._storage[0];
            }
            return null;
        }

        Queue.prototype.back = function () {
            if (this._size > 0) {
                return this._storage[this._size - 1];
            }
            return null;
        }

        Queue.prototype.empty = function () {
            return this._size === 0;
        };

        Queue.prototype.size = function () {
            return this._size;
        };

        return Queue;

    })();


    var fill_question_miniform = $('#fill-question');
    var coding_question_miniform = $('#coding-question');
    var multiple_question_miniform = $('#multiple-question');
    var truefalse_question_miniform = $('#true-false-question');

    var question_elem = $('#question');
    var next = $('#next');
    var prev= $('#prev');

    function render_question(question) {
    	var dup;
    	miniform_id = question['qtype'];
    	switch(miniform_id) {
    		case "fill":
    			dup = fill_question_miniform.clone();
    			break;
    		case "multiple":
                dup = multiple_question_miniform.clone();
                var answers = question.answers;
                dup.find("label").each(function(i,e) {
                    $(this).append("<pre>" + answers[i].answer_value + "</pre>");
                });

                dup.find("input").each(function(i,e) {
                    if (i === 0) $(this).prop('checked',true);
                    $(this).val(answers[i].answer_value);
                });
    			break;
    		case "coding":
          dup = coding_question_miniform.clone();
          var tbody = dup.find("tbody");
          var trow;
          var tdi,tdo;
          var answers = question.answers;

          answers.forEach(function(e,i,a) {
            trow = $('<tr>');
            tdi   = $('<td>');
            tdo   = $('<td>');
            tdi.text(answers[i].answer_key);
            tdo.text(answers[i].answer_value);
            trow.append(tdi);
            trow.append(tdo);
            tbody.append(trow);
          });

    			break;
        case "true-false":
          dup = truefalse_question_miniform.clone();
          var first = dup.find("input")[0];
          $(first).prop('checked',true);
    			break;
    		default:
    			// ignore
    			break;
    	}

      dup.data("questionid",question.id);
    	dup.attr('id','');
      dup.attr('style','');
      var label = $('<h5>');
      label.text(question.title);

      var spec = $('<p>');
      spec.text(question.spec);

      question_elem.html("");
      question_elem.append(label);
      question_elem.append(spec);
      question_elem.append(dup);
    }

    var answer_data = {};

    function get_answer_data() {
      console.log("GETTING DATA");
      var row = question_elem.find(".row");
      var qid = row.data("questionid");
      var qtype = row.data("questiontype");

      var answer = {
        "qtype":qtype,
      };

    	switch(qtype) {
      case "fill":
            answer['value'] = question_elem.find("input").val();
            break;
          case "multiple":
            answer['value'] = question_elem.find("input:checked").val();
            break;
          case "coding":
            answer['value'] = question_elem.find("textarea").val();
            break;
          case "true-false":
            answer['value'] = question_elem.find("input:checked").val();
            break;
      }

      answer_data[qid.toString()] = answer;   // store the answers by qid, makes for easy retrieval on server
    }


    function register_final(ctx) {
      var submit_button = $("<button>");
      submit_button.text("Submit");
      ctx.after(submit_button);
      submit_button.click(function(e) {
        e.preventDefault();
        get_answer_data();
        $(this).attr('disabled','disabled');
        $(this).text("Saved");

        var request = {};
        request.answers = answer_data;
        request.exam_id = <?php echo $_GET['exam_id'] ?>;
  
        $.ajax({
          type: "POST",
          url: "http://web.njit.edu/~jdl38/application_server/app.php/grade",
          data: JSON.stringify(request),
          dataType: "json",
          contentType: "application/json; charset=utf-8",
          success: function(d){
              console.log(d);
              question_elem.html("<a href='http://web.njit.edu/~arm32/client/dash_student.php'><button>Click to go to Dashboard</button></a>");

          },
          error: function(e) {
          },
        });

      });
    }
    var TOTAL;
    var CURRENT_QUESTION = 0;
    var FRONT_INDEX = 0;
    function setup() {
      var questions = exam_data['questions'];
      var question_queue = new Array();
      var cur_question;


      exam_data['questions'].forEach( function (question, idx, questions) {
        question_queue.push(question);
      });

      TOTAL = question_queue.length;

      next.on('click', function(e) {

          FRONT_INDEX++;
          CURRENT_QUESTION++;
          var progress_value = (CURRENT_QUESTION/TOTAL * 100);
          var pbar = $("#progress-bar");
          pbar.attr("aria-valuenow", progress_value);
          pbar.text(progress_value.toString());
          pbar.attr("style", "width: " + progress_value.toString() + "%;");

          if (FRONT_INDEX === question_queue.length) {   // on the last questi:n!
            register_final($(this));
            $(this).remove();
          }

          get_answer_data();
          cur_question = question_queue[FRONT_INDEX];
          render_question(cur_question);
      });

      prev.on('click', function(e) {
          if (CURRENT_QUESTION > 0) {
              console.log("HERE");
              console.log(FRONT_INDEX);
              CURRENT_QUESTION--;
              FRONT_INDEX--;
              console.log(FRONT_INDEX);
              var progress_value = (CURRENT_QUESTION/TOTAL * 100);
              var pbar = $("#progress-bar");
              pbar.attr("aria-valuenow", progress_value);
              pbar.text(progress_value.toString());
              pbar.attr("style", "width: " + progress_value.toString() + "%;");
              cur_question = question_queue[FRONT_INDEX];
              render_question(cur_question);
          }
      });

      var q = question_queue[FRONT_INDEX];

      render_question(q);

    }

    $.ajax({
      type: "GET",
      url: "http://web.njit.edu/~jdl38/application_server/app.php/exam/<?php echo $_GET['exam_id']; ?>",
      dataType: "json",
      xhrFields: {
        withCredentials: true
      },
      success: function(d) {
        exam_data = d;
        setup();
      },
      error: function(e) {
        console.warn("Could not retrieve data");
      }
    });
    	
    </script>


    <?php include('footer.php');?>
    
    
</body>
<?php else: ?>
<body>
404 NOT FOUND

<?php include('footer.php');?>
</body>
<?php endif; ?>
</html>


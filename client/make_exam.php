<?php include('header.php'); ?>
<!-- add question weights -->
<style>
    .qtable {
        border: solid 2px;
    }
</style>
<body>

    <?php include 'nav-bar.php';?>
    <div class="container" >
        <!-- SELECT BOX REPLACEMENT -->
        <div class="row">
            <form role="form" name="exam_maker" method="post" >
                <div class="col-xs-10">
                    <div class="btn-group form-group">
                        <input type="text" id="exam-title" name="exam-body_title" class="form-control flat" placeholder="Enter Exam Title Here">
                    </div>  
                    <div class="btn-group form-group">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><span id="lang">Select Language Type</span><span class="caret"></span></button>
                            <span class="dropdown-arrow"></span>
                            <ul id="sub" name="subject" class="dropdown-menu">
                                <li><a href="#">Javascript</a></li>
                                <li><a href="#">Python</a></li>
                                <li><a href="#">Java</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="btn-group form-group">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><span id="subject">Select Subject Type</span><span class="caret"></span></button>
                            <span class="dropdown-arrow"></span>

                            <ul id="sub" name="subject" class="dropdown-menu">
                                <li><a href="#">Variables</a></li>
                                <li><a href="#">Syntax</a></li>
                                <li><a href="#">Classes</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="btn-group form-group">
                      <button id="save">Save</button>
                    </div>
                    <br><br>
                </div>
            </form>
        </div>
        <div class="row">
            <!-- END SELECT BOX REPLACEMENT -->
            <div class="col-8">
                <table class="qtable">
                    <thead>
                        <tr>
                            <th>Add</th>
                            <th>Title</th>
                            <th>Spec</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="row1">
                            <td class="table-data-elem remove-button"><button class="btn add">Add</button></td>
                            <td class="table-data-elem"></td>
                            <td class="table-data-elem"></td>
                        </tr>
                        <tr id="row2">
                            <td class="table-data-elem remove-button"><button class="btn add">Add</button></td>
                            <td class="table-data-elem"></td>
                            <td class="table-data-elem"></td>
                        </tr>
                        <tr id="row3">
                            <td class="table-data-ele remove-button v"><button class="btn add">Add</button></td>
                            <td class="table-data-elem"></td>
                            <td class="table-data-elem"></td>
                        </tr>
                        <tr id="row4">
                            <td class="table-data-elem"><button class="btn add">Add</button></td>
                            <td class="table-data-elem"></td>
                            <td class="table-data-elem"></td>
                        </tr>
                        <tr id="row5">
                            <td class="table-data-elem"><button class="btn add">Add</button></td>
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
        <div class="row">
            <div id="exam-body">
                <div class="row">
                <div class="col-xs-3">
                    <h4 id="exam-title-receive"></h4>
                </div>
                <div class="col-xs-3 col-right" >
                    <p id="total-receiver"></p>
                </div>
            </div>
                <form>
                    <ul class="sortable list">
                    </ul>
                    <hr class="exam-line">
                </form>
            </div>
        </div> 
    </div> <!-- /container -->


<script type="text/javascript" src="js/amalgation.min.js"></script>
<script type="text/javascript">

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

function populate_from_queue(queue) {
    var TABLE_ROWS = 5;
    var q;
    for(var i = 0; i < TABLE_ROWS; i++) {
       q = queue.front();
       queue.pop();
       row_name = "#row" + (i+1).toString();
       
       var td = $(row_name).find("td");
       if (q) {
         console.log(q.id);
         $(td[0]).data("questionid",q.id);
         $(td[1]).text(q.title);
         $(td[2]).text(q.spec);
       }else {
         break;
       }
    }
}

/*
    Initial table population
*/

var questions_queue = new Queue();
var old_questions_queue = new Queue();

$.ajax({
    method: "GET",
    url: "http://web.njit.edu/~jdl38/application_server/app.php/question_data",
    xhrFields: {
      withCredentials: true
    },
    dataType: "json",
    success: function(d) {
        var subjects = d['subjects'];
        var languages = d['languages'];
        var questions = d['questions'];
        for (var i in questions) {
          questions_queue.push(questions[i]);
        }
        populate_from_queue(questions_queue);
    },
    error: function(e) {
        console.log(e);
    }
});



$('#next').click(function(e) {
  console.log("NEXT",questions_queue.size());
    var lang = $('#lang').val();
    var subject = $('#subject').val();
    var params = {};

    if (lang.length) params['language'] = lang;
    if (subject.length) params['subject'] = subject;

    if (questions_queue.size() < 10) {
        //retrieve more 
        // using filter if set
        $.ajax({
            method: "GET",
            url: "http://web.njit.edu/~jdl38/application_server/app.php/question_data",
            xhrFields: {
              withCredentials: true
            },
            data: params,
            dataType: "json",
            success: function(d) {
                var questions = d['questions'];
                questions.forEach(function(e,i,a) {
                  questions_queue.push(e);
                });
                populate_from_queue(questions_queue);
            },
            error: function(e) {
                console.log(e);
            }
        });
    }else{
      populate_from_queue(questions_queue);
    }
    // Populate questions using queue (saves network access time)
});

var question_set = {};

$('.sortable').on("click",".remove",function(e) {
    e.preventDefault();
    var parent = $(this).parent();
    var qid = parent.data("questionid");
    console.log("DELETING",qid);
    console.log(question_set);
    delete question_set[qid];
    console.log(question_set);
    parent.remove();
});

$('.add').click(function(e) {
    var li = $('<li>');
    var btn = $('<button>');
    var span = $('<span>');
    var input = $('<input>');

    console.log(question_set);

    btn.addClass("btn");
    btn.addClass("btn-danger");
    btn.addClass("remove");
    btn.text("Remove");

    span.addClass("question");

    var text = $(this).parent().next().text();
    span.text(text);

    input.attr("min","1");
    input.attr("max","100");
    input.attr("value","10");
    input.attr("type","number");

    li.attr("draggable","true");
    var parent = $(this).parent();
    var qid = parent.data("questionid");

    li.data("questionid",qid);
    console.log(li.data("questionid"));
    li.append(btn);
    li.append(span);
    li.append(input);

    //    $('.sortable').append('<li draggable="true"><button class="btn btn-danger remove">Remove</button><span class="question">Question 1</span>&nbsp;<input min="1" max="100" value="10" type="number"></li>');

    if (qid in question_set) {
      // do nothing
    }else {
      question_set[qid] = true;
      $('.sortable').append(li);
    }


});

$('#save').click(function(e) {

  e.preventDefault();

  $(this).attr('disabled','disabled');
  $(this).text("Saved");

  var exam_title = $('#exam-title').val();
  var acc = [];
  var qid,weight;
  var q;

  $('.sortable li').each(function(iter) {
    qid = $(this).data("questionid");
    weight = $(this).find("input").val();
    acc.push({
      "qid":qid,
      "weight":weight,
    });
  });
  console.log(acc);

  var request = {};

  request.title = exam_title;
  request.questions = acc;

  var data = JSON.stringify(request);

  $.ajax({
      type: "POST",
      url: "http://web.njit.edu/~jdl38/application_server/app.php/exam",
      contentType: 'application/json; charset=utf-8',
      dataType: "json",
      data: data,
      success: function(d,s,x) {
        //$(this).removeAttr('disabled');
      },
      error: function(x,s,e) {
        $(this).removeAttr('disabled');
        console.log("ERROR");
      },
  });


});

var cur_total = 0;
var total_receiver = $('#total-receiver');

$("input[type='number']").each(function() {      
    cur_total = parseInt($(this).attr('value')) + cur_total;
});
total_receiver.text("Total: " + cur_total.toString());

var exam_title_receiver = $('#exam-title-receive');
$('#exam-title').on('input', function(e) {
    exam_title_receiver.text($(this).val());
});

$("input[type='number']").on('input', function(e) {
    cur_total = 0;
    $("input[type='number']").each(function() {      
        cur_total = parseInt($(this).attr('value')) + cur_total;
    });
    total_receiver.text("Total: " + cur_total.toString());
});


$(".dropdown-menu li a").click(function(){
    var text = $(this).text();
    $(this).parents(".btn-group").find('#lang').text(text);
    $(this).parents(".btn-group").find('#lang').val(text);
    $(this).parents(".btn-group").find('#select').text(text);
    $(this).parents(".btn-group").find('#select').val(text);
    $(this).parents(".btn-group").find('#subject').text(text);
    $(this).parents(".btn-group").find('#subject').val(text);

});


</script>

<script src="js/jquery.sortable.min.js"></script>
<script>
    $('.sortable').sortable();
</script>
</body>
</html>

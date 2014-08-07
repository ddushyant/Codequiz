<?php include('header.php'); ?>
<body>
    <?php include('nav-bar.php');?>
<style>
table td {
    overflow:hidden;
    text-overflow:ellipsis;
}
</style>
    <div class="container" >
        <!-- SELECT BOX REPLACEMENT -->
        <div class="row">
            <form role="form" name="exam_maker" method="post" >
                <div class="col-xs-12">
                    <div class="btn-group form-group">
                        <input type="text" id="exam-title" name="exam-body_title" class="form-control flat" placeholder="Enter Exam Title Here">
                    </div>  
                    <div class="btn-group form-group">
                        <div class="dropdown">
                            <button class="btn btn-info dropdown-toggle" data-toggle="dropdown"><span id="lang">Language</span><span class="caret"></span></button>
                            <span class="dropdown-arrow"></span>
                            <ul id="language_dropdown" name="subject" class="question_scroll dropdown-menu">
                            <li><a>None</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="btn-group form-group">
                        <div class="dropdown">
                            <button class="btn btn-info dropdown-toggle" data-toggle="dropdown"><span id="subject">Subject</span><span class="caret"></span></button>
                            <span class="dropdown-arrow"></span>

                            <ul id="subject_dropdown" name="subject" class="question_scroll dropdown-menu">
                                <li><a>None</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="btn-group form-group">
                        <div class="dropdown">
                            <button class="btn btn-info dropdown-toggle" data-toggle="dropdown"><span id="qtype">Question Type</span><span class="caret"></span></button>
                            <span class="dropdown-arrow"></span>
                            <ul id="qtype_dropdown" name="qtype" class="question_scroll dropdown-menu">
                                <li><a>None</a></li>
                                <li><a data-qtype="coding">Coding</a></li>
                                <li><a data-qtype="fill">Fill</a></li>
                                <li><a data-qtype="multiple">Multiple Choice</a></li>
                                <li><a data-qtype="true-false">True-False</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="btn-group form-group">
                        <label>
                            Difficulty: 
                            <input id="difficulty" type="number" min="1" max="5" value="3">
                        </label>
                    </div>
                    <div class="btn-group form-group">
                      <button id="search" class="btn btn-embossed btn-primary btn-block" type="submit">Search</button>
                    </div>
                    <div class="btn-group form-group">
                      <button id="save" class="btn btn-embossed btn-primary btn-block" type="submit">Create Exam</button>
                    </div>
                    <div class="btn-group form-group">
                      <button id="exam_preview" class="btn btn-embossed btn-primary btn-block" data-toggle="modal" data-target=".bs-example-modal-lg" type="button">Preview Exam</button>
                    </div>
                      <!--  Modal content for the above example -->
  <div id="preview-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title" id="myLargeModalLabel">Exam Preview</h4>
        </div>
        <div class="modal-body">
            <?php include("modal.php");?>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
                </div>
            </form>
        </div>
        <div class="row">
            <!-- END SELECT BOX REPLACEMENT -->
            <div class="col-8">
                <div id="foo"></div>  <!-- REMEMBER ME-->
                <table class="qtable">
                    <thead>
                        <tr>
                            <th>Add</th>
                            <th>Title</th>
                            <th>Spec</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="row1" class="previewer">
                            <td class="table-data-elem remove-button"><button class="btn add">Add</button></td>
                            <td class="table-data-elem"></td>
                            <td class="table-data-elem"></td>
                        </tr>
                        <tr id="row2" class="previewer">
                            <td class="table-data-elem remove-button"><button class="btn add">Add</button></td>
                            <td class="table-data-elem"></td>
                            <td class="table-data-elem"></td>
                        </tr>
                        <tr id="row3" class="previewer">
                            <td class="table-data-ele remove-button v"><button class="btn add">Add</button></td>
                            <td class="table-data-elem"></td>
                            <td class="table-data-elem"></td>
                        </tr>
                        <tr id="row4" class="previewer">
                            <td class="table-data-elem"><button class="btn add">Add</button></td>
                            <td class="table-data-elem"></td>
                            <td class="table-data-elem"></td>
                        </tr>
                        <tr id="row5" class="previewer">
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
<script src="js/jquery.sortable.min.js"></script>
<script>
$('.sortable').sortable();
</script>
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

    Queue.prototype.clear = function() {
        this._size = 0;
        this._storage = [];
    }

    return Queue;

})();
function populate_from_queue(queue,other) {
    var TABLE_ROWS = 5;
    var q;

    $("tbody tr").each(function(i) {
        $(this).find("td").each(function(i) {
            if (i !== 0) {
                $(this).html("");
            }
        });
    });

    for(var i = 0; i < TABLE_ROWS; i++) {
        q = queue.front();
        other.push(q);
        queue.pop();
        row_name = "#row" + (i+1).toString();
        var td = $(row_name).find("td");
        if (q) {
            $(td[0]).data("questionid",q.id);
            $(td[1]).text(q.title);
            $(td[2]).text(q.spec);
        }else {
            break;
        }
    }
}

function populate_from_array(A) {
    var TABLE_ROWS = 5;
    var q;

    $("tbody tr").each(function(i) {
        $(this).find("td").each(function(i) {
            if (i !== 0) {
                $(this).html("");
            }
        });
    });

    var current_question_group = questions_table[TABLE_IDX].slice(0);

    for(var i = 0; i < TABLE_ROWS; i++) {
        if (current_question_group.length <= 0){ break;}  // don't let it continue!
            q = current_question_group.pop();
        row_name = "#row" + (i+1).toString();
        var td = $(row_name).find("td");
        if (q) {
            $(td[0]).data("questionid",q.id);
            $(td[1]).text(q.title);
            $(td[2]).text(q.spec);
        }
    }
}
/*
    Initial table population
 */

/*
var questions_queue = new Queue();
var old_questions_queue = new Queue();
 */

var questions_table = new Array();
var TABLE_IDX = 0;
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


            var languages_dropdown = $('#language_dropdown');
            var subject_dropdown = $('#subject_dropdown');

            subjects.forEach(function(e,i,a) {
                subject_dropdown.append('<li><a data-subject="' + e.id + '">' + e.name + '</a></li>');
            });

            languages.forEach(function(e,i,a) {
                languages_dropdown.append('<li><a data-language="' + e.id + '">' + e.name + '</a></li>');
            });

            $("#subject_dropdown li a").click(function(){
                var subject_span = $("#subject");
                subject_span.text($(this).text());
                if ($(this).text() === "None") { $(this).removeData(); subject_span.removeData(); }
                subject_span.data("subject", $(this).data("subject"));
            });

            $("#language_dropdown li a").click(function(){
                var language_span = $("#lang");
                language_span.text($(this).text());
                if ($(this).text() === "None") { $(this).removeData(); language_span.removeData(); }
                language_span.data("language", $(this).data("language"));
            });

            $("#qtype_dropdown li a").click(function() {
                var qtype_span = $('#qtype');
                qtype_span.text($(this).text());
                if ($(this).text() === "None") { $(this).removeData(); qtype_span.removeData(); }
                qtype_span.data("qtype", $(this).data("qtype"));
            });

            var c = 0;
            for (var i in questions) {
                if (c % 5 === 0) {
                    questions_table.push([]);
                }
                c++;
                //questions_queue.push(questions[i]);
                var len = questions_table.length;
                questions_table[len-1].push(questions[i]);
            }
            //populate_from_queue(questions_queue,old_questions_queue);
            populate_from_array(questions_table);
        },
            error: function(e) {
                console.log(e);
            }
});


$('#next').click(function(e) {

    //populate_from_queue(questions_queue,old_questions_queue);
    if (questions_table[TABLE_IDX+1]) {
        /* CLEAR POPOVERS */
        $('tbody td').each(function(i) {
            $(this).removeData();
        });

        $('#foo').removeData();
        TABLE_IDX++;
        populate_from_array(questions_table);
    }else {
        console.log("NO NEW QUESTIONS");
    }
});


$('#prev').click(function(e) {

    //populate_from_queue(questions_queue,old_questions_queue);
    if (questions_table[TABLE_IDX-1]) {
        /* CLEAR POPOVERS */
        $('tbody td').each(function(i) {
            $(this).removeData();
        });

        $('#foo').removeData();
        TABLE_IDX--;
        populate_from_array(questions_table);
    }else {
        console.log("NO NEW QUESTIONS");
    }
});

var question_set = {};

$('.sortable').on("click",".remove",function(e) {
    e.preventDefault();
    var parent = $(this).parent();
    var qid = parent.data("questionid");
    delete question_set[qid];
    parent.remove();
});

$('.add').click(function(e) {
    e.preventDefault();
    var li = $('<li>');
    var btn = $('<button>');
    var span = $('<span>');
    var input = $('<input>');


    btn.addClass("btn");
    btn.addClass("btn-danger");
    btn.addClass("remove");
    btn.attr("type","button");
    btn.text("Remove");

    span.addClass("question");

    var text = $(this).parent().next().text();
    span.text(text);

    input.attr("min","1");
    input.attr("max","100");
    input.attr("value","10");
    input.attr("type","number");
    input.attr("style", "float:right;");

    li.attr("draggable","true");
    var parent = $(this).parent();
    var qid = parent.data("questionid");

    li.data("questionid",qid);
    li.append(btn);
    li.append(span);
    li.append(input);

    //    $('.sortable').append('<li draggable="true"><button class="btn btn-danger remove">Remove</button><span class="question">Question 1</span>&nbsp;<input min="1" max="100" value="10" type="number"></li>');

    if (qid in question_set) {
        // do nothing
    }else {
        question_set[qid] = true;
        $('.sortable').append(li);
        cur_total += parseInt(input.val());
        total_receiver.text("Total: " + cur_total.toString());
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
                alert(d['message']);
                window.location = window.location.pathname;
            },
                error: function(x,s,e) {
                    $(this).removeAttr('disabled');
                },
    });


});

var cur_total = 0;
var total_receiver = $('#total-receiver');

/*
$("input[type='number']").each(function() {      
    cur_total = parseInt($(this).attr('value')) + cur_total;
});
 */
total_receiver.text("Total: " + cur_total.toString());

var exam_title_receiver = $('#exam-title-receive');
$('#exam-title').on('input', function(e) {
    exam_title_receiver.text($(this).val());
});

$(".list").on('input', "input[type='number']",function(e) {
    cur_total = 0;
    $(".list input[type='number']").each(function() {      
        cur_total += parseInt($(this).val());
    });
    total_receiver.text("Total: " + cur_total.toString());
});

$('#search').click(function(e) {
    e.preventDefault();

    /* CLEAR THE DATA FROM TABLE ROWS FOR POPOVER*/
    $('tbody td').each(function(i) {
        $(this).removeData();
    });
    $('#foo').removeData();

    var lang = $('#lang').data("language");
    var subject = $('#subject').data("subject");
    var difficulty = $('#difficulty').val();
    var qtype = $('#qtype').data("qtype");

    var params = {};
    if (lang) params.language = lang;
    if (subject) params.subject = subject;
    if (difficulty) params.difficulty = difficulty;
    if (qtype) params.qtype = qtype;
    $.ajax({
        method: "GET",
            url: "http://web.njit.edu/~arm32/data_server/app.php/question",
            xhrFields: {
                withCredentials: true
            },
            data: params,
            dataType: "json",
            success: function(d) {
                var questions = d['questions'];

                questions_table = new Array();
                TABLE_IDX = 0;

                var c = 0;
                for (var i in questions) {
                    if (c % 5 === 0) {
                        questions_table.push([]);
                    }
                    c++;
                    var len = questions_table.length;
                    questions_table[len-1].push(questions[i]);
                }

                populate_from_array(questions_table);

            },
                error: function(e) {
                    console.log(e);
                }
    });
});


var popover1 = $('#row1').popover({
    animation: true,
        title: "Question Preview",
        template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
        placement: "auto",
        trigger: "manual",
        container: "body",
});


/*
 *
 *
 * What follows is a really big mess of callbacks and workarounds
 * the popover plugin would not work as expected, so...
 * I just made one for each separate table row.
 *
 * A MUCH better thing to do that doesn't involve ajax is 
 * storing the question content in data-* attributes.
 *
 * However, I have NO time for testing as the RC is due tomorrow.
 *
 * */
$('#row1').hover(function(e) {
    var question_id = $($(this).find("td")[0]).data("questionid");
    if (question_id) {

        var url = "http://web.njit.edu/~arm32/data_server/app.php/question/" + question_id;

        $.ajax({
            type: "GET",
                url: url,
                dataType: "json",
                success:function (d) {
                    var question = d['question'];
                    popover1.attr('data-original-title', question.title);
                    popover1.attr('data-content', question.spec);
                    popover1.popover('show');
                },
                    error: function() {
                        popover1.attr('data-content', "Unable to retrieve content.");
                        popover1.popover('show');
                    },
        });
    }
}, function(e) {
    popover1.popover('hide');
});


var popover2 = $('#row2').popover({
    animation: true,
        title: "Question Preview",
        template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
        placement: "auto",
        trigger: "manual",
        container: "body",
});



$('#row2').hover(function(e) {
    var question_id = $($(this).find("td")[0]).data("questionid");

    if (question_id) {
        var url = "http://web.njit.edu/~arm32/data_server/app.php/question/" + question_id;

        $.ajax({
            type: "GET",
                url: url,
                dataType: "json",
                success:function (d) {
                    var question = d['question'];
                    popover2.attr('data-original-title', question.title);
                    popover2.attr('data-content', question.spec);
                    popover2.popover('show');
                },
                    error: function() {
                        popover2.attr('data-content', "Unable to retrieve content.");
                        popover2.popover('show');
                    },
        });
    }
}, function(e) {
    popover2.popover('hide');
});

var popover3 = $('#row3').popover({
    animation: true,
        title: "Question Preview",
        template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
        placement: "auto",
        trigger: "manual",
        container: "body",
});



$('#row3').hover(function(e) {
    var question_id = $($(this).find("td")[0]).data("questionid");
    if (question_id) {
        var url = "http://web.njit.edu/~arm32/data_server/app.php/question/" + question_id;

        $.ajax({
            type: "GET",
                url: url,
                dataType: "json",
                success:function (d) {
                    var question = d['question'];
                    popover3.attr('data-original-title', question.title);
                    popover3.attr('data-content', question.spec);
                    popover3.popover('show');
                },
                    error: function() {
                        popover3.attr('data-content', "Unable to retrieve content.");
                        popover3.popover('show');
                    },
        });
    }
}, function(e) {
    popover3.popover('hide');
});
var popover4 = $('#row4').popover({
    animation: true,
        title: "Question Preview",
        template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
        placement: "auto",
        trigger: "manual",
        container: "body",
});



$('#row4').hover(function(e) {
    var question_id = $($(this).find("td")[0]).data("questionid");

    if (question_id) {

        var url = "http://web.njit.edu/~arm32/data_server/app.php/question/" + question_id;

        $.ajax({
            type: "GET",
                url: url,
                dataType: "json",
                success:function (d) {
                    var question = d['question'];
                    popover4.attr('data-original-title', question.title);
                    popover4.attr('data-content', question.spec);
                    popover4.popover('show');
                },
                    error: function() {
                        popover4.attr('data-content', "Unable to retrieve content.");
                        popover4.popover('show');
                    },
        });
    }
}, function(e) {
    popover4.popover('hide');
});

var popover5 = $('#row5').popover({
    animation: true,
        title: "Question Preview",
        template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
        placement: "auto",
        trigger: "manual",
        container: "body",
});
$('#row5').hover(function(e) {
    var question_id = $($(this).find("td")[0]).data("questionid");

    if (question_id) {

        var url = "http://web.njit.edu/~arm32/data_server/app.php/question/" + question_id;

        $.ajax({
            type: "GET",
                url: url,
                dataType: "json",
                success:function (d) {
                    var question = d['question'];
                    popover5.attr('data-original-title', question.title);
                    popover5.attr('data-content', question.spec);
                    popover5.popover('show');
                },
                    error: function() {
                        popover5.attr('data-content', "Unable to retrieve content.");
                        popover5.popover('show');
                    },
        });
    }
}, function(e) {
    popover5.popover('hide');
});

$('tbody tr').click(function(e) {
    popover1.popover('hide');
    popover2.popover('hide');
    popover3.popover('hide');
    popover4.popover('hide');
    popover5.popover('hide');
});


$('#search11').click(function(e) {
    e.preventDefault();
});

function render_modal_question(q) {
        var url = "http://web.njit.edu/~arm32/data_server/app.php/question/" + q.qid;

        $.ajax({
            type: "GET",
                url: url,
                dataType: "json",
                success:function (d) {
                    var question = d['question'];
                    $("#modal-question").html(
                        "<h3>" + question.title + "</h3>"
                    +   "<p>"
                    +   question.spec
                    +   "</p>"
                    );
                },
                error: function() {
                    console.log("FUCKITJS");
                },
        });
}

$('#preview-modal').on('show.bs.modal', function (e) {
    $("#modal-question").html("");
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

    if (acc.length === 0) return e.preventDefault();
    var IDX = 0;

    $('.modal-body').on("click", "#modal-prev", function(e) {
        if (IDX > 0) {
            IDX--;
            render_modal_question(acc[IDX]);
        }
    });

    $('.modal-body').on("click", "#modal-next", function(e) {
        if (IDX < acc.length-1) {
            IDX++;
            render_modal_question(acc[IDX]);
        }
    });
    render_modal_question(acc[IDX]);
});
</script>

<?php include('footer.php');?>
</body>
</html>

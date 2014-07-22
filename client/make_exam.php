<?php include('header.php'); ?>
<!-- add question weights -->
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
                        <tr>
                            <td class="table-data-elem remove-button"><button class="btn">Add</button></td>
                            <td class="table-data-elem">Question Title</td>
                            <td class="table-data-elem">Question Spec</td>
                        </tr>
                        <tr>
                            <td class="table-data-elem remove-button"><button class="btn">Add</button></td>
                            <td class="table-data-elem">Question Title</td>
                            <td class="table-data-elem">Question Spec</td>
                        </tr>
                        <tr>
                            <td class="table-data-ele remove-button v"><button class="btn">Add</button></td>
                            <td class="table-data-elem">Question Title</td>
                            <td class="table-data-elem">Question Spec</td>
                        </tr>
                        <tr>
                            <td class="table-data-elem"><button class="btn">Add</button></td>
                            <td class="table-data-elem">Question Title</td>
                            <td class="table-data-elem">Question Spec</td>
                        </tr>
                        <tr>
                            <td class="table-data-elem"><button class="btn">Add</button></td>
                            <td class="table-data-elem">Question Title</td>
                            <td class="table-data-elem">Question Spec</td>
                        </tr>
                    </tbody>
                </table>
                <ul class="pager">
                  <li class="previous"><a href="#">&larr; Prev</a></li>
                  <li class="next"><a href="#">Next &rarr;</a></li>
                </ul>
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
                        <li><button class="btn btn-danger">Remove</button><span class="question">Question 1</span>&nbsp;<input type="number" min="1" max="100" value="10">
                        <li><button class="btn btn-danger">Remove</button><span class="question">Question 2</span>&nbsp;<input type="number" min="1" max="100" value="10">
                        <li><button class="btn btn-danger">Remove</button><span class="question">Question 3</span>&nbsp;<input type="number" min="1" max="100" value="10">
                        <li><button class="btn btn-danger">Remove</button><span class="question">Question 4</span>&nbsp;<input type="number" min="1" max="100" value="10">
                        <li><button class="btn btn-danger">Remove</button><span class="question">Question 5</span>&nbsp;<input type="number" min="1" max="100" value="10">
                    </ul>
                    <hr class="exam-line">
                </form>
            </div>
        </div> 
    </div> <!-- /container -->


<script type="text/javascript" src="js/amalgation.min.js"></script>
<script type="text/javascript">

var cur_total = 0;
var total_receiver = $('#total-receiver');

$("input[type='number']").each(function() {      
    console.log($(this).val());
    cur_total = parseInt($(this).attr('value')) + cur_total;
});
total_receiver.text("Total: " + cur_total.toString());

var exam_title_receiver = $('#exam-title-receive');
$('#exam-title').on('input', function(e) {
    console.log("THERE WASD A CHANGE");
    exam_title_receiver.text($(this).val());
});

$("input[type='number']").on('input', function(e) {
    cur_total = 0;
    $("input[type='number']").each(function() {      
        cur_total = parseInt($(this).attr('value')) + cur_total;
    });
    total_receiver.text("Total: " + cur_total.toString());
});

$('form').submit(function(e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "<?php echo $APP_SERVER_BASE_URL; ?>/auth",
        data: $('form').serialize(),
        success: function(data,stat,xhr) {
            console.log("Success: ",data);
            $('#flash').html(data['message']);
        },
        error: function(xhr,stat,err) {
            console.log("Fail: ", err);
        },
        dataType: "json"
    });
});

$(".dropdown-menu li a").click(function(){

    $(this).parents(".btn-group").find('#lang').text($(this).text());
    $(this).parents(".btn-group").find('#lang').val($(this).text());
    $(this).parents(".btn-group").find('#select').text($(this).text());
    $(this).parents(".btn-group").find('#select').val($(this).text());
    $(this).parents(".btn-group").find('#subject').text($(this).text());
    $(this).parents(".btn-group").find('#subject').val($(this).text());

});

// multiple choice
jQuery("#action-1").click(function(e){
    $("#mult").html("");
    $("#mult").append('<div class="form-group"><input type="text" name="mult_answer" class="form-control flat" placeholder="Enter Correct Answer Here" required autofocus></div>');
    $("#mult").append('<div class="form-group"><input type="text" name="opt1" class="form-control flat" placeholder="Option 1" required></div>');
    $("#mult").append('<div class="form-group"><input type="text" name="opt2" class="form-control flat" placeholder="Option 2" required autofocus></div>');
    $("#mult").append('<div class="form-group"><input type="text" name="opt3" class="form-control flat" placeholder="Option 3" required></div>'); 
    $("#mult").append("<input id='qtype' type='hidden' name='qtype' value='multi'>");
    register_multi_hooks();
});

// true false
jQuery("#action-2").click(function(e){
    $("#mult").html("");
    $("#mult").append('<label class="radio checked"><span class="icons"><span class="first-icon fui-radio-unchecked"></span><span class="second-icon fui-radio-checked"></span></span><input type="radio" name="group1" value="True" data-toggle="radio" checked>Answer is True</label>');
    $("#mult").append('<label class="radio"><span class="icons"><span class="first-icon fui-radio-unchecked"></span><span class="second-icon fui-radio-checked"></span></span><input type="radio" name="group1" value="False" data-toggle="radio">Answer is False</label>');
    $("#mult").append("<input id='qtype' type='hidden' name='qtype' value='true-false'>");
    register_truefalse_hooks();
});

// open-ended
jQuery("#action-3").click(function(e){
    $("#mult").html("");
    $("#mult").append('<div class="form-group"><input type="text" name="open_answer" class="form-control flat" placeholder="Enter Correct Answer Here" required autofocus></div>');
    $("#mult").append("<input id='qtype' type='hidden' name='qtype' value='open'>");
    register_open_hooks();
});

// coding question
jQuery("#action-4").click(function(e){
    var html = '<button id="add_btn" class="btn">Add</button><ul id="inoutlist"><li class="inout"><input type="text" class="in" placeholder="Input"><input type="text" class="out" placeholder="Output"></li></ul>';
    $("#mult").html(html);
    register_coding_hooks();
});
</script>

<script src="js/jquery.sortable.min.js"></script>
<script>
    $('.sortable').sortable();
</script>
</body>
</html>

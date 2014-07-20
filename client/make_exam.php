<?php include('header.php'); ?>
<!-- add question weights -->
<body>
    <style>

    .static,.viewport
    {
        vertical-align:top;
    }

    body{
        line-height:1;
    }            

    hr {
        border: 0;
        border-bottom: 2px solid #ccc;
        background: #999;
    }

    ol li .question { 
      display: inline-block;
      width: 200px; 
      text-overflow: ellipsis; /* will make [...] at the end */
      white-space: nowrap; /* paragraph to one line */
      overflow:hidden; /* older browsers */
      margin-right: 10px;
    }   
    </style>
    <div class="container" >
        <!-- SELECT BOX REPLACEMENT -->
        <div class="row">
            <input id="exam-title" type="text" placeholder="Exam Title">
            <br>
            <br>
            <br>
        </div>
        <div class="row">
        <div class="col-xs-3">
            <select style="display: none;" name="herolist" value="X-Men" class="select-block">
                <option value="0">Choose hero</option>
                <option value="1">Spider Man</option>
                <option value="2">Wolverine</option>
                <option value="3">Captain America</option>
                <option value="X-Men" selected="selected">X-Men</option>
                <option value="Crocodile">Crocodile</option>
            </select>
            <div class="btn-group select select-block">
            <button class="btn dropdown-toggle clearfix btn-primary" data-toggle="dropdown">
                <span class="filter-option pull-left">X-Men</span>&nbsp;
                <span class="caret"></span>
            </button>
            <span class="dropdown-arrow dropdown-arrow-inverse"></span>
            <ul style="overflow-y: auto; min-height: 108px; max-height: 97px;" class="dropdown-menu dropdown-inverse" role="menu">
                <li rel="0"><a tabindex="-1" href="#" class=""><span class="pull-left">Choose hero</span></a>
                </li>
                <li rel="1"><a tabindex="-1" href="#" class=""><span class="pull-left">Spider Man</span></a>
                </li>
                <li rel="2"><a tabindex="-1" href="#" class=""><span class="pull-left">Wolverine</span></a>
                </li>
                <li rel="3"><a tabindex="-1" href="#" class=""><span class="pull-left">Captain America</span></a>
                </li>
                <li class="selected" rel="4"><a tabindex="-1" href="#" class=""><span class="pull-left">X-Men</span></a>
                </li>
                <li rel="5"><a tabindex="-1" href="#" class=""><span class="pull-left">Crocodile</span></a>
                </li>
            </ul>
        </div>
    </div>
        <div class="col-xs-3">
            <select style="display: none;" name="herolist" value="X-Men" class="select-block">
                <option value="0">Choose hero</option>
                <option value="1">Spider Man</option>
                <option value="2">Wolverine</option>
                <option value="3">Captain America</option>
                <option value="X-Men" selected="selected">X-Men</option>
                <option value="Crocodile">Crocodile</option>
            </select>
            <div class="btn-group select select-block">
            <button class="btn dropdown-toggle clearfix btn-primary" data-toggle="dropdown">
                <span class="filter-option pull-left">X-Men</span>&nbsp;
                <span class="caret"></span>
            </button>
            <span class="dropdown-arrow dropdown-arrow-inverse"></span>
            <ul style="overflow-y: auto; min-height: 108px; max-height: 97px;" class="dropdown-menu dropdown-inverse" role="menu">
                <li rel="0"><a tabindex="-1" href="#" class=""><span class="pull-left">Choose hero</span></a>
                </li>
                <li rel="1"><a tabindex="-1" href="#" class=""><span class="pull-left">Spider Man</span></a>
                </li>
                <li rel="2"><a tabindex="-1" href="#" class=""><span class="pull-left">Wolverine</span></a>
                </li>
                <li rel="3"><a tabindex="-1" href="#" class=""><span class="pull-left">Captain America</span></a>
                </li>
                <li class="selected" rel="4"><a tabindex="-1" href="#" class=""><span class="pull-left">X-Men</span></a>
                </li>
                <li rel="5"><a tabindex="-1" href="#" class=""><span class="pull-left">Crocodile</span></a>
                </li>
            </ul>
        </div>
    </div>
    </div>
    <div class="row">
    <!-- END SELECT BOX REPLACEMENT -->
    <div class="col-3">
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>Title</th>
                    <th>Spec</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="table-data-elem"><button style="btn">Add</button></td>
                    <td class="table-data-elem">Question Title</td>
                    <td class="table-data-elem">Question Spec</td>
                </tr>
                <tr>
                    <td class="table-data-elem"><button style="btn">Add</button></td>
                </tr>
                <tr>
                    <td class="table-data-elem"><button style="btn">Add</button></td>
                </tr>
                <tr>
                    <td class="table-data-elem"><button style="btn">Add</button></td>
                </tr>
                <tr>
                    <td class="table-data-elem"><button style="btn">Add</button></td>
                </tr>
                <tr>
                    <td class="table-data-elem"><button style="btn">Add</button></td>
                </tr>
                <tr>
                    <td class="table-data-elem"><button style="btn">Add</button></td>
                </tr>
                <tr>
                    <td class="table-data-elem"><button style="btn">Add</button></td>
                </tr>
                <tr>
                    <td class="table-data-elem"><button style="btn">Add</button></td>
                </tr>
                <tr>
                    <td class="table-data-elem"><button style="btn">Add</button></td>
                </tr>
            </tbody>
        </table>
        <ul class="pager">
          <li class="previous"><a href="#">&larr; Prev</a></li>
          <li class="next"><a href="#">Next &rarr;</a></li>
      </ul>
        </div>

        <div id="exam-body" class="">
            <form>
            <h5 id="exam-title-receive"></h5>
            <ol>
            <li><span class="question">Question 1 aslkfjasdklfjaskljflsdkfjlasdkfjlksdjfaklfjl;asdkjl;askjfl;kasjfl;kasjfl;kajsl;fkjsdl;kfasl;kfj;alksfl;kasf</span><span><input type="number" min="1" max="100" value="10"></span></li>
            <li><span class="question">Question 2</span><input type="number" min="1" max="100" value="10"></li>
            <li><span class="question">Question 3</span><input type="number" min="1" max="100" value="10"></li>
            <li><span class="question">Question 4</span><input type="number" min="1" max="100" value="10"></li>
            <li><span class="question">Question 5</span><input type="number" min="1" max="100" value="10"></li>
            </ol>
            <hr>
            <div class="row">
                <div class="col-xs-3">
                    <span id="total-receiver"></span>
                </div>
            </div>
            </form>
        </div>
        </div> 
       </div> 
    </div> <!-- /container -->


    <script type="text/javascript" src="js/amalgation.min.js"></script>
    <script type="text/javascript">
    var exam_title_receiver = $('#exam-title-receive');
    $('#exam-title').on('input', function(e) {
        console.log("THERE WASD A CHANGE");
        exam_title_receiver.text($(this).val());
    });
    var cur_total = 0;
    var total_receiver = $('#total-receiver');
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
    </script>
</body>
</html>

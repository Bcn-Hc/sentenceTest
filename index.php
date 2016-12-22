<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <script type="text/javascript" src="bootstrap/js/jquery.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style type="text/css">
        body {
            font-family: "MS UI Gothic", "arial";
        }

        .pg-header {
            margin-top: 30px;
        }

        .search-type div {
            display: inline-block;
            margin-right: 15px;
        }

        .search-or {
            padding-top: 7px;
            text-align: center;
        }

        .search-right .search-date {
            float: left;
            margin-right: 10px;
        }

        .clear {
            clear: both;
        }

        .splitter {
            margin-top: 50px;
            margin-bottom: 30px;
            border-top: 1px grey solid;
        }

        .check-wrapper {
            text-align: center;
        }

        .table-edit input {
            width: 100%;
        }

        #btn_check {
            margin-right: 30px;
        }

        #save_info {
            text-align: center;
            display: none;
        }
    </style>
</head>
<body>
<div class="pg-header">
    <div class="search-left col-sm-4 col-sm-offset-1 ">
        <div class="input-group">
            <input type="text" class="form-control" id="search-text"/>
					<span class="input-group-btn">
						<button class="btn btn-default" type="button" id="search-btn">
                            Go
                        </button>
					</span>
        </div>
        <span class="search-type">
        <div><input type="checkbox" id="search-sId"/>sId</div>
        <div><input type="checkbox" id="search-memo"/>memo</div>
        <div><input type="checkbox" id="search-content" checked="checked"/>content</div>
        <div><input type="checkbox" id="search-answer"/>answer</div>
        <div><input type="checkbox" id="search-translation"/>translation</div>
        <div><input type="checkbox" id="search-tips"/>tips</div>
        </span>
    </div>

    <div class="search-or col-sm-1">OR</div>

    <div class="search-right col-sm-5">
        <div>
            <div class="search-date input-group col-sm-5">
                <input type="text" class="form-control" id="from-date-text">

                <div class="input-group-btn">
                    <button type="button" class="btn btn-default
                        dropdown-toggle" data-toggle="dropdown">From
                        <span class="caret"></span>
                    </button>
                    <ul id="from-date-ul" class="date-dropdown dropdown-menu pull-right">
                    </ul>
                </div>
                <!-- /btn-group -->
            </div>
            <div class="search-date input-group col-sm-5">
                <input type="text" class="form-control" id="to-date-text">

                <div class="input-group-btn">
                    <button type="button" class="btn btn-default
                        dropdown-toggle" data-toggle="dropdown">To
                        <span class="caret"></span>
                    </button>
                    <ul id="to-date-ul" class="to-date-ul date-dropdown dropdown-menu pull-right">
                    </ul>
                </div>
                <!-- /btn-group -->
            </div>
            <div class="search-date col-sm-1">
                <button type="button" class="btn btn-default" id="date-btn">Go</button>
            </div>
            <div class="clear">
            </div>
        </div>
    </div>
</div>
<div class="pg-content">
    <div class="table-wrapper col-sm-10 col-sm-offset-1">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>sId</th>
                <th>memo</th>
                <th>content</th>
                <th>answer</th>
                <th>translation</th>
                <th>tips</th>
                <th>created_at</th>
                <th>edit</th>
            </tr>
            </thead>
            <tbody id="question-list">
            </tbody>
        </table>
    </div>
    <div class="check-wrapper col-sm-10 col-sm-offset-1">
        <button type="button" class="btn btn-info" id="btn_check">Check</button>
        <button type="button" class="btn btn-info" id="btn_new">New</button>
    </div>
    <div class="splitter col-sm-10 col-sm-offset-1"></div>
    <div class="edit-tab col-sm-10 col-sm-offset-1 ">
        <table class="table table-striped table-edit">
            <caption class="text-center"><h3>Edit</h3></caption>
            <thead>
            <tr>
                <th class="col-sm-2">Field</th>
                <th class="col-sm-10">Value</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><label>sId</label></td>
                <td><span type="text" id="edit-sId"/></span></td>
            </tr>
            <tr>
                <td><label>memo</label></td>
                <td><input type="text" id="edit-memo"/></td>
            </tr>
            <tr>
                <td><label>content</label></td>
                <td><input type="text" id="edit-content"/></td>
            </tr>
            <tr>
                <td><label>answer</label></td>
                <td><input type="text" id="edit-answer"/></td>
            </tr>
            <tr>
                <td><label>translation</label></td>
                <td><input type="text" id="edit-translation"/></td>
            </tr>
            <tr>
                <td><label>tips</label></td>
                <td><input type="text" id="edit-tips"/></td>
            </tr>
            </tbody>
        </table>
        <div class="col-sm-12 alert alert-success" id="save_info"></div>
        <div class="check-wrapper col-sm-10 col-sm-offset-1">
            <button type="button" class="btn btn-info" id="btn_ok">ok</button>
        </div>
    </div>
</div>

<script type="text/javascript">
    var curQuestions;
    function checkSingQuestion(i) {
        if ($("#mask-" + i).length==0 || $("#mask-" + i).val() == curQuestions[i]["answer"]) {
            $("#question-" + i).removeClass('danger');
            $("#question-" + i).addClass('success');
        } else {
            $("#question-" + i).removeClass('success');
            $("#question-" + i).addClass('danger');
        }
        $($("#question-" + i).children()[3]).text(curQuestions[i]["answer"]);
    }
    function checkAllQuestions(){
        for(var i=0;i<curQuestions.length;++i) {
            checkSingQuestion(i);
        }
    }
    function updateQuestion(data) {
        curQuestions = JSON.parse(data);
        $('#question-list').html("");
        for (var i = 0; i < curQuestions.length; i++) {
            var tr = $("<tr id=\"question-" + i.toString() + "\"></tr>");
            tr.append("<td>" + curQuestions[i]['sId'] + "</td>");
            tr.append("<td>" + curQuestions[i]['memo'] + "</td>");
            var strQuest = curQuestions[i]['content'].replace("%s", " <input type=\"text\" id=\"mask-" + i + "\" class=\"mask\" /> ");
            tr.append("<td>" + strQuest + "</td>");
            //tr.append("<td>" + curQuestions[i]['answer'] + "</td>");
            tr.append("<td></td>");
            tr.append("<td>" + curQuestions[i]['translation'] + "</td>");
            tr.append("<td>" + curQuestions[i]['tips'] + "</td>");
            tr.append("<td>" + curQuestions[i]['created_at'] + "</td>");
            tr.append("<td><button type=\"button\" class=\"btn btn-info btn-edit\" id=\"edit-" + i.toString() + "\">Edit</button></td>");
            $('#question-list').append(tr);
        }

        //press ctrl+enter to check question
        //press enter to next question
        //press tab to next question
        $('.mask').keydown(function (e) {
            if (e.keyCode == 13) {
                if (e.ctrlKey) {
                    //press the ctrl+enter
                    var id = $(this).attr("id");
                    var arr_id = id.split("-");
                    if (arr_id.length == 2) {
                        checkSingQuestion(arr_id[1]);
                    }
                } else {
                    //only press the enter
                    $(this).parent().parent().next().find('.mask').focus();
                }
            } else if (e.keyCode == 9) {
                //9 is the tab key
                $(this).parent().parent().next().find('.mask').focus();
                e.preventDefault();
                return false;
            }
        }
    );

    //click the edit button
    $('.btn-edit').click(function () {
        var index = $(this).attr('id').split('-')[1];
        $('#edit-sId').text(curQuestions[index]['sId']);
        $('#edit-memo').val(curQuestions[index]['memo']);
        $('#edit-content').val(curQuestions[index]['content']);
        $('#edit-answer').val(curQuestions[index]['answer']);
        $('#edit-translation').val(curQuestions[index]['translation']);
        $('#edit-tips').val(curQuestions[index]['tips']);
        $('#save_info').hide();
    });

    //click the check button
    $('#btn_check').click(function(){
        checkAllQuestions();
    });
    }
</script>
<!--init the date information-->
<script type="text/javascript">

    $('document').ready(function () {
        function getDateListFunc(data, textStatus, jqXHR) {
            var jsonData = JSON.parse(data);
            for (var i = 0; i < jsonData.length; i++) {
                $('.date-dropdown').each(
                    function (index, element) {
                        $(element).append('<li><a href="#">' + jsonData[i]['created_at'] + '</a></li>');
                    }
                )
            }
            $('#from-date-ul a').click(function () {
                $('#from-date-text').val($(this).text());
                if ($('#to-date-text').val() == "") {
                    $('#to-date-text').val($(this).text());
                }
            });

            $('#to-date-ul a').click(function () {
                $('#to-date-text').val($(this).text());
                if ($('#from-date-text').val() == "") {
                    $('#from-date-text').val($(this).text());
                }
            });
        }

        $.ajax({
            url: "request.php",
            type: "post",
            data: {
                action: 'getDateList'
            },
            success: getDateListFunc,
            datatype: "json"
        });

    })
</script>
<!--search-->
<script type="text/javascript">
    function searchText() {
        var searchFields = new Array();
        if ($('#search-sId').is(':checked')) {
            searchFields.push('sId');
        }
        if ($('#search-memo').is(':checked')) {
            searchFields.push('memo');
        }
        if ($('#search-content').is(':checked')) {
            searchFields.push('content');
        }
        if ($('#search-answer').is(':checked')) {
            searchFields.push('answer');
        }
        if ($('#search-translation').is(':checked')) {
            searchFields.push('translation');
        }
        if ($('#search-tips').is(':checked')) {
            searchFields.push('tips');
        }
        function searchFunc(data, textStatus, jqXHR) {
            updateQuestion(data);
        }

        $.ajax({
            url: "request.php",
            type: "post",
            data: {
                action: 'search',
                searchFields: searchFields,
                key: $('#search-text').val()
            },
            success: searchFunc,
            datatype: "json"
        });
    }
    document.getElementById("search-btn").addEventListener("click", function () {
        searchText();
        return false;
    });
    $('#search-text').keydown(function (e) {
        if (e.keyCode == 13) {
            searchText();
        }
    });
</script>
<!--list by date-->
<script type="text/javascript">
    function listByDate() {
        function dateFunc(data, textStatus, jqXHR) {
            updateQuestion(data);
        }

        $.ajax({
            url: "request.php",
            type: "post",
            data: {
                action: 'date',
                from_date: $('#from-date-text').val(),
                to_date: $('#to-date-text').val()
            },
            success: dateFunc,
            datatype: "json"
        });
    }
    document.getElementById("date-btn").addEventListener("click", function () {
        listByDate();
        return false;
    });
</script>

<!--new or modify a record-->
<script type="text/javascript">
    $('#btn_ok').click(function () {
        var params = [
            {
                'sId': $('#edit-sId').text(),
                'memo': $('#edit-memo').val(),
                'content': $('#edit-content').val(),
                'answer': $('#edit-answer').val(),
                'translation': $('#edit-translation').val(),
                'tips': $('#edit-tips').val()
            }
        ];

        function saveFunc(data, textStatus, jqXHR) {
            var jsonData = JSON.parse(data);
            if (typeof jsonData[0] !== 'undefined') {
                if (typeof jsonData[0]['succeed'] !== 'undefined') {
                    $('#save_info').show();
                    $('#save_info').removeClass('alert-danger');
                    $('#save_info').addClass('alert-success');
                    $('#save_info').text(jsonData[0]['succeed']);
                } else if (typeof jsonData[0]['failed'] !== 'undefined') {
                    $('#save_info').show();
                    $('#save_info').removeClass('alert-success');
                    $('#save_info').addClass('alert-danger');
                    $('#save_info').text(jsonData[0]['failed']);
                } else {
                    $('#save_info').hide();
                }
            }
        }

        $.ajax({
            url: "request.php",
            type: "post",
            data: {
                action: 'saveRecord',
                params: params
            },
            success: saveFunc,
            datatype: "json"
        });
    });

    //click the new button
    $('#btn_new').click(function () {
        $('#edit-sId').text("");
        $('#edit-memo').val("");
        $('#edit-content').val("");
        $('#edit-answer').val("");
        $('#edit-translation').val("");
        $('#edit-tips').val("");
        $('#save_info').hide();
    });
</script>

</body>
</html>
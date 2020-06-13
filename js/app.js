//add comment form submission handler
$(document).ready(function() {
    $('form[id=addCom]').submit(function(event) {
        //gets submitted form data
        var formData = {
            'name'          : $('input[id=com_name]').val(),
            'email'         : $('input[id=com_email]').val(),
            'comment'       : $('textarea[id=com_comment]').val(),
            'submit_com'    : $('input[id=submit_com]').val()
        };
        //send ajax post request to validate and insert comment
        $.ajax({
            type        : 'POST',
            url         : '/comments/process.php',
            data        : formData
        })
            .done(function(data) {
                //parses data
                var parsed = JSON.parse(data);
                //clears form error messages if there are any
                var error;
                if(error = document.getElementById("name-error")){
                    error.remove();
                }
                if(error = document.getElementById("email-error")){
                    error.remove();
                }
                if(error = document.getElementById("comment-error")){
                    error.remove();
                }
                //validation unsuccessful
                //sets error messages
                if ( !parsed.success ) {
                    if (parsed.errors.name) {
                        $('#name-group').append('<div id="name-error" class="text-danger">' + parsed.errors.name + '</div>');
                    }
        
                    if (parsed.errors.email) {
                        $('#email-group').append('<div id="email-error" class="text-danger">' + parsed.errors.email + '</div>');
                    }
        
                    if (parsed.errors.comment) {
                        $('#comment-group').append('<div id="comment-error" class="text-danger">' + parsed.errors.comment + '</div>');
                    }
                } else {
                    //validation successful
                    //clears submitted form fields
                    document.getElementById("com_name").value = "";
                    document.getElementById("com_email").value = "";
                    document.getElementById("com_comment").value = "";
                    //reloads comment and subcomment list
                    load();
                }
            });
        //prevents default submit event
        event.preventDefault();
    });
});
//loads comment and subcomment list
function load() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            //parses data if response was successful
            var jsondata=JSON.parse(this.responseText);
            //clears comment container
            document.getElementById("comments").innerHTML = "";
            //creates header with comment count
            var header = $('<h2>').attr("id", "totalCom");
            $('#comments').append(header);
            var $comCount = 0;
            //goes through each comment
            jsondata.forEach(el => {
                //adds comment to comment count
                $comCount++;
                //adds comment html to container
                addComment(el);
                //if comment has any subcomments goes through each subcomment
                if(el.subcomments) {
                    (el.subcomments).forEach( sub => {
                        //adds subcomment to comment count
                        $comCount++;
                        //adds subcomment html to container
                        addSubcomment(sub);
                    })
                }
            });
            //adds comment count to header
            document.getElementById("totalCom").innerHTML = $comCount + " comments";
    }
    };
    xmlhttp.open("GET","/comments/process.php");
    xmlhttp.send();
}
//adds comments html to comment container
function addComment(comment) {
    var div = $("<div>").addClass("bg-light rounded py-2 px-4 mt-2");
    var span_name = $('<span class="font-weight-bold mr-2">').html(comment.name);
    var span_date = $('<span class="text-secondary">').html(comment.date.slice(0, 10));
    var span_reply = $('<span class="float-right">');
    var ref = "#collapseForm" + comment.id;
    var arrow = 
        "<svg class='bi bi-arrow-clockwise' width='1em' height='1em' viewBox='0 0 16 16' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>" +
            "<path fill-rule='evenodd' d='M3.17 6.706a5 5 0 0 1 7.103-3.16.5.5 0 1 0 .454-.892A6 6 0 1 0 13.455 5.5a.5.5 0 0 0-.91.417 5 5 0 1 1-9.375.789z'/>" +
            "<path fill-rule='evenodd' d='M8.147.146a.5.5 0 0 1 .707 0l2.5 2.5a.5.5 0 0 1 0 .708l-2.5 2.5a.5.5 0 1 1-.707-.708L10.293 3 8.147.854a.5.5 0 0 1 0-.708z'/>" +
        "</svg>";
    var a = $("<a data-toggle='collapse' href='" + ref + "' role='button' aria-expanded='false' aria-controls='collapseForm" + comment.id + "'>")
        .html(arrow + " Reply");
    span_reply.append(a);
    var div_comment = $("<div>").html(comment.comment).addClass("mt-1 text-justify");
    div.append(span_name, span_date, span_reply, div_comment);
    $('#comments').append(div);
    //initializes collapsible subcomment submission form for each comment
    initializeCollapse(comment);
}
//adds subcomments html to comment container
function addSubcomment(subcomment) {
    var div = $("<div>").addClass("container mt-2 pr-0");
    var div1 = $("<div>").addClass("offset-2 col-10 pr-0");
    div.append(div1);
    var div2 = $("<div>").addClass("bg-light rounded py-2 px-4");
    div1.append(div2);
    var span_name = $('<span class="font-weight-bold mr-2">').html(subcomment.name);
    var span_date = $('<span class="text-secondary">').html(subcomment.date.slice(0, 10));
    var div_comment = $("<div>").html(subcomment.comment).addClass("mt-1 text-justify");
    div2.append(span_name, span_date, div_comment);
    $('#comments').append(div);
}
//initializes collapsible reply form
function initializeCollapse(comment) {
    var div1 = $("<div>").addClass("row mt-2");
    var div2 = $("<div>").addClass("offset-2 col-10 pl-5");
    //gets html container with forms html and changes its id to unique object id
    document.getElementById("subcommentCollapse").id = "collapseSubcommentForm" + comment.id;
    //saves html container's html to variable
    var html = document.getElementById("collapseSubcommentForm" + comment.id).outerHTML;
    //changes html container's id to initial value
    document.getElementById("collapseSubcommentForm" + comment.id).id = "subcommentCollapse";
    div1.append(div2);
    div2.append(html);
    var div = $("<div>")
        .addClass('collapse')
        .attr('id', 'collapseForm' + comment.id);
    div.append(div1);
    $('#comments').append(div);
    //sets comment foreign key value for reply
    document.forms["collapseSubcommentForm" + comment.id]["fk_comment_id"].value = comment.id;
}
//handles subcomments submission, is called by form on submit
function subcommentSubmit(e) {
    //prevents default submit action
    e.preventDefault();
    //gets submitted form's id
    var form_id = e.target.id;
    //gets form's data
    var formData = {
        'name'              : document.forms[form_id]["name"].value,
        'email'             : document.forms[form_id]["email"].value,
        'comment'           : document.forms[form_id]["subcomment"].value,
        'submit_sub'        : document.forms[form_id]["submit_sub"].value,
        'fk_comment_id'     : document.forms[form_id]["fk_comment_id"].value
    };
    //sends ajax post request with submitted data
    $.ajax({
        type        : 'POST',
        url         : '/comments/process.php',
        data        : formData
    })
    .done(function(data) {
        var parsed = JSON.parse(data);
        //removes error messages if any exist
        var error;
        if(error = document.getElementById("sub_name-error")){
            error.remove();
        }
        if(error = document.getElementById("sub_email-error")){
            error.remove();
        }
        if(error = document.getElementById("sub_comment-error")){
            error.remove();
        }
        //validation unsuccessful
        if ( !parsed.success ) {
            //adds error messages
            if (parsed.errors.name) {
                $('form[id=' + form_id + '] .name-group').append('<div id="sub_name-error" class="text-danger">' + parsed.errors.name + '</div>');
            }

            if (parsed.errors.email) {
                $('form[id=' + form_id + '] .email-group').append('<div id="sub_email-error" class="text-danger">' + parsed.errors.email + '</div>');
            }

            if (parsed.errors.comment) {
                $('form[id=' + form_id + '] .comment-group').append('<div id="sub_comment-error" class="text-danger">' + parsed.errors.comment + '</div>');
            }
        } else {
            //validation successful
            //submitted form values are cleared
            document.forms[form_id]["name"].value = "";
            document.forms[form_id]["email"].value = "";
            document.forms[form_id]["subcomment"].value = "";
            //collapses submitted reply form
            document.getElementById("collapseForm" + formData.fk_comment_id).className = "collapse";
            //reloads comment and subcomment list
            load();
        }
    });
};
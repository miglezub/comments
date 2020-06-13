<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" 
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="js/app.js" type="text/javascript"></script>
    <title>Comments</title>
</head>
<body onload="load()">
    <div class="container col-md-8">
        <h2 class="mt-2">Comment Form</h2>
        <form action="process.php" method="POST" id="addCom">
            <div class="row">
                <div id="email-group" class="form-group col-md-6">
                    <label for="email">Email*</label>
                    <input type="text" class="form-control" id="com_email" name="email">
                </div>
                <div id="name-group" class="form-group col-md-6">
                    <label for="name">Name*</label>
                    <input type="text" class="form-control" id="com_name" name="name">
                </div>
                <div id="comment-group" class="form-group col-12">
                    <label for="comment">Comment*</label>
                    <textarea name="comment" id="com_comment" class="form-control"></textarea>
                </div>
                <input type="hidden" id="submit_com" name="submit_com" value="1">
                <button class="btn btn-secondary ml-3">Submit</button>
            </div>
        </form>
    </div>

    <div class="container col-md-8 mt-4 mb-5" id="comments"></div>
    
    <div class="d-none">
        <div class="row mt-2">
            <div class="offset-2 col-10 pl-5">
                <form action="process.php" method="POST" class="ml-2" id="subcommentCollapse"
                    onsubmit="return subcommentSubmit(event)">
                    <div class="row">
                        <div class="form-group col-md-6 email-group" id="email-group">
                            <label for="email">Email*</label>
                            <input type="text" class="form-control" id="email">
                        </div>
                        <div class="form-group col-md-6 name-group" id="name-group">
                            <label for="name">Name*</label>
                            <input type="text" class="form-control" id="name">
                        </div>
                        <div class="form-group col-12 comment-group" id="comment-group">
                            <label for="subcomment">Comment*</label>
                            <textarea name="subcomment" id="subcomment" class="form-control"></textarea>
                        </div>
                        <input type="hidden" id="submit_sub" value="1"></input>
                        <input type="hidden" id="fk_comment_id"></input>
                        <button class="btn btn-secondary ml-3" id="submit_subcomment">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <hr>
    <p class="text-center">Užduotį atliko: Miglė Zubavičiūtė</p>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>

</html>
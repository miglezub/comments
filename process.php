<?php
    include("include/database.php");

    class Process {

        function Process() {
            //request to add comment
            if(isset($_POST['submit_com']) && $_POST['submit_com'] == 1)
                $this->addComment();
            //request to add subcomment
            else if(isset($_POST['submit_sub']) && $_POST['submit_sub'] == 1)
                $this->addSubcomment();
            //request to get comments and subcomments
            else
                $this->getComments();
        }
        //add comment
        function addComment() {
            global $database;
            //validate submitted comment
            $errors = $this->validateComment($_POST['name'], $_POST['email'], $_POST['comment']);
            //validation successful
            if(empty($errors)) {
                $_POST['success'] = true;
                //comment is inserted to database
                $database->insertComment($_POST['name'], $_POST['email'], $_POST['comment']);
            }
            //validation unsuccessful
            else {
                $_POST['success'] = false;
                //passing validation errors
                $_POST['errors'] = $errors;
            }
            echo json_encode($_POST);
        }
        //add subcomment
        function addSubcomment() {
            global $database;
            //validate submitted subcomment
            $errors = $this->validateComment($_POST['name'], $_POST['email'], $_POST['comment']);
            //validation successful
            if(empty($errors)) {
                $_POST['success'] = true;
                //subcomment is inserted to database
                $database->insertSubcomment($_POST['name'], $_POST['email'], $_POST['comment'], $_POST['fk_comment_id']);
            }
            //validation unsuccessful
            else {
                $_POST['success'] = false;
                //passing validation errors
                $_POST['errors'] = $errors;
            }
            echo json_encode($_POST);
        }
        //comment validation
        function validateComment($name, $email, $comment) {
            $errors = array();
            //name is required and less than 100 characters
            if(empty($name))
                $errors['name'] = "Name is required";
            else if(strlen($name) > 100)
                $errors['name'] = "Name must be less than 100 characters";
            //email is required, less than 100 characters and format must be ***@***.***
            if(empty($email))
                $errors['email'] = "Email is required";
            else if(strlen($email) > 100)
                $errors['email'] = "Email must be less than 100 characters";
            else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
                $errors['email'] = "Wrong email format";
            //comment is required and less than 255 characters
            if(empty($comment))
                $errors['comment'] = "Comment is required";
            else if(strlen($comment) > 255)
                $errors['comment'] = "Comment must be less than 255 characters";

            return $errors;
        }
        //gets comment and subcomment list
        function getComments() {
            global $database;
            print json_encode($database->getComments());
        }
    }

    $process = new Process;
?>
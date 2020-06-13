<?php

class Database {

    private $connection;

    function Database() {
        //global connection initialization
        $this->connection = mysqli_connect('localhost', 'root', '', 'comments');
        if (!$this->connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }
    //inserts validated comment
    function insertComment($name, $email, $comment) {
        $date = date('Y-m-d H:i:s');
        $query = "INSERT INTO comments (name, email, comment, date) VALUES (?, ?, ?, ?)";
        $stmt= $this->connection->prepare($query);
        $stmt->bind_param("ssss", $name, $email, $comment, $date);
        $stmt->execute();
    }
    //inserts validated subcomment
    function insertSubcomment($name, $email, $comment, $fk_comment) {
        $date = date('Y-m-d H:i:s');
        $query = "INSERT INTO subcomments (name, email, comment, date, fk_comment) VALUES (?, ?, ?, ?, ?)";
        $stmt= $this->connection->prepare($query);
        $stmt->bind_param("ssssi", $name, $email, $comment, $date, $fk_comment);
        $stmt->execute();
    }
    //gets comment and subcomment list
    function getComments() {
        //Right join is used to select all comments even if they don't have subcomments
        //returns an ordered list where comments having more than 1 subcomment appear more than once
        $query = "SELECT 
            subcomments.id AS sub_id, 
            subcomments.name AS sub_name, 
            subcomments.email AS sub_email, 
            subcomments.comment AS sub_comment,
            subcomments.date as sub_date, 
            fk_comment, 
            comments.* 
            FROM subcomments
            RIGHT JOIN comments ON subcomments.fk_comment=comments.id
            ORDER BY comments.date DESC, subcomments.date DESC";
        $result = mysqli_query($this->connection, $query);

        $comments = array();
        $previousRow = null;
        while($row = mysqli_fetch_assoc($result)) {
            //if it is the first row or comment appears for the first time in a list
            if($previousRow['id'] != $row['id'] || $previousRow == null){
                $newRow = $this->makeRow($row['id'], $row['name'], $row['comment'], $row['date']);
                if($row['sub_id'] != NULL) {
                    $newRow['subcomments'][] = 
                        $this->makeRow($row['sub_id'], $row['sub_name'], $row['sub_comment'], $row['sub_date']);
                }
                $comments[] = $newRow;
            }
            //if previous row had the same comment it means that only subcomment must be added
            else {
                $comments[count($comments) - 1]['subcomments'][] = 
                    $this->makeRow($row['sub_id'], $row['sub_name'], $row['sub_comment'], $row['sub_date']);
            }
            $previousRow = $row;
        }
        return $comments;
    }

    function makeRow($id, $name, $comment, $date) {
        $newRow = null;
        $newRow['id'] = $id;
        $newRow['name'] = $name;
        $newRow['comment'] = $comment;
        $newRow['date'] = $date;
        return $newRow;
    }
}

$database = new Database

?>
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
        //selects all comments
        $query = "SELECT * FROM comments ORDER BY date DESC";
        $result = mysqli_query($this->connection, $query);

        $comments = array();
        //goes through the list of comments, gets subcomments for each comment
        while($row = mysqli_fetch_assoc($result)) {
            $query = "SELECT * FROM subcomments WHERE fk_comment = '" . $row['id'] . "' ORDER BY date DESC";
            $subcom = mysqli_query($this->connection, $query);
            //goes through all subcomments, inserts subcomment data to array
            while($subRow = mysqli_fetch_assoc($subcom)) {
                $row['subcomments'][] = $subRow;
            }
            $comments[] = $row;
        }
        return $comments;
    }
}

$database = new Database

?>
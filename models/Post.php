<?php
class Post{

private $conn;
private $table ='user_queries';
public $id;
public $uname;
public $email;
public $phone;
public $comments;
public $date_query;


public function __construct($db){
    $this->conn=$db;
}

public function read(){

    $query="SELECT id,uname,email,phone,date_query,comments FROM " . $this->table;
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;   
}




public function create(){
    $query = "INSERT INTO " . $this->table . "
    SET
      uname = :uname,
       email= :email,
      phone = :phone,
      date_query=:date_query,
      comments = :comments";

      $stmt = $this->conn->prepare($query);

      $this->uname=htmlspecialchars(strip_tags($this->uname));
      $this->email=htmlspecialchars(strip_tags($this->email));
      $this->phone=htmlspecialchars(strip_tags($this->phone));
      $this->date_query=htmlspecialchars(strip_tags($this->date_query));
      $this->comments=htmlspecialchars(strip_tags($this->comments));

     
      $stmt->bindParam(':uname', $this->uname);
      $stmt->bindParam(':email', $this->email);
      $stmt->bindParam(':phone', $this->phone);
      $stmt->bindParam(':date_query', $this->date_query);
      $stmt->bindParam(':comments', $this->comments);


      if($stmt->execute()){
          return true;
      }
          printf("Error: %s.\n", $stmt->error);
          return false;
      
}

}
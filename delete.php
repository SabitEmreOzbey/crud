<?php
include'config/database.php';
try{

    //get record ID
    $id=isset($_GET['id'])? $_GET['id'] : die('ERROR: Record ID not found.');
    //delete query
    $query="DELETE FROM products WHERE id = ?";
    $stmt=$con->prepare($query);
    $stmt->bindParam(1,$id);
    
    if($stmt->execute()){
        header('Location: index.php?action=deleted');
    }else {
        die('Unable to delete record.');
    }

}catch(PDOException $exception){
    die('ERROR: '.$exception->getMessage());
}
?>
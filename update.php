<!DOCTYPE HTML>
<html>
<head>
<title>PDO - Update a Record - PHP CRUD</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
</head>
<body>
    <div class="container">
        <div class="page-header">
        <h1>Update Product</h1>
    </div>
    <!-- PHP read record by ID will be here -->
    <?php
    $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found');
    include'config/database.php';
    try{
       $query="SELECT id,name,description.price FROM products WHERE id = ? LIMIT 0,1";
       $stmt=$con->prepare($query);

       //this is the first question mark
       $stmt->bindParam(1,$id);

       //execute our query
       $stmt->execute();

       // store retrieced row to a variable
       $row =$stmt->fetch(PDO::FETCH_ASSOC);

       //Values to fill up our form
       $name = $row['name'];
       $description=$row['description'];
       $pirce =$row['price'];
    
    }catch(PDOException $exception){
        die('ERROR: ' . $exception->getMessage());
    }
    ?>
    <!-- PHP post to update record will be here -->
   <?php
    // check if form was submitted
    if($_POST){

        try{
            //write update query
            //in this case, it seemed like we have so many fields to pass and
            // it is better to label them and not use question marks
            //$query"UPDATE products SET name=:name, description =:description, price=:price WHERE id =:id";
            $query = "UPDATE products 
                    SET name=:name, description=:description, price=:price 
                    WHERE id = :id";
            //prepare query for execution
            $stmt=$con->prepare($query);
            //posted values
            $name=htmlspecialchars(strip_tags($_POST['name']));
            $description=htmlspecialchars(strip_tags($_POST['description']));
            $price=htmlspecialchars(strip_tags($_POST['price']));
            // bind the parameters
            $stmt->bindParam(':name',$name);
            $stmt->bindParam(':description',$description);
            $stmt->bindParam(':price',$price);
            $stmt->bindParam(':id',$id);
            //Execute the query
            if($stmt->execute()){
                echo"<div class='alert alert-success'>Record was updated.</div";
            }else {
                echo "<div class='alert aler-danger'>Unable to update record.Plase try again.</div>";   
            }
        }catch(PDOException $exception){
            die('ERROR: '.$exception->getMessage());
        }
    }
    ?>
    <!-- HTML form to update record will be here -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?id={$id}");?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
    <tr>
        <td>Name</td>
        <td><input type='text' name='name' value="<?php echo htmlspecialchars($name, ENT_QUOTES); ?>" class='form-control'/></td>
    </tr>
    <tr>
        <td>Description</td>
        <td><textarea name='description' class= 'form-control'><?php echo htmlspecialchars($description,ENT_QUOTES);?></textarea>

    </tr>
    <tr>
        <td>Price</td>
        <td><input type='text' name='price' value="<?php echo htmlspecialchars($name, ENT_QUOTES); ?>" class='form-control'/></td>
    </tr>
    <tr>
    <td></td>
    <td><input type='submit' value='Save Changes' class='btn btn-primary'/>
    <a href='index.php' class='btn btn-danger'>Back to read products</a>
       </td>
      </tr>
     </table>
    </form>    
    </div><!--edn. container -->

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>
</html>
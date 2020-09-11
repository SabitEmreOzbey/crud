<!Doctype HTML>
<HTML>
<head>
<title>PDO -Read Records - PHP CRUD</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
<!-- custon css -->
<style>
.m-r-1em{margin-right:1em;}
.m-b-1em{margin-bottom:1em;}
.m-l-1em{margin-left:1em;}
.mt0{margin-top:0;}
</style>
</head>
<body>
<!--container-->
<div class="container">
<div class="page-header">
   <h1>Read Products</h1>
</div>
<!-- PHP code to read records will be here -->
<?php
//include database connection
include 'config/database.php';
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$records_per_page=5;
$from_record_num=($records_per_page*$page)-$records_per_page;
//delete message prompt will be here
$action = isset($_GET['action']) ? $_GET['action'] : "";
// if it was redirected from delete.php
if($action=='deleted'){
    echo "<div class='alert alert-success'>Record was deleted.</div>";
}

//select all data
/*$query ="SELECT id,name,description,price FROM products ORDER BY id DESC";
$stmt=$con->prepare($query);
$stmt->execute();*/ 


// select data for current page
$query = "SELECT id, name, description, price FROM products ORDER BY id DESC
    LIMIT :from_record_num, :records_per_page";
$stmt = $con->prepare($query);
$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
$stmt->execute();
//this is how to get number of rows returned
$num =$stmt->rowCount();
//link to create record form
echo"<a href='create.php' class= 'btn btn-primary m-b-1em'>Create New Product</a>";
//check if more than 0 record found
if ($num>0){
    echo "<table class='table table-hover table-responsive table-bordered'";
    echo "<tr>";
       echo"<th># ID</th>";
       echo"<th>Name</th>";
       echo"<th>Description</th>";
       echo"<th>Price</th>";
       echo"<th>Action</th>";
    echo"<tr>";
    while ($row =$stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        echo "<tr>";
           echo "<td>{$id}</td>";
           echo "<td>{$name}</td>";
           echo "<td>{$description}</td>";
           echo "<td>{$price}</td>";
           echo"<td>";
               echo "<a href ='read_one.php?id={$id}' class='btn btn-info m-r-1em'>Read</a>";
               echo "<a href ='update.php?id={$id}' class='btn btn-primary m-r-1em'>Edit</a>";
               echo "<a href='#' onclick='delete_user({$id});'  class='btn btn-danger'>Delete</a>";
            echo"</td>";
        echo "</tr>";
    }
echo "</table>";
//PAGINATION
/*$query = "SELECT COUNT(*) as total_rows FROM products";
$smtm=$con->prepare($query);
$smtm->execute();
$row= $smtm->fetch(PDO::FETCH_ASSOC);
$total_rows=$row['total_rows'];*/
// PAGINATION
// count total number of rows
$query = "SELECT COUNT(*) as total_rows FROM products";
$stmt = $con->prepare($query);
 
// execute query
$stmt->execute();
 
// get total rows
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$total_rows = $row['total_rows'];

//paginate records
/*$page_url="index.php?";
include_once "pageing.php";
}else{
    echo"div class='alert alert-danger'>No records found.</div>";
}*/
// paginate records
$page_url="index.php?";
include_once "paging.php";
}
?>
</div><!-- end. container -->
<!-- jQuery(necessary for Bootstrap's JavaSacript plugins)-->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<!--Lastest compied and minified Bootstrap JavaScript -->
<script src ="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- confirm delete record will be here -->
<script type='text/javascript'>
//confirn record deletion
function delete_user(id){
     var answer = confirm('Are you sure?');
     if(answer){
         // if user clicked ok,
         //pass the id to delete.php and execute the delete query
         window.location='delete.php?id=' + id;
     }
}
</script>
</body>
</HTML>
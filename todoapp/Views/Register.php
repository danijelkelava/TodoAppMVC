<?php
$database = new Database;
$db = $database->getConnection();

$user = new User($db);

$pageTitle = "Register"; 
include $_SERVER['DOCUMENT_ROOT'] . "/todoapp/include/header.php";
?>
    <div class="container-fluid jumbotron">          
      <h1>Register Form</h1>        
    </div>
    <div class="container">
    	<div class="row">
    		<form method="post">
          <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Enter email">
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="lozinka" id="password" placeholder="Password">
          </div>
          <div class="form-group">
            <label for="ime">Ime</label>
            <input type="text" class="form-control" name="ime" id="ime" placeholder="Unesi ime">
          </div>
          <div class="form-group">
            <label for="prezime">Prezime</label>
            <input type="text" class="form-control" name="prezime" id="prezime" placeholder="Unesi prezime">
          </div>
          <button type="submit" name="register" class="btn btn-primary">Submit</button>
        </form>
    	</div>
    </div>


<?php 
include $_SERVER['DOCUMENT_ROOT'] . "/todoapp/include/footer.php";
?>
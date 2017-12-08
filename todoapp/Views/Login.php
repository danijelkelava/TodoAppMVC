<?php
$pageTitle = "Login"; 
include $_SERVER['DOCUMENT_ROOT'] . "/todoapp/include/header.php";
?>
    <div class="container-fluid jumbotron">          
      <h1>Login Form</h1>
      <hr class="my-4">
      <p>Ako nemas korisnicki racun <a href="/todoapp/register">REGISTRIRAJ SE!</a></p>           
    </div>
    <div class="container">
      <div class="row">
        <?php 
          if (isset($_SESSION['error'])) {
           echo '<div class="alert alert-danger" role="alert">';
           echo $_SESSION['error']; 
           echo '</div>'; 
           unset($_SESSION['error']);        
          }
        ?>
      </div>
    	<div class="row">
        
    		<form method="post">
          <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" name="lozinka" class="form-control" id="exampleInputPassword1" placeholder="Password">
          </div>
          <button type="submit" name="login" class="btn btn-primary">Submit</button>
        </form>
    	</div>
    </div>


<?php 
include $_SERVER['DOCUMENT_ROOT'] . "/todoapp/include/footer.php";
?>
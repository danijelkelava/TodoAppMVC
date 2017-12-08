<?php 

$database = new Database;
$db = $database->getConnection();

$user = new User($db);

if (isset($_GET['active']) || isset($_POST['activation'])) {
  $tk = isset($_POST['activation']) ? $_POST['activation-code'] : $_GET['active'];
  $id = isset($_POST['activation']) ? $_POST['id'] : $_GET['id'];

  $user->activate($id, $tk);
}

$pageTitle = "Activation"; 
include $_SERVER['DOCUMENT_ROOT'] . "/todoapp/include/header.php";
?>
    <div class="container-fluid jumbotron">          
      <h1>Activation</h1>
      <hr class="my-4">
        <p>Poslali smo vam link za aktivaciju racuna na vasu email adresu ili unesite kod u polje za aktivaciju.</p> 
        </div>         
    <div class="container">
      <div class="row">
       <h2>Aktiviraj se</h2> 
      </div>    
    	<div class="row">    		
          <form method="post">
            <fieldset class="form-group">
              <label for="active">Kod za aktivaciju</label>
              <input type="text" class="form-control" id="active" name="activation-code" placeholder="Unesi kod za aktivaciju">
            </fieldset>
            <input type="hidden" name="id" value="<?php echo $_SESSION['id']; ?>" >
            <input class="btn btn-primary" type="submit" name="activation" value="Aktiviraj se" >
          </form>
    	</div>
    </div>


<?php 
include $_SERVER['DOCUMENT_ROOT'] . "/todoapp/include/footer.php";
?>
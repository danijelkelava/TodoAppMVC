<?php
Helper::redirect();
$pageTitle = "Create Todo"; 
include $_SERVER['DOCUMENT_ROOT'] . "/todoapp/include/header.php";
?>
    <div class="container-fluid jumbotron">          
      <h1 class="display-5">Kreiraj Todo</h1>
      <hr class="my-4">           
    </div>
    <div class="container">
    	<div class="row">
    		<div class="col">
        <form method="post">
          <div class="form-group">
            <label for="naziv_liste">Ime liste</label>
            <input type="text" class="form-control" id="naziv_liste" name="naziv_liste" aria-describedby="" placeholder="Unesite ime">
            <p class="text-danger"><?php if(isset($validationErrors['naziv_liste'])){ Helper::htmlout($validationErrors['naziv_liste']); } ?></p>
          </div>
          <button type="submit" class="btn btn-primary" name="create_todo_listu">Dodaj listu</button>
        </form>
    		</div>
    	</div>
    </div>
<?php 
include $_SERVER['DOCUMENT_ROOT'] . "/todoapp/include/footer.php";
?>
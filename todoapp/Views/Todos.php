<?php
Helper::redirect();
$pageTitle = "Todo Lista"; 
include $_SERVER['DOCUMENT_ROOT'] . "/todoapp/include/header.php";
?>
   <a href="/todoapp">POVRATAK NA NASLOVNU</a>
    <div class="container-fluid jumbotron">          
      <h1 class="display-5">Todo Lista</h1>
      <hr class="my-4">
	  <p class="lead">
	    <a class="btn btn-primary btn-lg" href="/todoapp/create_todo" role="button">Dodaj listu</a>	    
	  </p>           
    </div>
    <div class="container">
      <div class="row">
        <div class="col">
          <?php
             include $_SERVER['DOCUMENT_ROOT'] . "/todoapp/include/todo_sort.html.php"; 
          ?>
        </div>
      </div>
      <div class="row">
        <div class="col">

        </div>
      </div>
    </div>
    <div class="container">
    	<div class="row">
    		<div class="col">        
  
          <?php 
          $database = new Database;
          $db = $database->getConnection();
          $todos = new Todos($db);

          $todos->setOrder('ORDER BY datum_izrade DESC');

          if (isset($_POST['type']) && $_POST['type'] == 'najstarije') {
             $todos->setOrder('ORDER BY datum_izrade ASC');         
          } elseif (isset($_POST['type']) && $_POST['type'] == 'po nazivu'){
             $todos->setOrder('ORDER BY naziv_liste ASC');
          }

          $todo_liste = $todos->readTodos();
          
          ?>
    		</div>
    	</div>
    </div>
<?php 
include $_SERVER['DOCUMENT_ROOT'] . "/todoapp/include/footer.php";
?>



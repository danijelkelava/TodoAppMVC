
<?php
Helper::redirect();
$pageTitle = "Todo App"; 
include $_SERVER['DOCUMENT_ROOT'] . "/todoapp/include/header.php";
?>
    <a href="/todoapp/logout">Odlogiraj se</a>
    <div class="container-fluid jumbotron">          
      <h1 class="display-5">Todo App</h1>
      <p><?php echo $_SESSION['user']['ime'] . " " . $_SESSION['user']['prezime']; ?></p>
      <hr class="my-4">           
    </div>
    <div class="container">
    	<div class="row">
    		<nav>
    			<ul  class="list-group">
    				<li class="list-group-item"><a class="btn btn-primary btn-lg" href="/todoapp/todo">Idi na listu</a></li>
    			</ul>
    		</nav>
    	</div>
    </div>
    <div class="container">
    	<div class="row">
    		<!--<?php/*
    			$numVisits = Helper::getVisits();
    			if($numVisits > 1){
    			 include $_SERVER['DOCUMENT_ROOT'] . "/todoapp/include/welcome.html.php";
    			}else{
           Helper::notification('Dobrodosli na moju aplikaciju!!!!');
    			}*/
  			?>-->
    	</div>
    </div>

<?php 
include $_SERVER['DOCUMENT_ROOT'] . "/todoapp/include/footer.php";
?>
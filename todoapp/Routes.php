<?php

Route::set('index.php', function(){
	Index::CreateView("Index");
});

Route::set('todo', function(){

	if(isset($_GET['id'])) {
	  Todos::CreateView("Todo");  
	}else{
	  Todos::CreateView("Todos");
	}

	$database = new Database;
	$db = $database->getConnection();
	$todos = new Todos($db);
    $tasks = new Tasks($db);


	if(isset($_GET['delete_todo_listu'])) {
	  $todos->deleteTodos($_GET['id']);
	}

	if(isset($_POST['kreiraj_task'])) {
	  $tasks->setNazivTaska($_POST['naziv_taska']);
	  $tasks->setPrioritet($_POST['prioritet']);
	  $tasks->setRok($_POST['rok']);
	  $tasks->createTask($_POST['todoID']);
	}

	if(isset($_POST['finishTask'])) {
	  $tasks->finishTask($_POST['id'], $_POST['todoID']);
	} 

	if(isset($_POST['delete_task'])) {
      $tasks->deleteTask($_POST['id'], $_POST['todoID']);
    }
	 
});

Route::set('create_todo', function(){
	Todos::CreateView("CreateTodo");

	$database = new Database;
	$db = $database->getConnection();
	$todos = new Todos($db);
	
	if(isset($_POST['create_todo_listu'])) {
	  $todos->setNazivListe($_POST['naziv_liste']);
	  $todos->createTodos();
	}
});

Route::set('update_todo', function(){
	Tasks::CreateView("UpdateTodo");

	$database = new Database;
	$db = $database->getConnection();
	$todos = new Todos($db);

	if(isset($_POST['update_todo_listu'])) {;
	  $todos->setNazivListe($_POST['naziv_liste']);
	  $todos->updateTodo($_POST['todoID']);
	} 
});

Route::set('update_task', function(){
	Tasks::CreateView("UpdateTask");

	$database = new Database;
	$db = $database->getConnection();
	$tasks = new Tasks($db);

	if(isset($_POST['update_task'])) {
	  $tasks->setNazivTaska($_POST['naziv_taska']);
	  $tasks->setPrioritet($_POST['prioritet']);
	  $tasks->setRok($_POST['rok']);
	  $tasks->updateTask($_POST['id'], $_POST['todoID']);
    }
});

Route::set('login', function(){

	Todos::CreateView("Login");
	$database = new Database;
	$db = $database->getConnection();
	$user = new User($db);

	if (isset($_POST['login'])) {
    $user->setEmail($_POST['email']);
    $user->setLozinka($_POST['lozinka']);
    $user->login();
    }
});

Route::set('logout', function(){
	Todos::CreateView("Logout");
});

Route::set('register', function(){

	Todos::CreateView("Register");
	$database = new Database;
	$db = $database->getConnection();
	$user = new User($db);

	if (isset($_POST['register'])) {
    $user->setIme($_POST['ime']);
    $user->setPrezime($_POST['prezime']);
    $user->setEmail($_POST['email']);
    $user->setLozinka($_POST['lozinka']);
    $user->register();
    }
});

Route::set('activation', function(){
	Index::CreateView("Activation");
});



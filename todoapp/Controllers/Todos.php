<?php

class Todos extends Controller
{
	private $table_name = "todo";
	private $naziv_liste;
	private $order;
	private $db;

	public function __construct($db)
	{
		$this->db = $db;
	}

	public function setNazivListe($naziv_liste)
	{
		$this->naziv_liste = $naziv_liste;
	}

	public function setOrder($order)
	{
		$this->order = $order;
	}

	public function getOrder()
	{
		return $this->order;
	}

	public function createTodos()
	{
		try {
			$q = "INSERT INTO " . $this->table_name . " SET naziv_liste=:naziv_liste, datum_izrade=now()";
			$result = $this->db->prepare($q);
			$this->naziv_liste = htmlspecialchars(strip_tags($this->naziv_liste), ENT_QUOTES, 'UTF-8');
			$result->bindValue(':naziv_liste', $this->naziv_liste);
			$result->execute();
		} catch (Exception $e) {
			$_SESSION['error'] = "Database connection error: " . $e->getMessage();
            return;
		}
		

		header("Location:http://" . $_SERVER['HTTP_HOST'] . "/todoapp/todo");
	}

	public function readTodos()
	{
		try {
			$q = "SELECT id, naziv_liste, datum_izrade FROM " . $this->table_name . " " . $this->order;
		    $result = $this->db->query($q);
		} catch (Exception $e) {
			$_SESSION['error'] = "Database connection error: " . $e->getMessage();
            return;
		}

		foreach ($result as $row) {
			$todo_liste[] = ['id'=>$row['id'], 'naziv_liste'=>$row['naziv_liste'], 'datum_izrade'=>$row['datum_izrade']];
		}

		if (isset($todo_liste)) {
			include $_SERVER['DOCUMENT_ROOT'] . "/todoapp/include/todos.html.php";
		    return $todo_liste;
		}else{
			echo "Niste stvorili nijednu listu";
            return;
		}
	}

	public function deleteTodos($todoID)
	{
		
		try {
			$q = "DELETE FROM " . $this->table_name . " WHERE id=:id";
			$result = $this->db->prepare($q);
			$result->bindValue(':id', $todoID);
			$result->execute();			
		} catch (Exception $e) {
			$_SESSION['error'] = "Database connection error: " . $e->getMessage();
            return;
		}
		header("Location:http://" . $_SERVER['HTTP_HOST'] . "/todoapp/todo");
	}

	public function getTodoById($id)
	{
		try {
			$q = "SELECT * FROM " . $this->table_name . " WHERE id='$id'";		
			$result = $this->db->query($q);
			$row = $result->fetch();
	        return $row;
		} catch (Exception $e) {
			$_SESSION['error'] = "Database connection error: " . $e->getMessage();
            return;
		}		
	}

	public function updateTodo($id)
	{
		try {
			$q = "UPDATE " . $this->table_name . " SET naziv_liste=:naziv_liste WHERE id=:id";
			$result = $this->db->prepare($q);
			$result->bindValue(':naziv_liste', $this->naziv_liste);
			$result->bindValue(':id', $id);
			$result->execute();
		} catch (Exception $e) {
			$_SESSION['error'] = "Database connection error: " . $e->getMessage();
            return;
		}

		header("Location:http://" . $_SERVER['HTTP_HOST'] . "/todoapp/todo");		
	}
}
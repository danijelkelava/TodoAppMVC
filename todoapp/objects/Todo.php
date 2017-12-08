<?php 

class Todo
{
	private $db;
	private $table_name = "todo";
	private $ime_todo_liste;

	public function __construct($db)
	{
		$this->db = $db;
	}

	public function setImeTodoList($ime_todo_liste)
	{
		$this->ime_todo_liste = $ime_todo_liste;
	}

	public function createTodoList()
	{
		try {
			$q = "INSERT INTO " . $this->table_name . " SET ime_todo_liste=:ime_todo_liste, datum_izrade=now()";
			$result = $this->db->prepare($q);
			$this->ime_todo_liste = htmlspecialchars(strip_tags($this->ime_todo_liste), ENT_QUOTES, 'UTF-8');
			$result->bindValue(':ime_todo_liste', $this->ime_todo_liste);
		    $result->execute();
		} catch (Exception $e) {
			$_SESSION['error'] = "Database connection error: " . $e->getMessage();
            return;
		}
		

	    header("Location:http://" . $_SERVER['HTTP_HOST'] . "/todoapp/");

	}

	public function readTodoList($order)
	{
		try {
			$q = "SELECT id, ime_todo_liste, datum_izrade FROM " . $this->table_name . " " . $order;
		    $result = $this->db->query($q);
		} catch (Exception $e) {
			$_SESSION['error'] = "Database connection error: " . $e->getMessage();
            return;
		}
		
		foreach ($result as $row) {
			$todo_liste[] = ['id'=>$row['id'], 'ime_todo_liste'=>$row['ime_todo_liste'], 'datum_izrade'=>$row['datum_izrade']];
		}

		if (isset($todo_liste)) {
			include $_SERVER['DOCUMENT_ROOT'] . "/todoapp/include/todo_liste.html.php";
		    return $todo_liste;
		}else{
			$_SESSION['todo_info'] = "Niste stvorili nijednu listu";
            return;
		}                
	}

	public function deleteTodoList($todoID)
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
		
	}

	/*public function getTodoById($id)
	{
		$q = "SELECT * FROM " . $this->table_name . " WHERE id='$id'";
		$result = $this->db->query($q);
		$row = $result->fetch();
	}*/
}
<?php 
//ob_start();
class Tasks extends Controller
{
	private $table_name = 'task';
	private $naziv_taska;
	private $prioritet;
	private $rok;
	private $db;

	public function __construct($db)
	{
		$this->db = $db;
	}

	public function setNazivTaska($naziv_taska)
	{
		$this->naziv_taska = $naziv_taska;
	}

	public function setPrioritet($prioritet)
	{
		$this->prioritet = $prioritet;
	}

	public function setRok($rok)
	{
		$this->rok = $rok;
	}

	public function createTask($id){

		try {
			$q = "INSERT INTO " . $this->table_name . " SET naziv_taska=:naziv_taska, prioritet=:prioritet, rok=:rok, todoID=:todoid";
			$result = $this->db->prepare($q);

			$this->naziv_taska = htmlspecialchars(strip_tags($this->naziv_taska), ENT_QUOTES, 'UTF-8');
			$this->prioritet = htmlspecialchars(strip_tags($this->prioritet), ENT_QUOTES, 'UTF-8');
			$this->rok = htmlspecialchars(strip_tags($this->rok), ENT_QUOTES, 'UTF-8');

			$result->bindValue(':naziv_taska', $this->naziv_taska);
			$result->bindValue(':prioritet', $this->prioritet);
			$result->bindValue(':rok', $this->rok);
			$result->bindValue(':todoid', $_POST['todoID']);
			
			$result->execute();
			} catch (PDOException $e) {
				$_SESSION['error'] = "Database connection error: " . $e->getMessage();
	            return;
			}
					
		header("Location:http://" . $_SERVER['HTTP_HOST'] . "/todoapp/todo/?id=" . $id );
	}

	public function readTasks($where, $order, $id)
	{
		try {
			$q = "SELECT todo.id as todoid, task.id as taskid, prioritet, rok, status, naziv_taska, DATEDIFF(rok, CURDATE()) as datediff FROM todo left OUTER JOIN task ON todoID=todo.id WHERE todo.id='$id'" . $where . "" . $order;
		    $result = $this->db->query($q);
		} catch (Exception $e) {
			$_SESSION['error'] = "Database connection error: " . $e->getMessage();
	        return;
		}
		

		foreach ($result as $row) {
			$tasks[] = ['todoid'=>$row['todoid'], 'taskid'=>$row['taskid'], 'naziv_taska'=>$row['naziv_taska'], 'prioritet'=>$row['prioritet'], 'rok'=>$row['rok'], 'status'=>$row['status'], 'datediff'=>$row['datediff']];
		}
		
		if (isset($row['taskid'])) {
			include $_SERVER['DOCUMENT_ROOT'] . "/todoapp/include/tasks.html.php";
		    return $tasks;
		}else{
			echo "Ne postoji!!!";
            return;
		}
        /*
		if(empty($row['taskid'])){
			echo "Niste stvorili nijedan task!!!";			
			exit();
		}else{
			include $_SERVER['DOCUMENT_ROOT'] . "/todoapp/include/tasks.html.php";
		}*/
	}

	public function finishTask($id, $todoID){
		try {
			$q = "UPDATE " . $this->table_name . " SET status='zavrseno' WHERE id=:id";
			$result = $this->db->prepare($q);
			$result->bindValue(':id', $id);
			$result->execute();
		} catch (PDOException $e) {
			$_SESSION['error'] = "Database connection error: " . $e->getMessage();
            return;
		}

		header("Location:http://" . $_SERVER['HTTP_HOST'] . "/todoapp/todo/?id=" . $todoID );
	}

	public function getTaskById($id){
		try {
			$q = "SELECT id, naziv_taska, prioritet, rok, status, todoID FROM " . $this->table_name . " WHERE id='$id'";
		    $result = $this->db->query($q);
		    $row = $result->fetch();
		    return $row;
		} catch (PDOException $e) {
			$_SESSION['error'] = "Database connection error: " . $e->getMessage();
            return;
		}				 
	}

	public function getEnumValues(){
		try {
			$q = "SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
              WHERE TABLE_SCHEMA = 'todoapp2' AND TABLE_NAME = 'task' AND COLUMN_NAME = 'prioritet'";
            $result = $this->db->query($q);
            $row = $result->fetch();
	        $enum = explode(",", str_replace("'", "", substr($row['COLUMN_TYPE'], 5, (strlen($row['COLUMN_TYPE'])-6))));
	        return $enum;
		} catch (PDOException $e) {
			$_SESSION['error'] = "Database connection error: " . $e->getMessage();
            return;
		}        
	}

	public function updateTask($taskID, $todoID){
		try {
			$q = "UPDATE " . $this->table_name . " SET naziv_taska=:naziv_taska, prioritet=:prioritet, rok=:rok, status='nije zavrseno', todoID=:todoID WHERE id='$taskID'";
			$result = $this->db->prepare($q);
			$this->naziv_taska = htmlspecialchars(strip_tags($this->naziv_taska), ENT_QUOTES, 'UTF-8');
			$this->prioritet = htmlspecialchars(strip_tags($this->prioritet), ENT_QUOTES, 'UTF-8');
			$this->rok = htmlspecialchars(strip_tags($this->rok), ENT_QUOTES, 'UTF-8');
			$result->bindValue(':naziv_taska', $this->naziv_taska);
			$result->bindValue(':prioritet', $this->prioritet);
			$result->bindValue(':rok', $this->rok);
			$result->bindValue(':todoID', $_POST['todoID']);
			$result->execute();
		} catch (PDOException $e) {
			$_SESSION['error'] = "Database connection error: " . $e->getMessage();
            return;
		}
		
		header("Location:http://" . $_SERVER['HTTP_HOST'] . "/todoapp/todo/?id=" . $todoID );
	}

	public function deleteTask($id, $todoID){
		try {
			$q = "DELETE FROM " . $this->table_name . " WHERE id='$id'";
			$result = $this->db->query($q); 
		} catch (PDOException $e) {
			$_SESSION['error'] = "Database connection error: " . $e->getMessage();
            return;
		}

		header("Location:http://" . $_SERVER['HTTP_HOST'] . "/todoapp/todo/?id=" . $todoID );
	}
}

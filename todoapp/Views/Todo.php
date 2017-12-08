<?php
  Helper::redirect();
  
  ob_start();
  
  $database = new Database;
  $db = $database->getConnection();
  $todos = new Todos($db);
  $tasks = new Tasks($db);

  $row = $todos->getTodoById($_GET['id']);

  $pageTitle = "Task List"; 
  include $_SERVER['DOCUMENT_ROOT'] . "/todoapp/include/header.php";
?>
    <a href="/todoapp/todo">POVRATAK NA LISTU</a>
    <div class="container-fluid jumbotron">
      <h1 class="display-5"><?php Helper::htmlout($row['naziv_liste']);?></h1>
      <p>Lista kreirana: <?php Helper::htmlout($row['datum_izrade']);?></p>
      
    <form method="get">
      <div class="form-group">
        <input class="btn btn-danger" type="submit" name="delete_todo_listu" value="delete">
      </div>
      <input type="hidden" name="id" value="<?php Helper::htmlout($row['id']);?>"> 
    </form>
    <hr class="my-4">
    <form class="bg-info table form-inline" method="post">
    <fieldset class="form-group">
    <label for="naziv_taska">IME ZADATKA:</label>
    <input type="text" class="form-control" id="naziv_taska" name="naziv_taska" placeholder="Ime zadatka" value="" required>
    </fieldset>

    <fieldset class="form-group">
    <label for="prioritet">PRIORITET:</label>
    <select id="prioritet" name="prioritet">
      <option value="low">low</option>
      <option value="normal">normal</option>
      <option value="high">high</option>
    </select>
    </fieldset>

    <fieldset class="form-group">
    <label for="rok">ROK:</label>
    <input type="date" class="form-control" id="rok" name="rok" placeholder="MM/DD/YYY" value="" required>
    </fieldset>
      <input type="hidden" name="todoID" value="<?php Helper::htmlout($row['id']); ?>">
    <button class="btn btn-default" type="submit" name="kreiraj_task" role="button">Kreiraj task</button> 
    </form>  

    </div>
    <div class="container">
      <div class="row">
        <div class="col">
        <?php
          include $_SERVER['DOCUMENT_ROOT'] . "/todoapp/include/task_sort.html.php";
       
          $where = "";
          $order = " ORDER BY taskid DESC";

          if (isset($_POST['type']) && $_POST['type'] == 'najstarije') {
            $order = " ORDER BY taskid ASC";
          }
          if (isset($_POST['type']) && $_POST['type'] == 'po nazivu') {
            $order = " ORDER BY naziv_taska ASC";
          }
          if (isset($_POST['type']) && $_POST['type'] == 'zavrseno') {
            $where = " AND status='zavrseno' ";
          }
          if (isset($_POST['type']) && $_POST['type'] == 'nije zavrseno') {
            $where = " AND status='nije zavrseno' ";
          }
          if (isset($_POST['type']) && $_POST['type'] == 'low') {
            $where = " AND prioritet='low' ";
          }
          if (isset($_POST['type']) && $_POST['type'] == 'normal') {
            $where = " AND prioritet='normal' ";
          }
          if (isset($_POST['type']) && $_POST['type'] == 'high') {
            $where = " AND prioritet='high' ";
          }

          $tasks->readTasks($where, $order, $_GET['id']);

        ?>
        </div>
      </div>
    </div>
  
<?php 
include $_SERVER['DOCUMENT_ROOT'] . "/todoapp/include/footer.php";
?>


<table class="table">
  <thead>
    <tr>
      <th scope="col">Ime Taska</th>
      <th scope="col">Prioritet</th>
      <th scope="col">Rok Izvrsavanja</th>      
      <th scope="col">Status</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($tasks as $task) { ?>
    <tr>
    <td>
      <p><?php Helper::htmlout($task['naziv_taska']);?></p>
    </td>
    <td>
      <p><?php Helper::htmlout($task['prioritet']);?></p>
    </td>
    <td>
      <p><?php Helper::dateFormat($task['rok']);?></p>
    </td>
    <td>
      <p><?php Helper::htmlout($task['status']);?></p>
    </td>
    <td>
      <p><?php           
        if ($task['status'] == 'zavrseno') {

          if ($task['datediff'] < 0) {
            echo Helper::htmlout(abs($task['datediff'])) .' dana poslije roka';
          }else{
            echo Helper::htmlout(abs($task['datediff'])) .' dana prije roka';
          }

        }else{

          if ($task['datediff'] >= 0) {
              echo 'Preostalo dana: ';
          }else{
            echo '<span class="alert-danger">';
            echo 'Kasnjenje: ';
            echo '</span>';
          }
            Helper::htmlout(abs($task['datediff'])) . ' dana';
          }
          
      ?></p>
    </td>
    <td>
      <form class="form-inline" method="post">
        <div class="">           
          <input class="btn btn-default" type="submit" name="finishTask" value="&times;" 
                      <?php 
                      if ($task['status'] == 'zavrseno') {
                        echo 'disabled';
                      }
                      ?>
          >           
        </div>
        <input type="hidden" name="todoID" value="<?php Helper::htmlout($task['todoid']);?>">
        <input type="hidden" name="id" value="<?php Helper::htmlout($task['taskid']);?>"> 
      </form>
    </td>
    <td>
      <a class="btn btn-info" href="/todoapp/update_task/?id=<?php Helper::htmlout($task['taskid']);?>">update</a>
    </td>
    <td>
      <form method="post">
        <div class="form-group">
          <input class="btn btn-danger" type="submit" name="delete_task" value="delete">
        </div>
        <input type="hidden" name="todoID" value="<?php Helper::htmlout($task['todoid']);?>">
        <input type="hidden" name="id" value="<?php Helper::htmlout($task['taskid']);?>">
      </form>
    </td> 
    </tr>
  <?php } ?>
  </tbody>
</table>
<table class="table">
  <thead>
    <tr>
      <th scope="col">Ime Liste/Idi na Listu</th>
      <th scope="col">Datum Izrade</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($todo_liste as $todo_lista) { ?>
    <tr>
    <td>
      <a href="/todoapp/todo/?id=<?php Helper::htmlout($todo_lista['id']);?>"><?php Helper::htmlout($todo_lista['naziv_liste']);?></a>
    </td>
    <td>
      <p><?php Helper::htmlout($todo_lista['datum_izrade']);?></p>
    </td>
    <td>
      <a class="btn btn-info" href="/todoapp/update_todo/?id=<?php Helper::htmlout($todo_lista['id']);?>">update</a>
    </td>
    <td>
      <form method="get">
        <div class="form-group">
          <input class="btn btn-danger" type="submit" name="delete_todo_listu" value="delete">
        </div>
        <input type="hidden" name="id" value="<?php Helper::htmlout($todo_lista['id']);?>"> 
      </form>
    </td> 
    </tr>
  <?php } ?>
  </tbody>
</table>
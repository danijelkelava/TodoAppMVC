<form class="form-inline" action="" method="post">
  <fieldset class="form-group">
    <label for="type">Sortiraj po:</label>
    <select name="type" onchange='this.form.submit()'; required>
        <option value="najnovije">Najnovije</option>
      <option value="najstarije" <?php if (isset($_POST['type']) && $_POST['type'] == 'najstarije') {echo 'selected';}?>>Najstarije</option>
      <option value="po nazivu" <?php if (isset($_POST['type']) && $_POST['type'] == 'po nazivu') {echo 'selected';}?>>Po nazivu</option>
      <option value="zavrseno" <?php if (isset($_POST['type']) && $_POST['type'] == 'zavrseno') {echo 'selected';}?>>Zavrseno</option>
      <option value="nije zavrseno" <?php if (isset($_POST['type']) && $_POST['type'] == 'nije zavrseno') {echo 'selected';}?>>Nije zavrseno</option>
      <option value="low" <?php if (isset($_POST['type']) && $_POST['type'] == 'low') {echo 'selected';}?>>Low</option>
      <option value="normal" <?php if (isset($_POST['type']) && $_POST['type'] == 'normal') {echo 'selected';}?>>Normal</option>
      <option value="high" <?php if (isset($_POST['type']) && $_POST['type'] == 'high') {echo 'selected';}?>>High</option>                  
    </select>
  </fieldset> 
<!--<input class="btn btn-primary btn-xs" type="submit" name="sort" value="Sortiraj">-->
</form>
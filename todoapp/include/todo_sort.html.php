<form class="form-inline" method="post">
	<fieldset class="form-group">
		<label for="type">Sortiraj po:</label>
		<select name="type" onchange='this.form.submit()'; required>
		    <option value="najnovije">Najnovije</option>
			<option value="najstarije" <?php if (isset($_POST['type']) && $_POST['type'] == 'najstarije') {echo 'selected';}?>>Najstarije</option>
			<option value="po nazivu" <?php if (isset($_POST['type']) && $_POST['type'] == 'po nazivu') {echo 'selected';}?>>Po nazivu</option>			
		</select>
	</fieldset>	
</form>
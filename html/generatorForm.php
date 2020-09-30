<h1>MVC + HTML Generator</h1>

<p>Pick the table you want to generate the set for</p>

<form action="<?=URL?>/gen/action" method="post">
    <label>Generate a MVC + HTML set for table: </label>
    <select name='table'>
    <?foreach($tables as $table){?>
        <?$dbname = DB_DATABASE?>
        <option><?=$table["Tables_in_$dbname"]?></option>
    <?}?>
    </select><br>
    <label>&nbsp;</label><input type="submit" value="Generate" class="button-primary">
</form>

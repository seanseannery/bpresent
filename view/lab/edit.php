<?php
$temp = new user();
$admins = $temp->getAll(array('role'=>'admin'));
$tas = $temp->getAll(array('role'=>'ta'));
$all_admins = array_merge($admins, $tas);

$data->quarter == "spring" ? "selected=true" : ""
?>


<form>
<p>
Quarter: 
<select name="quarter">
  <option value="spring" <?= ($data->quarter == "spring" ? 'selected="true"' : "") ?> >Spring</option>
  <option value="summer" <?= ($data->quarter == "summer" ? 'selected="true"' : "") ?> >Summer</option>
  <option value="fall" <?= ($data->quarter == "fall" ? 'selected="true"' : "") ?> >Fall</option>
  <option value="winter" <?= ($data->quarter == "winter" ? 'selected="true"' : "") ?> >Winter</option>
</select>
<select name="year">
  <option value="2013" <?= ($data->year == "2013" ? 'selected="true"' : "") ?> >2013</option>
  <option value="2014" <?= ($data->year == "2014" ? 'selected="true"' : "") ?> >2014</option>
  <option value="2015" <?= ($data->year == "2015" ? 'selected="true"' : "") ?> >2015</option>
  <option value="2016" <?= ($data->year == "2016" ? 'selected="true"' : "") ?> >2016</option>
  <option value="2017" <?= ($data->year == "2017" ? 'selected="true"' : "") ?> >2017</option>
  <option value="2018" <?= ($data->year == "2018" ? 'selected="true"' : "") ?> >2018</option>
  <option value="2019" <?= ($data->year == "2019" ? 'selected="true"' : "") ?> >2019</option>
  <option value="2020" <?= ($data->year == "2020" ? 'selected="true"' : "") ?> >2020</option>
</select>
</p>

<p> Name: 
<input type="text" name="name" value="<?= $data->classname ?>"/>
</p>

<p>
Time:
<input type="text" name="time" value="<?= $data->labtime ?>"/>
</p>

<p>
TAs:
<?php 

foreach( $all_admins as $ta) {

?>
	<input type="checkbox" name="tas" value="<?php echo $ta->id ?>"><?php echo $ta->name ?><br />
<?php 
}
?>
</p>

<input type="submit" name="a" value="save"/>
<?php 
if ($data->id != "") 
{
?>
	<input type="submit" name="a" value="destroy"/>
<?php 
} 
?>
<input type="hidden" name="c" value="lab" />
<input type="hidden" name="id" value="<?= ($data->id == "" ? "NULL" : $data->id) ?>" />


</form>
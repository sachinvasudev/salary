<html>
<head>
<title>
Salary
</title>



<link type="text/css" rel="stylesheet" href="salary.css"/>
<link rel="stylesheet" type="text/css" media="all" href="calendar/jsDatePick_ltr.min.css" />

<script type="text/javascript" src="calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript" src="salary.js"></script>




</head>

<body>
	
<?php

if(!isset($_POST['generate']))
{

?>

<form method="POST" action="" name="myform" onsubmit="return validate_f1()">

<h1 class="heading">Salary Calculator</h1>


<table border="2">
	<tr>
		
		<td colspan="2">
			Start Date
			<input name="d1"  id="d1" type="text"/> 
		</td>
			
		<td colspan="2">
			End Date
			<input name="d2" id="d2" type="text"/>
			
		</td>
		
</table>

<table border="2">
		
	</tr>
	
	<tr>
		
		<td>
			Salary Rate/hr
			<input name="salaryRate" id="salaryRate1" type="text"/>
			
		</td>
		
		<td>
			Overtime Rate/hr
			<input name="overTimeRate"  id="overTimeRate1"  type="text"/>
			
		</td>
		
			<td>
			Tax Rate(%)
			<input name="taxRate" id="taxRate1" type="text"/>
			
		</td>
		
		
	</tr>
	
	
</table>






<br/>
<input type="submit" name="generate" value="Generate Form"/>


</form>

<?php
}
else
{
	$d1=strtotime($_POST['d1']);
	$d2=strtotime($_POST['d2']);
	$salaryRate= $_POST['salaryRate'];
	$overTimeRate= $_POST['overTimeRate'];
	$taxRate= $_POST['taxRate'];
	
	
$hours= array("9","10","11","12","13","14","15","16","17");
$hours1= array("09 AM","10 AM","11 AM","12 PM","01 PM","02 PM","03 PM","04 PM","05 PM");
$otHours = array("17","18","19");
$otHours1 = array("05 PM","06 PM","07 PM");


$days = abs(round(($d1-$d2)/86400));


echo 'Salary Details From '.date('dS F,Y',$d1).' to '.date('dS F,Y',$d2);


?>


<h2 class="heading">Work Hours</h2>

<form method="post" />
<input type="hidden" name="days" id ="days" value="<?php echo $days;?>"/>



<?php
for($k=0;$k<=$days;$k++)
{
	
?>

<table border="1"  id="rowa<?php echo $k?>">  
<tr>

	
	
	<td colspan="2">
	   <input type="button" id ="editButton<?php echo $k?>" value="View" onclick="expand(this)">
	</td>
	
	<td colspan="2">
	   &nbsp;Leave <input type="checkbox" id ="markLeave<?php echo $k?>" value="View" onclick="markLeave(this)">
	</td>
	
	<td colspan="2">
	    <?php echo date('dS F,Y',$d1);  ?>	
	</td>

</tr>

<tr class = "collapsed" id="rowb<?php echo $k?>">  
	 <td>
	 	 Work Hours:
	  </td>
	<td>
		<select name="HoursStart[]" id="HoursStart<?php echo $k?>" onchange="updateHours(this)">
		<?php
		
			foreach($hours as $key=>$val)
			echo "<option value=\"$val\">$hours1[$key]</option>"
			?></select>
			
			<select name="MinutesStart[]" id="MinutesStart<?php echo $k?>" onchange="updateHours(this)">
			<?php
			for($i=0;$i<60;$i++)
			{
				echo "<option value=\"$i\">$i</option>";
			}
			?></select>
			
			<select name="SecondsStart[]" id="SecondsStart<?php echo $k?>" onchange="updateHours(this)">
				<?php
			for($i=0;$i<60;$i++)
			{
			
				echo "<option value=\"$i\">$i</option>";
			}
			?></select>
						
	
	</td>
	
	<td>
		 &nbsp&nbsp to &nbsp&nbsp
	 </td>
		<td>
		<select name="HoursEnd[]" id="HoursEnd<?php echo $k?>" onchange="updateHours(this)">
			
			<?php
			foreach($hours as $key=>$val)
			{
			if($val==17)
			echo '<option selected="selected" value="17">5 PM</option>';
			else	
			echo "<option value=\"$val\">$hours1[$key]</option>";
			}
			?></select>
			
			<select name="MinutesEnd[]" disabled="disabled" id="MinutesEnd<?php echo $k?>" onchange="updateHours(this)">
			<?php
			for($i=0;$i<60;$i++)
			{
			
				echo "<option value=\"$i\">$i</option>";
			}
			?></select>
			
			<select name="SecondsEnd[]" disabled="disabled" id="SecondsEnd<?php echo $k?>" onchange="updateHours(this)">
				<?php
			for($i=0;$i<60;$i++)
			{
			
				echo "<option value=\"$i\">$i</option>";
			}
			?></select>
			
		
	</td>
	<td>
		&nbsp&nbsp=&nbsp&nbsp
	 </td>
	<td>
		 <input name="Hours[]" id="Hours<?php echo $k?>" type="text" size="2"value="8.00"readonly="readonly"/>

	
		Hours&nbsp;

	</td>


</tr>

<tr class = "collapsed" id="rowc<?php echo $k?>">
	
</tr>

<tr class="collapsed" id="rowd<?php echo $k?>">
	 <td>
	 	<input type="checkbox" name="otOverTime[]" id="otOverTime<?php echo $k?>" onclick="enableOverTime(this)"/>
	 	<input type="hidden" name="otOverTimeEnabled[]" id="otOverTimeEnabled<?php echo $k?>" value="false"/>
	 	 Overtime:
	  </td>
	<td>
		<select name="otHoursStart" id="otHoursStart<?php echo $k?>" disabled="disabled" onchange="updateHours(this)">
			
			<?php
		
			foreach($otHours as $key=>$val)
			echo "<option value=\"$val\">$otHours1[$key]</option>";
			
			?></select>


		<select name="otMinutesStart" id="otMinutesStart<?php echo $k?>" disabled="disabled" onchange="updateHours(this)">
			<?php
			for($i=0;$i<60;$i++)
			{
				echo "<option value=\"$i\">$i</option>";
			}
			?></select>
	
	
	
		
		<select name="otSecondsStart[]" id="otSecondsStart<?php echo $k?>" disabled="disabled" onchange="updateHours(this)">
				<?php
			for($i=0;$i<60;$i++)
			{
			
				echo "<option value=\"$i\">$i</option>";
			}
			?></select>

	

	
	</td>
	
	<td>
		 to
	 </td>
		<td>
		<select name="otHoursEnd[]" id="otHoursEnd<?php echo $k?>" disabled="disabled" onchange="updateHours(this)">
			
			<?php
			foreach($otHours as $key=>$val)
			{
			if($val==19)
			echo '<option selected="selected" value="19">7 PM</option>';
			else	
				echo "<option value=\"$val\">$otHours1[$key]</option>";
			}
			?></select>
	
		<select name="otMinutesEnd[]" id="otMinutesEnd<?php echo $k?>" disabled="disabled" onchange="updateHours(this)">
			<?php
			for($i=0;$i<60;$i++)
			{
			
				echo "<option value=\"$i\">$i</option>";
			}
			?></select>

		
		<select name="otSecondsEnd[]" id="otSecondsEnd<?php echo $k?>" disabled="disabled" onchange="updateHours(this)">
				<?php
			for($i=0;$i<60;$i++)
			{
			
				echo "<option value=\"$i\">$i</option>";
			}
			?></select>

	 
	</td>
	<td>
		&nbsp&nbsp=&nbsp&nbsp
	 </td>
	<td>
		 <input name="otHours[]" id="otHours<?php echo $k?>" disabled="disabled" type="text"  size="2"value=""readonly="readonly"/>

	Hours&nbsp;

	</td>


</tr>
</table>
<?php

$d1+=86400;
}
?>



<br/>
<h2 class="heading">Rates</h2>
<table border="1" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			&nbsp;Salary Rate:
			<input type="text" onchange = "updateDisplays()" size="15" name="salaryRate" id="salaryRate" value="<?php echo $salaryRate?>"/>
			per hour&nbsp;
			
		</td>
		
		<td>
			&nbsp;Overtime Rate:
			<input type="text" onchange = "updateDisplays()" size="15"name="overTimeRate" id="overTimeRate" value="<?php echo $overTimeRate;?>"/>
			per hour&nbsp;
			
		</td>
		
	</tr>
</table>



<br/>
<h2 class="heading">Salary Calculation</h2>
<table border="1" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			&nbsp;Gross Income:
			<input type="text" size="15" name="grossIncome" id="grossIncome" readonly="readonly"/>
			&nbsp;
			
		</td>
		
		<td>
			&nbsp;Tax Rate:&nbsp;&nbsp;&nbsp;&nbsp
			<input type="text" size="15" onchange = "updateDisplays()" name="taxRate" id="taxRate" value="<?php echo $taxRate;?>"/>
			%&nbsp;
			
		</td>
		
	</tr>
	
	<tr>
		<td>
			&nbsp;Tax Deduction:
			<input type="text" size="15" name="taxDecuction" id="taxDeduction" readonly="readonly"/>
			&nbsp;
			
		</td>
		
		<td>
			&nbsp;Net Income:
			<input type="text" size="15"name="netIncome" id="netIncome" readonly="readonly"/>
			&nbsp;&nbsp;&nbsp;&nbsp;
			
		</td>
		
	</tr>
	
</table>

<input type="reset">

</form>

<script type="text/javascript">
window.onload=updateDisplays();	

</script>

<?php


}
?>



</body>
 

</html>

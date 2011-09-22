<?php
if(isset($_POST['submit']))
{
	$days = $_POST['days'];
	$startDate = $_POST['startDate'];
	$endDate = $_POST['endDate'];
	
	
	$HoursStart = $_POST['HoursStart'];
	$MinutesStart = $_POST['MinutesStart'];
	$SecondsStart = $_POST['SecondsStart'];
	$HoursEnd = $_POST['HoursEnd'];
	$MinutesEnd = $_POST['MinutesEnd'];
	$SecondsEnd = $_POST['SecondsEnd'];
				
	$otHoursStart = $_POST['otHoursStart'];
	$otMinutesStart = $_POST['otMinutesStart'];
	$otSecondsStart = $_POST['otSecondsStart'];
	$otHoursEnd = $_POST['otHoursEnd'];
	$otMinutesEnd = $_POST['otMinutesEnd'];
	$otSecondsEnd = $_POST['otSecondsEnd'];
	$otEnabled = $_POST['otOverTimeEnabled'];
	
	$salaryRate = $_POST['salaryRate'];
	$overTimeRate= $_POST['overTimeRate'];
	$taxRate = $_POST['taxRate']/100;
	
	
    
	$leaveDays=0;
	if(isset($_POST['markLeave']))
	$leaveDays = (sizeof($_POST['markLeave']));
	
	
	$grossIncome = $_POST['grossIncome'];
	$netIncome = $_POST['netIncome'];
	
	$startTime = new DateTime();
	$endTime = new DateTime();
	
	$otstartTime = new DateTime();
	$otendTime = new DateTime();
	
	$totalHours=0;
	$totalHoursOt=0;
	
	$averageStart=0;
	$averageEnd=0;
	
	for($i=0;$i<=$days;$i++)
	{
		$hourS = $HoursStart[$i];
		$minuteS = $MinutesStart[$i];
	    $secondS = $SecondsStart[$i];
		$hourE = $HoursEnd[$i];
		$minuteE = $MinutesEnd[$i];
	    $secondE = $SecondsEnd[$i];
		
		$othourS = $otHoursStart[$i];
		$otminuteS = $otMinutesStart[$i];
	    $otsecondS = $otSecondsStart[$i];
		$othourE = $otHoursEnd[$i];
		$otminuteE = $otMinutesEnd[$i];
	    $otsecondE = $otSecondsEnd[$i];
		
	
		$startTime->setTime((int)$hourS,(int)$minuteS,(int)$secondS);
		$endTime->setTime((int)$hourE,(int)$minuteE,(int)$secondE);
		
		$otstartTime->setTime((int)$othourS,(int)$otminuteS,(int)$otsecondS);
		$otendTime->setTime((int)$othourE,(int)$otminuteE,(int)$otsecondE);
		
		$averageStart+= $startTime->format('H')+$startTime->format('i')/60;
		$averageEnd+= $endTime->format('H')+$endTime->format('i')/60;
		
		
	//
		//echo  $startTime->format('Y/m/d H:i:s');		
		//echo '<br/>';
		
		
		$difference= abs($endTime->format('U')- $startTime->format('U'))/3600;
		if($otEnabled[$i]=="true")
		$otdifference= abs($otendTime->format('U')- $otstartTime->format('U'))/3600;
		else $otdifference=0;
		
		$totalHours+=$difference;
		$totalHoursOt+=$otdifference;
		
		
		
		
}

$totalHours=round($totalHours,2);
$totalHoursOt=round($totalHoursOt,2);

$grossIncome = round($totalHours*$salaryRate+$totalHoursOt*$overTimeRate,2);
$deduction = round($taxRate*$grossIncome,2);
$netIncome = $grossIncome-$deduction;



$averageStart=$averageStart/($days+1);
$startExp = explode('.',$averageStart);
if(sizeof($startExp)==1)
$startExp[1]=0;

$startExp[1]='.'.$startExp[1]; //making into decimal the minutes part

$startExp[1] = floor($startExp[1]*60);
$startExp[1]= str_pad($startExp[1],2,'0',STR_PAD_LEFT); //adding padding to hours and minutes
$startExp[0]= str_pad($startExp[0],2,'0',STR_PAD_LEFT);
$averageStart = $startExp[0].':'.$startExp[1];

$averageEnd=$averageEnd/($days+1);
$endExp = explode('.',$averageEnd);
if(sizeof($endExp)==1)
$endExp[1]=0;
$endExp[1]='.'.$endExp[1]; //making into decimal the minutes part

$endExp[1] = floor($endExp[1]*60); // removing the seconds portion
$endExp[1]= str_pad($endExp[1],2,'0',STR_PAD_LEFT); //adding padding to hours and minutes
$endExp[0]= str_pad($endExp[0],2,'0',STR_PAD_LEFT);
$averageEnd = $endExp[0].':'.$endExp[1];



	


?>

<html>
	
	<head>
		<title>
			Salary Report
		</title>
		
		<link type="text/css" rel="stylesheet" href="salary.css"/>
		
	</head>
	<body>
		
		<h1 class="heading">Salary Report</h1>
		
		<h2 class="heading">
			<?php echo 'Salary details from '.date('dS F,Y',$startDate).' to '.date('dS F,Y',$endDate);?>
			</h2>
		
		<table border="5" >
			
			<tr>
				<th>Total working hours</th>
				<td><?php echo $totalHours;?></td>
				<td></td>
				<th>Average start time</th>
				<td><?php echo $averageStart;?></td>
				
				
			</tr>
			
			<tr>
				<th>Total overtime hours </th>
				<td><?php echo $totalHoursOt;?></td>
				<td></td>
				<th>Average end time </th>
				<td><?php echo $averageEnd;	?></td>
				
			</tr>
			
			<tr>
				<th>Total hours</th>
				<td><?php echo $totalHours+$totalHoursOt?></td>
				<td></td>
				<th>Gross Income</th>
				<td><?php echo number_format($grossIncome,2);?></td>
			</tr>
				
			<tr>
				<th>Total working days</th>
				<td><?php echo $days-$leaveDays+1;?></td>
				<td></td>
				<th>Tax Deduction </th>
				<td><?php echo number_format($deduction,2);?></td>
			</tr>
			
				<tr>
				<th>Total days on leave</th>
				<td><?php echo $leaveDays;?></td>
				<td></td>
				<th>Net Income </th>
				<td><?php echo number_format($netIncome,2);?></td>
			</tr>
					
					
				
				
				
			</tr>
			
		</table>
		
	</body>
	
</html>

<?php
}
else
header("Location: index.php"); 
?>

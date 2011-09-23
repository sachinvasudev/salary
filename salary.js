

window.onload = function() {

		new JsDatePick({
			useMode : 2,
			target : "d1",
			dateFormat : "%d-%m-%Y",
			imgPath:"calendar/img/"


		});

		new JsDatePick({
			useMode : 2,
			target : "d2",
			dateFormat : "%d-%m-%Y"
		});
		

    
	}
	


function validate_f1()
{
  var salaryRate= document.getElementById("salaryRate1");
  var overTimeRate= document.getElementById("overTimeRate1");
  var taxRate = document.getElementById("taxRate1");
  var startDate = document.getElementById("d1");
  var endDate = document.getElementById("d2");
  
  
  
	if(isEmpty(startDate, "Start Date")) {
		if(isValidDate(startDate, "Start Date")) {
			if(isEmpty(endDate, "End Date")) {
				if(isValidDate(endDate, "End Date")) {

					if(compareDates(startDate, endDate)) {

						if(isEmpty(salaryRate, "Salary Rate")) {
							if(isNum(salaryRate, "Salary Rate")) {

								if(isEmpty(overTimeRate, "Overtime Rate")) {
									if(isNum(overTimeRate, "Overtime Rate")) {

										if(isEmpty(taxRate, "Tax Rate")) {
											if(isNum(taxRate, "Tax Rate")) {
												return true;

											}
										}

									}
								}

							}
						}

					}

				}

			}

		}

	}

  

  return false;	
  
  
}

function validate_f2()
{
	
  var salaryRate= document.getElementById("salaryRate");
  var overTimeRate= document.getElementById("overTimeRate");
  var taxRate = document.getElementById("taxRate");


	if(isEmpty(salaryRate, "Salary Rate")) {
		if(isNum(salaryRate, "Salary Rate")) {

			if(isEmpty(overTimeRate, "Overtime Rate")) {
				if(isNum(overTimeRate, "Overtime Rate")) {

					if(isEmpty(taxRate, "Tax Rate")) {
						if(isNum(taxRate, "Tax Rate")) {
							return true;

						}
					}

				}
			}

		}
	}

	return false;
	
}



function isNum(item,itemName)
{
  var pattern=/[0-9]/;
  if(pattern.test(item.value))
  return true;
  else
  	{
  		alert("Please enter a numeric value for "+itemName);
  		item.focus();
  	}
}

function isEmpty(item,itemName)
{
 
  if(item.value.length!=0)
  return true;
  else
  	{
  		alert(itemName+" cannot be empty");
  		item.focus();
  	}
}

function isValidDate(item,itemName) 
{
	var pattern = /^\d{2}-\d{2}-\d{4}$/;
	var date="";
	if(pattern.test(item.value))
	{
	    var date=item.value.substring(0,2);
	    var  month=parseInt(item.value.substring(3,5),10);
	    var year = item.value.substring(6,10);
		
	 var months=[0,31,28,31,30,31,30,31,31,30,31,30,31];

	 if(year%4==0)
		 months[2]=29;

	  if(date<=months[month]&&date>0&&month<=12&&month>0)
		  return true;
	  else
	  {
		 alert(itemName+" is not a valid date");
		 item.focus();
	  }
	}
	else
	{
	 alert("Please enter "+itemName+" in the correct format DD-MM-YYYY");
	 item.focus();
	 return false;
	}
	
}


function compareDates(d1, d2) //returns true if d2>d1
 {
 	
	var date1 = d1.value.substring(0, 2);
	var month1 = parseInt(d1.value.substring(3, 5), 10);
	var year1 = d1.value.substring(6, 10);
	
	var date2 = d2.value.substring(0, 2);
	var month2 = parseInt(d2.value.substring(3, 5), 10);
	var year2 = d2.value.substring(6, 10);
	
	var dt1 = new Date(year1,month1,date1);
	var dt2 = new Date(year2,month2,date2);
	
	if(dt1>dt2)
	{
		alert("End date cannot be less than start date");
		
		
		return false;
		
	}
	
	else
	return true;
	
	

}

function updateHours(element)
{
	//check if all fields are entered correctly and update accordingly
	//also call function to update total wage
	//var hours= getTotalHours()
var id=element.id;
var otPrefix="";

var idNum=getIdNum(id);
var idCode=getIdCode(id)



var startTime = new Date();
var endTime = new Date();

if(idCode=='ot')
{
	otPrefix="ot";

}

var hoursStart = document.getElementById(otPrefix+"HoursStart"+idNum);
var minutesStart = document.getElementById(otPrefix+"MinutesStart"+idNum);
var secondsStart = document.getElementById(otPrefix+"SecondsStart"+idNum);

var hoursEnd = document.getElementById(otPrefix+"HoursEnd"+idNum);
var minutesEnd = document.getElementById(otPrefix+"MinutesEnd"+idNum);
var secondsEnd = document.getElementById(otPrefix+"SecondsEnd"+idNum);




disableElems(element);
	
	




startTime.setHours(hoursStart.value,minutesStart.value,secondsStart.value);
endTime.setHours(hoursEnd.value,minutesEnd.value,secondsEnd.value);

if(endTime<startTime)
{
	alert("Starting time cannot be greater than ending time");
	hoursEnd.value=hoursStart.value;
	minutesEnd.value=minutesStart.value;
	secondsEnd.value=secondsStart.value;
	return;
}

var totalHours = getTotalHours(startTime,endTime);
if(document.getElementById(otPrefix+"Hours"+idNum).disabled=="disabled")
document.getElementById(otPrefix+"Hours"+idNum).value=0;
else
document.getElementById(otPrefix+"Hours"+idNum).value=totalHours.toFixed(2);

updateDisplays();
}

function getTotalHours(first,second)
{
	var MS = Math.abs(second.getTime()-first.getTime());
	return MS/(60*60*1000);
	
}

function enableOverTime(element)
{
	
	var disabled="";
	var idNum= getIdNum(element.id);
	overTime = document.getElementById("otOverTime"+idNum);
	overTimeEnabled = document.getElementById("otOverTimeEnabled"+idNum);
	var checkbox = document.getElementById("otOverTime"+idNum);
	updateHours(element);
	
	if(checkbox.checked==true)
	{
		disabled="";
		overTimeEnabled.value="true";
		
		
	}
	
	else
	{
		disabled="disabled";
		document.getElementById("otHours"+idNum).value="0.0";
		updateDisplays();
		overTimeEnabled.value="false";
		
	}
	
	/*if(overTimeEnabled.value=="false")
	{
		overTimeEnabled.value="true";
		disabled = "";
		
		
	}
	else
	{
	overTimeEnabled.value="false";
	disabled="disabled";
	document.getElementById("otHours"+idNum).value="0";
	updateDisplays();
	
	}*/
	
			
document.getElementById("otHoursStart"+idNum).disabled=disabled;
document.getElementById("otMinutesStart"+idNum).disabled=disabled;
document.getElementById("otSecondsStart"+idNum).disabled=disabled;
document.getElementById("otHoursEnd"+idNum).disabled=disabled;
document.getElementById("otMinutesEnd"+idNum).disabled=disabled;
document.getElementById("otSecondsEnd"+idNum).disabled=disabled;
document.getElementById("otHours"+idNum).disabled=disabled;
			
		
disableElems(element);
		
}

function disableElems(element)//to disalbe minute and seconds element 
{
var id=element.id;
var otPrefix="";

var idNum=getIdNum(id);
var idCode=getIdCode(id)


if(idCode=='ot')
{
	otPrefix="ot";

}


	
var hoursStart = document.getElementById(otPrefix+"HoursStart"+idNum);
var minutesStart = document.getElementById(otPrefix+"MinutesStart"+idNum);
var secondsStart = document.getElementById(otPrefix+"SecondsStart"+idNum);

var hoursEnd = document.getElementById(otPrefix+"HoursEnd"+idNum);
var minutesEnd = document.getElementById(otPrefix+"MinutesEnd"+idNum);
var secondsEnd = document.getElementById(otPrefix+"SecondsEnd"+idNum);
	
	
	var action="";
	var control;
	
	if(otPrefix=="ot")
	control=19;
	else
	control=17;
	
	
	if(hoursStart.value==control)
	{
		minutesStart.selectedIndex=0;
		secondsStart.selectedIndex=0;
		action="disabled";
	}
	
	
	minutesStart.disabled=action;
	secondsStart.disabled=action;
    action="";
   
     if(hoursEnd.value==control)
   {
   		minutesEnd.selectedIndex=0;
		secondsEnd.selectedIndex=0;
    	action="disabled";	
    }
    
    
    minutesEnd.disabled=action;
	secondsEnd.disabled=action;
	
	
	if(minutesStart.disabled=="disabled")
	{
		
		minutesStart.disabled="00";
		secondsStart.disabled="00";
		
	}
	
	
}

function enableElems()
{
	

var x=0;
otPrefix="";

var days = document.getElementById("days").value;

while(x<2)
{
for(idNum=0;idNum<=days;idNum++)
{
	
var hoursStart = document.getElementById(otPrefix+"HoursStart"+idNum).disabled="";
var minutesStart = document.getElementById(otPrefix+"MinutesStart"+idNum).disabled="";
var secondsStart = document.getElementById(otPrefix+"SecondsStart"+idNum).disabled="";

var hoursEnd = document.getElementById(otPrefix+"HoursEnd"+idNum).disabled="";
var minutesEnd = document.getElementById(otPrefix+"MinutesEnd"+idNum).disabled="";
var secondsEnd = document.getElementById(otPrefix+"SecondsEnd"+idNum).disabled="";
var secondsEnd = document.getElementById(otPrefix+"Hours"+idNum).disabled="";


}
otPrefix="ot";
x++;
}

return true;
	
	
}

function getIdNum(id)
{
	return id.match(/\d+/);
}

function getIdCode(id)
{
	var idCode= id+"";
	return idCode.substring(0,2);
}

function expand(element)
{
	var idNum = getIdNum(element.id)
	var button = document.getElementById("editButton"+idNum);
	 
	if(button.value=="View")
	{
	document.getElementById("rowb"+idNum).className=null;
	document.getElementById("rowc"+idNum).className=null;
	document.getElementById("rowd"+idNum).className=null;
	button.value="Close";
	}
	
	else if(button.value=="Close")
	{	
				
		document.getElementById("rowb"+idNum).className="collapsed";
		document.getElementById("rowc"+idNum).className="collapsed";
		document.getElementById("rowd"+idNum).className="collapsed";
		button.value="View";
	}
	
	
	
	
	
   
    
	
	
	
	
	
}


function markLeave(element)
{
	var idNum = getIdNum(element.id);
	var button = document.getElementById("editButton"+idNum);
	
	if(button.disabled=="")
	{
	button.disabled="disabled";
	document.getElementById("Hours"+idNum).value="0";
	}
	else
	{
	button.disabled="";
	//document.getElementById("Hours"+idNum).value="8";
	updateHours(element);
	}
	
	updateDisplays();
	
	if(button.value=="Close")
	{	
				
		document.getElementById("rowb"+idNum).className="collapsed";
		document.getElementById("rowc"+idNum).className="collapsed";
		document.getElementById("rowd"+idNum).className="collapsed";
		button.value="View";
	}
	
	
	
	
	
	
}

function updateDisplays()
{
	if(validate_f2())
	{
	
	var grossIncome = getGrossIncome();
	var taxDeduction = getTaxDeduction();
	var netIncome =grossIncome-taxDeduction;
	
	document.getElementById("grossIncome").value=grossIncome;
	document.getElementById("taxDeduction").value=taxDeduction;
	document.getElementById("netIncome").value=netIncome.toFixed(2);
	
	}
	 
}

function getWorkingHours(type) //argument specifies whether to calculate overtime for normal hours or overtime
{
	var prefix="";
	var days = document.getElementById("days").value;
	var workingHours=0;
	
	if(type=="ot")
	prefix="ot";
	
	for(var x=0;x<=days;x++)
	{
		
		workingHours=workingHours-(-document.getElementById(prefix+"Hours"+x).value);
		
	}

return workingHours;
}

function getGrossIncome()
{
	
	var salaryRate = document.getElementById("salaryRate").value;
	var overTimeRate = document.getElementById("overTimeRate").value;
	
	
	
	var grossIncome = getWorkingHours("normal")*salaryRate+getWorkingHours("ot")*overTimeRate;
	return grossIncome.toFixed(2);
	
}

function getTaxDeduction()
{
    var taxRate = document.getElementById("taxRate").value;
    var deduction= (taxRate/100)*getGrossIncome();
    return deduction.toFixed(2);
	
}

function reset()
{	
	var days = document.getElementById("days").value;
	
	for(var i=0;i<=days;i++)
	{
		var overTimeEnabled = document.getElementById("otOverTimeEnabled"+i);
		overTimeEnabled.value="false";
		
	}
	
}


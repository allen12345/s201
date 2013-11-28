<script src="http://code.jquery.com/jquery-1.9.1.js"></script>

<script src="http://code.highcharts.com/highcharts.js"></script>

<script src="http://code.highcharts.com/modules/exporting.js"></script>  

<script type="text/javascript">
       $(document).ready(function () {
    $('.group').hide();
    $('#month').show();
    $('#selectMe').change(function () {
        $('.group').hide();
        $('#'+$(this).val()).show();
    })
});


</script>
<?php
if(isset($_POST['mode']))
{
?>
<script type="text/javascript">
$(window).load(function() {
       $('.group').hide();
        $('#'+'<?php echo $_POST['mode'] ?>').show();
        $("#selectMe option[value='<?php echo $_POST['mode'] ?>']").attr("selected", "selected");
});
</script>
<?php
}
?>
<div style="float:left;margin-left: 167px; margin-top: -45px;">
<select id="selectMe" name="selectMe">
<option value="month">Month</option>
<option value="day">Day</option>
<option value="quarter">quarter</option>
<option value="year">year</option>
</select>
</div>
<!--******************************************************************CHART OF Month*********************************************-->
<?php
/*$favcolor="red";
switch ($favcolor)
{
case "red":
   echo "Your favorite color is red!";
   break;
case "blue":
   echo "Your favorite color is blue!";
   break;
case "green":
   echo "Your favorite color is green!";
   break;
default:
   echo "Your favorite color is neither red, blue, or green!";
}*/
?>
<!--START MONTH DIV HERE-->
<div id="month" class="group" >
<form method=post name=f1 action=''>
<table border="0" cellspacing="0" >
<tr><td> Start Date:  
<select name=startmonth value=''>Select Month</option>
<option value='1'>Jan</option>
<option value='2'>Feb</option>
<option value='3'>Mar</option>
<option value='4'>Apr</option>
<option value='5'>May</option>
<option value='6'>Jun</option>
<option value='7'>Jul</option>
<option value='8'>Aug</option>
<option value='9'>Sep</option>
<option value='10'>Oct</option>
<option value='11'>Nov</option>
<option value='12'>Dec</option>
</select><select name=startyear >
<option value='2011'selected="selected">2011</option>
<option value='2012'>2012</option>
<option value='2013'>2013</option>  
</select></td><td> End Date:  
<select name=endmonth value=''>Select Month</option>
<option value='1'>Jan</option>
<option value='2'>Feb</option>
<option value='3'>Mar</option>
<option value='4'>Apr</option>
<option value='5'>May</option>
<option value='6'>Jun</option>
<option value='7'>Jul</option>
<option value='8'>Aug</option>
<option value='9'>Sep</option>
<option value='10'>Oct</option>
<option value='11'>Nov</option>
<option value='12'selected="selected">Dec</option>
</select><select name=endyear >
<option value='2011'selected="selected">2011</option>
<option value='2012'>2012</option>
<option value='2013'>2013</option>  
</select><input type="hidden" name="mode" value="month"></td><td><input type=submit name="month" value=Submit></td></tr>
</table>
</form>
</div>
<!--MONTH DIV END HERE-->

<!--START DAYS DIV HERE-->
<div id="day" class="group" >
<form method=post name=f2 action=''>
<table border="0" cellspacing="0" >
<tr><td> Start Date:  
<select name=startdaymonth value=''>Select Month</option>
<option value='1'>Jan</option>
<option value='2'>Feb</option>
<option value='3'>Mar</option>
<option value='4'>Apr</option>
<option value='5'>May</option>
<option value='6'>Jun</option>
<option value='7'>Jul</option>
<option value='8'>Aug</option>
<option value='9'>Sep</option>
<option value='10'>Oct</option>
<option value='11'>Nov</option>
<option value='12'>Dec</option>
</select><select name=startdaydt >
<option value='01'>01</option>
<option value='02'>02</option>
<option value='03'>03</option>
<option value='04'>04</option>
<option value='05'>05</option>
<option value='06'>06</option>
<option value='07'>07</option>
<option value='08'>08</option>
<option value='09'>09</option>
<option value='10'>10</option>
<option value='11'>11</option>
<option value='12'>12</option>
<option value='13'>13</option>
<option value='14'>14</option>
<option value='15'>15</option>
<option value='16'>16</option>
<option value='17'>17</option>
<option value='18'>18</option>
<option value='19'>19</option>
<option value='20'>20</option>
<option value='21'>21</option>
<option value='22'>22</option>
<option value='23'>23</option>
<option value='24'>24</option>
<option value='25'>25</option>
<option value='26'>26</option>
<option value='27'>27</option>
<option value='28'>28</option>
<option value='29'>29</option>
<option value='30'>30</option>
<option value='31'>31</option>
</select><select name=startdayyear >
<option value='2011'selected="selected">2011</option>
<option value='2012'>2012</option>
<option value='2013'>2013</option>  
</select></td><td>End Date:  
<select name=enddaymonth value=''>Select Month</option>
<option value='1'>Jan</option>
<option value='2'>Feb</option>
<option value='3'>Mar</option>
<option value='4'>Apr</option>
<option value='5'>May</option>
<option value='6'>Jun</option>
<option value='7'>Jul</option>
<option value='8'>Aug</option>
<option value='9'>Sep</option>
<option value='10'>Oct</option>
<option value='11'>Nov</option>
<option value='12'selected="selected">Dec</option>
</select><select name=enddaydt >
<option value='01'>01</option>
<option value='02'>02</option>
<option value='03'>03</option>
<option value='04'>04</option>
<option value='05'>05</option>
<option value='06'>06</option>
<option value='07'>07</option>
<option value='08'>08</option>
<option value='09'>09</option>
<option value='10'>10</option>
<option value='11'>11</option>
<option value='12'>12</option>
<option value='13'>13</option>
<option value='14'>14</option>
<option value='15'>15</option>
<option value='16'>16</option>
<option value='17'>17</option>
<option value='18'>18</option>
<option value='19'>19</option>
<option value='20'>20</option>
<option value='21'>21</option>
<option value='22'>22</option>
<option value='23'>23</option>
<option value='24'>24</option>
<option value='25'>25</option>
<option value='26'>26</option>
<option value='27'>27</option>
<option value='28'>28</option>
<option value='29'>29</option>
<option value='30'>30</option>
<option value='31' selected="selected">31</option>
</select><select name=enddayyear >
<option value='2011'selected="selected">2011</option>
<option value='2012'>2012</option>
<option value='2013'>2013</option>  
</select><input type="hidden" name="mode" value="day"></td><td><input type=submit name="day" value=Submit></td></tr>
</table>
</form>
</div>
<!--DAYS DIV END HERE-->

<!--START Quarter DIV HERE-->
<div id="quarter" class="group" >
<form method=post name=f3 action=''>
<table border="0" cellspacing="0" >
<tr><td> Start Date:  
<select name=startmonth value=''>Select Month</option>
<option value='1'>Jan</option>
<option value='2'>Feb</option>
<option value='3'>Mar</option>
<option value='4'>Apr</option>
<option value='5'>May</option>
<option value='6'>Jun</option>
<option value='7'>Jul</option>
<option value='8'>Aug</option>
<option value='9'>Sep</option>
<option value='10'>Oct</option>
<option value='11'>Nov</option>
<option value='12'>Dec</option>
</select><select name=startyear >
<option value='2011'selected="selected">2011</option>
<option value='2012'>2012</option>
<option value='2013'>2013</option>  
</select></td><td> End Date:  
<select name=endmonth value=''>Select Month</option>
<option value='1'>Jan</option>
<option value='2'>Feb</option>
<option value='3'>Mar</option>
<option value='4'>Apr</option>
<option value='5'>May</option>
<option value='6'>Jun</option>
<option value='7'>Jul</option>
<option value='8'>Aug</option>
<option value='9'>Sep</option>
<option value='10'>Oct</option>
<option value='11'>Nov</option>
<option value='12'selected="selected">Dec</option>
</select><select name=endyear >
<option value='2011'selected="selected">2011</option>
<option value='2012'>2012</option>
<option value='2013'>2013</option>  
</select><input type="hidden" name="mode" value="quarter"></td><td><input type=submit name="quarter" value=Submit></td></tr>
</table>
</form>
</div>
<!--Quarter DIV END HERE-->

<!--START YEAR DIV HERE-->
<div id="year" class="group" >
<form method=post name=f4 action=''>
<table border="0" cellspacing="0" >
<tr><td> Start Date:  
<select name=startyear >
<option value='2011'selected="selected">2011</option>
<option value='2012'>2012</option>
<option value='2013'>2013</option>  
</select></td><td> End Date:  
<select name=endyear >
<option value='2011'selected="selected">2011</option>
<option value='2012'>2012</option>
<option value='2013'>2013</option>  
</select><input type="hidden" name="mode" value="year"></td><td><input type=submit name="year" value=Submit></td></tr>
</table>
</form>
</div>
<!--YEAR DIV END HERE-->


<?Php
$facilitycode = "TEST000001";
if(isset($_POST['month'])=="Submit"){
$startmonth=$_POST['startmonth'];
$startdt=$_POST['startdt'];
$startyear=$_POST['startyear'];
//echo "Start date: $startyear-$startmonth-$startdt<br>";
 $startdate_value="$startyear-$startmonth-$startdt";
 
$endmonth=$_POST['endmonth'];
$enddt=$_POST['enddt'];
$endyear=$_POST['endyear'];
//echo "End date: $endyear-$endmonth-$enddt";
$enddate_value="$endyear-$endmonth-$enddt";

$Month=array('','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');

for($m=$startmonth;$m<=$endmonth;$m++)
{
    $NumericMonth .= $m.",";
    $MyMonth.="'".$Month[$m]."',";
}
$SelMonth=  substr($MyMonth,0,-1);
$NumMonth=  substr($NumericMonth,0,-1);

for($n=$startyear;$n<=$endyear;$n++)
{
    $NumericYear .= $n.",";
    $MyYear.="'".$n."',";
}
$SelYear=  substr($MyYear,0,-1);
$NumYear=  substr($NumericYear,0,-1);
    
$sql = "SELECT count(distinct patientcode) as patienttotal,count(distinct woundnumber) as woundtotal FROM {med_data} WHERE facilitycode = '$facilitycode' AND  DATE_FORMAT( servicedate, '%m' ) IN ( $NumMonth ) AND  DATE_FORMAT( servicedate, '%Y' ) IN ($NumYear) GROUP BY DATE_FORMAT( servicedate, '%m' ) ";
$result = db_query($sql);
$Data=$result->fetchAll();
foreach($Data as $s)
{
    $patient = $s->patienttotal;
    $wound   = $s->woundtotal;
    $patient2 .= $patient.",";
    $wound2   .= $wound.",";
}
 $patient3 =  substr($patient2,0,-1);
 $wound3 =  substr($wound2,0,-1);

?>
<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<script type="text/javascript">
    
$(function () {
        $('#container').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Facility TEST000001 Patients Statistics'
            },
            xAxis: {
                categories: [<?php echo $SelMonth; ?>]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Facility TEST000001 Patients Statistics'
                }
            },
            tooltip: {
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Patients',
                data: [<?php echo $patient3; ?>]
    
            }, {
                name: 'Wound_Number',
                data: [<?php echo $wound3; ?>]
    
            }]
        });
    });
    
    
</script>
<?php
}elseif(isset($_POST['day'])=="Submit" and $_POST['mode']=='day')
{
$startdaymonth=$_POST['startdaymonth'];
$startdaydt=$_POST['startdaydt'];
$startdayyear=$_POST['startdayyear'];
//echo "Start date: $startyear-$startmonth-$startdt<br>";
//$startdate_value="$startyear-$startmonth-$startdt";

$enddaymonth=$_POST['enddaymonth'];
$enddaydt=$_POST['enddaydt'];
$enddayyear=$_POST['enddayyear'];
//echo "End date: $endyear-$endmonth-$enddt";
//$enddate_value="$endyear-$endmonth-$enddt";

//$day=array('','Sun','Mon','Tue','Wed','Thu','Fri','Sat');
//$dayMonth=array('','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');

for($k=$startdaydt;$k<=$enddaydt;$k++)
{
    $NumericDay .= $k.",";
    $MyDay.="'".$day[$k]."',";
}
$Selday=  substr($MyDay,0,-1);
$Numday=  substr($NumericDay,0,-1);
//echo "<P>DATA<PRE>";print_r($Numday);echo "</PRE>";
//exit();

for($k1=$startdaymonth;$k1<=$enddaymonth;$k1++)
{
    $NumericdayMonth .= $k1.",";
    $MydayMonth .= $dayMonth[$k1];
}
$SeldayMonth=  substr($MydayMonth,0,-1);
$NumDayMonth=  substr($NumericdayMonth,0,-1);
//echo "<P>DATA<PRE>";print_r($SeldayMonth);echo "</PRE>";
//exit();
for($k2=$startdayyear;$k2<=$enddayyear;$k2++)
{
    $NumericDayYear .= $k2.",";
    $MydayYear.="'".$k2."',";
}
$SelDayYear=  substr($MydayYear,0,-1);
$NumDayYear=  substr($NumericDayYear,0,-1);
 
echo $sqlday = "SELECT count(distinct patientcode) as patientdaytotal,count(distinct woundnumber) as wounddaytotal FROM {med_data} WHERE facilitycode = '$facilitycode' AND  DATE_FORMAT( servicedate, '%d' ) IN ( 11,12,13,14,15,16,17,18,19 ) AND  DATE_FORMAT( servicedate, '%m' ) IN ( $NumDayMonth ) AND  DATE_FORMAT( servicedate, '%Y' ) IN ($NumDayYear)";
$resultday = db_query($sqlday);
$Dataday=$resultday->fetchAll();

foreach($Dataday as $dayvalue)
{
     $patientday = $dayvalue->patientdaytotal;
     //echo "<P>DATA<PRE>";print_r($patientday);echo "</PRE>";
    //$woundday   = $dayvalue->wounddaytotal;
     $patientday2 .= $patientday.",";
    //$woundday2   .= $woundday.",";
}
 $patientday3 =  substr($patientday2,0,-1);
 //$woundday3 =  substr($woundday2,0,-1);


//echo "<P>DATA<PRE>";print_r($patientday3);echo "</PRE>";


?>
<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<script type="text/javascript">
    
$(function () {
        $('#container').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Facility TEST000001 Patients Statistics'
            },
            xAxis: {
                categories: [<?php echo $Numday; ?>]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Facility TEST000001 Patients Statistics'
                }
            },
            tooltip: {
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Patients',
                data: [<?php echo $patientday3; ?>]
    
            }, {
                name: 'Wound_Number',
                data: [<?php echo $woundday3; ?>]
    
            }]
        });
    });
    
    
</script>
<?php
    }
    elseif(isset($_POST['quarter'])=="Submit" and $_POST['mode']=='quarter')
    {
    echo "hi world";
    }elseif(isset($_POST['year'])=="Submit" and $_POST['mode']=='year')
    {
    echo "hi friends";
    }else{
    
$facilitycode = "TEST000001";
$startmonth=1;
$startdt=01;
$startyear=2011;
//echo $startdate_value="$startyear-$startmonth-$startdt<br>";
 $startdate_value="$startyear-$startmonth-$startdt";
 
$endmonth=12;
$enddt=31;
$endyear=2011;
//echo $enddate_value="$endyear-$endmonth-$enddt";
$enddate_value="$endyear-$endmonth-$enddt";

    $Month=array('','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');

    for($m=$startmonth;$m<=$endmonth;$m++)
    {
        $NumericMonth .= $m.",";
        $MyMonth.="'".$Month[$m]."',";
    }
    $SelMonth=  substr($MyMonth,0,-1);
    $NumMonth=  substr($NumericMonth,0,-1);

$sql = "SELECT count(distinct patientcode) as patienttotal,count(distinct woundnumber) as woundtotal FROM {med_data} WHERE facilitycode = '$facilitycode' AND  DATE_FORMAT( servicedate, '%m' ) IN ( $NumMonth ) AND  DATE_FORMAT( servicedate, '%Y' ) IN (2011) GROUP BY DATE_FORMAT( servicedate, '%m' ) ";
$result = db_query($sql);
$Data=$result->fetchAll();
foreach($Data as $s)
{
    $patient = $s->patienttotal;
    $wound   = $s->woundtotal;
    $patient2 .= $patient.",";
    $wound2   .= $wound.",";
}
 $patient3 =  substr($patient2,0,-1);
 $wound3 =  substr($wound2,0,-1);
    
    ?>
        <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<script type="text/javascript">
    
$(function () {
        $('#container').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Facility TEST000001 Patients Statistics'
            },
            xAxis: {
                categories: [<?php echo $SelMonth; ?>]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Facility TEST000001 Patients Statistics'
                }
            },
            tooltip: {
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Patients',
                data: [<?php echo $patient3; ?>]
    
            }, {
                name: 'Wound_Number',
                data: [<?php echo $wound3; ?>]
    
            }]
        });
    });
    
    
</script>
        
        <?php
    
}
?>


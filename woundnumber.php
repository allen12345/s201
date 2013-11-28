<?php
$d = array();
$data = array();

$facilitycode = "TEST000001";

$d1 = array();
$d1['start'] = "2011-01-01";
$d1['end'] = "2011-01-02";
$d1['x'] = "Jan 2011";
$d[] = $d1;

$d1 = array();
$d1['start'] = "2011-01-01";
$d1['end'] = "2011-01-03";
$d1['x'] = "2011-01-03";
$d[] = $d1;

$d1 = array();
$d1['start'] = "2011-01-01";
$d1['end'] = "2011-01-04";
$d1['x'] = "2011-01-04";
$d[] = $d1;

$d1 = array();
$d1['start'] = "2011-01-01";
$d1['end'] = "2011-01-05";
$d1['x'] = "2011-01-05";
$d[] = $d1;

$d1 = array();
$d1['start'] = "2011-01-01";
$d1['end'] = "2011-01-06";
$d1['x'] = "2011-01-06";
$d[] = $d1;

$d1 = array();
$d1['start'] = "2011-01-01";
$d1['end'] = "2011-01-07";
$d1['x'] = "2011-01-07";
$d[] = $d1;

$d1 = array();
$d1['start'] = "2011-01-01";
$d1['end'] = "2011-01-08";
$d1['x'] = "2011-01-08";
$d[] = $d1;

$d1 = array();
$d1['start'] = "2011-01-01";
$d1['end'] = "2011-01-09";
$d1['x'] = "2011-01-09";
$d[] = $d1;

$d1 = array();
$d1['start'] = "2011-01-01";
$d1['end'] = "2011-01-10";
$d1['x'] = "2011-01-10";
$d[] = $d1;

$d1 = array();
$d1['start'] = "2011-01-01";
$d1['end'] = "2011-01-11";
$d1['x'] = "2011-01-11";
$d[] = $d1;

$d1 = array();
$d1['start'] = "2011-01-01";
$d1['end'] = "2011-01-12";
$d1['x'] = "2011-01-12";
$d[] = $d1;

$d1 = array();
$d1['start'] = "2011-01-01";
$d1['end'] = "2011-01-13";
$d1['x'] = "2011-01-13";
$d[] = $d1;

$x=array();
$data=array();
foreach ($d as $d1) {
$start = $d1['start'];
$end = $d1['end'];
$xa = $d1['x'];
$x[] .= strip_tags($xa);


/*$sql = "SELECT count(distinct patientcode) FROM {med_data} 
         WHERE facilitycode = '$facilitycode' 
           AND servicedate >= '$start'
           AND servicedate <= '$end'
       ";*/
/*$sql = "SELECT count(distinct woundnumber) FROM {med_data} 
         WHERE facilitycode = '$facilitycode' 
           AND servicedate >= '$start'
           AND servicedate <= '$end'
       ";
$result = db_query($sql);
$data[] = $result->fetchField();
$data[] .= strip_tags($data);*/


$sql = "SELECT count(distinct woundnumber) FROM {med_data} 
         WHERE facilitycode = '$facilitycode' 
           AND servicedate >= '$start'
           AND servicedate <= '$end'
       ";
$result = db_query($sql);
$data12 = $result->fetchField();
$data[]=strip_tags($data12);
/*$ab=$data[];
$data[] .= strip_tags($data);*/


//echo "<P>X<PRE>";print_r($x);echo "</pre>";
//echo "<P>DATA<PRE>";print_r($data);echo "</PRE>";
//exit();


}


  
  $pie['chart']['chartOne'] = array(
'header' => $x,
'rows' => array($data),
'columns' => array('Wound_Number'),
'chartType' => 'PieChart',    
'containerId' =>  'content',
'options' => array(
'forceIFrame' => FALSE,
'title' => 'Facility TEST000001 woundnumber Statistics',
'width' => 800,
'height' => 400
  )
  );
  $ret = draw_chart($pie); 

?>

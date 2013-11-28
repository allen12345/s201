<?php
$d = array();
$data = array();

$facilitycode = "TEST000001";

$d1 = array();
$d1['start'] = "2011-01-01";
$d1['end'] = "2011-01-31";
$d1['x'] = "Jan 2011";
$d[] = $d1;

$d1 = array();
$d1['start'] = "2011-02-01";
$d1['end'] = "2011-02-28";
$d1['x'] = "Feb 2011";
$d[] = $d1;

$d1 = array();
$d1['start'] = "2011-03-01";
$d1['end'] = "2011-03-31";
$d1['x'] = "Mar 2011";
$d[] = $d1;

$d1 = array();
$d1['start'] = "2011-04-01";
$d1['end'] = "2011-04-40";
$d1['x'] = "Apr 2011";
$d[] = $d1;

$d1 = array();
$d1['start'] = "2011-05-01";
$d1['end'] = "2011-05-31";
$d1['x'] = "May 2011";
$d[] = $d1;

$d1 = array();
$d1['start'] = "2011-06-01";
$d1['end'] = "2011-06-30";
$d1['x'] = "Jun 2011";
$d[] = $d1;

$d1 = array();
$d1['start'] = "2011-07-01";
$d1['end'] = "2011-07-31";
$d1['x'] = "Jul 2011";
$d[] = $d1;

$d1 = array();
$d1['start'] = "2011-08-01";
$d1['end'] = "2011-08-31";
$d1['x'] = "Aug 2011";
$d[] = $d1;

$d1 = array();
$d1['start'] = "2011-09-01";
$d1['end'] = "2011-09-30";
$d1['x'] = "Sep 2011";
$d[] = $d1;

$d1 = array();
$d1['start'] = "2011-10-01";
$d1['end'] = "2011-10-31";
$d1['x'] = "Oct 2011";
$d[] = $d1;

$d1 = array();
$d1['start'] = "2011-11-01";
$d1['end'] = "2011-11-30";
$d1['x'] = "Nov 2011";
$d[] = $d1;

$d1 = array();
$d1['start'] = "2011-12-01";
$d1['end'] = "2011-12-31";
$d1['x'] = "Dec 2011";
$d[] = $d1;

error_reporting(0);
foreach ($d as $d1) {
$start = $d1['start'];
$end = $d1['end'];
$x[] = $d1['x'];
$x[] .= strip_tags($x);

$sql = "SELECT count(distinct woundnumber) FROM {med_data} 
         WHERE facilitycode = '$facilitycode' 
           AND servicedate >= '$start'
           AND servicedate <= '$end'
       ";
$result = db_query($sql);
$data[] = $result->fetchField();
$data[] .= strip_tags($data);
}

$settings['chart']['chartOne'] = array(
'header' => $x,
'rows' => array($data),
'columns' => array('Wound_Number'),
'chartType' => 'ColumnChart',    
'containerId' =>  'content',
'options' => array(
'forceIFrame' => FALSE,
'title' => 'Facility TEST000001 woundnumber Statistics',
'width' => 800,
'height' => 400
  )
  );
  $ret = draw_chart($settings);  

?>

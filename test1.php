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


foreach ($d as $d1) {
$start = $d1['start'];
$end = $d1['end'];
$x[] = $d1['x'];
$sql = "SELECT count(distinct patientcode) FROM {med_data} 
         WHERE facilitycode = '$facilitycode' 
           AND servicedate >= '$start'
           AND servicedate <= '$end'
       ";
$result = db_query($sql);
$data[] = $result->fetchField();
}

//echo "<P>X<PRE>";print_r($x);echo "</pre>";
//echo "<P>DATA<PRE>";print_r($data);echo "</PRE>";
//exit();

$settings['chart']['chartOne'] = array(
    'header' => $x,
    'rows' => array($data),
    'columns' => array('Patients'),
    'chartType' => 'ColumnChart',    
    'containerId' =>  'content',
    'options' => array(
      'forceIFrame' => FALSE,
      'title' => 'Facility TEST000001 Patients Statistics',
      'width' => 800,
      'height' => 400
    )
  );
/*
$settings['chart']['chartOne'] = array(
    'header' => array('Apple', 'Banana', 'Mango'),
    'rows' => array(array(12, 6, 8)),
    'columns' => array('Fruit count'),
    'chartType' => 'ColumnChart',    
    'containerId' =>  'content',
    'options' => array(
      'forceIFrame' => FALSE,
      'title' => 'Fruit count',
      'width' => 800,
      'height' => 400
    )
  );

$settings['chart']['chartTwo'] = array(
    'header' => array('Apple', 'Banana', 'Mango'),
    'rows' => array(array(12, 6, 8)),
    'columns' => array('Fruit count'),
    'chartType' => 'PieChart',
    'containerId' =>  'content2',
    'options' => array(
      'forceIFrame' => FALSE,
      'title' => 'Fruit count',
      'width' => 800,
      'height' => 400
    )
  );
*/
  //Draw it.
  $ret = draw_chart($settings);  
//echo "<P>RET<XMP>"; print_r($ret); echo "</XMP>";
?>

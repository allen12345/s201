<?php
/**
 * month.php
 */

/**
 * configuration
 */
global $wounds_table;
$wounds_table = "wounds";
//$wounds_table = "med_data";

// chart width
//$chart_width = 983;

$chart_width = 984;

define('DRUPAL_ROOT', getcwd());
require_once './includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

$getvalue = htmlspecialchars(strip_tags($_REQUEST["nameofmonth"]));
$facility = $_REQUEST["facilitycode"];
$selmode = $_REQUEST["mode"];

if($selmode =="day"){
$strtovalue =  strtotime($getvalue);
$startdate_array = explode("-", $strtovalue);
$startyear = $startdate_array[0];
$startmonth = $startdate_array[1];
$startdt = $startdate_array[2];
$startdate = "$startyear-$startmonth-$startdt";

$date=date("Y-m-d",$startdate);
$date_new = strtotime("+1 WEEK", $startdate);  
$end_date=date("Y-m-d",$date_new);

$d1 = strtotime($date);
$d2 = strtotime($end_date);
$min_date = min($d1, $d2);
$max_date = max($d1, $d2);

$data_start = date("Y-m-d", $min_date);
$data_end = date("Y-m-d", $max_date);


$sql = "SELECT distinct unit FROM {$wounds_table} WHERE facilitycode = '$facility'";
$result = db_query($sql);
foreach ($result as $row) {
$units[] = "'$row->unit'";
}
foreach ($units as $unit) {  
$sql = "SELECT count(distinct patientcode) as patienttotal
        FROM {$wounds_table} 
       WHERE facilitycode = '$facility'
         AND servicedate >= '$data_start' AND servicedate <= '$data_end'               
         AND unit = $unit 
     ";

$result = db_query($sql);
$patientsunit[] = $result->fetchField();

$sqlw = "SELECT count(distinct woundnumber) as woundtotal 
        FROM {$wounds_table} 
       WHERE facilitycode = '$facility'
         AND servicedate >= '$data_start' AND servicedate <= '$data_end'                
         AND unit = $unit 
     ";

$resultw = db_query($sqlw);
$woundunit[] = $resultw->fetchField();
}

$partic_month_units = implode(",", $units);
$partic_month_patient = implode(",", $patientsunit);
$partic_month_wound = implode(",", $woundunit);

//pie chart of that day.......................................

$pieofpmonthsql = "SELECT count(type) as number, type FROM {$wounds_table} WHERE facilitycode = '$facility' 
       AND servicedate >= '$data_start' AND servicedate <= '$data_end' GROUP BY type";    
$resultofpmonth = db_query($pieofpmonthsql);
$sum = 0;
$data = array();
foreach ($resultofpmonth as $row) {
$d = array();
$d['type'] = $row->type;
$d['number'] = $row->number;
$data[] = $d;
$sum += $row->number; 
} 
$new_data = array();
foreach ($data as $d) {
$d['number'] = round(($d['number']/$sum)*100, 2);
$new_data[] = $d;
}
$pie = "";
$pieType="";
$pieNumber="";

$count = 0;
foreach ($new_data as $d) {
if ($count > 0) {
$pie .= ",";   
}  
$pie .= "['$d[type]', $d[number]]";
$count++;
}
//echo "<P>DATA<PRE>";print_r($pie);echo "</PRE>";
//exit();
?>
<script type="text/javascript">
$(function () {
  var categories = [<?php echo $partic_month_units; ?>];
      $('#monthdetail').highcharts({
          chart: {
              type: 'column',
              width: <?php echo $chart_width;?>
          },
          title: {
              text: 'Report of patients and wound number of <?php echo $getvalue; ?>  with Unit'
          },
          xAxis: {
              categories: categories
          },
          yAxis: {
              title: {
               text: 'Report of patients and wound_number of <?php echo $getvalue; ?>  with Unit'
              },
              labels: {
                  formatter: function() {
                      return this.value
                  }
              }
          },
          tooltip: {
          useHTML: true,
          shared: true 
          },
          plotOptions: {
              spline: {
                  marker: {
                      radius: 4,
                      lineColor: '#666666',
                      lineWidth: 1
                  }
              }
          },
          legend: {
          enabled: true,
          layout: 'vertical',
          align: 'right',
          verticalAlign: 'middle',
          labelFormatter: function() {
          return this.name;
          }
          },
          series: [{
              name: 'Patients of <?php echo $getvalue; ?> with Unit',
              data: [<?php echo $partic_month_patient; ?>]

          }, {
              name: 'wound of  <?php echo $getvalue; ?> with Unit',
              data: [<?php echo $partic_month_wound; ?>]
          }]
      });
  });  
</script>


<script type="text/javascript">
$(function () {
      $('#monthdetailofpie').highcharts({
          chart: {
              type: 'pie',
              width: <?php echo $chart_width;?>
          },
          title: {
              text: 'Report of wound Type of <?php echo $getvalue; ?>  with Pie Chart'
          },
          tooltip: {
          pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
          },
          plotOptions: {
          pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                  enabled: true,
                  color: '#000000',
                  connectorColor: '#000000',
                  format: '<b>{point.name}</b>: {point.y}'
              },
              showInLegend: true
          }
      },
          legend: {
              enabled: true,
              layout: 'vertical',
              align: 'right',
              width: 220,
              verticalAlign: 'middle',
                              borderWidth: 0,
              useHTML: true,
                              labelFormatter: function() {
                                      return '<div style="width:200px"><span style="float:left">' + this.name + '</span><?php echo $pie; ?><span style="float:right">' + this.y + '%</span></div>';
                              },
                              title: {
                                      text: 'Primary',
                                      style: {
                                              fontWeight: 'bold'
                                      }
                              }
          },
          series: [{
              name: 'Type of <?php echo $getvalue; ?>',
              data: [ <?php echo $pie; ?>]

          }]
      });
  });    
</script> 
<?php
}
elseif($selmode =="month"){
$strtovalue =  strtotime($getvalue);
$startdate_array = explode("-", $strtovalue);
$startyear = $startdate_array[0];
$startmonth = $startdate_array[1];
$startdt = $startdate_array[2];
$startdate = "$startyear-$startmonth-$startdt";

$date=date("Y-m-d",$startdate);
$end_date=date("Y-m-31",$startdate);

$d1 = strtotime($date);
$d2 = strtotime($end_date);
$min_date = min($d1, $d2);
$max_date = max($d1, $d2);

$data_start = date("Y-m-d", $min_date);
$data_end = date("Y-m-d", $max_date);


$sql = "SELECT distinct unit FROM {$wounds_table} WHERE facilitycode = '$facility'";
$result = db_query($sql);
foreach ($result as $row) {
 $units[] = "'$row->unit'";
}
foreach ($units as $unit) {  
$sql = "SELECT count(distinct patientcode) as patienttotal
         FROM {$wounds_table} 
        WHERE facilitycode = '$facility'
          AND servicedate >= '$data_start' AND servicedate <= '$data_end'               
          AND unit = $unit 
      ";

$result = db_query($sql);
$patientsunit[] = $result->fetchField();

$sqlw = "SELECT count(distinct woundnumber) as woundtotal 
         FROM {$wounds_table} 
        WHERE facilitycode = '$facility'
          AND servicedate >= '$data_start' AND servicedate <= '$data_end'                
          AND unit = $unit 
      ";

$resultw = db_query($sqlw);
$woundunit[] = $resultw->fetchField();
}

$partic_month_units = implode(",", $units);
$partic_month_patient = implode(",", $patientsunit);
$partic_month_wound = implode(",", $woundunit);

//pie chart of that month.......................................
$pieofpmonthsql = "SELECT count(type) as number, type FROM {$wounds_table} WHERE facilitycode = '$facility' 
        AND servicedate >= '$data_start' AND servicedate <= '$data_end' GROUP BY type";    
$resultofpmonth = db_query($pieofpmonthsql);
$sum = 0;
$data = array();
foreach ($resultofpmonth as $row) {
$d = array();
$d['type'] = $row->type;
$d['number'] = $row->number;
$data[] = $d;
$sum += $row->number; 
} 
$new_data = array();
foreach ($data as $d) {
$d['number'] = ($d['number']);
$new_data[] = $d;
}
$pie = "";
$pieType="";
$pieNumber="";

$count = 0;
foreach ($new_data as $d) {
if ($count > 0) {
 $pie .= ",";   
}  
$pie .= "['$d[type]', $d[number]]";
$count++;
}
//echo "<P>DATA<PRE>";print_r($pie);echo "</PRE>";
//exit();
?>

<script type="text/javascript">
$(function () {
   var categories = [<?php echo $partic_month_units; ?>];
       $('#monthdetail').highcharts({
           chart: {
               type: 'column',
               width: <?php echo $chart_width;?>
           },
           title: {
               text: 'Report of patients and wound number of <?php echo $getvalue; ?>  with Unit'
           },
           xAxis: {
               categories: categories
           },
           yAxis: {
               title: {
                  text: 'Report of patients and wound number of <?php echo $getvalue; ?>  with Unit'
               },
               labels: {
                   formatter: function() {
                       return this.value
                   }
               }
           },
           tooltip: {
           useHTML: true,
           shared: true 
           },
           plotOptions: {
               spline: {
                   marker: {
                       radius: 4,
                       lineColor: '#666666',
                       lineWidth: 1
                   }
               }
           },
           legend: {
           enabled: true,
           layout: 'vertical',
           align: 'right',
           verticalAlign: 'middle',
           labelFormatter: function() {
           return this.name;
           }
           },
           series: [{
               name: 'Patients of <?php echo $getvalue; ?> with Unit',
               data: [<?php echo $partic_month_patient; ?>]

           }, {
               name: 'wound of  <?php echo $getvalue; ?> with Unit',
               data: [<?php echo $partic_month_wound; ?>]
           }]
       });
   });  
</script>


<script type="text/javascript">
$(function () {
       $('#monthdetailofpie').highcharts({
           chart: {
               type: 'pie',
               width: <?php echo $chart_width;?>
           },
           title: {
               text: 'Report of wound Type of <?php echo $getvalue; ?>  with Pie Chart'
           },
           tooltip: {
           pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
           },
           plotOptions: {
           pie: {
               allowPointSelect: true,
               cursor: 'pointer',
               dataLabels: {
                   enabled: true,
                   color: '#000000',
                   connectorColor: '#000000',
                   format: '<b>{point.name}</b>: {point.y}'
               },
               showInLegend: true
           }
       },
           legend: {
               enabled: true,
               layout: 'vertical',
               align: 'right',
               width: 220,
               verticalAlign: 'middle',
                               borderWidth: 0,
               useHTML: true,
                               labelFormatter: function() {
                                       return '<div style="width:200px"><span style="float:left">' + this.name + '</span><span style="float:right">' + this.y + '</span></div>';
                               },
                               title: {
                                       text: 'Primary',
                                       style: {
                                               fontWeight: 'bold'
                                       }
                               }
           },
           series: [{
               name: 'Type of <?php echo $getvalue; ?>',
               data: [ <?php echo $pie; ?>]

           }]
       });
   });    
</script> 
<?php
}
elseif($selmode =="quarter"){
$getyear =  substr($getvalue, 0,-3);
$getquarter =  substr($getvalue, 6);
$date=date("{$getyear}-01-01",$getyear);
$end_date=date("{$getyear}-12-31",$getyear);
  
$d1 = strtotime($date);
$d2 = strtotime($end_date);
$min_date = min($d1, $d2);
$max_date = max($d1, $d2);


if($getquarter==1)
{
$data_start = date("Y-1-1", $min_date);
$data_end = date("Y-3-31", $min_date);
$min_date_new = date("Y-4-1", $min_date);
$min_date_new = strtotime($min_date_new);
}
elseif ($getquarter == 2) {
$data_start = date("Y-4-1", $min_date);
$data_end = date("Y-6-31", $min_date);
$min_date_new = date("Y-7-1", $min_date);      
$min_date_new = strtotime($min_date_new);    
}
elseif ($getquarter == 3) {
$data_start = date("Y-7-1", $min_date);
$data_end = date("Y-9-31", $min_date);
$min_date_new = date("Y-10-1", $min_date);
$min_date_new = strtotime($min_date_new);    
}
elseif ($getquarter == 4) {
$data_start = date("Y-10-1", $min_date);
$data_end = date("Y-12-31", $min_date);
$min_date_new = date("Y-1-1", $min_date);
$min_date_new = strtotime($min_date_new);
$min_date_new = strtotime("+1 YEAR", $min_date_new);
}

$sql = "SELECT distinct unit FROM {$wounds_table} WHERE facilitycode = '$facility'";
$result = db_query($sql);
foreach ($result as $row) {
$units[] = "'$row->unit'";
}
foreach ($units as $unit) {  
$sql = "SELECT count(distinct patientcode) as patienttotal
        FROM {$wounds_table} 
       WHERE facilitycode = '$facility'
         AND servicedate >= '$data_start' AND servicedate <= '$data_end'               
         AND unit = $unit 
     ";

$result = db_query($sql);
$patientsunit[] = $result->fetchField();

$sqlw = "SELECT count(distinct woundnumber) as woundtotal 
        FROM {$wounds_table} 
       WHERE facilitycode = '$facility'
         AND servicedate >= '$data_start' AND servicedate <= '$data_end'                
         AND unit = $unit 
     ";

$resultw = db_query($sqlw);
$woundunit[] = $resultw->fetchField();
}

$partic_month_units = implode(",", $units);
$partic_month_patient = implode(",", $patientsunit);
$partic_month_wound = implode(",", $woundunit);

//pie chart of that quarter.......................................
$pieofpmonthsql = "SELECT count(type) as number, type FROM {$wounds_table} WHERE facilitycode = '$facility' 
       AND servicedate >= '$data_start' AND servicedate <= '$data_end' GROUP BY type";    
$resultofpmonth = db_query($pieofpmonthsql);
$sum = 0;
$data = array();
foreach ($resultofpmonth as $row) {
$d = array();
$d['type'] = $row->type;
$d['number'] = $row->number;
$data[] = $d;
$sum += $row->number; 
} 
$new_data = array();
foreach ($data as $d) {
$d['number'] = round(($d['number']/$sum)*100, 2);
$new_data[] = $d;
}
$pie = "";
$pieType="";
$pieNumber="";

$count = 0;
foreach ($new_data as $d) {
if ($count > 0) {
$pie .= ",";   
}  
$pie .= "['$d[type]', $d[number]]";
$count++;
}
//echo "<P>DATA<PRE>";print_r($pie);echo "</PRE>";
//exit();
?>
<script type="text/javascript">
$(function () {
  var categories = [<?php echo $partic_month_units; ?>];
      $('#monthdetail').highcharts({
          chart: {
              type: 'column',
              width: <?php echo $chart_width;?>
          },
          title: {
              text: 'Report of patients and wound number of <?php echo $getvalue; ?>  with Unit'
          },
          xAxis: {
              categories: categories
          },
          yAxis: {
              title: {
                 text: 'Report for patients and wound number of <?php echo $getvalue; ?>  with Unit'
              },
              labels: {
                  formatter: function() {
                      return this.value
                  }
              }
          },
          tooltip: {
          useHTML: true,
          shared: true 
          },
          plotOptions: {
              spline: {
                  marker: {
                      radius: 4,
                      lineColor: '#666666',
                      lineWidth: 1
                  }
              }
          },
          legend: {
          enabled: true,
          layout: 'vertical',
          align: 'right',
          verticalAlign: 'middle',
          labelFormatter: function() {
          return this.name;
          }
          },
          series: [{
              name: 'Patients of <?php echo $getvalue; ?> with Unit',
              data: [<?php echo $partic_month_patient; ?>]

          }, {
              name: 'wound of  <?php echo $getvalue; ?> with Unit',
              data: [<?php echo $partic_month_wound; ?>]
          }]
      });
  });  
</script>


<script type="text/javascript">
$(function () {
      $('#monthdetailofpie').highcharts({
          chart: {
              type: 'pie',
              width: <?php echo $chart_width;?>
          },
          title: {
              text: 'Report of wound Type of <?php echo $getvalue; ?>  with Pie Chart'
          },
          tooltip: {
          pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
          },
          plotOptions: {
          pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                  enabled: true,
                  color: '#000000',
                  connectorColor: '#000000',
                  format: '<b>{point.name}</b>: {point.y:.1f}'
              },
              showInLegend: true
          }
      },
          legend: {
              enabled: true,
              layout: 'vertical',
              align: 'right',
              width: 220,
              verticalAlign: 'middle',
                              borderWidth: 0,
              useHTML: true,
                              labelFormatter: function() {
                                      return '<div style="width:200px"><span style="float:left">' + this.name + '</span><span style="float:right">' + this.y + '%</span></div>';
                              },
                              title: {
                                      text: 'Primary',
                                      style: {
                                              fontWeight: 'bold'
                                      }
                              }
          },
          series: [{
              name: 'Type of <?php echo $getvalue; ?>',
              data: [ <?php echo $pie; ?>]

          }]
      });
  });    
</script> 
<?php
}
elseif($selmode ="year"){
$date=date("{$getvalue}-01-01",$getvalue);
$date_new = strtotime("+1 YEAR", $date);  
$end_date=date("{$getvalue}-12-31",$date_new);

$d1 = strtotime($date);
$d2 = strtotime($end_date);
$min_date = min($d1, $d2);
$max_date = max($d1, $d2);

 $data_start = date("Y-m-d", $min_date);
 $data_end = date("Y-m-d", $max_date);
 
$sql = "SELECT distinct unit FROM {$wounds_table} WHERE facilitycode = '$facility'";
$result = db_query($sql);
foreach ($result as $row) {
  $units[] = "'$row->unit'";
}
foreach ($units as $unit) {  
$sql = "SELECT count(distinct patientcode) as patienttotal
          FROM {$wounds_table} 
         WHERE facilitycode = '$facility'
           AND servicedate >= '$data_start' AND servicedate <= '$data_end'               
           AND unit = $unit 
       ";
 
$result = db_query($sql);
$patientsunit[] = $result->fetchField();

$sqlw = "SELECT count(distinct woundnumber) as woundtotal 
          FROM {$wounds_table} 
         WHERE facilitycode = '$facility'
           AND servicedate >= '$data_start' AND servicedate <= '$data_end'                
           AND unit = $unit 
       ";

$resultw = db_query($sqlw);
$woundunit[] = $resultw->fetchField();
}

$partic_month_units = implode(",", $units);
$partic_month_patient = implode(",", $patientsunit);
$partic_month_wound = implode(",", $woundunit);

//pie chart of that year.......................................
$pieofpmonthsql = "SELECT count(type) as number, type FROM {$wounds_table} WHERE facilitycode = '$facility' 
         AND servicedate >= '$data_start' AND servicedate <= '$data_end' GROUP BY type";    
 $resultofpmonth = db_query($pieofpmonthsql);
 $sum = 0;
 $data = array();
foreach ($resultofpmonth as $row) {
$d = array();
$d['type'] = $row->type;
$d['number'] = $row->number;
$data[] = $d;
$sum += $row->number; 
} 
$new_data = array();
foreach ($data as $d) {
$d['number'] = round(($d['number']/$sum)*100, 2);
$new_data[] = $d;
}
$pie = "";
$pieType="";
$pieNumber="";

$count = 0;
foreach ($new_data as $d) {
if ($count > 0) {
  $pie .= ",";   
}  
$pie .= "['$d[type]', $d[number]]";
$count++;
}
 //echo "<P>DATA<PRE>";print_r($pie);echo "</PRE>";
 //exit();
?>
<script type="text/javascript">
$(function () {
    var categories = [<?php echo $partic_month_units; ?>];
        $('#monthdetail').highcharts({
            chart: {
                type: 'column',
                width: <?php echo $chart_width;?>
            },
            title: {
                text: 'Report of patients and wound number of <?php echo $getvalue; ?>  with Unit'
            },
            xAxis: {
                categories: categories
            },
            yAxis: {
                title: {
                   text: 'Report of patients and wound number of <?php echo $getvalue; ?>  with Unit'
                },
                labels: {
                    formatter: function() {
                        return this.value
                    }
                }
            },
            tooltip: {
            useHTML: true,
            shared: true 
            },
            plotOptions: {
                spline: {
                    marker: {
                        radius: 4,
                        lineColor: '#666666',
                        lineWidth: 1
                    }
                }
            },
            legend: {
            enabled: true,
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            labelFormatter: function() {
            return this.name;
            }
            },
            series: [{
                name: 'Patients of <?php echo $getvalue; ?> with Unit',
                data: [<?php echo $partic_month_patient; ?>]
    
            }, {
                name: 'wound of  <?php echo $getvalue; ?> with Unit',
                data: [<?php echo $partic_month_wound; ?>]
            }]
        });
    });  
</script>


<script type="text/javascript">
$(function () {
        $('#monthdetailofpie').highcharts({
            chart: {
                type: 'pie',
                width: <?php echo $chart_width;?>
            },
            title: {
                text: 'Report of wound Type of <?php echo $getvalue; ?>  with Pie Chart'
            },
            tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    color: '#000000',
                    connectorColor: '#000000',
                    format: '<b>{point.name}</b>: {point.y:.1f}'
                },
                showInLegend: true
            }
        },
            legend: {
                enabled: true,
                layout: 'vertical',
                align: 'right',
                width: 220,
                verticalAlign: 'middle',
				borderWidth: 0,
                useHTML: true,
				labelFormatter: function() {
					return '<div style="width:200px"><span style="float:left">' + this.name + '</span><span style="float:right">' + this.y + '%</span></div>';
				},
				title: {
					text: 'Primary',
					style: {
						fontWeight: 'bold'
					}
				}
            },
            series: [{
                name: 'Type of <?php echo $getvalue; ?>',
                data: [ <?php echo $pie; ?>]
    
            }]
        });
    });    
</script>
<?php
 }
?>

<?php
/**
 * Name: charts21.php
 * This program performs statistics analysis on patient number, wound number, wound type
 * and display the result as column and pie charts.
 * 
 * Message/Notes:
 * 
 */
// Set wounds analysis table
global $wounds_table;
//$wounds_table = "med_data"; // NO TEST NOW
$wounds_table = "wounds"; // production


define('DRUPAL_ROOT', getcwd());
require_once './includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
?>
<style>
body {
	font-family: "Trebuchet MS", "Helvetica", "Arial",  "Verdana", "sans-serif";
	font-size: 62.5%;
}

#main ul {display:none;}
</style>

<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>



<script>

$(function() {

$( "#datepicker1" ).datepicker();
   $(document).ready(function() {
$( "#datepicker1" ).datepicker( "option", "dateFormat", "yy-mm-dd");
});
});

$(function() {

$( "#datepicker2" ).datepicker();
   $(document).ready(function() {
$( "#datepicker2" ).datepicker( "option", "dateFormat", "yy-mm-dd");
});
});

</script>

<script>
    $(document).ready(function() {
        $("#summary_btn").click(function(){
        $( "#monthdetail" ).hide();
         $( "#monthdetailofpie" ).hide();
          $( "#container_2" ).show();
         $( "#container_3" ).show();
    });
    });
    </script>

<script>
    
Highcharts.theme = {
	colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
	chart: {
		backgroundColor: {
			linearGradient: [0, 0, 500, 500],
			stops: [
				[0, 'rgb(255, 255, 255)'],
				[1, 'rgb(240, 240, 255)']
			]
		},
		borderWidth: 2,
		plotBackgroundColor: 'rgba(255, 255, 255, .9)',
		plotShadow: true,
		plotBorderWidth: 1
	},
	title: {
		style: {
			color: '#000',
			font: 'bold 16px "Trebuchet MS", Verdana, sans-serif'
		}
	},
	subtitle: {
		style: {
			color: '#666666',
			font: 'bold 12px "Trebuchet MS", Verdana, sans-serif'
		}
	},
	xAxis: {
		gridLineWidth: 1,
		lineColor: '#000',
		tickColor: '#000',
		labels: {
			style: {
				color: '#000',
				font: '11px Trebuchet MS, Verdana, sans-serif'
			}
		},
		title: {
			style: {
				color: '#333',
				fontWeight: 'bold',
				fontSize: '12px',
				fontFamily: 'Trebuchet MS, Verdana, sans-serif'

			}
		}
	},
	yAxis: {
		minorTickInterval: 'auto',
		lineColor: '#000',
		lineWidth: 1,
		tickWidth: 1,
		tickColor: '#000',
		labels: {
			style: {
				color: '#000',
				font: '11px Trebuchet MS, Verdana, sans-serif'
			}
		},
		title: {
			style: {
				color: '#333',
				fontWeight: 'bold',
				fontSize: '12px',
				fontFamily: 'Trebuchet MS, Verdana, sans-serif'
			}
		}
	},
	legend: {
		itemStyle: {
			font: '9pt Trebuchet MS, Verdana, sans-serif',
			color: 'black'

		},
		itemHoverStyle: {
			color: '#039'
		},
		itemHiddenStyle: {
			color: 'gray'
		}
	},
	labels: {
		style: {
			color: '#99b'
		}
	}
};

// Apply the theme
var highchartsOptions = Highcharts.setOptions(Highcharts.theme);
</script>
<div id="summary_btn" style="float:right; display: none; margin-top:85px;"><input type="submit" value="Go Back to Summary"></div>
<?php
/**
 * This function draws column chart with 2 data sets in drill down.
 * @param type $input
 *   $input['container_id']: container id
 *   $input['title']: title
 *   $input['xs']: X axis labels
 *   $input['name1']: data set 1 name
 *   $input['data1']: data set 1 data
 *   $input['name2']: data set 2 name
 *   $input['data2']: data set 2 data
 * @return boolean
 */

function mi_chart_column_2_drill($input) {

  $container_id = $input['container_id'];    
  $title = $input['title'];
  $xs = $input['xs'];
  $name1 = $input['name1'];
  $data1 = $input['data1'];
  $name2 = $input['name2'];
  $data2 = $input['data2'];

?>


<div id="<?php echo $container_id;?>" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<script type="text/javascript">
$(function () {
        $('#<?php echo $container_id;?>').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: '<?php echo "$title";?>'
            },
            xAxis: {
                categories: [<?php echo $xs;?>]
            },
            yAxis: {
                min: 0,
                title: {
                    text: ''                    
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
                },               
            },
            
plotOptions: {
    column: {
        point: {
            events: {
                click: function() {  alert("HA");                 
                    $('#dateDisplay').text(this.category);
                    $.getJSON("data.php?dateParam="+this.category, function(json){                       
                        options.xAxis.categories = json['category'];
                        options.series[0].name = json['name'];
                        options.series[0].data = json['data'];
                        options.xAxis.labels = {
                            formatter: function() {
                            //return Highcharts.dateFormat('%l%p', Date.parse(this.value +' UTC'));
                            return Highcharts.dateFormat('%l%p', Date.parse(this.value));
                            //return this.value;
                            }
                        }                       
                    });
                }
            }
        },
        dataLabels: {
            enabled: true
        }
    }
},

            
            
            
            series: [{
                name: '<?php echo "$name1";?>',
                data: [<?php echo "$data1";?>]
    
            }, {
                name: '<?php echo "$name2";?>',
                data: [<?php echo "$data2";?>]    
            }],

            drilldown: {
                series: [<?php echo "$data1";?>]
            }           
            
        });
    });
</script>
<?php
  return TRUE;
} // function mi_chart_column

/**
 * This function draws column chart with 2 data sets.
 * @param type $input
 *   $input['container_id']: container id
 *   $input['title']: title
 *   $input['xs']: X axis labels
 *   $input['name1']: data set 1 name
 *   $input['data1']: data set 1 data
 *   $input['name2']: data set 2 name
 *   $input['data2']: data set 2 data
 * @return boolean
 */
function mi_chart_column_2($input) {

  $container_id = $input['container_id'];    
  $title = $input['title'];
  $xs = $input['xs'];
  $name1 = $input['name1'];
  $data1 = $input['data1'];
  $name2 = $input['name2'];
  $data2 = $input['data2'];

?>
<div id="<?php echo $container_id;?>" style="min-width: 310px; height: 400px; margin: 0 auto"></div>


<script type="text/javascript">
$(function () {
        $('#<?php echo $container_id;?>').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: '<?php echo "$title";?>'
            },
            xAxis: {
                categories: [<?php echo $xs;?>]
            },
            yAxis: {
                min: 0,
                title: {
                    text: ''                    
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
                name: '<?php echo "$name1";?>',
                data: [<?php echo "$data1";?>]
    
            }, {
                name: '<?php echo "$name2";?>',
                data: [<?php echo "$data2";?>]    
            }]
        });
    });
</script>
<?php
  return TRUE;
} // function mi_chart_column
/**
 * This function draws a pie chart.
 * @param type $input
 *   $input['pie']: pie data
 *   $input['container_id']: container id
 *   $input['title']: title
 * @return boolean 
 */
function mi_chart_pie($input) {
  $pie = $input['pie'];
  $sum = $input['sum'];
  $container_id = $input['container_id'];    
  $title = $input['title'];
?>  


<div id="<?php echo $container_id;?>" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<!--<div id="summary_btn" style="float:left; display: none;"><input type="submit" value="Go Back to Summary"></div>-->

<script type="text/javascript">
$(function () {
        $('#<?php echo $container_id;?>').highcharts({
        chart: {
                type: 'pie',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
        },
        title: {
            text: '<?php echo "$title";?>'
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
                    format: '<b>{point.name}</b>: {point.y} '
                },
                showInLegend: true
            }
        },
        legend: {
                enabled: true,
                layout: 'vertical',
                align: 'right',
                width: 230,
                verticalAlign: 'top',
		borderWidth: 0,
                useHTML: true,
                pieSliceText:'value',
		labelFormatter: function() {
                    var floatvalue = (this.y/100) * <?php echo $sum;?>;
                    var intvalue = Math.round( floatvalue );
                    return '<div style="width:200px"><span style="float:left">' + this.name + '</span><span style="float:right">' + intvalue + '</span></div>';
		},
		title: {
                    text: 'Summary',
                    style: {
                        fontWeight: 'bold'
                    }
		}
            },
        series: [{
            name: 'Browser share',
            data: [
                <?php echo $pie; ?>
            ]
        }]

        });
});    
</script>
<?php
return TRUE;
} // function mi_chart_pie

/**
 * This function gives wound type report with pie chart.
 * @param type $input
 *   $input['container_id']: container id
 *   $input['facilitycode']: facility code
 *   $input['startyear']:
 *   $input['startmonth']:
 *   $input['startdt']:
 *   $input['endyear']:
 *   $input['endmonth']:
 *   $input['enddt']: 
 * @return boolean
 */
function mi_report_wound_type($input) {
  global $wounds_table;
  
  $debug = $input['debug'];
  $container_id = $input['container_id'];
  $facilitycode = $input['facilitycode'];    
  $startyear = $input['startyear'];
  $startmonth = $input['startmonth'];
  $startdt = $input['startdt'];
  $endyear = $input['endyear'];
  $endmonth = $input['endmonth'];
  $enddt = $input['enddt'];
    
  $startdate = "$startyear-$startmonth-$startdt";
  $enddate = "$endyear-$endmonth-$enddt";

  $d1 = strtotime($startdate);
  $d2 = strtotime($enddate);
  $min_date = min($d1, $d2);
  $max_date = max($d1, $d2);

  $data_start = date("Y-m-d", $min_date);
  $data_end = date("Y-m-d", $max_date);

  $sql = "SELECT count(type) as number, type
            FROM {$wounds_table} 
           WHERE facilitycode = '$facilitycode'
             AND servicedate >= '$data_start' AND servicedate <= '$data_end'
        GROUP BY type         
         ";
  if ($debug) {
    echo "<BR>SQL=$sql";
  }
  $result = db_query($sql);
  $sum = 0;
  $data = array();
  foreach ($result as $row) {
    $d = array();
    $d['type'] = $row->type;
    $d['number'] = $row->number;
    $data[] = $d;
    $sum += $row->number; 
  }  
  if ($debug) {
    echo "<P>$sum<PRE>";print_r($data);echo "</PRE>";
  }
  $new_data = array();
  foreach ($data as $d) {
    $d['number'] = round(($d['number']/$sum)*100, 2);
    $new_data[] = $d;
  }
  if ($debug) {
    echo "<P>$sum<PRE>";print_r($new_data);echo "</PRE>";  
  }

  $pie = "";
  $count = 0;
  foreach ($new_data as $d) {
    if ($count > 0) {
      $pie .= ",";    
    }  
    $pie .= "['$d[type]', $d[number]]";
    $count++;
  }
  if ($debug) {
    echo "<P>PIE=$pie";
  }
  
  // Get facility name.
  $facility = "FACILITY";  
  if ($wounds_table == "wounds") {
    $sql = "SELECT facility FROM {whs_cms_facilities_crosswalk} WHERE facilitycode = '$facilitycode'";
    $result = db_query($sql);
    $facility = $result->fetchField();
  }
  
  $ipt = array();
  $ipt['title'] = "Facility $facility wound type statistics";
  $ipt['container_id'] = $container_id;
  $ipt['pie'] = $pie;
  $ipt['sum'] = $sum;
  $ret = mi_chart_pie($ipt);
  
  return TRUE;
} // function mi_report_wound_type


/**
 * This functions gives patient and wound number report with 2 column chart.
 * @param type $input
 * @return boolean
 */
function mi_report_patient_wound($input) {
  global $wounds_table;
  
  $debug = $input['debug'];  
  $facilitycode = $input['facilitycode'];
  $mode = $input['mode'];
  $container_id = $input['container_id'];
  $startyear = $input['startyear'];
  $startmonth = $input['startmonth'];
  $startdt = $input['startdt'];  
  $endyear = $input['endyear'];
  $endmonth = $input['endmonth'];
  $enddt = $input['enddt']; 
  if ($debug) {
    echo "<P>INPUT<PRE>"; 
    print_r($input); 
    echo "</PRE>";   
  }

  $startdate = "$startyear-$startmonth-$startdt";
  $enddate = "$endyear-$endmonth-$enddt";

  $d1 = strtotime($startdate);
  $d2 = strtotime($enddate);
  $min_date = min($d1, $d2);
  $max_date = max($d1, $d2);
  if ($debug) {
    echo "<P>min_date=$min_date max_date=$max_date";
  }
  
  $i = 0;
  $xs = array();
  $ranges = array();
  $patients = array();
  $wounds = array();  

// Period day  
if ($mode == "day") {
while ($min_date <= $max_date) {  
  $data_start = date("Y-m-d", $min_date);
  
  $min_date_new = strtotime("+1 WEEK", $min_date);  
  $data_end = date("Y-m-d", $min_date_new);
  
  $x = date("Y-m-d", $min_date_new);
  $range = "$data_start - $data_end";
  $xs[] = "'$x'";
  $ranges[] = $range;
  
  $sql = "SELECT count(distinct patientcode) as patienttotal
            FROM {$wounds_table} 
           WHERE facilitycode = '$facilitycode'
             AND servicedate >= '$data_start' AND servicedate <= '$data_end'
         ";
  if ($debug) {
    echo "<P>SQL=$sql";
  }
  $result = db_query($sql);
  $patients[] = $result->fetchField();
  
  $sql = "SELECT count(distinct woundnumber) as woundtotal 
            FROM {$wounds_table} 
           WHERE facilitycode = '$facilitycode'
             AND servicedate >= '$data_start' AND servicedate <= '$data_end'
         ";
  if ($debug) {
    echo "<P>SQL=$sql";
  }  
  $result = db_query($sql);
  $wounds[] = $result->fetchField();

  $min_date = $min_date_new;
  $i++;
}

} // if ($mode == "day")

// Period month
if ($mode == "month") {
while ($min_date <= $max_date) {
  $min_date_new = strtotime("+1 MONTH", $min_date); 
  
  $data_start = date("Y-m-1", $min_date);
  $data_end = date("Y-m-31", $min_date);
  
  $x = date("Y-m", $min_date);
  $range = "$data_start - $data_end";
  $xs[] = "'$x'";
  $ranges[] = $range;

  $sql = "SELECT count(distinct patientcode) as patienttotal
            FROM {$wounds_table} 
           WHERE facilitycode = '$facilitycode'
             AND servicedate >= '$data_start' AND servicedate <= '$data_end'
         ";
  if ($debug) {
    echo "<P>SQL=$sql";
  }
  $result = db_query($sql);
  $patients[] = $result->fetchField();
  
  $sql = "SELECT count(distinct woundnumber) as woundtotal 
            FROM {$wounds_table} 
           WHERE facilitycode = '$facilitycode'
             AND servicedate >= '$data_start' AND servicedate <= '$data_end'
         ";
  if ($debug) {
    echo "<P>SQL=$sql";
  }  
  $result = db_query($sql);
  $wounds[] = $result->fetchField();

  $min_date = $min_date_new;  
  $i++;
}

} // if ($mode == "month")

// Period quarter
if ($mode == "quarter") {
while ($min_date <= $max_date) {
  $min_date_year = date("Y", $min_date);
  $min_date_month = date("m", $min_date);
  $min_date_quarter = ceil($min_date_month/3);
  if ($debug) {
    echo "<P>min_date=$min_date Y=$min_date_year M=$min_date_month Q=$min_date_quarter";
  }
  
  if ($min_date_quarter == 1) {
    $data_start = date("Y-1-1", $min_date);
    $data_end = date("Y-3-31", $min_date);
    $min_date_new = date("Y-4-1", $min_date);
    $min_date_new = strtotime($min_date_new);
  }
  elseif ($min_date_quarter == 2) {
    $data_start = date("Y-4-1", $min_date);
    $data_end = date("Y-6-31", $min_date);
    $min_date_new = date("Y-7-1", $min_date);      
    $min_date_new = strtotime($min_date_new);    
  }
  elseif ($min_date_quarter == 3) {
    $data_start = date("Y-7-1", $min_date);
    $data_end = date("Y-9-31", $min_date);
    $min_date_new = date("Y-10-1", $min_date);
    $min_date_new = strtotime($min_date_new);    
  }
  elseif ($min_date_quarter == 4) {
    $data_start = date("Y-10-1", $min_date);
    $data_end = date("Y-12-31", $min_date);
    $min_date_new = date("Y-1-1", $min_date);
    $min_date_new = strtotime($min_date_new);
    $min_date_new = strtotime("+1 YEAR", $min_date_new);
  }

  if ($debug) {
    echo "<P>start=$data_start end=$data_end min_date_new=$min_date_new";    
  }

  $x = "$min_date_year Q$min_date_quarter";
  $range = "$data_start - $data_end";
  $xs[] = "'$x'";
  $ranges[] = $range;

  $sql = "SELECT count(distinct patientcode) as patienttotal
            FROM {$wounds_table} 
           WHERE facilitycode = '$facilitycode'
             AND servicedate >= '$data_start' AND servicedate <= '$data_end'
         ";
  if ($debug) {
    echo "<P>SQL=$sql";
  }
  $result = db_query($sql);
  $patients[] = $result->fetchField();
  
  $sql = "SELECT count(distinct woundnumber) as woundtotal 
            FROM {$wounds_table} 
           WHERE facilitycode = '$facilitycode'
             AND servicedate >= '$data_start' AND servicedate <= '$data_end'
         ";
  if ($debug) {
    echo "<P>SQL=$sql";
  }  
  $result = db_query($sql);
  $wounds[] = $result->fetchField();

  $min_date = $min_date_new;  
  $i++;
  
  // Can not > 100.
  //if ($i==100) {
  //  exit();
  //}
}

} // if ($mode == "quarter")


// Period year
if ($mode == "year") {
while ($min_date <= $max_date) {
  $min_date_new = strtotime("+1 YEAR", $min_date);
  
  $data_start = date("Y-1-1", $min_date);
  $data_end = date("Y-12-31", $min_date);
  
  $x = date("Y", $min_date);
  $range = "$data_start - $data_end";
  $xs[] = "'$x'";
  $ranges[] = $range;
  
  $sql = "SELECT count(distinct patientcode) as patienttotal
            FROM {$wounds_table} 
           WHERE facilitycode = '$facilitycode'
             AND servicedate >= '$data_start' AND servicedate <= '$data_end'
         ";
  if ($debug) {
    echo "<P>SQL=$sql";
  }  
  $result = db_query($sql);
  $patients[] = $result->fetchField();
  
  $sql = "SELECT count(distinct woundnumber) as woundtotal 
            FROM {$wounds_table} 
           WHERE facilitycode = '$facilitycode'
             AND servicedate >= '$data_start' AND servicedate <= '$data_end'
         ";  
  if ($debug) {
    echo "<P>SQL=$sql";
  }  
  $result = db_query($sql);
  $wounds[] = $result->fetchField();
  
  $min_date = $min_date_new;
  $i++;
}

} // if ($mode == "year")


  if ($debug) {
    echo "<P>FINAL I=$i<PRE>";
    print_r($xs);
    print_r($ranges);
    print_r($patients);
    print_r($wounds);
    echo "</PRE>";
  }

  $x3 = implode(",", $xs);
  $patient3 = implode(",", $patients);
  $wound3 = implode(",", $wounds);

  // Begin to draw chart
  if ($debug) {
    echo "<P>X3=$x3 PATIENT3=$patient3 WOUND3=$wound3";
  }

  // Get facility name.
  $facility = "FACILITY"; 
  if ($wounds_table == "wounds") {
    $sql = "SELECT facility FROM {whs_cms_facilities_crosswalk} WHERE facilitycode = '$facilitycode'";
    $result = db_query($sql);
    $facility = $result->fetchField();
  }
  
  $ipt = array();
  $ipt['container_id'] = $container_id;
  $ipt['title'] = "Report for facility $facility with $mode period";
  $ipt['xs'] = $x3;
  $ipt['name1'] = "Patients";
  $ipt['data1'] = $patient3;
  $ipt['name2'] = "Wound number";
  $ipt['data2'] = $wound3;
  $ret = mi_chart_column_2_drill($ipt);

  return TRUE;
} // mi_report_patient_wound

/**
 * This functions gives patient and wound number report on unit with 2 column chart.
 * @param type $input
 * @return boolean
 */
function mi_report_patient_wound_unit($input) {
  global $wounds_table;

  $debug = $input['debug'];  
  $facilitycode = $input['facilitycode'];
  $mode = $input['mode'];
  $container_id = $input['container_id'];
  $startyear = $input['startyear'];
  $startmonth = $input['startmonth'];
  $startdt = $input['startdt'];  
  $endyear = $input['endyear'];
  $endmonth = $input['endmonth'];
  $enddt = $input['enddt'];
  if ($debug) {
    echo "<P>INPUT<PRE>";
    print_r($input);
    echo "</PRE>";
  }
  
  $startdate = "$startyear-$startmonth-$startdt";
  $enddate = "$endyear-$endmonth-$enddt";

  $d1 = strtotime($startdate);
  $d2 = strtotime($enddate);
  $min_date = min($d1, $d2);
  $max_date = max($d1, $d2);
  
  $units = array();
  $sql = "SELECT distinct unit
            FROM {$wounds_table}
           WHERE facilitycode = '$facilitycode'
         ";
  if ($debug) {
    echo "<P>SQL=$sql";
  }
  $result = db_query($sql);
  foreach ($result as $row) {
    $units[] = "'$row->unit'";    
  }
  if ($debug) {
    echo "<P>UNITS<PRE>";
    print_r($units);
    echo "</PRE>";
  }

$patients = array();
$wounds = array();
foreach ($units as $unit) {  
  $sql = "SELECT count(distinct patientcode) as patienttotal
            FROM {$wounds_table} 
           WHERE facilitycode = '$facilitycode'
             AND servicedate >= '$startdate' AND servicedate <= '$enddate'               
             AND unit = $unit
         ";
  if ($debug) {
    echo "<P>SQL=$sql";
  }
  $result = db_query($sql);
  $patients[] = $result->fetchField();
  
  $sql = "SELECT count(distinct woundnumber) as woundtotal 
            FROM {$wounds_table} 
           WHERE facilitycode = '$facilitycode'
             AND servicedate >= '$startdate' AND servicedate <= '$enddate'                
             AND unit = $unit
         ";
  if ($debug) {
    echo "<P>SQL=$sql";
  }  
  $result = db_query($sql);
  $wounds[] = $result->fetchField();
}

  if ($debug) {
    echo "<P>UNITS DATA<PRE>";
    print_r($units);
    print_r($patients);
    print_r($wounds);
    echo "</PRE>";
  }

  $x3 = implode(",", $units);
  $patient3 = implode(",", $patients);
  $wound3 = implode(",", $wounds);

  // Begin to draw chart
  if ($debug) {
    echo "<P>X3=$x3 PATIENT3=$patient3 WOUND3=$wound3";
  }

  // Get facility name.
  $facility = "FACILITY";
  if ($wounds_table == "wounds") {
    $sql = "SELECT facility FROM {whs_cms_facilities_crosswalk} WHERE facilitycode = '$facilitycode'";
    $result = db_query($sql);
    $facility = $result->fetchField();  
  }

  $ipt = array();
  $ipt['container_id'] = $container_id;
  $ipt['title'] = "Report for facility $facility with unit";
  $ipt['xs'] = $x3;
  $ipt['name1'] = "Patients";
  $ipt['data1'] = $patient3;
  $ipt['name2'] = "Wound number";
  $ipt['data2'] = $wound3;
  $ret = mi_chart_column_2($ipt);

  return TRUE;
} // mi_report_patient_wound_unit



/*
 * Main program 
 */

// Get facility code and facility name.
if ($wounds_table == "wounds") {
  $sql = "select distinct c.facilitycode, c.facility
            from {$wounds_table} w, {whs_cms_facilities_crosswalk} c
           where w.facilitycode = c.facilitycode
             and c.facility is not null
           order by c.facility
         ";
  $result = db_query($sql);
  $options = array();
  foreach ($result as $row) {
    $option = array();
    $option['value'] = $row->facilitycode;
    $option['name'] = $row->facility;
    $options[] = $option;
  }
}

if ($wounds_table == "med_data") {
  $sql = "SELECT DISTINCT facilitycode FROM {$wounds_table} ORDER BY facilitycode";
  $result = db_query($sql);
  $options = array();
  foreach ($result as $row) {
    $option = array();
    $option['value'] = $row->facilitycode;
    $option['name'] = $row->facilitycode; // use facilitycode as facility name
    $options[] = $option;
  }
}


// Set build form.
echo "<form method=post id=form1>";

echo "<b>Facilities</b> <select style='width:223px;'name=facilitycode><br>Select Facility";
foreach ($options as $option) {
echo "<option value=$option[value]";
if (isset($_REQUEST['facilitycode']) && $_REQUEST['facilitycode']==$option['value']) {
  echo " SELECTED ";    
}
echo ">$option[name]</option>";    
}
echo "</select>";

echo "<br><b>Date From</b> [yyyy-mm-dd] <input style='width:148px;' type=text id=\"datepicker1\" name=startdate ";
if (isset($_REQUEST['startdate'])) {
  echo " value=\"$_REQUEST[startdate]\"";
}    
echo ">";
//echo "<br>Select date report start date";

echo "<br><b>Date To</b> [yyyy-mm-dd] <input style='width:160px;' type=text id=\"datepicker2\" name=enddate ";    
if (isset($_REQUEST['enddate'])) {
  echo " value=\"$_REQUEST[enddate]\"";
}    
echo ">";
//echo "<br>Select date report end date";

echo "<br><b>Chart Period</b> ";
echo "<input type=radio name=mode value=day ";
if (isset($_REQUEST['mode']) && $_REQUEST['mode']=="day") {
  echo " CHECKED  ";    
}
echo "> Day ";

echo "<input type=radio name=mode value=month ";
if (isset($_REQUEST['mode']) && $_REQUEST['mode']=="month") {
  echo " CHECKED  ";    
}
echo "> Month ";

echo "<input type=radio name=mode value=quarter ";
if (isset($_REQUEST['mode']) && $_REQUEST['mode']=="quarter") {
  echo " CHECKED  ";    
}
echo "> Quarter ";

echo "<input type=radio name=mode value=year ";
if (isset($_REQUEST['mode']) && $_REQUEST['mode']=="year") {
  echo " CHECKED  ";    
}
echo "> Year ";
//echo "<br>Select chart period";

echo "<br><input type=submit value=\"Build Chart\">";
echo "<input type=hidden name=act value=build>";
echo "</form>";

// Build the charts

if (isset($_REQUEST['act']) && $_REQUEST['act'] == "build") {
  $facilitycode = $_REQUEST['facilitycode'];
  $startdate_value = $_REQUEST['startdate'];
  $enddate_value = $_REQUEST['enddate'];
  $mode = $_REQUEST['mode'];

  // yyyy-mm-dd
  $startdate_array = explode("-", $startdate_value);
  $startyear = $startdate_array[0];
  $startmonth = $startdate_array[1];
  $startdt = $startdate_array[2];

  $enddate_array = explode("-", $enddate_value);
  $endyear = $enddate_array[0];
  $endmonth = $enddate_array[1];
  $enddt = $enddate_array[2];

/*  // mm/dd/yyyy
  $startdate_array = explode("/", $startdate_value);
  $startyear = $startdate_array[2];
  $startmonth = $startdate_array[0];
  $startdt = $startdate_array[1];
  
  $enddate_array = explode("/", $enddate_value);
  $endyear = $enddate_array[2];
  $endmonth = $enddate_array[0];
  $enddt = $enddate_array[1]; */


////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////  
  
  
$startdate = "$startyear-$startmonth-$startdt";
$enddate = "$endyear-$endmonth-$enddt";

$d1 = strtotime($startdate);
$d2 = strtotime($enddate);
$min_date = min($d1, $d2);
$max_date = max($d1, $d2);

$data_start = date("Y-m-d", $min_date);
$data_end = date("Y-m-d", $max_date); 

// Get facility name.
$facility = "FACILITY";
if ($wounds_table == "wounds") {
  $sql = "SELECT facility FROM {whs_cms_facilities_crosswalk} WHERE facilitycode = '$facilitycode'";
  $result = db_query($sql);
  $facility = $result->fetchField();  
}

$i=0;
if ($mode == "day") {

while ($min_date <= $max_date) {  
$new_data_start = date("Y-m-d", $min_date);

$min_date_new = strtotime("+1 WEEK", $min_date);  
$new_data_end = date("Y-m-d", $min_date_new);

$x = date("Y-m-d", $min_date);
$xs[] = "'$x'";

$sql = "SELECT count(distinct patientcode) as patienttotal
          FROM {$wounds_table} 
         WHERE facilitycode = '$facilitycode'
           AND servicedate >= '$new_data_start' AND servicedate <= '$new_data_end'
       ";

$result = db_query($sql);
$patients[] = $result->fetchField();

$sql = "SELECT count(distinct woundnumber) as woundtotal 
          FROM {$wounds_table} 
         WHERE facilitycode = '$facilitycode'
           AND servicedate >= '$new_data_start' AND servicedate <= '$new_data_end'
       ";

$result = db_query($sql);
$wounds[] = $result->fetchField();

$min_date = $min_date_new;
$i++;
}
$days = implode(",", $xs);
$patient3 = implode(",", $patients);
$wound3 = implode(",", $wounds);

//$units = array();
$sql = "SELECT distinct unit FROM {$wounds_table} WHERE facilitycode = '$facilitycode'";
$result = db_query($sql);
foreach ($result as $row) {
  $units[] = "'$row->unit'";    
}

foreach ($units as $unit) {  
$sql = "SELECT count(distinct patientcode) as patienttotal
          FROM {$wounds_table} 
         WHERE facilitycode = '$facilitycode'
           AND servicedate >= '$startdate' AND servicedate <= '$enddate'               
           AND unit = $unit
       ";

$result = db_query($sql);
$patientsofunit[] = $result->fetchField();

$sql = "SELECT count(distinct woundnumber) as woundtotal 
          FROM {$wounds_table} 
         WHERE facilitycode = '$facilitycode'
           AND servicedate >= '$data_start' AND servicedate <= '$data_end'                
           AND unit = $unit
       ";

$result = db_query($sql);
$woundsofunit[] = $result->fetchField();
}

$units2 = implode(",", $units);
$unitsu =  substr($units2, 0,-3);
$patientsu = implode(",", $patientsofunit);
$woundsu = implode(",", $woundsofunit);

//For pie chart.......................................
$sql = "SELECT count(type) as number, type FROM {$wounds_table} WHERE facilitycode = '$facilitycode' 
      AND servicedate >= '$data_start' AND servicedate <= '$data_end' GROUP BY type";    
$resultt = db_query($sql);
$sum = 0;
$data = array();
foreach ($resultt as $row) {
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
  $pieType .= ","; 
  $pieNumber .= ",";    
}  
$pie .= "['$d[type]', $d[number]]";
$pieType .= "'$d[type]'";
$pieNumber .= "$d[number]";
$count++;
}
?>

<div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>

<div id="monthdetail" style="min-width: 400px; height: 400px; margin: 0 auto"></div>

<div id="monthdetailofpie" style="min-width: 400px; height: 400px; margin: 0 auto"></div>

<div id="overlay"></div>
<div id="confirmBox" onclick="toggleOverlay()">
<div class="message"></div>
<span class="button unit">UNIT</span>
<span class="button type">WOUND-TYPE</span>
</div>

<script type="text/javascript">

Highcharts.theme = {
colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
chart: {
backgroundColor: {
linearGradient: { x1: 0, y1: 0, x2: 1, y2: 1 },
stops: [
[0, 'rgb(255, 255, 255)'],
[1, 'rgb(240, 240, 255)']
]
},
borderWidth: 2,
plotBackgroundColor: 'rgba(255, 255, 255, .9)',
plotShadow: true,
plotBorderWidth: 1
},
title: {
style: {
color: '#000',
font: 'bold 16px "Trebuchet MS", Verdana, sans-serif'
}
},
subtitle: {
style: {
color: '#666666',
font: 'bold 12px "Trebuchet MS", Verdana, sans-serif'
}
},
xAxis: {
gridLineWidth: 1,
lineColor: '#000',
tickColor: '#000',
labels: {
style: {
color: '#000',
font: '11px Trebuchet MS, Verdana, sans-serif'
}
},
title: {
style: {
color: '#333',
fontWeight: 'bold',
fontSize: '12px',
fontFamily: 'Trebuchet MS, Verdana, sans-serif'

}
}
},
yAxis: {
minorTickInterval: 'auto',
lineColor: '#000',
lineWidth: 1,
tickWidth: 1,
tickColor: '#000',
labels: {
style: {
color: '#000',
font: '11px Trebuchet MS, Verdana, sans-serif'
}
},
title: {
style: {
color: '#333',
fontWeight: 'bold',
fontSize: '12px',
fontFamily: 'Trebuchet MS, Verdana, sans-serif'
}
}
},
legend: {
itemStyle: {
font: '9pt Trebuchet MS, Verdana, sans-serif',
color: 'black'

},
itemHoverStyle: {
color: '#039'
},
itemHiddenStyle: {
color: 'gray'
}
},
labels: {
style: {
color: '#99b'
}
},

navigation: {
buttonOptions: {
theme: {
stroke: '#CCCCCC'
}
}
}
};

// Apply the theme
var highchartsOptions = Highcharts.setOptions(Highcharts.theme);

function toggleOverlay(){
var overlay = document.getElementById('overlay');
var specialBox = document.getElementById('confirmBox');
overlay.style.opacity = .8;
if(overlay.style.display == "block"){
overlay.style.display = "none";
specialBox.style.display = "none";
} else {
overlay.style.display = "block";
specialBox.style.display = "block";
}
}
</script>
<style>
div#overlay {
display: none;
z-index: 2;
background: #000;
position: fixed;
width: 100%;
height: 100%;
top: 0px;
left: 0px;
text-align: center;
}
body { font-family: sans-serif; }
#confirmBox {
background: none repeat scroll 0 0 #EEEEEE;
border: 1px solid #AAAAAA;
border-radius: 5px 5px 5px 5px;
display: none;
left: 42%;
padding: 6px 8px 8px;
position: fixed;
text-align: center;
top: 10%;
width: 22%;
z-index: 9;
}
#confirmBox .button {
background-color: #CCCCCC;
border: 1px solid #AAAAAA;
border-radius: 3px 3px 3px 3px;
cursor: pointer;
display: inline-block;
font-size: 13px;
font-weight: bold;
padding: 4px;
text-align: center;
width: 100px;
}
#confirmBox .button:hover
{
background-color: #ddd;
}
#confirmBox .message {
margin-bottom: 8px;
margin-top: 12px;
text-align: center;
}
</style>

<script type="text/javascript">
$( "#monthdetail" ).hide();
$( "#monthdetailofpie" ).hide();
function doConfirm(msg, unitFn, typeFn) {
var confirmBox = $("#confirmBox");
confirmBox.find(".message").text(msg);
confirmBox.find(".unit,.type").unbind().click(function () {
confirmBox.hide();
});
confirmBox.find(".unit").click(unitFn);
confirmBox.find(".type").click(typeFn);
confirmBox.show();
}

$(function () {
var chart;
$(document).ready(function() {
var colors = Highcharts.getOptions().colors;
var p = [<?php echo $patient3; ?>]; 
var wn = [<?php echo $wound3; ?>];
var categories = [<?php echo $days; ?>];
name = 'Patients';
name2 = 'Wound_Number';

var sss;
sss = '';
var ss;
ss = ''; 
var Mycat;
Mycat = categories.length-1;
for(var i=Mycat; i >=0 ; i--){
ss = [{y:p[i]}];
if(i == Mycat) { data = ss;}
else { data = ss.concat(sss); }
sss = data; 
}

for(var i=Mycat; i >=0 ; i--){
ss = [{y:wn[i]}];
if(i == Mycat) { data2 = ss;}
else { data2 = ss.concat(sss); }
sss = data2; 
}

chart = new Highcharts.Chart({
    chart: {
        renderTo: 'container'
    },
    title: {
        text: 'Report of facility <?php echo $facility;?> with Days period'
    },
    xAxis: {
        categories: categories
    },
    yAxis: {
        title: {
         text: 'Report of facility <?php echo $facility;?> with Days period'
        }
    },
    plotOptions: {
        column: {
            cursor: 'pointer',
            point: {
                events: {
                    click: function(event) {
                    //$( "#container" ).hide();  
                    //toggleOverlay(); 
                        //doConfirm('Select to look the unit and wound type reports of this month  '+ this.category+' ?', function unit() {
                        //REDIRECT                      
                            $( "#monthdetail" ).show();
                            $( "#monthdetailofpie" ).show(); 
                            $( "#container" ).hide();
                        //}, function type() {                                     
                        //REDIRECT
                            //$( "#monthdetail" ).hide();
                            //$( "#monthdetailofpie" ).show();
                        //});                      
                        var monthname =  this.category;
var data = 'nameofmonth='+monthname+'&facilitycode=<?php echo $facilitycode; ?>'+'&mode=<?php echo $mode;?>';
        $.ajax({
type: "GET",
url: "month.php",
data: data,
success:function(result){
     $("#monthdetailofpie").html(result);
      $("#monthdetail").html(result);
}
});
                    }
                }
            }
       },
        pie: {
            allowPointSelect: true,
            dataLabels: {
                enabled: true,
                color: '#000000',
                connectorColor: '#000000',
                format: '<b>{point.name}</b>: {point.percentage:.1f} %'
            },
           showInLegend: true
       }},
    tooltip: {
        useHTML: true,
          shared: true 
    },
    legend: {
    enabled: false,
    layout: 'vertical',
    align: 'right',
    verticalAlign: 'middle',
    pieSliceText:'value',
    labelFormatter: function() {
    return this.name;
    }
    },
    series: [{ 
    name: name, 
    color: '#8BBC21', 
    type: 'column', 
    data: data 
    }, 
    { 
    name: name2, 
    color: '#AA1919', 
    type: 'column', 
    data: data2 
    }],
    exporting: {
    enabled: true
    }
});
});
});

</script>

<?php }

else if ($mode == "month") { 
      
while ($min_date <= $max_date) {
$min_date_new = strtotime("+1 MONTH", $min_date); 

$new_data_start = date("Y-m-1", $min_date);
$new_data_end = date("Y-m-31", $min_date);

 //$x = date('M', $min_date);
$x = date('M Y', $min_date);
 $xs[] = "'$x'";

$sql = "SELECT count(distinct patientcode) as patienttotal
          FROM {$wounds_table} 
         WHERE facilitycode = '$facilitycode'
           AND servicedate >= '$new_data_start' AND servicedate <= '$new_data_end'
       ";
 
$result = db_query($sql);
$patients[] = $result->fetchField();
  
$sql = "SELECT count(distinct woundnumber) as woundtotal 
          FROM {$wounds_table} 
         WHERE facilitycode = '$facilitycode'
           AND servicedate >= '$new_data_start' AND servicedate <= '$new_data_end'
       ";
$result = db_query($sql);
$wounds[] = $result->fetchField();
$min_date = $min_date_new;  
}

$month = implode(",", $xs);
$patient3 = implode(",", $patients);
$wound3 = implode(",", $wounds);

 //$units = array();
$sql = "SELECT distinct unit FROM {$wounds_table} WHERE facilitycode = '$facilitycode'";
$result = db_query($sql);
foreach ($result as $row) {
  $units[] = "'$row->unit'";
}

foreach ($units as $unit) {  
$sql = "SELECT count(distinct patientcode) as patienttotal
          FROM {$wounds_table} 
         WHERE facilitycode = '$facilitycode'
           AND servicedate >= '$data_start' AND servicedate <= '$data_end'               
           AND unit = $unit 
       ";
 
$result = db_query($sql);
$patientsofunitmonth[] = $result->fetchField();

$sqlw = "SELECT count(distinct woundnumber) as woundtotal 
          FROM {$wounds_table} 
         WHERE facilitycode = '$facilitycode'
           AND servicedate >= '$data_start' AND servicedate <= '$data_end'                
           AND unit = $unit 
       ";

$resultw = db_query($sqlw);
$woundsofunitmonth[] = $resultw->fetchField();
}
   
$units2 = implode(",", $units);
$unitsu =  substr($units2, 0,-3);
$patientsu = implode(",", $patientsofunitmonth);
$woundsu = implode(",", $woundsofunitmonth);

 //For pie chart.......................................
$sql = "SELECT count(type) as number, type FROM {$wounds_table} WHERE facilitycode = '$facilitycode' 
         AND servicedate >= '$data_start' AND servicedate <= '$data_end' GROUP BY type";    
 $resultt = db_query($sql);
 $sum = 0;
 $data = array();
foreach ($resultt as $row) {
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
  $pieType .= ","; 
  $pieNumber .= ",";    
}  
$pie .= "['$d[type]', $d[number]]";
$pieType .= "'$d[type]'";
$pieNumber .= "$d[number]";
$count++;
}

?>

<div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>

<div id="monthdetail" style="min-width: 400px; height: 400px; margin: 0 auto"></div>

<div id="monthdetailofpie" style="min-width: 400px; height: 400px; margin: 0 auto"></div>



<div id="overlay"></div>
<div id="confirmBox" onclick="toggleOverlay()">
<div class="message"></div>
<span class="button unit">UNIT</span>
<span class="button type">WOUND-TYPE</span>
</div>

<script type="text/javascript">
    
Highcharts.theme = {
colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
chart: {
backgroundColor: {
linearGradient: { x1: 0, y1: 0, x2: 1, y2: 1 },
stops: [
[0, 'rgb(255, 255, 255)'],
[1, 'rgb(240, 240, 255)']
]
},
borderWidth: 2,
plotBackgroundColor: 'rgba(255, 255, 255, .9)',
plotShadow: true,
plotBorderWidth: 1
},
title: {
style: {
color: '#000',
font: 'bold 16px "Trebuchet MS", Verdana, sans-serif'
}
},
subtitle: {
style: {
color: '#666666',
font: 'bold 12px "Trebuchet MS", Verdana, sans-serif'
}
},
xAxis: {
gridLineWidth: 1,
lineColor: '#000',
tickColor: '#000',
labels: {
style: {
color: '#000',
font: '11px Trebuchet MS, Verdana, sans-serif'
}
},
title: {
style: {
color: '#333',
fontWeight: 'bold',
fontSize: '12px',
fontFamily: 'Trebuchet MS, Verdana, sans-serif'

}
}
},
yAxis: {
minorTickInterval: 'auto',
lineColor: '#000',
lineWidth: 1,
tickWidth: 1,
tickColor: '#000',
labels: {
style: {
color: '#000',
font: '11px Trebuchet MS, Verdana, sans-serif'
}
},
title: {
style: {
color: '#333',
fontWeight: 'bold',
fontSize: '12px',
fontFamily: 'Trebuchet MS, Verdana, sans-serif'
}
}
},
legend: {
itemStyle: {
font: '9pt Trebuchet MS, Verdana, sans-serif',
color: 'black'

},
itemHoverStyle: {
color: '#039'
},
itemHiddenStyle: {
color: 'gray'
}
},
labels: {
style: {
color: '#99b'
}
},

navigation: {
buttonOptions: {
theme: {
stroke: '#CCCCCC'
}
}
}
};

// Apply the theme
var highchartsOptions = Highcharts.setOptions(Highcharts.theme);

function toggleOverlay(){
var overlay = document.getElementById('overlay');
var specialBox = document.getElementById('confirmBox');
overlay.style.opacity = .8;
if(overlay.style.display == "block"){
overlay.style.display = "none";
specialBox.style.display = "none";
} else {
overlay.style.display = "block";
specialBox.style.display = "block";
}
}
</script>
<style>


div#overlay {
display: none;
z-index: 2;
background: #000;
position: fixed;
width: 100%;
height: 100%;
top: 0px;
left: 0px;
}
body { font-family: sans-serif; }
#confirmBox {
background: none repeat scroll 0 0 #EEEEEE;
border: 1px solid #AAAAAA;
border-radius: 5px 5px 5px 5px;
display: none;
left: 42%;
padding: 6px 8px 8px;
position: fixed;
text-align: center;
top: 10%;
width: 22%;
 z-index: 9;
}
#confirmBox .button {
background-color: #CCCCCC;
border: 1px solid #AAAAAA;
border-radius: 3px 3px 3px 3px;
cursor: pointer;
display: inline-block;
font-size: 13px;
font-weight: bold;
padding: 4px;
text-align: center;
width: 100px;
}
#confirmBox .button:hover
{
background-color: #ddd;
}
#confirmBox .message {
margin-bottom: 8px;
margin-top: 12px;
text-align: center;
}
</style>


<script type="text/javascript">
$( "#monthdetail" ).hide();
$( "#monthdetailofpie" ).hide();
//document.getElementById("monthdetail").style.display = 'none';
//document.getElementById("monthdetailofpie").style.display = 'none';
function doConfirm(msg, unitFn, typeFn) {
var confirmBox = $("#confirmBox");
confirmBox.find(".message").text(msg);
confirmBox.find(".unit,.type").unbind().click(function () {
    confirmBox.hide();
});
confirmBox.find(".unit").click(unitFn);
confirmBox.find(".type").click(typeFn);
confirmBox.show();
}

$(function () {
var chart;
$(document).ready(function() {
var colors = Highcharts.getOptions().colors;
var p = [<?php echo $patient3; ?>]; 
var wn = [<?php echo $wound3; ?>];
var categories = [<?php echo $month; ?>];
name = 'Patients';
name2 = 'Wound_Number';
var sss;
sss = '';
var ss;
ss = ''; 
var Mycat;
Mycat = categories.length-1;

for(var i=Mycat; i >=0 ; i--){
ss = [{y:p[i]}];
if(i == Mycat) { data = ss;}
else { data = ss.concat(sss); }
sss = data; 
}
        
for(var i=Mycat; i >=0 ; i--){
ss =[{y:wn[i]}];
if(i == Mycat) { data2 = ss;}
else { data2 = ss.concat(sss); }
sss = data2; 
}        

chart = new Highcharts.Chart({
    chart: {
        renderTo: 'container'
    },
    title: {
        text: 'Report of facility <?php echo $facility;?> with month period'
    },
    xAxis: {
        categories: categories    
    },
    yAxis: {
        title: {
         text: 'Report of facility <?php echo $facility;?> with month period'
        }
    },
    plotOptions: {
    column: {
    cursor: 'pointer',        
          point: {
                events: {
                    click: function(event) {
                    //$( "#container" ).hide();  
                    //toggleOverlay(); 
                        //doConfirm('Select to look the unit and wound type reports of this month  '+ this.category+' ?', function unit() {
                        //REDIRECT     
                            $( "#summary_btn" ).show();
                            $( "#monthdetail" ).show();
                            $( "#monthdetailofpie" ).show();  
                            $( "#container_2" ).hide();
                            $( "#container_3" ).hide(); 
                            
                        //}, function type() {                                     
                        //REDIRECT
                            //$( "#monthdetail" ).hide();
                           // $( "#monthdetailofpie" ).show();
                        //});





                        var monthname =  this.category;
var data = 'nameofmonth='+monthname+'&facilitycode=<?php echo $facilitycode; ?>'+'&mode=<?php echo $mode;?>';
    $.ajax({
type: "GET",
url: "month.php",
data: data,
success:function(result){
     $("#monthdetailofpie").html(result);
      $("#monthdetail").html(result); 
        
}
});
                    }
                }
            }
    },
    pie: {
        allowPointSelect: true,
        dataLabels: {
            enabled: true,
            color: '#000000',
            connectorColor: '#000000',
            format: '<b>{point.name}</b>: {point.y:.1f}'
        },
        showInLegend: true
    }},
    tooltip: {
        useHTML: true,
          shared: true 
    },
    legend: {
    enabled: false,
    layout: 'vertical',
    align: 'right',
    verticalAlign: 'middle',
    pieSliceText:'value',
    labelFormatter: function() {
            return this.name;
    }
    },
    series: [{ 
    name: name, 
    color: '#8BBC21', 
    type: 'column', 
    data: data 
    }, 
    { 
    name: name2, 
    color: '#AA1919', 
    type: 'column', 
    data: data2 
    }],
    exporting: {
    enabled: true
    }
});
});
});

</script>

<?php }

else if($mode == "quarter") { 

while ($min_date <= $max_date) {
$min_date_year = date("Y", $min_date);
$min_date_month = date("m", $min_date);
$min_date_quarter = ceil($min_date_month/3);

if ($min_date_quarter == 1) {
$year_data_start = date("Y-1-1", $min_date);
$year_data_end = date("Y-3-31", $min_date);
$min_date_new = date("Y-4-1", $min_date);
$min_date_new = strtotime($min_date_new);
}
elseif ($min_date_quarter == 2) {
$year_data_start = date("Y-4-1", $min_date);
$year_data_end = date("Y-6-31", $min_date);
$min_date_new = date("Y-7-1", $min_date);      
$min_date_new = strtotime($min_date_new);    
}
elseif ($min_date_quarter == 3) {
$year_data_start = date("Y-7-1", $min_date);
$year_data_end = date("Y-9-31", $min_date);
$min_date_new = date("Y-10-1", $min_date);
$min_date_new = strtotime($min_date_new);    
}
elseif ($min_date_quarter == 4) {
$year_data_start = date("Y-10-1", $min_date);
$year_data_end = date("Y-12-31", $min_date);
$min_date_new = date("Y-1-1", $min_date);
$min_date_new = strtotime($min_date_new);
$min_date_new = strtotime("+1 YEAR", $min_date_new);
}

$x = "$min_date_year Q$min_date_quarter";
$xs[] = "'$x'";

$sql = "SELECT count(distinct patientcode) as patienttotal
          FROM {$wounds_table} 
         WHERE facilitycode = '$facilitycode'
           AND servicedate >= '$year_data_start' AND servicedate <= '$year_data_end'
       ";
$result = db_query($sql);
$patients[] = $result->fetchField();

$sql = "SELECT count(distinct woundnumber) as woundtotal 
          FROM {$wounds_table} 
         WHERE facilitycode = '$facilitycode'
           AND servicedate >= '$year_data_start' AND servicedate <= '$year_data_end'
       ";
$result = db_query($sql);
$wounds[] = $result->fetchField();
$min_date = $min_date_new;  
$i++;
}

$quarter = implode(",", $xs);
$patient3 = implode(",", $patients);
$wound3 = implode(",", $wounds);

//$units = array();
$sql = "SELECT distinct unit FROM {$wounds_table} WHERE facilitycode = '$facilitycode'";
$result = db_query($sql);
foreach ($result as $row){
$units[] = "'$row->unit'";
}

foreach ($units as $unit) {  
$sql = "SELECT count(distinct patientcode) as patienttotal
          FROM {$wounds_table} 
         WHERE facilitycode = '$facilitycode'
           AND servicedate >= '$data_start' AND servicedate <= '$data_end'               
           AND unit = $unit 
       ";
$result = db_query($sql);
$patientsofunityear[] = $result->fetchField();
  
$sqlw = "SELECT count(distinct woundnumber) as woundtotal 
          FROM {$wounds_table} 
         WHERE facilitycode = '$facilitycode'
           AND servicedate >= '$data_start' AND servicedate <= '$data_end'                
           AND unit = $unit 
       ";
$resultw = db_query($sqlw);
$woundsofunityear[] = $resultw->fetchField();
}
   
$units2 = implode(",", $units);
$unitsu =  substr($units2, 0,-3);
$patientsu = implode(",", $patientsofunityear);
$woundsu = implode(",", $woundsofunityear);

 //For pie chart.......................................
$sql = "SELECT count(type) as number, type FROM {$wounds_table} WHERE facilitycode = '$facilitycode' 
         AND servicedate >= '$data_start' AND servicedate <= '$data_end' GROUP BY type";    
 $resultt = db_query($sql);
$sum = 0;
$data = array();
foreach ($resultt as $row) {
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
$pieType .= ","; 
$pieNumber .= ",";    
}  
$pie .= "['$d[type]', $d[number]]";
$pieType .= "'$d[type]'";
$pieNumber .= "$d[number]";
$count++;
}
?>
<div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>

<div id="monthdetail" style="min-width: 400px; height: 400px; margin: 0 auto"></div>

<div id="monthdetailofpie" style="min-width: 400px; height: 400px; margin: 0 auto"></div>

<div id="overlay"></div>
<div id="confirmBox" onclick="toggleOverlay()">
<div class="message"></div>
<span class="button unit">UNIT</span>
<span class="button type">WOUND-TYPE</span>
</div>
<script type="text/javascript">
    
    
Highcharts.theme = {
colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
chart: {
backgroundColor: {
linearGradient: { x1: 0, y1: 0, x2: 1, y2: 1 },
stops: [
[0, 'rgb(255, 255, 255)'],
[1, 'rgb(240, 240, 255)']
]
},
borderWidth: 2,
plotBackgroundColor: 'rgba(255, 255, 255, .9)',
plotShadow: true,
plotBorderWidth: 1
},
title: {
style: {
color: '#000',
font: 'bold 16px "Trebuchet MS", Verdana, sans-serif'
}
},
subtitle: {
style: {
color: '#666666',
font: 'bold 12px "Trebuchet MS", Verdana, sans-serif'
}
},
xAxis: {
gridLineWidth: 1,
lineColor: '#000',
tickColor: '#000',
labels: {
style: {
color: '#000',
font: '11px Trebuchet MS, Verdana, sans-serif'
}
},
title: {
style: {
color: '#333',
fontWeight: 'bold',
fontSize: '12px',
fontFamily: 'Trebuchet MS, Verdana, sans-serif'
}
}
},
yAxis: {
minorTickInterval: 'auto',
lineColor: '#000',
lineWidth: 1,
tickWidth: 1,
tickColor: '#000',
labels: {
style: {
color: '#000',
font: '11px Trebuchet MS, Verdana, sans-serif'
}
},
title: {
style: {
color: '#333',
fontWeight: 'bold',
fontSize: '12px',
fontFamily: 'Trebuchet MS, Verdana, sans-serif'
}
}
},
legend: {
itemStyle: {
font: '9pt Trebuchet MS, Verdana, sans-serif',
color: 'black'

},
itemHoverStyle: {
color: '#039'
},
itemHiddenStyle: {
color: 'gray'
}
},
labels: {
style: {
color: '#99b'
}
},

navigation: {
buttonOptions: {
theme: {
stroke: '#CCCCCC'
}
}
}
};

// Apply the theme
var highchartsOptions = Highcharts.setOptions(Highcharts.theme);
function toggleOverlay(){
var overlay = document.getElementById('overlay');
var specialBox = document.getElementById('confirmBox');
overlay.style.opacity = .8;
if(overlay.style.display == "block"){
overlay.style.display = "none";
specialBox.style.display = "none";
} else {
overlay.style.display = "block";
specialBox.style.display = "block";
}
}
</script>
<style>
div#overlay {
display: none;
z-index: 2;
background: #000;
position: fixed;
width: 100%;
height: 100%;
top: 0px;
left: 0px;
text-align: center;
}
body { font-family: sans-serif; }
#confirmBox {
background: none repeat scroll 0 0 #EEEEEE;
border: 1px solid #AAAAAA;
border-radius: 5px 5px 5px 5px;
display: none;
left: 42%;
padding: 6px 8px 8px;
position: fixed;
text-align: center;
top: 10%;
width: 26%;
 z-index: 9;
}
#confirmBox .button {
background-color: #CCCCCC;
border: 1px solid #AAAAAA;
border-radius: 3px 3px 3px 3px;
cursor: pointer;
display: inline-block;
font-size: 13px;
font-weight: bold;
padding: 4px;
text-align: center;
width: 100px;
}
#confirmBox .button:hover
{
background-color: #ddd;
}
#confirmBox .message {
margin-bottom: 8px;
margin-top: 12px;
text-align: center;
}
</style>

<script type="text/javascript">
$( "#monthdetail" ).hide();
$( "#monthdetailofpie" ).hide();
function doConfirm(msg, unitFn, typeFn) {
var confirmBox = $("#confirmBox");
confirmBox.find(".message").text(msg);
confirmBox.find(".unit,.type").unbind().click(function () {
confirmBox.hide();
});
confirmBox.find(".unit").click(unitFn);
confirmBox.find(".type").click(typeFn);
confirmBox.show();
}

$(function () {
var chart;
$(document).ready(function() {
var colors = Highcharts.getOptions().colors;
var p = [<?php echo $patient3; ?>]; 
var wn = [<?php echo $wound3; ?>];
var categories = [<?php echo $quarter; ?>];
name = 'Patients';
name2 = 'Wound_Number';
var sss;
sss = '';
var ss;
ss = ''; 
var Mycat;
Mycat = categories.length-1;
for(var i=Mycat; i >=0 ; i--){
ss = [{y:p[i]}];
if(i == Mycat) { data = ss;}
else { data = ss.concat(sss); }
sss = data; 
}
        
for(var i=Mycat; i >=0 ; i--){
ss = [{y:wn[i]}];
if(i == Mycat) { data2 = ss;}
else { data2 = ss.concat(sss); }
sss = data2; 
}
   
chart = new Highcharts.Chart({
    chart: {
        renderTo: 'container'
    },
    title: {
        text: 'Report of facility <?php echo $facility;?> with Quarter period'
    },
    xAxis: {
        categories: categories
    },
    yAxis: {
        title: {
         text: 'Report of facility <?php echo $facility;?> with Quarter period'
        }
    },
    plotOptions: {
    column: {
        cursor: 'pointer',
            point: {
                events: {
                    click: function(event) {
                    //$( "#container" ).hide();  
                    toggleOverlay(); 
                        doConfirm('Select to look the unit and wound type reports of this month  '+ this.category+' ?', function unit() {
                        //REDIRECT                      
                            $( "#monthdetail" ).show();
                            $( "#monthdetailofpie" ).hide();                     
                        }, function type() {                                     
                        //REDIRECT
                            $( "#monthdetail" ).hide();
                            $( "#monthdetailofpie" ).show();
                        });
                        
                        var monthname =  this.category;
var data = 'nameofmonth='+monthname+'&facilitycode=<?php echo $facilitycode; ?>'+'&mode=<?php echo $mode;?>';
        $.ajax({
type: "GET",
url: "month.php",
data: data,
success:function(result){
     $("#monthdetailofpie").html(result);
      $("#monthdetail").html(result);
}
});
                    }
                }
            }
         },
        pie: {
        allowPointSelect: true,
        dataLabels: {
        enabled: true,
        color: '#000000',
        connectorColor: '#000000',
        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
        },
        showInLegend: true
        }},
        tooltip: {
            useHTML: true,
              shared: true 
        },
        legend: {
        enabled: false,
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle',
        pieSliceText:'value',
        labelFormatter: function() {
                return this.name;
        }
        },
        series: [{ 
        name: name, 
        color: '#8BBC21', 
        type: 'column', 
        data: data 
        }, 
        { 
        name: name2, 
        color: '#AA1919', 
        type: 'column', 
        data: data2 
        }],
        exporting: {
        enabled: true
        }
});
});
});

</script>
<?php }

else if ($mode == "year") {    
while ($min_date <= $max_date) {
$min_date_new = strtotime("+1 YEAR", $min_date);
$years_data_start = date("Y-1-1", $min_date);
$years_data_end = date("Y-12-31", $min_date); 
$x = date("Y", $min_date);
$xs[] = "'$x'";
  
$sql = "SELECT count(distinct patientcode) as patienttotal
          FROM {$wounds_table} 
         WHERE facilitycode = '$facilitycode'
           AND servicedate >= '$years_data_start' AND servicedate <= '$years_data_end'
       ";  
$result = db_query($sql);
$patients[] = $result->fetchField();
  
$sql = "SELECT count(distinct woundnumber) as woundtotal 
          FROM {$wounds_table} 
         WHERE facilitycode = '$facilitycode'
           AND servicedate >= '$years_data_start' AND servicedate <= '$years_data_end'
       ";  
$result = db_query($sql);
$wounds[] = $result->fetchField(); 
$min_date = $min_date_new;
$i++;
}
     
$years = implode(",", $xs);
$patient3 = implode(",", $patients);
$wound3 = implode(",", $wounds);

 //$units = array();
$sql = "SELECT distinct unit FROM {$wounds_table} WHERE facilitycode = '$facilitycode'";
$result = db_query($sql);
foreach ($result as $row) {
  $units[] = "'$row->unit'";
}
//echo "<P>DATA<PRE>";print_r($units3);echo "</PRE>";

foreach ($units as $unit) {  
$sql = "SELECT count(distinct patientcode) as patienttotal
          FROM {$wounds_table} 
         WHERE facilitycode = '$facilitycode'
           AND servicedate >= '$data_start' AND servicedate <= '$data_end'               
           AND unit = $unit 
       ";
$result = db_query($sql);
$patientsofunityears[] = $result->fetchField();
  
$sqlw = "SELECT count(distinct woundnumber) as woundtotal 
          FROM {$wounds_table} 
         WHERE facilitycode = '$facilitycode'
           AND servicedate >= '$data_start' AND servicedate <= '$data_end'                
           AND unit = $unit 
       "; 
$resultw = db_query($sqlw);
$woundsofunityears[] = $resultw->fetchField();
}   
$units2 = implode(",", $units);
$unitsu =  substr($units2, 0,-3);
$patientsu = implode(",", $patientsofunityears);
$woundsu = implode(",", $woundsofunityears);

 //For pie chart.......................................
$sql = "SELECT count(type) as number, type FROM {$wounds_table} WHERE facilitycode = '$facilitycode' 
         AND servicedate >= '$data_start' AND servicedate <= '$data_end' GROUP BY type";    
$resultt = db_query($sql);
$sum = 0;
$data = array();
foreach ($resultt as $row) {
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
$pieType .= ","; 
$pieNumber .= ",";    
}  
$pie .= "['$d[type]', $d[number]]";
$pieType .= "'$d[type]'";
$pieNumber .= "$d[number]";
$count++;
}
   
?>
<div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>

<div id="monthdetail" style="min-width: 400px; height: 400px; margin: 0 auto"></div>

<div id="monthdetailofpie" style="min-width: 400px; height: 400px; margin: 0 auto"></div>

<div id="overlay"></div>
<div id="confirmBox" onclick="toggleOverlay()">
<div class="message"></div>
<span class="button unit">UNIT</span>
<span class="button type">WOUND-TYPE</span>
</div>

<script type="text/javascript">
    
Highcharts.theme = {
colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
chart: {
backgroundColor: {
linearGradient: { x1: 0, y1: 0, x2: 1, y2: 1 },
stops: [
[0, 'rgb(255, 255, 255)'],
[1, 'rgb(240, 240, 255)']
]
},
borderWidth: 2,
plotBackgroundColor: 'rgba(255, 255, 255, .9)',
plotShadow: true,
plotBorderWidth: 1
},
title: {
style: {
color: '#000',
font: 'bold 16px "Trebuchet MS", Verdana, sans-serif'
}
},
subtitle: {
style: {
color: '#666666',
font: 'bold 12px "Trebuchet MS", Verdana, sans-serif'
}
},
xAxis: {
gridLineWidth: 1,
lineColor: '#000',
tickColor: '#000',
labels: {
style: {
color: '#000',
font: '11px Trebuchet MS, Verdana, sans-serif'
}
},
title: {
style: {
color: '#333',
fontWeight: 'bold',
fontSize: '12px',
fontFamily: 'Trebuchet MS, Verdana, sans-serif'

}
}
},
yAxis: {
minorTickInterval: 'auto',
lineColor: '#000',
lineWidth: 1,
tickWidth: 1,
tickColor: '#000',
labels: {
style: {
color: '#000',
font: '11px Trebuchet MS, Verdana, sans-serif'
}
},
title: {
style: {
color: '#333',
fontWeight: 'bold',
fontSize: '12px',
fontFamily: 'Trebuchet MS, Verdana, sans-serif'
}
}
},
legend: {
itemStyle: {
font: '9pt Trebuchet MS, Verdana, sans-serif',
color: 'black'

},
itemHoverStyle: {
color: '#039'
},
itemHiddenStyle: {
color: 'gray'
}
},
labels: {
style: {
color: '#99b'
}
},

navigation: {
buttonOptions: {
theme: {
stroke: '#CCCCCC'
}
}
}
};

// Apply the theme
var highchartsOptions = Highcharts.setOptions(Highcharts.theme);

function toggleOverlay(){
var overlay = document.getElementById('overlay');
var specialBox = document.getElementById('confirmBox');
overlay.style.opacity = .8;
if(overlay.style.display == "block"){
overlay.style.display = "none";
specialBox.style.display = "none";
} else {
overlay.style.display = "block";
specialBox.style.display = "block";
}
}
</script>
<style>
div#overlay {
display: none;
z-index: 2;
background: #000;
position: fixed;
width: 100%;
height: 100%;
top: 0px;
left: 0px;
text-align: center;
}
body { font-family: sans-serif; }
#confirmBox {
background: none repeat scroll 0 0 #EEEEEE;
border: 1px solid #AAAAAA;
border-radius: 5px 5px 5px 5px;
display: none;
left: 42%;
padding: 6px 8px 8px;
position: fixed;
text-align: center;
top: 10%;
width: 22%;
 z-index: 9;
}
#confirmBox .button {
background-color: #CCCCCC;
border: 1px solid #AAAAAA;
border-radius: 3px 3px 3px 3px;
cursor: pointer;
display: inline-block;
font-size: 13px;
font-weight: bold;
padding: 4px;
text-align: center;
width: 100px;
}
#confirmBox .button:hover
{
background-color: #ddd;
}
#confirmBox .message {
margin-bottom: 8px;
margin-top: 12px;
text-align: center;
}
</style>


<script type="text/javascript">
$( "#monthdetail" ).hide();
$( "#monthdetailofpie" ).hide();
function doConfirm(msg, unitFn, typeFn) {
var confirmBox = $("#confirmBox");
confirmBox.find(".message").text(msg);
confirmBox.find(".unit,.type").unbind().click(function () {
    confirmBox.hide();
});
confirmBox.find(".unit").click(unitFn);
confirmBox.find(".type").click(typeFn);
confirmBox.show();
}

$(function () {
var chart;
$(document).ready(function() {   
var colors = Highcharts.getOptions().colors;
var p = [<?php echo $patient3; ?>]; 
var wn = [<?php echo $wound3; ?>];
var categories = [<?php echo $years; ?>];
name = 'Patients';
name2 = 'Wound_Number';

var sss;
sss = '';
var ss;
ss = ''; 
var Mycat;
Mycat = categories.length-1;
for(var i=Mycat; i >=0 ; i--){
ss = [{y:p[i]}];
if(i == Mycat) { data = ss;}
else { data = ss.concat(sss); }
sss = data; 
}
        
for(var i=Mycat; i >=0 ; i--){
ss = [{y:wn[i]}];
if(i == Mycat) { data2 = ss;}
else { data2 = ss.concat(sss); }
sss = data2; 
}

chart = new Highcharts.Chart({
    chart: {
        renderTo: 'container'
    },
    title: {
        text: 'Report of facility <?php echo $facility;?> with Year period'
    },
    xAxis: {
        categories: categories
    },
    yAxis: {
        title: {
         text: 'Report of facility <?php echo $facility;?> with Year period'
        }
    },
    plotOptions: {
    column: {
        cursor: 'pointer',
              point: {
                events: {
                    click: function(event) {
                   // $( "#container" ).hide();  
                    toggleOverlay(); 
                        doConfirm('Select to look the unit and wound type reports of this month  '+ this.category+' ?', function unit() {
                        //REDIRECT                      
                            $( "#monthdetail" ).show();
                            $( "#monthdetailofpie" ).hide();                     
                        }, function type() {                                     
                        //REDIRECT
                            $( "#monthdetail" ).hide();
                            $( "#monthdetailofpie" ).show();
                        });
                        
                        var monthname =  this.category;
var data = 'nameofmonth='+monthname+'&facilitycode=<?php echo $facilitycode; ?>'+'&mode=<?php echo $mode;?>';
        $.ajax({
type: "GET",
url: "month.php",
data: data,
success:function(result){
     $("#monthdetailofpie").html(result);
      $("#monthdetail").html(result);
}
});
                    }
                }
            }
         },
    pie: {
    allowPointSelect: true,
    dataLabels: {
    enabled: true,
    color: '#000000',
    connectorColor: '#000000',
    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
    },
    showInLegend: true
    }},
    tooltip: {
        useHTML: true,
          shared: true 
    },
    legend: {
    enabled:false,
    layout: 'vertical',
    align: 'right',
    verticalAlign: 'middle',
    pieSliceText:'value',
    labelFormatter: function() {
            return this.name;
    }
    },
    series: [{ 
    name: name, 
    color: '#8BBC21', 
    type: 'column', 
    data: data 
    }, 
    { 
    name: name2, 
    color: '#AA1919', 
    type: 'column', 
    data: data2 
    }],
    exporting: {
    enabled: true
    }
});
});
});

</script>
  <?php }
else{ echo "<h2>Please select facilities,date and period for Chart.</h2>";}  
  
  
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////   
  
  

  $container_id = 0;

  // patient number and wound number on period
  $ipt = array();
  $ipt['debug'] = FALSE;
  $ipt['facilitycode'] = $facilitycode;
  $ipt['mode'] = $mode;
  $container_id += 1;
  $ipt['container_id'] = "container_$container_id";
  $ipt['startyear'] = $startyear;
  $ipt['startmonth'] = $startmonth;
  $ipt['startdt'] = $startdt;  
  $ipt['endyear'] = $endyear;
  $ipt['endmonth'] = $endmonth;
  $ipt['enddt'] = $enddt; 
  // $ret = mi_report_patient_wound($ipt); 

  // patient number and wound number on unit
  $ipt = array();
  $ipt['debug'] = FALSE;
  $ipt['facilitycode'] = $facilitycode;
  $ipt['mode'] = $mode;
  $container_id += 1;
  $ipt['container_id'] = "container_$container_id";
  $ipt['startyear'] = $startyear;
  $ipt['startmonth'] = $startmonth;
  $ipt['startdt'] = $startdt;  
  $ipt['endyear'] = $endyear;
  $ipt['endmonth'] = $endmonth;
  $ipt['enddt'] = $enddt; 
  $ret = mi_report_patient_wound_unit($ipt);  

  // wound type
  $ipt = array();
  $ipt['debug'] = FALSE;
  $container_id += 1;
  $ipt['container_id'] = "container_$container_id";
  $ipt['facilitycode'] = $facilitycode;
  $ipt['startyear'] = $startyear;
  $ipt['startmonth'] = $startmonth;
  $ipt['startdt'] = $startdt;
  $ipt['endyear'] = $endyear;
  $ipt['endmonth'] = $endmonth;
  $ipt['enddt'] = $enddt;
  $ret = mi_report_wound_type ($ipt);

} // if ($_REQUEST['act'] == "build")
?>

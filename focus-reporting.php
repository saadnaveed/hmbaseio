<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

function startsWith($haystack, $needle)
{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}

$current_user = wp_get_current_user();
$username = $current_user->user_login;
$userID = 0;
$special = '<center><div style="color: white; width: 300px; background-color: rgba(255, 0, 0, 0.6); padding: 5px; font-size: 11px;">'.do_shortcode('[icon name="fa-exclamation-triangle"]').'<i> We have a new question of the Month: <b>IF you could add a new feature to homebase, what would it be?</b> (<a href="https://docs.google.com/forms/d/e/1FAIpQLSeOuugdw7fVeu9FGwJoylsbAKiIO33OEkRb0NV32T9qkA5mQA/viewform" target="_blank">Submit Form</a>)</i></div></center>';

$table = TablePress::$model_table->load( 4, true, false );

$totalAgents = count($table['data']);
$colTimes = count($table['data'][2]);
$colTimesRowStart = $table['data'][2];

for ($i = 3; $i < $totalAgents; $i++) {
	if (strtolower($table['data'][$i][0]) == strtolower($username)) {
		$userID = $i;
	}
}

$date = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
$date->setTimeZone(new DateTimeZone('America/Chicago'));
$currentHour = $date->format('G');
$lastUpdated = $date->format('g:i a');
$dayOfWeek = $date->format('D');

$tableTimes = array (
							'8' => '8a',
							'9' => '9a',
							'10' => '10a',
							'11' => '11a',
							'12' => '12p',
							'13' => '1p',
							'14' => '2p',
							'15' => '3p',
							'16' => '4p',
							'17' => '5p',
							'18' => '6p',
							'19' => '7p',
							'8a' => '8',
							'9a' => '9',
							'10a' => '10',
							'11a' => '11',
							'12p' => '12',
							'1p' => '13',
							'2p' => '14',
							'3p' => '15',
							'4p' => '16',
							'5p' => '17',
							'6p' => '18',
							'7p' => '19',
);

$agentExt = array (
							'saad' => '1000',
							'mariam' => '1004',
							'david' => '1009',
							'ryan' => '1013',
							'cindy' => '1017',
							'ciara' => '1018',
							'alexander' => '1023',
							'chris' => '1024',
							'liza' => '1029',
							'rosvy' => '1031',
							'molly' => '1036',
							'brandon' => '1037',
							'cat' => '1039',
							'doc' => '1041',
							'daveen' => '1042',
							'kyle' => '1045',
							'katarina' => '1046',
							'bridgette' => '1049',
							'connie' => '1051',
							'dexter' => '1053',
							'daniel' => '1054',
							'missy' => '1056',
							'rachel' => '1001',
);
	
if ($userID != 0) {

	echo '<div style="background-color: #8857ac; color: white; padding: 5px;"><strong>'.do_shortcode('[icon name="fa-sun-o"]').' How\'s my day looking? '. $table['data'][$userID][1] .'pm</strong></div>';

	echo '<div style="padding-left: 20px; padding-top: 10px; margin-top: 0px; margin-bottom: 10px; background-color: #fcf7fc"><h3>Hi, ' .$username. '! Welcome back :) </h3><br />';

	//print("<pre>".print_r($table['data'][$userID],true)."</pre>");
	//print_r(array_count_values($table['data'][$userID]));

	// Print Today's Shift Time
	//echo "Today you're working from: ";
	//echo $table['data'][$userID][1] .'pm <br />';
	
	$current_date = $date->format("Y-m-d H:i:s");
	$shift_date = $date->format("Y-m-d");
	
	for ($i = 3; $i < $totalAgents; $i++) {
		
		// First check to see if there is already an entry for the day
		$focus = $wpdb->get_row( "SELECT * FROM cs_focus WHERE agent_name = '". $table['data'][$i][0]."' AND shift_date = '". $shift_date ." 00:00:00'");
		
		// Insert into DB if brand new day
		if ($table['data'][$i][0] != '' && $table['data'][$i][1] != '' && !$focus) {
			$wpdb->insert('cs_focus', array(
				'agent_name' => strtolower($table['data'][$i][0]),
				'shift_date' => $shift_date,
				'shift_time' => $table['data'][$i][1],
				'focus_8am' => $table['data'][$i][3],
				'focus_9am' => $table['data'][$i][4],
				'focus_10am' => $table['data'][$i][5],
				'focus_11am' => $table['data'][$i][6],
				'focus_12pm' => $table['data'][$i][7],
				'focus_1pm' => $table['data'][$i][8],
				'focus_2pm' => $table['data'][$i][9],
				'focus_3pm' => $table['data'][$i][10],
				'focus_4pm' => $table['data'][$i][11],
				'focus_5pm' => $table['data'][$i][12],
				'focus_6pm' => $table['data'][$i][13],
				'focus_7pm' => $table['data'][$i][14],
				'date_created' => $current_date,
				'updated' => 0,
			));
		}
		// TODO: only update every x minutes
		/* else if ($focus && $focus->agent_name == strtolower($table['data'][$i][0])) {
			$wpdb->query("UPDATE cs_focus SET 
			focus_8am = '".$table['data'][$i][3]."',
			focus_9am = '".$table['data'][$i][4]."',
			focus_10am = '".$table['data'][$i][5]."',
			focus_11am = '".$table['data'][$i][6]."',
			focus_12pm = '".$table['data'][$i][8]."',
			focus_1pm = '".$table['data'][$i][8]."',
			focus_2pm = '".$table['data'][$i][9]."',
			focus_3pm = '".$table['data'][$i][10]."',
			focus_4pm = '".$table['data'][$i][11]."',
			focus_5pm = '".$table['data'][$i][12]."',
			focus_6pm = '".$table['data'][$i][13]."',
			focus_7pm = '".$table['data'][$i][14]."',
			updated = '1'
			WHERE agent_name = '". $table['data'][$i][0]."' AND shift_date = '". $shift_date ." 00:00:00'");
		} */
	
	}
	
	echo '<h1>Your stats for today:</h1> <br><br>';
	
	$focusToday = $wpdb->get_row( "SELECT * FROM cs_focus WHERE agent_name = '".$username."' AND shift_date = '". $shift_date ." 00:00:00'", ARRAY_N);
	
	//print_r($focus);
	
	$totalHoursToday = 0;
	
	for ($i = 4; $i < 16; $i++) {
		if ($focusToday[$i] != '') {
			$totalHoursToday++;
		}
	}
	
	$IBHoursToday = 0;
	
	for ($i = 4; $i < 16; $i++) {
		if (startsWith($focusToday[$i], 'IB/')) {
			$IBHoursToday++;
		}
	}
	
	$percentIB = ($IBHoursToday / $totalHoursToday) * 100;
	
	echo '% you spent on IB today: '.$percentIB.'%<br>';
	
	$ICHoursToday = 0;
	
	for ($i = 4; $i < 16; $i++) {
		if (startsWith($focusToday[$i], 'IC/')) {
			$ICHoursToday++;
		}
	}
	
	$percentIC = ($ICHoursToday / $totalHoursToday) * 100;
	
	echo '% you spent on IC today: '.$percentIC.'%<br>';
	
	$OtherHoursToday = 0;
	
	for ($i = 4; $i < 16; $i++) {
		if (!startsWith($focusToday[$i], 'IC/') && !startsWith($focusToday[$i], 'IB/') && !startsWith($focusToday[$i], 'ZD/') && $focusToday[$i] != '') {
			$OtherHoursToday++;
		}
	}
	
	$percentOther = ($OtherHoursToday / $totalHoursToday) * 100;
	
	echo '% you spent on other stuff today: '.$percentOther.'%<br>';
	
	echo '<h1>Your stats since start:</h1> <br><br>';
	
	$focusSinceStart = $wpdb->get_results( "SELECT * FROM cs_focus WHERE agent_name = '".$username."' AND shift_date <= '". $shift_date ." 00:00:00'", ARRAY_N);
	
	$totalHoursStart = 0;
	$ICHoursStart = 0;
	$IBHoursStart = 0;
	$OtherHoursStart = 0;
	$percentIBStart = 0;
	$percentICStart = 0;
	$percentOtherStart = 0;
	
	 foreach( $focusSinceStart as $focus ) {

        for ($i = 4; $i < 16; $i++) {
			if ($focus[$i] != '') {
				$totalHoursStart++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focus[$i], 'IB/')) {
				$IBHoursStart++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focus[$i], 'IC/')) {
				$ICHoursStart++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if (!startsWith($focus[$i], 'IC/') && !startsWith($focus[$i], 'IB/') && !startsWith($focus[$i], 'ZD/') && $focus[$i] != '') {
				$OtherHoursStart++;
			}
		}
    }
	
	/*echo $totalHoursStart."<br>";
	echo $ICHoursStart."<br>";
	echo $IBHoursStart."<br>";
	echo $OtherHoursStart."<br>";
	echo $percentIBStart."<br>";
	echo $percentICStart."<br>";
	echo $percentOtherStart."<br>"; */
	
	$percentIBStart = number_format((float)(($IBHoursStart / $totalHoursStart) * 100), 2, '.', '');
	$percentICStart = number_format((float)(($ICHoursStart / $totalHoursStart) * 100), 2, '.', '');
	$percentOtherStart = number_format((float)(($OtherHoursStart / $totalHoursStart) * 100), 2, '.', '');
	
	echo '% you spent on IB since start: '.$percentIBStart.'%<br>';
	echo '% you spent on IC since start: '.$percentICStart.'%<br>';
	echo '% you spent on Other Stuff since start: '.$percentOtherStart.'%<br>';
	
	echo '<br /><center><p><i><span style="color: black; font-size: 11px;">Page Last Updated: '. $lastUpdated .'</span></i></p></center><br />';

	echo '</div>';

}

echo '<div style="background-color: #8857ac; color: white; padding: 5px;"><strong>'.do_shortcode('[icon name="fa-search-plus"]').' CS Quick Glance</strong></div>';

echo '<div style="padding-left: 30px; margin-top: 0px; padding-top: 10px; padding-bottom: 10px; background-color: #fcf7fc;"><h1>CS stats for today:</h1> <br><br>';
	
	$focusCSSinceToday = $wpdb->get_results( "SELECT * FROM cs_focus WHERE shift_date = '". $shift_date ." 00:00:00'", ARRAY_N);
	
	$CS_totalHoursToday = 0;
	$CS_ICHoursToday = 0;
	$CS_IBHoursToday= 0;
	$CS_ZDHoursToday = 0;
	$CS_OtherHoursToday = 0;
	$CS_percentIBToday = 0;
	$CS_percentICToday = 0;
	$CS_percentOtherToday = 0;
	$CS_percentZDToday = 0;
	
	 foreach( $focusCSSinceToday as $focus ) {

        for ($i = 4; $i < 16; $i++) {
			if ($focus[$i] != '' && $focus[$i] != 'TM' && $focus[$i] != 'LNCH') {
				$CS_totalHoursToday++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focus[$i], 'IB/')) {
				//echo $focus[$i]."<br />";
				$CS_IBHoursToday++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focus[$i], 'IC/')) {
				$CS_ICHoursToday++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focus[$i], 'ZD/')) {
				$CS_ZDHoursToday++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if (!startsWith($focus[$i], 'IC/') && !startsWith($focus[$i], 'IB/') && !startsWith($focus[$i], 'ZD/') && $focus[$i] != '' && $focus[$i] != 'TM' && $focus[$i] != 'LNCH') {
				//echo $focus[$i]."<br />";
				$CS_OtherHoursToday++;
			}
		}
    }
	
	/* echo $CS_totalHoursToday."<br>";
	echo $CS_ICHoursToday."<br>";
	echo $CS_IBHoursToday."<br>";
	echo $CS_ZDHoursToday."<br>";
	echo $CS_OtherHoursToday."<br>";
	echo $CS_percentIBToday."<br>";
	echo $CS_percentICToday."<br>";
	echo $CS_percentOtherToday."<br>";
	echo $CS_percentZDToday."<br>"; */
	
	$CS_percentIBToday = number_format((float)(($CS_IBHoursToday / $CS_totalHoursToday) * 100), 2, '.', '');
	$CS_percentICToday = number_format((float)(($CS_ICHoursToday / $CS_totalHoursToday) * 100), 2, '.', '');
	$CS_percentOtherToday = number_format((float)(($CS_OtherHoursToday / $CS_totalHoursToday) * 100), 2, '.', '');
	$CS_percentZDToday = number_format((float)(($CS_ZDHoursToday / $CS_totalHoursToday) * 100), 2, '.', '');
	
	echo '% CS spent on IB today: '.$CS_percentIBToday.'%<br>';
	echo '% CS spent on ZD today: '.$CS_percentZDToday.'%<br>';
	echo '% CS spent on IC today: '.$CS_percentICToday.'%<br>';
	echo '% CS spent on Other Stuff today: '.$CS_percentOtherToday.'%<br>';
	
	echo '<h1>CS stats since start:</h1> <br><br>';
	
	$focusCSSinceStart = $wpdb->get_results( "SELECT * FROM cs_focus WHERE shift_date <= '". $shift_date ." 00:00:00'", ARRAY_N);
	
	$CS_totalHoursStart = 0;
	$CS_ICHoursStart = 0;
	$CS_IBHoursStart= 0;
	$CS_ZDHoursStart = 0;
	$CS_OtherHoursStart = 0;
	$CS_percentIBStart = 0;
	$CS_percentICStart = 0;
	$CS_percentOtherStart = 0;
	$CS_percentZDStart = 0;
	
	 foreach( $focusCSSinceStart as $focus ) {

        for ($i = 4; $i < 16; $i++) {
			if ($focus[$i] != '' && $focus[$i] != 'TM' && $focus[$i] != 'LNCH') {
				$CS_totalHoursStart++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focus[$i], 'IB/')) {
				//echo $focus[$i]."<br />";
				$CS_IBHoursStart++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focus[$i], 'IC/')) {
				$CS_ICHoursStart++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focus[$i], 'ZD/')) {
				$CS_ZDHoursStart++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if (!startsWith($focus[$i], 'IC/') && !startsWith($focus[$i], 'IB/') && !startsWith($focus[$i], 'ZD/') && $focus[$i] != '' && $focus[$i] != 'TM' && $focus[$i] != 'LNCH') {
				//echo $focus[$i]."<br />";
				$CS_OtherHoursStart++;
			}
		}
    }
	
	/* echo $CS_totalHoursStart."<br>";
	echo $CS_ICHoursStart."<br>";
	echo $CS_IBHoursStart."<br>";
	echo $CS_ZDHoursStart."<br>";
	echo $CS_OtherHoursStart."<br>";
	echo $CS_percentIBStart."<br>";
	echo $CS_percentICStart."<br>";
	echo $CS_percentOtherStart."<br>";
	echo $CS_percentZDStart."<br>"; */
	
	$CS_percentIBStart = number_format((float)(($CS_IBHoursStart / $CS_totalHoursStart) * 100), 2, '.', '');
	$CS_percentICStart = number_format((float)(($CS_ICHoursStart / $CS_totalHoursStart) * 100), 2, '.', '');
	$CS_percentOtherStart = number_format((float)(($CS_OtherHoursStart / $CS_totalHoursStart) * 100), 2, '.', '');
	$CS_percentZDStart = number_format((float)(($CS_ZDHoursStart / $CS_totalHoursStart) * 100), 2, '.', '');
	
	echo '% CS spent on IB since start: '.$CS_percentIBStart.'%<br>';
	echo '% CS spent on ZD since start: '.$CS_percentZDStart.'%<br>';
	echo '% CS spent on IC since start: '.$CS_percentICStart.'%<br>';
	echo '% CS spent on Other Stuff since start: '.$CS_percentOtherStart.'%<br>';

// Total number of people currently on Inbound
$totalIB = 0;

for ($i = 3; $i < $totalAgents; $i++) {
	for ($j = 0; $j < $colTimes; $j++) {
		if (startsWith($table['data'][$i][$j], 'IB/') && $colTimesRowStart[$j] == $tableTimes[$currentHour]) {
			$totalIB++;
		}
	}
}

echo '<ul><li>'.do_shortcode('[icon name="fa-phone"]').' Agents currently on IB: <strong>'. $totalIB. '</strong>';


if ($totalIB > 0) {
	echo '<ol>';
	for ($i = 3; $i < $totalAgents; $i++) {
		for ($j = 0; $j < $colTimes; $j++) {
			if (startsWith($table['data'][$i][$j], 'IB/') && $colTimesRowStart[$j] == $tableTimes[$currentHour]) {
				echo '<li>'. $table['data'][$i][0].' <span style="font-size: 9px;"><i>(x'.$agentExt[strtolower($table['data'][$i][0])].')</i></span></li>';
			}
		}
	}
	echo '</ol>';
	
}
echo '</li><br />';

// Total number of people currently on Zendesk
$totalZD = 0;

for ($i = 0; $i <= $totalAgents; $i++) {
	for ($j = 0; $j < $colTimes; $j++) {
		if (startsWith($table['data'][$i][$j], 'ZD/') && $colTimesRowStart[$j] == $tableTimes[$currentHour]) {
			$totalZD++;
		}
	}
}

echo '<li>'.do_shortcode('[icon name="fa-envelope"]').' Agents currently on ZD: <strong>'. $totalZD. '</strong>';

if ($totalZD > 0) {
	echo '<ol>';
	for ($i = 3; $i < $totalAgents; $i++) {
		for ($j = 0; $j < $colTimes; $j++) {
			if (startsWith($table['data'][$i][$j], 'ZD/') && $colTimesRowStart[$j] == $tableTimes[$currentHour]) {
				echo '<li>'. $table['data'][$i][0].'</li>';
			}
		}
	}
	echo '</ol>';
	
}
echo '</li><br />';

// Total number of people currently on Intercom
$totalIC = 0;

for ($i = 3; $i < $totalAgents; $i++) {
	for ($j = 0; $j < $colTimes; $j++) {
		if (startsWith($table['data'][$i][$j], 'IC/') && $colTimesRowStart[$j] == $tableTimes[$currentHour]) {
			$totalIC++;
		}
	}
}

echo '<li>'.do_shortcode('[icon name="fa-comment"]').' Agents currently on IC: <strong>'. $totalIC. '</strong>';

if ($totalIC > 0) {
	echo '<ol>';
	for ($i = 3; $i < $totalAgents; $i++) {
		for ($j = 0; $j < $colTimes; $j++) {
			if (startsWith($table['data'][$i][$j], 'IC/') && $colTimesRowStart[$j] == $tableTimes[$currentHour]) {
				echo '<li>'. $table['data'][$i][0].'</li>';
			}
		}
	}
	echo '</ol>';
	
}
echo '</li><br />';

// Total number of people currently on Hiring
$totalHiring = 0;

for ($i = 3; $i < $totalAgents; $i++) {
	for ($j = 0; $j < $colTimes; $j++) {
		if (startsWith($table['data'][$i][$j], 'H/') && $colTimesRowStart[$j] == $tableTimes[$currentHour]) {
			$totalHiring++;
		}
	}
}

echo '<li>'.do_shortcode('[icon name="fa-globe"]').' Agents currently on Hiring: <strong>'. $totalHiring. '</strong>';

if ($totalHiring > 0) {
	echo '<ol>';
	for ($i = 3; $i < $totalAgents; $i++) {
		for ($j = 0; $j < $colTimes; $j++) {
			if (startsWith($table['data'][$i][$j], 'H/') && $colTimesRowStart[$j] == $tableTimes[$currentHour]) {
				echo '<li>'. $table['data'][$i][0].'</li>';
			}
		}
	}
	echo '</ol>';
	
}
echo '</li><br />';

// Total number of people currently on Activation
$totalACT = 0;

for ($i = 3; $i < $totalAgents; $i++) {
	for ($j = 0; $j < $colTimes; $j++) {
		if (startsWith($table['data'][$i][$j], 'ACT') && $colTimesRowStart[$j] == $tableTimes[$currentHour]) {
			$totalACT++;
		}
	}
}

echo '<li>'.do_shortcode('[icon name="fa-handshake-o"]').' Agents currently on ACT: <strong>'. $totalACT. '</strong>';

if ($totalACT > 0) {
	echo '<ol>';
	for ($i = 3; $i < $totalAgents; $i++) {
		for ($j = 0; $j < $colTimes; $j++) {
			if (startsWith($table['data'][$i][$j], 'ACT') && $colTimesRowStart[$j] == $tableTimes[$currentHour]) {
				echo '<li>'. $table['data'][$i][0].'</li>';
			}
		}
	}
	echo '</ol>';
	
}
echo '</li><br />';

// Total number of people currently on break
$totalLNCH = 0;

for ($i = 3; $i < $totalAgents; $i++) {
	for ($j = 0; $j < $colTimes; $j++) {
		if (startsWith($table['data'][$i][$j], 'LNCH') && $colTimesRowStart[$j] == $tableTimes[$currentHour]) {
			$totalLNCH++;
		}
	}
}

echo '<li>'.do_shortcode('[icon name="fa-cutlery"]').' Agents currently on Lunch: <strong>'. $totalLNCH. '</strong>';

if ($totalLNCH > 0) {
	echo '<ol>';
	for ($i = 0; $i <= $totalAgents; $i++) {
		for ($j = 0; $j < $colTimes; $j++) {
			if (startsWith($table['data'][$i][$j], 'LNCH') && $colTimesRowStart[$j] == $tableTimes[$currentHour]) {
				echo '<li>'. $table['data'][$i][0].'</li>';
			}
		}
	}
	echo '</ol>';
	
}
echo '</li></ul></div><br /><br /><br /><br /><br /><br />';

/* if (strtolower($username) == 'saad') { */
echo '<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />';
	echo do_shortcode('[table id=4 /]');


?>
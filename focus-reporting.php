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
	
$current_date = $date->format("Y-m-d H:i:s");
$shift_date = $date->format("Y-m-d");
	
if ($userID != 0) {

	if (strtolower($username) != 'jc' && strtolower($username) != 'rebecca' && strtolower($username) != 'alex' && strtolower($username) != 'greg' && strtolower($username) != 'amy') { 
		echo '<div style="background-color: #8857ac; color: white; padding: 5px;"><strong>Your Focus Report</strong></div>';

		echo '<div style="padding-left: 20px; padding-top: 10px; margin-top: 0px; margin-bottom: 10px; background-color: #fcf7fc"><h3>Hi, ' .$username. '! Welcome back :) </h3><br />';
	}

	//print("<pre>".print_r($table['data'][$userID],true)."</pre>");
	//print_r(array_count_values($table['data'][$userID]));

	// Print Today's Shift Time
	//echo "Today you're working from: ";
	//echo $table['data'][$userID][1] .'pm <br />';
	
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
		//TODO: only update every x minutes
		else if ($focus && $focus->agent_name == strtolower($table['data'][$i][0])) {
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
		}
	
	}
	
	if (strtolower($username) != 'jc' && strtolower($username) != 'rebecca' && strtolower($username) != 'alex' && strtolower($username) != 'greg' && strtolower($username) != 'amy') { 
		echo '<h1>Today:</h1>';
		
		$focusToday = $wpdb->get_row( "SELECT * FROM cs_focus WHERE agent_name = '".$username."' AND shift_date = '". $shift_date ." 00:00:00'", ARRAY_N);
		
		//print_r($focus);
		
		$totalHoursToday = 0;
		$ICHoursToday = 0;
		$IBHoursToday= 0;
		$ZDHoursToday = 0;
		$HiringHoursToday = 0;
		$ACTHoursToday = 0;
		$ACTOHoursToday = 0;
		$OpenHoursToday = 0;
		$TrainerHoursToday = 0;
		$TraineeHoursToday = 0;
		$OtherHoursToday = 0;
		$percentIBToday = 0;
		$percentICToday = 0;
		$percentOtherToday = 0;
		$percentZDToday = 0;
		$percentHiringToday = 0;
		$percentACTToday = 0;
		$percentOpenToday = 0;
		$percentACTOToday = 0;
		$percentTrainerToday = 0;
		$percentTraineeToday = 0;
		
		$otherItemsListToday = array();
		
		for ($i = 4; $i < 16; $i++) {
			if ($focusToday[$i] != '' && $focusToday[$i] != 'TM' && $focusToday[$i] != 'LNCH') {
				//echo $focusToday[$i]."<br />";
				$totalHoursToday++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focusToday[$i], 'IB/')) {
				//echo $focusToday[$i]."<br />";
				$IBHoursToday++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focusToday[$i], 'IC/')) {
				$ICHoursToday++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focusToday[$i], 'ZD/')) {
				$ZDHoursToday++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focusToday[$i], 'H/')) {
				$HiringHoursToday++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if ($focusToday[$i] == 'ACT') {
				$ACTHoursToday++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if ($focusToday[$i] == 'ACT/O') {
				$ACTOHoursToday++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focusToday[$i], 'O')) {
				$OpenHoursToday++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focusToday[$i], 'TR')) {
				$TrainerHoursToday++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focusToday[$i], 'TT')) {
				$TraineeHoursToday++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if (!startsWith($focusToday[$i], 'IC/') && !startsWith($focusToday[$i], 'IB/') && !startsWith($focusToday[$i], 'ZD/') && $focusToday[$i] != '' && $focusToday[$i] != 'TM' && $focusToday[$i] != 'LNCH' && !startsWith($focusToday[$i], 'H/') && !startsWith($focusToday[$i], 'ACT/O') && !startsWith($focusToday[$i], 'TT') && !startsWith($focusToday[$i], 'TR') && $focusToday[$i] != 'ACT' && $focusToday[$i] != 'O') {
				//echo $focusToday[$i]."<br />";
				$OtherHoursToday++;
				$otherItemsListToday[] = $focusToday[$i];
			}
		}
		
		/* echo $totalHoursToday."<br>";
		echo $ICHoursToday."<br>";
		echo $IBHoursToday."<br>";
		echo $ZDHoursToday."<br>";
		echo $HiringHoursToday."<br>";
		echo $ACTHoursToday."<br>";
		echo $ACTOHoursToday."<br>";
		echo $OpenHoursToday."<br>";
		echo $OtherHoursToday."<br>";
		echo $percentIBToday."<br>";
		echo $percentICToday."<br>";
		echo $percentOtherToday."<br>";
		echo $percentZDToday."<br>"; */
		
		if (($ICHoursToday + $IBHoursToday + $ZDHoursToday + $HiringHoursToday + $ACTHoursToday + $ACTOHoursToday + $OpenHoursToday + $TrainerHoursToday + $TraineeHoursToday + $OtherHoursToday) != $totalHoursToday) {
			echo 'Error: hours aren\'t matching up for today\'s stats';
		}
		
		$percentIBToday = number_format((float)(($IBHoursToday / $totalHoursToday) * 100), 2, '.', '');
		$percentICToday = number_format((float)(($ICHoursToday / $totalHoursToday) * 100), 2, '.', '');
		$percentOtherToday = number_format((float)(($OtherHoursToday / $totalHoursToday) * 100), 2, '.', '');
		$percentZDToday = number_format((float)(($ZDHoursToday / $totalHoursToday) * 100), 2, '.', '');
		$percentACTToday = number_format((float)(($ACTHoursToday / $totalHoursToday) * 100), 2, '.', '');
		$percentACTOToday = number_format((float)(($ACTOHoursToday / $totalHoursToday) * 100), 2, '.', '');
		$percentHiringToday = number_format((float)(($HiringHoursToday / $totalHoursToday) * 100), 2, '.', '');
		$percentOpenToday = number_format((float)(($OpenHoursToday / $totalHoursToday) * 100), 2, '.', '');
		$percentTraineeToday = number_format((float)(($TraineeHoursToday / $totalHoursToday) * 100), 2, '.', '');
		$percentTrainerToday = number_format((float)(($TrainerHoursToday / $totalHoursToday) * 100), 2, '.', '');
		
		if ($IBHoursToday != 0) {
			echo '<h5>IB ('.$percentIBToday.'%) </h5><span style="color: gray; font-size: 10px;">['.$IBHoursToday.' / '.$totalHoursToday.' hours]</span><br><br>';
		}
		if ($ZDHoursToday != 0) {
			echo '<h5>ZD: ('.$percentZDToday.'%) </h5><span style="color: gray; font-size: 10px;">['.$ZDHoursToday.' / '.$totalHoursToday.' hours]</span><br><br>';
		}
		if ($ICHoursToday != 0) {
			echo '<h5>IC: ('.$percentICToday.'%) </h5><span style="color: gray; font-size: 10px;">['.$ICHoursToday.' / '.$totalHoursToday.' hours]</span><br><br>';
		}
		if ($HiringHoursToday != 0) {
			echo '<h5>Hiring: ('.$percentHiringToday.'%) </h5><span style="color: gray; font-size: 10px;">['.$HiringHoursToday.' / '.$totalHoursToday.' hours]</span><br><br>';
		}
		if ($ACTHoursToday != 0) {
			echo '<h5>ACT: ('.$percentACTToday.'%) </h5><span style="color: gray; font-size: 10px;">['.$ACTHoursToday.' / '.$totalHoursToday.' hours]</span><br><br>';
		}
		if ($ACTOHoursToday != 0) {
			echo '<h5>ACT/O: ('.$percentACTOToday.'%) </h5><span style="color: gray; font-size: 10px;">['.$ACTOHoursToday.' / '.$totalHoursToday.' hours]</span><br><br>';
		}
		if ($OpenHoursToday != 0) {
			echo '<h5>Open: ('.$percentOpenToday.'%) </h5><span style="color: gray; font-size: 10px;">['.$OpenHoursToday.' / '.$totalHoursToday.' hours]</span><br><br>';
		}
		if ($TrainerHoursToday != 0) {
			echo '<h5>Trainer (TR): ('.$percentTrainerToday.'%) </h5><span style="color: gray; font-size: 10px;">['.$TrainerHoursToday.' / '.$totalHoursToday.' hours]</span><br><br>';
		}
		if ($TraineeHoursToday != 0) {
			echo '<h5>Trainees (TT): ('.$percentTraineeToday.'%) </h5><span style="color: gray; font-size: 10px;">['.$TraineeHoursToday.' / '.$totalHoursToday.' hours]</span><br><br>';
		}
		if ($OtherHoursToday != 0) {
			echo '<h5>Other:  ('.$percentOtherToday.'%) </h5><span style="color: gray; font-size: 10px;">['.$OtherHoursToday.' / '.$totalHoursToday.' hours]</span>';
			
			echo '<div style="padding-left: 30px; color: gray; font-size: 10px;"><ul>';
			
			for ($i = 0; $i < count($otherItemsListToday); $i++) {
				echo '<li>'.$otherItemsListToday[$i].'</li>';
			}
			
			echo '</ul></div>';
		}
		
		/**** YOUR PAST WEEK REPORT *****/
		echo '<h1>Last 7 Days</h1>';
		
		$focusSinceWeek = $wpdb->get_results( "SELECT * FROM `cs_focus` WHERE agent_name = '".$username."' AND `shift_date` BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW()", ARRAY_N);
		
		$totalHoursWeek = 0;
		$ICHoursWeek = 0;
		$IBHoursWeek= 0;
		$ZDHoursWeek = 0;
		$HiringHoursWeek = 0;
		$ACTHoursWeek = 0;
		$ACTOHoursWeek = 0;
		$TrainerHoursWeek = 0;
		$TraineeHoursWeek = 0;
		$OpenHoursWeek = 0;
		$OtherHoursWeek = 0;
		$percentIBWeek = 0;
		$percentICWeek = 0;
		$percentOtherWeek = 0;
		$percentZDWeek = 0;
		$percentHiringWeek = 0;
		$percentACTWeek = 0;
		$percentOpenWeek = 0;
		$percentACTOWeek = 0;
		$percentTrainerWeek = 0;
		$percentTraineeWeek = 0;
		
		$otherItemsListWeek = array();
		
		 foreach( $focusSinceWeek as $focus ) {

			for ($i = 4; $i < 16; $i++) {
				if ($focus[$i] != '' && $focus[$i] != 'TM' && $focus[$i] != 'LNCH') {
					//echo $focus[$i]."<br />";
					$totalHoursWeek++;
				}
			}
			
			for ($i = 4; $i < 16; $i++) {
				if (startsWith($focus[$i], 'IB/')) {
					//echo $focus[$i]."<br />";
					$IBHoursWeek++;
				}
			}
			
			for ($i = 4; $i < 16; $i++) {
				if (startsWith($focus[$i], 'IC/')) {
					$ICHoursWeek++;
				}
			}
			
			for ($i = 4; $i < 16; $i++) {
				if (startsWith($focus[$i], 'ZD/')) {
					$ZDHoursWeek++;
				}
			}
			
			for ($i = 4; $i < 16; $i++) {
				if (startsWith($focus[$i], 'H/')) {
					$HiringHoursWeek++;
				}
			}
			
			for ($i = 4; $i < 16; $i++) {
				if ($focus[$i] == 'ACT') {
					$ACTHoursWeek++;
				}
			}
			
			for ($i = 4; $i < 16; $i++) {
				if ($focus[$i] == 'ACT/O') {
					$ACTOHoursWeek++;
				}
			}
			
			for ($i = 4; $i < 16; $i++) {
				if (startsWith($focus[$i], 'O')) {
					$OpenHoursWeek++;
				}
			}
			
			for ($i = 4; $i < 16; $i++) {
				if (startsWith($focus[$i], 'TR')) {
					$TraineeHoursWeek++;
				}
			}
			
			for ($i = 4; $i < 16; $i++) {
				if (startsWith($focus[$i], 'TT')) {
					$TrainerHoursWeek++;
				}
			}
			
			for ($i = 4; $i < 16; $i++) {
				if (!startsWith($focus[$i], 'IC/') && !startsWith($focus[$i], 'IB/') && !startsWith($focus[$i], 'ZD/') && $focus[$i] != '' && $focus[$i] != 'TM' && $focus[$i] != 'LNCH' && !startsWith($focus[$i], 'H/') && !startsWith($focus[$i], 'ACT/O') && !startsWith($focus[$i], 'TT') && !startsWith($focus[$i], 'TR') && $focus[$i] != 'ACT' && $focus[$i] != 'O') {
					//echo $focus[$i]."<br />";
					$OtherHoursWeek++;
					$otherItemsListWeek[] = $focus[$i];
				}
			}
		}
		
		/* echo $totalHoursWeek."<br>";
		echo $ICHoursWeek."<br>";
		echo $IBHoursWeek."<br>";
		echo $ZDHoursWeek."<br>";
		echo $HiringHoursWeek."<br>";
		echo $ACTHoursWeek."<br>";
		echo $ACTOHoursWeek."<br>";
		echo $OpenHoursWeek."<br>";
		echo $OtherHoursWeek."<br>";
		echo $percentIBWeek."<br>";
		echo $percentICWeek."<br>";
		echo $percentOtherWeek."<br>";
		echo $percentZDWeek."<br>"; */
		
		if (($ICHoursWeek + $IBHoursWeek + $ZDHoursWeek + $HiringHoursWeek + $ACTHoursWeek + $ACTOHoursWeek + $OpenHoursWeek + $OtherHoursWeek + $TrainerHoursWeek + $TraineeHoursWeek) != $totalHoursWeek) {
			echo 'Error: hours aren\'t matching up for stats for the week';
		}
		
		$percentIBWeek = number_format((float)(($IBHoursWeek / $totalHoursWeek) * 100), 2, '.', '');
		$percentICWeek = number_format((float)(($ICHoursWeek / $totalHoursWeek) * 100), 2, '.', '');
		$percentOtherWeek = number_format((float)(($OtherHoursWeek / $totalHoursWeek) * 100), 2, '.', '');
		$percentZDWeek = number_format((float)(($ZDHoursWeek / $totalHoursWeek) * 100), 2, '.', '');
		$percentACTWeek = number_format((float)(($ACTHoursWeek / $totalHoursWeek) * 100), 2, '.', '');
		$percentACTOWeek = number_format((float)(($ACTOHoursWeek / $totalHoursWeek) * 100), 2, '.', '');
		$percentHiringWeek = number_format((float)(($HiringHoursWeek / $totalHoursWeek) * 100), 2, '.', '');
		$percentOpenWeek = number_format((float)(($OpenHoursWeek / $totalHoursWeek) * 100), 2, '.', '');
		$percentTrainerWeek = number_format((float)(($TrainerHoursWeek / $totalHoursWeek) * 100), 2, '.', '');
		$percentTraineeWeek = number_format((float)(($TraineeHoursWeek / $totalHoursWeek) * 100), 2, '.', '');
		
		if ($IBHoursWeek != 0) {
			echo '<h5>IB ('.$percentIBWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$IBHoursWeek.' / '.$totalHoursWeek.' hours]</span><br><br>';
		}
		if ($ZDHoursWeek != 0) {
			echo '<h5>ZD: ('.$percentZDWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$ZDHoursWeek.' / '.$totalHoursWeek.' hours]</span><br><br>';
		}
		if ($ICHoursWeek != 0) {
			echo '<h5>IC: ('.$percentICWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$ICHoursWeek.' / '.$totalHoursWeek.' hours]</span><br><br>';
		}
		if ($HiringHoursWeek != 0) {
			echo '<h5>Hiring: ('.$percentHiringWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$HiringHoursWeek.' / '.$totalHoursWeek.' hours]</span><br><br>';
		}
		if ($ACTHoursWeek != 0) {
			echo '<h5>ACT: ('.$percentACTWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$ACTHoursWeek.' / '.$totalHoursWeek.' hours]</span><br><br>';
		}
		if ($ACTOHoursWeek != 0) {
			echo '<h5>ACT/O: ('.$percentACTOWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$ACTOHoursWeek.' / '.$totalHoursWeek.' hours]</span><br><br>';
		}
		if ($OpenHoursWeek != 0) {
			echo '<h5>Open: ('.$percentOpenWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$OpenHoursWeek.' / '.$totalHoursWeek.' hours]</span><br><br>';
		}
		if ($TrainerHoursWeek != 0) {
			echo '<h5>Trainer (TT): ('.$percentTrainerWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$TrainerHoursWeek.' / '.$totalHoursWeek.' hours]</span><br><br>';
		}
		if ($TraineeHoursWeek != 0) {
			echo '<h5>Trainee (TT): ('.$percentTraineeWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$TraineeHoursWeek.' / '.$totalHoursWeek.' hours]</span><br><br>';
		}
		if ($OtherHoursWeek != 0) {
			echo '<h5>Other:  ('.$percentOtherWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$OtherHoursWeek.' / '.$totalHoursWeek.' hours]</span>';
			
			echo '<div style="padding-left: 30px; color: gray; font-size: 10px;"><ul>';
			
			for ($i = 0; $i < count($otherItemsListWeek); $i++) {
				echo '<li>'.$otherItemsListWeek[$i].'</li>';
			}
			
			echo '</ul></div>';
		}
		
		/**** YOUR ALL TIME REPORT *****/
		echo '<h1>All Time:</h1>';
		
		$focusSinceStart = $wpdb->get_results( "SELECT * FROM cs_focus WHERE agent_name = '".$username."' AND shift_date <= '". $shift_date ." 00:00:00'", ARRAY_N);
		
		//print_r($focusSinceStart);
		
		$totalHoursStart = 0;
		$ICHoursStart = 0;
		$IBHoursStart= 0;
		$ZDHoursStart = 0;
		$HiringHoursStart = 0;
		$ACTHoursStart = 0;
		$ACTOHoursStart = 0;
		$OpenHoursStart = 0;
		$OtherHoursStart = 0;
		$TrainerHoursStart = 0;
		$TraineeHoursStart = 0;
		$percentIBStart = 0;
		$percentICStart = 0;
		$percentOtherStart = 0;
		$percentZDStart = 0;
		$percentHiringStart = 0;
		$percentACTStart = 0;
		$percentOpenStart = 0;
		$percentACTOStart = 0;
		$percentTrainerStart = 0;
		$percentTraineeStart = 0;
		
		$otherItemsListStart = array();
		
		foreach( $focusSinceStart as $focus ) {
			
			for ($i = 4; $i < 16; $i++) {
				if ($focus[$i] != '' && $focus[$i] != 'TM' && $focus[$i] != 'LNCH') {
					//echo $focus[$i]."<br />";
					$totalHoursStart++;
				}
			}
			
			for ($i = 4; $i < 16; $i++) {
				if (startsWith($focus[$i], 'IB/')) {
					//echo $focus[$i]."<br />";
					$IBHoursStart++;
				}
			}
			
			for ($i = 4; $i < 16; $i++) {
				if (startsWith($focus[$i], 'IC/')) {
					$ICHoursStart++;
				}
			}
			
			for ($i = 4; $i < 16; $i++) {
				if (startsWith($focus[$i], 'ZD/')) {
					$ZDHoursStart++;
				}
			}
			
			for ($i = 4; $i < 16; $i++) {
				if (startsWith($focus[$i], 'H/')) {
					$HiringHoursStart++;
				}
			}
			
			for ($i = 4; $i < 16; $i++) {
				if ($focus[$i] == 'ACT') {
					$ACTHoursStart++;
				}
			}
			
			for ($i = 4; $i < 16; $i++) {
				if ($focus[$i] == 'ACT/O') {
					$ACTOHoursStart++;
				}
			}
			
			for ($i = 4; $i < 16; $i++) {
				if (startsWith($focus[$i], 'O')) {
					$OpenHoursStart++;
				}
			}
			
			for ($i = 4; $i < 16; $i++) {
				if (startsWith($focus[$i], 'TR')) {
					$TrainerHoursStart++;
				}
			}
			
			for ($i = 4; $i < 16; $i++) {
				if (startsWith($focus[$i], 'TT')) {
					$TraineeHoursStart++;
				}
			}
			
			for ($i = 4; $i < 16; $i++) {
				if (!startsWith($focus[$i], 'IC/') && !startsWith($focus[$i], 'IB/') && !startsWith($focus[$i], 'ZD/') && $focus[$i] != '' && $focus[$i] != 'TM' && $focus[$i] != 'LNCH' && !startsWith($focus[$i], 'H/') && !startsWith($focus[$i], 'ACT/O') && !startsWith($focus[$i], 'TT') && !startsWith($focus[$i], 'TR') && $focus[$i] != 'ACT' && $focus[$i] != 'O') {
					//echo $focus[$i]."<br />";
					$otherItemsListStart[] = $focus[$i];
					$OtherHoursStart++;
				}
			}
		}
		
		/* echo $totalHoursStart."<br>";
		echo $ICHoursStart."<br>";
		echo $IBHoursStart."<br>";
		echo $ZDHoursStart."<br>";
		echo $HiringHoursStart."<br>";
		echo $ACTHoursStart."<br>";
		echo $ACTOHoursStart."<br>";
		echo $OpenHoursStart."<br>";
		echo $OtherHoursStart."<br>";
		echo $percentIBStart."<br>";
		echo $percentICStart."<br>";
		echo $percentOtherStart."<br>";
		echo $percentZDStart."<br>"; */
		
		if (($ICHoursStart + $IBHoursStart + $ZDHoursStart + $HiringHoursStart + $ACTHoursStart + $ACTOHoursStart + $OpenHoursStart + $OtherHoursStart + $TraineeHoursStart + $TrainerHoursStart) != $totalHoursStart) {
			echo 'Error: hours aren\'t matching up for all time stats';
		}
		
		$percentIBStart = number_format((float)(($IBHoursStart / $totalHoursStart) * 100), 2, '.', '');
		$percentICStart = number_format((float)(($ICHoursStart / $totalHoursStart) * 100), 2, '.', '');
		$percentOtherStart = number_format((float)(($OtherHoursStart / $totalHoursStart) * 100), 2, '.', '');
		$percentZDStart = number_format((float)(($ZDHoursStart / $totalHoursStart) * 100), 2, '.', '');
		$percentACTStart = number_format((float)(($ACTHoursStart / $totalHoursStart) * 100), 2, '.', '');
		$percentACTOStart = number_format((float)(($ACTOHoursStart / $totalHoursStart) * 100), 2, '.', '');
		$percentHiringStart = number_format((float)(($HiringHoursStart / $totalHoursStart) * 100), 2, '.', '');
		$percentOpenStart = number_format((float)(($OpenHoursStart / $totalHoursStart) * 100), 2, '.', '');
		$percentTrainerStart = number_format((float)(($TrainerHoursStart / $totalHoursStart) * 100), 2, '.', '');
		$percentTraineeStart = number_format((float)(($TraineeHoursStart / $totalHoursStart) * 100), 2, '.', '');
		
		if ($IBHoursStart != 0) {
			echo '<h5>IB ('.$percentIBStart.'%) </h5><span style="color: gray; font-size: 10px;">['.$IBHoursStart.' / '.$totalHoursStart.' hours]</span><br><br>';
		}
		if ($ZDHoursStart != 0) {
			echo '<h5>ZD: ('.$percentZDStart.'%) </h5><span style="color: gray; font-size: 10px;">['.$ZDHoursStart.' / '.$totalHoursStart.' hours]</span><br><br>';
		}
		if ($ICHoursStart != 0) {
			echo '<h5>IC: ('.$percentICStart.'%) </h5><span style="color: gray; font-size: 10px;">['.$ICHoursStart.' / '.$totalHoursStart.' hours]</span><br><br>';
		}
		if ($HiringHoursStart != 0) {
			echo '<h5>Hiring: ('.$percentHiringStart.'%) </h5><span style="color: gray; font-size: 10px;">['.$HiringHoursStart.' / '.$totalHoursStart.' hours]</span><br><br>';
		}
		if ($ACTHoursStart != 0) {
			echo '<h5>ACT: ('.$percentACTStart.'%) </h5><span style="color: gray; font-size: 10px;">['.$ACTHoursStart.' / '.$totalHoursStart.' hours]</span><br><br>';
		}
		if ($ACTOHoursStart != 0) {
			echo '<h5>ACT/O: ('.$percentACTOStart.'%) </h5><span style="color: gray; font-size: 10px;">['.$ACTOHoursStart.' / '.$totalHoursStart.' hours]</span><br><br>';
		}
		if ($OpenHoursStart != 0) {
			echo '<h5>Open: ('.$percentOpenStart.'%) </h5><span style="color: gray; font-size: 10px;">['.$OpenHoursStart.' / '.$totalHoursStart.' hours]</span><br><br>';
		}
		if ($TrainerHoursStart != 0) {
			echo '<h5>Trainer (TR): ('.$percentTrainerStart.'%) </h5><span style="color: gray; font-size: 10px;">['.$TrainerHoursStart.' / '.$totalHoursStart.' hours]</span><br><br>';
		}
		if ($TraineeHoursStart != 0) {
			echo '<h5>Trainee (TT): ('.$percentTraineeStart.'%) </h5><span style="color: gray; font-size: 10px;">['.$TraineeHoursStart.' / '.$totalHoursStart.' hours]</span><br><br>';
		}
		if ($OtherHoursStart != 0) {
			echo '<h5>Other:  ('.$percentOtherStart.'%) </h5><span style="color: gray; font-size: 10px;">['.$OtherHoursStart.' / '.$totalHoursStart.' hours]</span>';
			
			echo '<div style="padding-left: 30px; color: gray; font-size: 10px;"><ul>';
			
			for ($i = 0; $i < count($otherItemsListStart); $i++) {
				echo '<li>'.$otherItemsListStart[$i].'</li>';
			}
			
			echo '</ul></div>';
		}
		
		echo '<br /><center><p><i><span style="color: black; font-size: 11px;">Page Last Updated: '. $lastUpdated .'</span></i></p></center><br />';

		echo '</div>';
	}

}

echo '<div style="background-color: #8857ac; color: white; padding: 5px;"><strong>'.do_shortcode('[icon name="fa-search-plus"]').' CS Focus Report</strong></div>';

	/***** CS REPORT FOR TODAY ******/
	echo '<div style="padding-left: 30px; margin-top: 0px; padding-top: 10px; padding-bottom: 10px; background-color: #fcf7fc;"><h1>Today</h1>';
	
	$focusCSSinceToday = $wpdb->get_results( "SELECT * FROM cs_focus WHERE shift_date = '". $shift_date ." 00:00:00'", ARRAY_N);
	
	$CS_totalHoursToday = 0;
	$CS_ICHoursToday = 0;
	$CS_IBHoursToday= 0;
	$CS_ZDHoursToday = 0;
	$CS_HiringHoursToday = 0;
	$CS_ACTHoursToday = 0;
	$CS_ACTOHoursToday = 0;
	$CS_OpenHoursToday = 0;
	$CS_TrainerHoursToday = 0;
	$CS_TraineeHoursToday = 0;
	$CS_OtherHoursToday = 0;
	$CS_percentIBToday = 0;
	$CS_percentICToday = 0;
	$CS_percentOtherToday = 0;
	$CS_percentZDToday = 0;
	$CS_percentHiringToday = 0;
	$CS_percentACTToday = 0;
	$CS_percentOpenToday = 0;
	$CS_percentACTOToday = 0;
	$CS_percentTrainerToday = 0;
	$CS_percentTraineeToday = 0;
	
	$CS_otherItemsListToday = array();
	
	 foreach( $focusCSSinceToday as $focus ) {

        for ($i = 4; $i < 16; $i++) {
			if ($focus[$i] != '' && $focus[$i] != 'TM' && $focus[$i] != 'LNCH') {
				//echo $focus[$i]."<br />";
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
			if (startsWith($focus[$i], 'H/')) {
				$CS_HiringHoursToday++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if ($focus[$i] == 'ACT') {
				$CS_ACTHoursToday++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if ($focus[$i] == 'ACT/O') {
				$CS_ACTOHoursToday++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focus[$i], 'O')) {
				$CS_OpenHoursToday++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focus[$i], 'TR')) {
				$CS_TrainerHoursToday++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focus[$i], 'TT')) {
				$CS_TraineeHoursToday++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if (!startsWith($focus[$i], 'IC/') && !startsWith($focus[$i], 'IB/') && !startsWith($focus[$i], 'ZD/') && $focus[$i] != '' && $focus[$i] != 'TM' && $focus[$i] != 'LNCH' && !startsWith($focus[$i], 'H/') && !startsWith($focus[$i], 'ACT/O') && !startsWith($focus[$i], 'TT') && !startsWith($focus[$i], 'TR') && $focus[$i] != 'ACT' && $focus[$i] != 'O') {
				//echo $focus[$i]."<br />";
				$CS_OtherHoursToday++;
				$CS_otherItemsListToday[] = $focus[$i];
			}
		}
    }
	
	/* echo $CS_totalHoursToday."<br>";
	echo $CS_ICHoursToday."<br>";
	echo $CS_IBHoursToday."<br>";
	echo $CS_ZDHoursToday."<br>";
	echo $CS_HiringHoursToday."<br>";
	echo $CS_ACTHoursToday."<br>";
	echo $CS_ACTOHoursToday."<br>";
	echo $CS_OpenHoursToday."<br>";
	echo $CS_OtherHoursToday."<br>";
	echo $CS_percentIBToday."<br>";
	echo $CS_percentICToday."<br>";
	echo $CS_percentOtherToday."<br>";
	echo $CS_percentZDToday."<br>"; */
	
	if (($CS_ICHoursToday + $CS_IBHoursToday + $CS_ZDHoursToday + $CS_HiringHoursToday + $CS_ACTHoursToday + $CS_ACTOHoursToday + $CS_OpenHoursToday + $CS_OtherHoursToday + $CS_TrainerHoursToday + $CS_TraineeHoursToday) != $CS_totalHoursToday) {
		echo 'Error: hours aren\'t matching up for today\'s stats';
	}
	
	$CS_percentIBToday = number_format((float)(($CS_IBHoursToday / $CS_totalHoursToday) * 100), 2, '.', '');
	$CS_percentICToday = number_format((float)(($CS_ICHoursToday / $CS_totalHoursToday) * 100), 2, '.', '');
	$CS_percentOtherToday = number_format((float)(($CS_OtherHoursToday / $CS_totalHoursToday) * 100), 2, '.', '');
	$CS_percentZDToday = number_format((float)(($CS_ZDHoursToday / $CS_totalHoursToday) * 100), 2, '.', '');
	$CS_percentACTToday = number_format((float)(($CS_ACTHoursToday / $CS_totalHoursToday) * 100), 2, '.', '');
	$CS_percentACTOToday = number_format((float)(($CS_ACTOHoursToday / $CS_totalHoursToday) * 100), 2, '.', '');
	$CS_percentHiringToday = number_format((float)(($CS_HiringHoursToday / $CS_totalHoursToday) * 100), 2, '.', '');
	$CS_percentOpenToday = number_format((float)(($CS_OpenHoursToday / $CS_totalHoursToday) * 100), 2, '.', '');
	$CS_percentTrainerToday = number_format((float)(($CS_TrainerHoursToday / $CS_totalHoursToday) * 100), 2, '.', '');
	$CS_percentTraineeToday = number_format((float)(($CS_TraineeHoursToday / $CS_totalHoursToday) * 100), 2, '.', '');
	
	echo '<h5>IB ('.$CS_percentIBToday.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_IBHoursToday.' / '.$CS_totalHoursToday.' hours]</span><br><br>';
	echo '<h5>ZD: ('.$CS_percentZDToday.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_ZDHoursToday.' / '.$CS_totalHoursToday.' hours]</span><br><br>';
	echo '<h5>IC: ('.$CS_percentICToday.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_ICHoursToday.' / '.$CS_totalHoursToday.' hours]</span><br><br>';
	echo '<h5>Hiring: ('.$CS_percentHiringToday.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_HiringHoursToday.' / '.$CS_totalHoursToday.' hours]</span><br><br>';
	echo '<h5>ACT: ('.$CS_percentACTToday.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_ACTHoursToday.' / '.$CS_totalHoursToday.' hours]</span><br><br>';
	echo '<h5>ACT/O: ('.$CS_percentACTOToday.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_ACTOHoursToday.' / '.$CS_totalHoursToday.' hours]</span><br><br>';
	echo '<h5>Open: ('.$CS_percentOpenToday.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_OpenHoursToday.' / '.$CS_totalHoursToday.' hours]</span><br><br>';
	echo '<h5>Trainer (TR): ('.$CS_percentTrainerToday.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_TrainerHoursToday.' / '.$CS_totalHoursToday.' hours]</span><br><br>';
	echo '<h5>Trainee (TT): ('.$CS_percentTraineeToday.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_TraineeHoursToday.' / '.$CS_totalHoursToday.' hours]</span><br><br>';
	if ($CS_OtherHoursToday != 0) {
		echo '<h5>Other:  ('.$CS_percentOtherToday.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_OtherHoursToday.' / '.$CS_totalHoursToday.' hours]</span>';
		
		echo '<div style="padding-left: 30px; color: gray; font-size: 10px;"><ul>';
		
		for ($i = 0; $i < count($CS_otherItemsListToday); $i++) {
			echo '<li>'.$CS_otherItemsListToday[$i].'</li>';
		}
		
		echo '</ul></div>';
	}
	
	/***** CS REPORT PAST WEEK ******/
	echo '<h1>Last 7 Days</h1>';
	
	$focusCSSinceWeek = $wpdb->get_results( "SELECT * FROM `cs_focus` WHERE `shift_date` BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW()", ARRAY_N);
	
	$CS_totalHoursWeek = 0;
	$CS_ICHoursWeek = 0;
	$CS_IBHoursWeek= 0;
	$CS_ZDHoursWeek = 0;
	$CS_HiringHoursWeek = 0;
	$CS_ACTHoursWeek = 0;
	$CS_ACTOHoursWeek = 0;
	$CS_OpenHoursWeek = 0;
	$CS_OtherHoursWeek = 0;
	$CS_TrainerHoursWeek = 0;
	$CS_TraineeHoursWeek = 0;
	$CS_percentIBWeek = 0;
	$CS_percentICWeek = 0;
	$CS_percentOtherWeek = 0;
	$CS_percentZDWeek = 0;
	$CS_percentHiringWeek = 0;
	$CS_percentACTWeek = 0;
	$CS_percentOpenWeek = 0;
	$CS_percentACTOWeek = 0;
	
	$CS_otherItemsListWeek = array();
	
	 foreach( $focusCSSinceWeek as $focus ) {

        for ($i = 4; $i < 16; $i++) {
			if ($focus[$i] != '' && $focus[$i] != 'TM' && $focus[$i] != 'LNCH') {
				//echo $focus[$i]."<br />";
				$CS_totalHoursWeek++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focus[$i], 'IB/')) {
				//echo $focus[$i]."<br />";
				$CS_IBHoursWeek++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focus[$i], 'IC/')) {
				$CS_ICHoursWeek++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focus[$i], 'ZD/')) {
				$CS_ZDHoursWeek++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focus[$i], 'H/')) {
				$CS_HiringHoursWeek++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if ($focus[$i] == 'ACT') {
				$CS_ACTHoursWeek++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if ($focus[$i] == 'ACT/O') {
				$CS_ACTOHoursWeek++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focus[$i], 'O')) {
				$CS_OpenHoursWeek++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focus[$i], 'TR')) {
				$CS_TrainerHoursWeek++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focus[$i], 'TT')) {
				$CS_TraineeHoursWeek++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if (!startsWith($focus[$i], 'IC/') && !startsWith($focus[$i], 'IB/') && !startsWith($focus[$i], 'ZD/') && $focus[$i] != '' && $focus[$i] != 'TM' && $focus[$i] != 'LNCH' && !startsWith($focus[$i], 'H/') && !startsWith($focus[$i], 'ACT/O') && !startsWith($focus[$i], 'TR') && !startsWith($focus[$i], 'TT') && $focus[$i] != 'ACT' && $focus[$i] != 'O') {
				//echo $focus[$i]."<br />";
				$CS_OtherHoursWeek++;
				$CS_otherItemsListWeek[] = $focus[$i];
			}
		}
    }
	
	/* echo $CS_totalHoursWeek."<br>";
	echo $CS_ICHoursWeek."<br>";
	echo $CS_IBHoursWeek."<br>";
	echo $CS_ZDHoursWeek."<br>";
	echo $CS_HiringHoursWeek."<br>";
	echo $CS_ACTHoursWeek."<br>";
	echo $CS_ACTOHoursWeek."<br>";
	echo $CS_OpenHoursWeek."<br>";
	echo $CS_OtherHoursWeek."<br>";
	echo $CS_percentIBWeek."<br>";
	echo $CS_percentICWeek."<br>";
	echo $CS_percentOtherWeek."<br>";
	echo $CS_percentZDWeek."<br>"; */
	
	if (($CS_ICHoursWeek + $CS_IBHoursWeek + $CS_ZDHoursWeek + $CS_HiringHoursWeek + $CS_ACTHoursWeek + $CS_ACTOHoursWeek + $CS_OpenHoursWeek + $CS_OtherHoursWeek + $CS_TrainerHoursWeek + $CS_TraineeHoursWeek) != $CS_totalHoursWeek) {
		echo 'Error: hours aren\'t matching up for stats for the week';
	}
	
	$CS_percentIBWeek = number_format((float)(($CS_IBHoursWeek / $CS_totalHoursWeek) * 100), 2, '.', '');
	$CS_percentICWeek = number_format((float)(($CS_ICHoursWeek / $CS_totalHoursWeek) * 100), 2, '.', '');
	$CS_percentOtherWeek = number_format((float)(($CS_OtherHoursWeek / $CS_totalHoursWeek) * 100), 2, '.', '');
	$CS_percentZDWeek = number_format((float)(($CS_ZDHoursWeek / $CS_totalHoursWeek) * 100), 2, '.', '');
	$CS_percentACTWeek = number_format((float)(($CS_ACTHoursWeek / $CS_totalHoursWeek) * 100), 2, '.', '');
	$CS_percentACTOWeek = number_format((float)(($CS_ACTOHoursWeek / $CS_totalHoursWeek) * 100), 2, '.', '');
	$CS_percentHiringWeek = number_format((float)(($CS_HiringHoursWeek / $CS_totalHoursWeek) * 100), 2, '.', '');
	$CS_percentOpenWeek = number_format((float)(($CS_OpenHoursWeek / $CS_totalHoursWeek) * 100), 2, '.', '');
	$CS_percentTrainerWeek = number_format((float)(($CS_TrainerHoursWeek / $CS_totalHoursWeek) * 100), 2, '.', '');
	$CS_percentTraineeWeek = number_format((float)(($CS_TraineeHoursWeek / $CS_totalHoursWeek) * 100), 2, '.', '');
	
	echo '<h5>IB ('.$CS_percentIBWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_IBHoursWeek.' / '.$CS_totalHoursWeek.' hours]</span><br><br>';
	echo '<h5>ZD: ('.$CS_percentZDWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_ZDHoursWeek.' / '.$CS_totalHoursWeek.' hours]</span><br><br>';
	echo '<h5>IC: ('.$CS_percentICWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_ICHoursWeek.' / '.$CS_totalHoursWeek.' hours]</span><br><br>';
	echo '<h5>Hiring: ('.$CS_percentHiringWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_HiringHoursWeek.' / '.$CS_totalHoursWeek.' hours]</span><br><br>';
	echo '<h5>ACT: ('.$CS_percentACTWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_ACTHoursWeek.' / '.$CS_totalHoursWeek.' hours]</span><br><br>';
	echo '<h5>ACT/O: ('.$CS_percentACTOWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_ACTOHoursWeek.' / '.$CS_totalHoursWeek.' hours]</span><br><br>';
	echo '<h5>Open: ('.$CS_percentOpenWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_OpenHoursWeek.' / '.$CS_totalHoursWeek.' hours]</span><br><br>';
	echo '<h5>Trainer (TR): ('.$CS_percentTrainerWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_TrainerHoursWeek.' / '.$CS_totalHoursWeek.' hours]</span><br><br>';
	echo '<h5>Trainee (TT): ('.$CS_percentTraineeWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_TraineeHoursWeek.' / '.$CS_totalHoursWeek.' hours]</span><br><br>';
	if ($CS_OtherHoursWeek != 0) {
		echo '<h5>Other:  ('.$CS_percentOtherWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_OtherHoursWeek.' / '.$CS_totalHoursWeek.' hours]</span>';
		
		/* echo '<div style="padding-left: 30px; color: gray; font-size: 10px;"><ul>';
		
		for ($i = 0; $i < count($CS_otherItemsListWeek); $i++) {
			echo '<li>'.$CS_otherItemsListWeek[$i].'</li>';
		}
		
		echo '</ul></div>'; */
	}
	
	/***** CS REPORT SINCE START ******/
	echo '<h1>All Time</h1>';
	
	$focusCSSinceStart = $wpdb->get_results( "SELECT * FROM cs_focus WHERE shift_date <= '". $shift_date ." 00:00:00'", ARRAY_N);
	
	$CS_totalHoursStart = 0;
	$CS_ICHoursStart = 0;
	$CS_IBHoursStart= 0;
	$CS_ZDHoursStart = 0;
	$CS_HiringHoursStart = 0;
	$CS_ACTHoursStart = 0;
	$CS_ACTOHoursStart = 0;
	$CS_OpenHoursStart = 0;
	$CS_OtherHoursStart = 0;
	$CS_TrainerHoursStart = 0;
	$CS_TraineeHoursStart = 0;
	$CS_percentIBStart = 0;
	$CS_percentICStart = 0;
	$CS_percentOtherStart = 0;
	$CS_percentZDStart = 0;
	$CS_percentHiringStart = 0;
	$CS_percentACTStart = 0;
	$CS_percentOpenStart = 0;
	$CS_percentACTOStart = 0;
	$CS_percentTrainerStart = 0;
	$CS_percentTraineeStart = 0;
	
	$CS_otherItemsListStart = array();
	
	 foreach( $focusCSSinceStart as $focus ) {

        for ($i = 4; $i < 16; $i++) {
			if ($focus[$i] != '' && $focus[$i] != 'TM' && $focus[$i] != 'LNCH') {
				//echo $focus[$i]."<br />";
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
			if (startsWith($focus[$i], 'H/')) {
				$CS_HiringHoursStart++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if ($focus[$i] == 'ACT') {
				$CS_ACTHoursStart++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if ($focus[$i] == 'ACT/O') {
				$CS_ACTOHoursStart++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focus[$i], 'O')) {
				$CS_OpenHoursStart++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focus[$i], 'TR')) {
				$CS_TrainerHoursStart++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focus[$i], 'TT')) {
				$CS_TraineeHoursStart++;
			}
		}
		
		for ($i = 4; $i < 16; $i++) {
			if (!startsWith($focus[$i], 'IC/') && !startsWith($focus[$i], 'IB/') && !startsWith($focus[$i], 'ZD/') && $focus[$i] != '' && $focus[$i] != 'TM' && $focus[$i] != 'LNCH' && !startsWith($focus[$i], 'H/') && !startsWith($focus[$i], 'ACT/O') && !startsWith($focus[$i], 'TT') && !startsWith($focus[$i], 'TR') && $focus[$i] != 'ACT' && $focus[$i] != 'O') {
				//echo $focus[$i]."<br />";
				$CS_OtherHoursStart++;
				$CS_otherItemsListStart[] = $focus[$i];
			}
		}
    }
	
	/* echo $CS_totalHoursStart."<br>";
	echo $CS_ICHoursStart."<br>";
	echo $CS_IBHoursStart."<br>";
	echo $CS_ZDHoursStart."<br>";
	echo $CS_HiringHoursStart."<br>";
	echo $CS_ACTHoursStart."<br>";
	echo $CS_ACTOHoursStart."<br>";
	echo $CS_OpenHoursStart."<br>";
	echo $CS_OtherHoursStart."<br>";
	echo $CS_percentIBStart."<br>";
	echo $CS_percentICStart."<br>";
	echo $CS_percentOtherStart."<br>";
	echo $CS_percentZDStart."<br>"; */
	
	if (($CS_ICHoursStart + $CS_IBHoursStart + $CS_ZDHoursStart + $CS_HiringHoursStart + $CS_ACTHoursStart + $CS_ACTOHoursStart + $CS_OpenHoursStart + $CS_OtherHoursStart + $CS_TrainerHoursStart + $CS_TraineeHoursStart) != $CS_totalHoursStart) {
		echo 'Error: hours aren\'t matching up for stats since start';
	}
	
	$CS_percentIBStart = number_format((float)(($CS_IBHoursStart / $CS_totalHoursStart) * 100), 2, '.', '');
	$CS_percentICStart = number_format((float)(($CS_ICHoursStart / $CS_totalHoursStart) * 100), 2, '.', '');
	$CS_percentOtherStart = number_format((float)(($CS_OtherHoursStart / $CS_totalHoursStart) * 100), 2, '.', '');
	$CS_percentZDStart = number_format((float)(($CS_ZDHoursStart / $CS_totalHoursStart) * 100), 2, '.', '');
	$CS_percentACTStart = number_format((float)(($CS_ACTHoursStart / $CS_totalHoursStart) * 100), 2, '.', '');
	$CS_percentACTOStart = number_format((float)(($CS_ACTOHoursStart / $CS_totalHoursStart) * 100), 2, '.', '');
	$CS_percentHiringStart = number_format((float)(($CS_HiringHoursStart / $CS_totalHoursStart) * 100), 2, '.', '');
	$CS_percentOpenStart = number_format((float)(($CS_OpenHoursStart / $CS_totalHoursStart) * 100), 2, '.', '');
	$CS_percentTrainerStart = number_format((float)(($CS_TrainerHoursStart / $CS_totalHoursStart) * 100), 2, '.', '');
	$CS_percentTraineeStart = number_format((float)(($CS_TraineeHoursStart / $CS_totalHoursStart) * 100), 2, '.', '');
	
	echo '<h5>IB ('.$CS_percentIBStart.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_IBHoursStart.' / '.$CS_totalHoursStart.' hours]</span><br><br>';
	echo '<h5>ZD: ('.$CS_percentZDStart.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_ZDHoursStart.' / '.$CS_totalHoursStart.' hours]</span><br><br>';
	echo '<h5>IC: ('.$CS_percentICStart.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_ICHoursStart.' / '.$CS_totalHoursStart.' hours]</span><br><br>';
	echo '<h5>Hiring: ('.$CS_percentHiringStart.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_HiringHoursStart.' / '.$CS_totalHoursStart.' hours]</span><br><br>';
	echo '<h5>ACT: ('.$CS_percentACTStart.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_ACTHoursStart.' / '.$CS_totalHoursStart.' hours]</span><br><br>';
	echo '<h5>ACT/O: ('.$CS_percentACTOStart.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_ACTOHoursStart.' / '.$CS_totalHoursStart.' hours]</span><br><br>';
	echo '<h5>Open: ('.$CS_percentOpenStart.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_OpenHoursStart.' / '.$CS_totalHoursStart.' hours]</span><br><br>';
	echo '<h5>Trainer (TR): ('.$CS_percentTrainerStart.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_TrainerHoursStart.' / '.$CS_totalHoursStart.' hours]</span><br><br>';
	echo '<h5>Trainee (TT): ('.$CS_percentTraineeStart.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_TraineeHoursStart.' / '.$CS_totalHoursStart.' hours]</span><br><br>';
	if ($CS_OtherHoursStart != 0) {
		echo '<h5>Other:  ('.$CS_percentOtherStart.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_OtherHoursStart.' / '.$CS_totalHoursStart.' hours]</span>';
		
		/* echo '<div style="padding-left: 30px; color: gray; font-size: 10px;"><ul>';
		
		for ($i = 0; $i < count($CS_otherItemsListStart); $i++) {
			echo '<li>'.$CS_otherItemsListStart[$i].'</li>';
		}
		
		echo '</ul></div>'; */
	}


echo '</div>';

/* if (strtolower($username) == 'saad') { */
echo '<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />';
	echo do_shortcode('[table id=4 /]');


?>
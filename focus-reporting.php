<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

function startsWith($haystack, $needle)
{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}

$current_user = wp_get_current_user();
$username = $current_user->user_login;

$table = TablePress::$model_table->load( 4, true, false );

$totalAgents = count($table['data']);

$date = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
$date->setTimeZone(new DateTimeZone('America/Chicago'));
$lastUpdated = $date->format('g:i a');
$shift_date = $date->format("Y-m-d");

//if ($userID != 0) {

	if (strtolower($username) != 'jc' && strtolower($username) != 'rebecca' && strtolower($username) != 'alex' && strtolower($username) != 'greg' && strtolower($username) != 'amy' && strtolower($username) != 'rushi') {
		echo '<div style="background-color: #8857ac; color: white; padding: 5px;"><strong>Your Focus Report</strong></div>';

		echo '<div style="padding-left: 20px; padding-top: 10px; margin-top: 0px; margin-bottom: 10px; background-color: #fcf7fc"><h3>Hi, ' .$username. '! Welcome back :) </h3><br />';
	}

	//print("<pre>".print_r($table['data'][$userID],true)."</pre>");
	//print_r(array_count_values($table['data'][$userID]));

	// Print Today's Shift Time
	//echo "Today you're working from: ";
	//echo $table['data'][$userID][1] .'pm <br />';

	if (strtolower($username) != 'jc' && strtolower($username) != 'rebecca' && strtolower($username) != 'alex' && strtolower($username) != 'greg' && strtolower($username) != 'amy') {
		echo '<div style="background-color: black; color: white; padding-left: 10px;"><h1>Today</h1></div>';

		$focusToday = $wpdb->get_row( "SELECT * FROM cs_focus WHERE agent_name = '".$username."' AND shift_date = '". $shift_date ." 00:00:00'", ARRAY_N);

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
		$TCHoursToday = 0;
		$TMHoursToday = 0;
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
		$percentTCToday = 0;
		$percentTMToday = 0;

		$otherItemsListToday = array();

		for ($i = 4; $i < 16; $i++) {
			if ($focusToday[$i] != '' && $focusToday[$i] != 'LNCH') {
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
			if (startsWith($focusToday[$i], 'TC')) {
				$TCHoursToday++;
			}
		}

		for ($i = 4; $i < 16; $i++) {
      if ($focusToday[$i] == 'TM') {
				$TMHoursToday++;
			}
		}

		for ($i = 4; $i < 16; $i++) {
			if (!startsWith($focusToday[$i], 'IC/') && !startsWith($focusToday[$i], 'IB/') && !startsWith($focusToday[$i], 'ZD/') && $focusToday[$i] != '' && $focusToday[$i] != 'TM' && $focusToday[$i] != 'LNCH' && !startsWith($focusToday[$i], 'H/') && !startsWith($focusToday[$i], 'ACT/O') && !startsWith($focusToday[$i], 'TT') && !startsWith($focusToday[$i], 'TR') && $focusToday[$i] != 'ACT' && $focusToday[$i] != 'O' && $focusToday[$i] != 'TC') {
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

		// if (($ICHoursToday + $IBHoursToday + $ZDHoursToday + $HiringHoursToday + $ACTHoursToday + $ACTOHoursToday + $OpenHoursToday + $TrainerHoursToday + $TraineeHoursToday + $OtherHoursToday + $TCHoursToday) != $totalHoursToday) {
		// 	echo 'Error: hours aren\'t matching up for today\'s stats';
		// }

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
		$percentTCToday = number_format((float)(($TCHoursToday / $totalHoursToday) * 100), 2, '.', '');
		$percentTMToday = number_format((float)(($TMHoursToday / $totalHoursToday) * 100), 2, '.', '');

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
		if ($TCHoursToday != 0) {
			echo '<h5>Training Call (TC): ('.$percentTCToday.'%) </h5><span style="color: gray; font-size: 10px;">['.$TCHoursToday.' / '.$totalHoursToday.' hours]</span><br><br>';
		}
		if ($TMHoursToday != 0) {
			echo '<h5>Team Meeting (TM): ('.$percentTMToday.'%) </h5><span style="color: gray; font-size: 10px;">['.$TMHoursToday.' / '.$totalHoursToday.' hours]</span><br><br>';
		}
		if ($OtherHoursToday != 0) {
			echo '<h5>Other:  ('.$percentOtherToday.'%) </h5><span style="color: gray; font-size: 10px;">['.$OtherHoursToday.' / '.$totalHoursToday.' hours]</span>';

			echo '<div style="padding-left: 30px; color: gray; font-size: 10px;"><ul>';

			for ($i = 0; $i < count($otherItemsListToday); $i++) {
				echo '<li>'.$otherItemsListToday[$i].'</li>';
			}

			echo '</ul></div>';
		}

		/**** YOUR THIS WEEK REPORT *****/
		echo '<div style="background-color: black; color: white; padding-left: 10px;"><h1>This Week</h1></div>';

		$focusSinceThisWeek = $wpdb->get_results( "SELECT * FROM `cs_focus` WHERE agent_name = '".$username."' AND YEARWEEK(`shift_date`, 1) = YEARWEEK(CURDATE(), 1)", ARRAY_N);

		$totalHoursThisWeek = 0;
		$ICHoursThisWeek = 0;
		$IBHoursThisWeek= 0;
		$ZDHoursThisWeek = 0;
		$HiringHoursThisWeek = 0;
		$ACTHoursThisWeek = 0;
		$ACTOHoursThisWeek = 0;
		$TrainerHoursThisWeek = 0;
		$TraineeHoursThisWeek = 0;
		$OpenHoursThisWeek = 0;
		$OtherHoursThisWeek = 0;
		$TCHoursThisWeek = 0;
    $TMHoursThisWeek = 0;
		$percentIBThisWeek = 0;
		$percentICThisWeek = 0;
		$percentOtherThisWeek = 0;
		$percentZDThisWeek = 0;
		$percentHiringThisWeek = 0;
		$percentACTThisWeek = 0;
		$percentOpenThisWeek = 0;
		$percentACTOThisWeek = 0;
		$percentTrainerThisWeek = 0;
		$percentTraineeThisWeek = 0;
		$percentTCThisWeek = 0;
		$percentTMThisWeek = 0;

		$otherItemsListThisWeek = array();

		 foreach( $focusSinceThisWeek as $focus ) {

			for ($i = 4; $i < 16; $i++) {
				if ($focus[$i] != '' && $focus[$i] != 'LNCH') {
					//echo $focus[$i]."<br />";
					$totalHoursThisWeek++;
				}
			}

			for ($i = 4; $i < 16; $i++) {
				if (startsWith($focus[$i], 'IB/')) {
					//echo $focus[$i]."<br />";
					$IBHoursThisWeek++;
				}
			}

			for ($i = 4; $i < 16; $i++) {
				if (startsWith($focus[$i], 'IC/')) {
					$ICHoursThisWeek++;
				}
			}

			for ($i = 4; $i < 16; $i++) {
				if (startsWith($focus[$i], 'ZD/')) {
					$ZDHoursThisWeek++;
				}
			}

			for ($i = 4; $i < 16; $i++) {
				if (startsWith($focus[$i], 'H/')) {
					$HiringHoursThisWeek++;
				}
			}

			for ($i = 4; $i < 16; $i++) {
				if ($focus[$i] == 'ACT') {
					$ACTHoursThisWeek++;
				}
			}

			for ($i = 4; $i < 16; $i++) {
				if ($focus[$i] == 'ACT/O') {
					$ACTOHoursThisWeek++;
				}
			}

			for ($i = 4; $i < 16; $i++) {
				if (startsWith($focus[$i], 'O')) {
					$OpenHoursThisWeek++;
				}
			}

			for ($i = 4; $i < 16; $i++) {
				if (startsWith($focus[$i], 'TR')) {
					$TrainerHoursThisWeek++;
				}
			}

			for ($i = 4; $i < 16; $i++) {
				if (startsWith($focus[$i], 'TT')) {
					$TraineeHoursThisWeek++;
				}
			}

			for ($i = 4; $i < 16; $i++) {
				if (startsWith($focus[$i], 'TC')) {
					$TCHoursThisWeek++;
				}
			}

      for ($i = 4; $i < 16; $i++) {
				if ($focus[$i] == 'TM') {
					$ACTOHoursThisWeek++;
				}
			}

			for ($i = 4; $i < 16; $i++) {
				if (!startsWith($focus[$i], 'IC/') && !startsWith($focus[$i], 'IB/') && !startsWith($focus[$i], 'ZD/') && $focus[$i] != '' && $focus[$i] != 'TM' && $focus[$i] != 'LNCH' && !startsWith($focus[$i], 'H/') && !startsWith($focus[$i], 'ACT/O') && !startsWith($focus[$i], 'TT') && !startsWith($focus[$i], 'TR') && $focus[$i] != 'ACT' && $focus[$i] != 'O' && $focus[$i] != 'TC') {
					//echo $focus[$i]."<br />";
					$OtherHoursThisWeek++;
					$otherItemsListThisWeek[] = $focus[$i];
				}
			}
		}

		/* echo $totalHoursThisWeek."<br>";
		echo $ICHoursThisWeek."<br>";
		echo $IBHoursThisWeek."<br>";
		echo $ZDHoursThisWeek."<br>";
		echo $HiringHoursThisWeek."<br>";
		echo $ACTHoursThisWeek."<br>";
		echo $ACTOHoursThisWeek."<br>";
		echo $OpenHoursThisWeek."<br>";
		echo $OtherHoursThisWeek."<br>";
		echo $percentIBThisWeek."<br>";
		echo $percentICThisWeek."<br>";
		echo $percentOtherThisWeek."<br>";
		echo $percentZDThisWeek."<br>"; */

		// if (($ICHoursThisWeek + $IBHoursThisWeek + $ZDHoursThisWeek + $HiringHoursThisWeek + $ACTHoursThisWeek + $ACTOHoursThisWeek + $OpenHoursThisWeek + $OtherHoursThisWeek + $TrainerHoursThisWeek + $TraineeHoursThisWeek + $TCHoursThisWeek) != $totalHoursThisWeek) {
		// 	echo 'Error: hours aren\'t matching up for stats for the ThisWeek';
		// }

		$percentIBThisWeek = number_format((float)(($IBHoursThisWeek / $totalHoursThisWeek) * 100), 2, '.', '');
		$percentICThisWeek = number_format((float)(($ICHoursThisWeek / $totalHoursThisWeek) * 100), 2, '.', '');
		$percentOtherThisWeek = number_format((float)(($OtherHoursThisWeek / $totalHoursThisWeek) * 100), 2, '.', '');
		$percentZDThisWeek = number_format((float)(($ZDHoursThisWeek / $totalHoursThisWeek) * 100), 2, '.', '');
		$percentACTThisWeek = number_format((float)(($ACTHoursThisWeek / $totalHoursThisWeek) * 100), 2, '.', '');
		$percentACTOThisWeek = number_format((float)(($ACTOHoursThisWeek / $totalHoursThisWeek) * 100), 2, '.', '');
		$percentHiringThisWeek = number_format((float)(($HiringHoursThisWeek / $totalHoursThisWeek) * 100), 2, '.', '');
		$percentOpenThisWeek = number_format((float)(($OpenHoursThisWeek / $totalHoursThisWeek) * 100), 2, '.', '');
		$percentTrainerThisWeek = number_format((float)(($TrainerHoursThisWeek / $totalHoursThisWeek) * 100), 2, '.', '');
		$percentTraineeThisWeek = number_format((float)(($TraineeHoursThisWeek / $totalHoursThisWeek) * 100), 2, '.', '');

		$percentTCThisWeek = number_format((float)(($TCHoursThisWeek / $totalHoursThisWeek) * 100), 2, '.', '');
		$percentTMThisWeek = number_format((float)(($TMHoursThisWeek / $totalHoursThisWeek) * 100), 2, '.', '');

		if ($IBHoursThisWeek != 0) {
			echo '<h5>IB ('.$percentIBThisWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$IBHoursThisWeek.' / '.$totalHoursThisWeek.' hours]</span><br><br>';
		}
		if ($ZDHoursThisWeek != 0) {
			echo '<h5>ZD: ('.$percentZDThisWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$ZDHoursThisWeek.' / '.$totalHoursThisWeek.' hours]</span><br><br>';
		}
		if ($ICHoursThisWeek != 0) {
			echo '<h5>IC: ('.$percentICThisWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$ICHoursThisWeek.' / '.$totalHoursThisWeek.' hours]</span><br><br>';
		}
		if ($HiringHoursThisWeek != 0) {
			echo '<h5>Hiring: ('.$percentHiringThisWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$HiringHoursThisWeek.' / '.$totalHoursThisWeek.' hours]</span><br><br>';
		}
		if ($ACTHoursThisWeek != 0) {
			echo '<h5>ACT: ('.$percentACTThisWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$ACTHoursThisWeek.' / '.$totalHoursThisWeek.' hours]</span><br><br>';
		}
		if ($ACTOHoursThisWeek != 0) {
			echo '<h5>ACT/O: ('.$percentACTOThisWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$ACTOHoursThisWeek.' / '.$totalHoursThisWeek.' hours]</span><br><br>';
		}
		if ($OpenHoursThisWeek != 0) {
			echo '<h5>Open: ('.$percentOpenThisWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$OpenHoursThisWeek.' / '.$totalHoursThisWeek.' hours]</span><br><br>';
		}
		if ($TrainerHoursThisWeek != 0) {
			echo '<h5>Trainer (TR): ('.$percentTrainerThisWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$TrainerHoursThisWeek.' / '.$totalHoursThisWeek.' hours]</span><br><br>';
		}
		if ($TraineeHoursThisWeek != 0) {
			echo '<h5>Trainee (TT): ('.$percentTraineeThisWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$TraineeHoursThisWeek.' / '.$totalHoursThisWeek.' hours]</span><br><br>';
		}
		if ($TCHoursThisWeek != 0) {
			echo '<h5>Training Call (TC): ('.$percentTCThisWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$TCHoursThisWeek.' / '.$totalHoursThisWeek.' hours]</span><br><br>';
		}
		if ($TMHoursThisWeek != 0) {
			echo '<h5>Team Meeting (TM): ('.$percentTMThisWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$TMHoursThisWeek.' / '.$totalHoursThisWeek.' hours]</span><br><br>';
		}
		if ($OtherHoursThisWeek != 0) {
			echo '<h5>Other:  ('.$percentOtherThisWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$OtherHoursThisWeek.' / '.$totalHoursThisWeek.' hours]</span>';

			echo '<div style="padding-left: 30px; color: gray; font-size: 10px;"><ul>';

			for ($i = 0; $i < count($otherItemsListThisWeek); $i++) {
				echo '<li>'.$otherItemsListThisWeek[$i].'</li>';
			}

			echo '</ul></div>';
		}

		/**** YOUR LAST WEEK REPORT *****/
		echo '<div style="background-color: black; color: white; padding-left: 10px;"><h1>Last Week</h1></div>';

		$focusSinceWeek = $wpdb->get_results( "SELECT * FROM `cs_focus` WHERE agent_name = '".$username."' AND shift_date >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY
AND shift_date <= curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY", ARRAY_N);

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
		$TCHoursWeek = 0;
		$TMHoursWeek = 0;
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
		$percentTCWeek = 0;
		$percentTMWeek = 0;

		$otherItemsListWeek = array();

		 foreach( $focusSinceWeek as $focus ) {

			for ($i = 4; $i < 16; $i++) {
				if ($focus[$i] != '' && $focus[$i] != 'LNCH') {
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
					$TrainerHoursWeek++;
				}
			}

			for ($i = 4; $i < 16; $i++) {
				if (startsWith($focus[$i], 'TT')) {
					$TraineeHoursWeek++;
				}
			}

			for ($i = 4; $i < 16; $i++) {
				if (startsWith($focus[$i], 'TC')) {
					$TCHoursWeek++;
				}
			}

			for ($i = 4; $i < 16; $i++) {
				if (startsWith($focus[$i], 'TM')) {
					$TMHoursWeek++;
				}
			}

			for ($i = 4; $i < 16; $i++) {
				if (!startsWith($focus[$i], 'IC/') && !startsWith($focus[$i], 'IB/') && !startsWith($focus[$i], 'ZD/') && $focus[$i] != '' && $focus[$i] != 'TM' && $focus[$i] != 'LNCH' && !startsWith($focus[$i], 'H/') && !startsWith($focus[$i], 'ACT/O') && !startsWith($focus[$i], 'TT') && !startsWith($focus[$i], 'TR') && $focus[$i] != 'ACT' && $focus[$i] != 'O' && $focus[$i] != 'TC') {
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

		// if (($ICHoursWeek + $IBHoursWeek + $ZDHoursWeek + $HiringHoursWeek + $ACTHoursWeek + $ACTOHoursWeek + $OpenHoursWeek + $OtherHoursWeek + $TrainerHoursWeek + $TraineeHoursWeek + $TCHoursWeek) != $totalHoursWeek) {
		// 	echo 'Error: hours aren\'t matching up for stats for the week';
		// }

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
		$percentTMWeek = number_format((float)(($TMHoursWeek / $totalHoursWeek) * 100), 2, '.', '');

		$percentTCWeek = number_format((float)(($TCHoursWeek / $totalHoursWeek) * 100), 2, '.', '');

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
			echo '<h5>Trainer (TR): ('.$percentTrainerWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$TrainerHoursWeek.' / '.$totalHoursWeek.' hours]</span><br><br>';
		}
		if ($TraineeHoursWeek != 0) {
			echo '<h5>Trainee (TT): ('.$percentTraineeWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$TraineeHoursWeek.' / '.$totalHoursWeek.' hours]</span><br><br>';
		}
		if ($TCHoursWeek != 0) {
			echo '<h5>Training Call (TC): ('.$percentTCWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$TCHoursWeek.' / '.$totalHoursWeek.' hours]</span><br><br>';
		}
		if ($TMHoursWeek != 0) {
			echo '<h5>Team Meeting (TM): ('.$percentTMWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$TMHoursWeek.' / '.$totalHoursWeek.' hours]</span><br><br>';
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
		echo '<div style="background-color: black; color: white; padding-left: 10px;"><h1>All Time</h1></div>';

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
		$TCHoursStart = 0;
		$TrainerHoursStart = 0;
		$TraineeHoursStart = 0;
		$TMHoursStart = 0;
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
		$percentTMStart = 0;

		$otherItemsListStart = array();

		foreach( $focusSinceStart as $focus ) {

			for ($i = 4; $i < 16; $i++) {
				if ($focus[$i] != '' && $focus[$i] != 'LNCH') {
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
				if (startsWith($focus[$i], 'TC')) {
					$TCHoursStart++;
				}
			}

			for ($i = 4; $i < 16; $i++) {
        if ($focus[$i] == 'TM') {
					$TMHoursStart++;
				}
			}

			for ($i = 4; $i < 16; $i++) {
				if (!startsWith($focus[$i], 'IC/') && !startsWith($focus[$i], 'IB/') && !startsWith($focus[$i], 'ZD/') && $focus[$i] != '' && $focus[$i] != 'TM' && $focus[$i] != 'LNCH' && !startsWith($focus[$i], 'H/') && !startsWith($focus[$i], 'ACT/O') && !startsWith($focus[$i], 'TT') && !startsWith($focus[$i], 'TR') && $focus[$i] != 'ACT' && $focus[$i] != 'O' && $focus[$i] != 'TC') {
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

		// if (($ICHoursStart + $IBHoursStart + $ZDHoursStart + $HiringHoursStart + $ACTHoursStart + $ACTOHoursStart + $OpenHoursStart + $OtherHoursStart + $TraineeHoursStart + $TrainerHoursStart + $TCHoursStart) != $totalHoursStart) {
		// 	echo 'Error: hours aren\'t matching up for all time stats';
		// }

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
		$percentTCStart = number_format((float)(($TCHoursStart / $totalHoursStart) * 100), 2, '.', '');
		$percentTMStart = number_format((float)(($TMHoursStart / $totalHoursStart) * 100), 2, '.', '');

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
		if ($TCHoursStart != 0) {
			echo '<h5>Training Call (TC): ('.$percentTCStart.'%) </h5><span style="color: gray; font-size: 10px;">['.$TCHoursStart.' / '.$totalHoursStart.' hours]</span><br><br>';
		}
		if ($TMHoursStart != 0) {
			echo '<h5>Team Meeting (TM): ('.$percentTMStart.'%) </h5><span style="color: gray; font-size: 10px;">['.$TMHoursStart.' / '.$totalHoursStart.' hours]</span><br><br>';
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

echo '<div style="background-color: #8857ac; color: white; padding: 5px;"><strong>'.do_shortcode('[icon name="fa-search-plus"]').' CS Focus Report</strong></div>';

	/***** CS REPORT FOR TODAY ******/
	echo '<div style="padding-left: 30px; margin-top: 0px; padding-top: 10px; padding-bottom: 10px; background-color: #fcf7fc;"><div style="background-color: black; color: white; padding-left: 10px;"><h1>Today</h1></div>';

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
	$CS_TCHoursToday = 0;
	$CS_TMHoursToday = 0;
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
	$CS_TCTraineeToday = 0;

	$CS_otherItemsListToday = array();

	 foreach( $focusCSSinceToday as $focus ) {

        for ($i = 4; $i < 16; $i++) {
			if ($focus[$i] != '' && $focus[$i] != 'LNCH') {
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
			if (startsWith($focus[$i], 'TC')) {
				$CS_TCHoursToday++;
			}
		}

		for ($i = 4; $i < 16; $i++) {
      if ($focus[$i] == 'TM') {
				$CS_TMHoursToday++;
			}
		}

		for ($i = 4; $i < 16; $i++) {
			if (!startsWith($focus[$i], 'IC/') && !startsWith($focus[$i], 'IB/') && !startsWith($focus[$i], 'ZD/') && $focus[$i] != '' && $focus[$i] != 'TM' && $focus[$i] != 'LNCH' && !startsWith($focus[$i], 'H/') && !startsWith($focus[$i], 'ACT/O') && !startsWith($focus[$i], 'TT') && !startsWith($focus[$i], 'TR') && $focus[$i] != 'ACT' && $focus[$i] != 'O' && $focus[$i] != 'TC') {
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

	// if (($CS_ICHoursToday + $CS_IBHoursToday + $CS_ZDHoursToday + $CS_HiringHoursToday + $CS_ACTHoursToday + $CS_ACTOHoursToday + $CS_OpenHoursToday + $CS_OtherHoursToday + $CS_TrainerHoursToday + $CS_TraineeHoursToday + $CS_TCHoursToday) != $CS_totalHoursToday) {
	// 	echo 'Error: hours aren\'t matching up for today\'s stats';
	// }

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
	$CS_percentTCToday = number_format((float)(($CS_TCHoursToday / $CS_totalHoursToday) * 100), 2, '.', '');
	$CS_percentTMToday = number_format((float)(($CS_TMHoursToday / $CS_totalHoursToday) * 100), 2, '.', '');

	echo '<h5>IB ('.$CS_percentIBToday.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_IBHoursToday.' / '.$CS_totalHoursToday.' hours]</span><br><br>';
	echo '<h5>ZD: ('.$CS_percentZDToday.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_ZDHoursToday.' / '.$CS_totalHoursToday.' hours]</span><br><br>';
	echo '<h5>IC: ('.$CS_percentICToday.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_ICHoursToday.' / '.$CS_totalHoursToday.' hours]</span><br><br>';
	echo '<h5>Hiring: ('.$CS_percentHiringToday.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_HiringHoursToday.' / '.$CS_totalHoursToday.' hours]</span><br><br>';
	echo '<h5>ACT: ('.$CS_percentACTToday.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_ACTHoursToday.' / '.$CS_totalHoursToday.' hours]</span><br><br>';
	echo '<h5>ACT/O: ('.$CS_percentACTOToday.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_ACTOHoursToday.' / '.$CS_totalHoursToday.' hours]</span><br><br>';
	echo '<h5>Open: ('.$CS_percentOpenToday.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_OpenHoursToday.' / '.$CS_totalHoursToday.' hours]</span><br><br>';
	echo '<h5>Trainer (TR): ('.$CS_percentTrainerToday.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_TrainerHoursToday.' / '.$CS_totalHoursToday.' hours]</span><br><br>';
	echo '<h5>Trainee (TT): ('.$CS_percentTraineeToday.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_TraineeHoursToday.' / '.$CS_totalHoursToday.' hours]</span><br><br>';
	echo '<h5>Training Call (TC): ('.$CS_percentTCToday.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_TCHoursToday.' / '.$CS_totalHoursToday.' hours]</span><br><br>';
  if ($CS_TMHoursToday != 0) {
    echo '<h5>Team Meeting (TM): ('.$CS_percentTMToday.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_TMHoursToday.' / '.$CS_totalHoursToday.' hours]</span><br><br>';
  }
	if ($CS_OtherHoursToday != 0) {
		echo '<h5>Other:  ('.$CS_percentOtherToday.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_OtherHoursToday.' / '.$CS_totalHoursToday.' hours]</span>';

		echo '<div style="padding-left: 30px; color: gray; font-size: 10px;"><ul>';

		for ($i = 0; $i < count($CS_otherItemsListToday); $i++) {
			echo '<li>'.$CS_otherItemsListToday[$i].'</li>';
		}

		echo '</ul></div>';
	}

	/***** CS REPORT This Week ******/
	echo '<div style="background-color: black; color: white; padding-left: 10px;"><h1>This Week</h1></div>';

	$focusCSSinceThisWeek = $wpdb->get_results( "SELECT * FROM `cs_focus` WHERE YEARWEEK(`shift_date`, 1) = YEARWEEK(CURDATE(), 1)", ARRAY_N);

	$CS_totalHoursThisWeek = 0;
	$CS_ICHoursThisWeek = 0;
	$CS_IBHoursThisWeek= 0;
	$CS_ZDHoursThisWeek = 0;
	$CS_HiringHoursThisWeek = 0;
	$CS_ACTHoursThisWeek = 0;
	$CS_ACTOHoursThisWeek = 0;
	$CS_OpenHoursThisWeek = 0;
	$CS_OtherHoursThisWeek = 0;
	$CS_TrainerHoursThisWeek = 0;
	$CS_TraineeHoursThisWeek = 0;
	$CS_TCHoursThisWeek = 0;
	$CS_TMHoursThisWeek = 0;
	$CS_percentIBThisWeek = 0;
	$CS_percentICThisWeek = 0;
	$CS_percentOtherThisWeek = 0;
	$CS_percentZDThisWeek = 0;
	$CS_percentHiringThisWeek = 0;
	$CS_percentACTThisWeek = 0;
	$CS_percentOpenThisWeek = 0;
	$CS_percentACTOThisWeek = 0;
	$CS_percentTCThisWeek = 0;
	$CS_percentTMThisWeek = 0;

	$CS_otherItemsListThisWeek = array();

	 foreach( $focusCSSinceThisWeek as $focus ) {

        for ($i = 4; $i < 16; $i++) {
			if ($focus[$i] != '' && $focus[$i] != 'LNCH') {
				//echo $focus[$i]."<br />";
				$CS_totalHoursThisWeek++;
			}
		}

		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focus[$i], 'IB/')) {
				//echo $focus[$i]."<br />";
				$CS_IBHoursThisWeek++;
			}
		}

		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focus[$i], 'IC/')) {
				$CS_ICHoursThisWeek++;
			}
		}

		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focus[$i], 'ZD/')) {
				$CS_ZDHoursThisWeek++;
			}
		}

		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focus[$i], 'H/')) {
				$CS_HiringHoursThisWeek++;
			}
		}

		for ($i = 4; $i < 16; $i++) {
			if ($focus[$i] == 'ACT') {
				$CS_ACTHoursThisWeek++;
			}
		}

		for ($i = 4; $i < 16; $i++) {
			if ($focus[$i] == 'ACT/O') {
				$CS_ACTOHoursThisWeek++;
			}
		}

		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focus[$i], 'O')) {
				$CS_OpenHoursThisWeek++;
			}
		}

		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focus[$i], 'TR')) {
				$CS_TrainerHoursThisWeek++;
			}
		}

		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focus[$i], 'TT')) {
				$CS_TraineeHoursThisWeek++;
			}
		}

		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focus[$i], 'TC')) {
				$CS_TCHoursThisWeek++;
			}
		}

		for ($i = 4; $i < 16; $i++) {
      if ($focus[$i] == 'TM') {
				$CS_TMHoursThisWeek++;
			}
		}

		for ($i = 4; $i < 16; $i++) {
			if (!startsWith($focus[$i], 'IC/') && !startsWith($focus[$i], 'IB/') && !startsWith($focus[$i], 'ZD/') && $focus[$i] != '' && $focus[$i] != 'TM' && $focus[$i] != 'LNCH' && !startsWith($focus[$i], 'H/') && !startsWith($focus[$i], 'ACT/O') && !startsWith($focus[$i], 'TR') && !startsWith($focus[$i], 'TT') && $focus[$i] != 'ACT' && $focus[$i] != 'O' && $focus[$i] != 'TC') {
				//echo $focus[$i]."<br />";
				$CS_OtherHoursThisWeek++;
				$CS_otherItemsListThisWeek[] = $focus[$i];
			}
		}
    }

	/* echo $CS_totalHoursThisWeek."<br>";
	echo $CS_ICHoursThisWeek."<br>";
	echo $CS_IBHoursThisWeek."<br>";
	echo $CS_ZDHoursThisWeek."<br>";
	echo $CS_HiringHoursThisWeek."<br>";
	echo $CS_ACTHoursThisWeek."<br>";
	echo $CS_ACTOHoursThisWeek."<br>";
	echo $CS_OpenHoursThisWeek."<br>";
	echo $CS_OtherHoursThisWeek."<br>";
	echo $CS_percentIBThisWeek."<br>";
	echo $CS_percentICThisWeek."<br>";
	echo $CS_percentOtherThisWeek."<br>";
	echo $CS_percentZDThisWeek."<br>"; */

	if (($CS_ICHoursThisWeek + $CS_IBHoursThisWeek + $CS_ZDHoursThisWeek + $CS_HiringHoursThisWeek + $CS_ACTHoursThisWeek + $CS_ACTOHoursThisWeek + $CS_OpenHoursThisWeek + $CS_OtherHoursThisWeek + $CS_TrainerHoursThisWeek + $CS_TraineeHoursThisWeek + $CS_TCHoursThisWeek) != $CS_totalHoursThisWeek) {
		echo 'Error: hours aren\'t matching up for stats for the ThisWeek';
	}

	$CS_percentIBThisWeek = number_format((float)(($CS_IBHoursThisWeek / $CS_totalHoursThisWeek) * 100), 2, '.', '');
	$CS_percentICThisWeek = number_format((float)(($CS_ICHoursThisWeek / $CS_totalHoursThisWeek) * 100), 2, '.', '');
	$CS_percentOtherThisWeek = number_format((float)(($CS_OtherHoursThisWeek / $CS_totalHoursThisWeek) * 100), 2, '.', '');
	$CS_percentZDThisWeek = number_format((float)(($CS_ZDHoursThisWeek / $CS_totalHoursThisWeek) * 100), 2, '.', '');
	$CS_percentACTThisWeek = number_format((float)(($CS_ACTHoursThisWeek / $CS_totalHoursThisWeek) * 100), 2, '.', '');
	$CS_percentACTOThisWeek = number_format((float)(($CS_ACTOHoursThisWeek / $CS_totalHoursThisWeek) * 100), 2, '.', '');
	$CS_percentHiringThisWeek = number_format((float)(($CS_HiringHoursThisWeek / $CS_totalHoursThisWeek) * 100), 2, '.', '');
	$CS_percentOpenThisWeek = number_format((float)(($CS_OpenHoursThisWeek / $CS_totalHoursThisWeek) * 100), 2, '.', '');
	$CS_percentTrainerThisWeek = number_format((float)(($CS_TrainerHoursThisWeek / $CS_totalHoursThisWeek) * 100), 2, '.', '');
	$CS_percentTraineeThisWeek = number_format((float)(($CS_TraineeHoursThisWeek / $CS_totalHoursThisWeek) * 100), 2, '.', '');
	$CS_percentTCThisWeek = number_format((float)(($CS_TCHoursThisWeek / $CS_totalHoursThisWeek) * 100), 2, '.', '');
	$CS_percentTMThisWeek = number_format((float)(($CS_TMHoursThisWeek / $CS_totalHoursThisWeek) * 100), 2, '.', '');

	echo '<h5>IB ('.$CS_percentIBThisWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_IBHoursThisWeek.' / '.$CS_totalHoursThisWeek.' hours]</span><br><br>';
	echo '<h5>ZD: ('.$CS_percentZDThisWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_ZDHoursThisWeek.' / '.$CS_totalHoursThisWeek.' hours]</span><br><br>';
	echo '<h5>IC: ('.$CS_percentICThisWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_ICHoursThisWeek.' / '.$CS_totalHoursThisWeek.' hours]</span><br><br>';
	echo '<h5>Hiring: ('.$CS_percentHiringThisWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_HiringHoursThisWeek.' / '.$CS_totalHoursThisWeek.' hours]</span><br><br>';
	echo '<h5>ACT: ('.$CS_percentACTThisWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_ACTHoursThisWeek.' / '.$CS_totalHoursThisWeek.' hours]</span><br><br>';
	echo '<h5>ACT/O: ('.$CS_percentACTOThisWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_ACTOHoursThisWeek.' / '.$CS_totalHoursThisWeek.' hours]</span><br><br>';
	echo '<h5>Open: ('.$CS_percentOpenThisWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_OpenHoursThisWeek.' / '.$CS_totalHoursThisWeek.' hours]</span><br><br>';
	echo '<h5>Trainer (TR): ('.$CS_percentTrainerThisWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_TrainerHoursThisWeek.' / '.$CS_totalHoursThisWeek.' hours]</span><br><br>';
	echo '<h5>Trainee (TT): ('.$CS_percentTraineeThisWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_TraineeHoursThisWeek.' / '.$CS_totalHoursThisWeek.' hours]</span><br><br>';
	echo '<h5>Training Call (TC): ('.$CS_percentTCThisWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_TCHoursThisWeek.' / '.$CS_totalHoursThisWeek.' hours]</span><br><br>';
  if ($CS_TMHoursThisWeek != 0) {
  	echo '<h5>Team Meeting (TM): ('.$CS_percentTMThisWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_TMHoursThisWeek.' / '.$CS_totalHoursThisWeek.' hours]</span><br><br>';
  }
	if ($CS_OtherHoursThisWeek != 0) {
		echo '<h5>Other:  ('.$CS_percentOtherThisWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_OtherHoursThisWeek.' / '.$CS_totalHoursThisWeek.' hours]</span>';

		echo '<div style="padding-left: 30px; color: gray; font-size: 10px;"><ul>';

		for ($i = 0; $i < count($CS_otherItemsListThisWeek); $i++) {
			echo '<li>'.$CS_otherItemsListThisWeek[$i].'</li>';
		}

		echo '</ul></div>';
		echo '<br><br>';
	}

	/***** CS REPORT LAST WEEK ******/
	echo '<div style="background-color: black; color: white; padding-left: 10px;"><h1>Last Week</h1></div>';

	$focusCSSinceLastWeek = $wpdb->get_results( "SELECT * FROM `cs_focus` WHERE shift_date >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY
AND shift_date <= curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY", ARRAY_N);

	$CS_totalHoursLastWeek = 0;
	$CS_ICHoursLastWeek = 0;
	$CS_IBHoursLastWeek= 0;
	$CS_ZDHoursLastWeek = 0;
	$CS_HiringHoursLastWeek = 0;
	$CS_ACTHoursLastWeek = 0;
	$CS_ACTOHoursLastWeek = 0;
	$CS_OpenHoursLastWeek = 0;
	$CS_OtherHoursLastWeek = 0;
	$CS_TrainerHoursLastWeek = 0;
	$CS_TraineeHoursLastWeek = 0;
	$CS_TCHoursLastWeek = 0;
	$CS_TMHoursLastWeek = 0;
	$CS_percentIBLastWeek = 0;
	$CS_percentICLastWeek = 0;
	$CS_percentOtherLastWeek = 0;
	$CS_percentZDLastWeek = 0;
	$CS_percentHiringLastWeek = 0;
	$CS_percentACTLastWeek = 0;
	$CS_percentOpenLastWeek = 0;
	$CS_percentACTOLastWeek = 0;
	$CS_percentTCLastWeek = 0;
	$CS_percentTMLastWeek = 0;

	$CS_otherItemsListLastWeek = array();

	 foreach( $focusCSSinceLastWeek as $focus ) {

        for ($i = 4; $i < 16; $i++) {
			if ($focus[$i] != '' && $focus[$i] != 'LNCH') {
				//echo $focus[$i]."<br />";
				$CS_totalHoursLastWeek++;
			}
		}

		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focus[$i], 'IB/')) {
				//echo $focus[$i]."<br />";
				$CS_IBHoursLastWeek++;
			}
		}

		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focus[$i], 'IC/')) {
				$CS_ICHoursLastWeek++;
			}
		}

		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focus[$i], 'ZD/')) {
				$CS_ZDHoursLastWeek++;
			}
		}

		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focus[$i], 'H/')) {
				$CS_HiringHoursLastWeek++;
			}
		}

		for ($i = 4; $i < 16; $i++) {
			if ($focus[$i] == 'ACT') {
				$CS_ACTHoursLastWeek++;
			}
		}

		for ($i = 4; $i < 16; $i++) {
			if ($focus[$i] == 'ACT/O') {
				$CS_ACTOHoursLastWeek++;
			}
		}

		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focus[$i], 'O')) {
				$CS_OpenHoursLastWeek++;
			}
		}

		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focus[$i], 'TR')) {
				$CS_TrainerHoursLastWeek++;
			}
		}

		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focus[$i], 'TT')) {
				$CS_TraineeHoursLastWeek++;
			}
		}

		for ($i = 4; $i < 16; $i++) {
			if (startsWith($focus[$i], 'TC')) {
				$CS_TCHoursLastWeek++;
			}
		}

		for ($i = 4; $i < 16; $i++) {
      if ($focus[$i] == 'TM') {
				$CS_TMHoursLastWeek++;
			}
		}

		for ($i = 4; $i < 16; $i++) {
			if (!startsWith($focus[$i], 'IC/') && !startsWith($focus[$i], 'IB/') && !startsWith($focus[$i], 'ZD/') && $focus[$i] != '' && $focus[$i] != 'TM' && $focus[$i] != 'LNCH' && !startsWith($focus[$i], 'H/') && !startsWith($focus[$i], 'ACT/O') && !startsWith($focus[$i], 'TR') && !startsWith($focus[$i], 'TT') && $focus[$i] != 'ACT' && $focus[$i] != 'O' && $focus[$i] != 'TC') {
				//echo $focus[$i]."<br />";
				$CS_OtherHoursLastWeek++;
				$CS_otherItemsListLastWeek[] = $focus[$i];
			}
		}
    }

	/* echo $CS_totalHoursLastWeek."<br>";
	echo $CS_ICHoursLastWeek."<br>";
	echo $CS_IBHoursLastWeek."<br>";
	echo $CS_ZDHoursLastWeek."<br>";
	echo $CS_HiringHoursLastWeek."<br>";
	echo $CS_ACTHoursLastWeek."<br>";
	echo $CS_ACTOHoursLastWeek."<br>";
	echo $CS_OpenHoursLastWeek."<br>";
	echo $CS_OtherHoursLastWeek."<br>";
	echo $CS_percentIBLastWeek."<br>";
	echo $CS_percentICLastWeek."<br>";
	echo $CS_percentOtherLastWeek."<br>";
	echo $CS_percentZDLastWeek."<br>"; */

	/* if (($CS_ICHoursLastWeek + $CS_IBHoursLastWeek + $CS_ZDHoursLastWeek + $CS_HiringHoursLastWeek + $CS_ACTHoursLastWeek + $CS_ACTOHoursLastWeek + $CS_OpenHoursLastWeek + $CS_OtherHoursLastWeek + $CS_TrainerHoursLastWeek + $CS_TraineeHoursLastWeek + $CS_TCHoursLastWeek) != $CS_totalHoursLastWeek) {
		echo 'Error: hours aren\'t matching up for stats for the LastWeek';
	} */

	$CS_percentIBLastWeek = number_format((float)(($CS_IBHoursLastWeek / $CS_totalHoursLastWeek) * 100), 2, '.', '');
	$CS_percentICLastWeek = number_format((float)(($CS_ICHoursLastWeek / $CS_totalHoursLastWeek) * 100), 2, '.', '');
	$CS_percentOtherLastWeek = number_format((float)(($CS_OtherHoursLastWeek / $CS_totalHoursLastWeek) * 100), 2, '.', '');
	$CS_percentZDLastWeek = number_format((float)(($CS_ZDHoursLastWeek / $CS_totalHoursLastWeek) * 100), 2, '.', '');
	$CS_percentACTLastWeek = number_format((float)(($CS_ACTHoursLastWeek / $CS_totalHoursLastWeek) * 100), 2, '.', '');
	$CS_percentACTOLastWeek = number_format((float)(($CS_ACTOHoursLastWeek / $CS_totalHoursLastWeek) * 100), 2, '.', '');
	$CS_percentHiringLastWeek = number_format((float)(($CS_HiringHoursLastWeek / $CS_totalHoursLastWeek) * 100), 2, '.', '');
	$CS_percentOpenLastWeek = number_format((float)(($CS_OpenHoursLastWeek / $CS_totalHoursLastWeek) * 100), 2, '.', '');
	$CS_percentTrainerLastWeek = number_format((float)(($CS_TrainerHoursLastWeek / $CS_totalHoursLastWeek) * 100), 2, '.', '');
	$CS_percentTraineeLastWeek = number_format((float)(($CS_TraineeHoursLastWeek / $CS_totalHoursLastWeek) * 100), 2, '.', '');
	$CS_percentTCLastWeek = number_format((float)(($CS_TCHoursLastWeek / $CS_totalHoursLastWeek) * 100), 2, '.', '');
	$CS_percentTMLastWeek = number_format((float)(($CS_TMHoursLastWeek / $CS_totalHoursLastWeek) * 100), 2, '.', '');

	echo '<h5>IB ('.$CS_percentIBLastWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_IBHoursLastWeek.' / '.$CS_totalHoursLastWeek.' hours]</span><br><br>';
	echo '<h5>ZD: ('.$CS_percentZDLastWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_ZDHoursLastWeek.' / '.$CS_totalHoursLastWeek.' hours]</span><br><br>';
	echo '<h5>IC: ('.$CS_percentICLastWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_ICHoursLastWeek.' / '.$CS_totalHoursLastWeek.' hours]</span><br><br>';
	echo '<h5>Hiring: ('.$CS_percentHiringLastWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_HiringHoursLastWeek.' / '.$CS_totalHoursLastWeek.' hours]</span><br><br>';
	echo '<h5>ACT: ('.$CS_percentACTLastWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_ACTHoursLastWeek.' / '.$CS_totalHoursLastWeek.' hours]</span><br><br>';
	echo '<h5>ACT/O: ('.$CS_percentACTOLastWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_ACTOHoursLastWeek.' / '.$CS_totalHoursLastWeek.' hours]</span><br><br>';
	echo '<h5>Open: ('.$CS_percentOpenLastWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_OpenHoursLastWeek.' / '.$CS_totalHoursLastWeek.' hours]</span><br><br>';
	echo '<h5>Trainer (TR): ('.$CS_percentTrainerLastWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_TrainerHoursLastWeek.' / '.$CS_totalHoursLastWeek.' hours]</span><br><br>';
	echo '<h5>Trainee (TT): ('.$CS_percentTraineeLastWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_TraineeHoursLastWeek.' / '.$CS_totalHoursLastWeek.' hours]</span><br><br>';
	echo '<h5>Training Call (TC): ('.$CS_percentTCLastWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_TCHoursLastWeek.' / '.$CS_totalHoursLastWeek.' hours]</span><br><br>';
  if ($CS_TMHoursLastWeek != 0) {
  	echo '<h5>Team Meeting (TM): ('.$CS_percentTMLastWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_TMHoursLastWeek.' / '.$CS_totalHoursLastWeek.' hours]</span><br><br>';
  }
	if ($CS_OtherHoursLastWeek != 0) {
		echo '<h5>Other:  ('.$CS_percentOtherLastWeek.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_OtherHoursLastWeek.' / '.$CS_totalHoursLastWeek.' hours]</span>';

		/* echo '<div style="padding-left: 30px; color: gray; font-size: 10px;"><ul>';

		for ($i = 0; $i < count($CS_otherItemsListLastWeek); $i++) {
			echo '<li>'.$CS_otherItemsListLastWeek[$i].'</li>';
		}

		echo '</ul></div>'; */
		echo '<br><br>';
	}

	/***** CS REPORT SINCE START ******/
	echo '<div style="background-color: black; color: white; padding-left: 10px;"><h1>All Time</h1></div>';

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
	$CS_TCHoursStart = 0;
	$CS_TMHoursStart = 0;
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
	$CS_percentTCStart = 0;
	$CS_percentTMStart = 0;

	$CS_otherItemsListStart = array();

	 foreach( $focusCSSinceStart as $focus ) {

        for ($i = 4; $i < 16; $i++) {
			if ($focus[$i] != '' && $focus[$i] != 'LNCH') {
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
			if (startsWith($focus[$i], 'TC')) {
				$CS_TCHoursStart++;
			}
		}

		for ($i = 4; $i < 16; $i++) {
      if ($focus[$i] == 'TM') {
				$CS_TMHoursStart++;
			}
		}

		for ($i = 4; $i < 16; $i++) {
			if (!startsWith($focus[$i], 'IC/') && !startsWith($focus[$i], 'IB/') && !startsWith($focus[$i], 'ZD/') && $focus[$i] != '' && $focus[$i] != 'TM' && $focus[$i] != 'LNCH' && !startsWith($focus[$i], 'H/') && !startsWith($focus[$i], 'ACT/O') && !startsWith($focus[$i], 'TT') && !startsWith($focus[$i], 'TR') && $focus[$i] != 'ACT' && $focus[$i] != 'O' && $focus[$i] != 'TC') {
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

	/* if (($CS_ICHoursStart + $CS_IBHoursStart + $CS_ZDHoursStart + $CS_HiringHoursStart + $CS_ACTHoursStart + $CS_ACTOHoursStart + $CS_OpenHoursStart + $CS_OtherHoursStart + $CS_TrainerHoursStart + $CS_TraineeHoursStart + $CS_TCHoursStart) != $CS_totalHoursStart) {
		echo 'Error: hours aren\'t matching up for stats since start';
	} */

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
	$CS_percentTCStart = number_format((float)(($CS_TCHoursStart / $CS_totalHoursStart) * 100), 2, '.', '');
	$CS_percentTMStart = number_format((float)(($CS_TMHoursStart / $CS_totalHoursStart) * 100), 2, '.', '');

	echo '<h5>IB ('.$CS_percentIBStart.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_IBHoursStart.' / '.$CS_totalHoursStart.' hours]</span><br><br>';
	echo '<h5>ZD: ('.$CS_percentZDStart.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_ZDHoursStart.' / '.$CS_totalHoursStart.' hours]</span><br><br>';
	echo '<h5>IC: ('.$CS_percentICStart.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_ICHoursStart.' / '.$CS_totalHoursStart.' hours]</span><br><br>';
	echo '<h5>Hiring: ('.$CS_percentHiringStart.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_HiringHoursStart.' / '.$CS_totalHoursStart.' hours]</span><br><br>';
	echo '<h5>ACT: ('.$CS_percentACTStart.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_ACTHoursStart.' / '.$CS_totalHoursStart.' hours]</span><br><br>';
	echo '<h5>ACT/O: ('.$CS_percentACTOStart.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_ACTOHoursStart.' / '.$CS_totalHoursStart.' hours]</span><br><br>';
	echo '<h5>Open: ('.$CS_percentOpenStart.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_OpenHoursStart.' / '.$CS_totalHoursStart.' hours]</span><br><br>';
	echo '<h5>Trainer (TR): ('.$CS_percentTrainerStart.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_TrainerHoursStart.' / '.$CS_totalHoursStart.' hours]</span><br><br>';
	echo '<h5>Trainee (TT): ('.$CS_percentTraineeStart.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_TraineeHoursStart.' / '.$CS_totalHoursStart.' hours]</span><br><br>';
	echo '<h5>Training Call (TC): ('.$CS_percentTCStart.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_TCHoursStart.' / '.$CS_totalHoursStart.' hours]</span><br><br>';
	echo '<h5>Team Meeting (TM): ('.$CS_percentTMStart.'%) </h5><span style="color: gray; font-size: 10px;">['.$CS_TMHoursStart.' / '.$CS_totalHoursStart.' hours]</span><br><br>';
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

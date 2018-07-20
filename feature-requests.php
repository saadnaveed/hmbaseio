<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

function startsWith($haystack, $needle)
{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}

$date = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
$date->setTimeZone(new DateTimeZone('America/Chicago'));
$currentHour = $date->format('G');
$lastUpdated = $date->format('g:i a');
$dayOfWeek = $date->format('D');

$current_date = $date->format("Y-m-d H:i:s");
$shift_date = $date->format("Y-m-d");

$categories = [
  array(
    "name" => "Timesheets",
    "subcategories" => array (
      "Format" => "http://hmbase.io/timesheetsformat/",
      "Change" => "http://hmbase.io/timesheets-change/",
      "New Functionality" => "http://hmbase.io/timesheetsnew-functionality/",
      "Permissions" => "http://hmbase.io/timesheetspermissions/",
      "Other" => "http://hmbase.io/timesheetsother/",
      "Export" => "http://hmbase.io/timesheetsexports/",
    )
  ),
  array(
    "name" => "Schedule",
    "subcategories" => array (
      "Format" => "http://hmbase.io/scheduleformat/",
      "Change" => "http://hmbase.io/schedulechange/",
      "New Functionality" => "http://hmbase.io/schedulenew-functionality/",
      "Permissions" => "http://hmbase.io/schedulepermissions/",
      "Other" => "http://hmbase.io/scheduleother/",
      "Export" => "http://hmbase.io/scheduleexports/",
    )
  ),
  array(
    "name" => "Auto-Schedule",
    "subcategories" => array (
      "Format" => "http://hmbase.io/auto-scheduleformat/",
      "Change" => "http://hmbase.io/auto-schedulechange/",
      "New Functionality" => "http://hmbase.io/auto-schedulenew-functionality/",
      "Permissions" => "http://hmbase.io/auto-schedulepermissions/",
      "Other" => "http://hmbase.io/auto-scheduleother/",
      "Export" => "http://hmbase.io/auto-scheduleexports/",
    )
  ),
  array(
    "name" => "Clover-Specific",
    "subcategories" => array (
      "Format" => "http://hmbase.io/clover-specificformat/",
      "Change" => "http://hmbase.io/clover-specificchange/",
      "New Functionality" => "http://hmbase.io/clover-specificnew-functionality/",
      "Permissions" => "http://hmbase.io/clover-specificpermissions/",
      "Other" => "http://hmbase.io/clover-specificother/",
      "Export" => "http://hmbase.io/clover-specificexports/",
    )
  ),
  array(
    "name" => "Hiring",
    "subcategories" => array (
      "Format" => "http://hmbase.io/hiringformat/",
      "Change" => "http://hmbase.io/hiringchange/",
      "New Functionality" => "http://hmbase.io/hiringnew-functionality/",
      "Permissions" => "http://hmbase.io/hiringpermissions/",
      "Other" => "http://hmbase.io/hiringother/",
      "Export" => "http://hmbase.io/hiringexports/",
    )
  ),
  array(
    "name" => "Integrations",
    "subcategories" => array (
      "Format" => "http://hmbase.io/integrationsformat/",
      "Change" => "http://hmbase.io/integrationschange/",
      "New Functionality" => "http://hmbase.io/integrationsnew-functionality/",
      "Permissions" => "http://hmbase.io/integrationspermissions/",
      "Other" => "http://hmbase.io/integrationsother/",
      "Export" => "http://hmbase.io/integrationsexports/",
    )
  ),
  array(
    "name" => "Messaging",
    "subcategories" => array (
      "Format" => "http://hmbase.io/messagingformat/",
      "Change" => "http://hmbase.io/messagingchange/",
      "New Functionality" => "http://hmbase.io/messagingnew-functionality/",
      "Permissions" => "http://hmbase.io/messagingpermissions/",
      "Other" => "http://hmbase.io/messagingother/",
      "Export" => "http://hmbase.io/messagingexports/",
    )
  ),
  array(
    "name" => "Mobile",
    "subcategories" => array (
      "Format" => "http://hmbase.io/mobileformat/",
      "Change" => "http://hmbase.io/mobilechange/",
      "New Functionality" => "http://hmbase.io/mobilenew-functionality/",
      "Permissions" => "http://hmbase.io/mobilepermissions/",
      "Other" => "http://hmbase.io/mobileother/",
      "Export" => "http://hmbase.io/mobileexports/",
    )
  ),
  array(
    "name" => "Notifications",
    "subcategories" => array (
      "Format" => "http://hmbase.io/notificationsformat/",
      "Change" => "http://hmbase.io/notificationschange/",
      "New Functionality" => "http://hmbase.io/notificationsnew-functionality/",
      "Permissions" => "http://hmbase.io/notificationspermissions/",
      "Other" => "http://hmbase.io/notificationsother/",
      "Export" => "http://hmbase.io/notificationsexports/",
    )
  ),
  array(
    "name" => "Other",
    "subcategories" => array (
      "Format" => "http://hmbase.io/otherformat/",
      "Change" => "http://hmbase.io/otherchange/",
      "New Functionality" => "http://hmbase.io/othernew-functionality/",
      "Permissions" => "http://hmbase.io/otherpermissions/",
      "Other" => "http://hmbase.io/otherother/",
      "Export" => "http://hmbase.io/otherexports/",
    )
  ),
  array(
    "name" => "Permissions",
    "subcategories" => array (
      "Format" => "http://hmbase.io/permissionsformat/",
      "Change" => "http://hmbase.io/permissionschange/",
      "New Functionality" => "http://hmbase.io/permissionsnew-functionality/",
      "Permissions" => "http://hmbase.io/permissionspermissions/",
      "Other" => "http://hmbase.io/permissionsother/",
      "Export" => "http://hmbase.io/permissionsexports/",
    )
  ),
  array(
    "name" => "PTO",
    "subcategories" => array (
      "Format" => "http://hmbase.io/ptoformat/",
      "Change" => "http://hmbase.io/ptochange/",
      "New Functionality" => "http://hmbase.io/ptonew-functionality/",
      "Permissions" => "http://hmbase.io/ptopermissions/",
      "Other" => "http://hmbase.io/ptoother/",
      "Export" => "http://hmbase.io/ptoexports/",
    )
  ),
  array(
    "name" => "Reports",
    "subcategories" => array (
      "Format" => "http://hmbase.io/reportsformat/",
      "Change" => "http://hmbase.io/reportschange/",
      "New Functionality" => "http://hmbase.io/reportsnew-functionality/",
      "Permissions" => "http://hmbase.io/reportspermissions/",
      "Other" => "http://hmbase.io/reportsother/",
      "Export" => "http://hmbase.io/reportsexports/",
    )
  ),
  array(
    "name" => "Square-Specific",
    "subcategories" => array (
      "Format" => "http://hmbase.io/square-specificformat/",
      "Change" => "http://hmbase.io/square-specificchange/",
      "New Functionality" => "http://hmbase.io/square-specificnew-functionality/",
      "Permissions" => "http://hmbase.io/square-specificpermissions/",
      "Other" => "http://hmbase.io/square-specificother/",
      "Export" => "http://hmbase.io/square-specificexports/",
    )
  ),
  array(
    "name" => "Team",
    "subcategories" => array (
      "Format" => "http://hmbase.io/teamformat/",
      "Change" => "http://hmbase.io/teamchange/",
      "New Functionality" => "http://hmbase.io/teamnew-functionality/",
      "Permissions" => "http://hmbase.io/teampermissions/",
      "Other" => "http://hmbase.io/teamother/",
      "Export" => "http://hmbase.io/teamexports/",
    )
  ),
  array(
    "name" => "Time Clock",
    "subcategories" => array (
      "Format" => "http://hmbase.io/time-clockformat/",
      "Change" => "http://hmbase.io/time-clockchange/",
      "New Functionality" => "http://hmbase.io/time-clocknew-functionality/",
      "Permissions" => "http://hmbase.io/time-clockpermissions/",
      "Other" => "http://hmbase.io/time-clockother/",
      "Export" => "http://hmbase.io/time-clockexports/",
    )
  ),
];

echo '<div style="background-color: #8857ac; color: white; padding: 5px;"><strong>'.do_shortcode('[icon agent="fa-search-plus"]').' CS Feature Requests</strong></div>';

	/***** CS REPORT This Week ******/
	echo '<div style="padding-left: 30px; margin-top: 0px; padding-top: 10px; padding-bottom: 10px; background-color: #fcf7fc;">';

  echo '<form method="post" action="/feature-requests">
    <select name="category">';

for ($i = 0; $i < count($categories); $i++) {
  //echo "<option value=".$agentNamesArray[$i][0].">".$agentNamesArray[$i][0]."</option>";
  echo "<option ".selected($_POST['category'], $categories[$i]['name'])."value=".$i.">".$categories[$i]['name']."</option>";

}

/* New Functionality
Change
Format
Permissions
Exports
Other */

    echo '</select>
    <select name="type">
    <option '.selected($_POST['type'], 'New Functionality').'value="New Functionality">New Functionality</option>
    <option '.selected($_POST['type'], 'Change').'value="Change">Change in Current Functionality</option>
    <option '.selected($_POST['type'], 'Format').'value="Format">Format (Colors/Fonts/Layout/Views/etc…)</option>
    <option '.selected($_POST['type'], 'Permissions').'value="Permissions">Permissions</option>
    <option '.selected($_POST['type'], 'Export').'value="Export">Exports/Uploads</option>
    <option '.selected($_POST['type'], 'Other').'value="Other">Other</option>
    <br>
    <br>
    <input type="submit" value="Go"/>
  </form><br>';

     $option = isset($_POST['category']) ? $_POST['category'] : -1;
     if ($option != -1) {
       $url = $categories[$_POST['category']]['subcategories'][$_POST['type']];
       echo "<script type='text/javascript'>var link = window.top.location='$url';</script>";
       exit;
     } else {
       echo "Please select a category and type to go to the form.";
     }

  echo '</div>'


?>

<?php

echo '<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">';

error_reporting(E_ALL);
ini_set('display_errors', 1);

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
    "name" => "Dashboard",
    "subcategories" => array (
      "Format" => "http://hmbase.io/time-clockformat/",
      "How Something Currently Works" => "http://hmbase.io/time-clockHow Something Currently Works/",
      "New Feature" => "http://hmbase.io/time-clocknew-functionality/",
      "Permissions" => "http://hmbase.io/time-clockpermissions/",
      "Other" => "http://hmbase.io/time-clockother/",
      "Export" => "http://hmbase.io/time-clockexports/",
    )
  ),
  array(
    "name" => "Timesheets",
    "subcategories" => array (
      "Format" => "http://hmbase.io/timesheetsformat/",
      "How Something Currently Works" => "http://hmbase.io/timesheets-How Something Currently Works/",
      "New Feature" => "http://hmbase.io/timesheetsnew-functionality/",
      "Permissions" => "http://hmbase.io/timesheetspermissions/",
      "Other" => "http://hmbase.io/timesheetsother/",
      "Export" => "http://hmbase.io/timesheetsexports/",
    )
  ),
  array(
    "name" => "Schedule",
    "subcategories" => array (
      "Format" => "http://hmbase.io/scheduleformat/",
      "How Something Currently Works" => "http://hmbase.io/scheduleHow Something Currently Works/",
      "New Feature" => "http://hmbase.io/schedulenew-functionality/",
      "Permissions" => "http://hmbase.io/schedulepermissions/",
      "Other" => "http://hmbase.io/scheduleother/",
      "Export" => "http://hmbase.io/scheduleexports/",
    )
  ),
  array(
    "name" => "Auto-Schedule",
    "subcategories" => array (
      "Format" => "http://hmbase.io/auto-scheduleformat/",
      "How Something Currently Works" => "http://hmbase.io/auto-scheduleHow Something Currently Works/",
      "New Feature" => "http://hmbase.io/auto-schedulenew-functionality/",
      "Permissions" => "http://hmbase.io/auto-schedulepermissions/",
      "Other" => "http://hmbase.io/auto-scheduleother/",
      "Export" => "http://hmbase.io/auto-scheduleexports/",
    )
  ),
  array(
    "name" => "Clover-Specific",
    "subcategories" => array (
      "Format" => "http://hmbase.io/clover-specificformat/",
      "How Something Currently Works" => "http://hmbase.io/clover-specificHow Something Currently Works/",
      "New Feature" => "http://hmbase.io/clover-specificnew-functionality/",
      "Permissions" => "http://hmbase.io/clover-specificpermissions/",
      "Other" => "http://hmbase.io/clover-specificother/",
      "Export" => "http://hmbase.io/clover-specificexports/",
    )
  ),
  array(
    "name" => "Hiring",
    "subcategories" => array (
      "Format" => "http://hmbase.io/hiringformat/",
      "How Something Currently Works" => "http://hmbase.io/hiringHow Something Currently Works/",
      "New Feature" => "http://hmbase.io/hiringnew-functionality/",
      "Permissions" => "http://hmbase.io/hiringpermissions/",
      "Other" => "http://hmbase.io/hiringother/",
      "Export" => "http://hmbase.io/hiringexports/",
    )
  ),
  array(
    "name" => "Integrations",
    "subcategories" => array (
      "Format" => "http://hmbase.io/integrationsformat/",
      "How Something Currently Works" => "http://hmbase.io/integrationsHow Something Currently Works/",
      "New Feature" => "http://hmbase.io/integrationsnew-functionality/",
      "Permissions" => "http://hmbase.io/integrationspermissions/",
      "Other" => "http://hmbase.io/integrationsother/",
      "Export" => "http://hmbase.io/integrationsexports/",
    )
  ),
  array(
    "name" => "Messaging",
    "subcategories" => array (
      "Format" => "http://hmbase.io/messagingformat/",
      "How Something Currently Works" => "http://hmbase.io/messagingHow Something Currently Works/",
      "New Feature" => "http://hmbase.io/messagingnew-functionality/",
      "Permissions" => "http://hmbase.io/messagingpermissions/",
      "Other" => "http://hmbase.io/messagingother/",
      "Export" => "http://hmbase.io/messagingexports/",
    )
  ),
  array(
    "name" => "Mobile",
    "subcategories" => array (
      "Format" => "http://hmbase.io/mobileformat/",
      "How Something Currently Works" => "http://hmbase.io/mobileHow Something Currently Works/",
      "New Feature" => "http://hmbase.io/mobilenew-functionality/",
      "Permissions" => "http://hmbase.io/mobilepermissions/",
      "Other" => "http://hmbase.io/mobileother/",
      "Export" => "http://hmbase.io/mobileexports/",
    )
  ),
  array(
    "name" => "Notifications",
    "subcategories" => array (
      "Format" => "http://hmbase.io/notificationsformat/",
      "How Something Currently Works" => "http://hmbase.io/notificationsHow Something Currently Works/",
      "New Feature" => "http://hmbase.io/notificationsnew-functionality/",
      "Permissions" => "http://hmbase.io/notificationspermissions/",
      "Other" => "http://hmbase.io/notificationsother/",
      "Export" => "http://hmbase.io/notificationsexports/",
    )
  ),
  array(
    "name" => "Other",
    "subcategories" => array (
      "Format" => "http://hmbase.io/otherformat/",
      "How Something Currently Works" => "http://hmbase.io/otherHow Something Currently Works/",
      "New Feature" => "http://hmbase.io/othernew-functionality/",
      "Permissions" => "http://hmbase.io/otherpermissions/",
      "Other" => "http://hmbase.io/otherother/",
      "Export" => "http://hmbase.io/otherexports/",
    )
  ),
  array(
    "name" => "Permissions",
    "subcategories" => array (
      "Format" => "http://hmbase.io/permissionsformat/",
      "How Something Currently Works" => "http://hmbase.io/permissionsHow Something Currently Works/",
      "New Feature" => "http://hmbase.io/permissionsnew-functionality/",
      "Permissions" => "http://hmbase.io/permissionspermissions/",
      "Other" => "http://hmbase.io/permissionsother/",
      "Export" => "http://hmbase.io/permissionsexports/",
    )
  ),
  array(
    "name" => "PTO",
    "subcategories" => array (
      "Format" => "http://hmbase.io/ptoformat/",
      "How Something Currently Works" => "http://hmbase.io/ptoHow Something Currently Works/",
      "New Feature" => "http://hmbase.io/ptonew-functionality/",
      "Permissions" => "http://hmbase.io/ptopermissions/",
      "Other" => "http://hmbase.io/ptoother/",
      "Export" => "http://hmbase.io/ptoexports/",
    )
  ),
  array(
    "name" => "Reports",
    "subcategories" => array (
      "Format" => "http://hmbase.io/reportsformat/",
      "How Something Currently Works" => "http://hmbase.io/reportsHow Something Currently Works/",
      "New Feature" => "http://hmbase.io/reportsnew-functionality/",
      "Permissions" => "http://hmbase.io/reportspermissions/",
      "Other" => "http://hmbase.io/reportsother/",
      "Export" => "http://hmbase.io/reportsexports/",
    )
  ),
  array(
    "name" => "Square-Specific",
    "subcategories" => array (
      "Format" => "http://hmbase.io/square-specificformat/",
      "How Something Currently Works" => "http://hmbase.io/square-specificHow Something Currently Works/",
      "New Feature" => "http://hmbase.io/square-specificnew-functionality/",
      "Permissions" => "http://hmbase.io/square-specificpermissions/",
      "Other" => "http://hmbase.io/square-specificother/",
      "Export" => "http://hmbase.io/square-specificexports/",
    )
  ),
  array(
    "name" => "Team",
    "subcategories" => array (
      "Format" => "http://hmbase.io/teamformat/",
      "How Something Currently Works" => "http://hmbase.io/teamHow Something Currently Works/",
      "New Feature" => "http://hmbase.io/teamnew-functionality/",
      "Permissions" => "http://hmbase.io/teampermissions/",
      "Other" => "http://hmbase.io/teamother/",
      "Export" => "http://hmbase.io/teamexports/",
    )
  ),
  array(
    "name" => "Time Clock",
    "subcategories" => array (
      "Format" => "http://hmbase.io/time-clockformat/",
      "How Something Currently Works" => "http://hmbase.io/time-clockHow Something Currently Works/",
      "New Feature" => "http://hmbase.io/time-clocknew-functionality/",
      "Permissions" => "http://hmbase.io/time-clockpermissions/",
      "Other" => "http://hmbase.io/time-clockother/",
      "Export" => "http://hmbase.io/time-clockexports/",
    )
  ),
];

sort($categories);

echo '<div style="background-color: #8857ac; color: white; padding: 5px;"><strong>'.do_shortcode('[icon agent="fa-search-plus"]').' CS Feature Request List</strong></div>';

	echo '<div style="padding-left: 30px; margin-top: 0px; padding-top: 10px; padding-bottom: 10px; background-color: #fcf7fc;">';

  echo '';

  echo '<form method="post" action="/feature-requests-list">
  <div class="form-group">
  <label for="txtCategory">Category</label>
    <select class="form-control" id="txtCategory" name="category">';

for ($i = 0; $i < count($categories); $i++) {
  //echo "<option value=".$agentNamesArray[$i][0].">".$agentNamesArray[$i][0]."</option>";
  if ($_POST['category'] == 'Time') {
    $_POST['category'] = 'Time Clock';
  }

  echo "<option ".selected($_POST['category'], $categories[$i]['name'])."value=".$categories[$i]['name'].">".$categories[$i]['name']."</option>";

}

/* New Feature
How Something Currently Works
Format
Permissions
Exports
Other */

    echo '</div>
    <div class="form-group">
    </select>
    <label for="txtSubCategory" style="margin-top: 10px;">Subcategory</label>
    <select class="form-control" id="txtSubCategory" name="type">
    <option '.selected($_POST['type'], '-').'value="-">-</option>
    <option '.selected($_POST['type'], 'New Feature').'value="New Feature">New Feature</option>
    <option '.selected($_POST['type'], 'Change in How Something Currently Works').'value="Change in How Something Currently Works">Change in How Something Currently Works</option>
    <option '.selected($_POST['type'], 'Format').'value="Format">Format (Colors/Fonts/Layout/Views/etc…)</option>
    <option '.selected($_POST['type'], 'Permissions').'value="Permissions">Permissions</option>
    <option '.selected($_POST['type'], 'Exports').'value="Exports">Exports/Uploads</option>
    </div>
    <input class="btn btn-primary" style="margin-top: 10px; margin-bottom: 20px;" type="submit" value="Go!"/>
  </form><br>';

     $option = isset($_POST['category']) ? $_POST['category'] : -1;
     if ($option != -1) {
       if ($_POST['category'] == 'Time') {
         $_POST['category'] = 'Time Clock';
       }

       if ($_POST['type'] != '-') {
         $features = $wpdb->get_results( "SELECT feature_name, requests FROM cs_feature_requests WHERE category = '".$_POST['category']."' AND subcategory = '".$_POST['type']."' ORDER BY requests DESC LIMIT 5;", ARRAY_N);
         if (!empty($features)) {
           echo '<div style="background-color: black; color: white; padding-left: 10px;"><h1>Top 5 Requests</h1></div>';
           echo '<ul>';
           for ($i = 0; $i < count($features); $i++) {
             echo '<li><b>Feature Name:</b> '.$features[$i][0].'</b><br>';
             echo '<b>Requests:</b> '.$features[$i][1].'</span><br><br>';
           }
           echo '</ul>';
         } else {
           $url = 'http://hmbase.io/feature-request-form/?category='.$_POST['category'].'&subcategory='.$_POST['type'];
           echo 'Hmm, there\'s currently no feature requests for this category/subcategory. <a href="'.$url.'" target="_blank">Want to add one?</a>';
         }
       } else {
         $features = $wpdb->get_results( "SELECT feature_name, requests, category, subcategory FROM cs_feature_requests WHERE category = '".$_POST['category']."' ORDER BY requests DESC LIMIT 5;", ARRAY_N);
         if (!empty($features)) {
           echo '<div style="background-color: black; color: white; padding-left: 10px;"><h1>Top 5 Requests</h1></div>';
           echo '<ul>';
           for ($i = 0; $i < count($features); $i++) {
             echo '<li><b>Feature Name:</b> '.$features[$i][0].'</b><br>';
             echo '<b>Requests:</b> '.$features[$i][1].'</span><br>';
             echo '<b>Category:</b> '.$features[$i][2].'</span><br>';
             echo '<b>Subcategory:</b> '.$features[$i][3].'</span><br><br>';
           }
           echo '</ul>';
         } else {
           $url = 'http://hmbase.io/feature-request-form/?category='.$_POST['category'].'&subcategory='.$_POST['type'];
           echo 'Hmm, there\'s currently no feature requests for this category/subcategory. <a href="'.$url.'" target="_blank">Want to add one?</a>';
         }
       }
     } else {
       echo "Please select a category and subcategory to view the top 5 feature requests for a specific category/subcategory.";
       $features = $wpdb->get_results( "SELECT feature_name, requests, category, subcategory FROM cs_feature_requests ORDER BY requests DESC LIMIT 5;", ARRAY_N);
       echo '<div style="background-color: black; color: white; padding-left: 10px; margin-top: 15px;"><h1>All Time Top 5 Requests</h1></div>';
       echo '<ul>';
       for ($i = 0; $i < count($features); $i++) {
         echo '<li><b>Feature Name:</b> '.$features[$i][0].'</b><br>';
         echo '<b>Requests:</b> '.$features[$i][1].'</span><br>';
         echo '<b>Category:</b> '.$features[$i][2].'</span><br>';
         echo '<b>Subcategory:</b> '.$features[$i][3].'</span><br><br>';
       }
       echo '</ul><br>';
       echo '<a href="/feature-requests">Submit New Request</a>';
     }

  echo '</div>'


?>

<?php
/**
 * Shop! Module Entry Point
 *
 * @package    Joomla.Tutorials
 * @subpackage Modules
 * @link http://docs.joomla.org/J2.5:Creating_a_simple_module/Developing_a_Basic_Module
 * @license        GNU/GPL, see LICENSE.php
 * mod_helloworld is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

// No direct access
defined('_JEXEC' ) or die;

// Include the syndicate functions only once
require_once dirname(__FILE__) . '/helper.php';
$module = JModuleHelper::getModule('mod_careerform');
$params = new JRegistry($module->params);

define('CONST_SERVER_TIMEZONE', 'UTC');
define('CONST_SERVER_DATEFORMAT', 'YmdHis');

$str_user_timezone = 'Africa/Nairobi';
$str_server_dateformat = CONST_SERVER_DATEFORMAT;

date_default_timezone_set($str_user_timezone);

$date = new DateTime('now');
$str_server_now = $date->format($str_server_dateformat);

$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$actual_link = explode('/',$actual_link);
$actual_link = end($actual_link);
$mainlink = preg_replace('/[0-9]+/', '', $actual_link);
$jobtitle = str_replace('-',' ',$mainlink);

if (isset($_POST['submit']))
 {
     #retrieve file title
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $subject = $_POST["subject"];
        $location = $_POST["location"];

        $resume = $_FILES["resume"];
        $coverletter = $_FILES["coverletter"];

   $directoryName = '/home/isobarke/domains/isobarkenya.com/public_html/kaa/website_preview/modules/mod_careerform/images/' . $str_server_now . '/';
 
    //check if directory exist.
    if(!is_dir($directoryName)){
     
         mkdir($directoryName, 0755, true);
     
      }
    //upload resume name and path
    $tmp_resume_name = $_FILES['resume']['tmp_name'];
    $newresumePath = "/home/isobarke/domains/isobarkenya.com/public_html/kaa/website_preview/modules/mod_careerform/images/". $str_server_now . "/" .$_FILES["resume"]["name"];
    //Set coverletter name and path
    $tmp_coverletter_name = $_FILES['coverletter']['tmp_name'];
    $newcoverletterPath = "/home/isobarke/domains/isobarkenya.com/public_html/kaa/website_preview/modules/mod_careerform/images/". $str_server_now . "/" .$_FILES["coverletter"]["name"];
    #TO move the uploaded file to specific location
    move_uploaded_file($tmp_resume_name, $newresumePath);
    move_uploaded_file($tmp_coverletter_name, $newcoverletterPath);

    echo "<div class='success'><p>Your Submition has been recived. Thank you  we will contact you shortly.</p></div>";
    
    modCareerformHelper::job($firstname,$lastname,$email,$phone,$subject,$jobtitle,$location,$newresumePath,$newcoverletterPath);

}

//$dine = modDineHelper::getDiningPlace($params);
require(JModuleHelper::getLayoutPath('mod_careerform'));
?>

<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-01-30 14:58:18 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\views\_layout_signin.php 24
ERROR - 2020-01-30 14:58:21 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\models\Signin_m.php 32
ERROR - 2020-01-30 14:58:21 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\core\MY_Model.php 31
ERROR - 2020-01-30 14:58:21 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\models\Signin_m.php 51
ERROR - 2020-01-30 14:58:21 --> Severity: Notice --> Undefined property: stdClass::$usertype C:\xampp\htdocs\valuex\mvc\models\Signin_m.php 58
ERROR - 2020-01-30 14:58:21 --> Severity: Notice --> Array to string conversion C:\xampp\htdocs\valuex\mvc\models\Signin_m.php 73
ERROR - 2020-01-30 14:58:21 --> Severity: Notice --> Undefined property: stdClass::$Array C:\xampp\htdocs\valuex\mvc\models\Signin_m.php 73
ERROR - 2020-01-30 14:58:21 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\models\Signin_m.php 75
ERROR - 2020-01-30 14:58:21 --> Severity: Notice --> Array to string conversion C:\xampp\htdocs\valuex\mvc\models\Signin_m.php 89
ERROR - 2020-01-30 14:58:22 --> Severity: Notice --> Undefined index: usertypeID C:\xampp\htdocs\valuex\mvc\libraries\Admin_Controller.php 107
ERROR - 2020-01-30 14:58:22 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'then 'yes' else 'no' end) as active From VX_permissions p1 left join VX_permissi' at line 1 - Invalid query: Select p1.permissionID,p1.name,p1.description, (case when p2.roleID =  then 'yes' else 'no' end) as active From VX_permissions p1 left join VX_permission_relationships p2 ON p1.permissionID = p2.permission_id and p2.roleID = WHERE p1.name NOT IN("bulkimport","backup","update") 
ERROR - 2020-01-30 14:59:22 --> Severity: Notice --> Undefined index: usertypeID C:\xampp\htdocs\valuex\mvc\libraries\Admin_Controller.php 107
ERROR - 2020-01-30 14:59:22 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'then 'yes' else 'no' end) as active From VX_permissions p1 left join VX_permissi' at line 1 - Invalid query: Select p1.permissionID,p1.name,p1.description, (case when p2.roleID =  then 'yes' else 'no' end) as active From VX_permissions p1 left join VX_permission_relationships p2 ON p1.permissionID = p2.permission_id and p2.roleID = WHERE p1.name NOT IN("bulkimport","backup","update") 
ERROR - 2020-01-30 15:10:23 --> Query error: Unknown column 'p2.roleID' in 'field list' - Invalid query: Select p1.permissionID,p1.name,p1.description, (case when p2.roleID = 1 then 'yes' else 'no' end) as active From VX_permissions p1 left join VX_permission_relationships p2 ON p1.permissionID = p2.permission_id and p2.roleID =1 WHERE p1.name NOT IN("bulkimport","backup","update") 
ERROR - 2020-01-30 15:12:12 --> Severity: Warning --> Creating default object from empty value C:\xampp\htdocs\valuex\mvc\controllers\Dashboard.php 53
ERROR - 2020-01-30 15:12:12 --> Severity: Warning --> Creating default object from empty value C:\xampp\htdocs\valuex\mvc\controllers\Dashboard.php 58
ERROR - 2020-01-30 15:12:12 --> Severity: Warning --> Creating default object from empty value C:\xampp\htdocs\valuex\mvc\controllers\Dashboard.php 63
ERROR - 2020-01-30 15:12:12 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\views\components\page_topbar.php 6
ERROR - 2020-01-30 15:12:12 --> Could not find the language line "menu_dashboardd"
ERROR - 2020-01-30 15:12:12 --> Could not find the language line "menu_Configuration"
ERROR - 2020-01-30 15:12:12 --> Could not find the language line "menu_Airports  Master"
ERROR - 2020-01-30 15:12:12 --> Could not find the language line "menu_Definition Data"
ERROR - 2020-01-30 15:12:12 --> Could not find the language line "menu_Staff"
ERROR - 2020-01-30 15:12:12 --> Could not find the language line "menu_Datatype"
ERROR - 2020-01-30 15:12:12 --> Could not find the language line "menu_Menu"
ERROR - 2020-01-30 15:12:12 --> Could not find the language line "menu_My Airline"
ERROR - 2020-01-30 15:12:12 --> Could not find the language line "menu_Airline Client"
ERROR - 2020-01-30 15:12:12 --> Could not find the language line "menu_Airline"
ERROR - 2020-01-30 15:12:12 --> Could not find the language line "menu_cabin gallery"
ERROR - 2020-01-30 15:12:12 --> Could not find the language line "menu_cabin class mapping"
ERROR - 2020-01-30 15:12:12 --> Could not find the language line "menu_cabin mapping"
ERROR - 2020-01-30 15:12:12 --> Could not find the language line "menu_Data Feed"
ERROR - 2020-01-30 15:12:12 --> Could not find the language line "menu_Offer Management"
ERROR - 2020-01-30 15:12:12 --> Could not find the language line "menu_Eligibility Exclusion"
ERROR - 2020-01-30 15:12:12 --> Could not find the language line "menu_Auto Confirm Setup Rule"
ERROR - 2020-01-30 15:12:12 --> Could not find the language line "menu_Offers"
ERROR - 2020-01-30 15:12:12 --> Could not find the language line "menu_Bids"
ERROR - 2020-01-30 15:12:12 --> Could not find the language line "menu_Feedback"
ERROR - 2020-01-30 15:12:12 --> Could not find the language line "menu_Airline Preferences"
ERROR - 2020-01-30 15:12:12 --> Could not find the language line "menu_User Preferences"
ERROR - 2020-01-30 15:12:12 --> Could not find the language line "menu_Application Preferences"
ERROR - 2020-01-30 15:12:12 --> Severity: Notice --> Undefined index: user C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 127
ERROR - 2020-01-30 15:12:13 --> Severity: Notice --> Trying to get property 'link' of non-object C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 127
ERROR - 2020-01-30 15:12:13 --> Severity: Notice --> Undefined index: airports_master C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 127
ERROR - 2020-01-30 15:12:13 --> Severity: Notice --> Trying to get property 'link' of non-object C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 127
ERROR - 2020-01-30 15:12:13 --> Severity: Notice --> Trying to get property 'link' of non-object C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 127
ERROR - 2020-01-30 15:12:13 --> Severity: Notice --> Trying to get property 'link' of non-object C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 127
ERROR - 2020-01-30 15:12:13 --> Severity: Notice --> Undefined index: client C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 127
ERROR - 2020-01-30 15:12:13 --> Severity: Notice --> Trying to get property 'link' of non-object C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 127
ERROR - 2020-01-30 15:12:13 --> Severity: Notice --> Undefined index: eligibility_exclusion C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 127
ERROR - 2020-01-30 15:12:13 --> Severity: Notice --> Trying to get property 'link' of non-object C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 127
ERROR - 2020-01-30 15:12:13 --> Severity: Notice --> Trying to get property 'link' of non-object C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 127
ERROR - 2020-01-30 15:12:13 --> Severity: Notice --> Undefined index: sent_offer_mails C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 125
ERROR - 2020-01-30 15:12:13 --> Severity: Notice --> Undefined index: sent_offer_mails C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 129
ERROR - 2020-01-30 15:12:13 --> Severity: Notice --> Undefined index: bid_complete C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 125
ERROR - 2020-01-30 15:12:13 --> Severity: Notice --> Undefined index: bid_complete C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 129
ERROR - 2020-01-30 15:12:19 --> Severity: Notice --> Undefined variable: airlinelist C:\xampp\htdocs\valuex\mvc\controllers\User.php 155
ERROR - 2020-01-30 15:12:19 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\valuex\mvc\controllers\User.php 155
ERROR - 2020-01-30 15:12:20 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\views\components\page_topbar.php 6
ERROR - 2020-01-30 15:12:20 --> Could not find the language line "menu_dashboardd"
ERROR - 2020-01-30 15:12:20 --> Could not find the language line "menu_Configuration"
ERROR - 2020-01-30 15:12:20 --> Could not find the language line "menu_Airports  Master"
ERROR - 2020-01-30 15:12:20 --> Could not find the language line "menu_Definition Data"
ERROR - 2020-01-30 15:12:20 --> Could not find the language line "menu_Staff"
ERROR - 2020-01-30 15:12:20 --> Could not find the language line "menu_Datatype"
ERROR - 2020-01-30 15:12:20 --> Could not find the language line "menu_Menu"
ERROR - 2020-01-30 15:12:20 --> Could not find the language line "menu_My Airline"
ERROR - 2020-01-30 15:12:20 --> Could not find the language line "menu_Airline Client"
ERROR - 2020-01-30 15:12:20 --> Could not find the language line "menu_Airline"
ERROR - 2020-01-30 15:12:20 --> Could not find the language line "menu_cabin gallery"
ERROR - 2020-01-30 15:12:20 --> Could not find the language line "menu_cabin class mapping"
ERROR - 2020-01-30 15:12:20 --> Could not find the language line "menu_cabin mapping"
ERROR - 2020-01-30 15:12:20 --> Could not find the language line "menu_Data Feed"
ERROR - 2020-01-30 15:12:20 --> Could not find the language line "menu_Offer Management"
ERROR - 2020-01-30 15:12:20 --> Could not find the language line "menu_Eligibility Exclusion"
ERROR - 2020-01-30 15:12:20 --> Could not find the language line "menu_Auto Confirm Setup Rule"
ERROR - 2020-01-30 15:12:20 --> Could not find the language line "menu_Offers"
ERROR - 2020-01-30 15:12:20 --> Could not find the language line "menu_Bids"
ERROR - 2020-01-30 15:12:20 --> Could not find the language line "menu_Feedback"
ERROR - 2020-01-30 15:12:20 --> Could not find the language line "menu_Airline Preferences"
ERROR - 2020-01-30 15:12:20 --> Could not find the language line "menu_User Preferences"
ERROR - 2020-01-30 15:12:20 --> Could not find the language line "menu_Application Preferences"
ERROR - 2020-01-30 15:12:21 --> Severity: Notice --> Undefined property: stdClass::$usertype C:\xampp\htdocs\valuex\mvc\views\user\index.php 66
ERROR - 2020-01-30 15:12:21 --> Severity: Warning --> implode(): Invalid arguments passed C:\xampp\htdocs\valuex\mvc\views\user\index.php 72
ERROR - 2020-01-30 15:12:21 --> Severity: Notice --> Undefined property: stdClass::$usertype C:\xampp\htdocs\valuex\mvc\views\user\index.php 66
ERROR - 2020-01-30 15:12:21 --> Severity: Notice --> Undefined property: stdClass::$usertype C:\xampp\htdocs\valuex\mvc\views\user\index.php 66
ERROR - 2020-01-30 15:12:21 --> Severity: Notice --> Undefined property: stdClass::$usertype C:\xampp\htdocs\valuex\mvc\views\user\index.php 66
ERROR - 2020-01-30 15:12:21 --> Severity: Notice --> Undefined property: stdClass::$usertype C:\xampp\htdocs\valuex\mvc\views\user\index.php 66
ERROR - 2020-01-30 15:12:21 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\views\components\page_topbar.php 6
ERROR - 2020-01-30 15:12:21 --> Could not find the language line "menu_dashboardd"
ERROR - 2020-01-30 15:12:21 --> Could not find the language line "menu_Configuration"
ERROR - 2020-01-30 15:12:21 --> Could not find the language line "menu_Airports  Master"
ERROR - 2020-01-30 15:12:21 --> Could not find the language line "menu_Definition Data"
ERROR - 2020-01-30 15:12:22 --> Could not find the language line "menu_Staff"
ERROR - 2020-01-30 15:12:22 --> Could not find the language line "menu_Datatype"
ERROR - 2020-01-30 15:12:22 --> Could not find the language line "menu_Menu"
ERROR - 2020-01-30 15:12:22 --> Could not find the language line "menu_My Airline"
ERROR - 2020-01-30 15:12:22 --> Could not find the language line "menu_Airline Client"
ERROR - 2020-01-30 15:12:22 --> Could not find the language line "menu_Airline"
ERROR - 2020-01-30 15:12:22 --> Could not find the language line "menu_cabin gallery"
ERROR - 2020-01-30 15:12:22 --> Could not find the language line "menu_cabin class mapping"
ERROR - 2020-01-30 15:12:22 --> Could not find the language line "menu_cabin mapping"
ERROR - 2020-01-30 15:12:22 --> Could not find the language line "menu_Data Feed"
ERROR - 2020-01-30 15:12:22 --> Could not find the language line "menu_Offer Management"
ERROR - 2020-01-30 15:12:22 --> Could not find the language line "menu_Eligibility Exclusion"
ERROR - 2020-01-30 15:12:22 --> Could not find the language line "menu_Auto Confirm Setup Rule"
ERROR - 2020-01-30 15:12:22 --> Could not find the language line "menu_Offers"
ERROR - 2020-01-30 15:12:22 --> Could not find the language line "menu_Bids"
ERROR - 2020-01-30 15:12:22 --> Could not find the language line "menu_Feedback"
ERROR - 2020-01-30 15:12:22 --> Could not find the language line "menu_Airline Preferences"
ERROR - 2020-01-30 15:12:22 --> Could not find the language line "menu_User Preferences"
ERROR - 2020-01-30 15:12:22 --> Could not find the language line "menu_Application Preferences"
ERROR - 2020-01-30 15:12:22 --> Severity: Notice --> Undefined variable: active C:\xampp\htdocs\valuex\mvc\views\airports_master\index.php 31
ERROR - 2020-01-30 15:12:23 --> Severity: Notice --> Trying to get property 'create_date' of non-object C:\xampp\htdocs\valuex\mvc\models\Trigger_m.php 28
ERROR - 2020-01-30 15:12:23 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\views\components\page_topbar.php 6
ERROR - 2020-01-30 15:12:23 --> Could not find the language line "menu_dashboardd"
ERROR - 2020-01-30 15:12:23 --> Could not find the language line "menu_Configuration"
ERROR - 2020-01-30 15:12:23 --> Could not find the language line "menu_Airports  Master"
ERROR - 2020-01-30 15:12:23 --> Could not find the language line "menu_Definition Data"
ERROR - 2020-01-30 15:12:23 --> Could not find the language line "menu_Staff"
ERROR - 2020-01-30 15:12:23 --> Could not find the language line "menu_Datatype"
ERROR - 2020-01-30 15:12:23 --> Could not find the language line "menu_Menu"
ERROR - 2020-01-30 15:12:23 --> Could not find the language line "menu_My Airline"
ERROR - 2020-01-30 15:12:23 --> Could not find the language line "menu_Airline Client"
ERROR - 2020-01-30 15:12:23 --> Could not find the language line "menu_Airline"
ERROR - 2020-01-30 15:12:23 --> Could not find the language line "menu_cabin gallery"
ERROR - 2020-01-30 15:12:23 --> Could not find the language line "menu_cabin class mapping"
ERROR - 2020-01-30 15:12:23 --> Could not find the language line "menu_cabin mapping"
ERROR - 2020-01-30 15:12:23 --> Could not find the language line "menu_Data Feed"
ERROR - 2020-01-30 15:12:23 --> Could not find the language line "menu_Offer Management"
ERROR - 2020-01-30 15:12:23 --> Could not find the language line "menu_Eligibility Exclusion"
ERROR - 2020-01-30 15:12:23 --> Could not find the language line "menu_Auto Confirm Setup Rule"
ERROR - 2020-01-30 15:12:23 --> Could not find the language line "menu_Offers"
ERROR - 2020-01-30 15:12:23 --> Could not find the language line "menu_Bids"
ERROR - 2020-01-30 15:12:23 --> Could not find the language line "menu_Feedback"
ERROR - 2020-01-30 15:12:24 --> Could not find the language line "menu_Airline Preferences"
ERROR - 2020-01-30 15:12:24 --> Could not find the language line "menu_User Preferences"
ERROR - 2020-01-30 15:12:24 --> Could not find the language line "menu_Application Preferences"
ERROR - 2020-01-30 15:12:24 --> Severity: Notice --> Undefined variable: sairline_id C:\xampp\htdocs\valuex\mvc\views\marketzone\index.php 149
ERROR - 2020-01-30 15:12:24 --> Severity: Warning --> implode(): Invalid arguments passed C:\xampp\htdocs\valuex\mvc\views\marketzone\index.php 455
ERROR - 2020-01-30 15:12:24 --> Severity: Warning --> implode(): Invalid arguments passed C:\xampp\htdocs\valuex\mvc\views\marketzone\index.php 458
ERROR - 2020-01-30 15:12:24 --> Severity: Warning --> implode(): Invalid arguments passed C:\xampp\htdocs\valuex\mvc\views\marketzone\index.php 461
ERROR - 2020-01-30 15:12:24 --> Severity: Notice --> Trying to get property 'create_date' of non-object C:\xampp\htdocs\valuex\mvc\models\Trigger_m.php 28
ERROR - 2020-01-30 15:12:24 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\views\components\page_topbar.php 6
ERROR - 2020-01-30 15:12:24 --> Could not find the language line "menu_dashboardd"
ERROR - 2020-01-30 15:12:24 --> Could not find the language line "menu_Configuration"
ERROR - 2020-01-30 15:12:24 --> Could not find the language line "menu_Airports  Master"
ERROR - 2020-01-30 15:12:25 --> Could not find the language line "menu_Definition Data"
ERROR - 2020-01-30 15:12:25 --> Could not find the language line "menu_Staff"
ERROR - 2020-01-30 15:12:25 --> Could not find the language line "menu_Datatype"
ERROR - 2020-01-30 15:12:25 --> Could not find the language line "menu_Menu"
ERROR - 2020-01-30 15:12:25 --> Could not find the language line "menu_My Airline"
ERROR - 2020-01-30 15:12:25 --> Could not find the language line "menu_Airline Client"
ERROR - 2020-01-30 15:12:25 --> Could not find the language line "menu_Airline"
ERROR - 2020-01-30 15:12:25 --> Could not find the language line "menu_cabin gallery"
ERROR - 2020-01-30 15:12:25 --> Could not find the language line "menu_cabin class mapping"
ERROR - 2020-01-30 15:12:25 --> Could not find the language line "menu_cabin mapping"
ERROR - 2020-01-30 15:12:25 --> Could not find the language line "menu_Data Feed"
ERROR - 2020-01-30 15:12:25 --> Could not find the language line "menu_Offer Management"
ERROR - 2020-01-30 15:12:25 --> Could not find the language line "menu_Eligibility Exclusion"
ERROR - 2020-01-30 15:12:25 --> Could not find the language line "menu_Auto Confirm Setup Rule"
ERROR - 2020-01-30 15:12:25 --> Could not find the language line "menu_Offers"
ERROR - 2020-01-30 15:12:25 --> Could not find the language line "menu_Bids"
ERROR - 2020-01-30 15:12:25 --> Could not find the language line "menu_Feedback"
ERROR - 2020-01-30 15:12:25 --> Could not find the language line "menu_Airline Preferences"
ERROR - 2020-01-30 15:12:25 --> Could not find the language line "menu_User Preferences"
ERROR - 2020-01-30 15:12:25 --> Could not find the language line "menu_Application Preferences"
ERROR - 2020-01-30 15:12:26 --> Severity: Notice --> Undefined variable: airlinecode C:\xampp\htdocs\valuex\mvc\views\season\index.php 141
ERROR - 2020-01-30 15:12:26 --> Severity: Warning --> implode(): Invalid arguments passed C:\xampp\htdocs\valuex\mvc\views\season\index.php 492
ERROR - 2020-01-30 15:12:26 --> Severity: Warning --> implode(): Invalid arguments passed C:\xampp\htdocs\valuex\mvc\views\season\index.php 494
ERROR - 2020-01-30 15:12:26 --> Severity: Warning --> implode(): Invalid arguments passed C:\xampp\htdocs\valuex\mvc\views\season\index.php 497
ERROR - 2020-01-30 15:12:26 --> Severity: Warning --> implode(): Invalid arguments passed C:\xampp\htdocs\valuex\mvc\views\season\index.php 499
ERROR - 2020-01-30 15:12:26 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:26 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:26 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:26 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:26 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:26 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:26 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:26 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:26 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:26 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:26 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:26 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:26 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:26 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:27 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:27 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:27 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:27 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:27 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:27 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:27 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:27 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:27 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:27 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:27 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:27 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:27 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:27 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:27 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:27 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:27 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:27 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:27 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:27 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:27 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:27 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:27 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:27 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:27 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:27 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:27 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:27 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:27 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:27 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:27 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:27 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\views\components\page_topbar.php 6
ERROR - 2020-01-30 15:12:27 --> Could not find the language line "menu_dashboardd"
ERROR - 2020-01-30 15:12:27 --> Could not find the language line "menu_Configuration"
ERROR - 2020-01-30 15:12:27 --> Could not find the language line "menu_Airports  Master"
ERROR - 2020-01-30 15:12:27 --> Could not find the language line "menu_Definition Data"
ERROR - 2020-01-30 15:12:27 --> Could not find the language line "menu_Staff"
ERROR - 2020-01-30 15:12:28 --> Could not find the language line "menu_Datatype"
ERROR - 2020-01-30 15:12:28 --> Could not find the language line "menu_Menu"
ERROR - 2020-01-30 15:12:28 --> Could not find the language line "menu_My Airline"
ERROR - 2020-01-30 15:12:28 --> Could not find the language line "menu_Airline Client"
ERROR - 2020-01-30 15:12:28 --> Could not find the language line "menu_Airline"
ERROR - 2020-01-30 15:12:28 --> Could not find the language line "menu_cabin gallery"
ERROR - 2020-01-30 15:12:28 --> Could not find the language line "menu_cabin class mapping"
ERROR - 2020-01-30 15:12:28 --> Could not find the language line "menu_cabin mapping"
ERROR - 2020-01-30 15:12:28 --> Could not find the language line "menu_Data Feed"
ERROR - 2020-01-30 15:12:28 --> Could not find the language line "menu_Offer Management"
ERROR - 2020-01-30 15:12:28 --> Could not find the language line "menu_Eligibility Exclusion"
ERROR - 2020-01-30 15:12:28 --> Could not find the language line "menu_Auto Confirm Setup Rule"
ERROR - 2020-01-30 15:12:28 --> Could not find the language line "menu_Offers"
ERROR - 2020-01-30 15:12:28 --> Could not find the language line "menu_Bids"
ERROR - 2020-01-30 15:12:28 --> Could not find the language line "menu_Feedback"
ERROR - 2020-01-30 15:12:28 --> Could not find the language line "menu_Airline Preferences"
ERROR - 2020-01-30 15:12:28 --> Could not find the language line "menu_User Preferences"
ERROR - 2020-01-30 15:12:28 --> Could not find the language line "menu_Application Preferences"
ERROR - 2020-01-30 15:12:28 --> Severity: Notice --> Undefined variable: boarding_point C:\xampp\htdocs\valuex\mvc\views\offer\index.php 21
ERROR - 2020-01-30 15:12:28 --> Severity: Notice --> Undefined variable: off_point C:\xampp\htdocs\valuex\mvc\views\offer\index.php 27
ERROR - 2020-01-30 15:12:28 --> Severity: Notice --> Undefined variable: flight_number C:\xampp\htdocs\valuex\mvc\views\offer\index.php 50
ERROR - 2020-01-30 15:12:28 --> Severity: Notice --> Undefined variable: end_flight_number C:\xampp\htdocs\valuex\mvc\views\offer\index.php 53
ERROR - 2020-01-30 15:12:28 --> Severity: Notice --> Undefined variable: dep_from_date C:\xampp\htdocs\valuex\mvc\views\offer\index.php 59
ERROR - 2020-01-30 15:12:28 --> Severity: Notice --> Undefined variable: dep_to_date C:\xampp\htdocs\valuex\mvc\views\offer\index.php 65
ERROR - 2020-01-30 15:12:28 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\views\components\page_topbar.php 6
ERROR - 2020-01-30 15:12:29 --> Could not find the language line "menu_dashboardd"
ERROR - 2020-01-30 15:12:29 --> Could not find the language line "menu_Configuration"
ERROR - 2020-01-30 15:12:29 --> Could not find the language line "menu_Airports  Master"
ERROR - 2020-01-30 15:12:29 --> Could not find the language line "menu_Definition Data"
ERROR - 2020-01-30 15:12:29 --> Could not find the language line "menu_Staff"
ERROR - 2020-01-30 15:12:29 --> Could not find the language line "menu_Datatype"
ERROR - 2020-01-30 15:12:29 --> Could not find the language line "menu_Menu"
ERROR - 2020-01-30 15:12:29 --> Could not find the language line "menu_My Airline"
ERROR - 2020-01-30 15:12:29 --> Could not find the language line "menu_Airline Client"
ERROR - 2020-01-30 15:12:29 --> Could not find the language line "menu_Airline"
ERROR - 2020-01-30 15:12:29 --> Could not find the language line "menu_cabin gallery"
ERROR - 2020-01-30 15:12:29 --> Could not find the language line "menu_cabin class mapping"
ERROR - 2020-01-30 15:12:29 --> Could not find the language line "menu_cabin mapping"
ERROR - 2020-01-30 15:12:29 --> Could not find the language line "menu_Data Feed"
ERROR - 2020-01-30 15:12:29 --> Could not find the language line "menu_Offer Management"
ERROR - 2020-01-30 15:12:29 --> Could not find the language line "menu_Eligibility Exclusion"
ERROR - 2020-01-30 15:12:29 --> Could not find the language line "menu_Auto Confirm Setup Rule"
ERROR - 2020-01-30 15:12:29 --> Could not find the language line "menu_Offers"
ERROR - 2020-01-30 15:12:29 --> Could not find the language line "menu_Bids"
ERROR - 2020-01-30 15:12:29 --> Could not find the language line "menu_Feedback"
ERROR - 2020-01-30 15:12:29 --> Could not find the language line "menu_Airline Preferences"
ERROR - 2020-01-30 15:12:29 --> Could not find the language line "menu_User Preferences"
ERROR - 2020-01-30 15:12:30 --> Could not find the language line "menu_Application Preferences"
ERROR - 2020-01-30 15:12:30 --> Severity: Notice --> Undefined variable: nbr_start C:\xampp\htdocs\valuex\mvc\views\acsr\index.php 40
ERROR - 2020-01-30 15:12:30 --> Severity: Notice --> Undefined variable: nbr_end C:\xampp\htdocs\valuex\mvc\views\acsr\index.php 46
ERROR - 2020-01-30 15:12:30 --> Severity: Notice --> Undefined variable: dep_date_start C:\xampp\htdocs\valuex\mvc\views\acsr\index.php 51
ERROR - 2020-01-30 15:12:30 --> Severity: Notice --> Undefined variable: dep_date_end C:\xampp\htdocs\valuex\mvc\views\acsr\index.php 57
ERROR - 2020-01-30 15:12:30 --> Severity: Notice --> Undefined variable: future_use C:\xampp\htdocs\valuex\mvc\views\acsr\index.php 172
ERROR - 2020-01-30 15:12:30 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:30 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:30 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:30 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:30 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:30 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:30 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:30 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\views\components\page_topbar.php 6
ERROR - 2020-01-30 15:12:30 --> Could not find the language line "menu_dashboardd"
ERROR - 2020-01-30 15:12:30 --> Could not find the language line "menu_Configuration"
ERROR - 2020-01-30 15:12:30 --> Could not find the language line "menu_Airports  Master"
ERROR - 2020-01-30 15:12:30 --> Could not find the language line "menu_Definition Data"
ERROR - 2020-01-30 15:12:31 --> Could not find the language line "menu_Staff"
ERROR - 2020-01-30 15:12:31 --> Could not find the language line "menu_Datatype"
ERROR - 2020-01-30 15:12:31 --> Could not find the language line "menu_Menu"
ERROR - 2020-01-30 15:12:31 --> Could not find the language line "menu_My Airline"
ERROR - 2020-01-30 15:12:31 --> Could not find the language line "menu_Airline Client"
ERROR - 2020-01-30 15:12:31 --> Could not find the language line "menu_Airline"
ERROR - 2020-01-30 15:12:31 --> Could not find the language line "menu_cabin gallery"
ERROR - 2020-01-30 15:12:31 --> Could not find the language line "menu_cabin class mapping"
ERROR - 2020-01-30 15:12:31 --> Could not find the language line "menu_cabin mapping"
ERROR - 2020-01-30 15:12:31 --> Could not find the language line "menu_Data Feed"
ERROR - 2020-01-30 15:12:31 --> Could not find the language line "menu_Offer Management"
ERROR - 2020-01-30 15:12:31 --> Could not find the language line "menu_Eligibility Exclusion"
ERROR - 2020-01-30 15:12:31 --> Could not find the language line "menu_Auto Confirm Setup Rule"
ERROR - 2020-01-30 15:12:31 --> Could not find the language line "menu_Offers"
ERROR - 2020-01-30 15:12:31 --> Could not find the language line "menu_Bids"
ERROR - 2020-01-30 15:12:31 --> Could not find the language line "menu_Feedback"
ERROR - 2020-01-30 15:12:31 --> Could not find the language line "menu_Airline Preferences"
ERROR - 2020-01-30 15:12:31 --> Could not find the language line "menu_User Preferences"
ERROR - 2020-01-30 15:12:31 --> Could not find the language line "menu_Application Preferences"
ERROR - 2020-01-30 15:12:31 --> Severity: Notice --> Undefined variable: default_airlineID C:\xampp\htdocs\valuex\mvc\views\eligibility_exclusion\index.php 48
ERROR - 2020-01-30 15:12:31 --> Severity: Notice --> Undefined variable: nbr_start C:\xampp\htdocs\valuex\mvc\views\eligibility_exclusion\index.php 277
ERROR - 2020-01-30 15:12:31 --> Severity: Notice --> Undefined variable: nbr_end C:\xampp\htdocs\valuex\mvc\views\eligibility_exclusion\index.php 283
ERROR - 2020-01-30 15:12:31 --> Severity: Notice --> Undefined variable: efec_date C:\xampp\htdocs\valuex\mvc\views\eligibility_exclusion\index.php 288
ERROR - 2020-01-30 15:12:31 --> Severity: Notice --> Undefined variable: disc_date C:\xampp\htdocs\valuex\mvc\views\eligibility_exclusion\index.php 294
ERROR - 2020-01-30 15:12:31 --> Severity: Notice --> Undefined variable: sexcl_id C:\xampp\htdocs\valuex\mvc\views\eligibility_exclusion\index.php 376
ERROR - 2020-01-30 15:12:32 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\views\components\page_topbar.php 6
ERROR - 2020-01-30 15:12:32 --> Could not find the language line "menu_dashboardd"
ERROR - 2020-01-30 15:12:32 --> Could not find the language line "menu_Configuration"
ERROR - 2020-01-30 15:12:32 --> Could not find the language line "menu_Airports  Master"
ERROR - 2020-01-30 15:12:32 --> Could not find the language line "menu_Definition Data"
ERROR - 2020-01-30 15:12:32 --> Could not find the language line "menu_Staff"
ERROR - 2020-01-30 15:12:32 --> Could not find the language line "menu_Datatype"
ERROR - 2020-01-30 15:12:32 --> Could not find the language line "menu_Menu"
ERROR - 2020-01-30 15:12:32 --> Could not find the language line "menu_My Airline"
ERROR - 2020-01-30 15:12:32 --> Could not find the language line "menu_Airline Client"
ERROR - 2020-01-30 15:12:32 --> Could not find the language line "menu_Airline"
ERROR - 2020-01-30 15:12:32 --> Could not find the language line "menu_cabin gallery"
ERROR - 2020-01-30 15:12:32 --> Could not find the language line "menu_cabin class mapping"
ERROR - 2020-01-30 15:12:32 --> Could not find the language line "menu_cabin mapping"
ERROR - 2020-01-30 15:12:32 --> Could not find the language line "menu_Data Feed"
ERROR - 2020-01-30 15:12:32 --> Could not find the language line "menu_Offer Management"
ERROR - 2020-01-30 15:12:32 --> Could not find the language line "menu_Eligibility Exclusion"
ERROR - 2020-01-30 15:12:32 --> Could not find the language line "menu_Auto Confirm Setup Rule"
ERROR - 2020-01-30 15:12:32 --> Could not find the language line "menu_Offers"
ERROR - 2020-01-30 15:12:32 --> Could not find the language line "menu_Bids"
ERROR - 2020-01-30 15:12:32 --> Could not find the language line "menu_Feedback"
ERROR - 2020-01-30 15:12:32 --> Could not find the language line "menu_Airline Preferences"
ERROR - 2020-01-30 15:12:32 --> Could not find the language line "menu_User Preferences"
ERROR - 2020-01-30 15:12:33 --> Could not find the language line "menu_Application Preferences"
ERROR - 2020-01-30 15:12:33 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:33 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:33 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:33 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:33 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:33 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:33 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:33 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:33 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:33 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:33 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:33 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:33 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:33 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:33 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:33 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:33 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:33 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:33 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:33 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:33 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:33 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:33 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:33 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:33 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:34 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:34 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:34 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:34 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:34 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:34 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:34 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:34 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:34 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:34 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:34 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:34 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:34 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:34 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:34 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:34 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:34 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:34 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:34 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:34 --> Severity: Notice --> Undefined property: stdClass::$VX_data_defnsID C:\xampp\htdocs\valuex\mvc\models\Airports_m.php 129
ERROR - 2020-01-30 15:12:34 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\views\components\page_topbar.php 6
ERROR - 2020-01-30 15:12:34 --> Could not find the language line "menu_dashboardd"
ERROR - 2020-01-30 15:12:34 --> Could not find the language line "menu_Configuration"
ERROR - 2020-01-30 15:12:34 --> Could not find the language line "menu_Airports  Master"
ERROR - 2020-01-30 15:12:34 --> Could not find the language line "menu_Definition Data"
ERROR - 2020-01-30 15:12:34 --> Could not find the language line "menu_Staff"
ERROR - 2020-01-30 15:12:34 --> Could not find the language line "menu_Datatype"
ERROR - 2020-01-30 15:12:34 --> Could not find the language line "menu_Menu"
ERROR - 2020-01-30 15:12:34 --> Could not find the language line "menu_My Airline"
ERROR - 2020-01-30 15:12:34 --> Could not find the language line "menu_Airline Client"
ERROR - 2020-01-30 15:12:35 --> Could not find the language line "menu_Airline"
ERROR - 2020-01-30 15:12:35 --> Could not find the language line "menu_cabin gallery"
ERROR - 2020-01-30 15:12:35 --> Could not find the language line "menu_cabin class mapping"
ERROR - 2020-01-30 15:12:35 --> Could not find the language line "menu_cabin mapping"
ERROR - 2020-01-30 15:12:35 --> Could not find the language line "menu_Data Feed"
ERROR - 2020-01-30 15:12:35 --> Could not find the language line "menu_Offer Management"
ERROR - 2020-01-30 15:12:35 --> Could not find the language line "menu_Eligibility Exclusion"
ERROR - 2020-01-30 15:12:35 --> Could not find the language line "menu_Auto Confirm Setup Rule"
ERROR - 2020-01-30 15:12:35 --> Could not find the language line "menu_Offers"
ERROR - 2020-01-30 15:12:35 --> Could not find the language line "menu_Bids"
ERROR - 2020-01-30 15:12:35 --> Could not find the language line "menu_Feedback"
ERROR - 2020-01-30 15:12:35 --> Could not find the language line "menu_Airline Preferences"
ERROR - 2020-01-30 15:12:35 --> Could not find the language line "menu_User Preferences"
ERROR - 2020-01-30 15:12:35 --> Could not find the language line "menu_Application Preferences"
ERROR - 2020-01-30 15:12:35 --> Severity: Notice --> Undefined variable: boarding_point C:\xampp\htdocs\valuex\mvc\views\offer_table\index.php 11
ERROR - 2020-01-30 15:12:35 --> Severity: Notice --> Undefined variable: off_point C:\xampp\htdocs\valuex\mvc\views\offer_table\index.php 17
ERROR - 2020-01-30 15:12:35 --> Severity: Notice --> Undefined variable: flight_number C:\xampp\htdocs\valuex\mvc\views\offer_table\index.php 69
ERROR - 2020-01-30 15:12:35 --> Severity: Notice --> Undefined variable: end_flight_number C:\xampp\htdocs\valuex\mvc\views\offer_table\index.php 72
ERROR - 2020-01-30 15:12:35 --> Severity: Notice --> Undefined variable: dep_from_date C:\xampp\htdocs\valuex\mvc\views\offer_table\index.php 78
ERROR - 2020-01-30 15:12:35 --> Severity: Notice --> Undefined variable: dep_to_date C:\xampp\htdocs\valuex\mvc\views\offer_table\index.php 84
ERROR - 2020-01-30 15:12:36 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\views\components\page_topbar.php 6
ERROR - 2020-01-30 15:12:36 --> Could not find the language line "menu_dashboardd"
ERROR - 2020-01-30 15:12:36 --> Could not find the language line "menu_Configuration"
ERROR - 2020-01-30 15:12:36 --> Could not find the language line "menu_Airports  Master"
ERROR - 2020-01-30 15:12:36 --> Could not find the language line "menu_Definition Data"
ERROR - 2020-01-30 15:12:36 --> Could not find the language line "menu_Staff"
ERROR - 2020-01-30 15:12:36 --> Could not find the language line "menu_Datatype"
ERROR - 2020-01-30 15:12:36 --> Could not find the language line "menu_Menu"
ERROR - 2020-01-30 15:12:36 --> Could not find the language line "menu_My Airline"
ERROR - 2020-01-30 15:12:36 --> Could not find the language line "menu_Airline Client"
ERROR - 2020-01-30 15:12:36 --> Could not find the language line "menu_Airline"
ERROR - 2020-01-30 15:12:36 --> Could not find the language line "menu_cabin gallery"
ERROR - 2020-01-30 15:12:36 --> Could not find the language line "menu_cabin class mapping"
ERROR - 2020-01-30 15:12:36 --> Could not find the language line "menu_cabin mapping"
ERROR - 2020-01-30 15:12:36 --> Could not find the language line "menu_Data Feed"
ERROR - 2020-01-30 15:12:36 --> Could not find the language line "menu_Offer Management"
ERROR - 2020-01-30 15:12:36 --> Could not find the language line "menu_Eligibility Exclusion"
ERROR - 2020-01-30 15:12:36 --> Could not find the language line "menu_Auto Confirm Setup Rule"
ERROR - 2020-01-30 15:12:36 --> Could not find the language line "menu_Offers"
ERROR - 2020-01-30 15:12:36 --> Could not find the language line "menu_Bids"
ERROR - 2020-01-30 15:12:36 --> Could not find the language line "menu_Feedback"
ERROR - 2020-01-30 15:12:36 --> Could not find the language line "menu_Airline Preferences"
ERROR - 2020-01-30 15:12:36 --> Could not find the language line "menu_User Preferences"
ERROR - 2020-01-30 15:12:36 --> Could not find the language line "menu_Application Preferences"
ERROR - 2020-01-30 15:12:37 --> Severity: Notice --> Undefined index: bSearchable_11 C:\xampp\htdocs\valuex\mvc\controllers\Marketzone.php 633
ERROR - 2020-01-30 15:12:37 --> Severity: Notice --> Undefined index: bSearchable_12 C:\xampp\htdocs\valuex\mvc\controllers\Marketzone.php 633
ERROR - 2020-01-30 15:12:37 --> Severity: Notice --> Undefined index: bSearchable_13 C:\xampp\htdocs\valuex\mvc\controllers\Marketzone.php 633
ERROR - 2020-01-30 15:12:37 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Marketzone.php 800
ERROR - 2020-01-30 15:12:37 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Marketzone.php 800
ERROR - 2020-01-30 15:12:37 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Marketzone.php 800
ERROR - 2020-01-30 15:12:37 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Marketzone.php 800
ERROR - 2020-01-30 15:12:37 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Marketzone.php 800
ERROR - 2020-01-30 15:12:37 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Marketzone.php 800
ERROR - 2020-01-30 15:12:37 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Marketzone.php 800
ERROR - 2020-01-30 15:12:37 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Marketzone.php 800
ERROR - 2020-01-30 15:12:37 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Marketzone.php 800
ERROR - 2020-01-30 15:12:37 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Marketzone.php 800
ERROR - 2020-01-30 15:12:37 --> Severity: Notice --> Undefined variable: sub_id C:\xampp\htdocs\valuex\mvc\controllers\Marketzone.php 401
ERROR - 2020-01-30 15:12:38 --> Severity: Notice --> Undefined property: stdClass::$season_id C:\xampp\htdocs\valuex\mvc\controllers\Offer_issue.php 450
ERROR - 2020-01-30 15:12:38 --> Severity: Notice --> Undefined property: stdClass::$season_id C:\xampp\htdocs\valuex\mvc\controllers\Offer_issue.php 450
ERROR - 2020-01-30 15:12:38 --> Severity: Notice --> Undefined property: stdClass::$season_id C:\xampp\htdocs\valuex\mvc\controllers\Offer_issue.php 450
ERROR - 2020-01-30 15:12:38 --> Severity: Notice --> Undefined property: stdClass::$season_id C:\xampp\htdocs\valuex\mvc\controllers\Offer_issue.php 450
ERROR - 2020-01-30 15:12:38 --> Severity: Notice --> Undefined property: stdClass::$season_id C:\xampp\htdocs\valuex\mvc\controllers\Offer_issue.php 450
ERROR - 2020-01-30 15:12:38 --> Severity: Notice --> Undefined property: stdClass::$season_id C:\xampp\htdocs\valuex\mvc\controllers\Offer_issue.php 450
ERROR - 2020-01-30 15:12:38 --> Severity: Notice --> Undefined property: stdClass::$season_id C:\xampp\htdocs\valuex\mvc\controllers\Offer_issue.php 450
ERROR - 2020-01-30 15:12:38 --> Severity: Notice --> Undefined property: stdClass::$season_id C:\xampp\htdocs\valuex\mvc\controllers\Offer_issue.php 450
ERROR - 2020-01-30 15:12:38 --> Severity: Notice --> Undefined property: stdClass::$season_id C:\xampp\htdocs\valuex\mvc\controllers\Offer_issue.php 450
ERROR - 2020-01-30 15:12:38 --> Severity: Notice --> Undefined property: stdClass::$season_id C:\xampp\htdocs\valuex\mvc\controllers\Offer_issue.php 450
ERROR - 2020-01-30 15:12:38 --> Severity: Warning --> Use of undefined constant Cabin - assumed 'Cabin' (this will throw an Error in a future version of PHP) C:\xampp\htdocs\valuex\mvc\controllers\Airline_cabin_class.php 476
ERROR - 2020-01-30 15:12:39 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Season.php 759
ERROR - 2020-01-30 15:12:39 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Season.php 759
ERROR - 2020-01-30 15:12:39 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Season.php 759
ERROR - 2020-01-30 15:12:39 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Season.php 759
ERROR - 2020-01-30 15:12:39 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Season.php 759
ERROR - 2020-01-30 15:12:39 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Season.php 759
ERROR - 2020-01-30 15:12:39 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Season.php 759
ERROR - 2020-01-30 15:12:39 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Season.php 759
ERROR - 2020-01-30 15:12:39 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Season.php 759
ERROR - 2020-01-30 15:12:39 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Season.php 759
ERROR - 2020-01-30 15:12:39 --> Severity: Notice --> Undefined property: stdClass::$image C:\xampp\htdocs\valuex\mvc\controllers\Client.php 708
ERROR - 2020-01-30 15:12:39 --> Severity: Notice --> Undefined property: stdClass::$image C:\xampp\htdocs\valuex\mvc\controllers\Client.php 708
ERROR - 2020-01-30 15:12:39 --> Severity: Notice --> Undefined property: stdClass::$image C:\xampp\htdocs\valuex\mvc\controllers\Client.php 708
ERROR - 2020-01-30 15:12:39 --> Severity: Notice --> Undefined property: stdClass::$image C:\xampp\htdocs\valuex\mvc\controllers\Client.php 708
ERROR - 2020-01-30 15:12:39 --> Severity: Notice --> Undefined property: stdClass::$image C:\xampp\htdocs\valuex\mvc\controllers\Client.php 708
ERROR - 2020-01-30 15:12:39 --> Severity: Notice --> Undefined property: stdClass::$image C:\xampp\htdocs\valuex\mvc\controllers\Client.php 708
ERROR - 2020-01-30 15:12:39 --> Severity: Notice --> Undefined property: stdClass::$image C:\xampp\htdocs\valuex\mvc\controllers\Client.php 708
ERROR - 2020-01-30 15:12:39 --> Severity: Notice --> Undefined property: stdClass::$image C:\xampp\htdocs\valuex\mvc\controllers\Client.php 708
ERROR - 2020-01-30 15:12:39 --> Severity: Notice --> Undefined property: stdClass::$image C:\xampp\htdocs\valuex\mvc\controllers\Client.php 708
ERROR - 2020-01-30 15:12:39 --> Severity: Notice --> Undefined property: stdClass::$image C:\xampp\htdocs\valuex\mvc\controllers\Client.php 708
ERROR - 2020-01-30 15:12:40 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\valuex\mvc\controllers\Marketzone.php 483
ERROR - 2020-01-30 15:12:40 --> Severity: Notice --> Undefined index: bSearchable_18 C:\xampp\htdocs\valuex\mvc\controllers\Eligibility_exclusion.php 815
ERROR - 2020-01-30 15:12:40 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Eligibility_exclusion.php 1066
ERROR - 2020-01-30 15:12:40 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Eligibility_exclusion.php 1066
ERROR - 2020-01-30 15:12:40 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Eligibility_exclusion.php 1066
ERROR - 2020-01-30 15:12:40 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Eligibility_exclusion.php 1066
ERROR - 2020-01-30 15:12:40 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Eligibility_exclusion.php 1066
ERROR - 2020-01-30 15:12:40 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Eligibility_exclusion.php 1066
ERROR - 2020-01-30 15:12:41 --> Severity: Warning --> Use of undefined constant Cabin - assumed 'Cabin' (this will throw an Error in a future version of PHP) C:\xampp\htdocs\valuex\mvc\controllers\Airline_cabin_class.php 476
ERROR - 2020-01-30 15:12:41 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\valuex\mvc\controllers\Marketzone.php 483
ERROR - 2020-01-30 15:12:41 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Airports_master.php 566
ERROR - 2020-01-30 15:12:41 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Airports_master.php 566
ERROR - 2020-01-30 15:12:42 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Airports_master.php 566
ERROR - 2020-01-30 15:12:42 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Airports_master.php 566
ERROR - 2020-01-30 15:12:42 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Airports_master.php 566
ERROR - 2020-01-30 15:12:42 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Airports_master.php 566
ERROR - 2020-01-30 15:12:42 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Airports_master.php 566
ERROR - 2020-01-30 15:12:42 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Airports_master.php 566
ERROR - 2020-01-30 15:12:42 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Airports_master.php 566
ERROR - 2020-01-30 15:12:42 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Airports_master.php 566
ERROR - 2020-01-30 15:12:42 --> Severity: Notice --> Undefined variable: sub_id C:\xampp\htdocs\valuex\mvc\controllers\Marketzone.php 401
ERROR - 2020-01-30 15:12:43 --> Severity: Notice --> Undefined index: bSearchable_20 C:\xampp\htdocs\valuex\mvc\controllers\Offer_table.php 313
ERROR - 2020-01-30 15:12:43 --> Severity: Notice --> Undefined index: bSearchable_21 C:\xampp\htdocs\valuex\mvc\controllers\Offer_table.php 313
ERROR - 2020-01-30 15:12:43 --> Severity: Notice --> Undefined index: bSearchable_22 C:\xampp\htdocs\valuex\mvc\controllers\Offer_table.php 313
ERROR - 2020-01-30 15:12:44 --> Could not find the language line "view"
ERROR - 2020-01-30 15:12:44 --> Could not find the language line "view"
ERROR - 2020-01-30 15:12:44 --> Could not find the language line "view"
ERROR - 2020-01-30 15:12:44 --> Could not find the language line "view"
ERROR - 2020-01-30 15:12:44 --> Could not find the language line "view"
ERROR - 2020-01-30 15:12:44 --> Could not find the language line "view"
ERROR - 2020-01-30 15:12:44 --> Could not find the language line "view"
ERROR - 2020-01-30 15:12:44 --> Could not find the language line "view"
ERROR - 2020-01-30 15:12:44 --> Could not find the language line "view"
ERROR - 2020-01-30 15:12:44 --> Severity: Notice --> Undefined variable: sub_id C:\xampp\htdocs\valuex\mvc\controllers\Marketzone.php 401
ERROR - 2020-01-30 15:12:45 --> Severity: Notice --> Undefined variable: sub_id C:\xampp\htdocs\valuex\mvc\controllers\Marketzone.php 401
ERROR - 2020-01-30 15:12:45 --> Severity: Notice --> Undefined variable: sub_id C:\xampp\htdocs\valuex\mvc\controllers\Marketzone.php 401
ERROR - 2020-01-30 15:12:45 --> Severity: Notice --> Undefined variable: sub_id C:\xampp\htdocs\valuex\mvc\controllers\Marketzone.php 401
ERROR - 2020-01-30 15:13:57 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\views\components\page_topbar.php 6
ERROR - 2020-01-30 15:13:57 --> Could not find the language line "menu_dashboardd"
ERROR - 2020-01-30 15:13:57 --> Could not find the language line "menu_Configuration"
ERROR - 2020-01-30 15:13:57 --> Could not find the language line "menu_Airports  Master"
ERROR - 2020-01-30 15:13:57 --> Could not find the language line "menu_Definition Data"
ERROR - 2020-01-30 15:13:57 --> Could not find the language line "menu_Staff"
ERROR - 2020-01-30 15:13:57 --> Could not find the language line "menu_Datatype"
ERROR - 2020-01-30 15:13:57 --> Could not find the language line "menu_Menu"
ERROR - 2020-01-30 15:13:57 --> Could not find the language line "menu_My Airline"
ERROR - 2020-01-30 15:13:57 --> Could not find the language line "menu_Airline Client"
ERROR - 2020-01-30 15:13:57 --> Could not find the language line "menu_Airline"
ERROR - 2020-01-30 15:13:57 --> Could not find the language line "menu_cabin gallery"
ERROR - 2020-01-30 15:13:57 --> Could not find the language line "menu_cabin class mapping"
ERROR - 2020-01-30 15:13:57 --> Could not find the language line "menu_cabin mapping"
ERROR - 2020-01-30 15:13:57 --> Could not find the language line "menu_Data Feed"
ERROR - 2020-01-30 15:13:57 --> Could not find the language line "menu_Offer Management"
ERROR - 2020-01-30 15:13:57 --> Could not find the language line "menu_Eligibility Exclusion"
ERROR - 2020-01-30 15:13:57 --> Could not find the language line "menu_Auto Confirm Setup Rule"
ERROR - 2020-01-30 15:13:57 --> Could not find the language line "menu_Offers"
ERROR - 2020-01-30 15:13:57 --> Could not find the language line "menu_Bids"
ERROR - 2020-01-30 15:13:57 --> Could not find the language line "menu_Feedback"
ERROR - 2020-01-30 15:13:57 --> Could not find the language line "menu_Airline Preferences"
ERROR - 2020-01-30 15:13:57 --> Could not find the language line "menu_User Preferences"
ERROR - 2020-01-30 15:13:58 --> Could not find the language line "menu_Application Preferences"
ERROR - 2020-01-30 15:13:58 --> Severity: Notice --> Undefined variable: active C:\xampp\htdocs\valuex\mvc\views\airports_master\index.php 31
ERROR - 2020-01-30 15:13:58 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\views\components\page_topbar.php 6
ERROR - 2020-01-30 15:13:58 --> Could not find the language line "menu_dashboardd"
ERROR - 2020-01-30 15:13:58 --> Could not find the language line "menu_Configuration"
ERROR - 2020-01-30 15:13:58 --> Could not find the language line "menu_Airports  Master"
ERROR - 2020-01-30 15:13:58 --> Could not find the language line "menu_Definition Data"
ERROR - 2020-01-30 15:13:58 --> Could not find the language line "menu_Staff"
ERROR - 2020-01-30 15:13:58 --> Could not find the language line "menu_Datatype"
ERROR - 2020-01-30 15:13:58 --> Could not find the language line "menu_Menu"
ERROR - 2020-01-30 15:13:58 --> Could not find the language line "menu_My Airline"
ERROR - 2020-01-30 15:13:58 --> Could not find the language line "menu_Airline Client"
ERROR - 2020-01-30 15:13:58 --> Could not find the language line "menu_Airline"
ERROR - 2020-01-30 15:13:58 --> Could not find the language line "menu_cabin gallery"
ERROR - 2020-01-30 15:13:58 --> Could not find the language line "menu_cabin class mapping"
ERROR - 2020-01-30 15:13:58 --> Could not find the language line "menu_cabin mapping"
ERROR - 2020-01-30 15:13:58 --> Could not find the language line "menu_Data Feed"
ERROR - 2020-01-30 15:13:58 --> Could not find the language line "menu_Offer Management"
ERROR - 2020-01-30 15:13:58 --> Could not find the language line "menu_Eligibility Exclusion"
ERROR - 2020-01-30 15:13:59 --> Could not find the language line "menu_Auto Confirm Setup Rule"
ERROR - 2020-01-30 15:13:59 --> Could not find the language line "menu_Offers"
ERROR - 2020-01-30 15:13:59 --> Could not find the language line "menu_Bids"
ERROR - 2020-01-30 15:13:59 --> Could not find the language line "menu_Feedback"
ERROR - 2020-01-30 15:13:59 --> Could not find the language line "menu_Airline Preferences"
ERROR - 2020-01-30 15:13:59 --> Could not find the language line "menu_User Preferences"
ERROR - 2020-01-30 15:13:59 --> Could not find the language line "menu_Application Preferences"
ERROR - 2020-01-30 15:13:59 --> Severity: Notice --> Undefined variable: airlinelist C:\xampp\htdocs\valuex\mvc\controllers\User.php 155
ERROR - 2020-01-30 15:13:59 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\valuex\mvc\controllers\User.php 155
ERROR - 2020-01-30 15:13:59 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\views\components\page_topbar.php 6
ERROR - 2020-01-30 15:13:59 --> Could not find the language line "menu_dashboardd"
ERROR - 2020-01-30 15:13:59 --> Could not find the language line "menu_Configuration"
ERROR - 2020-01-30 15:13:59 --> Could not find the language line "menu_Airports  Master"
ERROR - 2020-01-30 15:13:59 --> Could not find the language line "menu_Definition Data"
ERROR - 2020-01-30 15:13:59 --> Could not find the language line "menu_Staff"
ERROR - 2020-01-30 15:13:59 --> Could not find the language line "menu_Datatype"
ERROR - 2020-01-30 15:13:59 --> Could not find the language line "menu_Menu"
ERROR - 2020-01-30 15:14:00 --> Could not find the language line "menu_My Airline"
ERROR - 2020-01-30 15:14:00 --> Could not find the language line "menu_Airline Client"
ERROR - 2020-01-30 15:14:00 --> Could not find the language line "menu_Airline"
ERROR - 2020-01-30 15:14:00 --> Could not find the language line "menu_cabin gallery"
ERROR - 2020-01-30 15:14:00 --> Could not find the language line "menu_cabin class mapping"
ERROR - 2020-01-30 15:14:00 --> Could not find the language line "menu_cabin mapping"
ERROR - 2020-01-30 15:14:00 --> Could not find the language line "menu_Data Feed"
ERROR - 2020-01-30 15:14:00 --> Could not find the language line "menu_Offer Management"
ERROR - 2020-01-30 15:14:00 --> Could not find the language line "menu_Eligibility Exclusion"
ERROR - 2020-01-30 15:14:00 --> Could not find the language line "menu_Auto Confirm Setup Rule"
ERROR - 2020-01-30 15:14:00 --> Could not find the language line "menu_Offers"
ERROR - 2020-01-30 15:14:00 --> Could not find the language line "menu_Bids"
ERROR - 2020-01-30 15:14:00 --> Could not find the language line "menu_Feedback"
ERROR - 2020-01-30 15:14:00 --> Could not find the language line "menu_Airline Preferences"
ERROR - 2020-01-30 15:14:00 --> Could not find the language line "menu_User Preferences"
ERROR - 2020-01-30 15:14:00 --> Could not find the language line "menu_Application Preferences"
ERROR - 2020-01-30 15:14:00 --> Severity: Notice --> Undefined property: stdClass::$usertype C:\xampp\htdocs\valuex\mvc\views\user\index.php 66
ERROR - 2020-01-30 15:14:00 --> Severity: Warning --> implode(): Invalid arguments passed C:\xampp\htdocs\valuex\mvc\views\user\index.php 72
ERROR - 2020-01-30 15:14:00 --> Severity: Notice --> Undefined property: stdClass::$usertype C:\xampp\htdocs\valuex\mvc\views\user\index.php 66
ERROR - 2020-01-30 15:14:00 --> Severity: Notice --> Undefined property: stdClass::$usertype C:\xampp\htdocs\valuex\mvc\views\user\index.php 66
ERROR - 2020-01-30 15:14:00 --> Severity: Notice --> Undefined property: stdClass::$usertype C:\xampp\htdocs\valuex\mvc\views\user\index.php 66
ERROR - 2020-01-30 15:14:00 --> Severity: Notice --> Undefined property: stdClass::$usertype C:\xampp\htdocs\valuex\mvc\views\user\index.php 66
ERROR - 2020-01-30 15:14:01 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\views\components\page_topbar.php 6
ERROR - 2020-01-30 15:14:01 --> Could not find the language line "menu_dashboardd"
ERROR - 2020-01-30 15:14:01 --> Could not find the language line "menu_Configuration"
ERROR - 2020-01-30 15:14:01 --> Could not find the language line "menu_Airports  Master"
ERROR - 2020-01-30 15:14:01 --> Could not find the language line "menu_Definition Data"
ERROR - 2020-01-30 15:14:01 --> Could not find the language line "menu_Staff"
ERROR - 2020-01-30 15:14:01 --> Could not find the language line "menu_Datatype"
ERROR - 2020-01-30 15:14:01 --> Could not find the language line "menu_Menu"
ERROR - 2020-01-30 15:14:01 --> Could not find the language line "menu_My Airline"
ERROR - 2020-01-30 15:14:01 --> Could not find the language line "menu_Airline Client"
ERROR - 2020-01-30 15:14:01 --> Could not find the language line "menu_Airline"
ERROR - 2020-01-30 15:14:01 --> Could not find the language line "menu_cabin gallery"
ERROR - 2020-01-30 15:14:01 --> Could not find the language line "menu_cabin class mapping"
ERROR - 2020-01-30 15:14:01 --> Could not find the language line "menu_cabin mapping"
ERROR - 2020-01-30 15:14:01 --> Could not find the language line "menu_Data Feed"
ERROR - 2020-01-30 15:14:01 --> Could not find the language line "menu_Offer Management"
ERROR - 2020-01-30 15:14:01 --> Could not find the language line "menu_Eligibility Exclusion"
ERROR - 2020-01-30 15:14:01 --> Could not find the language line "menu_Auto Confirm Setup Rule"
ERROR - 2020-01-30 15:14:01 --> Could not find the language line "menu_Offers"
ERROR - 2020-01-30 15:14:01 --> Could not find the language line "menu_Bids"
ERROR - 2020-01-30 15:14:01 --> Could not find the language line "menu_Feedback"
ERROR - 2020-01-30 15:14:01 --> Could not find the language line "menu_Airline Preferences"
ERROR - 2020-01-30 15:14:02 --> Could not find the language line "menu_User Preferences"
ERROR - 2020-01-30 15:14:02 --> Could not find the language line "menu_Application Preferences"
ERROR - 2020-01-30 15:14:02 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\core\MY_Model.php 31
ERROR - 2020-01-30 15:14:02 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\views\components\page_topbar.php 6
ERROR - 2020-01-30 15:14:02 --> Could not find the language line "menu_dashboardd"
ERROR - 2020-01-30 15:14:02 --> Could not find the language line "menu_Configuration"
ERROR - 2020-01-30 15:14:02 --> Could not find the language line "menu_Airports  Master"
ERROR - 2020-01-30 15:14:02 --> Could not find the language line "menu_Definition Data"
ERROR - 2020-01-30 15:14:02 --> Could not find the language line "menu_Staff"
ERROR - 2020-01-30 15:14:02 --> Could not find the language line "menu_Datatype"
ERROR - 2020-01-30 15:14:02 --> Could not find the language line "menu_Menu"
ERROR - 2020-01-30 15:14:02 --> Could not find the language line "menu_My Airline"
ERROR - 2020-01-30 15:14:02 --> Could not find the language line "menu_Airline Client"
ERROR - 2020-01-30 15:14:03 --> Could not find the language line "menu_Airline"
ERROR - 2020-01-30 15:14:03 --> Could not find the language line "menu_cabin gallery"
ERROR - 2020-01-30 15:14:03 --> Could not find the language line "menu_cabin class mapping"
ERROR - 2020-01-30 15:14:03 --> Could not find the language line "menu_cabin mapping"
ERROR - 2020-01-30 15:14:03 --> Could not find the language line "menu_Data Feed"
ERROR - 2020-01-30 15:14:03 --> Could not find the language line "menu_Offer Management"
ERROR - 2020-01-30 15:14:03 --> Could not find the language line "menu_Eligibility Exclusion"
ERROR - 2020-01-30 15:14:03 --> Could not find the language line "menu_Auto Confirm Setup Rule"
ERROR - 2020-01-30 15:14:03 --> Could not find the language line "menu_Offers"
ERROR - 2020-01-30 15:14:03 --> Could not find the language line "menu_Bids"
ERROR - 2020-01-30 15:14:03 --> Could not find the language line "menu_Feedback"
ERROR - 2020-01-30 15:14:03 --> Could not find the language line "menu_Airline Preferences"
ERROR - 2020-01-30 15:14:03 --> Could not find the language line "menu_User Preferences"
ERROR - 2020-01-30 15:14:03 --> Could not find the language line "menu_Application Preferences"
ERROR - 2020-01-30 15:14:03 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\core\MY_Model.php 31
ERROR - 2020-01-30 15:14:03 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\views\components\page_topbar.php 6
ERROR - 2020-01-30 15:14:03 --> Could not find the language line "menu_dashboardd"
ERROR - 2020-01-30 15:14:03 --> Could not find the language line "menu_Configuration"
ERROR - 2020-01-30 15:14:04 --> Could not find the language line "menu_Airports  Master"
ERROR - 2020-01-30 15:14:04 --> Could not find the language line "menu_Definition Data"
ERROR - 2020-01-30 15:14:04 --> Could not find the language line "menu_Staff"
ERROR - 2020-01-30 15:14:04 --> Could not find the language line "menu_Datatype"
ERROR - 2020-01-30 15:14:04 --> Could not find the language line "menu_Menu"
ERROR - 2020-01-30 15:14:04 --> Could not find the language line "menu_My Airline"
ERROR - 2020-01-30 15:14:04 --> Could not find the language line "menu_Airline Client"
ERROR - 2020-01-30 15:14:04 --> Could not find the language line "menu_Airline"
ERROR - 2020-01-30 15:14:04 --> Could not find the language line "menu_cabin gallery"
ERROR - 2020-01-30 15:14:04 --> Could not find the language line "menu_cabin class mapping"
ERROR - 2020-01-30 15:14:04 --> Could not find the language line "menu_cabin mapping"
ERROR - 2020-01-30 15:14:04 --> Could not find the language line "menu_Data Feed"
ERROR - 2020-01-30 15:14:04 --> Could not find the language line "menu_Offer Management"
ERROR - 2020-01-30 15:14:04 --> Could not find the language line "menu_Eligibility Exclusion"
ERROR - 2020-01-30 15:14:04 --> Could not find the language line "menu_Auto Confirm Setup Rule"
ERROR - 2020-01-30 15:14:04 --> Could not find the language line "menu_Offers"
ERROR - 2020-01-30 15:14:04 --> Could not find the language line "menu_Bids"
ERROR - 2020-01-30 15:14:04 --> Could not find the language line "menu_Feedback"
ERROR - 2020-01-30 15:14:04 --> Could not find the language line "menu_Airline Preferences"
ERROR - 2020-01-30 15:14:04 --> Could not find the language line "menu_User Preferences"
ERROR - 2020-01-30 15:14:04 --> Could not find the language line "menu_Application Preferences"
ERROR - 2020-01-30 15:14:04 --> Severity: Notice --> Undefined variable: usertypes C:\xampp\htdocs\valuex\mvc\views\resetpassword\index.php 31
ERROR - 2020-01-30 15:14:04 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\views\resetpassword\index.php 31
ERROR - 2020-01-30 15:14:04 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\core\MY_Model.php 31
ERROR - 2020-01-30 15:14:04 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\views\components\page_topbar.php 6
ERROR - 2020-01-30 15:14:05 --> Could not find the language line "menu_dashboardd"
ERROR - 2020-01-30 15:14:05 --> Could not find the language line "menu_Configuration"
ERROR - 2020-01-30 15:14:05 --> Could not find the language line "menu_Airports  Master"
ERROR - 2020-01-30 15:14:05 --> Could not find the language line "menu_Definition Data"
ERROR - 2020-01-30 15:14:05 --> Could not find the language line "menu_Staff"
ERROR - 2020-01-30 15:14:05 --> Could not find the language line "menu_Datatype"
ERROR - 2020-01-30 15:14:05 --> Could not find the language line "menu_Menu"
ERROR - 2020-01-30 15:14:05 --> Could not find the language line "menu_My Airline"
ERROR - 2020-01-30 15:14:05 --> Could not find the language line "menu_Airline Client"
ERROR - 2020-01-30 15:14:05 --> Could not find the language line "menu_Airline"
ERROR - 2020-01-30 15:14:05 --> Could not find the language line "menu_cabin gallery"
ERROR - 2020-01-30 15:14:05 --> Could not find the language line "menu_cabin class mapping"
ERROR - 2020-01-30 15:14:05 --> Could not find the language line "menu_cabin mapping"
ERROR - 2020-01-30 15:14:05 --> Could not find the language line "menu_Data Feed"
ERROR - 2020-01-30 15:14:05 --> Could not find the language line "menu_Offer Management"
ERROR - 2020-01-30 15:14:05 --> Could not find the language line "menu_Eligibility Exclusion"
ERROR - 2020-01-30 15:14:05 --> Could not find the language line "menu_Auto Confirm Setup Rule"
ERROR - 2020-01-30 15:14:05 --> Could not find the language line "menu_Offers"
ERROR - 2020-01-30 15:14:05 --> Could not find the language line "menu_Bids"
ERROR - 2020-01-30 15:14:05 --> Could not find the language line "menu_Feedback"
ERROR - 2020-01-30 15:14:05 --> Could not find the language line "menu_Airline Preferences"
ERROR - 2020-01-30 15:14:05 --> Could not find the language line "menu_User Preferences"
ERROR - 2020-01-30 15:14:05 --> Could not find the language line "menu_Application Preferences"
ERROR - 2020-01-30 15:14:05 --> Severity: Notice --> Undefined variable: usertypes C:\xampp\htdocs\valuex\mvc\views\usertype\index.php 36
ERROR - 2020-01-30 15:14:05 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\views\usertype\index.php 36
ERROR - 2020-01-30 15:14:06 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\core\MY_Model.php 31
ERROR - 2020-01-30 15:14:06 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\views\components\page_topbar.php 6
ERROR - 2020-01-30 15:14:06 --> Could not find the language line "menu_dashboardd"
ERROR - 2020-01-30 15:14:06 --> Could not find the language line "menu_Configuration"
ERROR - 2020-01-30 15:14:06 --> Could not find the language line "menu_Airports  Master"
ERROR - 2020-01-30 15:14:06 --> Could not find the language line "menu_Definition Data"
ERROR - 2020-01-30 15:14:06 --> Could not find the language line "menu_Staff"
ERROR - 2020-01-30 15:14:06 --> Could not find the language line "menu_Datatype"
ERROR - 2020-01-30 15:14:06 --> Could not find the language line "menu_Menu"
ERROR - 2020-01-30 15:14:06 --> Could not find the language line "menu_My Airline"
ERROR - 2020-01-30 15:14:06 --> Could not find the language line "menu_Airline Client"
ERROR - 2020-01-30 15:14:06 --> Could not find the language line "menu_Airline"
ERROR - 2020-01-30 15:14:06 --> Could not find the language line "menu_cabin gallery"
ERROR - 2020-01-30 15:14:06 --> Could not find the language line "menu_cabin class mapping"
ERROR - 2020-01-30 15:14:06 --> Could not find the language line "menu_cabin mapping"
ERROR - 2020-01-30 15:14:06 --> Could not find the language line "menu_Data Feed"
ERROR - 2020-01-30 15:14:06 --> Could not find the language line "menu_Offer Management"
ERROR - 2020-01-30 15:14:06 --> Could not find the language line "menu_Eligibility Exclusion"
ERROR - 2020-01-30 15:14:06 --> Could not find the language line "menu_Auto Confirm Setup Rule"
ERROR - 2020-01-30 15:14:06 --> Could not find the language line "menu_Offers"
ERROR - 2020-01-30 15:14:06 --> Could not find the language line "menu_Bids"
ERROR - 2020-01-30 15:14:06 --> Could not find the language line "menu_Feedback"
ERROR - 2020-01-30 15:14:06 --> Could not find the language line "menu_Airline Preferences"
ERROR - 2020-01-30 15:14:06 --> Could not find the language line "menu_User Preferences"
ERROR - 2020-01-30 15:14:07 --> Could not find the language line "menu_Application Preferences"
ERROR - 2020-01-30 15:14:07 --> Severity: Notice --> Undefined variable: usertypes C:\xampp\htdocs\valuex\mvc\views\permission\index.php 30
ERROR - 2020-01-30 15:14:07 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\valuex\mvc\views\permission\index.php 30
ERROR - 2020-01-30 15:14:07 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\views\components\page_topbar.php 6
ERROR - 2020-01-30 15:14:07 --> Could not find the language line "menu_dashboardd"
ERROR - 2020-01-30 15:14:07 --> Could not find the language line "menu_Configuration"
ERROR - 2020-01-30 15:14:07 --> Could not find the language line "menu_Airports  Master"
ERROR - 2020-01-30 15:14:07 --> Could not find the language line "menu_Definition Data"
ERROR - 2020-01-30 15:14:07 --> Could not find the language line "menu_Staff"
ERROR - 2020-01-30 15:14:07 --> Could not find the language line "menu_Datatype"
ERROR - 2020-01-30 15:14:07 --> Could not find the language line "menu_Menu"
ERROR - 2020-01-30 15:14:07 --> Could not find the language line "menu_My Airline"
ERROR - 2020-01-30 15:14:07 --> Could not find the language line "menu_Airline Client"
ERROR - 2020-01-30 15:14:07 --> Could not find the language line "menu_Airline"
ERROR - 2020-01-30 15:14:07 --> Could not find the language line "menu_cabin gallery"
ERROR - 2020-01-30 15:14:07 --> Could not find the language line "menu_cabin class mapping"
ERROR - 2020-01-30 15:14:07 --> Could not find the language line "menu_cabin mapping"
ERROR - 2020-01-30 15:14:07 --> Could not find the language line "menu_Data Feed"
ERROR - 2020-01-30 15:14:07 --> Could not find the language line "menu_Offer Management"
ERROR - 2020-01-30 15:14:07 --> Could not find the language line "menu_Eligibility Exclusion"
ERROR - 2020-01-30 15:14:07 --> Could not find the language line "menu_Auto Confirm Setup Rule"
ERROR - 2020-01-30 15:14:08 --> Could not find the language line "menu_Offers"
ERROR - 2020-01-30 15:14:08 --> Could not find the language line "menu_Bids"
ERROR - 2020-01-30 15:14:08 --> Could not find the language line "menu_Feedback"
ERROR - 2020-01-30 15:14:08 --> Could not find the language line "menu_Airline Preferences"
ERROR - 2020-01-30 15:14:08 --> Could not find the language line "menu_User Preferences"
ERROR - 2020-01-30 15:14:08 --> Could not find the language line "menu_Application Preferences"
ERROR - 2020-01-30 15:14:08 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\views\components\page_topbar.php 6
ERROR - 2020-01-30 15:14:08 --> Could not find the language line "menu_dashboardd"
ERROR - 2020-01-30 15:14:08 --> Could not find the language line "menu_Configuration"
ERROR - 2020-01-30 15:14:08 --> Could not find the language line "menu_Airports  Master"
ERROR - 2020-01-30 15:14:08 --> Could not find the language line "menu_Definition Data"
ERROR - 2020-01-30 15:14:08 --> Could not find the language line "menu_Staff"
ERROR - 2020-01-30 15:14:08 --> Could not find the language line "menu_Datatype"
ERROR - 2020-01-30 15:14:08 --> Could not find the language line "menu_Menu"
ERROR - 2020-01-30 15:14:08 --> Could not find the language line "menu_My Airline"
ERROR - 2020-01-30 15:14:08 --> Could not find the language line "menu_Airline Client"
ERROR - 2020-01-30 15:14:08 --> Could not find the language line "menu_Airline"
ERROR - 2020-01-30 15:14:08 --> Could not find the language line "menu_cabin gallery"
ERROR - 2020-01-30 15:14:08 --> Could not find the language line "menu_cabin class mapping"
ERROR - 2020-01-30 15:14:09 --> Could not find the language line "menu_cabin mapping"
ERROR - 2020-01-30 15:14:09 --> Could not find the language line "menu_Data Feed"
ERROR - 2020-01-30 15:14:09 --> Could not find the language line "menu_Offer Management"
ERROR - 2020-01-30 15:14:09 --> Could not find the language line "menu_Eligibility Exclusion"
ERROR - 2020-01-30 15:14:09 --> Could not find the language line "menu_Auto Confirm Setup Rule"
ERROR - 2020-01-30 15:14:09 --> Could not find the language line "menu_Offers"
ERROR - 2020-01-30 15:14:09 --> Could not find the language line "menu_Bids"
ERROR - 2020-01-30 15:14:09 --> Could not find the language line "menu_Feedback"
ERROR - 2020-01-30 15:14:09 --> Could not find the language line "menu_Airline Preferences"
ERROR - 2020-01-30 15:14:09 --> Could not find the language line "menu_User Preferences"
ERROR - 2020-01-30 15:14:09 --> Could not find the language line "menu_Application Preferences"
ERROR - 2020-01-30 15:14:09 --> Severity: Notice --> Undefined variable: markpercentages C:\xampp\htdocs\valuex\mvc\views\setting\index.php 300
ERROR - 2020-01-30 15:14:09 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\views\setting\index.php 300
ERROR - 2020-01-30 15:14:10 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\views\components\page_topbar.php 6
ERROR - 2020-01-30 15:14:10 --> Could not find the language line "menu_dashboardd"
ERROR - 2020-01-30 15:14:10 --> Could not find the language line "menu_Configuration"
ERROR - 2020-01-30 15:14:10 --> Could not find the language line "menu_Airports  Master"
ERROR - 2020-01-30 15:14:10 --> Could not find the language line "menu_Definition Data"
ERROR - 2020-01-30 15:14:10 --> Could not find the language line "menu_Staff"
ERROR - 2020-01-30 15:14:10 --> Could not find the language line "menu_Datatype"
ERROR - 2020-01-30 15:14:10 --> Could not find the language line "menu_Menu"
ERROR - 2020-01-30 15:14:10 --> Could not find the language line "menu_My Airline"
ERROR - 2020-01-30 15:14:10 --> Could not find the language line "menu_Airline Client"
ERROR - 2020-01-30 15:14:10 --> Could not find the language line "menu_Airline"
ERROR - 2020-01-30 15:14:10 --> Could not find the language line "menu_cabin gallery"
ERROR - 2020-01-30 15:14:10 --> Could not find the language line "menu_cabin class mapping"
ERROR - 2020-01-30 15:14:10 --> Could not find the language line "menu_cabin mapping"
ERROR - 2020-01-30 15:14:10 --> Could not find the language line "menu_Data Feed"
ERROR - 2020-01-30 15:14:10 --> Could not find the language line "menu_Offer Management"
ERROR - 2020-01-30 15:14:10 --> Could not find the language line "menu_Eligibility Exclusion"
ERROR - 2020-01-30 15:14:10 --> Could not find the language line "menu_Auto Confirm Setup Rule"
ERROR - 2020-01-30 15:14:10 --> Could not find the language line "menu_Offers"
ERROR - 2020-01-30 15:14:10 --> Could not find the language line "menu_Bids"
ERROR - 2020-01-30 15:14:10 --> Could not find the language line "menu_Feedback"
ERROR - 2020-01-30 15:14:11 --> Could not find the language line "menu_Airline Preferences"
ERROR - 2020-01-30 15:14:11 --> Could not find the language line "menu_User Preferences"
ERROR - 2020-01-30 15:14:11 --> Could not find the language line "menu_Application Preferences"
ERROR - 2020-01-30 15:14:12 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Airports_master.php 566
ERROR - 2020-01-30 15:14:12 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Airports_master.php 566
ERROR - 2020-01-30 15:14:12 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Airports_master.php 566
ERROR - 2020-01-30 15:14:12 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Airports_master.php 566
ERROR - 2020-01-30 15:14:12 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Airports_master.php 566
ERROR - 2020-01-30 15:14:12 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Airports_master.php 566
ERROR - 2020-01-30 15:14:12 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Airports_master.php 566
ERROR - 2020-01-30 15:14:12 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Airports_master.php 566
ERROR - 2020-01-30 15:14:12 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Airports_master.php 566
ERROR - 2020-01-30 15:14:13 --> Severity: Notice --> Undefined property: stdClass::$action C:\xampp\htdocs\valuex\mvc\controllers\Airports_master.php 566
ERROR - 2020-01-30 16:04:53 --> Severity: Warning --> Creating default object from empty value C:\xampp\htdocs\valuex\mvc\controllers\Dashboard.php 53
ERROR - 2020-01-30 16:04:53 --> Severity: Warning --> Creating default object from empty value C:\xampp\htdocs\valuex\mvc\controllers\Dashboard.php 58
ERROR - 2020-01-30 16:04:53 --> Severity: Warning --> Creating default object from empty value C:\xampp\htdocs\valuex\mvc\controllers\Dashboard.php 63
ERROR - 2020-01-30 16:04:53 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\views\components\page_topbar.php 6
ERROR - 2020-01-30 16:04:53 --> Could not find the language line "menu_dashboardd"
ERROR - 2020-01-30 16:04:53 --> Could not find the language line "menu_Configuration"
ERROR - 2020-01-30 16:04:53 --> Could not find the language line "menu_Airports  Master"
ERROR - 2020-01-30 16:04:53 --> Could not find the language line "menu_Definition Data"
ERROR - 2020-01-30 16:04:53 --> Could not find the language line "menu_Staff"
ERROR - 2020-01-30 16:04:53 --> Could not find the language line "menu_Datatype"
ERROR - 2020-01-30 16:04:53 --> Could not find the language line "menu_Menu"
ERROR - 2020-01-30 16:04:53 --> Could not find the language line "menu_My Airline"
ERROR - 2020-01-30 16:04:53 --> Could not find the language line "menu_Airline Client"
ERROR - 2020-01-30 16:04:53 --> Could not find the language line "menu_Airline"
ERROR - 2020-01-30 16:04:53 --> Could not find the language line "menu_cabin gallery"
ERROR - 2020-01-30 16:04:53 --> Could not find the language line "menu_cabin class mapping"
ERROR - 2020-01-30 16:04:53 --> Could not find the language line "menu_cabin mapping"
ERROR - 2020-01-30 16:04:53 --> Could not find the language line "menu_Data Feed"
ERROR - 2020-01-30 16:04:53 --> Could not find the language line "menu_Offer Management"
ERROR - 2020-01-30 16:04:53 --> Could not find the language line "menu_Eligibility Exclusion"
ERROR - 2020-01-30 16:04:53 --> Could not find the language line "menu_Auto Confirm Setup Rule"
ERROR - 2020-01-30 16:04:54 --> Could not find the language line "menu_Offers"
ERROR - 2020-01-30 16:04:54 --> Could not find the language line "menu_Bids"
ERROR - 2020-01-30 16:04:54 --> Could not find the language line "menu_Feedback"
ERROR - 2020-01-30 16:04:54 --> Could not find the language line "menu_Airline Preferences"
ERROR - 2020-01-30 16:04:54 --> Could not find the language line "menu_User Preferences"
ERROR - 2020-01-30 16:04:54 --> Could not find the language line "menu_Application Preferences"
ERROR - 2020-01-30 16:04:54 --> Severity: Notice --> Undefined index: user C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 127
ERROR - 2020-01-30 16:04:54 --> Severity: Notice --> Trying to get property 'link' of non-object C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 127
ERROR - 2020-01-30 16:04:54 --> Severity: Notice --> Undefined index: airports_master C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 127
ERROR - 2020-01-30 16:04:54 --> Severity: Notice --> Trying to get property 'link' of non-object C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 127
ERROR - 2020-01-30 16:04:54 --> Severity: Notice --> Trying to get property 'link' of non-object C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 127
ERROR - 2020-01-30 16:04:54 --> Severity: Notice --> Trying to get property 'link' of non-object C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 127
ERROR - 2020-01-30 16:04:54 --> Severity: Notice --> Undefined index: client C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 127
ERROR - 2020-01-30 16:04:54 --> Severity: Notice --> Trying to get property 'link' of non-object C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 127
ERROR - 2020-01-30 16:04:54 --> Severity: Notice --> Undefined index: eligibility_exclusion C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 127
ERROR - 2020-01-30 16:04:54 --> Severity: Notice --> Trying to get property 'link' of non-object C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 127
ERROR - 2020-01-30 16:04:54 --> Severity: Notice --> Trying to get property 'link' of non-object C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 127
ERROR - 2020-01-30 16:04:54 --> Severity: Notice --> Undefined index: sent_offer_mails C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 125
ERROR - 2020-01-30 16:04:54 --> Severity: Notice --> Undefined index: sent_offer_mails C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 129
ERROR - 2020-01-30 16:04:54 --> Severity: Notice --> Undefined index: bid_complete C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 125
ERROR - 2020-01-30 16:04:54 --> Severity: Notice --> Undefined index: bid_complete C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 129
ERROR - 2020-01-30 16:04:59 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\models\Signin_m.php 253
ERROR - 2020-01-30 16:04:59 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\views\_layout_signin.php 24
ERROR - 2020-01-30 16:05:01 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\models\Signin_m.php 32
ERROR - 2020-01-30 16:05:01 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\core\MY_Model.php 31
ERROR - 2020-01-30 16:05:01 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\models\Signin_m.php 51
ERROR - 2020-01-30 16:05:01 --> Severity: Notice --> Undefined property: stdClass::$usertype C:\xampp\htdocs\valuex\mvc\models\Signin_m.php 58
ERROR - 2020-01-30 16:05:01 --> Severity: Notice --> Array to string conversion C:\xampp\htdocs\valuex\mvc\models\Signin_m.php 73
ERROR - 2020-01-30 16:05:01 --> Severity: Notice --> Undefined property: stdClass::$Array C:\xampp\htdocs\valuex\mvc\models\Signin_m.php 73
ERROR - 2020-01-30 16:05:01 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\models\Signin_m.php 75
ERROR - 2020-01-30 16:05:01 --> Severity: Notice --> Array to string conversion C:\xampp\htdocs\valuex\mvc\models\Signin_m.php 89
ERROR - 2020-01-30 16:05:02 --> Severity: Warning --> Creating default object from empty value C:\xampp\htdocs\valuex\mvc\controllers\Dashboard.php 53
ERROR - 2020-01-30 16:05:02 --> Severity: Warning --> Creating default object from empty value C:\xampp\htdocs\valuex\mvc\controllers\Dashboard.php 58
ERROR - 2020-01-30 16:05:02 --> Severity: Warning --> Creating default object from empty value C:\xampp\htdocs\valuex\mvc\controllers\Dashboard.php 63
ERROR - 2020-01-30 16:05:02 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\valuex\mvc\views\components\page_topbar.php 6
ERROR - 2020-01-30 16:05:02 --> Could not find the language line "menu_dashboardd"
ERROR - 2020-01-30 16:05:02 --> Could not find the language line "menu_Configuration"
ERROR - 2020-01-30 16:05:02 --> Could not find the language line "menu_Airports  Master"
ERROR - 2020-01-30 16:05:02 --> Could not find the language line "menu_Definition Data"
ERROR - 2020-01-30 16:05:02 --> Could not find the language line "menu_Staff"
ERROR - 2020-01-30 16:05:02 --> Could not find the language line "menu_Datatype"
ERROR - 2020-01-30 16:05:02 --> Could not find the language line "menu_Menu"
ERROR - 2020-01-30 16:05:02 --> Could not find the language line "menu_My Airline"
ERROR - 2020-01-30 16:05:02 --> Could not find the language line "menu_Airline Client"
ERROR - 2020-01-30 16:05:02 --> Could not find the language line "menu_Airline"
ERROR - 2020-01-30 16:05:02 --> Could not find the language line "menu_cabin gallery"
ERROR - 2020-01-30 16:05:02 --> Could not find the language line "menu_cabin class mapping"
ERROR - 2020-01-30 16:05:02 --> Could not find the language line "menu_cabin mapping"
ERROR - 2020-01-30 16:05:02 --> Could not find the language line "menu_Data Feed"
ERROR - 2020-01-30 16:05:02 --> Could not find the language line "menu_Offer Management"
ERROR - 2020-01-30 16:05:02 --> Could not find the language line "menu_Eligibility Exclusion"
ERROR - 2020-01-30 16:05:02 --> Could not find the language line "menu_Auto Confirm Setup Rule"
ERROR - 2020-01-30 16:05:02 --> Could not find the language line "menu_Offers"
ERROR - 2020-01-30 16:05:02 --> Could not find the language line "menu_Bids"
ERROR - 2020-01-30 16:05:02 --> Could not find the language line "menu_Feedback"
ERROR - 2020-01-30 16:05:02 --> Could not find the language line "menu_Airline Preferences"
ERROR - 2020-01-30 16:05:02 --> Could not find the language line "menu_User Preferences"
ERROR - 2020-01-30 16:05:02 --> Could not find the language line "menu_Application Preferences"
ERROR - 2020-01-30 16:05:02 --> Severity: Notice --> Undefined index: user C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 127
ERROR - 2020-01-30 16:05:02 --> Severity: Notice --> Trying to get property 'link' of non-object C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 127
ERROR - 2020-01-30 16:05:02 --> Severity: Notice --> Undefined index: airports_master C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 127
ERROR - 2020-01-30 16:05:02 --> Severity: Notice --> Trying to get property 'link' of non-object C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 127
ERROR - 2020-01-30 16:05:02 --> Severity: Notice --> Trying to get property 'link' of non-object C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 127
ERROR - 2020-01-30 16:05:02 --> Severity: Notice --> Trying to get property 'link' of non-object C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 127
ERROR - 2020-01-30 16:05:03 --> Severity: Notice --> Undefined index: client C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 127
ERROR - 2020-01-30 16:05:03 --> Severity: Notice --> Trying to get property 'link' of non-object C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 127
ERROR - 2020-01-30 16:05:03 --> Severity: Notice --> Undefined index: eligibility_exclusion C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 127
ERROR - 2020-01-30 16:05:03 --> Severity: Notice --> Trying to get property 'link' of non-object C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 127
ERROR - 2020-01-30 16:05:03 --> Severity: Notice --> Trying to get property 'link' of non-object C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 127
ERROR - 2020-01-30 16:05:03 --> Severity: Notice --> Undefined index: sent_offer_mails C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 125
ERROR - 2020-01-30 16:05:03 --> Severity: Notice --> Undefined index: sent_offer_mails C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 129
ERROR - 2020-01-30 16:05:03 --> Severity: Notice --> Undefined index: bid_complete C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 125
ERROR - 2020-01-30 16:05:03 --> Severity: Notice --> Undefined index: bid_complete C:\xampp\htdocs\valuex\mvc\views\dashboard\index.php 129

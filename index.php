<?php
error_reporting(E_ALL);

// speed things up with gzip plus ob_start() is required for csv export
if(!ob_start('ob_gzhandler'))
	ob_start();

header('Content-Type: text/html; charset=utf-8');

include('lazy_mofo.php');
//connect to database
include('db_conn.php');

echo "
<!DOCTYPE html>
<html>
<head>
	<meta charset='UTF-8'>
	<link rel='stylesheet' type='text/css' href='style.css'>
</head>
<body>
"; 

// connect with pdo 
try {
	$dbh = new PDO("mysql:host=$db_host;dbname=$db_name;", $db_user, $db_pass);
}
catch(PDOException $e) {
	die('pdo connection error: ' . $e->getMessage());
}

// create LM object, pass in PDO connection
$lm = new lazy_mofo($dbh); 


// table name for updates, inserts and deletes
$lm->table = 'data_table';


// identity / primary key for table
$lm->identity_name = 'data_id';


// optional, make friendly names for fields
$lm->rename['data_id'] = 'ID';
$lm->rename['type_id'] = 'Type';


// optional, define input controls on the form
$lm->form_input_control['photo'] = '--image';
$lm->form_input_control['document'] = '--document';
//$lm->form_input_control['html_link'] = '--link';

//$lm->form_input_control['is_active'] = "select 1, 'Yes' union select 0, 'No' union select 2, 'Maybe'; --radio";
//$lm->form_input_control['snippet_id'] = 'select snippet_id, snippet_name from snippets; --select';
$lm->form_input_control['type_id'] = 'select type_id, file_type from type; --select';


// optional, define editable input controls on the grid
//$lm->grid_input_control['is_active'] = '--checkbox';


// optional, define output control on the grid 
//$lm->grid_output_control['contact_email'] = '--email'; // make email clickable
$lm->grid_output_control['document'] = '--document'; // image clickable 
$lm->grid_output_control['photo'] = '--image'; // image clickable  
$lm->grid_output_control['html_link'] = '--link'; // image clickable  

// new in version >= 2015-02-27 all searches have to be done manually
$lm->grid_show_search_box = true;


// optional, query for grid(). LAST COLUMN MUST BE THE IDENTITY for [edit] and [delete] links to appear
$lm->grid_sql = "
select 
  d.title
, d.description
, d.details
, d.html_link
, t.file_type
, d.document
, d.photo
, d.create_date
, d.data_id
from  data_table d
left  
join  type t 
on    d.type_id = t.type_id 
where coalesce(d.title, '') like :_search 
or 	  coalesce(d.description, '') like :_search
or 	  coalesce(t.file_type, '') like :_search
or 	  coalesce(t.file_type, '') like :_search
order by d.data_id desc
";
$lm->grid_sql_param[':_search'] = '%' . trim(@$_REQUEST['_search']) . '%';


// optional, define what is displayed on edit form. identity id must be passed in also.  
$lm->form_sql = "
select
  data_id
, title
, html_link
, document
, photo
, description
, details
, type_id
from data_table 
where data_id = :data_id
";
$lm->form_sql_param[":$lm->identity_name"] = @$_REQUEST[$lm->identity_name]; 


// optional, validation. input:  regular expression (with slashes), error message, tip/placeholder
// first element can also be a user function or 'email'
$lm->on_insert_validate['snippet_name'] = array('/.+/', 'Missing Snippet Name', 'this is required'); 
//$lm->on_insert_validate['contact_email'] = array('email', 'Invalid Email', 'this is optional', true); 

// copy validation rules to update - same rules
$lm->on_update_validate = $lm->on_insert_validate;  


// use the lm controller
$lm->run();


echo "</body></html>";

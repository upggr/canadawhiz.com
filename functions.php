<?php
function loadresult($apicall) {
$xml = simplexml_load_file($apicall) 
       or die("Error: Cannot create object");	   
foreach($xml->children() as $results){
foreach($results->children() as $result => $data){
define('id', $data->id);
define('company_name', $data->company_name);
define('mailing_address', $data->mailing_address);
define('mailing_city', $data->mailing_city);
define('mailing_province', $data->mailing_province);
define('mailing_postal', $data->mailing_postal);
define('physical_address', $data->physical_address);
define('physical_city', $data->physical_city);
define('physical_province', $data->physical_province);
define('physical_postal', $data->physical_postal);
define('average_earning', $data->average_earning);
define('telephone_number', $data->telephone_number);
define('fax_number', $data->fax_number);
define('email', $data->email);
define('website', $data->website);
define('primary_contact_name', $data->primary_contact_name);
define('primary_contact_title', $data->primary_contact_title);
define('primary_contact_phone', $data->primary_contact_phone);
define('primary_contact_email', $data->primary_contact_email);
define('other_contacts', $data->other_contacts);
define('profile', $data->profile);
define('year_founded', $data->year_founded);
define('industry', $data->industry);
define('naics_primary', $data->naics_primary);
define('naics_secondary', $data->naics_secondary);
define('sic_primary', $data->sic_primary);
define('sic_secondary', $data->sic_secondary);
define('business_activity', $data->business_activity);
define('sales_volume', $data->sales_volume);
define('number_of_employees', $data->number_of_employees);
define('products_services', $data->products_services);
}}}

function loadresults($apicall) {
$xml = simplexml_load_file($apicall) 
       or die("Error: Cannot create object");	
echo '<div class="row">';      
foreach($xml->children() as $results){
foreach($results->children() as $result => $data){	
$id = $data->id;
$company_name = $data->company_name;
$physical_province = $data->physical_province;
if ($physical_province == 'British Columbia') {$physical_province = 'BC';};
if ($physical_province != '') {
echo '<div class="col-lg-4 col-sm-12 text-center"> <div class="circle">'.$physical_province.'</div><h3><a href="http://canadawhiz.com/'.$id.'/'.$company_name.'.html">'.$company_name.'</a></h3><p>'.$company_name.'</p></div>';
};
}}
echo '</div>';
}

function loadrandomresults($apicall) {
$xml = simplexml_load_file($apicall) 
       or die("Error: Cannot create object");	
echo '<div class="row">';   
foreach($xml->children() as $results){
foreach($results->children() as $result => $data){	
$id = $data->id;
$company_name = $data->company_name;
$physical_province = $data->physical_province;
if ($physical_province == 'British Columbia') {$physical_province = 'BC';};
if ($physical_province != '') {
echo '<div class="col-lg-4 col-sm-12 text-center"> <div class="circle">'.$physical_province.'</div><h3><a href="http://canadawhiz.com/'.$id.'/'.$company_name.'.html">'.$company_name.'</a></h3><p>'.$company_name.'</p></div>';
};
}}
echo '</div>';
}

function loadsitemap($apicall) {
include 'Sitemap.php';
$sitemap = new Sitemap('http://canadawhiz.com'); 
$xml = simplexml_load_file($apicall) 
       or die("Error: Cannot create object");	  
foreach($xml->children() as $results){
foreach($results->children() as $result => $data){	
$company_id = $data->id;
$company_name = $data->company_name;
 $sitemap->addItem('/'.$company_id.'/'.str_replace(' ','-',$company_name).'.html', '1.0', 'monthly', 'Today');}
 
 }
 $sitemap->createSitemapIndex('http://canadawhiz.com/', 'Today');
}

?>
<?php
//ini_set('display_errors', '1');
function getapicall($value){
if(isset($_GET['type'])) {
thelogic($_GET['type'],$value) ;
}
else { 
return 'NA'; 
}
}

function thelogic($apicall,$value) {
	switch ($apicall) {
    case "search":
        getresults($value);
        break;
    case "readresult":
        getresult($value);
        break;
	case "random":
        getrandomresults($value);
        break;	
	case "sitemap":
        getsitemap($value);
        break;				
	case "countnaicsp":
        countnaicsp($value);
        break;	
		case "countnaicss":
        countnaicss($value);
        break;	
		case "countsicp":
        countsicp($value);
        break;	
		case "countsics":
        countsics($value);
        break;		
	case "deleteresult":
        echo "delete result api $value";	
        break;
}
}

function countnaicsp($value){
include('db.php');
$sql = "Select
  count(canadawh_2.canada.ID) as theid
From
  canadawh_2.canada
Where
  canadawh_2.canada.[NAICS Primary] Like '$value%'"; 
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
echo $row{'theid'};
echo ' Records Found that start with NAICS PRIMARY '.$value.'';
}
sqlsrv_free_stmt( $stmt);		
}

function countnaicss($value){
	include('db.php');
$sql = "Select
  count(canadawh_2.canada.ID) as theid
From
  canadawh_2.canada
Where
  canadawh_2.canada.[NAICS Secondary] Like '$value%'"; 
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
echo $row{'theid'};
echo ' Records Found that start with NAICS Secondary '.$value.'';
}
sqlsrv_free_stmt( $stmt);		
}

function countsicp($value){
		include('db.php');
$sql = "Select
  count(canadawh_2.canada.ID) as theid
From
  canadawh_2.canada
Where
  canadawh_2.canada.[SIC Primary] Like '$value%'"; 
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
echo $row{'theid'};
echo ' Records Found that start with SIC Primary '.$value.'';
}
sqlsrv_free_stmt( $stmt);	
}

function countsics($value){
		include('db.php');
$sql = "Select
  count(canadawh_2.canada.ID) as theid
From
  canadawh_2.canada
Where
  canadawh_2.canada.[SIC Secondary] Like '$value%'"; 
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
echo $row{'theid'};
echo ' Records Found that start with SIC Secondary '.$value.'';
}
sqlsrv_free_stmt( $stmt);	
}

function getresults($searchterm) {
include('db.php');
$sql = "Select  top 12 canadawh_2.canada.[Company Name],canadawh_2.canada.[ID],canadawh_2.canada.[Physical Province] From canadawh_2.canada WHERE canadawh_2.canada.[Company Name] LIKE '%$searchterm%' or canadawh_2.canada.[Industry] LIKE '%$searchterm%'"; 
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}
$output = '<?xml version="1.0" encoding="iso-8859-1"?>';
$output .= '<data>';
$output .= '<results>';
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
	
$company_name = $row{'Company Name'};
$id = $row{'ID'};
$physical_province = $row{'Physical Province'};
if (!empty($row{'Physical Province'})) {
	$output .= '<result>';
$output .= "<id>$id</id>";
$output .= "<company_name><![CDATA[$company_name]]></company_name>";
$output .= "<physical_province><![CDATA[$physical_province]]></physical_province>";
	$output .= '</result>';
}}
$output .= '</results>';
$output .= '</data>';
sqlsrv_free_stmt( $stmt);	
print ($output);	
}

function getrandomresults($value) {
include('db.php');
$sql = "Select  top $value canadawh_2.canada.[Company Name],canadawh_2.canada.[ID],canadawh_2.canada.[Physical Province] From canadawh_2.canada WHERE 0.01 >= CAST(CHECKSUM(NEWID(), canadawh_2.canada.[ID]) & 0x7fffffff AS float) / CAST (0x7fffffff AS int)"; 
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}
$output = '<?xml version="1.0" encoding="iso-8859-1"?>';
$output .= '<data>';
$output .= '<results>';
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
$company_name = $row{'Company Name'};
$id = $row{'ID'};
$physical_province = $row{'Physical Province'};
if (!empty($row{'Physical Province'})) {
$output .= '<result>';
$output .= "<id>$id</id>";
$output .= "<company_name><![CDATA[$company_name]]></company_name>";
$output .= "<physical_province><![CDATA[$physical_province]]></physical_province>";
$output .= '</result>';
}}
$output .= '</results>';
$output .= '</data>';
sqlsrv_free_stmt( $stmt);	
print ($output);	
}

function getsitemap($value) {
include('db.php');
$sql = "Select  canadawh_2.canada.[Company Name],canadawh_2.canada.[ID] From canadawh_2.canada"; 
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}
$output = '<?xml version="1.0" encoding="iso-8859-1"?>';
$output .= '<data>';
$output .= '<results>';
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
	$output .= '<result>';
$company_name = $row{'Company Name'};
$id = $row{'ID'};
$output .= "<id>$id</id>";
$output .= "<company_name><![CDATA[$company_name]]></company_name>";
	$output .= '</result>';
}
$output .= '</results>';
$output .= '</data>';
sqlsrv_free_stmt( $stmt);	
print ($output);	
}

function getresult($resultid) {
include('db.php');
$sql = "Select
  canadawh_2.canada.ID,
  canadawh_2.canada.[Company Name],
  canadawh_2.canada.[Mailing Address],
  canadawh_2.canada.[Mailing City],
  canadawh_2.canada.[Mailing Province],
  canadawh_2.canada.[Mailing Postal],
  canadawh_2.canada.[Physical City],
  canadawh_2.canada.[Physical Address],
  canadawh_2.canada.[Physical Province],
  canadawh_2.canada.[Physical Postal],
  canadawh_2.canada.[Average earning],
  canadawh_2.canada.[Telephone Number],
  canadawh_2.canada.[Fax Number],
  canadawh_2.canada.Email,
  canadawh_2.canada.Website,
  canadawh_2.canada.[Primary Contact Name],
  canadawh_2.canada.[Primary Contact Title],
  canadawh_2.canada.[Primary Contact Phone],
  canadawh_2.canada.[Primary Contact Email],
  canadawh_2.canada.[Other Contacts],
  canadawh_2.canada.Profile,
  canadawh_2.canada.[Year Founded],
  canadawh_2.canada.Industry,
  canadawh_2.canada.[NAICS Primary],
  canadawh_2.canada.[NAICS Secondary],
  canadawh_2.canada.[SIC Primary],
  canadawh_2.canada.[SIC Secondary],
  canadawh_2.canada.[Business Activity],
  canadawh_2.canada.[Sales Volume],
  canadawh_2.canada.[Number of Employees],
  canadawh_2.canada.[Products Services]
From
  canadawh_2.canada
Where
  canadawh_2.canada.ID = '$resultid'"; 
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}
$output = '<?xml version="1.0" encoding="iso-8859-1"?>';
$output .= '<data>';
$output .= '<results>';
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
$output .= '<result>';
$id = $row{'ID'};
$company_name = $row{'Company Name'};
$mailing_address = $row{'Mailing Address'};
$mailing_city = $row{'Mailing City'};
$mailing_province = $row{'Mailing Province'};
$mailing_postal = $row{'Mailing Postal'};
$physical_address = $row{'Physical Address'};
$physical_city = $row{'Physical City'};
$physical_province = $row{'Physical Province'};
$physical_postal = $row{'Physical Postal'};
$average_earning = $row{'Average earning'};
$telephone_number = $row{'Telephone Number'};
$fax_number = $row{'Fax Number'};
$email = $row{'Email'};
$website = $row{'Website'};
$primary_contact_name = $row{'Primary Contact Name'};
$primary_contact_title = $row{'Primary Contact Title'};
$primary_contact_phone = $row{'Primary Contact Phone'};
$primary_contact_email = $row{'Primary Contact Email'};
$other_contacts = $row{'Other Contacts'};
$profile = $row{'Profile'};
$year_founded = $row{'Year Founded'};
$industry = $row{'Industry'};
$naics_primary = $row{'NAICS Primary'};
$naics_secondary = $row{'NAICS Secondary'};
$sic_primary = $row{'SIC Primary'};
$sic_secondary = $row{'SIC Secondary'};
$business_activity = $row{'Business Activity'};
$sales_volume = $row{'Sales Volume'};
$number_of_employees = $row{'Number of Employees'};
$products_services = $row{'Products Services'};
$output .= "<id>$id</id>";
$output .= "<company_name><![CDATA[$company_name]]></company_name>";
$output .= "<mailing_address><![CDATA[$mailing_address]]></mailing_address>";
$output .= "<mailing_city><![CDATA[$mailing_city]]></mailing_city>";
$output .= "<mailing_province><![CDATA[$mailing_province]]></mailing_province>";
$output .= "<mailing_postal><![CDATA[$mailing_postal]]></mailing_postal>";
$output .= "<physical_address><![CDATA[$physical_address]]></physical_address>";
$output .= "<physical_city><![CDATA[$physical_city]]></physical_city>";
$output .= "<physical_province><![CDATA[$physical_province]]></physical_province>";
$output .= "<physical_postal><![CDATA[$physical_postal]]></physical_postal>";
$output .= "<average_earning><![CDATA[$average_earning]]></average_earning>";
$output .= "<telephone_number><![CDATA[$telephone_number]]></telephone_number>";
$output .= "<fax_number><![CDATA[$fax_number]]></fax_number>";
$output .= "<email><![CDATA[$email]]></email>";
$output .= "<website><![CDATA[$website]]></website>";
$output .= "<primary_contact_name><![CDATA[$primary_contact_name]]></primary_contact_name>";
$output .= "<primary_contact_title><![CDATA[$primary_contact_title]]></primary_contact_title>";
$output .= "<primary_contact_phone><![CDATA[$primary_contact_phone]]></primary_contact_phone>";
$output .= "<primary_contact_email><![CDATA[$primary_contact_email]]></primary_contact_email>";
$output .= "<other_contacts><![CDATA[$other_contacts]]></other_contacts>";
$output .= "<profile><![CDATA[$profile]]></profile>";
$output .= "<year_founded><![CDATA[$year_founded]]></year_founded>";
$output .= "<industry><![CDATA[$industry]]></industry>";
$output .= "<naics_primary><![CDATA[$naics_primary]]></naics_primary>";
$output .= "<naics_secondary><![CDATA[$naics_secondary]]></naics_secondary>";
$output .= "<sic_primary><![CDATA[$sic_primary]]></sic_primary>";
$output .= "<sic_secondary><![CDATA[$sic_secondary]]></sic_secondary>";
$output .= "<business_activity><![CDATA[$business_activity]]></business_activity>";
$output .= "<sales_volume><![CDATA[$sales_volume]]></sales_volume>";
$output .= "<number_of_employees><![CDATA[$number_of_employees]]></number_of_employees>";
$output .= "<products_services><![CDATA[$products_services]]></products_services>";
$output .= '</result>';
}
$output .= '</results>';
$output .= '</data>';
sqlsrv_free_stmt( $stmt);	
print ($output);		
}
?>
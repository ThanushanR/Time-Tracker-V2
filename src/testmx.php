<html>
<head>
<link href="css/style.css" rel="stylesheet" type="text/css"/>
<title>Check Email MX Record</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
</head>
<body>
<div class="container">
<div class="row">
<div class="col-sm-1 col-md-2 col-lg-12">
<div id="main" class="col-sm-1 col-md-2 col-lg-12">
<div class="col-sm-1 col-md-2 col-lg-12"><h1>Check Email MX Record</h1> </div>
<div id="login">
<h2>MX Record Checker</h2>
<hr>
<div id="right">
<form name="myForm" method="post" action="testmx.php">
Please Enter Email Address:<br /><br />
<input type="email" size=18 name="email" id="email"><br /><br />
<div class="col-sm-1 col-md-2 col-lg-12"> <input type="submit" value="Check" id="dsubmit" name ="submit"></div>
</form>
<div id ="result">
<?php
if (isset($_POST['submit'])) {
$email = $_POST['email'];
/*
* Getting Domain part from user input Email-Address
*/
$domain = substr(strrchr($email, "@"), 1);
/*
* This Function is used for fetching the MX data records to a corresponding
- Email domain
*/

function mxrecordValidate($domain) {

$arr = dns_get_record($domain, DNS_MX);
if ($arr[0]['host'] == $domain && !empty($arr[0]['target'])) {
return $arr[0]['target'];
}
}

echo"<table id ='tid' >";
echo"<th>";
echo"Result";
echo"</th>";
echo"<tr>";
echo"<td>";
if (mxrecordValidate($domain)) {
echo('This MX records exists.Valid Email Address.');
$data = dns_get_record($domain, DNS_MX);
foreach ($data as $key1) {
echo "Host:- " . $key1['host'] ;
echo "Class:- " . $key1['class'] ;
echo "TTL:- " . $key1['ttl'] ;
echo "Type:- " . $key1['type'] ;
echo "PRI:- " . $key1['pri'] ;
echo "Target:- " . $key1['target'] ;
echo "Target-IP:- " . gethostbyname($key1['target']) ;
}
echo"</td>";
echo"</tr>";
} else {
echo('No MX record exists.Invalid Email.');
}
echo"</td>";
echo"</tr>";
echo"</table>";
}
?>
</div>
</div>
</div>
</div>
</div>
</div>
</body>
</html>
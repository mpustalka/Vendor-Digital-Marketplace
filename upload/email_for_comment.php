<?php
$body = '
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="'.ADMIN_URL.'css/main.css">
</head>
<body>
<center>
<table style="border:1px dotted #00CCFF; min-width:300px;">
<tr>
<td  colspan="2">
<center> <img src="'.ADMIN_URL.'images/siteLogo.png" ></center>
</td>
</tr>
<tr >
<td width="50%" style="border:1px solid #00CC33;">
Name 
</td>
<td style="border:1px solid #00CC33;" >
'.$userName.'
</td>
</tr>
</tr>
<tr >
<td width="50%" style="border:1px solid #00CC33;">
Email 
</td>
<td style="border:1px solid #00CC33;">
'.$userEmail.'
</td>
</tr>
<tr >
<td width="50%" style="border:1px solid #00CC33;">
Comment 
</td>
<td style="border:1px solid #00CC33;">
'.strip_tags($_POST['comment']).'
</td>
</tr>
<tr >
<td colspan="2" style="border:1px solid #00CC33; padding:10px;">
<center><a href="'.$webUrl.'"><img src="'.ADMIN_URL.'images/view_item.png" alt ="View Item" ></a> </center>
</td>
</tr>
</table>
</center>
</body>
</html>';
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Fira+Code&display=swap" rel="stylesheet">

	<style type="text/css">
		body {
			font-size: 14px;
			font-family: 'Menlo', 'Fire Code', monospace;
			font-weight: 400;
			line-height: 1.15;
			white-space: pre;
		}
	</style>
</head>
<body><?php echo $render; ?></body>
</html>
<?php
die();

echo '<pre style="font-family: \'Menlo\', monospace">';
#print_r($area_1->render());
echo "\n";
#print_r($area_2->render());
echo '</pre>';


echo '<pre>';
print_r($layout);
print_r($area_1);
print_r($document);
echo '</pre>';
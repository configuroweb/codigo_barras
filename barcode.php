<?php

require 'vendor/autoload.php';
extract($_POST);

$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
$code2 ='';
foreach(str_split($code) as $key => $c){
	$code2 .=$c;
	if(count(str_split($code)) != $key)
	$code2 .=' ';

}
?>

<div id="field">
<center><large><b><?php echo $label ?></b></large></center>
<img src="data:image/png;base64,<?php echo base64_encode($generator->getBarcode($code, $type)) ?>">
<div id="code"><?php echo $code2 ?></div>
</div>
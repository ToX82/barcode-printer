<?php
/*
* THE FORM 
*/
$hideForm = ($_GET['hideFormCheckbox']) ? "style='display:none;'" : null;
$hideFormCheckbox = ($_GET['hideFormCheckbox']) ? "checked" : null;


echo "<form action='' $hideForm method='get'>";
	echo "<h1>BarcodePrinter</h1>";

	echo "<h2>Settings</h2>";

	$howManyCodes = (isset($_GET['howManyCodes'])) ? $_GET['howManyCodes'] : 12;
	$digits = (isset($_GET['digits'])) ? $_GET['digits'] : 10;
	$start = (isset($_GET['start'])) ? $_GET['start'] : 1;
	$hideText = (isset($_GET['hideText'])) ? "checked" : null;
	echo "<br>Digits per code: <input type='text' name='digits' value='{$digits}'>";
	echo "<br>How many codes: <input type='text' name='howManyCodes' value='{$howManyCodes}'>";
	echo "<br>Starting from: <input type='text' name='start' value='{$start}'>";
	echo "<br>Hide text code below image: <input type='checkbox' name='hideText' $hideText>";

	echo "<hr>";

	$codeArray = (isset($_GET['codeArray'])) ? $_GET['codeArray'] : "";
	echo "<br>Or, specify array of codes: <input type='text' name='codeArray' value='{$codeArray}'> array format: [\"code1\",\"code2\",\"code3\"]";

	echo "<hr>";

	$pageWidth = (isset($_GET['pageWidth'])) ? $_GET['pageWidth'] : "210mm";
	$pageHeight = (isset($_GET['pageHeight'])) ? $_GET['pageHeight'] : "297mm";
	echo "<br>Page width: <input type='text' name='pageWidth' value='{$pageWidth}'>";
	echo "<br>Page height: <input type='text' name='pageHeight' value='{$pageHeight}'>";

	$itemWidth = (isset($_GET['itemWidth'])) ? $_GET['itemWidth'] : "50mm";
	$itemHeight = (isset($_GET['itemHeight'])) ? $_GET['itemHeight'] : "35mm";
	echo "<br>Label width: <input type='text' name='itemWidth' value='{$itemWidth}'>";
	echo "<br>Label height: <input type='text' name='itemHeight' value='{$itemHeight}'>";

	$itemMarginBottom = (isset($_GET['itemMarginBottom'])) ? $_GET['itemMarginBottom'] : "0mm";
	$itemMarginRight = (isset($_GET['itemMarginRight'])) ? $_GET['itemMarginRight'] : "0mm";
	echo "<br>Item bottom margin: <input type='text' name='itemMarginBottom' value='{$itemMarginBottom}'>";
	echo "<br>Item right margin: <input type='text' name='itemMarginRight' value='{$itemMarginRight}'>";

	$barCodeHeight = (isset($_GET['barCodeHeight'])) ? $_GET['barCodeHeight'] : 80;
	echo "<br>Barcode Height: <input type='text' name='barCodeHeight' value='{$barCodeHeight}'>";

	echo "<hr>";
	$codetype = (isset($_GET['codetype'])) ? $_GET['codetype'] : "code128";
	echo "<br>Barcode type: <input type='text' name='codetype' value='{$codetype}'> (Valid codetypes: code128, code39, code25, codabar, qrcode)";
	
	echo "<hr>";

	echo "<br>Hide form: <input type='checkbox' name='hideFormCheckbox' $hideFormCheckbox>";

	echo "<br><input type='submit' value='Update'>";

	echo '<input type="button" value="Print" onClick="window.print()">';

	echo "<h2>Preview:</h2>";
echo "</form>";



/*
* THE SHEET
*/
echo "<div class='sheet'>";
	if ($codeArray != "") { // Specified array of codes
		foreach (json_decode($codeArray) as $code) {
			echo "<div class='item'>";
		    	echo "<img src='barcode.php?codetype={$codetype}&size={$barCodeHeight}&text={$code}'>";
		    	if ($hideText == null) {
		    		echo "<div>{$code}</div>";
		    	}
		    echo "</div>";
		}
	} else { // Unspecified codes, let's go ncremental
		for ($i = $start; $i <= $howManyCodes + $start; $i++) {
			$code = str_pad($i, $digits, "0", STR_PAD_LEFT);

			echo "<div class='item'>";
		    	echo "<img src='barcode.php?codetype={$codetype}&size={$barCodeHeight}&text={$code}'>";
		    	if ($hideText == null) {
		    		echo "<div>{$code}</div>";
		    	}
		    echo "</div>";
		}
	}
echo "</div>";



/*
* THE STYLE
*/
echo <<<STYLE
	<style>
		html {
			background-color: #EEE;
		}
		body {
			margin: 5px auto;
			width: $pageWidth;
		}
		input {
			margin: 0 5px;
		}
		.sheet {
			background-color: #FFF;
			display: table;
			height: $pageHeight;
			width: $pageWidth;
			overflow: hidden;
		}
		.item {
			float: left;
			border: 1px solid #ddd;
			text-align: center;
			vertical-align: middle;

			height: $itemHeight;
			width: $itemWidth;
			margin-right: $itemMarginRight;
			margin-bottom: $itemMarginBottom;

			display: flex;
		    justify-content:center;
		    align-content:center;
		    flex-direction:column; /* column | row */
		}

		@media print {
			html, body {
				margin: 0;
				padding: 0;
				height: $pageHeight;
				width: $pageWidth;
			}
		    form {
		        display: none;
		    }
			.item {
				border: none;
				page-break-inside: avoid;
			}
		}
	</style>
STYLE;

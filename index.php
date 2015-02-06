<?php
require_once("sanitizer.php");

/*
* THE FORM 
*/
$hideForm = (filterString('hideFormCheckbox')) ? "style='display:none;'" : null;
$hideFormCheckbox = (filterString('hideFormCheckbox')) ? "checked" : null;


echo "<form action='' $hideForm method='get'>";
	echo "<h1>BarcodePrinter</h1>";

	echo "<h2>Settings</h2>";

	$howManyCodes = (filterInt('howManyCodes') != "") ? filterInt('howManyCodes') : 12;
	$digits = (filterInt('digits') != "") ? filterInt('digits') : 10;
	$start = (filterInt('start') != "") ? filterInt('start') : 1;
	$hideText = (filterString('hideText') != "") ? "checked" : null;
	echo "<br>Digits per code: <input type='text' name='digits' value='{$digits}'>";
	echo "<br>How many codes: <input type='text' name='howManyCodes' value='{$howManyCodes}'>";
	echo "<br>Starting from: <input type='text' name='start' value='{$start}'>";
	echo "<br>Hide text code below image: <input type='checkbox' name='hideText' $hideText>";

	echo "<hr>";

	$codeArray = (filterRaw('codeArray') != "") ? filterRaw('codeArray') : "";
	echo "<br>Or, specify array of codes: <input type='text' name='codeArray' value='{$codeArray}'> array format: [\"code1\",\"code2\",\"code3\"]";

	echo "<hr>";

	$pageWidth = (filterString('pageWidth') != "") ? filterString('pageWidth') : "210mm";
	$pageHeight = (filterString('pageHeight') != "") ? filterString('pageHeight') : "297mm";
	echo "<br>Page width: <input type='text' name='pageWidth' value='{$pageWidth}'>";
	echo "<br>Page height: <input type='text' name='pageHeight' value='{$pageHeight}'>";

	$itemWidth = (filterString('itemWidth') != "") ? filterString('itemWidth') : "50mm";
	$itemHeight = (filterString('itemHeight') != "") ? filterString('itemHeight') : "35mm";
	echo "<br>Label width: <input type='text' name='itemWidth' value='{$itemWidth}'>";
	echo "<br>Label height: <input type='text' name='itemHeight' value='{$itemHeight}'>";

	$itemMarginBottom = (filterString('itemMarginBottom') != "") ? filterString('itemMarginBottom') : "0mm";
	$itemMarginRight = (filterString('itemMarginRight') != "") ? filterString('itemMarginRight') : "0mm";
	echo "<br>Item bottom margin: <input type='text' name='itemMarginBottom' value='{$itemMarginBottom}'>";
	echo "<br>Item right margin: <input type='text' name='itemMarginRight' value='{$itemMarginRight}'>";

	$barCodeHeight = (filterInt('barCodeHeight') != "") ? filterInt('barCodeHeight') : 80;
	echo "<br>Barcode Height: <input type='text' name='barCodeHeight' value='{$barCodeHeight}'>";

	echo "<hr>";
	$codetype = (filterString('codetype') != "") ? filterString('codetype') : "code128";
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
		for ($i = $start; $i < $howManyCodes + $start; $i++) {
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

<?php
if (isset($_POST['submit'])) {
	include('fractionCalculator.php');
	if (validate($_POST)) {
		$fractionCalculator = new fractionCalculator();
		$fraction = new fraction($_POST['num1'], $_POST['den1']);
		$fractionCalculator->addFraction($fraction);
		$fraction = new fraction($_POST['num2'], $_POST['den2']);
		$fractionCalculator->addFraction($fraction);
		$fractionCalculator->setOperator($_POST['operator']);
		
		$fractionCalculator->calculate();
	}		
}



/**
 * Ensure we have valid post data
 * 
 * @param array $data
 */
function validate($data) {
	$valid = true;
	if (!isset($data['num1'])) {
		$valid = false;
		echo '<h3>Missing numerator for fraction 1.</h3>';
	} elseif(!is_numeric($data['num1'])) {
		$valid = false;
		echo "<h3>Numerator for fraction 1 '{$data['num1']}' is not numeric.";
	}
	if (!isset($data['den1'])) {
		$valid = false;	
		echo '<h3>Missing Denominator for fraction 1.</h3>';
	} elseif(!is_numeric($data['den1'])) {
		$valid = false;
		echo "<h3>Denominator for fraction 1 '{$data['den1']}' is not numeric.";
	}
	if (!isset($data['num2'])) {
		$valid = false;
		echo '<h3>Missing numerator for fraction 2.</h3>';
	} elseif(!is_numeric($data['num2'])) {
		$valid = false;
		echo "<h3>Numerator for fraction 2 '{$data['num2']}' is not numeric.";
	}
	if (!isset($data['den2'])) {
		$valid = false;
		echo '<h3>Missing Denominator for fraction 2.</h3>';
	} elseif(!is_numeric($data['den2'])) {
		$valid = false;
		echo "<h3>Denominator for fraction 2 '{$data['den2']}' is not numeric.";
	}
	
	return $valid;
}



?>
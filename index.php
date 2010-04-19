<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Fraction Calculator</title>
		<style type="text/css">
			h1 {
				text-align: center;
			}
			#fractionFormContainer {
				width: 500px;
				margin-left: auto;
				margin-right: auto;
			}
			#fraction1{
				width: 160px;
				float: left;
			}
			#fraction2 {
				width: 160px;
				float: left;
				
			}
			#operatorText {
				float: left;
				width: 180px;
				text-align: center;
			}
			#operator {
				clear: both;
				width: 300px;
				margin-left: auto;
				margin-right: auto;
			}
			input {
				text-align: left;
			}
			#submitButton {
				text-align: center;
				width: 100px;
				margin-left: auto;
				margin-right: auto;
			}
			#result {
				text-align: center;	
			}
		</style>
	</head>

	<body>
		<h1>Fraction Calculator</h1>
		<div id="fractionFormContainer">
			<form action="index.php" method="post">
				<div id="fraction1">
					fraction 1
					<br />
					<input type="text" name="num1" value="<?php echo isset($_POST['num1']) ? $_POST['num1'] : null?>"/>
					<br />
					<input type="text" name="den1" value="<?php echo isset($_POST['den1']) ? $_POST['den1'] : null?>"/>
						
				</div>
				<p id="operatorText"><br />+</p>
				<div id="fraction2">
					fraction 2
					<br />
					<input type="text" name="num2" value="<?php echo isset($_POST['num2']) ? $_POST['num2'] : null?>"/>
					<br />
					<input type="text" name="den2" value="<?php echo isset($_POST['den2']) ? $_POST['den2'] : null?>"/>
				</div>
				<div  id="operator">
					Add: <input type="radio" name="operator" value="add" <?php echo (!isset($_POST['operator']) || $_POST['operator'] == 'add') ? 'checked="checked" ' : null?>/>
					Subtract: <input type="radio" name="operator" value="subtract" <?php echo (isset($_POST['operator']) && $_POST['operator'] == 'subtract') ? 'checked="checked" ' : null?>/>
					Multiply: <input type="radio" name="operator" value="multiply" <?php echo (isset($_POST['operator']) && $_POST['operator'] == 'multiply') ? 'checked="checked" ' : null?>/>
					Divide: <input type="radio" name="operator" value="divide" <?php echo (isset($_POST['operator']) && $_POST['operator'] == 'divide') ? 'checked="checked" ' : null?>/>
				</div>
				<div id="submitButton">
					<br />
					<input type="submit" name="submit" value="Calculate!" />
				</div>
				
			</form>
		</div>
		<?php
			if (isset($_POST['submit'])) {
				include('calculateScript.php');
			}
		?>
	</body>

</html>

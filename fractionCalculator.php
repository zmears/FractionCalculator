<?php

require_once 'fraction.php';
/**
 * Fraction Calculation Class
 * 
 * @autor oreX
 */
class fractionCalculator {

	/**
	 * Holds the chosen mathmatical operator
	 * 
	 * @var string
	 */
	protected $_operator = 'add';
	
	/**
	 * Holds an array of fractions to use
	 * 
	 * @var array of fraction
	 * @see fraction
	 */
	protected $_fractions = array();
	
	/**
	 * Holds the result
	 * 
	 * @var fraction
	 */
	public $result = null;
	
	/*
	 * Holds any error messages
	 * 
	 * @var array
	 */
	public $errors = array();
	
	
	/**
	 * Method to add a fraction
	 * 
	 * @param fraction $fraction
	 */
	public function addFraction(fraction $fraction) {
		$this->_fractions[] = $fraction;
	}
	
	/**
	 * Sets the operator
	 * 
	 * @param string $operator
	 */
	public function setOperator($operator) {
		$validOperators = array(
							'add',
							'subtract',
							'multiply',
							'divide',
			);
		if (!in_array($operator, $validOperators)) {
			throw new Exception("Invalid operator of '$operator' specified.");
		}
		
		$this->_operator = $operator;
	}
	
	/**
	 * Performs the calculation
	 * 
	 * @return void
	 */
	public function calculate() {
		try {
			$method = $this->_operator;
			$this->$method();
		} catch (Exception $e){
			
		}

		$this->_displayResults();
	}
	
	/**
	 * Method to add fractions together
	 * 
	 * @return bool
	 */
	public function add() {
		$lcd = $this->getLcd();
		$newNumerator = 0;
		foreach($this->_fractions as $fraction) {
			//Determine how much to multiply the numerator by	
			$multiplier = ($lcd / $fraction->denominator);
			//Equalize the numerator with the new lcd and add it to the new numerator.
			$newNumerator += ($fraction->numerator * $multiplier);
		}
		//Create the result
		$result = new fraction($newNumerator, $lcd);
		//Reduce the fraction
		$result->reduce($result);
		
		$this->result = $result;
		return true;
	}
	
	/**
	 * Method to add fractions together
	 * 
	 * @return bool
	 */
	public function subtract() {
		//Ensure we have atleast two fractions to work with
		if (count($this->_fractions) < 2) {
			throw new Exception("You need two or more fractions in order to subtract them.");
		}
		//Get the lcd and fraction array
		$lcd = $this->getLcd();
		$fractions = $this->_fractions;
		//Get the initial fraction to subtract from
		$leftFraction = array_shift($fractions);
		//Equalize the fraction using the lcd
		$multiplier = ($lcd / $leftFraction->denominator);		
		$newNumerator = ($multiplier * $leftFraction->numerator);
		//Subtract the remaining fractions
		foreach($fractions as $fraction) {
			//Determine how much to multiply the numerator by	
			$multiplier = ($lcd / $fraction->denominator);
			//Equalize the numerator with the new lcd and subtract it from the new numerator.
			$newNumerator -= ($multiplier * $fraction->numerator);
		}
		//Create the result
		$result = new fraction($newNumerator, $lcd);
		//Reduce the fraction
		$result->reduce($result);
		
		$this->result = $result;
		return true;
	}
	
	/**
	 * Method to multiply fractions
	 * 
	 * @return bool
	 */
	public function multiply() {
		//Initiate the first fraction
		$fractions = $this->_fractions;
		$firstFraction = array_shift($fractions);
		$numerator   = $firstFraction->numerator;
		$denominator = $firstFraction->denominator;
		
		foreach($fractions as $fraction) {
			$numerator = $fraction->numerator * $numerator;
			$denominator = $fraction->denominator * $denominator; 
		}
		$fraction = new fraction($numerator, $denominator);
		$fraction->reduce($fraction);
		
		$this->result = $fraction;
		
		return true;
	}
	
	/**
	 * Method to divide fractions
	 * 
	 * @return bool
	 */
	public function divide() {
		//Initiate the left fraction
		$fractions = $this->_fractions;
		$firstFraction = array_shift($fractions);
		$leftFraction = clone $firstFraction;
		
		foreach($fractions as $fraction) {
			//Flip the right fraction then multiply the numerator and denominator
			$numerator   = $fraction->denominator;
			$denominator = $fraction->numerator;

			$leftFraction->numerator   = $leftFraction->numerator * $numerator;
			$leftFraction->denominator = $leftFraction->denominator * $denominator;
		}
		
		$leftFraction->reduce();
		$this->result = $leftFraction;

		return true;
	}
	/**
	 * Method to get the least commong denominator of the fractions
	 * 
	 * @return integer $lcm
	 */
	public function getLcd() {
		//Ensure we have atleast two fractions to work with
		if (count($this->_fractions) < 2) {
			throw new Exception("You need two or more fractions in order to calculate the lease common multiple.");
		}
		/* Visit this link for an explination of the forumla used, secion 3.3 explains it
		 * http://en.wikipedia.org/wiki/Least_common_multiple#A_simple_algorithm
		 */
		//Get the first two fractions
		$fractions = $this->_fractions;
		$leftFraction = array_shift($fractions);
		$rightFraction = array_shift($fractions);
		
		//Need to find the least common multiple of the denominators
		$lcm = $this->getLcm($leftFraction->denominator, $rightFraction->denominator);
		foreach ($fractions as $fraction) {
			$lcm = $this->getLcm($lcm, $fraction->denominator);
		}
		
		return $lcm;
	}
	
	/**
	 * Calculates the least common multiple of two numbers
	 * 
	 * @param integer $left
	 * @param integer $right
	 * @return integer $lcm
	 */
	public function getLcm($left, $right) {
		//Create a new fraction in order to get the gcd
		$gcdFraction = new fraction(0, 0);
		$gcd = $gcdFraction->getGcd((int) $left, (int) $right);
		//Get the greated common multiple, lookup lcm on wiki for an explination of the formula
		$lcm = ($left / $gcd) * $right;
		
		return $lcm;
	}
	
	/**
	 * Displays the results of the calculation
	 * 
	 * @return void
	 */
	protected function _displayResults() {
		if (null !== $this->result) {
            //Determine if the fraction is negative and add the prefix to the begginging.
		    $prefix = (($this->result->numerator < 0) || ($this->result->denominator < 0)) ? "-" : null;
			echo '<h3 id="result">' 
			     . $prefix
			     . abs($this->result->numerator)
			     . '/'
			     . abs($this->result->denominator)
			     . '</h3>';
		}
	}
}



?>
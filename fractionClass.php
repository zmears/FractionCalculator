<?php 
/**
 * Simple Fraction Class
 * 
 * @author oreX
 */
class fraction {
	/**
	 * Holds the numerator
	 * 
	 * @var integer
	 */
	public $numerator = null;
	
	/**
	 * Holds the denominator
	 * 
	 * @var integer
	 */
	public $denominator = null;
	
	/**
	 * Populators the numerator and demoninator
	 * when the class is instantiated. 
	 *
	 *@param integer $numerator
	 *@param integer $denominator
	 */
	public function __construct($numerator, $denominator) {
		//Ensure the numerator is numeric
		if (!is_numeric($numerator)) {
			throw new Exception("The numerator must be numeric. '$numerator' is not a valid value.");
		}
		//Ensure the denominator is numeric
		if (!is_numeric($denominator)) {
			throw new Exception("The denominator must be numeric. '$denominator' is not a valid value.");
		}
		//Set the values if they pass the basic validation
		$this->numerator   = $numerator;
		$this->denominator = $denominator;
	}
	
	/**
	 * Method to reduce a fraction
	 * 
	 * @return void
	 */
	public function reduce() {
		
		$gcf = $this->_getGcd($this->numerator, $this->denominator);
		$this->numerator   = ($this->numerator / $gcf);
		$this->denominator = ($this->denominator / $gcf);
	}
	
	/**
	 * Method to determine greatest common divisor
	 * 
	 * @param integer $left
	 * @param integer $right
	 */
	protected function _getGcd($left, $right) {
		/*
		 * divide 84 by 18 to get a quotient of 4 and a remainder of 12.
		 * Then divide 18 by 12 to get a quotient of 1 and a remainder of 6.
		 * Then divide 12 by 6 to get a remainder of 0, which means
		 * that 6 is the gcd.
		 */
		//determine if the left value is the gcd
		if (($right % $left) !== 0) {
			//get the quotient
			$multiplier = floor($right / $left);
			//get the remainder
			$remainder = ($right - ($left * $multiplier));
			//the remainder becomes the new left value
			$this->_getGcd($remainder, $left);
		} else {
			return $left;
		}
	}
}


?>

<?php
if (true) {
	// AS-IS
	$balanceCoefficient 	= 1.29;
	$centralityCoefficient 	= 0.22;
	$density 				= 0.25;
	$elements 				= array("E1", "E2", "D1", "D2", "D3", "A1", "A2", "A3", "A4");
	$normalizedCentralities = array(-0.25, -0.13, -0.13, -0.38, -0.5, -0.25, -0.13, -0.13, -0.38);
} else {
	// TO-BE
	$balanceCoefficient 	= 0.46;
	$centralityCoefficient 	= 0.03;
	$density 				= 0.21;
	$elements 				= array("E1", "E2", "E3", "D2", "D3", "A1", "A2", "A3", "A4");
	$normalizedCentralities = array(-0.13, -0.13, -0.13, -0.25, -0.25, -0.25, -0.25, -0.25, -0.25);
}
?>
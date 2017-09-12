<?php
include "DataFlowAnalysisService.php";

header("Content-type: application/json");

$json = array();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
	$dataFlowAnalysisService = new DataFlowAnalysisService;

	$dataFlowAnalysisService->calculateBalanceCoefficient();
	$dataFlowAnalysisService->calculateCentralityCoefficient();
	$dataFlowAnalysisService->calculateDensity();
	$dataFlowAnalysisService->calculateNormalizedCentralities();

	$balanceCoefficient 	= $dataFlowAnalysisService->getBalanceCoefficient();
	$centralityCoefficient 	= $dataFlowAnalysisService->getCentralityCoefficient();
	$density 				= $dataFlowAnalysisService->getDensity();
	$elements 				= $dataFlowAnalysisService->getElements();
	$normalizedCentralities = $dataFlowAnalysisService->getNormalizedCentralities();

	# include "test.php";

	$json = array(
		"balance" 		=> $balanceCoefficient,
		"centrality" 	=> $centralityCoefficient,
		"density" 		=> $density,
		"elements" 		=> $elements,
		"centralities" 	=> $normalizedCentralities);
} else {
	$json = array("message" => "Request method not accepted");
}

echo json_encode($json);
?>
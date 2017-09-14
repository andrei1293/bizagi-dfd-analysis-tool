<?php
include "DataFlowAnalysisDAO.php";

class DataFlowAnalysisService {
	private $dataFlowAnalysisDAO;

	private $balanceCoefficient;
	private $centralityCoefficient;
	private $density;
	private $normalizedCentralities;

	public function __construct() {
		$this->dataFlowAnalysisDAO = new DataFlowAnalysisDAO;

		$this->dataFlowAnalysisDAO->retrieveData();
	}

	public function calculateBalanceCoefficient() {
		$weights 		= $this->dataFlowAnalysisDAO->getWeights();
		$centralities 	= $this->dataFlowAnalysisDAO->getCentralities();
		$elements 		= $this->dataFlowAnalysisDAO->getElements();

		if (count($elements) > 0) {
			$weightedCentralities = array();

			for ($i = 0; $i < count($centralities); $i++) {
				$weightedCentralities[$i] = $weights[$i] * $centralities[$i];
			}

			$this->balanceCoefficient = round(abs(array_sum($weightedCentralities) / count($weightedCentralities) - max($weightedCentralities)), 2);
		} else {
			$this->balanceCoefficient = 0;
		}
	}

	public function calculateCentralityCoefficient() {
		$weights 		= $this->dataFlowAnalysisDAO->getWeights();
		$centralities 	= $this->dataFlowAnalysisDAO->getCentralities();

		$value = 0;

		for ($i = 0; $i < count($centralities); $i++) {
			$value += (max($centralities) - $centralities[$i]) * $weights[$i];
		}

		$size = count($centralities);
		$this->centralityCoefficient = round($value / (($size - 1) * ($size - 2)), 2);
	}

	public function calculateDensity() {
		$centralities 		= $this->dataFlowAnalysisDAO->getCentralities();
		$dataFlowsAmount 	= $this->dataFlowAnalysisDAO->getDataFlowsAmount();
		$elements 			= $this->dataFlowAnalysisDAO->getElements();

		if (count($elements) > 0) {
			$size = count($centralities);
			$this->density = $dataFlowsAmount / ($size * ($size - 1));
		} else {
			$this->density = 0;
		}
	}

	public function calculateNormalizedCentralities() {
		$centralities 	= $this->dataFlowAnalysisDAO->getCentralities();
		$elements 		= $this->dataFlowAnalysisDAO->getElements();

		if (count($elements) > 0) {
			$size = count($centralities);

			for ($i = 0; $i < count($centralities); $i++) {
				$this->normalizedCentralities[$i] = -round($centralities[$i] / ($size - 1), 2);
			}
		} else {
			$this->normalizedCentralities = array();
		}
	}

	public function getBalanceCoefficient() {
		return $this->balanceCoefficient;
	}

	public function getCentralityCoefficient() {
		return $this->centralityCoefficient;
	}

	public function getDensity() {
		return $this->density;
	}

	public function getNormalizedCentralities() {
		return $this->normalizedCentralities;
	}

	public function getElements() {
		return $this->dataFlowAnalysisDAO->getElements();;
	}
}
?>
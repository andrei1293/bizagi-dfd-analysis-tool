<?php
class DataFlowAnalysisDAO {
	private $server = "LENOVO-PC\SQLEXPRESS";
	private $user 	= "sa";
	private $pass 	= "Bizagi10GO";

	private $dataBaseName = "DataFlowAnalysis";

	private $query = "SELECT 
			Title,
			(SELECT 
				Weight 
			FROM DataConnectivity 
			WHERE idDataConnectivity = DiagramElement.DataConnectivity),
			(SELECT 
				COUNT(*) 
			FROM RelatedDataFlows 
			WHERE RelatedDataFlows.DiagramElement = DiagramElement.idDiagramElement AND
				IsOutgoing = 1)
		FROM DiagramElement
		WHERE Diagram = (SELECT TOP 1 idDiagram FROM Diagram ORDER BY idDiagram DESC)";

	private $elements 			= array();
	private $weights 			= array();
	private $centralities 		= array();
	private $dataFlowsAmount 	= 0;

	public function retrieveData() {
		$conn = mssql_connect($this->server, $this->user, $this->pass) 
			or die ("Couldn't connect to SQL Server on " . $this->server);

		mssql_select_db($this->dataBaseName, $conn);

		$result = mssql_query($this->query);

		while ($row = mssql_fetch_array($result)) {
			array_push($this->elements, 	$row[0]);
			array_push($this->weights, 		$row[1]);
			array_push($this->centralities, $row[2]);

			$this->dataFlowsAmount += $row[2];
		}

		mssql_close($conn);
	}

	public function getElements() {
		return $this->elements;
	}

	public function getWeights() {
		return $this->weights;
	}

	public function getCentralities() {
		return $this->centralities;
	}

	public function getDataFlowsAmount() {
		return $this->dataFlowsAmount;
	}
}
?>
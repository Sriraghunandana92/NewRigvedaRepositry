<?php

class dataModel extends Model {

	public function __construct() {

		parent::__construct();
	}

	public function getJsonFiles($dir, $jsonFiles){

	    $files = scandir($dir);

	    foreach($files as $file) {

	        if($file != '.' && $file != '..') {

				if(preg_match('/\.json$/', $file)) {

					array_push($jsonFiles, $dir . '/' . $file);
				} 
	            if(is_dir($dir . '/' . $file)) {

	            	$jsonFiles = $this->getJsonFiles($dir . '/' . $file, $jsonFiles);
	            }
	        }
	    }

	    return $jsonFiles;
	}

	public function getJsonData($jsonFile = '') {
		
		$jsonData = json_decode(file_get_contents($jsonFile), true);

		if(!($jsonData)) return [];

		$data['id'] = sprintf("%03d", explode('.', $jsonData['id'])[0]) . '.' . sprintf("%03d", explode('.', $jsonData['id'])[1]) . '.' . sprintf("%03d", explode('.', $jsonData['id'])[2]);

		$data['mandala'] = $jsonData['classification']['mandala'];
		$data['sukta'] = $jsonData['classification']['sukta'];
		$data['ashtaka'] = $jsonData['classification']['ashtaka'];
		$data['adhyaya'] = $jsonData['classification']['adhyaya'];
		$data['varga'] = $jsonData['classification']['varga'];
		$data['anuvaka'] = $jsonData['classification']['anuvaka'];
		$data['rik'] = $jsonData['classification']['rik'];
		$data['devata'] = $jsonData['attribute']['devata'];
		$data['rishi'] = $jsonData['attribute']['rishi'];
		$data['chandas'] = $jsonData['attribute']['chandas'];
		
		$samhita = $jsonData['samhitaAux']['lines'];
		$data['samhita'] = (is_array($samhita)) ? implode(';', $samhita) : $samhita;
		$data['samhita'] = $this->addVedicSymbols($data['samhita']);
		$data['samhitaNoSwara'] = $this->removeSwara($data['samhita']);

		$samhitaAux = $jsonData['samhita']['lines'];
		$data['samhitaAux'] = (is_array($samhitaAux)) ? implode(';', $samhitaAux) : $samhitaAux;

		$padapaatha = $jsonData['padapaatha']['lines'];
		$data['padapaatha'] = (is_array($padapaatha)) ? implode(';', $padapaatha) : $padapaatha;
		$data['padapaatha'] = $this->addVedicSymbols($data['padapaatha']);
		
		$data['sayanaBhashya'] = (isset($jsonData['sayanaBhashya'])) ? $jsonData['sayanaBhashya'] : '';

		return $data;
	}

	public function getWordConcordance($dbh, $table) {

		$sth = $dbh->prepare('SELECT id, padapaatha FROM ' . BASEDATA_TABLE);
		$sth->execute();

		$concordance = [];
		while($result = $sth->fetch(PDO::FETCH_ASSOC)) {

			$result['padapaatha'] = str_replace(';', '', $result['padapaatha']);
			$result['padapaatha'] = str_replace('॥', '', $result['padapaatha']);
			$result['padapaatha'] = trim($result['padapaatha']);

			$words = explode('।', $result['padapaatha']);
			foreach ($words as $word) {
				
				$word = trim($word);

				if (!(isset($concordance{$word}))) $concordance{$word} = [];
				$concordance{$word}[] = $result['id'];
			}
		}

		$data = [];
		$wordID = 1;
		foreach ($concordance as $word => $occurrenceArray) {
			
			$row['id'] = sprintf("%05d", $wordID++);
			$row['pada'] = $word;			
			$row['padaNoSwara'] = $this->removeSwara($word);
			$row['occurrence'] = implode(';', $occurrenceArray);
			$data[] = $row;
		}

		$dbh = null;
		return $data;
	}
}

?>

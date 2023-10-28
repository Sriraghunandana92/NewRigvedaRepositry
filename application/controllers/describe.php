<?php

class describe extends Controller {

	public function __construct() {
		
		parent::__construct();
	}

	public function index() {

	}

	public function rikMandala($id = DEFAULT_RIK, $query = array()) {

		$data = $this->model->getRikDetailsByID($id);
		($data) ? $this->view('describe/rikMandala', $data) : $this->view('error/index');
	}

	public function rikAshtaka($quadruplet = DEFAULT_QUADRUPLET, $query = array()) {

		// Quadruplet: Ashtaka, adhyaya, varga, rik
		$data = $this->model->getRikDetailsByQuadruplet($quadruplet);
		($data) ? $this->view('describe/rikAshtaka', $data) : $this->view('error/index');
	}
	
	public function attr($attr = DEFAULT_ATTR, $attrName = '', $query = array()) {

		$filterJSON = '{"' . $attr . '" : "' . $attrName . '"}';
		$data['json'] = $this->model->listDistinctAttribute('id', $filterJSON);

		if ($data) {

			$data['filterKey'] = $attr;$data['filterName'] = $attrName;
			$this->view('describe/attr', $data);
		}
		else {

			$this->view('error/index');
		}
	}

	public function pada($word = '') {

		$data = $this->model->getWordFromConcordance($word);
		// var_dump($data);
		($data) ? $this->view('describe/pada', $data) : $this->view('error/index');
	}

	public function audio() {

		$data = $this->model->listAudio();

		// var_dump($data);
	// 	($data) ? $this->view('display/diff', $data) : $this->view('error/index');
	}
}

?>
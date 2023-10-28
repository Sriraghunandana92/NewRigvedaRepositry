<?php

class listing extends Controller {

	public function __construct() {
		
		parent::__construct();
	}

	public function index() {

		$this->mandala();
	}

	public function mandala($query = array()) {

		$data = $this->model->listDistinctAttribute('mandala');
		($data) ? $this->view('listing/mandala', $data) : $this->view('error/index');
	}

	public function sukta($query = array()) {

		$mandala = (isset($query['mandala'])) ? $query['mandala'] : DEFAULT_MANDALA;

		$filterJSON = '{"mandala" : "' . $mandala . '"}';
		$data = $this->model->listDistinctAttribute('sukta', $filterJSON);
		($data) ? $this->getComponent('listing/sukta', $data) : $this->view('error/index');
	}

	public function rikMandala($query = array()) {

		$mandala = (isset($query['mandala'])) ? $query['mandala'] : DEFAULT_MANDALA;
		$sukta = (isset($query['sukta'])) ? $query['sukta'] : DEFAULT_SUKTA;

		$filterJSON = '{"mandala" : "' . $mandala . '", "sukta" : "' . $sukta . '"}';
		$data = $this->model->listDistinctAttribute('rik, samhita, id', $filterJSON);
		($data) ? $this->getComponent('listing/rikMandala', $data) : $this->view('error/index');
	}

	public function ashtaka($query = array()) {

		$data = $this->model->listDistinctAttribute('ashtaka');
		($data) ? $this->view('listing/ashtaka', $data) : $this->view('error/index');
	}

	public function adhyaya($query = array()) {

		$ashtaka = (isset($query['ashtaka'])) ? $query['ashtaka'] : DEFAULT_ASHTAKA;

		$filterJSON = '{"ashtaka" : "' . $ashtaka . '"}';
		$data = $this->model->listDistinctAttribute('adhyaya', $filterJSON);
		($data) ? $this->getComponent('listing/adhyaya', $data) : $this->view('error/index');
	}

	public function varga($query = array()) {

		$ashtaka = (isset($query['ashtaka'])) ? $query['ashtaka'] : DEFAULT_ASHTAKA;
		$adhyaya = (isset($query['adhyaya'])) ? $query['adhyaya'] : DEFAULT_ADHYAYA;

		$filterJSON = '{"ashtaka" : "' . $ashtaka . '", "adhyaya" : "' . $adhyaya . '"}';
		$data = $this->model->listDistinctAttribute('varga', $filterJSON);
		($data) ? $this->getComponent('listing/varga', $data) : $this->view('error/index');
	}

	public function rikAshtaka($query = array()) {

		$ashtaka = (isset($query['ashtaka'])) ? $query['ashtaka'] : DEFAULT_ASHTAKA;
		$adhyaya = (isset($query['adhyaya'])) ? $query['adhyaya'] : DEFAULT_ADHYAYA;
		$varga = (isset($query['varga'])) ? $query['varga'] : DEFAULT_VARGA;

		$filterJSON = '{"ashtaka" : "' . $ashtaka . '", "adhyaya" : "' . $adhyaya . '", "varga" : "' . $varga . '"}';
		$data = $this->model->listDistinctAttribute('rik, samhita, id', $filterJSON);
		($data) ? $this->getComponent('listing/rikAshtaka', $data) : $this->view('error/index');
	}

	public function attr($attr = DEFAULT_ATTR, $query = array()) {

		$data = $this->model->listDistinctAttribute($attr);
		($data) ? $this->view('listing/attr', $data) : $this->view('error/index');
	}

	public function pada($query = array()) {

		$from = (isset($query['from'])) ? $query['from'] : DEFAULT_PADA_FROM;
		$data = $this->model->listWordConcordance($from);
		($data) ? $this->view('listing/pada', $data) : $this->view('error/index');
	}

	public function mantra($query = array()) {

		$from = (isset($query['from'])) ? $query['from'] : DEFAULT_MANTRA_FROM;
		$data = $this->model->listMantra($from);
		($data) ? $this->view('listing/mantra', $data) : $this->view('error/index');
	}
}

?>
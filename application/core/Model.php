<?php

class Model {

	public function __construct() {

		$this->db = new Database();
	}

	public function getPostData() {

		if (isset($_POST['submit'])) {

			unset($_POST['submit']);	
		}

		if(!array_filter($_POST)) {
		
			return false;
		}
		else {

			return array_filter(filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS));
		}
	}

	public function getGETData() {

		if(!array_filter($_GET)) {
		
			return false;
		}
		else {

			return filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
		}
	}

	public function preProcessPOST ($data) {

		return array_map("trim", $data);
	}

	public function preProcessGET ($data) {

		return array_map("trim", $data);
	}

	public function encrypt ($data) {

		return sha1(SALT.$data);
	}
	
	public function sendLetterToPostman ($fromName = SERVICE_NAME, $fromEmail = SERVICE_EMAIL, 
		$toName = SERVICE_NAME, $toEmail = SERVICE_EMAIL, $subject = 'Bounce', 
		$message = '', $successMessage = 'Bounce', $errorMessage = 'Error') {

	    $mail = new PHPMailer();
        $mail->isSendmail();
        $mail->isHTML(true);
        $mail->setFrom($fromEmail, $fromName);
        $mail->addReplyTo($fromEmail, $fromName);
        $mail->addAddress($toEmail, $toName);
        $mail->Subject = $subject;
        $mail->Body = $message;
        
        return $mail->send();
 	}

 	public function bindVariablesToString ($str = '', $data = array()) {

 		unset($data['count(*)']);
	    
	    while (list($key, $val) = each($data)) {
	    
	        $str = preg_replace('/:'.$key.'/', $val, $str);
		}
	    return $str;
 	}
 
	public function listFiles ($path = '') {

 		if (!(is_dir($path))) return array();

 		$files = scandir($path);
 
 		unset($files[array_search('.', $files)]);
 		unset($files[array_search('..', $files)]);
 
 		return $files;
 	}

 	public function processRikID($id) {

 		// $id = preg_replace('/^0+|\.0+/', '', $id);
 		$pieces = explode('.', $id);
		$id = sprintf("%03d", intval($pieces[0])) . '.' . sprintf("%03d", intval($pieces[1])) . '.' . sprintf("%03d", intval($pieces[2]));

 		return $id;
 	}

	public function listDistinctAttribute($attr = '', $filter = '') {

		if(!($attr)) return null;
		
		if($filter) {
			
			$filterArray = json_decode($filter, True);
			
			$filterPieces = [];
			foreach ($filterArray as $key => $value) {
				
				$data{$key} = $value;	
				$filterPieces[] = $key . ' = \'' . $value . '\'';
			}

			$filterString = 'WHERE ' . implode(' AND ', $filterPieces) . ' ';
		
			$filter = $filterString;
		}

		$dbh = $this->db->connect(DB_NAME);
		if(is_null($dbh))return null;
		
		$sth = $dbh->prepare('SELECT DISTINCT ' . $attr . ' FROM ' . BASEDATA_TABLE . ' ' . $filter . ' ORDER BY ' . $attr);
		$sth->execute();

		$data['list'] = [];
		while($result = $sth->fetch(PDO::FETCH_ASSOC)) {

			array_push($data['list'], $result);
		}

		$dbh = null;

		if ($data) $data['attr'] = $attr;

		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}

    public function addVedicSymbols($text) {

        $text = preg_replace("/\{0\}/", "", $text);
        $text = preg_replace("/\{1\}/", "॒", $text);
        $text = preg_replace("/\{2\}/", "॑", $text);
        $text = preg_replace("/\{4\}/", "ँ", $text);
        $text = preg_replace("/\{5\}/", "ऽ", $text);

        return $text;
    }

    public function removeSwara($text) {

        $text = preg_replace("/॒|॑/", "", $text);

        return $text;
    }

}

?>
<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ernesto J. Rodriguez (Certun)
 * File: Encounter.php
 * Date: 1/21/12
 * Time: 3:26 PM
 */
if(!isset($_SESSION)) {
	session_name('GaiaEHR');
	session_start();
	session_cache_limiter('private');
}
include_once($_SESSION['root'] . '/classes/dbHelper.php');
include_once($_SESSION['root'] . '/dataProvider/Patient.php');
include_once($_SESSION['root'] . '/dataProvider/User.php');
include_once($_SESSION['root'] . '/dataProvider/PoolArea.php');
include_once($_SESSION['root'] . '/dataProvider/Medical.php');
include_once($_SESSION['root'] . '/dataProvider/PreventiveCare.php');

include_once($_SESSION['root'] . '/dataProvider/Services.php');
include_once($_SESSION['root'] . '/dataProvider/DiagnosisCodes.php');
class Encounter
{
	/**
	 * @var dbHelper
	 */
	private $db;
	/**
	 * @var User
	 */
	private $user;
	/**
	 * @var Patient
	 */
	private $patient;
	/**
	 * @var Services
	 */
	private $services;
	/**
	 * @var
	 */
	private $eid;
	/**
	 * @var PoolArea
	 */
	private $poolArea;
	/**
	 * @var Medical
	 */
	private $medical;
	/**
	 * @var PreventiveCare
	 */
	private $preventiveCare;
	/**
	 * @var DiagnosisCodes
	 */
	private $diagnosis;

	function __construct()
	{
		$this->db             = new dbHelper();
		$this->user           = new User();
		$this->patient        = new Patient();
		$this->services       = new Services();
		$this->poolArea       = new PoolArea();
		$this->medical        = new Medical();
		$this->preventiveCare = new PreventiveCare();
		$this->diagnosis      = new DiagnosisCodes();
		return;
	}

	private function setEid($eid)
	{
		$this->eid = $eid;
	}

	/**
	 * @return array
	 *  NOTES: What is ck?
	 *  Naming: "checkOpenEncounters"
	 */
	public function checkOpenEncounters()
	{
		$fields[] = "*";
		$where[]  = "pid = '" . $_SESSION['patient']['pid'] . "'";
		$where[]  = "close_date IS NULL";
		$this->db->setSQL($this->db->sqlSelectBuilder("form_data_encounter", $fields, $where));
		$total = $this->db->rowCount();
		if($total >= 1) {
			return array('encounter' => true);
		} else {
			return array('encounter' => false);
		}
	}

	/**
	 * @param stdClass $params
	 * @return array
	 *  Naming: "getPatientEncounters"
	 */
	public function getEncounters(stdClass $params)
	{
		$fields[] = "*";
		if(isset($params->sort)) {
			$order[$params->sort[0]->direction] = $params->sort[0]->property;
		} else {
			$order['DESC'] = 'start_date';
		}
		$where[] = "pid = '" . $_SESSION['patient']['pid'] . "'";
		$this->db->setSQL($this->db->sqlSelectBuilder('form_data_encounter', $fields, $where, $order));
		$rows = array();
		foreach($this->db->fetchRecords(PDO::FETCH_ASSOC) as $row) {
			$row['status'] = ($row['close_date'] == null) ? 'open' : 'close';
			array_push($rows, $row);
		}
		return $rows;
	}

	/**
	 * @param stdClass $params
	 * @return array
	 *  Naming: "getPatientEncounters"
	 */
	public function getEncountersPastDue(stdClass $params)
	{
		$fields[] = "*";
		if(isset($params->sort)) {
			$order[$params->sort[0]->direction] = $params->sort[0]->property;
		} else {
			$order['DESC'] = 'start_date';
		}
		$where[] = "pid = '" . $_SESSION['patient']['pid'] . "'";
		$this->db->setSQL($this->db->sqlSelectBuilder('form_data_encounter', $fields, $where, $order));
		$rows = array();
		foreach($this->db->fetchRecords(PDO::FETCH_ASSOC) as $row) {
			$row['status'] = ($row['close_date'] == null) ? 'open' : 'close';
			array_push($rows, $row);
		}
		return $rows;
	}

	/**
	 * @param stdClass $params
	 * @return array
	 *  Naming: "createPatientEncounters"
	 */
	public function createEncounter(stdClass $params)
	{
		$params->pid      = (isset($params->pid) && is_numeric($params->pid) ? $params->pid : $_SESSION['patient']['pid']);
		$params->open_uid = $_SESSION['user']['id'];
		$data = get_object_vars($params);
		foreach($data as $key => $val) {
			if($val == '') {
				unset($data[$key]);
			}
		}
		$data['start_date'] = $this->parseDate($data['start_date']);
		$sql = $this->db->sqlBind($data, 'form_data_encounter', 'I');
		$this->db->setSQL($sql);
		$this->db->execLog();
		$eid = $this->db->lastInsertId;
		$default = array('pid'=> $params->pid, 'eid'=> $eid);
		$this->db->setSQL($this->db->sqlBind($default, 'form_data_review_of_systems', 'I'));
		$this->db->execOnly();
		$this->db->setSQL($this->db->sqlBind($default, 'form_data_review_of_systems_check', 'I'));
		$this->db->execOnly();
		$this->db->setSQL($this->db->sqlBind($default, 'form_data_soap', 'I'));
		$this->db->execOnly();
		$this->db->setSQL($this->db->sqlBind($default, 'form_data_dictation', 'I'));
		$this->db->execOnly();
		$params->eid = intval($eid);
		$this->poolArea->updateCurrentPatientPoolAreaByPid(array('eid'=> $params->eid, 'priority'=> $params->priority), $params->pid);
		$this->setEid($params->eid);
		$this->addEncounterHistoryEvent('New Encounter Created');
		return array('success'=> true, 'encounter'=> $params);
	}

	/**
	 * @param stdClass $params
	 * @return array|mixed
	 *  Naming: "getPatientEncounters"
	 */
	public function getEncounter(stdClass $params)
	{
		$this->setEid($params->eid);
		$this->db->setSQL("SELECT * FROM form_data_encounter WHERE eid = '$params->eid'");
		$encounter = $this->db->fetchRecord(PDO::FETCH_ASSOC);
		$encounter['vitals']                = $this->getVitalsByPid($encounter['pid']);
		$encounter['reviewofsystems']       = $this->getReviewOfSystemsByEid($params->eid);
		$encounter['reviewofsystemschecks'] = $this->getReviewOfSystemsChecksByEid($params->eid);
		$encounter['soap']                  = $this->getSoapByEid($params->eid);
		$encounter['speechdictation']       = $this->getDictationByEid($params->eid);
		$this->addEncounterHistoryEvent('Encounter viewed');
		if(!empty($encounter)) {
			return array('success' => true, 'encounter' => $encounter);
		} else {
			return array('success' => false, 'error' => "Encounter ID $params->eid not found");
		}
	}

	public function updateEncounterPriority($params)
	{
		$data['priority'] = $params->priority;
		$this->db->setSQL($this->db->sqlBind($data, 'form_data_encounter', 'U', array('eid'=> $params->eid)));
		$this->db->execLog();
		$this->poolArea->updateCurrentPatientPoolAreaByPid(array('eid'=> $params->eid, 'priority'=> $params->priority), $params->pid);
	}

	/**
	 * @param stdClass $params
	 * @return array|mixed
	 */
	public function updateEncounter(stdClass $params)
	{
		return array("success" => true, 'encounter' => $params);
	}

	/**
	 * @param stdClass $params
	 * @return array
	 */
	public function closeEncounter(stdClass $params)
	{
		$this->setEid($params->eid);
		$data = get_object_vars($params);
		unset($data['eid'], $data['pid'], $data['signature'], $data['note'], $data['reminder']);
		$data['close_uid'] = $_SESSION['user']['id'];
		if($this->user->verifyUserPass($params->signature)) {
			if($params->note != '') {
				$this->patient->addPatientNoteByPid($params->pid, $params->note, $params->eid);
			}
			if($params->reminder != '') {
				$this->patient->addPatientReminderByPid($params->pid, $params->reminder, $params->eid);
			}
			$this->db->setSQL($this->db->sqlBind($data, 'form_data_encounter', 'U', array('eid' => $params->eid)));
			$this->db->execLog();
			$this->addEncounterHistoryEvent('Encounter Closed');
			return array('success'=> true, 'data' => $data);
		} else {
			return array('success'=> false);
		}

	}

	/******************************************************************************************************************/
	/**
	 * @param $pid
	 * @return array
	 */
	public function getVitalsByPid($pid)
	{
		$this->db->setSQL("SELECT * FROM form_data_vitals WHERE pid = '$pid' ORDER BY date DESC");
		$rows = array();
		foreach($this->db->fetchRecords(PDO::FETCH_ASSOC) as $row) {
			$row['height_in']     = intval($row['height_in']);
			$row['height_cn']     = intval($row['height_cn']);
			$row['administer_by'] = $this->user->getUserNameById($row['uid']);
			$row['authorized_by'] = $this->user->getUserNameById($row['auth_uid']);
			array_push($rows, $row);
		}
		return $rows;
	}

	/**
	 * @param $eid
	 * @return array
	 */
	public function getVitalsByEid($eid)
	{
		$this->db->setSQL("SELECT * FROM form_data_vitals WHERE eid = '$eid' ORDER BY date DESC");
		$rows = array();
		foreach($this->db->fetchRecords(PDO::FETCH_ASSOC) as $row) {
			$row['height_in']     = intval($row['height_in']);
			$row['height_cn']     = intval($row['height_cn']);
			$row['administer_by'] = $this->user->getUserNameById($row['uid']);
			$row['authorized_by'] = $this->user->getUserNameById($row['auth_uid']);
			array_push($rows, $row);
		}
		return $rows;
	}

	/**
	 * @param stdClass $params
	 * @return array
	 */
	public function getVitals(stdClass $params)
	{
		$pid    = (isset($params->pid)) ? $params->pid : $_SESSION['patient']['pid'];
		$vitals = $this->getVitalsByPid($pid);
		if(count($vitals) >= 1) {
			return $vitals;
		} else {
			return array();
		}
	}

	/**
	 * @param stdClass $params
	 * @return stdClass
	 */
	public function addVitals(stdClass $params)
	{
		$this->setEid($params->eid);
		$data = get_object_vars($params);

		unset($data['administer_by'], $data['authorized_by'], $data['id'], $data['bp_diastolic_normal'], $data['bp_systolic_normal']);

		$this->db->setSQL($this->db->sqlBind($data, 'form_data_vitals', 'I'));
		$this->db->execLog();

		$params->id            = $this->db->lastInsertId;
		$params->administer_by = $this->user->getUserNameById($params->uid);
		$this->addEncounterHistoryEvent('Vitals added');
		return $params;
	}

	/**
	 * @param stdClass $params
	 * @return stdClass
	 */
	public function updateVitals(stdClass $params)
	{
		$this->setEid($params->eid);
		$params->date = $this->parseDate($params->date);
		$data = get_object_vars($params);
		unset($data['date'], $data['administer_by'], $data['authorized_by'], $data['id'], $data['bp_diastolic_normal'], $data['bp_systolic_normal']);
		$sql = $this->db->sqlBind($data, 'form_data_vitals', 'U', array('id'=> $params->id));
		$this->db->setSQL($sql);
		$this->db->execLog();
		$params->administer_by = $this->user->getUserNameById($params->uid);
		$params->authorized_by = $this->user->getUserNameById($params->auth_uid);
		return $params;
	}

	/******************************************************************************************************************/
	/**
	 * @param $eid
	 * @return array
	 */
	public function getSoapByEid($eid)
	{
		$this->db->setSQL("SELECT * FROM form_data_soap WHERE eid = '$eid' ORDER BY date DESC");
		$soap = $this->db->fetchRecord(PDO::FETCH_ASSOC);
		$soap['icdxCodes'] = $this->diagnosis->getICDByEid($eid);
		return $soap;
	}

	/**
	 * @param stdClass $params
	 * @return stdClass
	 */
	public function updateSoapById(stdClass $params)
	{
		$this->setEid($params->eid);
		$data = get_object_vars($params);
		unset($data['id'], $data['icdxCodes']);
		$this->db->setSQL($this->db->sqlBind($data, 'form_data_soap', 'U', "id='" . $params->id . "'"));
		$this->db->execLog();
		$this->db->setSQL("DELETE FROM encounter_codes_icdx WHERE eid = '$params->eid'");
		$this->db->execOnly();
		$this->updateEncounterIcdxCodes($params);
		$this->addEncounterHistoryEvent('SOAP updated');
		return $params;
	}

	/**
	 * @param $eid
	 * @return array
	 */
	public function getReviewOfSystemsChecksByEid($eid)
	{
		$this->db->setSQL("SELECT * FROM form_data_review_of_systems_check WHERE eid = '$eid' ORDER BY date DESC");
		return $this->db->fetchRecords(PDO::FETCH_ASSOC);
	}

	/**
	 * @param $eid
	 * @return array
	 */
	public function getReviewOfSystemsByEid($eid)
	{
		$this->db->setSQL("SELECT * FROM form_data_review_of_systems WHERE eid = '$eid' ORDER BY date DESC");
		$record = $this->db->fetchRecord();
		foreach($record as $key => $val) {
			$record[$key] = ($val == null) ? 'null' : $val;
		}
		return $record;
	}

	public function getEncounterCodes($params)
	{
		return $this->getEncounterCodesByEid($params->eid);
	}

	public function getEncounterCodesByEid($eid)
	{
		$records = array();
		foreach($this->diagnosis->getICDByEid($eid) as $fo) {
			$fo['type'] = 'ICD';
			$records[]  = $fo;
		}
		$foo = $this->services->getCptByEid($eid);
		foreach($foo['rows'] as $fo) {
			$fo['type'] = 'CPT';
			$records[]  = $fo;
		}
		$foo = $this->services->getHCPCByEid($eid);
		foreach($foo['rows'] as $fo) {
			$fo['type'] = 'HCPC';
			$records[]  = $fo;
		}
		return $records;
	}

	/**
	 * @param $eid
	 * @return array
	 */
	public function getDictationByEid($eid)
	{
		$this->db->setSQL("SELECT * FROM form_data_dictation WHERE eid = '$eid' ORDER BY date DESC");
		return $this->db->fetchRecord(PDO::FETCH_ASSOC);
	}

	public function updateEncounterIcdxCodes(stdClass $params)
	{
		$this->setEid($params->eid);
		if(!is_string($params->icdxCodes)) {
			foreach($params->icdxCodes as $icdcCode) {
				$icdc['eid']  = $params->eid;
				$icdc['code'] = trim($icdcCode);
				$this->db->setSQL($this->db->sqlBind($icdc, 'encounter_codes_icdx', 'I'));
				$this->db->execOnly();
			}
		} else {
			$icdc['eid']  = $params->eid;
			$icdc['code'] = trim($params->icdxCodes);
			$this->db->setSQL($this->db->sqlBind($icdc, 'encounter_codes_icdx', 'I'));
			$this->db->execOnly();
		}
		return $params;
	}

	public function getEncounterIcdxCodes(stdClass $params)
	{
		$this->setEid($params->eid);
		return $this->services->getIcdxByEid($params->eid);
	}

	/**
	 * @param stdClass $params
	 * @return stdClass
	 */
	public function updateReviewOfSystemsChecksById(stdClass $params)
	{
		$this->setEid($params->eid);
		$data = get_object_vars($params);
		unset($data['id']);
		$this->db->setSQL($this->db->sqlBind($data, 'form_data_review_of_systems_check', 'U', "id='" . $params->id . "'"));
		$this->db->execLog();
		$this->addEncounterHistoryEvent('Review of System Checks updated');
		return $params;
	}

	/**
	 * @param stdClass $params
	 * @return stdClass
	 */
	public function updateReviewOfSystemsById(stdClass $params)
	{
		$this->setEid($params->eid);
		$data = get_object_vars($params);
		unset($data['id']);
		$this->db->setSQL($this->db->sqlBind($data, 'form_data_review_of_systems', 'U', "id='" . $params->id . "'"));
		$this->db->execLog();
		$this->addEncounterHistoryEvent('Review of System updated');
		return $params;
	}

	/**
	 * @param stdClass $params
	 * @return stdClass
	 */
	public function updateDictationById(stdClass $params)
	{
		$this->setEid($params->eid);
		$data = get_object_vars($params);
		unset($data['id']);
		$this->db->setSQL($this->db->sqlBind($data, 'form_data_dictation', 'U', "id='" . $params->id . "'"));
		$this->db->execLog();
		$this->addEncounterHistoryEvent('Speech Dictation updated');
		return $params;
	}

	/**
	 * @param $eid
	 * @return array
	 *  Naming: "closePatientEncounter"
	 */
	public function getProgressNoteByEid($eid)
	{
		$this->db->setSQL("SELECT * FROM form_data_encounter WHERE eid = '$eid'");
		$encounter                 = $this->db->fetchRecord(PDO::FETCH_ASSOC);
		$encounter['start_date']   = date('F j, Y, g:i a', strtotime($encounter['start_date']));
		$encounter['patient_name'] = $this->patient->getPatientFullNameByPid($encounter['pid']);
		$encounter['open_by']      = $this->user->getUserNameById($encounter['open_uid']);
		$encounter['signed_by']    = $this->user->getUserNameById($encounter['close_uid']);
		/**
		 * Add vitals to progress note
		 */
		$vitals = $this->getVitalsByEid($eid);
		if(count($vitals)) $encounter['vitals'] = $vitals;
		/**
		 * Add Review of Systems to progress note
		 */
		$ros = $this->getReviewOfSystemsByEid($eid);
		$foo = array();
		foreach($ros as $key => $value) {
			if($key != 'id' && $key != 'pid' && $key != 'eid' && $key != 'uid' && $key != 'date') {
				if($value != null && $value != 'null') {
					$value = ($value == 1 || $value == '1') ? 'Yes' : 'No';
					$foo[] = array('name' => $key, 'value' => $value);
				}
			}

		}
		if(!empty($foo)) $encounter['reviewofsystems'] = $foo;
		/**
		 * Add Review of Systems Checks to progress note
		 */
		$rosck = $this->getReviewOfSystemsChecksByEid($eid);
		$foo   = array();
		foreach($rosck[0] as $key => $value) {
			if($key != 'id' && $key != 'pid' && $key != 'eid' && $key != 'uid' && $key != 'date') {
				if($value != null && $value != 'null' && $value != '0' || $value != 0) {
					$value = ($value == 1 || $value == '1') ? 'Yes' : 'No';
					$foo[] = array('name' => $key, 'value' => $value);
				}
			}
		}
		if(!empty($foo)) $encounter['reviewofsystemschecks'] = $foo;
		/**
		 * Add SOAP to progress note
		 */
		$icdxs = '';
		foreach($this->diagnosis->getICDByEid($eid) as $code) {
			$icdxs .= '<li><span style="font-weight:bold; text-decoration:none">' . $code['code'] . '</span> - ' . $code['long_desc'] . '</li>';
		}
		//$icdxs = substr($icdxs, 0, -2);
		$soap = $this->getSoapByEid($eid);
		$medications = $this->medical->getPatientMedicationsByEncounterID($eid);
		if(!empty($medications)) {
			$lis = '';
			foreach($medications as $foo) {
				$lis .= '<li>' . $foo['medication'] . ' ' . $foo['dose'] . ' ' . $foo['dose_mg'] . '<br>';
				$lis .= 'Instruction: ' . $foo['take_pills'] . ' ' . $foo['type'] . ' ' . $foo['by'] . ' ' . $foo['prescription_often'] . ' ' . $foo['prescription_when'] . '<br>';
				$lis .= 'Dispense: ' . $foo['dispense'] . '  Refill: ' . $foo['refill'] . ' </li>';
			}
			$soap['objective'] .= '<p>Medications:</p>';
			$soap['objective'] .= '<ul class="ProgressNote-ul">' . $lis . '</ul>';
		}
		$immunizations = $this->medical->getImmunizationsByEncounterID($eid);
		if(!empty($immunizations)) {
			$lis = '';
			foreach($immunizations as $foo) {
				$lis .= '<li>Immunization name: ' . $foo['immunization_name'] . '<br>';
				$lis .= 'Immunization ID: ' . $foo['immunization_id'] . '<br>';
				$lis .= 'Manufacturer: ' . $foo['manufacturer'] . '<br>';
				$lis .= 'Lot Number: ' . $foo['lot_number'] . '<br>';
				$lis .= 'Dosis: ' . $foo['dosis'] . '<br>';
				$lis .= 'Administered By: ' . $foo['administered_by'] . ' </li>';
			}
			$soap['objective'] .= '<p>Immunizations:</p>';
			$soap['objective'] .= '<ul class="ProgressNote-ul">' . $lis . '</ul>';
		}
		$allergies = $this->medical->getAllergiesByEncounterID($eid);
		if(!empty($allergies)) {
			$lis = '';
			foreach($allergies as $foo) {
				$lis .= '<li>Allergy: ' . $foo['allergy'] . ' (' . $foo['allergy_type'] . ')<br>';
				$lis .= 'Reaction: ' . $foo['reaction'] . '<br>';
				$lis .= 'Severity: ' . $foo['severity'] . '<br>';
				$lis .= 'Location: ' . $foo['location'] . '<br>';
				$lis .= 'Active?: ' . ($foo['end_date'] != null ? 'Yes' : 'No') . '</li>';
			}
			$soap['objective'] .= '<p>Allergies:</p>';
			$soap['objective'] .= '<ul class="ProgressNote-ul">' . $lis . '</ul>';
		}
		$surgeries = $this->medical->getPatientSurgeryByEncounterID($eid);
		if(!empty($surgeries)) {
			$lis = '';
			foreach($surgeries as $foo) {
				//			    $lis .= '<li>Immunization name: '.$foo['immunization_name'].'<br>';
				//			    $lis .= 'Immunization ID: ' .$foo['immunization_id'].'<br>';
				//			    $lis .= 'Administered By: '.$foo['administered_by'].' </li>';
			}
			$soap['objective'] .= '<p>Surgeries:</p>';
			$soap['objective'] .= '<ul class="ProgressNote-ul">' . $lis . '</ul>';
		}
		$dental = $this->medical->getPatientDentalByEncounterID($eid);
		if(!empty($dental)) {
			$lis = '';
			foreach($dental as $foo) {
				//			    $lis .= '<li>Immunization name: '.$foo['immunization_name'].'<br>';
				//			    $lis .= 'Immunization ID: ' .$foo['immunization_id'].'<br>';
				//			    $lis .= 'Administered By: '.$foo['administered_by'].' </li>';
			}
			$soap['objective'] .= '<p>Dental:</p>';
			$soap['objective'] .= '<ul class="ProgressNote-ul">' . $lis . '</ul>';
		}
		$activeProblems = $this->medical->getMedicalIssuesByEncounterID($eid);
		if(!empty($activeProblems)) {
			$lis = '';
			foreach($activeProblems as $foo) {
				$lis .= '<li>Immunization name: ' . $foo['immunization_name'] . '<br>';
				//			    $lis .= 'Immunization ID: ' .$foo['immunization_id'].'<br>';
				//			    $lis .= 'Administered By: '.$foo['administered_by'].' </li>';
			}
			$soap['objective'] .= '<p>Active Problems:</p>';
			$soap['objective'] .= '<ul class="ProgressNote-ul">' . $lis . '</ul>';
		}
		$preventiveCare = $this->preventiveCare->getPreventiveCareDismissPatientByEncounterID($eid);
		if(!empty($preventiveCare)) {
			$lis = '';
			foreach($preventiveCare as $foo) {
				$lis .= '<li>Description: ' . $foo['description'] . '<br>';
				$lis .= 'Reason: ' . $foo['reason'] . '<br>';
				$lis .= 'Observation: ' . $foo['observation'] . ' </li>';
			}
			$soap['objective'] .= '<p>Preventive Care:</p>';
			$soap['objective'] .= '<ul class="ProgressNote-ul">' . $lis . '</ul>';
		}
		$soap['assessment'] = $soap['assessment'] . '<ul  class="ProgressNote-ul">' . $icdxs . '</ul>';
		$encounter['soap'] = $soap;
		/**
		 * Add Dictation to progress note
		 */
		$speech = $this->getDictationByEid($eid);
		if($speech['dictation']) {
			$encounter['speechdictation'] = $speech;
		}
		/**
		 * return the encounter array of data
		 */
		return $encounter;
	}

	protected function addEncounterHistoryEvent($msg)
	{
		$data['eid'] = $this->eid;
		//$data['pid']    = $_SESSION['patient']['pid'];
		$data['date']  = date('Y-m-d H:i:s');
		$data['user']  = $this->user->getCurrentUserTitleLastName();
		$data['event'] = $msg;
		$this->db->setSQL($this->db->sqlBind($data, 'encounter_history', 'I'));
		$this->db->execOnly();
	}

	public function getEncounterEventHistory($params)
	{
		$this->db->setSQL("SELECT * FROM encounter_history WHERE eid = '$params->eid' ORDER BY `date` DESC");
		return $this->db->fetchRecords(PDO::FETCH_ASSOC);
	}

	public function checkoutAlerts(stdClass $params)
	{
		$alerts = array();
		$this->db->setSQL("SELECT review_immunizations,
                                  review_allergies,
                                  review_active_problems,
                                  review_surgery,
                                  review_dental,
                                  review_medications,
                                  review_alcohol,
                                  review_smoke,
                                  review_pregnant
                             FROM form_data_encounter
                            WHERE eid = '$params->eid'");
		$records = $this->db->fetchRecord(PDO::FETCH_ASSOC);
		foreach($records as $key => $rec) {
			if($rec != 0 && $rec != null) {
				unset($records[$key]);
			}
		}
		foreach($records as $key => $rec) {
			$foo              = array();
			$foo['alert']     = 'Need to ' . str_replace('_', ' ', $key) . ' area';
			$foo['alertType'] = 1;
			$alerts[]         = $foo;
		}
		//TODO: vitals check
		return $alerts;
	}

	/**
	 * @param $date
	 * @return mixed
	 */
	public function parseDate($date)
	{
		return str_replace('T', ' ', $date);
	}

	public function checkForAnOpenedEncounterByPid(stdClass $params)
	{
		$date = strtotime('-1 day', strtotime($params->date));
		$date = date('Y-m-d H:i:s', $date);
		$this->db->setSQL("SELECT * FROM form_data_encounter
                           WHERE (pid='$params->pid'
                           AND   close_date is NULL)
                           AND start_date >= '$date'");
		$data = $this->db->fetchRecord(PDO::FETCH_ASSOC);
		if(isset($data['eid'])) {
			return true;
		} else {
			return false;
		}

	}

	public function getEncounterFollowUpInfoByEid($eid)
	{
		$this->db->setSQL("SELECT followup_time, followup_facility FROM form_data_encounter WHERE eid = '$eid'");
		$rec                      = $this->db->fetchRecord(PDO::FETCH_ASSOC);
		$rec['followup_facility'] = intval($rec['followup_facility']);
		return $rec;
	}

	public function getEncounterMessageByEid($eid)
	{
		$this->db->setSQL("SELECT message FROM form_data_encounter WHERE eid = '$eid'");
		return $this->db->fetchRecord(PDO::FETCH_ASSOC);
	}

	public function onSaveItemsToReview(stdClass $params)
	{
		$data = get_object_vars($params);
		$eid  = $data['eid'];
		unset($data['eid']);
		$this->db->setSQL($this->db->sqlBind($data, "form_data_encounter", "U", "eid='$eid'"));
		$this->db->execLog();
		return array('success' => true);

	}

}
//
//$params = new stdClass();
//$params->eid = 1;
////$params->date = '2012-06-25 10:48:00';
//
//$e = new Encounter();
//echo '<pre>';
////print_r($e->getEncounter($params));
//print_r($e->getSoapByEid(1));

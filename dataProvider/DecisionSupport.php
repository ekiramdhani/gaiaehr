<?php
/**
 * GaiaEHR (Electronic Health Records)
 * Copyright (C) 2013 Certun, LLC.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

include_once(ROOT . '/dataProvider/Patient.php');
include_once(ROOT . '/dataProvider/Vitals.php');
include_once(ROOT . '/dataProvider/Orders.php');
include_once(ROOT . '/dataProvider/Allergies.php');
include_once(ROOT . '/dataProvider/Medications.php');
include_once(ROOT . '/dataProvider/Procedures.php');
include_once(ROOT . '/dataProvider/ActiveProblems.php');
include_once(ROOT . '/lib/Matcha/plugins/Carbon/Carbon.php');

class DecisionSupport {

	/**
	 * @var MatchaCUP Rules Model
	 */
	private $r;
	/**
	 * @var MatchaCUP Rule Items Model
	 */
	private $rc;

	/**
	 * @var Patient
	 */
	private $Patient;
	/**
	 * @var Medications
	 */
	private $Medications;
	/**
	 * @var Procedures
	 */
	private $Procedures;
	/**
	 * @var ActiveProblems
	 */
	private $ActiveProblems;
	/**
	 * @var Orders
	 */
	private $Orders;
	/**
	 * @var Allergies
	 */
	private $Allergies;
	/**
	 * @var Vitals
	 */
	private $Vitals;
	/**
	 * @var null | Array
	 */
	private $rules = null;

	function __construct() {
		$this->r = MatchaModel::setSenchaModel('App.model.administration.DecisionSupportRule');
		$this->rc = MatchaModel::setSenchaModel('App.model.administration.DecisionSupportRuleConcept');
		$this->Orders = new Orders();
		$this->Vitals = new Vitals();
		$this->Allergies = new Allergies();
		$this->Medications = new Medications();
		$this->Procedures = new Procedures();
		$this->ActiveProblems = new ActiveProblems();

	}

	public function getDecisionSupportRules($params){
		return $this->r->load($params)->all();
	}

	public function getDecisionSupportRule($params){
		return $this->r->load($params)->one();
	}

	public function addDecisionSupportRule($params){
		return $this->r->save($params);
	}

	public function updateDecisionSupportRule($params){
		return $this->r->save($params);
	}

	public function deleteDecisionSupportRule($params){
		return $this->r->destroy($params);
	}

	public function getDecisionSupportRuleConcepts($params){
		return $this->rc->load($params)->all();
	}

	public function getDecisionSupportRuleConcept($params){
		return $this->rc->load($params)->one();
	}

	public function addDecisionSupportRuleConcept($params){
		return $this->rc->save($params);
	}

	public function updateDecisionSupportRuleConcept($params){
		return $this->rc->save($params);
	}

	public function deleteDecisionSupportRuleConcept($params){
		return $this->rc->destroy($params);
	}

	/**
	 * @param object $params $params->pid and $params->alertType required
	 * @return array
	 */
	public function getAlerts($params){
		$this->Patient = new Patient($params->pid);
		$this->setRules($params->alertType);
		$alerts = array();
		foreach($this->rules as $rule){
			$alert = $this->ckRule($rule);
			if($alert !== false){
				unset($rule['concepts']); // remove concepts
				$alerts[] = $rule;
			}
		}
		return $alerts;
	}

	private function setRules($alertType, $category = 'C'){
		$params = new stdClass();

		$params->filter[0] = new stdClass();
		$params->filter[0]->property = 'active';
		$params->filter[0]->value = 1;

		$params->filter[1] = new stdClass();
		$params->filter[1]->property = 'alert_type';
		$params->filter[1]->value = $alertType;

		$params->filter[2] = new stdClass();
		$params->filter[2]->property = 'category';
		$params->filter[2]->value = $category;

		// get support rules
		$this->rules = $this->getDecisionSupportRules($params);
		$this->rules = $this->rules['data'];

		// unset filter[2] to use $params to filter concepts
		unset($params->filter[2]);

		// change property to filter concepts
		$params->filter[0]->property = 'rule_id';
		$params->filter[1]->property = 'concept_type';
		foreach($this->rules as $i => $rule){
			$params->filter[0]->value = $rule['id'];

			$params->filter[1]->value = 'PROC';
			$this->rules[$i]['concepts']['PROC'] = $this->getDecisionSupportRuleConcepts($params);

			$params->filter[1]->value = 'PROB';
			$this->rules[$i]['concepts']['PROB'] = $this->getDecisionSupportRuleConcepts($params);

			$params->filter[1]->value = 'MEDI';
			$this->rules[$i]['concepts']['MEDI'] = $this->getDecisionSupportRuleConcepts($params);

			$params->filter[1]->value = 'ALLE';
			$this->rules[$i]['concepts']['ALLE'] = $this->getDecisionSupportRuleConcepts($params);

			$params->filter[1]->value = 'LAB';
			$this->rules[$i]['concepts']['LAB'] = $this->getDecisionSupportRuleConcepts($params);

			$params->filter[1]->value = 'VITA';
			$this->rules[$i]['concepts']['VITA'] = $this->getDecisionSupportRuleConcepts($params);
		}
		// unset params since will not be use again
		unset($params);
	}

	private function ckRule($rule){
		return (
			$this->ckDemographics($rule) && (
				!isset($rule['concepts']) || (
					$this->ckProcedures($rule) &&  // done
					$this->ckActiveProblems($rule) && // done
					$this->ckActiveMedications($rule) &&// done
					$this->ckActiveMedicationAllergies($rule) && //done
					$this->ckLaboratoryResults($rule) && // done
					$this->ckSocialHistory($rule) && // done
					$this->ckVitals($rule) // done
				)
			)
		);
	}

	/**
	 * this method will always return true unless one of the conditions is met.
	 * @param $rule
	 * @return bool
	 */
	private function ckDemographics($rule){
		$age = $this->Patient->getPatientAge();
		// if age_start if not unlimited and patient age is less than age_start, return false
		if($rule['age_start'] > 0 && $age['DMY']['years'] < $rule['age_start']){
			 return false;
		}
		// if age_end if not unlimited and patient age is grater than age_end, return false
		if($rule['age_end'] > 0 && $age['DMY']['years'] > $rule['age_end']){
			return false;
		}
		if($rule['sex'] !== 'all' && $this->Patient->getPatientSex() != $rule['sex']){
			return false;
		}
		return true;
	}

	/**
	 * @param $rule
	 * @return bool
	 */
	private function ckProcedures($rule){
		if(isset($rule['concepts']['PROC']) && !empty($rule['concepts']['PROC'])){
			$count = 0;
			foreach($rule['concepts']['PROC'] as $concept){
				$procedures = $this->Procedures->getPatientProcedureByPidAndCode($this->Patient->getPatientPid(), $concept['concept_code']);
				if(empty($procedures)) continue;
				if($concept['frequency_interval'] == 0){
					$count++;
					continue;
				}
				$frequency = 0;
				foreach($procedures as $procedure){
					if($this->isWithInterval($procedure['create_date'], $concept['frequency_interval'], $concept['frequency_operator'], 'Y-m-d H:i:s')){
						$frequency++;
						if($concept['frequency'] == $frequency) break;
					}
				}
				if($frequency >= $concept['frequency']){
					$count++;
				}
			}
			return $count == count($rule['concepts']['PROC']);
		}
		return true;
	}

	/**
	 * @param $rule
	 * @return bool
	 */
	private function ckActiveProblems($rule){
		if(isset($rule['concepts']['PROB']) && !empty($rule['concepts']['PROB'])){
			$count = 0;
			foreach($rule['concepts']['PROB'] as $concept){
				$problems = $this->ActiveProblems->getPatientActiveProblemByPidAndCode($this->Patient->getPatientPid(), $concept['concept_code']);
				if(empty($problems)) continue;
				if($concept['frequency_interval'] == 0){
					$count++;
					continue;
				}
				$frequency = 0;
				foreach($problems as $problem){
					if($this->isWithInterval($problem['begin_date'], $concept['frequency_interval'], $concept['frequency_operator'], 'Y-m-d')){
						$frequency++;
						if($concept['frequency'] == $frequency) break;
					}
				}
				if($frequency >= $concept['frequency']){
					$count++;
				}
			}
			return $count == count($rule['concepts']['PROB']);
		}
		return true;
	}

	/**
	 * @param $rule
	 * @return bool
	 */
	private function ckActiveMedications($rule){

		if(isset($rule['concepts']['MEDI']) && !empty($rule['concepts']['MEDI'])){
			$count = 0;
			foreach($rule['concepts']['MEDI'] as $concept){
				$medications = $this->Medications->getPatientActiveMedicationsByPidAndCode($this->Patient->getPatientPid(), $concept['concept_code']);
				if(empty($medications)) continue;
				$count++;
			}
			// meditations found should equal the medication concepts
			return $count == count($rule['concepts']['MEDI']);
		}

		return true;
	}

	/**
	 * @param $rule
	 * @return bool
	 */
	private function ckActiveMedicationAllergies($rule){

		if(isset($rule['concepts']['ALLE']) && !empty($rule['concepts']['ALLE'])){
			$count = 0;
			foreach($rule['concepts']['ALLE'] as $concept){
				$allergies = $this->Allergies->getPatientActiveDrugAllergiesByPidAndCode($this->Patient->getPatientPid(), $concept['concept_code']);
				if(empty($allergies)) continue;

				if($concept['frequency_interval'] == 0){
					$count++;
					continue;
				}
				$frequency = 0;
				foreach($allergies as $allergy){
					if($this->isWithInterval($allergy['begin_date'], $concept['frequency_interval'], $concept['frequency_operator'], 'Y-m-d')){
						$frequency++;
						if($concept['frequency'] == $frequency) break;
					}
				}
				if($frequency >= $concept['frequency']){
					$count++;
				}
			}
			return $count == count($rule['concepts']['ALLE']);
		}
		return true;
	}

	/**
	 * @param $rule
	 * @return bool
	 */
	private function ckLaboratoryResults($rule){
		if(isset($rule['concepts']['LAB']) && !empty($rule['concepts']['LAB'])){
			$count = 0;
			foreach($rule['concepts']['LAB'] as $concept){
				$observations = $this->Orders->getOrderResultObservationsByPidAndCode($this->Patient->getPatientPid(), $concept['concept_code']);
				if(empty($observations)) continue;
				$frequency = 0;
				foreach($observations as $observation){
					if($this->compare($observation['value'], $concept['value_operator'], $concept['value'])){
						if($this->isWithInterval($observation['result_date'], $concept['frequency_interval'], $concept['frequency_operator'], 'Y-m-d H:i:s')){
							$frequency++;
							if($concept['frequency'] == $frequency) break;
						}
					}
				}
				if($concept['frequency_interval'] == 0 || $frequency >= $concept['frequency']){
					$count++;
				}
			}
			return $count == count($rule['concepts']['LAB']);
		}
		return true;
	}

	/**
	 * @param $rule
	 * @return bool
	 */
	private function ckSocialHistory($rule){
		if(isset($rule['concepts']['SOCI']) && !empty($rule['concepts']['SOCI'])){
			$count = 0;
			foreach($rule['concepts']['SOCI'] as $concept){
				$vitals = $this->Vitals->getVitalsByPid($this->Patient->getPatientPid());
				$codes = $this->Vitals->getCodes();
				if(empty($vitals)) continue;
				$frequency = 0;
				foreach($vitals as $vital){
					$mapping = $codes[$concept['concept_code']]['mapping'];
					if($this->compare($vital[$mapping], $concept['value_operator'], $concept['value'])){
						if($this->isWithInterval($vital['date'], $concept['frequency_interval'], $concept['frequency_operator'], 'Y-m-d H:i:s')){
							$frequency++;
							//if($concept['frequency'] == $frequency) break;
						}
					}
				}
				if($concept['frequency_interval'] == 0 || $frequency >= $concept['frequency']){
					$count++;
				}
			}
			return $count == count($rule['concepts']['SOCI']);
		}

		return true;
	}

	/**
	 * @param $rule
	 * @return bool
	 */
	private function ckVitals($rule){
		if(isset($rule['concepts']['VITA']) && !empty($rule['concepts']['PROC'])){
			$count = 0;
			foreach($rule['concepts']['VITA'] as $concept){
				$vitals = $this->Vitals->getVitalsByPid($this->Patient->getPatientPid());
				$codes = $this->Vitals->getCodes();
				if(empty($vitals)) continue;
				$frequency = 0;
				foreach($vitals as $vital){
					$mapping = $codes[$concept['concept_code']]['mapping'];
					if($this->compare($vital[$mapping], $concept['value_operator'], $concept['value'])){
						if($this->isWithInterval($vital['date'], $concept['frequency_interval'], $concept['frequency_operator'], 'Y-m-d H:i:s')){
							$frequency++;
							//if($concept['frequency'] == $frequency) break;
						}
					}
				}
				if($concept['frequency_interval'] == 0 || $frequency >= $concept['frequency']){
					$count++;
				}
			}
			return $count == count($rule['concepts']['VITA']);
		}

		return true;
	}

	private function isWithInterval($date, $interval, $operator = '=', $dateFormat = 'Y-m-d'){
		$now = Carbon::now();
		$date = Carbon::createFromFormat($dateFormat, $date);
		switch(strtoupper($interval[1])){
			case 'D':
				$date->addDays($interval[0]);
				break;
			case 'M':
				$date->addMonths($interval[0]);
				break;
			default:
				$date->addYears($interval[0]);
		}
		return $this->compare($now, $operator, $date);
	}

	private function compare($v1, $operator, $v2){
		switch($operator) {
			case '!=': return $v1 != $v2;
			case '>=': return $v1 >= $v2;
			case '<=': return $v1 <= $v2;
			case '>':  return $v1 >  $v2;
			case '<':  return $v1 <  $v2;
			default:   return $v1 == $v2;
		}
	}

}

//$params = new stdClass();
//$params->start = 0;
//$params->limit = 25;
//$params->pid = 5;
//$t = new PreventiveCare();
//print '<pre>';
//print_r($t->getPreventiveCareCheck($params));

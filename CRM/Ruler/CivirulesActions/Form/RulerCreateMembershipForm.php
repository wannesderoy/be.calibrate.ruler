<?php

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Ruler_CivirulesActions_Form_RulerCreateMembershipForm extends CRM_CivirulesActions_Form_Form {

  protected $ruleActionId = FALSE;

  protected $ruleAction;

  protected $action;

  /**
   * Overridden parent method to do pre-form building processing
   *
   * @throws Exception when action or rule action not found
   * @access public
   */
  public function preProcess() {
    $this->ruleActionId = CRM_Utils_Request::retrieve('rule_action_id', 'Integer');
    $this->ruleAction = new CRM_Civirules_BAO_RuleAction();
    $this->action = new CRM_Civirules_BAO_Action();
    $this->ruleAction->id = $this->ruleActionId;
    if ($this->ruleAction->find(TRUE)) {
      $this->action->id = $this->ruleAction->action_id;
      if (!$this->action->find(TRUE)) {
        throw new Exception('CiviRules Could not find action with id ' . $this->ruleAction->action_id);
      }
    }
    else {
      throw new Exception('CiviRules Could not find rule action with id ' . $this->ruleActionId);
    }
    parent::preProcess();
  }

  /**
   * Method to get membership types
   *
   * @return array
   * @access protected
   */
  protected function getMembershipTypes() {
    $types = [];
    $types[] = ts('- Select -');
    $types = $types + CRM_Member_BAO_MembershipType::getMembershipTypes();
    return $types;
  }

  /**
   * Method to get the membership status
   *
   * @return array
   * @access protected
   */
  protected function getMemershipStatus() {
    $statuses = civicrm_api3('MembershipStatus', 'get', []);
    $return = [];
    $return[] = ts('- Select -');
    foreach ($statuses['values'] as $status) {
      $return[$status['id']] = $status['label'];
    }
    return $return;
  }

  function buildQuickForm() {
    $this->setFormTitle();
    $this->add('hidden', 'rule_action_id');
    $this->add('select', 'membership_type', ts('Membership types'), $this->getMembershipTypes(), TRUE);
    $this->add('select', 'membership_status', ts('Membership status'), $this->getMemershipStatus(), TRUE);
    $this->addFormRule([
      'CRM_Ruler_CivirulesActions_Form_RulerCreateMembershipForm',
      'validateForm',
    ]);
    $this->addButtons([
      ['type' => 'next', 'name' => ts('Save'), 'isDefault' => TRUE,],
      ['type' => 'cancel', 'name' => ts('Cancel')],
    ]);
  }

  public static function validateForm($fields) {
    $errors = [];
    if (empty($fields['membership_type'])) {
      $errors['membership_type'] = ts('Membership type is required');
    }
    if (empty($fields['membership_status'])) {
      $errors['membership_status'] = ts('Membership status is required');
    }
    if (!empty($errors)) {
      return $errors;
    }
    else {
      return TRUE;
    }
  }

  /**
   * Overridden parent method to set default values
   *
   * @return array $defaultValues
   * @access public
   */
  public function setDefaultValues() {
    $data = [];
    $defaultValues = [];
    $defaultValues['rule_action_id'] = $this->ruleActionId;
    if (!empty($this->ruleAction->action_params)) {
      $data = unserialize($this->ruleAction->action_params);
    }
    if (!empty($data['membership_type'])) {
      $defaultValues['membership_type'] = $data['membership_type'];
    }
    if (!empty($data['membership_status'])) {
      $defaultValues['membership_status'] = $data['membership_status'];
    }
    return $defaultValues;
  }

  /**
   * Overridden parent method to process form data after submitting
   *
   * @access public
   */
  public function postProcess() {
    $data['membership_status'] = $this->_submitValues['membership_status'];
    $data['membership_type'] = $this->_submitValues['membership_type'];
    $ruleAction = new CRM_Civirules_BAO_RuleAction();
    $ruleAction->id = $this->ruleActionId;
    $ruleAction->action_params = serialize($data);
    $ruleAction->save();
    $session = CRM_Core_Session::singleton();
    $session->setStatus('Action ' . $this->action->label . ' parameters updated to CiviRule ' . CRM_Civirules_BAO_Rule::getRuleLabelWithId($this->ruleAction->rule_id),
      'Action parameters updated', 'success');
    $redirectUrl = CRM_Utils_System::url('civicrm/civirule/form/rule', 'action=update&id=' . $this->ruleAction->rule_id, TRUE);
    CRM_Utils_System::redirect($redirectUrl);
  }

  /**
   * Method to set the form title
   *
   * @access protected
   */
  protected function setFormTitle() {
    $title = 'CiviRules Edit Action parameters';
    $this->assign('ruleActionHeader', 'Edit action ' . $this->action->label . ' of CiviRule ' . CRM_Civirules_BAO_Rule::getRuleLabelWithId($this->ruleAction->rule_id));
    CRM_Utils_System::setTitle($title);
  }

}

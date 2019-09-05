<?php
/**
 * @author Calibrate <hello@calibrate.be>
 * @license http://www.gnu.org/licenses/agpl-3.0.html
 */

class CRM_Ruler_CivirulesActions_RulerCreateMembership extends CRM_Civirules_Action {

  /**
   * Process the action
   *
   * @param CRM_Civirules_TriggerData_TriggerData $triggerData
   *
   * @throws Exception
   * @access public
   */
  public function processAction(CRM_Civirules_TriggerData_TriggerData $triggerData) {
    $membershipParams = [];
    $actionParams = $this->getActionParameters();
    $membershipParams['membership_type_id'] = $actionParams['membership_type'];
    $membershipParams['status_id'] = $actionParams['membership_status'];
    $membershipParams['contact_id'] = $triggerData->getContactId();

    // @todo Checks: has membership?
    $result = civicrm_api3('Membership', 'create', $membershipParams);
  }

  /**
   * Returns a redirect url to extra data input from the user after adding a
   * action
   *
   * Return false if you do not need extra data input
   *
   * @param int $ruleActionId
   *
   * @return bool|string
   * $access public
   */
  public function getExtraDataInputUrl($ruleActionId) {
    return CRM_Utils_System::url('civicrm/civirule/form/action/createmembershipform', 'rule_action_id=' . $ruleActionId);
  }

  /**
   * Returns a user friendly text explaining the condition params
   * e.g. 'Older than 65'
   *
   * @return string
   * @access public
   */
  public function userFriendlyConditionParams() {
    $params = $this->getActionParameters();
    $label = ts('Set membership type to: ');
    $label .= print_r($params, TRUE);
    return $label;
  }

}

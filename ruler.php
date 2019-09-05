<?php

require_once 'ruler.civix.php';
use CRM_Ruler_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function ruler_civicrm_config(&$config) {
  _ruler_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function ruler_civicrm_xmlMenu(&$files) {
  _ruler_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function ruler_civicrm_install() {
  _ruler_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function ruler_civicrm_postInstall() {
  _ruler_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function ruler_civicrm_uninstall() {
  _ruler_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function ruler_civicrm_enable() {
  _ruler_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function ruler_civicrm_disable() {
  _ruler_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function ruler_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _ruler_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function ruler_civicrm_managed(&$entities) {
  _ruler_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_caseTypes
 */
function ruler_civicrm_caseTypes(&$caseTypes) {
  _ruler_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
function ruler_civicrm_angularModules(&$angularModules) {
  _ruler_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function ruler_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _ruler_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function ruler_civicrm_entityTypes(&$entityTypes) {
  _ruler_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_themes().
 */
function ruler_civicrm_themes(&$themes) {
  _ruler_civix_civicrm_themes($themes);
}

/**
 * Function to check if CiviRules extension (org.civicoop.civirules) is
 * installed as this is required.
 */
function _ruler_civirules_installed() {
  $installed = FALSE;
  try {
    $extensions = civicrm_api3('Extension', 'get');
    foreach($extensions['values'] as $ext) {
      if ($ext['key'] == 'org.civicoop.civirules' &&$ext['status'] == 'installed') {
        $installed = TRUE;
      }
    }
  } catch (Exception $e) {
    $installed = FALSE;
  }
  return $installed;
}

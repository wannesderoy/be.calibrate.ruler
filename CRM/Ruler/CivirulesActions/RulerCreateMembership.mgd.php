<?php
/**
 * @author Calibrate <hello@calibrate.be>
 * @license http://www.gnu.org/licenses/agpl-3.0.html
 */

if (_ruler_civirules_installed()) {
  return [
    0 =>
      [
        'name' => 'Civirules:Action.RulerCreateMembership',
        'entity' => 'CiviRuleAction',
        'params' =>
          [
            'version' => 3,
            'name' => 'ruler_create_membership',
            'label' => 'Create new membership from Contribution',
            'class_name' => 'CRM_Ruler_CivirulesActions_RulerCreateMembership',
            'is_active' => 1,
          ],
      ],
  ];
}


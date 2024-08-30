<?php

require_once 'reminderpreview.civix.php';
// phpcs:disable
use CRM_Reminderpreview_ExtensionUtil as E;
// phpcs:enable

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function reminderpreview_civicrm_config(&$config) {
  _reminderpreview_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function reminderpreview_civicrm_install() {
  _reminderpreview_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function reminderpreview_civicrm_enable() {
  _reminderpreview_civix_civicrm_enable();
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 */
//function reminderpreview_civicrm_preProcess($formName, &$form) {
//
//}

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 */
//function reminderpreview_civicrm_navigationMenu(&$menu) {
//  _reminderpreview_civix_insert_navigation_menu($menu, 'Mailings', [
//    'label' => E::ts('New subliminal message'),
//    'name' => 'mailing_subliminal_message',
//    'url' => 'civicrm/mailing/subliminal',
//    'permission' => 'access CiviMail',
//    'operator' => 'OR',
//    'separator' => 0,
//  ]);
//  _reminderpreview_civix_navigationMenu($menu);
//}

function reminderpreview_civicrm_links($op, $objectName, $objectId, &$links, &$mask, &$values) {
  if ($op == 'actionSchedule.manage.action' && $objectName == 'ActionSchedule') {
    // Add a link to view the zoom registrants
    $links[] = [
      'name' => ts('Preview Recipient'),
      'title' => ts('Preview Recipient'),
      'class' => 'no-popup',
      'url' => CRM_Utils_System::url('civicrm/admin/scheduleReminders/preview',
        "reset=1&id=" . $objectId),
    ];
  }
}

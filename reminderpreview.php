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
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function reminderpreview_civicrm_xmlMenu(&$files) {
  _reminderpreview_civix_civicrm_xmlMenu($files);
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
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function reminderpreview_civicrm_postInstall() {
  _reminderpreview_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function reminderpreview_civicrm_uninstall() {
  _reminderpreview_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function reminderpreview_civicrm_enable() {
  _reminderpreview_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function reminderpreview_civicrm_disable() {
  _reminderpreview_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function reminderpreview_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _reminderpreview_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function reminderpreview_civicrm_managed(&$entities) {
  _reminderpreview_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Add CiviCase types provided by this extension.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_caseTypes
 */
function reminderpreview_civicrm_caseTypes(&$caseTypes) {
  _reminderpreview_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Add Angular modules provided by this extension.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
function reminderpreview_civicrm_angularModules(&$angularModules) {
  // Auto-add module files from ./ang/*.ang.php
  _reminderpreview_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function reminderpreview_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _reminderpreview_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function reminderpreview_civicrm_entityTypes(&$entityTypes) {
  _reminderpreview_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_themes().
 */
function reminderpreview_civicrm_themes(&$themes) {
  _reminderpreview_civix_civicrm_themes($themes);
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

<?php

use CRM_Reminderpreview_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Reminderpreview_Form_Preview extends CRM_Core_Form {
  /**
   * The id of the reminder.
   *
   * @var int
   */
  public $_id;

  /**
   * Set variables up before form is built.
   *
   * @throws \Exception
   */
  public function preProcess() {
    // mapping id
    $this->_id = CRM_Utils_Request::retrieve('id', 'Positive', $this);
  }

  /**
   * Build the form object.
   *
   * @throws \CRM_Core_Exception
   */
  public function buildQuickForm() {
    $this->add('datepicker', "preview_date", ts('Preview Date'), [],
      FALSE, ['time' => TRUE]);
    $this->add('hidden', "id", $this->_id);
    $this->addButtons([
      [
        'type' => 'submit',
        'name' => E::ts('Preview and Download'),
        'isDefault' => TRUE,
      ],
      [
        'type' => 'cancel',
        'name' => ts('Cancel'),
      ],
    ]);

    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());
    parent::buildQuickForm();
  }

  /**
   * Process the form submission.
   */
  public function postProcess() {
    $values = $this->exportValues();
    if ($values['id']) {
      // Delete entry for same reminder in case it is present.
      $inputQueryParams = [1 => [$values['id'], 'Integer']];
      CRM_Core_DAO::executeQuery("delete from civicrm_action_log_preview where action_schedule_id = %1", $inputQueryParams);
      $scheduleID = $values['id'];
      $preview_date = NULL;
      // replace characters.
      if ($values['preview_date']) {
        $preview_date = str_replace([':', ' ', '-'], '', $values['preview_date']);
      }
      $mappingID = CRM_Core_DAO::getFieldValue('CRM_Core_DAO_ActionSchedule',
        $scheduleID, 'mapping_id');
      // get time.
      $now = $preview_date ?? CRM_Utils_Time::getTime();
      $_REQUEST['action_preview'] = TRUE;
      CRM_Core_BAO_ActionSchedule::buildRecipientContacts((string)$mappingID, $now, $params);
      $this->downloadCSV();
    }
    CRM_Core_Session::singleton()->replaceUserContext(CRM_Utils_System::url('civicrm/admin/scheduleReminders',
      "reset=1"
    ));
  }

  /**
   * Get the fields/elements defined in this form.
   *
   * @return array (string)
   */
  public function getRenderableElementNames() {
    // The _elements list includes some items which should not be
    // auto-rendered in the loop -- such as "qfKey" and "buttons".  These
    // items don't have labels.  We'll identify renderable by filtering on
    // the 'label'.
    $elementNames = [];
    foreach ($this->_elements as $element) {
      /** @var HTML_QuickForm_Element $element */
      $label = $element->getLabel();
      if (!empty($label)) {
        $elementNames[] = $element->getName();
      }
    }

    return $elementNames;
  }

  /**
   * Function to download CSV for preview.
   */
  public function downloadCSV() {
    $inputQueryParams = [1 => [$this->_id, 'Integer']];
    $sql = "SELECT p.contact_id as 'contact_id', c.contact_type, c.display_name, e.email
        FROM civicrm_action_log_preview p
        inner join civicrm_contact c on (c.id = p.contact_id)
        inner JOIN civicrm_email e on (e.contact_id = c.id and e.is_primary = 1)
        where p.action_schedule_id = %1";
    $dao = CRM_Core_DAO::executeQuery($sql, $inputQueryParams);
    $finalReport = [];
    while ($dao->fetch()) {
      $rowData = [];
      $rowData['contact_id'] = $dao->contact_id;
      $rowData['contact_type'] = $dao->contact_type;
      $rowData['display_name'] = $dao->display_name;
      $rowData['email'] = $dao->email;
      $finalReport[] = $rowData;
    }
    if (empty($finalReport)) {
      CRM_Core_Session::setStatus(E::ts('No data available'), 'Error', 'info');
    }
    $fileName = 'Reminder_Preview.csv';
    $columnsHeader = ['Contact ID', 'Contact ype', 'Display Name', 'Email'];
    CRM_Core_Report_Excel::writeCSVFile($fileName, $columnsHeader, $finalReport);
  }

}

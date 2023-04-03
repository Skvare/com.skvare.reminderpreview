# com.skvare.reminderpreview

This Extension provides a preview of scheduled reminders. This prepares the list
of contacts based on preview date and time. Prepared list gets downloaded in
CSV file.

## Requirements

* PHP v7.2+
* CiviCRM 5.45

## Installation (Web UI)

Learn more about installing CiviCRM extensions in the [CiviCRM Sysadmin Guide](https://docs.civicrm.org/sysadmin/en/latest/customize/extensions/).

## Installation (CLI, Zip)

Sysadmins and developers may download the `.zip` file for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
cd <extension-dir>
cv dl com.skvare.reminderpreview@https://github.com/skvare/com.skvare.reminderpreview/archive/master.zip
```

## Installation (CLI, Git)

Sysadmins and developers may clone the [Git](https://en.wikipedia.org/wiki/Git) repo for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
git clone https://github.com/skvare/com.skvare.reminderpreview.git
cv en reminderpreview
```

## Getting Started

* Visit the Reminder list.
* Click on more link, you will see link with name `Preview Recipient`
* Clicking on this link, new form opened.
* You can keep `Preview Date` empty in case you want to use the current date
  and time.
* In case you want to check the Recipient list for tomorrow's date then
  choose the date
accordingly.
* Once you submit the form, the CSV file gets prepared with a contact list.

![Screenshot](/images/preview_link.png)

![Screenshot](/images/preview_form.png)


# Major requirement
We need to apply **patch** in **CiviCRM Core** to prepare the list into separate
table.
New table `civicrm_action_log_preview` is copy of `civicrm_action_log`.

```patch
--- a/Civi/ActionSchedule/RecipientBuilder.php
+++ b/Civi/ActionSchedule/RecipientBuilder.php
@@ -547,9 +547,12 @@ WHERE      $group.id = {$groupId}
if ($this->resetOnTriggerDateChange() && ($phase == self::PHASE_RELATION_FIRST || $phase == self::PHASE_RELATION_REPEAT)) {
$actionLogColumns[] = "reference_date";
}
-
+    $table = 'civicrm_action_log';
+    if (!empty($_REQUEST['action_preview'])) {
+      $table = 'civicrm_action_log_preview';
+    }
     return $this->selectActionLogFields($phase, $query)
-      ->insertInto('civicrm_action_log', $actionLogColumns);
+      ->insertInto($table, $actionLogColumns);
  }
```

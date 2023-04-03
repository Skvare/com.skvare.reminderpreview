<div id="help">
  <p>This is an experiential process.</p>
  <p>You can choose the date for preparing the list, to use current date and time do not fill any detail in the date field.</p>
  <p>This process prepares the list and downloads it through a CSV file.</p>
</div>
{foreach from=$elementNames item=elementName}
  <div class="crm-section">
    <div class="label">{$form.$elementName.label}</div>
    <div class="content">{$form.$elementName.html}</div>
    <div class="clear"></div>
  </div>
{/foreach}
<div class="crm-submit-buttons">
{include file="CRM/common/formButtons.tpl" location="bottom"}
</div>

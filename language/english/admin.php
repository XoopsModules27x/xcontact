<?php
defined('XOOPS_ROOT_PATH') || exit();
if (!defined('_AM_XCFORM_MENU_MAIN')) {
define('_AM_XCFORM_MENU_MAIN',        'Dashboard');
define('_AM_XCFORM_MENU_FORMS',       'Form List');
define('_AM_XCFORM_MENU_NEW_FORM',    'New Form');
define('_AM_XCFORM_MENU_SUBMISSIONS', 'Submissions');
define('_AM_XCFORM_MENU_ABOUT',       'About');
define('_AM_XCFORM_DASHBOARD',        'xcform Dashboard');
define('_AM_XCFORM_STAT_FORMS',       'Total Forms');
define('_AM_XCFORM_STAT_ACTIVE',      'Active Forms');
define('_AM_XCFORM_STAT_SUBS',        'Total Submissions');
define('_AM_XCFORM_STAT_NEW_SUBS',    'New Submissions');
define('_AM_XCFORM_FORM_SAVED',       'Form saved successfully.');
define('_AM_XCFORM_FORM_DELETED',     'Form deleted.');
define('_AM_XCFORM_FORM_NOT_FOUND',   'Form not found.');
define('_AM_XCFORM_FORM_NAME',        'Form Name');
define('_AM_XCFORM_FORM_SLUG',        'Slug (URL)');
define('_AM_XCFORM_FORM_DESC',        'Description');
define('_AM_XCFORM_FORM_ACTIVE',      'Enable Form');
define('_AM_XCFORM_FORM_CAPTCHA',     'Enable CAPTCHA');
define('_AM_XCFORM_SUCCESS_MSG',      'Success Message');
define('_AM_XCFORM_NOTIFY_EMAIL',     'Notification Email');
define('_AM_XCFORM_EMAIL_SUBJECT',    'Email Subject');
define('_AM_XCFORM_SAVE',             'Save');
define('_AM_XCFORM_CANCEL',           'Cancel');
define('_AM_XCFORM_EDIT',             'Edit');
define('_AM_XCFORM_DELETE',           'Delete');
define('_AM_XCFORM_ACTIONS',          'Actions');
define('_AM_XCFORM_SUB_NOT_FOUND',    'Submission not found.');
define('_AM_XCFORM_SUB_DATE',         'Date');
define('_AM_XCFORM_SUB_IP',           'IP Address');
define('_AM_XCFORM_SUB_STATUS',       'Status');
define('_AM_XCFORM_SUB_NEW',          'New');
define('_AM_XCFORM_SUB_READ',         'Read');
define('_AM_XCFORM_SUB_VIEW',         'View');
define('_AM_XCFORM_BACK_TO_LIST',     '← Back to List');
define('_AM_XCFORM_BLOCK_SLUG',       'Select Form:');
define('_AM_XCFORM_SELECT_FORM',      '— Select a Form —');
define('_AM_XCFORM_USAGE_TITLE',      'Template Usage');
define('_AM_XCFORM_USAGE_DESC',       'Link to the form page or use the XOOPS block system.');
} // end if !defined
if (!defined('_AM_XCFORM_BUILDER_FIELD_TYPES')) {
// Form Builder - field type labels
define('_AM_XCFORM_FT_SHORT_TEXT',   'Short Text');
define('_AM_XCFORM_FT_LONG_TEXT',    'Long Text');
define('_AM_XCFORM_FT_EMAIL',        'Email');
define('_AM_XCFORM_FT_WEBSITE',      'Website');
define('_AM_XCFORM_FT_PHONE',        'Phone');
define('_AM_XCFORM_FT_NUMBER',       'Number');
define('_AM_XCFORM_FT_DATE',         'Date');
define('_AM_XCFORM_FT_TIME',         'Time');
define('_AM_XCFORM_FT_FILE',         'File');
define('_AM_XCFORM_FT_HIDDEN',       'Hidden');
define('_AM_XCFORM_FT_LABEL',        'Label');
define('_AM_XCFORM_FT_HEADING',      'Heading');
define('_AM_XCFORM_FT_PARAGRAPH',    'Paragraph');
define('_AM_XCFORM_FT_CHOICE',       'Choice');
define('_AM_XCFORM_FT_IMAGE_CHOICE', 'Image Choice');
define('_AM_XCFORM_FT_DROPDOWN',     'Dropdown');
define('_AM_XCFORM_FT_CONSENT',      'Consent');
define('_AM_XCFORM_FT_SIGNATURE',    'Signature');
// Form Builder - interface labels
define('_AM_XCFORM_BUILDER_FIELD_TYPES',  'Field Types');
define('_AM_XCFORM_BUILDER_DRAG_HINT',    'Drag a field from the left or double-click');
define('_AM_XCFORM_BUILDER_TAB_BUILDER',  'Form Builder');
define('_AM_XCFORM_BUILDER_TAB_SETTINGS', 'Settings');
define('_AM_XCFORM_BUILDER_SAVE_FORM',    'Save Form');
define('_AM_XCFORM_BUILDER_EDIT_TITLE',   'Edit Form:');
define('_AM_XCFORM_BUILDER_NEW_TITLE',    'Create New Form');
define('_AM_XCFORM_BUILDER_ISP_TITLE',    'Field Settings');
define('_AM_XCFORM_BUILDER_CONFIRM_DEL',  'Are you sure you want to delete this field?');
define('_AM_XCFORM_BUILDER_REQUIRED_LBL', 'Required');
define('_AM_XCFORM_ISP_CONTENT',          'Content');
define('_AM_XCFORM_ISP_FIELD_LABEL',      'Field Label');
define('_AM_XCFORM_ISP_FIELD_NAME',       'Field Name (name)');
define('_AM_XCFORM_ISP_PLACEHOLDER',      'Placeholder');
define('_AM_XCFORM_ISP_DEFAULT_VAL',      'Default Value');
define('_AM_XCFORM_ISP_OPTIONS',          'Options (one per line)');
define('_AM_XCFORM_ISP_REQUIRED',         'Required field');
define('_AM_XCFORM_ISP_DESC',             'Description');
define('_AM_XCFORM_ISP_WIDTH',            'Width');
define('_AM_XCFORM_ISP_WIDTH_FULL',       'Full');
define('_AM_XCFORM_ISP_SAVE',             'Save');
define('_AM_XCFORM_ISP_SETTINGS_SUFFIX',  'Settings');
define('_AM_XCFORM_ISP_DEFAULT_OPTION',   'Option 1');
define('_AM_XCFORM_ISP_DEFAULT_OPTION2',  'Option 2');
// Settings tab
define('_AM_XCFORM_SET_FORM_NAME',        'Form Name *');
define('_AM_XCFORM_SET_FORM_SLUG',        'Slug (URL) *');
define('_AM_XCFORM_SET_SLUG_HINT',        'Lowercase letters and hyphens. e.g. contact-form');
define('_AM_XCFORM_SET_DESC',             'Description');
define('_AM_XCFORM_SET_SUCCESS_MSG',      'Success Message');
define('_AM_XCFORM_SET_NOTIFY_EMAIL',     'Notification Email');
define('_AM_XCFORM_SET_EMAIL_HINT',       'Leave blank to disable email notifications.');
define('_AM_XCFORM_SET_EMAIL_SUBJECT',    'Email Subject');
define('_AM_XCFORM_SET_IS_ACTIVE',        'Enable Form');
define('_AM_XCFORM_SET_CAPTCHA',          'Enable CAPTCHA');
define('_AM_XCFORM_SET_DEFAULT_SUCCESS',  'Your form has been submitted successfully. Thank you!');
define('_AM_XCFORM_SET_DEFAULT_SUBJECT',  'New Form Submission');
define('_AM_XCFORM_SET_SLUG_PLACEHOLDER', 'contact-form');
}
if (!defined('_AM_XCFORM_ABOUT_TITLE')) {
// About page
define('_AM_XCFORM_ABOUT_TITLE',      'xcform — Contact Form Builder');
define('_AM_XCFORM_ABOUT_MOD_NAME',   'Module Name');
define('_AM_XCFORM_ABOUT_VERSION',    'Version');
define('_AM_XCFORM_ABOUT_AUTHOR',     'Author');
define('_AM_XCFORM_ABOUT_LICENSE',    'License');
define('_AM_XCFORM_ABOUT_COMPAT',     'Compatibility');
define('_AM_XCFORM_ABOUT_FEATURES',   'Features');
define('_AM_XCFORM_ABOUT_USAGE',      'Usage');
define('_AM_XCFORM_ABOUT_F1',         '18 field types (text, email, phone, file, signature, choice, etc.)');
define('_AM_XCFORM_ABOUT_F2',         'Drag-and-drop form builder');
define('_AM_XCFORM_ABOUT_F3',         'Side-by-side field support (Full / 1/2 / 1/3)');
define('_AM_XCFORM_ABOUT_F4',         'GD-based CAPTCHA');
define('_AM_XCFORM_ABOUT_F5',         'Email notifications');
define('_AM_XCFORM_ABOUT_F6',         'Submission management in admin panel');
define('_AM_XCFORM_ABOUT_F7',         'Honeypot spam protection');
define('_AM_XCFORM_ABOUT_F8',         'XOOPS block system integration');
define('_AM_XCFORM_ABOUT_LINK_USAGE', 'Direct form link:');
define('_AM_XCFORM_ABOUT_BLOCK_USE',  'As a block: <strong>Admin → Blocks → xcform Contact Form Block</strong> → Select form');
// Forms list
define('_AM_XCFORM_FORMS_TITLE',      'Form List');
define('_AM_XCFORM_FORMS_NEW',        'New Form');
define('_AM_XCFORM_FORMS_BLOCK_INFO', 'Add as XOOPS block: <strong>Modules → xcform → Block Management</strong><br>Or direct link:');
define('_AM_XCFORM_FORMS_DELETED',    'Form and all submissions deleted.');
define('_AM_XCFORM_FORMS_COL_NAME',   'Name');
define('_AM_XCFORM_FORMS_COL_SLUG',   'Slug / Usage');
define('_AM_XCFORM_FORMS_COL_FIELDS', 'Fields');
define('_AM_XCFORM_FORMS_COL_SUBS',   'Submissions');
define('_AM_XCFORM_FORMS_COL_STATUS', 'Status');
define('_AM_XCFORM_FORMS_FIELD_COUNT','fields');
define('_AM_XCFORM_FORMS_SUB_COUNT',  'submissions');
define('_AM_XCFORM_FORMS_STATUS_ON',  'Active');
define('_AM_XCFORM_FORMS_STATUS_OFF', 'Inactive');
define('_AM_XCFORM_FORMS_BTN_EDIT',   'Edit');
define('_AM_XCFORM_FORMS_BTN_SUBS',   'Submissions');
define('_AM_XCFORM_FORMS_BTN_DEL',    'Delete');
define('_AM_XCFORM_FORMS_CONFIRM_DEL','Are you sure you want to delete this form and all its submissions?');
define('_AM_XCFORM_FORMS_EMPTY',      'No forms yet.');
define('_AM_XCFORM_FORMS_CREATE_FIRST','Create your first form →');
// Dashboard
define('_AM_XCFORM_DASH_RECENT_FORMS','Recent Forms');
define('_AM_XCFORM_DASH_RECENT_SUBS', 'Recent Submissions');
define('_AM_XCFORM_DASH_COL_AD',      'Name');
define('_AM_XCFORM_DASH_COL_SLUG',    'Slug');
define('_AM_XCFORM_DASH_COL_FORM',    'Form');
define('_AM_XCFORM_DASH_COL_DATE',    'Date');
define('_AM_XCFORM_DASH_NO_FORMS',    'No forms yet.');
define('_AM_XCFORM_DASH_NEW_FORM',    '+ Create New Form');
define('_AM_XCFORM_DASH_NO_SUBS',     'No submissions yet.');
define('_AM_XCFORM_DASH_BTN_FORMS',   'All Forms');
define('_AM_XCFORM_DASH_BTN_VIEW',    'View');
// Submissions
define('_AM_XCFORM_SUBS_TITLE',       'Submissions');
define('_AM_XCFORM_SUBS_BACK',        '← Back to Forms');
define('_AM_XCFORM_SUBS_SELECT',      '— Select a Form —');
define('_AM_XCFORM_SUBS_COL_DATE',    'Date');
define('_AM_XCFORM_SUBS_COL_IP',      'IP');
define('_AM_XCFORM_SUBS_BTN_VIEW',    'View');
define('_AM_XCFORM_SUBS_BTN_DEL',     'Delete');
define('_AM_XCFORM_SUBS_CONFIRM_DEL', 'Are you sure you want to delete this submission?');
define('_AM_XCFORM_SUBS_EMPTY',       'No submissions for this form yet.');
define('_AM_XCFORM_SUB_STATUS_NEW',   'New');
define('_AM_XCFORM_SUB_STATUS_READ',  'Read');
}
if (!defined('_AM_XCFORM_SUB_VIEW_TITLE')) {
define('_AM_XCFORM_SUB_VIEW_TITLE', 'Submission');
define('_AM_XCFORM_SUB_VIEW_BACK',  '← Back to Submissions');
}
if (!defined('_AM_XCFORM_BLOCK_DISPLAY_MODE')) {
define('_AM_XCFORM_BLOCK_DISPLAY_MODE', 'Display Mode');
define('_AM_XCFORM_BLOCK_MODE_LINK',    'Show as link (redirect to form page)');
define('_AM_XCFORM_BLOCK_MODE_EMBED',   'Embed form directly in block');
}

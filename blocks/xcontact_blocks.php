<?php
/**
 * xcontact — Bloklar
 * @package  xcontact
 * @author   Eren Yumak — Aymak (aymak.net) / Goffy (wedega.com)
 */

use Xmf\Request;
use XoopsModules\Xcontact\ {
    Icons,
    Helper,
    Constants
};

if (!defined('XOOPS_ROOT_PATH')) { exit(); }

// ── Contact Form Block — show_func ─────────────────────────────────────────

function xcontact_block_form($options)
{
    \xoops_loadLanguage('admin', 'xcontact');
    \xoops_loadLanguage('main', 'xcontact');
    require_once dirname(__DIR__) . '/include/common.php';

    $helper = Helper::getInstance();
    /** `@var` \XoopsModules\Xcontact\FormsHandler $formsHandler */
    $formsHandler = $helper->getHandler('Forms');
    /** `@var` \XoopsModules\Xcontact\SubmissionsHandler $submissionsHandler */
    $submissionsHandler = $helper->getHandler('Submissions');

    $currentUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http')
        . '://' . htmlspecialchars($_SERVER['HTTP_HOST'], ENT_QUOTES, 'UTF-8')
        . htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES, 'UTF-8');

    $op     = Request::getString('op', 'list', 'POST');

    $slug  = isset($options[0]) ? trim($options[0]) : '';
    $embed = isset($options[1]) ? (int)$options[1]  : 0;

    if ($slug === '' || $slug === 'none') return false;
    $safeSlug = preg_replace('/[^a-z0-9\-]/', '', strtolower($slug));

    $icons = Icons::iconsLoad();
    $GLOBALS['xoopsTpl']->assign('icons',$icons);

    // Get active forms
    $formObj = $formsHandler->getFormBySlug($safeSlug, Constants::FORM_IS_ACTIVE);
    if (false === $formObj) {
        return false;
    }
    $form = $formObj->getValuesForms();

    $formId       = (int)$form['form_id'];
    $formFields   = json_decode($form['fields'] ?? '[]', true) ?: [];
    $formSettings = json_decode($form['settings'] ?? '{}', true) ?: [];
    $formSuccess  = false;
    $formErrors   = [];
    $formData     = [];

    if ('list' == $op) {
        // initialize all fields with default value
        $formData = $formsHandler->initiateFormFields($formFields);
    }

    $block = array(
        'form_url'    => $form['url'],
        'form_desc'   => $form['description'],
        'embed'       => $embed,
        'form_id'     => $formId,
        'success'     => false,
        'errors'      => array(),
        'data'        => array(),
        'fields'      => array(),
        'success_msg' => $formSettings['success_msg'] ?? \_AM_XCONTACT_SET_DEFAULT_SUCCESS,
    );

    // stop here if only url should be shown
    if (!$embed) return $block;

    // ── POST processing ───────────────────────────────────────────────────────────
    $cfFormId = Request::getInt('cf_form_id', 0, 'POST');

    if ('save' == $op && $formId === $cfFormId) {
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $formErrors[]  = \_MD_XCONTACT_TOKEN_ERROR;
        } else {
            $result      = $submissionsHandler->processSubmission($formFields, $formSettings, $form);
            $formSuccess = $result['success'];
            $formErrors  = $result['errors'];
            $formData    = $result['data'];
        }
    }

    $block['form'] = false;
    if (!$formSuccess) {
        // Form Create when first call or after error
        $form = $formObj->getFormUI($currentUrl, $formData);
        $block['form'] = $form->render();
    }

    $block['success'] = $formSuccess;
    $block['errors']  = $formErrors;

    // load js and css
    $GLOBALS['xoTheme']->addScript(\XCONTACT_URL . '/assets/js/xcontact-form.js', ['type' => 'text/javascript']);
    $GLOBALS['xoTheme']->addStylesheet(\XCONTACT_URL . '/assets/css/xcontact-form.css', null);

    return $block;
}

// ── Contact Form Block — edit_func ─────────────────────────────────────────

function xcontact_block_form_edit($options)
{
    \xoops_loadLanguage('admin', 'xcontact');

    $helper = Helper::getInstance();
    /** `@var` \XoopsModules\Xcontact\FormsHandler $formsHandler */
    $formsHandler = $helper->getHandler('Forms');

    $slug  = isset($options[0]) ? trim($options[0]) : '';
    $embed = isset($options[1]) ? (int)$options[1]  : 0;
    if ($slug === 'none') $slug = '';

    // Get active forms
    $crForms = new \CriteriaCompo();
    $crForms->add(new \Criteria('is_active', Constants::FORM_IS_ACTIVE));
    $crForms->setSort('form_id');
    $crForms->setOrder('DESC');
    $formsAll = $formsHandler->getAll($crForms);

    $html  = '<table>';
    $html .= '<tr><td>' . \_AM_XCONTACT_SELECT_FORM . ':</td><td>';
    $html .= '<select name="options[0]">';
    $html .= '<option value="none">' . \_AM_XCONTACT_SELECT_OPT . '</option>';
    if ($formsHandler->getCount($crForms) > 0) {
        foreach (\array_keys($formsAll) as $i) {
            $sel   = ($formsAll[$i]->getVar('slug') === $slug) ? ' selected' : '';
            $html .= '<option value="' . htmlspecialchars($formsAll[$i]->getVar('slug'), ENT_QUOTES) . '"' . $sel . '>'
                . htmlspecialchars($formsAll[$i]->getVar('name'), ENT_QUOTES) . '</option>';
        }
    }
    $html .= '</select></td></tr>';
    $html .= '<tr><td>' . \_AM_XCONTACT_BLOCK_DISPLAY_MODE . ':</td><td>';
    $html .= '<label><input type="radio" name="options[1]" value="0"' . ($embed ? '' : ' checked') . '> ' . \_AM_XCONTACT_BLOCK_MODE_LINK . '</label>&nbsp;';
    $html .= '<label><input type="radio" name="options[1]" value="1"' . ($embed ? ' checked' : '') . '> ' . \_AM_XCONTACT_BLOCK_MODE_EMBED . '</label>';
    $html .= '</td></tr></table>';

    return $html;
}

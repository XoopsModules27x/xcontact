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
    require_once dirname(__DIR__) . '/include/functions.php';

    $helper = Helper::getInstance();
    /** `@var` \XoopsModules\Xcontact\FormsHandler $formsHandler */
    $formsHandler = $helper->getHandler('Forms');
    /** `@var` \XoopsModules\Xcontact\SubmissionsHandler $submissionsHandler */
    $submissionsHandler = $helper->getHandler('Submissions');

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

    $cf_form_id = (int)$form['form_id'];
    $cf_fields  = json_decode($form['fields'] ?? '[]', true) ?: [];
    $cf_settings= json_decode($form['settings'] ?? '{}', true) ?: [];

    $block = array(
        'form_url'    => $form['url'],
        'form_desc'   => $form['description'],
        'embed'       => $embed,
        'form_id'     => $cf_form_id,
        'success'     => false,
        'errors'      => array(),
        'data'        => array(),
        'fields'      => array(),
        'success_msg' => $cf_settings['success_msg'] ?? \_AM_XCONTACT_SET_DEFAULT_SUCCESS,
    );

    if (!$embed) return $block;

    // ── Embed mode: prepare the fields ─────────────────────────────────────────
    $block['xoops_token'] = $GLOBALS['xoopsSecurity']->getTokenHTML();

    // Field type → HTML input type matching
    $inputTypes = array(
        'short_text' => 'text',
        'email'      => 'email',
        'website'    => 'url',
        'phone'      => 'tel',
        'number'     => 'number',
        'date'       => 'date',
        'time'       => 'time',
    );

    // Prepare the fields for the template
    $nonInputFieldTypes = ['label', 'heading', 'paragraph', 'hidden'];
    $preparedFields = array();
    foreach ($cf_fields as $field) {
        $fieldType = $field['type'] ?? '';
        if (in_array($fieldType, $nonInputFieldTypes, true)) {
            continue;
        }
        $f = $field;
        $f['input_type'] = $inputTypes[$fieldType] ?? 'text';
        $preparedFields[] = $f;
    }
    $block['fields'] = $preparedFields;

    // ── POST processing ───────────────────────────────────────────────────────────

    $formId = Request::getInt('cf_form_id', 0, 'POST');
    $hp = Request::getString('cf_hp', '', 'POST');

    if ($formId === $cf_form_id) {
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $errors[] = _MD_XCONTACT_TOKEN_ERROR;
            $block['errors'] = $errors;
        } else {
            if ($hp !== '') {
                // Honeypot match
                $block['success'] = true;
            } else {
                $errors = [];
                $data = [];

                foreach ($cf_fields as $field) {
                    $fieldName = $field['name'] ?? '';
                    $fieldType = $field['type'] ?? '';
                    $req = !empty($field['required']);

                    if (!$fieldName || in_array($fieldType, $nonInputFieldTypes, true)) {
                        continue;
                    }

                    if ($fieldType === 'choice') {
                        $val = Request::getArray($fieldName, [], 'POST');
                        $val = array_filter(
                            array_map(
                                static fn($item) => is_scalar($item) ? trim(strip_tags((string)$item)) : null,
                                $val
                            )
                        );

                        if ($req && empty($val)) {
                            $errors[] = htmlspecialchars($field['label'] ?? $fieldName) . ' ' . _MB_XCONTACT_IS_MANDATORY;
                        }
                    } elseif ($fieldType === 'consent') {
                        $postedConsent = Request::getString($fieldName, '', 'POST');
                        $val = $postedConsent === '1' ? '1' : '0';

                        if ($req && $val !== '1') {
                            $errors[] = htmlspecialchars($field['label'] ?? $fieldName) . ' ' . _MB_XCONTACT_MUST_BE_CHECKED;
                        }
                    } else {
                        $val = trim(Request::getString($fieldName, '', 'POST'));

                        if ($req && $val === '') {
                            $errors[] = htmlspecialchars($field['label'] ?? $fieldName) . ' ' . _MB_XCONTACT_IS_MANDATORY;
                        }

                        if (
                            $val !== ''
                            && $fieldType === 'email'
                            && !filter_var($val, FILTER_VALIDATE_EMAIL)
                        ) {
                            $errors[] = _MB_XCONTACT_ENTER_VALID_MAIL;
                        }
                    }

                    $data[$fieldName] = $val;
                }

                $block['data'] = $data;

                if (empty($errors)) {
                    $submissionsObj = $submissionsHandler->create();

                    $ip = Request::getString('REMOTE_ADDR', '', 'SERVER');

                    $submissionsObj->setVar('form_id', $cf_form_id);
                    $submissionsObj->setVar('data', json_encode($data, JSON_UNESCAPED_UNICODE));
                    $submissionsObj->setVar('ip', $ip);
                    $submissionsObj->setVar('status', Constants::SUBMISSION_NEW);
                    $submissionsObj->setVar('created_at', time());

                    if ($submissionsHandler->insert($submissionsObj)) {
                        if (!empty($cf_settings['notify_email'])) {
                            $body = _AM_XCONTACT_FORM . ': ' . $form['name'] . "\n";
                            $body .= _MD_XCONTACT_SUB_DATE_LABEL . ': ' . date('d.m.Y H:i') . "\n";
                            $body .= 'IP: ' . $ip . "\n";
                            $body .= str_repeat('-', 40) . "\n";

                            foreach ($data as $k => $v) {
                                $lbl = $k;

                                foreach ($cf_fields as $fd) {
                                    if (($fd['name'] ?? '') === $k) {
                                        $lbl = $fd['label'] ?? $k;
                                        break;
                                    }
                                }

                                $body .= $lbl . ': ' . (is_array($v) ? implode(', ', $v) : $v) . "\n";
                            }

                            xcontact_send_mail(
                                $cf_settings['notify_email'],
                                $cf_settings['email_subject'] ?? _MD_XCONTACT_NEW_SUBMISSION,
                                $body
                            );
                        }
                    } else {
                        $errors[] = _MD_XCONTACT_SUBMISSION_ERROR;
                    }

                    if (empty($errors)) {
                        $block['success'] = true;
                    } else {
                        $block['errors'] = $errors;
                    }
                } else {
                    $block['errors'] = $errors;
                }
            }
        }
    }
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
    $html .= '<tr><td>' . \_AM_XCONTACT_BLOCK_SLUG . ':</td><td>';
    $html .= '<select name="options[0]">';
    $html .= '<option value="none">' . \_AM_XCONTACT_SELECT_FORM . '</option>';
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

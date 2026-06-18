<?php
/**
 * xcontact — Bloklar
 * @package  xcontact
 * @author   Eren Yumak — Aymak (aymak.net) / Goffy (wedega.com)
 */

use XoopsModules\Xcontact\ {
    Icons,
    Helper,
    Constants
};

if (!defined('XOOPS_ROOT_PATH')) { exit(); }

// ── İletişim Formu Bloğu — show_func ─────────────────────────────────────────

function xcontact_block_form($options)
{
    \xoops_loadLanguage('admin', 'xcontact');

    $helper = Helper::getInstance();
    $formsHandler = $helper->getHandler('Forms');
    $submissionsHandler = $helper->getHandler('Submissions');

    $slug  = isset($options[0]) ? trim($options[0]) : '';
    $embed = isset($options[1]) ? (int)$options[1]  : 0;

    if ($slug === '' || $slug === 'none') return false;
    $safeSlug = preg_replace('/[^a-z0-9\-]/', '', strtolower($slug));

    $icons = Icons::iconsLoad();
    $GLOBALS['xoopsTpl']->assign('icons',$icons);

    // Get active forms
    $crForms = new \CriteriaCompo();
    $crForms->add(new \Criteria('is_active', Constants::FORM_IS_ACTIVE));
    $crForms->add(new \Criteria('slug', $safeSlug));
    $crForms->setLimit(1);
    $crForms->setSort('form_id');
    $crForms->setOrder('DESC');
    if (0 == $formsHandler->getCount($crForms)) {
        return false;
    }
    $formsAll = $formsHandler->getAll($crForms);
    foreach (\array_keys($formsAll) as $i) {
        $form = $formsAll[$i]->getValuesForms();
        $GLOBALS['xoopsTpl']->append('recent_forms', $form);
    }
    unset($crForms);

    $cf_form_id = (int)$form['form_id'];
    $cf_fields  = json_decode($form['fields'] ?? '[]', true) ?: [];
    $cf_settings= json_decode($form['settings'] ?? '{}', true) ?: [];
    //$url        = XOOPS_URL . '/modules/xcontact/form.php?slug=' . urlencode($safeSlug);

    $block = array(
        'form_url'    => $form['url'],
        'form_desc'   => $form['description'],
        'embed'       => $embed,
        'form_id'     => $cf_form_id,
        'success'     => false,
        'errors'      => array(),
        'data'        => array(),
        'fields'      => array(),
        'token'       => '',
        'success_msg' => $cf_settings['success_msg'] ?? \_AM_XCONTACT_SET_DEFAULT_SUCCESS,
    );

    if (!$embed) return $block;

    // ── Embed modu: alanları hazırla ─────────────────────────────────────────
    $cf_token = md5($cf_form_id . 'xcontact_salt_aymak');
    $block['token'] = $cf_token;

    // Field type → HTML input type eşleştirmesi
    $inputTypes = array(
        'short_text' => 'text',
        'email'      => 'email',
        'website'    => 'url',
        'phone'      => 'tel',
        'number'     => 'number',
        'date'       => 'date',
        'time'       => 'time',
    );

    // Alanları template için hazırla
    $preparedFields = array();
    foreach ($cf_fields as $field) {
        $ft = $field['type'] ?? '';
        if (in_array($ft, ['label', 'paragraph', 'hidden'])) continue;
        $f = $field;
        $f['input_type'] = $inputTypes[$ft] ?? 'text';
        $preparedFields[] = $f;
    }
    $block['fields'] = $preparedFields;

    // ── POST işleme ───────────────────────────────────────────────────────────
    if (
        !empty($_POST) &&
        (int)($_POST['cf_form_id'] ?? 0) === $cf_form_id &&
        !empty($_POST['cf_token']) &&
        $_POST['cf_token'] === $cf_token
    ) {
        if (!empty($_POST['cf_hp'])) {
            $block['success'] = true;
        } else {
            $errors = array();
            $data   = array();
            foreach ($cf_fields as $field) {
                $fn  = $field['name'] ?? '';
                $ft  = $field['type'] ?? '';
                $req = !empty($field['required']);
                if (!$fn || in_array($ft, ['label','heading','paragraph'])) continue;
                if ($ft === 'choice') {
                    $val = isset($_POST[$fn]) ? array_map('strip_tags', (array)$_POST[$fn]) : array();
                    if ($req && empty($val)) $errors[] = htmlspecialchars($field['label']??$fn) . ' ' . \_MB_XCONTACT_IS_MANDATORY;
                } elseif ($ft === 'consent') {
                    $val = isset($_POST[$fn]) ? '1' : '0';
                    if ($req && $val !== '1') $errors[] = htmlspecialchars($field['label']??$fn) . ' ' . \_MB_XCONTACT_MUST_BE_CHECKED;
                } else {
                    $val = strip_tags(trim($_POST[$fn] ?? ''));
                    if ($req && $val === '') $errors[] = htmlspecialchars($field['label']??$fn) . ' ' . \_MB_XCONTACT_IS_MANDATORY;
                    if ($val !== '' && $ft === 'email' && !filter_var($val, FILTER_VALIDATE_EMAIL)) {
                        $errors[] = \_MB_XCONTACT_ENTER_VALID_MAIL;
                    }
                }
                $data[$fn] = $val;
            }
            $block['data'] = $data;

            if (empty($errors)) {
                $submissionsObj = $submissionsHandler->create();
                $submissionsObj->setVar('form_id', $cf_form_id);
                $submissionsObj->setVar('data', json_encode($data, JSON_UNESCAPED_UNICODE));
                $submissionsObj->setVar('ip', $_SERVER['REMOTE_ADDR']);
                $submissionsObj->setVar('status', 0);
                $submissionsObj->setVar('created_at', time());
                // Insert Data
                if ($submissionsHandler->insert($submissionsObj)) {
                    // E-posta bildirimi
                    if (!empty($cf_settings['notify_email'])) {
                        $body  =  \_AM_XCONTACT_FORM . ':' . $form['name'] . "\n" . _MD_XCONTACT_SUB_DATE_LABEL . ': ' . date('d.m.Y H:i') . "\nIP: {$_SERVER['REMOTE_ADDR']}\n" . str_repeat('-', 40) . "\n";
                        foreach ($data as $k => $v) {
                            $lbl = $k;
                            foreach ($cf_fields as $fd) { if (($fd['name'] ?? '') === $k) { $lbl = $fd['label'] ?? $k; break; } }
                            $body .= $lbl . ': ' . (is_array($v) ? implode(', ', $v) : $v) . "\n";
                        }
                        xcontact_send_mail($cf_settings['notify_email'], $cf_settings['email_subject'] ?? _MD_XCONTACT_NEW_SUBMISSION, $body);
                    }
                } else {
                    $errors[] = \_MD_XCONTACT_SUBMISSION_ERROR;
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

    return $block;
}

// ── İletişim Formu Bloğu — edit_func ─────────────────────────────────────────

function xcontact_block_form_edit($options)
{
    \xoops_loadLanguage('admin', 'xcontact');

    $slug  = isset($options[0]) ? trim($options[0]) : '';
    $embed = isset($options[1]) ? (int)$options[1]  : 0;
    if ($slug === 'none') $slug = '';

    $db  = XoopsDatabaseFactory::getDatabaseConnection();
    $tbl = $db->prefix('xcontact_forms');
    $res = $db->query("SELECT form_id, name, slug FROM `{$tbl}` WHERE is_active=1 ORDER BY form_id DESC");

    $html  = '<table>';
    $html .= '<tr><td>' . \_AM_XCONTACT_BLOCK_SLUG . ':</td><td>';
    $html .= '<select name="options[0]">';
    $html .= '<option value="none">' . \_AM_XCONTACT_SELECT_FORM . '</option>';
    if ($res) {
        while ($row = $db->fetchArray($res)) {
            $sel   = ($row['slug'] === $slug) ? ' selected' : '';
            $html .= '<option value="' . htmlspecialchars($row['slug'], ENT_QUOTES) . '"' . $sel . '>'
                   . htmlspecialchars($row['name'], ENT_QUOTES) . '</option>';
        }
    }
    $html .= '</select></td></tr>';
    $html .= '<tr><td>' . \_AM_XCONTACT_BLOCK_DISPLAY_MODE . ':</td><td>';
    $html .= '<label><input type="radio" name="options[1]" value="0"' . ($embed ? '' : ' checked') . '> ' . \_AM_XCONTACT_BLOCK_MODE_LINK . '</label>&nbsp;';
    $html .= '<label><input type="radio" name="options[1]" value="1"' . ($embed ? ' checked' : '') . '> ' . \_AM_XCONTACT_BLOCK_MODE_EMBED . '</label>';
    $html .= '</td></tr></table>';

    return $html;
}

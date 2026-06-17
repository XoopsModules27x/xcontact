<?php
/**
 * xcontact — Bloklar
 * @package  xcontact
 * @author   Eren Yumak — Aymak (aymak.net) / Goffy (wedega.com)
 */

if (!defined('XOOPS_ROOT_PATH')) { exit(); }

// ── İletişim Formu Bloğu — show_func ─────────────────────────────────────────

function xcontact_block_form($options)
{
    $slug  = isset($options[0]) ? trim($options[0]) : '';
    $embed = isset($options[1]) ? (int)$options[1]  : 0;

    if ($slug === '' || $slug === 'none') return false;

    $db  = XoopsDatabaseFactory::getDatabaseConnection();
    $tbl = $db->prefix('xcontact_forms');

    $safe = preg_replace('/[^a-z0-9\-]/', '', strtolower($slug));
    $res  = $db->query("SELECT * FROM `{$tbl}` WHERE slug='" . $db->escape($safe) . "' AND is_active=1 LIMIT 1");
    if (!$res || $db->getRowsNum($res) == 0) return false;

    $form       = $db->fetchArray($res);
    $cf_form_id = (int)$form['form_id'];
    $cf_fields  = json_decode($form['fields'] ?? '[]', true) ?: [];
    $cf_settings= json_decode($form['settings'] ?? '{}', true) ?: [];
    $url        = XOOPS_URL . '/modules/xcontact/form.php?slug=' . urlencode($safe);

    $block = array(
        'form_url'    => $url,
        'form_desc'   => $form['description'],
        'embed'       => $embed,
        'form_id'     => $cf_form_id,
        'success'     => false,
        'errors'      => array(),
        'data'        => array(),
        'fields'      => array(),
        'token'       => '',
        'success_msg' => $cf_settings['success_msg'] ?? 'Formunuz başarıyla gönderildi. Teşekkürler!',
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
                    if ($req && empty($val)) $errors[] = htmlspecialchars($field['label']??$fn) . ' zorunludur.';
                } elseif ($ft === 'consent') {
                    $val = isset($_POST[$fn]) ? '1' : '0';
                    if ($req && $val !== '1') $errors[] = htmlspecialchars($field['label']??$fn) . ' onaylanmalıdır.';
                } else {
                    $val = strip_tags(trim($_POST[$fn] ?? ''));
                    if ($req && $val === '') $errors[] = htmlspecialchars($field['label']??$fn) . ' zorunludur.';
                    if ($val !== '' && $ft === 'email' && !filter_var($val, FILTER_VALIDATE_EMAIL)) {
                        $errors[] = 'Geçerli bir e-posta girin.';
                    }
                }
                $data[$fn] = $val;
            }
            $block['data'] = $data;

            if (empty($errors)) {
                $ts  = $db->prefix('xcontact_submissions');
                $ip  = $db->escape($_SERVER['REMOTE_ADDR'] ?? '');
                $dj  = $db->escape(json_encode($data, JSON_UNESCAPED_UNICODE));
                $now = time();
                $db->queryF("INSERT INTO `{$ts}`(form_id,data,ip,status,created_at) VALUES('{$cf_form_id}','{$dj}','{$ip}','0','{$now}')");
                $block['success'] = true;
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
    $slug  = isset($options[0]) ? trim($options[0]) : '';
    $embed = isset($options[1]) ? (int)$options[1]  : 0;
    if ($slug === 'none') $slug = '';

    $db  = XoopsDatabaseFactory::getDatabaseConnection();
    $tbl = $db->prefix('xcontact_forms');
    $res = $db->query("SELECT form_id, name, slug FROM `{$tbl}` WHERE is_active=1 ORDER BY form_id DESC");

    $html  = '<table>';
    $html .= '<tr><td>Form Seçin:</td><td>';
    $html .= '<select name="options[0]">';
    $html .= '<option value="none">-- Form Seçin --</option>';
    if ($res) {
        while ($row = $db->fetchArray($res)) {
            $sel   = ($row['slug'] === $slug) ? ' selected' : '';
            $html .= '<option value="' . htmlspecialchars($row['slug'], ENT_QUOTES) . '"' . $sel . '>'
                   . htmlspecialchars($row['name'], ENT_QUOTES) . '</option>';
        }
    }
    $html .= '</select></td></tr>';
    $html .= '<tr><td>Gösterim:</td><td>';
    $html .= '<label><input type="radio" name="options[1]" value="0"' . ($embed ? '' : ' checked') . '> Link olarak göster</label>&nbsp;';
    $html .= '<label><input type="radio" name="options[1]" value="1"' . ($embed ? ' checked' : '') . '> Formu göster</label>';
    $html .= '</td></tr></table>';

    return $html;
}

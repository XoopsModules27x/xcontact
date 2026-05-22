<?php
defined('XOOPS_ROOT_PATH') || exit();
if (!defined('_MD_XCFORM_FORM_NOT_FOUND')) {
define('_MD_XCFORM_FORM_NOT_FOUND',    'Form bulunamadı veya devre dışı.');
define('_MD_XCFORM_TOKEN_ERROR',       'Güvenlik doğrulama hatası. Lütfen tekrar deneyin.');
define('_MD_XCFORM_CAPTCHA_ERROR',     'Güvenlik kodu hatalı. Lütfen tekrar deneyin.');
define('_MD_XCFORM_REQUIRED',          'alanı zorunludur.');
define('_MD_XCFORM_MUST_ACCEPT',       'onaylanmalıdır.');
define('_MD_XCFORM_INVALID_EMAIL',     'Geçerli bir e-posta adresi girin.');
define('_MD_XCFORM_MUST_BE_NUMBER',    'sayısal olmalıdır.');
define('_MD_XCFORM_INVALID_EXT',       'izin verilmeyen dosya türü.');
define('_MD_XCFORM_FILE_TOO_BIG',      "dosya 5MB'dan büyük olamaz.");
define('_MD_XCFORM_SUBMIT',            'Gönder');
define('_MD_XCFORM_SENDING',           'Gönderiliyor...');
define('_MD_XCFORM_SECURITY_CODE',     'Güvenlik Kodu');
define('_MD_XCFORM_CODE_HINT',         'Yukarıdaki kodu girin');
define('_MD_XCFORM_SUCCESS',           'Formunuz başarıyla gönderildi. Teşekkürler!');
define('_MD_XCFORM_PLEASE_FIX',        'Lütfen düzeltin:');
define('_MD_XCFORM_SELECT_OPT',        '-- Seçin --');
define('_MD_XCFORM_SIG_CLEAR',         'Temizle');
define('_MD_XCFORM_FILE_HINT',         'Maks. 5MB · jpg,png,pdf,doc,xls,txt,zip');
define('_MD_XCFORM_EMAIL_PLACEHOLDER', 'ornek@email.com');
define('_MD_XCFORM_PHONE_PLACEHOLDER', '05XX XXX XX XX');
define('_MD_XCFORM_NO_FORMS',          'Henüz aktif form yok.');
define('_MD_XCFORM_FILL_FORM',         'Formu Doldurun →');
}
// (Bu sabitler form.php içinde mail için kullanılır)
if (!defined('_MD_XCFORM_SUB_DATE_LABEL')) {
define('_MD_XCFORM_SUB_DATE_LABEL',  'Tarih');
define('_MD_XCFORM_NEW_SUBMISSION',  'Yeni Form Gönderisi');
}

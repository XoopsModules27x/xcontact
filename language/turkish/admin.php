<?php
defined('XOOPS_ROOT_PATH') || exit();
// Çift define engellemek için defined() kontrolü
if (!defined('_AM_XCFORM_MENU_MAIN')) {
define('_AM_XCFORM_MENU_MAIN',        'Ana Sayfa');
define('_AM_XCFORM_MENU_FORMS',       'Form Listesi');
define('_AM_XCFORM_MENU_NEW_FORM',    'Yeni Form');
define('_AM_XCFORM_MENU_SUBMISSIONS', 'Gönderiler');
define('_AM_XCFORM_MENU_ABOUT',       'Hakkında');
define('_AM_XCFORM_DASHBOARD',        'xcform Kontrol Paneli');
define('_AM_XCFORM_STAT_FORMS',       'Toplam Form');
define('_AM_XCFORM_STAT_ACTIVE',      'Aktif Form');
define('_AM_XCFORM_STAT_SUBS',        'Toplam Gönderi');
define('_AM_XCFORM_STAT_NEW_SUBS',    'Yeni Gönderi');
define('_AM_XCFORM_FORM_SAVED',       'Form başarıyla kaydedildi.');
define('_AM_XCFORM_FORM_DELETED',     'Form silindi.');
define('_AM_XCFORM_FORM_NOT_FOUND',   'Form bulunamadı.');
define('_AM_XCFORM_FORM_NAME',        'Form Adı');
define('_AM_XCFORM_FORM_SLUG',        'Slug (URL)');
define('_AM_XCFORM_FORM_DESC',        'Açıklama');
define('_AM_XCFORM_FORM_ACTIVE',      'Formu Aktif Et');
define('_AM_XCFORM_FORM_CAPTCHA',     'CAPTCHA Etkinleştir');
define('_AM_XCFORM_SUCCESS_MSG',      'Başarı Mesajı');
define('_AM_XCFORM_NOTIFY_EMAIL',     'Bildirim E-postası');
define('_AM_XCFORM_EMAIL_SUBJECT',    'E-posta Konusu');
define('_AM_XCFORM_SAVE',             'Kaydet');
define('_AM_XCFORM_CANCEL',           'İptal');
define('_AM_XCFORM_EDIT',             'Düzenle');
define('_AM_XCFORM_DELETE',           'Sil');
define('_AM_XCFORM_ACTIONS',          'İşlemler');
define('_AM_XCFORM_SUB_NOT_FOUND',    'Gönderi bulunamadı.');
define('_AM_XCFORM_SUB_DATE',         'Tarih');
define('_AM_XCFORM_SUB_IP',           'IP Adresi');
define('_AM_XCFORM_SUB_STATUS',       'Durum');
define('_AM_XCFORM_SUB_NEW',          'Yeni');
define('_AM_XCFORM_SUB_READ',         'Okundu');
define('_AM_XCFORM_SUB_VIEW',         'Görüntüle');
define('_AM_XCFORM_BACK_TO_LIST',     '← Listeye Dön');
define('_AM_XCFORM_BLOCK_SLUG',       'Form Seçin:');
define('_AM_XCFORM_SELECT_FORM',      '— Form Seçin —');
define('_AM_XCFORM_USAGE_TITLE',      'Şablonda Kullanım');
define('_AM_XCFORM_USAGE_DESC',       'Form sayfasına link verin veya XOOPS blok sistemi kullanın.');
} // end if !defined
if (!defined('_AM_XCFORM_BUILDER_FIELD_TYPES')) {
// Form Builder - alan türü etiketleri
define('_AM_XCFORM_FT_SHORT_TEXT',   'Kısa Metin');
define('_AM_XCFORM_FT_LONG_TEXT',    'Uzun Metin');
define('_AM_XCFORM_FT_EMAIL',        'E-posta');
define('_AM_XCFORM_FT_WEBSITE',      'Web Sitesi');
define('_AM_XCFORM_FT_PHONE',        'Telefon');
define('_AM_XCFORM_FT_NUMBER',       'Sayı');
define('_AM_XCFORM_FT_DATE',         'Tarih');
define('_AM_XCFORM_FT_TIME',         'Saat');
define('_AM_XCFORM_FT_FILE',         'Dosya');
define('_AM_XCFORM_FT_HIDDEN',       'Gizli');
define('_AM_XCFORM_FT_LABEL',        'Etiket');
define('_AM_XCFORM_FT_HEADING',      'Başlık');
define('_AM_XCFORM_FT_PARAGRAPH',    'Paragraf');
define('_AM_XCFORM_FT_CHOICE',       'Seçim');
define('_AM_XCFORM_FT_IMAGE_CHOICE', 'Resimli Seçim');
define('_AM_XCFORM_FT_DROPDOWN',     'Açılır Menü');
define('_AM_XCFORM_FT_CONSENT',      'Onay');
define('_AM_XCFORM_FT_SIGNATURE',    'İmza');
// Form Builder - arayüz etiketleri
define('_AM_XCFORM_BUILDER_FIELD_TYPES',  'Alan Türleri');
define('_AM_XCFORM_BUILDER_DRAG_HINT',    'Soldan alan sürükleyin veya çift tıklayın');
define('_AM_XCFORM_BUILDER_TAB_BUILDER',  'Form Oluşturucu');
define('_AM_XCFORM_BUILDER_TAB_SETTINGS', 'Ayarlar');
define('_AM_XCFORM_BUILDER_SAVE_FORM',    'Formu Kaydet');
define('_AM_XCFORM_BUILDER_EDIT_TITLE',   'Formu Düzenle:');
define('_AM_XCFORM_BUILDER_NEW_TITLE',    'Yeni Form Oluştur');
define('_AM_XCFORM_BUILDER_ISP_TITLE',    'Alan Ayarları');
define('_AM_XCFORM_BUILDER_CONFIRM_DEL',  'Bu alanı silmek istediğinize emin misiniz?');
define('_AM_XCFORM_BUILDER_REQUIRED_LBL', 'Zorunlu');
define('_AM_XCFORM_ISP_CONTENT',          'İçerik');
define('_AM_XCFORM_ISP_FIELD_LABEL',      'Alan Etiketi');
define('_AM_XCFORM_ISP_FIELD_NAME',       'Alan Adı (name)');
define('_AM_XCFORM_ISP_PLACEHOLDER',      'Placeholder');
define('_AM_XCFORM_ISP_DEFAULT_VAL',      'Varsayılan Değer');
define('_AM_XCFORM_ISP_OPTIONS',          'Seçenekler (her satıra bir)');
define('_AM_XCFORM_ISP_REQUIRED',         'Zorunlu alan');
define('_AM_XCFORM_ISP_DESC',             'Açıklama');
define('_AM_XCFORM_ISP_WIDTH',            'Genişlik');
define('_AM_XCFORM_ISP_WIDTH_FULL',       'Tam');
define('_AM_XCFORM_ISP_SAVE',             'Kaydet');
define('_AM_XCFORM_ISP_SETTINGS_SUFFIX',  'Ayarları');
define('_AM_XCFORM_ISP_DEFAULT_OPTION',   'Seçenek 1');
define('_AM_XCFORM_ISP_DEFAULT_OPTION2',  'Seçenek 2');
// Ayarlar sekmesi
define('_AM_XCFORM_SET_FORM_NAME',        'Form Adı *');
define('_AM_XCFORM_SET_FORM_SLUG',        'Slug (URL) *');
define('_AM_XCFORM_SET_SLUG_HINT',        'Küçük harf, tire. Örn: iletisim-formu');
define('_AM_XCFORM_SET_DESC',             'Açıklama');
define('_AM_XCFORM_SET_SUCCESS_MSG',      'Başarı Mesajı');
define('_AM_XCFORM_SET_NOTIFY_EMAIL',     'Bildirim E-posta');
define('_AM_XCFORM_SET_EMAIL_HINT',       'Boş bırakırsanız e-posta gönderilmez.');
define('_AM_XCFORM_SET_EMAIL_SUBJECT',    'E-posta Konusu');
define('_AM_XCFORM_SET_IS_ACTIVE',        'Formu Aktif Et');
define('_AM_XCFORM_SET_CAPTCHA',          'CAPTCHA Etkinleştir');
define('_AM_XCFORM_SET_DEFAULT_SUCCESS',  'Formunuz başarıyla gönderildi. Teşekkürler!');
define('_AM_XCFORM_SET_DEFAULT_SUBJECT',  'Yeni Form Gönderisi');
define('_AM_XCFORM_SET_SLUG_PLACEHOLDER', 'iletisim-formu');
}
if (!defined('_AM_XCFORM_ABOUT_TITLE')) {
// About sayfası
define('_AM_XCFORM_ABOUT_TITLE',      'xcform — İletişim Formu Oluşturucu');
define('_AM_XCFORM_ABOUT_MOD_NAME',   'Modül Adı');
define('_AM_XCFORM_ABOUT_VERSION',    'Sürüm');
define('_AM_XCFORM_ABOUT_AUTHOR',     'Yazar');
define('_AM_XCFORM_ABOUT_LICENSE',    'Lisans');
define('_AM_XCFORM_ABOUT_COMPAT',     'Uyumluluk');
define('_AM_XCFORM_ABOUT_FEATURES',   'Özellikler');
define('_AM_XCFORM_ABOUT_USAGE',      'Kullanım');
define('_AM_XCFORM_ABOUT_F1',         '18 alan türü (metin, e-posta, telefon, dosya, imza, seçim vb.)');
define('_AM_XCFORM_ABOUT_F2',         'Sürükle-bırak form oluşturucu');
define('_AM_XCFORM_ABOUT_F3',         'Yan yana alan desteği (Tam / 1/2 / 1/3)');
define('_AM_XCFORM_ABOUT_F4',         'GD tabanlı CAPTCHA');
define('_AM_XCFORM_ABOUT_F5',         'E-posta bildirimi');
define('_AM_XCFORM_ABOUT_F6',         'Admin panelinde gönderi yönetimi');
define('_AM_XCFORM_ABOUT_F7',         'Honeypot spam koruması');
define('_AM_XCFORM_ABOUT_F8',         'XOOPS blok sistemi entegrasyonu');
define('_AM_XCFORM_ABOUT_LINK_USAGE', 'Form sayfasına link:');
define('_AM_XCFORM_ABOUT_BLOCK_USE',  'Blok olarak: <strong>Admin → Bloklar → xcform İletişim Formu Bloğu</strong> → Form seçin');
// Forms listesi
define('_AM_XCFORM_FORMS_TITLE',      'Form Listesi');
define('_AM_XCFORM_FORMS_NEW',        'Yeni Form');
define('_AM_XCFORM_FORMS_BLOCK_INFO', 'Formu XOOPS bloğu olarak ekleyin: <strong>Modüller → xcform → Blok Yönetimi</strong><br>Veya doğrudan link:');
define('_AM_XCFORM_FORMS_DELETED',    'Form ve tüm gönderileri silindi.');
define('_AM_XCFORM_FORMS_COL_NAME',   'Ad');
define('_AM_XCFORM_FORMS_COL_SLUG',   'Slug / Kullanım');
define('_AM_XCFORM_FORMS_COL_FIELDS', 'Alan');
define('_AM_XCFORM_FORMS_COL_SUBS',   'Gönderi');
define('_AM_XCFORM_FORMS_COL_STATUS', 'Durum');
define('_AM_XCFORM_FORMS_FIELD_COUNT','alan');
define('_AM_XCFORM_FORMS_SUB_COUNT',  'gönderi');
define('_AM_XCFORM_FORMS_STATUS_ON',  'Aktif');
define('_AM_XCFORM_FORMS_STATUS_OFF', 'Pasif');
define('_AM_XCFORM_FORMS_BTN_EDIT',   'Düzenle');
define('_AM_XCFORM_FORMS_BTN_SUBS',   'Gönderiler');
define('_AM_XCFORM_FORMS_BTN_DEL',    'Sil');
define('_AM_XCFORM_FORMS_CONFIRM_DEL','Formu ve tüm gönderileri silmek istediğinize emin misiniz?');
define('_AM_XCFORM_FORMS_EMPTY',      'Henüz form yok.');
define('_AM_XCFORM_FORMS_CREATE_FIRST','İlk formunuzu oluşturun →');
// Dashboard
define('_AM_XCFORM_DASH_RECENT_FORMS','Son Formlar');
define('_AM_XCFORM_DASH_RECENT_SUBS', 'Son Gönderiler');
define('_AM_XCFORM_DASH_COL_AD',      'Ad');
define('_AM_XCFORM_DASH_COL_SLUG',    'Slug');
define('_AM_XCFORM_DASH_COL_FORM',    'Form');
define('_AM_XCFORM_DASH_COL_DATE',    'Tarih');
define('_AM_XCFORM_DASH_NO_FORMS',    'Henüz form yok.');
define('_AM_XCFORM_DASH_NEW_FORM',    '+ Yeni Form Oluştur');
define('_AM_XCFORM_DASH_NO_SUBS',     'Henüz gönderi yok.');
define('_AM_XCFORM_DASH_BTN_FORMS',   'Tüm Formlar');
define('_AM_XCFORM_DASH_BTN_VIEW',    'Gör');
// Submissions
define('_AM_XCFORM_SUBS_TITLE',       'Gönderiler');
define('_AM_XCFORM_SUBS_BACK',        '← Formlara Dön');
define('_AM_XCFORM_SUBS_SELECT',      '— Form Seçin —');
define('_AM_XCFORM_SUBS_COL_DATE',    'Tarih');
define('_AM_XCFORM_SUBS_COL_IP',      'IP');
define('_AM_XCFORM_SUBS_BTN_VIEW',    'Görüntüle');
define('_AM_XCFORM_SUBS_BTN_DEL',     'Sil');
define('_AM_XCFORM_SUBS_CONFIRM_DEL', 'Silmek istediğinize emin misiniz?');
define('_AM_XCFORM_SUBS_EMPTY',       'Bu form için henüz gönderi yok.');
define('_AM_XCFORM_SUB_STATUS_NEW',   'Yeni');
define('_AM_XCFORM_SUB_STATUS_READ',  'Okundu');
}
if (!defined('_AM_XCFORM_SUB_VIEW_TITLE')) {
define('_AM_XCFORM_SUB_VIEW_TITLE', 'Gönderi');
define('_AM_XCFORM_SUB_VIEW_BACK',  '← Gönderilere Dön');
}
if (!defined('_AM_XCFORM_BLOCK_DISPLAY_MODE')) {
define('_AM_XCFORM_BLOCK_DISPLAY_MODE', 'Gösterim Modu');
define('_AM_XCFORM_BLOCK_MODE_LINK',    'Link olarak göster (forma yönlendir)');
define('_AM_XCFORM_BLOCK_MODE_EMBED',   'Formu doğrudan göster (embed)');
}

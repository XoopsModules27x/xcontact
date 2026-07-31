<?php declare(strict_types=1);
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * xcontact module
 *
 * @copyright       XOOPS Project (https://xoops.org)
 * @license         GNU GPL 2.0 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 * @since           3.23
 * @author          Xoops Development Team
 */
$moduleDirName      = \basename(\dirname(__DIR__, 2));
$moduleDirNameUpper = \mb_strtoupper($moduleDirName);

\define('_CO_XCONTACT_GDLIBSTATUS', 'GD kütüphane desteği: ');
\define('_CO_XCONTACT_GDLIBVERSION', 'GD Kütüphane sürümü: ');
\define('_CO_XCONTACT_GDOFF', "<span style='font-weight: bold;'>Devre Dışı</span> (Küçük resimler kullanılamıyor)");
\define('_CO_XCONTACT_GDON', "<span style='font-weight: bold;'>Etkin</span> (Küçük resimler kullanılabilir)");
\define('_CO_XCONTACT_IMAGEINFO', 'Sunucu durumu');
\define('_CO_XCONTACT_MAXPOSTSIZE', 'İzin verilen maksimum gönderi boyutu (php.ini içindeki post_max_size): ');
\define('_CO_XCONTACT_MAXUPLOADSIZE', 'İzin verilen maksimum yükleme boyutu (php.ini içindeki upload_max_filesize): ');
\define('_CO_XCONTACT_MEMORYLIMIT', 'Bellek sınırı (php.ini içindeki memory_limit): ');
\define('_CO_XCONTACT_METAVERSION', "<span style='font-weight: bold;'>İndirmeler meta sürümü:</span> ");
\define('_CO_XCONTACT_OFF', "<span style='font-weight: bold;'>KAPALI</span>");
\define('_CO_XCONTACT_ON', "<span style='font-weight: bold;'>AÇIK</span>");
\define('_CO_XCONTACT_SERVERPATH', 'XOOPS kök dizinine sunucu yolu: ');
\define('_CO_XCONTACT_SERVERUPLOADSTATUS', 'Sunucu yükleme durumu: ');
\define('_CO_XCONTACT_SPHPINI', "<span style='font-weight: bold;'>PHP ini dosyasından alınan bilgiler:</span>");
\define('_CO_XCONTACT_UPLOADPATHDSC', 'Not: Yükleme yolu, yükleme klasörünüzün tam sunucu yolunu İÇERMELİDİR.');

\define('_CO_XCONTACT_PRINT', "<span style='font-weight: bold;'>Yazdır</span>");
\define('_CO_XCONTACT_PDF', "<span style='font-weight: bold;'>PDF Oluştur</span>");

\define('_CO_XCONTACT_UPGRADEFAILED0', "Güncelleme başarısız - '%s' alanı yeniden adlandırılamadı");
\define('_CO_XCONTACT_UPGRADEFAILED1', "Güncelleme başarısız - yeni alanlar eklenemedi");
\define('_CO_XCONTACT_UPGRADEFAILED2', "Güncelleme başarısız - '%s' tablosu yeniden adlandırılamadı");
\define('_CO_XCONTACT_ERROR_COLUMN', 'Veritabanında sütun oluşturulamadı: %s');
\define('_CO_XCONTACT_ERROR_BAD_XOOPS', 'Bu modül XOOPS %s+ gerektirir (%s yüklü)');
\define('_CO_XCONTACT_ERROR_BAD_PHP', 'Bu modül PHP %s+ gerektirir (%s yüklü)');
\define('_CO_XCONTACT_ERROR_TAG_REMOVAL', 'Tag modülündeki etiketler kaldırılamadı');

\define('_CO_XCONTACT_FOLDERS_DELETED_OK', 'Yükleme klasörleri silindi');

// Error Msgs
\define('_CO_XCONTACT_ERROR_BAD_DEL_PATH', '%s dizini silinemedi');
\define('_CO_XCONTACT_ERROR_BAD_REMOVE', '%s silinemedi');
\define('_CO_XCONTACT_ERROR_NO_PLUGIN', 'Eklenti yüklenemedi');

//Help
\define('_CO_XCONTACT_BACK_2_ADMIN', 'Yönetim paneline geri dön: ');
\define('_CO_XCONTACT_OVERVIEW', 'Genel Bakış');

//help multi-page
\define('_CO_XCONTACT_DISCLAIMER', 'Sorumluluk Reddi');
\define('_CO_XCONTACT_LICENSE', 'Lisans');
\define('_CO_XCONTACT_SUPPORT', 'Destek');

//Sample Data
\define('_CO_XCONTACT_ADD_SAMPLEDATA', 'Örnek Verileri İçe Aktar (mevcut TÜM veriler silinecektir)');
\define('_CO_XCONTACT_SAMPLEDATA_SUCCESS', 'Örnek veriler başarıyla içe aktarıldı');
\define('_CO_XCONTACT_SAVE_SAMPLEDATA', 'Tabloları YAML olarak dışa aktar');
\define('_CO_XCONTACT_SAVE_SAMPLEDATA_SUCCESS', 'Tablolar başarıyla YAML olarak dışa aktarıldı');
\define('_CO_XCONTACT_SAVE_SAMPLEDATA_ERROR', 'HATA: Tabloların YAML dışa aktarımı başarısız oldu');
\define('_CO_XCONTACT_SHOW_SAMPLE_BUTTON', 'Örnek Veri düğmesi gösterilsin mi?');
\define('_CO_XCONTACT_SHOW_SAMPLE_BUTTON_DESC', 'Evet seçilirse, "Örnek Veri Ekle" düğmesi yöneticiye görünür olur. İlk kurulumda varsayılan olarak Evet seçilidir.');
\define('_CO_XCONTACT_EXPORT_SCHEMA', 'Veritabanı şemasını YAML olarak dışa aktar');
\define('_CO_XCONTACT_EXPORT_SCHEMA_SUCCESS', 'Veritabanı şeması başarıyla YAML olarak dışa aktarıldı');
\define('_CO_XCONTACT_EXPORT_SCHEMA_ERROR', 'HATA: Veritabanı şemasının YAML dışa aktarımı başarısız oldu');
\define('_CO_XCONTACT_ADD_SAMPLEDATA_OK', 'Örnek verileri içe aktarmak istediğinizden emin misiniz? (Mevcut TÜM veriler silinecektir)');
\define('_CO_XCONTACT_HIDE_SAMPLEDATA_BUTTONS', 'İçe aktarma düğmelerini gizle');
\define('_CO_XCONTACT_SHOW_SAMPLEDATA_BUTTONS', 'İçe aktarma düğmelerini göster');
\define('_CO_XCONTACT_CONFIRM', 'Onayla');

//letter choice
\define('_CO_XCONTACT_BROWSETOTOPIC', "<span style='font-weight: bold;'>Öğeleri alfabetik olarak görüntüle</span>");
\define('_CO_XCONTACT_OTHER', 'Diğer');
\define('_CO_XCONTACT_ALL', 'Tümü');

// block defines
\define('_CO_XCONTACT_ACCESSRIGHTS', 'Erişim Hakları');
\define('_CO_XCONTACT_ACTION', 'İşlem');
\define('_CO_XCONTACT_ACTIVERIGHTS', 'Aktif Haklar');
\define('_CO_XCONTACT_BADMIN', 'Blok Yönetimi');
\define('_CO_XCONTACT_BLKDESC', 'Açıklama');
\define('_CO_XCONTACT_CBCENTER', 'Orta Merkez');
\define('_CO_XCONTACT_CBLEFT', 'Orta Sol');
\define('_CO_XCONTACT_CBRIGHT', 'Orta Sağ');
\define('_CO_XCONTACT_SBLEFT', 'Sol');
\define('_CO_XCONTACT_SBRIGHT', 'Sağ');
\define('_CO_XCONTACT_SIDE', 'Hizalama');
\define('_CO_XCONTACT_TITLE', 'Başlık');
\define('_CO_XCONTACT_VISIBLE', 'Görünür');
\define('_CO_XCONTACT_VISIBLEIN', 'Şurada Görünür');
\define('_CO_XCONTACT_WEIGHT', 'Sıra');

\define('_CO_XCONTACT_PERMISSIONS', 'İzinler');
\define('_CO_XCONTACT_BLOCKS', 'Blok Yönetimi');
\define('_CO_XCONTACT_BLOCKS_DESC', 'Blok/Grup Yönetimi');

\define('_CO_XCONTACT_BLOCKS_MANAGMENT', 'Yönet');
\define('_CO_XCONTACT_BLOCKS_ADDBLOCK', 'Yeni blok ekle');
\define('_CO_XCONTACT_BLOCKS_EDITBLOCK', 'Blok düzenle');
\define('_CO_XCONTACT_BLOCKS_CLONEBLOCK', 'Blok kopyala');

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

\define('CO_' . $moduleDirNameUpper . '_GDLIBSTATUS', 'GD kütüphane desteği: ');
\define('CO_' . $moduleDirNameUpper . '_GDLIBVERSION', 'GD Kütüphane sürümü: ');
\define('CO_' . $moduleDirNameUpper . '_GDOFF', "<span style='font-weight: bold;'>Devre Dışı</span> (Küçük resimler kullanılamıyor)");
\define('CO_' . $moduleDirNameUpper . '_GDON', "<span style='font-weight: bold;'>Etkin</span> (Küçük resimler kullanılabilir)");
\define('CO_' . $moduleDirNameUpper . '_IMAGEINFO', 'Sunucu durumu');
\define('CO_' . $moduleDirNameUpper . '_MAXPOSTSIZE', 'İzin verilen maksimum gönderi boyutu (php.ini içindeki post_max_size): ');
\define('CO_' . $moduleDirNameUpper . '_MAXUPLOADSIZE', 'İzin verilen maksimum yükleme boyutu (php.ini içindeki upload_max_filesize): ');
\define('CO_' . $moduleDirNameUpper . '_MEMORYLIMIT', 'Bellek sınırı (php.ini içindeki memory_limit): ');
\define('CO_' . $moduleDirNameUpper . '_METAVERSION', "<span style='font-weight: bold;'>İndirmeler meta sürümü:</span> ");
\define('CO_' . $moduleDirNameUpper . '_OFF', "<span style='font-weight: bold;'>KAPALI</span>");
\define('CO_' . $moduleDirNameUpper . '_ON', "<span style='font-weight: bold;'>AÇIK</span>");
\define('CO_' . $moduleDirNameUpper . '_SERVERPATH', 'XOOPS kök dizinine sunucu yolu: ');
\define('CO_' . $moduleDirNameUpper . '_SERVERUPLOADSTATUS', 'Sunucu yükleme durumu: ');
\define('CO_' . $moduleDirNameUpper . '_SPHPINI', "<span style='font-weight: bold;'>PHP ini dosyasından alınan bilgiler:</span>");
\define('CO_' . $moduleDirNameUpper . '_UPLOADPATHDSC', 'Not: Yükleme yolu, yükleme klasörünüzün tam sunucu yolunu İÇERMELİDİR.');

\define('CO_' . $moduleDirNameUpper . '_PRINT', "<span style='font-weight: bold;'>Yazdır</span>");
\define('CO_' . $moduleDirNameUpper . '_PDF', "<span style='font-weight: bold;'>PDF Oluştur</span>");

\define('CO_' . $moduleDirNameUpper . '_UPGRADEFAILED0', "Güncelleme başarısız - '%s' alanı yeniden adlandırılamadı");
\define('CO_' . $moduleDirNameUpper . '_UPGRADEFAILED1', "Güncelleme başarısız - yeni alanlar eklenemedi");
\define('CO_' . $moduleDirNameUpper . '_UPGRADEFAILED2', "Güncelleme başarısız - '%s' tablosu yeniden adlandırılamadı");
\define('CO_' . $moduleDirNameUpper . '_ERROR_COLUMN', 'Veritabanında sütun oluşturulamadı: %s');
\define('CO_' . $moduleDirNameUpper . '_ERROR_BAD_XOOPS', 'Bu modül XOOPS %s+ gerektirir (%s yüklü)');
\define('CO_' . $moduleDirNameUpper . '_ERROR_BAD_PHP', 'Bu modül PHP %s+ gerektirir (%s yüklü)');
\define('CO_' . $moduleDirNameUpper . '_ERROR_TAG_REMOVAL', 'Tag modülündeki etiketler kaldırılamadı');

\define('CO_' . $moduleDirNameUpper . '_FOLDERS_DELETED_OK', 'Yükleme klasörleri silindi');

// Error Msgs
\define('CO_' . $moduleDirNameUpper . '_ERROR_BAD_DEL_PATH', '%s dizini silinemedi');
\define('CO_' . $moduleDirNameUpper . '_ERROR_BAD_REMOVE', '%s silinemedi');
\define('CO_' . $moduleDirNameUpper . '_ERROR_NO_PLUGIN', 'Eklenti yüklenemedi');

//Help
\define('CO_' . $moduleDirNameUpper . '_BACK_2_ADMIN', 'Yönetim paneline geri dön: ');
\define('CO_' . $moduleDirNameUpper . '_OVERVIEW', 'Genel Bakış');

//help multi-page
\define('CO_' . $moduleDirNameUpper . '_DISCLAIMER', 'Sorumluluk Reddi');
\define('CO_' . $moduleDirNameUpper . '_LICENSE', 'Lisans');
\define('CO_' . $moduleDirNameUpper . '_SUPPORT', 'Destek');

//Sample Data
\define('CO_' . $moduleDirNameUpper . '_' . 'ADD_SAMPLEDATA', 'Örnek Verileri İçe Aktar (mevcut TÜM veriler silinecektir)');
\define('CO_' . $moduleDirNameUpper . '_' . 'SAMPLEDATA_SUCCESS', 'Örnek veriler başarıyla içe aktarıldı');
\define('CO_' . $moduleDirNameUpper . '_' . 'SAVE_SAMPLEDATA', 'Tabloları YAML olarak dışa aktar');
\define('CO_' . $moduleDirNameUpper . '_' . 'SAVE_SAMPLEDATA_SUCCESS', 'Tablolar başarıyla YAML olarak dışa aktarıldı');
\define('CO_' . $moduleDirNameUpper . '_' . 'SAVE_SAMPLEDATA_ERROR', 'HATA: Tabloların YAML dışa aktarımı başarısız oldu');
\define('CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON', 'Örnek Veri düğmesi gösterilsin mi?');
\define('CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON_DESC', 'Evet seçilirse, "Örnek Veri Ekle" düğmesi yöneticiye görünür olur. İlk kurulumda varsayılan olarak Evet seçilidir.');
\define('CO_' . $moduleDirNameUpper . '_' . 'EXPORT_SCHEMA', 'Veritabanı şemasını YAML olarak dışa aktar');
\define('CO_' . $moduleDirNameUpper . '_' . 'EXPORT_SCHEMA_SUCCESS', 'Veritabanı şeması başarıyla YAML olarak dışa aktarıldı');
\define('CO_' . $moduleDirNameUpper . '_' . 'EXPORT_SCHEMA_ERROR', 'HATA: Veritabanı şemasının YAML dışa aktarımı başarısız oldu');
\define('CO_' . $moduleDirNameUpper . '_' . 'ADD_SAMPLEDATA_OK', 'Örnek verileri içe aktarmak istediğinizden emin misiniz? (Mevcut TÜM veriler silinecektir)');
\define('CO_' . $moduleDirNameUpper . '_' . 'HIDE_SAMPLEDATA_BUTTONS', 'İçe aktarma düğmelerini gizle');
\define('CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLEDATA_BUTTONS', 'İçe aktarma düğmelerini göster');
\define('CO_' . $moduleDirNameUpper . '_' . 'CONFIRM', 'Onayla');

//letter choice
\define('CO_' . $moduleDirNameUpper . '_' . 'BROWSETOTOPIC', "<span style='font-weight: bold;'>Öğeleri alfabetik olarak görüntüle</span>");
\define('CO_' . $moduleDirNameUpper . '_' . 'OTHER', 'Diğer');
\define('CO_' . $moduleDirNameUpper . '_' . 'ALL', 'Tümü');

// block defines
\define('CO_' . $moduleDirNameUpper . '_' . 'ACCESSRIGHTS', 'Erişim Hakları');
\define('CO_' . $moduleDirNameUpper . '_' . 'ACTION', 'İşlem');
\define('CO_' . $moduleDirNameUpper . '_' . 'ACTIVERIGHTS', 'Aktif Haklar');
\define('CO_' . $moduleDirNameUpper . '_' . 'BADMIN', 'Blok Yönetimi');
\define('CO_' . $moduleDirNameUpper . '_' . 'BLKDESC', 'Açıklama');
\define('CO_' . $moduleDirNameUpper . '_' . 'CBCENTER', 'Orta Merkez');
\define('CO_' . $moduleDirNameUpper . '_' . 'CBLEFT', 'Orta Sol');
\define('CO_' . $moduleDirNameUpper . '_' . 'CBRIGHT', 'Orta Sağ');
\define('CO_' . $moduleDirNameUpper . '_' . 'SBLEFT', 'Sol');
\define('CO_' . $moduleDirNameUpper . '_' . 'SBRIGHT', 'Sağ');
\define('CO_' . $moduleDirNameUpper . '_' . 'SIDE', 'Hizalama');
\define('CO_' . $moduleDirNameUpper . '_' . 'TITLE', 'Başlık');
\define('CO_' . $moduleDirNameUpper . '_' . 'VISIBLE', 'Görünür');
\define('CO_' . $moduleDirNameUpper . '_' . 'VISIBLEIN', 'Şurada Görünür');
\define('CO_' . $moduleDirNameUpper . '_' . 'WEIGHT', 'Sıra');

\define('CO_' . $moduleDirNameUpper . '_' . 'PERMISSIONS', 'İzinler');
\define('CO_' . $moduleDirNameUpper . '_' . 'BLOCKS', 'Blok Yönetimi');
\define('CO_' . $moduleDirNameUpper . '_' . 'BLOCKS_DESC', 'Blok/Grup Yönetimi');

\define('CO_' . $moduleDirNameUpper . '_' . 'BLOCKS_MANAGMENT', 'Yönet');
\define('CO_' . $moduleDirNameUpper . '_' . 'BLOCKS_ADDBLOCK', 'Yeni blok ekle');
\define('CO_' . $moduleDirNameUpper . '_' . 'BLOCKS_EDITBLOCK', 'Blok düzenle');
\define('CO_' . $moduleDirNameUpper . '_' . 'BLOCKS_CLONEBLOCK', 'Blok kopyala');

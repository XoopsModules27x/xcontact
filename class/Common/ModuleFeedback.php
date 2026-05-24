<?php declare(strict_types=1);

namespace XoopsModules\Xcontact\Common;

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * Feedback plugin for xoops modules
 *
 * @copyright      2000-2026 XOOPS Project (https://xoops.org)
 * @license        GNU GPL 2.0 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 * @author         Michael Beck <mambax7@gmail.com>
 * @author         Wedega - Email:<webmaster@wedega.com>
 * @author         Fernando Santos (topet05) <fernando@mastop.com.br>
 */

/**
 * Class Object ModuleFeedback
 */
class ModuleFeedback extends \XoopsObject
{
    public $name    = '';
    public $email   = '';
    public $site    = '';
    public $type    = '';
    public $content = '';
    private ?\XoopsModule $module;
    private ?string $moduleDirname;

    /**
     * Constructor
     */
    public function __construct(?\XoopsModule $module = null, ?string $moduleDirname = null)
    {
        $this->module = $module;
        $this->moduleDirname = null !== $moduleDirname ? basename($moduleDirname) : null;
    }

    /**
     * @static function &getInstance
     *
     */
    public static function getInstance(): self
    {
        static $instance = false;
        if (!$instance) {
            $instance = new self();
        }
        return $instance;
    }

    /**
     * @public function getFormFeedback:
     * provide form for sending a feedback to module author
     * @param bool $action
     */
    public function getFormFeedback($action = false, ?\XoopsModule $module = null): \XoopsThemeForm
    {
        if (false === $action) {
            $action = str_replace(["\r", "\n"], '', (string)($_SERVER['REQUEST_URI'] ?? 'feedback.php'));
        }
        $module = $module ?? $this->module ?? $this->resolveModule();
        if (!$module instanceof \XoopsModule) {
            throw new \RuntimeException('ModuleFeedback requires a consumer module context.');
        }

        $moduleDirName      = (string)$module->getVar('dirname');
        $moduleDirNameUpper = \mb_strtoupper($moduleDirName);
        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm($this->constantValue($moduleDirNameUpper, 'FB_FORM_TITLE', 'Feedback'), 'formfeedback', (string)$action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');

        $recipient = new \XoopsFormText($this->constantValue($moduleDirNameUpper, 'FB_RECIPIENT', 'Recipient'), 'recipient', 50, 255, (string)$module->getInfo('author_mail'));
        $recipient->setExtra('disabled="disabled"');
        $form->addElement($recipient);
        $your_name = new \XoopsFormText($this->constantValue($moduleDirNameUpper, 'FB_NAME', 'Name'), 'your_name', 50, 255, $this->name);
        $your_name->setExtra('placeholder="' . \htmlspecialchars($this->constantValue($moduleDirNameUpper, 'FB_NAME_PLACEHOLER', 'Your name'), \ENT_QUOTES | \ENT_SUBSTITUTE, 'UTF-8') . '"');
        $form->addElement($your_name);
        $your_site = new \XoopsFormText($this->constantValue($moduleDirNameUpper, 'FB_SITE', 'Website'), 'your_site', 50, 255, $this->site);
        $your_site->setExtra('placeholder="' . \htmlspecialchars($this->constantValue($moduleDirNameUpper, 'FB_SITE_PLACEHOLER', 'Your website'), \ENT_QUOTES | \ENT_SUBSTITUTE, 'UTF-8') . '"');
        $form->addElement($your_site);
        $your_mail = new \XoopsFormText($this->constantValue($moduleDirNameUpper, 'FB_MAIL', 'Email'), 'your_mail', 50, 255, $this->email);
        $your_mail->setExtra('placeholder="' . \htmlspecialchars($this->constantValue($moduleDirNameUpper, 'FB_MAIL_PLACEHOLER', 'Your email'), \ENT_QUOTES | \ENT_SUBSTITUTE, 'UTF-8') . '"');
        $form->addElement($your_mail);

        $fbtypeSelect = new \XoopsFormSelect($this->constantValue($moduleDirNameUpper, 'FB_TYPE', 'Type'), 'fb_type', $this->type);
        $fbtypeSelect->addOption('', '');
        foreach (['SUGGESTION' => 'Suggestion', 'BUGS' => 'Bug report', 'TESTIMONIAL' => 'Testimonial', 'FEATURES' => 'Feature request', 'OTHERS' => 'Other'] as $suffix => $fallback) {
            $label = $this->constantValue($moduleDirNameUpper, 'FB_TYPE_' . $suffix, $fallback);
            $fbtypeSelect->addOption($label, $label);
        }
        $form->addElement($fbtypeSelect, true);

        $editorConfigs           = [];
        $editorConfigs['name']   = 'fb_content';
        $editorConfigs['value']  = $this->content;
        $editorConfigs['rows']   = 5;
        $editorConfigs['cols']   = 40;
        $editorConfigs['width']  = '100%';
        $editorConfigs['height'] = '400px';
        /** @var \XoopsModuleHandler $moduleHandler */
        $moduleHandler = \xoops_getHandler('module');
        $systemModule  = $moduleHandler->getByDirname('system');
        /** @var \XoopsConfigHandler $configHandler */
        $configHandler           = \xoops_getHandler('config');
        $config                  = $configHandler->getConfigsByCat(0, $systemModule->getVar('mid'));
        $editorConfigs['editor'] = $config['general_editor'];
        $editor                  = new \XoopsFormEditor($this->constantValue($moduleDirNameUpper, 'FB_TYPE_CONTENT', 'Message'), 'fb_content', $editorConfigs);
        $form->addElement($editor, true);

        $form->addElement(new \XoopsFormHidden('op', 'send'));
        $form->addElement(new \XoopsFormButtonTray('', \_SUBMIT, 'submit', '', false));

        return $form;
    }

    private function resolveModule(): ?\XoopsModule
    {
        if (isset($GLOBALS['xoopsModule']) && $GLOBALS['xoopsModule'] instanceof \XoopsModule) {
            return $GLOBALS['xoopsModule'];
        }

        if (null === $this->moduleDirname || !\class_exists(\XoopsModule::class)) {
            return null;
        }

        $module = \XoopsModule::getByDirname($this->moduleDirname);

        return $module instanceof \XoopsModule ? $module : null;
    }

    private function constantValue(string $moduleDirNameUpper, string $suffix, string $fallback): string
    {
        $constant = '_CO_XCONTACT_' . $suffix;

        return \defined($constant) ? (string)\constant($constant) : $fallback;
    }
}

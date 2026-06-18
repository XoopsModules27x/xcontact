# xContact

A modern and flexible contact and form builder module for XOOPS CMS.

## Overview

xContact is a powerful contact and form management module for XOOPS. It allows administrators to create multiple contact forms, collect submissions, manage requests, and notify responsible users by email.

The module is inspired by the original xmContact module and has been redesigned for current XOOPS versions with improved usability, a visual form builder, submission management, and modern UI support.

---

## Features

### Frontend

* Unlimited contact forms
* Drag & Drop form builder
* Responsive Bootstrap-based templates
* Custom field labels and descriptions
* Required field validation
* Honeypot spam protection
* Email validation
* Success and error messages
* Multiple form types

### Available Field Types

* Short Text
* Long Text
* Email
* Website URL
* Phone Number
* Number
* Date
* Time
* File Upload
* Hidden Field
* Label
* Heading
* Paragraph
* Checkbox Group
* Image Choice
* Dropdown List
* Consent Checkbox (GDPR)
* Signature

### Administration

* Create and manage multiple forms
* Visual Drag & Drop form designer
* Submission management
* Submission status tracking
* Email notifications
* Form activation/deactivation
* Permissions management
* Form preview

### Notifications

* Email notification on new submission
* Configurable recipients
* Custom email subjects
* Submission details included in notification

### Security

* XOOPS Security Token validation
* XMF Request filtering
* Honeypot anti-spam protection
* Input sanitization
* Group permissions

### UI Features

* Font Awesome support
* Glyphicons support
* Unicode/Emoji icon fallback
* Bootstrap-compatible templates
* Mobile-friendly administration

---

## Requirements

### Minimum

| Component       | Version            |
| --------------- | ------------------ |
| XOOPS           | 2.5.11             |
| PHP             | 8.0+               |
| MySQL / MariaDB | Supported by XOOPS |

### Recommended

| Component       | Version |
| --------------- | ------- |
| XOOPS           | 2.7.x   |
| PHP             | 8.2+    |
| Bootstrap Theme | Latest  |

XOOPS is a modular PHP-based CMS with extensive support for modules and permissions management.

---

## Installation

1. Download the latest release.
2. Extract the archive.
3. Upload the directory:

```text
/modules/xcontact
```

4. Login as Administrator.
5. Open:

```text
Administration → Modules
```

6. Install **xContact**.
7. Configure module preferences.
8. Create your first form.

---

## Upgrade

1. Backup your database.
2. Replace module files.
3. Go to:

```text
Administration → Modules
```

4. Update the module.
5. Verify preferences and permissions.

---

## Quick Start

### Create a Form

1. Open:

```text
Modules → xContact → Forms
```

2. Click **Add Form**.
3. Enter:

    * Name
    * Description
    * Notification Email
4. Save.

### Build Fields

1. Open the Form Builder.
2. Drag fields from the toolbox.
3. Configure:

    * Label
    * Name
    * Placeholder
    * Width
    * Required option
4. Save.

### Display the Form

Insert the generated form block or use the provided template.

---

## Form Builder

The visual form builder supports:

### Drag & Drop

* Reorder fields
* Instant preview
* Field settings panel

### Layout Widths

* Full Width (12)
* Half Width (6)
* Third Width (4)

### Field Settings

* Label
* Internal Name
* Placeholder
* Description
* Default Value
* Required
* Width
* Options (for selectable fields)

---

## Submission Management

Every submission is stored in the database.

Stored information:

* Submission Date
* Form ID
* User IP Address
* Status
* Submitted Data

Status examples:

* New
* Read
* Replied
* Closed

---

## Email Notifications

When a form is submitted:

1. Submission is validated.
2. Data is stored.
3. Notification email is generated.
4. Configured recipient receives the message.

Notification includes:

* Form Name
* Submission Date
* IP Address
* Submitted Values

---

## Permissions

xContact uses the native XOOPS permission system.

Available permissions may include:

* View Forms
* Submit Forms
* View Submissions
* Manage Submissions
* Administer Module

---

## Icon System

The module supports multiple icon providers.

### Font Awesome

Recommended default option.

### Glyphicons

Useful for older Bootstrap environments.

### Unicode Icons

No external dependencies required.

Example:

```php
Icons::get('edit');
Icons::get('delete');
Icons::get('save');
```

---

## Developer Notes

### XMF Request

The module uses:

```php
use Xmf\Request;
```

instead of direct access to:

```php
$_GET
$_POST
$_REQUEST
```

for improved security and consistency.

### Namespaces

```php
namespace XoopsModules\Xcontact;
```

### Coding Standards

* PSR-12
* Strict Types
* XMF Components
* XOOPS Coding Guidelines

---

## Folder Structure

```text
xcontact/
├── admin/
├── assets/
├── blocks/
├── class/
├── include/
├── language/
├── templates/
├── uploads/
├── index.php
├── xoops_version.php
└── README.md
```

---

## Roadmap

Planned features:

* File upload management
* CSV export
* PDF export
* Submission search
* Conditional fields
* Multi-step forms
* Webhook support
* REST API integration
* reCAPTCHA support
* Form analytics

---

## Contributing

Contributions are welcome.

### Workflow

1. Fork repository.
2. Create feature branch.
3. Commit changes.
4. Submit Pull Request.

Please follow XOOPS coding standards.

---

## Credits

### Original Inspiration

* xmContact module by the XM Modules team.

### XOOPS Project

XOOPS CMS Community and Contributors.

---

## License

GPL-2.0-or-later

This module is distributed under the GNU General Public License.

---

## Support

### GitHub

Repository:

https://github.com/XoopsModules27x/xcontact

### Issues

Please use GitHub Issues for bug reports and feature requests.

### XOOPS Community

https://xoops.org

---

**xContact — Flexible Contact and Form Management for XOOPS CMS**


# 🛡️ Axcora Security Hunter

**Axcora Security Hunter** is an aesthetic, lightweight, 
and terminal-based security auditor designed specifically for PHP developers. 
It helps you identify critical security gaps and suspicious code patterns before they can be exploited by hackers.

---

## ✨ Key Features

* **🎨 Aesthetic UI:** A modern terminal interface inspired by tools like Astro.js and Vite.
* **📂 Directory Exposure Audit:** Automatically detects sensitive folders (`admin`, `config`, `vendor`, `system`, etc.) that are publicly accessible due to missing `.htaccess`.
* **🔍 Heuristic Code Analysis:** Intelligent scanning for dangerous PHP patterns such as obfuscated backdoors and remote code execution (RCE).
* **💡 Actionable Intelligence:** Every threat found comes with a **Risk Analysis** and **Mitigation Tips** in plain English.
* **🚀 Zero Dependency:** A single PHP file that works out of the box. No database or complex setup required.

---

## 🚀 Getting Started

### 1. Installation
Simply download `axcora-security.php` and place it into your project's root directory.

### 2. Execution
Open your terminal and run the following command:
```bash
php axcora-security.php
```

### 3. Integrate with Composer (Recommended)

Add this to your composer.json to make it a part of your workflow:

```json
"scripts": {
    "axcorasecure": "php axcora-security.php"
}
```

Then just run: `composer axcorasecure`

### 🔍 What it Audits?

Audit Type,Description,Security Risk
Directory Protection,Checks for missing .htaccess in sensitive folders.,Potential 
directory browsing and sensitive data leaks.
Obfuscated Code,Detects eval() or system() combined with base64.,
Hidden backdoors often used by hackers to maintain access.
Input Execution,Finds raw $_GET or $_POST passed to dynamic functions.,
Critical: Allows Remote Command Execution (RCE).
Malicious Redirects,Scans for suspicious window.location JavaScript injectors.,
Phishing or unauthorized traffic redirection (Adware).

### 🔍 Security Audit Details

| Audit Type | Description | Security Risk |
| :--- | :--- | :--- |
| **Directory Protection** | Checks for missing `.htaccess` in sensitive folders. | Potential directory browsing and sensitive data leaks. |
| **Obfuscated Code** | Detects `eval()` or `system()` combined with `base64`. | Hidden backdoors often used by hackers to maintain access. |
| **Input Execution** | Finds raw `$_GET` or `$_POST` passed to dynamic functions. | **Critical:** Allows Remote Command Execution (RCE). |
| **Malicious Redirects** | Scans for suspicious `window.location` JavaScript injectors. | Phishing or unauthorized traffic redirection (Adware). |

### 🛡️ Instant Protection with htaccess.example
To help you secure your directories quickly, we have provided an htaccess.example file. 
If the scanner flags a "warn" on a directory, follow these steps:

+ Locate the htaccess.example file to the flagged folder.
+ Copy it to the flagged directory (e.g., ./system/ or ./vendor/).
+ Rename it to .htaccess.
+ Result: The directory is now locked from public access.

#### This file contains industry-standard rules to:

+ Deny all public access to the folder contents.
+ Disable directory browsing (preventing hackers from seeing your file list).
+ Prevent script execution inside the folder for maximum hardening.


### 📝 Important Note

[!CAUTION] This tool provides indications, not absolute confirmations of malware. 
This tool uses heuristic patterns that may flag legitimate framework files 
(False Positives). Always manually review flagged files, especially within core framework directories.

### 🛠️ Mitigation Guide

+ If the scanner flags a threat, follow these steps:
+ For Warnings: Create an .htaccess file in the flagged directory to restrict public access.
+ For Failures: Compare the flagged file with a clean backup or official repository.
+ For Critical Risks: Sanitize all user inputs and avoid using dynamic execution functions on raw data.

---

### Buy me a coffee ☕️ ❤️  ✌🏻 

[Paypal](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=JVZVXBC4N9DAN) [Gumroad](https://creativitaz.gumroad.com/l/coffee) [Github Sponsor](https://github.com/sponsors/mesinkasir)

---

Built with ❤️ by Axcora Technology

---

## 🌐 Connect with Us

Developed and maintained by **Axcora Technology**. 
We provide innovative solutions for FinTech, Automation, and Web Security.

* **Website:** [https://www.axcora.com](https://www.axcora.com)
* **Axcora Lab:** [https://axcora.my.id](https://axcora.my.id)

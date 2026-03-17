<?php
/**
 * AXCORA SECURITY HUNTER - PRO OPEN SOURCE
 * Aesthetic Terminal Security Scanner with Risk Analysis
 * @author Axcora Technology
 * @version 1.0.4
 */

class AxcoraHunter {
    private $scanned = 0;
    private $threats = 0;
    private $startTime;
    private $basePath;

    public function __construct() {
        $this->startTime = microtime(true);
        $this->basePath = realpath('./');
    }

    private function color($text, $code) {
        return "\033[{$code}m{$text}\033[0m";
    }

    private function getRelativePath($fullPath) {
        return str_replace($this->basePath, '.', $fullPath);
    }

    public function run($dir = './') {
        echo "\n " . $this->color("=== Axcora Zetta Core Security Scanning ===", "1;36") . "\n";
        echo " " . $this->color(str_repeat("-", 65), "90") . "\n";

        $target = realpath($dir);
        if ($target && is_dir($target)) {
            $this->scan($target);
        }

        $time = round(microtime(true) - $this->startTime, 2);
        echo " " . $this->color(str_repeat("-", 65), "90") . "\n";
        echo " " . $this->color("=== Axcora Zetta Core Security Complete / Finish Scanning ===", "1;32") . "\n";
        echo " " . $this->color("  └─", "90") . " Files Scanned : " . $this->color($this->scanned, "1;37") . "\n";
        echo " " . $this->color("  └─", "90") . " Threats Found : " . ($this->threats > 0 ? $this->color($this->threats, "1;31") : $this->color("0", "1;32")) . "\n";
        echo " " . $this->color("  └─", "90") . " Execution Time: " . $this->color($time . "s", "1;33") . "\n\n";
    }

    private function scan($path) {
        $items = @scandir($path);
        if (!$items) return;

        foreach ($items as $item) {
            if ($item == '.' || $item == '..') continue;
            $fullPath = $path . DIRECTORY_SEPARATOR . $item;
            $relativePath = $this->getRelativePath($fullPath);

            if (is_dir($fullPath)) {
                if (in_array($item, ['.git', 'node_modules', 'cache'])) continue;

                $sensitive = ['admin', 'config', 'db', 'vendor', 'system', 'includes', 'uploads'];
                if (in_array(strtolower($item), $sensitive)) {
                    if (!file_exists($fullPath . '/.htaccess')) {
                        echo " " . $this->color("!", "1;33") . " " . $this->color("warn", "33") . " No .htaccess in " . $this->color($relativePath, "1;37") . "\n";
                        echo "    " . $this->color("Risk:", "1;31") . " Potential directory browsing and sensitive data exposure.\n";
                        echo "    " . $this->color("Tips:", "1;32") . " Create an .htaccess file in this directory to restrict access.\n\n";
                        $this->threats++;
                    }
                }
                $this->scan($fullPath);
            } else {
                $this->scanned++;
                $this->auditFile($fullPath, $relativePath);
            }
        }
    }

    private function auditFile($file, $relativePath) {
        if (pathinfo($file, PATHINFO_EXTENSION) !== 'php') return;
        $content = @file_get_contents($file);
        if (!$content) return;

        $rules = [
            '/(eval|shell_exec|system|passthru)\s*\(.*base64_decode/i' => 'Encoded Backdoor',
            '/\$_(GET|POST|REQUEST)\[.*(eval|assert)/i'           => 'Remote Input Exec',
            '/(window|document)\.location\.href\s*=\s*[\'"]http/i' => 'External Redirect'
        ];

        foreach ($rules as $pattern => $label) {
            if (preg_match($pattern, $content)) {
                echo " " . $this->color("×", "1;31") . " " . $this->color("fail", "31") . " " . $this->color($label, "1;37") . " at " . $this->color($relativePath, "90") . "\n";
                
                // Detailed Risk & Tips in English
                $risk = "Allows hackers to execute malicious code or hide backdoors.";
                $tip  = "Review the source code immediately and remove suspicious functions.";

                if ($label == 'External Redirect') {
                    $risk = "May lead users to phishing or malicious websites.";
                    $tip  = "Check if the redirect URL is authorized and secure.";
                }
                if ($label == 'Remote Input Exec') {
                    $risk = "CRITICAL: Direct execution of user-controlled input found.";
                    $tip  = "Sanitize all inputs or use safer alternatives to eval().";
                }

                echo "    " . $this->color("Risk:", "1;31") . " $risk\n";
                echo "    " . $this->color("Tips:", "1;32") . " $tip\n\n";
                $this->threats++;
            }
        }
    }
}

$app = new AxcoraHunter();
$app->run();
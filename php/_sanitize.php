<?php
class HtmlSanitizer
{
    // Allowed HTML tags and their permitted attributes
    private $allowedTags = [
        'p' => ['class', 'style'],
        'b' => [],
        'i' => [],
        'em' => [],
        'strong' => [],
        'a' => ['href', 'title', 'target'],
        'ul' => ['class'],
        'ol' => ['class'],
        'li' => [],
        'br' => [],
        'h1' => ['class'],
        'h2' => ['class'],
        'h3' => ['class'],
        'h4' => ['class']
    ];

    // Attributes that might contain JavaScript
    private $dangerousAttributes = [
        'onclick',
        'ondblclick',
        'onmousedown',
        'onmousemove',
        'onmouseout',
        'onmouseover',
        'onmouseup',
        'onkeydown',
        'onkeypress',
        'onkeyup',
        'onload',
        'onunload',
        'onchange',
        'onsubmit',
        'onreset',
        'onerror',
        'onselect',
        'onblur',
        'onfocus',
        'javascript:',
        'vbscript:',
        'expression',
        'oninput'
    ];

    public function sanitize($content)
    {
        // Convert special characters to HTML entities
        $content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');

        // Restore allowed tags
        foreach ($this->allowedTags as $tag => $attributes) {
            // Opening tags
            $content = preg_replace(
                '/&lt;' . $tag . '(\s[^&>]*)?&gt;/i',
                $this->cleanTag($tag, '$1'),
                $content
            );

            // Closing tags
            $content = preg_replace(
                '/&lt;\/' . $tag . '&gt;/i',
                '</' . $tag . '>',
                $content
            );
        }

        // Remove any remaining < or > that might be part of HTML tags
        $content = preg_replace('/&lt;(?!(\/?' . implode('|\\/?', array_keys($this->allowedTags)) . ')\W)[^&]*&gt;/i', '', $content);

        return $content;
    }

    private function cleanTag($tag, $attributeString)
    {
        if (!isset($this->allowedTags[$tag])) {
            return '';
        }

        // Start building the cleaned tag
        $cleaned = '<' . $tag;

        // If there are no attributes, return the simple tag
        if (empty($attributeString) || trim($attributeString) === '') {
            return $cleaned . '>';
        }

        // Convert HTML entities back for attribute processing
        $attributeString = html_entity_decode(trim($attributeString), ENT_QUOTES, 'UTF-8');

        // Extract attributes and their values
        preg_match_all('/(\w+)\s*=\s*["\']([^"\']*)["\']/', $attributeString, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $attributeName = strtolower($match[1]);
            $attributeValue = $match[2];

            // Check if this attribute is allowed for this tag
            if (!in_array($attributeName, $this->allowedTags[$tag])) {
                continue;
            }

            // Check for dangerous content in attribute values
            $isDangerous = false;
            foreach ($this->dangerousAttributes as $dangerous) {
                if (stripos($attributeValue, $dangerous) !== false) {
                    $isDangerous = true;
                    break;
                }
            }

            if (!$isDangerous) {
                // Special handling for href attributes
                if ($attributeName === 'href') {
                    // Only allow http://, https://, mailto:, and relative paths
                    if (preg_match('/^(https?:\/\/|mailto:|\/|#)/', $attributeValue)) {
                        $cleaned .= ' ' . $attributeName . '="' . htmlspecialchars($attributeValue, ENT_QUOTES, 'UTF-8') . '"';
                    }
                } else {
                    $cleaned .= ' ' . $attributeName . '="' . htmlspecialchars($attributeValue, ENT_QUOTES, 'UTF-8') . '"';
                }
            }
        }

        return $cleaned . '>';
    }

    // Example usage for file uploads (optional)
    public function sanitizeFileName($fileName)
    {
        // Remove any directory components
        $fileName = basename($fileName);

        // Remove special characters and spaces
        $fileName = preg_replace('/[^a-zA-Z0-9._-]/', '', $fileName);

        // Ensure the filename doesn't start with a dot
        $fileName = ltrim($fileName, '.');

        return $fileName;
    }
}

// Example usage:
/*
$sanitizer = new HtmlSanitizer();

// Sanitize HTML content
$dirtyHtml = '<p onclick="alert(1)">Hello <script>alert("xss")</script> <b>World</b>!</p>';
$cleanHtml = $sanitizer->sanitize($dirtyHtml);

// Sanitize file name
$dirtyFileName = '../../../malicious.php.jpg';
$cleanFileName = $sanitizer->sanitizeFileName($dirtyFileName);
*/
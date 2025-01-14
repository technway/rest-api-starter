<?php

if ($argc < 2) {
    echo "Usage: php rename-theme.php '<New Theme Name>'\n";
    exit(1);
}

$newThemeName = trim($argv[1]);

// Generate name variations
$newThemeNameTrimmed = preg_replace('/\s+/', '_', $newThemeName);
$newThemeNameLower = strtolower($newThemeNameTrimmed);
$newThemeNameKebab = strtolower(str_replace('_', '-', $newThemeNameTrimmed));

$starterThemeName = "REST API Starter";
$starterThemeNameUpper = "_REST_API_STARTER_";
$starterThemeNameLower = "rest_api_starter";
$starterThemeNameKebab = "rest-api-starter";

// Define files to update
$filesToUpdate = [
    'functions.php',
    'readme.txt',
    'style.css',
    'README.md',
    'api-tests/api-tests.md',
];

foreach ($filesToUpdate as $file) {
    if (!file_exists($file)) {
        echo "File not found: $file\n";
        continue;
    }

    $content = file_get_contents($file);
    
    // Temporarily replace content between backticks with placeholders
    $backtickBlocks = [];
    $content = preg_replace_callback('/`[^`]*`/', function($matches) use (&$backtickBlocks) {
        $placeholder = '{{BACKTICK_BLOCK_' . count($backtickBlocks) . '}}';
        $backtickBlocks[] = $matches[0];
        return $placeholder;
    }, $content);

    // Replace variations of the starter theme name
    $content = str_replace($starterThemeName, $newThemeName, $content);
    $content = str_replace($starterThemeNameUpper, '_' . strtoupper($newThemeNameTrimmed) . '_', $content);
    $content = str_replace($starterThemeNameLower, $newThemeNameLower, $content);
    $content = str_replace($starterThemeNameKebab, $newThemeNameKebab, $content);

    // Restore backtick blocks
    foreach ($backtickBlocks as $index => $block) {
        $content = str_replace('{{BACKTICK_BLOCK_' . $index . '}}', $block, $content);
    }

    file_put_contents($file, $content);
    echo "Updated: $file\n";
}

echo "Theme successfully renamed to '$newThemeName'.\n";

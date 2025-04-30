<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpWord\TemplateProcessor;

try {
    // Load the template
    $template = new TemplateProcessor(__DIR__ . '/template/SURATKETERANGANDOMISILI.docx');
    
    // Get all variables in the template
    $variables = $template->getVariables();
    
    echo "Placeholder yang ditemukan dalam template:\n";
    foreach ($variables as $variable) {
        echo "- \${$variable}\n";
    }
    
    // Cek apakah file template ada
    if (file_exists(__DIR__ . '/template/SURATKETERANGANDOMISILI.docx')) {
        echo "\nFile template ditemukan di: " . __DIR__ . '/template/SURATKETERANGANDOMISILI.docx';
        echo "\nUkuran file: " . filesize(__DIR__ . '/template/SURATKETERANGANDOMISILI.docx') . " bytes";
    } else {
        echo "\nFile template TIDAK ditemukan!";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} 
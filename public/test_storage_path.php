<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpWord\TemplateProcessor;

try {
    // Test different storage paths
    $paths = [
        __DIR__ . '/test_storage.docx', // Public directory
        __DIR__ . '/../storage/app/public/test_storage.docx', // Storage directory
        __DIR__ . '/../storage/app/public/surat/test_storage.docx', // Surat directory
    ];
    
    foreach ($paths as $index => $path) {
        // Create directory if it doesn't exist
        $dir = dirname($path);
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
            echo "Created directory: $dir\n";
        }
        
        // Create a new TemplateProcessor for each path
        $template = new TemplateProcessor(__DIR__ . '/template/SURATKETERANGANDOMISILI.docx');
        
        // Set values
        $template->setValue('nama', 'Test User');
        $template->setValue('nik', '1234567890123456');
        $template->setValue('tempat_lahir', 'Test City');
        $template->setValue('tanggal_lahir', '01 Januari 1990');
        $template->setValue('jeniskelamin', 'Laki-laki');
        $template->setValue('alamat', 'Test Address');
        $template->setValue('pekerjaan', 'Test Job');
        $template->setValue('agama', 'Islam');
        
        // Try to save the file
        $template->saveAs($path);
        echo "File saved successfully to: $path\n";
        
        // Check if file exists and is readable
        if (file_exists($path)) {
            echo "File exists and is readable. Size: " . filesize($path) . " bytes\n";
        } else {
            echo "File does not exist or is not readable!\n";
        }
        
        echo "-----------------------------------\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
} 
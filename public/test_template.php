<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpWord\TemplateProcessor;

try {
    // Load the template
    $template = new TemplateProcessor(__DIR__ . '/template/SURATKETERANGANDOMISILI.docx');
    
    // Set some test values
    $template->setValue('nama', 'Test User');
    $template->setValue('nik', '1234567890123456');
    $template->setValue('tempat_lahir', 'Test City');
    $template->setValue('tanggal_lahir', '1990-01-01');
    $template->setValue('jeniskelamin', 'Laki-laki');
    $template->setValue('alamat', 'Test Address');
    $template->setValue('pekerjaan', 'Test Job');
    $template->setValue('agama', 'Islam');
    $template->setValue('nomor_surat', '001');
    
    // Save the file
    $template->saveAs(__DIR__ . '/test_template.docx');
    
    echo "Template processed successfully!";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} 
<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpWord\TemplateProcessor;

try {
    // Load the template
    $template = new TemplateProcessor(__DIR__ . '/template/SURATKETERANGANDOMISILI.docx');
    
    // Set values with different date formats
    $template->setValue('nama', 'Test User');
    $template->setValue('nik', '1234567890123456');
    $template->setValue('tempat_lahir', 'Test City');
    $template->setValue('tanggal_lahir', '01 Januari 1990'); // Format Indonesia
    $template->setValue('jeniskelamin', 'Laki-laki');
    $template->setValue('alamat', 'Test Address');
    $template->setValue('pekerjaan', 'Test Job');
    $template->setValue('agama', 'Islam');
    
    // Save the file
    $template->saveAs(__DIR__ . '/test_date_format.docx');
    
    echo "Template dengan format tanggal Indonesia berhasil diproses!\n";
    
    // Coba format tanggal lain
    $template = new TemplateProcessor(__DIR__ . '/template/SURATKETERANGANDOMISILI.docx');
    $template->setValue('nama', 'Test User');
    $template->setValue('nik', '1234567890123456');
    $template->setValue('tempat_lahir', 'Test City');
    $template->setValue('tanggal_lahir', '1 Januari 1990'); // Format Indonesia tanpa leading zero
    $template->setValue('jeniskelamin', 'Laki-laki');
    $template->setValue('alamat', 'Test Address');
    $template->setValue('pekerjaan', 'Test Job');
    $template->setValue('agama', 'Islam');
    
    // Save the file
    $template->saveAs(__DIR__ . '/test_date_format2.docx');
    
    echo "Template dengan format tanggal Indonesia (tanpa leading zero) berhasil diproses!\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} 
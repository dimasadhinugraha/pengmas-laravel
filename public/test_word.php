<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

// Create a new PhpWord object
$phpWord = new PhpWord();

// Add a section
$section = $phpWord->addSection();

// Add a text element
$section->addText('Hello World!');

// Save the file
$objWriter = IOFactory::createWriter($phpWord, 'Word2007');
$objWriter->save(__DIR__ . '/test.docx');

echo "Document created successfully!"; 
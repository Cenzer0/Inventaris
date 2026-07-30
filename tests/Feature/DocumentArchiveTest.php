<?php

namespace Tests\Feature;

use App\Http\Controllers\DocumentArchiveController;
use PHPUnit\Framework\Attributes\Test;

class DocumentArchiveTest extends \PHPUnit\Framework\TestCase
{
    #[Test]
    public function test_extract_metadata_from_pdf_filename(): void
    {
        $controller = new DocumentArchiveController();
        $method = new \ReflectionMethod($controller, 'extractMetadataFromFileName');
        $method->setAccessible(true);

        $metadata = $method->invoke($controller, 'Perda No. 5 Tahun 2026.pdf');

        $this->assertSame('Perda No. 5 Tahun 2026', $metadata['title']);
        $this->assertSame('No. 5', $metadata['document_number']);
        $this->assertSame('perda', $metadata['document_type']);
        $this->assertSame('2026-01-01', $metadata['issued_date']);
    }
}

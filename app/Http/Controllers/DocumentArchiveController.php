<?php

namespace App\Http\Controllers;

use App\Models\DocumentArchive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentArchiveController extends Controller
{
    /**
     * Daftar arsip dokumen dengan pencarian dan filter.
     */
    public function index(Request $request)
    {
        $query = DocumentArchive::with('uploader')->latest();

        // Pencarian berdasarkan judul atau nomor dokumen
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('document_number', 'like', "%{$search}%")
                  ->orWhere('issued_by', 'like', "%{$search}%")
                  ->orWhereYear('issued_date', $search);
            });
        }

        // Filter berdasarkan jenis dokumen
        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('document_type', $request->type);
        }

        $archives = $query->paginate(10)->withQueryString();
        $documentTypes = DocumentArchive::DOCUMENT_TYPES;

        return view('archives.index', compact('archives', 'documentTypes'));
    }

    /**
     * Form tambah dokumen baru.
     */
    public function create()
    {
        $documentTypes = DocumentArchive::DOCUMENT_TYPES;
        return view('archives.create', compact('documentTypes'));
    }

    /**
     * Simpan dokumen baru ke database dan storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|file|mimes:pdf|max:10240', // Maks 10MB
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
        $filePath = $file->storeAs('public/archives', $fileName);

        $metadata = $this->extractMetadataFromPdf(storage_path('app/' . $filePath), $file->getClientOriginalName());

        DocumentArchive::create([
            'document_number' => $metadata['document_number'],
            'title'           => $metadata['title'],
            'document_type'   => $metadata['document_type'],
            'description'     => $metadata['description'],
            'file_path'       => $filePath,
            'file_size'       => $file->getSize(),
            'issued_date'     => $metadata['issued_date'],
            'issued_by'       => $metadata['issued_by'],
            'uploaded_by'     => auth()->id(),
        ]);

        return redirect()->route('archives.index')
            ->with('success', 'Dokumen berhasil diarsipkan.');
    }

    private function extractMetadataFromPdf(string $fullPath, string $originalFileName): array
    {
        // 1. Tipe Data Bawaan / Fallback (dari nama file)
        $fileNameWithoutExtension = pathinfo($originalFileName, PATHINFO_FILENAME);
        $cleanTitle = trim(preg_replace('/\s+/', ' ', str_replace(['_', '-'], ' ', $fileNameWithoutExtension)));
        $titleFallback = $cleanTitle ?: 'Dokumen';
        
        $documentNumber = $titleFallback;
        $documentType = 'lainnya';
        $title = $titleFallback;
        $issuedDate = now()->toDateString();
        
        $text = '';
        try {
            // 2. Coba Parsing PDF
            $parser = new \Smalot\PdfParser\Parser();
            $pdf = $parser->parseFile($fullPath);
            $text = $pdf->getText();
            
            // Batasi teks pencarian di halaman awal saja agar tidak over-process
            $textSnippet = mb_substr($text, 0, 3000); 
            
            // --- CARI NOMOR DOKUMEN ---
            if (preg_match('/Nomor\s*:\s*([^\r\n]+)/i', $textSnippet, $matches)) {
                $documentNumber = trim($matches[1]);
            } elseif (preg_match('/(?:no|nomor)\s*\.?\s*([0-9\/\-\.]+)/i', $textSnippet, $matches)) {
                $documentNumber = 'No. ' . trim($matches[1]);
            } elseif (preg_match('/(?:no|nomor)\s*\.?\s*([0-9\/\-\.]+)/i', $titleFallback, $matches)) {
                $documentNumber = 'No. ' . $matches[1];
            }

            // --- CARI JENIS DOKUMEN ---
            $lowerText = strtolower($textSnippet);
            $lowerTitle = strtolower($titleFallback);
            
            if (str_contains($lowerText, 'peraturan daerah') || str_contains($lowerTitle, 'perda')) {
                $documentType = 'perda';
            } elseif (str_contains($lowerText, 'peraturan bupati') || str_contains($lowerTitle, 'perbup')) {
                $documentType = 'perbup';
            } elseif (str_contains($lowerText, 'surat keputusan') || str_contains($lowerText, 'keputusan bupati') || str_contains($lowerTitle, 'sk')) {
                $documentType = 'sk';
            } elseif (str_contains($lowerText, 'perjanjian kerja sama') || str_contains($lowerText, 'perjanjian') || str_contains($lowerTitle, 'perjanjian')) {
                $documentType = 'surat_perjanjian';
            } elseif (str_contains($lowerText, 'memorandum of understanding') || str_contains($lowerTitle, 'mou')) {
                $documentType = 'mou';
            }

            // --- CARI JUDUL DOKUMEN ---
            // Biasanya judul ada di bawah kata TENTANG
            if (preg_match('/TENTANG\s+([A-Z0-9\s\.\,\-\/\(\)]+)(?:\n\n|\r\n\r\n|DENGAN|MENIMBANG|MEMUTUSKAN)/is', $textSnippet, $matches)) {
                $parsedTitle = trim(preg_replace('/\s+/', ' ', $matches[1]));
                if (strlen($parsedTitle) > 10) {
                    $title = ucwords(strtolower($parsedTitle));
                }
            }

            // --- CARI TANGGAL DITETAPKAN ---
            if (preg_match('/Ditetapkan di[\s\S]{1,100}?pada tanggal\s+([0-9]+)\s+([a-zA-Z]+)\s+([0-9]{4})/i', $textSnippet, $matches)) {
                // Konversi tanggal Indonesia sederhana ke format Y-m-d
                $day = str_pad($matches[1], 2, '0', STR_PAD_LEFT);
                $year = $matches[3];
                $monthStr = strtolower(trim($matches[2]));
                
                $months = [
                    'januari' => '01', 'februari' => '02', 'maret' => '03', 'april' => '04',
                    'mei' => '05', 'juni' => '06', 'juli' => '07', 'agustus' => '08',
                    'september' => '09', 'oktober' => '10', 'november' => '11', 'nopember' => '11', 'desember' => '12'
                ];
                
                $month = $months[$monthStr] ?? '01';
                $issuedDate = "$year-$month-$day";
            } elseif (preg_match('/\b(19|20)\d{2}\b/', $titleFallback, $yearMatches)) {
                $issuedDate = $yearMatches[0] . '-01-01';
            }

        } catch (\Exception $e) {
            // Jika PDF gagal dibaca (misal di-enkripsi atau murni gambar/scan tanpa text layer)
            // Biarkan menggunakan nilai fallback.
            \Illuminate\Support\Facades\Log::warning("PDF Parsing failed for {$originalFileName}: " . $e->getMessage());
        }

        // Limit panjang judul untuk amannya
        $title = mb_substr($title, 0, 250);

        return [
            'document_number' => $documentNumber,
            'title' => $title,
            'document_type' => $documentType,
            'description' => 'Diunggah dan dibaca secara otomatis dari isi teks PDF.',
            'issued_date' => $issuedDate,
            'issued_by' => null,
        ];
    }

    /**
     * Tampilkan detail dokumen.
     */
    public function show(DocumentArchive $archive)
    {
        $archive->load('uploader');
        return view('archives.show', compact('archive'));
    }

    /**
     * Form edit dokumen.
     */
    public function edit(DocumentArchive $archive)
    {
        $documentTypes = DocumentArchive::DOCUMENT_TYPES;
        return view('archives.edit', compact('archive', 'documentTypes'));
    }

    /**
     * Update data dokumen (dan file PDF jika diubah).
     */
    public function update(Request $request, DocumentArchive $archive)
    {
        $validated = $request->validate([
            'document_number' => 'required|string|max:255',
            'title'           => 'required|string|max:255',
            'document_type'   => 'required|in:' . implode(',', array_keys(DocumentArchive::DOCUMENT_TYPES)),
            'description'     => 'nullable|string',
            'file'            => 'nullable|file|mimes:pdf|max:10240', // Opsional saat update
            'issued_date'     => 'required|date',
            'issued_by'       => 'nullable|string|max:255',
        ]);

        $data = [
            'document_number' => $validated['document_number'],
            'title'           => $validated['title'],
            'document_type'   => $validated['document_type'],
            'description'     => $validated['description'] ?? null,
            'issued_date'     => $validated['issued_date'],
            'issued_by'       => $validated['issued_by'] ?? null,
        ];

        // Jika ada file baru, hapus file lama dan upload yang baru
        if ($request->hasFile('file')) {
            // Hapus file lama
            if ($archive->file_path && Storage::exists($archive->file_path)) {
                Storage::delete($archive->file_path);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
            $filePath = $file->storeAs('public/archives', $fileName);

            $data['file_path'] = $filePath;
            $data['file_size'] = $file->getSize();
        }

        $archive->update($data);

        return redirect()->route('archives.index')
            ->with('success', 'Dokumen berhasil diperbarui.');
    }

    /**
     * Hapus dokumen dan file PDF-nya.
     */
    public function destroy(DocumentArchive $archive)
    {
        // Hapus file PDF dari storage
        if ($archive->file_path && Storage::exists($archive->file_path)) {
            Storage::delete($archive->file_path);
        }

        $archive->delete();

        return redirect()->route('archives.index')
            ->with('success', 'Dokumen berhasil dihapus.');
    }

    /**
     * Download file PDF.
     */
    public function download(DocumentArchive $archive)
    {
        if (!Storage::exists($archive->file_path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        $fileName = $archive->document_number . ' - ' . $archive->title . '.pdf';
        // Bersihkan karakter yang tidak valid untuk nama file
        $fileName = preg_replace('/[\/\\\\:*?"<>|]/', '_', $fileName);

        return Storage::download($archive->file_path, $fileName);
    }

    /**
     * Preview/tampilkan file PDF di browser.
     */
    public function preview(DocumentArchive $archive)
    {
        if (!Storage::exists($archive->file_path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        return response()->file(storage_path('app/' . $archive->file_path), [
            'Content-Type' => 'application/pdf',
        ]);
    }
}

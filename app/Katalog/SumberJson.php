<?php

namespace App\Katalog;

use RuntimeException;

/** Katalog dari file JSON hasil database/data/export-katalog.sql. */
final class SumberJson implements SumberKatalog
{
    public function __construct(private readonly string $path) {}

    public function baris(): array
    {
        if (! is_file($this->path)) {
            throw new RuntimeException("File katalog tidak ditemukan: {$this->path}");
        }
        $data = json_decode((string) file_get_contents($this->path), true, flags: JSON_THROW_ON_ERROR);

        return array_values($data['kue'] ?? []);
    }
}

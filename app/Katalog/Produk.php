<?php

namespace App\Katalog;

/**
 * Satu produk di website. Untuk kue kering: satu rasa, dengan kemasan sebagai varian.
 *
 * @property-read list<array{id:string, nama:string, harga:?int, kue_id:int}> $varian
 * @property-read list<array{src:?string, alt:string, label:string}> $foto
 */
final class Produk
{
    /**
     * @param  list<array{id:string, nama:string, harga:?int, kue_id:int}>  $varian
     * @param  list<string>  $alergen  gluten|telur|susu|kacang
     * @param  list<array{src:?string, alt:string, label:string}>  $foto
     * @param  list<string>  $musim  lebaran|natal|imlek
     */
    public function __construct(
        public readonly string $slug,
        public readonly string $nama,
        public readonly string $kategori,
        public readonly string $labelVarian,
        public readonly array $varian,
        public readonly string $ringkas,
        public readonly string $deskripsi,
        public readonly ?string $komposisi,
        public readonly array $alergen,
        public readonly bool $best,
        public readonly bool $tampil,
        public readonly int $peringkat,
        public readonly array $foto,
        public readonly array $musim,
        public readonly ?string $merek = null,
    ) {}

    public function hargaMulai(): ?int
    {
        $h = $this->hargaValid();

        return $h ? min($h) : null;
    }

    public function hargaTertinggi(): ?int
    {
        $h = $this->hargaValid();

        return $h ? max($h) : null;
    }

    /** "mulai Rp 30.000", "Rp 65.000", atau "Tanya harga" */
    public function labelHarga(): string
    {
        $mulai = $this->hargaMulai();
        if ($mulai === null) {
            return 'Tanya harga';
        }

        return count($this->varian) > 1 && $this->hargaTertinggi() !== $mulai
            ? 'mulai '.rupiah($mulai)
            : rupiah($mulai);
    }

    public function url(): string
    {
        return route('produk.show', $this->slug);
    }

    /** Jenis ilustrasi placeholder foto. */
    public function jenisFoto(): string
    {
        return match ($this->kategori) {
            'hampers' => 'hampers',
            'cake' => 'cake',
            'snack' => 'kue',
            default => 'toples',
        };
    }

    /** @return list<int> */
    private function hargaValid(): array
    {
        return array_values(array_filter(array_column($this->varian, 'harga'), fn ($h) => $h !== null && $h > 0));
    }
}

-- Ekspor katalog publik dari database admin Teratai (MariaDB 10.5+).
-- Hanya kolom yang aman untuk publik: TIDAK ada harga_reseller, stok, pelanggan, atau transaksi.
-- Pakai:  mariadb -N -r u5653668_teratai < scripts/export-katalog.sql > src/data/katalog-db.json
-- lalu:   node scripts/rapikan-ekspor.mjs src/data/katalog-db.json
SELECT JSON_OBJECT(
  'diekspor', DATE_FORMAT(NOW(), '%Y-%m-%d'),
  'kue', (
    SELECT JSON_ARRAYAGG(JSON_OBJECT(
      'id', k.id,
      'nama', TRIM(k.nama),
      'kemasan', kt.nama,
      'harga', k.harga,
      'deskripsi', k.deskripsi,
      'komposisi', k.komposisi,
      'best', k.best,
      'tampil', k.tampil,
      'gambar', (SELECT JSON_ARRAYAGG(CONCAT(g.id, '.', g.ext)) FROM gambar g WHERE g.kue_id = k.id),
      'varian', (SELECT JSON_ARRAYAGG(JSON_OBJECT('nama', v.nama_varian, 'harga', v.harga)) FROM kue_varian v WHERE v.kue_id = k.id),
      'terjual', (SELECT IFNULL(SUM(n.jumlah),0) FROM nota_has_kue n WHERE n.kue_id = k.id)
               + (SELECT IFNULL(SUM(t.jumlah),0) FROM t_notas_has_kue t WHERE t.kue_id = k.id)
    ))
    FROM kue k JOIN kategori kt ON kt.id = k.kategori_id
    WHERE k.deleted_at IS NULL AND k.harga > 0
      AND kt.nama NOT IN ('Minuman','Hiasan','Toping','Mie Ayam')
  )
);

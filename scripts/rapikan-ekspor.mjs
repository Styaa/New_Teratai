// Merapikan hasil ekspor SQL (satu baris JSON) menjadi JSON terformat agar mudah di-review di git.
import { readFileSync, writeFileSync } from 'node:fs';
const file = process.argv[2];
const data = JSON.parse(readFileSync(file, 'utf8'));
for (const k of data.kue) {
  if ('harga_reseller' in k) delete k.harga_reseller; // pengaman: jangan pernah publikasikan harga reseller
}
writeFileSync(file, JSON.stringify(data, null, 1) + '\n');
console.log(`Katalog: ${data.kue.length} baris ditulis ke ${file}`);

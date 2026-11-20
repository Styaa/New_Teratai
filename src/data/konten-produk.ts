/**
 * Teks website per produk (kunci = slug). Menggantikan deskripsi dari admin bila ada.
 * Produk tanpa entri di sini memakai deskripsi dari database admin.
 * `ringkas` dipakai di kartu produk dan meta description.
 */
export const KONTEN_PRODUK: Record<string, { ringkas: string; deskripsi?: string }> = {
  'nastar': {
    ringkas: 'Kulit lembut yang lumer, isi selai nanas asam-manis.',
    deskripsi:
      'Nastar adalah kue yang selalu dicari setiap hari raya. Kulitnya lembut dan gurih dengan taburan keju, lalu isi selai nanasnya terasa asam-manis dan lumer di mulut. Cocok untuk sajian tamu maupun hantaran.',
  },
  'nastar-daun': {
    ringkas: 'Nastar berbentuk daun dengan isi selai nanas.',
    deskripsi:
      'Rasa nastar yang sama, dibentuk seperti daun sehingga tampil cantik di meja tamu. Isi selai nanasnya manis segar, kulitnya lembut dan gurih.',
  },
  'kastengel': {
    ringkas: 'Gurih dan asin dari keju, renyah di setiap gigitan.',
    deskripsi:
      'Kastengel kami gurih dan sedikit asin berkat campuran kejunya, dengan tekstur renyah yang pas. Hadir di setiap Lebaran, Natal, dan Imlek.',
  },
  'keju': {
    ringkas: 'Kue keju renyah dengan rasa gurih yang ringan.',
    deskripsi: 'Kue keju dengan tekstur renyah dan rasa gurih yang tidak berlebihan. Enak dinikmati bersama teh atau minuman segar.',
  },
  'keju-coklat': {
    ringkas: 'Gurih keju bertemu manis cokelat.',
    deskripsi:
      'Perpaduan gurihnya keju dan manisnya cokelat dalam satu kue. Teksturnya renyah dengan irisan keju, cocok untuk pencinta rasa keju-cokelat.',
  },
  'coklat-chip': {
    ringkas: 'Cookies renyah dengan butiran cokelat di dalamnya.',
    deskripsi:
      'Cookies cokelat chip yang renyah, dengan butiran cokelat di setiap gigitan. Teman yang pas untuk teh atau susu di sore hari.',
  },
  'coklat-mente': {
    ringkas: 'Cokelat renyah dengan potongan kacang mete.',
    deskripsi: 'Kue cokelat renyah dengan potongan mete yang gurih. Manis dan gurihnya seimbang.',
  },
  'coklat-cornflake': {
    ringkas: 'Cokelat manis dengan taburan cornflake yang renyah.',
    deskripsi:
      'Sering disebut kue komplek. Kue cokelat ini diberi taburan cornflake sehingga renyah dan manis, enak untuk camilan santai.',
  },
  'mente': {
    ringkas: 'Renyah dengan rasa gurih kacang mete.',
    deskripsi: 'Kue mete dengan tekstur renyah dan rasa gurih yang khas. Pendamping teh atau kopi saat santai bersama keluarga.',
  },
  'mente-keju': {
    ringkas: 'Gurih mete berpadu keju.',
    deskripsi: 'Kue mete yang renyah dengan tambahan keju, rasanya gurih berlapis.',
  },
  'belinjo': {
    ringkas: 'Gurih dan crispy dari emping belinjo.',
    deskripsi: 'Kue belinjo dengan tekstur lembut namun tetap crispy. Rasa gurihnya unik dan banyak dicari.',
  },
  'belinjo-keju': {
    ringkas: 'Kue belinjo dengan tambahan keju.',
    deskripsi: 'Kue belinjo yang gurih dan crispy, dipadukan dengan keju untuk rasa yang lebih kaya.',
  },
  'kacang': {
    ringkas: 'Renyah di luar, lembut di dalam, manis-gurih.',
    deskripsi:
      'Kue kacang klasik dengan rasa manis dan gurih. Renyah di luar, lembut di dalam, sajian yang tidak pernah salah untuk acara keluarga.',
  },
  'kacang-coklat': {
    ringkas: 'Kue kacang dengan lapisan cokelat.',
    deskripsi: 'Kue kacang yang renyah di luar dan lembut di dalam, ditambah manis cokelat yang lumer.',
  },
  'bangket-kacang': {
    ringkas: 'Kue bangkit lembut dengan topping kacang.',
    deskripsi: 'Kue bangket (bangkit) yang lembut dan meleleh di mulut, dengan topping kacang yang gurih. Favorit saat Lebaran.',
  },
  'bangket-mente': {
    ringkas: 'Kue bangkit lembut dengan topping mete.',
    deskripsi: 'Kue bangket (bangkit) yang lembut dan meleleh di mulut, dengan topping kacang mete yang gurih.',
  },
  'salju': {
    ringkas: 'Lumer di mulut dengan balutan gula halus.',
    deskripsi: 'Kue putri salju yang lembut dan lumer, dibalut gula halus yang terasa dingin di lidah.',
  },
  'sagu': {
    ringkas: 'Kue sagu ringan yang langsung lumer.',
    deskripsi: 'Kue sagu dengan tekstur ringan dan rapuh yang langsung lumer di mulut.',
  },
  'sagu-keju': {
    ringkas: 'Kue sagu lumer dengan rasa keju.',
  },
  'blueberry-keju': {
    ringkas: 'Kue keju dengan selai blueberry.',
    deskripsi: 'Kue keju yang gurih dengan isian selai blueberry yang manis-asam.',
  },
  'stick-coklat': {
    ringkas: 'Stik cokelat renyah, mudah dinikmati.',
    deskripsi: 'Kue stik cokelat yang renyah dan praktis dinikmati kapan saja.',
  },
  'kopi': {
    ringkas: 'Aroma kopi dengan taburan mete.',
    deskripsi: 'Kue rasa kopi dengan pecahan mete di atasnya. Aromanya hangat seperti suasana kafe di rumah.',
  },
  'kopi-cornflake': {
    ringkas: 'Rasa kopi dengan taburan cornflake.',
  },
  'selai-3-rasa': {
    ringkas: 'Tiga selai: nanas, blueberry, dan stroberi.',
    deskripsi:
      'Kue gurih dengan tiga pilihan selai sekaligus: nanas, blueberry, dan stroberi. Satu kemasan, tiga rasa favorit.',
  },
  'tosca': {
    ringkas: 'Kue khas Manado bertopping cokelat dan kenari.',
    deskripsi:
      'Kue kering khas Manado yang biasa hadir saat Natal. Renyah, diberi topping cokelat, glasur gula, dan butiran kenari.',
  },
  'toples-3-rasa': {
    ringkas: 'Tiga rasa kue kering dalam satu toples.',
    deskripsi: 'Satu toples berisi tiga rasa kue kering. Pilihan praktis untuk sajian tamu atau hadiah. [perlu konfirmasi: rasa apa saja isinya]',
  },
  'spekulas-kenari': {
    ringkas: 'Kue rempah spekulas dengan kenari.',
  },
  'durian': {
    ringkas: 'Kue kering dengan aroma durian.',
  },
  'hampers-sedang': {
    ringkas: 'Hampers isi 3 toples kue kering.',
    deskripsi: 'Hampers isi 3 toples kue kering pilihan. Isi bisa disesuaikan, tanyakan rasa yang tersedia lewat WhatsApp.',
  },
  'chiffon-cake-20-cm': {
    ringkas: 'Chiffon lembut 20 cm: keju, coklat, atau pandan.',
    deskripsi: 'Chiffon cake ukuran 20 cm yang ringan dan lembut. Pilih rasa keju, coklat, atau pandan.',
  },
  'keju-gonrong-30-cm': {
    ringkas: 'Cake keju besar 30 cm untuk acara.',
  },
  'jalangkote': {
    ringkas: 'Jalangkote khas Makassar dari Jalangkote Lasinrang.',
  },
  'lumpia': {
    ringkas: 'Lumpia dari Jalangkote Lasinrang.',
  },
};

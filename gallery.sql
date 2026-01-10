-- Struktur tabel untuk gallery
CREATE TABLE IF NOT EXISTS `gallery` (
  `id_gallery` int(11) NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `tanggal_upload` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_gallery`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert data sample untuk testing
INSERT INTO `gallery` (`judul`, `deskripsi`, `gambar`, `tanggal_upload`) VALUES
('Kegiatan pagi', 'Dokumentasi Aktivitas pagi hari', 'pagi.jpg', NOW()),
('Belajar coding', 'Belajar Pemograman PHP', 'coding.jpg', NOW()),
('Rapat tim', 'Diskusi Proyek Harian', 'rapat.jpg', NOW()),
('Makan siang', 'Istirahat dan Makan Siang', 'makan.jpg', NOW()),
('Olahgara sore', 'Jooging Sore untuk Kesehatan', 'olahraga.jpg', NOW()),
('Curug sewu', 'Pemandangan Curug Siang hari', 'curug.jpg', NOW());
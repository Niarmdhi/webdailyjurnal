-- Struktur tabel untuk user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT 'default.jpg',
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert data sample untuk testing (termasuk user danny dengan password admin)
INSERT INTO `user` (`username`, `password`, `foto`) VALUES
('admin', MD5('admin123'), 'admin.jpg'), 
('danny', MD5('admin'), 'danny.jpg'),
('user1', MD5('password123'), 'user1.jpg'),
('user2', MD5('password123'), 'user2.jpg'),
('user3', MD5('password123'), 'user3.jpg'),
('user4', MD5('password123'), 'user4.jpg'),
('user5', MD5('password123'), 'user5.jpg'),
('user6', MD5('password123'), 'user6.jpg');
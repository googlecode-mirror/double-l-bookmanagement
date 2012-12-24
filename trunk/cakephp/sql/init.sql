INSERT INTO `users` (`id`, `username`, `name`, `password`, `role`, `location_id`, `valid`, `created`, `modified`) VALUES
('admin', 'admin', 'Default Admin', 'b54025851dd54398f9c83ae6b3a0a376e0b28095', 'admin', 'A', 1, '2012-11-12 15:18:25', '2012-11-12 15:18:25');

INSERT INTO `system_incs` (`id`, `format`, `count`, `create_time`, `modi_time`) VALUES
('BOOK_B', 'B%1$07d', 0, '2012-11-19 22:49:35', '2012-11-20 23:41:16'),
('BOOK_M', 'M%1$07d', 0, '2012-11-19 22:50:03', '2012-11-21 00:01:28');

INSERT INTO `book_status` (`id`, `status_nme`) VALUES
(0, '購買中'),
(1, '在庫'),
(2, '借出'),
(3, '已歸還'),
(4, '整理中'),
(5, '運送中'),
(6, '預約中');

INSERT INTO `lend_status` (`id`, `lend_status_name`) VALUES
('C', '出借中'),
('D', '遺失'),
('E', '續借中'),
('I', '歸還'),
('R', '預約'),
('S', '取消');

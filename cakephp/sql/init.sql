INSERT INTO `users` (`id`, `username`, `name`, `password`, `role`, `location_id`, `valid`, `created`, `modified`) VALUES
('admin', 'admin', 'Default Admin', 'b54025851dd54398f9c83ae6b3a0a376e0b28095', 'admin', 'A', 1, '2012-11-12 15:18:25', '2012-11-12 15:18:25');

INSERT INTO `system_incs` (`id`, `format`, `count`, `create_time`, `modi_time`) VALUES
('BOOK_B', 'B%1$07d', 0, '2012-11-19 22:49:35', '2012-11-20 23:41:16'),
('BOOK_M', 'M%1$07d', 0, '2012-11-19 22:50:03', '2012-11-21 00:01:28');

INSERT INTO `book_status` (`id`, `status_nme`) VALUES
(0, '�ʶR��'),
(1, '�b�w'),
(2, '�ɥX'),
(3, '�w�k��'),
(4, '��z��'),
(5, '�B�e��'),
(6, '�w����');

INSERT INTO `lend_status` (`id`, `lend_status_name`) VALUES
('C', '�X�ɤ�'),
('D', '��'),
('E', '��ɤ�'),
('I', '�k��'),
('R', '�w��'),
('S', '����');

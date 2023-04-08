
CREATE TABLE `tasks` (
  `id` int(10) NOT NULL,
  `title` varchar(250) NOT NULL,
  `about` text NOT NULL,
  `user_id` int(10) NOT NULL,
  `task_type_id` int(10) NOT NULL,
  `task_date` date DEFAULT current_timestamp(),
  `priority_id` int(10) NOT NULL DEFAULT 3,
  `status_id` int(10) NOT NULL DEFAULT 1,
  `next_date` datetime DEFAULT current_timestamp(),
  `project_id` int(10) DEFAULT 1,
  `created_by` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `uuid` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `about`, `user_id`, `task_type_id`, `task_date`, `priority_id`, `status_id`, `next_date`, `project_id`, `created_by`, `created_at`, `updated_at`, `uuid`) VALUES
(3, 'Task Performed to Maria Shaban', 'People care about how you see the world, how you think, what motivates you, what you’re struggling with or afraid of. Tafadhali ongeza salio, kifurushi au angalia huduma zetu za BUREParticipating in agile development processes and attending sprint meetings.\n\n\n', 2, 2, '2023-02-18', 2, 7, '2023-02-27 23:04:00', 1, 1, '2023-02-18 17:07:03', '2023-04-08 17:46:41', '002e5fb9-8afa-4210-ab5e-7ceeef72ee38'),
(4, 'Albogast Sent New Message', 'Implementing security measures and ensuring compliance with security standards', 1, 5, '2023-02-18', 1, 7, '2023-02-18 00:00:00', 1, 1, '2023-02-18 18:29:15', '2023-04-08 17:47:40', '226fc8f6-91fe-448e-b4b2-b172d03e9d4f'),
(5, 'Albogast Sent New Message', 'Creating and maintaining software deployment pipelines\n', 1, 5, '2023-02-18', 1, 7, '2023-02-18 00:00:00', 1, 1, '2023-02-18 18:29:39', '2023-04-08 17:47:28', '3fbf09e9-3568-43d0-9459-2126fdac501e'),
(6, 'Performed to Clients', 'Optimizing code and systems for performance and scalability\n', 1, 2, '2023-02-19', 1, 3, '2023-03-01 23:34:00', 2, 1, '2023-02-19 17:34:41', '2023-04-08 17:47:52', '3c978d52-5727-48ff-8cfe-fccc92269c90'),
(7, 'Pink is obviously a better color.', 'Troubleshooting and resolving issues in production systems\n', 1, 2, '2023-02-20', 3, 1, '2023-02-22 07:29:00', 4, 1, '2023-02-20 01:29:39', '2023-04-08 17:48:29', '8d1312fe-9b95-459e-90f1-9ef12604f1c0'),
(8, 'Checking the network cables, modem, and router', 'Troubleshooting and resolving issues in production systems', 2, 7, '2023-02-20', 2, 5, '2023-02-22 08:26:00', 8, 2, '2023-02-20 02:27:00', '2023-04-08 17:48:39', 'b3f5601d-1e92-4e64-a4fe-6dca0dfd15d1'),
(12, 'Junior Mkuti Sent New Message', 'Participating in agile development processes and attending sprint meetings.\n\n', 4, 5, '2023-03-27', 1, 7, '2023-03-27 00:00:00', 1, 4, '2023-03-27 10:47:25', '2023-04-08 17:48:15', '5251f12d-c1e2-49a4-9ecc-12e90d58d667'),
(13, 'Payment', 'Writing unit tests and conducting automated testing', 4, 4, '2023-03-27', 1, 3, '2023-03-27 13:49:00', 1, 4, '2023-03-27 10:49:37', '2023-04-08 17:48:52', '08f16643-262b-493b-92c1-55559f683384'),
(14, 'Payment', 'Developing and implementing algorithms and data structures', 4, 4, '2023-03-27', 1, 3, '2023-03-27 13:49:00', 1, 4, '2023-03-27 10:49:38', '2023-04-08 17:51:56', 'b2e2c252-e894-4196-9593-ea2b0eb9df41'),
(15, 'Siah Sent New Message', 'Writing code and debugging errors', 5, 5, '2023-03-27', 1, 7, '2023-03-27 00:00:00', 1, 5, '2023-03-27 11:14:01', '2023-04-08 17:49:25', 'a85ced61-6425-425d-b9c8-53ec79355654'),
(16, 'Siah Sent New Message', 'Designing software architecture and system architecture.', 5, 5, '2023-03-27', 1, 7, '2023-03-27 00:00:00', 1, 5, '2023-03-27 11:14:06', '2023-04-08 17:49:38', '5de8ea96-907f-4718-8dc6-cc921f8fe14d'),
(17, 'Siah Sent New Message', 'Creating and maintaining documentation for code and systems', 5, 5, '2023-03-27', 1, 7, '2023-03-27 00:00:00', 1, 5, '2023-03-27 11:14:06', '2023-04-08 17:49:51', '0b856aca-dad7-47c9-b0da-34471814fbe7'),
(18, 'Junior Mkuti Sent New Message', 'Conducting code reviews and providing feedback to peers', 4, 5, '2023-03-27', 1, 7, '2023-03-27 00:00:00', 1, 4, '2023-03-27 11:15:30', '2023-04-08 17:50:13', '20dc0452-2f87-4795-b68a-32134be85b1f'),
(19, 'Junior Mkuti Sent New Message', 'Developing and implementing algorithms and data structures.', 4, 5, '2023-03-27', 1, 7, '2023-03-27 00:00:00', 1, 4, '2023-03-27 11:17:17', '2023-04-08 17:52:44', '1a99ecc3-7ae0-4582-b4da-1950fa2d368c'),
(20, 'Junior Mkuti Sent New Message', 'Integrating third-party software and APIs into projects', 4, 5, '2023-03-27', 1, 7, '2023-03-27 00:00:00', 1, 4, '2023-03-27 11:26:09', '2023-04-08 17:50:50', 'e233594f-39a2-46f5-aeb4-93d73ba1eb9f'),
(21, 'Junior Mkuti Sent New Message', 'Integrating third-party software and APIs into projects', 4, 5, '2023-03-27', 1, 7, '2023-03-27 00:00:00', 1, 4, '2023-03-27 11:30:13', '2023-04-08 17:50:44', 'b088048e-3cf2-44ad-96b9-9977df8a4311'),
(22, 'Junior Mkuti Sent New Message', 'Creating and maintaining user interfaces.', 4, 5, '2023-03-27', 1, 7, '2023-03-27 00:00:00', 1, 4, '2023-03-27 11:34:48', '2023-04-08 17:51:33', 'bbbd06b7-62f9-45b3-bc17-326eb4c23745'),
(23, 'Development', 'Reorder tasks with drag and drop in the browser. Priority should automatically be updated based on this. #1 priority goes at the top, #2 next down, and so on.', 2, 3, '2023-04-08', 1, 3, '2023-04-14 20:26:00', NULL, 2, '2023-04-08 17:30:48', '2023-04-08 17:35:22', 'c13b2484-6781-4124-8bc1-7ec7d9965b8f'),
(24, 'Resolve Bug', 'Create task (info to save: task name, priority, timestamps)', 3, 2, '2023-04-08', 3, 1, '2023-04-10 20:43:00', NULL, 3, '2023-04-08 17:44:02', '2023-04-08 17:44:02', '756475d7-a437-45c5-a3ed-66222f9e6fd3'),
(25, 'Development', 'BONUS POINT: add project functionality to the tasks. Users should be able to select a project from a dropdown and only view tasks associated with that project.', 4, 3, '2023-04-08', 2, 3, '2023-04-22 20:44:00', NULL, 4, '2023-04-08 17:44:42', '2023-04-08 17:44:42', 'd2a7db98-efe9-4776-b6c3-143de82e2b58');

-- --------------------------------------------------------

--
-- Table structure for table `task_priority`
--

CREATE TABLE `task_priority` (
  `id` int(10) NOT NULL,
  `name` varchar(200) NOT NULL,
  `about` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `task_priority`
--

INSERT INTO `task_priority` (`id`, `name`, `about`, `created_at`, `updated_at`) VALUES
(1, 'High Priority', 'High Priority', '2023-02-15 14:13:59', '2023-02-15 14:13:59'),
(2, 'Urgent Priority', 'Urgent Priority', '2023-02-15 14:13:59', '2023-02-15 14:13:59'),
(3, 'Medium Priority', 'Medium Priority', '2023-02-15 14:15:25', '2023-02-15 14:15:25'),
(4, 'Normal Priority', 'Normal Priority', '2023-02-15 14:15:25', '2023-02-15 14:15:25'),
(5, 'Low Priority', 'Low Priority', '2023-02-15 14:15:25', '2023-02-15 14:15:25');

-- --------------------------------------------------------

--
-- Table structure for table `task_status`
--

CREATE TABLE `task_status` (
  `id` int(10) NOT NULL,
  `name` varchar(200) NOT NULL,
  `about` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `task_status`
--

INSERT INTO `task_status` (`id`, `name`, `about`, `created_at`, `updated_at`) VALUES
(1, 'Started', 'Task Started', '2023-02-15 14:20:36', '2023-02-15 14:20:36'),
(3, 'Onprogess', 'Task Onprogess', '2023-02-15 14:21:42', '2023-02-15 14:21:42'),
(4, 'Pending', 'Task Pending', '2023-02-15 14:21:42', '2023-02-15 14:21:42'),
(5, 'Scheduled', 'Task Scheduled', '2023-02-15 14:21:42', '2023-02-15 14:21:42'),
(7, 'Completed', 'Task Completed', '2023-02-15 14:20:36', '2023-04-08 17:36:05');

-- --------------------------------------------------------

--
-- Table structure for table `task_type`
--

CREATE TABLE `task_type` (
  `id` int(10) NOT NULL,
  `name` varchar(200) NOT NULL,
  `code` varchar(200) NOT NULL,
  `about` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `task_type`
--

INSERT INTO `task_type` (`id`, `name`, `code`, `about`, `created_at`, `updated_at`) VALUES
(1, 'Followup', '001', 'Customer Followup', '2023-02-15 16:00:08', '2023-02-15 16:00:08'),
(2, 'Resolve Bug', '002', 'Customer Visitation', '2023-02-15 16:00:08', '2023-04-08 15:47:14'),
(3, 'Development', '003', 'Received Call feom Customer', '2023-02-15 16:01:33', '2023-04-08 15:47:22'),
(4, 'New Feature', '004', 'Phone Call Made', '2023-02-15 16:01:33', '2023-04-08 15:47:31'),
(5, 'Deployment', '005', 'Send Messges to Clients', '2023-02-15 16:03:28', '2023-04-08 15:47:47'),
(6, 'Configuration', '006', 'Send Email to Customer', '2023-02-15 16:03:28', '2023-04-08 15:47:57'),
(7, 'Training', '008', 'Make Training', '2023-02-15 16:09:46', '2023-02-15 16:09:46'),
(8, 'Support', '009', 'Consultation to Customers', '2023-02-15 16:09:46', '2023-04-08 15:48:10');

-- --------------------------------------------------------

--
-- Table structure for table `task_users`
--

CREATE TABLE `task_users` (
  `id` int(10) NOT NULL,
  `task_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sex` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` int(10) DEFAULT NULL,
  `photo` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT 'user.png',
  `dob` date NOT NULL DEFAULT current_timestamp(),
  `address` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` int(10) NOT NULL DEFAULT 5,
  `role_id` int(10) NOT NULL DEFAULT 5,
  `jod` date NOT NULL DEFAULT current_timestamp(),
  `salary` float DEFAULT 0,
  `status` int(2) NOT NULL DEFAULT 1,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `uuid` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `sex`, `code`, `photo`, `dob`, `address`, `department_id`, `role_id`, `jod`, `salary`, `status`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `uuid`) VALUES
(1, 'Albogast', 'albogast@coalitiontechnologies.com', '+255786550809', 'Male', 10001, 'user.png', '2023-02-15', 'Mbezi juu', 3, 1, '2023-02-15', 100000, 1, NULL, '$2y$10$A9UnRc8zAYSTNrCv49Zdq.mttiIgwPWYOft4dKZMDFiF0euf6GkFC', NULL, NULL, NULL, 'f505c47f-09eb-426a-b09c-4704090bacd7'),
(2, 'Christine John', 'christine@coalitiontechnologies.com', '+255076452387', 'Male', 218, 'user.png', '1987-01-31', 'Dar Es Salaam', 6, 2, '2023-02-01', 120000, 1, NULL, '$2y$10$RCx3N4spc6BPr6G84HpXMuj.jsYCOONU2PGVkUuJQGWTU.sf675QC', NULL, '2023-02-15 15:26:49', '2023-02-15 15:26:49', 'ff9d8f81-c44f-46f2-9493-93945f9e583a'),
(3, 'Joel Cole', 'joel@coalitiontechnologies.com', '+255765025563', 'Male', 310, 'user.png', '2001-02-28', 'Mbezi, Africana', 4, 6, '2022-12-08', 1, 1, NULL, '$2y$10$.rHuKxkkOxG5JUUn3J8K0OW8BjNaxusVT.p734qrL78rubpxQH7Fa', NULL, '2023-03-19 10:11:42', '2023-03-19 10:11:42', 'b35f273c-cd8a-4062-bbe6-8599b221da1b'),
(4, 'Rebecca Junior', 'rebecca@coalitiontechnologies.com', '+255714101010', 'Male', 310, 'user.png', '2001-02-28', 'Mbezi, Africana', 6, 3, '2023-03-16', 1, 1, NULL, '$2y$10$zXFbnZhx/akXxgjKRgCsCudNUnMI5H5e2fFPDlRauCpgn2hHNCHeq', NULL, '2023-03-19 10:14:38', '2023-03-19 10:14:38', 'a82a4913-58f0-4395-aef3-1fc31dd0195d'),
(5, 'Thiago Torres', 'thiago@coalitiontechnologies.com', '+255715751925', 'Female', 310, 'user.png', '2001-03-11', 'Mbezi, Africana', 6, 3, '2023-02-27', 1, 1, NULL, '$2y$10$WzEHmbXnoRCim5pAEpTA/.Hgwq1kY9bagYEBBBuAYVr.7XC3QNHD6', NULL, '2023-03-19 10:16:32', '2023-03-19 10:16:32', 'a007a44c-34d9-48b0-ade8-aa0955d2b795');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_type_id` (`task_type_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `priority_id` (`priority_id`),
  ADD KEY `status_id` (`status_id`);

--
-- Indexes for table `task_priority`
--
ALTER TABLE `task_priority`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_status`
--
ALTER TABLE `task_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_type`
--
ALTER TABLE `task_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_users`
--
ALTER TABLE `task_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `task_priority`
--
ALTER TABLE `task_priority`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `task_status`
--
ALTER TABLE `task_status`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `task_type`
--
ALTER TABLE `task_type`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `task_users`
--
ALTER TABLE `task_users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`task_type_id`) REFERENCES `task_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tasks_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tasks_ibfk_4` FOREIGN KEY (`priority_id`) REFERENCES `task_priority` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tasks_ibfk_5` FOREIGN KEY (`status_id`) REFERENCES `task_status` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `task_users`
--
ALTER TABLE `task_users`
  ADD CONSTRAINT `task_users_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `task_users_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

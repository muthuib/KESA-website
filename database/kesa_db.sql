-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2025 at 08:41 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kesa_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_us`
--

CREATE TABLE `about_us` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `TITLE` varchar(255) NOT NULL,
  `CONTENT` text NOT NULL,
  `CREATED_AT` timestamp NULL DEFAULT NULL,
  `UPDATED_AT` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `about_us`
--

INSERT INTO `about_us` (`ID`, `TITLE`, `CONTENT`, `CREATED_AT`, `UPDATED_AT`) VALUES
(1, 'KESA', 'KESA is a Premier National Economics Scholars Association that unites Economics, Business, and Statistics Stakeholders and Passionate Associate members from other backgrounds from various universities, colleges, and Technical, Vocational Education, and Training Institutions in Kenya.', '2024-12-21 09:04:57', '2024-12-21 09:04:57');

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `ACTION` varchar(255) NOT NULL,
  `DESCRIPTION` text NOT NULL,
  `CREATED_AT` timestamp NOT NULL DEFAULT current_timestamp(),
  `UPDATED_AT` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `ID` int(11) NOT NULL,
  `CERTIFICATE_NUMBER` varchar(255) NOT NULL,
  `ISSUED_DATE` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `collaborations`
--

CREATE TABLE `collaborations` (
  `ID` int(10) NOT NULL,
  `NAME` varchar(255) NOT NULL,
  `LOGO_PATH` varchar(255) NOT NULL,
  `DESCRIPTION` text DEFAULT NULL,
  `WEBSITE` varchar(255) DEFAULT NULL,
  `CREATED_AT` timestamp NULL DEFAULT NULL,
  `UPDATED_AT` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `collaborations`
--

INSERT INTO `collaborations` (`ID`, `NAME`, `LOGO_PATH`, `DESCRIPTION`, `WEBSITE`, `CREATED_AT`, `UPDATED_AT`) VALUES
(3, 'Roundtech', 'logos/Xo6IxmYtJVMhZcMRNoofULlh0rziPxOEuD4QQWti.png', 'tech company', 'https://roundtech.co.ke/', '2024-12-21 00:00:14', '2025-01-02 08:16:28'),
(4, 'Roundtech', 'logos/aJ8xwAsXM2Z9PdjsLx2m5yYRcKX3kgzYHT2gm8x6.png', 'dd', 'https://roundtech.co.ke/', '2025-01-02 08:17:11', '2025-01-02 08:17:11'),
(5, 'mount-kenya-university', 'logos/E8gi2ulTsXRgWqZuMFpSVxbccuGqXQbW5QyHFxz6.jpg', 'mku', 'https://roundtech.co.ke/', '2025-01-02 08:18:34', '2025-01-02 08:18:34'),
(6, 'KESA', 'logos/PXJbKVhHwFkb3y7MX1BX7URhdTL1YtIuGzrndYpX.jpg', 'KESA', 'https://roundtech.co.ke/', '2025-01-02 08:19:17', '2025-01-02 08:19:17'),
(7, 'Roundtech', 'logos/O571vE3m02KhqIbytxhAeVmW5KbtxvosdgUOJh3D.jpg', 'J', 'https://roundtech.co.ke/', '2025-01-02 08:20:00', '2025-01-02 08:20:00');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `venue` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `start_date` date NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `location`, `venue`, `description`, `image`, `start_date`, `start_time`, `end_time`, `end_date`, `created_at`, `updated_at`) VALUES
(1, 'Debate', 'Nairobi, KEN', 'Nairobi, KEN', 'A debate motion needs to give both sides plenty to say – in the Schools\' Mace, enough to fill two seven-minute speeches, and inspire an interesting floor debate. It should give speakers a chance to choose between arguments as well, and decide which they want to focus on and prioritise. A debate motion needs to give both sides plenty to say – in the Schools\' Mace, enough to fill two seven-minute speeches, and inspire an interesting floor debate. It should give speakers a chance to choose between arguments as well, and decide which they want to focus on and prioritise. \r\n\r\n\r\n\r\nA debate motion needs to give both sides plenty to say – in the Schools\' Mace, enough to fill two seven-minute speeches, and inspire an interesting floor debate. It should give speakers a chance to choose between arguments as well, and decide which they want to focus on and prioritise. A debate motion needs to give both sides plenty to say – in the Schools\' Mace, enough to fill two seven-minute speeches, and inspire an interesting floor debate. It should give speakers a chance to choose between arguments as well, and decide which they want to focus on and prioritise.  A debate motion needs to give both sides plenty to say – in the Schools\' Mace, enough to fill two seven-minute speeches, and inspire an interesting floor debate. It should give speakers a chance to choose between arguments as well, and decide which they want to focus on and prioritise.', 'event_images/WZ9opJ2BED8yGWHKKoZMv2JmTnaXtCrCMdAWxNTJ.jpg', '2025-01-30', '08:00:00', '17:00:00', NULL, '2025-01-07 09:52:36', '2025-01-08 04:39:19'),
(2, 'charity', 'Nairobi, KEN', 'Nairobi, KEN', 'f', 'event_images/3KAQqlWF7qrsHVaUJ7r32GxSz68Z8LNu1v5GOWOR.jpg', '2025-01-02', '08:00:00', '17:00:00', NULL, '2025-01-07 10:47:32', '2025-01-08 03:39:52'),
(6, 'charity', 'Nairobi, KEN', 'Nairobi, KEN', 'hhhhhhhh', 'event_images/jkmt0DdIXU8Bczv0earwVB7TG1WwakdCPhuMvvx0.jpg', '2025-01-30', '10:07:00', '15:12:00', NULL, '2025-01-08 04:07:33', '2025-01-08 04:38:44');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `ID` int(11) NOT NULL,
  `FIRST_NAME` varchar(255) NOT NULL,
  `LAST_NAME` varchar(255) NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `STATUS` varchar(50) NOT NULL,
  `COURSE` varchar(255) DEFAULT NULL,
  `UNIVERSITY` varchar(255) DEFAULT NULL,
  `KESA_CERTIFICATE_NUMBER` varchar(255) DEFAULT NULL,
  `REASON` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2024_11_26_041015_create_subscriptions_table', 1),
(3, '2024_12_01_051419_create_jobs_table', 2),
(4, '2024_12_18_170150_create_roles_table', 3),
(5, '2024_12_18_170225_create_permissions_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `ID` int(11) NOT NULL,
  `TITLE` varchar(255) NOT NULL,
  `DESCRIPTION` text DEFAULT NULL,
  `IMAGE` varchar(255) DEFAULT NULL,
  `EVENT_DATE` date NOT NULL,
  `CREATED_BY` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `newsletters`
--

CREATE TABLE `newsletters` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `SUBJECT` varchar(255) NOT NULL,
  `MESSAGE` text NOT NULL,
  `CREATED_AT` timestamp NULL DEFAULT NULL,
  `UPDATED_AT` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `TITLE` varchar(255) NOT NULL,
  `MESSAGE` text NOT NULL,
  `NOTIFIABLE_ID` int(11) DEFAULT NULL,
  `NOTIFIABLE_TYPE` varchar(255) DEFAULT NULL,
  `READ_AT` timestamp NULL DEFAULT NULL,
  `CREATED_AT` timestamp NOT NULL DEFAULT current_timestamp(),
  `UPDATED_AT` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE `partners` (
  `ID` int(11) NOT NULL,
  `COMPANY_NAME` varchar(255) NOT NULL,
  `REGISTRATION_NUMBER` varchar(255) NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `PHONE_NUMBER` varchar(20) NOT NULL,
  `PHYSICAL_ADDRESS` varchar(255) NOT NULL,
  `COMPANY_TYPE` varchar(255) DEFAULT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `REASON` text DEFAULT NULL,
  `CREATED_AT` timestamp NOT NULL DEFAULT current_timestamp(),
  `UPDATED_AT` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `partners`
--

INSERT INTO `partners` (`ID`, `COMPANY_NAME`, `REGISTRATION_NUMBER`, `EMAIL`, `PHONE_NUMBER`, `PHYSICAL_ADDRESS`, `COMPANY_TYPE`, `PASSWORD`, `REASON`, `CREATED_AT`, `UPDATED_AT`) VALUES
(3, 'Roundtech', '12345', 'anniekasyoka1@gmail.com', '0799937896', '01000', 'IT', '$2y$10$739AiJ3xRzD3qzC.VaniTOmiXLmPtHZJaSpKt5TklO6FTZ1f7hXsu', 'ww', '2024-12-23 11:21:13', '2024-12-23 11:21:13');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'create post', '2024-12-19 01:43:05', '2024-12-19 01:43:05'),
(2, 'edit post', '2024-12-19 01:43:05', '2024-12-19 01:43:05'),
(3, 'update post', '2024-12-19 01:43:05', '2024-12-19 01:43:05'),
(4, 'delete post', '2024-12-19 01:43:05', '2024-12-19 01:43:05'),
(5, 'view post', '2024-12-19 01:43:05', '2024-12-19 01:43:05');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`id`, `permission_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 2, 1, NULL, NULL),
(3, 4, 1, NULL, NULL),
(4, 3, 1, NULL, NULL),
(5, 5, 2, NULL, NULL),
(6, 5, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `event_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `qr_code_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE `resources` (
  `ID` int(11) NOT NULL,
  `TITLE` varchar(255) NOT NULL,
  `DESCRIPTION` text DEFAULT NULL,
  `FILE_PATH` varchar(255) NOT NULL,
  `PRICE` float DEFAULT 0,
  `TYPE` varchar(255) DEFAULT NULL,
  `CREATED_AT` timestamp NOT NULL DEFAULT current_timestamp(),
  `UPDATED_AT` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resources`
--

INSERT INTO `resources` (`ID`, `TITLE`, `DESCRIPTION`, `FILE_PATH`, `PRICE`, `TYPE`, `CREATED_AT`, `UPDATED_AT`) VALUES
(5, 'KESA', 'Econometrics is a branch of economics that uses statistical and mathematical methods to analyze economic data. It\'s a quantitative approach to economics that aims to understand how the economy works by turning theoretical economic models into tools for policymaking', 'images/1734371412.png', 2000, 'pdf', '2024-12-16 08:49:19', '2024-12-21 15:31:56'),
(6, 'kesa', 'ddd', 'images/1734804436.jfif', 899, 'article', '2024-12-21 15:07:16', '2024-12-21 17:36:24'),
(7, 'Kesa resource', 'kesa', 'images/1734812300.pdf', 0, 'pdf', '2024-12-21 17:18:20', '2024-12-21 17:18:20');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2024-12-19 01:43:05', '2024-12-19 01:43:05'),
(2, 'partner', '2024-12-19 01:43:05', '2024-12-19 01:43:05'),
(3, 'member', '2024-12-19 01:43:05', '2024-12-19 01:43:05');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`id`, `role_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 7, NULL, NULL),
(12, 3, 20, NULL, NULL),
(17, 3, 11, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `slides`
--

CREATE TABLE `slides` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `IMAGE_PATH` varchar(255) NOT NULL,
  `CAPTION` varchar(255) DEFAULT NULL,
  `CREATED_AT` timestamp NULL DEFAULT NULL,
  `UPDATED_AT` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `slides`
--

INSERT INTO `slides` (`ID`, `IMAGE_PATH`, `CAPTION`, `CREATED_AT`, `UPDATED_AT`) VALUES
(18, 'slides/1734691725.jfif', '\"Empowering Future Economists: Uniting Knowledge and Leadership.\" \"Welcome to the Hub of Economic Excellence.\"', '2024-12-20 07:48:45', '2024-12-20 07:48:45'),
(19, 'slides/1734691759.jfif', '\"Where Ideas Shape Economies.\" \"Inspiring Growth, One Student at a Time.\"', '2024-12-20 07:49:19', '2024-12-20 07:49:19'),
(20, 'slides/1734691889.jfif', '\"Fostering Innovation, Empowering Change.\" \"Shaping Tomorrow’s Economic Leaders Today.\"', '2024-12-20 07:51:29', '2024-12-20 07:51:29'),
(21, 'slides/1734691957.jfif', 'Your Journey to Economic Mastery Begins Here.\" \"Networking, Knowledge, and Opportunities—All in One Place.\"', '2024-12-20 07:52:37', '2024-12-20 07:52:37'),
(22, 'slides/1734691993.jfif', '\"Engage. Educate. Excel.\" \"Workshops, Seminars, and Beyond—For a Brighter Economic Future.\"', '2024-12-20 07:53:13', '2024-12-20 07:53:13');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `CREATED_AT` timestamp NULL DEFAULT NULL,
  `UPDATED_AT` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`ID`, `EMAIL`, `CREATED_AT`, `UPDATED_AT`) VALUES
(65, 'muthuib220@gmail.com', '2024-12-16 09:12:02', '2024-12-16 09:12:02');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `name`, `price`, `created_at`, `updated_at`) VALUES
(1, 'Debate', 1.00, '2025-01-05 04:48:42', '2025-01-05 16:52:34');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `mpesa_receipt` varchar(255) DEFAULT NULL,
  `status` enum('pending','completed','failed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `ticket_id`, `phone`, `amount`, `mpesa_receipt`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '254799937896', 500.00, NULL, 'pending', '2025-01-05 04:49:27', '2025-01-05 04:49:27'),
(2, 1, '254799937896', 1000.00, NULL, 'pending', '2025-01-05 06:33:25', '2025-01-05 06:33:25'),
(3, 1, '254799937896', 1000.00, NULL, 'pending', '2025-01-05 06:34:26', '2025-01-05 06:34:26'),
(4, 1, '254799937896', 1000.00, NULL, 'pending', '2025-01-05 09:41:56', '2025-01-05 09:41:56');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `FIRST_NAME` varchar(255) NOT NULL,
  `LAST_NAME` varchar(255) NOT NULL,
  `USERNAME` varchar(255) NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `EMAIL_VERIFICATION` tinyint(1) DEFAULT 0,
  `CATEGORY` varchar(255) NOT NULL,
  `COURSE` varchar(255) NOT NULL,
  `UNIVERSITY` varchar(255) NOT NULL,
  `REASON` varchar(255) DEFAULT NULL,
  `email_verified_at` datetime(6) DEFAULT NULL,
  `PASSWORD_HASH` varchar(255) NOT NULL,
  `ROLE` enum('STUDENT','INSTRUCTOR','ADMIN','ALUMNI') DEFAULT 'STUDENT',
  `CREATED_AT` timestamp NOT NULL DEFAULT current_timestamp(),
  `UPDATED_AT` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `FIRST_NAME`, `LAST_NAME`, `USERNAME`, `EMAIL`, `EMAIL_VERIFICATION`, `CATEGORY`, `COURSE`, `UNIVERSITY`, `REASON`, `email_verified_at`, `PASSWORD_HASH`, `ROLE`, `CREATED_AT`, `UPDATED_AT`) VALUES
(7, 'Benjamin', 'Muthui', 'ben', 'benmuthui98@gmail.com', 0, 'graduate', 'Economics', 'University of Nairobi', '', NULL, '$2y$10$z7xvqQMVIR.HQoLmJzH4HOjqIOErrmB0nSNsCzH2EEc31W3zgV.9y', 'STUDENT', '2024-12-19 03:22:14', '2024-12-23 16:10:32'),
(11, 'Ann', 'David', 'muthuibb', 'anniekasyoka1@gmail.com', 0, 'Ongoing Student', 'Economics', 'University of Nairobi', 'reason', NULL, '$2y$10$0XnVDeoeb0aBoEnnIJflDuCy.D1N20F5TQHCSpNGQwX5fdZV1Yi2C', 'STUDENT', '2024-12-23 14:32:17', '2025-01-04 06:01:43'),
(20, 'Benjamin', 'Muthui', 'muthuib', 'muthuib220@gmail.com', 0, 'graduate', 'Economics', 'University of Nairobi', 'reason', NULL, '$2y$10$3LQC0hTtbQSR.tMkHGe2tOJuN4DrLCPH/JobMutoyRj0Nd9Y3KtU2', 'STUDENT', '2025-01-02 02:42:24', '2025-01-02 02:42:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_us`
--
ALTER TABLE `about_us`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `CERTIFICATE_NUMBER` (`CERTIFICATE_NUMBER`);

--
-- Indexes for table `collaborations`
--
ALTER TABLE `collaborations`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `EMAIL` (`EMAIL`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `CREATED_BY` (`CREATED_BY`);

--
-- Indexes for table `newsletters`
--
ALTER TABLE `newsletters`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `USER_ID` (`USER_ID`);

--
-- Indexes for table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `REGISTRATION_NUMBER` (`REGISTRATION_NUMBER`),
  ADD UNIQUE KEY `EMAIL` (`EMAIL`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_id` (`permission_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `slides`
--
ALTER TABLE `slides`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `subscriptions_email_unique` (`EMAIL`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_id` (`ticket_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `EMAIL` (`EMAIL`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_us`
--
ALTER TABLE `about_us`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `collaborations`
--
ALTER TABLE `collaborations`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `newsletters`
--
ALTER TABLE `newsletters`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resources`
--
ALTER TABLE `resources`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `slides`
--
ALTER TABLE `slides`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`CREATED_BY`) REFERENCES `members` (`ID`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`USER_ID`) REFERENCES `users` (`ID`);

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_ibfk_1` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_role_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `registrations`
--
ALTER TABLE `registrations`
  ADD CONSTRAINT `registrations_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

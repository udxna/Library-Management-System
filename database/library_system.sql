-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 14, 2026 at 04:25 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `book_id` varchar(5) NOT NULL,
  `book_name` varchar(100) NOT NULL,
  `category_id` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`book_id`, `book_name`, `category_id`) VALUES
('B001', 'Harry Potter 1', 'C001'),
('B002', 'ben 10', 'C004');

-- --------------------------------------------------------

--
-- Table structure for table `bookborrower`
--

CREATE TABLE `bookborrower` (
  `borrow_id` varchar(5) NOT NULL,
  `book_id` varchar(5) NOT NULL,
  `member_id` varchar(5) NOT NULL,
  `borrow_status` varchar(100) NOT NULL,
  `borrower_date_modified` varchar(100) NOT NULL,
  `borrow_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookborrower`
--

INSERT INTO `bookborrower` (`borrow_id`, `book_id`, `member_id`, `borrow_status`, `borrower_date_modified`, `borrow_date`, `due_date`, `return_date`) VALUES
('BR001', 'B001', 'M001', 'Returned', '2026-05-14 15:19:02', NULL, NULL, '2026-05-14'),
('BR002', 'B001', 'M002', 'Returned', '2026-05-14 15:19:17', '2026-05-14', '2026-05-21', '2026-05-14'),
('BR003', 'B001', 'M001', 'Returned', '2026-05-14 15:24:25', '2026-05-14', '2026-05-21', '2026-05-14');

-- --------------------------------------------------------

--
-- Table structure for table `bookcategory`
--

CREATE TABLE `bookcategory` (
  `category_id` varchar(5) NOT NULL,
  `category_Name` varchar(100) NOT NULL,
  `date_modified` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookcategory`
--

INSERT INTO `bookcategory` (`category_id`, `category_Name`, `date_modified`) VALUES
('C001', 'Sci-fi', '2014-08-12 11:14:54am'),
('C002', 'Adventure', '2014-08-13 11:14:54am'),
('C003', 'Romance', '2026-05-13 10:01:42'),
('C004', 'History', '2026-05-13 11:49:56');

-- --------------------------------------------------------

--
-- Table structure for table `fine`
--

CREATE TABLE `fine` (
  `fine_id` varchar(5) NOT NULL,
  `book_id` varchar(5) NOT NULL,
  `member_id` varchar(5) NOT NULL,
  `overdue_days` int(11) NOT NULL,
  `fine_amount` decimal(10,2) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Unpaid',
  `fine_date_modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fine`
--

INSERT INTO `fine` (`fine_id`, `book_id`, `member_id`, `overdue_days`, `fine_amount`, `status`, `fine_date_modified`) VALUES
('F001', 'B001', 'M001', 0, 0.00, 'Paid', '2026-05-14 10:09:18'),
('F335', 'B001', 'M001', 20586, 205860.00, 'Unpaid', '2026-05-14 10:47:33'),
('F744', 'B001', 'M001', 20586, 205860.00, 'Paid', '2026-05-14 13:43:11'),
('F745', 'B001', 'M001', 4, 40.00, 'Paid', '2026-05-14 13:47:24'),
('F746', 'B001', 'M002', 3, 30.00, 'Paid', '2026-05-14 13:47:22');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `member_id` varchar(5) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `birthday` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`member_id`, `first_name`, `last_name`, `birthday`, `email`) VALUES
('M001', 'Shan', 'Jayasekar', '12/02/2000', 'shan@gmail.com'),
('M002', 'udana', 'srimal', '2026-05-02', 'us@gmail.com'),
('M004', 'ushss', 'd', '2026-05-07', 'us@gmail.com'),
('M005', 'ncv nc', 'cvcv', '4434-03-23', 'cd@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` varchar(5) NOT NULL,
  `email` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` varchar(50) NOT NULL DEFAULT 'Librarian'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `firstname`, `lastname`, `username`, `password`, `created_at`, `role`) VALUES
('U001', 'kamal@gmail.com', 'Kamal', 'Perera', 'k_perera', 'admin123', '2026-05-12 16:48:25', 'Librarian'),
('U002', 'as@gmail.com', 'Udana', 'Srimal', 'us', '$2y$10$y7HSvRzHPy6CjtNx2dF3KeiXAS9QTJiUTMKftrhpI72lq0mhskL0i', '2026-05-12 16:49:24', 'Librarian'),
('U003', 'js@gmail.com', 'js', 'js', 'js', '$2y$10$34FWIqfduVGHehBtd6FBUueFLdf0QM0hUcBJTpRnQufhgr27R2t2K', '2026-05-14 14:15:13', 'Librarian');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `fk_cat_id` (`category_id`);

--
-- Indexes for table `bookborrower`
--
ALTER TABLE `bookborrower`
  ADD PRIMARY KEY (`borrow_id`,`book_id`,`member_id`),
  ADD KEY `fk_book_id` (`book_id`),
  ADD KEY `fk_member_id` (`member_id`);

--
-- Indexes for table `bookcategory`
--
ALTER TABLE `bookcategory`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `fine`
--
ALTER TABLE `fine`
  ADD PRIMARY KEY (`fine_id`),
  ADD KEY `fk_book_id_fine` (`book_id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `fk_cat_id` FOREIGN KEY (`category_id`) REFERENCES `bookcategory` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bookborrower`
--
ALTER TABLE `bookborrower`
  ADD CONSTRAINT `fk_book_id` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_member_id` FOREIGN KEY (`member_id`) REFERENCES `member` (`member_id`) ON UPDATE CASCADE;

--
-- Constraints for table `fine`
--
ALTER TABLE `fine`
  ADD CONSTRAINT `fk_book_id_fine` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 21, 2017 at 01:47 PM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 7.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wusapp_dev_v1`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_token`
--

CREATE TABLE `access_token` (
  `access_token_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `access_token` varchar(100) NOT NULL,
  `device_token` text NOT NULL,
  `os_type` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `config_master`
--

CREATE TABLE `config_master` (
  `config_id` int(11) NOT NULL,
  `config_key` varchar(100) NOT NULL,
  `config_value` varchar(200) NOT NULL,
  `config_label` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `def_clients`
--

CREATE TABLE `def_clients` (
  `client_id` int(11) NOT NULL,
  `client_key` varchar(50) NOT NULL,
  `client_secret` varchar(50) NOT NULL,
  `type` enum('WEB','ANDROID','IOS') NOT NULL,
  `version` decimal(10,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `log_table`
--

CREATE TABLE `log_table` (
  `log_id` int(11) NOT NULL,
  `log_type` varchar(20) NOT NULL,
  `route_name` varchar(100) NOT NULL,
  `log_text` text NOT NULL,
  `file_log_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `message_id` int(11) NOT NULL,
  `message_key` varchar(100) NOT NULL,
  `message_label` varchar(100) NOT NULL,
  `message_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`message_id`, `message_key`, `message_label`, `message_value`) VALUES
(1, 'login_successfully', 'Login Successfully', 'Login Successfully'),
(2, 'email_password_not_match', 'Email or Password not match', 'Email or Password not match please try again.'),
(3, 'email_id_not_registered', 'Email is not registered', 'This Email is not register with us'),
(4, 'account_suspend', 'Your account is suspend', 'Your account is suspend by admin '),
(5, 'something_went_wrong', 'Something Went wrong please try again', 'Something Went wrong please try again'),
(6, 'email_already_exist', 'Email address is exist', 'This email is already register with us'),
(7, 'register_successfully', 'Register Successfully', 'Register Successfully'),
(8, 'verify_email_link_in_mail', 'verify Email subject name in mail', 'Verify Account'),
(10, 'verifylink_sent_successfully', 'Verify link sent successfully', 'Verify link sent successfully please check your email'),
(11, 'reset_password_link_in_mail', 'Reset Password subject name in mail', 'Reset password Link'),
(12, 'forgot_password_link_sent', 'Forgot Password Link sent successfully', 'Forgot Password Link sent successfully'),
(13, 'logout_success', 'Your device logout successfully', 'Your device logout successfully'),
(14, 'user_profile', 'Get User Profile', 'user profile retrive successfully'),
(15, 'profile_update_success', 'User profile update successfully', 'User profile update successfully');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access_token`
--
ALTER TABLE `access_token`
  ADD PRIMARY KEY (`access_token_id`);

--
-- Indexes for table `config_master`
--
ALTER TABLE `config_master`
  ADD PRIMARY KEY (`config_id`);

--
-- Indexes for table `def_clients`
--
ALTER TABLE `def_clients`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `log_table`
--
ALTER TABLE `log_table`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`message_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access_token`
--
ALTER TABLE `access_token`
  MODIFY `access_token_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;
--
-- AUTO_INCREMENT for table `config_master`
--
ALTER TABLE `config_master`
  MODIFY `config_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `def_clients`
--
ALTER TABLE `def_clients`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `log_table`
--
ALTER TABLE `log_table`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

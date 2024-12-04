-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2024 at 10:35 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smile_hero_clinic`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `admin_id` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_image` varchar(299) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `admin_id`, `first_name`, `last_name`, `email`, `contact`, `password`, `profile_image`, `created_at`) VALUES
(3, 'ADMIN5376', 'Leon', 'Manansala', 'admin@gmail.com', '09112233442', '$2y$10$Lw4SW0.ngP5GTIWSE.Cw2OMjkWKvdbSNV4uoLgRQyZpHMFplhelua', '125242687_365670124698131_3446407587757504268_n.jpg', '2024-10-23 03:38:12');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `user_id` varchar(100) NOT NULL,
  `doctor_id` varchar(100) DEFAULT NULL,
  `appointment_id` varchar(20) NOT NULL,
  `label` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(30) NOT NULL,
  `message` text NOT NULL,
  `date` varchar(30) NOT NULL,
  `time` varchar(30) NOT NULL,
  `service` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`user_id`, `doctor_id`, `appointment_id`, `label`, `name`, `email`, `contact`, `message`, `date`, `time`, `service`, `location`, `status`, `created_at`) VALUES
('SHC1677TCU', NULL, 'SHC1315', 'new', 'John Paul Villaruel Dela Cruz ', 'jpvillaruel02@gmail.com', '09070050140', '', '2024-11-19', '1:00 PM', 'dental filling  ₱6,700, braces consultation  ₱5,600, root canal treatment ₱16,800', 'Bayani Road, Taguig City', 'canceled', '2024-11-16 00:30:42'),
('SHC1677TCU', NULL, 'SHC34c4', 'new', 'John Paul Villaruel Dela Cruz ', 'jpvillaruel02@gmail.com', '09070050140', '', '2024-11-18', '11:00 AM', 'tooth extraction  ₱4,200, routine checkup-up ₱2,200, braces consultation  ₱5,600', 'Bayani Road, Taguig City', 'accepted', '2024-11-17 21:07:10'),
('SHC1677TCU', NULL, 'SHC6572', 'new', 'John Paul Villaruel Dela Cruz ', 'jpvillaruel02@gmail.com', '09070050140', '', '2024-11-15', '11:00 AM', 'dental filling  ₱6,700, routine checkup-up ₱2,200, braces consultation  ₱5,600', 'Bayani Road, Taguig City', 'canceled', '2024-11-14 15:56:40'),
('Walk-in', NULL, 'SHC8554', 'Walk-in', 'Leonel Martinez Constantino Sr.', 'LeonelSr@gmail.com', '09978545678', 'Good Day Leonel Martinez Constantino Sr., your appointment on 2024-12-18 at 10:00 AM has been accepted. Thanks for Choosing Smile Hero Dental Clinic', '2024-12-18', '10:00 AM', 'teeth whitening  ₱8,400, tooth extraction  ₱4,200, routine checkup-up ₱2,200, root canal treatment ₱', 'Bayani Road, Taguig City', 'accepted', '2024-11-19 15:08:53'),
('SHC1677TCU', NULL, 'SHC9054', 'new', 'John Paul Villaruel Dela Cruz ', 'jpvillaruel02@gmail.com', '09070050140', '', '2024-11-21', '2:00 PM', 'teeth whitening  ₱8,400, tooth extraction  ₱4,200, routine checkup-up ₱2,200', 'Bayani Road, Taguig City', 'canceled', '2024-11-17 18:55:27'),
('SHCQC38TCU', 'DOCCF32', 'SHCBA82', 'new', 'Emily Martin', 'emily.martin@example.com', '09112345678', 'I would like a teeth whitening', '2024-11-20', '2:00 pm', 'Teeth Whitening', 'Bayani Road, Taguig City', 'request', '2024-11-07 17:20:44'),
('SHCVR56TCU', 'DOCLZ92', 'SHCBN31', 'regular', 'Aiden Lee', 'aiden.lee@example.com', '09213456789', 'Interested in braces consultation', '2024-12-04', '3:30 pm', 'Braces Consultation', 'Bayani Road, Taguig City', 'completed', '2024-11-13 17:25:00'),
('walk-in', 'DOCMS63', 'SHCBY29', 'walk-in', 'Amelia Martinez', 'amelia.martinez@example.com', '09154567890', 'Seeking teeth whitening', '2024-12-07', '5:30 pm', 'Teeth Whitening', 'Bayani Road, Taguig City', 'request', '2024-11-10 13:50:00'),
('SHCVE64TCU', 'DOCMC09', 'SHCCB51', 'new', 'Chloe Garcia', 'chloe.garcia@example.com', '09212345678', 'I need a dental filling', '2024-11-23', '4:00 pm', 'Dental Filling', 'Bayani Road, Taguig City', 'accepted', '2024-11-12 13:28:12'),
('walk-in', 'DOCFA56', 'SHCCM17', 'walk-in', 'Grace Lee', 'grace.lee@example.com', '09214567890', 'I want to inquire about routine check-ups', '2024-11-19', '7:00 pm', 'Routine Check-up', 'Bayani Road, Taguig City', 'completed', '2024-11-02 10:14:33'),
('walk-in', 'DOCKP21', 'SHCDE23', 'walk-in', 'Sophia Taylor', 'sophia.taylor@example.com', '09256789012', 'I need a dental implant consultation', '2024-11-23', '1:00 pm', 'Dental Implants', 'Bayani Road, Taguig City', 'rejected', '2024-11-18 14:25:40'),
('walk-in', 'DOCTQ85', 'SHCEX53', 'walk-in', 'Charlotte Brown', 'charlotte.brown@example.com', '09172345678', 'Interested in routine checkup', '2024-12-09', '9:00 am', 'Routine Check-up', 'Bayani Road, Taguig City', 'accepted', '2024-11-08 11:25:00'),
('SHCZR98TCU', 'DOCMK39', 'SHCEX64', 'regular', 'Samantha Wilson', 'samantha.wilson@example.com', '09174561234', 'Looking for braces consultation', '2024-11-25', '1:00 pm', 'Braces Consultation', 'Bayani Road, Taguig City', 'rejected', '2024-11-02 18:45:27'),
('walk-in', 'DOCBV90', 'SHCFR63', 'walk-in', 'Zoe Adams', 'zoe.adams@example.com', '09234567890', 'Looking for routine checkup', '2024-11-20', '3:00 pm', 'Routine Check-up', 'Bayani Road, Taguig City', 'accepted', '2024-11-05 13:20:47'),
('SHCJS90TCU', 'DOCNJ76', 'SHCFT55', 'regular', 'William Harris', 'william.harris@example.com', '09182345678', 'Looking for a routine checkup', '2024-11-24', '3:00 pm', 'Routine Check-up', 'Bayani Road, Taguig City', 'completed', '2024-11-22 09:01:22'),
('walk-in', 'DOCXM88', 'SHCJF13', 'walk-in', 'Megan Harris', 'megan.harris@example.com', '09121234567', 'Looking for a root canal consultation', '2024-11-25', '12:00 pm', 'Root Canal Treatment', 'Bayani Road, Taguig City', 'rejected', '2024-11-10 18:01:06'),
('SHCPE94TCU', 'DOCAF82', 'SHCJV77', 'new', 'Grace Allen', 'grace.allen@example.com', '09185678901', 'Interested in routine checkup', '2024-11-22', '10:00 am', 'Routine Check-up', 'Bayani Road, Taguig City', 'request', '2024-11-17 08:13:33'),
('walk-in', 'DOCQT72', 'SHCJX52', 'walk-in', 'Mia Carter', 'mia.carter@example.com', '09162234567', 'Looking for tooth extraction', '2024-12-13', '1:30 pm', 'Tooth Extraction', 'Bayani Road, Taguig City', 'accepted', '2024-11-04 12:45:00'),
('SHCQM20TCU', 'DOCSD01', 'SHCJX95', 'new', 'Matthew Wilson', 'matthew.wilson@example.com', '09237890123', 'I want to have a dental filling', '2024-11-21', '9:00 am', 'Dental Filling', 'Bayani Road, Taguig City', 'request', '2024-10-25 13:45:48'),
('SHCDJ72TCU', 'DOCHT53', 'SHCND92', 'new', 'Oliver Wright', 'oliver.wright@example.com', '09171234567', 'Seeking consultation for dental implants', '2024-11-22', '7:00 pm', 'Dental Implants', 'Bayani Road, Taguig City', 'request', '2024-11-09 14:24:57'),
('SHCMZ34TCU', 'DOCPQ11', 'SHCNY48', 'new', 'Lucas White', 'lucas.white@example.com', '09161234567', 'I need a dental filling', '2024-12-06', '4:00 pm', 'Dental Filling', 'Bayani Road, Taguig City', 'rejected', '2024-11-11 16:15:00'),
('SHCFM91TCU', 'DOCDR25', 'SHCNY83', 'regular', 'Jackie Adams', 'jackie.adams@example.com', '09176543921', 'I need a braces consultation', '2024-12-20', '1:30 pm', 'Braces Consultation', 'Bayani Road, Taguig City', 'completed', '2024-10-28 17:10:00'),
('SHCCM15TCU', 'DOCJW55', 'SHCNZ80', 'regular', 'Zoe Thompson', 'zoe.thompson@example.com', '09161234567', 'Looking for a root canal treatment', '2024-11-25', '7:00 pm', 'Root Canal Treatment', 'Bayani Road, Taguig City', 'completed', '2024-11-14 16:09:43'),
('walk-in', 'DOCQS81', 'SHCPI17', 'walk-in', 'James Wilson', 'james.wilson@example.com', '09123456789', 'Interested in teeth whitening', '2024-11-24', '9:00 am', 'Teeth Whitening', 'Bayani Road, Taguig City', 'request', '2024-11-13 11:45:30'),
('SHCYK87TCU', 'DOCXZ49', 'SHCPL39', 'regular', 'Liam Davis', 'liam.davis@example.com', '09215678901', 'Looking for root canal treatment', '2024-12-08', '6:00 pm', 'Root Canal Treatment', 'Bayani Road, Taguig City', 'completed', '2024-11-09 15:45:00'),
('SHCJT70TCU', 'DOCGH92', 'SHCPL64', 'new', 'Samantha Evans', 'samantha.evans@example.com', '09155678901', 'I want to inquire about braces', '2024-11-23', '11:00 am', 'Braces Consultation', 'Bayani Road, Taguig City', 'request', '2024-10-30 16:13:54'),
('SHCWB64TCU', 'DOCHS07', 'SHCPL92', 'new', 'James Moore', 'james.moore@example.com', '09189987654', 'Looking for dental implants consultation', '2024-11-20', '5:30 pm', 'Dental Implants', 'Bayani Road, Taguig City', 'request', '2024-11-04 13:22:34'),
('SHCXY94TCU', 'DOCQR12', 'SHCPZ88', 'new', 'Mia Clark', 'mia.clark@example.com', '09166789012', 'Interested in teeth whitening', '2024-11-23', '9:00 am', 'Teeth Whitening', 'Bayani Road, Taguig City', 'rejected', '2024-11-06 08:10:58'),
('SHCZN12TCU', 'DOCCM28', 'SHCQL85', 'regular', 'Noah Miller', 'noah.miller@example.com', '09161234567', 'Seeking advice for a root canal treatment', '2024-11-24', '2:30 pm', 'Root Canal Treatment', 'Bayani Road, Taguig City', 'completed', '2024-10-29 18:22:06'),
('SHCBN54TCU', 'DOCLB73', 'SHCQR11', 'new', 'Ava Roberts', 'ava.roberts@example.com', '09174567890', 'Looking to consult for braces', '2024-11-19', '11:00 am', 'Braces Consultation', 'Bayani Road, Taguig City', 'accepted', '2024-11-20 17:04:56'),
('SHCVD56TCU', 'DOCJK45', 'SHCQS79', 'regular', 'Amelia White', 'amelia.white@example.com', '09182345678', 'Looking for a dental filling', '2024-11-25', '2:00 pm', 'Dental Filling', 'Bayani Road, Taguig City', 'request', '2024-11-10 16:42:05'),
('SHCNR81TCU', 'DOCAG43', 'SHCQT14', 'new', 'Lucas Harris', 'lucas.harris@example.com', '09123456789', 'For a dental cleaning session', '2024-11-21', '2:00 pm', 'Teeth Cleaning', 'Bayani Road, Taguig City', 'rejected', '2024-11-01 12:58:12'),
('SHCNP93TCU', 'DOCKJ38', 'SHCRB07', 'regular', 'Emily Foster', 'emily.foster@example.com', '09126789012', 'Routine checkup for dental care', '2024-11-23', '5:00 pm', 'Routine Check-up', 'Bayani Road, Taguig City', 'accepted', '2024-10-26 12:03:17'),
('SHCVM18TCU', 'DOCTN59', 'SHCRB29', 'new', 'Harper Morgan', 'harper.morgan@example.com', '09191238901', 'Interested in root canal consultation', '2024-12-18', '10:30 am', 'Root Canal Treatment', 'Bayani Road, Taguig City', 'request', '2024-10-30 13:30:00'),
('walk-in', 'DOCNM45', 'SHCRL64', 'walk-in', 'Ella Rodriguez', 'ella.rodriguez@example.com', '09173456981', 'I need a teeth cleaning appointment', '2024-12-11', '10:30 am', 'Teeth Cleaning', 'Bayani Road, Taguig City', 'request', '2024-11-06 14:05:00'),
('SHCJF41TCU', 'DOCRS98', 'SHCRP31', 'new', 'Evelyn Evans', 'evelyn.evans@example.com', '09175678901', 'Seeking dental filling', '2024-12-14', '2:30 pm', 'Dental Filling', 'Bayani Road, Taguig City', 'rejected', '2024-11-03 17:55:00'),
('walk-in', 'DOCNX94', 'SHCRV94', 'walk-in', 'Lily Anderson', 'lily.anderson@example.com', '09187654321', 'Need a dental cleaning appointment', '2024-11-21', '2:00 pm', 'Teeth Cleaning', 'Bayani Road, Taguig City', 'request', '2024-11-05 15:07:52'),
('walk-in', 'DOCNB84', 'SHCRY71', 'walk-in', 'Noah Harris', 'noah.harris@example.com', '09162345678', 'I need a routine checkup', '2024-11-19', '9:00 am', 'Routine Check-up', 'Bayani Road, Taguig City', 'accepted', '2024-11-08 16:56:31'),
('SHCBN93TCU', 'DOCQV77', 'SHCRZ73', 'regular', 'Scarlett Young', 'scarlett.young@example.com', '09194561234', 'Looking for a braces consultation', '2024-12-16', '4:00 pm', 'Braces Consultation', 'Bayani Road, Taguig City', 'completed', '2024-11-01 16:50:00'),
('walk-in', 'DOCQW16', 'SHCTU47', 'walk-in', 'Maya Parker', 'maya.parker@example.com', '09165789012', 'Want a routine checkup', '2024-11-22', '3:00 pm', 'Routine Check-up', 'Bayani Road, Taguig City', 'completed', '2024-11-03 11:04:59'),
('SHCVP16TCU', 'DOCZR33', 'SHCTY84', 'regular', 'Mason Allen', 'mason.allen@example.com', '09182345678', 'I would like a root canal treatment', '2024-12-12', '11:00 am', 'Root Canal Treatment', 'Bayani Road, Taguig City', 'completed', '2024-11-05 15:15:00'),
('SHCAG23TCU', 'DOCMD67', 'SHCUI53', 'new', 'Olivia Davis', 'olivia.davis@example.com', '09215678901', 'I need braces consultation', '2024-11-22', '4:00 pm', 'Braces Consultation', 'Bayani Road, Taguig City', 'request', '2024-11-08 11:21:48'),
('SHCWB38TCU', 'DOCPX94', 'SHCUM61', 'walk-in', 'Lucas Martinez', 'lucas.martinez@example.com', '09234567890', 'I would like a teeth cleaning', '2024-11-21', '2:00 am', 'Teeth Cleaning', 'Bayani Road, Taguig City', 'request', '2024-11-21 14:32:11'),
('walk-in', 'DOCMB25', 'SHCUP42', 'walk-in', 'Henry Walker', 'henry.walker@example.com', '09186789012', 'Interested in teeth whitening', '2024-12-15', '3:30 pm', 'Teeth Whitening', 'Bayani Road, Taguig City', 'request', '2024-11-02 10:20:00'),
('SHCFM15TCU', 'DOCJT53', 'SHCUP77', 'new', 'Liam Walker', 'liam.walker@example.com', '09185678901', 'I need a tooth extraction', '2024-11-21', '8:00 am', 'Tooth Extraction', 'Bayani Road, Taguig City', 'request', '2024-11-04 14:42:59'),
('SHCZS43TCU', 'DOCNB41', 'SHCUQ68', 'regular', 'Lily Robinson', 'lily.robinson@example.com', '09164567890', 'Inquiring about a tooth extraction', '2024-11-22', '2:00 pm', 'Tooth Extraction', 'Bayani Road, Taguig City', 'completed', '2024-10-24 09:26:59'),
('SHCWL95TCU', 'DOCQP21', 'SHCUR34', 'new', 'James Thompson', 'james.thompson@example.com', '09187654321', 'Looking for braces consultation', '2024-12-10', '8:00 am', 'Braces Consultation', 'Bayani Road, Taguig City', 'request', '2024-11-07 09:30:00'),
('SHCJF23TCU', 'DOCDX31', 'SHCUV15', 'new', 'Ethan Taylor', 'ethan.taylor@example.com', '09185678901', 'I need a routine checkup', '2024-12-02', '11:30 am', 'Routine Check-up', 'Bayani Road, Taguig City', 'accepted', '2024-11-15 14:55:00'),
('walk-in', 'DOCQW67', 'SHCUV81', 'walk-in', 'Carlos Martinez', 'carlos.martinez@example.com', '09193456789', 'I need a root canal treatment', '2024-11-20', '1:00 pm', 'Root Canal Treatment', 'Bayani Road, Taguig City', 'accepted', '2024-11-09 17:58:33'),
('walk-in', 'DOCRN78', 'SHCUX45', 'walk-in', 'Olivia Harris', 'olivia.harris@example.com', '09173456789', 'I would like a tooth extraction', '2024-12-05', '2:00 pm', 'Tooth Extraction', 'Bayani Road, Taguig City', 'accepted', '2024-11-12 10:40:00'),
('walk-in', 'DOCWK45', 'SHCUY22', 'walk-in', 'Emma Garcia', 'emma.garcia@example.com', '09191234567', 'Looking for dental implants', '2024-12-03', '1:00 pm', 'Dental Implants', 'Bayani Road, Taguig City', 'request', '2024-11-14 12:10:00'),
('SHCKQ81TCU', 'DOCTF22', 'SHCVE56', 'regular', 'Liam Roberts', 'liam.roberts@example.com', '09164567890', 'For a tooth extraction consultation', '2024-11-23', '8:00 pm', 'Tooth Extraction', 'Bayani Road, Taguig City', 'accepted', '2024-11-06 12:11:09'),
('walk-in', 'DOCRK81', 'SHCVL67', 'walk-in', 'Sophia King', 'sophia.king@example.com', '09182347890', 'Seeking dental implant consultation', '2024-12-19', '11:30 am', 'Dental Implants', 'Bayani Road, Taguig City', 'accepted', '2024-10-29 15:45:00'),
('SHCUM61TCU', 'DOCAF29', 'SHCWA12', 'new', 'Zara Brown', 'zara.brown@example.com', '09223456789', 'Looking for a consultation on dental implants', '2024-11-20', '3:30 pm', 'Dental Implants', 'Bayani Road, Taguig City', 'request', '2024-10-28 10:54:32'),
('SHCNP48TCU', 'DOCXJ32', 'SHCWB21', 'regular', 'Ethan Johnson', 'ethan.johnson@example.com', '09154567890', 'Teeth cleaning, please', '2024-11-19', '11:00 am', 'Teeth Cleaning', 'Bayani Road, Taguig City', 'completed', '2024-11-07 15:36:12'),
('SHCDB38TCU', 'DOCEG32', 'SHCWF12', 'new', 'Sophia Brown', 'sophia.brown@example.com', '09231234567', 'Interested in teeth whitening', '2024-11-22', '10:00 am', 'Teeth Whitening', 'Bayani Road, Taguig City', 'accepted', '2024-11-11 09:01:23'),
('SHCPM72TCU', 'DOCXY56', 'SHCWL53', 'regular', 'Mason Lee', 'mason.lee@example.com', '09184567890', 'For a teeth cleaning appointment', '2024-11-20', '10:30 am', 'Teeth Cleaning', 'Bayani Road, Taguig City', 'completed', '2024-11-11 09:35:17'),
('SHCZX39TCU', 'DOCSD84', 'SHCWR02', 'regular', 'Benjamin King', 'benjamin.king@example.com', '09178965432', 'For a dental implant consultation', '2024-11-24', '12:00 pm', 'Dental Implants', 'Bayani Road, Taguig City', 'accepted', '2024-11-03 17:58:45'),
('walk-in', 'DOCLC73', 'SHCXP54', 'walk-in', 'Henry Davis', 'henry.davis@example.com', '09184561234', 'Need a teeth whitening session', '2024-11-22', '1:00 pm', 'Teeth Whitening', 'Bayani Road, Taguig City', 'rejected', '2024-10-27 14:11:09'),
('walk-in', 'DOCLB82', 'SHCXR94', 'walk-in', 'Ella Perez', 'ella.perez@example.com', '09173451234', 'Looking for teeth cleaning', '2024-12-17', '9:30 am', 'Teeth Cleaning', 'Bayani Road, Taguig City', 'request', '2024-10-31 11:10:00'),
('walk-in', 'DOCAB12', 'SHCXY10', 'walk-in', 'Sophia Wilson', 'sophia.wilson@example.com', '09123456789', 'Interested in teeth cleaning', '2024-12-01', '10:00 am', 'Teeth Cleaning', 'Bayani Road, Taguig City', 'request', '2024-11-16 09:20:00'),
('SHCFA32TCU', 'DOCAZ15', 'SHCXY19', 'new', 'Isabella Turner', 'isabella.turner@example.com', '09153456789', 'I need a dental filling', '2024-11-23', '8:00 am', 'Dental Filling', 'Bayani Road, Taguig City', 'request', '2024-11-23 07:12:08'),
('walk-in', 'DOCBX39', 'SHCZN84', 'walk-in', 'James Davis', 'james.davis@example.com', '09256789012', 'Looking for tooth extraction', '2024-11-22', '10:00 am', 'Tooth Extraction', 'Bayani Road, Taguig City', 'accepted', '2024-10-31 09:47:21'),
('walk-in', 'DOCAB54', 'SHCZY71', 'walk-in', 'John Doe', 'john.doe@example.com', '09171234567', 'I would like a routine checkup', '2024-11-20', '9:00 pm', 'Routine Check-up', 'Bayani Road, Taguig City', 'request', '2024-11-12 14:23:47'),
('walk-in', 'DOCRF31', 'SHCZY87', 'walk-in', 'Benjamin Scott', 'benjamin.scott@example.com', '09213456789', 'I want to have a tooth extraction', '2024-11-21', '5:00 pm', 'Tooth Extraction', 'Bayani Road, Taguig City', 'accepted', '2024-11-16 10:22:57');

-- --------------------------------------------------------

--
-- Table structure for table `appointment_dates`
--

CREATE TABLE `appointment_dates` (
  `id` int(11) NOT NULL,
  `available_dates` date NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment_dates`
--

INSERT INTO `appointment_dates` (`id`, `available_dates`, `created_at`) VALUES
(2, '2024-11-19', '2024-11-12 23:32:17'),
(4, '2024-11-21', '2024-11-12 23:32:17'),
(5, '2024-11-27', '2024-11-12 23:32:17'),
(6, '2024-11-26', '2024-11-12 23:32:17'),
(9, '2024-11-19', '2024-11-12 23:45:23'),
(10, '2024-11-20', '2024-11-12 23:45:23'),
(11, '2024-12-10', '2024-11-12 23:45:23'),
(12, '2024-12-11', '2024-11-12 23:45:23'),
(13, '2024-12-18', '2024-11-12 23:45:23'),
(14, '2024-12-17', '2024-11-12 23:45:23'),
(15, '2024-12-26', '2024-11-12 23:45:23'),
(16, '2024-12-19', '2024-11-12 23:45:23'),
(17, '2024-12-20', '2024-11-12 23:45:23'),
(18, '2024-12-27', '2024-11-12 23:45:23'),
(22, '2024-11-22', '2024-11-15 11:48:34'),
(23, '2024-11-23', '2024-11-15 11:48:34'),
(24, '2024-11-28', '2024-11-15 11:48:34'),
(25, '2024-11-29', '2024-11-15 11:48:34'),
(26, '2024-12-09', '2024-11-15 11:48:34'),
(27, '2024-12-16', '2024-11-15 11:48:34'),
(28, '2024-12-12', '2024-11-15 11:48:34'),
(30, '2024-11-25', '2024-11-15 23:25:21'),
(31, '2024-12-03', '2024-11-15 23:25:21'),
(32, '2024-12-04', '2024-11-15 23:25:21'),
(33, '2024-12-05', '2024-11-15 23:25:21'),
(34, '2024-12-06', '2024-11-15 23:25:21'),
(35, '2024-12-13', '2024-11-15 23:25:21'),
(36, '2024-12-23', '2024-11-15 23:25:21'),
(37, '2024-12-24', '2024-11-15 23:25:21'),
(38, '2024-12-25', '2024-11-15 23:25:21'),
(39, '2024-12-30', '2024-11-15 23:25:21'),
(40, '2024-12-31', '2024-11-15 23:25:21'),
(41, '2025-01-01', '2024-11-15 23:25:21'),
(42, '2025-01-02', '2024-11-15 23:25:21'),
(43, '2025-01-03', '2024-11-15 23:25:21'),
(44, '2025-01-06', '2024-11-15 23:25:21'),
(45, '2025-01-08', '2024-11-15 23:25:21'),
(46, '2025-01-09', '2024-11-15 23:25:21'),
(47, '2025-01-10', '2024-11-15 23:25:21'),
(48, '2025-01-13', '2024-11-15 23:25:21'),
(49, '2025-01-14', '2024-11-15 23:25:21'),
(50, '2025-01-15', '2024-11-15 23:25:21'),
(51, '2025-01-16', '2024-11-15 23:25:21'),
(52, '2025-01-17', '2024-11-15 23:25:21'),
(53, '2025-01-20', '2024-11-15 23:25:21'),
(54, '2025-01-21', '2024-11-15 23:25:21'),
(55, '2025-01-22', '2024-11-15 23:25:21'),
(56, '2025-01-23', '2024-11-15 23:25:21'),
(57, '2025-01-24', '2024-11-15 23:25:21'),
(58, '2025-01-27', '2024-11-15 23:25:21'),
(59, '2025-01-28', '2024-11-15 23:25:21'),
(60, '2025-01-29', '2024-11-15 23:25:21'),
(61, '2025-01-30', '2024-11-15 23:25:21'),
(62, '2025-02-03', '2024-11-15 23:25:21'),
(63, '2025-02-04', '2024-11-15 23:25:21'),
(64, '2025-02-05', '2024-11-15 23:25:21'),
(65, '2025-02-06', '2024-11-15 23:25:21'),
(66, '2025-02-07', '2024-11-15 23:25:21'),
(67, '2025-02-10', '2024-11-15 23:25:21'),
(68, '2025-02-11', '2024-11-15 23:25:21'),
(69, '2025-02-12', '2024-11-15 23:25:21'),
(70, '2025-02-13', '2024-11-15 23:25:21'),
(71, '2025-02-14', '2024-11-15 23:25:21'),
(72, '2025-02-17', '2024-11-15 23:25:21'),
(73, '2025-02-18', '2024-11-15 23:25:21'),
(74, '2025-02-19', '2024-11-15 23:25:21'),
(75, '2025-02-20', '2024-11-15 23:25:21'),
(76, '2025-02-21', '2024-11-15 23:25:21'),
(77, '2025-02-24', '2024-11-15 23:25:21'),
(78, '2025-02-25', '2024-11-15 23:25:21'),
(79, '2025-02-26', '2024-11-15 23:25:21'),
(80, '2025-02-27', '2024-11-15 23:25:21'),
(81, '2025-02-28', '2024-11-15 23:25:21'),
(82, '2025-01-07', '2024-11-15 23:25:21'),
(83, '2025-01-31', '2024-11-15 23:25:21'),
(84, '2024-12-02', '2024-11-15 23:25:21');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `doctor_id` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`doctor_id`, `first_name`, `last_name`, `phone_number`, `email`, `created_at`) VALUES
('DOC6e30', 'Leon', 'Manansala', '09784541254', 'LeonM@gmail.com', '2024-11-16 09:38:10'),
('DOCcab8', 'April', 'Gonzales', '09332244634', 'DocAprilG@gmail.com', '2024-10-12 06:38:18'),
('DOCdc43', 'Pablo', 'Escobar', '09454741547', 'Pab@gmail.com', '2024-10-11 05:15:49'),
('DOCe86d', 'Louise', 'Manzano', '09987873454', 'DocLMan@gmail.com', '2024-10-13 07:46:58');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `doctor_id` varchar(100) DEFAULT NULL,
  `name` varchar(299) NOT NULL,
  `email` varchar(299) NOT NULL,
  `feedback` text NOT NULL,
  `rating` enum('1','2','3','4','5') NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `user_id`, `doctor_id`, `name`, `email`, `feedback`, `rating`, `created_at`) VALUES
(4, 'SHC9d72TCU', NULL, 'John Paul Dela Cruz', 'jpvillaruel02@gmail.com', 'testing to\r\n', '4', '2024-10-12 16:08:51'),
(5, 'SHC786fTCU', NULL, 'Cj dela cruz', 'lems.christianjakedelacruz@gmail.com', 'Great Services', '5', '2024-10-13 15:40:33'),
(6, 'SHC0141TCU', NULL, 'Dave pesco', 'pdavemarc@gmail.com', 'good ', '5', '2024-10-14 10:26:19'),
(7, 'SHC1677TCU', NULL, 'John Paul Villaruel Dela Cruz ', 'jpvillaruel02@gmail.com', 'greate service', '5', '2024-10-17 17:05:04'),
(8, 'SHC1677TCU', NULL, 'John Paul Villaruel Dela Cruz ', 'jpvillaruel02@gmail.com', '', '4', '2024-10-17 21:38:20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` varchar(100) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `suffix` varchar(100) NOT NULL,
  `birthdate` date NOT NULL,
  `gender` set('male','female') DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(11) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `pass` varchar(255) NOT NULL,
  `label` varchar(100) NOT NULL,
  `account_activation_hash` varchar(64) DEFAULT NULL,
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `middle_name`, `last_name`, `suffix`, `birthdate`, `gender`, `email`, `contact`, `address`, `pass`, `label`, `account_activation_hash`, `reset_token_hash`, `reset_token_expires_at`, `created_at`) VALUES
('SHC1677TCU', 'John Paul', 'Villaruel', 'Dela Cruz', '', '2002-02-18', 'male', 'jpvillaruel02@gmail.com', '09070050140', '10 everlasting st. taguig city', '$2y$10$bgT9YeRs9fMfn68ccVcldulrpTa7hFg8FnLiVfIsMl1u47Urj9AHu', 'new', NULL, NULL, NULL, '2024-10-23 03:46:57'),
('SHCA1B2CTCU', 'Sophia', 'L.', 'Wilson', '', '1990-07-15', 'female', 'sophia.wilson@example.com', '09191234567', '456 Maple St, Taguig City', 'password123', 'new', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCAG12TCU', 'Jane', 'Marie', 'Smith', '', '1995-08-20', 'female', 'jane.smith@example.com', '09181234567', '56 Oak Road, Makati, Philippines', 'hashedpassword456', 'regular', NULL, '0e4e415b13549ee5e5f6dbff983c08e16233f727e96244a48913cd5089d15b01', '2024-11-19 09:08:28', '2024-11-19 09:15:34'),
('SHCAY99TCU', 'Henry', 'Isaac', 'Clark', '', '1990-01-17', 'male', 'henry.clark@example.com', '09161234567', '888 Birch Lane, Manila, Philippines', '$2y$12$rCSTmDp62DrE0E9j8N8RBeGBCvMWhmsqDciZ3VugivAcpVspO0zTS', 'new', NULL, NULL, NULL, '2024-11-19 09:13:18'),
('SHCB2C3DTCU', 'Liam', '', 'Taylor', '', '1991-09-12', 'male', 'liam.taylor@example.com', '09193456789', '789 Pine St, Taguig City', 'password456', 'regular', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCBE87TCU', 'Jacob', 'Samuel', 'Scott', '', '1995-09-14', 'male', 'jacob.scott@example.com', '09201234567', '78 Cedar Avenue, Mandaluyong, Philippines', 'hashedpassword616', 'new', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCBX89TCU', 'John', 'Michael', 'Doe', 'Jr.', '1990-05-15', 'male', 'john.doe@example.com', '09171234567', '1234 Elm Street, Quezon City, Philippines', 'hashedpassword123', 'new', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCC3D4ETCU', 'Olivia', 'A.', 'Garcia', '', '1993-03-22', 'female', 'olivia.garcia@example.com', '09195678901', '123 Oak St, Taguig City', 'password789', 'new', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCD4E5FTCU', 'Noah', 'T.', 'Harris', '', '1987-10-05', 'male', 'noah.harris@example.com', '09197890123', '654 Birch St, Taguig City', 'password101', 'regular', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCDB04TCU', 'Matthew', 'Jacob', 'Martinez', '', '1999-04-16', 'male', 'matthew.martinez@example.com', '09184920234', '567 Birch Lane, Pasig, Philippines', 'hashedpassword808', 'new', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCDP90TCU', 'Ethan', 'Jacob', 'Mitchell', '', '2001-08-30', 'male', 'ethan.mitchell@example.com', '09123456789', '64 Birch Road, Taguig, Philippines', 'hashedpassword626', 'new', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCDR57TCU', 'Carlos', 'Eduardo', 'Lopez', '', '1987-03-25', 'male', 'carlos.lopez@example.com', '09221234567', '789 Pine Avenue, Pasig, Philippines', 'hashedpassword789', 'new', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCE5F6GTCU', 'Emma', '', 'Martinez', 'Jr.', '1995-05-10', 'female', 'emma.martinez@example.com', '09192347890', '321 Main St, Taguig City', 'password202', 'new', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCF6G7HTCU', 'James', 'L.', 'Lee', '', '1992-02-28', 'male', 'james.lee@example.com', '09194561234', '432 Elm St, Taguig City', 'password303', 'regular', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCFN29TCU', 'Eli', 'Maxwell', 'Foster', '', '1990-05-28', 'male', 'eli.foster@example.com', '09215554321', '345 Pine Road, Manila, Philippines', 'hashedpassword737', 'regular', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCFN34TCU', 'Maria', 'Lucia', 'Garcia', '', '1992-07-10', 'female', 'maria.garcia@example.com', '09321234567', '12 Maple Street, Taguig, Philippines', 'hashedpassword101', 'regular', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCFT63TCU', 'Henry', 'Leo', 'Hughes', '', '1995-01-04', 'male', 'henry.hughes@example.com', '09197654321', '111 Pine Street, Pasig, Philippines', 'hashedpassword525', 'regular', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCFU30TCU', 'William', 'Lucas', 'Young', '', '1993-07-22', 'male', 'william.young@example.com', '09174856321', '302 Pine Avenue, Cebu, Philippines', 'hashedpassword414', 'new', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCG7H8ITCU', 'Amelia', 'D.', 'Brown', '', '1990-06-18', 'female', 'amelia.brown@example.com', '09195671234', '213 Pine St, Taguig City', 'password404', 'new', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCGA03TCU', 'Benjamin', 'David', 'Evans', '', '1991-08-29', 'male', 'benjamin.evans@example.com', '09199876543', '650 Birch Road, Taguig, Philippines', 'hashedpassword545', 'regular', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCGX15TCU', 'Ella', 'Madeline', 'King', '', '2000-02-12', 'female', 'ella.king@example.com', '09183324567', '222 Birch Lane, Taguig, Philippines', 'hashedpassword515', 'regular', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCH8I9JTCU', 'Lucas', '', 'White', '', '1993-11-23', 'male', 'lucas.white@example.com', '09197892345', '654 Maple St, Taguig City', 'password505', 'regular', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCHJ48TCU', 'Samantha', 'Lily', 'Baker', '', '1993-05-05', 'female', 'samantha.baker@example.com', '09224657890', '67 Maple Street, Taguig, Philippines', 'hashedpassword222', 'new', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCI9J0KTCU', 'Isabella', '', 'Perez', '', '1991-01-12', 'female', 'isabella.perez@example.com', '09198904567', '876 Birch St, Taguig City', 'password606', 'new', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCIR45TCU', 'Maya', 'Victoria', 'Taylor', '', '1992-01-14', 'female', 'maya.taylor@example.com', '09152467890', '230 Birch Avenue, Taguig, Philippines', 'hashedpassword636', 'new', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCJ0K1LTCU', 'Ethan', 'C.', 'Adams', '', '1988-04-09', 'male', 'ethan.adams@example.com', '09194560123', '987 Elm St, Taguig City', 'password707', 'regular', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCJE43TCU', 'Daniel', 'Alberto', 'Martinez', 'Sr.', '1985-12-05', 'male', 'daniel.martinez@example.com', '09131567890', '34 Birch Lane, Mandaluyong, Philippines', 'hashedpassword202', 'new', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCJE58TCU', 'Sophia', 'Lilian', 'Roberts', '', '2000-03-13', 'female', 'sophia.roberts@example.com', '09185673245', '159 Maple Road, Quezon City, Philippines', 'hashedpassword040', 'new', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCJI71TCU', 'Zoe', 'Violet', 'Gonzalez', '', '1999-03-22', 'female', 'zoe.gonzalez@example.com', '09226789012', '543 Cedar Avenue, Cebu, Philippines', 'hashedpassword424', 'new', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCJX41TCU', 'Lucas', 'Oliver', 'Taylor', '', '1997-03-02', 'male', 'lucas.taylor@example.com', '09175345678', '253 Pine Street, Manila, Philippines', 'hashedpassword919', 'regular', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCK1L2MTCU', 'Mia', '', 'Carter', '', '1995-12-01', 'female', 'mia.carter@example.com', '09192347890', '432 Oak St, Taguig City', 'password808', 'new', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCKJ64TCU', 'Ava', 'Grace', 'Simmons', '', '1994-12-18', 'female', 'ava.simmons@example.com', '09231234567', '102 Birch Avenue, Quezon City, Philippines', 'hashedpassword828', 'new', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCKM22TCU', 'Elijah', 'Daniel', 'Perez', '', '1992-09-10', 'male', 'elijah.perez@example.com', '09165543210', '100 Oak Road, Mandaluyong, Philippines', 'hashedpassword323', 'regular', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCKT24TCU', 'Sophia', 'Zoe', 'Davis', '', '1996-06-17', 'female', 'sophia.davis@example.com', '09238912345', '89 Cedar Street, Quezon City, Philippines', 'hashedpassword727', 'regular', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCL2M3NTCU', 'Benjamin', 'K.', 'Davis', '', '1989-09-17', 'male', 'benjamin.davis@example.com', '09194563478', '123 Birch St, Taguig City', 'password909', 'regular', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCLD55TCU', 'Isabella', 'Sophia', 'Morris', '', '1994-10-30', 'female', 'isabella.morris@example.com', '09193456789', '19 Oak Road, Quezon City, Philippines', 'hashedpassword909', 'regular', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCLZ99TCU', 'Lily', 'Irene', 'Martinez', '', '1992-06-08', 'female', 'lily.martinez@example.com', '09189654321', '38 Maple Road, Makati, Philippines', 'hashedpassword929', 'regular', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCM3N4OTCU', 'Ella', '', 'Rodriguez', '', '1994-03-13', 'female', 'ella.rodriguez@example.com', '09197890134', '765 Maple St, Taguig City', 'password010', 'new', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCN4O5PTCU', 'Jack', 'P.', 'Morgan', '', '1992-07-20', 'male', 'jack.morgan@example.com', '09194567890', '987 Main St, Taguig City', 'password111', 'regular', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCNR57TCU', 'Isabella', 'Maya', 'Moore', '', '1995-07-02', 'female', 'isabella.moore@example.com', '09178901234', '532 Birch Road, Pasig, Philippines', 'hashedpassword333', 'regular', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCO5P6QTCU', 'Harper', '', 'King', '', '1987-06-09', 'female', 'harper.king@example.com', '09192345678', '543 Elm St, Taguig City', 'password212', 'new', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCQN83TCU', 'Jackson', 'Bryce', 'Thomas', '', '1996-09-22', 'male', 'jackson.thomas@example.com', '09156789012', '231 Cedar Avenue, Davao, Philippines', 'hashedpassword030', 'new', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCQR82TCU', 'Amelia', 'Sophia', 'Clark', '', '1996-04-06', 'female', 'amelia.clark@example.com', '09234567890', '330 Cedar Avenue, Makati, Philippines', 'hashedpassword646', 'new', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCRY67TCU', 'Amelia', 'Grace', 'Rodriguez', '', '2001-01-22', 'female', 'amelia.rodriguez@example.com', '09211234567', '45 Maple Avenue, Makati, Philippines', 'hashedpassword707', 'regular', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCTF82TCU', 'James', 'Alexander', 'White', '', '1991-06-14', 'male', 'james.white@example.com', '09212567890', '31 Pine Street, Makati, Philippines', 'hashedpassword010', 'new', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCUP60TCU', 'Liam', 'Eli', 'Scott', '', '1993-03-19', 'male', 'liam.scott@example.com', '09230123456', '409 Oak Avenue, Quezon City, Philippines', 'hashedpassword535', 'regular', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCUP76TCU', 'Benjamin', 'Charles', 'Nelson', '', '1992-04-19', 'male', 'benjamin.nelson@example.com', '09214567890', '134 Birch Lane, Makati, Philippines', 'hashedpassword818', 'new', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCVI12TCU', 'Oliver', 'Ethan', 'Hernandez', '', '1996-10-02', 'male', 'oliver.hernandez@example.com', '09146789012', '92 Birch Street, Mandaluyong, Philippines', 'hashedpassword141', 'regular', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCVO56TCU', 'Sophia', 'Charlotte', 'Lee', '', '1997-05-11', 'female', 'sophia.lee@example.com', '09213657890', '540 Maple Street, Pasig, Philippines', 'hashedpassword313', 'regular', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCVP28TCU', 'Sophia', 'Isabella', 'Brown', '', '1993-09-18', 'female', 'sophia.brown@example.com', '09142678901', '456 Cedar Road, Quezon City, Philippines', 'hashedpassword303', 'regular', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCWB15TCU', 'Lucas', 'Gabriel', 'Miller', '', '1997-06-09', 'male', 'lucas.miller@example.com', '09173456789', '120 Oak Road, Davao, Philippines', 'hashedpassword606', 'new', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCWI66TCU', 'Amos', 'Phillip', 'Williams', '', '1989-10-15', 'male', 'amos.williams@example.com', '09215678901', '401 Pine Lane, Mandaluyong, Philippines', 'hashedpassword232', 'new', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCWL53TCU', 'Charlotte', 'Evelyn', 'Adams', '', '1998-12-28', 'female', 'charlotte.adams@example.com', '09192034567', '389 Oak Road, Quezon City, Philippines', 'hashedpassword717', 'regular', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCWL79TCU', 'Emily', 'Nora', 'Evans', '', '1994-11-16', 'female', 'emily.evans@example.com', '09223456789', '180 Oak Road, Davao, Philippines', 'hashedpassword020', 'new', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCWL82TCU', 'James', 'Samuel', 'Walker', '', '1994-11-11', 'male', 'james.walker@example.com', '09165912345', '120 Maple Street, Cebu, Philippines', 'hashedpassword434', 'new', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCXP63TCU', 'Mia', 'Emma', 'Harris', '', '1996-08-24', 'female', 'mia.harris@example.com', '09181234567', '250 Cedar Avenue, Taguig, Philippines', 'hashedpassword111', 'regular', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCXP94TCU', 'Oliver', 'Quinn', 'Nelson', '', '1994-07-30', 'male', 'oliver.nelson@example.com', '09213456789', '812 Cedar Avenue, Pasig, Philippines', 'hashedpassword939', 'regular', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCXQ91TCU', 'Olivia', 'Chloe', 'Davis', 'III', '1998-02-28', 'female', 'olivia.davis@example.com', '09162345678', '789 Cedar Avenue, Cebu, Philippines', 'hashedpassword505', 'regular', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCYA51TCU', 'Chloe', 'Grace', 'Reed', '', '1999-02-28', 'female', 'chloe.reed@example.com', '09125678901', '87 Cedar Avenue, Cebu, Philippines', 'hashedpassword242', 'new', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCYF04TCU', 'Ethan', 'John', 'Collins', '', '1997-12-10', 'male', 'ethan.collins@example.com', '09254567890', '233 Oak Road, Pasig, Philippines', 'hashedpassword343', 'regular', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCZB11TCU', 'Charlotte', 'Bella', 'Garcia', '', '1997-04-25', 'female', 'charlotte.garcia@example.com', '09223456789', '53 Oak Street, Taguig, Philippines', 'hashedpassword131', 'regular', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCZG34TCU', 'Liam', 'Christopher', 'Green', '', '1996-07-25', 'male', 'liam.green@example.com', '09182534678', '25 Birch Avenue, Quezon City, Philippines', 'hashedpassword121', 'regular', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCZN21TCU', 'Ethan', 'Matthew', 'Wilson', '', '2000-11-05', 'male', 'ethan.wilson@example.com', '09151234567', '21 Pine Street, Manila, Philippines', 'hashedpassword404', 'new', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCZT66TCU', 'Lila', 'Emma', 'Morris', '', '1998-11-15', 'female', 'lila.morris@example.com', '09287654321', '454 Pine Street, Davao, Philippines', 'hashedpassword444', 'new', NULL, NULL, NULL, '2024-11-19 09:16:17'),
('SHCZT77TCU', 'Zara', 'Rose', 'Bennett', '', '1998-08-06', 'female', 'zara.bennett@example.com', '09175432109', '67 Oak Road, Makati, Philippines', 'hashedpassword838', 'new', NULL, NULL, NULL, '2024-11-15 14:43:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `appointment_dates`
--
ALTER TABLE `appointment_dates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`doctor_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `reset_token_hash` (`reset_token_hash`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `appointment_dates`
--
ALTER TABLE `appointment_dates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

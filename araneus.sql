-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 19, 2026 at 12:20 PM
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
-- Database: `araneus`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`id`, `course_id`, `title`, `description`, `due_date`, `created_at`) VALUES
(2, 8, 'Simple Calculator Program', 'Create a basic calculator that can perform addition, subtraction, multiplication, and division. Use functions and handle division by zero.', '2026-04-12', '2026-03-19 11:15:53'),
(3, 8, 'Number Guessing Game', 'Develop a number guessing game where the computer randomly selects a number and the user has to guess it. Provide hints like \"too high\" or \"too low\".', '2026-04-12', '2026-03-19 11:15:53'),
(4, 8, 'Student Grade Management System', 'Build a system to store and manage student grades using lists and dictionaries. Allow adding, updating, and displaying grades.', '2026-04-19', '2026-03-19 11:15:53'),
(5, 8, 'Personal Contact Manager', 'Create a contact manager that saves contacts to a file. Implement add, search, delete, and list all contacts.', '2026-04-19', '2026-03-19 11:15:53'),
(6, 8, 'Image as Array Manipulation', 'Use NumPy to load an image (as array) and perform manipulations like cropping, rotating, and color adjustments.', '2026-04-26', '2026-03-19 11:15:53'),
(7, 8, 'Statistical Analysis of Datasets', 'Perform statistical analysis (mean, median, mode, standard deviation) on a provided dataset using NumPy.', '2026-04-26', '2026-03-19 11:15:53'),
(8, 8, 'Sales Data Analysis', 'Analyze sales data from a CSV file using Pandas. Calculate total sales, best-selling products, and monthly trends.', '2026-05-03', '2026-03-19 11:15:53'),
(9, 8, 'Customer Data Cleaning Project', 'Clean a messy customer dataset: handle missing values, remove duplicates, standardize formats using Pandas.', '2026-05-03', '2026-03-19 11:15:53'),
(10, 8, 'Module 1 Project: Financial Data Analyzer', 'Build a CLI tool that analyzes stock market data: calculate moving averages, volatility metrics, and generate performance reports. Integrate NumPy and Pandas.', '2026-05-06', '2026-03-19 11:15:53'),
(11, 8, 'Simple Calculator GUI', 'Create a GUI calculator using Tkinter with buttons for digits and operations.', '2026-05-10', '2026-03-19 11:15:53'),
(12, 8, 'Text Editor Application', 'Build a basic text editor with open, save, edit, and find/replace functionality using Tkinter.', '2026-05-10', '2026-03-19 11:15:53'),
(13, 8, 'File Explorer Interface', 'Develop a file explorer GUI that displays files and folders, allows navigation, and shows file properties.', '2026-05-17', '2026-03-19 11:15:53'),
(14, 8, 'Student Database Management System', 'Create a GUI application to manage student records with add, edit, delete, and search using Tkinter and file storage.', '2026-05-17', '2026-03-19 11:15:53'),
(15, 8, 'Interactive Drawing Application', 'Build a simple drawing app with Pygame where users can draw with the mouse and choose colors.', '2026-05-24', '2026-03-19 11:15:53'),
(16, 8, 'Animated Character Movement', 'Create an animated character that moves with arrow keys and has walking animation using Pygame sprites.', '2026-05-24', '2026-03-19 11:15:53'),
(17, 8, 'Ball Collision Simulation', 'Simulate bouncing balls with collision detection between balls and walls using Pygame.', '2026-05-31', '2026-03-19 11:15:53'),
(18, 8, 'Complete Arcade-Style Game', 'Develop a complete arcade game (e.g., space invaders, platformer) with levels, scoring, and game over conditions.', '2026-05-31', '2026-03-19 11:15:53'),
(19, 8, 'Module 2 Project: Personal Productivity Suite', 'Integrated desktop application with multiple tools: todo list, note-taking, Pomodoro timer. Optional: simple arcade game.', '2026-06-03', '2026-03-19 11:15:53'),
(20, 8, 'Library Management Database', 'Design and implement SQL tables for a library. Write queries to manage books, members, and transactions.', '2026-06-07', '2026-03-19 11:15:53'),
(21, 8, 'Complex Business Analytics Queries', 'Write advanced SQL queries involving JOINs, GROUP BY, subqueries on a sample business database.', '2026-06-07', '2026-03-19 11:15:53'),
(22, 8, 'Customer Management System with SQL', 'Build a Python CLI application that uses SQLite to manage customer data with CRUD operations.', '2026-06-14', '2026-03-19 11:15:53'),
(23, 8, 'E-commerce Database with Python Interface', 'Create an e-commerce database and a Python interface to handle products, orders, and customers using SQLAlchemy or sqlite3.', '2026-06-14', '2026-03-19 11:15:53'),
(24, 8, 'Sales Trend Visualization', 'Use Matplotlib to visualize sales trends from a dataset: line plots, bar charts, and subplots.', '2026-06-21', '2026-03-19 11:15:53'),
(25, 8, 'Customer Demographic Analysis', 'Create statistical visualizations (histograms, box plots, heatmaps) with Seaborn to analyze customer demographics.', '2026-06-21', '2026-03-19 11:15:53'),
(26, 8, 'House Price Prediction Model', 'Build a linear regression model to predict house prices using scikit-learn. Perform train/test split and evaluate.', '2026-06-28', '2026-03-19 11:15:53'),
(27, 8, 'Customer Segmentation Project', 'Apply K-Means clustering to segment customers based on purchasing behavior. Visualize clusters.', '2026-06-28', '2026-03-19 11:15:53'),
(28, 8, 'Module 3 Project: Customer Analytics Platform', 'End-to-end data solution: extract data from SQL database, analyze with Python, build ML models, and present results in an interactive dashboard.', '2026-07-01', '2026-03-19 11:15:53'),
(29, 8, 'Final Project: Comprehensive Business Intelligence System', 'Complete desktop application with database backend, data processing modules, ML models for forecasting, and interactive dashboard. Must integrate all three modules.', '2026-07-15', '2026-03-19 11:15:53');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `hours` decimal(5,2) DEFAULT 1.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `student_id`, `course_id`, `date`, `hours`, `created_at`) VALUES
(1, 11, 8, '2026-03-19', 1.00, '2026-03-19 11:00:32');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `content` longtext NOT NULL,
  `author` varchar(100) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `status` enum('draft','published') DEFAULT 'published',
  `published_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `slug`, `excerpt`, `content`, `author`, `category`, `featured_image`, `status`, `published_date`, `created_at`, `updated_at`) VALUES
(1, 'The Future of Education Technology', 'future-of-education-technology', 'How emerging technologies are transforming the educational landscape and what institutions need to do to stay ahead.', '<p>Education technology has evolved significantly over the past decade...</p>', 'Dr. Ananya Roy', 'Education', NULL, 'published', '2023-08-15', '2026-01-03 08:17:13', '2026-01-03 08:17:13'),
(2, 'Implementing ERP Solutions for SMEs', 'implementing-erp-solutions-smes', 'A guide for small and medium enterprises looking to implement ERP systems without disrupting their operations.', '<p>Enterprise Resource Planning (ERP) systems are no longer just for large corporations...</p>', 'Sanjay Mehta', 'Business', NULL, 'published', '2023-09-05', '2026-01-03 08:17:13', '2026-01-03 08:17:13');

-- --------------------------------------------------------

--
-- Table structure for table `career_applications`
--

CREATE TABLE `career_applications` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `position` varchar(100) NOT NULL,
  `experience` varchar(20) NOT NULL,
  `resume_path` varchar(255) NOT NULL,
  `cover_letter` text DEFAULT NULL,
  `how_heard` varchar(50) DEFAULT NULL,
  `status` enum('new','reviewed','shortlisted','rejected') DEFAULT 'new',
  `application_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `enrollment_id` int(11) DEFAULT NULL,
  `certificate_id` varchar(50) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `course_name` varchar(150) NOT NULL,
  `issue_date` date NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `qr_code` varchar(255) DEFAULT NULL,
  `status` enum('active','expired','revoked') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `client_name` varchar(200) NOT NULL,
  `client_type` enum('individual','company') DEFAULT 'company',
  `contact_person` varchar(150) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT 'India',
  `gstin` varchar(15) DEFAULT NULL,
  `pan` varchar(10) DEFAULT NULL,
  `status` enum('active','inactive','lead') DEFAULT 'active',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_submissions`
--

CREATE TABLE `contact_submissions` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message` text NOT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('new','read','replied') DEFAULT 'new'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `mode` enum('Online','Offline','Hybrid','') NOT NULL,
  `fee` decimal(10,2) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `instructor` varchar(100) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `syllabus_file` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `program_format` varchar(100) DEFAULT NULL,
  `tools_provided` text DEFAULT NULL,
  `hardware_kit` text DEFAULT NULL,
  `certification_type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `description`, `duration`, `mode`, `fee`, `category`, `instructor`, `image_url`, `syllabus_file`, `is_active`, `created_at`, `program_format`, `tools_provided`, `hardware_kit`, `certification_type`) VALUES
(4, 'Web Development with Django & React', 'Full-stack web development course covering Django backend, React frontend, REST APIs, and deployment. Build complete web applications with database integration and modern UI/UX.', '80 Hours', 'Online', 11999.00, 'Web Development', 'Full Stack Developer', 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', NULL, 1, '2026-01-02 07:06:38', 'Live Online Sessions', 'Django, React, PostgreSQL, VS Code, Git', 'Not Required', 'Certificate of Completion'),
(5, 'Data Science & Machine Learning Bootcamp', 'Intensive bootcamp covering data analysis, visualization, statistical modeling, and machine learning algorithms. Hands-on projects with real datasets and industry case studies.', '100 Hours', 'Online', 17999.00, 'Data Science', 'Data Scientist', 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', NULL, 1, '2026-01-02 07:06:38', 'Weekend Batch', 'Python, Pandas, NumPy, Scikit-learn, TensorFlow, Jupyter', 'Not Required', 'Certificate with Project Portfolio'),
(6, 'Android App Development with Kotlin', 'Learn to build native Android applications using Kotlin. Covers UI design, database integration, API calls, and publishing to Play Store.', '60 Hours', 'Online', 9999.00, 'Mobile Development', 'Android Developer', 'https://images.unsplash.com/photo-1611224923853-80b023f02d71?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', NULL, 1, '2026-01-02 07:06:38', 'Self-paced with Mentorship', 'Android Studio, Kotlin, Firebase, Git', 'Optional Android Device', 'Certificate of Completion'),
(7, 'Cybersecurity Fundamentals', 'Introduction to cybersecurity concepts, network security, ethical hacking, and penetration testing. Hands-on labs with security tools and techniques.', '50 Hours', 'Online', 12999.00, 'Cybersecurity', 'Security Expert', 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', NULL, 1, '2026-01-02 07:06:38', 'Evening Batch', 'Kali Linux, Wireshark, Metasploit, VirtualBox', 'Not Required', 'Certificate of Completion'),
(8, 'Python Power: Complete 120-Hour Training Program', 'A comprehensive Python training program covering foundations, desktop applications, game development, data science, SQL integration, and machine learning. This hands-on course includes three major modules with practical projects, culminating in a Final Integrated Business Intelligence System project.', '120 Hours', 'Online', 14999.00, 'Programming & Data Science', 'Senior Python Developer', 'https://images.unsplash.com/photo-1526379879527-8559ecfcaec0?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', NULL, 1, '2026-01-02 07:11:33', 'Live Online/In-Person with Hands-on Projects', 'Python 3.8+, VS Code with Python extension, Jupyter Notebook, SQLite Browser, Git for version control', 'Not Required (Software-based Course)', 'Certificate of Completion with Project Portfolio'),
(9, 'IoT Product Engineering & Simulation (IPES-Lab)', 'Integrated Training & Internship Program focusing on IoT product development with Proteus simulation. Covers Python programming, Tkinter GUI, MQTT protocol, embedded systems, React Native mobile development, and full-stack IoT solutions. Includes 200 hours of training followed by 200 hours of internship with a major real-life project.', '400 Hours (Training+ Internship)', 'Online', 24999.00, 'IoT & Embedded Systems', 'IoT Product Engineering Team', 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', NULL, 1, '2026-01-02 07:11:33', 'Blended (Online + Lab + Internship)', 'Proteus Design Suite (Educational License), Arduino IDE, Python 3.x, Node.js, React Native setup, MQTT Broker, Virtual Machine image with pre-configured environment', 'Arduino Uno/Nano, ESP32 Development Board, Sensor Kit (DHT11, IR, PIR), Relay module, Breadboard and jumper wires (Shared Kit)', 'Certificate of Completion + Internship Certificate');

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `enrollment_date` date NOT NULL,
  `completion_date` date DEFAULT NULL,
  `status` enum('enrolled','in_progress','completed','dropped') DEFAULT 'enrolled',
  `grade` varchar(10) DEFAULT NULL,
  `certificate_issued` tinyint(1) DEFAULT 0,
  `certificate_id` varchar(50) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `attendance_sheet` varchar(255) DEFAULT NULL,
  `payment_receipt` varchar(255) DEFAULT NULL,
  `project_report` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`id`, `student_id`, `course_id`, `enrollment_date`, `completion_date`, `status`, `grade`, `certificate_issued`, `certificate_id`, `notes`, `attendance_sheet`, `payment_receipt`, `project_report`, `created_at`) VALUES
(1, 11, 8, '2025-11-15', '2025-12-12', 'completed', 'AA', 0, NULL, NULL, NULL, NULL, NULL, '2026-03-19 08:04:52');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `event_time` time DEFAULT NULL,
  `venue` varchar(200) DEFAULT NULL,
  `event_type` enum('webinar','workshop','seminar','conference') DEFAULT 'webinar',
  `registration_link` varchar(255) DEFAULT NULL,
  `is_upcoming` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `event_date`, `event_time`, `venue`, `event_type`, `registration_link`, `is_upcoming`, `created_at`) VALUES
(1, 'Digital Transformation in Education', 'A webinar on how educational institutions can leverage technology for better learning outcomes.', '2023-11-20', '14:00:00', 'Online', 'webinar', 'https://example.com/register/digital-edu', 1, '2026-01-03 08:17:13'),
(2, 'CRM Implementation Best Practices', 'Workshop on successful CRM implementation strategies for business growth.', '2023-12-05', '10:00:00', 'Kolkata Business Center', 'workshop', 'https://example.com/register/crm-workshop', 1, '2026-01-03 08:17:13');

-- --------------------------------------------------------

--
-- Table structure for table `gst_returns`
--

CREATE TABLE `gst_returns` (
  `id` int(11) NOT NULL,
  `period` varchar(20) NOT NULL COMMENT 'Format: YYYY-MM',
  `filing_date` date DEFAULT NULL,
  `total_sales` decimal(12,2) DEFAULT 0.00,
  `cgst` decimal(12,2) DEFAULT 0.00,
  `sgst` decimal(12,2) DEFAULT 0.00,
  `igst` decimal(12,2) DEFAULT 0.00,
  `total_tax_collected` decimal(12,2) DEFAULT 0.00,
  `total_purchases` decimal(12,2) DEFAULT 0.00,
  `input_tax_credit` decimal(12,2) DEFAULT 0.00,
  `net_tax_payable` decimal(12,2) DEFAULT 0.00,
  `status` enum('pending','filed','paid') DEFAULT 'pending',
  `gstr3b_file` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `invoice_number` varchar(50) NOT NULL,
  `client_id` int(11) NOT NULL,
  `invoice_date` date NOT NULL,
  `due_date` date NOT NULL,
  `po_number` varchar(100) DEFAULT NULL,
  `sub_total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `tax_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `discount_amount` decimal(12,2) DEFAULT 0.00,
  `total_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `amount_paid` decimal(12,2) DEFAULT 0.00,
  `balance_due` decimal(12,2) DEFAULT 0.00,
  `status` enum('draft','sent','paid','partial','overdue','cancelled') DEFAULT 'draft',
  `payment_terms` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `product_service_id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `unit_price` decimal(12,2) NOT NULL,
  `gst_rate` decimal(5,2) NOT NULL,
  `tax_amount` decimal(12,2) NOT NULL,
  `total_amount` decimal(12,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_openings`
--

CREATE TABLE `job_openings` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `department` varchar(50) NOT NULL,
  `location` varchar(50) NOT NULL,
  `employment_type` enum('full-time','part-time','contract','internship') DEFAULT 'full-time',
  `description` text NOT NULL,
  `requirements` text NOT NULL,
  `responsibilities` text DEFAULT NULL,
  `benefits` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `posted_date` date DEFAULT NULL,
  `application_deadline` date DEFAULT NULL,
  `views` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `token` varchar(100) NOT NULL,
  `expiry` datetime NOT NULL,
  `used` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `payment_date` date NOT NULL,
  `payment_method` enum('cash','bank_transfer','cheque','online','card') DEFAULT 'bank_transfer',
  `transaction_id` varchar(100) DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products_services`
--

CREATE TABLE `products_services` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `type` enum('product','service') NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `unit_price` decimal(12,2) NOT NULL,
  `gst_rate` decimal(5,2) DEFAULT 18.00,
  `hsn_sac_code` varchar(10) DEFAULT NULL,
  `unit` varchar(20) DEFAULT 'unit',
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `candidate_id` varchar(50) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `father_name` varchar(100) NOT NULL,
  `time_hours` int(11) NOT NULL,
  `address` text NOT NULL,
  `highest_qualification` varchar(50) DEFAULT NULL,
  `current_organization` varchar(50) DEFAULT NULL,
  `org_i_card` varchar(50) DEFAULT NULL,
  `github_link` varchar(255) DEFAULT NULL,
  `qr_code_path` varchar(255) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive','pending') DEFAULT 'pending',
  `last_login` datetime DEFAULT NULL,
  `email_verified` tinyint(1) DEFAULT 1,
  `verification_token` varchar(100) DEFAULT NULL,
  `reset_token` varchar(100) DEFAULT NULL,
  `reset_expiry` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `candidate_id`, `full_name`, `phone`, `email`, `password`, `father_name`, `time_hours`, `address`, `highest_qualification`, `current_organization`, `org_i_card`, `github_link`, `qr_code_path`, `profile_picture`, `status`, `last_login`, `email_verified`, `verification_token`, `reset_token`, `reset_expiry`, `created_at`, `updated_at`) VALUES
(11, 'PP/11/25/252608', 'Neha Das', '98765430', 'n9770900@gmail.com', '$2y$10$8r8yn2t5Tj3ACMHJmjEy5uAiHLBBtl1HcOQMKgS4TMDzdoESrdc0u', '', 1, 'Madanpur,Masunda, Amdanga, North 24 Parganas,West Bengal, PIN - 743711', '', 'KCS', 'kcs/116', 'https://github.com/nehadas', NULL, '1773914156_neha_das_1765829550.png', 'pending', '2026-03-19 16:10:31', 1, '625653ddaf379f89dd28039d7cf69c12a060382e0c68edab9b3b4f9ded4774ee', NULL, NULL, '2026-03-19 07:22:02', '2026-03-19 11:00:32'),
(12, 'IP-07-25-252612', 'Rupsha Saha', '9123317563', 'rupshasaha005@gmail.com', '$2y$10$zz4mw4auVb36emybuogrL.6k31cxd1t3TCHDUbrXsGWq38o3C/EE6', 'Samar Kumar  Saha', 0, 'Siddhanta Para Main Road , Barrackpore \r\nKolkata  : 700122   state  : West Bengal \r\nDist : North 24 parganas , post office  :  Nonachandanpukur, PIN-700122', 'HS', 'Techno India Saltlake', '5566', 'https://github.com/rupshasaha', NULL, '1773915270_rupsha_saha_1766345080.jpeg', 'pending', '2026-03-19 15:38:29', 1, '4a97b7e36ea7b866adaaa25a690b38a2a56e17be3aa88d3d9e822c14d2ff6a16', NULL, NULL, '2026-03-19 10:08:17', '2026-03-19 10:16:03');

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE `submissions` (
  `id` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `submission_file` varchar(255) DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `grade` varchar(10) DEFAULT NULL,
  `feedback` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `client_name` varchar(100) NOT NULL,
  `client_position` varchar(100) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `testimonial` text NOT NULL,
  `rating` int(11) DEFAULT 5,
  `testimonial_date` date DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('published','not published','review','') DEFAULT 'published'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `client_name`, `client_position`, `company`, `testimonial`, `rating`, `testimonial_date`, `is_featured`, `created_at`, `status`) VALUES
(1, 'Rajesh Kumar', 'HR Manager', 'Tech Solutions Inc.', 'Araneus Edutech provided excellent training for our new hires. The industry-relevant curriculum and expert trainers helped our team get up to speed quickly.', 5, '2023-05-15', 1, '2026-01-03 08:17:13', 'published'),
(2, 'Priya Sharma', 'Director', 'Global Education Trust', 'Their educational consultancy helped us redesign our curriculum to better align with industry needs. Student placement rates have improved by 40%.', 4, '2023-06-22', 1, '2026-01-03 08:17:13', 'published'),
(3, 'Amit Patel', 'CEO', 'StartUp Innovate', 'The Salesforce CRM implementation was seamless. The Araneus team provided excellent support throughout the transition process.', 5, '2023-07-10', 1, '2026-01-03 08:17:13', 'published');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('admin','staff','student') NOT NULL DEFAULT 'staff',
  `full_name` varchar(100) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password_hash`, `email`, `role`, `full_name`, `status`, `last_login`, `created_at`) VALUES
(1, 'admin', '$2y$10$YourHashedPasswordHere', 'admin@araneusedutech.com', 'admin', 'Administrator', 'active', NULL, '2026-02-11 08:06:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `career_applications`
--
ALTER TABLE `career_applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `certificate_id` (`certificate_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `contact_submissions`
--
ALTER TABLE `contact_submissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gst_returns`
--
ALTER TABLE `gst_returns`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `period` (`period`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_number` (`invoice_number`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_id` (`invoice_id`),
  ADD KEY `product_service_id` (`product_service_id`);

--
-- Indexes for table `job_openings`
--
ALTER TABLE `job_openings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_id` (`invoice_id`);

--
-- Indexes for table `products_services`
--
ALTER TABLE `products_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `candidate_id` (`candidate_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `submissions`
--
ALTER TABLE `submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assignment_id` (`assignment_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `career_applications`
--
ALTER TABLE `career_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_submissions`
--
ALTER TABLE `contact_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `gst_returns`
--
ALTER TABLE `gst_returns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_openings`
--
ALTER TABLE `job_openings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products_services`
--
ALTER TABLE `products_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `submissions`
--
ALTER TABLE `submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`);

--
-- Constraints for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD CONSTRAINT `invoice_items_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoice_items_ibfk_2` FOREIGN KEY (`product_service_id`) REFERENCES `products_services` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`);

--
-- Constraints for table `submissions`
--
ALTER TABLE `submissions`
  ADD CONSTRAINT `submissions_ibfk_1` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `submissions_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

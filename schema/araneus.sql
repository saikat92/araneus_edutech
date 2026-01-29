-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 29, 2026 at 05:37 PM
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
-- Database: `araneus`
--

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
  `fee` decimal(10,2) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `instructor` varchar(100) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
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

INSERT INTO `courses` (`id`, `title`, `description`, `duration`, `fee`, `category`, `instructor`, `image_url`, `is_active`, `created_at`, `program_format`, `tools_provided`, `hardware_kit`, `certification_type`) VALUES
(4, 'Web Development with Django & React', 'Full-stack web development course covering Django backend, React frontend, REST APIs, and deployment. Build complete web applications with database integration and modern UI/UX.', '80 Hours', 11999.00, 'Web Development', 'Full Stack Developer', 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 1, '2026-01-02 07:06:38', 'Live Online Sessions', 'Django, React, PostgreSQL, VS Code, Git', 'Not Required', 'Certificate of Completion'),
(5, 'Data Science & Machine Learning Bootcamp', 'Intensive bootcamp covering data analysis, visualization, statistical modeling, and machine learning algorithms. Hands-on projects with real datasets and industry case studies.', '100 Hours', 17999.00, 'Data Science', 'Data Scientist', 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 1, '2026-01-02 07:06:38', 'Weekend Batch', 'Python, Pandas, NumPy, Scikit-learn, TensorFlow, Jupyter', 'Not Required', 'Certificate with Project Portfolio'),
(6, 'Android App Development with Kotlin', 'Learn to build native Android applications using Kotlin. Covers UI design, database integration, API calls, and publishing to Play Store.', '60 Hours', 9999.00, 'Mobile Development', 'Android Developer', 'https://images.unsplash.com/photo-1611224923853-80b023f02d71?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 1, '2026-01-02 07:06:38', 'Self-paced with Mentorship', 'Android Studio, Kotlin, Firebase, Git', 'Optional Android Device', 'Certificate of Completion'),
(7, 'Cybersecurity Fundamentals', 'Introduction to cybersecurity concepts, network security, ethical hacking, and penetration testing. Hands-on labs with security tools and techniques.', '50 Hours', 12999.00, 'Cybersecurity', 'Security Expert', 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 1, '2026-01-02 07:06:38', 'Evening Batch', 'Kali Linux, Wireshark, Metasploit, VirtualBox', 'Not Required', 'Certificate of Completion'),
(8, 'Python Power: Complete 120-Hour Training Program', 'A comprehensive Python training program covering foundations, desktop applications, game development, data science, SQL integration, and machine learning. This hands-on course includes three major modules with practical projects, culminating in a Final Integrated Business Intelligence System project.', '120 Hours', 14999.00, 'Programming & Data Science', 'Senior Python Developer', 'https://images.unsplash.com/photo-1526379879527-8559ecfcaec0?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 1, '2026-01-02 07:11:33', 'Live Online/In-Person with Hands-on Projects', 'Python 3.8+, VS Code with Python extension, Jupyter Notebook, SQLite Browser, Git for version control', 'Not Required (Software-based Course)', 'Certificate of Completion with Project Portfolio'),
(9, 'IoT Product Engineering & Simulation (IPES-Lab)', 'Integrated Training & Internship Program focusing on IoT product development with Proteus simulation. Covers Python programming, Tkinter GUI, MQTT protocol, embedded systems, React Native mobile development, and full-stack IoT solutions. Includes 200 hours of training followed by 200 hours of internship with a major real-life project.', '400 Hours (Training+ Internship)', 24999.00, 'IoT & Embedded Systems', 'IoT Product Engineering Team', 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 1, '2026-01-02 07:11:33', 'Blended (Online + Lab + Internship)', 'Proteus Design Suite (Educational License), Arduino IDE, Python 3.x, Node.js, React Native setup, MQTT Broker, Virtual Machine image with pre-configured environment', 'Arduino Uno/Nano, ESP32 Development Board, Sensor Kit (DHT11, IR, PIR), Relay module, Breadboard and jumper wires (Shared Kit)', 'Certificate of Completion + Internship Certificate');

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
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `candidate_id` varchar(50) NOT NULL,
  `certificate_id` varchar(50) NOT NULL,
  `candidate_name` varchar(100) NOT NULL,
  `father_name` varchar(100) NOT NULL,
  `course_completed` varchar(200) NOT NULL,
  `certification` varchar(200) NOT NULL,
  `mode` varchar(50) NOT NULL,
  `time_hours` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `llpin` varchar(20) DEFAULT NULL,
  `address` text NOT NULL,
  `github_link` varchar(255) DEFAULT NULL,
  `qr_code_path` varchar(255) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `candidate_id`, `certificate_id`, `candidate_name`, `father_name`, `course_completed`, `certification`, `mode`, `time_hours`, `start_date`, `end_date`, `llpin`, `address`, `github_link`, `qr_code_path`, `profile_picture`, `created_at`, `updated_at`) VALUES
(1, 'AEL2025-PP-11-25-252608', 'PP/11/25/252608', 'Neha Das', 'Tarun Das', 'Integrated Internship Program on \"Python Power\"', 'Araneus Edutech LLP. (An MSME Company)', 'In-House (Offline)', 120, '2025-11-15', '2025-12-12', 'AAP-3776', '116/56/E/N, East Chandmari, Barrackpore, Kol - 700122', 'https://github.com/nehadas', 'qr_codes/ND-PP-11-25-252608.jpg', 'profile_pictures/neha_das_1765829550.png', '2025-12-15 18:05:42', '2025-12-15 20:43:36'),
(5, 'AEL2025-PP-11-25-252609', 'PP/11/25/252609', 'Tripan Nandi', 'Tapan Kumar Nandi', 'Integrated Internship Program on \"Python Power\"', 'Araneus Edutech LLP. (An MSME Company)', 'In-House (Offline)', 120, '2025-11-15', '2025-12-12', 'AAP-3776', '116/56/E/N, East Chandmari, Barrackpore, Kol - 700122', 'https://github.com/codewithnandi/python_power_tn.git', 'qr_codes/TN-PP-11-25-252609.jpg', 'profile_pictures/tripan_nandi_1765829495.jpeg', '2025-12-15 19:20:05', '2025-12-15 20:43:43'),
(6, 'AEL2025-PP-11-25-252610', 'PP/11/25/252610', 'Suvendu Ghosh', 'Sukumar Ghosh', 'Integrated Internship Program on \"Python Power\"', 'Araneus Edutech LLP. (An MSME Company)', 'In-House (Offline)', 120, '2025-11-15', '2025-12-12', 'AAP-3776', '116/56/E/N, East Chandmari, Barrackpore, Kol - 700122', 'https://github.com/suvodev27/python_power_SG.git', 'qr_codes/SG-PP-11-25-252610.jpg', 'profile_pictures/suvendu_ghosh_1765829529.jpg', '2025-12-15 19:20:05', '2025-12-15 20:12:09'),
(7, 'AEL2025-PP-11-25-252611', 'PP/11/25/252611', 'Debapriya Mallick', 'Debu Mallick', 'Integrated Internship Program on \"Python Power\"', 'Araneus Edutech LLP. (An MSME Company)', 'In-House (Offline)', 120, '2025-11-15', '2025-12-12', 'AAP-3776', '116/56/E/N, East Chandmari, Barrackpore, Kol - 700122', 'https://github.com/debapriyamallick495/Python_Power_DM.git', 'qr_codes/DM-PP-11-25-252611.jpg', 'profile_pictures/debapriya_mallick_1765867498.jpg', '2025-12-15 19:20:05', '2025-12-16 06:44:58'),
(8, 'AEL2025-IP-07-25-252612', 'IP/07/25/252612', 'Rupsha Saha', 'Samar Kumar Saha', 'Integrated Internship Program on IoT Product Engineering & Simulation', 'Araneus Edutech LLP. (An MSME Company)', 'In-House (Offline)', 400, '2025-07-20', '2025-12-20', 'AAP-3776', '116/56/E/N, East Chandmari, Barrackpore, Kol - 700122', '', 'qr_codes/RS-IP-07-25-252612.jpg', 'profile_pictures/rupsha_saha_1766345080.jpeg', '2025-12-21 16:59:27', '2025-12-21 19:24:40');

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
  `role` enum('admin','editor') DEFAULT 'editor',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password_hash`, `email`, `role`, `created_at`) VALUES
(1, 'admin', '$2y$10$YourHashedPasswordHere', 'admin@araneusedutech.com', 'admin', '2025-12-15 18:05:42');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_openings`
--
ALTER TABLE `job_openings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

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
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `job_openings`
--
ALTER TABLE `job_openings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

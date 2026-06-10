-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 05, 2026 at 12:05 PM
-- Server version: 11.4.10-MariaDB-cll-lve-log
-- PHP Version: 8.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `plasxjel_araneus_edutech`
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
(1, 1, 'Python Data Processor', 'Write a script to load a CSV (e.g., Iris or housing data), compute summary statistics (mean, median), and output cleaned data. Use Pandas, NumPy, and Git for version control.', '2026-05-28', '2026-03-25 10:43:13'),
(2, 1, 'Statistical Analysis of Dataset', 'Using the UCI Heart Disease dataset, compute summary statistics, test a hypothesis (e.g., average cholesterol difference between groups), and interpret p-values.', '2026-05-29', '2026-03-25 10:43:13'),
(3, 1, 'Titanic EDA and Preprocessing', 'Perform exploratory data analysis on the Titanic dataset: visualize survival by features, impute missing ages, and output a cleaned CSV.', NULL, '2026-03-25 10:43:13'),
(4, 1, 'Customer Data Dashboard', 'Given a sales dataset, create bar and line charts to show trends (monthly sales, top product categories) using Pandas and Matplotlib/Seaborn.', '2026-05-30', '2026-03-25 10:43:13'),
(5, 1, 'House Prices Prediction', 'Build a linear regression model on a housing dataset, evaluate using MSE and R², and experiment with polynomial features.', '2026-05-28', '2026-03-25 10:43:13'),
(6, 1, 'Medical Diagnosis Classifier', 'Train logistic regression and decision tree models on the Heart Disease dataset. Compute accuracy, precision, recall, and ROC-AUC.', NULL, '2026-03-25 10:43:13'),
(7, 1, 'Cluster Analysis', 'Apply k-means and PCA on the Iris dataset. Visualize clusters and 2D projections. (Optional: hierarchical clustering dendrogram).', NULL, '2026-03-25 10:43:13'),
(8, 1, 'Model Tuning', 'Use GridSearchCV to tune hyperparameters of a decision tree or random forest on the classification problem from Module 5. Compare tuned vs default performance.', NULL, '2026-03-25 10:43:13'),
(9, 1, 'Handwritten Digit Classifier', 'Build a feedforward neural network (and optionally a CNN) in Keras to classify MNIST digits. Achieve at least 90% accuracy.', NULL, '2026-03-25 10:43:13'),
(10, 1, 'Sentiment Analysis with RNN', 'Preprocess text and train a simple LSTM network for binary sentiment classification on IMDB reviews. Report accuracy and confusion matrix.', NULL, '2026-03-25 10:43:13'),
(11, 1, 'ML Deployment Task', 'Create a GitHub repo with code, Dockerize a model, or deploy a Flask API that serves a trained model (e.g., house price predictor).', NULL, '2026-03-25 10:43:13'),
(12, 1, 'Capstone Project', 'End-to-end ML project (e.g., movie recommender, heart disease predictor, sales forecaster). Includes proposal, interim report, final code, and presentation.', '2026-05-31', '2026-03-25 10:43:13'),
(13, 2, 'Personal Portfolio Website', 'Build a personal portfolio page using HTML5, CSS3, and JavaScript. Include responsive design and interactive elements.', NULL, '2026-03-25 10:43:13'),
(14, 2, 'Business Landing Page with Bootstrap', 'Create a fully responsive business landing page using Bootstrap 4/5, Font Awesome, and custom CSS.', NULL, '2026-03-25 10:43:13'),
(15, 2, 'Task Manager CRUD App', 'Develop a complete task management application with PHP and MySQL. Implement user registration, login, and CRUD operations for tasks.', NULL, '2026-03-25 10:43:13'),
(16, 2, 'Blog System with MVC & Authentication', 'Build a blog system using PHP OOP and a custom MVC framework. Include user authentication, role-based access, and blog post management.', NULL, '2026-03-25 10:43:13'),
(17, 2, 'Capstone Project (Full-Stack PHP)', 'Choose a project from provided ideas (e.g., CRM, ERP, E-commerce, Hospital Management) and build a complete web application using all skills learned.', NULL, '2026-03-25 10:43:13'),
(18, 3, 'TaskFlow API (Backend)', 'Build a secure RESTful API with Node.js, Express, MongoDB, and JWT authentication. Implement user registration, login, and task CRUD operations with user-specific data.', NULL, '2026-03-25 10:43:13'),
(19, 3, 'TaskFlow React Dashboard', 'Create a dynamic React frontend that consumes the TaskFlow API. Implement authentication, task listing, creation, editing, and deletion using React Router and Context API.', NULL, '2026-03-25 10:43:13'),
(20, 3, 'TaskFlow Angular Admin Portal', 'Develop an Angular admin portal that consumes the same TaskFlow API. Use services, RxJS, reactive forms, and route guards to manage users and tasks.', NULL, '2026-03-25 10:43:13'),
(21, 3, 'Final Capstone Project (MEARN Stack)', 'Choose a capstone project (e.g., Book Discovery Platform, Fitness Tracker, Event Manager) and build a full-stack application from scratch using MongoDB, Express, React/Angular, and Node.js. Deploy to cloud platforms.', NULL, '2026-03-25 10:43:13'),
(22, 4, 'Virtual Smart Home Controller (Tkinter)', 'Create a Tkinter application with 3 virtual rooms displaying temperature/humidity, control buttons for lights and fans, and a log panel. Use Python classes to simulate device behavior.', NULL, '2026-03-25 10:43:13'),
(23, 4, 'Distributed Weather Monitoring System', 'Develop three independent Python programs: a sensor simulator publishing random weather data via MQTT, a desktop dashboard subscribing to data, and an alert manager sending email alerts for threshold exceedances.', NULL, '2026-03-25 10:43:13'),
(24, 4, 'Smart Plant Watering System (Proteus)', 'Design a circuit in Proteus with Arduino, soil moisture sensor (potentiometer), relay, and LCD. Write Arduino code to control watering based on moisture level. Optionally add MQTT integration.', NULL, '2026-03-25 10:43:13'),
(25, 4, 'Complete IoT Home Automation Suite', 'Integrate Proteus simulation (Arduino with sensors/actuators), a Python MQTT bridge, a React Native mobile app for control, and a Tkinter desktop monitor. Demonstrate bidirectional communication.', NULL, '2026-03-25 10:43:13'),
(26, 4, 'Major Real-Life IoT Project', 'Select a real-life IoT project (e.g., hydroponics system, smart irrigation, health monitoring) and complete all phases: planning, Proteus simulation, physical implementation, software integration, testing, and documentation.', NULL, '2026-03-25 10:43:13'),
(27, 5, 'Simple Calculator Program', 'Write a Python script that takes two numbers and an operator (+, -, *, /) from the user and displays the result. Handle division by zero gracefully.', NULL, '2026-04-16 14:22:54'),
(28, 5, 'Number Guessing Game', 'Create a game where the computer picks a random number between 1 and 100, and the user has to guess it. Provide hints (too high/too low) and count attempts.', NULL, '2026-04-16 14:22:54'),
(29, 5, 'Student Grade Management System', 'Build a program that stores student names and grades using a list of dictionaries. Implement functions to add a student, calculate the average grade, and display all records.', NULL, '2026-04-16 14:22:54'),
(30, 5, 'Personal Contact Manager with JSON Storage', 'Develop a command-line contact manager that stores contacts (name, phone, email) in a JSON file. Support adding, viewing, and deleting contacts.', NULL, '2026-04-16 14:22:54'),
(31, 5, 'NumPy Statistical Analysis', 'Generate a random dataset of 1000 values (normal distribution, mean=50, std=15). Compute and print the mean, median, standard deviation, and percentiles using NumPy.', NULL, '2026-04-16 14:22:54'),
(32, 5, 'Sales Data Analysis with Pandas', 'Load a sales CSV (Date, Product, Sales). Convert the date column to datetime, group by product to get total sales, and create a line plot of daily sales using Pandas built-in plotting.', NULL, '2026-04-16 14:22:54'),
(33, 5, 'Customer Data Cleaning Project', 'Load a messy customer dataset (with missing values, duplicates, inconsistent formatting). Clean it by handling missing values, removing duplicates, and standardizing text columns.', NULL, '2026-04-16 14:22:54'),
(34, 5, 'Financial Data Analyzer (CLI Tool)', 'Build a command-line tool that reads stock market data from a CSV, calculates moving averages (e.g., 20-day and 50-day), volatility (standard deviation of daily returns), and generates a performance report.', NULL, '2026-04-16 14:22:54'),
(35, 5, 'Simple Calculator GUI with Tkinter', 'Create a graphical calculator using Tkinter with buttons for digits 0-9, operators (+, -, *, /), equals, and clear. Display the current expression in an Entry widget.', NULL, '2026-04-16 14:22:54'),
(36, 5, 'Text Editor Application', 'Develop a basic text editor using Tkinter with a menu bar (File: New, Open, Save, Exit) and a Text widget. Support opening and saving plain text files.', NULL, '2026-04-16 14:22:54'),
(37, 5, 'Student Database Management System (Tkinter + SQLite)', 'Build a GUI application to manage student records. Include fields: name, roll number, grade. Use SQLite for storage. Implement add, update, delete, and search functionality.', NULL, '2026-04-16 14:22:54'),
(38, 5, 'Interactive Drawing Application with Pygame', 'Create a Pygame program where the user can draw on the screen by holding the mouse button. Support different colors (e.g., red, green, blue) using keyboard keys.', NULL, '2026-04-16 14:22:54'),
(39, 5, 'Animated Character Movement', 'Load a character sprite and move it left/right/up/down using arrow keys. Add boundaries to prevent it from leaving the screen. Animate walking cycles if possible.', NULL, '2026-04-16 14:22:54'),
(40, 5, 'Ball Collision Simulation', 'Simulate a bouncing ball with gravity and velocity. The ball should bounce off the edges of the screen and lose some energy (coefficient of restitution).', NULL, '2026-04-16 14:22:54'),
(41, 5, 'Complete Arcade-Style Game', 'Develop a simple arcade game (e.g., Pong, Snake, or Space Invaders) using Pygame. Include score tracking, game over condition, and restart functionality.', NULL, '2026-04-16 14:22:54'),
(42, 5, 'Personal Productivity Suite (Desktop App)', 'Create an integrated Tkinter application with a Todo list, note-taking module, and Pomodoro timer. Optionally add a simple arcade game as a break feature. Use JSON or SQLite for data persistence.', NULL, '2026-04-16 14:22:54'),
(43, 5, 'Library Management Database (SQL)', 'Design and implement an SQLite database for a library: tables for books, members, and loans. Write SQL queries to insert sample data, list overdue books, and find the most borrowed book.', NULL, '2026-04-16 14:22:54'),
(44, 5, 'Complex Business Analytics Queries', 'Using an orders database (customers, orders, order_details, products), write queries that use JOIN, GROUP BY, and subqueries to compute total sales per customer, monthly revenue, and top 5 selling products.', NULL, '2026-04-16 14:22:54'),
(45, 5, 'Customer Management System with SQLite Backend', 'Build a Python CLI or Tkinter app that interacts with a SQLite database for customers. Use parameterized queries to prevent SQL injection. Implement CRUD operations.', NULL, '2026-04-16 14:22:54'),
(46, 5, 'E-Commerce Database with Python & Pandas', 'Create an e-commerce database schema (products, orders, order_items). Use Pandas to load CSV data into tables (to_sql) and then run analytical queries (read_sql) to produce a revenue report.', NULL, '2026-04-16 14:22:54'),
(47, 5, 'Sales Trend Visualization with Matplotlib', 'Load monthly sales data from a CSV and create a line plot with markers, titles, axis labels, and a legend. Also create a bar chart of sales by product category.', NULL, '2026-04-16 14:22:54'),
(48, 5, 'Customer Demographic Analysis with Seaborn', 'Use a customer dataset (age, income, spending score). Create a distribution plot (histogram + KDE), a boxplot of spending by age group, and a heatmap of correlations between numerical features.', NULL, '2026-04-16 14:22:54'),
(49, 5, 'House Price Prediction Model', 'Build a linear regression model using Scikit-learn on a housing dataset. Split data into train/test, train the model, evaluate using R² and RMSE, and plot actual vs predicted values.', NULL, '2026-04-16 14:22:54'),
(50, 5, 'Customer Segmentation with K-Means', 'Perform customer segmentation using K-Means clustering on a retail dataset. Determine the optimal number of clusters (elbow method) and visualize the clusters in 2D (using PCA).', NULL, '2026-04-16 14:22:54'),
(51, 5, 'Customer Analytics Platform (End-to-End)', 'Integrate SQL data extraction, Pandas analysis, and ML modeling. Extract customer data from a database, perform segmentation with K-Means, and build a churn prediction classifier. Present results with a dashboard (Tkinter + Matplotlib).', NULL, '2026-04-16 14:22:54'),
(52, 5, 'Final Integrated Project: Business Intelligence System', 'Develop a complete desktop application with database backend, Tkinter dashboard, predictive models for business forecasting, and interactive visualizations. Deliverables: full source code, documentation, and a portfolio-ready demo.', NULL, '2026-04-16 14:22:54');

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
(3, 15, 1, '2026-03-25', 4.00, '2026-03-25 12:27:27'),
(4, 15, 1, '2026-03-27', 1.00, '2026-03-27 15:28:01'),
(5, 15, 1, '2026-03-29', 4.00, '2026-03-29 13:28:56'),
(6, 15, 1, '2026-03-30', 4.00, '2026-03-30 15:41:58'),
(7, 15, 1, '2026-03-31', 4.00, '2026-03-31 15:07:44'),
(8, 15, 1, '2026-04-01', 4.00, '2026-04-01 12:18:19'),
(9, 15, 1, '2026-04-02', 4.00, '2026-04-02 16:13:50'),
(10, 15, 1, '2026-04-03', 4.00, '2026-04-03 12:58:30'),
(11, 15, 1, '2026-04-08', 4.00, '2026-04-08 13:38:25'),
(12, 15, 1, '2026-04-09', 4.00, '2026-04-09 10:05:08'),
(13, 15, 1, '2026-04-11', 4.00, '2026-04-11 12:17:08'),
(14, 15, 1, '2026-04-13', 4.00, '2026-04-13 12:58:36'),
(15, 15, 1, '2026-04-15', 4.00, '2026-04-15 06:40:50'),
(16, 16, 5, '2026-04-16', 8.00, '2026-04-16 15:23:22'),
(17, 15, 1, '2026-04-18', 4.00, '2026-04-18 09:03:06'),
(18, 15, 1, '2026-04-19', 4.00, '2026-05-22 07:04:42'),
(19, 15, 1, '2026-04-20', 4.00, '2026-05-22 07:04:57'),
(20, 15, 1, '2026-04-21', 4.00, '2026-05-22 07:05:06'),
(21, 15, 1, '2026-04-22', 4.00, '2026-05-22 07:05:18'),
(22, 15, 1, '2026-04-23', 4.00, '2026-05-22 07:05:28'),
(23, 15, 1, '2026-04-24', 4.00, '2026-05-22 07:05:41'),
(24, 15, 1, '2026-04-25', 4.00, '2026-05-22 07:05:50'),
(25, 15, 1, '2026-04-27', 4.00, '2026-05-22 07:06:01'),
(26, 15, 1, '2026-04-28', 4.00, '2026-05-22 07:06:09'),
(27, 15, 1, '2026-04-29', 4.00, '2026-05-22 07:06:16'),
(28, 15, 1, '2026-04-30', 4.00, '2026-05-22 07:06:24'),
(29, 15, 1, '2026-05-02', 4.00, '2026-05-22 07:06:38'),
(30, 15, 1, '2026-05-03', 4.00, '2026-05-22 07:06:46'),
(31, 15, 1, '2026-05-05', 4.00, '2026-05-22 07:07:01'),
(32, 15, 1, '2026-05-06', 4.00, '2026-05-22 07:07:09'),
(33, 15, 1, '2026-05-08', 4.00, '2026-05-22 07:07:17'),
(34, 15, 1, '2026-05-09', 4.00, '2026-05-22 07:07:25'),
(35, 15, 1, '2026-05-11', 4.00, '2026-05-22 07:07:38'),
(36, 15, 1, '2026-05-13', 4.00, '2026-05-22 07:07:48'),
(37, 15, 1, '2026-05-14', 4.00, '2026-05-22 07:08:00'),
(38, 19, 2, '2026-05-14', 3.00, '2026-05-23 04:23:54'),
(39, 18, 2, '2026-05-14', 3.00, '2026-05-23 04:23:59'),
(40, 20, 2, '2026-05-14', 3.00, '2026-05-23 04:24:15'),
(41, 19, 2, '2026-05-23', 2.00, '2026-05-23 04:24:24'),
(42, 18, 2, '2026-05-23', 2.00, '2026-05-23 04:24:32'),
(43, 20, 2, '2026-05-23', 2.00, '2026-05-23 04:24:42'),
(44, 19, 2, '2026-05-28', 2.00, '2026-05-28 15:17:28'),
(45, 20, 2, '2026-06-04', 2.00, '2026-06-04 15:35:50'),
(46, 19, 2, '2026-06-04', 2.00, '2026-06-04 15:36:30'),
(47, 20, 2, '2026-05-28', 2.00, '2026-06-04 15:36:46'),
(48, 18, 2, '2026-05-28', 2.00, '2026-06-04 15:38:09'),
(49, 18, 2, '2026-06-04', 2.00, '2026-06-04 15:38:38');

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
(4, 'Browsing Smarter: What a VPN Does and Why It Matters', 'browsing-smarter-what-a-vpn-does-and-why-it-matters', 'A plain-English guide to Virtual Private Networks — what they are, how they work, and when to use one.', 'What Is a VPN?\r\nA Virtual Private Network (VPN) is a technology that creates a secure, encrypted tunnel between your device and the internet. When you connect through a VPN, your data is routed via a private server — masking your IP address and shielding your online activity from third parties such as internet service providers, advertisers, and malicious actors.\r\nHow Does It Work?\r\nThe process is straightforward:\r\n•	Your device connects to a VPN server using an encrypted protocol (e.g., OpenVPN, WireGuard, or IKEv2).\r\n•	All outbound traffic appears to originate from the VPN server\'s IP address — not your own.\r\n•	Data in transit is encrypted end-to-end, making it unreadable to anyone intercepting the connection.\r\n•	Websites and services see only the VPN server\'s location, not your actual one.\r\nKey Uses of a VPN\r\n•	Privacy Protection: Prevents ISPs, advertisers, and governments from monitoring your browsing habits.\r\n•	Secure Public Wi-Fi: Encrypts your connection on open networks (cafés, airports, hotels) where eavesdropping is common.\r\n•	Remote Work Access: Allows employees to securely connect to corporate networks and internal resources from anywhere.\r\n•	Bypassing Geo-Restrictions: Enables access to content or services restricted to specific regions (streaming libraries, news sites).\r\n•	Avoiding Censorship: Useful in regions where certain websites or platforms are blocked by government firewalls.\r\nLimitations to Keep in Mind\r\nA VPN is a powerful privacy tool, but not a complete security solution:\r\n•	It does not protect against malware, phishing, or device-level threats.\r\n•	A VPN can slow connection speeds due to encryption overhead and server routing.\r\n•	Free VPN services may log and sell your data — defeating the purpose entirely.\r\n•	VPN use is restricted or illegal in some countries; always check local regulations.\r\n\r\nChoosing the Right VPN\r\nWhen evaluating a VPN provider, prioritise the following:\r\n•	No-log policy: The provider should not store records of your activity.\r\n•	Strong encryption standards: Look for AES-256 encryption and modern protocols like WireGuard.\r\n•	Kill switch feature: Automatically cuts your internet if the VPN drops, preventing accidental exposure.\r\n•	Jurisdiction: Providers based in privacy-friendly countries offer stronger legal protections.\r\n•	Independent audits: Third-party security audits signal transparency and trustworthiness.\r\n', 'Saikat Biswas, Director', 'Cybersecurity', 'https://content.kaspersky-labs.com/fm/press-releases/e5/e59b70d04f650e7aa400466e119f672d/processed/what-is-a-vpn-2-q93.png', 'published', '2026-05-06', '2026-05-06 07:17:12', '2026-05-06 07:23:11'),
(5, 'Java 8, Spring Boot & Microservices', 'java-8-spring-boot-microservices', 'Modern Java development has evolved from monolithic architectures to cloud-native microservices. This journey is powered by Java 8’s foundational features, the productivity of Spring Boot, and distributed systems patterns.', 'Core Evolution: Modern Java development has evolved from monolithic architectures to cloud-native microservices. This journey is powered by Java 8’s foundational features, the productivity of Spring Boot, and distributed systems patterns.\r\nKey Technologies:\r\n1.	Java 8+: Introduced lambda expressions and the Streams API, enabling functional, declarative programming that reduces boilerplate and improves code clarity.\r\n2.	Spring Boot: Revolutionised enterprise Java with convention-over-configuration, auto-configuration, and starter dependencies, allowing developers to create standalone, production-ready applications with minimal setup.\r\n3.	REST API Development: Spring Boot simplifies building stateless, HTTP-based APIs using @RestController and @RequestMapping annotations, with automatic JSON serialisation.\r\nMicroservices Architecture: This architectural style decomposes an application into small, loosely coupled services, each encapsulating a specific business domain. Benefits include independent deployment, technology diversity, and granular scaling, but it introduces complexity in communication and data consistency.\r\nImplementation with Spring Cloud: The Spring Cloud ecosystem provides tools for production-grade microservices:\r\n•	Service Discovery (Eureka): Services automatically register and find each other.\r\n•	API Gateway: A single-entry point for routing and cross-cutting concerns.\r\n•	Circuit Breakers (Resilience4j): Prevent cascading failures by stopping calls to failing services.\r\n•	Distributed Configuration: Centralised external configuration management.\r\nCommunication & Deployment: Services communicate via synchronous REST or asynchronous messaging (e.g., Kafka). They are deployed as Docker containers and orchestrated with Kubernetes, supported by CI/CD pipelines and comprehensive monitoring.\r\nConclusion: The modern Java stack empowers developers to build scalable, resilient, and maintainable systems by combining Java\'s robust language features, Spring Boot\'s efficiency, and cloud-native architectural principles.\r\n\r\n', 'Saikat Biswas, Director', 'Java Application', 'https://miro.medium.com/v2/0*DSiA3UVKvohpj508.png', 'published', '2026-05-06', '2026-05-06 07:18:53', '2026-05-06 07:21:36'),
(6, 'CONTROL UNIT DESIGN: THE BRAIN BEHIND THE CPU', 'control-unit-design-the-brain-behind-the-cpu', 'A Beginner\'s Guide to design computing system.', 'Introduction\r\n\r\nThe Control Unit (CU) is frequently referred to as the brain within a computer system in computer design.  The control unit serves as a coordinator and conductor, making sure that each instruction is retrieved, decoded, and carried out in perfect order, while the Arithmetic Logic Unit (ALU) conducts calculations.\r\n It controls the flow of data between the processor, memory, and I/O devices, converting binary instructions into precise control signals that keep the computer\'s heartbeat.  Logic design and creativity come together when creating an effective control unit, combining timing, digital circuitry, and micro-operations into a single, coherent system.\r\nWhat is a Control Unit?\r\n\r\nAn essential part of the Central Processing Unit (CPU) that controls how instructions are carried out is the Control Unit (CU).  It decodes each instruction\'s opcode and produces control signals to direct the ALU, registers, memory, and other CPU components.\r\nTo put it simply, it instructs the system on what has to be done, when, and how.\r\nFunctions of the Control Unit:\r\n\r\nA well-designed control unit ensures the smooth operation of all CPU components. Its primary functions include:\r\n1.	Instruction Fetching: Retrieves the next instruction from memory into the instruction register.\r\n2.	Instruction Decoding: Interprets the operation code (opcode) and identifies the type of instruction.\r\n3.	Control Signal Generation: Produces control signals to activate specific data paths and hardware components.\r\n4.	Timing and Synchronization: Ensures all actions occur in the correct order and at the right time.\r\n5.	Communication Control: Coordinates between CPU, memory, and I/O devices for data exchange.\r\n\r\nTypes of Control Unit Design:\r\n\r\n1.	Hardwired Control Unit: A hardwired control unit uses combinational logic circuits to generate control signals. The logic is built using gates, flip-flops, decoders, and counters, making it extremely fast.\r\nAdvantages:\r\n•	High speed due to direct hardware connections\r\n•	Low latency in signal generation\r\n\r\nDisadvantages:\r\n•	Difficult to modify or upgrade\r\n•	Complex to design for large instruction sets\r\nHardwired control is ideal for RISC (Reduced Instruction Set Computer) architectures, where instructions are simple and uniform.\r\n\r\n2.	Microprogrammed Control Unit: A microprogrammed control unit stores control signals in a control memory as microinstructions. Each machine instruction is executed through a sequence of micro-operations.\r\nAdvantages:\r\n•	Easier to design and modify\r\n•	Highly flexible and adaptable\r\n•	Ideal for CISC (Complex Instruction Set Computer) architectures\r\nDisadvantages:\r\n•	Slower than hardwired designs due to memory access delays\r\n\r\nHardwired vs. Microprogrammed Control: A Comparison.\r\n\r\nFeature	Hardwired Control	Microprogrammed Control\r\nSpeed	Faster	Slower\r\nDesign Complexity	High	Moderate\r\nFlexibility	Low	High\r\nModification	Difficult	Easy\r\nUsed in	RISC processors	CISC processors\r\n\r\nMicro-operations and Control Signals: At the core of control unit design lies the concept of micro-operations — the basic operations performed on data stored in registers.\r\nExamples include:\r\n•	Transfer: R1 ← R2\r\n•	Arithmetic: R3 ← R1 + R2\r\n•	Logic: R1 ← R1 AND R2\r\n•	Shift: R1 ← shl R1\r\n\r\nThe control unit issues the appropriate control signals to trigger these micro-operations in the correct sequence.\r\n\r\n\r\n\r\nMicroprogrammed Control Design Flow\r\n\r\nA microprogrammed control unit typically consists of:\r\n1.	Control Memory (ROM): Stores microinstructions.\r\n2.	Control Address Register (CAR): Points to the address of the next microinstruction.\r\n3.	Control Data Register (CDR): Holds the microinstruction fetched from control memory.\r\n4.	Sequencer: Determines the sequence of microinstructions.\r\nThis structure allows easy modification of control logic — simply by altering the microprogram stored in memory.\r\n\r\nModern Trends in Control Unit Design \r\n\r\nWith the rise of superscalar, pipelined, and multi-core processors, control unit design has evolved significantly.\r\nToday’s CUs integrate:\r\n•	Pipeline control mechanisms for parallel instruction execution\r\n•	Out-of-order execution handling\r\n•	Interrupt handling and exception control\r\n•	Micro-op fusion and dynamic scheduling\r\nThese advanced designs enhance performance and efficiency while maintaining precise instruction flow.\r\nApplications and Importance\r\nThe design of a control unit determines:\r\n•	How efficiently instructions are executed\r\n•	The processor’s speed and response time\r\n•	Its compatibility with different instruction sets\r\nFrom simple embedded systems to high-end processors, every computing device relies on the control unit’s intelligence to function effectively.\r\n\r\nConclusion\r\nThe Control Unit is the unsung hero of computer architecture — a silent coordinator that transforms binary instructions into meaningful actions.\r\nUnderstanding its design not only deepens one’s grasp of Computer Organization and Architecture (COA) but also builds the foundation for mastering processor design, embedded systems, and digital logic.\r\nAs computing continues to evolve, innovations in control unit design will remain central to achieving faster, smarter, and more efficient processors.', 'Riya Shaw, Co-Founder', 'VLSI', 'https://varshaaks.wordpress.com/wp-content/uploads/2020/10/abasiccomputer.gif', 'published', '2026-05-06', '2026-05-06 07:24:43', '2026-05-06 07:25:38');

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
  `student_id` int(11) NOT NULL,
  `enrollment_id` int(11) DEFAULT NULL,
  `certificate_id` varchar(50) NOT NULL COMMENT 'e.g. PP/05/26/482910 — generated by admin',
  `certificate_type` varchar(50) NOT NULL DEFAULT 'participation' COMMENT 'participation | internship | completion',
  `program_name` varchar(200) NOT NULL,
  `project_name` varchar(200) DEFAULT NULL,
  `duration` varchar(100) DEFAULT NULL COMMENT 'e.g. 3 Months',
  `mode` varchar(50) NOT NULL DEFAULT 'Offline',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `director_name` varchar(150) NOT NULL DEFAULT 'Shubhajit Kantossan',
  `coordinator_name` varchar(150) NOT NULL DEFAULT 'Mayukh Maitha',
  `issued_date` date NOT NULL DEFAULT curdate(),
  `status` enum('issued','revoked') NOT NULL DEFAULT 'issued',
  `qr_code_path` varchar(255) DEFAULT NULL COMMENT 'Filename only — stored in admin/uploads/qrcodes/',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Certificates issued via the admin panel';

--
-- Dumping data for table `certificates`
--

INSERT INTO `certificates` (`id`, `student_id`, `enrollment_id`, `certificate_id`, `certificate_type`, `program_name`, `project_name`, `duration`, `mode`, `start_date`, `end_date`, `director_name`, `coordinator_name`, `issued_date`, `status`, `qr_code_path`, `created_at`, `updated_at`) VALUES
(1, 15, 5, 'ML/05/26/835470', 'completion', '120-Hour Machine Learning Internship Program', 'SEISMOSENSE - INDIA DISASTER INTELLIGENCE PLATFORM', '133 hours', 'Offline', '2026-02-02', '2026-05-27', 'Dr. Shubhajit Kanti Das', 'Saikat Biswas', '2026-05-29', 'issued', 'qrcodes/qr_ML_05_26_835470.png', '2026-05-29 15:00:30', '2026-05-29 15:00:30');

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

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `client_name`, `client_type`, `contact_person`, `email`, `phone`, `address`, `city`, `state`, `country`, `gstin`, `pan`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(3, 'PLASTWRORK INDUSTRIES LLP', 'company', 'Suyash Moondhara', 'suyash.moondhara@plastwork.in', '+917838852428', 'Khasara No. 353, Jholungey, Mamring- Samardung Road, South Sikkim, PIN - 737137', 'Jholungey', 'South Sikkim', 'India', '', '', 'active', '', '2026-04-16 15:56:52', '2026-04-16 15:56:52'),
(4, 'Ranita Paul', 'individual', 'Ranita Paul', 'ranitapaul943@gmail.com', '8910971887', '', 'Barrackproe', 'WB', 'India', '', '', 'active', 'Auto-registered from student: 262702', '2026-05-15 08:09:48', '2026-05-20 10:05:06'),
(5, 'Soumodip Adhikary', 'individual', 'Soumodip Adhikary', 'soumodipadhikary574@gmail.com', '7477390994', '', 'Dumdum', 'WB', 'India', '', '', 'active', 'Auto-registered from student: 262703', '2026-05-16 10:59:09', '2026-05-20 10:05:20'),
(6, 'Kingston Education Institute', 'company', 'Sudipta Ghosh Sur', 'kpcprincipal@keical.edu.in', '+918336911917', 'KAJIBARI, BERUNANPUKURIA P.O. – MALIKAPUR, BARASAT, DIST. – 24 PGS. (N), KOLKATA – 700126', 'Barasat', 'WB', 'India', '', '', 'active', '', '2026-05-20 10:04:43', '2026-05-20 10:04:43'),
(7, 'PAYEL CHAKRABORTY', 'individual', 'PAYEL CHAKRABORTY', 'cpayel034@gmail.com', '7439328467', NULL, NULL, NULL, 'India', NULL, NULL, 'active', 'Auto-registered from student: 262701', '2026-05-20 10:28:29', '2026-05-20 10:28:29'),
(8, 'Debapriya Das - New Delhi institute of management', 'individual', '', 'priya261277@gmail.com', '+918130360101', 'D-7/7318, Vasant Kunj, South West Delhi, Delhi - 110070', 'New Delhi', 'Delhi', 'India', '', '', 'active', '', '2026-06-01 14:39:16', '2026-06-01 14:40:40');

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
(1, '120-Hour Machine Learning Internship Program', 'Comprehensive ML program covering Python, statistics, data wrangling, supervised/unsupervised learning, neural networks, NLP, deployment, and a capstone project. Hands-on with real datasets and industry-relevant tools.', '120 hours (approx. 8-12 weeks)', 'Online', 9500.00, 'Machine Learning', 'Araneus Faculty', NULL, 'ml_syllabus.pdf', 1, '2026-03-25 10:43:13', 'Internship Program', 'Python 3.x, Jupyter Notebook, Git/GitHub, NumPy, Pandas, Matplotlib, Seaborn, Scikit-learn, TensorFlow/Keras, SQLite, Flask (optional)', NULL, 'Certificate of Completion'),
(2, 'Internship on Full-Stack PHP 2026', 'Build complete database-driven web applications with HTML, CSS, JavaScript, Bootstrap, PHP, MySQL, and MVC pattern. Hands-on projects including Task Manager, Blog System, and a final capstone.', '60 Hours (approx. 10 weeks)', 'Hybrid', 4500.00, 'Web Development', 'Araneus Faculty', NULL, 'php_syllabus.pdf', 1, '2026-03-25 10:43:13', 'Internship', 'HTML5, CSS3, JavaScript, Bootstrap 4/5, PHP 8, MySQL, phpMyAdmin, Git, VS Code', NULL, 'Certificate of Completion'),
(3, 'Internship on JS Full Stack 2026 (MEARN Stack)', 'Master full-stack development with MongoDB, Express.js, Angular, React, Node.js. Build a complete backend API, then create two separate front-end applications (React and Angular) that connect to the same API. Covers authentication, deployment, and a final capstone project.', '60 Hours (approx. 10-12 weeks)', 'Online', 7500.00, 'Web Development', 'Araneus Faculty', NULL, 'js_syllabus.pdf', 1, '2026-03-25 10:43:13', 'Internship', 'Node.js, Express.js, MongoDB, Mongoose, React, Angular, TypeScript, RxJS, JWT, Postman, Git, Vercel/Netlify, Render/Cyclic', NULL, 'Certificate of Completion'),
(4, 'IoT Product Engineering & Simulation (IPES-Lab) Integrated Training & Internship Program', 'Comprehensive IoT program covering Python, Tkinter GUI, MQTT protocol, Proteus simulation, embedded systems (Arduino), and React Native mobile app development. Includes four minor projects and a major real-life project with progressive simulation and physical implementation.', '200+ hours (Training + Internship)', 'Hybrid', 12000.00, 'IoT & Embedded Systems', 'Araneus Faculty', NULL, 'ipes_syllabus.pdf', 1, '2026-03-25 10:43:13', 'Training & Internship', 'Python 3.x, Tkinter, Paho-MQTT, Eclipse Mosquitto, Proteus Design Suite, Arduino IDE, React Native, Node.js, Firebase/Thingspeak (optional)', 'Arduino Uno/Nano, ESP32 Development Board, Sensor Kit (DHT11, IR, PIR, etc.), Relay module, Breadboard, jumper wires (shared)', 'Certificate of Completion'),
(5, 'Python Power: Complete 120-Hour Training Program', 'Comprehensive Python training covering foundations, NumPy, Pandas, Tkinter GUI development, Pygame, SQL, data visualization (Matplotlib/Seaborn), and introductory machine learning (Scikit-learn). Includes three module projects and a final integrated Business Intelligence System.', '120 hours', 'Hybrid', 7500.00, 'Python & Data Science', 'Araneus Faculty', NULL, 'python_power_syllabus.pdf', 1, '2026-04-16 14:22:54', 'Training Program', 'Python 3.8+, VS Code, Jupyter Notebook, NumPy, Pandas, Matplotlib, Seaborn, Scikit-learn, Tkinter, Pygame, SQLite, SQLAlchemy, Git', NULL, 'Certificate of Completion');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `type` enum('full-time','part-time','freelancer','intern') DEFAULT 'full-time',
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT 0.00,
  `join_date` date DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `role`, `type`, `email`, `phone`, `salary`, `join_date`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(2, 'SAIKAT BISWAS', 'CEO', 'full-time', 'saikatbiswas2811@gmail.com', '07044058292', 0.00, '2014-04-16', 'active', '', '2026-04-16 16:07:35', '2026-04-16 16:07:35');

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
(5, 15, 1, '2026-03-25', NULL, 'enrolled', NULL, 0, NULL, '', NULL, NULL, NULL, '2026-03-25 12:26:38'),
(6, 16, 5, '2025-11-15', NULL, 'enrolled', 'AA', 1, NULL, '', NULL, NULL, 'project_16_6_1778941913.pdf', '2026-04-16 14:46:06'),
(7, 18, 2, '2026-05-14', NULL, 'in_progress', NULL, 0, NULL, '', NULL, NULL, NULL, '2026-05-15 08:02:08'),
(8, 19, 2, '2026-05-14', NULL, 'in_progress', NULL, 0, NULL, '', NULL, NULL, NULL, '2026-05-15 08:02:27'),
(9, 20, 2, '2026-05-14', NULL, 'in_progress', NULL, 0, NULL, '', NULL, NULL, NULL, '2026-05-15 08:02:51');

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

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `invoice_number`, `client_id`, `invoice_date`, `due_date`, `po_number`, `sub_total`, `tax_amount`, `discount_amount`, `total_amount`, `amount_paid`, `balance_due`, `status`, `payment_terms`, `notes`, `created_at`, `updated_at`) VALUES
(3, 'INV-20260416-344', 3, '2026-04-16', '2026-04-20', 'NA', 14952.00, 0.00, 0.00, 14952.00, 0.00, 14952.00, 'sent', '', NULL, '2026-04-16 16:01:23', '2026-05-21 06:38:42'),
(4, 'INV-20260515-845', 4, '2026-03-17', '2026-03-17', '', 3900.00, 0.00, 400.00, 3500.00, 3500.00, 0.00, 'paid', '', '', '2026-05-15 08:09:48', '2026-05-15 08:21:58'),
(5, 'INV-20260516-395', 5, '2026-03-16', '2026-03-17', '', 3900.00, 0.00, 400.00, 3500.00, 3500.00, 0.00, 'paid', '', '', '2026-05-16 11:01:31', '2026-05-16 11:03:07'),
(7, 'INV-20260520-564', 7, '2026-05-14', '2026-05-15', '', 3900.00, 0.00, 1900.00, 2000.00, 2000.00, 0.00, 'paid', '', '', '2026-05-20 10:28:54', '2026-05-20 10:29:35'),
(8, 'INV-20260522-661', 6, '2025-03-25', '2025-03-30', 'NA', 9035.00, 1626.30, 0.00, 10661.30, 0.00, 10661.30, 'sent', '', '', '2026-05-22 07:34:29', '2026-05-22 09:44:34'),
(9, 'INV-20260601-379', 8, '2025-04-16', '2025-04-20', '', 445000.00, 0.00, 0.00, 445000.00, 0.00, 445000.00, 'draft', '', '', '2026-06-01 14:41:48', '2026-06-01 14:41:48'),
(10, 'INV-20260601-820', 8, '2025-04-02', '2025-04-30', '', 245000.00, 0.00, 0.00, 245000.00, 0.00, 245000.00, 'draft', '', '', '2026-06-01 14:44:57', '2026-06-01 14:44:57'),
(11, 'INV-20260601-725', 8, '2026-04-15', '2026-04-25', '', 15000.00, 0.00, 0.00, 15000.00, 0.00, 15000.00, 'draft', '', '', '2026-06-01 14:47:38', '2026-06-01 14:47:38');

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

--
-- Dumping data for table `invoice_items`
--

INSERT INTO `invoice_items` (`id`, `invoice_id`, `product_service_id`, `description`, `quantity`, `unit_price`, `gst_rate`, `tax_amount`, `total_amount`, `created_at`) VALUES
(2, 3, 2, 'plastwork.in maintainance and bug fixing 1/04/2025 - 31/03/2026', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-04-16 16:01:23'),
(3, 3, 3, 'Domain monitoring (SSL installatioan and monitoring)', 12.00, 279.00, 0.00, 0.00, 3348.00, '2026-04-16 16:01:23'),
(4, 3, 4, 'Email Maintainance', 12.00, 399.00, 0.00, 0.00, 4788.00, '2026-04-16 16:01:23'),
(5, 3, 5, 'Hosting Management', 12.00, 389.00, 0.00, 0.00, 4668.00, '2026-04-16 16:01:23'),
(6, 3, 6, 'Webiste backup and 2FA', 12.00, 179.00, 0.00, 0.00, 2148.00, '2026-04-16 16:01:23'),
(7, 4, 7, 'Course Fee: Internship on Full-Stack PHP 2026', 1.00, 3900.00, 0.00, 0.00, 3900.00, '2026-05-15 08:09:48'),
(8, 5, 7, 'Course Fee: Internship on Full-Stack PHP 2026', 1.00, 3900.00, 0.00, 0.00, 3900.00, '2026-05-16 11:01:31'),
(10, 7, 7, 'Course Fee: Internship on Full-Stack PHP 2026', 1.00, 3900.00, 0.00, 0.00, 3900.00, '2026-05-20 10:28:54'),
(11, 8, 9, 'Purchase of Electronic Components from Haque Electronics, INV No.: 14 Dated: 22.03.2025', 1.00, 9035.00, 18.00, 1626.30, 10661.30, '2026-05-22 07:34:29'),
(12, 9, 10, 'Geospatial AI App Development,Node.js / Express.js Backend API,Firebase Integration,AI / ML Microservice — Python FastAPI server hosting 3 trained ML models', 1.00, 445000.00, 0.00, 0.00, 445000.00, '2026-06-01 14:41:48'),
(13, 10, 11, 'Third-Party API Integration,SOS Emergency Module,Twilio SMS API Integration, SRS document, Other Technicallities', 1.00, 245000.00, 0.00, 0.00, 245000.00, '2026-06-01 14:44:57'),
(14, 11, 12, 'Geospatial Application Testing', 1.00, 15000.00, 0.00, 0.00, 15000.00, '2026-06-01 14:47:38');

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

--
-- Dumping data for table `job_openings`
--

INSERT INTO `job_openings` (`id`, `title`, `department`, `location`, `employment_type`, `description`, `requirements`, `responsibilities`, `benefits`, `is_active`, `posted_date`, `application_deadline`, `views`, `created_at`) VALUES
(2, 'Microsoft Office Intern', 'Data Entry', 'WFH', 'internship', 'Simple PPT making work.', 'MS Office,', 'making 15 - 20 PPT per day', 'Fixed Salary + Overtime Bonus.', 1, '2026-05-06', NULL, 0, '2026-05-06 07:29:27');

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

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `invoice_id`, `payment_date`, `payment_method`, `transaction_id`, `amount`, `notes`, `created_at`) VALUES
(2, 4, '2026-05-15', 'bank_transfer', '234567890', 3500.00, '', '2026-05-15 08:21:58'),
(3, 5, '2026-05-16', 'bank_transfer', '22', 3500.00, '', '2026-05-16 11:03:07'),
(4, 7, '2026-05-15', 'cash', '', 2000.00, '', '2026-05-20 10:29:35');

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

--
-- Dumping data for table `products_services`
--

INSERT INTO `products_services` (`id`, `name`, `type`, `category`, `description`, `unit_price`, `gst_rate`, `hsn_sac_code`, `unit`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'plastwork.in maintainance and bug fixing 1/04/2025 - 31/03/2026', 'service', NULL, NULL, 0.00, 0.00, NULL, 'unit', 1, '2026-04-16 16:01:23', '2026-04-16 16:01:23'),
(3, 'Domain monitoring (SSL installatioan and monitoring)', 'service', NULL, NULL, 279.00, 0.00, NULL, 'unit', 1, '2026-04-16 16:01:23', '2026-04-16 16:01:23'),
(4, 'Email Maintainance', 'service', NULL, NULL, 399.00, 0.00, NULL, 'unit', 1, '2026-04-16 16:01:23', '2026-04-16 16:01:23'),
(5, 'Hosting Management', 'service', NULL, NULL, 389.00, 0.00, NULL, 'unit', 1, '2026-04-16 16:01:23', '2026-04-16 16:01:23'),
(6, 'Webiste backup and 2FA', 'service', NULL, NULL, 179.00, 0.00, NULL, 'unit', 1, '2026-04-16 16:01:23', '2026-04-16 16:01:23'),
(7, 'Course Fee: Internship on Full-Stack PHP 2026', 'service', NULL, NULL, 3900.00, 0.00, NULL, 'unit', 1, '2026-05-15 08:09:48', '2026-05-15 08:09:48'),
(8, 'E-Cleaning Device automation Development Software Development', 'service', NULL, NULL, 0.00, 18.00, NULL, 'unit', 1, '2026-05-20 10:27:14', '2026-05-20 10:27:14'),
(9, 'Purchase of Electronic Components from Haque Electronics, INV No.: 14 Dated: 22.03.2025', 'service', NULL, NULL, 9035.00, 18.00, NULL, 'unit', 1, '2026-05-22 07:34:29', '2026-05-22 07:34:29'),
(10, 'Geospatial AI App Development,Node.js / Express.js Backend API,Firebase Integration,AI / ML Microservice — Python FastAPI server hosting 3 trained ML models', 'service', NULL, NULL, 445000.00, 0.00, NULL, 'unit', 1, '2026-06-01 14:41:48', '2026-06-01 14:41:48'),
(11, 'Third-Party API Integration,SOS Emergency Module,Twilio SMS API Integration, SRS document, Other Technicallities', 'service', NULL, NULL, 245000.00, 0.00, NULL, 'unit', 1, '2026-06-01 14:44:57', '2026-06-01 14:44:57'),
(12, 'Geospatial Application Testing', 'service', NULL, NULL, 15000.00, 0.00, NULL, 'unit', 1, '2026-06-01 14:47:38', '2026-06-01 14:47:38');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL DEFAULT '',
  `description` text DEFAULT NULL,
  `tags` varchar(500) DEFAULT NULL COMMENT 'Comma-separated tag list',
  `image_url` varchar(500) DEFAULT NULL COMMENT 'Cover image URL or relative path',
  `color` varchar(20) DEFAULT '#ff4000' COMMENT 'Accent hex colour for card badge',
  `media` text DEFAULT NULL COMMENT 'JSON: [{type,url,label}]',
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `status` enum('published','draft') NOT NULL DEFAULT 'published',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `title`, `category`, `description`, `tags`, `image_url`, `color`, `media`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Plastwork – Industrial Plastics Platform', 'Web Development', 'A full-featured B2B marketplace and product catalogue for an industrial plastics manufacturer. Built with custom PHP backend, responsive UI, and an integrated enquiry management system.', 'PHP,MySQL,Bootstrap 5,REST API', 'https://plastwork.in/assets/img/loading_logo.jpeg', '#ff4000', '[{\"type\":\"link\",\"url\":\"https://plastwork.in\",\"label\":\"Live Site\"}]', 1, 'published', '2026-05-14 16:55:46', '2026-05-14 16:55:46'),
(2, 'Araneus Student Portal', 'EdTech Platform', 'A complete student lifecycle management portal — enrollment, course delivery, assignment submission with file uploads, attendance tracking, grade management, and certificate generation with QR verification.', 'PHP,MySQL,Bootstrap 5,AJAX', 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=800&q=80', '#0f3460', '[{\"type\":\"link\",\"url\":\"https://araneus.plastwork.in/pages/home.php\",\"label\":\"Live Site\"}]', 2, 'published', '2026-05-14 16:55:46', '2026-05-14 16:55:46'),
(3, 'Salesforce CRM Implementation', 'Business Solutions', 'End-to-end Salesforce Sales Cloud implementation for a mid-size manufacturing firm — custom objects, automated workflows, reporting dashboards, and staff training program.', 'Salesforce,CRM,Apex,LWC', 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=800&q=80', '#00a1e0', '[{\"type\":\"link\",\"url\":\"#\",\"label\":\"Case Study\"}]', 3, 'published', '2026-05-14 16:55:46', '2026-05-14 16:55:46'),
(4, 'Oracle ERP – Finance & Inventory Module', 'ERP Solutions', 'Configured and deployed Oracle E-Business Suite for a distribution company. Covers GL, AP/AR, fixed assets, inventory control, and custom management reporting.', 'Oracle EBS,SQL,PL/SQL,Finance', 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=800&q=80', '#c74634', '[{\"type\":\"link\",\"url\":\"#\",\"label\":\"Case Study\"}]', 4, 'published', '2026-05-14 16:55:46', '2026-05-14 16:55:46'),
(5, 'GST & E-Invoicing Integration', 'Compliance Tech', 'Automated GST filing and IRP-compliant e-invoicing pipeline integrated directly with the client\'s existing ERP. Reduced manual effort by 80% and eliminated filing errors.', 'GST,E-Invoice,IRP API,Python', 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?auto=format&fit=crop&w=800&q=80', '#1d9e75', '[{\"type\":\"link\",\"url\":\"#\",\"label\":\"Case Study\"}]', 5, 'published', '2026-05-14 16:55:46', '2026-05-14 16:55:46'),
(6, 'Devtiplast – Polymer Industry Site', 'Web Development', 'Corporate website and product showcase for a polymer products manufacturer — built with SEO-optimised architecture, enquiry forms, product galleries, and admin content panel.', 'PHP,MySQL,Bootstrap,SEO', 'https://devtiplast.com/wp-content/uploads/2026/01/cropped-cropped-WhatsApp-Image-2025-12-20-at-1.00.20-PM.jpeg', '#6f42c1', '[{\"type\":\"link\",\"url\":\"https://devtiplast.com\",\"label\":\"Live Site\"}]', 6, 'published', '2026-05-14 16:55:46', '2026-05-14 16:55:46');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `created_at`, `updated_at`) VALUES
(1, 'company_name', 'Araneus Edutech LLP.', '2026-03-22 19:43:03', '2026-03-25 10:29:15'),
(2, 'company_email', 'araneusedutech@gmail.com', '2026-03-22 19:43:03', '2026-03-25 10:29:31'),
(3, 'company_phone', '+919874291460', '2026-03-22 19:43:03', '2026-04-16 16:05:32'),
(4, 'company_address', '116/56/E/N, East Chandmari, 3rd Lane, Barrackpore, PO: NCP, PS: Titagarh, Kolkata - 700122', '2026-03-22 19:43:03', '2026-04-16 16:05:32'),
(5, 'company_city', 'Barrackpore, Kolkata', '2026-03-22 19:43:03', '2026-04-16 16:05:32'),
(6, 'company_state', 'West Bengal', '2026-03-22 19:43:03', '2026-04-16 16:05:32'),
(7, 'company_pincode', '700122', '2026-03-22 19:43:03', '2026-04-16 16:05:32'),
(8, 'company_gstin', '', '2026-03-22 19:43:03', '2026-03-22 19:43:03'),
(9, 'company_pan', 'AAXFB1706D', '2026-03-22 19:43:03', '2026-04-16 16:05:32'),
(10, 'company_website', 'https://araneus.plastwork.in/', '2026-03-22 19:43:03', '2026-04-16 16:05:32'),
(11, 'company_tagline', '', '2026-03-22 19:43:03', '2026-03-22 19:43:03'),
(12, 'bank_name', 'STATE BANK OF INDIA', '2026-03-22 19:43:03', '2026-04-16 16:06:06'),
(13, 'bank_account', '38904707477', '2026-03-22 19:43:03', '2026-04-16 16:06:06'),
(14, 'bank_ifsc', 'SBIN0001770', '2026-03-22 19:43:03', '2026-04-16 16:06:06'),
(15, 'bank_branch', 'ANANDAPURI', '2026-03-22 19:43:03', '2026-04-16 16:06:06');

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
(15, '252613', 'RUPSHA SAHA', '9123317563', 'rupshasaha005@gmail.com', '$2y$10$Kd9o4E2dAxjoECZruh7L8u6.rRIMnBsAq3SDApT5a.IPlDjMH0xkS', 'Samar Kumar  Saha', 133, '\"Siddhanta Para Main Road , Barrackpore \r\nKolkata  : 700122   state  : West Bengal \r\nDist : North 24 parganas , post office  :  Nonachandanpukur, KOL - 700122', 'HS', 'TI BCA DAA', NULL, '', NULL, '1779349264_15.jpeg', 'active', '2026-05-29 11:40:09', 1, 'd47126705869a51d2abb0d13ee853cd645d7205c17dd174e8189fbfc5b1f1c67', NULL, NULL, '2026-03-25 12:23:51', '2026-05-29 15:40:09'),
(16, '252608', 'Neha Das', '9830440551', 'n9770900@gmail.com', '$2y$10$yTED2my.mSd3e59.w8Zu8OxNgKjkJ.t1Oggv5eWEyqzk545/JbvP2', '', 68, 'Madanpur,Masunda, Amdanga, North 24 Parganas,West Bengal, PIN - 743711', 'HS', 'KCS BCA H', NULL, 'https://github.com/', NULL, NULL, 'active', '2026-05-16 11:17:27', 1, 'e9c88450967f17b18e2d423f0a2fe38720778f6a6c77b398edeaa6a40bb532c9', NULL, NULL, '2026-04-16 05:51:40', '2026-05-16 15:17:27'),
(17, '252609', 'Tripan Nandi', '7001984201', 'tripannandi266@gmail.com', '$2y$10$B6paMkFekk.k0ASCKyaHu.TvV2EAtQg/jjZiunC8zWpSu4gcgkcD6', 'Tapan KR nandi', 6, 'Basirhat College , P.O. Basirhat, Pin Code: 743412, West Bengal. North 24 Parganas district, PIN - 743412', 'HS', 'KCS BCA H', NULL, 'https://github.com/', NULL, NULL, 'active', NULL, 1, NULL, NULL, NULL, '2026-04-16 15:34:55', '2026-04-16 15:34:55'),
(18, '262701', 'PAYEL CHAKRABORTY', '7439328467', 'cpayel034@gmail.com', '$2y$10$4Q93F6j8s2oj0bkpAt0/4..6dzS4IGO6IWWRIMLpNm2H4LwSrWbnm', 'Prosenjt Chakraborty', 69, 'Barrackpore', 'BCA', 'Techno India Salt Lake', NULL, '', NULL, NULL, 'active', '2026-06-04 11:37:32', 1, NULL, NULL, NULL, '2026-05-15 07:29:15', '2026-06-04 15:38:38'),
(19, '262702', 'Ranita Paul', '8910971887', 'ranitapaul943@gmail.com', '$2y$10$aNsJjpzhy/gv46QChgmGL.d08JBt90MWVSJ.BMZYl3JuAb6vzIw7i', 'Ram joy Paul', 69, '19, Sukanta sarani Barrackpore', 'BCA', 'Techno India Saltlake', NULL, '', NULL, NULL, 'active', '2026-06-05 06:35:56', 1, NULL, NULL, NULL, '2026-05-15 08:00:08', '2026-06-05 10:35:56'),
(20, '262703', 'Soumodip Adhikary', '7477390994', 'soumodipadhikary574@gmail.com', '$2y$10$myog.IgFPntlDFJjkibeD.xhwYl0N.nva6sHu85iMjKj5ursRDTam', 'Samir Adhikary', 69, 'West Bengal, Midnapure,ashok Nagar', 'BCA', 'SRM', NULL, '', NULL, NULL, 'active', '2026-06-04 11:35:33', 1, NULL, NULL, NULL, '2026-05-15 08:01:34', '2026-06-04 15:36:46');

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
(2, 'admin', '$2y$10$1rYuoRKgwCpz4DxQJWziHedjbVfmT37R0jHDiu9oEK0lRMQjz7HjK', 'saikatbiswas2811@gmail.com', 'admin', 'SAIKAT BISWAS', 'active', '2026-06-05 07:23:00', '2026-03-21 13:24:32'),
(3, 'Shaw', '$2y$10$TQaMIyCx3g3Q.HG.Qw23ve.N8ATGwIEq748pCvPAQolvgTFLI4MY6', 'shaw.riya@gmail.com', 'staff', 'Riya', 'active', '2026-03-22 20:54:30', '2026-03-21 14:03:48');

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
  ADD UNIQUE KEY `certificate_id` (`certificate_id`),
  ADD UNIQUE KEY `uq_certificate_id` (`certificate_id`),
  ADD KEY `idx_student_id` (`student_id`),
  ADD KEY `idx_enrollment_id` (`enrollment_id`),
  ADD KEY `idx_status` (`status`);

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
-- Indexes for table `employees`
--
ALTER TABLE `employees`
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
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_category` (`category`),
  ADD KEY `idx_sort` (`sort_order`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `career_applications`
--
ALTER TABLE `career_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `contact_submissions`
--
ALTER TABLE `contact_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `job_openings`
--
ALTER TABLE `job_openings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products_services`
--
ALTER TABLE `products_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `submissions`
--
ALTER TABLE `submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
-- Constraints for table `certificates`
--
ALTER TABLE `certificates`
  ADD CONSTRAINT `fk_cert_enrollment` FOREIGN KEY (`enrollment_id`) REFERENCES `enrollments` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cert_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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

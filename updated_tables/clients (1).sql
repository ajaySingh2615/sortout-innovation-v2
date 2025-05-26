-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2025 at 01:16 PM
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
-- Database: `u469276866_sortout`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `followers` varchar(50) DEFAULT NULL,
  `category` enum('Dating App Host','Video Live Streamers','Voice Live Streamers','Singer','Dancer','Actor / Actress','Model','Artist / Painter','Social Media Influencer','Content Creator','Vlogger','Gamer / Streamer','YouTuber','Anchor / Emcee / Host','DJ / Music Producer','Photographer / Videographer','Makeup Artist / Hair Stylist','Fashion Designer / Stylist','Fitness Trainer / Yoga Instructor','Motivational Speaker / Life Coach','Chef / Culinary Artist','Child Artist','Pet Performer / Pet Model','Instrumental Musician','Director / Scriptwriter / Editor','Voice Over Artist','Magician / Illusionist','Stand-up Comedian','Mimicry Artist','Poet / Storyteller','Language Trainer / Public Speaking Coach','Craft Expert / DIY Creator','Travel Blogger / Explorer','Astrologer / Tarot Reader','Educator / Subject Matter Expert','Tech Reviewer / Gadget Expert','Unboxing / Product Reviewer','Business Coach / Startup Mentor','Health & Wellness Coach','Event Anchor / Wedding Host') DEFAULT NULL,
  `influencer_category` text DEFAULT NULL,
  `influencer_type` varchar(255) DEFAULT NULL,
  `instagram_profile` varchar(500) DEFAULT NULL,
  `expected_payment` varchar(255) DEFAULT NULL,
  `work_type_preference` text DEFAULT NULL,
  `language` varchar(255) NOT NULL,
  `professional` enum('Artist','Employee') NOT NULL,
  `image_url` varchar(500) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `experience` varchar(50) DEFAULT NULL,
  `approval_status` enum('pending','approved','rejected') DEFAULT 'pending',
  `approved_by` int(11) DEFAULT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `rejected_by` int(11) DEFAULT NULL,
  `rejected_at` datetime DEFAULT NULL,
  `city` enum('Mumbai','Delhi','Bangalore','Hyderabad','Ahmedabad','Chennai','Kolkata','Surat','Pune','Jaipur','Lucknow','Kanpur','Nagpur','Indore','Thane','Bhopal','Visakhapatnam','Pimpri and Chinchwad','Patna','Vadodara','Ghaziabad','Ludhiana','Agra','Nashik','Faridabad','Meerut','Rajkot','Kalyan and Dombivali','Vasai Virar','Varanasi','Srinagar','Aurangabad','Dhanbad','Amritsar','Navi Mumbai','Allahabad','Haora','Ranchi','Gwalior','Jabalpur','Coimbatore','Vijayawada','Jodhpur','Madurai','Raipur','Kota','Chandigarh','Guwahati','Solapur','Hubli and Dharwad','Bareilly','Mysore','Moradabad','Gurgaon','Aligarh','Jalandhar','Tiruchirappalli','Bhubaneswar','Salem','Mira and Bhayander','Thiruvananthapuram','Bhiwandi','Saharanpur','Gorakhpur','Guntur','Amravati','Bikaner','Noida','Jamshedpur','Bhilai Nagar','Warangal','Cuttack','Firozabad','Kochi','Bhavnagar','Dehradun','Durgapur','Asansol','Nanded Waghala','Kolapur','Ajmer','Gulbarga','Loni','Ujjain','Siliguri','Ulhasnagar','Jhansi','Sangli Miraj Kupwad','Jammu','Nellore','Mangalore','Belgaum','Jamnagar','Tirunelveli','Malegaon','Gaya','Ambattur','Jalgaon','Udaipur','Maheshtala','Tiruppur','Davanagere','Kozhikode','Kurnool') NOT NULL DEFAULT 'Mumbai',
  `resume_url` varchar(255) DEFAULT NULL,
  `current_salary` varchar(50) DEFAULT NULL,
  `is_visible` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `age`, `gender`, `followers`, `category`, `influencer_category`, `influencer_type`, `instagram_profile`, `expected_payment`, `work_type_preference`, `language`, `professional`, `image_url`, `created_at`, `experience`, `approval_status`, `approved_by`, `phone`, `email`, `role`, `rejected_by`, `rejected_at`, `city`, `resume_url`, `current_salary`, `is_visible`) VALUES
(107, 'one', 18, 'Male', '333K', 'Social Media Influencer', NULL, NULL, NULL, NULL, NULL, 'English,Bengali', 'Artist', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1741434553/client_images/aqxlptafnuh3m59pruad.png', '2025-03-08 11:49:13', '', 'rejected', NULL, '8808319836', NULL, '', 13, '2025-03-08 13:26:20', 'Mumbai', NULL, NULL, 1),
(108, 'two', 22, 'Male', '', '', NULL, NULL, NULL, NULL, NULL, 'English,Hindi', 'Employee', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1741434595/client_images/cpzyocrhzug9loryqdrk.jpg', '2025-03-08 11:49:54', '3', 'rejected', NULL, '8808319836', NULL, 'Chartered Accountant (CA)', 13, '2025-03-08 13:26:18', 'Mumbai', NULL, NULL, 1),
(110, 'Pooja', 25, 'Female', '22k', 'Social Media Influencer', NULL, NULL, NULL, NULL, NULL, 'Hindi', 'Artist', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1741436137/client_images/zt1aoqoldcsjjt1pdxeo.png', '2025-03-08 12:15:37', '', 'approved', 13, '7557474744', NULL, '', NULL, NULL, 'Mumbai', NULL, NULL, 1),
(112, 'Ajay Singh', 19, 'Male', '12K', '', NULL, NULL, NULL, NULL, NULL, 'English', 'Artist', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1741438643/client_images/uxjeecvmaobl3sfokqoj.png', '2025-03-08 12:57:24', '', 'rejected', NULL, '8808319836', NULL, '', 13, '2025-03-08 13:26:13', 'Mumbai', NULL, NULL, 1),
(113, 'Moumita Mukherjee', 25, 'Female', '125K', 'Social Media Influencer', NULL, NULL, NULL, NULL, NULL, 'Hindi,Bengali', 'Artist', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1741440328/client_images/rzlnrlgpgdu19mfre4os.png', '2025-03-08 13:25:29', '', 'approved', 13, '9330019437', NULL, '', NULL, NULL, 'Mumbai', NULL, NULL, 1),
(114, 'Naveena kapoor', 29, 'Female', '104K', 'Social Media Influencer', NULL, NULL, NULL, NULL, NULL, 'English,Hindi', 'Artist', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1741440734/client_images/lyy5pjekjt8ylzuprdzq.png', '2025-03-08 13:32:14', '', 'approved', 13, '7589304295', NULL, '', NULL, NULL, 'Mumbai', NULL, NULL, 1),
(115, 'Shambhavi Sharma', 26, 'Female', '103K', 'Social Media Influencer', NULL, NULL, NULL, NULL, NULL, 'English,Hindi', 'Artist', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1741441018/client_images/i3xqrb19yz9l3tf68tpz.png', '2025-03-08 13:36:58', '', 'approved', 13, '9145680978', NULL, '', NULL, NULL, 'Mumbai', NULL, NULL, 1),
(116, 'MUSKAAN MEHRA', 28, 'Female', '72.7K', 'Social Media Influencer', NULL, NULL, NULL, NULL, NULL, 'English,Hindi', 'Artist', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1741441304/client_images/kufnjneubyklq5dutmfy.png', '2025-03-08 13:41:45', '', 'approved', 13, '7678602883', NULL, '', NULL, NULL, 'Mumbai', NULL, NULL, 1),
(117, 'Arnav Mathur', 31, 'Male', '36.9K', 'Social Media Influencer', NULL, NULL, NULL, NULL, NULL, 'English,Hindi', 'Artist', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1741441584/client_images/zycyunwql6mdmar5m1tl.png', '2025-03-08 13:46:25', '', 'approved', 13, '8770806271', NULL, '', NULL, NULL, 'Mumbai', NULL, NULL, 1),
(118, 'Aishwarya Sanglikar', 26, 'Female', '189K', 'Social Media Influencer', NULL, NULL, NULL, NULL, NULL, 'English,Hindi', 'Artist', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1741441861/client_images/lg2n78vnqwg7g3akoy2g.png', '2025-03-08 13:51:02', '', 'approved', 13, '7744911820', NULL, '', NULL, NULL, 'Mumbai', NULL, NULL, 1),
(119, 'Dia Bajaj', 25, 'Female', '21.3K', 'Social Media Influencer', NULL, NULL, NULL, NULL, NULL, 'English,Hindi', 'Artist', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1741442129/client_images/afvjccywxfyhwrwm25es.png', '2025-03-08 13:55:29', '', 'approved', 13, '9999618050', NULL, '', NULL, NULL, 'Mumbai', NULL, NULL, 1),
(120, 'Niharika shara', 26, 'Female', '39.9K', 'Social Media Influencer', NULL, NULL, NULL, NULL, NULL, 'English,Hindi', 'Artist', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1741442399/client_images/wh7dw2mmejeujarlgfsh.png', '2025-03-08 14:00:00', '', 'approved', 13, '8360949432', NULL, '', NULL, NULL, 'Mumbai', NULL, NULL, 1),
(121, 'Manisha sharma', 27, 'Female', '154K', 'YouTuber', NULL, NULL, NULL, NULL, NULL, 'English,Hindi', 'Artist', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1741442705/client_images/vlxtj5why8jmhzhcacbz.png', '2025-03-08 14:05:06', '', 'approved', 13, '8360949432', NULL, '', NULL, NULL, 'Mumbai', NULL, NULL, 1),
(122, 'Iris Vatrana', 30, 'Female', '597K', 'YouTuber', NULL, NULL, NULL, NULL, NULL, 'English,Hindi', 'Artist', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1741444154/client_images/wb2cmxvtsxwpftghojmg.png', '2025-03-08 14:29:14', '', 'approved', 13, '9818737073', NULL, '', NULL, NULL, 'Mumbai', NULL, NULL, 1),
(123, 'Divya Belani', 24, 'Female', '974k', 'Social Media Influencer', NULL, NULL, NULL, NULL, NULL, 'English,Hindi', 'Artist', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1741444403/client_images/jsag3k5l9xe8renimgeb.png', '2025-03-08 14:33:24', '', 'approved', 13, '9307702889', NULL, '', NULL, NULL, 'Mumbai', NULL, NULL, 1),
(124, 'Aarushi Sharma', 27, 'Female', '38.2K', 'YouTuber', NULL, NULL, NULL, NULL, NULL, 'English,Hindi', 'Artist', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1741444756/client_images/p3yy43xogaznzsezyusn.png', '2025-03-08 14:39:16', '', 'approved', 13, '9417926769', NULL, '', NULL, NULL, 'Mumbai', NULL, NULL, 1),
(128, 'Khushi Gupta', 23, 'Female', '', '', NULL, NULL, NULL, NULL, NULL, 'English,Hindi', 'Employee', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1741609174/client_images/yvuua7haupztor7kmclo.png', '2025-03-10 12:19:35', '1', 'approved', 13, '9818559391', NULL, 'Human Resources Manager (HR Manager)', NULL, NULL, 'Gurgaon', NULL, NULL, 1),
(131, 'Kavita gupta', 26, 'Female', '25.9K', 'YouTuber', NULL, NULL, NULL, NULL, NULL, 'English,Hindi', 'Artist', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1741615135/client_images/n4vk3yhnaxbxcmlzoyah.png', '2025-03-10 13:58:56', '', 'approved', 13, '7619122830', NULL, '', NULL, NULL, 'Mumbai', NULL, NULL, 1),
(135, 'Riyu', 29, 'Female', '12k', 'Social Media Influencer', NULL, NULL, NULL, NULL, NULL, 'English,Hindi', 'Artist', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1741755722/client_images/na21hcbgcmqhwvbp49vt.jpg', '2025-03-12 05:02:03', '', 'approved', 13, '9560046000', NULL, '', NULL, NULL, 'Ludhiana', '', NULL, 1),
(136, 'Priya Sharma', 27, 'Female', '15k', 'Social Media Influencer', NULL, NULL, NULL, NULL, NULL, 'Hindi', 'Artist', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1741756205/client_images/rdgk8l3ahdubqccoddbm.jpg', '2025-03-12 05:10:05', '', 'approved', 13, '9560046000', NULL, '', NULL, NULL, 'Ludhiana', '', NULL, 1),
(137, 'Arisha', 20, 'Female', '55k', 'Social Media Influencer', NULL, NULL, NULL, NULL, NULL, 'Bengali', 'Artist', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1741763309/client_images/jtdff47doigwoie0a9ax.jpg', '2025-03-12 07:08:30', '', 'approved', 13, '9560046000', NULL, '', NULL, NULL, 'Kolkata', '', NULL, 1),
(138, 'Miss Tanu', 24, 'Female', '65k', 'Social Media Influencer', NULL, NULL, NULL, NULL, NULL, 'Hindi', 'Artist', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1741763773/client_images/lt7rzxg69nt7l97kfwb7.jpg', '2025-03-12 07:16:13', '', 'approved', 13, '9560046000', NULL, '', NULL, NULL, 'Ahmedabad', '', NULL, 1),
(139, 'Royel Babby', 22, 'Female', '12k', 'Social Media Influencer', NULL, NULL, NULL, NULL, NULL, 'Hindi', 'Artist', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1741764345/client_images/bg0zt9j9ervnsci2fiw5.jpg', '2025-03-12 07:25:45', '', 'approved', 13, '9560046000', NULL, '', NULL, NULL, 'Delhi', '', NULL, 1),
(140, 'Patolaaa', 23, 'Female', '44k', 'Social Media Influencer', NULL, NULL, NULL, NULL, NULL, 'Hindi', 'Artist', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1741771704/client_images/re74kabwqtdegbnt0mdx.jpg', '2025-03-12 09:28:24', NULL, 'approved', 13, '9560046000', NULL, NULL, NULL, NULL, 'Faridabad', NULL, NULL, 1),
(142, 'Aadil khan', 20, 'Male', '', '', NULL, NULL, NULL, NULL, NULL, 'English,Hindi', 'Employee', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1742215089/client_images/hkkkuruhh8o9s1wsqvwh.png', '2025-03-17 12:38:09', '2', 'approved', 13, '8059917302', NULL, 'Social Media Manager', NULL, NULL, 'Gurgaon', 'uploads/resumes/resume_67d817af3ced9_1742215087.pdf', NULL, 1),
(143, 'Shikha', 25, 'Female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Hindi', 'Employee', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1742215759/client_images/gt7kxobzbbrnkgutko2p.jpg', '2025-03-17 12:49:19', '3', 'approved', 13, '9654723158', NULL, 'Recruitment Specialist', NULL, NULL, 'Gurgaon', 'uploads/resumes/resume_67d81a4dd3cd7_1742215757.pdf', NULL, 1),
(144, 'aaaa', 34, 'Female', '333K', 'DJ / Music Producer', NULL, NULL, NULL, NULL, NULL, 'English', 'Artist', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1742222820/client_images/ofsl4lmag6gpozapeyle.jpg', '2025-03-17 14:47:00', '', 'rejected', NULL, '7007363453', NULL, '', 13, '2025-03-17 14:47:10', 'Jhansi', '', NULL, 1),
(145, 'Srishti', 23, 'Female', '', '', NULL, NULL, NULL, NULL, NULL, 'English,Hindi', 'Employee', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1742283929/client_images/migoecbal4mdh6gi33dl.jpg', '2025-03-18 07:45:29', '2', 'approved', 13, '9258419336', NULL, 'Telecaller', NULL, NULL, 'Gurgaon', 'uploads/resumes/resume_67d92497dc7cd_1742283927.pdf', NULL, 0),
(146, 'Riya Gupta', 24, 'Female', '', '', NULL, NULL, NULL, NULL, NULL, 'English,Hindi', 'Employee', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1742285410/client_images/jfvajigq4lvppzko7ce6.jpg', '2025-03-18 08:10:11', '1', 'approved', 13, '7974773502', NULL, 'Telecaller', NULL, NULL, 'Delhi', 'uploads/resumes/resume_67d92a60d3779_1742285408.docx', NULL, 1),
(147, 'Nishant Gupta', 31, 'Male', '', '', NULL, NULL, NULL, NULL, NULL, 'English,Hindi', 'Employee', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1742285437/client_images/jde2s3prpdsculeawf12.png', '2025-03-18 08:10:38', '8', 'approved', 13, '9648493666', NULL, 'Project Manager', NULL, NULL, 'Gurgaon', 'uploads/resumes/resume_67d92a7b67ddd_1742285435.pdf', NULL, 1),
(148, 'Nisha rani', 18, 'Female', '', '', NULL, NULL, NULL, NULL, NULL, 'Hindi', 'Employee', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1742363398/client_images/bhjwl1n9zp7h5rumogqv.jpg', '2025-03-19 05:49:59', '02', 'approved', 13, '9466986449', NULL, 'Telecaller', NULL, NULL, 'Delhi', 'uploads/resumes/resume_67da5b055e041_1742363397.pdf', NULL, 1),
(149, 'Rashmi', 21, 'Female', '', '', NULL, NULL, NULL, NULL, NULL, 'English', 'Employee', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1742370648/client_images/ucurw7gcpmzyafqeiiag.jpg', '2025-03-19 07:50:48', '1', 'approved', 13, '9696587275', NULL, 'Telecaller', NULL, NULL, 'Gurgaon', 'uploads/resumes/resume_67da77575b9c5_1742370647.pdf', NULL, 1),
(150, 'Smiley', 20, 'Female', '', 'Dating App Host', NULL, NULL, NULL, NULL, NULL, 'Hindi', 'Artist', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1742929807/client_images/ow0qqycebez7syxllflo.jpg', '2025-03-25 19:10:08', '', 'approved', 13, '9999999999', NULL, '', NULL, NULL, 'Kolkata', '', '', 1),
(151, 'kinu doll', 22, 'Female', '', 'Dating App Host', NULL, NULL, NULL, NULL, NULL, 'Hindi', 'Artist', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1742929964/client_images/dktpn4sbwd91o0xhp6xz.jpg', '2025-03-25 19:12:44', '', 'approved', 13, '9999999999', NULL, '', NULL, NULL, 'Kolkata', '', '', 1),
(152, 'Nandini Verma', 22, 'Female', '', '', NULL, NULL, NULL, NULL, NULL, 'English,Hindi,Punjabi', 'Employee', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1742968339/client_images/mbkevybmvjaloe7pevrj.jpg', '2025-03-26 05:52:20', '1', 'approved', 13, '7838035872', NULL, 'Talent Acquisition Manager', NULL, NULL, 'Gurgaon', 'uploads/resumes/resume_67e396121e884_1742968338.pdf', '29000', 1),
(153, 'MARY Singh', 35, 'Female', '', '', NULL, NULL, NULL, NULL, NULL, 'English,Hindi', 'Employee', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1742973574/client_images/anxjpidh3shwspn0da1s.jpg', '2025-03-26 07:19:35', '9', 'approved', 13, '7007558318', NULL, 'Human Resources Manager (HR Manager)', NULL, NULL, 'Delhi', 'uploads/resumes/resume_67e3aa85566a6_1742973573.pdf', '35500', 1),
(154, 'Dushyant Vats', 27, 'Male', '', '', NULL, NULL, NULL, NULL, NULL, 'English,Hindi,Punjabi', 'Employee', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1743074661/client_images/h7ln726marvbhlkdxn2x.jpg', '2025-03-27 11:24:22', '4', 'approved', 13, '7982224800', NULL, 'Graphic Designer', NULL, NULL, 'Faridabad', 'uploads/resumes/resume_67e5356418bc1_1743074660.pdf', '26500', 1),
(155, 'Aindrila Roy Datta', 25, 'Female', '', '', NULL, NULL, NULL, NULL, NULL, 'English,Hindi,Bengali', 'Employee', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1744367144/client_images/wwqhygorh8bwnbv5zj73.jpg', '2025-03-27 11:59:42', '2', 'approved', 13, '9073699832', NULL, 'School Principal', NULL, NULL, 'Delhi', 'uploads/resumes/resume_67e53dac6ccd7_1743076780.pdf', '28000', 1),
(156, 'Nisha', 23, 'Female', '1500', 'Model', NULL, NULL, NULL, NULL, NULL, 'English,Hindi', 'Artist', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1743186378/client_images/elzafpm5ejobar3avv7v.jpg', '2025-03-28 18:26:18', '', 'approved', 13, '9310961008', NULL, '', NULL, NULL, 'Delhi', '', '', 1),
(157, 'Nisha', 23, 'Female', '', '', NULL, NULL, NULL, NULL, NULL, 'English,Hindi', 'Employee', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1743186568/client_images/rzklr7is5eujqmexipsz.jpg', '2025-03-28 18:29:29', '1', 'approved', 13, '9310961008', NULL, 'Recruitment Specialist', NULL, NULL, 'Delhi', 'uploads/resumes/resume_67e6ea86ddd74_1743186566.pdf', '27', 1),
(158, 'Deepika', 26, 'Female', '', '', NULL, NULL, NULL, NULL, NULL, 'English,Hindi', 'Employee', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1743268601/client_images/i6zwsfupny1n93lotcxl.jpg', '2025-03-29 17:16:42', '2', 'approved', 13, '7303296139', NULL, 'Customer Support Executive', NULL, NULL, 'Delhi', 'uploads/resumes/resume_67e82af818f6c_1743268600.pdf', '26000', 0),
(159, 'Anushka', 24, 'Female', '', '', NULL, NULL, NULL, NULL, NULL, 'Hindi', 'Employee', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1744367270/client_images/dyqgbt0f8bsvdbieymeg.webp', '2025-03-29 19:19:32', '1', 'approved', 13, '7827268002', NULL, 'Executive Assistant', NULL, NULL, 'Patna', 'uploads/resumes/resume_67e847c236df6_1743275970.pdf', '280000', 1),
(160, 'Swati', 24, 'Female', '', '', NULL, NULL, NULL, NULL, NULL, 'Hindi', 'Employee', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1743304647/client_images/sggxvdijqjgygy9h31fx.jpg', '2025-03-30 03:17:28', '2', 'approved', 13, '8882874516', NULL, 'Sales Manager', NULL, NULL, 'Delhi', 'uploads/resumes/resume_67e8b7c5b44c7_1743304645.pdf', '17', 1),
(161, 'Teresa CynthiaSilvester', 50, 'Female', '', '', NULL, NULL, NULL, NULL, NULL, 'English,Hindi,Tamil,Malayalam', 'Employee', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1743318300/client_images/vclmjubempplntfxwmd7.png', '2025-03-30 07:05:01', '16', 'approved', 13, '8904334741', NULL, 'Operations Manager', NULL, NULL, 'Bangalore', 'uploads/resumes/resume_67e8ed1aa22c0_1743318298.pdf', '30000', 1),
(162, 'Amanpreet Sethi', 25, 'Female', '', '', NULL, NULL, NULL, NULL, NULL, 'English,Hindi', 'Employee', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1743751407/client_images/ju0jfcgfd0hr8vq4qeil.jpg', '2025-04-04 07:23:27', '3', 'approved', 13, '9318417676', NULL, 'Telecaller', NULL, NULL, 'Gurgaon', 'uploads/resumes/resume_67ef88ec9e833_1743751404.pdf', '35000', 1),
(164, 'Ajay', 26, 'Male', '', '', NULL, NULL, NULL, NULL, NULL, 'English,Hindi', 'Employee', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1744264844/client_images/y7slaf8ilziwgmmdjfnx.jpg', '2025-04-10 06:00:44', '5', 'approved', 13, '7838113429', NULL, 'Financial Analyst', NULL, NULL, 'Gurgaon', 'uploads/resumes/resume_67f75e896589d_1744264841.pdf', '24000', 1),
(165, 'Simran kour', 21, 'Female', '', '', NULL, NULL, NULL, NULL, NULL, 'English,Hindi,Punjabi', 'Employee', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1744267321/client_images/stbtpq7glvqlaepalbhh.jpg', '2025-04-10 06:42:01', '2', 'approved', 13, '8302975772', NULL, 'Telecaller', NULL, NULL, 'Gurgaon', 'uploads/resumes/resume_67f768370ee8a_1744267319.pdf', '30 k', 1),
(166, 'Nidhi Singh', 25, 'Female', '', '', NULL, NULL, NULL, NULL, NULL, 'English,Hindi', 'Employee', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1744278716/client_images/lao5t0enbhuzaphjqyfr.jpg', '2025-04-10 09:51:56', '3', 'approved', 13, '7268922971', NULL, 'Customer Support Executive', NULL, NULL, 'Gurgaon', 'uploads/resumes/resume_67f794ba1c687_1744278714.pdf', '18000', 1),
(167, 'Ajay Kumar', 24, 'Male', '', '', NULL, NULL, NULL, NULL, NULL, 'English,Hindi', 'Employee', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1744278845/client_images/vqqz9yzisw0scrnt49qz.jpg', '2025-04-10 09:54:04', '1', 'approved', 13, '8194003683', NULL, 'Customer Support Executive', NULL, NULL, 'Gurgaon', 'uploads/resumes/resume_67f7953a76acf_1744278842.pdf', '18000', 1),
(168, 'test1', 23, 'Male', '', '', NULL, NULL, NULL, NULL, NULL, 'English', 'Employee', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1744357846/client_images/jvwnk5v3fgqx00fp77db.jpg', '2025-04-11 07:50:46', '2', 'rejected', NULL, '8808319836', NULL, 'Social Media Manager', 13, '2025-04-11 09:02:46', 'Lucknow', 'uploads/resumes/resume_67f8c9d299ffa_1744357842.pdf', '550000', 1),
(169, 'Abhay singh', 21, 'Male', '', '', NULL, NULL, NULL, NULL, NULL, 'English,Hindi', 'Employee', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1744362359/client_images/vii0ce8d23vxh7bgyp2f.jpg', '2025-04-11 09:05:59', '1', 'approved', 13, '7570009757', NULL, 'Telecaller', NULL, NULL, 'Gurgaon', 'uploads/resumes/resume_67f8db744720f_1744362356.pdf', '23,000', 1),
(170, 'Lajwanti', 25, 'Female', '', '', NULL, NULL, NULL, NULL, NULL, 'English,Hindi', 'Employee', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1744373777/client_images/oxwirhw7f916jdcb52di.jpg', '2025-04-11 12:16:17', '1', 'approved', 13, '8814829719', NULL, 'Telecaller', NULL, NULL, 'Gurgaon', 'uploads/resumes/resume_67f9080f9472e_1744373775.pdf', '20000', 1),
(171, 'Abhay kumar', 24, 'Male', '', '', NULL, NULL, NULL, NULL, NULL, 'English,Hindi', 'Employee', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1744447549/client_images/gqakoqlwsbaizjq8vcvi.jpg', '2025-04-12 08:45:49', '0', 'approved', 13, '6398104315', NULL, 'Digital Marketing Manager', NULL, NULL, 'Moradabad', 'uploads/resumes/resume_67fa283ba01a3_1744447547.pdf', '0', 1),
(172, 'Arpita Gehlot', 21, 'Female', '', '', NULL, NULL, NULL, NULL, NULL, 'English,Hindi', 'Employee', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1744447630/client_images/eu4jg2fx9uxihjx4mrxk.jpg', '2025-04-12 08:47:10', '0', 'approved', 13, '6378595456', NULL, 'Software Engineer', NULL, NULL, 'Ajmer', 'uploads/resumes/resume_67fa288c66923_1744447628.pdf', '0', 1),
(173, 'Manisha Kumari', 24, 'Female', '2K', 'Social Media Influencer', NULL, NULL, NULL, NULL, NULL, 'English', 'Artist', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1744481565/client_images/bdn0ahhaqrwwmw2tjzwf.jpg', '2025-04-12 18:12:45', '', 'approved', 13, '8979975022', NULL, '', NULL, NULL, 'Agra', '', '', 1),
(174, 'Riya nagar', 24, 'Female', '', '', NULL, NULL, NULL, NULL, NULL, 'English,Hindi', 'Employee', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1744613853/client_images/tfgnvk3gbungqkw0zw8l.jpg', '2025-04-14 06:57:33', '4', 'approved', 13, '8287037010', NULL, 'Sales Manager', NULL, NULL, 'Delhi', 'uploads/resumes/resume_67fcb1d9a7f43_1744613849.pdf', '26000', 1),
(175, 'Aradhna', 22, 'Female', '', '', NULL, NULL, NULL, NULL, NULL, 'English,Hindi', 'Employee', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1744614020/client_images/uhsrxtq3vd3jzo5pkkfj.jpg', '2025-04-14 07:00:20', '3', 'approved', 13, '8447182844', NULL, 'Sales Manager', NULL, NULL, 'Delhi', 'uploads/resumes/resume_67fcb2813e809_1744614017.pdf', '25k', 1),
(176, 'Nargis bano', 23, 'Female', '', '', NULL, NULL, NULL, NULL, NULL, 'English,Hindi', 'Employee', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1744614854/client_images/vcicjzz4fsbu29x8ns6z.jpg', '2025-04-14 07:14:14', '3', 'approved', 13, '9899430459', NULL, 'Sales Manager', NULL, NULL, 'Delhi', 'uploads/resumes/resume_67fcb5c415a7e_1744614852.docx', '25', 1),
(177, 'Madhu asseya', 31, 'Female', '', '', NULL, NULL, NULL, NULL, NULL, 'English,Hindi', 'Employee', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1744627725/client_images/x7ua5xah1lej4atvsxy9.jpg', '2025-04-14 10:48:44', '2', 'approved', 13, '6265722554', NULL, 'Customer Support Executive', NULL, NULL, 'Gurgaon', 'uploads/resumes/resume_67fce80a8d4f2_1744627722.pdf', '18k', 1),
(178, 'Sabeena', 29, 'Female', '', '', NULL, NULL, NULL, NULL, NULL, 'English,Hindi', 'Employee', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1744628418/client_images/sug6u5wzkacvr4b6ch1m.jpg', '2025-04-14 11:00:18', '8', 'rejected', NULL, '9873017483', NULL, 'Operations Manager', 13, '2025-04-14 11:17:12', 'Faridabad', 'uploads/resumes/resume_67fceabf631f2_1744628415.pdf', '28', 1),
(179, 'Sabeena khatton', 29, 'Female', '', '', NULL, NULL, NULL, NULL, NULL, 'English,Hindi', 'Employee', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1744628493/client_images/vjl7bvdjfshhor1u28kz.jpg', '2025-04-14 11:01:32', '8', 'approved', 13, '9873017483', NULL, 'Operations Manager', NULL, NULL, 'Faridabad', 'uploads/resumes/resume_67fceb098596f_1744628489.pdf', '28', 1),
(180, 'test10', 23, 'Male', '', '', NULL, NULL, NULL, NULL, NULL, 'English,Hindi', 'Employee', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1744874774/client_images/efa7ku74373flyvjvcqc.jpg', '2025-04-17 07:26:14', '3', 'approved', 13, '8808319836', NULL, 'Social Media Manager', NULL, NULL, 'Surat', 'uploads/resumes/resume_6800ad11c251f_1744874769.pdf', '300000', 1),
(181, 'nehaTest', 34, 'Male', '', '', NULL, NULL, NULL, NULL, NULL, 'English', 'Employee', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1744883514/client_images/nbais2jhbax7cigntoao.jpg', '2025-04-17 09:51:54', '2', 'pending', NULL, '8808319836', NULL, 'Marketing Manager', NULL, NULL, 'Chennai', 'uploads/resumes/resume_6800cf37c77f4_1744883511.pdf', '300000', 1),
(182, 'Ajay Singh', 23, 'Male', '', '', NULL, NULL, NULL, NULL, NULL, 'English', 'Employee', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1744883798/client_images/abuuvh1af0vdheuzwpkf.jpg', '2025-04-17 09:56:38', '3', 'rejected', NULL, '8808319836', NULL, 'Marketing Manager', 13, '2025-04-17 15:46:25', 'Nagpur', 'uploads/resumes/resume_6800d053bef9d_1744883795.docx', '15000', 1),
(183, 'finall test', 23, 'Male', '', '', NULL, NULL, NULL, NULL, NULL, 'English', 'Employee', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1744884749/client_images/txtfyxihi1w2yd6lxqzb.jpg', '2025-04-17 10:12:29', '2', 'pending', NULL, '9898767898', NULL, 'Operations Manager', NULL, NULL, 'Pune', 'uploads/resumes/resume_6800d40a59010_1744884746.docx', '18000', 1),
(184, 'ArtistFinalTest', 67, 'Male', '44k', 'YouTuber', NULL, NULL, NULL, NULL, NULL, 'Hindi', 'Artist', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1744884813/client_images/hp3nwzatl2vrn3dafxsb.jpg', '2025-04-17 10:13:33', '', 'pending', NULL, '8808319836', NULL, '', NULL, NULL, 'Lucknow', '', '', 1),
(185, 'aadilTest003', 34, 'Male', '23K', 'Vlogger', 'Comedy and Entertainment Influencers', 'Mega-influencers – with more than a million followers (think celebrities)', 'https://www.instagram.com/sortout_innovation/', 'Rs 70k to 1L', 'Vlogs (Video Blogs)', 'English,Hindi', 'Artist', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1748241686/client_images/g0bedhuex7pnb09dczhu.png', '2025-05-26 06:41:25', '', 'approved', 13, '9898767876', 'aadil@gmail.com', '', NULL, NULL, 'Surat', '', '', 1),
(186, 'Ajay_Singh_001', 34, 'Female', '', '', '', '', '', '', '', 'English', 'Employee', 'https://res.cloudinary.com/dcrk1fzah/image/upload/v1748252808/client_images/k5xsrgrchr0qqgewdjcd.png', '2025-05-26 09:46:48', '3', 'approved', NULL, '8808319836', '', 'Social Media Manager', NULL, NULL, 'Jaipur', 'uploads/resumes/resume_6834387bc237d_1748252795.pdf', '550000', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `approved_by` (`approved_by`),
  ADD KEY `idx_clients_email` (`email`),
  ADD KEY `idx_clients_influencer_type` (`influencer_type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

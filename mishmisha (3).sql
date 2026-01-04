-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 04, 2026 at 09:18 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mishmisha`
--

-- --------------------------------------------------------

--
-- Table structure for table `chapters`
--

CREATE TABLE `chapters` (
  `id` bigint UNSIGNED NOT NULL,
  `lesson_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `video_url` text COLLATE utf8mb4_unicode_ci,
  `video_url_ar` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chapters`
--

INSERT INTO `chapters` (`id`, `lesson_id`, `title`, `title_ar`, `icon`, `duration`, `deleted_at`, `created_at`, `updated_at`, `video_url`, `video_url_ar`) VALUES
(1, 1, 'Non ullamco et qui eaque id laboriosam quae proident facilis facilis qui animi in est', NULL, NULL, '50', NULL, '2025-12-03 17:58:24', '2025-12-03 17:58:24', NULL, NULL),
(2, 1, 'Molestias eiusmod mo', NULL, NULL, '20', NULL, '2025-12-07 21:37:57', '2025-12-07 21:37:57', NULL, NULL),
(3, 11, 'Nam alias neque soluta tenetur qui qui esse culpa et vel possimus dolore deleniti doloribus magnam', NULL, NULL, '30', NULL, '2025-12-07 21:45:56', '2025-12-07 21:45:56', NULL, NULL),
(4, 11, 'Enim quaerat adipisci error ut nisi dolor dolorem quod est', NULL, NULL, '40', NULL, '2025-12-07 21:46:03', '2025-12-07 21:46:03', NULL, NULL),
(5, 4, 'Voluptatem ex corporis molestiae nesciunt ut laudantium quia voluptatibus dolorem dolorem dolorum dolore reprehenderit aut', NULL, NULL, '48', NULL, '2025-12-09 23:15:54', '2025-12-23 13:49:15', 'courses/videos/01KD5YCHDFYKCKYQ2NWFTJ81AY.mp4', NULL),
(6, 1, 'Voluptatem ex corporis molestiae nesciunt ut laudantium quia voluptatibus dolorem dolorem dolorum dolore reprehenderit aut', NULL, NULL, '20', NULL, '2025-12-22 06:26:53', '2025-12-22 06:26:53', 'courses/videos/01KD2JP5RXV3E6M81HE6ZR4SDX.mp4', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `first_name`, `last_name`, `name`, `phone`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Cheyenne', 'Mcdonald', 'Cheyenne Mcdonald', '+1 (815) 463-9539', 'hoja@mailinator.com', NULL, '$2y$12$7Xl8DDNn6Osl0RnSW2CC7Oh5GMO4D1MEmVH6shHQ3a2lqEgetwXpG', NULL, '2025-12-30 23:40:38', '2025-12-30 23:40:38'),
(2, 'Eslam', 'Salah', 'Eslam Salah', '+201000907612', 'eslam.webdevlopre@gmail.com', NULL, '$2y$12$qQDV84F6YC2zlYmXI8r08.nuSguj3NLgNI8Y98uBs.6UpntwH1Yra', NULL, '2025-12-30 23:42:00', '2025-12-30 23:42:00'),
(3, 'Yoshio', 'Baker', 'Yoshio Baker', '+1 (708) 842-2381', 'buqy@mailinator.com', NULL, '$2y$12$6aJoWXlTn2Xj9HZm0ZUqhO0FQti.ROBN7PX6MV/BhOeVZaec.YwvK', NULL, '2025-12-31 00:08:18', '2025-12-31 00:08:18');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pinterest` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vimeo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `email`, `phone`, `address`, `facebook`, `instagram`, `pinterest`, `vimeo`, `created_at`, `updated_at`) VALUES
(1, 'cakes@rachelles.co.uk', '07958 714672', 'Anim explicabo Eos anim consectetur', 'https://www.pogutub.org.uk', 'https://www.xodisytawegesa.in', 'https://www.qys.us', 'https://www.xalexym.tv', '2025-12-14 20:08:50', '2025-12-14 20:08:50');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint UNSIGNED NOT NULL,
  `course_category_id` bigint UNSIGNED DEFAULT NULL,
  `instructor_id` bigint UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_description_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `course_duration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `course_duration_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `course_lessons` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `course_lessons_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price_after_discount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_start_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_end_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_category_id`, `instructor_id`, `title`, `title_ar`, `short_description`, `short_description_ar`, `description`, `description_ar`, `course_duration`, `course_duration_ar`, `course_lessons`, `course_lessons_ar`, `image`, `video`, `price`, `price_after_discount`, `discount_start_date`, `discount_end_date`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 'أساسيات خبز الكيك', 'Delectus velit omnis nobis impedit ipsum ex et sit atque quos sint id voluptas quae quo ut', 'تعلّم أساسيات خلط المكونات، تقنيات الخَبز الصحيحة، وتحضير القوالب بشكل مثالي.\n', 'Ex natus in lorem id ea suscipit proident quam qui ea sit est non', '<p dir=\"rtl\">تعلّم أساسيات خلط المكونات، تقنيات الخَبز الصحيحة، وتحضير القوالب بشكل مثالي.</p><p><br></p><p><br><br></p>', '<p>Itaque aliquip repel.</p>', 'In vero est laboris consequuntur iusto non omnis autem excepturi suscipit itaque ratione est reprehenderit dolor commodo quo ipsa', 'Omnis consequatur Voluptates qui et ut dolorum quam odit explicabo Aut consequatur aut fugiat quibusdam labore beatae', NULL, NULL, 'courses/01KCF9SFESV9Y88TXR5RW3P488.jpg', 'courses/videos/01KBB4ARA1VA7K13E0YFK12687.mp4', '650', '558', '02-May-2005', '05-Aug-1990', '2025-11-30 17:37:42', '2025-12-14 18:51:47'),
(2, 2, 1, 'تزيين الكيك بكريمة الزبدة', 'Delectus velit omnis nobis impedit ipsum ex et sit atque quos sint id voluptas quae quo ut', 'إتقان تزيين الكيك باستخدام كريمة الزبدة وتعلّم تشكيل الورود وأساليب التزيين المختلفة.\n\n', 'Ex natus in lorem id ea suscipit proident quam qui ea sit est non', '<p dir=\"rtl\">إتقان تزيين الكيك باستخدام كريمة الزبدة وتعلّم تشكيل الورود وأساليب التزيين المختلفة.</p><p><br></p><p><br><br></p>', '<p>Itaque aliquip repel.</p>', 'In vero est laboris consequuntur iusto non omnis autem excepturi suscipit itaque ratione est reprehenderit dolor commodo quo ipsa', 'Omnis consequatur Voluptates qui et ut dolorum quam odit explicabo Aut consequatur aut fugiat quibusdam labore beatae', NULL, NULL, 'courses/01KCF9TRD216CFD1K3SA33MQGA.jpg', NULL, '650', '558', '02-May-2005', '05-Aug-1990', '2025-11-30 17:38:26', '2025-12-14 18:51:56'),
(3, 1, 1, 'كعكات الزفاف والمناسبات', 'Officia unde enim tempore voluptatem quaerat architecto maxime aspernatur vitae pariatur Ut laborum In commodo', 'تصميم وصناعة كعكات فاخرة للزفاف والمناسبات مع ديكورات مبتكرة وأنماط مميزة.\n\n', 'Voluptate mollit fugiat perferendis dolore voluptates magnam totam eaque dolores voluptatibus atque quo facere est minim aliquam sint accusamus', '<p dir=\"rtl\">تصميم وصناعة كعكات فاخرة للزفاف والمناسبات مع ديكورات مبتكرة وأنماط مميزة.</p><p><br></p><p><br><br></p>', '<p>Consequuntur qui rat.</p>', 'Voluptatem cupiditate in natus ad quo laborum Dolore sint fugit corporis', 'Ut fugit pariatur Veniam repudiandae sunt qui qui aut', NULL, NULL, 'courses/01KCF9VSTB5K6750PK2KNAENBY.jpg', 'courses/videos/01KBB4DQB0F119QN7WCTW32JYT.mp4', '408', '529', '22-Aug-2017', '17-Oct-1983', '2025-11-30 17:39:19', '2025-12-14 18:47:03'),
(4, 3, 1, 'فن الفوندان المتقدم', 'Reprehenderit vero deleniti aperiam doloremque', 'إتقان العمل بالفوندان وصناعة المجسّمات الثلاثية الأبعاد والزخارف الاحترافية القابلة للأكل.\n\n', 'Voluptates irure et irure fugiat dignissimos deserunt soluta repudiandae saepe impedit aut tempore quidem accusamus cupidatat impedit ut consectetur libero', '<p dir=\"rtl\">إتقان العمل بالفوندان وصناعة المجسّمات الثلاثية الأبعاد والزخارف الاحترافية القابلة للأكل.</p><p><br></p><p><br><br></p>', '<p>Est incidunt, modi d.</p>', 'Exercitation cupiditate maiores proident possimus ullamco', 'Voluptates eum ducimus et incididunt veritatis iure fugiat commodi reiciendis consequat Quis occaecat qui', NULL, NULL, 'courses/01KCF9XDB9939S1QN2QGDA9V4C.jpg', NULL, '197', '488', '28-Aug-2022', '26-Dec-2020', '2025-11-30 17:39:48', '2025-12-14 18:52:04'),
(5, 1, 1, 'صناعة الكب كيك الاحترافية', 'Velit placeat debitis ipsa in quam doloribus reprehenderit quo dolore et rerum ut architecto ipsum ut ex', 'تعلّم كيفية خبز وتزيين الكب كيك بشكل مبتكر لمختلف المناسبات.\n\n', 'Eaque aliquam minus elit vero veniam autem aspernatur et veniam quia ut', '<p dir=\"rtl\">تعلّم كيفية خبز وتزيين الكب كيك بشكل مبتكر لمختلف المناسبات.</p><p><br></p><p><br><br></p>', '<p>Illum, natus sed lor.</p>', 'Dolor aspernatur ducimus incididunt dolorem', 'Voluptas laboriosam ad qui ut dolore quod et rem cillum nisi beatae et reprehenderit aut excepteur praesentium sunt aliquam', NULL, NULL, 'courses/01KCF9ZFPCKCXCRVF7JBR8R0ME.jpg', 'courses/videos/01KBB533ZZBG43TYM6RXHGKKXS.mp4', '474', '158', '08-Aug-2012', '11-Sep-2017', '2025-11-30 17:40:30', '2025-12-14 18:49:04'),
(6, 1, 1, 'تقنيات التزيين المتقدمة', NULL, 'تعلّم تقنيات التزيين باستخدام آيسينغ رويال وطرق الرسم الاحترافية على الكيك.\n\n', NULL, '<p dir=\"rtl\">تعلّم تقنيات التزيين باستخدام آيسينغ رويال وطرق الرسم الاحترافية على الكيك.</p><p><br></p><p><br><br></p>', NULL, NULL, NULL, NULL, NULL, 'courses/01KCFA0P0N4TET0SMRZRF7WJEW.jpg', NULL, '474', '158', NULL, NULL, '2025-12-14 18:49:43', '2025-12-14 18:49:43'),
(7, 1, 1, 'كعكات ثلاثية الأبعاد احترافية', NULL, 'إنشاء كعكات فنية ثلاثية الأبعاد بتصاميم واقعية باستخدام تقنيات النحت المتقدمة.\n\n', NULL, '<p dir=\"rtl\">إنشاء كعكات فنية ثلاثية الأبعاد بتصاميم واقعية باستخدام تقنيات النحت المتقدمة.</p><p><br></p><p><br><br></p>', NULL, NULL, NULL, NULL, NULL, 'courses/01KCFA1ZKWGQV8D4K3GZ2THD9Z.jpg', NULL, '650', '158', NULL, NULL, '2025-12-14 18:50:26', '2025-12-14 18:50:26'),
(8, 1, 1, 'ماستر كلاس الحلويات الفرنسية', NULL, 'تعلّم كيفية صنع الماكرون، الإكلير، والتارت الفرنسي الكلاسيكي باستخدام تقنيات احترافية.\n\n', NULL, '<p dir=\"rtl\">تعلّم كيفية صنع الماكرون، الإكلير، والتارت الفرنسي الكلاسيكي باستخدام تقنيات احترافية.</p><p><br></p><p><br><br></p>', NULL, NULL, NULL, NULL, NULL, 'courses/01KCFA2ZYPCXNF0NMAQYGNDB6F.jpg', NULL, '650', '158', NULL, NULL, '2025-12-14 18:50:59', '2025-12-14 18:50:59');

-- --------------------------------------------------------

--
-- Table structure for table `course_bookings`
--

CREATE TABLE `course_bookings` (
  `id` bigint UNSIGNED NOT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_bookings`
--

INSERT INTO `course_bookings` (`id`, `client_id`, `course_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'approved', '2025-12-31 00:07:51', '2025-12-31 00:10:10');

-- --------------------------------------------------------

--
-- Table structure for table `course_categories`
--

CREATE TABLE `course_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_categories`
--

INSERT INTO `course_categories` (`id`, `title`, `title_ar`, `created_at`, `updated_at`) VALUES
(1, 'مبتدئ', NULL, '2025-11-28 22:18:20', '2025-12-14 18:51:17'),
(2, 'متوسط', NULL, '2025-12-14 18:51:27', '2025-12-14 18:51:27'),
(3, 'متقدم', NULL, '2025-12-14 18:51:38', '2025-12-14 18:51:38');

-- --------------------------------------------------------

--
-- Table structure for table `designs`
--

CREATE TABLE `designs` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `designs`
--

INSERT INTO `designs` (`id`, `title`, `title_ar`, `image`, `created_at`, `updated_at`) VALUES
(1, 'كيك حفلة مميز', NULL, '01KCF8M6CTVTB4HV65CH15D9N8.jpg', '2025-12-14 18:25:25', '2025-12-14 18:25:25'),
(2, 'كيك حفلة مميز', NULL, '01KCF8MQ34NQQ9PV6CBM65337D.jpg', '2025-12-14 18:25:42', '2025-12-14 18:25:42'),
(3, 'كيك حفلة مميز', NULL, '01KCF8N43RXJ4PP9XCE64NN44N.jpg', '2025-12-14 18:25:56', '2025-12-14 18:25:56'),
(4, 'كيك حفلة مميز', NULL, '01KCF8NHSHHC5PJ5HXXD05C20M.jpg', '2025-12-14 18:26:10', '2025-12-14 18:26:10');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `instructors`
--

CREATE TABLE `instructors` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `instructors`
--

INSERT INTO `instructors` (`id`, `name`, `name_ar`, `title`, `title_ar`, `image`, `description`, `description_ar`, `created_at`, `updated_at`) VALUES
(1, 'نورهان محمد', NULL, ' خبيرة صناعة الكيك – خبرة 15 سنة', NULL, '01KB6FR55M4G41YXTEARTKGQ52.jpg', '                                    شيف متخصصة في الحلويات الفاخرة وصناعة الكيك، حاصلة على شهادات دولية من معاهد مرموقة                                     في                                     باريس ولندن. عملت مع أفضل المطاعم العالمية ودربت أكثر من 500', NULL, '2025-11-28 22:21:03', '2025-12-14 19:38:55');

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `course_id`, `title`, `title_ar`, `icon`, `duration`, `deleted_at`, `created_at`, `updated_at`, `color`) VALUES
(1, 5, 'Odit qui nisi distinctio Earum aperiam molestiae quia amet eveniet et accusamus provident eligendi rerum temporibus', NULL, '01KBJW1D1TRE7M3CWN7CBD44KP.png', 'Voluptatem dignissimos sequi molestiae fugit incidunt', NULL, '2025-12-03 17:46:42', '2025-12-07 20:23:11', NULL),
(2, 5, 'Repudiandae consequuntur possimus quam ut incidunt repudiandae id quam veniam iure', NULL, '01KBXEZ4K3P8D5RK4XA2SEK2GY.jpg', 'Placeat laborum eum lorem vero sit odit mollitia maxime id nulla omnis ex quis perferendis', NULL, '2025-12-07 20:29:55', '2025-12-07 20:29:55', NULL),
(3, 5, 'Molestias eiusmod mo', NULL, '01KBXF8HY20G766GVWJZFEJSEJ.jpg', '20', NULL, '2025-12-07 20:35:04', '2025-12-07 20:35:04', NULL),
(4, 1, 'Facere veniam ullam dolor sit Nam est', NULL, '01KCFBR60H92CXGE0VHB3ENETA.png', 'Deleniti obcaecati tempore earum rerum hic aliquid numquam cupidatat consequuntur dolore tempore dolores non', NULL, '2025-12-07 20:35:50', '2025-12-14 19:20:02', '#a81a1a'),
(5, 1, 'Provident omnis recusandae Sit dolore sunt voluptatem laborum Iste voluptatem Dolorum voluptates est labore velit rerum sunt', NULL, '01KBXHDZ066HGAJ5KEH4TCRW46.jpg', 'Commodo proident aut aliquip omnis atque dolor incididunt adipisicing dolor', NULL, '2025-12-07 21:12:58', '2025-12-07 21:12:58', NULL),
(6, 1, 'Sed sunt et ea est et numquam quas magni nulla et aute id voluptates inventore corporis nesciunt quae labore labore', NULL, '01KBXHGJN4ARC8BYCT8E53HJSS.jpg', 'Aspernatur impedit sed officia nulla mollitia est', NULL, '2025-12-07 21:14:24', '2025-12-07 21:14:24', NULL),
(7, 1, 'Magna atque saepe qui aut exercitation sed praesentium vero corrupti ut sed pariatur Nisi quibusdam eius qui', NULL, '01KBXHJ82SV5RNEQ3DEPCJHXFM.jpg', 'Numquam aut sed sed a blanditiis exercitation do', NULL, '2025-12-07 21:15:19', '2025-12-07 21:15:19', NULL),
(8, 1, 'Architecto ullam quam cupiditate omnis unde id assumenda voluptate vel illo ut itaque eum in pariatur Cillum architecto', NULL, '01KBXHMSHT08PGGKPXMJCY33PC.png', 'Eaque nihil distinctio Omnis veritatis aute voluptas harum sint eum dolores', NULL, '2025-12-07 21:16:42', '2025-12-07 21:16:42', NULL),
(9, 1, 'Voluptas aut culpa nostrum lorem dolorem possimus eum atque dolor officia voluptatem Cumque et qui est aliquip ut sit nisi', NULL, '01KBXHQ4AD5Y3W23HVT21A6KZC.png', 'Dolore dolor repudiandae earum ut quia debitis commodo est perspiciatis error sit atque mollitia ea', NULL, '2025-12-07 21:17:59', '2025-12-07 21:17:59', NULL),
(10, 1, 'Repellendus Aperiam velit eum proident doloremque aliquid dicta', NULL, '01KBXHRKR9DQN0WE60HW6WZQBT.png', 'Nisi eveniet dolorum eos est ab', NULL, '2025-12-07 21:18:47', '2025-12-07 21:18:47', NULL),
(11, 1, 'Cupidatat ipsa do aut magnam omnis libero ullam fugiat quia accusantium quibusdam laborum aut delectus suscipit dignissimos nobis', NULL, '01KBXHV963TRT6WBDZ0B91E6HS.png', 'Id voluptatem autem laboris ipsum', NULL, '2025-12-07 21:20:15', '2025-12-07 21:20:15', NULL),
(12, 1, 'Consectetur quaerat rem qui consectetur praesentium dignissimos ut quo ut est ea', NULL, '01KBXHX9QAV1V6439A7Z27637F.png', 'Sint voluptas et ut eius eveniet accusamus perspiciatis illum et consectetur ullam dolor voluptatem Eu', NULL, '2025-12-07 21:21:21', '2025-12-07 21:21:21', NULL),
(13, 1, 'Consectetur quaerat rem qui consectetur praesentium dignissimos ut quo ut est ea', NULL, '01KBXHY2XTWVD61235N00N1XGN.png', 'Sint voluptas et ut eius eveniet accusamus perspiciatis illum et consectetur ullam dolor voluptatem Eu', NULL, '2025-12-07 21:21:47', '2025-12-07 21:21:47', NULL),
(14, 1, 'Necessitatibus voluptatem Consequatur recusandae Voluptas obcaecati quod deserunt quos', NULL, '01KC2RTWD1ZZWDJYVKTA5CY49Z.png', NULL, NULL, '2025-12-09 21:58:34', '2025-12-09 21:58:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_11_28_235708_create_sliders_table', 2),
(6, '2025_11_28_000917_create_instructors_table', 3),
(7, '2025_11_28_000_create_course_categories_table', 3),
(8, '2025_11_28_235748_create_courses_table', 4),
(9, '2025_12_03_193432_create_lessons_table', 5),
(10, '2025_12_03_194737_create_chapters_table', 6),
(11, '2025_12_03_194800_create_pages_table', 6),
(12, '2025_12_10_010839_add-video-row_to_chapters_table', 7),
(14, '2025_12_14_201921_create_designs_table', 8),
(15, '2025_12_14_211846_add-row_color_to_lessons_table', 9),
(16, '2025_12_14_220440_create_contacts_table', 10),
(17, '2025_12_30_224652_add_new_rows_users-table', 11),
(19, '2025_12_31_003320_add_row_type_pages-table', 13),
(20, '2025_12_31_005424_create_newsletters_table', 14),
(21, '2025_12_31_010136_add_role_to_users_table', 15),
(22, '2025_12_31_013206_create_clients_table', 16),
(23, '2025_12_30_233007_create_course_bookings_table', 17);

-- --------------------------------------------------------

--
-- Table structure for table `newsletters`
--

CREATE TABLE `newsletters` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `newsletters`
--

INSERT INTO `newsletters` (`id`, `name`, `email`, `created_at`, `updated_at`) VALUES
(1, 'asdasd', 'eslam.webdevlopre@gmail.com', '2025-12-30 22:56:30', '2025-12-30 22:56:30');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci,
  `short_description_ar` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `description_ar` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` enum('page','home') COLLATE utf8mb4_unicode_ci DEFAULT 'home'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `title_ar`, `slug`, `slug_ar`, `short_description`, `short_description_ar`, `description`, `description_ar`, `image`, `created_at`, `updated_at`, `type`) VALUES
(2, 'ماذا أفعل', NULL, 'matha-afaal', NULL, 'تتخصص Rachelles في صناعة كيكات مخصصة مذهلة لحفلات الزفاف والمناسبات والاحتفالات الخاصة. كل كيك فريد، رائع ومصمم حسب الطلب. أعمل عن قرب مع كل عميل معتمدًا على خدمة شخصية، ودية واهتمام دقيق. من الاستشارة حتى التسليم، أسعى لجعل تجربتك خالية من أي ضغط أو توتر. الذوق مهم بقدر الأناقة، ولهذا السبب يتم استخدام أفضل وأجود المكونات الطازجة فقط. سيكون كيكك متعة للعين والذوق أيضًا. أعمل في ويست دورست مع إمكانية التوصيل للمناطق المحيطة أو عند الطلب. أتخصص أيضًا في فن تزيين الكيك بالورود وأنماط التزيين، مع تقديم دروس خاصة في الاستوديو ودروس أونلاين عبر مدرسة الكيك!\n\n', NULL, '<p dir=\"rtl\">تتخصص Rachelles في صناعة كيكات مخصصة مذهلة لحفلات الزفاف والمناسبات والاحتفالات الخاصة. كل كيك فريد، رائع ومصمم حسب الطلب. أعمل عن قرب مع كل عميل معتمدًا على خدمة شخصية، ودية واهتمام دقيق. من الاستشارة حتى التسليم، أسعى لجعل تجربتك خالية من أي ضغط أو توتر. الذوق مهم بقدر الأناقة، ولهذا السبب يتم استخدام أفضل وأجود المكونات الطازجة فقط. سيكون كيكك متعة للعين والذوق أيضًا. أعمل في ويست دورست مع إمكانية التوصيل للمناطق المحيطة أو عند الطلب. أتخصص أيضًا في فن تزيين الكيك بالورود وأنماط التزيين، مع تقديم دروس خاصة في الاستوديو ودروس أونلاين عبر <a href=\"http://mishmish.test/#\"><span style=\"text-decoration: underline;\">مدرسة الكيك</span></a>!</p><p><strong><br></strong><br></p>', NULL, 'pages/01KCF81QDW343DDE4642138ECW.jpeg', '2025-12-14 18:15:20', '2025-12-14 18:15:20', 'home'),
(3, 'كيك الزفاف', NULL, 'kyk-alzfaf', NULL, 'تتخصص Rachelles في صناعة كيكات مخصصة مذهلة لحفلات الزفاف والمناسبات والاحتفالات الخاصة. كل كيك فريد، رائع ومصمم حسب الطلب. أعمل عن قرب مع كل عميل معتمدًا على خدمة شخصية، ودية واهتمام دقيق. من الاستشارة حتى التسليم، أسعى لجعل تجربتك خالية من أي ضغط أو توتر. الذوق مهم بقدر الأناقة، ولهذا السبب يتم استخدام أفضل وأجود المكونات الطازجة فقط. سيكون كيكك متعة للعين والذوق أيضًا. أعمل في ويست دورست مع إمكانية التوصيل للمناطق المحيطة أو عند الطلب. أتخصص أيضًا في فن تزيين الكيك بالورود وأنماط التزيين، مع تقديم دروس خاصة في الاستوديو ودروس أونلاين عبر مدرسة الكيك!\n\n', NULL, '<p dir=\"rtl\">تتخصص Rachelles في صناعة كيكات مخصصة مذهلة لحفلات الزفاف والمناسبات والاحتفالات الخاصة. كل كيك فريد، رائع ومصمم حسب الطلب. أعمل عن قرب مع كل عميل معتمدًا على خدمة شخصية، ودية واهتمام دقيق. من الاستشارة حتى التسليم، أسعى لجعل تجربتك خالية من أي ضغط أو توتر. الذوق مهم بقدر الأناقة، ولهذا السبب يتم استخدام أفضل وأجود المكونات الطازجة فقط. سيكون كيكك متعة للعين والذوق أيضًا. أعمل في ويست دورست مع إمكانية التوصيل للمناطق المحيطة أو عند الطلب. أتخصص أيضًا في فن تزيين الكيك بالورود وأنماط التزيين، مع تقديم دروس خاصة في الاستوديو ودروس أونلاين عبر <a href=\"http://mishmish.test/#\"><span style=\"text-decoration: underline;\">مدرسة الكيك</span></a>!</p><p><strong><br></strong><br></p>', NULL, 'pages/01KCF82X9FMRNNX2KNDBB29T9W.jpg', '2025-12-14 18:15:59', '2025-12-14 18:15:59', 'home'),
(4, 'كيك الحفلات', NULL, 'kyk-alhflat', NULL, 'تتخصص Rachelles في صناعة كيكات مخصصة مذهلة لحفلات الزفاف، الحفلات والمناسبات الخاصة. كل كيك فريد، رائع ومصمم حسب الطلب. أعمل عن قرب مع كل عميل معتمدًا على خدمة شخصية، ودية واهتمام دقيق. من الاستشارة حتى التسليم، أسعى لجعل تجربتك خالية من أي ضغط أو توتر. الذوق مهم بقدر الأناقة، ولهذا السبب يتم استخدام أفضل وأجود المكونات الطازجة فقط. سيكون كيكك متعة للعين والذوق أيضًا. أعمل في ويست دورست مع إمكانية التوصيل للمناطق المحيطة أو عند الطلب. أتخصص أيضًا في فن تزيين الكيك بالورود وأنماط التزيين، مع تقديم دروس خاصة في الاستوديو ودروس أونلاين عبر مدرسة الكيك!', NULL, '<p dir=\"rtl\"><strong>تتخصص Rachelles في صناعة كيكات مخصصة مذهلة لحفلات الزفاف، الحفلات والمناسبات الخاصة. كل كيك فريد، رائع ومصمم حسب الطلب. أعمل عن قرب مع كل عميل معتمدًا على خدمة شخصية، ودية واهتمام دقيق. من الاستشارة حتى التسليم، أسعى لجعل تجربتك خالية من أي ضغط أو توتر. الذوق مهم بقدر الأناقة، ولهذا السبب يتم استخدام أفضل وأجود المكونات الطازجة فقط. سيكون كيكك متعة للعين والذوق أيضًا. أعمل في ويست دورست مع إمكانية التوصيل للمناطق المحيطة أو عند الطلب. أتخصص أيضًا في فن تزيين الكيك بالورود وأنماط التزيين، مع تقديم دروس خاصة في الاستوديو ودروس أونلاين عبر </strong><a href=\"http://mishmish.test/#\"><strong style=\"text-decoration: underline;\">مدرسة الكيك</strong></a><strong>!</strong></p>', NULL, 'pages/01KCF84ED29BKSEF2ASPMV2AX5.jpg', '2025-12-14 18:16:49', '2025-12-14 18:16:49', 'home'),
(5, 'كيك الزفاف', NULL, 'kyk-alzfaf-2', NULL, 'تتخصص Rachelles في صناعة كيكات مخصصة مذهلة لحفلات الزفاف والمناسبات والاحتفالات الخاصة. كل كيك فريد، رائع ومصمم حسب الطلب. أعمل عن قرب مع كل عميل معتمدًا على خدمة شخصية، ودية واهتمام دقيق. من الاستشارة حتى التسليم، أسعى لجعل تجربتك خالية من أي ضغط أو توتر. الذوق مهم بقدر الأناقة، ولهذا السبب يتم استخدام أفضل وأجود المكونات الطازجة فقط. سيكون كيكك متعة للعين والذوق أيضًا. أعمل في ويست دورست مع إمكانية التوصيل للمناطق المحيطة أو عند الطلب. أتخصص أيضًا في فن تزيين الكيك بالورود وأنماط التزيين، مع تقديم دروس خاصة في الاستوديو ودروس أونلاين عبر مدرسة الكيك!', NULL, '<p dir=\"rtl\"><strong>تتخصص Rachelles في صناعة كيكات مخصصة مذهلة لحفلات الزفاف والمناسبات والاحتفالات الخاصة. كل كيك فريد، رائع ومصمم حسب الطلب. أعمل عن قرب مع كل عميل معتمدًا على خدمة شخصية، ودية واهتمام دقيق. من الاستشارة حتى التسليم، أسعى لجعل تجربتك خالية من أي ضغط أو توتر. الذوق مهم بقدر الأناقة، ولهذا السبب يتم استخدام أفضل وأجود المكونات الطازجة فقط. سيكون كيكك متعة للعين والذوق أيضًا. أعمل في ويست دورست مع إمكانية التوصيل للمناطق المحيطة أو عند الطلب. أتخصص أيضًا في فن تزيين الكيك بالورود وأنماط التزيين، مع تقديم دروس خاصة في الاستوديو ودروس أونلاين عبر </strong><a href=\"http://mishmish.test/#\"><strong style=\"text-decoration: underline;\">مدرسة الكيك</strong></a><strong>!</strong></p>', NULL, 'pages/01KCF8607SRRNGHBDET5EY8SEM.jpg', '2025-12-14 18:17:40', '2025-12-14 18:17:40', 'home'),
(6, 'كيك الحفلات', NULL, 'kyk-alhflat-2', NULL, 'تتخصص Rachelles في صناعة كيكات مخصصة مذهلة لحفلات الزفاف، الحفلات والمناسبات الخاصة. كل كيك فريد، رائع ومصمم حسب الطلب. أعمل عن قرب مع كل عميل معتمدًا على خدمة شخصية، ودية واهتمام دقيق. من الاستشارة حتى التسليم، أسعى لجعل تجربتك خالية من أي ضغط أو توتر. الذوق مهم بقدر الأناقة، ولهذا السبب يتم استخدام أفضل وأجود المكونات الطازجة فقط. سيكون كيكك متعة للعين والذوق أيضًا. أعمل في ويست دورست مع إمكانية التوصيل للمناطق المحيطة أو عند الطلب. أتخصص أيضًا في فن تزيين الكيك بالورود وأنماط التزيين، مع تقديم دروس خاصة في الاستوديو ودروس أونلاين عبر مدرسة الكيك!', NULL, '<p dir=\"rtl\"><strong>تتخصص Rachelles في صناعة كيكات مخصصة مذهلة لحفلات الزفاف، الحفلات والمناسبات الخاصة. كل كيك فريد، رائع ومصمم حسب الطلب. أعمل عن قرب مع كل عميل معتمدًا على خدمة شخصية، ودية واهتمام دقيق. من الاستشارة حتى التسليم، أسعى لجعل تجربتك خالية من أي ضغط أو توتر. الذوق مهم بقدر الأناقة، ولهذا السبب يتم استخدام أفضل وأجود المكونات الطازجة فقط. سيكون كيكك متعة للعين والذوق أيضًا. أعمل في ويست دورست مع إمكانية التوصيل للمناطق المحيطة أو عند الطلب. أتخصص أيضًا في فن تزيين الكيك بالورود وأنماط التزيين، مع تقديم دروس خاصة في الاستوديو ودروس أونلاين عبر </strong><a href=\"http://mishmish.test/#\"><strong style=\"text-decoration: underline;\">مدرسة الكيك</strong></a><strong>!</strong></p>', NULL, 'pages/01KCF86S1W7K2SNTXCBQT5GJVV.jpg', '2025-12-14 18:18:06', '2025-12-14 18:18:06', 'home'),
(7, 'من نحن', NULL, 'mn-nhn', NULL, 'sfaasfs', NULL, '<p>asdfsadf</p>', NULL, 'pages/01KDRWPWWGVGYGGCSKRB4XDS3Z.jpg', '2025-12-30 22:25:17', '2025-12-30 22:48:56', 'page'),
(8, 'الشروط والأحكام', NULL, 'alshrot-oalahkam', NULL, 'الشروط والأحكام', NULL, '<p dir=\"rtl\">&nbsp;الشروط والأحكام الشروط والأحكام</p>', NULL, 'pages/01KDRY08TMZBY38R32JBDFYKW3.png', '2025-12-30 22:47:53', '2025-12-30 22:47:53', 'home'),
(9, 'سياسة الخصوصية', NULL, 'syas-alkhsosy', NULL, 'سياسة الخصوصية', NULL, '<p dir=\"rtl\">سياسة الخصوصية</p>', NULL, 'pages/01KDRY137AVPV2GMK1C84MAJ6D.png', '2025-12-30 22:48:20', '2025-12-30 22:48:20', 'home');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `title`, `subtitle`, `title_ar`, `subtitle_ar`, `image`, `button_url`, `created_at`, `updated_at`) VALUES
(1, 'تعلم فنون صناعة الكيك الاحترافية', 'ابدأ رحلتك مع أفضل الدورات في الخبز وتزيين الكيك', NULL, NULL, '01KCF8ZAZA0ZP857CWYT8EES77.jpg', 'https://www.youtube.com/', '2025-11-28 22:22:10', '2025-12-14 18:31:30'),
(2, 'تعلم فنون صناعة الكيك الاحترافية', 'ابدأ رحلتك مع أفضل الدورات في الخبز وتزيين الكيك', NULL, NULL, '01KCF90E07EKRWCCVA18KXZA1D.jpg', 'https://www.youtube.com/', '2025-12-14 18:32:06', '2025-12-14 18:32:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_unicode_ci DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `first_name`, `last_name`, `phone`, `role`) VALUES
(1, 'mishmisha', 'admin@admin.com', NULL, '$2y$12$NoaTaGKuQHbfwupe4wyXlOQoBgJ3SmqCrqECgnsQVB0YIGXQ1wlfO', 'Ev5BCIa6nQZlmBPZQN4lDz5lAIMd2vVot0Eb85Gc5lvJa8avJ1Py79MgWzPH', '2025-11-28 13:10:44', '2025-11-28 13:10:44', NULL, NULL, NULL, 'admin'),
(2, 'Kyla Nash', 'koxox@mailinator.com', NULL, '$2y$12$YVCtRan1Gp0YG3R6bf8pA.9O6L4g9OzmmbwlTSSf6cxJE2q0BvPEO', NULL, '2025-12-30 20:51:00', '2025-12-30 20:51:00', 'Kyla', 'Nash', '+1 (993) 656-6612', 'user'),
(3, 'Eslam Salah', 'eslam.webdevlopre@gmail.com', NULL, '$2y$12$BsPdUHBId8ROjqt66TRUje337O.fcIbJJGzOXfGoc3t1/2jAJs.fG', NULL, '2025-12-30 23:25:28', '2025-12-30 23:25:28', 'Eslam', 'Salah', '+201000907612', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chapters`
--
ALTER TABLE `chapters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chapters_lesson_id_foreign` (`lesson_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clients_email_unique` (`email`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `courses_course_category_id_foreign` (`course_category_id`),
  ADD KEY `courses_instructor_id_foreign` (`instructor_id`);

--
-- Indexes for table `course_bookings`
--
ALTER TABLE `course_bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_bookings_client_id_foreign` (`client_id`),
  ADD KEY `course_bookings_course_id_foreign` (`course_id`);

--
-- Indexes for table `course_categories`
--
ALTER TABLE `course_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designs`
--
ALTER TABLE `designs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `instructors`
--
ALTER TABLE `instructors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lessons_course_id_foreign` (`course_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletters`
--
ALTER TABLE `newsletters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `chapters`
--
ALTER TABLE `chapters`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `course_bookings`
--
ALTER TABLE `course_bookings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `course_categories`
--
ALTER TABLE `course_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `designs`
--
ALTER TABLE `designs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `instructors`
--
ALTER TABLE `instructors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `newsletters`
--
ALTER TABLE `newsletters`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chapters`
--
ALTER TABLE `chapters`
  ADD CONSTRAINT `chapters_lesson_id_foreign` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_course_category_id_foreign` FOREIGN KEY (`course_category_id`) REFERENCES `course_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `courses_instructor_id_foreign` FOREIGN KEY (`instructor_id`) REFERENCES `instructors` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `course_bookings`
--
ALTER TABLE `course_bookings`
  ADD CONSTRAINT `course_bookings_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_bookings_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `lessons_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

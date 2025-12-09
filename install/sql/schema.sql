-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 30 2025 г., 12:21
-- Версия сервера: 10.8.4-MariaDB
-- Версия PHP: 8.0.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `lumix`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('cmskz_document_html_23', 's:9:\"rthrthtrh\";', 1764498866);

-- --------------------------------------------------------

--
-- Структура таблицы `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `chunks`
--

CREATE TABLE `chunks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `chunks`
--

INSERT INTO `chunks` (`id`, `name`, `content`, `created_at`, `updated_at`) VALUES
(1, 'header', '<header class=\"cms-header\">\r\n                        \r\n   <div class=\"cms-logo\">\r\n       <div class=\"logo-icon\">\r\n           <i class=\"fas fa-cube\"></i>\r\n       </div>\r\n     {{ $document->title }}\r\n   </div>\r\n   <p class=\"cms-subtitle\">Современная система управления контентом</p>\r\n   <span class=\"cms-version\">Версия 2.0.1</span>\r\n</header>', '2025-11-02 05:45:41', '2025-11-02 07:22:12'),
(2, 'footer', '<footer class=\"cms-footer\">\r\n            <div class=\"footer-links\">\r\n                <a href=\"#\">Документация</a>\r\n                <a href=\"#\">Форум</a>\r\n                <a href=\"#\">Блог</a>\r\n                <a href=\"#\">Поддержка</a>\r\n            </div>\r\n            <p class=\"copyright\">&copy; 2024 CMSKZ. Все права защищены.</p>\r\n        </footer>', '2025-11-02 06:21:01', '2025-11-02 07:11:36'),
(3, 'head', '<head>\r\n <meta charset=\"UTF-8\">\r\n <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\r\n <link href=\"https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap\" rel=\"stylesheet\">\r\n <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css\">\r\n <title>{{ $document->title }}</title>\r\n <style>\r\n        :root {\r\n            --white_color: #fff;\r\n            --blue_color: #0496ba;\r\n            --link_hover: #07637a;\r\n            --blue_dark_color: #2f323c;\r\n            --gray_light: #f8f9fa;\r\n            --gray_border: #e9ecef;\r\n        }\r\n\r\n        * {\r\n            margin: 0;\r\n            padding: 0;\r\n            box-sizing: border-box;\r\n        }\r\n\r\n        body {\r\n            font-family: \'Inter\', sans-serif;\r\n            background: var(--white_color);\r\n            color: var(--blue_dark_color);\r\n            line-height: 1.6;\r\n            min-height: 100vh;\r\n        }\r\n\r\n        .cms-container {\r\n            max-width: 1000px;\r\n            margin: 0 auto;\r\n            padding: 30px 20px;\r\n        }\r\n\r\n        /* Header */\r\n        .cms-header {\r\n            text-align: center;\r\n            margin-bottom: 3rem;\r\n            padding: 2rem;\r\n            background: linear-gradient(135deg, var(--blue_color), var(--link_hover));\r\n            border-radius: 16px;\r\n            color: var(--white_color);\r\n            position: relative;\r\n            overflow: hidden;\r\n        }\r\n\r\n        .cms-header::before {\r\n            content: \'\';\r\n            position: absolute;\r\n            top: -50%;\r\n            left: -50%;\r\n            width: 200%;\r\n            height: 200%;\r\n            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);\r\n            animation: rotate 20s linear infinite;\r\n        }\r\n\r\n        .cms-logo {\r\n            font-size: 3rem;\r\n            font-weight: 700;\r\n            margin-bottom: 0.5rem;\r\n            position: relative;\r\n            display: flex;\r\n            align-items: center;\r\n            justify-content: center;\r\n            gap: 1rem;\r\n        }\r\n\r\n        .logo-icon {\r\n            width: 50px;\r\n            height: 50px;\r\n            background: var(--white_color);\r\n            border-radius: 12px;\r\n            display: flex;\r\n            align-items: center;\r\n            justify-content: center;\r\n            color: var(--blue_color);\r\n            font-size: 1.5rem;\r\n        }\r\n\r\n        .cms-subtitle {\r\n            font-size: 1.1rem;\r\n            opacity: 0.9;\r\n            margin-bottom: 1rem;\r\n        }\r\n\r\n        .cms-version {\r\n            background: rgba(255,255,255,0.2);\r\n            padding: 6px 16px;\r\n            border-radius: 20px;\r\n            font-size: 0.85rem;\r\n            font-weight: 500;\r\n            display: inline-block;\r\n            backdrop-filter: blur(10px);\r\n        }\r\n\r\n        /* Quick Actions */\r\n        .quick-actions {\r\n            margin-bottom: 3rem;\r\n        }\r\n\r\n        .section-title {\r\n            font-size: 1.5rem;\r\n            font-weight: 600;\r\n            margin-bottom: 1.5rem;\r\n            color: var(--blue_dark_color);\r\n            display: flex;\r\n            align-items: center;\r\n            gap: 0.8rem;\r\n        }\r\n\r\n        .section-title i {\r\n            color: var(--blue_color);\r\n        }\r\n\r\n        .actions-grid {\r\n            display: grid;\r\n            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));\r\n            gap: 1.5rem;\r\n        }\r\n\r\n        .action-card {\r\n            background: var(--white_color);\r\n            border: 2px solid var(--gray_border);\r\n            border-radius: 12px;\r\n            padding: 1.5rem;\r\n            transition: all 0.3s ease;\r\n            text-decoration: none;\r\n            color: inherit;\r\n            position: relative;\r\n        }\r\n\r\n        .action-card:hover {\r\n            border-color: var(--blue_color);\r\n            transform: translateY(-3px);\r\n            box-shadow: 0 8px 25px rgba(4, 150, 186, 0.15);\r\n        }\r\n\r\n        .action-icon {\r\n            width: 50px;\r\n            height: 50px;\r\n            background: linear-gradient(135deg, var(--blue_color), var(--link_hover));\r\n            border-radius: 10px;\r\n            display: flex;\r\n            align-items: center;\r\n            justify-content: center;\r\n            color: var(--white_color);\r\n            font-size: 1.2rem;\r\n            margin-bottom: 1rem;\r\n            transition: transform 0.3s ease;\r\n        }\r\n\r\n        .action-card:hover .action-icon {\r\n            transform: scale(1.1);\r\n        }\r\n\r\n        .action-card h3 {\r\n            font-size: 1.2rem;\r\n            font-weight: 600;\r\n            margin-bottom: 0.5rem;\r\n            color: var(--blue_dark_color);\r\n        }\r\n\r\n        .action-card p {\r\n            color: #666;\r\n            font-size: 0.9rem;\r\n            line-height: 1.5;\r\n        }\r\n\r\n        /* Features */\r\n        .features-section {\r\n            margin-bottom: 3rem;\r\n        }\r\n\r\n        .features-grid {\r\n            display: grid;\r\n            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));\r\n            gap: 1.5rem;\r\n        }\r\n\r\n        .feature-card {\r\n            background: var(--white_color);\r\n            border: 1px solid var(--gray_border);\r\n            border-radius: 12px;\r\n            padding: 1.5rem;\r\n            transition: all 0.3s ease;\r\n        }\r\n\r\n        .feature-card:hover {\r\n            border-color: var(--blue_color);\r\n            box-shadow: 0 5px 20px rgba(0,0,0,0.08);\r\n        }\r\n\r\n        .feature-header {\r\n            display: flex;\r\n            align-items: center;\r\n            gap: 1rem;\r\n            margin-bottom: 1rem;\r\n        }\r\n\r\n        .feature-icon {\r\n            width: 40px;\r\n            height: 40px;\r\n            background: var(--blue_color);\r\n            border-radius: 8px;\r\n            display: flex;\r\n            align-items: center;\r\n            justify-content: center;\r\n            color: var(--white_color);\r\n            font-size: 1rem;\r\n        }\r\n\r\n        .feature-card h3 {\r\n            font-size: 1.1rem;\r\n            font-weight: 600;\r\n            color: var(--blue_dark_color);\r\n        }\r\n\r\n        .feature-card p {\r\n            color: #666;\r\n            font-size: 0.9rem;\r\n        }\r\n\r\n        /* Status */\r\n        .status-section {\r\n            background: var(--gray_light);\r\n            border-radius: 12px;\r\n            padding: 2rem;\r\n            margin-bottom: 3rem;\r\n        }\r\n\r\n        .status-grid {\r\n            display: grid;\r\n            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));\r\n            gap: 1.5rem;\r\n        }\r\n\r\n        .status-item {\r\n            text-align: center;\r\n        }\r\n\r\n        .status-number {\r\n            font-size: 2rem;\r\n            font-weight: 700;\r\n            color: var(--blue_color);\r\n            display: block;\r\n        }\r\n\r\n        .status-label {\r\n            color: #666;\r\n            font-size: 0.85rem;\r\n            margin-top: 0.5rem;\r\n        }\r\n\r\n        /* Resources */\r\n        .resources-section {\r\n            margin-bottom: 2rem;\r\n        }\r\n\r\n        .resources-grid {\r\n            display: grid;\r\n            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));\r\n            gap: 1.5rem;\r\n        }\r\n\r\n        .resource-card {\r\n            background: var(--white_color);\r\n            border: 1px solid var(--gray_border);\r\n            border-radius: 12px;\r\n            padding: 1.5rem;\r\n        }\r\n\r\n        .resource-card h3 {\r\n            font-size: 1.1rem;\r\n            font-weight: 600;\r\n            margin-bottom: 1rem;\r\n            color: var(--blue_dark_color);\r\n            display: flex;\r\n            align-items: center;\r\n            gap: 0.8rem;\r\n        }\r\n\r\n        .resource-card h3 i {\r\n            color: var(--blue_color);\r\n        }\r\n\r\n        .resource-links {\r\n            list-style: none;\r\n        }\r\n\r\n        .resource-links li {\r\n            padding: 0.6rem 0;\r\n            border-bottom: 1px solid var(--gray_border);\r\n        }\r\n\r\n        .resource-links li:last-child {\r\n            border-bottom: none;\r\n        }\r\n\r\n        .resource-links a {\r\n            color: var(--blue_color);\r\n            text-decoration: none;\r\n            display: flex;\r\n            align-items: center;\r\n            gap: 0.8rem;\r\n            transition: color 0.3s ease;\r\n            font-size: 0.9rem;\r\n        }\r\n\r\n        .resource-links a:hover {\r\n            color: var(--link_hover);\r\n        }\r\n\r\n        /* Footer */\r\n        .cms-footer {\r\n            text-align: center;\r\n            padding: 2rem 0 1rem;\r\n            border-top: 1px solid var(--gray_border);\r\n            color: #666;\r\n        }\r\n\r\n        .footer-links {\r\n            display: flex;\r\n            justify-content: center;\r\n            gap: 1.5rem;\r\n            margin-bottom: 1rem;\r\n            flex-wrap: wrap;\r\n        }\r\n\r\n        .footer-links a {\r\n            color: var(--blue_color);\r\n            text-decoration: none;\r\n            font-size: 0.9rem;\r\n            transition: color 0.3s ease;\r\n        }\r\n\r\n        .footer-links a:hover {\r\n            color: var(--link_hover);\r\n        }\r\n\r\n        .copyright {\r\n            font-size: 0.85rem;\r\n            opacity: 0.8;\r\n        }\r\n\r\n        /* Анимации */\r\n        @keyframes rotate {\r\n            from { transform: rotate(0deg); }\r\n            to { transform: rotate(360deg); }\r\n        }\r\n\r\n        @keyframes fadeInUp {\r\n            from {\r\n                opacity: 0;\r\n                transform: translateY(20px);\r\n            }\r\n            to {\r\n                opacity: 1;\r\n                transform: translateY(0);\r\n            }\r\n        }\r\n\r\n        .cms-header, .quick-actions, .features-section, .status-section, .resources-section {\r\n            animation: fadeInUp 0.6s ease-out forwards;\r\n        }\r\n\r\n        .cms-header { animation-delay: 0.1s; }\r\n        .quick-actions { animation-delay: 0.2s; }\r\n        .features-section { animation-delay: 0.3s; }\r\n        .status-section { animation-delay: 0.4s; }\r\n        .resources-section { animation-delay: 0.5s; }\r\n\r\n        /* Адаптивность */\r\n        @media (max-width: 768px) {\r\n            .cms-container {\r\n                padding: 20px 15px;\r\n            }\r\n            \r\n            .cms-logo {\r\n                font-size: 2.2rem;\r\n                flex-direction: column;\r\n                gap: 0.8rem;\r\n            }\r\n            \r\n            .logo-icon {\r\n                width: 45px;\r\n                height: 45px;\r\n                font-size: 1.3rem;\r\n            }\r\n            \r\n            .actions-grid,\r\n            .features-grid,\r\n            .resources-grid {\r\n                grid-template-columns: 1fr;\r\n            }\r\n            \r\n            .status-grid {\r\n                grid-template-columns: repeat(2, 1fr);\r\n            }\r\n            \r\n            .footer-links {\r\n                flex-direction: column;\r\n                gap: 1rem;\r\n            }\r\n        }\r\n\r\n        @media (max-width: 480px) {\r\n            .status-grid {\r\n                grid-template-columns: 1fr;\r\n            }\r\n            \r\n            .cms-header {\r\n                padding: 1.5rem;\r\n            }\r\n        }\r\n    </style>\r\n</head>', '2025-11-02 07:05:15', '2025-11-22 08:06:19'),
(5, 'item_top', '<a href=\"{{ $uri }}\" class=\"action-card\">{{ $title }}</a>', '2025-11-02 10:23:47', '2025-11-02 10:27:21');

-- --------------------------------------------------------

--
-- Структура таблицы `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template_id` bigint(20) UNSIGNED DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT 1,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'html',
  `uri` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `documents`
--

INSERT INTO `documents` (`id`, `title`, `alias`, `content`, `template_id`, `parent_id`, `published`, `type`, `uri`, `created_at`, `updated_at`) VALUES
(1, 'LUMIX', 'glavnaia', '<p>главная</p>', 1, NULL, 1, 'html', '/glavnaia', '2025-10-31 14:53:50', '2025-11-22 08:18:10'),
(6, 'Создать страницу', 'sozdat-stranicu', NULL, 5, NULL, 1, 'html', '/sozdat-stranicu', '2025-11-01 10:30:27', '2025-11-01 10:31:47'),
(7, 'Каталог', 'katalog', NULL, 1, NULL, 1, 'html', '/katalog', '2025-11-02 03:04:37', '2025-11-22 07:51:42'),
(12, 'Создание страницы', 'testings33', '<p>кпеукпкуп</p>', 6, 7, 1, 'html', '/katalog/testings33', '2025-11-02 05:34:28', '2025-11-27 14:01:37'),
(20, 'Создание чанка', 'sozdanie-canka', NULL, 6, 7, 0, 'html', '/katalog/sozdanie-canka', '2025-11-23 05:14:14', '2025-11-23 05:14:26'),
(21, 'Создание tv', 'sozdanie-tv', NULL, 6, 7, 1, 'html', '/katalog/sozdanie-tv', '2025-11-23 05:15:24', '2025-11-23 05:15:24');

-- --------------------------------------------------------

--
-- Структура таблицы `document_tvs`
--

CREATE TABLE `document_tvs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `document_id` bigint(20) UNSIGNED NOT NULL,
  `form_tv_id` bigint(20) UNSIGNED NOT NULL,
  `value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`value`)),
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `document_tvs`
--

INSERT INTO `document_tvs` (`id`, `document_id`, `form_tv_id`, `value`, `name`, `created_at`, `updated_at`) VALUES
(13, 1, 3, '{\"subtitle\":\"adwantage\",\"description\":\"ljh,jkh,j\"}', 'advantage', '2025-11-22 05:36:21', '2025-11-22 05:36:21'),
(14, 1, 1, '{\"gallery\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/images\\/%D0%A1%D0%BD%D0%B8%D0%BC%D0%BE%D0%BA%20%D1%8D%D0%BA%D1%80%D0%B0%D0%BD%D0%B0%202025-11-02%20182850.png\",\"subtitle\":\"\\u0414\\u043e\\u043f\\u043e\\u043b\\u043d\\u0438\\u0442\\u0435\\u043b\\u044c\\u043d\\u044b\\u0435 \\u043f\\u043e\\u043b\\u044f\",\"description\":\"\\u043a\\u0443\\u043f\\u043a\\u043f\\u0443\\u043a\\u043f\\u043a\\u0443\\u043f\",\"is_active\":\"on\"}', 'Serega', '2025-11-22 05:43:25', '2025-11-27 14:09:50'),
(15, 1, 1, '{\"gallery\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/images\\/%D0%A1%D0%BD%D0%B8%D0%BC%D0%BE%D0%BA%20%D1%8D%D0%BA%D1%80%D0%B0%D0%BD%D0%B0%202025-08-15%20204612.png\",\"subtitle\":\"\\u0424\\u0430\\u0439\\u043b\\u043e\\u0432\\u0430\\u044f \\u0441\\u0438\\u0441\\u0442\\u0435\\u043c\\u0430\",\"description\":\"\\u043f\\u043a\\u0443\\u043f\\u0443\\u043a\\u043f\\u043a\\u0443\\u043f\\u043a\\u0443\\u043f\",\"is_active\":\"on\"}', 'Serega', '2025-11-22 07:41:21', '2025-11-27 14:10:21'),
(16, 7, 1, '{\"gallery\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/all-popup-img-1.jpg\",\"subtitle\":\"\\u043a\\u0430\\u0442\\u0430\\u043b\\u043e\\u0433\",\"description\":\"56\\u0433\\u04335\\u0433\",\"is_active\":\"on\"}', 'Serega', '2025-11-22 07:52:10', '2025-11-22 07:52:10'),
(17, 1, 1, '{\"gallery\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/images\\/%D0%A1%D0%BD%D0%B8%D0%BC%D0%BE%D0%BA%20%D1%8D%D0%BA%D1%80%D0%B0%D0%BD%D0%B0%202025-08-12%20150048.png\",\"subtitle\":\"\\u0420\\u0435\\u0434\\u0430\\u043a\\u0442\\u0438\\u0440\\u043e\\u0432\\u0430\\u043d\\u0438\\u0435 tv\",\"description\":\"\\u043534\\u043534\\u0435\",\"is_active\":\"on\"}', 'Serega', '2025-11-22 07:57:22', '2025-11-27 14:11:38');

-- --------------------------------------------------------

--
-- Структура таблицы `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `folders`
--

CREATE TABLE `folders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `folders`
--

INSERT INTO `folders` (`id`, `name`, `slug`, `parent_id`, `created_at`, `updated_at`) VALUES
(2, 'Медиатека', 'main', NULL, '2025-11-08 12:44:39', '2025-11-08 09:48:38');

-- --------------------------------------------------------

--
-- Структура таблицы `forms_tv`
--

CREATE TABLE `forms_tv` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `template_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `caption` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`form`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `forms_tv`
--

INSERT INTO `forms_tv` (`id`, `template_id`, `name`, `caption`, `form`, `created_at`, `updated_at`) VALUES
(1, 1, 'Serega', 'Триггеры', '[\r\n  {\r\n    \"name\": \"gallery\",\r\n    \"type\": \"images\",\r\n    \"labels\": {\r\n      \"ru\": { \"label\": \"Галерея\" },\r\n      \"kz\": { \"label\": \"Галерея (қазақша)\" }\r\n    }\r\n  },\r\n  {\r\n    \"name\": \"subtitle\",\r\n    \"type\": \"text\",\r\n    \"labels\": {\r\n      \"ru\": { \"label\": \"Подзаголовок\" },\r\n      \"kz\": { \"label\": \"Астыңғы тақырып\" }\r\n    }\r\n  },\r\n  {\r\n    \"name\": \"description\",\r\n    \"type\": \"textarea\",\r\n    \"labels\": {\r\n      \"ru\": { \"label\": \"Описание\" },\r\n      \"kz\": { \"label\": \"Сипаттама\" }\r\n    }\r\n  },\r\n  {\r\n    \"name\": \"is_active\",\r\n    \"type\": \"checkbox\",\r\n    \"labels\": {\r\n      \"ru\": { \"label\": \"Активно?\" },\r\n      \"kz\": { \"label\": \"Белсенді ме?\" }\r\n    }\r\n  }\r\n]', '2025-11-08 02:58:22', '2025-11-08 02:58:22'),
(2, 5, 'phones', 'phones description test', '[\r\n  {\r\n    \"name\": \"subtitle\",\r\n    \"type\": \"text\",\r\n    \"labels\": {\r\n      \"ru\": { \"label\": \"Подзаголовок\" },\r\n      \"kz\": { \"label\": \"Астыңғы тақырып\" }\r\n    }\r\n  },\r\n  {\r\n    \"name\": \"description\",\r\n    \"type\": \"textarea\",\r\n    \"labels\": {\r\n      \"ru\": { \"label\": \"Описание\" },\r\n      \"kz\": { \"label\": \"Сипаттама\" }\r\n    }\r\n  }\r\n  \r\n]', '2025-11-08 04:31:32', '2025-11-08 04:31:32'),
(3, 1, 'advantage', 'примущество наших услуг', '[\r\n  {\r\n    \"name\": \"subtitle\",\r\n    \"type\": \"text\",\r\n    \"labels\": {\r\n      \"ru\": { \"label\": \"Подзаголовок\" },\r\n      \"kz\": { \"label\": \"Астыңғы тақырып\" }\r\n    }\r\n  },\r\n  {\r\n    \"name\": \"description\",\r\n    \"type\": \"textarea\",\r\n    \"labels\": {\r\n      \"ru\": { \"label\": \"Описание\" },\r\n      \"kz\": { \"label\": \"Сипаттама\" }\r\n    }\r\n  }\r\n  \r\n]', '2025-11-08 06:33:46', '2025-11-08 06:33:46');

-- --------------------------------------------------------

--
-- Структура таблицы `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `media_files`
--

CREATE TABLE `media_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `original_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extension` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` int(11) NOT NULL,
  `disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'public',
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`)),
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `folder_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_10_19_113302_create_documents_table', 1),
(5, '2025_10_26_085446_create_settings_table', 1),
(6, '2025_10_27_040556_create_templates_table', 1),
(7, '2025_10_27_041021_add_template_id_to_documents_table', 1),
(8, '2025_10_27_083512_make_content_nullable_in_templates_table', 1),
(9, '2025_10_31_163525_create_roles_table', 2),
(10, '2025_11_02_083753_create_chunks_table', 3),
(13, '2025_11_03_161329_create_forms_tv_table', 4),
(15, '2025_11_03_170933_create_document_tvs_table', 5),
(16, '2025_11_08_123055_create_folders_table', 6),
(17, '2025_11_08_123131_create_media_files_table', 6),
(18, '2025_11_08_123229_add_foreign_keys_to_media_tables', 6),
(19, '2025_11_30_091901_add_avatar_to_users_table', 7);

-- --------------------------------------------------------

--
-- Структура таблицы `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`permissions`)),
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_system` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `permissions`, `description`, `is_system`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'super_admin', '{\"*\":[\"*\"],\"roles\":[\"view\",\"update\"]}', 'Полный доступ ко всем функциям', 0, '2025-10-31 15:08:02', '2025-11-23 01:29:24'),
(2, 'Admin', 'admin', '{\"admin\":[\"access\"],\"users\":[\"read\"],\"content\":[\"*\",\"create\",\"read\",\"update\",\"delete\",\"publish\"],\"settings\":[\"read\"],\"roles\":[\"create\",\"read\",\"update\",\"delete\"]}', 'Администратор системы', 1, '2025-10-31 15:08:02', '2025-11-23 03:33:48'),
(3, 'User', 'user', '[]', 'Зарегистрированный пользователь', 1, '2025-10-31 15:08:02', '2025-11-23 02:16:48');

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'site_start', '1', '2025-10-31 14:54:47', '2025-10-31 14:54:47'),
(2, 'site_locale', 'ru', '2025-11-01 05:28:15', '2025-11-16 05:08:37');

-- --------------------------------------------------------

--
-- Структура таблицы `templates`
--

CREATE TABLE `templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `templates`
--

INSERT INTO `templates` (`id`, `name`, `content`, `created_at`, `updated_at`) VALUES
(1, 'шаблон главная', '<!DOCTYPE html>\r\n<html lang=\"ru\">\r\n@chunk(\'head\')\r\n\r\n<body>\r\n    <div class=\"cms-container\">\r\n        @chunk(\'header\')\r\n        <!-- Header -->\r\n        \r\n        <!-- Quick Actions -->\r\n        <section class=\"quick-actions\">\r\n            <h2 class=\"section-title\">\r\n                <i class=\"fas fa-rocket\"></i>\r\n                Быстрый старт\r\n            </h2>\r\n            <div class=\"actions-grid\">\r\n               @php\r\n                   $children = \\App\\Models\\Document::where(\'parent_id\', 7)\r\n                       ->orderBy(\'created_at\', \'desc\')\r\n                       ->limit(10)\r\n                       ->get();\r\n               @endphp\r\n               @foreach($children as $child)\r\n               @chunk(\'item_top\',[\'uri\' => $child->uri, \'title\' => $child->title])\r\n                        <!--<a href=\"{{ $child->uri }}\" class=\"action-card\">{{ $child->title }}</a>-->\r\n               @endforeach\r\n            </div>\r\n        </section>\r\n\r\n        <!-- Features -->\r\n        <section class=\"features-section\">\r\n            <h2 class=\"section-title\">\r\n                <i class=\"fas fa-star\"></i>\r\n                Основные возможности\r\n            </h2>\r\n            <div class=\"features-grid\">\r\n                <div class=\"feature-card\">\r\n                    <div class=\"feature-header\">\r\n                        <div class=\"feature-icon\">\r\n                            <i class=\"fas fa-bolt\"></i>\r\n                        </div>\r\n                        <h3>Производительность</h3>\r\n                    </div>\r\n                    <p>Оптимизированная архитектура для быстрой работы</p>\r\n                </div>\r\n                <div class=\"feature-card\">\r\n                    <div class=\"feature-header\">\r\n                        <div class=\"feature-icon\">\r\n                            <i class=\"fas fa-shield-alt\"></i>\r\n                        </div>\r\n                        <h3>Безопасность</h3>\r\n                    </div>\r\n                    <p>Многоуровневая защита и регулярные обновления</p>\r\n                </div>\r\n                <div class=\"feature-card\">\r\n                    <div class=\"feature-header\">\r\n                        <div class=\"feature-icon\">\r\n                            <i class=\"fas fa-mobile-alt\"></i>\r\n                            @if(!empty($tv->value[\'gallery\']))\r\n                                <img src=\"{{ $tv->value[\'gallery\'] }}\" alt=\"Галерея\">\r\n                            @endif\r\n                        </div>\r\n                        <h3>Адаптивность</h3>\r\n                    </div>\r\n                    <p>Идеальное отображение на всех устройствах</p>\r\n                </div>\r\n            </div>\r\n        </section>\r\n\r\n        <!-- Status -->\r\n        <section class=\"status-section\">\r\n            <h2 class=\"section-title\">\r\n                <i class=\"fas fa-chart-bar\"></i>\r\n                Статус системы\r\n            </h2>\r\n            <div class=\"status-grid\">\r\n                <div class=\"status-item\">\r\n                    <span class=\"status-number\">5</span>\r\n                    <span class=\"status-label\">Страниц</span>\r\n                </div>\r\n                <div class=\"status-item\">\r\n                    <span class=\"status-number\">3</span>\r\n                    <span class=\"status-label\">Пользователей</span>\r\n                </div>\r\n                <div class=\"status-item\">\r\n                    <span class=\"status-number\">12</span>\r\n                    <span class=\"status-label\">Модулей</span>\r\n                </div>\r\n                <div class=\"status-item\">\r\n                    <span class=\"status-number\">100%</span>\r\n                    <span class=\"status-label\">Активна</span>\r\n                </div>\r\n            </div>\r\n        </section>\r\n\r\n        <!-- Resources -->\r\n        <section class=\"resources-section\">\r\n            <h2 class=\"section-title\">\r\n                <i class=\"fas fa-life-ring\"></i>\r\n                Ресурсы\r\n            </h2>\r\n            <div class=\"resources-grid\">\r\n                <div class=\"resource-card\">\r\n                    <h3><i class=\"fas fa-book\"></i> Документация</h3>\r\n                    <ul class=\"resource-links\">\r\n                        <li><a href=\"#\"><i class=\"fas fa-arrow-right\"></i> Руководство</a></li>\r\n                        <li><a href=\"#\"><i class=\"fas fa-arrow-right\"></i> API</a></li>\r\n                        <li><a href=\"#\"><i class=\"fas fa-arrow-right\"></i> FAQ</a></li>\r\n                    </ul>\r\n                </div>\r\n                <div class=\"resource-card\">\r\n                    <h3><i class=\"fas fa-users\"></i> Сообщество</h3>\r\n                    <ul class=\"resource-links\">\r\n                        <li><a href=\"#\"><i class=\"fas fa-arrow-right\"></i> Форум</a></li>\r\n                        <li><a href=\"#\"><i class=\"fas fa-arrow-right\"></i> Блог</a></li>\r\n                        <li><a href=\"#\"><i class=\"fas fa-arrow-right\"></i> Поддержка</a></li>\r\n                    </ul>\r\n                </div>\r\n            </div>\r\n        </section>\r\n\r\n@php\r\n    $formTvId = 1; // например, нужная форма\r\n    $filteredTvs = $document->tvs->filter(fn($tv) => $tv->form_tv_id == $formTvId);\r\n@endphp\r\n\r\n@if($filteredTvs->isEmpty())\r\n    <p>Нет дополнительных данных</p>\r\n@else\r\n    <ul class=\"list_tv_testing\">\r\n        @foreach($filteredTvs as $tv)\r\n            <li>\r\n                <span>{{ $tv->value[\'subtitle\'] ?? \'\' }}</span>\r\n                @if(!empty($tv->value[\'gallery\']))\r\n                    <img src=\"{{ $tv->value[\'gallery\'] }}\" alt=\"Галерея\" >\r\n                @endif\r\n            </li>\r\n        @endforeach\r\n    </ul>\r\n@endif\r\n<style>\r\n    .list_tv_testing{\r\n        display: grid;\r\n        grid-template-columns: 32% 32% 32%;\r\n        column-gap: 2%;\r\n        row-gap: 12px;\r\n        margin-bottom:18px;\r\n    }\r\n    .list_tv_testing li{\r\n        display:flex;\r\n        flex-direction:column;\r\n        border: 1px solid #0496ba;\r\n        border-radius:8px;\r\n        overflow:hidden;\r\n        padding:10px;\r\n    }\r\n    .list_tv_testing li span{\r\n        display:inline-block;\r\n        font-size:22px;\r\n        padding:4px 12px;\r\n    }\r\n    .list_tv_testing li img{\r\n        display:block;\r\n        width:100% !important;\r\n\r\n        flex-shrink: 0;\r\n        object-fit:cover;\r\n    }\r\n</style>\r\n\r\n        <!-- Footer -->\r\n        @chunk(\'footer\')\r\n    </div>\r\n</body>\r\n</html>', '2025-10-31 14:54:11', '2025-11-27 14:17:14'),
(5, 'документация шаблон', '<!DOCTYPE html>\r\n<html lang=\"ru\">\r\n@chunk(\'head\')\r\n<body>\r\n    <div class=\"cms-container\">\r\n        <!-- Header -->\r\n        @chunk(\'header\')\r\n\r\n\r\n         <!---------------------------------------------------->\r\n@if($document->tvs->isEmpty())\r\n    <p>Нет дополнительных данных</p>\r\n@else\r\n    @foreach($document->tvs as $tv)\r\n        @php\r\n            // Преобразуем массив в объект\r\n            $values = (object)$tv->value;\r\n        @endphp\r\n\r\n        <div class=\"tv-block\">\r\n            <!--<h4>ID TV: {{ $tv->form_tv_id }}</h4>-->\r\n            <ul class=\"car_list\">\r\n                <li class=\"car_item\">\r\n                    <h4>{{ $values->subtitle }}</h4>\r\n                    <p>{{ $values->description }}</p>\r\n                </li>\r\n            </ul>\r\n        </div>\r\n    @endforeach\r\n@endif\r\n<!--ftrftftf-->\r\n        \r\n        @chunk(\'footer\')\r\n<!--lkuhiuh8h-->\r\n        \r\n    </div>\r\n\r\n    <script>\r\n        // Простой скрипт для переключения вкладок\r\n        document.addEventListener(\'DOMContentLoaded\', function() {\r\n            const tabs = document.querySelectorAll(\'.editor-tab\');\r\n            \r\n            tabs.forEach(tab => {\r\n                tab.addEventListener(\'click\', function() {\r\n                    // Убираем активный класс у всех вкладок\r\n                    tabs.forEach(t => t.classList.remove(\'active\'));\r\n                    // Добавляем активный класс к текущей вкладке\r\n                    this.classList.add(\'active\');\r\n                });\r\n            });\r\n            \r\n            // Автогенерация URL на основе заголовка\r\n            const titleInput = document.getElementById(\'page-title\');\r\n            const urlInput = document.getElementById(\'page-url\');\r\n            \r\n            titleInput.addEventListener(\'input\', function() {\r\n                if (!urlInput.value) {\r\n                    const url = this.value\r\n                        .toLowerCase()\r\n                        .replace(/[^\\wа-яё]+/g, \'-\')\r\n                        .replace(/^-+|-+$/g, \'\');\r\n                    urlInput.value = url;\r\n                }\r\n            });\r\n        });\r\n    </script>\r\n</body>\r\n</html>', '2025-11-01 10:31:36', '2025-11-27 14:15:52'),
(6, 'test', '<!DOCTYPE html>\r\n<html lang=\"ru\">\r\n@chunk(\'head\')\r\n<body>\r\n    <div class=\"cms-container\">\r\n        <!-- Header -->\r\n        @chunk(\'header\')\r\n        <h1>hello</h1>\r\n        \r\n        @chunk(\'footer\')\r\n        <!-- Footer -->\r\n        \r\n    </div>\r\n\r\n</body>\r\n</html>', '2025-11-02 04:14:23', '2025-11-22 08:10:29');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `country`, `city`, `phone`, `email_verified_at`, `password`, `role_id`, `avatar`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'serega', 'www.delphi7.ap55@gmail.com', NULL, NULL, NULL, NULL, '$2y$12$qSnf6PVayGQHZ6UEVGlfROqYgm1ElCycgKTIQ9KqTT0aBdK2FglC.', '1', NULL, NULL, '2025-10-31 14:23:56', '2025-10-31 14:23:56');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Индексы таблицы `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Индексы таблицы `chunks`
--
ALTER TABLE `chunks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `chunks_name_unique` (`name`);

--
-- Индексы таблицы `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `documents_alias_unique` (`alias`),
  ADD UNIQUE KEY `documents_uri_unique` (`uri`),
  ADD KEY `documents_parent_id_foreign` (`parent_id`),
  ADD KEY `documents_template_id_foreign` (`template_id`);

--
-- Индексы таблицы `document_tvs`
--
ALTER TABLE `document_tvs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `document_tvs_document_id_foreign` (`document_id`),
  ADD KEY `document_tvs_form_tv_id_foreign` (`form_tv_id`);

--
-- Индексы таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Индексы таблицы `folders`
--
ALTER TABLE `folders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `folders_parent_id_foreign` (`parent_id`);

--
-- Индексы таблицы `forms_tv`
--
ALTER TABLE `forms_tv`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `forms_tv_template_id_name_unique` (`template_id`,`name`);

--
-- Индексы таблицы `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Индексы таблицы `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `media_files`
--
ALTER TABLE `media_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_files_user_id_foreign` (`user_id`),
  ADD KEY `media_files_folder_id_foreign` (`folder_id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_slug_unique` (`slug`);

--
-- Индексы таблицы `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Индексы таблицы `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Индексы таблицы `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `chunks`
--
ALTER TABLE `chunks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT для таблицы `document_tvs`
--
ALTER TABLE `document_tvs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `folders`
--
ALTER TABLE `folders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `forms_tv`
--
ALTER TABLE `forms_tv`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `media_files`
--
ALTER TABLE `media_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `templates`
--
ALTER TABLE `templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `documents` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `documents_template_id_foreign` FOREIGN KEY (`template_id`) REFERENCES `templates` (`id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `document_tvs`
--
ALTER TABLE `document_tvs`
  ADD CONSTRAINT `document_tvs_document_id_foreign` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `document_tvs_form_tv_id_foreign` FOREIGN KEY (`form_tv_id`) REFERENCES `forms_tv` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `folders`
--
ALTER TABLE `folders`
  ADD CONSTRAINT `folders_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `folders` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `forms_tv`
--
ALTER TABLE `forms_tv`
  ADD CONSTRAINT `forms_tv_template_id_foreign` FOREIGN KEY (`template_id`) REFERENCES `templates` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `media_files`
--
ALTER TABLE `media_files`
  ADD CONSTRAINT `media_files_folder_id_foreign` FOREIGN KEY (`folder_id`) REFERENCES `folders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `media_files_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

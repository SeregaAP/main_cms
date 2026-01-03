-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Хост: MariaDB-10.4:3306
-- Время создания: Янв 03 2026 г., 20:15
-- Версия сервера: 10.4.34-MariaDB
-- Версия PHP: 8.2.29

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
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `type` enum('document','category','product') NOT NULL DEFAULT 'document',
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `format` varchar(255) NOT NULL DEFAULT 'html',
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT 1,
  `show_in_menu` tinyint(1) NOT NULL DEFAULT 0,
  `is_cache` tinyint(1) NOT NULL DEFAULT 1,
  `position` int(11) NOT NULL DEFAULT 0,
  `full_path` varchar(255) DEFAULT NULL,
  `template_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `documents`
--

INSERT INTO `documents` (`id`, `title`, `content`, `type`, `meta_title`, `meta_description`, `alias`, `parent_id`, `format`, `user_id`, `published`, `show_in_menu`, `is_cache`, `position`, `full_path`, `template_id`, `created_at`, `updated_at`) VALUES
(36, 'Главная', 'Начальный текст', 'document', 'главная', 'главная страница cms lumix', 'glavnaya', NULL, 'html', 1, 1, 1, 1, 0, 'glavnaya', 3, '2025-12-28 11:49:32', '2025-12-30 15:28:50'),
(40, 'Каталог', 'Начальный текст', 'document', 'каталог', 'телкфоны описание', 'katalog', NULL, 'html', 1, 1, 1, 1, 1, 'katalog', 7, '2025-12-30 14:34:39', '2026-01-02 01:39:36'),
(41, 'sitemap', 'Начальный текст', 'document', 'maps', 'sitemap для сайта', 'sitemap', NULL, 'xml', 1, 1, 1, 1, 2, 'sitemap', 5, '2025-12-30 15:18:31', '2025-12-30 15:18:31'),
(42, 'текст', 'Начальный текст', 'document', 'weffewf', 'телкфоны описание', 'tekst', NULL, 'txt', 1, 1, 1, 1, 3, 'tekst', 6, '2025-12-30 15:25:43', '2025-12-30 15:25:43');

-- --------------------------------------------------------

--
-- Структура таблицы `document_tv_values`
--

CREATE TABLE `document_tv_values` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `document_id` bigint(20) UNSIGNED NOT NULL,
  `tv_form_id` bigint(20) UNSIGNED NOT NULL,
  `value` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `document_tv_values`
--

INSERT INTO `document_tv_values` (`id`, `document_id`, `tv_form_id`, `value`, `created_at`, `updated_at`) VALUES
(1, 36, 18, 'Наконец то заработало', '2026-01-01 09:49:49', '2026-01-03 07:30:41'),
(2, 36, 19, 'терпения', '2026-01-01 09:49:49', '2026-01-03 07:30:41'),
(3, 36, 20, 'images\\noutbuks-2.jpg', '2026-01-01 12:14:37', '2026-01-03 09:32:23'),
(4, 36, 21, 'images\\noutbuks.jpg', '2026-01-03 09:21:27', '2026-01-03 09:32:07');

-- --------------------------------------------------------

--
-- Структура таблицы `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `jobs`
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
-- Структура таблицы `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_12_12_174439_create_roles_table', 1),
(5, '2025_12_17_160408_create_templates_table', 1),
(6, '2025_12_17_160409_create_documents_table', 1),
(7, '2025_12_29_154817_create_tv_forms_table', 2),
(8, '2025_12_29_155218_create_template_tv_form_table', 2),
(9, '2025_12_29_155319_create_document_tv_values_table', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`permissions`)),
  `description` varchar(255) DEFAULT NULL,
  `is_system` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `permissions`, `description`, `is_system`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'super-admin', '[\"*\"]', 'ползователь имеет полный доступ', 1, '2025-12-21 17:41:09', '2025-12-25 17:41:09');

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `templates`
--

CREATE TABLE `templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `templates`
--

INSERT INTO `templates` (`id`, `title`, `description`, `content`, `is_active`, `sort_order`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'шаблон гланая', 'шаблон главной страницы', '<!DOCTYPE html>\r\n<html lang=\"ru\">\r\n<head>\r\n    <meta charset=\"UTF-8\">\r\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\r\n    <title>Document</title>\r\n    <link rel=\"stylesheet\" href=\"./css/style.css\">\r\n</head>\r\n<body>\r\n    <div class=\"section test\">\r\n        <div class=\"container\">\r\n       <h2>HELLO MIRROR YES SINTACSIS ENABLED</h2>\r\n        </div>\r\n    </div>\r\n</body>\r\n</html>\r\n\r\n@if($document->title == \'Главная\')\r\n\r\n@endif\r\n{{ $document->title }}', 1, 0, '2025-12-24 12:45:25', '2025-12-28 11:42:56', '2025-12-28 11:42:56'),
(2, 'Каталог шаблон', 'шаблон для страниц категорий', '<h2><font color=\"#49b692\">шаблон для страниц категорий yes ok</font></h2>', 1, 0, '2025-12-28 03:49:30', '2025-12-28 11:42:54', '2025-12-28 11:42:54'),
(3, 'Шаблон главная', 'шаблон для главной страницы', '<!DOCTYPE html>\r\n<html lang=\"ru\">\r\n<head>\r\n    <meta charset=\"UTF-8\">\r\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\r\n    <title>Lumix CMS • Документация</title>\r\n    <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css\">\r\n    <style>\r\n        :root {\r\n            --primary: #2ecc71;\r\n            --primary-light: #bdf3d3;\r\n            --dark: #0f172a;\r\n            --light: #f8fafc;\r\n            --gray: #64748b;\r\n        }\r\n        \r\n        * {\r\n            margin: 0;\r\n            padding: 0;\r\n            box-sizing: border-box;\r\n        }\r\n        \r\n        body {\r\n            font-family: \'Inter\', -apple-system, BlinkMacSystemFont, sans-serif;\r\n            background: var(--dark);\r\n            color: var(--light);\r\n            overflow-x: hidden;\r\n            min-height: 100vh;\r\n        }\r\n        \r\n        /* 3D Эффект в шапке */\r\n        .hero-3d {\r\n            height: 100vh;\r\n            display: flex;\r\n            align-items: center;\r\n            justify-content: center;\r\n            position: relative;\r\n            overflow: hidden;\r\n        }\r\n        \r\n        .hero-bg {\r\n            position: absolute;\r\n            top: 0;\r\n            left: 0;\r\n            right: 0;\r\n            bottom: 0;\r\n            background: \r\n                radial-gradient(circle at 20% 80%, rgba(46, 204, 113, 0.15) 0%, transparent 50%),\r\n                radial-gradient(circle at 80% 20%, rgba(46, 204, 113, 0.1) 0%, transparent 50%),\r\n                radial-gradient(circle at 40% 40%, rgba(46, 204, 113, 0.08) 0%, transparent 50%);\r\n        }\r\n        \r\n        .floating-element {\r\n            position: absolute;\r\n            border-radius: 20px;\r\n            background: rgba(46, 204, 113, 0.1);\r\n            backdrop-filter: blur(10px);\r\n            border: 1px solid rgba(46, 204, 113, 0.2);\r\n            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);\r\n            transition: transform 0.3s;\r\n        }\r\n        \r\n        .floating-1 {\r\n            width: 200px;\r\n            height: 200px;\r\n            top: 15%;\r\n            left: 10%;\r\n            animation: float1 20s infinite ease-in-out;\r\n        }\r\n        \r\n        .floating-2 {\r\n            width: 150px;\r\n            height: 150px;\r\n            bottom: 20%;\r\n            right: 15%;\r\n            animation: float2 25s infinite ease-in-out;\r\n        }\r\n        \r\n        .floating-3 {\r\n            width: 100px;\r\n            height: 100px;\r\n            top: 50%;\r\n            right: 20%;\r\n            animation: float3 30s infinite ease-in-out;\r\n        }\r\n        \r\n        @keyframes float1 {\r\n            0%, 100% { transform: translate(0, 0) rotate(0deg); }\r\n            33% { transform: translate(30px, -50px) rotate(120deg); }\r\n            66% { transform: translate(-20px, 30px) rotate(240deg); }\r\n        }\r\n        \r\n        @keyframes float2 {\r\n            0%, 100% { transform: translate(0, 0) rotate(0deg); }\r\n            33% { transform: translate(-40px, 20px) rotate(-120deg); }\r\n            66% { transform: translate(20px, -40px) rotate(-240deg); }\r\n        }\r\n        \r\n        @keyframes float3 {\r\n            0%, 100% { transform: translate(0, 0) rotate(0deg); }\r\n            33% { transform: translate(20px, 30px) rotate(90deg); }\r\n            66% { transform: translate(-30px, -20px) rotate(180deg); }\r\n        }\r\n        \r\n        /* Контент */\r\n        .hero-content {\r\n            position: relative;\r\n            z-index: 10;\r\n            text-align: center;\r\n            max-width: 800px;\r\n            padding: 0 20px;\r\n        }\r\n        \r\n        .logo {\r\n            font-size: 48px;\r\n            font-weight: 800;\r\n            margin-bottom: 20px;\r\n        }\r\n        \r\n        .logo span {\r\n            background: linear-gradient(135deg, #2ecc71, #27ae60);\r\n            -webkit-background-clip: text;\r\n            -webkit-text-fill-color: transparent;\r\n            display: inline-block;\r\n            position: relative;\r\n        }\r\n        \r\n        .logo span::after {\r\n            content: \'\';\r\n            position: absolute;\r\n            bottom: -10px;\r\n            left: 50%;\r\n            transform: translateX(-50%);\r\n            width: 60px;\r\n            height: 4px;\r\n            background: #2ecc71;\r\n            border-radius: 2px;\r\n        }\r\n        \r\n        .tagline {\r\n            font-size: 20px;\r\n            color: #94a3b8;\r\n            margin-bottom: 40px;\r\n            line-height: 1.6;\r\n        }\r\n        \r\n        /* Кнопки */\r\n        .cta-buttons {\r\n            display: flex;\r\n            gap: 20px;\r\n            justify-content: center;\r\n            margin-bottom: 60px;\r\n        }\r\n        \r\n        .btn {\r\n            padding: 16px 32px;\r\n            border-radius: 12px;\r\n            font-weight: 600;\r\n            text-decoration: none;\r\n            display: inline-flex;\r\n            align-items: center;\r\n            gap: 10px;\r\n            transition: all 0.3s;\r\n            position: relative;\r\n            overflow: hidden;\r\n        }\r\n        \r\n        .btn-primary {\r\n            background: linear-gradient(135deg, #2ecc71, #27ae60);\r\n            color: white;\r\n            box-shadow: 0 10px 30px rgba(46, 204, 113, 0.3);\r\n        }\r\n        \r\n        .btn-primary:hover {\r\n            transform: translateY(-3px);\r\n            box-shadow: 0 15px 40px rgba(46, 204, 113, 0.4);\r\n        }\r\n        \r\n        .btn-outline {\r\n            background: rgba(255, 255, 255, 0.1);\r\n            color: white;\r\n            border: 1px solid rgba(46, 204, 113, 0.3);\r\n            backdrop-filter: blur(10px);\r\n        }\r\n        \r\n        .btn-outline:hover {\r\n            background: rgba(46, 204, 113, 0.1);\r\n            border-color: #2ecc71;\r\n        }\r\n        \r\n        /* Прокрутка вниз */\r\n        .scroll-down {\r\n            position: absolute;\r\n            bottom: 40px;\r\n            left: 50%;\r\n            transform: translateX(-50%);\r\n            color: #94a3b8;\r\n            display: flex;\r\n            flex-direction: column;\r\n            align-items: center;\r\n            gap: 10px;\r\n            cursor: pointer;\r\n            transition: color 0.3s;\r\n        }\r\n        \r\n        .scroll-down:hover {\r\n            color: #2ecc71;\r\n        }\r\n        \r\n        .scroll-down i {\r\n            animation: bounce 2s infinite;\r\n        }\r\n        \r\n        @keyframes bounce {\r\n            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }\r\n            40% { transform: translateY(-10px); }\r\n            60% { transform: translateY(-5px); }\r\n        }\r\n        \r\n        /* Основной контент */\r\n        .content {\r\n            max-width: 900px;\r\n            margin: 0 auto;\r\n            padding: 100px 20px;\r\n        }\r\n        \r\n        .section {\r\n            background: rgba(255, 255, 255, 0.05);\r\n            backdrop-filter: blur(10px);\r\n            border-radius: 20px;\r\n            padding: 40px;\r\n            margin-bottom: 40px;\r\n            border: 1px solid rgba(255, 255, 255, 0.1);\r\n            transition: transform 0.3s, box-shadow 0.3s;\r\n        }\r\n        \r\n        .section:hover {\r\n            transform: translateY(-5px);\r\n            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);\r\n            border-color: rgba(46, 204, 113, 0.3);\r\n        }\r\n        \r\n        .section-title {\r\n            font-size: 28px;\r\n            margin-bottom: 20px;\r\n            color: #2ecc71;\r\n            display: flex;\r\n            align-items: center;\r\n            gap: 15px;\r\n        }\r\n        \r\n        .section-title i {\r\n            width: 40px;\r\n            height: 40px;\r\n            background: rgba(46, 204, 113, 0.2);\r\n            border-radius: 10px;\r\n            display: flex;\r\n            align-items: center;\r\n            justify-content: center;\r\n        }\r\n        \r\n        .code-block {\r\n            background: rgba(0, 0, 0, 0.3);\r\n            border-radius: 12px;\r\n            padding: 25px;\r\n            font-family: \'JetBrains Mono\', monospace;\r\n            font-size: 14px;\r\n            line-height: 1.8;\r\n            margin: 20px 0;\r\n            border-left: 4px solid #2ecc71;\r\n            overflow-x: auto;\r\n        }\r\n        \r\n        .api-method {\r\n            display: inline-block;\r\n            padding: 8px 16px;\r\n            background: rgba(46, 204, 113, 0.2);\r\n            color: #2ecc71;\r\n            border-radius: 8px;\r\n            font-weight: 600;\r\n            font-size: 14px;\r\n            margin-right: 10px;\r\n            border: 1px solid rgba(46, 204, 113, 0.3);\r\n        }\r\n        \r\n        .feature-grid {\r\n            display: grid;\r\n            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));\r\n            gap: 20px;\r\n            margin-top: 30px;\r\n        }\r\n        \r\n        .feature {\r\n            background: rgba(255, 255, 255, 0.05);\r\n            padding: 20px;\r\n            border-radius: 12px;\r\n            border: 1px solid rgba(255, 255, 255, 0.1);\r\n        }\r\n        \r\n        .feature i {\r\n            color: #2ecc71;\r\n            font-size: 24px;\r\n            margin-bottom: 15px;\r\n        }\r\n        \r\n        /* Футер */\r\n        footer {\r\n            text-align: center;\r\n            padding: 60px 20px;\r\n            color: #94a3b8;\r\n            border-top: 1px solid rgba(255, 255, 255, 0.1);\r\n        }\r\n        \r\n        .footer-links {\r\n            display: flex;\r\n            justify-content: center;\r\n            gap: 30px;\r\n            margin: 30px 0;\r\n        }\r\n        \r\n        .footer-links a {\r\n            color: #94a3b8;\r\n            text-decoration: none;\r\n            transition: color 0.3s;\r\n        }\r\n        \r\n        .footer-links a:hover {\r\n            color: #2ecc71;\r\n        }\r\n        \r\n        /* Адаптивность */\r\n        @media (max-width: 768px) {\r\n            .cta-buttons {\r\n                flex-direction: column;\r\n                align-items: center;\r\n            }\r\n            \r\n            .btn {\r\n                width: 100%;\r\n                max-width: 300px;\r\n                justify-content: center;\r\n            }\r\n            \r\n            .feature-grid {\r\n                grid-template-columns: 1fr;\r\n            }\r\n            \r\n            .section {\r\n                padding: 30px 20px;\r\n            }\r\n            \r\n            .logo {\r\n                font-size: 36px;\r\n            }\r\n        }\r\n    </style>\r\n</head>\r\n<body>\r\n    <!-- 3D Шапка -->\r\n    <section class=\"hero-3d\">\r\n        <div class=\"hero-bg\"></div>\r\n        \r\n        <!-- Плавающие элементы -->\r\n        <div class=\"floating-element floating-1\"></div>\r\n        <div class=\"floating-element floating-2\"></div>\r\n        <div class=\"floating-element floating-3\"></div>\r\n        \r\n        <div class=\"hero-content\">\r\n            <h1 class=\"logo\">\r\n                <span>LUMIX CMS</span>\r\n            </h1>\r\n            \r\n            <p class=\"tagline\">\r\n                Современная система управления контентом для Laravel<br>\r\n                Мощный API • Красивый интерфейс • Простая настройка\r\n            </p>\r\n            \r\n            <div class=\"cta-buttons\">\r\n                <a href=\"#docs\" class=\"btn btn-primary\">\r\n                    <i class=\"fas fa-book\"></i> Документация\r\n                </a>\r\n                <a href=\"#api\" class=\"btn btn-outline\">\r\n                    <i class=\"fas fa-code\"></i> API Справка\r\n                </a>\r\n                <a href=\"/admin\" class=\"btn btn-outline\">\r\n                    <i class=\"fas fa-cog\"></i> Панель управления\r\n                </a>\r\n            </div>\r\n            \r\n            <div class=\"code-block\" style=\"text-align: left;\">\r\n                <span style=\"color: #2ecc71;\"># Установка</span><br>\r\n                <span style=\"color: #94a3b8;\">$ composer create-project lumix/cms my-project</span><br>\r\n                <span style=\"color: #94a3b8;\">$ cd my-project</span><br>\r\n                <span style=\"color: #94a3b8;\">$ php artisan serve</span>\r\n            </div>\r\n        </div>\r\n        \r\n        <div class=\"scroll-down\" onclick=\"scrollToContent()\">\r\n            <span>Прокрутите вниз</span>\r\n            <i class=\"fas fa-chevron-down\"></i>\r\n        </div>\r\n    </section>\r\n    \r\n    <!-- Основной контент -->\r\n    <div class=\"content\" id=\"docs\">\r\n        <!-- Быстрый старт -->\r\n        <section class=\"section\">\r\n            <h2 class=\"section-title\">\r\n                <i class=\"fas fa-rocket\"></i> Быстрый старт\r\n            </h2>\r\n            \r\n            <p style=\"margin-bottom: 20px; color: #cbd5e1;\">\r\n                Установите Lumix CMS за несколько минут и начните работу сразу.\r\n            </p>\r\n            \r\n            <div class=\"code-block\">\r\ncomposer create-project lumix/cms my-project<br>\r\ncd my-project<br>\r\nphp artisan migrate --seed<br>\r\nphp artisan serve\r\n            </div>\r\n            \r\n            <div style=\"margin-top: 20px; padding: 15px; background: rgba(46, 204, 113, 0.1); border-radius: 10px;\">\r\n                <strong style=\"color: #2ecc71;\">Доступ к админке:</strong> \r\n                <span style=\"color: #cbd5e1;\">http://localhost:8000/admin</span><br>\r\n                <strong style=\"color: #2ecc71;\">Логин:</strong> \r\n                <span style=\"color: #cbd5e1;\">admin@example.com</span><br>\r\n                <strong style=\"color: #2ecc71;\">Пароль:</strong> \r\n                <span style=\"color: #cbd5e1;\">password</span>\r\n            </div>\r\n        </section>\r\n        \r\n        <!-- Медиа менеджер -->\r\n        <section class=\"section\" id=\"api\">\r\n            <h2 class=\"section-title\">\r\n                <i class=\"fas fa-images\"></i> Медиа менеджер API\r\n            </h2>\r\n            \r\n            <p style=\"margin-bottom: 20px; color: #cbd5e1;\">\r\n                Удобное управление файлами через REST API. Полностью интегрирован с админкой.\r\n            </p>\r\n            \r\n            <div style=\"margin: 25px 0;\">\r\n                <span class=\"api-method\">GET</span>\r\n                <strong style=\"font-size: 18px;\">/api/media/folder</strong>\r\n                <p style=\"color: #94a3b8; margin-top: 10px;\">Получить список файлов и папок</p>\r\n            </div>\r\n            \r\n            <div class=\"code-block\">\r\n// Получить содержимое корневой папки<br>\r\nfetch(\'/api/media/folder\')<br>\r\n    .then(res => res.json())<br>\r\n    .then(data => console.log(data));<br><br>\r\n\r\n// Получить содержимое подпапки<br>\r\nfetch(\'/api/media/folder?path=images/products\')<br>\r\n    .then(res => res.json())<br>\r\n    .then(data => console.log(data));\r\n            </div>\r\n            \r\n            <div style=\"margin-top: 20px;\">\r\n                <span class=\"api-method\">POST</span>\r\n                <strong style=\"font-size: 18px;\">/api/media/upload</strong>\r\n                <p style=\"color: #94a3b8; margin-top: 10px;\">Загрузить файл</p>\r\n            </div>\r\n        </section>\r\n        \r\n        <!-- Основные возможности -->\r\n        <section class=\"section\">\r\n            <h2 class=\"section-title\">\r\n                <i class=\"fas fa-star\"></i> Основные возможности\r\n            </h2>\r\n            \r\n            <div class=\"feature-grid\">\r\n                <div class=\"feature\">\r\n                    <i class=\"fas fa-shield-alt\"></i>\r\n                    <h3 style=\"margin-bottom: 10px; color: #e2e8f0;\">Безопасность</h3>\r\n                    <p style=\"color: #94a3b8; font-size: 14px;\">Встроенная защита, RBAC, 2FA</p>\r\n                </div>\r\n                \r\n                <div class=\"feature\">\r\n                    <i class=\"fas fa-bolt\"></i>\r\n                    <h3 style=\"margin-bottom: 10px; color: #e2e8f0;\">Скорость</h3>\r\n                    <p style=\"color: #94a3b8; font-size: 14px;\">Оптимизация, кэширование, WebSocket</p>\r\n                </div>\r\n                \r\n                <div class=\"feature\">\r\n                    <i class=\"fas fa-puzzle-piece\"></i>\r\n                    <h3 style=\"margin-bottom: 10px; color: #e2e8f0;\">Модульность</h3>\r\n                    <p style=\"color: #94a3b8; font-size: 14px;\">Гибкая система модулей</p>\r\n                </div>\r\n                \r\n                <div class=\"feature\">\r\n                    <i class=\"fas fa-globe\"></i>\r\n                    <h3 style=\"margin-bottom: 10px; color: #e2e8f0;\">Мультиязычность</h3>\r\n                    <p style=\"color: #94a3b8; font-size: 14px;\">Поддержка многих языков</p>\r\n                </div>\r\n            </div>\r\n        </section>\r\n        \r\n        <!-- Другие API методы -->\r\n        <section class=\"section\">\r\n            <h2 class=\"section-title\">\r\n                <i class=\"fas fa-code\"></i> Другие API методы\r\n            </h2>\r\n            \r\n            <div style=\"display: grid; gap: 15px;\">\r\n                <div>\r\n                    <span class=\"api-method\">POST</span>\r\n                    <strong>/api/auth/login</strong>\r\n                    <span style=\"color: #94a3b8; margin-left: 10px;\">Аутентификация</span>\r\n                </div>\r\n                \r\n                <div>\r\n                    <span class=\"api-method\">GET</span>\r\n                    <strong>/api/users</strong>\r\n                    <span style=\"color: #94a3b8; margin-left: 10px;\">Пользователи</span>\r\n                </div>\r\n                \r\n                <div>\r\n                    <span class=\"api-method\">GET</span>\r\n                    <strong>/api/pages</strong>\r\n                    <span style=\"color: #94a3b8; margin-left: 10px;\">Страницы</span>\r\n                </div>\r\n                \r\n                <div>\r\n                    <span class=\"api-method\">GET</span>\r\n                    <strong>/api/settings</strong>\r\n                    <span style=\"color: #94a3b8; margin-left: 10px;\">Настройки</span>\r\n                </div>\r\n            </div>\r\n        </section>\r\n    </div>\r\n    \r\n    <!-- Футер -->\r\n    <footer>\r\n        <div class=\"footer-links\">\r\n            <a href=\"#docs\">Документация</a>\r\n            <a href=\"#api\">API</a>\r\n            <a href=\"/admin\">Админка</a>\r\n            <a href=\"https://github.com\">GitHub</a>\r\n        </div>\r\n        <p style=\"margin-top: 20px; font-size: 14px;\">\r\n            © 2024 Lumix CMS • Версия 2.0 • Лицензия MIT\r\n        </p>\r\n    </footer>\r\n    \r\n    <script>\r\n        // Прокрутка к контенту\r\n        function scrollToContent() {\r\n            document.querySelector(\'.content\').scrollIntoView({\r\n                behavior: \'smooth\'\r\n            });\r\n        }\r\n        \r\n        // Параллакс эффект для фона\r\n        document.addEventListener(\'mousemove\', (e) => {\r\n            const x = (window.innerWidth - e.pageX * 2) / 100;\r\n            const y = (window.innerHeight - e.pageY * 2) / 100;\r\n            \r\n            document.querySelector(\'.hero-bg\').style.transform = \r\n                `translate(${x}px, ${y}px)`;\r\n        });\r\n        \r\n        // Анимация появления секций\r\n        const observer = new IntersectionObserver((entries) => {\r\n            entries.forEach(entry => {\r\n                if (entry.isIntersecting) {\r\n                    entry.target.style.opacity = 1;\r\n                    entry.target.style.transform = \'translateY(0)\';\r\n                }\r\n            });\r\n        }, {\r\n            threshold: 0.1\r\n        });\r\n        \r\n        document.querySelectorAll(\'.section\').forEach(section => {\r\n            section.style.opacity = 0;\r\n            section.style.transform = \'translateY(30px)\';\r\n            section.style.transition = \'all 0.6s ease\';\r\n            observer.observe(section);\r\n        });\r\n    </script>\r\n</body>\r\n</html>', 1, 0, '2025-12-28 11:48:37', '2026-01-03 10:13:47', NULL),
(4, 'шаблон каталога', 'шаблон для категорий', '<!DOCTYPE html>\r\n<html lang=\"ru\">\r\n<head>\r\n    <meta charset=\"UTF-8\">\r\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\r\n    <title>Lumix CMS | Магическая система управления</title>\r\n    <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css\">\r\n    <link href=\"https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=MedievalSharp&family=Merriweather:wght@300;400&display=swap\" rel=\"stylesheet\">\r\n    <style>\r\nh2{\r\n  color:red;\r\n    </style>\r\n</head>\r\n<body>\r\n  <h2>hello serega</h2>\r\n</body>\r\n</html>', 1, 0, '2025-12-29 12:17:18', '2025-12-30 15:15:20', NULL),
(5, 'sitemap template', 'sitemaps', '<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n<document id=\"1\" name=\"document\">\r\n  <meta>\r\n    <created_at>2025-12-30 19:57:10</created_at>\r\n    <updated_at>2025-12-30 19:57:10</updated_at>\r\n  </meta>\r\n  <content><![CDATA[\r\n      HTML / Blade / Text\r\n  ]]></content>\r\n</document>', 1, 0, '2025-12-30 15:17:46', '2025-12-30 15:17:46', NULL),
(6, 'шаблон текста', 'шаблон текста', 'В этом году у казахстанцев будет четыре выходных дня подряд с 1 по 4 января. Это отличная возможность весело встретить Новый год, не ограничиваться домашним застольем и выбраться в город. Tengri Life собрал подборку мероприятий, куда можно сходить в Астане, в Алматы и в Шымкенте.', 1, 0, '2025-12-30 15:25:09', '2025-12-30 15:25:09', NULL),
(7, 'fwefewf', 'efwefewfwef', '<h2>hello testing editor</h2>', 1, 0, '2026-01-02 01:39:16', '2026-01-02 01:39:16', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `template_tv_form`
--

CREATE TABLE `template_tv_form` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `template_id` bigint(20) UNSIGNED NOT NULL,
  `tv_form_id` bigint(20) UNSIGNED NOT NULL,
  `position` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `template_tv_form`
--

INSERT INTO `template_tv_form` (`id`, `template_id`, `tv_form_id`, `position`) VALUES
(18, 3, 18, 0),
(19, 3, 19, 0),
(20, 3, 20, 0),
(21, 3, 21, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `tv_forms`
--

CREATE TABLE `tv_forms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `type` enum('text','image','migx') NOT NULL,
  `description` text DEFAULT NULL,
  `config` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`config`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `tv_forms`
--

INSERT INTO `tv_forms` (`id`, `name`, `key`, `type`, `description`, `config`, `created_at`, `updated_at`) VALUES
(18, 'Vasy', 'vasy', 'text', 'tyuytfytfytfyf', '{\"placeholder\":\"\\u0412\\u0432\\u0435\\u0434\\u0438\\u0442\\u0435 \\u0437\\u043d\\u0430\\u0447\\u0435\\u043d\\u0438\\u0435\",\"default\":\"\",\"maxlength\":255}', '2026-01-01 08:15:55', '2026-01-01 08:15:55'),
(19, 'test1', 'ruby', 'text', 'jghvyuvyuvuvu', '{\"placeholder\":\"\\u0412\\u0432\\u0435\\u0434\\u0438\\u0442\\u0435\",\"default\":\"\",\"maxlength\":255}', '2026-01-01 09:31:11', '2026-01-02 02:44:03'),
(20, 'Фон для секций о нас', 'kompleks', 'image', 'uyguguyguyguyg', '{\"accept\":[\"jpg\",\"png\",\"webp\"],\"maxSize\":2048,\"preview\":true}', '2026-01-01 12:14:09', '2026-01-03 09:08:41'),
(21, 'Картинка для баннера акций', 'action_bg', 'image', 'Картинка для баннера акций', '{\"accept\":[\"jpg\",\"png\",\"webp\"],\"maxSize\":2048,\"preview\":true}', '2026-01-03 09:16:55', '2026-01-03 09:16:55');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `country` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `country`, `city`, `phone`, `email_verified_at`, `avatar`, `password`, `role_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Serega', 'www.delphi7.ap55@gmail.com', NULL, NULL, NULL, NULL, 'images/avatar.jpg', '$2y$12$uu8I6N2irR/nh2SIWvqFSOrB6QpnIkvgs0XOrZG84VKty6fABuqzC', 1, NULL, '2025-12-24 17:44:46', '2025-12-24 17:44:46');

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
-- Индексы таблицы `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `documents_alias_unique` (`alias`),
  ADD KEY `documents_user_id_foreign` (`user_id`),
  ADD KEY `documents_type_index` (`type`),
  ADD KEY `documents_published_index` (`published`),
  ADD KEY `documents_parent_id_published_index` (`parent_id`,`published`),
  ADD KEY `documents_template_id_foreign` (`template_id`),
  ADD KEY `documents_position_index` (`position`);

--
-- Индексы таблицы `document_tv_values`
--
ALTER TABLE `document_tv_values`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `document_tv_values_document_id_tv_form_id_unique` (`document_id`,`tv_form_id`),
  ADD KEY `document_tv_values_tv_form_id_foreign` (`tv_form_id`);

--
-- Индексы таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Индексы таблицы `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `template_tv_form`
--
ALTER TABLE `template_tv_form`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `template_tv_form_template_id_tv_form_id_unique` (`template_id`,`tv_form_id`),
  ADD KEY `template_tv_form_tv_form_id_foreign` (`tv_form_id`);

--
-- Индексы таблицы `tv_forms`
--
ALTER TABLE `tv_forms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tv_forms_key_unique` (`key`);

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
-- AUTO_INCREMENT для таблицы `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT для таблицы `document_tv_values`
--
ALTER TABLE `document_tv_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `templates`
--
ALTER TABLE `templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `template_tv_form`
--
ALTER TABLE `template_tv_form`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT для таблицы `tv_forms`
--
ALTER TABLE `tv_forms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `documents` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `documents_template_id_foreign` FOREIGN KEY (`template_id`) REFERENCES `templates` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `documents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `document_tv_values`
--
ALTER TABLE `document_tv_values`
  ADD CONSTRAINT `document_tv_values_document_id_foreign` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `document_tv_values_tv_form_id_foreign` FOREIGN KEY (`tv_form_id`) REFERENCES `tv_forms` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `template_tv_form`
--
ALTER TABLE `template_tv_form`
  ADD CONSTRAINT `template_tv_form_template_id_foreign` FOREIGN KEY (`template_id`) REFERENCES `templates` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `template_tv_form_tv_form_id_foreign` FOREIGN KEY (`tv_form_id`) REFERENCES `tv_forms` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

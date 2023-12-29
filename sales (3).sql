-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 25, 2023 at 09:08 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sales`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` tinyint(4) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `added_by` tinyint(4) DEFAULT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `com_code` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `username`, `password`, `created_at`, `updated_at`, `added_by`, `updated_by`, `com_code`) VALUES
(11, NULL, NULL, 'user', '$2y$10$CgQdCkLmoaGM/U.ssBZPpe56yM07DgrdkBi23PBPzIGhqlGxa32ym', '2023-08-23 10:34:45', '2023-08-23 10:34:45', NULL, NULL, 1),
(12, NULL, NULL, 'admin', '$2y$10$EqU/.XjRMhQGBsYweLzXdOBIP.BD6dAQpeTB/i924HUGoVCAsT89q', '2023-08-23 10:35:57', '2023-08-23 10:35:57', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `admin_panel_settings`
--

CREATE TABLE `admin_panel_settings` (
  `id` int(11) NOT NULL,
  `system_name` varchar(250) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `com_code` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `admin_panel_settings`
--

INSERT INTO `admin_panel_settings` (`id`, `system_name`, `address`, `phone`, `added_by`, `updated_by`, `created_at`, `updated_at`, `com_code`) VALUES
(1, 'MONOGRAINS', 'المنطقة الصناعية', '01223725049', 0, 1, '2023-01-03 03:58:03', '2023-08-22 12:16:58', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) NOT NULL,
  `customer_code` bigint(20) NOT NULL,
  `name` varchar(225) NOT NULL,
  `start_balance_status` tinyint(4) DEFAULT NULL COMMENT '0-balance\r\n1-credit\r\n2-debit',
  `account_number` bigint(20) DEFAULT NULL,
  `start_balance` decimal(10,0) DEFAULT NULL COMMENT 'دائن او مدين او متزن اول المدة',
  `current_balance` decimal(10,0) DEFAULT 0,
  `notes` varchar(255) DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `active` tinyint(4) DEFAULT 0,
  `com_code` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='جدول الشجرة المحاسبية العامة';

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `customer_code`, `name`, `start_balance_status`, `account_number`, `start_balance`, `current_balance`, `notes`, `added_by`, `updated_by`, `created_at`, `updated_at`, `active`, `com_code`, `date`, `city_id`, `address`) VALUES
(1, 1, 'عميل 11', NULL, NULL, NULL, '0', 'شكرا لاستخدامك برنامجنا', 1, 1, '2023-08-22 12:19:19', '2023-08-25 20:52:10', 1, 1, '2023-08-22', NULL, 'دمياط الجديدة ح5 مج28');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employeeId` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `current_balance` int(11) DEFAULT 0,
  `notes` varchar(250) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `date` date NOT NULL,
  `com_code` int(11) NOT NULL,
  `start_balance_status` tinyint(4) DEFAULT NULL COMMENT '2creadit\r\n1debit\r\n0balanced',
  `address` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employeeId`, `name`, `current_balance`, `notes`, `created_at`, `updated_at`, `date`, `com_code`, `start_balance_status`, `address`) VALUES
(1, 'موظف1', -1000, NULL, '2023-08-22 12:43:01', '2023-08-22 12:43:32', '2023-08-22', 1, 0, 'دمياط الجديدة ح5 مج28');

-- --------------------------------------------------------

--
-- Table structure for table `inv_categories`
--

CREATE TABLE `inv_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `com_code` int(11) NOT NULL,
  `date` date DEFAULT NULL COMMENT 'for search',
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='جدول فئات الاصناف';

-- --------------------------------------------------------

--
-- Table structure for table `inv_items_per_category`
--

CREATE TABLE `inv_items_per_category` (
  `id` bigint(20) NOT NULL,
  `item_code` bigint(20) DEFAULT NULL,
  `barcode` varchar(50) DEFAULT NULL,
  `name` varchar(225) DEFAULT NULL,
  `item_type` tinyint(1) DEFAULT NULL COMMENT '1normal item\r\n2chassis',
  `item_stock_type` int(11) DEFAULT NULL COMMENT '1limtless number of items\r\n2limit quantity',
  `inv_category_id` int(11) DEFAULT NULL,
  `primary_item_id` bigint(20) DEFAULT NULL COMMENT 'كود الصنف الاب التابع له هذه العنصر',
  `has_retailunit` tinyint(1) DEFAULT NULL COMMENT 'هل للصنف واحدة تجزيئة',
  `retail_unit_id` int(11) DEFAULT NULL COMMENT 'كود وحدة التجزئه',
  `primary_unit_id` int(11) DEFAULT NULL COMMENT 'وحدة قياس الاب ',
  `units_per_parent` decimal(10,2) DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1,
  `date` date DEFAULT NULL,
  `com_code` int(11) DEFAULT NULL,
  `primary_retail_price` decimal(10,2) DEFAULT NULL COMMENT 'السعر قطاعي للوحدة الاساسيه',
  `primary_half_wholesale_price` decimal(10,2) DEFAULT NULL COMMENT 'سعر نص جمله للواحدة الاساسية',
  `primary_wholesale_price` decimal(10,2) DEFAULT NULL COMMENT 'سعر الجمله للواحدة الاساسية',
  `secondary_retail_price` decimal(10,2) DEFAULT NULL COMMENT 'السعر قطاعي لوحدة التجزيئه',
  `secondary_half_wholesale_price` decimal(10,2) DEFAULT NULL COMMENT 'السعرنص جملة لوحدة التجزيئه',
  `secondary_wholesale_price` decimal(10,2) DEFAULT NULL COMMENT 'سعر الجملو لوحده التجزئة',
  `primary_cost` decimal(10,2) DEFAULT NULL COMMENT 'تكلف لشراء الوحدة الاساسية على الشركة',
  `secondary_cost` decimal(10,2) DEFAULT NULL COMMENT 'تكلفة شراء المنتج بالتجزئة على الشركة',
  `has_fixed_price` tinyint(1) DEFAULT NULL COMMENT 'هل للصنف سعر ثابت او قابل للنقاش',
  `stock_quantity` int(11) DEFAULT NULL COMMENT 'الكمية بالوحدة الاب',
  `retail_quantity` decimal(10,2) DEFAULT NULL COMMENT 'الكمية المتبقية من الاوحده الاساسية فى حاله وجود فرط منها',
  `primary_and_retial_quantity` decimal(10,2) DEFAULT NULL COMMENT 'المجموع الكلى لعدد الوحدات الاب والتجزيئة معا',
  `photo` varchar(225) DEFAULT NULL,
  `width` int(11) DEFAULT 100,
  `length` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `inv_items_per_category`
--

INSERT INTO `inv_items_per_category` (`id`, `item_code`, `barcode`, `name`, `item_type`, `item_stock_type`, `inv_category_id`, `primary_item_id`, `has_retailunit`, `retail_unit_id`, `primary_unit_id`, `units_per_parent`, `added_by`, `updated_by`, `created_at`, `updated_at`, `active`, `date`, `com_code`, `primary_retail_price`, `primary_half_wholesale_price`, `primary_wholesale_price`, `secondary_retail_price`, `secondary_half_wholesale_price`, `secondary_wholesale_price`, `primary_cost`, `secondary_cost`, `has_fixed_price`, `stock_quantity`, `retail_quantity`, `primary_and_retial_quantity`, `photo`, `width`, `length`) VALUES
(1, 1, NULL, 'غراء', 1, 2, NULL, NULL, NULL, NULL, 2, NULL, 1, 1, '2023-08-22 12:18:49', '2023-08-22 12:41:51', 1, '2023-08-22', 1, '500.00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7000, NULL, NULL, NULL, 100, NULL),
(2, 2, NULL, 'شكارة0', 1, 2, NULL, NULL, NULL, NULL, 1, NULL, 12, 12, '2023-08-25 20:50:54', '2023-08-25 20:51:26', 1, '2023-08-25', 1, '42.00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5000, NULL, NULL, NULL, 100, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inv_units`
--

CREATE TABLE `inv_units` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `is_master` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `com_code` int(11) NOT NULL,
  `date` date DEFAULT NULL COMMENT 'for search',
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='جدول الوحدات';

--
-- Dumping data for table `inv_units`
--

INSERT INTO `inv_units` (`id`, `name`, `is_master`, `created_at`, `updated_at`, `added_by`, `updated_by`, `com_code`, `date`, `active`) VALUES
(1, 'KG', 1, '2023-08-22 12:17:28', '2023-08-22 12:17:28', 1, NULL, 1, '2023-08-22', 1),
(2, 'عبوة', 1, '2023-08-22 12:18:20', '2023-08-22 12:18:20', 1, NULL, 1, '2023-08-22', 1);

-- --------------------------------------------------------

--
-- Table structure for table `salesinvoices`
--

CREATE TABLE `salesinvoices` (
  `id` mediumint(9) NOT NULL,
  `sales_invoice_id` mediumint(9) NOT NULL,
  `invoice_date` date NOT NULL COMMENT 'تاريخ الفاتورة',
  `customer_id` mediumint(9) DEFAULT NULL COMMENT 'كود العميل',
  `com_code` tinyint(4) NOT NULL DEFAULT 1,
  `notes` varchar(225) DEFAULT NULL,
  `invoice_total_price_with_old` decimal(10,0) DEFAULT NULL COMMENT 'السعر الكلي بالقديم',
  `final_total_cost` decimal(10,2) DEFAULT 0.00 COMMENT 'القيمة الاجمالية النهائية للفاتورة بدون القديم',
  `what_paid` decimal(10,2) DEFAULT 0.00,
  `what_remain` decimal(10,2) DEFAULT 0.00,
  `added_by` tinyint(4) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `date` date NOT NULL,
  `is_approved` tinyint(4) NOT NULL DEFAULT 0,
  `old_remain` int(11) DEFAULT 0,
  `what_old_paid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='المبيعات للعملاء';

--
-- Dumping data for table `salesinvoices`
--

INSERT INTO `salesinvoices` (`id`, `sales_invoice_id`, `invoice_date`, `customer_id`, `com_code`, `notes`, `invoice_total_price_with_old`, `final_total_cost`, `what_paid`, `what_remain`, `added_by`, `created_at`, `updated_at`, `updated_by`, `date`, `is_approved`, `old_remain`, `what_old_paid`) VALUES
(2, 1, '2023-08-22', 1, 1, NULL, '500', '500.00', '0.00', '500.00', 1, '2023-08-22 12:29:53', '2023-08-22 12:30:45', NULL, '2023-08-22', 1, 0, 0),
(3, 2, '2023-08-22', 1, 1, NULL, '5000', '4500.00', '0.00', '5000.00', 1, '2023-08-22 12:31:10', '2023-08-22 12:31:15', NULL, '2023-08-22', 1, -500, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sales_invoice_details`
--

CREATE TABLE `sales_invoice_details` (
  `id` mediumint(9) NOT NULL,
  `customer_id` mediumint(9) DEFAULT NULL,
  `sales_invoice_id` mediumint(9) DEFAULT NULL,
  `item_code` mediumint(9) DEFAULT NULL,
  `unit_id` smallint(6) DEFAULT NULL,
  `quantity` mediumint(9) DEFAULT NULL,
  `total_unit_price` decimal(10,2) DEFAULT NULL,
  `unit_price` mediumint(9) NOT NULL,
  `invoice_total_price` decimal(10,2) DEFAULT NULL,
  `what_paid` decimal(10,0) NOT NULL,
  `what_remain` decimal(10,0) NOT NULL,
  `com_code` tinyint(4) DEFAULT 1,
  `invoice_date` date DEFAULT NULL,
  `added_by` tinyint(4) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `date` date DEFAULT NULL,
  `chassisWidthValue` smallint(6) DEFAULT NULL,
  `item_serial` bigint(20) DEFAULT NULL,
  `item_type` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='تفاصيل انصاف فاتورة المشتريات والمرتجعات';

--
-- Dumping data for table `sales_invoice_details`
--

INSERT INTO `sales_invoice_details` (`id`, `customer_id`, `sales_invoice_id`, `item_code`, `unit_id`, `quantity`, `total_unit_price`, `unit_price`, `invoice_total_price`, `what_paid`, `what_remain`, `com_code`, `invoice_date`, `added_by`, `created_at`, `updated_by`, `updated_at`, `date`, `chassisWidthValue`, `item_serial`, `item_type`) VALUES
(2, 1, 1, 1, 2, 1, '500.00', 500, '0.00', '0', '0', 1, '2023-08-22', 1, '2023-08-22 12:29:52', NULL, '2023-08-22 12:29:52', '2023-08-22', 0, 1692700192, 1),
(4, 1, 2, 1, 2, 9, '4500.00', 500, '0.00', '0', '0', 1, '2023-08-22', 1, '2023-08-22 12:31:10', NULL, '2023-08-22 12:31:10', '2023-08-22', 0, 1692700270, 1);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) NOT NULL,
  `supplier_code` bigint(20) DEFAULT NULL,
  `supplier_type_id` int(11) DEFAULT NULL,
  `name` varchar(225) DEFAULT NULL,
  `start_balance_status` tinyint(4) DEFAULT NULL COMMENT '0-balance\r\n1-credit\r\n2-debit',
  `account_number` bigint(20) DEFAULT NULL,
  `start_balance` decimal(10,0) DEFAULT NULL COMMENT 'دائن او مدين او متزن اول المدة',
  `current_balance` decimal(10,0) DEFAULT 0,
  `notes` varchar(255) DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `active` tinyint(4) DEFAULT 0,
  `com_code` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='جدول الشجرة المحاسبية العامة';

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `supplier_code`, `supplier_type_id`, `name`, `start_balance_status`, `account_number`, `start_balance`, `current_balance`, `notes`, `added_by`, `updated_by`, `created_at`, `updated_at`, `active`, `com_code`, `date`, `city_id`, `address`) VALUES
(1, 1, 1, 'مورد 11', NULL, NULL, NULL, '0', NULL, 1, 1, '2023-08-22 12:22:48', '2023-08-22 12:23:42', 1, 1, '2023-08-22', NULL, 'دمياط الجديدة ح5 مج28');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_orders`
--

CREATE TABLE `supplier_orders` (
  `id` bigint(20) NOT NULL,
  `order_type` tinyint(1) DEFAULT NULL COMMENT '1-مشتريات\r\n2-مرتجع\r\n3- مرتجع عام',
  `auto_serial` bigint(20) DEFAULT NULL COMMENT 'رقم خاص لكل فاتورة بديل عن ال id',
  `doc_no` varchar(20) DEFAULT NULL COMMENT 'رقم الفاتورة اللى باخدها من المورد',
  `order_date` date DEFAULT NULL COMMENT 'تاريخ الفاتورة',
  `supplier_code` bigint(20) DEFAULT NULL,
  `is_approved` tinyint(1) DEFAULT 0 COMMENT 'هل تم اعتماد الفاتورة وتوثر حاليا فى الحساب والسحب من المخزن؟',
  `com_code` int(11) DEFAULT NULL,
  `discount_type` tinyint(1) DEFAULT 0 COMMENT '1-خصم نسبة\r\n2-خصم يديوي',
  `discount_percent` decimal(10,0) DEFAULT 0 COMMENT 'نسبة الخصم',
  `discount_value` int(11) DEFAULT 0 COMMENT 'قيمة الخصم',
  `tax_percent` decimal(10,0) DEFAULT 0 COMMENT 'نسبة الضريبة ',
  `tax_value` decimal(10,0) DEFAULT 0 COMMENT 'قيمة الضريبه',
  `notes` varchar(250) DEFAULT NULL,
  `bill_final_total_cost` decimal(10,0) DEFAULT 0 COMMENT 'الاجمالي النهائي بعد الضريبة والخصم',
  `bill_total_cost_before_discount` decimal(10,0) DEFAULT 0 COMMENT 'اجمالى الفاتورة يشمل الضريبة وبدون الخصم',
  `account_number` bigint(20) DEFAULT NULL,
  `account_balance` decimal(10,0) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL COMMENT 'كود المخزن الذي سوف يستلم الفاتورة',
  `payment_type` tinyint(4) DEFAULT NULL COMMENT '1كاش\r\n2اجل',
  `paid` decimal(10,0) DEFAULT 0 COMMENT 'المدفوع ',
  `remain` decimal(10,0) DEFAULT 0 COMMENT 'المتبقي فى حاله الاجل',
  `treasuries_transaction_id` bigint(20) DEFAULT NULL,
  `balance_before` decimal(10,0) DEFAULT NULL COMMENT 'رصيد المورد قبل الفاتورة',
  `balance_after` decimal(10,0) DEFAULT NULL COMMENT 'رصيد المورد بعد الفاتورة',
  `added_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `item_total_price` int(11) DEFAULT NULL COMMENT 'السعر الكلي للمنتجات بدون ضريبة او خصم'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='جدول الطلبات الخاصة بالموردين';

--
-- Dumping data for table `supplier_orders`
--

INSERT INTO `supplier_orders` (`id`, `order_type`, `auto_serial`, `doc_no`, `order_date`, `supplier_code`, `is_approved`, `com_code`, `discount_type`, `discount_percent`, `discount_value`, `tax_percent`, `tax_value`, `notes`, `bill_final_total_cost`, `bill_total_cost_before_discount`, `account_number`, `account_balance`, `store_id`, `payment_type`, `paid`, `remain`, `treasuries_transaction_id`, `balance_before`, `balance_after`, `added_by`, `created_at`, `updated_at`, `updated_by`, `item_total_price`) VALUES
(3, 1, 3, NULL, '2023-08-22', 1, 1, 1, 0, '0', 0, '0', '0', NULL, '1500000', '1500000', NULL, NULL, NULL, NULL, '0', '0', NULL, NULL, NULL, 1, '2023-08-22 12:38:06', '2023-08-22 12:39:22', 1, 1500000);

-- --------------------------------------------------------

--
-- Table structure for table `supplier_order_details`
--

CREATE TABLE `supplier_order_details` (
  `id` bigint(20) NOT NULL,
  `supplier_orders_serial` bigint(20) NOT NULL,
  `order_type` tinyint(1) NOT NULL COMMENT '1 is PURCHASE_BILL,\r\n2 is SALES_BILL,\r\n3 is RETURN_BILL,',
  `com_code` int(11) NOT NULL,
  `received_quantity` decimal(10,0) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `unit_price` decimal(10,0) NOT NULL,
  `is_parent_unit` tinyint(1) NOT NULL COMMENT '0-retail\r\n1-main',
  `unit_total_price` decimal(10,0) NOT NULL,
  `order_date` date NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `item_code` bigint(20) NOT NULL,
  `batch_id` bigint(20) DEFAULT NULL COMMENT 'رقم الدفعه للصنف',
  `production_date` date DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `item_type` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='تفاصيل اصناف فاتورة المشتريات والمرتجعات';

--
-- Dumping data for table `supplier_order_details`
--

INSERT INTO `supplier_order_details` (`id`, `supplier_orders_serial`, `order_type`, `com_code`, `received_quantity`, `unit_id`, `unit_price`, `is_parent_unit`, `unit_total_price`, `order_date`, `added_by`, `created_at`, `updated_by`, `updated_at`, `item_code`, `batch_id`, `production_date`, `expire_date`, `item_type`) VALUES
(1, 3, 1, 1, '5000', 2, '300', 1, '1500000', '2023-08-22', 1, '2023-08-22 12:38:33', NULL, '2023-08-22 12:38:33', 1, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `supplier_types`
--

CREATE TABLE `supplier_types` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `com_code` int(11) NOT NULL,
  `date` date DEFAULT NULL COMMENT 'for search',
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `supplier_types`
--

INSERT INTO `supplier_types` (`id`, `name`, `created_at`, `updated_at`, `added_by`, `updated_by`, `com_code`, `date`, `active`) VALUES
(1, 'مورد حديد', '2023-08-22 12:22:18', '2023-08-22 12:22:25', 1, 1, 1, '2023-08-22', 1);

-- --------------------------------------------------------

--
-- Table structure for table `transactions_details`
--

CREATE TABLE `transactions_details` (
  `id` int(11) NOT NULL,
  `transaction_type` tinyint(1) NOT NULL COMMENT '	0withdrawal 1deposite	',
  `user_id` int(11) NOT NULL,
  `transaction_value` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `udated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `treasuries_transactions`
--

CREATE TABLE `treasuries_transactions` (
  `treasuries_transactionsID` int(11) NOT NULL,
  `transaction_money_value` decimal(10,0) DEFAULT NULL COMMENT 'المبلغ المصروف او المحصل بالخزينة',
  `current_account_balance` decimal(10,0) DEFAULT NULL COMMENT 'الاموال المصروفة للحساب',
  `account_number` int(11) DEFAULT NULL COMMENT 'رقم الحساب المالي الذي قام بالحركة المالية',
  `note` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `com_code` int(11) DEFAULT NULL,
  `transaction_date` date DEFAULT NULL,
  `auto_serial` int(11) DEFAULT NULL COMMENT 'كود تلقائي للحركة'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='حركات النقدية للشيفتات الخزن ونوعها والمبلغ والمواعيد';

--
-- Dumping data for table `treasuries_transactions`
--

INSERT INTO `treasuries_transactions` (`treasuries_transactionsID`, `transaction_money_value`, `current_account_balance`, `account_number`, `note`, `created_at`, `added_by`, `updated_at`, `updated_by`, `com_code`, `transaction_date`, `auto_serial`) VALUES
(1, '1000', NULL, 1, 'صرف مبلغ نظير سلفة', '2023-08-22 12:43:32', 1, '2023-08-22 12:43:32', NULL, 1, '2023-08-22', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_panel_settings`
--
ALTER TABLE `admin_panel_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employeeId`);

--
-- Indexes for table `inv_categories`
--
ALTER TABLE `inv_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inv_items_per_category`
--
ALTER TABLE `inv_items_per_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inv_units`
--
ALTER TABLE `inv_units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salesinvoices`
--
ALTER TABLE `salesinvoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_invoice_details`
--
ALTER TABLE `sales_invoice_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_orders`
--
ALTER TABLE `supplier_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_order_details`
--
ALTER TABLE `supplier_order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_types`
--
ALTER TABLE `supplier_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `treasuries_transactions`
--
ALTER TABLE `treasuries_transactions`
  ADD PRIMARY KEY (`treasuries_transactionsID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `admin_panel_settings`
--
ALTER TABLE `admin_panel_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employeeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inv_categories`
--
ALTER TABLE `inv_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inv_items_per_category`
--
ALTER TABLE `inv_items_per_category`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `inv_units`
--
ALTER TABLE `inv_units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `salesinvoices`
--
ALTER TABLE `salesinvoices`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sales_invoice_details`
--
ALTER TABLE `sales_invoice_details`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `supplier_orders`
--
ALTER TABLE `supplier_orders`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `supplier_order_details`
--
ALTER TABLE `supplier_order_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `supplier_types`
--
ALTER TABLE `supplier_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `treasuries_transactions`
--
ALTER TABLE `treasuries_transactions`
  MODIFY `treasuries_transactionsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

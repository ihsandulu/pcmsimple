-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2018 at 11:37 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pcm`
--

-- --------------------------------------------------------

--
-- Table structure for table `bap`
--

CREATE TABLE `bap` (
  `bap_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `bap_qty` int(11) NOT NULL,
  `bap_remarks` text NOT NULL,
  `bap_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `bap_price` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bap`
--

INSERT INTO `bap` (`bap_id`, `product_id`, `bap_qty`, `bap_remarks`, `bap_datetime`, `bap_price`) VALUES
(2, 1, 2, 'Reject Product Invoice INV-II-2018-001', '2018-03-25 17:15:19', 32000),
(3, 1, 2, 'Reject Product Invoice INV-II-2018-001', '2018-03-25 17:15:36', 32000),
(4, 1, 2, 'Reject Product Invoice INV-II-2018-001', '2018-03-25 17:16:17', 32000),
(5, 15, 1, 'Reject Product Invoice INV-II-2018-001', '2018-03-25 17:18:21', 133),
(6, 2, 1, 'Reject Product Invoice INV-II-2018-001', '2018-03-25 17:23:19', 12),
(7, 1, 2, 'Reject Product Invoice INV-II-2018-001', '2018-03-25 17:24:28', 23),
(8, 17, 2, 'Reject Product Invoice INV-V-2018-006', '2018-05-24 03:36:23', 160000);

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `branch_id` int(11) NOT NULL,
  `branch_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`branch_id`, `branch_name`) VALUES
(1, 'Pamulang'),
(2, 'Pekan Baru');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(50) NOT NULL,
  `customer_email` varchar(50) NOT NULL,
  `customer_cp` varchar(15) NOT NULL,
  `customer_address` text NOT NULL,
  `customer_phone` varchar(15) NOT NULL,
  `customer_npwp` varchar(50) NOT NULL,
  `customer_fax` varchar(15) NOT NULL,
  `customer_country` varchar(50) NOT NULL,
  `customer_ktp` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_name`, `customer_email`, `customer_cp`, `customer_address`, `customer_phone`, `customer_npwp`, `customer_fax`, `customer_country`, `customer_ktp`) VALUES
(1, 'PT. Wijaya Karya Industri dan Kontruksi', '', '0856723453', 'Jl. D.I. Pandjaitan Kav.9, Cipinang. Cempedak. Jatinegara, Jakarta Timur-13340.', '+62 21 86863103', '', '+62 21 86863102', 'Indonesia', '23442.2344.44333.22'),
(2, 'PT. INTRA COPENTA', '', '089654324', '', '', '', '', '', '423423.43453.213134'),
(3, 'SJtextile', 'riska@sjtextile.co.id', '', 'Jl. Kapuk Kamal Raya No.66', '', '', '', 'Indonesia', '123.432.14432.22334'),
(5, 'adin', 'adin@mail.com', '', 'Gg.Kober No.90', '', '', '', 'Indonesia', '23423');

-- --------------------------------------------------------

--
-- Table structure for table `customerproduct`
--

CREATE TABLE `customerproduct` (
  `customerproduct_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `customerproduct_price` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customerproduct`
--

INSERT INTO `customerproduct` (`customerproduct_id`, `customer_id`, `product_id`, `customerproduct_price`) VALUES
(6, 2, 3, 6500000),
(7, 2, 4, 27500000),
(8, 2, 5, 2800000),
(9, 2, 6, 70000),
(10, 2, 7, 85000),
(11, 2, 8, 500000),
(12, 2, 9, 1250000),
(13, 2, 10, 2300000),
(14, 2, 11, 450000),
(15, 1, 1, 30000),
(16, 1, 2, 1800000),
(17, 2, 12, 50000),
(18, 1, 15, 100000000),
(19, 1, 12, 50000),
(20, 3, 17, 160000),
(21, 3, 16, 150000),
(22, 3, 12, 50000),
(23, 1, 17, 160000),
(24, 2, 17, 160000);

-- --------------------------------------------------------

--
-- Table structure for table `element`
--

CREATE TABLE `element` (
  `element_id` int(11) NOT NULL,
  `element_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `element`
--

INSERT INTO `element` (`element_id`, `element_name`) VALUES
(1, 'input'),
(2, 'textarea'),
(3, 'checkbox'),
(4, 'date'),
(5, 'datetime');

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `faq_id` int(11) NOT NULL,
  `faq_tanya` text NOT NULL,
  `faq_jawab` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`faq_id`, `faq_tanya`, `faq_jawab`) VALUES
(2, 'What can i do to make you love me?', 'Make much money.'),
(3, 'How to be a man?', 'You must be human.');

-- --------------------------------------------------------

--
-- Table structure for table `gaji`
--

CREATE TABLE `gaji` (
  `gaji_id` int(11) NOT NULL,
  `gaji_name` varchar(50) NOT NULL,
  `gaji_no` varchar(50) NOT NULL,
  `gaji_month` int(11) NOT NULL,
  `gaji_year` int(11) NOT NULL,
  `gaji_period` varchar(100) NOT NULL,
  `gaji_remarks_payment` text NOT NULL,
  `gaji_deduction_name` text NOT NULL,
  `gaji_deduction_amount` bigint(20) NOT NULL,
  `gaji_bank` varchar(255) NOT NULL,
  `gaji_rek` varchar(100) NOT NULL,
  `gaji_prepare` varchar(100) NOT NULL,
  `gaji_approve` varchar(100) NOT NULL,
  `gaji_receive` varchar(100) NOT NULL,
  `gaji_remarks_bank` text NOT NULL,
  `gaji_description` text NOT NULL,
  `gaji_basic` bigint(20) NOT NULL,
  `gaji_rate` bigint(20) NOT NULL,
  `gaji_numday` int(11) NOT NULL,
  `gaji_jenis` varchar(100) NOT NULL COMMENT 'T=Tetap, S=Sementara',
  `branch_id` int(11) NOT NULL,
  `gaji_source` varchar(50) NOT NULL,
  `kas_id` int(11) NOT NULL,
  `petty_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gaji`
--

INSERT INTO `gaji` (`gaji_id`, `gaji_name`, `gaji_no`, `gaji_month`, `gaji_year`, `gaji_period`, `gaji_remarks_payment`, `gaji_deduction_name`, `gaji_deduction_amount`, `gaji_bank`, `gaji_rek`, `gaji_prepare`, `gaji_approve`, `gaji_receive`, `gaji_remarks_bank`, `gaji_description`, `gaji_basic`, `gaji_rate`, `gaji_numday`, `gaji_jenis`, `branch_id`, `gaji_source`, `kas_id`, `petty_id`) VALUES
(4, 'Sujana Masna', 'PSI/ACC/PA-TetapX/2017/001', 10, 2017, 'Salary Period 26 Sept - 25 Oct 2017', '', 'Casbon', 250000, 'Mandiri', '134.000.499.0791', '', '', '', '', 'AR Period 26 Sept - 25 Oct 2017', 0, 350000, 24, 'Tetap', 1, 'petty_id', 0, 27),
(7, 'Hasan', 'PYR-Tetap/XII/2017/002', 12, 2017, '1 November - 30 November', '', '', 0, 'BCA', '928759345', 'Hasan', 'Hasin', 'Hasun', '', '', 100000, 100000, 10, 'Tetap', 1, 'kas_id', 9, 0),
(8, 'Hasan', 'PYR-Tetap/II/2018/003', 2, 2018, '', '', 'Cicilan Koperasi', 50000, 'BCA', '928759345', '', '', '', '', '', 2000000, 100000, 24, 'Tetap', 1, 'kas_id', 10, 0);

-- --------------------------------------------------------

--
-- Table structure for table `grup`
--

CREATE TABLE `grup` (
  `grup_id` int(11) NOT NULL,
  `grup_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grup`
--

INSERT INTO `grup` (`grup_id`, `grup_name`) VALUES
(2, 'Pekerjaan: Pengusaha'),
(3, 'Jakarta');

-- --------------------------------------------------------

--
-- Table structure for table `grupd`
--

CREATE TABLE `grupd` (
  `grupd_id` int(11) NOT NULL,
  `grup_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grupd`
--

INSERT INTO `grupd` (`grupd_id`, `grup_id`, `customer_id`) VALUES
(7, 3, 2),
(9, 3, 3),
(10, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `gudang`
--

CREATE TABLE `gudang` (
  `gudang_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `gudang_qty` float(11,2) NOT NULL DEFAULT '0.00',
  `gudang_inout` enum('','in','out') NOT NULL,
  `sjmasukproduct_id` int(11) NOT NULL,
  `sjmasuk_no` varchar(50) NOT NULL,
  `sjkeluarproduct_id` int(11) NOT NULL,
  `sjkeluar_no` varchar(50) NOT NULL,
  `gudang_keterangan` text NOT NULL,
  `gudang_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `gudang_return` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gudang`
--

INSERT INTO `gudang` (`gudang_id`, `product_id`, `gudang_qty`, `gudang_inout`, `sjmasukproduct_id`, `sjmasuk_no`, `sjkeluarproduct_id`, `sjkeluar_no`, `gudang_keterangan`, `gudang_datetime`, `gudang_return`, `branch_id`) VALUES
(1, 1, 5.00, 'in', 0, '', 0, '', 'Return From PT.Sinarga', '2017-07-19 15:23:04', 0, 0),
(4, 1, 4.00, 'in', 4, 'SJM-323-sf/23/342', 0, '', '', '2017-07-29 14:19:16', 0, 0),
(5, 7, 6.00, 'out', 0, '', 4, 'SJK00002', '', '2017-07-29 17:00:31', 0, 0),
(6, 1, 2.00, 'in', 0, 'SJM-323-sf/23/342', 0, '', '', '2017-07-30 10:08:24', 0, 0),
(9, 1, 3.00, 'in', 7, 'SJM-323-sf/23/342', 0, '', '', '2017-07-30 10:13:12', 0, 0),
(11, 1, 7.00, 'in', 9, 'SJM-323-sf/23/343', 0, '', '', '2017-07-30 10:13:50', 0, 0),
(12, 2, 3.00, 'out', 0, '', 5, 'SJK00001', '', '2017-07-30 10:17:33', 0, 0),
(13, 1, 4.00, 'out', 0, '', 6, 'SJK00001', '', '2017-07-30 10:17:41', 0, 0),
(14, 3, 2.00, 'out', 0, '', 7, 'SJK00002', '', '2017-07-30 10:17:52', 0, 0),
(39, 15, 1.00, 'out', 0, '', 0, '', 'InvoiceINV-II-2018-001', '2018-03-25 17:18:15', 0, 0),
(40, 2, 1.00, 'out', 0, '', 0, '', 'InvoiceINV-II-2018-001', '2018-03-25 17:23:13', 0, 0),
(41, 1, 2.00, 'out', 0, '', 0, '', 'InvoiceINV-II-2018-001', '2018-03-25 17:24:24', 0, 0),
(43, 2, 2.00, 'out', 0, '', 0, '', 'InvoiceINV-III-2018-002', '2018-03-28 03:33:02', 0, 0),
(44, 4, 2.00, 'in', 0, '', 0, '', 'Pengembalian Invoice INV-III-2018-002', '2018-03-28 06:10:01', 0, 0),
(51, 2, 10.00, 'in', 0, '', 0, '', 'Invoice', '2018-04-26 06:53:47', 0, 0),
(54, 2, 1.00, 'out', 0, '', 0, '', 'InvoiceINV-IV-2018-001', '2018-04-26 10:16:15', 0, 0),
(55, 4, 1.00, 'out', 0, '', 0, '', 'InvoiceINV-IV-2018-002', '2018-04-26 10:16:27', 0, 0),
(56, 12, 2.00, 'out', 0, '', 0, '', 'InvoiceINV-IV-2018-003', '2018-04-26 10:24:12', 0, 0),
(57, 2, 2.00, 'out', 0, '', 0, '', 'InvoiceINV-IV-2018-004', '2018-04-29 00:50:31', 0, 0),
(58, 2, 2.40, 'in', 0, '', 0, '', 'Invoice', '2018-04-29 01:40:30', 0, 0),
(59, 12, 4.00, 'in', 0, '', 0, '', '', '2018-05-11 09:11:48', 0, 0),
(60, 4, 1.00, 'in', 0, '', 0, '', 'Pengembalian Invoice INV-IV-2018-005', '2018-05-24 03:32:31', 1, 0),
(61, 4, 1.00, 'in', 0, '', 0, '', '', '2018-05-24 03:33:39', 0, 1),
(62, 6, 2.00, 'in', 0, '', 0, '', 'Pengembalian Invoice INV-V-2018-006', '2018-05-24 03:39:41', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `identity`
--

CREATE TABLE `identity` (
  `identity_id` int(11) NOT NULL,
  `identity_name` varchar(50) NOT NULL,
  `identity_company` varchar(50) NOT NULL,
  `identity_slogan` text NOT NULL,
  `identity_services` text NOT NULL,
  `identity_address` text NOT NULL,
  `identity_email` text NOT NULL,
  `identity_picture` text NOT NULL,
  `identity_phone` varchar(50) NOT NULL,
  `identity_fax` varchar(50) NOT NULL,
  `identity_cp` varchar(50) NOT NULL,
  `identity_npwp` varchar(50) NOT NULL,
  `identity_web` varchar(150) NOT NULL,
  `identity_stok` int(11) NOT NULL COMMENT '0=stok diambil dr sj masuk dan keluar, jg dr manual stok.<br/> 1=stok diambil dr invoice masuk dan keluar, jg dari manual stok',
  `identity_project` int(11) NOT NULL COMMENT '0=tanpa project, 1=dgn project,2=product',
  `identity_city` varchar(255) NOT NULL,
  `identity_kirimemail` int(11) NOT NULL COMMENT '1=kirim email'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `identity`
--

INSERT INTO `identity` (`identity_id`, `identity_name`, `identity_company`, `identity_slogan`, `identity_services`, `identity_address`, `identity_email`, `identity_picture`, `identity_phone`, `identity_fax`, `identity_cp`, `identity_npwp`, `identity_web`, `identity_stok`, `identity_project`, `identity_city`, `identity_kirimemail`) VALUES
(1, 'Project Cost Management', 'Qithycomp', 'IT Solution', '<p>Website | Android | Desktop Application | Networking</p>\r\n', 'Jl. Cempedak No.34, Pasir Putih Sawangan, Depok.', 'admin@qithy.com', '01_07_45_qithy_png.png', '+628567148813', '', 'Ibadi Ichsan', '', 'https://www.qithy.com/', 0, 1, 'Jakarta', 0);

-- --------------------------------------------------------

--
-- Table structure for table `inv`
--

CREATE TABLE `inv` (
  `inv_id` int(11) NOT NULL,
  `inv_title` text NOT NULL,
  `inv_content` text NOT NULL,
  `inv_customize` int(11) NOT NULL COMMENT '1=Product, 2=PPN, 3=PPH',
  `inv_no` varchar(50) NOT NULL,
  `inv_date` text NOT NULL,
  `inv_duedate` date NOT NULL,
  `element_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `poc_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inv`
--

INSERT INTO `inv` (`inv_id`, `inv_title`, `inv_content`, `inv_customize`, `inv_no`, `inv_date`, `inv_duedate`, `element_id`, `project_id`, `poc_id`, `branch_id`) VALUES
(271, 'inv_date', '2018-04-29', 0, 'INV-IV-2018-005', '2018-04-29', '2018-04-30', 0, 0, 4, 1),
(272, 'inv_duedate', '2018-04-30', 0, 'INV-IV-2018-005', '2018-04-29', '2018-04-30', 0, 0, 4, 1),
(273, 'customer_id', '3', 0, 'INV-IV-2018-005', '2018-04-29', '2018-04-30', 0, 0, 4, 1),
(274, 'Job', '', 0, 'INV-IV-2018-005', '2018-04-29', '2018-04-30', 1, 0, 4, 1),
(275, 'Order_No', '', 0, 'INV-IV-2018-005', '2018-04-29', '2018-04-30', 1, 0, 4, 1),
(276, 'Period', '30 April 2018', 0, 'INV-IV-2018-005', '2018-04-29', '2018-04-30', 1, 0, 4, 1),
(277, 'Term', 'Batas maksimal penghapusan domain adalah 1 minggu dari batais akhir pembayaran.', 0, 'INV-IV-2018-005', '2018-04-29', '2018-04-30', 1, 0, 4, 1),
(278, 'Payment', '<p><span style=\"background-color:#e0e0e0; color:#0000bb; font-family:Verdana\">Rek BCA : 7410662218, A/N:IBADI ICHSAN</span></p>\r\n', 0, 'INV-IV-2018-005', '2018-04-29', '2018-04-30', 2, 0, 4, 1),
(279, 'Approved_By', 'Ihsan', 0, 'INV-IV-2018-005', '2018-04-29', '2018-04-30', 1, 0, 4, 1),
(280, 'Attn', 'Ibu Riska', 0, 'INV-IV-2018-005', '2018-04-29', '2018-04-30', 1, 0, 4, 1),
(281, 'Deliver_To', '', 0, 'INV-IV-2018-005', '2018-04-29', '2018-04-30', 1, 0, 4, 1),
(282, 'Receiver', '', 0, 'INV-IV-2018-005', '2018-04-29', '2018-04-30', 1, 0, 4, 1),
(283, 'Driver', '', 0, 'INV-IV-2018-005', '2018-04-29', '2018-04-30', 1, 0, 4, 1),
(284, 'Security', '', 0, 'INV-IV-2018-005', '2018-04-29', '2018-04-30', 1, 0, 4, 1),
(285, 'Storekeeper', '', 0, 'INV-IV-2018-005', '2018-04-29', '2018-04-30', 1, 0, 4, 1),
(286, 'Note', 'Mohon maaf atas keterlambatan invoice ini.', 0, 'INV-IV-2018-005', '2018-04-29', '2018-04-30', 1, 0, 4, 1),
(287, 'inv_date', '2018-05-11', 0, 'INV-V-2018-006', '2018-05-11', '2018-05-11', 0, 1, 0, 1),
(288, 'inv_duedate', '2018-05-11', 0, 'INV-V-2018-006', '2018-05-11', '2018-05-11', 0, 1, 0, 1),
(289, 'customer_id', '1', 0, 'INV-V-2018-006', '2018-05-11', '2018-05-11', 0, 1, 0, 1),
(290, 'Job', '', 0, 'INV-V-2018-006', '2018-05-11', '2018-05-11', 1, 1, 0, 1),
(291, 'Order_No', '', 0, 'INV-V-2018-006', '2018-05-11', '2018-05-11', 1, 1, 0, 1),
(292, 'Period', '', 0, 'INV-V-2018-006', '2018-05-11', '2018-05-11', 1, 1, 0, 1),
(293, 'Term', '', 0, 'INV-V-2018-006', '2018-05-11', '2018-05-11', 1, 1, 0, 1),
(294, 'Payment', '<p>aaaaaaa</p>\r\n', 0, 'INV-V-2018-006', '2018-05-11', '2018-05-11', 2, 1, 0, 1),
(295, 'Approved_By', 'Hanif', 0, 'INV-V-2018-006', '2018-05-11', '2018-05-11', 1, 1, 0, 1),
(296, 'Attn', '', 0, 'INV-V-2018-006', '2018-05-11', '2018-05-11', 1, 1, 0, 1),
(297, 'Deliver_To', '', 0, 'INV-V-2018-006', '2018-05-11', '2018-05-11', 1, 1, 0, 1),
(298, 'Receiver', '', 0, 'INV-V-2018-006', '2018-05-11', '2018-05-11', 1, 1, 0, 1),
(299, 'Driver', '', 0, 'INV-V-2018-006', '2018-05-11', '2018-05-11', 1, 1, 0, 1),
(300, 'Security', '', 0, 'INV-V-2018-006', '2018-05-11', '2018-05-11', 1, 1, 0, 1),
(301, 'Storekeeper', '', 0, 'INV-V-2018-006', '2018-05-11', '2018-05-11', 1, 1, 0, 1),
(302, 'Note', '<p>If you have any questions concerning this Delivery Order, please do not hesitate to contact us.</p>', 0, 'INV-V-2018-006', '2018-05-11', '2018-05-11', 1, 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `invfield`
--

CREATE TABLE `invfield` (
  `invfield_id` int(11) NOT NULL,
  `invfield_name` varchar(50) NOT NULL,
  `element_id` int(11) NOT NULL,
  `invfield_default` text NOT NULL,
  `invfield_customize` int(11) NOT NULL COMMENT '1=Product, 2=PPN, 3=PPH'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invfield`
--

INSERT INTO `invfield` (`invfield_id`, `invfield_name`, `element_id`, `invfield_default`, `invfield_customize`) VALUES
(2, 'Job', 1, '', 0),
(3, 'Order No', 1, '', 0),
(4, 'Period', 1, '', 0),
(5, 'Term', 1, '', 0),
(7, 'Payment', 2, '<p>Rek BCA : 7410662218, A/N:IBADI ICHSAN</p>\r\n', 0),
(8, 'Approved By', 1, '', 0),
(9, 'Attn', 1, '', 0),
(10, 'PPN', 3, '', 2),
(11, 'PPH', 3, '', 3),
(12, 'Deliver To', 1, '', 0),
(13, 'Receiver', 1, '', 0),
(14, 'Driver', 1, '', 0),
(15, 'Security', 1, '', 0),
(16, 'Storekeeper', 1, '', 0),
(17, 'Note', 1, '<p>If you have any questions concerning this Delivery Order, please do not hesitate to contact us.</p>\r\n', 0);

-- --------------------------------------------------------

--
-- Table structure for table `invpayment`
--

CREATE TABLE `invpayment` (
  `invpayment_id` int(11) NOT NULL,
  `inv_no` varchar(100) NOT NULL,
  `invpayment_payfrom` varchar(200) NOT NULL,
  `invpayment_date` date NOT NULL,
  `methodpayment_id` int(11) NOT NULL,
  `invpayment_picture` text NOT NULL,
  `invpayment_prepareby` varchar(200) NOT NULL,
  `invpayment_receivedby` varchar(200) NOT NULL,
  `invpayment_approvedby` varchar(200) NOT NULL,
  `invpayment_no` varchar(50) NOT NULL,
  `invpayment_faktur` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invpayment`
--

INSERT INTO `invpayment` (`invpayment_id`, `inv_no`, `invpayment_payfrom`, `invpayment_date`, `methodpayment_id`, `invpayment_picture`, `invpayment_prepareby`, `invpayment_receivedby`, `invpayment_approvedby`, `invpayment_no`, `invpayment_faktur`) VALUES
(31, 'INV-IV-2018-005', '', '2018-05-08', 1, '', 'Hanif', '', '', 'PIC-V/2018/003', '010.000.18.54320096'),
(29, 'INV-IV-2018-001', '', '2018-04-28', 1, '', '', '', '', 'PIC-IV/2018/001', ''),
(30, 'INV-IV-2018-004', 'hasan', '2018-04-29', 1, '', '', '', '', 'PIC-IV/2018/002', ''),
(34, 'INV-V-2018-006', 'Hasan', '2018-06-13', 1, '', 'Lisa Lestari', '', '', 'PIC-VI-2018-00001', '010.000.18.54320096'),
(35, 'INV-IV-2018-005', 'Hasan', '2018-06-13', 1, '', '', '', '', 'PIC-VI-2018-00002', '');

-- --------------------------------------------------------

--
-- Table structure for table `invpaymentproduct`
--

CREATE TABLE `invpaymentproduct` (
  `invpaymentproduct_id` int(11) NOT NULL,
  `invpaymentproduct_description` text NOT NULL,
  `invpaymentproduct_code` varchar(50) NOT NULL,
  `invpaymentproduct_qty` float(11,2) NOT NULL,
  `invpaymentproduct_amount` bigint(20) NOT NULL,
  `invpayment_no` varchar(100) NOT NULL,
  `invpaymentproduct_source` varchar(50) NOT NULL,
  `kas_id` int(11) NOT NULL,
  `petty_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invpaymentproduct`
--

INSERT INTO `invpaymentproduct` (`invpaymentproduct_id`, `invpaymentproduct_description`, `invpaymentproduct_code`, `invpaymentproduct_qty`, `invpaymentproduct_amount`, `invpayment_no`, `invpaymentproduct_source`, `kas_id`, `petty_id`) VALUES
(12, 'Email Hosting Unlimited', '', 1.00, 100000, 'PIC-V/2018/003', 'petty_id', 0, 31),
(11, '', '', 1.00, 100000, 'PIC-IV/2018/002', 'kas_id', 1, 0),
(13, '', '', 1.00, 200000, 'PIC-VI-2018-00001', 'petty_id', 0, 34);

-- --------------------------------------------------------

--
-- Table structure for table `invproduct`
--

CREATE TABLE `invproduct` (
  `invproduct_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `invproduct_qty` float(11,2) NOT NULL,
  `invproduct_price` bigint(20) NOT NULL,
  `inv_no` varchar(50) NOT NULL,
  `gudang_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invproduct`
--

INSERT INTO `invproduct` (`invproduct_id`, `product_id`, `invproduct_qty`, `invproduct_price`, `inv_no`, `gudang_id`) VALUES
(42, 16, 12.00, 150000, 'INV-IV-2018-005', 0),
(46, 17, 1.00, 160000, 'INV-V-2018-006', 0);

-- --------------------------------------------------------

--
-- Table structure for table `invs`
--

CREATE TABLE `invs` (
  `invs_id` int(11) NOT NULL,
  `invs_no` varchar(100) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `invs_date` date NOT NULL,
  `invs_duedate` date NOT NULL,
  `invs_disc` float NOT NULL,
  `invs_vat` int(11) NOT NULL,
  `invs_confirm` varchar(100) NOT NULL,
  `project_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invs`
--

INSERT INTO `invs` (`invs_id`, `invs_no`, `supplier_id`, `invs_date`, `invs_duedate`, `invs_disc`, `invs_vat`, `invs_confirm`, `project_id`, `branch_id`) VALUES
(10, '123/pra', 1, '2018-05-08', '2018-05-08', 0, 0, '', 0, 1),
(11, '123/aa', 2, '2018-05-10', '2018-05-10', 0, 0, '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `invspayment`
--

CREATE TABLE `invspayment` (
  `invspayment_id` int(11) NOT NULL,
  `invs_no` varchar(100) NOT NULL,
  `invspayment_payto` varchar(200) NOT NULL,
  `invspayment_date` date NOT NULL,
  `methodpayment_id` int(11) NOT NULL,
  `invspayment_picture` text NOT NULL,
  `invspayment_prepareby` varchar(200) NOT NULL,
  `invspayment_receivedby` varchar(200) NOT NULL,
  `invspayment_approvedby` varchar(200) NOT NULL,
  `invspayment_no` varchar(50) NOT NULL,
  `project_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invspayment`
--

INSERT INTO `invspayment` (`invspayment_id`, `invs_no`, `invspayment_payto`, `invspayment_date`, `methodpayment_id`, `invspayment_picture`, `invspayment_prepareby`, `invspayment_receivedby`, `invspayment_approvedby`, `invspayment_no`, `project_id`) VALUES
(25, '', '', '2018-04-28', 1, '', '', '', '', 'PIS-IV/2018/001', 0),
(27, '123/pra', 'aa', '2018-05-28', 1, '', 'vv', 'cc', 'dd', 'PIS-V/2018/002', 0),
(29, '123/pra', 'aa', '2018-06-01', 1, '', '', '', '', 'PIS-VI/2018/001', 0);

-- --------------------------------------------------------

--
-- Table structure for table `invspaymentproduct`
--

CREATE TABLE `invspaymentproduct` (
  `invspaymentproduct_id` int(11) NOT NULL,
  `invspaymentproduct_description` text NOT NULL,
  `invspaymentproduct_code` varchar(50) NOT NULL,
  `invspaymentproduct_qty` float(11,2) NOT NULL,
  `invspaymentproduct_amount` bigint(20) NOT NULL,
  `invspayment_no` varchar(100) NOT NULL,
  `invspaymentproduct_source` varchar(50) NOT NULL,
  `kas_id` int(11) NOT NULL,
  `petty_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invspaymentproduct`
--

INSERT INTO `invspaymentproduct` (`invspaymentproduct_id`, `invspaymentproduct_description`, `invspaymentproduct_code`, `invspaymentproduct_qty`, `invspaymentproduct_amount`, `invspayment_no`, `invspaymentproduct_source`, `kas_id`, `petty_id`) VALUES
(18, '', '', 1.00, 12000, 'PIS-IV/2018/001', 'kas_id', 2, 0),
(19, '', '', 1.00, 1000000, 'PIS-V/2018/002', 'petty_id', 0, 32),
(20, 'asd', 'a', 1.00, 10000, 'PIS-VI/2018/001', 'petty_id', 0, 33);

-- --------------------------------------------------------

--
-- Table structure for table `invsproduct`
--

CREATE TABLE `invsproduct` (
  `invsproduct_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `invsproduct_qty` float(11,2) NOT NULL,
  `invs_no` varchar(100) NOT NULL,
  `invsproduct_price` bigint(20) NOT NULL,
  `gudang_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invsproduct`
--

INSERT INTO `invsproduct` (`invsproduct_id`, `product_id`, `invsproduct_qty`, `invs_no`, `invsproduct_price`, `gudang_id`) VALUES
(12, 2, 1.30, '123/pra', 900000, 0),
(13, 5, 3.00, '123/aa', 2000000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `kas`
--

CREATE TABLE `kas` (
  `kas_id` int(11) NOT NULL,
  `kas_count` bigint(20) NOT NULL,
  `kas_inout` enum('','in','out') NOT NULL,
  `kas_remarks` text NOT NULL,
  `kas_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kas`
--

INSERT INTO `kas` (`kas_id`, `kas_count`, `kas_inout`, `kas_remarks`, `kas_date`) VALUES
(1, 100000, 'in', '', '2018-04-29'),
(2, 12000, 'out', '', '2018-04-28');

-- --------------------------------------------------------

--
-- Table structure for table `kasd`
--

CREATE TABLE `kasd` (
  `kasd_id` int(11) NOT NULL,
  `kasd_count` bigint(20) NOT NULL,
  `kasd_inout` enum('','in','out') NOT NULL,
  `po_no` varchar(50) NOT NULL,
  `invoice_no` varchar(50) NOT NULL,
  `kasd_keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `menu_id` int(11) NOT NULL,
  `menu_title` varchar(255) NOT NULL,
  `menu_url` varchar(255) NOT NULL,
  `menu_href` varchar(255) NOT NULL,
  `menu_fa` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `menu_title`, `menu_url`, `menu_href`, `menu_fa`) VALUES
(1, 'Master', '#', '1', 'sort-down'),
(2, 'Transaksi', '#', '2', 'sort-down'),
(3, 'Report', '#', '3', 'sort-down'),
(4, 'FAQ', '<?=site_url(\"faq?report=ok\");?>\r\n', '4', 'question-circle');

-- --------------------------------------------------------

--
-- Table structure for table `menu_sub`
--

CREATE TABLE `menu_sub` (
  `menu_sub_id` int(11) NOT NULL,
  `menu_sub_title` varchar(255) NOT NULL,
  `menu_sub_url` varchar(255) NOT NULL,
  `menu_sub_href` varchar(255) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `menu_sub_fa` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu_sub`
--

INSERT INTO `menu_sub` (`menu_sub_id`, `menu_sub_title`, `menu_sub_url`, `menu_sub_href`, `menu_id`, `menu_sub_fa`) VALUES
(1, 'Setting User', '#', '1-1', 1, 'sort-down'),
(2, 'Identity', '<?=site_url(\"identity\");?>', '', 1, 'user'),
(3, 'Branch', '<?=site_url(\"branch\");?>', '', 1, 'building-o'),
(4, 'Unit', '<?=site_url(\"unit\");?>', '', 1, 'asterisk'),
(5, 'Product', '<?=site_url(\"product\");?>', '', 1, 'shopping-bag'),
(6, 'Payment', '<?=site_url(\"methodpayment\");?>', '', 1, 'shopping-bag'),
(7, 'Supplier', '#', '1-2', 1, 'sort-down'),
(8, 'Customer', '#', '1-3', 1, 'sort-down'),
(9, 'Task', '<?=site_url(\"task\");?>', '', 2, 'tags'),
(10, 'Out Mail', '<?=site_url(\"suratkeluar\");?>', '', 2, 'envelope-open-o'),
(11, 'Project', '<?=site_url(\"project\");?>', '', 2, 'tags'),
(12, 'Big Cash', '<?=site_url(\"kas\");?>', '', 2, 'money'),
(13, 'Petty Cash', '<?=site_url(\"petty\");?>', '', 2, 'money'),
(14, 'Payroll', '<?=site_url(\'gaji?month=\'.date(\'n\'));?>', '', 2, 'money'),
(15, 'Stock', '<?=site_url(\"gudang\");?>', '', 2, 'cube'),
(16, 'Supplier', '#', '2-1', 2, 'sort-down'),
(17, 'Customer', '#', '2-2', 2, 'sort-down'),
(18, 'Task', '<?=site_url(\"task?report=ok\");?>', '', 3, 'tags'),
(19, 'Out Mail', '<?=site_url(\"suratkeluar?report=ok&dari=\".date(\"Y-m-d\").\"&ke=\".date(\"Y-m-d\"));?>', '', 3, 'envelope-open-o'),
(20, 'Big Cash', '<?=site_url(\"kas?report=ok&dari=\".date(\"Y-m-d\").\"&ke=\".date(\"Y-m-d\"));?>', '', 3, 'money'),
(21, 'Petty Cash', '<?=site_url(\"petty?report=ok&dari=\".date(\"Y-m-d\").\"&ke=\".date(\"Y-m-d\"));?>', '', 3, 'money'),
(22, 'Payroll', '<?=site_url(\"gaji?report=ok&month=\".date(\"n\"));?>', '', 3, 'money'),
(23, 'Stock', '<?=site_url(\"warehouse?report=ok\");?>', '', 3, 'cube'),
(24, 'Project', '<?=site_url(\"projectreport\");?>', '', 3, 'superpowers'),
(25, 'Supplier', '#', '3-1', 3, 'sort-down'),
(26, 'Customer', '#', '3-2', 3, 'sort-down'),
(27, 'Numbering Initials', '<?=site_url(\"nomor\");?>', '', 1, 'tags'),
(28, 'L/R Penjualan', '<?=site_url(\"labarugi\");?>', '', 3, 'money'),
(29, 'BAP', '<?=site_url(\"bap\");?>', '', 3, 'trash'),
(30, 'Pemasukan', '<?=site_url(\"invpayment\");?>', '', 2, 'money'),
(31, 'Pengeluaran', '<?=site_url(\"invspayment\");?>', '', 2, 'money'),
(32, 'SPK/WO', '<?=site_url(\"wo\");?>', '', 2, 'list'),
(33, 'SPK/WO', '<?=site_url(\"wo?report=ok\");?>', '', 3, 'list'),
(34, 'Permintaan Barang', '<?=site_url(\"permintaan\");?>', '', 2, 'tags'),
(35, 'Listing Products', '<?=site_url(\"jualan\");?>', '', 2, 'tags'),
(37, 'Faq', '<?=site_url(\"faq\");?>', '', 1, 'question-circle'),
(38, 'Suggestions', '<?=site_url(\"saran\");?>', '', 2, 'comment');

-- --------------------------------------------------------

--
-- Table structure for table `menu_sub_sub`
--

CREATE TABLE `menu_sub_sub` (
  `menu_sub_sub_id` int(11) NOT NULL,
  `menu_sub_sub_title` varchar(255) NOT NULL,
  `menu_sub_sub_url` varchar(255) NOT NULL,
  `menu_sub_sub_href` varchar(255) NOT NULL,
  `menu_sub_id` int(11) NOT NULL,
  `menu_sub_sub_fa` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu_sub_sub`
--

INSERT INTO `menu_sub_sub` (`menu_sub_sub_id`, `menu_sub_sub_title`, `menu_sub_sub_url`, `menu_sub_sub_href`, `menu_sub_id`, `menu_sub_sub_fa`) VALUES
(1, 'Position', '<?=site_url(\"position\");?>', '', 1, 'arrow-circle-right'),
(2, 'User', '<?=site_url(\"user\");?>', '', 1, 'arrow-circle-right'),
(3, 'Supplier', '<?=site_url(\"supplier\");?>', '', 7, 'arrow-circle-right'),
(4, 'PO Fields', '<?=site_url(\"pofield\");?>', '', 7, 'arrow-circle-right'),
(5, 'Customer', '<?=site_url(\"customer\");?>', '', 8, 'arrow-circle-right'),
(6, 'Quotation Fields', '<?=site_url(\"qfield\");?>', '', 8, 'arrow-circle-right'),
(7, 'Invoice Fields', '<?=site_url(\"invfield\");?>', '', 8, 'arrow-circle-right'),
(8, 'PO', '<?=site_url(\"po\");?>', '', 16, 'arrow-circle-right'),
(9, 'SJ Masuk', '<?=site_url(\"sjmasuk\");?>', '', 16, 'arrow-circle-right'),
(10, 'Invoice', '<?=site_url(\"invs\");?>', '', 16, 'arrow-circle-right'),
(12, 'Quotation & PO', '<?=site_url(\"quotation\");?>', '', 17, 'arrow-circle-right'),
(13, 'PO No Quotation', '<?=site_url(\"poc\");?>', '', 17, 'arrow-circle-right'),
(14, 'SJ Keluar', '<?=site_url(\"sjkeluar\");?>', '', 17, 'arrow-circle-right'),
(16, 'Invoice', '<?=site_url(\"inv\");?>', '', 17, 'arrow-circle-right'),
(18, 'PO', '<?=site_url(\"po?report=ok\");?>', '', 25, 'arrow-circle-right'),
(19, 'SJ Masuk', '<?=site_url(\"sjmasuk?report=ok\");?>', '', 25, 'arrow-circle-right'),
(20, 'Payment Invoice', '<?=site_url(\"spayment?report=ok\");?>', '', 25, 'arrow-circle-right'),
(21, 'Quotation', '<?=site_url(\"quotation?report=ok\");?>', '', 26, 'arrow-circle-right'),
(22, 'Summary Quotation', '<?=site_url(\"sumquotation?report=ok\");?>', '', 26, 'arrow-circle-right'),
(23, 'SJ Keluar', '<?=site_url(\"sjkeluar?report=ok\");?>', '', 26, 'arrow-circle-right'),
(25, 'Invoice', '<?=site_url(\"inv?report=ok\");?>', '', 26, 'arrow-circle-right'),
(26, 'Payment Invoice', '<?=site_url(\"cpayment?report=ok\");?>', '', 26, 'arrow-circle-right'),
(27, 'Customer Group', '<?=site_url(\"grup\");?>', '', 8, 'users');

-- --------------------------------------------------------

--
-- Table structure for table `methodpayment`
--

CREATE TABLE `methodpayment` (
  `methodpayment_id` int(11) NOT NULL,
  `methodpayment_name` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `methodpayment`
--

INSERT INTO `methodpayment` (`methodpayment_id`, `methodpayment_name`) VALUES
(1, 'Cash'),
(2, 'Transfer Bank'),
(3, 'Giro'),
(4, 'Check');

-- --------------------------------------------------------

--
-- Table structure for table `nomor`
--

CREATE TABLE `nomor` (
  `nomor_id` int(11) NOT NULL,
  `nomor_name` varchar(255) NOT NULL,
  `nomor_no` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nomor`
--

INSERT INTO `nomor` (`nomor_id`, `nomor_name`, `nomor_no`) VALUES
(1, 'Surat Keluar', 'SK'),
(2, 'Payroll', 'PYR'),
(3, 'PO Supplier', 'POS'),
(5, 'Payment Invoice Customer', 'PIC'),
(6, 'Payment Invoice Supplier', 'PIS'),
(7, 'Quotation', 'QUO'),
(8, 'SJ Keluar', 'SJK'),
(9, 'Assignment', 'ASG'),
(10, 'Invoice', 'INV'),
(11, 'Permintaan Barang', 'PMB');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan`
--

CREATE TABLE `permintaan` (
  `permintaan_id` int(11) NOT NULL,
  `permintaan_catatan` text NOT NULL,
  `permintaan_mengetahui` varchar(100) NOT NULL,
  `permintaan_finance` varchar(100) NOT NULL,
  `permintaan_pengerjaan` varchar(255) NOT NULL,
  `permintaan_tukang` varchar(100) NOT NULL,
  `permintaan_pemakaian` text NOT NULL,
  `permintaan_retensi` varchar(100) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `permintaan_date` date NOT NULL,
  `permintaan_no` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permintaan`
--

INSERT INTO `permintaan` (`permintaan_id`, `permintaan_catatan`, `permintaan_mengetahui`, `permintaan_finance`, `permintaan_pengerjaan`, `permintaan_tukang`, `permintaan_pemakaian`, `permintaan_retensi`, `branch_id`, `permintaan_date`, `permintaan_no`) VALUES
(1, '<p>aaaaaa</p>\r\n', '', '', '1 hari', 'Dadan', '<ol>\r\n	<li>Kayu 9 m</li>\r\n	<li>Paku 9&quot; 3 pack</li>\r\n	<li>Lem Kayu</li>\r\n	<li>Lem Aibon</li>\r\n</ol>\r\n', '1hari', 1, '2018-06-11', 'PMB-VI-2018-00001'),
(2, '<p>sdfdfdf</p>\r\n', '', '', '2hari', 'Dadan', '<p>-</p>\r\n', '1hari', 1, '2018-06-11', 'PMB-VI-2018-00002');

-- --------------------------------------------------------

--
-- Table structure for table `permintaanproduct`
--

CREATE TABLE `permintaanproduct` (
  `permintaanproduct_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `permintaanproduct_qty` int(11) NOT NULL,
  `permintaanproduct_nama` varchar(100) NOT NULL,
  `permintaanproduct_tlp` varchar(50) NOT NULL,
  `project_id` int(11) NOT NULL,
  `permintaan_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permintaanproduct`
--

INSERT INTO `permintaanproduct` (`permintaanproduct_id`, `product_id`, `permintaanproduct_qty`, `permintaanproduct_nama`, `permintaanproduct_tlp`, `project_id`, `permintaan_id`) VALUES
(1, 7, 2, 'Bp. Bayu', '081210650809', 1, 2),
(2, 9, 1, '', '', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `petty`
--

CREATE TABLE `petty` (
  `petty_id` int(11) NOT NULL,
  `petty_amount` bigint(20) NOT NULL,
  `petty_date` date NOT NULL,
  `petty_remarks` text NOT NULL,
  `kas_id` int(11) NOT NULL,
  `petty_inout` enum('','in','out') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `petty`
--

INSERT INTO `petty` (`petty_id`, `petty_amount`, `petty_date`, `petty_remarks`, `kas_id`, `petty_inout`) VALUES
(31, 100000, '2018-05-08', 'Email Hosting Unlimited', 0, 'in'),
(32, 1000000, '2018-05-28', '', 0, 'out'),
(33, 10000, '0000-00-00', 'asd', 0, 'out'),
(34, 200000, '2018-06-13', '', 0, 'in');

-- --------------------------------------------------------

--
-- Table structure for table `po`
--

CREATE TABLE `po` (
  `po_id` int(11) NOT NULL,
  `po_title` text NOT NULL,
  `po_content` text NOT NULL,
  `po_customize` int(11) NOT NULL COMMENT '1=Product, 2=PPN, 3=PPH',
  `po_no` varchar(50) NOT NULL,
  `po_date` date NOT NULL,
  `element_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `po`
--

INSERT INTO `po` (`po_id`, `po_title`, `po_content`, `po_customize`, `po_no`, `po_date`, `element_id`) VALUES
(7, 'supplier_id', '1', 0, 'POS-IV-2018-001', '2018-04-27', 0),
(8, 'Attention', '', 0, 'POS-IV-2018-001', '2018-04-27', 1),
(9, 'Product', '0', 1, 'POS-IV-2018-001', '2018-04-27', 3),
(10, 'Term_and_Conditions', '<p>Payment : COD</p>\r\n', 0, 'POS-IV-2018-001', '2018-04-27', 2),
(11, 'Prepare_By', '', 0, 'POS-IV-2018-001', '2018-04-27', 1),
(12, 'Approve_By', '', 0, 'POS-IV-2018-001', '2018-04-27', 1),
(13, 'Confirm_By', '', 0, 'POS-IV-2018-001', '2018-04-27', 1);

-- --------------------------------------------------------

--
-- Table structure for table `poc`
--

CREATE TABLE `poc` (
  `poc_id` int(11) NOT NULL,
  `poc_no` varchar(50) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `poc_remarks` text NOT NULL,
  `poc_prepared` varchar(150) NOT NULL,
  `poc_checked` varchar(150) NOT NULL,
  `poc_approved` varchar(150) NOT NULL,
  `poc_confirmed` varchar(150) NOT NULL,
  `quotation_no` varchar(100) NOT NULL,
  `poc_date` date NOT NULL,
  `poc_disc` float NOT NULL,
  `poc_vat` int(11) NOT NULL,
  `poc_picture` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `poc`
--

INSERT INTO `poc` (`poc_id`, `poc_no`, `customer_id`, `project_id`, `poc_remarks`, `poc_prepared`, `poc_checked`, `poc_approved`, `poc_confirmed`, `quotation_no`, `poc_date`, `poc_disc`, `poc_vat`, `poc_picture`) VALUES
(3, '', 1, 0, '', '', '', '', '', '', '2018-04-28', 0, 0, ''),
(4, '23/2e42', 1, 0, '', '', '', '', '', '', '2018-05-21', 0, 0, ''),
(5, 'asdf/234', 3, 0, '', '', '', '', '', '', '2018-05-21', 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `pocproduct`
--

CREATE TABLE `pocproduct` (
  `pocproduct_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `pocproduct_price` bigint(20) NOT NULL,
  `pocproduct_qty` int(11) NOT NULL,
  `poc_no` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pocproduct`
--

INSERT INTO `pocproduct` (`pocproduct_id`, `product_id`, `pocproduct_price`, `pocproduct_qty`, `poc_no`) VALUES
(2, 2, 1800000, 1, '23/2e42'),
(3, 15, 100000000, 1, '23/2e42');

-- --------------------------------------------------------

--
-- Table structure for table `pofield`
--

CREATE TABLE `pofield` (
  `pofield_id` int(11) NOT NULL,
  `pofield_name` varchar(50) NOT NULL,
  `element_id` int(11) NOT NULL,
  `pofield_default` text NOT NULL,
  `pofield_customize` int(11) NOT NULL COMMENT '1=Product, 2=PPN, 3=PPH'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pofield`
--

INSERT INTO `pofield` (`pofield_id`, `pofield_name`, `element_id`, `pofield_default`, `pofield_customize`) VALUES
(1, 'Attention', 1, '', 0),
(2, 'Product', 3, '', 1),
(3, 'Term and Conditions', 2, '<p>Payment : COD</p>\r\n', 0),
(4, 'Prepare By', 1, '', 0),
(5, 'Approve By', 1, '', 0),
(6, 'Confirm By', 1, '', 0),
(7, 'PPN', 3, '', 2),
(8, 'PPH', 3, '', 3);

-- --------------------------------------------------------

--
-- Table structure for table `poproduct`
--

CREATE TABLE `poproduct` (
  `poproduct_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `poproduct_qty` int(11) NOT NULL,
  `poproduct_price` bigint(20) NOT NULL,
  `po_no` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `poproduct`
--

INSERT INTO `poproduct` (`poproduct_id`, `product_id`, `poproduct_qty`, `poproduct_price`, `po_no`) VALUES
(1, 1, 2, 360000, 'POS-IV-2018-001');

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `position_id` int(11) NOT NULL,
  `position_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`position_id`, `position_name`) VALUES
(1, 'Administrator'),
(2, 'Teknisi'),
(3, 'Marketing'),
(4, 'Inventori'),
(5, 'Keuangan'),
(6, 'Customer');

-- --------------------------------------------------------

--
-- Table structure for table `position_menu`
--

CREATE TABLE `position_menu` (
  `position_menu_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `menu_sub_id` int(11) NOT NULL,
  `menu_sub_sub_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `position_menu`
--

INSERT INTO `position_menu` (`position_menu_id`, `position_id`, `menu_id`, `menu_sub_id`, `menu_sub_sub_id`) VALUES
(7, 2, 2, 9, 0),
(8, 2, 3, 18, 0),
(11, 1, 1, 4, 0),
(12, 1, 1, 5, 0),
(13, 1, 1, 6, 0),
(14, 1, 1, 1, 1),
(15, 1, 1, 1, 2),
(16, 1, 1, 7, 3),
(17, 1, 1, 7, 4),
(18, 1, 2, 10, 0),
(19, 1, 2, 11, 0),
(20, 1, 2, 12, 0),
(21, 1, 2, 13, 0),
(22, 1, 2, 14, 0),
(23, 1, 2, 15, 0),
(24, 1, 2, 16, 8),
(25, 1, 2, 16, 9),
(26, 1, 2, 16, 10),
(27, 1, 2, 16, 11),
(28, 1, 2, 17, 12),
(29, 1, 2, 17, 13),
(30, 1, 2, 17, 14),
(31, 1, 2, 17, 15),
(32, 1, 2, 17, 16),
(34, 1, 2, 17, 17),
(35, 1, 3, 19, 0),
(41, 1, 1, 2, 0),
(42, 1, 1, 3, 0),
(43, 1, 3, 20, 0),
(44, 1, 3, 21, 0),
(45, 1, 3, 22, 0),
(46, 1, 3, 23, 0),
(47, 1, 3, 24, 0),
(48, 1, 3, 25, 18),
(49, 1, 3, 25, 19),
(50, 1, 3, 25, 20),
(51, 1, 3, 26, 21),
(52, 1, 3, 26, 22),
(53, 1, 3, 26, 23),
(54, 1, 3, 26, 24),
(55, 1, 3, 26, 25),
(56, 1, 3, 26, 26),
(57, 1, 1, 8, 5),
(58, 1, 1, 8, 7),
(59, 1, 1, 8, 6),
(61, 1, 1, 0, 0),
(62, 1, 2, 0, 0),
(64, 1, 3, 0, 0),
(65, 1, 1, 1, 0),
(66, 1, 1, 7, 0),
(67, 1, 1, 8, 0),
(68, 1, 2, 16, 0),
(69, 1, 2, 17, 0),
(70, 1, 3, 25, 0),
(71, 1, 3, 26, 0),
(72, 2, 2, 0, 0),
(73, 2, 3, 0, 0),
(74, 3, 2, 17, 12),
(75, 3, 2, 17, 16),
(76, 3, 2, 17, 0),
(77, 3, 3, 0, 0),
(78, 3, 2, 0, 0),
(79, 3, 3, 26, 0),
(80, 3, 3, 26, 21),
(81, 3, 3, 26, 22),
(82, 3, 3, 26, 25),
(83, 3, 1, 5, 0),
(84, 3, 1, 6, 0),
(85, 3, 1, 0, 0),
(86, 3, 1, 4, 0),
(87, 3, 1, 8, 0),
(88, 3, 1, 8, 5),
(89, 5, 1, 0, 0),
(90, 5, 1, 1, 0),
(91, 5, 1, 1, 1),
(92, 5, 1, 1, 2),
(93, 5, 1, 4, 0),
(94, 5, 1, 3, 0),
(95, 5, 1, 2, 0),
(96, 5, 1, 6, 0),
(97, 5, 1, 5, 0),
(98, 5, 1, 7, 0),
(99, 5, 1, 7, 3),
(100, 5, 1, 8, 0),
(101, 5, 1, 8, 5),
(102, 5, 2, 0, 0),
(103, 5, 2, 9, 0),
(104, 5, 2, 10, 0),
(105, 5, 2, 11, 0),
(106, 5, 2, 12, 0),
(107, 5, 2, 13, 0),
(108, 5, 2, 14, 0),
(109, 5, 2, 16, 0),
(110, 5, 2, 16, 8),
(112, 5, 2, 16, 10),
(113, 5, 2, 16, 11),
(114, 5, 2, 17, 0),
(115, 5, 2, 17, 12),
(116, 5, 2, 17, 15),
(117, 5, 2, 17, 13),
(118, 5, 2, 17, 16),
(119, 5, 2, 17, 17),
(120, 5, 3, 0, 0),
(121, 5, 3, 18, 0),
(122, 5, 3, 19, 0),
(123, 5, 3, 20, 0),
(124, 5, 3, 21, 0),
(125, 5, 3, 22, 0),
(126, 5, 3, 24, 0),
(127, 5, 3, 25, 0),
(128, 5, 3, 25, 18),
(129, 5, 3, 25, 20),
(130, 5, 3, 26, 0),
(131, 5, 3, 26, 21),
(132, 5, 3, 26, 22),
(133, 5, 3, 26, 24),
(134, 5, 3, 26, 25),
(135, 5, 3, 26, 26),
(136, 4, 1, 4, 0),
(137, 4, 1, 5, 0),
(138, 4, 1, 0, 0),
(139, 4, 2, 0, 0),
(140, 4, 2, 15, 0),
(141, 4, 2, 16, 0),
(142, 4, 2, 16, 9),
(143, 4, 2, 17, 0),
(144, 4, 2, 17, 14),
(145, 4, 3, 0, 0),
(146, 4, 3, 23, 0),
(147, 4, 3, 25, 0),
(148, 4, 3, 26, 0),
(149, 4, 3, 25, 19),
(150, 4, 3, 26, 23),
(151, 1, 1, 27, 0),
(152, 1, 3, 28, 0),
(153, 1, 3, 29, 0),
(154, 1, 2, 30, 0),
(155, 1, 2, 31, 0),
(156, 1, 2, 9, 0),
(157, 1, 3, 18, 0),
(158, 1, 2, 32, 0),
(159, 1, 3, 33, 0),
(160, 1, 2, 34, 0),
(161, 1, 2, 35, 0),
(162, 1, 1, 36, 0),
(163, 1, 1, 8, 27),
(164, 1, 1, 37, 0),
(165, 1, 2, 38, 0),
(166, 1, 3, 39, 0),
(167, 6, 2, 17, 12),
(168, 6, 2, 17, 0),
(169, 6, 2, 38, 0),
(170, 6, 2, 0, 0),
(171, 6, 3, 39, 0),
(173, 1, 4, 0, 0),
(174, 6, 4, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `product_description` text NOT NULL,
  `product_buy` bigint(20) NOT NULL,
  `product_sell` bigint(20) NOT NULL,
  `product_type` enum('0','1') NOT NULL COMMENT '0=product,1=jasa',
  `product_minimal` int(11) NOT NULL,
  `product_picture` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `unit_id`, `product_description`, `product_buy`, `product_sell`, `product_type`, `product_minimal`, `product_picture`) VALUES
(1, 'Developer Liquid G-128 (5 liter)', 3, '', 360000, 0, '0', 0, ''),
(2, 'Ultra Sonic ASNT Level II', 7, '', 1000000, 1800000, '0', 5, ''),
(3, 'Welder  Qualification Test ', 7, '', 4800000, 6500000, '0', 0, ''),
(4, 'Welding Procedure Specification', 7, '', 25000000, 27500000, '0', 10, ''),
(5, 'Radiography Testing  Crew', 3, '', 2000000, 2800000, '0', 0, ''),
(6, 'Radiography Film  4x10', 3, '', 62000, 70000, '0', 0, '17_15_54_18316_4130472547223_398557723_n.jpg'),
(7, 'Radiography Film  4x15', 3, '', 76000, 85000, '0', 0, ''),
(8, 'Transportation', 3, '', 400000, 500000, '0', 0, ''),
(9, 'UT /MT/PT ASNT level II', 3, '', 1000000, 1250000, '0', 5, ''),
(10, 'UT /MT/PT PCN  level II', 3, '', 2000000, 2300000, '0', 0, ''),
(11, 'Ultrasonic Equipment & Calibration Block', 3, '', 340000, 450000, '0', 0, ''),
(12, 'Pemasangan Jaringan Hotspot', 8, '', 0, 50000, '1', 0, ''),
(13, 'Microsite questionnaire application', 7, '', 0, 2000000, '0', 1, ''),
(14, 'Microsite questionnaire application', 7, '', 0, 2000000, '0', 1, ''),
(15, 'Pembuatan Drainase', 7, '', 0, 100000000, '1', 0, ''),
(16, 'Email Hosting Unlimited', 7, '', 0, 150000, '0', 1, ''),
(17, 'Domain co.id', 7, '', 0, 160000, '0', 1, ''),
(18, 'Pemasangan Jaringan', 8, '', 0, 0, '1', 1, '17_13_21_12794484_10206080560520131_8733201915471275957_n.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `project_id` int(11) NOT NULL,
  `project_name` text NOT NULL,
  `project_budget` bigint(20) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `project_description` text NOT NULL,
  `project_code` varchar(150) NOT NULL,
  `project_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `project_selesai` varchar(255) NOT NULL COMMENT 'Selesai, Belum Selesai',
  `project_begin` date NOT NULL,
  `project_end` date NOT NULL,
  `project_jenis` varchar(255) NOT NULL COMMENT 'Personal, Swasta atau Pemerintah'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`project_id`, `project_name`, `project_budget`, `customer_id`, `project_description`, `project_code`, `project_datetime`, `project_selesai`, `project_begin`, `project_end`, `project_jenis`) VALUES
(1, 'Pembangunan Gedung Adi Sucipto', 1500000000, 1, '<p>Pembangunan Gedung Utama Adi Sucipto</p>\r\n', 'HPH BTG', '2017-10-01 09:02:01', 'Belum Selesai', '0000-00-00', '0000-00-00', ''),
(2, 'Pembangunan Drainase Jl Jakarta-Bogor KM.13', 2000000000, 2, '<p>Pembuata Drainase sepanjang Jl.Jakarta-Bogor di KM.13</p>\r\n', 'KM13', '2017-10-12 09:02:01', 'Belum Selesai', '2018-05-31', '0000-00-00', 'Personal');

-- --------------------------------------------------------

--
-- Table structure for table `qfield`
--

CREATE TABLE `qfield` (
  `qfield_id` int(11) NOT NULL,
  `qfield_name` varchar(50) NOT NULL,
  `element_id` int(11) NOT NULL,
  `qfield_default` text NOT NULL,
  `qfield_offerings` enum('0','1') NOT NULL COMMENT '1=Product Offerings'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qfield`
--

INSERT INTO `qfield` (`qfield_id`, `qfield_name`, `element_id`, `qfield_default`, `qfield_offerings`) VALUES
(13, 'To', 1, 'Customer', '0'),
(14, 'Introduction', 2, 'Quotation General NDT and optional rate for above mention we are project to submit the following', '0'),
(15, 'Workscope', 2, 'The testing plan are as follow : General NDT', '0'),
(16, 'Product', 2, '', '1'),
(17, 'Client to Provide The Following Free Of Charge', 2, '<p>Free and unrestricted access to work sites ,assistant crew here conditions render work able passage of personnel&nbsp;and equipment impossible</p>\r\n\r\n<p>Where required provision of shoring, staging, scaffolding, ladders, crane, lighting and removal of all debris and&nbsp;water from work areas,&nbsp;etc as necessary.</p>\r\n', '0'),
(18, 'Payment', 2, '<ul>\r\n	<li>Rates are exclude PPN &amp; VAT</li>\r\n	<li>All Rates quoted are&nbsp;in IDR</li>\r\n	<li>Invoices will be prepared based on approved timesheet which are required to be signed off daily by PT.PSI&nbsp;and&nbsp;approved&nbsp;client rep. Any discrepancies/alterations to be agreed and signed off prior to leaving site.</li>\r\n	<li>Payment terms strictly 30 days from invoice received</li>\r\n	<li>All terms and conditions of the subcontract to be agreed in&nbsp;writing at time of award of (sub) contract</li>\r\n</ul>\r\n', '0'),
(19, 'Closing', 2, '<p>We trust that this commercial proposal is acceptable and meets to your requirements. Please do not hesitate to contact the&nbsp;undersigned if&nbsp;you need&nbsp;any future clarification</p>\r\n\r\n<p>For&amp; on behalf of &nbsp;PT. Pesat Servis Industri</p>\r\n', '0'),
(20, 'Writted By', 1, '', '0'),
(21, 'Datetime', 5, '', '0');

-- --------------------------------------------------------

--
-- Table structure for table `qpicture`
--

CREATE TABLE `qpicture` (
  `qpicture_id` int(11) NOT NULL,
  `picture` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qpicture`
--

INSERT INTO `qpicture` (`qpicture_id`, `picture`, `datetime`) VALUES
(1, '09_00_20_cutting.png', '2018-04-30 09:16:27'),
(2, '10_06_24_21539_1180102629819_7699631_n.jpg', '2018-04-30 09:16:27'),
(3, '10_06_30_26318_1231250148475_2645347_n.jpg', '2018-04-30 09:16:27');

-- --------------------------------------------------------

--
-- Table structure for table `quotation`
--

CREATE TABLE `quotation` (
  `quotation_id` int(11) NOT NULL,
  `quotation_title` text NOT NULL,
  `quotation_content` text NOT NULL,
  `quotation_offerings` enum('0','1') NOT NULL COMMENT '1',
  `quotation_no` varchar(50) NOT NULL,
  `quotation_date` date NOT NULL,
  `element_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `quotation_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quotation`
--

INSERT INTO `quotation` (`quotation_id`, `quotation_title`, `quotation_content`, `quotation_offerings`, `quotation_no`, `quotation_date`, `element_id`, `project_id`, `quotation_status`) VALUES
(222, 'customer_id', '2', '0', 'QUO-VI-2018-00001', '2018-06-18', 0, 0, ''),
(223, 'To', 'Customer', '0', 'QUO-VI-2018-00001', '2018-06-18', 1, 0, ''),
(224, 'Introduction', '<p>Quotation General NDT and optional rate&nbsp;for above mention we are project to&nbsp;submit&nbsp;the following</p>\r\n', '0', 'QUO-VI-2018-00001', '2018-06-18', 2, 0, ''),
(225, 'Workscope', '<p>The testing plan are as follow :&nbsp;General NDT</p>\r\n', '0', 'QUO-VI-2018-00001', '2018-06-18', 2, 0, ''),
(226, 'Product', 'qfield_offerings', '1', 'QUO-VI-2018-00001', '2018-06-18', 0, 0, ''),
(227, 'Client_to_Provide_The_Following_Free_Of_Charge', '<p>Free and unrestricted access to work sites ,assistant crew here conditions render work able passage of personnel&nbsp;and equipment impossible</p>\r\n\r\n<p>Where required provision of shoring, staging, scaffolding, ladders, crane, lighting and removal of all debris and&nbsp;water from work areas,&nbsp;etc as necessary.</p>\r\n', '0', 'QUO-VI-2018-00001', '2018-06-18', 2, 0, ''),
(228, 'Payment', '<ul>\r\n	<li>Rates are exclude PPN &amp; VAT</li>\r\n	<li>All Rates quoted are&nbsp;in IDR</li>\r\n	<li>Invoices will be prepared based on approved timesheet which are required to be signed off daily by PT.PSI&nbsp;and&nbsp;approved&nbsp;client rep. Any discrepancies/alterations to be agreed and signed off prior to leaving site.</li>\r\n	<li>Payment terms strictly 30 days from invoice received</li>\r\n	<li>All terms and conditions of the subcontract to be agreed in&nbsp;writing at time of award of (sub) contract</li>\r\n</ul>\r\n', '0', 'QUO-VI-2018-00001', '2018-06-18', 2, 0, ''),
(229, 'Closing', '<p>We trust that this commercial proposal is acceptable and meets to your requirements. Please do not hesitate to contact the&nbsp;undersigned if&nbsp;you need&nbsp;any future clarification</p>\r\n\r\n<p>For&amp; on behalf of &nbsp;PT. Pesat Servis Industri</p>\r\n', '0', 'QUO-VI-2018-00001', '2018-06-18', 2, 0, ''),
(230, 'Writted_By', '', '0', 'QUO-VI-2018-00001', '2018-06-18', 1, 0, ''),
(231, 'Datetime', '2018-06-18 12:44:09', '0', 'QUO-VI-2018-00001', '2018-06-18', 5, 0, ''),
(232, 'customer_id', '2', '0', 'QUO-VI-2018-00002', '2018-06-21', 0, 0, ''),
(233, 'To', 'Customer', '0', 'QUO-VI-2018-00002', '2018-06-21', 1, 0, ''),
(234, 'Introduction', '<p>Quotation General NDT and optional rate&nbsp;for above mention we are project to&nbsp;submit&nbsp;the following</p>\r\n', '0', 'QUO-VI-2018-00002', '2018-06-21', 2, 0, ''),
(235, 'Workscope', '<p>The testing plan are as follow :&nbsp;General NDT</p>\r\n', '0', 'QUO-VI-2018-00002', '2018-06-21', 2, 0, ''),
(236, 'Product', 'qfield_offerings', '1', 'QUO-VI-2018-00002', '2018-06-21', 0, 0, ''),
(237, 'Client_to_Provide_The_Following_Free_Of_Charge', '<p>Free and unrestricted access to work sites ,assistant crew here conditions render work able passage of personnel&nbsp;and equipment impossible</p>\r\n\r\n<p>Where required provision of shoring, staging, scaffolding, ladders, crane, lighting and removal of all debris and&nbsp;water from work areas,&nbsp;etc as necessary.</p>\r\n', '0', 'QUO-VI-2018-00002', '2018-06-21', 2, 0, ''),
(238, 'Payment', '<ul>\r\n	<li>Rates are exclude PPN &amp; VAT</li>\r\n	<li>All Rates quoted are&nbsp;in IDR</li>\r\n	<li>Invoices will be prepared based on approved timesheet which are required to be signed off daily by PT.PSI&nbsp;and&nbsp;approved&nbsp;client rep. Any discrepancies/alterations to be agreed and signed off prior to leaving site.</li>\r\n	<li>Payment terms strictly 30 days from invoice received</li>\r\n	<li>All terms and conditions of the subcontract to be agreed in&nbsp;writing at time of award of (sub) contract</li>\r\n</ul>\r\n', '0', 'QUO-VI-2018-00002', '2018-06-21', 2, 0, ''),
(239, 'Closing', '<p>We trust that this commercial proposal is acceptable and meets to your requirements. Please do not hesitate to contact the&nbsp;undersigned if&nbsp;you need&nbsp;any future clarification</p>\r\n\r\n<p>For&amp; on behalf of &nbsp;PT. Pesat Servis Industri</p>\r\n', '0', 'QUO-VI-2018-00002', '2018-06-21', 2, 0, ''),
(240, 'Writted_By', '', '0', 'QUO-VI-2018-00002', '2018-06-21', 1, 0, ''),
(241, 'Datetime', '2018-06-21 11:28:05', '0', 'QUO-VI-2018-00002', '2018-06-21', 5, 0, ''),
(262, 'customer_id', '2', '0', 'QUO-VI-2018-00003', '2018-06-24', 0, 0, ''),
(263, 'To', 'Customer', '0', 'QUO-VI-2018-00003', '2018-06-24', 1, 0, ''),
(264, 'Introduction', '<p>Quotation General NDT and optional rate&nbsp;for above mention we are project to&nbsp;submit&nbsp;the following</p>\r\n', '0', 'QUO-VI-2018-00003', '2018-06-24', 2, 0, ''),
(265, 'Workscope', '<p>The testing plan are as follow :&nbsp;General NDT</p>\r\n', '0', 'QUO-VI-2018-00003', '2018-06-24', 2, 0, ''),
(266, 'Product', 'qfield_offerings', '1', 'QUO-VI-2018-00003', '2018-06-24', 0, 0, ''),
(267, 'Client_to_Provide_The_Following_Free_Of_Charge', '<p>Free and unrestricted access to work sites ,assistant crew here conditions render work able passage of personnel&nbsp;and equipment impossible</p>\r\n\r\n<p>Where required provision of shoring, staging, scaffolding, ladders, crane, lighting and removal of all debris and&nbsp;water from work areas,&nbsp;etc as necessary.</p>\r\n', '0', 'QUO-VI-2018-00003', '2018-06-24', 2, 0, ''),
(268, 'Payment', '<ul>\r\n	<li>Rates are exclude PPN &amp; VAT</li>\r\n	<li>All Rates quoted are&nbsp;in IDR</li>\r\n	<li>Invoices will be prepared based on approved timesheet which are required to be signed off daily by PT.PSI&nbsp;and&nbsp;approved&nbsp;client rep. Any discrepancies/alterations to be agreed and signed off prior to leaving site.</li>\r\n	<li>Payment terms strictly 30 days from invoice received</li>\r\n	<li>All terms and conditions of the subcontract to be agreed in&nbsp;writing at time of award of (sub) contract</li>\r\n</ul>\r\n', '0', 'QUO-VI-2018-00003', '2018-06-24', 2, 0, ''),
(269, 'Closing', '<p>We trust that this commercial proposal is acceptable and meets to your requirements. Please do not hesitate to contact the&nbsp;undersigned if&nbsp;you need&nbsp;any future clarification</p>\r\n\r\n<p>For&amp; on behalf of &nbsp;PT. Pesat Servis Industri</p>\r\n', '0', 'QUO-VI-2018-00003', '2018-06-24', 2, 0, ''),
(270, 'Writted_By', '', '0', 'QUO-VI-2018-00003', '2018-06-24', 1, 0, ''),
(271, 'Datetime', '2018-06-24 03:15:56', '0', 'QUO-VI-2018-00003', '2018-06-24', 5, 0, ''),
(272, 'customer_id', '3', '0', 'QUO-VI-2018-00004', '2018-06-24', 0, 0, ''),
(273, 'To', 'Customer', '0', 'QUO-VI-2018-00004', '2018-06-24', 1, 0, ''),
(274, 'Introduction', '<p>Quotation General NDT and optional rate&nbsp;for above mention we are project to&nbsp;submit&nbsp;the following</p>\r\n', '0', 'QUO-VI-2018-00004', '2018-06-24', 2, 0, ''),
(275, 'Workscope', '<p>The testing plan are as follow :&nbsp;General NDT</p>\r\n', '0', 'QUO-VI-2018-00004', '2018-06-24', 2, 0, ''),
(276, 'Product', 'qfield_offerings', '1', 'QUO-VI-2018-00004', '2018-06-24', 0, 0, ''),
(277, 'Client_to_Provide_The_Following_Free_Of_Charge', '<p>Free and unrestricted access to work sites ,assistant crew here conditions render work able passage of personnel&nbsp;and equipment impossible</p>\r\n\r\n<p>Where required provision of shoring, staging, scaffolding, ladders, crane, lighting and removal of all debris and&nbsp;water from work areas,&nbsp;etc as necessary.</p>\r\n', '0', 'QUO-VI-2018-00004', '2018-06-24', 2, 0, ''),
(278, 'Payment', '<ul>\r\n	<li>Rates are exclude PPN &amp; VAT</li>\r\n	<li>All Rates quoted are&nbsp;in IDR</li>\r\n	<li>Invoices will be prepared based on approved timesheet which are required to be signed off daily by PT.PSI&nbsp;and&nbsp;approved&nbsp;client rep. Any discrepancies/alterations to be agreed and signed off prior to leaving site.</li>\r\n	<li>Payment terms strictly 30 days from invoice received</li>\r\n	<li>All terms and conditions of the subcontract to be agreed in&nbsp;writing at time of award of (sub) contract</li>\r\n</ul>\r\n', '0', 'QUO-VI-2018-00004', '2018-06-24', 2, 0, ''),
(279, 'Closing', '<p>We trust that this commercial proposal is acceptable and meets to your requirements. Please do not hesitate to contact the&nbsp;undersigned if&nbsp;you need&nbsp;any future clarification</p>\r\n\r\n<p>For&amp; on behalf of &nbsp;PT. Pesat Servis Industri</p>\r\n', '0', 'QUO-VI-2018-00004', '2018-06-24', 2, 0, ''),
(280, 'Writted_By', '', '0', 'QUO-VI-2018-00004', '2018-06-24', 1, 0, ''),
(281, 'Datetime', '2018-06-24 03:15:56', '0', 'QUO-VI-2018-00004', '2018-06-24', 5, 0, ''),
(282, 'customer_id', '2', '0', 'QUO-VI-2018-00005', '2018-06-24', 0, 0, ''),
(283, 'To', 'Customer', '0', 'QUO-VI-2018-00005', '2018-06-24', 1, 0, ''),
(284, 'Introduction', '<p>Quotation General NDT and optional rate&nbsp;for above mention we are project to&nbsp;submit&nbsp;the following</p>\r\n', '0', 'QUO-VI-2018-00005', '2018-06-24', 2, 0, ''),
(285, 'Workscope', '<p>The testing plan are as follow :&nbsp;General NDT</p>\r\n', '0', 'QUO-VI-2018-00005', '2018-06-24', 2, 0, ''),
(286, 'Product', 'qfield_offerings', '1', 'QUO-VI-2018-00005', '2018-06-24', 0, 0, ''),
(287, 'Client_to_Provide_The_Following_Free_Of_Charge', '<p>Free and unrestricted access to work sites ,assistant crew here conditions render work able passage of personnel&nbsp;and equipment impossible</p>\r\n\r\n<p>Where required provision of shoring, staging, scaffolding, ladders, crane, lighting and removal of all debris and&nbsp;water from work areas,&nbsp;etc as necessary.</p>\r\n', '0', 'QUO-VI-2018-00005', '2018-06-24', 2, 0, ''),
(288, 'Payment', '<ul>\r\n	<li>Rates are exclude PPN &amp; VAT</li>\r\n	<li>All Rates quoted are&nbsp;in IDR</li>\r\n	<li>Invoices will be prepared based on approved timesheet which are required to be signed off daily by PT.PSI&nbsp;and&nbsp;approved&nbsp;client rep. Any discrepancies/alterations to be agreed and signed off prior to leaving site.</li>\r\n	<li>Payment terms strictly 30 days from invoice received</li>\r\n	<li>All terms and conditions of the subcontract to be agreed in&nbsp;writing at time of award of (sub) contract</li>\r\n</ul>\r\n', '0', 'QUO-VI-2018-00005', '2018-06-24', 2, 0, ''),
(289, 'Closing', '<p>We trust that this commercial proposal is acceptable and meets to your requirements. Please do not hesitate to contact the&nbsp;undersigned if&nbsp;you need&nbsp;any future clarification</p>\r\n\r\n<p>For&amp; on behalf of &nbsp;PT. Pesat Servis Industri</p>\r\n', '0', 'QUO-VI-2018-00005', '2018-06-24', 2, 0, ''),
(290, 'Writted_By', '', '0', 'QUO-VI-2018-00005', '2018-06-24', 1, 0, ''),
(291, 'Datetime', '2018-06-24 03:39:06', '0', 'QUO-VI-2018-00005', '2018-06-24', 5, 0, ''),
(292, 'customer_id', '3', '0', 'QUO-VI-2018-00006', '2018-06-24', 0, 0, ''),
(293, 'To', 'Customer', '0', 'QUO-VI-2018-00006', '2018-06-24', 1, 0, ''),
(294, 'Introduction', '<p>Quotation General NDT and optional rate&nbsp;for above mention we are project to&nbsp;submit&nbsp;the following</p>\r\n', '0', 'QUO-VI-2018-00006', '2018-06-24', 2, 0, ''),
(295, 'Workscope', '<p>The testing plan are as follow :&nbsp;General NDT</p>\r\n', '0', 'QUO-VI-2018-00006', '2018-06-24', 2, 0, ''),
(296, 'Product', 'qfield_offerings', '1', 'QUO-VI-2018-00006', '2018-06-24', 0, 0, ''),
(297, 'Client_to_Provide_The_Following_Free_Of_Charge', '<p>Free and unrestricted access to work sites ,assistant crew here conditions render work able passage of personnel&nbsp;and equipment impossible</p>\r\n\r\n<p>Where required provision of shoring, staging, scaffolding, ladders, crane, lighting and removal of all debris and&nbsp;water from work areas,&nbsp;etc as necessary.</p>\r\n', '0', 'QUO-VI-2018-00006', '2018-06-24', 2, 0, ''),
(298, 'Payment', '<ul>\r\n	<li>Rates are exclude PPN &amp; VAT</li>\r\n	<li>All Rates quoted are&nbsp;in IDR</li>\r\n	<li>Invoices will be prepared based on approved timesheet which are required to be signed off daily by PT.PSI&nbsp;and&nbsp;approved&nbsp;client rep. Any discrepancies/alterations to be agreed and signed off prior to leaving site.</li>\r\n	<li>Payment terms strictly 30 days from invoice received</li>\r\n	<li>All terms and conditions of the subcontract to be agreed in&nbsp;writing at time of award of (sub) contract</li>\r\n</ul>\r\n', '0', 'QUO-VI-2018-00006', '2018-06-24', 2, 0, ''),
(299, 'Closing', '<p>We trust that this commercial proposal is acceptable and meets to your requirements. Please do not hesitate to contact the&nbsp;undersigned if&nbsp;you need&nbsp;any future clarification</p>\r\n\r\n<p>For&amp; on behalf of &nbsp;PT. Pesat Servis Industri</p>\r\n', '0', 'QUO-VI-2018-00006', '2018-06-24', 2, 0, ''),
(300, 'Writted_By', '', '0', 'QUO-VI-2018-00006', '2018-06-24', 1, 0, ''),
(301, 'Datetime', '2018-06-24 03:39:06', '0', 'QUO-VI-2018-00006', '2018-06-24', 5, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `quotationd`
--

CREATE TABLE `quotationd` (
  `quotationd_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quotationd_price` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `quotationproduct`
--

CREATE TABLE `quotationproduct` (
  `quotationproduct_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quotationproduct_qty` int(11) NOT NULL,
  `quotationproduct_price` bigint(20) NOT NULL,
  `quotation_no` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quotationproduct`
--

INSERT INTO `quotationproduct` (`quotationproduct_id`, `product_id`, `quotationproduct_qty`, `quotationproduct_price`, `quotation_no`) VALUES
(1, 4, 1, -1, 'QUO-VI-2018-00005'),
(2, 4, 1, -1, 'QUO-VI-2018-00005'),
(3, 4, 1, -1, 'QUO-VI-2018-00005'),
(4, 4, 1, -1, 'QUO-VI-2018-00005'),
(5, 4, 1, -1, 'QUO-VI-2018-00005'),
(6, 4, 1, -1, 'QUO-VI-2018-00005'),
(7, 4, 1, -1, 'QUO-VI-2018-00005'),
(8, 4, 1, -1, 'QUO-VI-2018-00005'),
(9, 4, 1, -1, 'QUO-VI-2018-00005'),
(10, 4, 1, -1, 'QUO-VI-2018-00005'),
(11, 4, 1, -1, 'QUO-VI-2018-00006'),
(12, 4, 1, -1, 'QUO-VI-2018-00006'),
(13, 4, 1, -1, 'QUO-VI-2018-00006'),
(14, 4, 1, -1, 'QUO-VI-2018-00006'),
(15, 4, 1, -1, 'QUO-VI-2018-00006'),
(16, 4, 1, -1, 'QUO-VI-2018-00006'),
(17, 4, 1, -1, 'QUO-VI-2018-00006'),
(18, 4, 1, -1, 'QUO-VI-2018-00006'),
(19, 4, 1, -1, 'QUO-VI-2018-00006'),
(20, 4, 1, -1, 'QUO-VI-2018-00006');

-- --------------------------------------------------------

--
-- Table structure for table `saran`
--

CREATE TABLE `saran` (
  `saran_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `saran_content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `saran`
--

INSERT INTO `saran` (`saran_id`, `user_id`, `saran_content`) VALUES
(7, 0, '<p>Seharusnya pelayanannya di perbaiki.<img alt=\"surprise\" src=\"smiley/smiley8.gif\" style=\"height:20px; width:100px\" title=\"surprise\" /></p>\r\n\r\n<p>Dan customer harus diberi uang!&nbsp;<img alt=\"enlightened\" src=\"smiley/smiley15.gif\" style=\"height:19px; width:19px\" title=\"enlightened\" /></p>\r\n'),
(9, 8, '<p>Knapa saya g bisa ngutang di sini?&nbsp;<img alt=\"\" src=\"smiley/smiley33.gif\" style=\"height:18px; width:26px\" title=\"\" /></p>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `sjkeluar`
--

CREATE TABLE `sjkeluar` (
  `sjkeluar_id` int(11) NOT NULL,
  `sjkeluar_no` varchar(50) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `sjkeluar_pengirim` varchar(50) NOT NULL,
  `sjkeluar_penerima` varchar(50) NOT NULL,
  `sjkeluar_date` date NOT NULL,
  `sjkeluar_ekspedisi` varchar(50) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `sjkeluar_title` text NOT NULL,
  `sjkeluar_pemberitugas` varchar(255) NOT NULL,
  `sjkeluar_penerimatugas` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sjkeluar`
--

INSERT INTO `sjkeluar` (`sjkeluar_id`, `sjkeluar_no`, `customer_id`, `sjkeluar_pengirim`, `sjkeluar_penerima`, `sjkeluar_date`, `sjkeluar_ekspedisi`, `branch_id`, `sjkeluar_title`, `sjkeluar_pemberitugas`, `sjkeluar_penerimatugas`) VALUES
(1, 'SJK-VI-2018-00001', 1, 'Hasan', 'hanif', '2018-06-12', 'Truck', 1, 'Pengadaan Children Playground dan Outdoor', 'Hasan', 'Hanif');

-- --------------------------------------------------------

--
-- Table structure for table `sjkeluarproduct`
--

CREATE TABLE `sjkeluarproduct` (
  `sjkeluarproduct_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `sjkeluarproduct_qty` int(11) NOT NULL,
  `sjkeluar_no` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sjkeluarproduct`
--

INSERT INTO `sjkeluarproduct` (`sjkeluarproduct_id`, `product_id`, `sjkeluarproduct_qty`, `sjkeluar_no`) VALUES
(1, 2, 2, 'SJK-VI-2018-00001'),
(2, 15, 1, 'SJK-VI-2018-00001');

-- --------------------------------------------------------

--
-- Table structure for table `sjmasuk`
--

CREATE TABLE `sjmasuk` (
  `sjmasuk_id` int(11) NOT NULL,
  `sjmasuk_no` varchar(50) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `sjmasuk_pengirim` varchar(50) NOT NULL,
  `sjmasuk_penerima` varchar(50) NOT NULL,
  `sjmasuk_date` date NOT NULL,
  `sjmasuk_ekspedisi` varchar(50) NOT NULL,
  `sjmasuk_picture` text NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sjmasuk`
--

INSERT INTO `sjmasuk` (`sjmasuk_id`, `sjmasuk_no`, `supplier_id`, `sjmasuk_pengirim`, `sjmasuk_penerima`, `sjmasuk_date`, `sjmasuk_ekspedisi`, `sjmasuk_picture`, `branch_id`) VALUES
(2, 'asdf', 1, 'Ihsan', 'Hasan', '2018-06-10', 'Truk', '16_31_59_12438986_10205696301833904_5983593316926477933_n.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sjmasukproduct`
--

CREATE TABLE `sjmasukproduct` (
  `sjmasukproduct_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `sjmasukproduct_qty` int(11) NOT NULL,
  `sjmasuk_no` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `supplier_id` int(11) NOT NULL,
  `supplier_name` varchar(50) NOT NULL,
  `supplier_email` varchar(50) NOT NULL,
  `supplier_cp` varchar(50) NOT NULL,
  `supplier_address` text NOT NULL,
  `supplier_phone` varchar(15) NOT NULL,
  `supplier_fax` varchar(15) NOT NULL,
  `supplier_npwp` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`supplier_id`, `supplier_name`, `supplier_email`, `supplier_cp`, `supplier_address`, `supplier_phone`, `supplier_fax`, `supplier_npwp`) VALUES
(1, 'PT. Pratita Prama Nugraha', 'rahmat@pratita.com', '', 'Jl. Raya Dadap Ujung Laut Tangerang', '', '', ''),
(2, 'aa', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `supplierproduct`
--

CREATE TABLE `supplierproduct` (
  `supplierproduct_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `supplierproduct_price` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplierproduct`
--

INSERT INTO `supplierproduct` (`supplierproduct_id`, `supplier_id`, `product_id`, `supplierproduct_price`) VALUES
(1, 1, 1, 360000),
(2, 1, 2, 900000),
(3, 1, 9, 1000000),
(4, 2, 5, 2000000),
(5, 2, 1, 360000);

-- --------------------------------------------------------

--
-- Table structure for table `suratkeluar`
--

CREATE TABLE `suratkeluar` (
  `suratkeluar_id` int(11) NOT NULL,
  `suratkeluar_content` text NOT NULL,
  `suratkeluar_no` varchar(50) NOT NULL,
  `suratkeluar_date` date NOT NULL,
  `suratkeluar_title` text NOT NULL,
  `suratkeluar_remarks` text NOT NULL,
  `suratkeluar_user` varchar(50) NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `suratkeluar`
--

INSERT INTO `suratkeluar` (`suratkeluar_id`, `suratkeluar_content`, `suratkeluar_no`, `suratkeluar_date`, `suratkeluar_title`, `suratkeluar_remarks`, `suratkeluar_user`, `branch_id`) VALUES
(1, '<p>To : CNOOC SES</p>\r\n\r\n<p>Indonesian Stock Exchange Building Tower</p>\r\n\r\n<p>Jl.Jendral Sudirman Kav.52</p>\r\n\r\n<p>Jakarta 12190 Indonesia</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Attn : Tender Committee</p>\r\n\r\n<p>Subject : Supporting Letter for Tender</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Dear Sir,</p>\r\n\r\n<p>This to certify that if above subject is awarded to PT.Lekom Maras then PT.Pesat Servis Industri would like to give commitments support to PT.Lekom Maras for:</p>\r\n\r\n<p style=\"text-align:center\">&quot;LRUT Inspection for HIgh Risk Riser&quot;</p>\r\n\r\n<p style=\"text-align:justify\">The support is awarded to the subject above, Please do not hesitate to contact us if ypu have any question and need further information.</p>\r\n\r\n<p style=\"text-align:justify\">Acknowledge,</p>\r\n\r\n<p style=\"text-align:justify\"><strong>PT.Pesat Servis Industri</strong></p>\r\n\r\n<p style=\"text-align:justify\">&nbsp;</p>\r\n\r\n<p style=\"text-align:justify\">&nbsp;</p>\r\n\r\n<p style=\"text-align:justify\"><u>Achmad Munir</u></p>\r\n\r\n<p style=\"text-align:justify\">Director</p>\r\n', 'PSI-ADM-SK-X-2017-001', '2017-10-13', 'Surat Pengantar Retest OR', 'Soft (17/07/2017)', 'Zahro', 1),
(2, '<p>Pengambilan CO2 dan H2SO4</p>\r\n', 'QTHXII-2017-002', '2017-12-08', 'Surat Tugas Pengambilan Barang', 'Mohon diambil segera', 'Hasan', 1),
(3, '<p>Mohon dibantu untuk pengambilan barang oleh karyawan saya</p>\r\n', 'SK-II-2018-003', '2018-02-13', 'Surat Pengambilan Barang', 'Izin Pengambilan Barang', 'Ihsan', 1);

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `task_no` varchar(50) NOT NULL,
  `task_date` date NOT NULL,
  `inv_no` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`task_id`, `user_id`, `customer_id`, `task_no`, `task_date`, `inv_no`) VALUES
(2, 2, 1, 'ASG-V-2018-001', '2018-05-21', 'INV-V-2018-006');

-- --------------------------------------------------------

--
-- Table structure for table `taskproduct`
--

CREATE TABLE `taskproduct` (
  `taskproduct_id` int(11) NOT NULL,
  `taskproduct_qty` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `task_no` varchar(50) NOT NULL,
  `taskproduct_picture` text NOT NULL,
  `taskproduct_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `taskproduct`
--

INSERT INTO `taskproduct` (`taskproduct_id`, `taskproduct_qty`, `product_id`, `task_no`, `taskproduct_picture`, `taskproduct_date`) VALUES
(1, 0, 15, 'ASG-V-2018-001', '', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `unit_id` int(11) NOT NULL,
  `unit_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`unit_id`, `unit_name`) VALUES
(1, 'Cm'),
(2, 'M'),
(3, 'Pcs'),
(4, 'Gr'),
(5, 'Kg'),
(6, 'Liter'),
(7, 'Unit'),
(8, 'Node');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_password` varchar(50) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `position_id` int(11) NOT NULL,
  `user_picture` text NOT NULL,
  `branch_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_password`, `user_email`, `position_id`, `user_picture`, `branch_id`, `customer_id`) VALUES
(1, 'Admin', 'password', 'admin@mail.com', 1, '13_23_42_Chrysanthemum.jpg', 1, 0),
(2, 'Amir', 'password', 'teknisi@mail.com', 2, '13_31_25_Koala.jpg', 1, 0),
(3, 'Zahro', 'password', 'zahro@mail.com', 3, '', 1, 0),
(4, 'Riban', 'password', 'riban@mail.com', 4, '', 1, 0),
(5, 'Dwi', 'password', 'dwi@mail.com', 5, '', 1, 0),
(8, 'adin', 'password', 'adin@mail.com', 6, '21_16_54_205424_1659763181033_92516_n.jpg', 0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `wo`
--

CREATE TABLE `wo` (
  `wo_id` int(11) NOT NULL,
  `wo_picture` text NOT NULL,
  `wo_remarks` text NOT NULL,
  `wo_no` varchar(255) NOT NULL,
  `wo_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bap`
--
ALTER TABLE `bap`
  ADD PRIMARY KEY (`bap_id`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`branch_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `customerproduct`
--
ALTER TABLE `customerproduct`
  ADD PRIMARY KEY (`customerproduct_id`);

--
-- Indexes for table `element`
--
ALTER TABLE `element`
  ADD PRIMARY KEY (`element_id`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`faq_id`);

--
-- Indexes for table `gaji`
--
ALTER TABLE `gaji`
  ADD PRIMARY KEY (`gaji_id`);

--
-- Indexes for table `grup`
--
ALTER TABLE `grup`
  ADD PRIMARY KEY (`grup_id`);

--
-- Indexes for table `grupd`
--
ALTER TABLE `grupd`
  ADD PRIMARY KEY (`grupd_id`);

--
-- Indexes for table `gudang`
--
ALTER TABLE `gudang`
  ADD PRIMARY KEY (`gudang_id`);

--
-- Indexes for table `identity`
--
ALTER TABLE `identity`
  ADD PRIMARY KEY (`identity_id`);

--
-- Indexes for table `inv`
--
ALTER TABLE `inv`
  ADD PRIMARY KEY (`inv_id`);

--
-- Indexes for table `invfield`
--
ALTER TABLE `invfield`
  ADD PRIMARY KEY (`invfield_id`);

--
-- Indexes for table `invpayment`
--
ALTER TABLE `invpayment`
  ADD PRIMARY KEY (`invpayment_id`);

--
-- Indexes for table `invpaymentproduct`
--
ALTER TABLE `invpaymentproduct`
  ADD PRIMARY KEY (`invpaymentproduct_id`);

--
-- Indexes for table `invproduct`
--
ALTER TABLE `invproduct`
  ADD PRIMARY KEY (`invproduct_id`);

--
-- Indexes for table `invs`
--
ALTER TABLE `invs`
  ADD PRIMARY KEY (`invs_id`);

--
-- Indexes for table `invspayment`
--
ALTER TABLE `invspayment`
  ADD PRIMARY KEY (`invspayment_id`);

--
-- Indexes for table `invspaymentproduct`
--
ALTER TABLE `invspaymentproduct`
  ADD PRIMARY KEY (`invspaymentproduct_id`);

--
-- Indexes for table `invsproduct`
--
ALTER TABLE `invsproduct`
  ADD PRIMARY KEY (`invsproduct_id`);

--
-- Indexes for table `kas`
--
ALTER TABLE `kas`
  ADD PRIMARY KEY (`kas_id`);

--
-- Indexes for table `kasd`
--
ALTER TABLE `kasd`
  ADD PRIMARY KEY (`kasd_id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `menu_sub`
--
ALTER TABLE `menu_sub`
  ADD PRIMARY KEY (`menu_sub_id`);

--
-- Indexes for table `menu_sub_sub`
--
ALTER TABLE `menu_sub_sub`
  ADD PRIMARY KEY (`menu_sub_sub_id`);

--
-- Indexes for table `methodpayment`
--
ALTER TABLE `methodpayment`
  ADD PRIMARY KEY (`methodpayment_id`);

--
-- Indexes for table `nomor`
--
ALTER TABLE `nomor`
  ADD PRIMARY KEY (`nomor_id`);

--
-- Indexes for table `permintaan`
--
ALTER TABLE `permintaan`
  ADD PRIMARY KEY (`permintaan_id`);

--
-- Indexes for table `permintaanproduct`
--
ALTER TABLE `permintaanproduct`
  ADD PRIMARY KEY (`permintaanproduct_id`);

--
-- Indexes for table `petty`
--
ALTER TABLE `petty`
  ADD PRIMARY KEY (`petty_id`);

--
-- Indexes for table `po`
--
ALTER TABLE `po`
  ADD PRIMARY KEY (`po_id`);

--
-- Indexes for table `poc`
--
ALTER TABLE `poc`
  ADD PRIMARY KEY (`poc_id`);

--
-- Indexes for table `pocproduct`
--
ALTER TABLE `pocproduct`
  ADD PRIMARY KEY (`pocproduct_id`);

--
-- Indexes for table `pofield`
--
ALTER TABLE `pofield`
  ADD PRIMARY KEY (`pofield_id`);

--
-- Indexes for table `poproduct`
--
ALTER TABLE `poproduct`
  ADD PRIMARY KEY (`poproduct_id`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`position_id`);

--
-- Indexes for table `position_menu`
--
ALTER TABLE `position_menu`
  ADD PRIMARY KEY (`position_menu_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `qfield`
--
ALTER TABLE `qfield`
  ADD PRIMARY KEY (`qfield_id`);

--
-- Indexes for table `qpicture`
--
ALTER TABLE `qpicture`
  ADD PRIMARY KEY (`qpicture_id`);

--
-- Indexes for table `quotation`
--
ALTER TABLE `quotation`
  ADD PRIMARY KEY (`quotation_id`);

--
-- Indexes for table `quotationd`
--
ALTER TABLE `quotationd`
  ADD PRIMARY KEY (`quotationd_id`);

--
-- Indexes for table `quotationproduct`
--
ALTER TABLE `quotationproduct`
  ADD PRIMARY KEY (`quotationproduct_id`);

--
-- Indexes for table `saran`
--
ALTER TABLE `saran`
  ADD PRIMARY KEY (`saran_id`);

--
-- Indexes for table `sjkeluar`
--
ALTER TABLE `sjkeluar`
  ADD PRIMARY KEY (`sjkeluar_id`);

--
-- Indexes for table `sjkeluarproduct`
--
ALTER TABLE `sjkeluarproduct`
  ADD PRIMARY KEY (`sjkeluarproduct_id`);

--
-- Indexes for table `sjmasuk`
--
ALTER TABLE `sjmasuk`
  ADD PRIMARY KEY (`sjmasuk_id`);

--
-- Indexes for table `sjmasukproduct`
--
ALTER TABLE `sjmasukproduct`
  ADD PRIMARY KEY (`sjmasukproduct_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `supplierproduct`
--
ALTER TABLE `supplierproduct`
  ADD PRIMARY KEY (`supplierproduct_id`);

--
-- Indexes for table `suratkeluar`
--
ALTER TABLE `suratkeluar`
  ADD PRIMARY KEY (`suratkeluar_id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`task_id`);

--
-- Indexes for table `taskproduct`
--
ALTER TABLE `taskproduct`
  ADD PRIMARY KEY (`taskproduct_id`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`unit_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `wo`
--
ALTER TABLE `wo`
  ADD PRIMARY KEY (`wo_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bap`
--
ALTER TABLE `bap`
  MODIFY `bap_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `branch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `customerproduct`
--
ALTER TABLE `customerproduct`
  MODIFY `customerproduct_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `element`
--
ALTER TABLE `element`
  MODIFY `element_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `faq_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `gaji`
--
ALTER TABLE `gaji`
  MODIFY `gaji_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `grup`
--
ALTER TABLE `grup`
  MODIFY `grup_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `grupd`
--
ALTER TABLE `grupd`
  MODIFY `grupd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `gudang`
--
ALTER TABLE `gudang`
  MODIFY `gudang_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT for table `identity`
--
ALTER TABLE `identity`
  MODIFY `identity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `inv`
--
ALTER TABLE `inv`
  MODIFY `inv_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=303;
--
-- AUTO_INCREMENT for table `invfield`
--
ALTER TABLE `invfield`
  MODIFY `invfield_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `invpayment`
--
ALTER TABLE `invpayment`
  MODIFY `invpayment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `invpaymentproduct`
--
ALTER TABLE `invpaymentproduct`
  MODIFY `invpaymentproduct_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `invproduct`
--
ALTER TABLE `invproduct`
  MODIFY `invproduct_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT for table `invs`
--
ALTER TABLE `invs`
  MODIFY `invs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `invspayment`
--
ALTER TABLE `invspayment`
  MODIFY `invspayment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `invspaymentproduct`
--
ALTER TABLE `invspaymentproduct`
  MODIFY `invspaymentproduct_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `invsproduct`
--
ALTER TABLE `invsproduct`
  MODIFY `invsproduct_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `kas`
--
ALTER TABLE `kas`
  MODIFY `kas_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `kasd`
--
ALTER TABLE `kasd`
  MODIFY `kasd_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `menu_sub`
--
ALTER TABLE `menu_sub`
  MODIFY `menu_sub_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT for table `menu_sub_sub`
--
ALTER TABLE `menu_sub_sub`
  MODIFY `menu_sub_sub_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `methodpayment`
--
ALTER TABLE `methodpayment`
  MODIFY `methodpayment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `nomor`
--
ALTER TABLE `nomor`
  MODIFY `nomor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `permintaan`
--
ALTER TABLE `permintaan`
  MODIFY `permintaan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `permintaanproduct`
--
ALTER TABLE `permintaanproduct`
  MODIFY `permintaanproduct_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `petty`
--
ALTER TABLE `petty`
  MODIFY `petty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `po`
--
ALTER TABLE `po`
  MODIFY `po_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `poc`
--
ALTER TABLE `poc`
  MODIFY `poc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `pocproduct`
--
ALTER TABLE `pocproduct`
  MODIFY `pocproduct_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `pofield`
--
ALTER TABLE `pofield`
  MODIFY `pofield_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `poproduct`
--
ALTER TABLE `poproduct`
  MODIFY `poproduct_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `position_menu`
--
ALTER TABLE `position_menu`
  MODIFY `position_menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=175;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `qfield`
--
ALTER TABLE `qfield`
  MODIFY `qfield_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `qpicture`
--
ALTER TABLE `qpicture`
  MODIFY `qpicture_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `quotation`
--
ALTER TABLE `quotation`
  MODIFY `quotation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=302;
--
-- AUTO_INCREMENT for table `quotationd`
--
ALTER TABLE `quotationd`
  MODIFY `quotationd_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `quotationproduct`
--
ALTER TABLE `quotationproduct`
  MODIFY `quotationproduct_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `saran`
--
ALTER TABLE `saran`
  MODIFY `saran_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `sjkeluar`
--
ALTER TABLE `sjkeluar`
  MODIFY `sjkeluar_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `sjkeluarproduct`
--
ALTER TABLE `sjkeluarproduct`
  MODIFY `sjkeluarproduct_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `sjmasuk`
--
ALTER TABLE `sjmasuk`
  MODIFY `sjmasuk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `sjmasukproduct`
--
ALTER TABLE `sjmasukproduct`
  MODIFY `sjmasukproduct_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `supplierproduct`
--
ALTER TABLE `supplierproduct`
  MODIFY `supplierproduct_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `suratkeluar`
--
ALTER TABLE `suratkeluar`
  MODIFY `suratkeluar_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `taskproduct`
--
ALTER TABLE `taskproduct`
  MODIFY `taskproduct_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `unit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `wo`
--
ALTER TABLE `wo`
  MODIFY `wo_id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

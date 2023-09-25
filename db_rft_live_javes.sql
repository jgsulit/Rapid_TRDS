-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 25, 2023 at 11:21 AM
-- Server version: 5.5.32
-- PHP Version: 5.3.10-1ubuntu3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_rft_live_javes`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_access`
--

CREATE TABLE IF NOT EXISTS `tbl_access` (
  `pkid_access` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email_add` varchar(50) NOT NULL,
  `welcome` varchar(50) NOT NULL,
  `request` varchar(50) NOT NULL,
  `conformance` varchar(50) NOT NULL,
  `receiving` varchar(50) NOT NULL,
  `approval` varchar(50) NOT NULL,
  `special` varchar(5) NOT NULL,
  PRIMARY KEY (`pkid_access`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=214 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_email_receive_module`
--

CREATE TABLE IF NOT EXISTS `tbl_email_receive_module` (
  `pkid_email_receive` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `log_del` int(11) NOT NULL,
  PRIMARY KEY (`pkid_email_receive`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_logs`
--

CREATE TABLE IF NOT EXISTS `tbl_logs` (
  `type_of_query` varchar(100) NOT NULL,
  `query` int(200) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`type_of_query`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_request`
--

CREATE TABLE IF NOT EXISTS `tbl_request` (
  `pkid_request` int(11) NOT NULL AUTO_INCREMENT,
  `ctrlno_counter` int(11) NOT NULL,
  `control_no` varchar(50) NOT NULL,
  `dept` varchar(20) NOT NULL,
  `sec` varchar(20) NOT NULL,
  `rft` varchar(200) NOT NULL,
  `job_func` varchar(20) NOT NULL,
  `al_alloc` varchar(20) NOT NULL,
  `date_filed` date NOT NULL,
  `requested_by` varchar(100) NOT NULL,
  `conformed_by` varchar(100) NOT NULL,
  `conf_status` int(11) NOT NULL COMMENT '1 = OK; 0 = Not OK; 2 = pending',
  `conf_remarks` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `received_by` varchar(100) NOT NULL,
  `rec_status` int(11) NOT NULL COMMENT '1 = OK; 0 = Not OK; 2 = pending',
  `rec_remarks` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `approved_by` varchar(100) NOT NULL,
  `app_status` int(11) NOT NULL COMMENT '1 = OK; 0 = Not OK; 2 = pending',
  `app_remarks` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `overallStatus` int(11) NOT NULL COMMENT '1 = OK; 0 = Not OK',
  `remarks` text NOT NULL,
  `log_del` int(11) NOT NULL COMMENT '1 = Cancelled; 0 = Active',
  PRIMARY KEY (`pkid_request`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1845 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_trainees`
--

CREATE TABLE IF NOT EXISTS `tbl_trainees` (
  `pkid_trainees` int(11) NOT NULL AUTO_INCREMENT,
  `fkid_pkid_request` int(11) NOT NULL,
  `emp_no` varchar(50) NOT NULL,
  `emp_name` varchar(100) NOT NULL,
  `from_station` varchar(50) NOT NULL,
  `from_line` text NOT NULL,
  `to_station` text NOT NULL,
  `to_line` text NOT NULL,
  `date_hired` int(11) NOT NULL,
  `log_del` int(11) NOT NULL,
  PRIMARY KEY (`pkid_trainees`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11275 ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_list_of_trainees`
--
CREATE TABLE IF NOT EXISTS `vw_list_of_trainees` (
`traineeNo` int(11)
,`emp_no` varchar(50)
,`emp_name` varchar(100)
,`date_hired` int(11)
,`control_no` varchar(50)
,`date_filed` date
,`requested_by` varchar(100)
,`requestNo` int(11)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_list_of_trainees_old`
--
CREATE TABLE IF NOT EXISTS `vw_list_of_trainees_old` (
`traineeNo` int(11)
,`emp_no` varchar(50)
,`emp_name` varchar(100)
,`date_hired` int(11)
,`control_no` varchar(50)
,`date_filed` date
,`requested_by` varchar(100)
,`requestNo` int(11)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_requests`
--
CREATE TABLE IF NOT EXISTS `vw_requests` (
`pkid_request` int(11)
,`control_no` varchar(50)
,`date_filed` date
,`emp_no` varchar(50)
,`emp_name` varchar(100)
,`from_station` varchar(50)
,`from_line` text
,`to_station` text
,`to_line` text
,`date_hired` int(11)
,`requested_by` varchar(100)
);
-- --------------------------------------------------------

--
-- Structure for view `vw_list_of_trainees`
--
DROP TABLE IF EXISTS `vw_list_of_trainees`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_list_of_trainees` AS select `b`.`pkid_trainees` AS `traineeNo`,`b`.`emp_no` AS `emp_no`,`b`.`emp_name` AS `emp_name`,`b`.`date_hired` AS `date_hired`,`a`.`control_no` AS `control_no`,`a`.`date_filed` AS `date_filed`,`a`.`requested_by` AS `requested_by`,`a`.`pkid_request` AS `requestNo` from (`tbl_request` `a` join `tbl_trainees` `b` on((`a`.`pkid_request` = `b`.`fkid_pkid_request`))) where ((`a`.`log_del` = '0') and (`b`.`log_del` = '0'));

-- --------------------------------------------------------

--
-- Structure for view `vw_list_of_trainees_old`
--
DROP TABLE IF EXISTS `vw_list_of_trainees_old`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_list_of_trainees_old` AS select `b`.`pkid_trainees` AS `traineeNo`,`b`.`emp_no` AS `emp_no`,`b`.`emp_name` AS `emp_name`,`b`.`date_hired` AS `date_hired`,`a`.`control_no` AS `control_no`,`a`.`date_filed` AS `date_filed`,`a`.`requested_by` AS `requested_by`,`a`.`pkid_request` AS `requestNo` from (`tbl_request` `a` join `tbl_trainees` `b` on((`a`.`pkid_request` = `b`.`fkid_pkid_request`))) where (`a`.`overallStatus` = '1');

-- --------------------------------------------------------

--
-- Structure for view `vw_requests`
--
DROP TABLE IF EXISTS `vw_requests`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_requests` AS select `a`.`pkid_request` AS `pkid_request`,`a`.`control_no` AS `control_no`,`a`.`date_filed` AS `date_filed`,`b`.`emp_no` AS `emp_no`,`b`.`emp_name` AS `emp_name`,`b`.`from_station` AS `from_station`,`b`.`from_line` AS `from_line`,`b`.`to_station` AS `to_station`,`b`.`to_line` AS `to_line`,`b`.`date_hired` AS `date_hired`,`a`.`requested_by` AS `requested_by` from (`tbl_request` `a` join `tbl_trainees` `b` on((`a`.`pkid_request` = `b`.`fkid_pkid_request`)));

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

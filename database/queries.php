--
-- Table structure for table `crm_google_form_list`
--

CREATE TABLE `crm_google_form_list` (
`id` int(11) NOT NULL,
`name` varchar(100) NOT NULL,
`url` varchar(256) NOT NULL,
`sms_content` varchar(256) NOT NULL,
`active` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `crm_google_form_list`
--

INSERT INTO `crm_google_form_list` (`id`, `name`, `url`, `sms_content`, `active`) VALUES
(1, 'Account Change', '', '', 1),
(2, 'Payment Issue', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `crm_queries`
--

CREATE TABLE `crm_queries` (
`id` int(11) NOT NULL,
`user_id` int(11) NOT NULL,
`name` varchar(100) NOT NULL,
`phone` varchar(12) NOT NULL,
`merchant_id` int(11) NOT NULL DEFAULT '0',
`category_id` int(11) NOT NULL,
`sub_category_id` int(11) NOT NULL,
`issue_date_from` date DEFAULT NULL,
`issue_date_to` date DEFAULT NULL,
`utr_upi` varchar(30) NOT NULL,
`send_sms` tinyint(4) NOT NULL DEFAULT '0',
`google_form_id` smallint(6) NOT NULL,
`is_callback_issue_resolved` tinyint(4) DEFAULT '0',
`callback_issue_resolved_date` datetime DEFAULT NULL,
`mark_callback` tinyint(4) NOT NULL DEFAULT '0',
`payement_team` smallint(6) NOT NULL DEFAULT '0',
`backend_team` tinyint(4) NOT NULL DEFAULT '0',
`description_form` text NOT NULL,
`created_at` datetime NOT NULL,
`updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `crm_rc_status`
--

CREATE TABLE `crm_rc_status` (
`id` int(11) NOT NULL,
`status_id` int(11) NOT NULL,
`status_name` varchar(20) NOT NULL,
`sub_status_name` varchar(100) NOT NULL,
`description` text NOT NULL,
`active` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `crm_rc_status`
--

INSERT INTO `crm_rc_status` (`id`, `status_id`, `status_name`, `sub_status_name`, `description`, `active`) VALUES
(1, 2, 'Complaint', 'Payment Pending Issue', 'This issue happened because UPI server was down. Your payment will be settle in your account within 24 hours.', 1),
(2, 2, 'Complaint', 'Payment pending follow up', 'Please check your bank statement and if your amount is not credited let us know', 1),
(3, 2, 'Complaint', 'Payment Pending Issue In Daily Settlement', 'Your payment will be credited in your account tonight 1 am', 1),
(4, 2, 'Complaint', 'Payment Pending TAT Time Exceeded', 'Suggested to share your transaction history screenshot & registered mobile number to Support@bharatpe.com', 1),
(5, 2, 'Complaint', 'Agent Fraud', 'Suggested to share your transaction history screenshot & registered mobile number to Support@bharatpe.com', 1),
(6, 2, 'Complaint', 'Fraud Transaction', 'Information Provided  That we will escalate the case to the concern department and you will get a call from them', 1),
(7, 1, 'Query', 'QR Code Status', 'Checked & information Provided', 1),
(8, 1, 'Query', 'Wants To Know About the App Features', 'No charges, instant settlement, No KYC, No Limit', 1),
(9, 1, 'Query', 'Need a Agent', 'Requested to share the Required details to support Mail ID, All Details Shared', 1),
(10, 1, 'Query', 'Wallet Issue', 'Information Provided that to receive payment through UPI Only, Wallet payment is not accepted in BharatPe', 1),
(11, 1, 'Query', 'Not Showing Business name in customers Mobile', 'Please cross check the last six digit Number which is your Unique number which is printed on QR code stickers Also', 1),
(12, 1, 'Query', 'Wants To change the Bank details', 'Requested to share the Required details to support Mail ID, All Details Shared', 1),
(13, 1, 'Query', 'Cashback', 'Information provided after confirming the On boarded merchant as of now cashback is stopped', 1),
(14, 1, 'Query', 'Wants to know how to deactivate Bharatpe account', 'Information provided that please logout from the application it will be deleted soon', 1),
(15, 1, 'Query', 'Wants to know paytm', 'Infomation provided that please contacts paytm customer care number', 1),
(16, 1, 'Query', 'Wants  to deactivate bharatpe account', 'Please logout from the application ,It will be deleted after 15 days', 1),
(17, 1, 'Query', 'Wants to know about ios application', 'Information provided that  ios application is under development ,it will be launched soon', 1),
(18, 1, 'Query', 'Wants to know there UPI Id', 'Wants to know there UPI IdWants to know there UPI Id', 1),
(19, 1, 'Query', 'Wants to download bharatpe app', 'Information provided that download from playstore', 1),
(20, 1, 'Query', 'Payment Pending Issue In Daily Settlement', 'Your payment will be credited in your account tonight 1 am', 1),
(21, 1, 'Query', 'Others', 'Others', 1),
(22, 1, 'Query', 'Qr code not dilivered', 'Suggested Merchant to track with consignment number which is sent by DTDC', 1),
(23, 1, 'Query', 'QR Code Not Working', 'Suggested to receive UPI Payments', 1),
(24, 1, 'Query', 'Wants to know about the payment link', 'Information provided that our payment link option is not available ', 1),
(25, 1, 'Query', 'QR Code Not Scanning', 'We regret that you had to go through this, yesterday there was a some issues in UPI servers.We would like to inform you that now all issues are resolved. ', 1),
(26, 1, 'Query', 'Wants to know about the payment Status', 'Issue Resolved On Call', 1),
(27, 1, 'Query', 'Wants To know settlement type', 'Information Provided ', 1);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
`id` int(10) UNSIGNED NOT NULL,
`migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
`batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2017_08_21_075229_create_password_resets_table', 1),
(2, '2017_08_21_075329_create_users_table', 1),
(3, '2017_08_21_075429_create_config_table', 1),
(4, '2017_08_21_075605_create_tasks_table', 1),
(5, '2017_08_24_053036_create_profiles_table', 1),
(6, '2017_08_27_104452_create_todos_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `outbound_dial`
--

CREATE TABLE `outbound_dial` (
`id` int(11) NOT NULL,
`user_id` int(11) NOT NULL,
`phone` bigint(20) NOT NULL,
`problem_id` int(11) NOT NULL,
`satisfied` int(11) NOT NULL DEFAULT '0',
`ready` int(11) NOT NULL DEFAULT '0',
`contactable` int(11) NOT NULL DEFAULT '0',
`remarks` text NOT NULL,
`created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
`updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Indexes for table `crm_google_form_list`
--
ALTER TABLE `crm_google_form_list`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crm_queries`
--
ALTER TABLE `crm_queries`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crm_rc_status`
--
ALTER TABLE `crm_rc_status`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `outbound_dial`
--
ALTER TABLE `outbound_dial`
ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for table `crm_google_form_list`
--
ALTER TABLE `crm_google_form_list`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `crm_queries`
--
ALTER TABLE `crm_queries`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `crm_rc_status`
--
ALTER TABLE `crm_rc_status`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `outbound_dial`
--
ALTER TABLE `outbound_dial`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;


ALTER TABLE `admin_users`
ADD `name` VARCHAR(100) NOT NULL AFTER `status`,
ADD `email` VARCHAR(255) NOT NULL AFTER `name`,
ADD `password` VARCHAR(255) NOT NULL AFTER `email`,
ADD `activation_token` VARCHAR(64) NOT NULL AFTER `password`,
ADD `remember_token` VARCHAR(100) NOT NULL AFTER `activation_token`,
ADD `updated_at` TIMESTAMP NOT NULL AFTER `remember_token`;


INSERT INTO `admin_users` (`id`, `username`, `phone_number`, `City`, `role_type`, `status`, `name`, `email`, `password`, `activation_token`, `remember_token`, `updated_at`, `created_at`) VALUES ('0', NULL, NULL, NULL, '0', 'activated', 'Rahul Agarwal', 'executive@bharatpe.com', '$2y$10$LSu9cmh0BhHW1EvsI/4eFOZzMKXZ18Me1gbtIF28mtBf/udxrUXjG', '8548185f-fb1b-486f-a9c3-508f90d8c020', '', '2019-02-27 00:00:00', CURRENT_TIMESTAMP);





-----28 feb 2019----
rename outbound_dial to crm_outbound_dial;

INSERT INTO `crm_google_form_list` (`id`, `name`, `url`, `sms_content`, `active`) VALUES (NULL, 'Need an agent', '', '', '1');

-----28 feb 2019----



INSERT INTO `admin_users`
(`id`, `username`, `phone_number`, `City`, `role_type`, `status`, `name`, `email`, `password`, `activation_token`, `remember_token`, `updated_at`, `created_at`) VALUES

(NULL, NULL, '8447681931', NULL, '0', 'activated', 'Laxmi', 'laxmichaudharymagic@gmail.com', '$2y$10$LSu9cmh0BhHW1EvsI/4eFOZzMKXZ18Me1gbtIF28mtBf/udxrUXjG', '8548185f-fb1b-486f-a9c3-508f90d8c020', '', '2019-02-27 00:00:00', CURRENT_TIMESTAMP),
(NULL, NULL, '8368358669', NULL, '0', 'activated', 'Rajiv', 'rajivjakhad81@gmail.com', '$2y$10$LSu9cmh0BhHW1EvsI/4eFOZzMKXZ18Me1gbtIF28mtBf/udxrUXjG', '8548185f-fb1b-486f-a9c3-508f90d8c020', '', '2019-02-27 00:00:00', CURRENT_TIMESTAMP),
(NULL, NULL, '9910871207', NULL, '0', 'activated', 'Sagar', 'sagarchamp1031@gmail.com', '$2y$10$LSu9cmh0BhHW1EvsI/4eFOZzMKXZ18Me1gbtIF28mtBf/udxrUXjG', '8548185f-fb1b-486f-a9c3-508f90d8c020', '', '2019-02-27 00:00:00', CURRENT_TIMESTAMP),
(NULL, NULL, '8375994878', NULL, '0', 'activated', 'Vineet', 'vineetsingh3215@gmail.com', '$2y$10$LSu9cmh0BhHW1EvsI/4eFOZzMKXZ18Me1gbtIF28mtBf/udxrUXjG', '8548185f-fb1b-486f-a9c3-508f90d8c020', '', '2019-02-27 00:00:00', CURRENT_TIMESTAMP),
(NULL, NULL, '9650747558', NULL, '0', 'activated', 'Monu', 'monu007gautam@gmail.com', '$2y$10$LSu9cmh0BhHW1EvsI/4eFOZzMKXZ18Me1gbtIF28mtBf/udxrUXjG', '8548185f-fb1b-486f-a9c3-508f90d8c020', '', '2019-02-27 00:00:00', CURRENT_TIMESTAMP),
(NULL, NULL, '8368935099', NULL, '0', 'activated', 'Gulshan', 'gulshan02220@gmail.com', '$2y$10$LSu9cmh0BhHW1EvsI/4eFOZzMKXZ18Me1gbtIF28mtBf/udxrUXjG', '8548185f-fb1b-486f-a9c3-508f90d8c020', '', '2019-02-27 00:00:00', CURRENT_TIMESTAMP);

INSERT INTO `crm_rc_status` (`id`, `status_id`, `status_name`, `sub_status_name`, `description`, `active`) VALUES (NULL, '1', 'Query', 'Wants To know about the Loan', 'Wants To know about the Loan/ All information As per FAQs', '1');

----- 02 mar - 2019
ALTER TABLE `admin_users` CHANGE `role_type` `role_type` INT(11) NULL DEFAULT '0' COMMENT '0->superAdmin/CountryHead,1->City,2->ASM,3->executive,4->admin support';
update admin_users set status=1,role_type=3 where email !='';


------- 7 mar 2019---

ALTER TABLE `crm_bank_account_changes`
CHANGE `old_acc_passbook` `old_acc_cheque` VARCHAR(255) NOT NULL;
ALTER TABLE `crm_bank_account_changes`
ADD `old_acc_typeofid` VARCHAR(50) NOT NULL AFTER `old_acc_cheque`,
ADD `old_acc_idproof` VARCHAR(100) NOT NULL AFTER `old_acc_typeofid`,
ADD `terms_condition` VARCHAR(5) NOT NULL AFTER `old_acc_idproof`;

ALTER TABLE `crm_visitagents` ADD `terms_condition` VARCHAR(5) NOT NULL;
ALTER TABLE `crm_payment_pending_issues` ADD `terms_condition` VARCHAR(5) NOT NULL;
ALTER TABLE `crm_payment_pending_issues`
CHANGE `remark` `remark` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
## sudo yum install php-gd
## sudo yum install php-zip
## echo "extension=zip.so" >> /etc/php.d/zip.ini
## restart apache server
# composer update

------- 7 mar 2019 -----
------8 mar 2019-------
ALTER TABLE crm_payment_pending_issues ADD date_of_transaction DATE NOT NULL AFTER txn_history;


---------09 march 2019--------
CREATE TABLE `crm_role` (
  `id` int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `role_name` varchar(50) NOT NULL,
  `active` tinyint(1) NOT NULL
);

CREATE TABLE `crm_pages` (
  `id` int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `page_name` varchar(50) NOT NULL,
  `url` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL
);


CREATE TABLE `crm_role_permission` (
  `id` int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `role_id` int(2) NOT NULL,
  `page_id` int(3) NOT NULL
);


------- 11 march 2019 --------
ALTER TABLE crm_visitagents ADD is_issue_resolved TINYINT(1) zerofill NOT NULL AFTER city;
ALTER TABLE crm_payment_pending_issues ADD is_issue_resolved TINYINT(1) zerofill NOT NULL AFTER passbook;
ALTER TABLE crm_bank_account_changes ADD is_issue_resolved TINYINT(1) zerofill NOT NULL AFTER reason;
ALTER TABLE crm_merchant_revisits ADD is_issue_resolved TINYINT(1) zerofill NOT NULL AFTER scan_qr;

----- 11 mar 2019----
ALTER TABLE `crm_queries` ADD `is_time_out` INT NOT NULL AFTER `utr_upi`;

----------------------------------

CREATE TABLE `fos_merchant_status` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`merchant_id` int(11) NOT NULL,
`reason` varchar(50) NOT NULL,
`comment` text NOT NULL,
`created_at` datetime NOT NULL,
`updated_at` datetime NOT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `merchant_id` (`merchant_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
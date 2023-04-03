SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `civicrm_action_log_preview`;


--
-- Table structure for table `civicrm_action_log_preview`
--

CREATE TABLE `civicrm_action_log_preview` (
  `id` int UNSIGNED NOT NULL,
  `contact_id` int UNSIGNED DEFAULT NULL COMMENT 'FK to Contact ID',
  `entity_id` int UNSIGNED NOT NULL COMMENT 'FK to id of the entity that the action was performed on. Pseudo - FK.',
  `entity_table` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'name of the entity table for the above id, e.g. civicrm_activity, civicrm_participant',
  `action_schedule_id` int UNSIGNED NOT NULL COMMENT 'FK to the action schedule that this action originated from.',
  `action_date_time` datetime DEFAULT NULL COMMENT 'date time that the action was performed on.',
  `is_error` tinyint NOT NULL DEFAULT '0' COMMENT 'Was there any error sending the reminder?',
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'Description / text in case there was an error encountered.',
  `repetition_number` int UNSIGNED DEFAULT NULL COMMENT 'Keeps track of the sequence number of this repetition.',
  `reference_date` datetime DEFAULT NULL COMMENT 'Stores the date from the entity which triggered this reminder action (e.g. membership.end_date for most membership renewal reminders)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;


--
-- Indexes for dumped tables
--

--
-- Indexes for table `civicrm_action_log_preview`
--
ALTER TABLE `civicrm_action_log_preview`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_civicrm_action_log_contact_id` (`contact_id`),
  ADD KEY `FK_civicrm_action_log_action_schedule_id` (`action_schedule_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `civicrm_action_log_preview`
--
ALTER TABLE `civicrm_action_log_preview`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

SET FOREIGN_KEY_CHECKS=1;

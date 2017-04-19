
-- Table to store user infrmation (role indicates user type i.e. user may be admin or member). Admin can add edit, delete any crime/criminal record
-- whereas members can view crimes reported. Reports can be viewd by both of them. Admin will also have the capability to block any member. This way
-- we can have multiple admins and track which admin has reported the crime. This flexible approach can also help us to manage access control on 
--  various data.
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'member',
  `name` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `image` varchar(1000),
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_u_mobile` (`mobile`),
  UNIQUE KEY `uniq_u_email` (`email`)
);


-- This table stores information regarding the crime. We can query this table to fetch record according to the input filters. Only admin can enter data
--  in this table.
CREATE TABLE `crime` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `type` varchar(50) NOT NULL DEFAULT 'member',
  `description` TEXT NOT NULL,
  `tags` TEXT NOT NULL,
  `reported_by` INT(11) NOT NULL,
  `crime_date` datetime NOT NULL,
  `status` varchar(64) NOT NULL DEFAULT 'open',
  `images` text,
  `created_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_c_reported_by` (`reported_by`),
  CONSTRAINT `fk_c_reported_by` FOREIGN KEY (`reported_by`) REFERENCES `user` (`id`)
);


-- This table stores mantains the criminals information. We can thus mantain criminal database and lookup the table to fetch any criminal record and check for 
-- the current status. Only admin can enter values here.
CREATE TABLE `criminal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL,
  `address` varchar(200) NOT NULL,
  `description` varchar(200) NOT NULL,
  `image` varchar(1000),
  `status` varchar(64),
  `created_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
);


-- This table is used to map the crimes with criminals. A crime may have multiple crimianals associated with it and vice versa. Thus we need flexibility to
-- manage that kind of information.
CREATE TABLE `criminal_mapping` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `crime_id` int(11) NOT NULL,
  `criminal_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cm_crime_id` (`crime_id`),
  CONSTRAINT `fk_cm_crime_id` FOREIGN KEY (`crime_id`) REFERENCES `crime` (`id`),
  KEY `fk_cm_criminal_id` (`criminal_id`),
  CONSTRAINT `fk_cm_criminal_id` FOREIGN KEY (`criminal_id`) REFERENCES `criminal` (`id`)
);

-- All the reports will be generatied using these tables only. This is flexible and scalable approach to get efficient reports using limited information.
LOCK TABLES `acl_groups` WRITE;
/*!40000 ALTER TABLE `acl_groups` DISABLE KEYS */;
INSERT INTO `acl_groups` VALUES (1,'Administrators',1),(2,'Physicians',1),(3,'Administrative',1),(4,'Emergency Access',1),(5,'Nurse',1);
/*!40000 ALTER TABLE `acl_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `acl_permissions`
--

LOCK TABLES `acl_permissions` WRITE;
/*!40000 ALTER TABLE `acl_permissions` DISABLE KEYS */;
INSERT INTO `acl_permissions` VALUES (1,'access_calendar','Access Calendar','Calendar',1,1),(2,'add_appointments','Add Appointments','Calendar',2,1),(3,'remove_appointments','Remove Appointments','Calendar',3,1),(4,'access_demographics','Access Demographics','Demographics',1,1),(5,'edit_demographics','Edit Demographics','Demographics',2,1),(6,'access_documents','Access Documents','Documents',1,1),(7,'add_documents','Add Documents','Documents',2,1),(8,'delete_documents','Delete Documents','Documents',3,1),(9,'open_documents','Open Documents','Documents',4,1),(10,'rename_documents','Rename Documents','Documents',5,1),(11,'access_eprescription','Access ePrescription','ePrescription',1,1),(12,'access_eprescription_transaction','Access ePrescription Transaction','ePrescription',2,1),(13,'emergency_access','Emergency Access','Patients',1,1),(14,'add_patient','Add Patient','Patients',2,1),(15,'access_patient_summary','Access Patient Summary','Patients',3,1),(16,'inactive_patient','Inactive Patient','Patients',4,1),(17,'access_patient_search','Access Patient Search','Patients',4,1),(18,'access_encounters','Access Encounters','Encounters',1,1),(19,'add_encounters','Add Encounters','Encounters',2,1),(20,'edit_encounters','Edit Encounters','Encounters',3,1),(34,'access_dashboard','Access Dashboard','Dashboard',1,1),(35,'access_messages','Access Messages','General',2,1),(36,'access_gloabal_settings','Access to Global Settings','Administrators',1,1),(37,'access_facilities','Access to Facilities','Administrators',2,1),(38,'access_users','Access to Users','Administrators',3,1),(39,'access_practice','Access to Practice','Administrators',4,1),(40,'access_preventive_care','Access to Preventive Care','Administrators',5,1),(41,'access_roles','Access to Roles','Administrators',6,1),(42,'access_layouts','Access to Layouts','Administrators',7,1),(43,'access_lists','Access to Lists','Administrators',8,1),(44,'access_admin_audit_log','Access to Audit Log','Administrators',9,1),(45,'access_patient_visits','Access Patient Visits','Patients',3,1),(46,'add_vitals','Add Vitals','Encounters',6,1),(47,'access_encounter_checkout','Access Encounter Checkout','Encounters',50,1),(48,'access_medications','Access Medications','Administrators',1,1),(49,'access_data_manager','Access to Data Maneger','Administrators',5,1),(50,'access_visit_checkout','Visit Checkout','Encounters',50,1),(52,'access_poolcheckin','Access Check In','Pool Areas',3,1),(53,'access_pooltriage','Access Triage','Pool Areas',4,1),(54,'access_poolphysician','Access Physician','Pool Areas',5,1),(55,'access_poolcheckout','Access Check Out','Pool Areas',6,1),(56,'access_pool_areas_panel','Access Pool Areas Panel','Pool Areas',2,1),(57,'use_pool_areas','Use Pool Areas','Pool Areas',1,1),(59,'override_readonly','Override Read Only','Patients',10,1),(60,'access_floor_plans','Access to Floor Plans','Administrators',6,1),(72,'access_review_of_systems','Access Review of Systems','Encounters',0,1),(73,'access_review_of_systems_checks','Access Review of Systems Checks','Encounters',0,1),(74,'access_soap','Access SOAP','Encounters',0,1),(75,'access_itmes_to_review','Access Items ot Review','Encounters',0,1),(77,'access_enc_hcfa','Access HCFA','Encounters',0,1),(78,'access_enc_cpt','Access CPT','Encounters',0,1),(79,'access_enc_history','Access Encounter History','Encounters',0,1),(80,'access_patient_notes','Access Patient Notes','Patients',0,1),(81,'access_patient_reminders','Access Patient Reminders','Patients',0,1),(82,'access_patient_history','Access Patient History','Patients',0,1),(83,'access_patient_billing','Access Patient Billing','Patients',0,1),(84,'access_patient_preventive_care_alerts','Access Patient Preventive Care Alerts','Patients',0,1),(85,'access_patient_vitals','Access Patient Vitals','Patients',0,1),(87,'access_patient_documents','Access Patient Documents','Patients',0,1),(88,'access_patient_disclosures','Access Patient Disclosures','Patients',0,1),(89,'edit_enc_hcfa','Edit HCFA','Encounters',0,1),(90,'sign_enc','Sign Encounter','Encounters',0,1),(91,'sign_enc_supervisor','Sign Encounter (Supervisor)','Encounters',0,1),(92,'require_enc_supervisor','Require Encounter Supervisor','Encounters',0,1),(93,'access_family_history','Access Family History','Encounters',1,1),(94,'edit_family_history','Edit Family History','Encounters',1,1),(95,'access_patient_ccd','Access Patient CCD','Patients',0,1),(96,'access_patient_calendar_events','Access Patient Calendar Events','Patients',0,1),(97,'access_active_problems','Access Active Problems','Encounters',1,1),(98,'access_patient_allergies','Access Patient Allergies','Encounters',1,1),(99,'access_patient_immunizations','Access Patient Immunizations','Immunizations',1,1),(100,'access_patient_medications','Access Patient Medications','Encounters',1,1),(101,'access_floor_plan_panel','Access Floor Plan Panel','Pool Areas',2,1),(102,'create_emergency_encounter','Create Emergency Encounter','Encounters',1,1),(103,'access_patient_visit_checkout','Access Patient Visit Checkout','Patients',0,1),(105,'access_web_search','Access Web Search','Miscellaneous',2,1),(106,'access_address_book','Access Address Book','Miscellaneous',2,1),(107,'access_office_notes','Access Office Notes','Miscellaneous',2,1),(108,'access_admin_hl7','Administer HL7 Server','Administrators',6,1),(109,'access_admin_external_data','Administer External Data','Administrators',6,1),(110,'access_admin_applications','Administer Applications','Administrators',6,1),(111,'access_admin_modules','Administer Modules','Administrators',6,1),(112,'access_admin_encryption','Access Encryption Panel','Administrators',6,1),(113,'access_to_other_facilities','Access To Other Facilities','General',2,1),(114,'access_clinical_decision_support','Access Clinical Decision Support','Encounters',3,1),(115,'access_admin_patients_export','Access Patients Export Panel','Administrators',6,1),(116,'delete_patient_documents','Delete Patient Documents','Patients',0,1),(131,'view_dashboard_new_results','New Results','Dashboard',1,1),(132,'view_dashboard_daily_visits','Daily Visits','Dashboard',1,1),(133,'appointment_module_access','Access Appointment Module','TRA Appointments Module',1,1),(134,'appointment_calendar_access','Access Patient Calendar','TRA Appointments Module',2,1),(135,'appointment_add_patient_event','Add Patient Event','TRA Appointments Module',3,1),(136,'appointment_edit_patient_event','Edit Patient Event','TRA Appointments Module',4,1),(137,'appointment_delete_patient_event','Delete Patient Event','TRA Appointments Module',5,1),(138,'appointment_access_patient_history','Access Patient History','TRA Appointments Module',6,1),(139,'appointment_access_event_audit_trail','Access Event Audit Trail','TRA Appointments Module',7,1),(140,'appointment_admin_access','Access Appointment Admin','TRA Appointments Module',8,1),(141,'appointment_add_admin_event','Add Admin Event','TRA Appointments Module',9,1),(142,'appointment_edit_admin_event','Edit Admin Event','TRA Appointments Module',10,1),(143,'appointment_delete_admin_event','Delete Admin Event','TRA Appointments Module',11,1),(144,'appointment_add_book','Add Book','TRA Appointments Module',9,1),(145,'appointment_edit_book','Edit Book','TRA Appointments Module',10,1),(146,'appointment_delete_book','Delete Book','TRA Appointments Module',10,1),(147,'amendments_access','Access Amendments','Amendments',1,1),(148,'amendments_view_unassigned','View Unassigned Ammendments','Amendments',2,1),(149,'amendments_assign','Assign Ammendments','Amendments',3,1),(150,'amendments_response','Response Ammendments','Amendments',1,1),(151,'hl7_send_adt04','Send Hl7 ADT_04','HL7 Messages',1,1),(152,'administer_medications','Administer Medications','Clinical',3,1),(153,'add_patient_immunizations','Add Immunizations','Immunizations',1,1),(154,'delete_patient_immunizations','Delete Immunizations','Immunizations',1,1),(155,'administer_patient_immunizations','Administer Immunizations','Immunizations',1,1);
/*!40000 ALTER TABLE `acl_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `acl_role_perms`
--

LOCK TABLES `acl_role_perms` WRITE;
/*!40000 ALTER TABLE `acl_role_perms` DISABLE KEYS */;
INSERT INTO `acl_role_perms` VALUES (508,1,8,1,NULL),(509,0,9,1,NULL),(510,1,8,2,NULL),(511,0,9,2,NULL),(512,1,8,3,NULL),(513,0,9,3,NULL),(514,1,8,4,NULL),(515,0,9,4,NULL),(516,1,8,5,NULL),(517,0,9,5,NULL),(518,1,8,6,NULL),(519,0,9,6,NULL),(520,1,8,7,NULL),(521,0,9,7,NULL),(522,1,8,8,NULL),(523,0,9,8,NULL),(524,1,8,9,NULL),(525,0,9,9,NULL),(526,1,8,10,NULL),(527,0,9,10,NULL),(528,1,8,11,NULL),(529,0,9,11,NULL),(530,1,8,12,NULL),(531,0,9,12,NULL),(532,1,8,13,NULL),(533,0,9,13,NULL),(534,1,8,14,NULL),(535,0,9,14,NULL),(536,1,8,15,NULL),(537,0,9,15,NULL),(538,1,8,16,NULL),(539,0,9,16,NULL),(540,1,8,17,'0000-00-00 00:00:00'),(541,0,9,17,'0000-00-00 00:00:00'),(542,1,8,18,NULL),(543,0,9,18,NULL),(544,1,8,19,NULL),(545,0,9,19,NULL),(546,1,8,20,NULL),(547,0,9,20,NULL),(548,1,8,34,NULL),(549,0,9,34,NULL),(550,1,8,35,NULL),(551,0,9,35,NULL),(552,1,8,36,'0000-00-00 00:00:00'),(553,1,9,36,'0000-00-00 00:00:00'),(554,1,8,37,'0000-00-00 00:00:00'),(555,1,9,37,'0000-00-00 00:00:00'),(556,1,8,38,'0000-00-00 00:00:00'),(557,1,9,38,'0000-00-00 00:00:00'),(558,1,8,39,'0000-00-00 00:00:00'),(559,1,9,39,'0000-00-00 00:00:00'),(560,1,8,40,'0000-00-00 00:00:00'),(561,1,9,40,'0000-00-00 00:00:00'),(562,1,8,41,'0000-00-00 00:00:00'),(563,1,9,41,'0000-00-00 00:00:00'),(564,1,8,42,'0000-00-00 00:00:00'),(565,1,9,42,'0000-00-00 00:00:00'),(566,1,8,43,'0000-00-00 00:00:00'),(567,1,9,43,'0000-00-00 00:00:00'),(568,1,8,44,'0000-00-00 00:00:00'),(569,1,9,44,'0000-00-00 00:00:00'),(570,1,8,45,NULL),(571,0,9,45,NULL),(572,1,8,46,NULL),(573,0,9,46,NULL),(574,1,8,47,NULL),(575,0,9,47,NULL),(576,1,8,48,'0000-00-00 00:00:00'),(577,1,9,48,'0000-00-00 00:00:00'),(578,1,8,49,'0000-00-00 00:00:00'),(579,1,9,49,'0000-00-00 00:00:00'),(580,1,8,50,NULL),(581,0,9,50,NULL),(582,1,8,52,NULL),(583,0,9,52,NULL),(584,1,8,53,NULL),(585,0,9,53,NULL),(586,1,8,54,NULL),(587,0,9,54,NULL),(588,1,8,55,NULL),(589,0,9,55,NULL),(590,1,8,56,NULL),(591,0,9,56,NULL),(592,1,8,57,NULL),(593,0,9,57,NULL),(594,1,8,59,NULL),(595,0,9,59,NULL),(596,1,8,60,'0000-00-00 00:00:00'),(597,1,9,60,'0000-00-00 00:00:00'),(598,1,8,72,NULL),(599,0,9,72,NULL),(600,1,8,73,NULL),(601,0,9,73,NULL),(602,1,8,74,NULL),(603,0,9,74,NULL),(604,1,8,75,NULL),(605,0,9,75,NULL),(606,1,8,77,NULL),(607,0,9,77,NULL),(608,1,8,78,NULL),(609,0,9,78,NULL),(610,1,8,79,NULL),(611,0,9,79,NULL),(612,1,8,80,NULL),(613,0,9,80,NULL),(614,1,8,81,NULL),(615,0,9,81,NULL),(616,1,8,82,NULL),(617,0,9,82,NULL),(618,1,8,83,NULL),(619,0,9,83,NULL),(620,1,8,84,NULL),(621,0,9,84,NULL),(622,1,8,85,NULL),(623,0,9,85,NULL),(624,1,8,87,NULL),(625,0,9,87,NULL),(626,1,8,88,NULL),(627,0,9,88,NULL),(628,1,8,89,NULL),(629,0,9,89,NULL),(630,1,8,90,NULL),(631,0,9,90,NULL),(632,1,8,91,NULL),(633,0,9,91,NULL),(634,1,8,92,NULL),(635,0,9,92,NULL),(636,1,8,93,NULL),(637,0,9,93,NULL),(638,1,8,94,NULL),(639,0,9,94,NULL),(640,1,8,95,NULL),(641,0,9,95,NULL),(642,1,8,96,NULL),(643,0,9,96,NULL),(644,1,8,97,NULL),(645,0,9,97,NULL),(646,1,8,98,NULL),(647,0,9,98,NULL),(648,1,8,99,NULL),(649,0,9,99,NULL),(650,1,8,100,NULL),(651,0,9,100,NULL),(652,1,8,101,NULL),(653,0,9,101,NULL),(654,1,8,102,NULL),(655,0,9,102,NULL),(656,1,8,103,NULL),(657,0,9,103,NULL),(658,1,8,105,NULL),(659,0,9,105,NULL),(660,1,8,106,NULL),(661,0,9,106,NULL),(662,1,8,107,NULL),(663,0,9,107,NULL),(664,1,8,108,'0000-00-00 00:00:00'),(665,1,9,108,'0000-00-00 00:00:00'),(666,1,8,109,'0000-00-00 00:00:00'),(667,1,9,109,'0000-00-00 00:00:00'),(668,1,8,110,'0000-00-00 00:00:00'),(669,1,9,110,'0000-00-00 00:00:00'),(670,1,8,111,'0000-00-00 00:00:00'),(671,1,9,111,'0000-00-00 00:00:00'),(672,1,8,112,'0000-00-00 00:00:00'),(673,1,9,112,'0000-00-00 00:00:00'),(674,1,8,113,NULL),(675,0,9,113,NULL),(676,1,8,114,NULL),(677,0,9,114,NULL),(678,1,8,115,'0000-00-00 00:00:00'),(679,1,9,115,'0000-00-00 00:00:00'),(680,1,8,116,NULL),(681,0,9,116,NULL),(682,1,10,1,'0000-00-00 00:00:00'),(683,1,10,2,'0000-00-00 00:00:00'),(684,1,10,3,'0000-00-00 00:00:00'),(685,1,10,4,'0000-00-00 00:00:00'),(686,1,10,5,'0000-00-00 00:00:00'),(687,1,10,6,'0000-00-00 00:00:00'),(688,1,10,7,'0000-00-00 00:00:00'),(689,1,10,8,'0000-00-00 00:00:00'),(690,1,10,9,'0000-00-00 00:00:00'),(691,1,10,10,'0000-00-00 00:00:00'),(692,1,10,18,'0000-00-00 00:00:00'),(693,1,10,19,'0000-00-00 00:00:00'),(694,1,10,20,'0000-00-00 00:00:00'),(695,1,10,46,'0000-00-00 00:00:00'),(696,1,10,47,'0000-00-00 00:00:00'),(697,1,10,50,'0000-00-00 00:00:00'),(698,1,10,72,'0000-00-00 00:00:00'),(699,1,10,73,'0000-00-00 00:00:00'),(700,1,10,74,'0000-00-00 00:00:00'),(701,1,10,75,'0000-00-00 00:00:00'),(702,1,10,77,'0000-00-00 00:00:00'),(703,1,10,78,'0000-00-00 00:00:00'),(704,1,10,79,'0000-00-00 00:00:00'),(705,0,10,89,'0000-00-00 00:00:00'),(706,1,10,90,'0000-00-00 00:00:00'),(707,1,10,91,'0000-00-00 00:00:00'),(708,1,10,93,'0000-00-00 00:00:00'),(709,1,10,94,'0000-00-00 00:00:00'),(710,1,10,97,'0000-00-00 00:00:00'),(711,1,10,98,'0000-00-00 00:00:00'),(712,1,10,99,'0000-00-00 00:00:00'),(713,1,10,100,'0000-00-00 00:00:00'),(714,0,10,102,'0000-00-00 00:00:00'),(715,1,10,114,'0000-00-00 00:00:00'),(716,1,10,34,'0000-00-00 00:00:00'),(717,1,10,35,'0000-00-00 00:00:00'),(718,1,10,113,'0000-00-00 00:00:00'),(719,1,10,105,'0000-00-00 00:00:00'),(720,1,10,106,'0000-00-00 00:00:00'),(721,1,10,107,'0000-00-00 00:00:00'),(722,1,10,14,'0000-00-00 00:00:00'),(723,1,10,15,'0000-00-00 00:00:00'),(724,1,10,16,'0000-00-00 00:00:00'),(725,1,10,17,'0000-00-00 00:00:00'),(726,1,10,45,'0000-00-00 00:00:00'),(727,1,10,59,'0000-00-00 00:00:00'),(728,1,10,80,'0000-00-00 00:00:00'),(729,1,10,81,'0000-00-00 00:00:00'),(730,1,10,82,'0000-00-00 00:00:00'),(731,1,10,83,'0000-00-00 00:00:00'),(732,1,10,84,'0000-00-00 00:00:00'),(733,1,10,85,'0000-00-00 00:00:00'),(734,1,10,87,'0000-00-00 00:00:00'),(735,1,10,88,'0000-00-00 00:00:00'),(736,1,10,95,'0000-00-00 00:00:00'),(737,1,10,96,'0000-00-00 00:00:00'),(738,1,10,103,'0000-00-00 00:00:00'),(739,1,10,116,'0000-00-00 00:00:00'),(740,1,10,54,'0000-00-00 00:00:00'),(741,1,10,57,'0000-00-00 00:00:00'),(742,1,10,101,'0000-00-00 00:00:00'),(743,1,10,11,'0000-00-00 00:00:00'),(744,1,10,12,'0000-00-00 00:00:00'),(745,1,11,4,NULL),(746,1,11,5,NULL),(747,1,11,13,NULL),(748,1,11,14,NULL),(749,1,11,15,NULL),(750,1,11,16,NULL),(751,1,11,17,NULL),(752,1,11,45,NULL),(753,1,11,59,NULL),(754,1,11,80,NULL),(755,1,11,81,NULL),(756,1,11,82,NULL),(757,1,11,83,NULL),(758,1,11,87,NULL),(759,1,11,88,NULL),(760,1,11,95,NULL),(761,1,11,96,NULL),(762,1,11,103,NULL),(763,1,11,116,NULL),(764,1,11,52,NULL),(765,1,12,18,NULL),(766,1,12,19,NULL),(767,1,12,20,NULL),(768,1,12,46,NULL),(769,1,12,47,NULL),(770,1,12,50,NULL),(771,1,12,72,NULL),(772,1,12,73,NULL),(773,1,12,74,NULL),(774,1,12,75,NULL),(775,1,12,77,NULL),(776,1,12,78,NULL),(777,1,12,79,NULL),(778,1,12,89,NULL),(779,1,12,90,NULL),(780,1,12,91,NULL),(781,1,12,92,NULL),(782,1,12,93,NULL),(783,1,12,94,NULL),(784,1,12,97,NULL),(785,1,12,98,NULL),(786,1,12,99,NULL),(787,1,12,100,NULL),(788,1,12,102,NULL),(789,1,12,114,NULL),(790,1,13,6,'0000-00-00 00:00:00'),(791,1,13,9,'0000-00-00 00:00:00'),(792,1,15,18,NULL),(793,1,16,18,NULL),(794,0,15,19,NULL),(795,1,16,19,NULL),(796,0,15,20,NULL),(797,1,16,20,NULL),(798,1,15,46,NULL),(799,1,16,46,NULL),(800,1,15,47,NULL),(801,1,16,47,NULL),(802,1,15,50,NULL),(803,1,16,50,NULL),(804,1,15,72,NULL),(805,1,16,72,NULL),(806,1,15,73,NULL),(807,1,16,73,NULL),(808,0,15,74,NULL),(809,1,16,74,NULL),(810,0,15,75,NULL),(811,1,16,75,NULL),(812,0,15,77,NULL),(813,1,16,77,NULL),(814,0,15,78,NULL),(815,1,16,78,NULL),(816,1,15,79,NULL),(817,1,16,79,NULL),(818,0,15,89,NULL),(819,1,16,89,NULL),(820,1,15,92,NULL),(821,0,16,92,NULL),(822,1,15,93,NULL),(823,1,16,93,NULL),(824,1,15,94,NULL),(825,1,16,94,NULL),(826,1,15,97,NULL),(827,1,16,97,NULL),(828,1,15,98,NULL),(829,1,16,98,NULL),(830,1,15,99,NULL),(831,1,16,99,NULL),(832,1,15,100,NULL),(833,1,16,100,NULL),(834,1,15,102,NULL),(835,1,16,102,NULL),(836,1,15,114,NULL),(837,1,16,114,NULL),(838,1,15,105,NULL),(839,1,16,105,NULL),(840,1,15,13,NULL),(841,1,16,13,NULL),(842,1,15,14,NULL),(843,1,16,14,NULL),(844,1,15,15,NULL),(845,1,16,15,NULL),(846,1,15,16,NULL),(847,1,16,16,NULL),(848,1,15,17,NULL),(849,1,16,17,NULL),(850,1,15,45,NULL),(851,1,16,45,NULL),(852,0,15,59,NULL),(853,1,16,59,NULL),(854,1,15,80,NULL),(855,1,16,80,NULL),(856,1,15,81,NULL),(857,1,16,81,NULL),(858,1,15,82,NULL),(859,1,16,82,NULL),(860,1,15,84,NULL),(861,1,16,84,NULL),(862,1,15,85,NULL),(863,1,16,85,NULL),(864,1,15,87,NULL),(865,1,16,87,NULL),(866,1,15,88,NULL),(867,1,16,88,NULL),(868,0,15,95,NULL),(869,1,16,95,NULL),(870,1,15,96,NULL),(871,1,16,96,NULL),(872,1,15,103,NULL),(873,1,16,103,NULL),(874,1,15,116,NULL),(875,1,16,116,NULL),(876,1,15,57,NULL),(877,1,16,57,NULL),(878,1,15,101,NULL),(879,1,16,101,NULL),(880,1,15,53,NULL),(881,1,16,53,NULL),(882,0,13,1,NULL),(883,1,14,1,NULL),(884,0,13,2,NULL),(885,1,14,2,NULL),(886,0,13,3,NULL),(887,1,14,3,NULL),(888,1,14,6,NULL),(889,1,14,9,NULL),(890,0,13,18,NULL),(891,1,14,18,NULL),(892,0,13,19,NULL),(893,1,14,19,NULL),(894,0,13,20,NULL),(895,1,14,20,NULL),(896,0,13,46,NULL),(897,1,14,46,NULL),(898,0,13,47,NULL),(899,1,14,47,NULL),(900,0,13,50,NULL),(901,1,14,50,NULL),(902,0,13,72,NULL),(903,1,14,72,NULL),(904,0,13,73,NULL),(905,1,14,73,NULL),(906,0,13,74,NULL),(907,1,14,74,NULL),(908,0,13,75,NULL),(909,1,14,75,NULL),(910,0,13,77,NULL),(911,1,14,77,NULL),(912,0,13,78,NULL),(913,1,14,78,NULL),(914,0,13,79,NULL),(915,1,14,79,NULL),(916,0,13,89,'0000-00-00 00:00:00'),(917,1,14,89,'0000-00-00 00:00:00'),(918,0,13,90,NULL),(919,1,14,90,NULL),(920,0,13,91,NULL),(921,1,14,91,NULL),(922,0,13,93,NULL),(923,1,14,93,NULL),(924,0,13,94,NULL),(925,1,14,94,NULL),(926,0,13,97,NULL),(927,1,14,97,NULL),(928,0,13,98,NULL),(929,1,14,98,NULL),(930,0,13,99,NULL),(931,1,14,99,NULL),(932,0,13,100,NULL),(933,1,14,100,NULL),(934,0,13,102,'0000-00-00 00:00:00'),(935,1,14,102,'0000-00-00 00:00:00'),(936,0,13,114,NULL),(937,1,14,114,NULL),(938,0,13,34,NULL),(939,1,14,34,NULL),(940,0,13,35,NULL),(941,1,14,35,NULL),(942,0,13,113,NULL),(943,1,14,113,NULL),(944,0,13,105,NULL),(945,1,14,105,NULL),(946,0,13,106,NULL),(947,1,14,106,NULL),(948,0,13,107,NULL),(949,1,14,107,NULL),(950,0,13,14,NULL),(951,1,14,14,NULL),(952,0,13,15,NULL),(953,1,14,15,NULL),(954,0,13,16,NULL),(955,1,14,16,NULL),(956,0,13,17,NULL),(957,1,14,17,NULL),(958,0,13,45,NULL),(959,1,14,45,NULL),(960,0,13,59,NULL),(961,1,14,59,NULL),(962,0,13,80,NULL),(963,1,14,80,NULL),(964,0,13,81,NULL),(965,1,14,81,NULL),(966,0,13,82,NULL),(967,1,14,82,NULL),(968,0,13,83,NULL),(969,1,14,83,NULL),(970,0,13,84,NULL),(971,1,14,84,NULL),(972,0,13,85,NULL),(973,1,14,85,NULL),(974,0,13,87,NULL),(975,1,14,87,NULL),(976,0,13,88,NULL),(977,1,14,88,NULL),(978,0,13,95,NULL),(979,1,14,95,NULL),(980,0,13,96,NULL),(981,1,14,96,NULL),(982,0,13,103,NULL),(983,1,14,103,NULL),(984,0,13,116,NULL),(985,1,14,116,NULL),(986,0,13,54,NULL),(987,1,14,54,NULL),(988,0,13,57,NULL),(989,1,14,57,NULL),(990,0,13,101,NULL),(991,1,14,101,NULL),(992,0,13,11,NULL),(993,1,14,11,NULL),(994,0,13,12,NULL),(995,1,14,12,NULL),(996,1,10,129,NULL),(997,0,13,129,NULL),(998,1,14,129,NULL),(999,1,10,123,NULL),(1000,0,13,123,NULL),(1001,0,14,123,NULL),(1002,1,10,124,NULL),(1003,0,13,124,NULL),(1004,0,14,124,NULL),(1005,1,10,125,NULL),(1006,0,13,125,NULL),(1007,0,14,125,NULL),(1008,1,10,126,NULL),(1009,0,13,126,NULL),(1010,0,14,126,NULL),(1011,1,10,127,'0000-00-00 00:00:00'),(1012,0,13,127,'0000-00-00 00:00:00'),(1013,0,14,127,'0000-00-00 00:00:00'),(1014,1,10,128,'0000-00-00 00:00:00'),(1015,0,13,128,'0000-00-00 00:00:00'),(1016,0,14,128,'0000-00-00 00:00:00'),(1017,1,10,130,NULL),(1018,0,13,130,NULL),(1019,0,14,130,NULL),(1020,0,13,4,NULL),(1021,1,14,4,NULL),(1022,0,13,5,NULL),(1023,1,14,5,NULL),(1024,0,13,7,NULL),(1025,1,14,7,NULL),(1026,0,13,8,NULL),(1027,1,14,8,NULL),(1028,0,13,10,NULL),(1029,1,14,10,NULL),(1030,1,8,129,NULL),(1031,0,9,129,NULL),(1032,1,11,1,NULL),(1033,1,11,2,NULL),(1034,1,11,3,NULL),(1035,1,11,6,NULL),(1036,1,11,7,NULL),(1037,1,11,9,NULL),(1038,1,11,10,NULL),(1039,1,11,106,NULL),(1040,1,11,107,NULL),(1041,1,11,56,NULL),(1042,1,11,57,NULL),(1043,1,8,131,NULL),(1044,0,9,131,NULL),(1045,1,8,132,NULL),(1046,0,9,132,NULL),(1047,1,10,56,NULL),(1048,0,13,56,NULL),(1049,0,14,56,NULL),(1050,1,8,133,NULL),(1051,0,9,133,NULL),(1052,1,8,134,NULL),(1053,0,9,134,NULL),(1054,1,8,140,NULL),(1055,0,9,140,NULL),(1056,1,8,141,NULL),(1057,0,9,141,NULL),(1058,1,8,142,NULL),(1059,0,9,142,NULL),(1060,1,8,144,NULL),(1061,0,9,144,NULL),(1062,1,8,145,NULL),(1063,0,9,145,NULL),(1064,1,8,135,NULL),(1065,0,9,135,NULL),(1066,1,8,136,NULL),(1067,0,9,136,NULL),(1068,1,8,137,NULL),(1069,0,9,137,NULL),(1070,1,8,147,NULL),(1071,1,9,147,NULL),(1072,1,8,148,NULL),(1073,0,9,148,NULL),(1074,1,8,150,NULL),(1075,0,9,150,NULL),(1076,1,8,149,NULL),(1077,0,9,149,NULL),(1078,1,10,147,NULL),(1079,0,13,147,NULL),(1080,0,14,147,NULL),(1081,1,10,148,NULL),(1082,0,13,148,NULL),(1083,0,14,148,NULL),(1084,0,10,149,NULL),(1085,0,13,149,NULL),(1086,0,14,149,NULL),(1087,1,10,150,NULL),(1088,0,13,150,NULL),(1089,0,14,150,NULL),(1090,1,8,151,NULL),(1091,1,8,152,NULL),(1092,1,8,153,NULL),(1093,1,8,154,NULL),(1094,1,8,155,NULL),(1095,1,14,153,NULL),(1096,1,14,154,NULL),(1097,1,14,155,NULL),(1098,1,10,156,NULL),(1099,1,10,157,NULL),(1100,1,12,13,NULL),(1101,1,12,14,NULL),(1102,1,12,15,NULL),(1103,1,12,16,NULL),(1104,1,12,17,NULL),(1105,1,12,57,NULL),(1106,1,12,52,NULL),(1107,1,12,53,NULL),(1108,1,12,54,NULL),(1109,1,12,55,NULL),(1110,1,12,56,NULL),(1111,1,12,101,NULL),(1112,1,8,158,NULL),(1113,1,8,159,NULL),(1114,1,8,160,NULL),(1115,1,8,161,NULL),(1116,1,8,162,NULL),(1117,1,8,163,NULL),(1118,1,8,164,NULL),(1119,1,8,165,NULL),(1120,1,8,166,NULL),(1121,1,8,167,NULL),(1122,1,8,168,NULL),(1123,1,8,169,NULL),(1124,1,8,170,NULL),(1125,1,8,171,NULL);
/*!40000 ALTER TABLE `acl_role_perms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `acl_roles`
--

LOCK TABLES `acl_roles` WRITE;
/*!40000 ALTER TABLE `acl_roles` DISABLE KEYS */;
INSERT INTO `acl_roles` VALUES (8,'Super Admin',0,1,NULL),(9,'Jr Admin',0,1,NULL),(10,'Dentist',0,2,NULL),(11,'Check In',0,3,NULL),(12,'Physician Emer',0,4,NULL),(13,'Referrer',0,2,NULL),(14,'Doctor',0,2,NULL),(15,'Junior Nurce',0,5,NULL),(16,'Register Nurse',0,5,NULL);
/*!40000 ALTER TABLE `acl_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `globals`
--

LOCK TABLES `globals` WRITE;
/*!40000 ALTER TABLE `globals` DISABLE KEYS */;
INSERT INTO `globals` VALUES (1,'activate_ccr_ccd_report',0,'0','Reports'),(3,'atna_audit_cacert',0,'','Audit'),(4,'atna_audit_host',0,'','Audit'),(5,'atna_audit_localcert',0,'','Audit'),(6,'atna_audit_port',0,'6514','Audit'),(7,'audit_events_backup',0,'0','Audit'),(8,'audit_events_order',0,'0','Audit'),(9,'audit_events_other',0,'0','Audit'),(10,'audit_events_patient-record',0,'','Audit'),(11,'audit_events_query',0,'0','Audit'),(12,'audit_events_scheduling',0,'0','Audit'),(13,'audit_events_security-administration',0,'','Audit'),(14,'autosave',0,'1','General'),(19,'certificate_authority_crt',0,'','Security'),(20,'certificate_authority_key',0,'','Security'),(21,'client_certificate_valid_in_days',0,'365','Security'),(23,'country_data_type',0,'26','Locale'),(24,'country_list',0,'country','Locale'),(25,'css_header',0,'ext-all-gray.css','General'),(26,'currency_decimals',0,'2','Locale'),(27,'currency_dec_point',0,'.','Locale'),(28,'currency_thousands_sep',0,',','Locale'),(29,'date_display_format',0,'Y-m-d','Locale'),(30,'default_chief_complaint',0,'','Clinical'),(42,'EMAIL_METHOD',0,'SMTP','Email'),(43,'EMAIL_NOTIFICATION_HOUR',0,'50','Email'),(45,'enable_atna_audit',0,'0','Audit'),(46,'enable_auditlog',0,'0','Audit'),(47,'enable_hylafax',0,'0','Fax/Scanner'),(48,'enable_scanner',0,'0','Fax/Scanner'),(50,'fullname',0,'1','Locale'),(52,'gbl_currency_symbol',0,'$','Locale'),(53,'gbl_mask_invoice_number',0,'','General'),(54,'gbl_mask_patient_id',0,'','General'),(55,'gbl_mask_product_id',0,'','General'),(56,'gbl_nav_area_width',0,'200','General'),(57,'gbl_visit_referral_source',0,'0','General'),(58,'hylafax_basedir',0,'/var/spool/fax','Fax/Scanner'),(59,'hylafax_enscript',0,'enscript -M Letter -B -e^ --margins=36:36:36:36','Fax/Scanner'),(60,'hylafax_server',0,'localhost','Fax/Scanner'),(62,'inhouse_pharmacy',0,'','General'),(63,'is_client_ssl_enabled',0,'0','Security'),(64,'language_default',0,'en_US','Locale'),(66,'main_navigation_menu_left',0,'west','General'),(72,'password_expiration_days',0,'0','General'),(79,'phone_country_code',0,'1','Locale'),(82,'print_command',0,'lpr -P HPLaserjet6P -o cpi=10 -o lpi=6 -o page-left=72 -o page-top=72','Fax/Scanner'),(84,'scanner_output_directory',0,'/mnt/scan_docs','Fax/Scanner'),(93,'SMS_GATEWAY_APIKEY',0,'','Email'),(94,'SMS_GATEWAY_PASSWORD',0,'','Email'),(95,'SMS_GATEWAY_USENAME',0,'','Email'),(96,'SMS_NOTIFICATION_HOUR',0,'50','Email'),(97,'SMTP_HOST',0,'localhost','Email'),(98,'SMTP_PASS',0,'','Email'),(99,'SMTP_PORT',0,'25','Email'),(100,'SMTP_USER',0,'','Email'),(107,'timeout',0,'30','General'),(108,'time_display_format',0,'g:i a','Locale'),(109,'enable_poolarea_fade_in_out',0,'0','General'),(110,'enable_encounter_vitals',0,'1','Clinical'),(111,'enable_encounter_soap',0,'1','Clinical'),(112,'enable_encounter_cpt',0,'1','Clinical'),(113,'enable_encounter_hcfa',0,'1','Clinical'),(114,'enable_encounter_history',0,'1','Clinical'),(115,'enable_encounter_items_to_review',0,'1','Clinical'),(116,'enable_encounter_review_of_systems',0,'1','Clinical'),(117,'enable_encounter_review_of_systems_cks',0,'0','Clinical'),(118,'enable_encounter_dictation',0,'0','Clinical'),(119,'enable_document_encryption',0,'0','Security'),(120,'enable_dual_monitor',0,'0','General'),(121,'enable_encounter_soap_templates',0,'1','Clinical'),(122,'dx_code_type',0,'ICD10','Clinical'),(123,'units_of_measurement',0,'metric','General'),(124,'enable_encounter_family_history',0,'1','Clinical'),(125,'use_pubid_for_external_comm',0,'1','General'),(126,'enable_clinical_decision_support',0,'1','Clinical'),(127,'compact_demographics',0,'1','Demographics'),(128,'phone_validation_format',0,'^\\d{3}-\\d{3}-\\d{4}$','Locale'),(129,'zipcode_validation_format',0,'^\\d{5}(?:[-\\s]\\d{4})?$','Locale'),(130,'rx_order_number_prefix',0,'RX','General'),(131,'poolarea_order_by',0,'appointment','General'),(132,'display_pubpid',0,'1','General');
/*!40000 ALTER TABLE `globals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (1,'Default','admin');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user_settings`
--

LOCK TABLES `user_settings` WRITE;
/*!40000 ALTER TABLE `user_settings` DISABLE KEYS */;
INSERT INTO `user_settings` VALUES (0,'allergy_ps_expand','1'),(0,'appointments_ps_expand','1'),(0,'billing_ps_expand','0'),(0,'demographics_ps_expand','0'),(0,'dental_ps_expand','1'),(0,'directives_ps_expand','1'),(0,'disclosures_ps_expand','0'),(0,'gacl_protect','0'),(0,'immunizations_ps_expand','1'),(0,'insurance_ps_expand','0'),(0,'medical_problem_ps_expand','1'),(0,'medication_ps_expand','1'),(0,'pnotes_ps_expand','0'),(0,'prescriptions_ps_expand','1'),(0,'surgery_ps_expand','1'),(0,'vitals_ps_expand','1'),(1,'gacl_protect','1');
/*!40000 ALTER TABLE `user_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'gaiadb'
--

--
-- Dumping routines for database 'gaiadb'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-04-01 13:44:01

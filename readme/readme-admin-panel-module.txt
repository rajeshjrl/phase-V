|*|*********************************************************************************************************************|*|
|*|*********************************************************************************************************************|*|
|x|                                                                                                                     |x|
|x|                                                                                                                     |x|
|x|        _____         _____         ___        __        _____            ________   _________        _____          |x|
|x|       //---\\       //---\\       ||-\\       ||       //---\\          //======/   ||_______|      //---\\         |x|
|x|      ||     \\     //     \\      ||  \\      ||      //     \\        //           ||             //     \\        |x|
|x|      ||_____||    //       \\     ||   \\     ||     //       \\      ||            ||______      //       \\       |x|
|x|      ||____//    ||=========||    ||    \\    ||    ||=========||     ||            ||______|    ||=========||      |x|
|x|      ||          ||=========||    ||     \\   ||    ||=========||     \\            ||           ||=========||      |x|
|x|      ||          ||         ||    ||      \\  ||    ||         ||      \\_______    ||_______    ||         ||      |x|
|x|      ||          ||         ||    ||       \\_||    ||         ||       \=======\   ||_______|   ||         ||      |x|
|x|                                                                                                                     |x|
|x|                                                                                                                     |x|
|*|*********************************************************************************************************************|*|
|*|*********************************************************************************************************************|*|

   PIPL Code Library CI - Admin Panel Module CI
   Author - Pradip D Urunkar :)
   Purpose - The module will manage basic functionality required in backend for Admin Panel in Project
   Email - pradip@panaceatek.com

   ---------------------------
   What is Admin Panel?
   ---------------------------

   Web Defination  : This is area in which you will customize your business directory.  In the admin panel you can add and modify package listings, users,           subscriptions, as well as see your earning and statistics

  ---------------------------
   1. Installation Notes
   ---------------------------

    Table requireds as follows

	1. pipl_ci_sessions
	2. pipl_mst_global_settings
	3. pipl_trans_global_settings
	4. pipl_mst_email_templates
	5. pipl_mst_languages
	6. pipl_mst_privileges
	7. pipl_mst_role
	8. pipl_trans_role_privileges
	7. pipl_mst_users


   In order to use admin panel module CI , Below are steps.

	Step 1 : Create the neccessary data struture required for the project, the db_sql found in the file admin-panel-module-ci -> db_sql -> db-sql-admin-panel-module.txt, Import this file in your database. Please note, the suffix  must match with your project's suffix if not matched, you may need to change the suffix.
			
			e.q. 1.create database p777
			     2.Carefully Find and replace PIPL_  with  p777_ in the sql file
			     3.Copy sql and fire query in datatbase created	
	
	Step 2 : Copy the routes admin side routes from the file	pipl-code-library-ci -> application -> config -> routes.php and 

		paste it into your projects routes.

	Step 3 : Copy following model from  pipl-code-library-ci -> application -> models folder to your project models folder eq to P777-> application -> models 	folder

		1.  admin_model.php
		2.  common_model.php
		3.  global_setting_model.php

        Stpe 4 : Step 3 : Copy following controller from  pipl-code-library-ci -> application -> controllers folder to your project controller folder e.q. to P777-> application -> controllers folder
		
		1.  admin.php
		2.  global_setting.php
		3.  role.php

	Step 5 :Copy following folders and file from  pipl-code-library-ci -> application -> view -> backend folder to your project view backend folder e.q. to P777-> application -> view -> backend folder
		
		1.  admin
		2.  global-setting
		3.  log-in
		4.  role 
		5.  sections

		6. index.php

	Step 6 : Set your .htaccess rule correctly for the project directory


	Step 7 : check your Config parameter into  for the ci application is correctley set i.e into the config.php and database.php file found into the pipl-code-library-ci -> application -> config folder.

	
	Step 8 : Hit the admin login url in browser window
		
		  e.g http://192.168.2.41/p777/backend/login 
		
			Enter user name : admin
			Password : Pass@123$

	Step 9 : Your admin panel for project is ready.Check all Functionalities are working properly.



	Best Luck ...............  :)	


   ---------------------------
   2. Admin Panel Controller Logic
   ---------------------------

   All the Models, controller and View are self explanatory having all comments associated with respective method on top of the method and inside method.

	Important : The global setting is managed via file handling, and for each language file is found in pipl-code-library-ci -> application -> view -> backend -> 
	global-setting folde. When changes or add the new parameter for global settings into the database manulally, it is required to edit in admin panel once for 
	each language to update this file and global settings will get updated every where.
 
			


|*|*********************************************************************************************************************|*|
|x|                                                                                                                     |x|
|x|                                          PIPL Admin Panel Module CI - readme-admin-panel-module.txt                 |x|
|x|                                                                                                                     |x|
|*|*********************************************************************************************************************|*|
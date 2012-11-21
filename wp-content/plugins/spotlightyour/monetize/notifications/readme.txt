********************************************************************
MANAGE NOTIFICATION EMAILS AND MESSAGE MODULE - WP-ADMIN
********************************************************************
Includes 3 main files

1)admin_notification.php   --> includes code functionality for wp-admin notification interface.

2)notification_functions.php  --> main file for this module and included in modules_main.php file

3)notification_options.php  --> contains notification content data for emails and messages.



There are two main filter to manage Emails and Message content.
"DDBWP_email_notifications_filter"  --> for Notificaton Email
"DDBWP_msg_notifications_filter"    --> for notification Messages




You can Add/edit/remove any message/emails via this filters so easy to manage it.





Note : while include this module, you should include the "notification_functions.php" file to modules_main.php file.
       The php syntex is : 

	====================================================================================
        include_once (DDB_MODULES_FOLDER_PATH . 'notifications/notification_functions.php');
	====================================================================================






-----------------------------------------Thanks -------------------------------------------------------
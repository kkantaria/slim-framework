<?php
define("ROOT","http://".$_SERVER['SERVER_NAME']."/".$sub_folder);
define("DIR_ROOT",$_SERVER['DOCUMENT_ROOT']."/".$sub_folder);

// define("ROOT_URL","http://".$_SERVER['SERVER_NAME']."/drive_buddy/");
define("UPLOAD_URL",ROOT."uploads/");
define("UPLOAD_DIR",DIR_ROOT."uploads/");

define("MODE",$mode);
define("AUTH_ENABLE",$auth_enable);
define("IS_LOG",$is_log);


define("SUCCESS",200);
define("BAD_REQUEST",400);
define("UNAUTH",403);
define("NOT_FOUND",404);
define("METHOD_NOT_ALLOWED",405);
define("INTERNAL_SERVER_ERROR",500);
define("VERSION_NOT_SUPPORT",505);
define("CONFLICT",409);
define("TIMEOUT",504);

/*  Notification Constant */


define("GOOGLE_KEY",$PROJECT['android']['google_key']);

define("IOS_DEV_PEMFILE_PATH",$PROJECT['ios'][$app_version]['ios_dev_pemfile_path']);
define("IOS_DEV_PEM_PASSWORD",$PROJECT['ios'][$app_version]['ios_dev_pem_password']);

define("IOS_PRO_PEMFILE_PATH",$PROJECT['ios'][$app_version]['ios_pro_pemfile_path']);
define("IOS_PRO_PEM_PASSWORD",$PROJECT['ios'][$app_version]['ios_pro_pem_password']);


define("MAIL_TEMPLATE_PATH",$PROJECT['mail_template_path']);


define('BASE_URL', $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.$PROJECT['folder']['sub_folder']);

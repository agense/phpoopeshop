<?php
// DEBUG MODE
define('DEBUG', true);


// DEFAULT CONTROLLERS

// Default controler for front end
define('DEFAULT_CONTROLLER', 'Home'); 

// Default controler for admin area
define('ADMIN_DEFAULT_CONTROLLER', 'Access');

// Controller name for the restricted redirect
define('ACCESS_RESTRICTED', 'Restricted'); 



// DEFAULT PAGE LAYOUTS

// Default page layout (used if no loayout is defined in the controller)
define('DEFAULT_LAYOUT', 'default'); 

// Default page layout for admin area (used if no loayout is defined in the controller)
define('ADMIN_DEFAULT_LAYOUT', 'admin_default'); 



// DEFAULT USER SESSIONS

// Default session name for logged in administrator
define('ADMIN_SESSION_NAME', 'adm9687nfgbsoeng3869'); 

// Default session name for logged in front-end user
define('CURRENT_USER_SESSION_NAME', 'jhgfdrtyuiolkjhgfsgtr');

// Default cookie name for logged in user rememberMe 
define('REMEMBER_ME_COOKIE_NAME', '8765tghklofgt546nght'); 

// Default expiry timeframe for rememberMe cookies: 30 days time in seconds
define('REMEMBER_COOKIE_EXPIRY', 604800); 
define('CART_SESSION', 'YLs4JnliKNU1rr7PVmor');


// DEFAULT PROJECT ROOT
// Set this to '/' on the live server
define('PROOT', '/eshop/');  


// DEFAULT SITE SETTINGS

// Default site title
define('SITE_TITLE', 'THE ESHOP'); 

// Currency
define('CURRENCY', '€');

// Tax Percentage
define('TAX_RATE_PERCENTAGE', 13);

// Number of days for which to display products as new from their upload date
define('NEW_ITEMS_TRESHOLD', 180);


// FILE UPLOAD PATHS

// General image upload path
define('UPLOAD_PATH', 'images'.DS);

// Product Images Folder Path
define('PRODUCT_IMG_FOLDER', PROOT.'images'.DS.'product_images'.DS);

// Setting files folder
define('SETTINGS_FOLDER', ROOT.DS."app".DS."settings".DS);


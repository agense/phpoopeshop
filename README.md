## PHP OOP MVC MINI FRAMEWORK / E-SHOP WITH BACKEND MANAGEMENT SYSTEM
___

#### PROJECT DESCRIPTION

Project is composed of two parts, a mini PHP OOP MVC framework and an eshop application extending the framework.

The framework part includes core classes for routing, model loading, view rendering, request data processing, session and cookie management and class autoloading. The framework part is structurally separated from the eshop application part and can be reused for creating other projects.

The eshop application part includes a responsive frontend website with product display, shopping cart and ordering functionalities and a backend admin panel with role based access control, which provides a full content management capabilities for all eshop components. The project comes with two separate login systems: admin panel login and front end users account login \/ registration. 

#### PROJECT IN DETAILS

###### BACKEND CMS :

* Admin panel with separate login system and content access control based on three administrator roles: superadmin, admin and editor. Permissions are set during development in a dedicated JSON file
* Content management (CRUD) functionality for products, product  categories and subcategories, product brands, materials and colors, product collections, orders, website pages, administrator accounts, site contact info settings and social media settings
* Complete product management functionality: managing prices, setting discounts per product, updating quantities, uploading featured and slider images, toggling product display as featured in the frontend
* Soft delete and restore functionality for categories, products, product collections, and site administrators
* Order display and processing functionality
* Crud for website page creation with Summernote WYSIWYG editor, including image upload and toggling page link display in footer menu 

###### FRONTEND/ESHOP WEBSITE: 

* Landing page with product category display and sliders for newest products and featured products display
* Products page with filtering and sorting capabilities
* Single product page with product image slider and product photo zoom in option
* Pages for displaying product categories and subcategories, product collections and newest products per category
* Shopping Cart 
* Ordering Page
* Wishlist Functionality (for logged in users)
* User account management system with ability to update account details, view users orders and manage users wishlist. Includes user registration, login and auto-login from cookie (Remember Me)

#### APPLICATION STRUCTURE

###### CORE FILES:
* .htaccess - routes all incoming requests to index.php file - application entry point
* index.php -  application entry point. Calls the router class to route requests, autoloads all classes, starts the session, and enables the auto-login from cookie functionality.

###### CORE FOLDERS:
* App \- stores all the logic of the eshop application. Complies with MVC architectural pattern, all code is separated into controller, model and view folders.
    * Also includes: access control files (JSON), used to set access permissions for website content (acl.json) and admin area (admin_acl.json). 
    * Also includes: settings folder, storing updatable site settings (JSON files).
* Config \- stores app configuration files.
    * config.php \- sets general application configurations, i.e. environment (debug or production),  default controller, action and page layout for admin area and frontend, session and cookie names,  file upload paths, site title, currency, tax rate etc
    * db_config.php \- sets database credentials configurations.
    * display_config.php \- sets configurations for the site logo and landing page slider.
* Core \- stores all the logic for the framework part. Consists of core classes controlling the framework workflow. For details, see the \"CORE FRAMEWORK CLASSES\" part below.
* Assets \-  stores all css, js and fonts files.
* Images \-  stores all project images.

###### CORE FRAMEWORK CLASSES

* Application Class \- sets error reporting and unregisters the global variables. 
* Router Class \- routes incoming requests, loads controllers and calls controllers action methods which render views and retrieve all data required by the views.
* DB Class \- instantiates database connection using credentials set in db_config file. Uses PDO connection to MYSQL database. Uses SINGLETON pattern for returning database connection instance. Defines all methods for database operations. 
* Model Class \- extends the DB Class methods. Defines data retrieving, inserting and updating methods for specific model classes and additional helpers methods. All custom model classes must extend the core model class and use its methods for database operations instead of using the DB class directly.
* Controller Class \- provides basis for all custom controllers operations:  dynamically sets the correct controller and action (based on the routed request), defines logic the for loading model classes, instantiates view  and input classes. Every custom controller class must extend the core controller class and call its constructor method as parent constructor. 
* View Class \- defines methods used in creating views, including partial files into the views and rendering views from controllers.
* Session Class \- defines methods for setting, getting and deleting sessions. Provides additional methods for setting flash session messages.
* Cookie Class \- defined methods for setting, getting and deleting cookies.
* Input Class \- used to handle http requests. Defines methods for extracting and sanitizing request data from $_POST, $_GET and $_FILES superglobals.
* Cart Class \- handles shopping cart functionality.  Defines methods for saving and updating users shopping cart. Shopping cart data is saved in sessions.
* Uploader Class \- handles file uploads. Defines methods for uploading, replacing and deleting files to/from specified folder.
* FM Class \- form helper class. Defines methods for dynamically creating form fields (html) and displaying form errors. Sets and checks CSRF tokens for cross site request forgery protection.
* Helpers Class \- defines various helper methods.
* MenuHelpers Class \- creates html code for displaying frontend menus based on projects content created by admin user, i.e. gets dynamic categories, footer menu pages etc.
* Validator Classes (stored in validators folder) \- all data validation classes. Includes a main abstract CustomValidator Class and multiple specific validator classes. The CustomValidator Class sets the general validation logic inherited by all specific validator classes. Each additional validator class extends the CustomValidator class and must implement the runValidation() method, which defines the validation  logic for this specific validator. More specific data for performing validation can be found in comments of validation classes.

#### INSTALLATION

* Download/Clone the project.
* Create the database and import the provided *database.sql* file into it. This will create all tables and provide the default project data. Remove *database.sql* file from your project folder.
* Set the database connection credentials in db_config file (config folder).
* Set the ROOT constant in the config.php file to the root folder of your project and the PROOT (project root) constant to \" / \". 
* Use the config files in config folder to customize all other project settings as needed.

#### USAGE

###### ESHOP APPLICATION

* The frontend website comes ready by default. All application data can be managed from the admin panel.
* To login into the admin panel, create a new user with SuperAdmin role inside the databases administrators table 

###### FRAMEWORK

* New models, controllers and views can be added into the corresponding folders of the APP folder as needed.
* Each new controller class must extend the core controller class, call the parent class constructor method and load the model classes used by that controller. It can also set the layout for the views displayed by the controller methods. 
* Each new model class must extend the core model class, set the table name in models constructor method, and call the parent class constructor method passing table name as argument. It must also set the database tables column names as protected $dbColumns property (as an array).

#### TECHNOLOGIES, PLUGINS AND FRAMEWOKS USED:
* Object Oriented PHP
* MYSQL Database
* PDO 
* Javascript
* jQuery
* AJAX
* Bootstrap 4
* Bootstrap Theme [Bootswatch Lux](https://bootswatch.com/lux/) 
* Icon Fonts [Uxwing](https://uxwing.com/free-icon-fonts/)
* Icon Fonts [Font Awesome](https://fontawesome.com/)
* jQuery Plugin [Slick Slider](https://kenwheeler.github.io/slick/) 
* jQuery Plugin [JQUERY.ZOOM](http://www.jacklmoore.com/zoom) 
* WYSIWYG Editor [Summernote](https://summernote.org/)
* Plugin for Notifications [Toastr](https://github.com/CodeSeven/toastr)

#### ATTRIBUTION
The framework part of the project is based on Youtube video series *PHP MVC Framework by Curtis Parham.*  Some parts are modified.

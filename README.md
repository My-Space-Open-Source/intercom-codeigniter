# intercom-codeigniter
CodeIgniter Library for integration with Intercom.IO REST APIs.

We have developed the library function to bring all the required functionality of REST APIs mentioned on the following link :
https://developers.intercom.io/reference

## Prequists
This library is based on basic principal of Getters and setters. There are following prequists for this Library :
1. [CodeIgniter framework](https://www.codeigniter.com/download)
2. PHP with CURL extension
3. Intercom's API KEY (We recomend **Full Access API key** to make full use of the given library)

## Basic Setup
1. Please define following two constants at **config/constants.php**
	* INTERCOM_APPID -- This must be resolved to APPID that you have received at your intercom account
	* INTERCOM_KEY -- This will enable to you to access intercom REST API. You must gererate API key at API Keys page on Intercom, accessible from your Integration settings. For more details follow the link specified above.
2. Put the Intercom.php at **application/libraries**
3. Load library in your controller and call the provided methods below to use as per your need.
```php
$this->load->library('intercom');
```

Although it is developed intentionally for CodeIgniter framework but it can be used with any framework of PHP and even works even with Core PHP. If you are using it without CodeIgniter then you must comment / modify the following sections of the Code :
define BASEPATH constant somewhere before including this code
All calls to log_message function 

## At Present follwing methods are available:

### User Feature:

**getUsers** - This is used to fetch paginated list of users from Intercom App.

**getUser** - This is used to fetch specified user from Intercom App based on one of the parameter (id,email,user_id)

**setUser** - This is used to create/uopdate user at Intercom App

### Companies Feature:

**getCompanies** - This is used to fetch paginated list of companies from Intercom App.

**setCompany** - This is used to create/uopdate company at Intercom App.

### Tags Feature:

**getTags** - This is used to fetch paginated list of companies from Intercom App.

**setTag** - This is used to create/uopdate tag at Intercom App.

**removeTag** - This is used to delete specified tag from Intercom App.

## Example
```php
$parameters=["page"=>1];
$users=$this->intercom->getUsers($parameters);
print_r($users);
```

You can [Visit Us](http://my-space.co.in) at our site. we would love to hear from you.
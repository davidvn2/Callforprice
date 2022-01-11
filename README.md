Magento 2: Working with Callforprice
1. Description


2. How to install

-Install via composer (recommend)
Run the following command in Magento 2 root folder:

composer require v2agency/callforprice
php bin/magento setup:upgrade
php bin/magento setup:static-content:deploy
php bin/magento cache:clean


-Install ready-to-paste package
Download package from callforprice.zip
Unzip it
Upload it to your magento root ( package/app >> magento_root/app )
Run the following command in Magento 2 root folder:
php bin/magento setup:upgrade
php bin/magento setup:static-content:deploy
php bin/magento cache:clean
Logout and Login again to avoid "Access denied" 404 error in system configuration.

# Opencart-SSO

##############################################################################

INSTALLATION INFORMATION(STEP) FOR OPENCART MODULE

##############################################################################

Manual Installation:

1) Unzip the main module directory.

2) Select preferred version of Opencart SSO module according to your Opencart version.
    - OpenCart_2.0.x.x-to-2.1.x.x folder for Opencart Version 2.0.x.x to 2.1.x.x
    - OpenCart_2.2.x.x folder for Opencart Version 2.2.x.x
    - OpenCart_2.3.x.x folder for Opencart Version 2.3.x.x

3) Upload both admin and catalog directories into your Opencart's root directory.

4) After uploading directories, go to your browser and run Opencart and login to admin side.

5) Go to Users->User Groups and edit desired group(specially admin) and then give access and modify permission to all the uploaded files.

6) Now install module by heading towards Admin->Extension->Modules (Admin->Extension->Extensions->Modules for Opencart 2.3.x.x and upper).


Key Points:

1. You need to create an app under the Opencart SSO module and get the client_id and secret. Redirect url will be the url where you want to receive the apptoken.

2. For getting the customer information, you need to hit the url:
Opencart Site URL /index.php?route=account/wkocuvdssologin&client_id=place app clinet id here &redirect_url= place app redirect_url here.

3. After successfull login with the previous link, authorize the information access and after authorization you will be redirected to the specified redirect_url. Receive the app token here in the get request.

4. Now call the url: Opencart Site URL /index.php?route=account/wkocuvdssologin/getJWTToken with the post parameter apptoken.

5. You will get the jwt_token encoded with the clinet secret using the jwt library.Use client secret to decode the the data.  


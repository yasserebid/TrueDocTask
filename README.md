# TrueDocTask

1 - Clone the repo

2 - composer install

3 - create .env file :

 - setup database confiuration

 - make QUEUE_CONNECTION=database

 - add MAIL_TO_ADDRESS:any mail you want . This will be the mail that you recieve the result mail on. (Important)

 or you can use your mailtrap account for recieving email.

4 - run php artisan migrate

5 - go to  /import-patients route

6 - upload your xlsx file

7 - then if you on local server run  php artisan queue:listen --timeout=0

else if you already on production you should have a supervisor to run background queue


8 - Testing class is in  test/Feature/ValidationTest.php

9 - You can change the values of the row for testing

10 - To run testing unit on validation 

       .\vendor\bin\phpunit --filter testRowValidation


Thank you

# TrueDocTask

Clone the repo

composer install

create .env file :
 1 - setup database confiuration
 2 - add MAIL_TO_ADDRESS:any mail you want . This will be the mail that you recieve the result mail on. (Important)
     or you can use your mailtrap account for recieving email.

run php artisan migrate

go to  /import-patients route

upload your xlsx file

then if you on local server run  php artisan queue:listen --timeout=0

else if you already on production you should have a supervisor to run background queue


Testing class is in  test/Feature/ValidationTest.php
You can change the values of the row for testing
To run testing unit on validation 
run .\vendor\bin\phpunit --filter testRowValidation


Thank you

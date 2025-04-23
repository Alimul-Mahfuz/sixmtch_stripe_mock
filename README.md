

# Subscription Managment with mock Stripe



In the app user can subscribe three types of subscripton one is single purchage with life time validity. Other two is auto renewable, this auto renewable plan have grace period. Within this period users can cancel this subscription and get full refund. After this period user will not get any refund. The package is renewable after on perior to expires. Renewable subscription is not refundable.

## How to setup the project
##### 1. Clone the git hub repository
##### 2.  Make a .env file and copy the following file in it.
```  APP_NAME=Laravel  
APP_ENV=local  
APP_KEY=base64:xdoYpzuIOW5boM8EkylOOKkrp6G11EmH4i/2U73q1OY=  
APP_DEBUG=true  
APP_URL=http://localhost  
  
APP_LOCALE=en  
APP_FALLBACK_LOCALE=en  
APP_FAKER_LOCALE=en_US  
  
APP_MAINTENANCE_DRIVER=file  
# APP_MAINTENANCE_STORE=database  
  
PHP_CLI_SERVER_WORKERS=4  
  
BCRYPT_ROUNDS=12  
  
LOG_CHANNEL=stack  
LOG_STACK=single  
LOG_DEPRECATIONS_CHANNEL=null  
LOG_LEVEL=debug  
  
DB_CONNECTION=sqlite  
# DB_HOST=127.0.0.1  
# DB_PORT=3306  
# DB_DATABASE=laravel  
# DB_USERNAME=root  
# DB_PASSWORD=  
  
SESSION_DRIVER=database  
SESSION_LIFETIME=120  
SESSION_ENCRYPT=false  
SESSION_PATH=/  
SESSION_DOMAIN=null  
  
BROADCAST_CONNECTION=log  
FILESYSTEM_DISK=local  
QUEUE_CONNECTION=database  
  
CACHE_STORE=database  
# CACHE_PREFIX=  
  
MEMCACHED_HOST=127.0.0.1  
  
REDIS_CLIENT=phpredis  
REDIS_HOST=127.0.0.1  
REDIS_PASSWORD=null  
REDIS_PORT=6379  
  
MAIL_MAILER=log  
MAIL_SCHEME=null  
MAIL_HOST=127.0.0.1  
MAIL_PORT=2525  
MAIL_USERNAME=null  
MAIL_PASSWORD=null  
MAIL_FROM_ADDRESS="hello@example.com"  
MAIL_FROM_NAME="${APP_NAME}"  
  
AWS_ACCESS_KEY_ID=  
AWS_SECRET_ACCESS_KEY=  
AWS_DEFAULT_REGION=us-east-1  
AWS_BUCKET=  
AWS_USE_PATH_STYLE_ENDPOINT=false  
  
VITE_APP_NAME="${APP_NAME}"  
  
STRIPE_KEY="dierei4543234323432"
```
##### 4. Run
```
composer update
```

##### 5. Create a file database.sqlite under in the database folder.
##### 4. Run following command
```
php artisan migrate 
php artisan db:seed
php artisan optimize:clear
```
This will create the database table and fill the table with seeded data.
##### 5.  Now login to the system using Email: testuser1@gmail.com and Password: Password.
##### 6. Now subscribe to any plan.

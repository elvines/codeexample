Hello.

Here's what you need to know:
1. I can't use my live project examples as some of them are outdated or protected by NDA

2. This code example is artificial and does not have much complexity problems it can solve.
Because of this some things might be out of context and there are comments on this.
On other hand it can show what kind of code style I have, basic structure, a bit of database skills 
and unit testing. These are the most important things I believe every programmer should have.

3. I didn't like default laravel response() method so i've decided to rewrite 
it into some kind of response builder to provide more flexibility (html/json/possibly xml in future). 

4. Nginx and php-fpm files are lying in distr directory, copy them where they should be
5. Change root path in sites-enabled/codeexample.conf to your desired
6. In php pool.d conf change:
    1. User and group to your folder owner
    2. Owner and group to your folder owner
    3. Prefix to where the project lies if it's not /home/work/codeexample
    4. Access log, slow log and error log to where you want them to be.
    5. Path to socket
7. If it's too hard you can always run
    sudo service nginx stop
    sudo ./artisan serv --port=80
8. Edit /etc/hosts to provide some website url, in my case i've used http://codeexample.local
9. Edit .env
    1. Change DB_DATABASE
    2. Change DB_USERNAME
    3. Change DB_PASSWORD
10. Edit .env.testing (mostly db settings for testing environment). Notice it shouldn't be in git, serves only as an example
    1. Change DB_DATABASE
    2. Change DB_USERNAME
    3. Change DB_PASSWORD    
11. Create both databases for .env and .env.testing
12. Run ./artisan migrate --seed. This will fill up the database with dummy test data using .env environment. 
.env.testing environment is migrated and seeded automatically on tests usage, 
but it's possible to seed it using ./artisan migrate --seed --env=testing
 
13. check ./artisan routes:list to get full details of where to find a required route and method to use it.
14. Run tests using ./vendor/phpunit/phpunit/phpunit | Too much phpunit is never too much i guess.
15. Check the code under app/Models/Customer, app/Http/Controllers/Api/Customer, database/factories and database/seeds
16. Check tests under ./tests/Feature/ and ./tests/Unit


17. Route json request examples:
    1. api/customer/order/store/basedOnSubscription / {"order":{"customer_id":6,"total":60}}
    2. api/customer/subscription/update/dayIteration / {"subscription":{"id":1,"day_iteration":60}}
    3. api/customer/subscription/update/nextOrderDate / {"subscription":{"id":1}}
    
18. I guess that's it. Thank you for your time and I'm waiting for the review if you would like. 

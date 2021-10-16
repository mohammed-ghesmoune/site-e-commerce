## Requirements
* docker and docker-compose installed

## Installing & Setting up the application 
* ``` git clone https://github.com/mohammed-ghesmoune/site-e-commerce.git ```
* ``` cd site-e-commerce ```
* ``` docker-compose up -d --build ```
* ``` docker exec -ti boutique_php composer install -n ```
* ``` cat boutique.sql | docker exec -i boutique_database /usr/bin/mysql -u root --password=root boutique ```

## Running the application 
 ``` docker exec -ti boutique_php symfony serve -d --allow-http --no-tls --port=8000 ```
 
## Test the application 

* Web App : ``` http://localhost:8080 ```
* Mail server : ``` http://localhost:1080 ```
* Database : ``` http://localhost:8888 ``` (```server = database , user = root , password = root```)

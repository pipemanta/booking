# Booking
Booking - Training site

### Installation
```
#first run of docker have to create network
    docker network create -d bridge backoffice_stack_network
    
#local run in docker
    docker-compose up -d

# after complete working, shut down docker
    docker-compose down

#first time create db and user
    docker-compose exec db bash /tmp/provision-db.sh

#import database
    docker-compose exec -T db mysql -uroot -psecret booking_db < booking_db.sql
```

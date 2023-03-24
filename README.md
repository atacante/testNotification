docker-compose up

docker exec -it <container_name> php artisan app:send-notification <phone> <email> <message>

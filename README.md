# NotAdSpy

---

## Application for tracking ads prices changes
Built with:
- Laravel
- InertiaJs
- Mysql
- MailPit
- Horizon
- Sail

What user can do with this app:
- make subscriptions on price\'s changes. 
  - just add url of advert and save - all done
- receive mail notifications on price\'s changes
  - each time price changes user will receive mail to provided email during registration
  - email must be verified
- pause subscriptions
  - users can disable subscription without deleting it to stop notifications
- remove subscriptions
  - or completely remove it if subscription is unnecessary

## Installation

```shell
    git clone git@github.com:kimiriecs/noadspy.git
```

```shell
    cd adspy
```

## Automatically

```shell
    chmod +x ./install.sh && ./install.sh
```

## Manually

```shell
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        laravelsail/php84-composer:latest \
        composer install --ignore-platform-reqs
```

```shell
    cp .env.example .env && \
        sed -i 's/^APP_DEBUG=.*/APP_DEBUG=true/' .env && \
        sed -i 's/^DB_DATABASE=.*/DB_DATABASE=spy/' .env
```

```shell
    cp .env.example .env.testing && \
        sed -i 's/^APP_ENV=.*/APP_ENV=testing/' .env.testing && \
        sed -i 's/^APP_DEBUG=.*/APP_DEBUG=true/' .env && \
        sed -i 's/^DB_DATABASE=.*/DB_DATABASE=spy_testing/' .env.testing
```

```shell
     ./vendor/bin/sail up -d
```

```shell
     ./vendor/bin/sail artisan key:generate
```

#### !!! IMPORTANT: before executing next commands ensure that mysql service is running and healthy

```shell
     ./vendor/bin/sail artisan migrate
```

```shell
     ./vendor/bin/sail artisan db:seed
```

#### Install npm dependencies and build frontend

```shell
     ./vendor/bin/sail npm install
```

```shell
     ./vendor/bin/sail npm run build
```

## Run tests
```shell
    ./vendor/bin/sail test --env=testing
```

## Mails

For previewing mails in local environment use MailPit

### Tracking queues

For tracking queues of processing prices checks and sending mails in the project installed Laravel Horizon package

All queues will start automatically in the background via supervisor 

Use Makefile in the root project directory to manage supervisor

## Run price the tracking process

To run price the tracking process, there are two methods exist:

run artisan command manually:
```shell
    ./vendor/bin/sail artisan ad:price
```
or use scheduler to run the process periodically:
```shell   
    ./vendor/bin/sail artisan ad:price
```

Default cron schedule "30 * * * *" 

To overwrite this value, edit PRICE_TRACK_SCHEDULE variable in .env

## Hosts and ports

After running the app, these hosts are available in the browser:

#### App:
[https://localhost:20080](https://localhost:20080)

#### Horizon:
[https://localhost:20080/horizon](https://localhost:20080/horizon)

#### MailPit:
[https://localhost:28025](https://localhost:28025)

## Database

After running the app and executing a command 

```shell
    ./vendor/bin/sail artisan db:seed
```
in the database, three default users with subscriptions will be available
  - u1@test.com password
  - u2@test.com password
  - u3@test.com password

At this point, the app is ready to run scheduler or manually start price check process
All queues also must be running

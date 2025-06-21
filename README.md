# NotAdSpy

---
## Application for tracking ads prices changes
Built with:
- Laravel
- InertiaJs
- VueJs
- Mysql
- Redis
- MailPit
- Horizon
- Sail

What user can do with this app:
- make subscriptions on price\'s changes. 
  - just add url of advert and save - all done
- receive mail notifications on price\'s changes
  - each time price changes user will receive mail to email, provided during registration (email must be verified)
- pause subscriptions
  - users can disable subscription without deleting it to stop notifications
- remove subscriptions
  - users can completely remove subscription if it is unnecessary

---
## Installation
### Install a project automatically

```shell
    git clone git@github.com:kimiriecs/notadspy.git
```

```shell
    cd notadspy
```

```shell
    chmod +x ./install.sh && ./install.sh
```

### Install a project manually

```shell
    git clone git@github.com:kimiriecs/notadspy.git
```

```shell
    cd notadspy
```

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
        sed -i 's/^APP_DEBUG=.*/APP_DEBUG=true/' .env.testing && \
        sed -i 's/^DB_DATABASE=.*/DB_DATABASE=spy_testing/' .env.testing
```

```shell
     ./vendor/bin/sail up -d
```

```shell
     ./vendor/bin/sail artisan key:generate
```

#### !!! IMPORTANT: before executing the next two commands ensure that mysql service is running and healthy

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

---
## Run tests
```shell
    ./vendor/bin/sail test --env=testing
```

---
## Mails

For previewing mails or email verification in local environment use MailPit:

[https://localhost:28025](https://localhost:28025)

---
## Tracking queues

For tracking queues of processing prices checks and sending mails in the project installed Laravel Horizon package:

[https://localhost:20080/horizon](https://localhost:20080/horizon)

All queues will start automatically in the background via supervisor 

Use Makefile in the project's root directory to manage supervisor

---
## Run price the tracking process

To run price the tracking process, there are two methods exist:

run artisan command manually:
```shell
    ./vendor/bin/sail artisan ad:price
```
or use scheduler to run the process periodically:
```shell   
    ./vendor/bin/sail artisan schedule:work
```
to stop scheduler run:
```shell   
    ./vendor/bin/sail artisan schedule:interrupt
```

Default cron schedule "30 * * * *" 

To overwrite this value, edit PRICE_TRACK_SCHEDULE variable in .env

---

## Hosts and ports

For preventing conflicts with local ports all default ports for services were shifted by 20000.
For example, default port 80 became port 20080, port 8025 became port 28025, etc.

After running the app, these hosts are available in the browser:

#### App:
[https://localhost:20080](https://localhost:20080)

#### Horizon:
[https://localhost:20080/horizon](https://localhost:20080/horizon)

#### MailPit:
[https://localhost:28025](https://localhost:28025)

---

## Database

After running the app and executing a command 

```shell
    ./vendor/bin/sail artisan db:seed
```
in the database three default users with subscriptions will be available
  - u1@test.com password
  - u2@test.com password
  - u3@test.com password

### !!!IMPORTANT:
During execution of command `./vendor/bin/sail artisan db:seed` the command `./vendor/bin/sail artisan migrate:fresh` executed inside seeder.

So after each `./vendor/bin/sail artisan db:seed` command execution database will be in initial state.

---
At this point app is running [https://localhost:20080](https://localhost:20080) and ready to run scheduler or manual start of price's check process.
All queues also must be running.

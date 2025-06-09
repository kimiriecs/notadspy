.PHONY:  supervisor-status start-queues stop-queues start-queue stop-queue restart-queue run-price-check run-schedule stop-schedule schedule-instances

supervisor-status:
	./vendor/bin/sail exec app supervisorctl status

start-queues:
	./vendor/bin/sail exec app supervisorctl start spy-queues:*

stop-queues:
	./vendor/bin/sail exec app supervisorctl stop spy-queues:*

restart-queues:
	./vendor/bin/sail exec app supervisorctl restart spy-queues:*

start-queue:
	./vendor/bin/sail exec app supervisorctl start $(NAME)

stop-queue:
	./vendor/bin/sail exec app supervisorctl stop $(NAME)

restart-queue:
	./vendor/bin/sail exec app supervisorctl restart $(NAME)

run-price-check:
	./vendor/bin/sail artisan ad:price

#### Scheduler
run-schedule:
	./vendor/bin/sail artisan schedule:work

stop-schedule:
	./vendor/bin/sail exec app pkill -f schedule:work

schedule-instances:
	./vendor/bin/sail exec app pgrep -fl schedule:work

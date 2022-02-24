#!/bin/bash

# Starting cron service.
service cron start

exec "$@"

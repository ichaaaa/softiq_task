#!/bin/bash
while getopts v: flag; do case "${flag}" in v) php artisan show_redis_keys; exit; esac done; php artisan export $1;
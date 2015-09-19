#Insurance

Insurance is a general-purpose backup tool written in PHP. Originally designed for backup of WordPress sites to
Amazon S3, this tool is designed specifically to back up any file system you want (provided you give it the correct
paths to do so).

Insurance is designed to be run on an hourly cron, and will back up a maximum of once per day, depending on the day
you specify.

##Usage
Insurance only requires that you run a single file as the cron, and it will take care of the rest. That file is
bin/backupRunner. This file will automatically determine, based on your settings, which backup to run, and whether or
not it is the correct time to run the backup.

You can install this in your crontab with the following:

~~~
0 * * * * php /your/full/path/to/insurance/bin/backupRunner > /dev/null 2>&1
~~~

##Configuration
The configuration of Insurance is handled by copying the config.php-init file to config.php in the Insurance root
directory.

In this file, you must set the file names or paths you wish to back up (Insurance will seek files recursively), and
you can also specify certain files to exclude (e.g. the wp-content/cache directory should always be excluded).

For database settings, Insurance currently only works with MySQL. You must specify all the elements in order to export
your MySQL database.

You'll also need to specify your S3 credentials. Currently there is no option for uploading to a different service, or
for leaving the backup on your local disk.

Finally, you can specify the day and time of the backup. The system uses the default PHP days of the week (0 for Sunday,
6 for Saturday, 3 for Wednesday, etc). Specify the date and time of each backup.

The backup rules section determines how many of each type of backup will be retained. It's recommended to keep 10 days
of database-only backups, and five weeks of full filesystem backups.

##Questions?

Feel free to reach out via email or file an issue!
#!/bin/bash

# If you're not sure what value a variable should have, please leave it blank.
#
# Anything wrapped in {} is set during the init.sh script

production_database=
production_username=
production_password=''
# ssh user and server, or blank (e.g. remoteuser@remoteserver)
production_ssh=
production_ssh_port=

staging_database=
staging_username=$production_username
staging_password=$production_password
# ssh user and server, or blank (e.g. remoteuser@remoteserver)
staging_ssh=
staging_ssh_port=

local_database={db_dev}
local_username=root
local_password=

#leave this empty to use the default, otherwise "local", "staging" or "production"
remote_env=

sql_dir=`dirname $0`/../sql

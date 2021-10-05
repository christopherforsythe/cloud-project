FROM ubuntu:latest
MAINTAINER Chris Forsythe

# Add crontab file in the cron directory
ADD crontab /etc/cron.d/hello-cron

# Give execution rights on the cron job
RUN chmod 755 /etc/cron.d/hello-cron

# Create the log file to be able to run tail
RUN touch /var/log/cron.log

#Install Cron
RUN apt-get update
RUN apt-get -y install cron

#Install Curl
RUN apt-get update
RUN apt-get -y install curl


# Run the command on container startup
CMD cron && tail -f /var/log/cron.log

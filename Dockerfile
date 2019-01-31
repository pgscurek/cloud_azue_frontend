# Initial attempt at creating a base rhel7 image.

# The following line Pulls the rhel image from the red hat registry
FROM registry.access.redhat.com/rhel7

# Add labels to image for documentation.
LABEL MAINTAINER="Pete Scurek" description="Base rhel 7.latest image"

# Set user that this image will run container as
USER root 

# Add network utilities and webserver to image 
RUN yum update && yum -y install apr-util apr lgtoadpt net-tools httpd 

# Copy Webserver contents to image.
RUN mkdir -p /var/www/html/cloud_frontend
COPY ./cloud_frontend /var/www/html/
EXPOSE 80
EXPOSE 8080
EXPOSE 443 

# Configure and Start Apache
RUN /bin/bash -c 'echo "ServerName localhost" >>/etc/httpd/conf/httpd.conf'
RUN /bin/bash -c 'echo "OPTIONS=-DFOREGROUND" >>/etc/sysconfig/httpd'
CMD  /sbin/apachectl

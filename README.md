# DEPLOYMENT

Deploying any project to a server can be a complex endeavor, with potential unforeseen challenges. Aspects such as security, speed, and scalability demand careful consideration to avoid disrupting running projects. Therefore, thorough preparation and post-deployment checks are essential.

## Deployment Overview

This section provides straightforward deployment methods for various operating systems using different services. While most services offer Ubuntu as the default operating system, you have the flexibility to choose. This guide primarily focuses on Ubuntu.

We recommend utilizing [AWS (Amazon Web Services)](https://aws.amazon.com/) due to its rich feature set, user-friendliness, and responsive support staff. AWS even offers a one-year free trial. While this guide leans toward AWS, you can adapt it for other services as needed.

Once you've chosen a service, you'll have a server (OS) to host your project. Begin by installing PHP on it. If you're familiar with [Docker](https://www.docker.com/), you can create a container containing PHP and all required dependencies. Future sections will explore Docker further. For now, let's focus on running your project directly on the server.

Always ensure you use the latest versions of the OS and PHP. Refer to [Laravel's documentation on Deployment](https://laravel.com/docs/10.x/deployment) for Laravel-specific deployment details.

## Getting Started

1. **PHP Installation**: If you're using Ubuntu or a similar OS, you can easily install PHP using the commands provided in [this tutorial](https://www.digitalocean.com/community/tutorials/how-to-install-php-8-1-and-set-up-a-local-development-environment-on-ubuntu-22-04), which also covers Composer installation. Depending on your project's requirements, you may need to install additional PHP extensions. For Windows-based servers, consult [this guide](https://linuxhint.com/install-php-ec2-windows-aws/#:~:text=Installing%20PHP%20on%20an%20EC2,%E2%80%9CPath%E2%80%9D%20of%20environment%20variables.) for PHP setup.

2. **Web Server Setup**: To serve your PHP code to the world, you'll need a web server capable of running PHP. Two commonly used options are `apache2` and `nginx`. Follow [this guide](https://www.digitalocean.com/community/tutorials/how-to-install-the-apache-web-server-on-ubuntu-20-04) for Apache2 or [this guide](https://www.digitalocean.com/community/tutorials/how-to-install-nginx-on-ubuntu-20-04) for Nginx setup. Both guides lead you to a folder where you can place your PHP code, accessible via the server's IP address or linked domain.

3. **Project Deployment**: Clone your Laravel project from GitHub into the publicly available folder on your server. Don't forget to install all dependencies with Composer and create an `.env` file on your server. If everything is configured correctly, you should access your API via the server's IP ADDRESS. However, it won't work until you establish a database connection.

4. **Database Configuration**: You can either install MySQL directly on your server or use an external database server. Services like AWS and GCP offer MySQL databases (e.g., [RDS](https://aws.amazon.com/rds/)) for seamless integration with your main server. Once your database server is set up, note down the host, username, and password to use in your project's `.env` file.

5. **MySQL Installation**: If you opt to install MySQL on your server directly, consult [this guide](https://www.digitalocean.com/community/tutorials/how-to-install-mysql-on-ubuntu-20-04). Here, you can set up your MySQL username and password, with the host as "localhost." After configuring your `.env` file with the database details, run migrations and seeders to initialize your tables and populate them with dummy data. You can also run your tests.

6. **Scheduler and Queue Setup**: To handle background processes, set up the scheduler. For Windows, follow [this guide](https://blog.codehunger.in/cron-job-in-laravel-8-setting-up-cron-in-windows-pc/), and for Ubuntu, use [this guide](https://www.itsolutionstuff.com/post/laravel-8-cron-job-task-scheduling-tutorialexample.html). Typically, you need to add a scheduled task like this:

   ```
   * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
   ```

7. **Queue Configuration**: Setting up the queue on Ubuntu is detailed in [this guide](https://dev.to/techparida/how-to-set-up-laravel-queues-on-production-4one). For Windows, you can refer to [this discussion](https://laracasts.com/discuss/channels/general-discussion/best-way-to-use-queues-on-a-windows-server).

8. **Completion**: At this point, your Laravel project is deployed with background processes. Additional steps may be necessary depending on your specific use case and choice of services.

9. **Continuous Improvement**: Keep in mind that the deployment process varies for each case and may encounter unexpected issues. Stay connected with the online community to find optimal solutions. Deployment practices evolve, becoming increasingly automated, so explore better options over time.

## Additional Notes

- In future branches, we will delve deeper into deployment and automation, exploring topics such as [CI/CD](https://www.synopsys.com/glossary/what-is-cicd.html#:~:text=CI%20and%20CD%20stand%20for,are%20made%20frequently%20and%20reliably.) and [DevOps](https://aws.amazon.com/devops/what-is-devops/#:~:text=DevOps%20is%20the%20combination%20of,development%20and%20infrastructure%20management%20processes.). For now, this serves as a fundamental deployment guide.
- Engage in in-depth discussions with fellow developers by initiating new [discussions](https://github.com/mazimez/laravel-hands-on/discussions).
- Simplify interactions with developed APIs by utilizing our [Postman collection](https://elements.getpostman.com/redirect?entityId=13692349-4c7deece-f174-43a3-adfa-95e6cf36792b&entityType=collection).

## Additional Resources

1. [Laravel Documentation on Deployment](https://laravel.com/docs/10.x/deployment)
2. [How to Deploy Laravel Application on AWS EC2 the Right Way](https://www.clickittech.com/tutorial/deploy-laravel-on-aws-ec2/)
3. [Deploying a Laravel Application to Elastic Beanstalk](https://docs.aws.amazon.com/elasticbeanstalk/latest/dg/php-laravel-tutorial.html)
4. [Beginner’s Guide to Deploying PHP Laravel on the Google Cloud Platform](https://www.codemag.com/Article/2111071/Beginner%E2%80%99s-Guide-to-Deploying-PHP-Laravel-on-the-Google-Cloud-Platform

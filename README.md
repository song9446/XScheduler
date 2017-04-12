# 1. Discription
This is helping scheduling service application.

# 2. Get the repository
`git clone https://github.com/song9446/XScheduler`

# 3. In the repository
Before commit, please pull the last version of branch and try to build it.
1) git pull
2) ***edit what you want***
3) ***build and test***
4) git add edit-files-path  ( or just git add * )
5) git commit -m "comment"
6) git push

# 4. Dependency
Whatever static http server support php with mysqli is ok.

anyway I use php-mysql and php built-in server.

`php -S 0.0.0.0:80 -t docs`

# 5. Build
It doesn't need to compile or build.

just serve `docs` directory as root directory

# 6. Database server
It uses database server as AWS RDS(mysql) at 

`xscheduler.c4l3nt5dolim.ap-northeast-2.rds.amazonaws.com:3306`

you can connect with mysql cli client via

`mysql -u root -p -h xscheduler.c4l3nt5dolim.ap-northeast-2.rds.amazonaws.com`

# 7. Host
The application is served in host server(AWS EC2) at

`52.78.81.68`

At the server, It automatically pulls and serves the most recent master branch commit.

So after you update the master branch, you just wait 5 to 10 seconds and then you can check it's working state in `http://52.78.81.68`

# 8. Authors
Song, Eunchul

Dongju Sin

Jason Kim



this page is written by Song, eunchul

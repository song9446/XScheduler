# 1. Get the repository
`git clone https://github.com/song9446/XScheduler`

# 2. In the repository
Before commit, please pull the last version of branch and try to build it.
1) git pull
2) ***edit what you want***
3) ***build and test***
4) git add edit-files-path  ( or just git add * )
5) git commit -m "comment"
6) git push

# 3. Dependency
Whatever static http server support php with mysql is ok.
anyway I use php-mysql and php built in server.
`php -S 0.0.0.0:80 -t docs`

# 4. Build
It doesn't need to compile or build.
just serve `docs` directory as root directory

# 5. Database server
It uses database server as AWS RDS(mysql) at 
`xscheduler.c4l3nt5dolim.ap-northeast-2.rds.amazonaws.com:3306`

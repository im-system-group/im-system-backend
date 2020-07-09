# IM-system backend

## Preparation

* Change `.env.example` following variable to your DB setting
  * `DB_USERNAME` 
     > notice: if you use docker to build, this variable **must not be root**
  * `DB_PASSWORD`
  
* execute `cp .env.example .env`  
  
> If you use docker to Build <br>
  * Highly recommended change `docker-compose.yml` **MYSQL_ROOT_PASSWORD** to your password for security

  


**Build with docker**
- `docker-compose up -d`

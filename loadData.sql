
USE BasketballStatistics;

LOAD DATA LOCAL INFILE '/users/jaketherrien/downloads/2015-2016.nba.stats.csv' 
INTO TABLE Player_Data 
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 2 ROWS;




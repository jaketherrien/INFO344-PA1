
USE BasketballStatistics;

CREATE TABLE Player_Data_Final (
	firstName varchar(50),
    lastName varchar(50),
    teamName varchar(3),
    gamesPlayed int,
    minutes decimal(4,2),
    fgMade decimal(5,2),
    fgAttempt decimal(5,2),
    fgPercent decimal(4,2),
    threePtMade decimal(5,2),
	threePtAttempt decimal(5,2),
	threePtPercent decimal(5,2),
    freeThrowMade decimal(5,2),
    freeThrowAttempt decimal(5,2),
    freeThrowPercent decimal(5,2),
    reboundOff decimal(5,2),
    reboundDef decimal(5,2),
    reboundTot decimal(5,2),
    assist decimal(5,2),
    turnover decimal(5,2),
    steal decimal(5,2),
    blocks decimal(5,2),
    personalFouls decimal(5,2),
    pointsPerGame decimal(5,2)
)

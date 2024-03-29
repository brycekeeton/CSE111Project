----==== DROP TABLES SO YOU CAN ADD THEM AGAIN ====----

DROP TABLE Users;
DROP TABLE Recommendation;
DROP TABLE Review;
DROP TABLE vgData;
DROP TABLE Gameplay;
DROP TABLE Pictures;
DROP TABLE Recommend_User;
DROP TABLE User_Review;

----==== ADD TABLES TO THE DATABASE ====----

CREATE TABLE Users ( -- User Table
    u_username varchar(255),
    u_password varchar (255),
    u_type varchar(255)
);

CREATE TABLE Recommendation ( -- Recommendation Table
    rc_recID int,
    rc_gameID int,
    rc_status varchar(255),
    rc_comments varchar(255)
);

CREATE TABLE Review ( -- Review Tables
    r_reviewID int,
    r_gameID int,
    r_rating int,
    r_date date,
    r_comments varchar(255)
);

CREATE TABLE vgData ( -- VideoGames Database Table
    g_gameID int,
    g_name varchar(255),
    g_developer varchar (255),
    g_platform varchar(255),
    g_genre varchar(255),
    g_rating int,
    g_releasedate date
);

CREATE TABLE Gameplay ( -- Gamplay Table
    gp_gameID int,
    gp_id int,
    gp_username varchar (255),
    gp_comments varchar(255)
);

CREATE TABLE Pictures ( -- Pictures Table
    p_gameID varchar(255),
    p_imageID int,
    p_username varchar(255),
    p_comments varchar(255)
);

CREATE TABLE Recommend_User ( -- Many to Many Table (Recommendation to users from other users)
    ru_username varchar(255),
    ru_recID int
);

CREATE TABLE User_Review ( -- Many to Many (Group Reviews from people to other users)
    ur_username varchar(255),
    ur_reviewID int
);

----==== INSERT THE DATA INTO THE TABLES ====----

-- Admin type users have the ability to remove games and reviews from the database, while Member type users do not
INSERT INTO Users (u_username, u_password, u_type)
VALUES ("BoboCavern", "CSE111sux!", "Admin"),
("GRiMM", "iH8thisProj", "Admin"),
("CeeJay_FC", "AwesomePossum#", "Member"),
("JJuicy", "DatabaE>", "Member"),
("12345", "partyhearty", "Member"),
("Tashi", "Love4DBs", "Member"),
("Bris_Almighty", "Burt#1", "Member"),
("Teknically", "IamWrong123!", "Member");

INSERT INTO vgData (g_gameID, g_name, g_developer, g_platform, g_genre, g_rating, g_releasedate)
VALUES (1, "Grand Theft Auto V", "Rockstar", "PC, Xbox, Playstation", "RPG, Action, Adventure, Shooter", "Rating", "2013-09-17"),
(2, "Assasins Creed Odyssey", "Ubisoft", "Playstation, Xbox, Switch, Stadia, PC", "RPG, Open World, Action", "Rating", "2018-10-05"),
(3, "Skyrim", "Bethesda", "PC, Playstation, Xbox, Switch", "RPG, Action", "Rating", "2011-11-11"),
(4, "Fallout 4", "Bethesda", "PC, Xbox, Playstation", "RPG, Action", "Rating", "2015-11-10"),
(5, "Hollow Knight", "Team Cherry", "PC, Mac, Linux, Switch, Xbox, Playstation", "Action, Adventure, Platformer", "Rating", "2017-02-24"),
(6, "Minecraft", "Mojang Studios", "PC, Mac, Linux", "Sandbox, Survival", "rating", "2011-11-18"),
(7, "Overwatch", "Blizzard Entertainment", "PC, Playstation, Xbox, Switch", "FPS", "Rating", "2016-05-24"),
(8, "Witcher 3: Wild Hunt", "CD Projekt Red", "PC, Playstation, Xbox, Switch", "RPG", "Rating", "2015-05-19"),
(9, "Call of Duty: Modern Warfare", "Infinity Ward", "PC, Playstation, Xbox", "FPS", "Rating", "2019-10-25"),
(10, "Dark Souls", "Bandai Namco", "PlayStation, Xbox, Switch, PC", "RPG", "Rating", "2011-09-22"),
(11, "Halo MCC", "343 Industries", "Xbox, PC", "FPS", "Rating", "2014-11-11"),
(12, "Bioshock Infinite", "Irrational Games", "PC, Playstation, Xbox, Mac, Linux, Switch", "FPS", "Rating", "2013-03-26"),
(13, "Super Smash Bros Ultimate", "Bandai Namco", "Switch", "Fighting", "Rating", "2018-12-07"),
(14, "Legend of Zelda: Breathe of the Wild", "Nintendo", "Switch, Wii U", "Action, Adventure", "Rating", "2017-03-03"),
(15, "Pokemon: Shield", "Game Freak", "Switch", "RPG", "Rating", "2019-11-15"),
(16, "Fortnite", "Epic Games", "PC, Mac, Switch, Playstation, Xbox, iOS, Android", "Survival, Battle Royale, Sandbox", "Rating", "2017-07-21"),
(17, "Portal 2", "Valve", "PC, Mac, Linux, Playstation, Xbox", "Puzzle, Platform", "Rating", "2011-04-18"),
(18, "Super Mario Odyssey","Nintendo", "Switch", "Platform, Adventure", "Rating", "2017-10-27"),
(19, "Outer Wilds", "Mobius Digital", "PC, Xbox, Playstation", "Adventure", "Rating", "2019-05-28"),
(20, "The Last of Us", "Naughty Dog", "Playstation", "Survival, Horror, Action, Adventure", "Rating", "2013-06-14"),
(21, "Among Us", "Inner Sloth", "PC, iOS, Android", "Party", "Rating", "2018-06-05"),
(22, "The Forrest", "Endnight Games", "PC, Playstation","Survival, Horror", "Rating", "2014-05-14"),
(23, "Mortal Kombat 11", "NeatherRealm", "PC, Xbox, Playstation, Switch, Stadia", "Fighting", "Rating", "2019-04-19"),
(24, "Crash Bandicoot N. Sane Trilogy", "Vicarious Visions", "Playstation, Xbox, Switch, PC", "Platformer", "Rating", "2017-06-30"),
(25, "God of War", "SIE Santa Monica", "Playstation", "Action Adventure, Hack and Slash", "Rating",	"2018-04-20"),
(26, "Stardew Valley", "Concerned Ape", "Xbox, Playstation, PC, Mac, Linux, Switch, Vita, iOS, Andriod", "RPG, Simulation", "Rating", "2016-02-26"),
(27, "Rocket League", "Psyonix", "Xbox, Playstation, PC, Mac, Linux, Switch", "Sports", "Rating", "2015-07-07"),
(28, "Cuphead", "Studio MDHR", "PC, Mac, Xbox, Playstation, Switch", "Run and gun", "Rating", "2017-09-29"),
(29, "Counter Strike: Global Offensive", "Valve", "PC, Mac, Linux, Playstation, Xbox", "FPS", "Rating", "2012-08-21"),
(30, "Mass Effect 3", "BioWare", "PC, Xbox, Playstation, Wii U", "TPS, Role Playing", "Rating", "2012-03-06");

-- Reviews can be written by more than one User as per the multiple to multiple relationship specified in our Project 1
INSERT INTO Review (r_reviewID, r_gameID, r_rating, r_date, r_comments)
VALUES (1, 1, 5,  "2018-04-12", "Great game so much fun wow i am amazed"),
(2, 1, 4,  "2019-08-23", "Fun game but my only problem is the online too hard to make money"),
(3, 1, 5,  "2017-05-01", "I like to grief a lot of players"),
(4, 1, 3,  "2015-05-26", "good game graphics suck on my 1080 though"),
(5, 2, 4,  "2018-04-12", "Game is way too long but fun"),
(6, 3, 5,  "2014-10-18", "Dovakin #1"),
(7, 3, 5,  "2018-04-12", "So much replay ability amazing game"),
(8, 3, 5,  "2018-01-12", "How can you not like this game"),
(9, 4, 3,  "2019-07-04", "Could not get into the game"),
(10, 4, 5, "2017-09-11", "Fun game, love the story"),
(11, 5, 5,  "2019-12-11", "Great platformer game my favorite"),
(12, 6, 5,  "2012-05-19", "So much fun killing zombies"),
(13, 6, 5,  "2011-04-12", "Grief with all the TNT"),
(14, 6, 5,  "2013-05-11", "Best form of survival"),
(15, 6, 5,  "2018-04-12", "Got it because all my roommates have it, Fun"),
(16, 6, 5,  "2018-04-12", "Too dank"),
(17, 7, 5,  "2016-09-29", "Lots of fun when you play with roommates"),
(18, 7, 5,  "2016-05-29", "Fun game, worth the money"),
(19, 7, 4,  "2018-04-12", "Just here for all the hype"),
(20, 9, 5,  "2019-10-10", "Greatest COD in a while"),
(21, 10, 2,  "2018-04-12", "Trash Controls"),
(22, 11, 5,  "2018-04-12", "Holy Grail of Halo"),
(23, 12, 5,  "2018-04-12", "Loving the steam punk aesthetic"),
(24, 13, 3,  "2018-04-12", "The AI is way too hard"),
(25, 14, 5,  "2019-04-12", "Great adventure game"),
(26, 15, 4,  "2018-04-12", "Fun game but too easy"),
(27, 16, 5, "2017-09-11", "Where we dropping boys? Great game"),
(28, 17, 5, "2017-09-11", "Fun puzzle game, twist ending"),
(29, 18, 4, "2018-01-16", "Fun game, but too short of story, finished in 8 hours"),
(30, 19, 5, "2019-07-14", "Best adventure game I've ever played"),
(31, 20, 5, "2017-09-11", "Beautiful story, love the game"),
(32, 5, 4, "2017-06-22", "Throroughly enjoyable throughout"),
(33, 6, 5, "2012-07-01", "Classic!"),
(34, 10, 5, "2015-06-30", "Git gud"),
(35, 12, 2, "2014-10-04", "Liked the first game, but not a fan of this one"),
(36, 15, 1, "2020-05-21", "Don't bother with this one!");

-- More than one game can be recommended at a time, as per the multiple to multiple relationship specified in our Project 1
-- Status allows Users to classify their recommended games as unplayed, in progress, or finished
INSERT INTO Recommendation(rc_recID, rc_gameID, rc_status, rc_comments)
VALUES (1, 20, "Unplayed", "Hmm this looks interesting"), -- 1
(3, 19, "In Progress", "Kinda cool liking it so far"), -- 3
(4, 18, "In Progress", "This is hard, bro"), -- 4
(5, 18, "Unplayed", "Why did I get recommended this?"), -- 5
(7, 17, "In Progress", "Way cool!"), -- 7
(1, 16, "Unplayed", "Um pretty awesome looking ngl"), -- 1
(3, 15, "Unplayed", ""), -- 3
(5, 14, "Unplayed", ""), -- 5
(3, 13, "In Progress", "This is no fun! >:("), -- 3
(10, 10, "In Progress", "This is lots of fun! :-)"), -- 10
(9, 12, "Unplayed", ""), -- 9
(2, 11, "Unplayed", "Can't wait to check this out!"), -- 2
(4, 10, "In Progress", ""), -- 4
(6, 9, "In Progress", "Ehrm this is the best... Gotta play this more!"), -- 6
(9, 8, "In Progress", "I hate this"), -- 9
(7, 7, "Finished", "bro hype bro lol"), -- 7
(3, 6, "Unplayed", "Why have I not played this yet???"), -- 3
(9, 5, "Finished", ""), -- 9
(8, 4, "Unplayed", ""), -- 8
(2, 3, "Finished", "Dovakin #1"); -- 2

INSERT INTO Gameplay(gp_gameID, gp_id, gp_username, gp_comments)
VALUES (1, 1, "GRiMM", "Speed running the Repossession mission"),
(2, 2, "BoboCavern", "Trailer"),
(3, 3, "12345","Slaying Alduin"),
(4, 4, "12345", "Getting to Diamond City as soon as possible"),
(5, 5, "Teknically","Pale Ore Locations"),
(6, 6, "JJuicy","TNT in my friends house"),
(7, 7, "Tashi", "Unboxing loot boxes"),
(8, 8, "12345","Glitching for gold"),
(9, 9, "CeeJay_FC", "Quad Kill in Search and Destroy"),
(10, 10, "12345", "Watch me fall of of this cliff battling"),
(11, 11, "GRiMM", "Killtacular on Halo 3 Valhalla"),
(12, 12, "CeeJay_FC", "Elizabeth coming in clutch"),
(13, 13, "Tashi", "My tier list since Steve from Minecraft came"),
(14, 14, "Teknically", "Grinding for loot"),
(15, 15, "Bris_Almighty", "I hit level 100"),
(16, 16, "JJuicy", "Tilted tower takeover"),
(17, 17, "Bris_Almighty", "The Fall walkthrough"),
(18, 18, "GRiMM","Defeating Bowser"),
(19, 19, "BoboCavern","Launch Trailer"),
(20, 20, "JJuicy","Mini Golf Scene"),
(21, 21, "GRiMM", "Imposter gameplay"),
(22, 22, "BoboCavern", "Killing a whole tribe"),
(23, 23, "12345","Goro Trolling"),
(24, 24, "12345", "Platforms meant to kill you"),
(25, 25, "Teknically","End Scenes"),
(26, 26, "JJuicy", "Checking out my farm"),
(27, 27, "Tashi", "Scoring 2 points in 10 seconds"),
(28, 28, "12345", "Speedrunning"),
(29, 29, "CeeJay_FC", "Acing the 3rd round"),
(30, 30, "12345", "Destroying the ships");

INSERT INTO Pictures(p_gameID, p_imageID, p_username, p_comments)
VALUES (1, 1, "JJuicy", "Flying the jets"),
(2, 2, "CeeJay_FC", "Mines of the Great Trench"),
(3, 3, "GRiMM","Alduin's Wall"),
(4, 4, "CeeJay_FC", "Dogmeat chillin"),
(5, 5, "Tashi","Hollow Artwork"),
(6, 6, "12345","Creeper at the top of my roof"),
(7, 7, "GRiMM", "Tracer Artwork"),
(8, 8, "12345","Ciri"),
(9, 9, "JJuicy", "Bravo Six going dark"),
(10, 10, "Bris_Almighty", "The Catacombs"),
(11, 11, "12345", "Combat Evolved Graphics Comparison"),
(12, 12, "12345", "Ciphers"),
(13, 13, "Teknically", "Galeem"),
(14, 14, "Tashi", "New Bow"),
(15, 15, "Bris_Almighty", "Scorbunny #1"),
(16, 16, "12345", "Character Artwork"),
(17, 17, "12345", "Chell artwork"),
(18, 18, "Tashi","Thank you message"),
(19, 19, "JJuicy","Riebeck and the Banjo"),
(20, 20, "JJuicy","Zombie Artwork"),
(21, 21, "JJuicy", "Paid for suits"),
(22, 22, "CeeJay_FC", "My village"),
(23, 23, "GRiMM","Johnny Cage Art"),
(24, 24, "CeeJay_FC", "Cortex Art"),
(25, 25, "Tashi","Kratos and the boi"),
(26, 26, "12345","First House"),
(27, 27, "GRiMM", "Pimped out car"),
(28, 28, "12345","Almost Dead"),
(29, 29, "JJuicy", "Dragon Lore AWP"),
(30, 30, "Bris_Almighty", "Character created :)");

-- Maps username to recID and gameID, due to multi-multi relationship
INSERT INTO Recommend_User(ru_username, ru_recID)
VALUES ("GRiMM", 1), -- 1
("CeeJay_FC", 3), -- 3
("JJuicy", 4), -- 4
("12345", 5), -- 5
("Teknically", 7), -- 7
("Bris_Almighty", 10), -- 10
("Tashi", 9), -- 9
("GRiMM", 2), -- 2
("12345", 6), -- 6
("Teknically", 8); -- 8

-- Maps reviewID to usernames, due to multi-multi relationship
INSERT INTO User_Review(ur_username, ur_reviewID)
VALUES ("GRiMM", 1),
("CeeJay_FC",2),
("JJuicy", 3),
("12345", 4),
("Teknically", 5),
("GRiMM", 6),
("CeeJay_FC", 7),
("12345", 8),
("CeeJay_FC", 9),
("Bobocavern", 9),
("Bris_Almighty", 10),
("Tashi", 11),
("GRiMM", 12),
("JJuicy", 13),
("12345", 14),
("Tashi", 15),
("Teknically", 16),
("CeeJay_FC", 17),
("Tashi", 18),
("Teknically", 19),
("GRiMM", 20),
("Bris_Almighty", 21),
("12345", 22),
("Bris_Almighty", 23),
("Tashi", 24),
("Teknically", 25),
("Tashi", 26),
("Bris_Almighty", 27),
("12345", 28),
("GRiMM", 29),
("Bobocavern", 29),
("JJuicy", 30),
("JJuicy", 31),
("Bobocavern", 32),
("Bobocavern", 33),
("Bobocavern", 34),
("Bobocavern", 35),
("Bobocavern", 36);

----==== QUERIES FOR PROJECT 2 ====----

-- RECOMMENDATION QUERIES
---- SEARCH FOR RECOMMENDATIONS
---- EXAMPLES

-- #1: Search for Games reviewed by Bobocavern with an average score of >=3, 
--    but that bobocavern rated <= 3, for playstation, and released after 2014
-- USE CASE: Users can query the game database for recommendations
SELECT g_name as name
FROM vgData, Review, User_Review
WHERE g_gameID = r_gameID
    and ur_reviewID = r_reviewID
    and ur_username = "Bobocavern"
    and r_rating <= 3
    and g_platform like "%Playstation%"
    and g_releasedate > "2014-12-31"
    and g_gameID in (SELECT g_gameID 
        FROM vgData, Review 
        WHERE g_gameID = r_gameID 
        GROUP BY g_gameID 
        HAVING avg(r_rating) >= 3);

-- #2: Search for Games reviewed by both 12345 and Bobocavern for PC, released before 2018
-- USE CASE: Users can query the game database for recommendations
SELECT g_name as name, avg(three.r_rating) as AverageRating
FROM vgData, Review bcRev, User_Review bcUser, Review baRev, User_Review baUser, Review three
WHERE g_gameID = bcRev.r_gameID
    and bcRev.r_gameID = baRev.r_gameID
    and three.r_gameID = bcRev.r_gameID
    and bcRev.r_reviewID = bcUser.ur_reviewID
    and baRev.r_reviewID = baUser.ur_reviewID
    and baUser.ur_username = "Bris_Almighty" 
    and bcUser.ur_username = "Bobocavern"
    and g_platform like "%PC%"
    and g_releasedate < "2018-01-01"
GROUP BY three.r_gameID;

-- #3: View top 5 games of all time, by rating then by review count then alphabetically
-- USE CASE: Users can view games in the game database
SELECT g_name, avr, rcount
FROM vgData, 
    (SELECT r_gameID as avGameID, avg(r_rating) as avr FROM Review GROUP BY r_gameID),
    (SELECT r_gameID as countGameID, count(r_rating) as rcount FROM Review GROUP BY r_gameID)
WHERE g_gameID = avGameID
    and g_gameID = countGameID
ORDER BY avr desc, rcount desc, g_name asc
LIMIT 5;

---- ADD RECOMMENDATIONS
---- EXAMPLES
-- #4: Tashi wants to add Games for xbox reviewed by Admin users before 2016 to their Recommendations
-- USE CASE: Users can query the database for recommendations and save the set of recommended video games to view later
INSERT INTO Recommendation (rc_recID, rc_gameID, rc_status, rc_comments)
SELECT distinct maxID.theMax + 1, g_gameID, "Unplayed", ""
FROM Users, vgData, Review, User_Review,(SELECT max(rc_recID) as theMax FROM Recommendation) maxID
WHERE u_username = ur_username
    and g_gameID = r_gameID
    and u_type = "Admin"
    and g_platform like "%Xbox%"
    and r_date < "2019-01-01";
    
INSERT INTO Recommend_User (ru_username, ru_recID)
SELECT "Tashi", maxID.theMax
FROM (SELECT max(rc_recID) as theMax FROM Recommendation) maxID;


-- #5: 12345 wants to add Adventure games for xbox whose average reviews after 2016 are > 4 to their Recommendations
-- USE CASE: Users can query the database for recommendations and save the set of recommended video games to view later
INSERT INTO Recommendation (rc_recID, rc_gameID, rc_status, rc_comments)
SELECT distinct maxID.theMax + 1, g_gameID, "Unplayed", ""
FROM vgData, Review, (SELECT max(rc_recID) as theMax FROM Recommendation) maxID
WHERE g_gameID = r_gameID
    and g_gameID in (SELECT r_gameID
        FROM Review
        WHERE r_date > "2016-12-31"
        GROUP BY r_gameID
        HAVING avg(r_rating) > 4);
        
INSERT INTO Recommend_User (ru_username, ru_recID)
SELECT "12345", maxID.theMax
FROM (SELECT max(rc_recID) as theMax FROM Recommendation) maxID;

---- VIEW RECOMMENDATIONS
---- EXAMPLES

-- #6: Show the top three highest average rated recommendation sets for Tashi, descending by score, which contain adventure games
-- USE CASE: User can revisit old recommendations
SELECT rc_recID, avg(r_rating)
FROM vgData, Recommendation, Recommend_User, Review
WHERE g_gameID = r_gameID
    and g_gameID = rc_gameID
    and ru_recID = rc_recID
    and g_genre like "%Adventure%"
    and ru_username = "Tashi"
GROUP BY rc_recID
ORDER BY avg(r_rating) desc
LIMIT 3;

-- #7: Show all distinct xbox rpg games recommended to 12345, 
--     ascending by score, which have also been recommended to an Admin user
-- USE CASE: User can revisit old recommendations
SELECT rc_recID, g_name, rc_status, avg(r_rating)
FROM vgData, Recommendation, Recommend_User, Review
WHERE g_gameID = r_gameID
    and g_gameID = rc_gameID
    and ru_recID = rc_recID
    and g_genre like "%Adventure%"
    and ru_username = "12345"
    and g_gameID in (SELECT rc_gameID 
        FROM Users, Recommendation, Recommend_User 
        WHERE u_username = ru_username and ru_recID = rc_recID and u_type = "Admin")
GROUP BY rc_recID, rc_gameID;

---- UPDATE RECOMMENDATIONS
-- #8: Tashi wants to update the status to "In Progress" and comment on the game bioshock infinite, which they had been recommended earlier
-- USE CASE: User can revisit and edit old recommendations
UPDATE Recommendation
SET rc_status = "In Progress",
    rc_comments = "Liking it so far!"
WHERE rc_recID = (SELECT ru_recID FROM Recommend_User WHERE ru_username = "Tashi")
    and rc_gameID = (SELECT g_gameID FROM vgData WHERE g_name = "Bioshock Infinite");

---- DELETE RECOMMENDATIONS
-- #9: 12345 wants to delete the recommendation they got for Super Mario Odyssey under recommendation ID 5
-- USE CASE: User can revisit and edit old recommendations
DELETE FROM Recommendation 
WHERE rc_recID = 5 
    and rc_gameID = (SELECT g_gameID FROM vgData WHERE g_name = "Super Mario Odyssey");

-- GAMES QUERIES
---- ADD GAME ENTRY
-- #10: Add a game, called Mr Maze into the the database
-- USE CASE: User can add games to the database
INSERT INTO vgData
SELECT theMax + 1, "Mr Maze", "MJ Lovegrove", "PC", "Puzzle, Adventure, RPG", "Rating", "02/09/2019"
FROM (SELECT max(g_gameID) as theMax FROM vgData);

---- UPDATE GAME ENTRY
-- #11: Update the game entry, called Mr Maze to be called Mr. Maze, and change the genre to just Puzzle, Adventure
-- USE CASE: User can update games in the database
UPDATE vgData
SET g_name = "Mr. Maze",
    g_genre = "Puzzle, Adventure"
WHERE g_name = "Mr Maze";

---- DELETE GAME ENTRY
-- #12: Delete the game entry, called Mr. Maze
-- USE CASE: Admins can delete abusive game entries
DELETE FROM vgData
WHERE g_name = "Mr. Maze";


-- GAMEPLAY AND IMAGES
----  ADD GAMEPLAY
---- Add gameplay footage to the database. Users will be able to upload gameplay footage from their computer, 
---- and the filename will map to the gp_id in the database
-- #13: GRiMM wants to add a gameplay video to the game entry called Dark Souls, with a comment "fun game!"
-- USE CASE: Users can add gameplay videos to the database
INSERT INTO Gameplay
SELECT g_gameID, theMax+1, "GRiMM", "fun game!"
FROM vgData, (SELECT max(gp_id) as theMax FROM Gameplay)
WHERE g_name = "Dark Souls";

---- ADD IMAGE
---- Add images to the database. Users will be able to upload images from their computer, 
---- and the filename will map to the p_imageID in the database
-- #14: Teknically wants to add an image to the game entry called Hollow Knight, with a comment "lots of loot!"
-- USE CASE: Users can add Images of the game to the database
INSERT INTO Pictures
SELECT g_gameID, theMax+1, "Teknically", "lots of loot!"
FROM vgData, (SELECT max(p_imageID) as theMax FROM Pictures)
WHERE g_name = "Hollow Knight";

---- DELETE GAMEPLAY
-- #15: An Admin finds GRiMM's recently added gameplay video (gp_id = 21) offensive and wants to remove it
-- USE CASE: Admins can delete abusive gameplay videos
DELETE FROM Gameplay
WHERE gp_id = 21;

---- DELETE IMAGE
-- #16: An Admin finds Teknically's recently added image (p_imageID) offensive and wants to remove it
-- USE CASE: Admins can delete abusive images
DELETE FROM Pictures
WHERE p_imageID = 21;

---- VIEW GAME IMAGES AND VIDEOS
-- #17: select the image and gameplay ids for the images and videos for Minecraft, so that they can be shown
-- USE CASE: User can view a gallery of game images and videos
SELECT "Gameplay", gp_id
FROM vgData, Gameplay
WHERE g_gameID = gp_gameID
    and g_name = "Minecraft"
UNION 
SELECT "Image", p_imageID
FROM vgData, Pictures
WHERE g_gameID = p_gameID
    and g_name = "Minecraft";
    
-- REVIEWS
---- ADD REVIEW
-- #18: JJuicy writes an absolutely scathing review for Halo MCC
-- USE CASE: Users can write reviews for video games
INSERT INTO Review
SELECT theMax+1, gid, 0, substr(DATETIME('now'), 0, 11), "ABSOLUTELY HATED IT 0/10 NEVER PLAYING AGAIN"
FROM (SELECT max(r_reviewID) as theMax FROM Review), (SELECT g_gameID as gid FROM vgData WHERE g_name = "Halo MCC");

INSERT INTO User_Review
SELECT "JJuicy", theMax
FROM (SELECT max(r_reviewID) as theMax FROM Review);

---- DELETE A REVIEW
-- #19: An Admin is seething from JJuicy's scathing review for Halo MCC (reviewID = 37), and wants to delete it
-- USE CASE: Admins can delete abusive reviews for video games
DELETE FROM Review
WHERE r_reviewID = 37;

DELETE FROM User_Review
WHERE ur_reviewID = 37;

---- VIEW REVIEWS OF A GAME
-- #20: View the reviews for Overwatch, ordered by date (earliest first)
-- USE CASE: Users can view the reviews of a game in the database
SELECT r_date, ur_username, r_rating, r_comments
FROM Review, User_Review, vgData
WHERE r_gameID = g_gameID
    and r_reviewID = ur_reviewID
    and g_name = 'Overwatch'
ORDER BY r_date desc;

-- #21: View all reviews made in 2018, sorted by game alphabetically and score numerically
-- USE CASE: Users can view the reviews of a game in the database
SELECT distinct r_date, g_name, r_rating, r_comments
FROM vgData, Review
WHERE g_gameID = r_gameID AND r_date BETWEEN "2018-01-01" AND "2018-12-31"
GROUP BY r_reviewID
ORDER BY r_rating desc, g_name asc;

-- #22: View 5 newest reviews
-- USE CASE: Users can view new additions
SELECT r_date, g_name, r_rating, r_comments
FROM vgData, Review
WHERE g_gameID = r_gameID
ORDER BY r_date desc
LIMIT 5;

--#23: Select users from username table
SELECT u_username
FROM Users;
--#24: Get game name from developer Bandai Namco
Select g_name
From vgData
Where g_developer = "Bandai Namco";
--#25: Count games from developer Bethesda
Select COUNT(g_gameID)
From vgData
Where g_developer = "Bethesda";
--#26: List all games that can be played on the PC
SELECT g_name
FROM vgData
Where g_platform LIKE "%PC%";
--#27: View all reviews made in 2018 as well as their comments and game ID's
SELECT g_gameID, g_name, r_comments
FROM vgData, Review
WHERE g_gameID = r_gameID AND r_date BETWEEN "2018-01-01" AND "2018-12-31";















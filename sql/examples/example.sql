-- Franchises
INSERT INTO franchise (fName)
VALUES ("Phineas und Ferb"),
    ("Star Wars"),
    ("Marvel"),
    ("Overwatch");

-- Series
INSERT INTO series (seName)
VALUES ("Phineas und Ferb"),
    ("Lego Star Wars: Die Yoda-Chroniken"),
    ("Marvel Agents of Shield");

INSERT INTO se_franchise (fId, seId)
VALUES (1, 1), (2, 2), (3, 3);

-- Seasons
INSERT INTO season (seaEpisodeCount, seId, seaNr)
VALUES (26, 1, 1),
    (39, 1, 2);

-- Movies
INSERT INTO movie (mName)
VALUES ("Star Wars Episode I: Die dunkle Bedrohung"),
    ("Star Wars Episode II: Der Angriff der Klonkrieger"),
    ("Phineas und Ferb: Quer durch die 2te Dimension"),
    ("Marvel Avengers: Endgame");

INSERT INTO movie_franchise (mId, fId)
VALUES (1, 2), (2, 2), (3, 1), (4, 3);

-- Video games
INSERT INTO video_game (vName)
VALUES ("Phineas und Ferb: Quer durch die 2te Dimension"),
    ("Star Wars: The Force Unleashed"),
    ("Lego Marvel Super Heroes"),
    ("Overwatch");

INSERT INTO vg_franchise (fId, vId)
VALUES (1, 1), (2, 2), (3, 3), (4, 4);

-- Genders
INSERT INTO gender (gName)
VALUES ("männlich"),
    ("weiblich");

-- Characters
INSERT INTO charakter (cFirstName, cSurname, cPictureUrl, gId)
VALUES ("Phineas", "Flynn", "https://i.pinimg.com/originals/1a/6d/8a/1a6d8a51f617c7a72d49d26bb84f140a.png", 1),
    ("Ferb", "Fletcher", 
        "https://th.bing.com/th/id/R.d1f46e2897408757ae4e117a3c9a11c4?rik=4nZE%2fkbJT3CeDw&riu=http%3a%2f%2fimg.lum.dolimg.com%2fv1%2fimages%2fce17e66e3dd28cefad55fbd18262c660b4cd8294.jpeg%3fregion%3d0%2c0%2c600%2c600&ehk=diyZ4CoHJ4ZyVn6T9RKeuPRwqSCSn2U%2fRzpAaeA05KA%3d&risl=&pid=ImgRaw&r=0", 1),
    ("Yoda", NULL, "https://static.wikia.nocookie.net/starwars/images/d/d6/Yoda_SWSB.png/revision/latest/scale-to-width-down/1000?cb=20150206140125", 1),
    ("Obi-Wan", "Kenobi", "https://static.wikia.nocookie.net/p__/images/7/74/Star-wars-obi-wan-kenobi-jedi-cloak-3.jpg/revision/latest?cb=20171231024120&path-prefix=protagonist", 1),
    ("Tracer", NULL, "https://cdnb.artstation.com/p/assets/images/images/000/327/025/large/renaud-galand-trcr00.jpg?1443929186", 2),
    ("Tony", "Stark", "https://i.pinimg.com/originals/f3/58/73/f3587343df2a97bf6f738bc33547c83d.jpg", 1);


-- Languages
INSERT INTO lang (lShort, lName)
VALUES ("EN", "Englisch"),
    ("DE", "Deutsch"),
    ("FR", "Französisch"),
    ("JP", "Japanisch");

-- Voice Actors
INSERT INTO voice_actor (vaFirstName, vaSurname, gId, vaPictureUrl, vaBirthDate, vaBirthPlace, vaDeathDate, vaDeathPlace)
VALUES ("Manuel", "Straube", 1, "https://www.media-paten.com/sprecherkartei/bilder/bekannte-synchronsprecher/manuel-straube.jpg", "28. Juli 1984", "München (Germany)", NULL, NULL),
    ("Patrick", "Schröder", 1, NULL, "1987", "Bochum (Germany)", NULL, NULL),
    ("Stefan", "Günther", 1, "https://visual-history.de/wp-content/uploads/2022/03/Interview-Stefan-Guenther.jpg", "13. October 1979", "München (Germany)", NULL, NULL),
    ("Thomas", "Amper", 1, "https://images.genius.com/cdd2c864f341121e54c824cc38ad6345.431x431x1.jpg", "10. June 1962", "München (Germany)", NULL, NULL),
    ("Vincent", "Martella", 1, "https://tse2.mm.bing.net/th/id/OIP.wKQkiOPHxRdOh957okehagHaKV?rs=1&pid=ImgDetMain&o=7&rm=3", "15. October 1992", "Rochester (New York)", NULL, NULL),
    ("Thomas", "Sangster", 1, "https://tse3.mm.bing.net/th/id/OIP.4Jw5U5qObBRTYpC6Ao1aaAHaKd?rs=1&pid=ImgDetMain&o=7&rm=3", "16. May 1990", "London (England)", NULL, NULL),
    ("David", "Errigo Jr.", 1, "https://images.squarespace-cdn.com/content/v1/659dcc8b7b388b4c858473c7/1750727034728-YBBZE5Z9UDISN50UPBQA/1.+David+Errigo+Jr+Headshot.jpeg", "29 June 1986", "North Carolina (USA)", NULL, NULL),
    ("Danny", "Jacob", 1, "https://static.wikia.nocookie.net/phineasferb/images/1/1d/Danny_Jacob.jpg/revision/latest?cb=20130310044926&path-prefix=pt-br", "8. October 1956" ,"Los Angeles (California)", NULL, NULL),
    ("Ewan", "McGregor", 1, "https://tse1.mm.bing.net/th/id/OIP.q2eRYiAaCXz2w5FPlzZo2AHaJ4?rs=1&pid=ImgDetMain&o=7&rm=3", "31. March 1971", "Perth (Scottland)", NULL, NULL),
    ("Philipp", "Moog", 1, "https://th.bing.com/th/id/OIP.40-RWqEn_kgekURR1XBEcAAAAA?o=7rm=3&rs=1&pid=ImgDetMain&o=7&rm=3", "29. August 1961", "München (Germany)", NULL, NULL),
    ("Frank", "Oz", 1, "https://m.media-amazon.com/images/M/MV5BMTI1NTM4ODA0OV5BMl5BanBnXkFtZTYwODMxMjQ0._V1_FMjpg_UX1000_.jpg", "25. May 1944", "Hereford (England)", NULL, NULL),
    ("Gerry", "Wolff", 1, "https://images.mubicdn.net/images/cast_member/91019/cache-372104-1537264866/image-w856.jpg", "23. June 1920", "Bremen (Germany)", "16. Febuary 2005", "Oranienburg (Germany)"),
    ("Tobias", "Meister", 1, "https://th.bing.com/th/id/R.b93f5fc5d35f0e30e34127098f0b3247?rik=1tv5daIQWZLSAQ&pid=ImgRaw&r=0", "9. June 1957", "Köln (Germany)", NULL, NULL),
    ("Luisa", "Wietzorek", 2, "https://th.bing.com/th/id/R.d06d0afb84a834f7bbc91d42ac01a514?rik=k7C0vF1fscifuQ&riu=http%3a%2f%2fluisa.tv%2fwp-content%2fuploads%2f2016%2f08%2fluisa-wietzorek-kf1333067_gr_1024.jpg&ehk=wPB6xR1m52X%2fPs00rBDsYVV6hOzwNugRIafVbEutSAk%3d&risl=&pid=ImgRaw&r=0", "7. November 1986", "West-Berlin (Germany)", NULL, NULL),
    ("Adrian", "Pasdar", 1, "https://static.vecteezy.com/system/resources/previews/021/374/133/large_2x/adrian-pasdar-arriving-at-the-nbc-tca-party-at-the-beverly-hilton-hotel-in-beverly-hills-ca-onjuly-20-20082008-free-photo.jpg", "30. April 1965", "Pittsfield (Massachusetts)", NULL, NULL);

-- Voice Actor Languages
INSERT INTO va_lang (vaId, lId)
VALUES (1, 2), -- Manuel Straube (Deutsch)
    (2, 2), -- Patrick Schröder (Deutsch)
    (3, 2), -- Stefan Günther (Deutsch)
    (4, 2), -- Thomas Amper (Deutsch)
    (5, 1), -- Vincent Martella (Englisch)
    (6, 1), -- Thomas Sangster (Englisch)
    (7, 1), -- David Errigo Jr. (Englisch)
    (8, 1), -- Danny Jacob (Englisch)
    (9, 1), -- Ewan McGregor (Englisch)
    (10, 2), -- Philipp Moog (Deutsch)
    (11, 1), -- Frank Oz (Englisch)
    (12, 2), -- Gerry Wolff (Deutsch)
    (13, 2), -- Tobias Meister (Deutsch)
    (14, 2), -- Luisa Wietzorek (Deutsch)
    (15, 1); -- Adrian Pasdar (Englisch)

-- Characters and their voice actors
INSERT INTO va_char (cId, valId)
VALUES (1, 1), -- Phineas by Manuel Straube (Deutsch)
    (1, 2), -- Phineas by Patrick Schröder (Deutsch)
    (1, 5), -- Phineas by Vincent Martella (Englisch)
    (2, 3), -- Ferb by Stefan Günther (Deutsch)
    (2, 4), -- Ferb by Thomas Amper (Deutsch)
    (2, 6), -- Ferb by Thomas Sangster (Englisch)
    (2, 7), -- Ferb by David Errigo Jr. (Englisch)
    (2, 8), -- Ferb by Danny Jacob (Englisch)
    (3, 11), -- Yoda by Frank Oz (Englisch)
    (3, 12), -- Yoda by Gerry Wolff (Deutsch)
    (3, 13), -- Yoda by Tobias Meister (Deutsch)
    (4, 9), -- Obi-Wan by Ewan McGregor (Englisch)
    (4, 10), -- Obi-Wan by Philipp Moog (Deutsch)
    (5, 14), -- Tracer by Luisa Wietzorek (Deutsch)
    (6, 15); -- Tony Stark by Adrian Pasdar (Englisch)

-- Characters in the actual series
INSERT INTO content_cva (mId, vId, seaId, vacId, vacAge)
VALUES 
    (1, NULL, NULL, 9, 900),
    (1, NULL, NULL, 10, 900),
    (2, NULL, NULL, 9, 900),
    (2, NULL, NULL, 11, 900),
    (1, NULL, NULL, 12, 25),
    (1, NULL, NULL, 13, 25),
    (NULL, NULL, 1, 1, 10),
    (NULL, NULL, 1, 2, 10),
    (NULL, NULL, 1, 3, 10),
    (NULL, NULL, 1, 3, 10),
    (NULL, NULL, 1, 4, 10),
    (NULL, NULL, 1, 5, 10),
    (NULL, NULL, 1, 6, 10),
    (NULL, NULL, 1, 7, 10),
    (NULL, NULL, 1, 8, 10),
    (NULL, 4, NULL, 14, 28),
    (NULL, 3, NULL, 15, 53);
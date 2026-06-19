<!DOCTYPE html>
<html>

<head>
    <title>IKnowThisVoice</title>
    <meta charset="UTF-8">
    <meta name="keywords" content="voiceactor, synchronsprecher, stimme von">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Audiowide&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    </link>
</head>

<body>
    <!--Überschirft der Seite-->
    <h1 id="überschrift" style="text-align: center;">I know this voice!</h1>

    <!--Suchleiste-->
    <div class="searchbar">
        <form action="AEuP-Projekt.php" method="get">
            <input type="search" class="searchbar" id="suchleiste-text" autofocus
                placeholder="Suche nach Charakter/Sprecher/Serie/..." name="_suche">
            <select name="_dropdown" id="dropdown">
                <option value="charakter">Charakter</option>
                <option value="synchro">Synchronsprecher</option>
                <option value="film">Film</option>
                <option value="series">Serie</option>
                <option value="game">Videospiel</option>
            </select>
            <input type="submit" id="submitbutton" value="Suchen  ">

        </form>
    </div>


    <br>
    <hr class="trennlinie" id="trennlinieOben"><br><br><br>

    <!-- PHP zur Suche -->
    <?php
    $connect_db = mysqli_connect("localhost", "root", "") or die("Keine Verbindung zum Datenbankserver");
    mysqli_select_db($connect_db, "iktv") or die("Datenbank existiert nicht");


    if (isset($_GET["_suche"]) && !($_GET["_suche"] == "")) {
        $_suche = htmlspecialchars($_GET["_suche"]);
        $_dropdown = $_GET["_dropdown"];
        $where = "WHERE ";

        if ($_dropdown == "charakter") {

            $where = $where . "(charakter.cSurname IS NULL AND charakter.cFirstName LIKE '%" . $_suche . "%') OR
        CONCAT(charakter.cFirstName, ' ', charakter.cSurname LIKE '%" . $_suche . "%') OR
        CONCAT(charakter.cSurname, ' ', charakter.cFirstName LIKE '%" . $_suche . "%') OR
        charakter.cSurname LIKE '%" . $_suche . "%' OR
        charakter.cFirstName LIKE '%" . $_suche . "%'";
        } else if ($_dropdown == "synchro") {
            $where = $where . "(voice_actor.vaSurname IS NULL AND voice_actor.vaFirstName LIKE '%" . $_suche . "%') OR
        CONCAT(voice_actor.vaFirstName, ' ', voice_actor.vaSurname LIKE '%" . $_suche . "%') OR
        CONCAT(voice_actor.vaSurname, ' ', voice_actor.vaFirstName LIKE '%" . $_suche . "%') OR
        voice_actor.vaFirstName LIKE '%" . $_suche . "%' OR
        voice_actor.vaSurname LIKE '%" . $_suche . "%'";
        } else if ($_dropdown == "film") {
            $where = $where . "movie.mName LIKE '%" . $_suche . "%'";
        } else if ($_dropdown == "series") {
            $where = $where . "series.seName LIKE '%" . $_suche . "%'";
        } else if ($_dropdown == "game") {
            $where = $where . "video_game.vName LIKE '%" . $_suche . "%'";
        }
        $query =
            "SELECT charakter.cFirstName, 
            charakter.cSurname, 
            charakter.cPictureUrl, 
            voice_actor.vaFirstName, 
            voice_actor.vaSurname, 
            voice_actor.vaPictureUrl, 
            voice_actor.vaBirthPlace,
            voice_actor.vaBirthDate, 
            voice_actor.vaDeathDate, 
            voice_actor.vaDeathPlace,
            content_cva.vacAge,
            gc.gName,
            gva.gName, 
            movie.mName, 
            video_game.vName, 
            series.seName, 
            f1.fName AS fName1, f2.fName AS fName2, f3.fName AS fName3, 
            lang.lName, 
            season.seaNr
        FROM voice_actor 
        /*--------------LEFT JOINS--------------*/
        LEFT JOIN va_lang ON voice_actor.vaID = va_lang.vaID
        LEFT JOIN lang ON va_lang.lID = lang.lID
        LEFT JOIN va_char ON va_lang.valID = va_char.valID
        LEFT JOIN charakter ON va_char.cID = charakter.cID
        LEFT JOIN gender gc ON charakter.gID = gc.gID
        LEFT JOIN gender gva ON voice_actor.gID = gva.gID
        /*LEFT JOIN von Movie*/
        LEFT JOIN content_cva ON va_char.vacID = content_cva.vacID
        LEFT JOIN movie ON content_cva.mID = movie.mID
        LEFT JOIN movie_franchise ON movie.mID = movie_franchise.mID
        /*LEFT JOIN von Video-Games*/
        LEFT JOIN video_game ON content_cva.vID = video_game.vID
        LEFT JOIN vg_franchise ON video_game.vID = vg_franchise.vID
        /*LEFT JOIN von Serien*/
        LEFT JOIN season ON content_cva.seaID = season.seaID
        LEFT JOIN series ON season.seaID = series.seID
        LEFT JOIN se_franchise ON series.seID = se_franchise.seID
        /*LEFT JOIN von Franchise*/
        LEFT JOIN franchise f1 ON movie_franchise.fID = f1.fID
        LEFT JOIN franchise f2 ON se_franchise.fID = f2.fID
        LEFT JOIN franchise f3 ON vg_franchise.fID = f3.fID " . $where . ";";


        /* $ergebnis hat den Datentyp "mysqli_result" */
        $ergebnis = mysqli_query($connect_db, $query) or die("Anfrage gescheitert: " . mysqli_error($connect_db));
        /* $tupel ist ein Array mit der ersten Zeile als assiozatives Array*/
        $tupel = mysqli_fetch_assoc($ergebnis);
        //$tupel["cPictureUrl"] = "https://static.thenounproject.com/png/55168-200.png";
        $row = mysqli_num_rows($ergebnis);

    } else {
        $row = 0;
    }
    ?>

    <?php
    if ($row != 0) {
        //Gibt $keys alle Übrschriften als Array
        $keys = array_keys($tupel);
        //Loopt bis alle Zeilen durch sind
        for ($i = 0; $i <= $row; $i++) {

            foreach ($keys as $currentKey) {
                if (
                    $tupel != null && ($_dropdown == "charakter" || $_dropdown == "film" || $_dropdown == "series" || $_dropdown == "game")
                ) {

                    echo "<div class=\"visitenkarten_container\">";
                    echo "<div class=\"visitenkarten\">";
                    echo "<div class=\"hauptContainer\">";
                    echo "<div class=\"containerBild\">";

                    /* Einfügen des passenden Bildes */
                    echo "<img src=\"" . $tupel["cPictureUrl"] . "\" class=\"visitenbild\">";

                    /* Einfügen des passenden Namens */
                    echo "<span>Name: <span>" . $tupel["cFirstName"] . " " . $tupel["cSurname"] . "</span></span>";
                    echo "</div>";
                    echo "<div class=\"containerBeschreibung\">";
                    echo "<ul id=\"charakterbeschreibung\">";

                    /* Einfügen der Beschreibungen */
                    if ($tupel["vacAge"] != NULL) {
                        echo "<li><span>Alter: " . $tupel["vacAge"] . " Jahre</span></li>";
                    }

                    echo "<li><span>Geschlecht: " . $tupel["gName"] . "</span></li>";
                    echo "<li><span>Synchronsprecher: " . $tupel["vaFirstName"] . " " . $tupel["vaSurname"] . "</span></li>";
                    echo "<li><span>Synchronsprache: " . $tupel["lName"] . "</span></li>";

                    if ($tupel["seName"] != NULL) {
                        echo "<li><span>Serie: " . $tupel["seName"] . " Staffel " . $tupel["seaNr"] . "</span></li>";
                        echo "<li><span>Franchise: " . $tupel["fName2"] . "</span></li>";
                    } else if ($tupel["mName"] != NULL) {
                        echo "<li><span>Film: " . $tupel["mName"] . "</span></li>";
                        echo "<li><span>Franchise: " . $tupel["fName1"] . "</span></li>";
                    } else if ($tupel["vName"] != NULL) {
                        echo "<li><span>Videospiel: " . $tupel["vName"] . "</span></li>";
                        echo "<li><span>Franchise: " . $tupel["fName3"] . "</span></li>";
                    }
    
                    echo "</ul>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";

                    echo "<br><hr class=\"trennlinie\" id=\"trennlinieZwischen\"><br>";
                    break;
                } else if (
                    $tupel != null && $_dropdown == "synchro"
                ) {

                    echo "<div class=\"visitenkarten_container\">";
                    echo "<div class=\"visitenkarten\">";
                    echo "<div class=\"hauptContainer\">";
                    echo "<div class=\"containerBild\">";

                    /* Einfügen des passenden BILDES */
                    echo "<img src=\"" . $tupel["vaPictureUrl"] . "\" class=\"visitenbild\" alt=\"Kein Bild vorhanden\">";

                    /* Einfügen des passenden NAMENS */
                    echo "<span>Name: <span>" . $tupel["vaFirstName"] . "&nbsp" . $tupel["vaSurname"] . "</span></span>";
                    echo "</div>";
                    echo "<div class=\"containerBeschreibung\">";
                    echo "<ul id=\"charakterbeschreibung\">";


                    /* Einfügen der BESCHREIBUNG */
                    echo "<li><span>Geschlecht: " . $tupel["gName"] . "</span></li>";
                    echo "<li><span>Geb.: " . $tupel["vaBirthDate"] . "</span></li>";
                    if ($tupel["vaDeathDate"] != null) {
                        echo "<li><span>Gest.: " . $tupel["vaDeathDate"] . "</span></li>";
                    }
                    echo "<li><span>Herkunft: " . $tupel["vaBirthPlace"] . "</span></li>";

                    echo "<li><span>Charakter: " . $tupel["cFirstName"] . " " . $tupel["cSurname"] . "</span></li>";


                    if ($tupel["seName"] != NULL) {
                        echo "<li><span>Serie: " . $tupel["seName"] . " Staffel " . $tupel["seaNr"] . "</span></li>";
                    } else if ($tupel["mName"] != NULL) {
                        echo "<li><span>Film: " . $tupel["mName"] . "</span></li>";
                    } else if ($tupel["vName"] != NULL) {
                        echo "<li><span>Videospiel: " . $tupel["vName"] . "</span></li>";
                    }
    
                    echo "</ul>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";

                    echo "<br><hr class=\"trennlinie\" id=\"trennlinieZwischen\"><br>";
                    break;
                }
            }
            /* $tupel ist ein Array mit der ersten Zeile als assiozatives Array*/

            $tupel = mysqli_fetch_assoc($ergebnis);
            if ($tupel != null) {
                if ($tupel["cPictureUrl"] == " ") {
                    $tupel["cPictureUrl"] = "https://static.thenounproject.com/png/55168-200.png";
                } elseif ($tupel["vaPictureUrl"] == " ") {
                    $tupel["vaPictureUrl"] = "https://static.thenounproject.com/png/55168-200.png";
                }
            }
        }

    }


    ?>

</body>

</html>
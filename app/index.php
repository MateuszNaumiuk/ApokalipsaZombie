<?php
// dolaczenie pliku conn.php zawierajacego polaczenie z baza oraz pliku funkcje.php zawierajaca wszystkie potrzebne funkcje aplikacji
include("conn.php");

// stworzenie ciastka z aktualnym dniem
$cookieName = 'counter';
$counter = isset($_COOKIE[$cookieName]) ? $_COOKIE[$cookieName] : 0;

global $aktualnaSytuacja; // zmienna ktora opisuje co sie aktualnie dzieje, jest wypisywana na ekranie.

// ustawienie ciastka z aktualnym dniem i ustawienie mu czasu waznosci na 24h
setcookie($cookieName, $counter, time() + (24 * 60 * 60), '/');
include("funkcje.php");

// zmienna sprawdzająca czy jedna ze stron wygrała oraz zmienna sprawdzajaca ktora strona, jezeli jest 1 to ludzie, 2 to zombie
$isEnd = 0;
$ktoPrzezyl = 0;
?>
<html>

<head>
    <title>Zombie</title>
    <!-- podlaczenie bootstrap do projektu -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        body {
            background-color: #4B4B4B;
            color: white;
            text-align: center;
            font-size: 2.5vh;
        }

        .okno {
            background-color: #000;
            border: 1px solid white;
        }
    </style>
</head>

<body>
    <!-- pasek informujący o tym który jest dzień apokalipsy -->
    <div class="row">
        <div class="col-12">
            <p style="text-align: center;">Dzień apokalipsy nr: <span id="current-day">
                    <?php echo $_COOKIE['counter'] ?>
                </span></p>
        </div>
    </div>


    <div class="row" style="background-color: #4B4B4B;">
        <div class="col-xl-4 col-sm-12">
            <?php
            // wypisanie informacji o zombie z bazy danych
            echo "<h2>Zombie</h2>";
            $query = "select * from Zombies;";
            $result = pg_query($conn, $query);

            while ($row = pg_fetch_assoc($result)) {
                // jezeli zombie jest 0 lub mniej wypisz w konsoli ze ludzkosc przeżyla, w innym przypadku wypisuj informacje o zombie
                if ($row['zombieamount'] <= 0) {
                    $ktoPrzezyl = 1;
                    $isEnd = 1;
                } else {
                    echo "<a>Ilość zombie: " . $row['zombieamount'] . "</a><br>";
                }
            }
            if ($isEnd == 0) {
                ?>
                <form method="post">
                    <input type="submit" name="attackHumans" class="button" value="Zaatakuj ludzi" />
                </form>
                <?php
            }
            ?>
        </div>
        <div class="col-xl-4 col-sm-12">

            <?php
            echo "<h2>Ludzie</h2>";
            // wypisanie informacji o ludziach z bazy danych
            $query = "select * from humans;";
            $result = pg_query($conn, $query);

            while ($row = pg_fetch_assoc($result)) {
                // jezeli ludzi jest 0 lub mniej, lub jedzenia czy zarazenia wypisz w konsoli ze apokalipsa zniszczyla ludzkosc, w innym przypadku wypisuj informacje o ludziach
                if ($row['humanamount'] <= 0 || $row['humanhp'] <= 0 || $row['humanfood'] <= 0) {
                    $ktoPrzezyl = 2;
                    $isEnd = 1;
                } else {
                    echo "<a>Ilość: " . $row['humanamount'] . "</a><br>";
                    echo "<a>HP: " . $row['humanhp'] . "</a><br>";
                    echo "<a>Jedzenie: " . $row['humanfood'] . "</a><br>";
                    echo "<a>Obrona: " . $row['humandef'] . "</a><br><br>";
                }
            }
            // przyciski od ataku na zombie oraz o wyprawie, wiecej informacji o funkcjach znajduje sie w pliku funkcje.php
            if (isset($_POST['attackZombie'])) {
                attackZombies();
            }
            if (isset($_POST['attackHumans'])) {
                attackHumans();
            }

            if ($isEnd == 0) {
                ?>
                <form method="post">
                    <input type="submit" name="attackZombie" class="button" value="Zaatakuj Zombie" />
                </form>
                <?php
            }
            ?>
        </div>
        <div class="col-xl-4 col-sm-12">
            <?php

            // wypisanie informacji o dostepnych zasobach na swiecie
            echo "<h2>Dostepne zasoby na świecie</h2>";
            $query = "select * from resources;";
            $result = pg_query($conn, $query);

            while ($row = pg_fetch_assoc($result)) {
                echo "<a>Jedzenie: " . max(0, $row['foodamount']) . "</a><br>";
                echo "<a>Broń: " . max(0, $row['weaponsamount']) . "</a><br>";
                echo "<a>Medykamenty: " . max(0, $row['medicalsuppliesamount']) . "</a><br><br>";
            }
            ?>
        </div>
    </div>

    <!-- okno informacji co stalo sie danego dnia -->
    <div class="row">
        <div class="col-8 mx-auto okno">
            <a>Informacje z danego dnia:</a><br>
            <div class="text-left">
                <span id="okno">
                    <div id="okno">
                        <?php echo $aktualnaSytuacja; ?>
                    </div>
                </span></p>
            </div>
        </div>
    </div>

    <?php
    // przyciski odpowiadajace za dodawanie do bazy, wiecej informacji o konkretnych funkcjach znajduje sie w pliku funkcje.php
    if (isset($_POST['reset']))
        appReset();
    if (isset($_POST['dodajLudzi']))
        addHumans();
    if (isset($_POST['dodajzombie']))
        addZombie();
    if (isset($_POST['dodajResources']))
        addResources();

    // jezeli jest koniec symulacji ukryj przyciski od dodawania
    if ($isEnd == 0) {
        ?>
        <form method="post">
            <br>
            <input type="submit" name="dodajLudzi" class="button" value="dodaj ludzi" />
            <input type="submit" name="dodajzombie" class="button" value="dodaj zombie" />
            <input type="submit" name="dodajResources" class="button" value="Dodaj zasoby" />
        </form>
        <?php
    }
    // Zamknięcie połączenia
    pg_close($conn);
    ?>
    <form method="post">
        <br>
        <input type="submit" name="reset" class="button" value="Zacznij od nowa" /><br><br>
    </form>
</body>

</html>
<!-- bootstrap -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
    crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
    crossorigin="anonymous"></script>

<script>
    // aktualizacja ciastka zwiekszajac o 1 dzien
    function updateCounter() {
        var counter = parseInt(<?php echo $counter; ?>);
        counter += 1;
        document.cookie = '<?php echo $cookieName; ?>=' + counter + '; expires=; path=/';
        window.location = window.location
        document.getElementById('current-day').innerHTML = '' + counter;
    }
    <?php
    // gdy jedna strona wygra zatrzymuje sie data i przez co cala symulacja
    if ($isEnd == 0) {
        ?>
        // ustawienie interwalu co 5 sekund
        setInterval(updateCounter, 2000);
    <?
    } else {
        if ($ktoPrzezyl == 1) {
            ?>
            document.getElementById('okno').innerHTML = 'Ludzkość przeżyła';
            setInterval(updateCounter, 1000000);
        <?
        } elseif ($ktoPrzezyl == 2) {
            ?>
            document.getElementById('okno').innerHTML = 'Zombie zabiło ludzkosc';
            setInterval(updateCounter, 1000000);
                                <?
        }
    }
    ?>
</script>

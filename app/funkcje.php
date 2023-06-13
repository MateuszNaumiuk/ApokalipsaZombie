<?php
include("conn.php");
$aktualnaSytuacja; // zmienna ktora opisuje co sie aktualnie dzieje, jest wypisywana na ekranie.

// reset aplikacji, ustawia wszystko na 100
function appReset()
{
    global $conn;
    ?>
    <script>
        document.cookie = "counter=0; expires=; path=/";
        window.location = window.location

    </script>
    <?php
    $query =
        "UPDATE zombies SET zombieamount = 100;
             UPDATE humans SET humanamount = 100;
             UPDATE humans set humanhp = 100;
             UPDATE humans set humanhp = 100;
             UPDATE humans set humanfood = 100;
             UPDATE humans set humandef = 100;
             UPDATE resources SET foodamount = 100;
             UPDATE resources SET weaponsamount = 100;
             UPDATE resources SET medicalsuppliesamount = 100;
        ";
    $result = pg_query($conn, $query);
}
// wykonanie akcji randomEvent kazdego dnia apokalipsy
randomEvent();


// funkcja symulujaca ludzi jak i zombie oraz ich poczynania
function randomEvent()
{
    $isEnd = 0;
    global $aktualnaSytuacja;
    global $conn;
    // pobranie z bazy ilosci zasobow zeby sprawdzac gdy jedzenie sie skonczy
    $query = "select * from resources;";
    $result = pg_query($conn, $query);

    while ($row = pg_fetch_assoc($result)) {
        $brakjedzenia = ($row['foodamount'] <= 0) ? 1 : 0;
        $brakbroni = ($row['weaponsamount'] <= 0) ? 1 : 0;
        $brakmedic = ($row['medicalsuppliesamount'] <= 0) ? 1 : 0;
        $isEnd = ($row['zombieamount'] <= 0) ? 1 : 0;
    }

    // 10 % szans na rozne eventy
    $randomEvent = rand(1, 100);
    switch (true) {
        case ($randomEvent <= 10): // zaatakowanie ludzi
            attackHumans();
            break;
        case ($randomEvent > 10 && $randomEvent <= 20): // zaatakowanie zombie
            attackZombies();
            break;
        case ($randomEvent > 20 && $randomEvent <= 30): // znalezienie jedzenia
            if ($brakjedzenia != 1) { // sprawdzenie czy jedzenei sie skonczylo, jezeli tak to nie da sie wiecej go zdobyc, dotyczy to tez broni i medykamentow
                $aktualnaSytuacja = "znaleziono jedzenie";
                $randomNumber = rand(1, 20);
                $query = "UPDATE humans SET HumanFood = HumanFood + $randomNumber; UPDATE resources SET foodamount = foodamount - $randomNumber";
                $result = pg_query($conn, $query);
                break;
            } else {
                $aktualnaSytuacja = "spokojny dzien";
                break;
            }
        case ($randomEvent > 30 && $randomEvent <= 40): // znalezienie broni
            if ($brakbroni != 1) {
                $aktualnaSytuacja = "znaleziono bron";
                $randomNumber = rand(1, 20);
                $query = "UPDATE humans SET HumanDef = HumanDef + $randomNumber;UPDATE resources SET weaponsamount = weaponsamount - $randomNumber";
                $result = pg_query($conn, $query);
                break;
            } else {
                $aktualnaSytuacja = "spokojny dzien";
                break;
            }
        case ($randomEvent > 40 && $randomEvent <= 50): // znalezienie medykamentow
            if ($brakmedic != 1) {
                $aktualnaSytuacja = "znaleziono medykamenty";
                $randomNumber = rand(1, 20);
                $query = "UPDATE humans SET humanhp  = humanhp + $randomNumber;UPDATE resources SET medicalsuppliesamount = medicalsuppliesamount - $randomNumber";
                $result = pg_query($conn, $query);
            } else {
                $aktualnaSytuacja = "spokojny dzien";
                break;
            }
        default:
            $aktualnaSytuacja = "spokojny dzien";
            break;
    }
}

// funkcja atakujaca ludzi, generuje randomowe liczby i wysyla do bazy zapytanie aktualizujace ktore zmniejsza ilosc ludzi, ich hp oraz zwieksza nieduza ilosc zombie.
function attackHumans()
{
    global $conn;
    global $aktualnaSytuacja;

    $aktualnaSytuacja = "Zaatakowano ludzi";
    $randomNumber = rand(1, 10);
    $randomNumber2 = rand(0, 3);
    $query =
        "UPDATE humans SET humanamount = humanamount - $randomNumber, humanhp = humanhp - $randomNumber2;
             UPDATE zombies SET zombieamount = zombieamount + $randomNumber2;
         ";
    $result = pg_query($conn, $query);
}

// dodanie ludzi do symulacji
function addHumans()
{
    global $conn;
    $query =
        "UPDATE humans SET humanamount = humanamount + 10";
    $result = pg_query($conn, $query);
}

// funkcja atakowania zombie, aktualizuje informacje o ilosci zombie, w mniejszej ilosci ludzi i ich hp
function attackZombies()
{
    global $conn;
    global $aktualnaSytuacja;

    $aktualnaSytuacja = "Zaatakowano Zombie";
    $randomNumber = rand(1, 10);
    $randomNumber2 = rand(0, 3);
    $query =
        "UPDATE zombies SET zombieamount = zombieamount - $randomNumber;
             UPDATE humans SET humanamount = humanamount - $randomNumber2;
             UPDATE humans set HumanHP = HumanHP - ($randomNumber2/2);
        ";
    $result = pg_query($conn, $query);
}

// dodanie zombie do symulacji
function addZombie()
{
    global $conn;
    $query =
        "UPDATE zombies SET zombieamount = zombieamount + 10";
    $result = pg_query($conn, $query);
}

// dodanie zasobow do symulacji
function addResources()
{
    global $conn;
    $query =
        "UPDATE resources SET foodamount = foodamount + 100;
             UPDATE resources SET weaponsamount = weaponsamount + 100;
             UPDATE resources set medicalsuppliesamount = medicalsuppliesamount +100;
        ";
    $result = pg_query($conn, $query);
}
?>
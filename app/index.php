<html>

<head>
    <title>Zombie</title>
    <style>
        body {
            background-color: #4B4B4B;
            color: white;
        }
    </style>
</head>

<body>
    <?php
    // Konfiguracja połączenia z bazą danych PostgreSQL
    $host = 'postgres';
    $port = '5432';
    $dbname = 'apokalipsa';
    $user = 'docker';
    $password = 'docker';

    // Utworzenie połączenia
    $conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

    if (!$conn) {
        echo "Błąd połączenia z bazą danych.";
        exit;
    }


    echo "<h1>Humans</h1>";


    // Wykonanie zapytania do bazy danych
    $query = "select * from humans;";
    $result = pg_query($conn, $query);

    // Przetwarzanie wyników zapytania
    while ($row = pg_fetch_assoc($result)) {
        echo "ID: " . $row['humanid'] . "<br>";
        echo "Full Name: " . $row['humanfullname'] . "<br>";
        echo "HP: " . $row['humanhp'] . "<br><br>";
    }



    echo "<h1>Zombies</h1>";

    $query = "select * from Zombies;";
    $result = pg_query($conn, $query);

    // Przetwarzanie wyników zapytania
    while ($row = pg_fetch_assoc($result)) {
        echo "ID: " . $row['zombieid'] . "<br>";
        echo "Full Name: " . $row['zombiefullname'] . "<br>";
        echo "HP: " . $row['ZombieHP'] . "<br><br>";
    }




    echo "<h1>Resources</h1>";

    $query = "select * from resources;";
    $result = pg_query($conn, $query);

    // Przetwarzanie wyników zapytania
    while ($row = pg_fetch_assoc($result)) {
        echo "ID: " . $row['resourceid'] . "<br>";
        echo "Nutritions: " . $row['nutritions'] . "<br>";
        echo "DMG: " . $row['dmg'] . "<br>";
        echo "UsesLeft: " . $row['usesleft'] . "<br><br>";
    }

    // Zamknięcie połączenia
    pg_close($conn);
    ?>
</body>

</html>

# Apokalipsa Zombie

## Opis projektu
Zombie Apocalypse to aplikacja internetowa symulująca apokalipse zombie. Aplikacja pozwala na monitorowanie i zarządzanie populacją zombie, ludzi oraz zasobami dostępnymi na świecie.
Każdego dnia jest szansa ze ludzie znajdą jakieś zasoby, zostana zaatakowani przez zombie lub zaatakuja zombie.

## Wymagania
- Docker v.4.20.1
- Docker compose

### Instalacja docker'a:
1. Wybierz odpowiednią wersję Dockera dla swojego systemu operacyjnego. Możesz pobrać Docker ze strony oficjalnej: https://www.docker.com/get-docker
2. Po pobraniu instalatora Docker, uruchom go.
3. Jeżeli pojawią się jakieś problemy, przejdź do oficjalnej strony: https://www.docker.com/get-docker, po więcej informacji.
4. Po zakończeniu instalacji uruchom Dockera.
5. Gdy Docker jest uruchomiony, powinien działać jako usługa w tle. Możesz sprawdzić jego stan, wykonując polecenie w terminalu:
- docker version
6. jeżeli polecenie wyświetliło informacje, to znaczy że docker został zainstalowany poprawnie, w innym przypadku wróc do punktu 1.

## Instrukcje instalacji aplikacji
1. Wypakuj pliki do folderu.
2. Przejdz do katalogu glownego aplikacji.
3. Uruchom kontenery dockera w tym folderze poleceniem:
-   docker-compose up --build
4. aplikacja bedzie dostepna pod adresem:
-   https://localhost:80
-   https://127.0.0.1:80

# Konfiguracja

## Baza danych
1. Aplikacja korzysta z bazy danych na silniku Postgresql. Dane dostepowe do bazy to:
-   użytkownik: docker
-   hasło: docker
-   baza: docker

# interakcja z projektem
- aplikacja pozwala opcje takie jak, dodawanie ludzi, dodawanie zombie, i dodawanie zasobów, poniżej opisane są instrukcje jak to robić.

### Dodawanie ludzi
1. Otwórz aplikacje php w przeglądarce.
2. Kliknij przycisk "Dodaj ludzi".
3. Do aplikacji zostanie dodana grupa ludzi.

### Dodawanie zombie
1. Otwórz aplikacje php w przeglądarce.
2. Kliknij przycisk "Dodaj zombie".
3. Do aplikacji zostanie dodana grupa zombie.

### Dodawanie zasobów
1. Otwórz aplikacje php w przeglądarce.
2. Kliknij przycisk "Dodaj zasoby".
3. Do aplikacji zostaną dodane zasoby.

## aktualne informacje o symulacji
- Aplikacja PHP zapewnia interfejs użytkownika umożliwiający przeglądanie aktualnego stanu symulacji oraz wszelkich istotnych informacji. Interfejs składa się z różnych sekcji wyświetlających informacje na temat zombie, ludzi i dostępnych zasobów.
- Możesz zobaczyć aktualny dzień apokalipsy w sekcji "Dzień apokalipsy nr". Liczba ta reprezentuje bieżący dzień symulacji.
- Sekcja "Zombie" wyświetla informacje na temat zombie, w tym liczbę obecnych zombie.
- Sekcja "Ludzie" wyświetla informacje na temat ludzi, w tym ilość, punkty życia, jedzenie i obronę.
- Sekcja "Dostępne zasoby na świecie" pokazuje dostępne zasoby, w tym jedzenie, broń i środki medyczne.
- Sekcja "Informacje z danego dnia" wyświetla wynik konsoli, dostarczając informacji na temat wydarzeń i aktualizacji zachodzących w symulacji.

# Struktura projektu
- app/index.php - Główny plik aplikacji zawierający logikę symulacji apokalipsy zombie.
- app/conn.php - Plik łączący z bazą danych.
- app/funkcje.php - Plik zawierający wszystkie potrzebne funkcje do działania aplikacji.
- Dockerfile - Plik konfiguracyjny Docker, który definiuje obraz aplikacji.
- docker-compose.yml - Plik konfiguracyjny Docker Compose, który definiuje usługi i konfigurację kontenerów.
- apokalipsa.sql - Plik SQL zawierający skrypt inicjalizacyjny bazy danych.

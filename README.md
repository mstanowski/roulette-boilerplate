# Znajdź wszystkie nieprawidłowości ruletkowego API

Pewne kasyno zatrudniło młodego programistę **Juniora15k** do wykonania **symulatora gry w ruletkę**. 
Jak na świeżo upieczonego programistę przystało, kod zawiera sporo błędów i niedociągnieć a dokładniej całe **10 nieprawidłowości**!

Twoim zadaniem jest ich odnalezienie! Twoim orężem w tych poszukiwaniach są automatyczne testy _end-to-end__ ruletkowego API. 
Stworzony kod wyglądem przypomina spaghetti stąd testowane API traktujemy jako czarną skrzynkę. 
Do Twojej dyspozycji udostępniamy zasady gry w ruletkę oraz dokumentację, na podstawie której stworzono ruletkowe API.

## Znalezione nieprawidłowości

1. Zamienione kolory "11" z "12"
2. Brak cornera "31-32-34-35"
3. "19" nie nalezy do zbioru liczb wysokich
4. Brak zakładów /line/
5. Zakłady /split/ mają mnożnik 1:11 zamiast 1:17
6. Brak zakładu /straight/4
7. Można postawić więcej niż się posiada
8. "0" wygrywa zakład na parzyste
9. Można obstawiać nie całkowitą liczbę chipsów "50.70", API zaokrągla w dół

## Codeception

Do stworzenia automatycznych testów polecamy **Codeception**, które posiada wbudowany moduł do weryfikacji REST-owych API.
W przygotowanym przez nas starterze udostępniamy nastepujące pliki:
- `Helper/Api.php` zawierający klasę udostępniającą metodę, która pobiera `hashname` dla nowych graczy;
- `RouletteApiCest.php` zawierający metody testujące API.

**Cest** jest to specjalna notacja pozwalająca tworzyć scenariusze testowe, które można przeczytać jak zdania w języku angielskim. Przykład:
```
$I->haveHttpHeader('Authorization', $I->grabHashname()); // Mam nagłówek Authorization
$I->sendPOST('/bets/straight/32', ['chips' => 100]); // Wysyłam żądanie POST na adres /bets/straight/32
$I->seeResponseCodeIs(201); // Sprawdzam czy zwrócony kod to 201
$I->sendPOST('/spin/32'); // Wysyłam żądanie POST na adres /spin/32
$I->sendGET('/chips'); // Wysyłam żądanie GET na adres /chips
$I->assertEquals(3600, json_decode($I->grabResponse(), true)['chips']); // Sprawdza czy zwrócona liczba żetonów jest równa 3600
```
Cest tworzy przejrzyste logi procesu testowania co ułatwia weryfikację wykrytych błędów. Przykładowo:
```
RouletteApiCest: Test split bets | 8,9
Signature: RouletteApiCest:testSplitBets
Test: tests\RouletteApiCest.php:testSplitBets
Scenario --
 I have http header "Content-Type","application/json"
 I grab hashname
 I have http header "Authorization","8c2ecafb1805ad6d13c900e3212e945b"
 I send post "/bets/split/8-9",{"chips":100}
 I see response code is 201
 I send get "/chips"
 I grab response
 I assert equals 0,0
 I send post "/spin/8"
 ...
```

Dodatkową funkcją ułatwiającą pisanie powtarzanych scenariuszy testowych są testy parametryczne, które tworzymy przez adnotację `@dataProvider`.
Przekazane przez metodę wskazaną w adnotacji dane muszą być tablicą i dostęp do nich uzyskujemy przez argument `\Codeception\Example $example`.
Przykład:
```
protected function straightBetsProvider()
    {
        return [
            ['number' => 1]
        ];
    }

    /**
    * @dataProvider straightBetsProvider
    */
    public function testStraightBets(ApiTester $I, \Codeception\Example $example)
    {
        ...
```
```
+ RouletteApiCest: Test straight bets | 1 (0.61s)
```

## Instalacja & uruchomienie

Aby zainstalować, musimy skorzystać z composer (https://getcomposer.org/doc/00-intro.md)
(upewnij się że uruchamiasz komendy w folderze z projektem, to jest dziwny protip ale działa)
```
composer install
```

Aby uruchomić testy wystarczy wpisać komendę:

#### Windows
```
.\vendor\bin\codecept.bat run --env dev
```

#### Linux/Macos 
```
vendor/bin/codecept run --env dev
```
Konfiruracja środowiska, tj. adres API, znajdują się w podkatalogu `tests/_envs` (ale chyba nie bedziesz potrzebował zmieniać na czas coding dojo).

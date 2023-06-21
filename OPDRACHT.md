# Opdracht

Je dient de back-end applicatie te maken voor een Wordle spel. Zie https://wordlegame.org/ voor een voorbeeld, samengevat:

- De bedoeling is om een woord te raden van 5 letters lang (nooit minder dan of meer dan 5)
- Bij iedere inzending krijgt de speler terug:
  - een foutmelding indien het ingestuurde woord een niet-bestaand engels woord is (zie bijlage)
  - indien wél correct engels woord, wordt voor iedere letter getoond:
    - de letter komt voor in het gezochte woord en staat op de juiste plaats
    - de letter komt voor in het gezochte woord maar staat niet op de juiste plaats
    - de letter komt niet voor in het gezochte woord
- De speler krijgt hiervoor maximaal 6 pogingen
- Belangrijk: In tegenstelling tot wordlegame.org is er slechts 1 te raden woord per dag! Dit is gebaseerd op het de versie van NY Times: https://www.nytimes.com/games/wordle/index.html


## Wat wordt van jou verwacht?

- Start vanaf deze repo. Je vindt hierin volgende zaken terug:
  - een Laravel install met Breeze.
  - een volledige CRUD terug voor _words_ (MVC), achter login wall.
- Werk met verder met composer, extra packages mogen toegevoegd worden indien je dat nodig acht
- Werk, indien mogelijk, met sail of andere virtualisatie.
- Werk de CRUD verder af:
  - Wanneer je momenteel een _word_ aanmaakt of bewerkt, maar het niet uit wat je invult in het veld _sheduled at_, het resultaat in de database staat steeds op vandaag -> fix this
  - zorg voor degelijke validatie, deze ontbreekt vandaag!
    - _words_ moeten steeds 5 karakters lang zijn
    - een datumveld moet in de toekomst of vandaag zijn
    - er kunnen geen 2 woorden op éénzelfde datum ingeboekt worden
    - een woord moet een bestaand engels woord zijn. Hieronder verstaan we enkel woorden die voorkomen in bijgevoegde lijst _english5letterwords.csv_ in de root van deze repo.
    - bedenk nog minstens 1 extra validatie-regel en implementeer.
    - communiceer eventuele fouten duidelijk naar de gebruiker toe!
- Voorzie de API die nodig is om de front-end van het spel te kunnen bouwen
  - Denk zelf na over welke endpoints je nodig hebt om het spel te kunnen spelen en hoe die inhoudelijk best werken
  - Er dient niet ingelogd te kunnen worden om het spel te spelen
  - Er worden geen highscores bijgehouden
  - Een gebruiker krijgt maximum 6 pogingen om het woord te raden.
- Voorzie documentatie voor de endpoints. Deze mag gegenereerd worden door Scribe, andere manieren mogen ook, maar ik wil kunnen zien welke endpoints er zijn, wat ik ernaar toe kan/moet sturen en wat ik terug mag verwachten
- Maak op /dashboard een ranking van de 100 meest _gegokte_ woorden (die ook een bestaand engels woord zijn) en toon het precieze aantal.

## Beschikbare tools
Gebruik is toegestaan van:
- online documentatie en tutorials
- alle oefeningen die we het afgelopen jaar gemaakt hebben
- AI-tools, zoals ChatGPT en 
*Er mag absoluut niet: *
- samen gewerkt worden met andere cursisten


## Evaluatie
Je wordt geëvalueerd op basis van volgende criteria:

- Aanpak: Werk je features zo af zodat de waarde voor de klant zo hoog mogelijk is: je wil liever een werkende applicatie waarin bepaalde features ontbreken dan een niet-werkende applicatie waarbij alle features slechts half aanwezig zijn.
- Architectuur: blijf verder werken volgens het MVC-principe en denk na over een goede DB-structuur.
- Security: denk na over veiligheid van de back-end en zorg er vooral voor dat er niet valsgespeeld kan worden.
- Leesbaarheid van code + documentatie.
- Kennis: er kan tijdens het examen gevraagd worden om een stuk van je code toe te lichten.

Veel succes!
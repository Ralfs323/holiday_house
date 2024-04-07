<?php
// Iekļauj datubāzes konfigurāciju
include_once "../db/db.php";

// Izveido tukšu masīvu, kur glabāt notikumu datus
$events = [];

// Izgūst rezervāciju datus no datubāzes
$sql = "SELECT * FROM reservations";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Ja ir rezervāciju dati, pārvērš tos par FullCalendar notikumiem
    while ($row = $result->fetch_assoc()) {
        $event = [
            'title' => 'Rezervēts',
            'start' => $row['check_in'],
            'end' => $row['check_out'],
            'color' => 'red',
            'name' => $row['name'],
            'numberOfPeople' => $row['adults'] + $row['children']
        ];

        // Pievieno notikumu sarakstam
        $events[] = $event;
    }
}

// Aizver datubāzes savienojumu
$conn->close();
?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='utf-8' />
    <link href='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.11/main.min.css' rel='stylesheet' />
    <link href='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.11/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.11/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.11/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: <?php echo json_encode($events); ?>,
                eventDidMount: function(info) {
                    var event = info.event;
                    var eventEl = info.el;
                    var title = event.title;
                    var name = event.extendedProps.name;
                    var numberOfPeople = event.extendedProps.numberOfPeople;

                    eventEl.querySelector('.fc-event-title').innerHTML = title + '<br>' + name + '<br>' + numberOfPeople + ' cilvēki';
                }
            });
            calendar.render();
        });
    </script>
</head>
<body>
<div id='calendar'></div>
</body>
</html>

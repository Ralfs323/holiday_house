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
                events: [
                    // Piemērs rezervāciju datiem
                    {
                        title: 'Rezervēts',
                        start: '2024-03-10',
                        color: 'red',
                        phoneNumber: '12345678', // Telefona numurs
                        name: 'John Doe', // Vārds
                        numberOfPeople: 4 // Cilvēku skaits
                    },
                    {
                        title: 'Rezervēts',
                        start: '2024-03-15',
                        color: 'red',
                        phoneNumber: '98765432',
                        name: 'Jane Smith',
                        numberOfPeople: 2
                    }
                    // Pievieno citas rezervācijas šeit...
                ],
                eventDidMount: function(info) {
                    var event = info.event;
                    var eventEl = info.el;
                    var title = event.title;
                    var phoneNumber = event.extendedProps.phoneNumber; // Izņem telefonu numuru
                    var name = event.extendedProps.name; // Izņem vārdu
                    var numberOfPeople = event.extendedProps.numberOfPeople; // Izņem cilvēku skaitu

                    // Atjaunina notikuma virsrakstu ar rezervācijas informāciju
                    eventEl.querySelector('.fc-event-title').innerHTML = title + '<br>' + phoneNumber + '<br>' + name + '<br>' + numberOfPeople + ' cilvēki';
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

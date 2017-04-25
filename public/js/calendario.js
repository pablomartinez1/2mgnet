 $(document).ready(function() 
 {
    // page is now ready, initialize the calendar...
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
  
  /*
    Para poner un dia:

        title: 'Long Event', // Titulo
        start: new Date(y, m, d-5, 16, 0), // Toma el dia, mes y año de hoy y a eso le tenes que sumar/restar tantos dias para llegar al dia que uno esta buscando, en este caso toma la fecha de hoy y le resta 5 dias para tener un evento ahi.
        end: new Date(y, m, d-2, 18, 0)

        Los ultimos dos parametros son de que hora a que hora dura el evento.

  */

    $('#calendar').fullCalendar(
    {
        locale: 'es',
        header: 
        {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        editable: false,
        events: [
        {
            title: 'Pito',
            start: new Date(y, m, 1)
        },
        {
            title: 'Long Event',
            start: new Date(y, m, d-5),
            end: new Date(y, m, d-2)
        },
        {
            id: 999,
            title: 'Repeating Event',
            start: new Date(y, m, d-3, 16, 0),
            allDay: false
        },
        {
            id: 999,
            title: 'Repeating Event',
            start: new Date(y, m, d+4, 16, 0),
            allDay: false
        },
        {
            title: 'Meeting',
            start: new Date(y, m, d, 10, 30),
            allDay: false
        },
        {
            title: 'Lunch',
            start: new Date(y, m, d, 12, 0),
            end: new Date(y, m, d, 14, 0),
            allDay: false
        },
        {
            title: 'Birthday Party',
            start: new Date(y, m, d+1, 19, 30),
            end: new Date(y, m, d+1, 22, 30),
            allDay: false
        },
        {
            title: 'Aaaaaaaaaaa',
            start: new Date(y, m, 28),
            end: new Date(y, m, 29),
            url: 'http://google.com/'
        }]
    });
});
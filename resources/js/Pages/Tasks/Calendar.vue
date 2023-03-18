<template>
    <div class="row">
        <div class="col-xl-8">
            <div class="card card-plain h-100">
                <div class="card card-calendar">
                    <div class="card-body p-3">
                        <FullCalendar class="calendar" :options="calendarOptions" />
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="row">
                <div class="col-xl-12 col-md-6 mt-xl-0 mt-4">
                    <div class="card">
                        <div class="card-header p-3 pb-0">
                            <h6 class="mb-0">Next Action Tasks</h6>
                        </div>
                        <div class="card-body border-radius-lg p-3">
                        
                            <div v-for="task in alltasks" :value="task.id" :key="task.id" class="d-flex mt-2">
                                <div class="icon icon-shape bg-gradient-dark shadow text-center">
                                    <i class="material-icons opacity-10 pt-1">notifications</i>
                                </div>
                                <div class="ms-3">
                                    <div class="numbers">
                                        <h6 class="mb-1 text-dark text-sm"> <a :href="`/client/${ task.uuid }/view`">{{ task.nexttask }}</a></h6>
                                        <span class="text-sm">{{ task.time }}</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import { Head, Link } from "@inertiajs/vue3";
import axios from 'axios';

export default {
    components: {
        Link, Head,
        FullCalendar // make the <FullCalendar> tag available
    },
    props: {
    _token: String,
    user: Object,
    color: Array,
    clients: Array,
    alltasks: Array,
    tasks: String,
  },
    data() {
        return {
            calendarOptions: {
                plugins: [dayGridPlugin, interactionPlugin],
                dateClick: this.handleDateClick,
                contentHeight: 'auto',
                initialView: "dayGridMonth",
              //  initialView: "month",
                headerToolbar: {
                    start: 'title', // will normally be on the left. if RTL, will be on the right
                    center: '',
                    end: 'today prev,next' // will normally be on the right. if RTL, will be on the left
                },
                selectable: true,
                editable: true,
                events: []
                //[{"start":"2023-03-13","title":"Call Made to remind due payments - GLORY NNKO ABSALUM","end":"2023-03-14","className":"bg-gradient-success px-2"},{"start":"2023-03-10","title":"Received Amount of 1200000 - SHIIMIA ARANYANKIRA KINISI","end":"2023-03-10","className":"bg-gradient-info px-2"},{"start":"2023-03-10","title":"Received Amount of 480000 - MATURO ZADOCK MICHAEL","end":"2023-03-10","className":"bg-gradient-info px-2"},{"start":"2023-03-08","title":"Received Amount of 9000000 - UGUMBA AMRI MUSSA","end":"2023-03-08","className":"bg-gradient-info px-2"},{"start":"2023-03-08","title":"Made aCall to ask - Peter Maroha","end":"2023-03-17","className":"bg-gradient-info px-2"},{"start":"2023-03-08","title":"Made aCall to ask - Peter Maroha","end":"2023-03-17","className":"bg-gradient-success px-2"},{"start":"2023-03-06","title":"Call Made - JACKLINE JOSEPH KIBASYA","end":"2023-03-07","className":"bg-gradient-info px-2"},{"start":"2023-02-28","title":"Received Amount of 55000 - Maria Shabani","end":"2023-02-28","className":"bg-gradient-info px-2"},{"start":"2023-02-20","title":"Pink is obviously a better color. - Peter Maroha","end":"2023-02-22","className":"bg-gradient-info px-2"},{"start":"2023-02-19","title":"Performed to Clients - Peter Maroha","end":"2023-03-01","className":"bg-gradient-success px-2"},{"start":"2023-02-18","title":"Albogast Sent New Message - Maria Shabani","end":"2023-02-18","className":"bg-gradient-info px-2"},{"start":"2023-02-18","title":"Albogast Sent New Message - Maria Shabani","end":"2023-02-18","className":"bg-gradient-info px-2"},{"start":"2023-02-18","title":"Received Amount of 80000 - Maria Shabani","end":"2023-02-18","className":"bg-gradient-info px-2"}]
            }
        }
    },
    mounted() {
    axios
      .get('/calendar_data')
      .then((response) => {
        const data = response.data;
        this.calendarOptions.events = data;
      })
      .catch((error) => {
        console.log(error);
      });
  },
    methods: {
        handleDateClick: function (arg) {
            alert('date click! ' + arg.dateStr)
        },
    }
}
</script>
<!-- <script> 
var calendar = new FullCalendar.Calendar(document.getElementById("calendar"), {
    contentHeight: 'auto',
    initialView: "dayGridMonth",
    headerToolbar: {
        start: 'title', // will normally be on the left. if RTL, will be on the right
        center: '',
        end: 'today prev,next' // will normally be on the right. if RTL, will be on the left
    },
    selectable: true,
    editable: true,
    initialDate: '2020-12-01',
    events: [{
        title: 'Call with Dave',
        start: '2020-11-18',
        end: '2020-11-18',
        className: 'bg-gradient-danger'
    },

    {
        title: 'Lunch meeting',
        start: '2020-11-21',
        end: '2020-11-22',
        className: 'bg-gradient-warning'
    },

    {
        title: 'All day conference',
        start: '2020-11-29',
        end: '2020-11-29',
        className: 'bg-gradient-success'
    },

    {
        title: 'Meeting with Mary',
        start: '2020-12-01',
        end: '2020-12-01',
        className: 'bg-gradient-info'
    },

    {
        title: 'Winter Hackaton',
        start: '2020-12-03',
        end: '2020-12-03',
        className: 'bg-gradient-danger'
    },

    {
        title: 'Digital event',
        start: '2020-12-07',
        end: '2020-12-09',
        className: 'bg-gradient-warning'
    },

    {
        title: 'Marketing event',
        start: '2020-12-10',
        end: '2020-12-10',
        className: 'bg-gradient-primary'
    },

    {
        title: 'Dinner with Family',
        start: '2020-12-19',
        end: '2020-12-19',
        className: 'bg-gradient-danger'
    },

    {
        title: 'Black Friday',
        start: '2020-12-23',
        end: '2020-12-23',
        className: 'bg-gradient-info'
    },

    {
        title: 'Cyber Week',
        start: '2020-12-02',
        end: '2020-12-02',
        className: 'bg-gradient-warning'
    },

    ],
    views: {
        month: {
            titleFormat: {
                month: "long",
                year: "numeric"
            }
        },
        agendaWeek: {
            titleFormat: {
                month: "long",
                year: "numeric",
                day: "numeric"
            }
        },
        agendaDay: {
            titleFormat: {
                month: "short",
                year: "numeric",
                day: "numeric"
            }
        }
    },
});

calendar.render();
</script>
-->
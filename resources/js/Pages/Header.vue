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
                            <h6 class="mb-0">Next events</h6>
                        </div>
                        <div class="card-body border-radius-lg p-3">
                            <div class="d-flex">
                                <div class="icon icon-shape bg-gradient-dark shadow text-center">
                                    <i class="material-icons opacity-10 pt-1">attach_money</i>
                                </div>
                                <div class="ms-3">
                                    <div class="numbers">
                                        <h6 class="mb-1 text-dark text-sm">Cyber Week</h6>
                                        <span class="text-sm">27 March 2021, at 12:30 PM</span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mt-4">
                                <div class="icon icon-shape bg-gradient-dark shadow text-center">
                                    <i class="material-icons opacity-10 pt-1">notifications</i>
                                </div>
                                <div class="ms-3">
                                    <div class="numbers">
                                        <h6 class="mb-1 text-dark text-sm">Meeting with Marry</h6>
                                        <span class="text-sm">24 March 2021, at 10:00 PM</span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mt-4">
                                <div class="icon icon-shape bg-gradient-dark shadow text-center">
                                    <i class="material-icons opacity-10 pt-1">auto_stories</i>
                                </div>
                                <div class="ms-3">
                                    <div class="numbers">
                                        <h6 class="mb-1 text-dark text-sm">Book Deposit Hall</h6>
                                        <span class="text-sm">25 March 2021, at 9:30 AM</span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mt-4">
                                <div class="icon icon-shape bg-gradient-dark shadow text-center">
                                    <i class="material-icons opacity-10 pt-1">local_shipping</i>
                                </div>
                                <div class="ms-3">
                                    <div class="numbers">
                                        <h6 class="mb-1 text-dark text-sm">Shipment Deal UK</h6>
                                        <span class="text-sm">25 March 2021, at 2:00 PM</span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mt-4">
                                <div class="icon icon-shape bg-gradient-dark shadow text-center">
                                    <i class="material-icons opacity-10 pt-1">palette</i>
                                </div>
                                <div class="ms-3">
                                    <div class="numbers">
                                        <h6 class="mb-1 text-dark text-sm">Verify Dashboard Color
                                            Palette</h6>
                                        <span class="text-sm">26 March 2021, at 9:00 AM</span>
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

export default {
    components: {
        Link, Head,
        FullCalendar // make the <FullCalendar> tag available
    },
    data() {
        return {
            calendarOptions: {
                plugins: [dayGridPlugin, interactionPlugin],
                dateClick: this.handleDateClick,
                contentHeight: 'auto',
                // initialView: "dayGridMonth",
                defaultView: "month",
                headerToolbar: {
                    start: 'title', // will normally be on the left. if RTL, will be on the right
                    center: '',
                    end: 'today prev,next' // will normally be on the right. if RTL, will be on the left
                },
                selectable: true,
                editable: true,
                events: [
                    { title: 'event 1', date: '2023-03-01' },
                    { title: 'event 2', date: '2023-03-02' },
                    {
                        title: 'Dinner with Family',
                        start: '2023-03-10',
                        end: '2023-03-11',
                        className: 'bg-gradient-danger px-2'
                    },

                    {
                        title: 'Black Friday',
                        start: '2023-03-20',
                        end: '2023-03-20',
                        className: 'bg-gradient-info'
                    },

                ]
            }
        }
    },
    methods: {
        handleDateClick: function (arg) {
            alert('date click! ' + arg.dateStr)
        }
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
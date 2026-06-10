<x-admin.layout>
    <x-admin.breadcrumb title="{{ __('Insurance Claims Calendar') }}" :links="[['text' => __('Dashboard'), 'url' => route('dashboard')], ['text' => __('Insurance Claims Calendar')]]" />

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                direction: 'rtl',
                locale: 'he',
                events: [
                    @foreach ($insuranceClaims as $claim)
                        {
                            title: '{{ ($claim->check_total ? 'NIS '. $claim->check_total : $claim->lawsuit_no) }}',
                            url: '{{ route('insurance-claims.show', [$claim]) }}',
                            start: '{{ $claim->getRawOriginal('payment_date') }}',
                        },
                    @endforeach
                ],
                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    if (info.event.url) {
                        window.open(info.event.url, '_blank');
                    }
                },
                eventDidMount: function(info) {
                    var currentDate = new Date();
                    currentDate.setHours(0, 0, 0, 0);

                    var eventDate = new Date(info.event.start);
                    eventDate.setHours(0, 0, 0, 0);

                    if (eventDate < currentDate) {
                        info.el.style.backgroundColor = '#dc3545';
                    } else if (eventDate.getTime() === currentDate.getTime()) {
                        info.el.style.backgroundColor = '#28a745';
                    } else {
                        info.el.style.backgroundColor = '#022c5e';
                    }
                }
            });

            calendar.render();
        });
    </script>
    <div id='calendar'></div>
</x-admin.layout>

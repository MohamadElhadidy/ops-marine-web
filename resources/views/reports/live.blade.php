@extends('layouts.app')
@section('title', 'منظومة التشغيل')
@section('style')
    <link href="{{ asset('css/live.css') }}" rel="stylesheet">

@endsection


@section('content')

    <div class="wrapper" id="wrapper"></div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            loadData();
        });

        function loadData() {
            $('#wrapper').load('/RLive');
        }
        var Pchannel = pusher.subscribe('live');
        var Pchannel2 = pusher2.subscribe('live');
        Pchannel.bind('add-vessel', function(data) {
            loadData();
        });
        Pchannel2.bind('add-vessel', function(data) {
            loadData();
        });
    </script>
@endsection

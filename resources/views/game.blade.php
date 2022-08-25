@extends('layout.main-layout')

@section('content')
    <style>
        .card .body{
            padding: 15px;
        }

        .player1{
            background-image: url("{{ asset('assets/img/player1.png') }}");
            background-size: cover;
        }

        .player2{
            background-image: url("{{ asset('assets/img/player2.png') }}");
            background-size: cover;
        }
    </style>
    <div class="container">
        <div class="row">
            @php $i = 0; @endphp
            @foreach($players as $row)
                @if($i++ == 1)
                    <div class="col-md-4">
                        <h2>Player 1 : {{ $row->name }}</h2>
                        <h4>Sign : {{ $row->sign }}</h4>
                    </div>
                @else
                    <div class="offset-3 col-md-4">
                        <h2>Player 2 : {{ $row->name }}</h2>
                        <h4>Sign : {{ $row->sign }}</h4>
                    </div>
                @endif
            @endforeach
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Tic Tac Toe</strong> Board ( {{ $gameInfo->bordLength.' X '.$gameInfo->bordLength }} )<a class="close" href="javascript:resetGame();"> Reset</a></h2>
                    </div>
                    <div class="body">
                        <input type="hidden" id="player" >
                        <input type="hidden" id="gameStatus" value="{{ $gameInfo->status }}" >
                        <div align="center">
                            @for($i = 0; $i < $gameInfo->bordLength; $i++)
                                @for($j = 0; $j < $gameInfo->bordLength; $j++)
                                    <a class="tilece-a" id="{{ $i.$j }}" href="javascript:makeMove({{ $i.','.$j }});"><div class="tiles"></div></a>
                                @endfor
                                <br>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(function(){
            checkTurn()
        });

        function checkTurn(){
            $.ajax({
                url: '{{ url("/check-turn/") }}',
                datatype: 'json',
                type: 'get',
                success: function (data){
                    $('#player').val(data.id);
                    alert(data.name + 's turn');
                }
            });
        }

        function resetGame(){
            $.ajax({
                url: '{{ url("/game-reset/") }}',
                datatype: 'json',
                type: 'get',
                success: function (data){
                    if(data.success){
                        alert(data.success);
                        location.reload(true);
                    }else{
                        console.log(data.error);
                    }
                }
            });
        }

        function checkResult(id,x,y){
            $.ajax({
                url: '{{ url("/check-result/") }}/'+id +'/'+x +'/'+ y,
                datatype: 'json',
                type: 'get',
                success: function(data){
                    if(data.success){
                        $('#gameStatus').val(2);
                        alert(data.success);
                    }else if(data.sorry){
                        $('#gameStatus').val(3);
                    }else{
                        checkTurn();
                    }
                }
            });
        }

        function makeMove(x,y){
            console.log(x,y);
            var player = $('#player').val();
            var status = $('#gameStatus').val();

            if(status == 1){
                if(player == 1){
                    var sign = 'player1';
                }else{
                    var sign = 'player2';
                }

                $.ajax({
                    url: '{{ url("/set-move/") }}',
                    datatype: 'json',
                    type: 'post',
                    data: {
                        'box_id_x':x,
                        'box_id_y':y,
                        'player_id': player,
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(data){
                        if(data.success){
                            $('#'+x+y).children('div').addClass(sign);
                            checkResult(player,x,y);
                        }else if(data.error){
                            alert(data.error);
                        }
                    }
                });
            }
        }
    </script>
@endsection

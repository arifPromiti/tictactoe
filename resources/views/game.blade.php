@extends('layout.main-layout')

@section('content')
    <style>
        .container {
            margin-top: 30px;
        }

        .card{
            padding: 5px;
        }

        .tiles{
            height: 80px;
            width: 80px;
            border: 2px solid #0b2e13;
            text-align: center;
            font-size: 18px;
        }

        .tilece-a{
            display: inline-block;
            text-decoration: none;
        }
    </style>
    <div class="container">
        <div class="row">
            @php $i = 0; @endphp
            @foreach($players as $row)
                @if($i++ == 1)
                    <div class="col-md-4">
                        Player 1 : {{ $row->name }}<br>
                        Sign : {{ $row->sign }}
                    </div>
                @else
                    <div class="offset-3 col-md-4">
                        Player 2 : {{ $row->name }}<br>
                        Sign : {{ $row->sign }}
                    </div>
                @endif
            @endforeach
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Tic Tac Toe</strong> Board <button type="button" class="close" data-dismiss="modal"> Reset</button></h2>
                    </div>
                    <div class="body">
                        <input type="hidden" id="player" >
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
                    $('#player').val(data.id)
                    alert(data.name + 's turn');
                }
            });
        }

        function makeMove(x,y){
            console.log(x,y);
            var player = $('#player').val();

            if(player == 1){
               var sign = 'green';
            }else{
                var sign = 'red';
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
                        $('#'+x+y).children('div').css('background-color', sign);
                        checkTurn();
                    }else if(data.error){
                        alert(data.error);
                    }
                }
            });
        }
    </script>
@endsection

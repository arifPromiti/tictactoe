@extends('layout.main-layout')

@section('content')
    <style>
        .container {
            margin-top: 30px;
        }
    </style>
    <div class="container">
        <div class="row">
            @php $i = 0; @endphp
            @foreach($players as $row)
                @if($i++ == 1)
                    <div class="col-md-4">
                        Player 1 : {{ $row->name }}
                        Sign : {{ $row->sign }}
                    </div>
                @else
                    <div class="offset-3 col-md-4">
                        Player 1 : {{ $row->name }}
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
                        @for($i = 0; $i < $gameInfo; $i++)
                            @for($j = 0; $j < $gameInfo; $j++)
                                @php $a = 'A'; @endphp
                                <a href="javascript:makeMove();"><div id="{{ $i.$a++ }}" class="tiles"></div></a>
                            @endfor
                            <br>
                        @endfor
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

                }
            });
        }

        function makeMove(){
            $.ajax({
                url: '{{ url("/set-move/") }}',
                datatype: 'json',
                type: 'post',
                data: {
                    'name': name,
                    '_token': '{{ csrf_token() }}'
                },
                success: function (data) {

                }
            });
        }
    </script>
@endsection

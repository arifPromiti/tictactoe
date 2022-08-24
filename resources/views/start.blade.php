@extends('layout.main-layout')

@section('content')
    <style>
        .card{
            padding: 5px;
        }

        .container {
            margin-top: 30px;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="offset-md-2 col-md-4 ">
                <a type="button" href="javascript:startGame();" class="btn btn-info"> Start new game</a>
            </div>
        </div>
        <div class="modal fade bs-example-modal-lg" id="gameConfigModal" role="dialog" aria-labelledby="examConfigModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="card">
                            <div class="header">
                                <h2><strong>Please </strong> Insert <button type="button" class="close" data-dismiss="modal">&times;</button></h2>
                            </div>
                            <div class="body">
                                <form action="{{ url('/startNewGame/1') }}" id="gameConfigForm" class="form-horizontal" enctype="multipart/form-data" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="subjectId">1st Player name</label>
                                                <input type="text" name="1stPlayer" id="1stPlayer" class="form-control" placeholder="Arif" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="fullMark">2nd Player name</label>
                                                <input type="text" name="2ndPlayer" id="2ndPlayer" class="form-control" placeholder="Rafiq" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="passMark">Bord Length</label>
                                                <input type="number" name="bordLength" id="bordLength" class="form-control" placeholder="Max 10." required>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <a href="javascript:saveGameConfig();" id="submitFrom" type="button" class="btn btn-success">Start game</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function startGame(){
            $("#gameConfigForm").trigger('reset');
            $('#gameConfigModal').modal('show')
        }

        function saveGameConfig(){
            $('#gameConfigForm').submit();
        }
    </script>
@endsection

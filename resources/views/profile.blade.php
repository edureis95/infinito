@extends('layouts.app')


@section('content')
    <div class="col-xs-12" style="width: 98%;">
        @include('layouts.personal_nav')
        @include('layouts.user_profile_nav')
        <div class="panel panel-default borderless" style="margin-top: 2%;">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-2">
                        <div class="row">
                            <div class="col-md-12">
                                <img src="/uploads/avatars/{{ $user-> avatar }}" style="max-width:150px; float:left; margin-right:25px; padding:2px; border:1px solid #C0C0C0">
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <table>
                            <tr>
                                <th><i class="fa fa-envelope"></i> Email:</th>
                                <th><a href="mailto:{{ $user->email }}"> {{ $user->email }} </a></th>
                            </tr>
                            @if($user->sigla != '')
                            <tr>
                                <th>Sigla: </th>
                                <th>{{$user->sigla}}</th>
                            </tr>
                            @endif
                            @if($user->cell_phone  != '')
                            <tr>
                                <th><i class="fa fa-mobile"></i> Telemóvel: </th>
                                <th> {{ $user->cell_phone }} </th>
                            </tr>
                            @endif

                            @if($user->desk_phone  != '')
                            <tr>
                                <th><i class="fa fa-phone"></i> Telefone: </th>
                                <th> {{ $user->desk_phone }} </th>
                            </tr>
                            @endif

                            @if($user->skype  != '')
                            <tr>
                                <th><i class="fa fa-skype"></i> Skype: </th>
                                <th> {{ $user->skype }} </th>
                            </tr>
                            @endif

                        </table>                            
                    </div>
                    <div class="col-md-3">
                        <table class="table table-bordered">
                            <thead><tr><th>Ações</th></tr></thead>
                            <div class="list-group">
                                <tr><th><a href="{{$user->id}}/edit" class="list-group-item list-group-action"><i class="fa fa-btn fa-pencil-square-o"> Edita o perfil</i></a></th></tr>
                            </div>
                        </table>
                    </div>
                </div>  
            </div>
        </div>
    </div>


@endsection

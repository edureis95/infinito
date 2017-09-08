@extends('layouts.app')


@section('content')
    <div class="col-xs-12" style="width: 98%;">
        @include('layouts.personal_nav')
        <div class="panel panel-default panelMenu borderless" style="height: 69px !important;">
            <div class="panel-body link-nav" style="padding-top: 40px;">
                <span style="color: black; font-size: 20px;"><a href="/profile/{{$user->id}}">{{$user->name}}</a></span>
            </div>
        </div>
        <div class="row">
            <hr style="margin-top: 0px; margin-left: 0; width: 100%;">
        </div>
        <div class="panel panel-default borderless" style="margin-top: 2%;">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-2">
                        <div class="row">
                            <div class="col-md-12">
                                <img src="/uploads/avatars/{{ $user-> avatar }}" class="img img-responsive" style="max-width:150px; float:left; margin-right:25px; padding:2px; border:1px solid #C0C0C0; width: 100%;">
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <table>
                            <tr>
                                <th><i class="fa fa-envelope"></i> Email:</th>
                                <td><a href="mailto:{{ $user->email }}"> {{ $user->email }} </a></td>
                            </tr>
                            @if($user->sigla != '')
                            <tr>
                                <th>Sigla: </th>
                                <td>{{$user->sigla}}</td>
                            </tr>
                            @endif
                            @if($user->cell_phone  != '')
                            <tr>
                                <th><i class="fa fa-mobile"></i> Telemóvel: </th>
                                <td> {{ $user->cell_phone }} </td>
                            </tr>
                            @endif

                            @if($user->desk_phone  != '')
                            <tr>
                                <th><i class="fa fa-phone"></i> Telefone: </th>
                                <td> {{ $user->desk_phone }} </td>
                            </tr>
                            @endif

                            @if($user->skype  != '')
                            <tr>
                                <th><i class="fa fa-skype"></i> Skype: </th>
                                <td> {{ $user->skype }} </td>
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
                <div class="row">
                    <div class="col-xs-2">

                    </div>
                    <div class="col-xs-6">
                        <table>
                             @if($userDetails != null)
                            <tr>
                                <th>Morada:</th>
                                <td>{{$userDetails->address}}</td>
                            </tr>
                            <tr>
                                <th>Cód. Postal:</th>
                                <td>{{$userDetails->zip_code}}</td>
                            </tr>
                            <tr>
                                <th>Localidade:</th>
                                <td>{{$userDetails->local}}</td>
                            </tr>
                            <tr>
                                <th>NIF:</th>
                                <td>{{$userDetails->nif}}</td>
                            </tr>
                            <tr>
                                <th>NISS:</th>
                                <td>{{$userDetails->niss}}</td>
                            </tr>
                            <tr>
                                <th>IBAN:</th>
                                <td>{{$userDetails->iban}}</td>
                            </tr>
                            <tr>
                                <th>Banco:</th>
                                <td>{{$userDetails->bank}}</td>
                            </tr>
                            <tr>
                                <th>Seguro:</th>
                                <td>{{$userDetails->insurance}}</td>
                            </tr>
                            @endif
                        </table>
                    </div>  
                </div>
            </div>
        </div>
    </div>


@endsection

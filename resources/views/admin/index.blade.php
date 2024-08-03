@extends('admin.layouts.admin')

@section('title', trans('skin3d::messages.title'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            
            <div class="mt-4">
                <h5>{{ trans('skin3d::messages.how_to_use') }}</h5>
                
                <ul class="list-group">
                    <li class="list-group-item">
                        <strong>{{ trans('skin3d::messages.instruction') }}</strong> => 
                        <a href="{{ url('skin3d')}}" target="_blank">
                            {{ url('skin3d')}}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@extends('admin.layouts.admin')

@section('title', trans('skin3dviewer::messages.title'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            
            <div class="mt-4">
                <h5>{{ trans('skin3dviewer::messages.how_to_use') }}</h5>
                
                <ul class="list-group">
                    <li class="list-group-item">
                        <strong>{{ trans('skin3dviewer::messages.instruction') }}</strong> => 
                        <a href="{{ url('skin3dviewer')}}" target="_blank">
                            {{ url('skin3dviewer')}}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection

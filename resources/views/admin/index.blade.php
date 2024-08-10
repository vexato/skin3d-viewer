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

                <form action="{{ route('skin3d.admin.update') }}" method="POST">
                    @csrf
                    <div class="form-group mt-4">
                        <label for="service">{{ trans('skin3d::messages.choose_service') }}</label>
                        <select class="form-control" id="service" name="service">
                            <option value="premium" {{ old('service', $currentService) == 'premium' ? 'selected' : '' }}>Premium</option>
                            <option value="skin_api" {{ old('service', $currentService) == 'skin_api' ? 'selected' : '' }}>Skin API</option>
                        </select>
                    </div>
                    <div class="form-group mt-4">
                        <label for="phrase">{{ trans('skin3d::messages.phrase') }}</label>
                        <input type="text" class="form-control" id="phrase" placeholder="{{ trans('skin3d::messages.welcome_message') }}" name="phrase" value="{{ old('phrase', $currentPhrase) }}">
                        <ul class="list-group mt-2">
                    <li class="list-group-item">
                    <strong>placeholder: => </strong>
                    <code> :name: </code>
                    </li>
                </ul>

                    </div>
                    <button type="submit" class="btn btn-primary mt-2">{{ trans('skin3d::messages.save') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection

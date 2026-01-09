@extends('admin.layouts.admin')

@section('title', trans('skin3d::messages.title'))

@push('styles')
    <link href="{{ plugin_asset('skin3d', 'css/style.css') }}" rel="stylesheet"/>
@endpush

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="mt-4">
                <h5>{{ trans('skin3d::messages.how_to_use') }}</h5>
                <ul class="list-group">

                    @if ($currentService === 'premium')
                        <li class="list-group-item">
                            <strong>{{ trans('skin3d::admin.instruction_api') }}</strong> :
                            <a href="{{ url('skin3d/3d-api/premium/')}}" target="_blank">
                                <code>{{ url('skin3d/3d-api/premium/PSEUDO')}}</code>
                            </a>
                            Or
                            <a href="{{ url('skin3d/3d-api/premium/')}}" target="_blank">
                                <code>{{ url('skin3d/3d-api/premium/PSEUDO/width/height')}}</code>
                            </a>
                        </li>

                        <li class="list-group-item">
                            <strong>{{ trans('skin3d::admin.code_api_exemple') }}</strong> :
                            <code>
                                &lt;iframe id=&quot;iframeCode&quot; src=&quot;{{ url('skin3d/3d-api/premium/PSEUDO') }}&quot; style=&quot;border: none; width: 319px; height: 221px;&quot;&gt;&lt;/iframe&gt;
                            </code>
                        </li>
                        <li class="list-group-item">
                            <strong>{{ trans('skin3d::admin.settingsURL') }}: => </strong>
                            <code> ?zoom=false </code>
                        </li>
                        <h3 class="mt-5">{{ trans('skin3d::admin.code_api_exemple') }}</h3>

                        <div class="iframe-container">
                            <div class="iframe-box">
                                <iframe id="iframeCode" src="{{ url('skin3d/3d-api/premium/PSEUDO') }}" style="border: none; width: 319px; height: 221px;"></iframe>
                                <p>{{ trans('skin3d::admin.code_api_exemple') }}</p>
                            </div>
                            <div class="iframe-box">
                                <iframe id="iframeCode2" src="{{ url('skin3d/3d-api/premium/PSEUDO?zoom=false') }}" style="border: none; width: 319px; height: 221px;"></iframe>
                                <p>{{ trans('skin3d::admin.code_api_exemple_para') }}</p>
                            </div>
                        </div>
                    @else
                        <li class="list-group-item">
                            <strong>{{ trans('skin3d::admin.instruction_api_skap') }}</strong> :
                            <a href="{{ url('skin3d/3d-api/skin-api/PSEUDO')}}" target="_blank">
                                <code>{{ url('skin3d/3d-api/skin-api/PSEUDO')}}</code>
                            </a>
                            OR 
                            <a href="{{ url('skin3d/3d-api/skin-api/PSEUDO')}}" target="_blank">
                                <code>{{ url('skin3d/3d-api/skin-api/PSEUDO/width/height')}}</code>
                            </a>
                        </li>

                        <li class="list-group-item">
                            <strong>{{ trans('skin3d::admin.code_api_exemple') }}</strong> :
                            <code>
                                &lt;iframe id=&quot;iframeCode&quot; src=&quot;{{ url('skin3d/3d-api/skin-api/PSEUDO') }}&quot; style=&quot;border: none; width: 319px; height: 221px;&quot;&gt;&lt;/iframe&gt;
                            </code>
                        </li>
                        <li class="list-group-item">
                            <strong>{{ trans('skin3d::admin.settingsURL') }}: => </strong>
                            <code> ?zoom=false </code>
                        </li>
                        <h3 class="mt-5">{{ trans('skin3d::admin.code_api_exemple') }}</h3>
                        <div class="iframe-container">
                            <div class="iframe-box">
                                <iframe id="iframeCode1" src="{{ url('skin3d/3d-api/skin-api/PSEUDO') }}" style="border: none; width: 100%; height: 221px;"></iframe>
                                <p>{{ trans('skin3d::admin.code_api_exemple') }}</p>
                            </div>
                            <div class="iframe-box">
                                <iframe id="iframeCode2" src="{{ url('skin3d/3d-api/skin-api/PSEUDO?zoom=false') }}" style="border: none; width: 100%; height: 221px;"></iframe>
                                <p>{{ trans('skin3d::admin.code_api_exemple_para') }}</p>
                            </div>
                        </div>
                    @endif

                </ul>
                <button onclick="copyIframeCode1()" class="btn btn-primary mt-3">Copy Iframe Code</button>
                <button onclick="copyIframeCode2()" class="btn btn-primary mt-3">Copy Iframe Code with parameters</button>
            </div>
        </div>
    </div>
    @push('scripts')
    <script src="{{ plugin_asset('skin3d', 'js/script.admin.js')}}"></script>
    @endpush
@endsection

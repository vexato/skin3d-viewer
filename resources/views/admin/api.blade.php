@extends('admin.layouts.admin')

@section('title', trans('skin3d::messages.title'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <!-- BETA Alert -->
            <div class="alert alert-warning d-flex justify-content-between align-items-center" role="alert">
                <span>{{ trans('skin3d::admin.beta') }}</span>
                <a href="https://discord.com/invite/E8wzUQybAN" class="btn btn-secondary ml-2"><i class="bi bi-discord"></i> Discord</a>
            </div>



            <div class="mt-4">
                <h5>{{ trans('skin3d::messages.how_to_use') }}</h5>
                <ul class="list-group">

                    @if ($currentService === 'premium')
                        <li class="list-group-item">
                            <strong>{{ trans('skin3d::admin.instruction_api') }}</strong> :
                            <a href="{{ url('skin3d/3d-api/premium/')}}" target="_blank">
                                <code>{{ url('skin3d/3d-api/premium/PSEUDO')}}</code>
                            </a>
                        </li>

                        <li class="list-group-item">
                            <strong>{{ trans('skin3d::admin.code_api_exemple') }}</strong> :
                            <a href="{{ url('skin3d/3d-api/premium/PSEUDO')}}" target="_blank">
                                <code>
                                    &lt;iframe id=&quot;iframeCode&quot; src=&quot;{{ url('skin3d/3d-api/premium/PSEUDO') }}&quot; style=&quot;border: none; width: 319px; height: 221px;&quot;&gt;&lt;/iframe&gt;
                                </code>
                            </a>
                        </li>
                        <h3 class="mt-5">{{ trans('skin3d::admin.code_api_exemple') }}</h3>
                        <iframe id="iframeCode" src="{{ url('skin3d/3d-api/premium/PSEUDO') }}" style="border: none; width: 319px; height: 221px;"></iframe>

                    @else
                        <li class="list-group-item">
                            <strong>{{ trans('skin3d::admin.instruction_api_skap') }}</strong> :
                            <a href="{{ url('skin3d/3d-api/skin-api/PSEUDO')}}" target="_blank">
                                <code>{{ url('skin3d/3d-api/skin-api/PSEUDO')}}</code>
                            </a>
                        </li>

                        <li class="list-group-item">
                            <strong>{{ trans('skin3d::admin.code_api_exemple') }}</strong> :
                            <a href="{{ url('skin3d/3d-api/skin-api/PSEUDO')}}" target="_blank">
                                <code>
                                    &lt;iframe id=&quot;iframeCode&quot; src=&quot;{{ url('skin3d/3d-api/skin-api/PSEUDO') }}&quot; style=&quot;border: none; width: 319px; height: 221px;&quot;&gt;&lt;/iframe&gt;
                                </code>
                            </a>
                        </li>

                            <h3 class="mt-5">{{ trans('skin3d::admin.code_api_exemple') }}</h3>
                        <iframe id="iframeCode" src="{{ url('skin3d/3d-api/skin-api/PSEUDO') }}" style="border: none; width: 319px; height: 221px;"></iframe>
                    @endif

                </ul>

                <button onclick="copyIframeCode()" class="btn btn-primary mt-3">Copy Iframe Code</button>
            </div>
        </div>
    </div>

    <script>
        function copyIframeCode() {
            var iframe = document.getElementById('iframeCode');
            var iframeCode = `<iframe src="${iframe.src}" style="border: none; width: 319px; height: 221px;"></iframe>`;

            navigator.clipboard.writeText(iframeCode).then(function() {
                alert('Iframe code copied to clipboard!');
            }, function(err) {
                alert('Failed to copy iframe code: ', err);
            });
        }
    </script>
@endsection

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
                        </li>

                        <li class="list-group-item">
                            <strong>{{ trans('skin3d::admin.code_api_exemple') }}</strong> :
                            <a href="{{ url('skin3d/3d-api/skin-api/PSEUDO')}}" target="_blank">
                                <code>
                                    &lt;iframe id=&quot;iframeCode&quot; src=&quot;{{ url('skin3d/3d-api/skin-api/PSEUDO') }}&quot; style=&quot;border: none; width: 319px; height: 221px;&quot;&gt;&lt;/iframe&gt;
                                </code>
                            </a>
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
                <style>
                    .iframe-container {
                        display: flex; /* Permet de placer les boîtes côte à côte */
                        justify-content: space-between; /* Espacement entre les boîtes */
                        flex-wrap: wrap; /* Permet de passer à la ligne si l'espace est insuffisant */
                    }

                    .iframe-box {
                        border-radius: 10px;
                        border: 1px solid #ccc; /* Bordure autour de chaque iframe */
                        padding: 10px; /* Espacement à l'intérieur de la boîte */
                        width: 48%; /* Largeur de chaque boîte */
                        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1); /* Ombre pour un effet de profondeur */
                        margin-bottom: 20px; /* Espacement entre les boîtes sur petits écrans */
                    }

                    @media (max-width: 768px) { /* Pour les écrans de 768px ou moins */
                        .iframe-box {
                            width: 100%; /* Chaque boîte prend toute la largeur */
                        }
                    }
                </style>
                <button onclick="copyIframeCode1()" class="btn btn-primary mt-3">Copy Iframe Code</button>
                <button onclick="copyIframeCode2()" class="btn btn-primary mt-3">Copy Iframe Code with parameters</button>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>

        function copyIframeCode1() {
            var iframe = document.getElementById('iframeCode1');
            var iframeCode = `<iframe src="${iframe.src}" style="border: none; width: 319px; height: 221px;"></iframe>`;

            navigator.clipboard.writeText(iframeCode).then(function() {
                alert('Iframe code copied to clipboard!');
            }, function(err) {
                alert('Failed to copy iframe code: ', err);
            });
        }
        function copyIframeCode2() {
            var iframe = document.getElementById('iframeCode2');
            var iframeCode = `<iframe src="${iframe.src}" style="border: none; width: 319px; height: 221px;"></iframe>`;

            navigator.clipboard.writeText(iframeCode).then(function() {
                alert('Iframe code copied to clipboard!');
            }, function(err) {
                alert('Failed to copy iframe code: ', err);
            });
        }
    </script>
@endpush
@endsection

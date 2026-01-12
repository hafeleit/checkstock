@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'SALES USI'])

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-between">
                            <div>
                                <div class="d-flex align-items-center">
                                    <h6 class="mb-0 h3">SALES USI</h6>
                                </div>
                                @php
                                    $yesterday = date('d/m/Y', strtotime('-1 day'));
                                @endphp
                                <p class="text-uppercase text-secondary text-xxs font-weight-bolder">LAST UPDATE: {{ $yesterday }} 20:00</p>
                            </div>
                            <div>
                                <a href="{{ url()->previous() }}" id="backButton" type="button" class="btn btn-secondary d-flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-arrow-bar-left" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M12.5 15a.5.5 0 0 1-.5-.5v-13a.5.5 0 0 1 1 0v13a.5.5 0 0 1-.5.5M10 8a.5.5 0 0 1-.5.5H3.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L3.707 7.5H9.5a.5.5 0 0 1 .5.5" />
                                    </svg>
                                    <div>BACK</div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-md-3">
                                <img id="item_preview" src="/img/495.06.101.jpg" class="img-thumbnail">
                            </div>
                            <div class="col-md-9">
                                <div class="mb-3">
                                    <label class="fw-bold text-lg">Catalog <span class="text-xs gray">(Last version)</span></label>
                                    <div class="mx-3 underline">
                                        <a href="/files/sample_pdf.pdf" target="_blank" id="downloadCatalog" class="download-link">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filetype-pdf" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.6 11.85H0v3.999h.791v-1.342h.803q.43 0 .732-.173.305-.175.463-.474a1.4 1.4 0 0 0 .161-.677q0-.375-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179m.545 1.333a.8.8 0 0 1-.085.38.57.57 0 0 1-.238.241.8.8 0 0 1-.375.082H.788V12.48h.66q.327 0 .512.181.185.183.185.522m1.217-1.333v3.999h1.46q.602 0 .998-.237a1.45 1.45 0 0 0 .595-.689q.196-.45.196-1.084 0-.63-.196-1.075a1.43 1.43 0 0 0-.589-.68q-.396-.234-1.005-.234zm.791.645h.563q.371 0 .609.152a.9.9 0 0 1 .354.454q.118.302.118.753a2.3 2.3 0 0 1-.068.592 1.1 1.1 0 0 1-.196.422.8.8 0 0 1-.334.252 1.3 1.3 0 0 1-.483.082h-.563zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638z" />
                                            </svg>
                                            <u>sample_catelog_version_01.pdf</u>
                                        </a>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="fw-bold text-lg">Manual <span class="text-xs">(Last version)</span></label>
                                    <div class="mx-3 underline">
                                        <a href="/files/sample_pdf.pdf" target="_blank" id="downloadManual" class="download-link">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filetype-pdf" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.6 11.85H0v3.999h.791v-1.342h.803q.43 0 .732-.173.305-.175.463-.474a1.4 1.4 0 0 0 .161-.677q0-.375-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179m.545 1.333a.8.8 0 0 1-.085.38.57.57 0 0 1-.238.241.8.8 0 0 1-.375.082H.788V12.48h.66q.327 0 .512.181.185.183.185.522m1.217-1.333v3.999h1.46q.602 0 .998-.237a1.45 1.45 0 0 0 .595-.689q.196-.45.196-1.084 0-.63-.196-1.075a1.43 1.43 0 0 0-.589-.68q-.396-.234-1.005-.234zm.791.645h.563q.371 0 .609.152a.9.9 0 0 1 .354.454q.118.302.118.753a2.3 2.3 0 0 1-.068.592 1.1 1.1 0 0 1-.196.422.8.8 0 0 1-.334.252 1.3 1.3 0 0 1-.483.082h-.563zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638z" />
                                            </svg>
                                            <u>sample_manual_version_01.pdf</u>
                                        </a>
                                    </div>
                                </div>
                                <div>
                                    <label class="fw-bold text-lg">Spare part</label>
                                    <div class="mx-3"> Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        document.addEventListener('DOMContentLoaded', function() {
            const backBtn = document.getElementById('backButton');

            if (backBtn) {
                backBtn.addEventListener('click', function(event) {
                    event.preventDefault();
                    window.history.back();
                });
            }            
        });
    </script>
@endsection

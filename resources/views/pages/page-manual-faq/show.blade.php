@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'FAQ'])

    <link rel="stylesheet" href="{{ asset('assets/css/page-manual-faq.css') }}">

    <div class="container-fluid relative py-4">
        <div class="row mt-4 justify-content-center">
            <div>
                <div class="card">
                    <div class="card-header pb-0">
                        {{-- Page header --}}
                        <div class="faq-show-hero mb-3">
                            <div class="faq-show-hero-icon">
                                <i class="fas fa-question"></i>
                            </div>
                            <div class="faq-show-hero-text">
                                <h5 class="mb-0">{{ $pageLabel }}</h5>
                                <p class="mb-0">User Manual &amp; Frequently Asked Questions</p>
                            </div>
                            <span class="faq-show-count">{{ $faqs->count() }} questions</span>
                        </div>

                        {{-- Search --}}
                        <div class="faq-show-search-wrap mb-3">
                            <i class="fas fa-search faq-show-search-icon"></i>
                            <input type="text" id="faq-search" class="faq-show-search-input"
                                   placeholder="Search questions...">
                        </div>
                    </div>

                    <div class="card-body pt-2">
                        {{-- FAQ list --}}
                        <div id="faq-list">
                            @forelse ($faqs as $i => $faq)
                                <div class="faq-show-item" data-question="{{ strtolower($faq->question) }}">
                                    <button class="faq-show-question collapsed"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#faq-ans-{{ $faq->id }}"
                                            aria-expanded="false">
                                        <span class="faq-show-num">{{ $i + 1 }}</span>
                                        <span class="faq-show-q-text">{{ $faq->question }}</span>
                                        <span class="faq-show-chevron"><i class="fas fa-chevron-down"></i></span>
                                    </button>
                                    <div id="faq-ans-{{ $faq->id }}" class="collapse faq-show-answer">
                                        <div class="faq-show-answer-body">
                                            <p class="faq-show-answer-text">{{ $faq->answer }}</p>
                                            @if($faq->pdf_file_path)
                                                <a href="{{ asset("storage/{$faq->pdf_file_path}") }}"
                                                   target="_blank" class="faq-show-pdf-btn">
                                                    <i class="fas fa-file-pdf"></i>
                                                    <span>Manual</span>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="faq-show-empty">
                                    <i class="fas fa-inbox"></i>
                                    <p>No FAQ data available for this page.</p>
                                </div>
                            @endforelse
                        </div>

                        {{-- No search result --}}
                        <div id="faq-no-result" class="faq-show-empty d-none">
                            <i class="fas fa-search"></i>
                            <p>No questions matching "<span id="faq-no-result-term"></span>"</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        document.getElementById('faq-search').addEventListener('input', function () {
            var term = this.value.trim().toLowerCase();
            var items = document.querySelectorAll('#faq-list .faq-show-item');
            var visible = 0;

            items.forEach(function (item) {
                var match = !term || item.dataset.question.includes(term);
                item.classList.toggle('d-none', !match);
                if (match) visible++;
            });

            var noResult = document.getElementById('faq-no-result');
            noResult.classList.toggle('d-none', visible > 0 || !term);
            if (!visible && term) {
                document.getElementById('faq-no-result-term').textContent = term;
            }
        });
    </script>
@endsection

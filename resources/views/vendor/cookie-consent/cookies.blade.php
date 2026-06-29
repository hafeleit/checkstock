<aside id="cookies-policy" class="cookies cookies--no-js" data-text="{{ json_encode(__('cookieConsent::cookies.details')) }}">
    <div class="cookies__alert">
        <div class="cookies__container">
            <div class="cookies__wrapper">
                <div class="cookies__header">
                    <svg class="cookies__icon" width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10c0-.34-.02-.67-.05-1A3 3 0 0 1 17 7a3 3 0 0 1-3-3 3 3 0 0 1-.05-.49C13.34 2.03 12.68 2 12 2z" fill="#C8102E" opacity=".15"/>
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10c0-.34-.02-.67-.05-1A3 3 0 0 1 17 7a3 3 0 0 1-3-3 3 3 0 0 1-.05-.49C13.34 2.03 12.68 2 12 2z" stroke="#C8102E" stroke-width="1.5" fill="none"/>
                        <circle cx="8.5" cy="11.5" r="1.5" fill="#C8102E"/>
                        <circle cx="14.5" cy="14" r="1" fill="#C8102E"/>
                        <circle cx="13" cy="9" r="1" fill="#C8102E"/>
                    </svg>
                    <h2 class="cookies__title">@lang('cookieConsent::cookies.title')</h2>
                </div>
                <div class="cookies__intro">
                    <p>@lang('cookieConsent::cookies.intro')</p>
                    @if($policy)
                        <p>@lang('cookieConsent::cookies.link', ['url' => $policy])</p>
                    @endif
                </div>
                <div class="cookies__actions">
                    @cookieconsentbutton(action: 'accept.essentials', label: __('cookieConsent::cookies.essentials'), attributes: ['class' => 'cookiesBtn cookiesBtn--essentials'])
                    @cookieconsentbutton(action: 'accept.all', label: __('cookieConsent::cookies.all'), attributes: ['class' => 'cookiesBtn cookiesBtn--accept'])
                </div>
            </div>
        </div>
        <a href="#cookies-policy-customize" class="cookies__btn cookies__btn--customize">
            <span>@lang('cookieConsent::cookies.customize')</span>
            <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M14.7559 11.9782C15.0814 11.6527 15.0814 11.1251 14.7559 10.7996L10.5893 6.63297C10.433 6.47669 10.221 6.3889 10 6.38889C9.77899 6.38889 9.56703 6.47669 9.41075 6.63297L5.24408 10.7996C4.91864 11.1251 4.91864 11.6527 5.24408 11.9782C5.56951 12.3036 6.09715 12.3036 6.42259 11.9782L10 8.40074L13.5774 11.9782C13.9028 12.3036 14.4305 12.3036 14.7559 11.9782Z" fill="#6b7280"/>
            </svg>
        </a>
        <div class="cookies__expandable cookies__expandable--custom" id="cookies-policy-customize">
            <form action="{{ route('cookieconsent.accept.configuration') }}" method="post" class="cookies__customize">
                @csrf
                <div class="cookies__sections">
                    @foreach($cookies->getCategories() as $category)
                    <div class="cookies__section">
                        <label for="cookies-policy-check-{{ $category->key() }}" class="cookies__category">
                            @if ($category->key() === 'essentials')
                                <input type="hidden" name="categories[]" value="{{ $category->key() }}" />
                                <input type="checkbox" name="categories[]" value="{{ $category->key() }}" id="cookies-policy-check-{{ $category->key() }}" checked="checked" disabled="disabled" />
                            @else
                                <input type="checkbox" name="categories[]" value="{{ $category->key() }}" id="cookies-policy-check-{{ $category->key() }}" />
                            @endif
                            <span class="cookies__box">
                                <strong class="cookies__label">{{ $category->title }}</strong>
                            </span>
                            @if($category->description)
                                <p class="cookies__info">{{ $category->description }}</p>
                            @endif
                        </label>

                        <div class="cookies__expandable" id="cookies-policy-{{ $category->key() }}">
                            <ul class="cookies__definitions">
                                @foreach($category->getCookies() as $cookie)
                                <li class="cookies__cookie">
                                    <p class="cookies__name">{{ $cookie->name }}</p>
                                    <p class="cookies__duration">{{ Carbon\Carbon::now()->diffForHumans(Carbon\Carbon::now()->addMinutes($cookie->duration), true) }}</p>
                                    @if($cookie->description)
                                        <p class="cookies__description">{{ $cookie->description }}</p>
                                    @endif
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <a href="#cookies-policy-{{ $category->key() }}" class="cookies__details">@lang('cookieConsent::cookies.details.more')</a>
                    </div>
                    @endforeach
                </div>
                <div class="cookies__save">
                    <button type="submit" class="cookiesBtn__link">@lang('cookieConsent::cookies.save')</button>
                </div>
            </form>
        </div>
    </div>
</aside>

{{-- STYLES & SCRIPT --}}

<script data-cookie-consent nonce="{{ $csp_script_nonce }}">
    {!! file_get_contents(LCC_ROOT . '/dist/script.js') !!}
</script>
<style data-cookie-consent nonce="{{ $csp_style_nonce }}">
    {!! file_get_contents(LCC_ROOT . '/dist/style.css') !!}

    /* ── Modern Redesign ── */
    #cookies-policy.cookies {
        bottom: 20px;
        left: 20px;
        right: auto;
    }

    #cookies-policy .cookies__alert {
        width: 26em;
        border-radius: 16px;
        border: none;
        background: #ffffff;
    }

    /* Mobile: full-width banner at bottom */
    @media (max-width: 600px) {
        #cookies-policy.cookies {
            bottom: 0;
            left: 0;
            right: 0;
        }
        #cookies-policy .cookies__alert {
            width: 100%;
            max-width: 100%;
            margin: 0;
            border-radius: 16px 16px 0 0;
        }
    }

    #cookies-policy .cookies__wrapper {
        padding: 1.5em 1.5em 1.25em;
    }

    /* Header row: icon + title */
    #cookies-policy .cookies__header {
        display: flex;
        align-items: center;
        gap: .5em;
        margin-bottom: .75em;
    }

    #cookies-policy .cookies__icon {
        flex-shrink: 0;
    }

    #cookies-policy .cookies__title {
        margin-bottom: 0;
        font-size: 1em;
        font-weight: 700;
        color: #111827;
    }

    #cookies-policy .cookies__intro {
        color: #4b5563;
        font-size: .8125em;
        line-height: 1.55;
    }

    #cookies-policy .cookies__intro p { margin-top: .6em; }
    #cookies-policy .cookies__intro p:first-child { margin-top: 0; }

    /* Buttons: side by side */
    #cookies-policy .cookies__actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        margin-top: 1.1em;
    }

    #cookies-policy .cookiesBtn { width: 100%; }

    #cookies-policy .cookiesBtn__link {
        border-radius: 8px;
        font-size: .8125em;
        font-weight: 600;
        padding: .7em 1em;
        transition: background .18s ease, border-color .18s ease, color .18s ease, box-shadow .18s ease;
        white-space: nowrap;
    }

    /* "Only essentials" → outlined */
    #cookies-policy .cookiesBtn--essentials .cookiesBtn__link {
        background: transparent;
        border: 1.5px solid #C8102E;
        color: #C8102E;
    }
    #cookies-policy .cookiesBtn--essentials .cookiesBtn__link:hover,
    #cookies-policy .cookiesBtn--essentials .cookiesBtn__link:focus {
        background: #fff0f1;
        opacity: 1;
    }

    /* "Accept all" → filled */
    #cookies-policy .cookiesBtn--accept .cookiesBtn__link {
        background: #C8102E;
        border: 1.5px solid #C8102E;
        color: #fff;
        box-shadow: 0 2px 8px rgba(200,16,46,.25);
    }
    #cookies-policy .cookiesBtn--accept .cookiesBtn__link:hover,
    #cookies-policy .cookiesBtn--accept .cookiesBtn__link:focus {
        background: #a50d26;
        border-color: #a50d26;
        box-shadow: 0 4px 12px rgba(200,16,46,.35);
        opacity: 1;
    }

    /* Customize bar */
    #cookies-policy .cookies__btn--customize {
        padding: .875em 1.5em;
        font-size: .8125em;
        color: #6b7280;
        border-top: 1px solid #f3f4f6;
        transition: background .15s ease, color .15s ease;
    }
    #cookies-policy .cookies__btn--customize:hover {
        background: #f9fafb;
        color: #374151;
    }

    /* Expand section */
    #cookies-policy .cookies__section {
        padding: .75em 1.5em;
    }
    #cookies-policy .cookies__section + .cookies__section {
        border-top: 1px solid #f3f4f6;
    }

    #cookies-policy .cookies__label {
        font-size: .8125em;
        color: #111827;
    }
    #cookies-policy .cookies__info {
        font-size: .75em;
        color: #6b7280;
    }

    /* Toggle: CI color */
    #cookies-policy .cookies__category input:checked + .cookies__box:after {
        background: #C8102E;
    }
    #cookies-policy .cookies__box:after {
        background: #e5e7eb;
    }

    /* Details link */
    #cookies-policy .cookies__details,
    #cookies-policy .cookies__details:focus,
    #cookies-policy .cookies__details:hover {
        color: #C8102E;
        font-size: .75em;
    }

    /* Cookie list items */
    #cookies-policy .cookies__name { color: #374151; font-weight: 600; }
    #cookies-policy .cookies__duration { color: #9ca3af; }
    #cookies-policy .cookies__description { color: #6b7280; }

    /* Save button */
    #cookies-policy .cookies__save {
        padding: .875em 1.5em;
        border-top: 1px solid #f3f4f6;
    }
    #cookies-policy .cookies__save .cookiesBtn__link {
        background: #C8102E;
        border: 1.5px solid #C8102E;
        color: #fff;
        border-radius: 8px;
        width: auto;
        padding: .6em 1.5em;
        font-size: .8125em;
        box-shadow: 0 2px 8px rgba(200,16,46,.2);
    }
    #cookies-policy .cookies__save .cookiesBtn__link:hover,
    #cookies-policy .cookies__save .cookiesBtn__link:focus {
        background: #a50d26;
        border-color: #a50d26;
        opacity: 1;
    }

    /* Intro link hover */
    #cookies-policy .cookies__intro a:focus,
    #cookies-policy .cookies__intro a:hover {
        color: #C8102E;
    }
</style>

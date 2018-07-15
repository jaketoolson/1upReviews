@include('layouts.partials._headerhtml', ['bodyAttributes' => ['class' => 'bg-account-pages']])

<main id="root" role="main">
    <section>
        <div class="container">
            <div class="col-12">
                <div class="wrapper-page">
                    <div class="account-pages">
                        <div class="account-box">
                            <div class="account-logo-box">
                                <h2 class="text-uppercase text-center">
                                    <a href="/" class="text-success">
                                        <span>
                                            <img src="/assets/images/froggy_text.png" alt="" height="44">
                                        </span>
                                    </a>
                                </h2>
                            </div>
                            <div class="account-content">
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@include('layouts.partials._footerhtml')

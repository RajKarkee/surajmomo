    @extends('layouts.app')
    @section('content')
        <div id="products" class="page-section">
            <section class="products">
                <div class="container">
                    @if ($jumbotron)
                        <div class="row align-items-center mb-5">
                            <div class="col-lg-6 slide-in-left">
                                <h2>{{ $jumbotron->title }}</h2>
                                <p class="lead">{{ $jumbotron->subtitle }}</p>
                            </div>
                            <div class="col-lg-6 slide-in-right">
                                @if ($jumbotron->other_image)
                                    <img src="{{ asset('storage/' . $jumbotron->other_image) }}" alt="Jumbotron Image"
                                        class="img-fluid rounded-3 shadow">
                                @else
                                    <img src="https://images.unsplash.com/photo-1496412705862-e0088f16f791?w=600&h=400&fit=crop"
                                        alt="Frozen Momos" class="img-fluid rounded-3 shadow">
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="row align-items-center mb-5">
                            <div class="col-lg-6 slide-in-left">
                                <h2>Our Premium Frozen Momos</h2>
                                <p class="lead">Discover our authentic collection of frozen momos, each carefully crafted
                                    with
                                    traditional recipes and premium ingredients. From classic chicken to vegetarian
                                    delights, we
                                    have something for every taste.</p>
                            </div>
                            <div class="col-lg-6 slide-in-right">
                                <img src="https://images.unsplash.com/photo-1496412705862-e0088f16f791?w=600&h=400&fit=crop"
                                    alt="Frozen Momos" class="img-fluid rounded-3 shadow">
                            </div>
                        </div>
                    @endif

                    <!-- Ongoing Offers -->
                    @if ($offers->isNotEmpty())
                        <div class="row mb-5">

                            @foreach ($offers as $offer)
                                <div class="col-12">
                                    <div class="alert alert-warning pulse text-center">
                                        <h4><i class="fas fa-fire"></i> {{ $offer->title }}</h4>
                                        <p class="mb-0">{{ $offer->description }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <!-- Products Grid -->
                    <div class="row" id="productsGrid">
                        <!-- Products will be loaded here by JavaScript -->
                    </div>
                </div>
            </section>
        </div>
    @endsection

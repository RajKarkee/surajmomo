    @extends('layouts.app')
    @section('content')
        <div id="products" class="page-section">
            <section class="products">
                <div class="container">
                    <div class="row align-items-center mb-5">
                        <div class="col-lg-6 slide-in-left">
                            <h2>Our Premium Frozen Momos</h2>
                            <p class="lead">Discover our authentic collection of frozen momos, each carefully crafted with
                                traditional recipes and premium ingredients. From classic chicken to vegetarian delights, we
                                have something for every taste.</p>
                        </div>
                        <div class="col-lg-6 slide-in-right">
                            <img src="https://images.unsplash.com/photo-1496412705862-e0088f16f791?w=600&h=400&fit=crop"
                                alt="Frozen Momos" class="img-fluid rounded-3 shadow">
                        </div>
                    </div>

                    <!-- Ongoing Offers -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <div class="alert alert-warning pulse text-center">
                                <h4><i class="fas fa-fire"></i> Special Offer!</h4>
                                <p class="mb-0">Buy 2 Get 1 Free on all Chicken Momos | 20% off on orders above Rs. 1000
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Products Grid -->
                    <div class="row" id="productsGrid">
                        <!-- Products will be loaded here by JavaScript -->
                    </div>
                </div>
            </section>
        </div>
    @endsection

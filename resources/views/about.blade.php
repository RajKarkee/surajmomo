   @extends('layouts.app')

   @section('content')
       <div id="about" class="page-section">
           <!-- Hero Section -->
           <section class="about-hero">
               <div class="container">
                   <div class="row align-items-center">
                       <div class="col-lg-8 mx-auto text-center">
                           <h1 class="hero-title mb-4">About {{ $globalSettings->site_name ?? 'Frozen Momo' }}</h1>
                           <p class="hero-subtitle">Bringing authentic Nepali flavors to your doorstep with love, tradition,
                               and quality.</p>
                       </div>
                   </div>
               </div>
           </section>

           <section class="about-section py-5">
               <div class="container">
                   <!-- What We Do Section -->
                   <div class="row align-items-center mb-5">
                       <div class="col-lg-6 slide-in-left">
                           <h2 class="section-title mb-4">What We Do</h2>
                           <p class="lead mb-4">At {{ $globalSettings->site_name ?? 'Frozen Momo' }}, we are passionate
                               about bringing you the authentic taste of traditional momos with modern convenience.</p>
                           <ul class="list-unstyled feature-list">
                               <li class="mb-3 d-flex align-items-center">
                                   <i class="fas fa-check-circle text-success me-3 fs-5"></i>
                                   <span>We craft delicious momos with authentic recipes</span>
                               </li>
                               <li class="mb-3 d-flex align-items-center">
                                   <i class="fas fa-check-circle text-success me-3 fs-5"></i>
                                   <span>Frozen fresh to lock in taste and nutrition</span>
                               </li>
                               <li class="mb-3 d-flex align-items-center">
                                   <i class="fas fa-check-circle text-success me-3 fs-5"></i>
                                   <span>Available in multiple varieties and flavors</span>
                               </li>
                               <li class="mb-3 d-flex align-items-center">
                                   <i class="fas fa-check-circle text-success me-3 fs-5"></i>
                                   <span>Committed to quality, hygiene, and customer satisfaction</span>
                               </li>
                           </ul>
                       </div>
                       <div class="col-lg-6 slide-in-right">
                           <div class="about-image">
                               <img src="https://images.unsplash.com/photo-1496412705862-e0088f16f791?w=600&h=400&fit=crop"
                                   alt="Our Kitchen" class="img-fluid rounded shadow">
                           </div>
                       </div>
                   </div>

                   <!-- Stats Section -->
                   <div class="stats-section mb-5">
                       <div class="row text-center">
                           <div class="col-md-3 col-6 mb-4">
                               <div class="stat-card">
                                   <div class="stat-icon">
                                       <i class="fas fa-users"></i>
                                   </div>
                                   <h3 class="stat-number">5000+</h3>
                                   <p class="stat-label">Happy Customers</p>
                               </div>
                           </div>
                           <div class="col-md-3 col-6 mb-4">
                               <div class="stat-card">
                                   <div class="stat-icon">
                                       <i class="fas fa-award"></i>
                                   </div>
                                   <h3 class="stat-number">5+</h3>
                                   <p class="stat-label">Years Experience</p>
                               </div>
                           </div>
                           <div class="col-md-3 col-6 mb-4">
                               <div class="stat-card">
                                   <div class="stat-icon">
                                       <i class="fas fa-star"></i>
                                   </div>
                                   <h3 class="stat-number">4.9</h3>
                                   <p class="stat-label">Average Rating</p>
                               </div>
                           </div>
                           <div class="col-md-3 col-6 mb-4">
                               <div class="stat-card">
                                   <div class="stat-icon">
                                       <i class="fas fa-shipping-fast"></i>
                                   </div>
                                   <h3 class="stat-number">24/7</h3>
                                   <p class="stat-label">Fresh Delivery</p>
                               </div>
                           </div>
                       </div>
                   </div>

                   <!-- Our Story Section -->
                   <div class="row align-items-center mb-5">
                       <div class="col-lg-6 slide-in-left">
                           <div class="story-image">
                               <img src="https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=600&h=400&fit=crop"
                                   alt="Our Story" class="img-fluid rounded shadow">
                           </div>
                       </div>
                       <div class="col-lg-6 slide-in-right">
                           <h2 class="section-title mb-4">Our Story</h2>
                           <p class="mb-4">Founded with a passion for authentic Nepali cuisine,
                               {{ $globalSettings->site_name ?? 'Frozen Momo' }} started as a small family business with a
                               big dream - to share the incredible flavors of traditional momos with food lovers everywhere.
                           </p>
                           <p class="mb-4">Our journey began in the heart of Nepal, where we learned the ancient art of
                               momo making from generations of skilled cooks. Each recipe has been carefully preserved and
                               perfected to bring you the most authentic taste experience.</p>
                           <p class="mb-4">Today, we continue to honor these traditions while embracing modern techniques
                               to ensure our momos reach you fresh, flavorful, and ready to enjoy.</p>
                       </div>
                   </div>

                   <!-- Why Choose Us Section -->
                   <div class="why-choose-section mb-5">
                       <div class="row">
                           <div class="col-12 text-center mb-5">
                               <h2 class="section-title">Why Choose Us?</h2>
                               <p class="lead">We're committed to delivering excellence in every bite</p>
                           </div>
                       </div>
                       <div class="row g-4">
                           <div class="col-lg-4 col-md-6">
                               <div class="feature-card text-center h-100">
                                   <div class="feature-icon mb-4">
                                       <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=160&h=160&fit=crop&crop=center"
                                           alt="100% Natural" class="feature-image">
                                   </div>
                                   <h4 class="mb-3">100% Natural</h4>
                                   <p>Made with fresh, natural ingredients without any artificial preservatives or
                                       chemicals. Pure goodness in every bite.</p>
                                   <div class="feature-badge">Organic</div>
                               </div>
                           </div>
                           <div class="col-lg-4 col-md-6">
                               <div class="feature-card text-center h-100">
                                   <div class="feature-icon mb-4">
                                       <img src="https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=160&h=160&fit=crop&crop=center"
                                           alt="Flash Frozen" class="feature-image">
                                   </div>
                                   <h4 class="mb-3">Flash Frozen</h4>
                                   <p>Our advanced freezing technology locks in freshness and flavor for weeks without
                                       compromising quality or taste.</p>
                                   <div class="feature-badge">Fresh</div>
                               </div>
                           </div>
                           <div class="col-lg-4 col-md-6">
                               <div class="feature-card text-center h-100">
                                   <div class="feature-icon mb-4">
                                       <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=160&h=160&fit=crop&crop=center"
                                           alt="Made with Love" class="feature-image">
                                   </div>
                                   <h4 class="mb-3">Made with Love</h4>
                                   <p>Every momo is handcrafted with care and attention to detail by our experienced chefs
                                       who take pride in their work.</p>
                                   <div class="feature-badge">Handmade</div>
                               </div>
                           </div>
                           <div class="col-lg-4 col-md-6">
                               <div class="feature-card text-center h-100">
                                   <div class="feature-icon mb-4">
                                       <img src="https://images.unsplash.com/photo-1556909114-462e17fcf50c?w=160&h=160&fit=crop&crop=center"
                                           alt="Quality Assured" class="feature-image">
                                   </div>
                                   <h4 class="mb-3">Quality Assured</h4>
                                   <p>Rigorous quality checks ensure every product meets our high standards before reaching
                                       your table.</p>
                                   <div class="feature-badge">Certified</div>
                               </div>
                           </div>
                           <div class="col-lg-4 col-md-6">
                               <div class="feature-card text-center h-100">
                                   <div class="feature-icon mb-4">
                                       <img src="https://images.unsplash.com/photo-1551218808-94e220e084d2?w=160&h=160&fit=crop&crop=center"
                                           alt="Quick & Easy" class="feature-image">
                                   </div>
                                   <h4 class="mb-3">Quick & Easy</h4>
                                   <p>Ready to cook in minutes - perfect for busy lifestyles without compromising on
                                       authentic taste and quality.</p>
                                   <div class="feature-badge">Fast</div>
                               </div>
                           </div>
                           <div class="col-lg-4 col-md-6">
                               <div class="feature-card text-center h-100">
                                   <div class="feature-icon mb-4">
                                       <img src="https://images.unsplash.com/photo-1496412705862-e0088f16f791?w=160&h=160&fit=crop&crop=center"
                                           alt="Variety of Flavors" class="feature-image">
                                   </div>
                                   <h4 class="mb-3">Variety of Flavors</h4>
                                   <p>From classic chicken to vegetarian delights - something delicious for everyone in the
                                       family to enjoy.</p>
                                   <div class="feature-badge">Variety</div>
                               </div>
                           </div>
                       </div>
                   </div>

                   <!-- Customer Testimonials Section -->
                   <div class="testimonials-section mb-5">
                       <div class="container">
                           <div class="row">
                               <div class="col-12 text-center mb-5">
                                   <h2 class="section-title">What Our Customers Say</h2>
                                   <p class="lead">Don't just take our word for it - hear from our happy customers!</p>
                               </div>
                           </div>
                           <div class="row g-4">
                               <div class="col-lg-4 col-md-6">
                                   <div class="testimonial-card">
                                       <div class="stars mb-3">
                                           <i class="fas fa-star"></i>
                                           <i class="fas fa-star"></i>
                                           <i class="fas fa-star"></i>
                                           <i class="fas fa-star"></i>
                                           <i class="fas fa-star"></i>
                                       </div>
                                       <p class="testimonial-text">"Absolutely delicious! These momos taste just like the
                                           ones I had in Nepal. The quality is outstanding and they're so convenient to
                                           prepare."</p>
                                       <div class="customer-info">
                                           <div class="customer-avatar">
                                               <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?w=100&h=100&fit=crop&crop=face"
                                                   alt="Sarah Johnson">
                                           </div>
                                           <div class="customer-details">
                                               <h5>Sarah Johnson</h5>
                                               <span>Food Blogger</span>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                               <div class="col-lg-4 col-md-6">
                                   <div class="testimonial-card">
                                       <div class="stars mb-3">
                                           <i class="fas fa-star"></i>
                                           <i class="fas fa-star"></i>
                                           <i class="fas fa-star"></i>
                                           <i class="fas fa-star"></i>
                                           <i class="fas fa-star"></i>
                                       </div>
                                       <p class="testimonial-text">"Perfect for busy weeknights! My family loves them and
                                           they're ready in just 10 minutes. The flavors are amazing and authentic."</p>
                                       <div class="customer-info">
                                           <div class="customer-avatar">
                                               <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&h=100&fit=crop&crop=face"
                                                   alt="Michael Chen">
                                           </div>
                                           <div class="customer-details">
                                               <h5>Michael Chen</h5>
                                               <span>Working Father</span>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                               <div class="col-lg-4 col-md-6">
                                   <div class="testimonial-card">
                                       <div class="stars mb-3">
                                           <i class="fas fa-star"></i>
                                           <i class="fas fa-star"></i>
                                           <i class="fas fa-star"></i>
                                           <i class="fas fa-star"></i>
                                           <i class="fas fa-star"></i>
                                       </div>
                                       <p class="testimonial-text">"I've tried many frozen momos but these are by far the
                                           best! The spices and flavor profile are perfectly balanced. Highly recommended!"
                                       </p>
                                       <div class="customer-info">
                                           <div class="customer-avatar">
                                               <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=100&h=100&fit=crop&crop=face"
                                                   alt="Priya Sharma">
                                           </div>
                                           <div class="customer-details">
                                               <h5>Priya Sharma</h5>
                                               <span>Chef & Critic</span>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                               <div class="col-lg-4 col-md-6">
                                   <div class="testimonial-card">
                                       <div class="stars mb-3">
                                           <i class="fas fa-star"></i>
                                           <i class="fas fa-star"></i>
                                           <i class="fas fa-star"></i>
                                           <i class="fas fa-star"></i>
                                           <i class="fas fa-star"></i>
                                       </div>
                                       <p class="testimonial-text">"Great vegetarian options! As a vegetarian, it's hard to
                                           find good momos but these exceeded my expectations. Fresh and flavorful!"</p>
                                       <div class="customer-info">
                                           <div class="customer-avatar">
                                               <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop&crop=face"
                                                   alt="David Wilson">
                                           </div>
                                           <div class="customer-details">
                                               <h5>David Wilson</h5>
                                               <span>Health Enthusiast</span>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                               <div class="col-lg-4 col-md-6">
                                   <div class="testimonial-card">
                                       <div class="stars mb-3">
                                           <i class="fas fa-star"></i>
                                           <i class="fas fa-star"></i>
                                           <i class="fas fa-star"></i>
                                           <i class="fas fa-star"></i>
                                           <i class="fas fa-star"></i>
                                       </div>
                                       <p class="testimonial-text">"Delivery was super fast and the packaging kept
                                           everything fresh. These momos remind me of my grandmother's cooking. Pure
                                           nostalgia!"</p>
                                       <div class="customer-info">
                                           <div class="customer-avatar">
                                               <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&h=100&fit=crop&crop=face"
                                                   alt="Lisa Thompson">
                                           </div>
                                           <div class="customer-details">
                                               <h5>Lisa Thompson</h5>
                                               <span>Regular Customer</span>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                               <div class="col-lg-4 col-md-6">
                                   <div class="testimonial-card">
                                       <div class="stars mb-3">
                                           <i class="fas fa-star"></i>
                                           <i class="fas fa-star"></i>
                                           <i class="fas fa-star"></i>
                                           <i class="fas fa-star"></i>
                                           <i class="fas fa-star"></i>
                                       </div>
                                       <p class="testimonial-text">"Outstanding quality and taste! Perfect for entertaining
                                           guests. Everyone always asks where I got these amazing momos from!"</p>
                                       <div class="customer-info">
                                           <div class="customer-avatar">
                                               <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&h=100&fit=crop&crop=face"
                                                   alt="James Rodriguez">
                                           </div>
                                           <div class="customer-details">
                                               <h5>James Rodriguez</h5>
                                               <span>Party Host</span>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>

                   <!-- Our Location Section -->
                   <div class="row align-items-center">
                       <div class="col-lg-6 slide-in-left">
                           <h2 class="section-title mb-4">Find Us</h2>
                           <div class="contact-info">
                               <div class="contact-item mb-3">
                                   <i class="fas fa-map-marker-alt text-primary me-3"></i>
                                   <span><strong>Address:</strong>
                                       {{ $globalSettings->address ?? 'Frozen Momo Factory, Dharan, Nepal' }}</span>
                               </div>
                               <div class="contact-item mb-3">
                                   <i class="fas fa-phone text-primary me-3"></i>
                                   <span><strong>Phone:</strong>
                                       {{ $globalSettings->contact_phone ?? '+977-9876543210' }}</span>
                               </div>
                               <div class="contact-item mb-3">
                                   <i class="fas fa-envelope text-primary me-3"></i>
                                   <span><strong>Email:</strong>
                                       {{ $globalSettings->contact_email ?? 'info@frozenmomo.com' }}</span>
                               </div>
                               <div class="contact-item mb-3">
                                   <i class="fas fa-clock text-primary me-3"></i>
                                   <span><strong>Hours:</strong>
                                       {{ $globalSettings->time ?? 'Mon-Sun: 8:00 AM - 8:00 PM' }}</span>
                               </div>
                           </div>

                           <!-- Social Media Links -->
                           <div class="social-links mt-4">
                               <h5>Follow Us</h5>
                               <div class="d-flex gap-3">
                                   @if ($globalSettings->facebook_link)
                                       <a href="{{ $globalSettings->facebook_link }}" target="_blank"
                                           class="social-link">
                                           <i class="fab fa-facebook-f"></i>
                                       </a>
                                   @endif
                                   @if ($globalSettings->twitter_link)
                                       <a href="{{ $globalSettings->twitter_link }}" target="_blank" class="social-link">
                                           <i class="fab fa-twitter"></i>
                                       </a>
                                   @endif
                                   @if ($globalSettings->instagram_link)
                                       <a href="{{ $globalSettings->instagram_link }}" target="_blank"
                                           class="social-link">
                                           <i class="fab fa-instagram"></i>
                                       </a>
                                   @endif
                               </div>
                           </div>
                       </div>
                       <div class="col-lg-6 slide-in-right">
                           <div class="map-container">
                               @if ($globalSettings->map_link)
                                   <iframe src="{{ $globalSettings->map_link }}" width="100%" height="350"
                                       style="border:0; border-radius: 15px;" allowfullscreen="" loading="lazy"
                                       referrerpolicy="no-referrer-when-downgrade">
                                   </iframe>
                               @else
                                   <div class="map-placeholder">
                                       <i class="fas fa-map fa-3x text-muted mb-3"></i>
                                       <p class="text-muted">Map location will be displayed here</p>
                                   </div>
                               @endif
                           </div>
                       </div>
                   </div>
               </div>
           </section>
       </div>
   @endsection

   @extends('layouts.app')
   @section('content')
       <div id="about" class="page-section">
           <section class="about-section">
               <div class="container">
                   <!-- What We Do Section -->
                   <div class="row align-items-center mb-5">

                       <h2>What We Do</h2>
                       <ul class="list-unstyled">
                           <li class="mb-3"><i class="fas fa-check-circle text-success me-3"></i>We craft delicious
                               momos with authentic recipes</li>
                           <li class="mb-3"><i class="fas fa-check-circle text-success me-3"></i>Frozen fresh to
                               lock in taste</li>
                           <li class="mb-3"><i class="fas fa-check-circle text-success me-3"></i>Available in
                               multiple varieties</li>
                           <li class="mb-3"><i class="fas fa-check-circle text-success me-3"></i>Committed to
                               quality and hygiene</li>
                       </ul>
                   </div>
                   <div class="col-lg-6 slide-in-right">
                       <div class="about-image">
                           <img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ca4b?w=600&h=400&fit=crop"
                               alt="Our Kitchen" class="img-fluid">
                       </div>
                   </div>
               </div>

               <!-- Our Location Section -->
               <div class="row">
                   <div class="col-lg-6 slide-in-left">
                       <h2>Find Us</h2>
                       <div class="contact-info">
                           <p><strong>Address:</strong> Frozen Momo Factory, Dharan, Nepal</p>
                           <p><strong>Phone:</strong> +977-9876543210</p>
                           <p><strong>Email:</strong> info@frozenmomo.com</p>
                           <p><strong>Hours:</strong> Mon-Sun: 8:00 AM - 8:00 PM</p>
                       </div>
                   </div>
                   <div class="col-lg-6 slide-in-right">
                       <div class="map-container">
                           <iframe
                               src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3559.123456789!2d87.28511!3d26.8134!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjbCsDQ4JzUwLjQiTiA4N8KwMTcnMDYuNCJF!5e0!3m2!1sen!2snp!4v1234567890"
                               width="100%" height="300" style="border:0; border-radius: 15px;" allowfullscreen=""
                               loading="lazy"></iframe>
                       </div>
                   </div>
               </div>
       </div>
   @endsection

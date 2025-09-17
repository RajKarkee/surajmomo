@extends('admin.layout')

@section('title', 'About Page Management')

@section('content')
    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">About Page Management</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">About Page</li>
                </ol>
            </nav>
        </div>

        <form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')


            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bullseye me-2"></i>What We Do Section
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Section Title -->
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="what_we_do_title" class="form-label fw-bold text-dark">
                                    <i class="fas fa-heading me-2"></i>Section Title
                                </label>
                                <input type="text" class="form-control form-control-lg" id="what_we_do_title"
                                    name="what_we_do[title]"
                                    value="{{ old('what_we_do.title', $about->what_we_do['title'] ?? 'What We Do') }}"
                                    placeholder="Enter section title">
                            </div>
                        </div>

                        <!-- Section Image -->
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label fw-bold text-dark">
                                    <i class="fas fa-image me-2"></i>Section Image
                                </label>
                                <input type="file" id="what_we_do_image" name="what_we_do_img" class="dropify"
                                    data-default-file="{{ $about->what_we_do_img ? asset('storage/' . $about->what_we_do_img) : 'https://images.unsplash.com/photo-1496412705862-e0088f16f791?w=600&h=400&fit=crop' }}"
                                    data-height="200" accept="image/*" />
                            </div>
                        </div>

                        <!-- Lead Description -->
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="what_we_do_lead" class="form-label fw-bold text-dark">
                                    <i class="fas fa-align-left me-2"></i>Lead Description
                                </label>
                                <textarea class="form-control" id="what_we_do_lead" name="what_we_do[lead]" rows="3"
                                    placeholder="Enter lead description">{{ old('what_we_do.lead', $about->what_we_do['lead'] ?? 'At Frozen Momo, we are passionate about bringing you the authentic taste of traditional momos with modern convenience.') }}</textarea>
                            </div>
                        </div>

                        <!-- Feature Items -->
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-dark mb-3">
                                <i class="fas fa-list me-2"></i>Feature Items
                            </label>
                            <div id="what-we-do-features">
                                @php
                                    $features = $about->what_we_do['features'] ?? [
                                        'We craft delicious momos with authentic recipes',
                                        'Frozen fresh to lock in taste and nutrition',
                                        'Available in multiple varieties and flavors',
                                        'Committed to quality, hygiene, and customer satisfaction',
                                    ];
                                @endphp
                                @foreach ($features as $index => $feature)
                                    <div class="input-group mb-2 feature-item">
                                        <span class="input-group-text"><i
                                                class="fas fa-check-circle text-success"></i></span>
                                        <input type="text" class="form-control" name="what_we_do[features][]"
                                            value="{{ old('what_we_do.features.' . $index, $feature) }}"
                                            placeholder="Enter feature description">
                                        <button type="button" class="btn btn-outline-danger remove-feature">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-outline-success btn-sm" id="add-what-we-do-feature">
                                <i class="fas fa-plus me-2"></i>Add Feature
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Our Story Section -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-book-open me-2"></i>Our Story Section
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Section Title -->
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="our_story_title" class="form-label fw-bold text-dark">
                                    <i class="fas fa-heading me-2"></i>Section Title
                                </label>
                                <input type="text" class="form-control form-control-lg" id="our_story_title"
                                    name="our_story[title]"
                                    value="{{ old('our_story.title', $about->our_story['title'] ?? 'Our Story') }}"
                                    placeholder="Enter section title">
                            </div>
                        </div>

                        <!-- Section Image -->
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label fw-bold text-dark">
                                    <i class="fas fa-image me-2"></i>Section Image
                                </label>
                                <input type="file" id="our_story_image" name="our_story_img" class="dropify"
                                    data-default-file="{{ $about->our_story_img ? asset('storage/' . $about->our_story_img) : 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=600&h=400&fit=crop' }}"
                                    data-height="200" accept="image/*" />
                            </div>
                        </div>

                        <!-- Story Content -->
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-dark mb-3">
                                <i class="fas fa-paragraph me-2"></i>Story Paragraphs
                            </label>
                            <div id="our-story-content">
                                @php
                                    $storyParagraphs = $about->our_story['content'] ?? [
                                        'Founded with a passion for authentic Nepali cuisine, Frozen Momo started as a small family business with a big dream - to share the incredible flavors of traditional momos with food lovers everywhere.',
                                        'Our journey began in the heart of Nepal, where we learned the ancient art of momo making from generations of skilled cooks. Each recipe has been carefully preserved and perfected to bring you the most authentic taste experience.',
                                        'Today, we continue to honor these traditions while embracing modern techniques to ensure our momos reach you fresh, flavorful, and ready to enjoy.',
                                    ];
                                @endphp
                                @foreach ($storyParagraphs as $index => $paragraph)
                                    <div class="mb-3 story-paragraph">
                                        <div class="input-group">
                                            <span class="input-group-text">{{ $index + 1 }}</span>
                                            <textarea class="form-control" name="our_story[content][]" rows="3" placeholder="Enter story paragraph">{{ old('our_story.content.' . $index, $paragraph) }}</textarea>
                                            <button type="button" class="btn btn-outline-danger remove-paragraph">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-outline-success btn-sm" id="add-story-paragraph">
                                <i class="fas fa-plus me-2"></i>Add Paragraph
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Our Mission Section -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-rocket me-2"></i>Our Mission Section
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Mission Statement -->
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="our_mission_statement" class="form-label fw-bold text-dark">
                                    <i class="fas fa-quote-left me-2"></i>Mission Statement
                                </label>
                                <textarea class="form-control" id="our_mission_statement" name="our_mission[statement]" rows="4"
                                    placeholder="Enter mission statement">{{ old('our_mission.statement', $about->our_mission['statement'] ?? 'To deliver authentic, high-quality frozen momos that bring families together around delicious, convenient meals while preserving the rich culinary traditions of Nepal.') }}</textarea>
                            </div>
                        </div>

                        <!-- Mission Values -->
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-dark mb-3">
                                <i class="fas fa-values me-2"></i>Core Values
                            </label>
                            <div id="mission-values">
                                @php
                                    $values = $about->our_mission['values'] ?? [
                                        'Authenticity - Preserving traditional recipes and flavors',
                                        'Quality - Using only the finest, freshest ingredients',
                                        'Convenience - Making delicious meals accessible to busy families',
                                        'Sustainability - Supporting local farmers and eco-friendly practices',
                                    ];
                                @endphp
                                @foreach ($values as $index => $value)
                                    <div class="input-group mb-2 value-item">
                                        <span class="input-group-text"><i class="fas fa-star text-warning"></i></span>
                                        <input type="text" class="form-control" name="our_mission[values][]"
                                            value="{{ old('our_mission.values.' . $index, $value) }}"
                                            placeholder="Enter core value">
                                        <button type="button" class="btn btn-outline-danger remove-value">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-outline-success btn-sm" id="add-mission-value">
                                <i class="fas fa-plus me-2"></i>Add Value
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Section -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Statistics Section
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @php
                            $defaultStats = [
                                ['icon' => 'fas fa-users', 'number' => '5000+', 'label' => 'Happy Customers'],
                                ['icon' => 'fas fa-award', 'number' => '5+', 'label' => 'Years Experience'],
                                ['icon' => 'fas fa-star', 'number' => '4.9', 'label' => 'Average Rating'],
                                ['icon' => 'fas fa-shipping-fast', 'number' => '24/7', 'label' => 'Fresh Delivery'],
                            ];
                            $stats = $about->what_we_do['stats'] ?? $defaultStats;
                        @endphp
                        @foreach ($stats as $index => $stat)
                            <div class="col-md-6 mb-3">
                                <div class="card border">
                                    <div class="card-body">
                                        <h6 class="card-title">Statistic {{ $index + 1 }}</h6>
                                        <div class="row">
                                            <div class="col-4">
                                                <label class="form-label text-sm">Icon Class</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    name="what_we_do[stats][{{ $index }}][icon]"
                                                    value="{{ old('what_we_do.stats.' . $index . '.icon', $stat['icon']) }}"
                                                    placeholder="fas fa-users">
                                            </div>
                                            <div class="col-4">
                                                <label class="form-label text-sm">Number</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    name="what_we_do[stats][{{ $index }}][number]"
                                                    value="{{ old('what_we_do.stats.' . $index . '.number', $stat['number']) }}"
                                                    placeholder="5000+">
                                            </div>
                                            <div class="col-4">
                                                <label class="form-label text-sm">Label</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    name="what_we_do[stats][{{ $index }}][label]"
                                                    value="{{ old('what_we_do.stats.' . $index . '.label', $stat['label']) }}"
                                                    placeholder="Happy Customers">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="row">
                <div class="col-12">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>Save Changes
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-lg">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Initialize Dropify
                $('.dropify').dropify();
                $('.dropify').dropify('destroy').dropify();
                // Add What We Do Feature
                $('#add-what-we-do-feature').click(function() {
                    const featureHtml = `
                    <div class="input-group mb-2 feature-item">
                        <span class="input-group-text"><i class="fas fa-check-circle text-success"></i></span>
                        <input type="text" class="form-control" name="what_we_do[features][]" placeholder="Enter feature description">
                        <button type="button" class="btn btn-outline-danger remove-feature">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
                    $('#what-we-do-features').append(featureHtml);
                });

                // Remove Feature
                $(document).on('click', '.remove-feature', function() {
                    $(this).closest('.feature-item').remove();
                });

                // Add Story Paragraph
                $('#add-story-paragraph').click(function() {
                    const paragraphCount = $('#our-story-content .story-paragraph').length + 1;
                    const paragraphHtml = `
                    <div class="mb-3 story-paragraph">
                        <div class="input-group">
                            <span class="input-group-text">${paragraphCount}</span>
                            <textarea class="form-control" name="our_story[content][]" rows="3" placeholder="Enter story paragraph"></textarea>
                            <button type="button" class="btn btn-outline-danger remove-paragraph">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                `;
                    $('#our-story-content').append(paragraphHtml);
                });

                // Remove Paragraph
                $(document).on('click', '.remove-paragraph', function() {
                    $(this).closest('.story-paragraph').remove();
                    // Update paragraph numbers
                    $('#our-story-content .story-paragraph').each(function(index) {
                        $(this).find('.input-group-text').text(index + 1);
                    });
                });

                // Add Mission Value
                $('#add-mission-value').click(function() {
                    const valueHtml = `
                    <div class="input-group mb-2 value-item">
                        <span class="input-group-text"><i class="fas fa-star text-warning"></i></span>
                        <input type="text" class="form-control" name="our_mission[values][]" placeholder="Enter core value">
                        <button type="button" class="btn btn-outline-danger remove-value">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
                    $('#mission-values').append(valueHtml);
                });

                // Remove Value
                $(document).on('click', '.remove-value', function() {
                    $(this).closest('.value-item').remove();
                });
            });
        </script>
    @endpush
@endsection

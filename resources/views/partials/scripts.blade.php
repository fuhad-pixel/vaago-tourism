	<!-- Jquery -->
	<script src="{{ asset('assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
	<!-- Jquery UI -->
	<script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
	<!-- Moment -->
	<script src="{{ asset('assets/js/moment.min.js') }}"></script>
	<!-- Daterangepicker -->
	<script src="{{ asset('assets/js/daterangepicker.min.js') }}"></script>
	<!-- Swiper Slider -->
	<script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
	<!-- Bootstrap -->
	<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
	<!-- WOW.js Animation -->
	<script src="{{ asset('assets/js/wow.min.js') }}"></script>
	<!-- Magnific Popup -->
	<script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
	<!-- Image Loaded Jquery -->
	<script src="{{ asset('assets/js/imagesloaded.pkgd.min.js') }}"></script>
	<!-- Gsap -->
	<script src="{{ asset('assets/js/gsap.min.js') }}"></script>
	<!-- ScrollTrigger -->
	<script src="{{ asset('assets/js/ScrollTrigger.min.js') }}"></script>
	<!-- ScrollToPlugin -->
	<script src="{{ asset('assets/js/ScrollToPlugin.min.js') }}"></script>
	<!-- SplitText -->
	<script src="{{ asset('assets/js/SplitText.min.js') }}"></script>

	<!-- Main Js File -->
	<script src="{{ asset('assets/js/main.js') }}"></script>
	
	<!-- Global Search Typeahead -->
	<script>
	$(document).ready(function() {
		let debounceTimer;
		$('#global-search-input').on('keyup', function() {
			const query = $(this).val();
			const container = $('#search-suggestions-container');

			if (query.length < 2) {
				container.hide().empty();
				$('#global-search-input').removeClass('has-suggestions');
				return;
			}

			clearTimeout(debounceTimer);
			debounceTimer = setTimeout(function() {
				$.ajax({
					url: "{{ route('ajax.search') }}",
					type: "GET",
					data: { q: query },
					success: function(data) {
						container.empty();
						if (data.length > 0) {
							data.forEach(function(item) {
								const html = `
									<a href="${item.url}" class="suggestion-item">
										<div class="suggestion-icon">${item.icon}</div>
										<div class="suggestion-text">${item.title}</div>
										<div class="suggestion-type">${item.type}</div>
									</a>
								`;
								container.append(html);
							});
							container.slideDown(200);
							$('#global-search-input').addClass('has-suggestions');
						} else {
							container.html('<div style="padding: 15px 20px; color: #aaa;">No results found</div>');
							container.slideDown(200);
							$('#global-search-input').addClass('has-suggestions');
						}
					}
				});
			}, 300);
		});

		// Close suggestions when clicking outside
		$(document).on('click', function(e) {
			if (!$(e.target).closest('.popup-search-box form').length) {
				$('#search-suggestions-container').slideUp(200);
				$('#global-search-input').removeClass('has-suggestions');
			}
		});
	});
	</script>

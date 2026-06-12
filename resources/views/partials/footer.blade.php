		<footer class="ftco-footer bg-bottom ftco-no-pt" style="background-image: url({{ asset('images/bg_3.jpg') }});">
			<div class="container">
				<div class="row mb-5">
					<div class="col-md pt-5">
						<div class="ftco-footer-widget pt-md-5 mb-4">
							<h2 class="ftco-heading-2">About</h2>
							<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
							<ul class="ftco-footer-social list-unstyled float-md-left float-lft">
								@if(isset($company_setting) && $company_setting->twitter)
									<li class="ftco-animate"><a href="{{ $company_setting->twitter }}" target="_blank"><span class="fa fa-twitter"></span></a></li>
								@endif
								@if(isset($company_setting) && $company_setting->facebook)
									<li class="ftco-animate"><a href="{{ $company_setting->facebook }}" target="_blank"><span class="fa fa-facebook"></span></a></li>
								@endif
								@if(isset($company_setting) && $company_setting->instagram)
									<li class="ftco-animate"><a href="{{ $company_setting->instagram }}" target="_blank"><span class="fa fa-instagram"></span></a></li>
								@endif
								@if(isset($company_setting) && $company_setting->linkedin)
									<li class="ftco-animate"><a href="{{ $company_setting->linkedin }}" target="_blank"><span class="fa fa-linkedin"></span></a></li>
								@endif
							</ul>
						</div>
					</div>
					<div class="col-md pt-5 border-start">
						<div class="ftco-footer-widget pt-md-5 mb-4 ml-md-5">
							<h2 class="ftco-heading-2">Infromation</h2>
							<ul class="list-unstyled">
								<li><a href="#" class="py-2 d-block">Online Enquiry</a></li>
								<li><a href="#" class="py-2 d-block">General Enquiries</a></li>
								<li><a href="#" class="py-2 d-block">Booking Conditions</a></li>
								<li><a href="javascript:void(0)" onclick="showPolicyModal('Privacy Policy', 'privacy')" class="py-2 d-block">Privacy Policy</a></li>
								<li><a href="javascript:void(0)" onclick="showPolicyModal('Return Policy', 'return')" class="py-2 d-block">Return Policy</a></li>
								<li><a href="#" class="py-2 d-block">Call Us</a></li>
							</ul>
						</div>
					</div>
					<div class="col-md pt-5 border-start">
						<div class="ftco-footer-widget pt-md-5 mb-4">
							<h2 class="ftco-heading-2">Experience</h2>
							<ul class="list-unstyled">
								<li><a href="#" class="py-2 d-block">Adventure</a></li>
								<li><a href="#" class="py-2 d-block">Hotel and Restaurant</a></li>
								<li><a href="#" class="py-2 d-block">Beach</a></li>
								<li><a href="#" class="py-2 d-block">Nature</a></li>
								<li><a href="#" class="py-2 d-block">Camping</a></li>
								<li><a href="#" class="py-2 d-block">Party</a></li>
							</ul>
						</div>
					</div>
					<div class="col-md pt-5 border-start">
						<div class="ftco-footer-widget pt-md-5 mb-4">
							<h2 class="ftco-heading-2">Have a Questions?</h2>
							<div class="block-23 mb-3">
								<ul>
									@if(isset($company_setting) && $company_setting->address)
										<li><span class="icon fa fa-map-marker"></span><span class="text">{{ $company_setting->address }}</span></li>
									@endif
									@if(isset($company_setting) && $company_setting->phone)
										<li><a href="tel:{{ $company_setting->phone }}"><span class="icon fa fa-phone"></span><span class="text">{{ $company_setting->phone }}</span></a></li>
									@endif
									@if(isset($company_setting) && $company_setting->company_email)
										<li><a href="mailto:{{ $company_setting->company_email }}"><span class="icon fa fa-paper-plane"></span><span class="text">{{ $company_setting->company_email }}</span></a></li>
									@endif
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 text-center">

						<p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
							Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | {{ $company_setting->company_name ?? 'Pacific' }}
							<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
						</div>
					</div>
				</div>
			</footer>

<!-- Modern Policy Modal -->
<div id="policyModal" class="policy-modal-overlay" onclick="closePolicyModal(event)">
    <div class="policy-modal-box">
        <button type="button" class="policy-modal-close" onclick="closePolicyModalDirect()">&times;</button>
        <h3 id="policyModalTitle" class="policy-modal-title"></h3>
        <div id="policyModalBody" class="policy-modal-body"></div>
    </div>
</div>

<style>
    .policy-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.4s ease;
    }
    .policy-modal-overlay.active {
        opacity: 1;
        pointer-events: auto;
    }
    .policy-modal-box {
        background: #fff;
        border-radius: 20px;
        width: 90%;
        max-width: 700px;
        max-height: 80vh;
        padding: 35px 30px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        position: relative;
        transform: scale(0.85);
        transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        display: flex;
        flex-direction: column;
    }
    .policy-modal-overlay.active .policy-modal-box {
        transform: scale(1);
    }
    .policy-modal-close {
        position: absolute;
        top: 20px;
        right: 20px;
        background: #f1f5f9;
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        font-size: 1.5rem;
        color: #64748b;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        line-height: 1;
        outline: none;
    }
    .policy-modal-close:hover {
        background: #e2e8f0;
        color: #1e293b;
    }
    .policy-modal-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f1f5f9;
        text-align: left;
    }
    .policy-modal-body {
        font-size: 1rem;
        color: #475569;
        line-height: 1.7;
        overflow-y: auto;
        text-align: left;
        padding-right: 5px;
    }
    .policy-modal-body h1, .policy-modal-body h2, .policy-modal-body h3 {
        color: #1e293b;
        font-weight: 700;
        margin-top: 20px;
        margin-bottom: 10px;
    }
    .policy-modal-body ul, .policy-modal-body ol {
        padding-left: 20px;
        margin-bottom: 15px;
    }
    .policy-modal-body p {
        margin-bottom: 15px;
    }
</style>

<script>
    const policyData = {
        privacy: {!! json_encode($company_setting->privacy_policy ?? '<p class="text-muted">Privacy Policy has not been updated yet.</p>') !!},
        return: {!! json_encode($company_setting->return_policy ?? '<p class="text-muted">Return Policy has not been updated yet.</p>') !!}
    };

    function showPolicyModal(title, type) {
        document.getElementById('policyModalTitle').textContent = title;
        document.getElementById('policyModalBody').innerHTML = policyData[type];
        document.getElementById('policyModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closePolicyModalDirect() {
        document.getElementById('policyModal').classList.remove('active');
        document.body.style.overflow = '';
    }

    function closePolicyModal(event) {
        if (event.target.id === 'policyModal') {
            closePolicyModalDirect();
        }
    }
</script>

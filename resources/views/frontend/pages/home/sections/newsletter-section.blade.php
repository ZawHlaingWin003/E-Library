<!-- Newsletter -->
<section class="newsletter">
    <div class="container">
        <div class="subscribe-form-container">
            <h2 class="title mb-3">subscribe for latest updates</h2>
            <x-form action="{{ route('newsletter.subscribe') }}" method="POST" id="subscribe-form">
                @csrf

                <x-form-group class="mb-3" id="email-input-group">
                    <x-form-input type="email" name="email" placeholder="Enter Your Email" id="email" />
                </x-form-group>
    
                <x-main-button type="submit" buttonId="subscribe-button" iconName="fa-bell" iconId="subscribe-button-icon"
                    loaderId="subscribe-button-loader">
                    Subscribe
                </x-main-button>
            </x-form>
        </div>
    </div>

</section>

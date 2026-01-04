<div class="footer-container">
    <div class="container">
        <!-- Newsletter Section -->
        <div class="newsletter-section">
            <div class="newsletter-header">
                <h2 class="newsletter-title">الاشتراك في النشرة البريدية</h2>
                <div class="form-group">
                    <form action="{{ route('newsletter') }}" method="POST">
                        @csrf
                        <input type="text" placeholder="الاسم الأول" name="name" required>
                        <input type="email" placeholder="البريد الإلكتروني *" name="email" required>
                        <button type="submit" class="signup-btn">اشترك</button>
                    </form>
                </div>
            </div>
            <div class="newsletter-footer">
                <p>يرجى إضافة بياناتك لتلقي التحديثات حول الدروس الجديدة، الورش، العروض، الخصومات والمزيد.</p>
                <a  href="{{ route('privacy-policy') }}" class="privacy-link">اطلع على سياسة الخصوصية الخاصة بي هنا.</a>
            </div>
        </div>

        <!-- Info Section -->
        <div class="info-section">
            <div class="info-block">
                <h3>تواصل معنا</h3>
                <p>البريد الإلكتروني: <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></p>
                <p>الهاتف المحمول: {{ $contact->phone }}</p>
            </div>

            <div class="info-block">
                <h3>ساعات العمل</h3>
                <p><strong>الإثنين - السبت :</strong> 9 صباحًا - 6 مساءً</p>
                <p><strong>الأحد :</strong> مغلق</p>
            </div>

            <div class="info-block">
                <h3>الموقع</h3>
                <p>{{ $contact->address }}</p>
            </div>
        </div>

        <!-- Bottom Section -->
        <div class="bottom-section">
            <p class="copyright">جميع الحقوق محفوظة مشمة كيك اكاديمي 2025</p>
            <div class="social-icons">
                <a href="{{ $contact->facebook }}" target="_blank" aria-label="فيسبوك"><i class="fab fa-facebook-f"></i></a>
                <a href="{{ $contact->instagram }}" target="_blank" aria-label="انستجرام"><i class="fab fa-instagram"></i></a>
                <a href="{{ $contact->twitter }}" target="_blank" aria-label="تويتر"><i class="fab fa-twitter"></i></a>
                <a href="{{ $contact->pinterest }}" target="_blank" aria-label="بنترست"><i class="fab fa-pinterest-p"></i></a>
                <a href="{{ $contact->vimeo }}" target="_blank" aria-label="فيميو"><i class="fab fa-vimeo-v"></i></a>
            </div>
        </div>
    </div>
</div>
<button id="scrollTopBtn" class="scroll-top">
    <i class="fas fa-arrow-up"></i>
</button>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    AOS.init({
        duration: 1000,
        once: true
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/smooth-scrollbar@8.7.4/dist/smooth-scrollbar.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>

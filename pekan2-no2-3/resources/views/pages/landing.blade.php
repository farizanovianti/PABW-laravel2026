@extends('layouts.public')

@php($heroSlides = [
    ['title' => 'Pelatihan Vokasional', 'subtitle' => 'Inklusif untuk Remaja ABK', 'desc' => 'InkluSkill membantu sekolah, orang tua, dan lembaga pelatihan bekerja sama untuk membangun kemandirian remaja ABK melalui program pelatihan yang mudah diakses, ramah, dan terstruktur.', 'cta' => 'Lihat Pelatihan', 'link' => '#service'],
    ['title' => 'Belajar.<br><span>Berlatih</span>', 'subtitle' => '', 'desc' => 'Mendorong kemandirian remaja ABK melalui pelatihan vokasional yang praktis.', 'cta' => 'Lihat Program', 'link' => '#workflow'],
    ['title' => 'Tumbuh.<br><span>Berdaya</span>', 'subtitle' => '', 'desc' => 'Kolaborasi sekolah, orang tua, dan lembaga pelatihan untuk masa depan yang lebih baik.', 'cta' => 'Gabung Sekarang', 'link' => '/register'],
])
@php($trainings = [
    ['icon' => 'ri-restaurant-2-fill', 't' => 'Tata Boga', 'd' => 'Pelatihan memasak dasar & produksi sederhana'],
    ['icon' => 'ri-brush-fill', 't' => 'Perawatan & Kebersihan', 'd' => 'Keterampilan dasar maintenance dan cleaning service'],
    ['icon' => 'ri-handbag-fill', 't' => 'Kerajinan & Produksi', 'd' => 'Kerajinan tangan dan pekerjaan sederhana'],
    ['icon' => 'ri-plant-fill', 't' => 'Pertanian Ringan', 'd' => 'Budidaya sederhana dan perawatan tanaman'],
    ['icon' => 'ri-store-2-fill', 't' => 'Bisnis Sederhana', 'd' => 'Dukungan wirausaha skala rumah'],
    ['icon' => 'ri-palette-fill', 't' => 'Desain & Kreatif Ringan', 'd' => 'Aktivitas desain sederhana dan kerajinan digital dasar'],
    ['icon' => 'ri-user-voice-fill', 't' => 'Pelatihan Soft Skill', 'd' => 'Komunikasi dasar, adaptasi kerja, dan kemandirian'],
    ['icon' => 'ri-briefcase-fill', 't' => 'Magang & Kerja Praktik', 'd' => 'Penempatan magang yang ramah ABK'],
])
@php($workflows = [
    ['icon' => 'ri-user-fill', 't' => 'Data & Pendaftaran (Sekolah)', 'd' => 'Sekolah mendaftarkan peserta ke program pelatihan yang relevan dan mengelola daftar peserta.'],
    ['icon' => 'ri-search-fill', 't' => 'Pelaksanaan Offline', 'd' => 'Pelatihan berjalan secara tatap muka di sekolah, BLK, atau mitra pelatihan lokal sesuai jadwal.'],
    ['icon' => 'ri-file-paper-fill', 't' => 'Monitoring & Laporan', 'd' => 'Guru mengunggah ringkasan hasil, orang tua dapat melihat progres, dan BLK/Dinas memantau output program.'],
    ['icon' => 'ri-briefcase-fill', 't' => 'Peluang Setelah Pelatihan', 'd' => 'Peserta mendapat rekomendasi penempatan magang, kerja, atau wirausaha sesuai kemampuan.'],
])
@php($testimonials = [
    ['img' => 'assets/client-1.jpg', 'name' => 'Bu Siti Aminah', 'role' => 'Guru Pendamping SLB', 'rating' => 5, 'text' => 'InkluSkill sangat membantu kami dalam mengelola program pelatihan untuk siswa berkebutuhan khusus. Sistemnya mudah digunakan dan memudahkan koordinasi dengan orang tua serta lembaga pelatihan.'],
    ['img' => 'assets/client-2.jpg', 'name' => 'Pak Budi Santoso', 'role' => 'Orang Tua Peserta', 'rating' => 5, 'text' => 'Sebagai orang tua, saya merasa terbantu dengan adanya platform ini. Saya bisa memantau perkembangan anak saya dalam mengikuti pelatihan tata boga. Laporannya jelas dan mudah dipahami.'],
    ['img' => 'assets/client-3.jpg', 'name' => 'Andi Wijaya', 'role' => 'Peserta Pelatihan', 'rating' => 5, 'text' => 'Pelatihan yang diberikan sangat praktis dan sesuai dengan kemampuan kami. Instrukturnya sabar dan metode pelatihannya mudah dipahami. Sekarang saya lebih percaya diri untuk bekerja.'],
])
@php($services = [
    ['img' => 'assets/img1.jpeg', 't' => 'Terpadu dan Terpusat', 'd' => 'Pendaftaran dan rekam peserta dikelola oleh sekolah sehingga lebih rapi dan terpantau.'],
    ['img' => 'assets/img2.jpeg', 't' => 'Monitoring Perkembangan', 'd' => 'Tersedia perkembangan peserta melalui laporan sederhana dan sertifikat digital.'],
    ['img' => 'assets/img3.jpeg', 't' => 'Kolaborasi Sekolah & BLK', 'd' => 'Koordinasi yang mudah antara sekolah dan BLK/Dinas untuk program yang relevan.'],
])

@section('title', 'InkluSkill | Belajar, Berlatih, Berdaya')

@section('content')
<div>
    <section class="home" id="home">
        @foreach ($heroSlides as $i => $s)
            <video class="video-slide {{ $i === 0 ? 'active' : '' }}" src="{{ asset('assets/vid'.($i + 1).'.mp4') }}" autoplay muted loop playsinline></video>
        @endforeach

        @foreach ($heroSlides as $i => $s)
            <div class="hero-content {{ $i === 0 ? 'active' : '' }}">
                <h1>{!! $s['title'] !!}</h1>
                @if ($s['subtitle'])
                    <span class="subtitle">{{ $s['subtitle'] }}</span>
                @endif
                <p>{{ $s['desc'] }}</p>
                <a href="{{ $s['link'] }}" class="hero-cta">{{ $s['cta'] }}</a>
            </div>
        @endforeach

        <div class="slider-navigation">
            @foreach ($heroSlides as $i => $s)
                <button type="button" class="nav-btn {{ $i === 0 ? 'active' : '' }}" data-slide="{{ $i }}" aria-label="Slide {{ $i + 1 }}"></button>
            @endforeach
        </div>
    </section>

    <section class="section__container" id="about">
        <h2 class="section__header">Apa yang Kami <span>Tawarkan</span></h2>
        <p class="section__description">
            InkluSkill dirancang untuk mempermudah proses pelatihan dan penyaluran kerja
            bagi remaja berkebutuhan khusus dengan melibatkan sekolah, orang tua, dan lembaga terkait.
        </p>
        <div class="services__grid">
            @foreach ($services as $s)
                <div class="services__card">
                    <img src="{{ asset($s['img']) }}" alt="{{ $s['t'] }}">
                    <div class="services__details">
                        <div>
                            <h4>{{ $s['t'] }}</h4>
                            <p>{{ $s['d'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="section__container" id="statistics" style="background:var(--bg-soft)">
        <h2 class="section__header">Kenapa <span>InkluSkill</span> Dibutuhkan</h2>
        <p class="section__description">
            Berdasarkan survei dan riset terhadap guru, orang tua, dan remaja ABK di Indonesia.
        </p>
        <div class="statistics__grid">
            <div class="statistics__card">
                <div class="statistics__icon"><i class="ri-shield-check-fill"></i></div>
                <div class="statistics__number"><span class="js-counter" data-target="84">0</span>%</div>
                <p>Guru setuju sistem digital sangat dibutuhkan untuk pelatihan ABK</p>
            </div>
            <div class="statistics__card">
                <div class="statistics__icon"><i class="ri-user-heart-fill"></i></div>
                <div class="statistics__number"><span class="js-counter" data-target="70">0</span>%</div>
                <p>Siswa ABK ingin mengikuti pelatihan tata boga & pertanian</p>
            </div>
            <div class="statistics__card">
                <div class="statistics__icon"><i class="ri-parent-fill"></i></div>
                <div class="statistics__number"><span class="js-counter" data-target="95">0</span>%</div>
                <p>Orang tua ingin platform untuk memantau perkembangan anak</p>
            </div>
        </div>

        <div class="statistics__grid" style="margin-top:2rem">
            <div class="statistics__card">
                <div class="statistics__icon"><i class="ri-building-line"></i></div>
                <div class="statistics__number"><span class="js-counter" data-target="{{ $stats['total_sekolah'] }}">0</span></div>
                <p>Sekolah Terdaftar</p>
            </div>
            <div class="statistics__card">
                <div class="statistics__icon"><i class="ri-team-line"></i></div>
                <div class="statistics__number"><span class="js-counter" data-target="{{ $stats['total_peserta'] }}">0</span></div>
                <p>Peserta Aktif</p>
            </div>
            <div class="statistics__card">
                <div class="statistics__icon"><i class="ri-book-open-line"></i></div>
                <div class="statistics__number"><span class="js-counter" data-target="{{ $stats['total_pelatihan'] }}">0</span></div>
                <p>Pelatihan Tersedia</p>
            </div>
            <div class="statistics__card">
                <div class="statistics__icon"><i class="ri-briefcase-line"></i></div>
                <div class="statistics__number"><span class="js-counter" data-target="{{ $stats['total_lowongan'] }}">0</span></div>
                <p>Lowongan Tersedia</p>
            </div>
        </div>
    </section>

    <section class="section__container" id="service">
        <h2 class="section__header"><span>Pelatihan Vokasional</span> yang Tersedia</h2>
        <p class="section__description">
            Kami menyediakan pelatihan yang realistis dan ramah ABK berfokus pada
            kemandirian dan keterampilan praktis.
        </p>
        <div class="training__grid">
            @foreach ($trainings as $t)
                <div class="training__card">
                    <span><i class="{{ $t['icon'] }}"></i></span>
                    <h4>{{ $t['t'] }}</h4>
                    <p>{{ $t['d'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="workflow" id="workflow">
        <div class="section__container">
            <h2 class="section__header">Cara Kerja <span>InkluSkill</span></h2>
            <p class="section__description">
                Alur singkat bagi sekolah, orang tua, dan peserta untuk menjalankan
                program pelatihan secara terstruktur.
            </p>
            <div class="workflow__grid">
                @foreach ($workflows as $w)
                    <div class="workflow__card">
                        <span><i class="{{ $w['icon'] }}"></i></span>
                        <h4>{{ $w['t'] }}</h4>
                        <p>{{ $w['d'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section__container" id="testimonial">
        <h2 class="section__header">Apa Kata <span>Mereka</span></h2>
        <p class="section__description">
            Testimoni dari guru, orang tua, dan peserta yang telah merasakan manfaat program InkluSkill.
        </p>
        <div class="testimonial__grid">
            @foreach ($testimonials as $tm)
                <div class="testimonial__card">
                    <img src="{{ asset($tm['img']) }}" alt="{{ $tm['name'] }}">
                    <p>{{ $tm['text'] }}</p>
                    <div class="testimonial__ratings">
                        @for ($j = 0; $j < $tm['rating']; $j++)
                            <i class="ri-star-fill"></i>
                        @endfor
                    </div>
                    <h4>{{ $tm['name'] }}</h4>
                    <h5>{{ $tm['role'] }}</h5>
                </div>
            @endforeach
        </div>
    </section>

    <section style="background:var(--primary-color);color:#fff;padding:4rem 1rem;text-align:center">
        <h2 style="font-size:2rem;margin-bottom:1rem">Bergabunglah Sekarang</h2>
        <p style="max-width:600px;margin:0 auto 1.5rem;opacity:.95">
            Daftarkan sekolah, orang tua, atau lembaga Anda untuk mulai berkolaborasi
            membangun masa depan remaja ABK yang lebih baik.
        </p>
        <a href="{{ route('register') }}" class="btn" style="background:#fff;color:var(--primary-color);padding:14px 32px;font-weight:600">
            <i class="ri-user-add-line"></i> Daftar Sekarang
        </a>
    </section>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var slides = document.querySelectorAll('.video-slide');
    var contents = document.querySelectorAll('.hero-content');
    var buttons = document.querySelectorAll('.slider-navigation .nav-btn');
    var current = 0;
    var timer = null;

    function goTo(i) {
        current = i;
        slides.forEach(function (el, idx) { el.classList.toggle('active', idx === i); });
        contents.forEach(function (el, idx) { el.classList.toggle('active', idx === i); });
        buttons.forEach(function (el, idx) { el.classList.toggle('active', idx === i); });
    }

    function auto() {
        timer = setInterval(function () { goTo((current + 1) % slides.length); }, 7000);
    }

    buttons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            clearInterval(timer);
            goTo(parseInt(btn.dataset.slide, 10));
            auto();
        });
    });

    auto();

    // counter animation saat terlihat
    var counters = document.querySelectorAll('.js-counter');
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                var el = entry.target;
                var target = parseInt(el.dataset.target, 10) || 0;
                var steps = 60, step = 0;
                var id = setInterval(function () {
                    step++;
                    el.textContent = Math.min(target, Math.round((target / steps) * step));
                    if (step >= steps) clearInterval(id);
                }, 1500 / steps);
                io.unobserve(el);
            });
        });
        counters.forEach(function (el) { io.observe(el); });
    } else {
        counters.forEach(function (el) { el.textContent = el.dataset.target; });
    }
});
</script>
@endpush

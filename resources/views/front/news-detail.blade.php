@extends('layout.details.default', ['title' => 'Event'])
@section('content')
    <style>
        .events-container-detail {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .event {
            flex: 1 1 calc(33.33% - 20px);
            /* Menggunakan flex untuk mengatur lebar */
            display: flex;
            border: 1px solid #ccc;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .event:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .event img {
            width: 200px;
            /* Mengatur lebar gambar */
            height: 100%;
            object-fit: cover;
            border-bottom: 1px solid #ddd;
        }

        .event-details {
            flex: 1;
            /* Menggunakan flex untuk mengisi sisa ruang */
            padding: 20px;
        }

        .event-title {
            margin-bottom: 10px;
        }

        .event-title h3 {
            margin: 0;
            font-size: 1.2rem;
            color: #333;
        }

        .event-info {
            font-size: 0.9rem;
            color: #555;
            margin-bottom: 8px;
        }

        .event-description p {
            margin: 0;
            font-size: 0.9rem;
            color: #666;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        /* Tambahkan CSS untuk tampilan booking */
        .date-box {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            text-align: center;
            margin-bottom: 20px;
        }

        .time-slot {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 15px;
            text-align: center;
            background-color: #f8f9fa;
        }

        .time-slot.booked {
            background-color: #d1d5db;
            color: #6c757d;
        }

        .time-slot.available {
            background-color: #e9ecef;
            color: #198754;
        }

        .time-slot .price {
            font-size: 18px;
            font-weight: bold;
        }

        .time-slot .status {
            font-size: 14px;
            color: #198754;
            font-weight: bold;
        }

        .day-tuesday {
            color: #ff7b00;
            /* Warna merah untuk teks */
            /* background-color: #f0f0f0; */
            /* Warna latar belakang, jika diperlukan */
        }

        .day-wednesday {
            color: #ff7b00;
            /* Warna merah untuk teks */
            /* background-color: #f0f0f0; */
            /* Warna latar belakang, jika diperlukan */
        }

        .day-thursday {
            color: #ff7b00;
            /* Warna merah untuk teks */
            /* background-color: #f0f0f0; */
            /* Warna latar belakang, jika diperlukan */
        }

        .day-friday {
            color: #ff7b00;
            /* Warna merah untuk teks */
            /* background-color: #f0f0f0; */
            /* Warna latar belakang, jika diperlukan */
        }

        .day-saturday {
            color: #ff7b00;
            /* Warna merah untuk teks */
            /* background-color: #f0f0f0; */
            /* Warna latar belakang, jika diperlukan */
        }

        .day-sunday {
            color: #ff7b00;
            /* Warna merah untuk teks */
            /* background-color: #f0f0f0; */
            /* Warna latar belakang, jika diperlukan */
        }

        .day-monday {
            color: #ff7b00;
            /* Warna merah untuk teks */
            /* background-color: #f0f0f0; */
            /* Warna latar belakang, jika diperlukan */
        }

        .scroll-container {
            overflow-x: auto;
            /* Aktifkan scrolling horizontal */
            white-space: nowrap;
            /* Cegah line break pada div anak */
            padding-bottom: 10px;
            /* Tambahkan sedikit padding di bawah untuk ruang saat scroll */
        }

        #booking-slots .col-md-2 {
            flex: 0 0 auto;
            /* Pastikan kolom tidak mengecil */
            white-space: normal;
            /* Normalisasi line break dalam kolom */
            min-width: 200px;
            /* Atur lebar minimum untuk kolom */
        }

        .smaller-text {
            font-size: 0.8em;
            /* You can adjust this size */
        }
    </style>

    <main id="main">

        <!-- ======= Testimonials Section ======= -->
        <section id="testimonials" class="testimonials">
            <div class="container">
                <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <img src="{{ asset('assets/img/logo-white.svg') }}" alt="website logo"
                                    class="logo-dark mxw-300" width="382" height="157">
                                @foreach ($label as $item)
                                    @if ($item->code == 'events')
                                        <h3>{!! html_entity_decode($item->title) !!}</h3>
                                        <h4>{!! html_entity_decode($item->desc) !!}</h4>
                                    @endif
                                @endforeach


                                @foreach ($label as $item)
                                    @if ($item->code == 'tagline.event')
                                        <p>
                                            <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                            {!! html_entity_decode($item->desc) !!}
                                            <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                                        </p>
                                    @endif
                                @endforeach

                            </div>
                        </div>
                        <!-- End testimonial item -->
                    </div>
                    <div class="swiper-pagination"></div>
                </div>

            </div>
        </section>
        <!-- End Testimonials Section -->

        <!-- ======= Prosedur Section ======= -->
        <section id="event" class="features">
            <div class="container">

                <div class="section-title" data-aos="fade-up">
                    @foreach ($label as $item)
                        @if ($item->code == 'news')
                            <h2>{{ $item->title }}</h2>
                            <p>#{{ $item->desc }} , {{ $news->title }}</p>
                        @endif
                    @endforeach
                    {{-- <div class="event-info">
                    <h3>{{ $event->location }}</h3>
                    <h3>{{ date('H:i', strtotime($event->time)) }}</h3>
                </div> --}}
                </div>

                <div class="events-container-detail">
                    <div class="event" data-aos="zoom-in" data-aos-delay="100">
                        {{-- Cek apakah gambar utama ada dan valid --}}
                        @if ($news->image && Storage::exists('public/news/' . $news->image))
                            <a href="{{ asset('storage/news/' . $news->image) }}" class="gallery-lightbox">
                                <img src="{{ asset('storage/news/' . $news->image) }}" class="img-thumbnail" width="200">
                            </a>
                        @endif

                        {{-- Cek apakah gambar kedua ada dan valid --}}
                        @if ($news->image2 && Storage::exists('public/news/' . $news->image2))
                            <a href="{{ asset('storage/news/' . $news->image2) }}" class="gallery-lightbox">
                                <img src="{{ asset('storage/news/' . $news->image2) }}" alt="Gambar 2">
                            </a>
                        @endif

                        {{-- Cek apakah gambar ketiga ada dan valid --}}
                        @if ($news->image3 && Storage::exists('public/news/' . $news->image3))
                            <a href="{{ asset('storage/news/' . $news->image3) }}" class="gallery-lightbox">
                                <img src="{{ asset('storage/news/' . $news->image3) }}" alt="Gambar 3">
                            </a>
                        @endif

                        {{-- Jika tidak ada gambar sama sekali, tampilkan gambar default --}}
                        @if (!$news->image && !$news->image2 && !$news->image3)
                            <img src="{{ asset('assets/img/default-image.jpg') }}" class="img-thumbnail" width="100">
                        @endif
                    </div>


                    <div class="event-details">
                        <div class="event-title">
                            <h2><i class="bi bi-building" aria-hidden="true"></i>
                                </i> {{ $news->title }}</h2>
                        </div>
                        <div class="event-description">
                            <div class="event-title">
                                <span><i class="bi bi-journal-text"></i>
                                    {{ strip_tags(html_entity_decode($news->desc)) }}</span>
                                <br>
                                <span><i class="bi bi-envelope"></i> {{ $news->email }}</span>
                                <br>
                                <span><i class="bi bi-telephone"></i> {{ $news->phone }}</span>
                                <br>
                                <span><i class="bi bi-geo-alt"></i> {{ $news->location }}</span>
                                <br>
                                @foreach ($button as $item)
                                    {{-- @if ($item->code == 'news') --}}
                                    @if ($item->code == 'order')
                                        @if (Auth::check())
                                            <a href="{{ route('booking.show', $item->id) }}"
                                                class="btn btn-outline-success btn-block">{!! html_entity_decode($item->title) !!}</a>
                                        @else
                                            <a href="/register"
                                                class="btn btn-outline-success btn-block">{!! html_entity_decode($item->title) !!}</a>
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ======= Booking Section ======= -->
                <div class="container mt-5">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="booking-date" class="form-label">Pilih Tanggal Booking :</label>
                            <input type="date" class="form-control" id="booking-date" name="booking-date">
                        </div>
                        <div class="col-md-6">
                            <label for="lapangan" class="form-label">Lapangan :</label>
                            <input type="text" class="form-control" name="title"
                                value="{{ old('title', $news->title) }}" placeholder="Enter title" readonly="">
                        </div>
                    </div>
                    <div class="row mt-4">
                        <!-- Container untuk membuat scrolling horizontal -->
                        <div class="col-12">
                            <div class="scroll-container">
                                <div id="booking-slots" class="d-flex flex-nowrap">
                                    <!-- Slot Booking Akan Di-Generate Di Sini -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tambahkan kolom lainnya sesuai kebutuhan -->
                </div>
                <!-- End Booking Section -->

            </div>
        </section>
        <!-- End Features Section -->
    </main>
    <!-- End #main -->
    <script>
        const bookedSlots = @json($bookedSlots);

        document.getElementById('booking-date').addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            const bookingSlots = document.getElementById('booking-slots');
            bookingSlots.innerHTML = ''; // Kosongkan konten sebelumnya

            for (let i = 0; i < 7; i++) {
                const date = new Date(selectedDate);
                date.setDate(selectedDate.getDate() + i); // Tambahkan hari berturut-turut

                // Format tanggal
                const dayName = date.toLocaleString('en-US', {
                    weekday: 'long'
                });
                const dayMonth = date.toLocaleString('en-US', {
                    day: '2-digit',
                    month: 'short'
                });

                // Buat elemen kolom
                const colDiv = document.createElement('div');
                colDiv.className = 'col-md-2';

                // Buat elemen date box
                const dateBox = document.createElement('div');
                dateBox.className = 'date-box';
                dateBox.innerHTML =
                    `<div>${dayMonth}</div><div class="day-${dayName.toLowerCase()}">${dayName}</div>`;
                colDiv.appendChild(dateBox);

                // Loop untuk setiap slot waktu dari 06:00 hingga 22:00
                for (let hour = 6; hour < 22; hour += 1) {
                    const timeSlot = document.createElement('div');
                    timeSlot.className = 'time-slot available';

                    // Format jam
                    const startHour = hour.toString().padStart(2, '0');
                    const endHour = (hour + 1).toString().padStart(2, '0');
                    const slotDate = date.toISOString().split('T')[0]; // Format ISO untuk tanggal

                    // Periksa apakah slot ini sudah dipesan dari data booking
                    const isBooked = bookedSlots.some(slot => slot.booking_date === slotDate && hour >= parseInt(
                        slot
                        .start_time) && hour < parseInt(slot.end_time));

                    timeSlot.innerHTML = `
                        <small style="font-size: 0.8em;">60 Menit</small>
                        <div>${startHour}:00 - ${endHour}:00</div>
                        <div class="price">{{ 'Rp ' . number_format($news->price, 2, ',', '.') }}</div>
                        <div class="status" style="color: ${isBooked ? 'red' : ''};">
    ${isBooked ? 'Booked' : 'Available'}
</div>
                    `;

                    // Tambahkan class "booked" jika sudah dipesan
                    if (isBooked) {
                        timeSlot.classList.remove('available');
                        timeSlot.classList.add('booked');
                    }

                    colDiv.appendChild(timeSlot);
                }

                bookingSlots.appendChild(colDiv);
            }
        });
    </script>
@endsection

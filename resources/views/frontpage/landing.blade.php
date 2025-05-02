<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arjuna Trans - Layanan Transportasi Pariwisata Terbaik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#FF6500',
                        primaryDark: '#E05A00',
                        secondary: '#2D3748',
                        accent: '#4A5568',
                        light: '#F7FAFC',
                        dark: '#1A202C'
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'float-reverse': 'float-reverse 5s ease-in-out infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': {
                                transform: 'translateY(0)'
                            },
                            '50%': {
                                transform: 'translateY(-20px)'
                            },
                        },
                        'float-reverse': {
                            '0%, 100%': {
                                transform: 'translateY(0)'
                            },
                            '50%': {
                                transform: 'translateY(15px)'
                            },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        .hero-pattern {
            background-image: radial-gradient(rgba(255, 101, 0, 0.2) 1px, transparent 1px);
            background-size: 20px 20px;
        }

        .nav-link {
            position: relative;
        }

        .nav-link:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #FF6500;
            transition: width 0.3s ease;
        }

        .nav-link:hover:after {
            width: 100%;
        }

        .vehicle-card:hover .vehicle-image {
            transform: scale(1.05);
        }

        .testimonial-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .input-focus:focus {
            box-shadow: 0 0 0 2px rgba(255, 101, 0, 0.5);
        }

        .multiple-select {
            height: auto;
            min-height: 48px;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="fixed w-full bg-white shadow-sm z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <i class="fas fa-bus text-primary text-2xl mr-2"></i>
                        <span class="text-xl font-bold text-secondary">Arjuna Trans</span>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-center space-x-8">
                        <a href="#home" class="nav-link text-gray-700 hover:text-primary px-3 py-2 text-sm font-medium">Beranda</a>
                        <a href="#services" class="nav-link text-gray-700 hover:text-primary px-3 py-2 text-sm font-medium">Layanan</a>
                        <a href="#vehicles" class="nav-link text-gray-700 hover:text-primary px-3 py-2 text-sm font-medium">Armada</a>
                        <a href="#testimonials" class="nav-link text-gray-700 hover:text-primary px-3 py-2 text-sm font-medium">Testimoni</a>
                        <a href="#about" class="nav-link text-gray-700 hover:text-primary px-3 py-2 text-sm font-medium">Tentang</a>
                        <a href="#contact" class="nav-link text-gray-700 hover:text-primary px-3 py-2 text-sm font-medium">Kontak</a>
                        <a href="#booking" class="ml-4 bg-primary text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-primaryDark transition">Pesan Sekarang</a>
                    </div>
                </div>
                <div class="md:hidden">
                    <button type="button" class="mobile-menu-button inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-primary focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="mobile-menu hidden md:hidden bg-white shadow-lg">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="#home" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-primary">Beranda</a>
                <a href="#services" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-primary">Layanan</a>
                <a href="#vehicles" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-primary">Armada</a>
                <a href="#testimonials" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-primary">Testimoni</a>
                <a href="#about" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-primary">Tentang</a>
                <a href="#contact" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-primary">Kontak</a>
                <a href="#booking" class="block px-3 py-2 text-base font-medium text-white bg-primary rounded-md">Pesan Sekarang</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="pt-24 pb-16 md:pt-32 md:pb-24 hero-pattern">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-2 lg:gap-12 items-center">
                <div class="mb-12 lg:mb-0">
                    <h1 class="text-4xl md:text-5xl font-bold text-secondary leading-tight mb-6">
                        Perjalanan Nyaman dengan <span class="text-primary">Arjuna Trans</span>
                    </h1>
                    <p class="text-lg text-gray-600 mb-8">
                        Terpercaya untuk perjalanan Pariwisata. Kenyamanan, keamanan, dan layanan terbaik untuk pengalaman perjalanan yang tak terlupakan!
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="#booking" class="bg-primary hover:bg-primaryDark text-white font-medium py-3 px-6 rounded-lg transition flex items-center">
                            Pesan Sekarang <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                        <a href="#services" class="border border-gray-300 hover:border-primary text-gray-700 hover:text-primary font-medium py-3 px-6 rounded-lg transition flex items-center">
                            <i class="fas fa-play-circle mr-2"></i> Lihat Layanan
                        </a>
                    </div>
                    <div class="mt-10 flex flex-wrap gap-6">
                        <div class="flex items-center">
                            <div class="bg-primary bg-opacity-10 p-3 rounded-full mr-3">
                                <i class="fas fa-check-circle text-primary"></i>
                            </div>
                            <span class="text-gray-700 font-medium">Profesional</span>
                        </div>
                        <div class="flex items-center">
                            <div class="bg-primary bg-opacity-10 p-3 rounded-full mr-3">
                                <i class="fas fa-check-circle text-primary"></i>
                            </div>
                            <span class="text-gray-700 font-medium">Terpercaya</span>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="relative">
                        <img src="{{ asset('assets/images/travel-ilustration.png') }}"
                             alt="Travel Bus"
                             class="rounded-2xl shadow-xl w-full h-auto animate-float">
                        <div class="absolute -bottom-4 -right-4 w-25 h-25 bg-primary bg-opacity-10 rounded-2xl animate-float-reverse"></div>
                    </div>
                    <div class="absolute -z-10 w-full h-full bg-primary bg-opacity-5 rounded-2xl -bottom-6 -right-6"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-block px-3 py-1 text-sm font-medium text-primary bg-primary bg-opacity-10 rounded-full mb-4">Layanan Kami</span>
                <h2 class="text-3xl md:text-4xl font-bold text-secondary mb-4">Solusi Transportasi Pariwisata</h2>
                <p class="max-w-2xl mx-auto text-gray-600">Kami menyediakan berbagai layanan transportasi pariwisata untuk memenuhi kebutuhan perjalanan Anda</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-gray-50 p-8 rounded-xl hover:shadow-lg transition">
                    <div class="w-14 h-14 bg-primary bg-opacity-10 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-map-marked-alt text-primary text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-secondary mb-3">Tour Wisata</h3>
                    <p class="text-gray-600">Perjalanan wisata ke berbagai destinasi menarik dengan rute yang telah kami persiapkan dengan matang.</p>
                </div>

                <div class="bg-gray-50 p-8 rounded-xl hover:shadow-lg transition">
                    <div class="w-14 h-14 bg-primary bg-opacity-10 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-users text-primary text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-secondary mb-3">Group Travel</h3>
                    <p class="text-gray-600">Layanan transportasi untuk kelompok dengan kapasitas sesuai kebutuhan Anda, nyaman dan aman.</p>
                </div>

                <div class="bg-gray-50 p-8 rounded-xl hover:shadow-lg transition">
                    <div class="w-14 h-14 bg-primary bg-opacity-10 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-plane text-primary text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-secondary mb-3">Airport Transfer</h3>
                    <p class="text-gray-600">Pengantaran dan penjemputan dari/ke bandara dengan tepat waktu dan pelayanan yang profesional.</p>
                </div>

                <div class="bg-gray-50 p-8 rounded-xl hover:shadow-lg transition">
                    <div class="w-14 h-14 bg-primary bg-opacity-10 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-hotel text-primary text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-secondary mb-3">Hotel Transfer</h3>
                    <p class="text-gray-600">Layanan antar jemput dari/ke hotel dengan sopir berpengalaman dan kendaraan yang nyaman.</p>
                </div>

                <div class="bg-gray-50 p-8 rounded-xl hover:shadow-lg transition">
                    <div class="w-14 h-14 bg-primary bg-opacity-10 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-calendar-check text-primary text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-secondary mb-3">Event Transport</h3>
                    <p class="text-gray-600">Transportasi untuk acara khusus seperti pernikahan, seminar, atau acara perusahaan dengan pelayanan prima.</p>
                </div>

                <div class="bg-gray-50 p-8 rounded-xl hover:shadow-lg transition">
                    <div class="w-14 h-14 bg-primary bg-opacity-10 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-route text-primary text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-secondary mb-3">Custom Trip</h3>
                    <p class="text-gray-600">Rencanakan perjalanan sesuai keinginan Anda dengan rute dan destinasi pilihan yang fleksibel.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Vehicles Section -->
    <section id="vehicles" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-block px-3 py-1 text-sm font-medium text-primary bg-primary bg-opacity-10 rounded-full mb-4">Armada Kami</span>
                <h2 class="text-3xl md:text-4xl font-bold text-secondary mb-4">Kendaraan Nyaman & Aman</h2>
                <p class="max-w-2xl mx-auto text-gray-600">Kami menyediakan berbagai jenis kendaraan yang terawat dengan baik untuk kenyamanan perjalanan Anda</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Vehicle 1 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition vehicle-card">
                    <div class="overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1558981852-426c6c22a060?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Toyota Elf" class="w-full h-48 object-cover vehicle-image transition duration-500">
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-lg font-bold text-secondary">Toyota Elf</h3>
                            <span class="bg-primary bg-opacity-10 text-primary text-xs font-medium px-2.5 py-0.5 rounded">12 Seat</span>
                        </div>
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center">
                                <i class="fas fa-snowflake text-primary mr-2"></i>
                                <span class="text-sm text-gray-600">AC Dingin</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-music text-primary mr-2"></i>
                                <span class="text-sm text-gray-600">Audio System</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-chair text-primary mr-2"></i>
                                <span class="text-sm text-gray-600">Kursi Nyaman</span>
                            </div>
                        </div>
                        <a href="#booking" class="block text-center bg-primary hover:bg-primaryDark text-white font-medium py-2 px-4 rounded-lg transition text-sm">
                            Pesan Sekarang
                        </a>
                    </div>
                </div>

                <!-- Vehicle 2 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition vehicle-card">
                    <div class="overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1605559424843-9e4c228bf1c2?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Toyota Hiace" class="w-full h-48 object-cover vehicle-image transition duration-500">
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-lg font-bold text-secondary">Toyota Hiace</h3>
                            <span class="bg-primary bg-opacity-10 text-primary text-xs font-medium px-2.5 py-0.5 rounded">15 Seat</span>
                        </div>
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center">
                                <i class="fas fa-snowflake text-primary mr-2"></i>
                                <span class="text-sm text-gray-600">AC Dingin</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-tv text-primary mr-2"></i>
                                <span class="text-sm text-gray-600">TV & DVD</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-couch text-primary mr-2"></i>
                                <span class="text-sm text-gray-600">Reclining Seat</span>
                            </div>
                        </div>
                        <a href="#booking" class="block text-center bg-primary hover:bg-primaryDark text-white font-medium py-2 px-4 rounded-lg transition text-sm">
                            Pesan Sekarang
                        </a>
                    </div>
                </div>

                <!-- Vehicle 3 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition vehicle-card">
                    <div class="overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Bus Medium" class="w-full h-48 object-cover vehicle-image transition duration-500">
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-lg font-bold text-secondary">Bus Medium</h3>
                            <span class="bg-primary bg-opacity-10 text-primary text-xs font-medium px-2.5 py-0.5 rounded">30 Seat</span>
                        </div>
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center">
                                <i class="fas fa-snowflake text-primary mr-2"></i>
                                <span class="text-sm text-gray-600">AC Dingin</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-toilet text-primary mr-2"></i>
                                <span class="text-sm text-gray-600">Toilet</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-film text-primary mr-2"></i>
                                <span class="text-sm text-gray-600">Entertainment</span>
                            </div>
                        </div>
                        <a href="#booking" class="block text-center bg-primary hover:bg-primaryDark text-white font-medium py-2 px-4 rounded-lg transition text-sm">
                            Pesan Sekarang
                        </a>
                    </div>
                </div>

                <!-- Vehicle 4 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition vehicle-card">
                    <div class="overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1506260408121-e353d10b87c7?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Bus Besar" class="w-full h-48 object-cover vehicle-image transition duration-500">
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-lg font-bold text-secondary">Bus Besar</h3>
                            <span class="bg-primary bg-opacity-10 text-primary text-xs font-medium px-2.5 py-0.5 rounded">50 Seat</span>
                        </div>
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center">
                                <i class="fas fa-snowflake text-primary mr-2"></i>
                                <span class="text-sm text-gray-600">AC Dingin</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-toilet text-primary mr-2"></i>
                                <span class="text-sm text-gray-600">Toilet</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-wifi text-primary mr-2"></i>
                                <span class="text-sm text-gray-600">WiFi</span>
                            </div>
                        </div>
                        <a href="#booking" class="block text-center bg-primary hover:bg-primaryDark text-white font-medium py-2 px-4 rounded-lg transition text-sm">
                            Pesan Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-block px-3 py-1 text-sm font-medium text-primary bg-primary bg-opacity-10 rounded-full mb-4">Testimoni</span>
                <h2 class="text-3xl md:text-4xl font-bold text-secondary mb-4">Apa Kata Pelanggan Kami</h2>
                <p class="max-w-2xl mx-auto text-gray-600">Pengalaman nyata dari pelanggan yang telah menggunakan layanan Arjuna Trans</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-gray-50 p-8 rounded-xl testimonial-card transition duration-300">
                    <div class="flex items-center mb-6">
                        <img src="https://randomuser.me/api/portraits/women/32.jpg" alt="Sarah Wijaya" class="w-12 h-12 rounded-full object-cover mr-4">
                        <div>
                            <h4 class="font-bold text-secondary">Sarah Wijaya</h4>
                            <div class="flex text-yellow-400 mt-1">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-6">"Perjalanan wisata ke Bali bersama Arjuna Trans sangat menyenangkan. Sopirnya ramah dan profesional, armadanya nyaman dan bersih. Sangat direkomendasikan!"</p>
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2 text-primary"></i>
                        <span>12 Januari 2023</span>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-gray-50 p-8 rounded-xl testimonial-card transition duration-300">
                    <div class="flex items-center mb-6">
                        <img src="https://randomuser.me/api/portraits/men/75.jpg" alt="Budi Santoso" class="w-12 h-12 rounded-full object-cover mr-4">
                        <div>
                            <h4 class="font-bold text-secondary">Budi Santoso</h4>
                            <div class="flex text-yellow-400 mt-1">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-6">"Menggunakan Arjuna Trans untuk acara perusahaan kami. Pelayanannya sangat baik, tepat waktu, dan harganya kompetitif. Pasti akan menggunakan lagi untuk acara berikutnya."</p>
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2 text-primary"></i>
                        <span>5 Maret 2023</span>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-gray-50 p-8 rounded-xl testimonial-card transition duration-300">
                    <div class="flex items-center mb-6">
                        <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Dewi Lestari" class="w-12 h-12 rounded-full object-cover mr-4">
                        <div>
                            <h4 class="font-bold text-secondary">Dewi Lestari</h4>
                            <div class="flex text-yellow-400 mt-1">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-6">"Pengalaman pertama menggunakan Arjuna Trans sangat memuaskan. Busnya bersih dan nyaman, sopirnya berpengalaman dan tahu jalan-jalan alternatif untuk menghindari macet."</p>
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2 text-primary"></i>
                        <span="22 April 2023</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Booking Section -->
    <section id="booking" class="py-16 bg-primary">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                                <div class="grid grid-cols-1 lg:grid-cols-2">
                                    <div class="p-8 md:p-12 lg:p-16">
                                        <h2 class="text-3xl font-bold text-secondary mb-4">Pesan Kendaraan Anda Sekarang</h2>
                                        <p class="text-gray-600 mb-8">Isi form berikut untuk memesan layanan transportasi kami. Tim kami akan segera menghubungi Anda untuk konfirmasi.</p>

                                        <form class="space-y-5">
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                                <div>
                                                    <label class="block text-gray-700 text-sm font-medium mb-1">Nama Lengkap</label>
                                                    <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent input-focus" placeholder="Nama Anda" required>
                                                </div>
                                                <div>
                                                    <label class="block text-gray-700 text-sm font-medium mb-1">Email</label>
                                                    <input type="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent input-focus" placeholder="email@contoh.com" required>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                                <div>
                                                    <label class="block text-gray-700 text-sm font-medium mb-1">Nomor Telepon</label>
                                                    <input type="tel" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent input-focus" placeholder="0812-3456-7890" required>
                                                </div>
                                                <div>
                                                    <label class="block text-gray-700 text-sm font-medium mb-1">Tanggal Perjalanan</label>
                                                    <input type="date" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent input-focus" required>
                                                </div>
                                            </div>

                                            <div>
                                                <label class="block text-gray-700 text-sm font-medium mb-1">Lokasi Penjemputan</label>
                                                <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent input-focus" placeholder="Alamat lengkap penjemputan" required>
                                            </div>

                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                                <div>
                                                    <label class="block text-gray-700 text-sm font-medium mb-1">Tujuan</label>
                                                    <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent input-focus" placeholder="Tujuan perjalanan" required>
                                                </div>
                                                <div>
                                                    <label class="block text-gray-700 text-sm font-medium mb-1">Jumlah Penumpang</label>
                                                    <input type="number" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent input-focus" placeholder="Jumlah penumpang" min="1" required>
                                                </div>
                                            </div>

                                            <div>
                                                <label class="block text-gray-700 text-sm font-medium mb-1">Jenis Kendaraan</label>
                                                <select multiple class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent input-focus multiple-select" required>
                                                    <option value="elf">Toyota Elf (12 Seat)</option>
                                                    <option value="hiace">Toyota Hiace (15 Seat)</option>
                                                    <option value="bus-medium">Bus Medium (30 Seat)</option>
                                                    <option value="bus-besar">Bus Besar (50 Seat)</option>
                                                </select>
                                                <p class="text-xs text-gray-500 mt-1">Tekan Ctrl/Cmd untuk memilih lebih dari satu</p>
                                            </div>

                                            <div>
                                                <label class="block text-gray-700 text-sm font-medium mb-1">Catatan Tambahan</label>
                                                <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent input-focus" rows="3" placeholder="Kebutuhan khusus atau permintaan lainnya"></textarea>
                                            </div>

                                            <button type="submit" class="w-full bg-primary hover:bg-primaryDark text-white font-medium py-3 px-6 rounded-lg transition">
                                                Kirim Pesanan
                                            </button>
                                        </form>
                                    </div>
                                    <div class="hidden lg:block bg-gray-50 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1506929562872-bb421503ef21?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80')">
                                        <div class="h-full bg-primary bg-opacity-80 flex items-center justify-center p-12">
                                            <div class="text-white text-center">
                                                <h3 class="text-2xl font-bold mb-4">Butuh Bantuan?</h3>
                                                <p class="mb-6">Tim customer service kami siap membantu Anda 24/7 untuk semua pertanyaan dan kebutuhan pemesanan.</p>
                                                <div class="flex items-center justify-center space-x-4">
                                                    <div class="bg-white bg-opacity-20 p-3 rounded-full">
                                                        <i class="fas fa-phone-alt"></i>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm">Hubungi Kami</p>
                                                        <p class="font-bold text-lg">+62 361 1234567</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="order-2 lg:order-1">
                    <span class="inline-block px-3 py-1 text-sm font-medium text-primary bg-primary bg-opacity-10 rounded-full mb-4">Tentang Kami</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-secondary mb-6">Arjuna Trans - Partner Perjalanan Anda</h2>
                    <p class="text-gray-600 mb-6">Arjuna Trans adalah penyedia layanan transportasi pariwisata profesional yang berkomitmen memberikan pengalaman perjalanan terbaik bagi pelanggan kami sejak tahun 2010.</p>

                    <div class="space-y-4 mb-8">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="bg-primary bg-opacity-10 p-2 rounded-lg">
                                    <i class="fas fa-check text-primary"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-medium text-secondary">Sopir Profesional</h4>
                                <p class="text-gray-600 mt-1">Sopir kami berpengalaman dan terlatih untuk memberikan perjalanan yang aman dan nyaman.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="bg-primary bg-opacity-10 p-2 rounded-lg">
                                    <i class="fas fa-check text-primary"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-medium text-secondary">Armada Terawat</h4>
                                <p class="text-gray-600 mt-1">Kendaraan kami selalu dalam kondisi prima dengan perawatan rutin untuk kenyamanan Anda.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="bg-primary bg-opacity-10 p-2 rounded-lg">
                                    <i class="fas fa-check text-primary"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-medium text-secondary">Layanan 24/7</h4>
                                <p class="text-gray-600 mt-1">Tim kami siap membantu Anda kapan saja untuk semua kebutuhan transportasi Anda.</p>
                            </div>
                        </div>
                    </div>

                    <a href="#contact" class="inline-flex items-center text-primary font-medium">
                        Hubungi Kami <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <div class="order-1 lg:order-2 relative">
                    <img src="https://images.unsplash.com/photo-1502877338535-766e1452684a?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="About Arjuna Trans" class="rounded-xl shadow-lg w-full">
                    <div class="absolute -bottom-6 -left-6 bg-primary w-32 h-32 rounded-xl -z-10"></div>
                    <div class="absolute -top-6 -right-6 bg-primary bg-opacity-20 w-32 h-32 rounded-xl -z-10"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-block px-3 py-1 text-sm font-medium text-primary bg-primary bg-opacity-10 rounded-full mb-4">Kontak Kami</span>
                <h2 class="text-3xl md:text-4xl font-bold text-secondary mb-4">Hubungi Kami</h2>
                <p class="max-w-2xl mx-auto text-gray-600">Tim kami siap membantu Anda untuk semua pertanyaan dan kebutuhan transportasi</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <div>
                    <div class="bg-gray-50 rounded-xl p-8 shadow-sm">
                        <h3 class="text-xl font-bold text-secondary mb-6">Kirim Pesan</h3>
                        <form class="space-y-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-gray-700 text-sm font-medium mb-1">Nama Anda</label>
                                    <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent input-focus" placeholder="Nama lengkap" required>
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-medium mb-1">Email</label>
                                    <input type="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent input-focus" placeholder="email@contoh.com" required>
                                </div>
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-1">Subjek</label>
                                <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent input-focus" placeholder="Subjek pesan" required>
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-1">Pesan</label>
                                <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent input-focus" rows="4" placeholder="Tulis pesan Anda" required></textarea>
                            </div>

                            <button type="submit" class="bg-primary hover:bg-primaryDark text-white font-medium py-3 px-6 rounded-lg transition">
                                Kirim Pesan
                            </button>
                        </form>
                    </div>
                </div>

                <div>
                    <div class="space-y-8">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded-lg">
                                <i class="fas fa-map-marker-alt text-primary text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-bold text-secondary mb-2">Lokasi Kami</h3>
                                <p class="text-gray-600">Jl. Raya Kuta No. 123, Badung, Bali, Indonesia</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded-lg">
                                <i class="fas fa-phone-alt text-primary text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-bold text-secondary mb-2">Telepon</h3>
                                <p class="text-gray-600 mb-1">+62 361 1234567</p>
                                <p class="text-gray-600">+62 812 3456 7890 (WhatsApp)</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded-lg">
                                <i class="fas fa-envelope text-primary text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-bold text-secondary mb-2">Email</h3>
                                <p class="text-gray-600 mb-1">info@arjunatrans.com</p>
                                <p class="text-gray-600">booking@arjunatrans.com</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded-lg">
                                <i class="fas fa-clock text-primary text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-bold text-secondary mb-2">Jam Operasional</h3>
                                <p class="text-gray-600 mb-1">Senin - Jumat: 8:00 - 17:00</p>
                                <p class="text-gray-600">Sabtu: 8:00 - 15:0</p>
                            </div>
                        </div>

                        <div class="pt-4">
                            <h3 class="text-lg font-bold text-secondary mb-4">Ikuti Kami</h3>
                            <div class="flex space-x-4">
                                <a href="#" class="bg-gray-100 hover:bg-primary hover:text-white w-10 h-10 rounded-full flex items-center justify-center transition">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="bg-gray-100 hover:bg-primary hover:text-white w-10 h-10 rounded-full flex items-center justify-center transition">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="#" class="bg-gray-100 hover:bg-primary hover:text-white w-10 h-10 rounded-full flex items-center justify-center transition">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="bg-gray-100 hover:bg-primary hover:text-white w-10 h-10 rounded-full flex items-center justify-center transition">
                                    <i class="fab fa-youtube"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-secondary text-white pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                <div>
                    <div class="flex items-center mb-4">
                        <i class="fas fa-bus text-primary text-2xl mr-2"></i>
                        <span class="text-xl font-bold">Arjuna Trans</span>
                    </div>
                    <p class="text-gray-300 mb-4">Terpercaya untuk perjalanan Pariwisata. Kenyamanan, keamanan, dan layanan terbaik untuk pengalaman perjalanan yang tak terlupakan!</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-300 hover:text-primary transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-primary transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-primary transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-primary transition">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-4">Tautan Cepat</h3>
                    <ul class="space-y-2">
                        <li><a href="#home" class="text-gray-300 hover:text-primary transition">Beranda</a></li>
                        <li><a href="#services" class="text-gray-300 hover:text-primary transition">Layanan</a></li>
                        <li><a href="#vehicles" class="text-gray-300 hover:text-primary transition">Armada</a></li>
                        <li><a href="#testimonials" class="text-gray-300 hover:text-primary transition">Testimoni</a></li>
                        <li><a href="#about" class="text-gray-300 hover:text-primary transition">Tentang Kami</a></li>
                        <li><a href="#contact" class="text-gray-300 hover:text-primary transition">Kontak</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-4">Layanan</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-primary transition">Tour Wisata</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-primary transition">Group Travel</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-primary transition">Airport Transfer</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-primary transition">Hotel Transfer</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-primary transition">Event Transport</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-primary transition">Custom Trip</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-4">Newsletter</h3>
                    <p class="text-gray-300 mb-4">Dapatkan informasi terbaru tentang promo dan layanan kami.</p>
                    <form class="flex">
                        <input type="email" placeholder="Email Anda" class="px-4 py-3 rounded-l-lg focus:outline-none text-gray-800 w-full">
                        <button type="submit" class="bg-primary hover:bg-primaryDark text-white px-4 rounded-r-lg transition">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>

            <div class="border-t border-gray-700 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-300 text-sm mb-4 md:mb-0">&copy; 2023 Arjuna Trans. All rights reserved.</p>
                    <div class="flex space-x-6">
                        <a href="#" class="text-gray-300 hover:text-primary text-sm transition">Terms of Service</a>
                        <a href="#" class="text-gray-300 hover:text-primary text-sm transition">Privacy Policy</a>
                        <a href="#" class="text-gray-300 hover:text-primary text-sm transition">Cookie Policy</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating Action Button -->
    <div class="fixed bottom-6 right-6 z-50">
        <a href="#booking" class="bg-primary hover:bg-primaryDark text-white w-14 h-14 rounded-full flex items-center justify-center shadow-lg transition transform hover:scale-110">
            <i class="fas fa-calendar-check text-xl"></i>
        </a>
    </div>

    <!-- Back to Top Button -->
    <div class="fixed bottom-24 right-6 z-50 hidden">
        <button id="backToTop" class="bg-gray-700 hover:bg-gray-800 text-white w-12 h-12 rounded-full flex items-center justify-center shadow-lg transition">
            <i class="fas fa-arrow-up"></i>
        </button>
    </div>

    <!-- WhatsApp Floating Button -->
    <div class="fixed bottom-6 left-6 z-50">
        <a href="https://wa.me/6281234567890" class="bg-green-500 hover:bg-green-600 text-white w-14 h-14 rounded-full flex items-center justify-center shadow-lg transition transform hover:scale-110">
            <i class="fab fa-whatsapp text-2xl"></i>
        </a>
    </div>

    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.querySelector('.mobile-menu-button');
        const mobileMenu = document.querySelector('.mobile-menu');

        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('nav');
            if (window.scrollY > 50) {
                navbar.classList.add('shadow-lg');
                navbar.classList.add('bg-white');
                navbar.classList.remove('bg-opacity-0');
            } else {
                navbar.classList.remove('shadow-lg');
                navbar.classList.remove('bg-white');
                navbar.classList.add('bg-opacity-0');
            }

            // Show/hide back to top button
            const backToTopButton = document.querySelector('#backToTop');
            if (window.scrollY > 300) {
                backToTopButton.classList.remove('hidden');
            } else {
                backToTopButton.classList.add('hidden');
            }
        });

        // Back to top button
        document.getElementById('backToTop').addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();

                const targetId = this.getAttribute('href');
                if (targetId === '#') return;

                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });

                    // Close mobile menu if open
                    mobileMenu.classList.add('hidden');
                }
            });
        });

        // Set minimum date for booking forms
        const today = new Date().toISOString().split('T')[0];
        document.querySelectorAll('input[type="date"]').forEach(dateInput => {
            dateInput.min = today;
        });

        // Form submission handling
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                alert('Terima kasih! Pesan/pesanan Anda telah terkirim. Kami akan segera menghubungi Anda.');
                this.reset();
            });
        });

        // Custom multiple select styling
        document.querySelectorAll('.multiple-select').forEach(select => {
            select.addEventListener('change', function() {
                const options = Array.from(this.selectedOptions);
                const values = options.map(option => option.text);
                this.setAttribute('title', values.join(', '));
            });
        });
    </script>
</body>

</html>

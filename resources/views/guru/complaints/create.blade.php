@extends('layouts.rapi')

@section('title', 'Pengaduan Guru')

@section('page-title', 'Pengaduan Guru')

@section('breadcrumb', 'Admin / Pengaduan / Tambah')

@section('content')

<main class="max-w-5xl mx-auto px-6 py-8">

    {{-- ERROR --}}
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-5 py-4 mb-6">

            <p class="font-semibold">
                Pengaduan belum dapat dikirim
            </p>

            <ul class="list-disc list-inside text-sm mt-2 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif


    {{-- FORM CARD --}}
    <section class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">

        {{-- CARD HEADER --}}
        <div class="px-6 py-5 border-b border-slate-100">

            <h3 class="text-lg font-bold text-slate-900">
                Form Pengaduan Kerusakan
            </h3>

            <p class="text-sm text-slate-500 mt-1">
                Lengkapi informasi fasilitas yang mengalami kerusakan.
            </p>

        </div>


        {{-- FORM --}}
        <form
            action="{{ route('guru.complaints.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="p-6 md:p-8">

            @csrf


            {{-- JUDUL --}}
            <div class="mb-6">

                <label for="title"
                       class="block text-sm font-semibold text-slate-700 mb-2">

                    Judul Pengaduan

                </label>

                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title') }}"
                    placeholder="Contoh: Proyektor tidak menyala"
                    required
                    class="w-full border border-slate-300 bg-white text-slate-800 placeholder-slate-400 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">

                @error('title')
                    <p class="text-red-600 text-sm mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- RUANGAN --}}
            <div class="mb-6">

                <label for="room_id"
                       class="block text-sm font-semibold text-slate-700 mb-2">

                    Ruangan

                </label>

                <select
                    id="room_id"
                    name="room_id"
                    required
                    class="w-full border border-slate-300 bg-white text-slate-800 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">

                    <option value="">
                        -- Pilih Ruangan --
                    </option>

                    @foreach ($rooms as $room)
                        <option
                            value="{{ $room->id }}"
                            {{ old('room_id') == $room->id ? 'selected' : '' }}>

                            {{ $room->name }} - {{ $room->location }}

                        </option>
                    @endforeach

                </select>

                @error('room_id')
                    <p class="text-red-600 text-sm mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- DESKRIPSI --}}
            <div class="mb-6">

                <label for="description"
                       class="block text-sm font-semibold text-slate-700 mb-2">

                    Deskripsi Kerusakan

                </label>

                <textarea
                    id="description"
                    name="description"
                    rows="6"
                    placeholder="Jelaskan kondisi kerusakan yang ditemukan..."
                    required
                    class="w-full border border-slate-300 bg-white text-slate-800 placeholder-slate-400 rounded-xl px-4 py-3 outline-none resize-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">{{ old('description') }}</textarea>

                <p class="text-xs text-slate-400 mt-2">
                    Jelaskan jenis kerusakan dan kondisi fasilitas secara jelas.
                </p>

                @error('description')
                    <p class="text-red-600 text-sm mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- FOTO --}}
            <div class="mb-6">

                <label class="block text-sm font-semibold text-slate-700 mb-3">
                    Foto Kerusakan
                </label>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    {{-- PILIH FOTO GALERI --}}
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-5">

                        <div class="flex items-center gap-2 mb-4">

                            <div class="bg-indigo-100 text-indigo-600 p-2 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-5 h-5"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>

                                </svg>
                            </div>

                            <div>
                                <h4 class="font-semibold text-slate-800">
                                    Pilih dari Galeri
                                </h4>

                                <p class="text-xs text-slate-500">
                                    Gunakan foto yang sudah tersedia.
                                </p>
                            </div>

                        </div>

                        <input
                            type="file"
                            id="photo"
                            name="photo"
                            accept="image/jpeg,image/png,image/webp"
                            class="block w-full text-sm text-slate-600
                                   file:mr-3 file:py-2 file:px-3
                                   file:rounded-lg file:border-0
                                   file:text-sm file:font-semibold
                                   file:bg-indigo-600 file:text-white
                                   hover:file:bg-indigo-700
                                   file:cursor-pointer">

                        <p class="text-xs text-slate-500 mt-3">
                            JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
                        </p>

                    </div>


                    {{-- AMBIL FOTO KAMERA --}}
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-5">

                        <div class="flex items-center gap-2 mb-4">

                            <div class="bg-emerald-100 text-emerald-600 p-2 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-5 h-5"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M3 9a2 2 0 012-2h2l2-2h6l2 2h2a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>

                                    <circle cx="12"
                                            cy="13"
                                            r="3"
                                            stroke-width="2"/>

                                </svg>
                            </div>

                            <div>
                                <h4 class="font-semibold text-slate-800">
                                    Foto Langsung
                                </h4>

                                <p class="text-xs text-slate-500">
                                    Ambil foto menggunakan kamera.
                                </p>
                            </div>

                        </div>


                        {{-- AREA KAMERA DAN PREVIEW --}}
                        <div class="relative w-full min-h-48 bg-slate-200 rounded-xl overflow-hidden flex items-center justify-center">

                            {{-- PLACEHOLDER --}}
                            <div id="cameraPlaceholder"
                                 class="text-center text-slate-500 p-5">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-12 h-12 mx-auto mb-2 text-slate-400"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="1.5"
                                          d="M3 9a2 2 0 012-2h2l2-2h6l2 2h2a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>

                                    <circle cx="12"
                                            cy="13"
                                            r="3"
                                            stroke-width="1.5"/>

                                </svg>

                                <p class="text-sm">
                                    Kamera belum dibuka
                                </p>

                            </div>


                            {{-- LIVE CAMERA --}}
                            <video
                                id="cameraPreview"
                                autoplay
                                playsinline
                                class="hidden w-full max-h-80 object-contain bg-black">
                            </video>


                            {{-- HASIL FOTO --}}
                            <img
                                id="photoPreview"
                                src=""
                                alt="Preview foto kerusakan"
                                class="hidden w-full max-h-80 object-contain bg-black">


                            {{-- CANVAS UNTUK MENGAMBIL FOTO --}}
                            <canvas id="photoCanvas" class="hidden"></canvas>

                        </div>


                        {{-- BUTTON KAMERA --}}
                        <div class="flex flex-wrap gap-2 mt-4">

                            <button
                                type="button"
                                id="startCameraBtn"
                                class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition">

                                Buka Kamera

                            </button>

                            <button
                                type="button"
                                id="capturePhotoBtn"
                                class="hidden flex-1 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition">

                                Ambil Foto

                            </button>

                            <button
                                type="button"
                                id="stopCameraBtn"
                                class="hidden flex-1 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition">

                                Tutup Kamera

                            </button>

                        </div>


                        {{-- STATUS KAMERA --}}
                        <p id="cameraStatus"
                           role="status"
                           aria-live="polite"
                           class="text-xs text-slate-500 mt-3">

                            Tekan tombol Buka Kamera untuk mengambil foto langsung.

                        </p>

                    </div>

                </div>


                @error('photo')
                    <p class="text-red-600 text-sm mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- INFORMATION --}}
            <div class="bg-indigo-50 border border-indigo-100 rounded-xl px-5 py-4">

                <p class="text-sm font-semibold text-indigo-700">
                    Proses Pengaduan
                </p>

                <p class="text-sm text-indigo-600 mt-1 leading-6">

                    Setelah dikirim, pengaduan akan tercatat dengan
                    status Dilaporkan. PIC ruangan dapat memproses
                    laporan dan memperbarui status penanganannya.

                </p>

            </div>


            {{-- BUTTON --}}
            <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-3 mt-8 pt-6 border-t border-slate-100">

                <a href="{{ route('guru.complaints.index') }}"
                   class="inline-flex justify-center bg-slate-100 hover:bg-slate-200 text-slate-700 px-5 py-2.5 rounded-lg text-sm font-semibold transition">

                    Batal

                </a>

                <button
                    type="submit"
                    class="inline-flex justify-center bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-lg text-sm font-semibold shadow-sm transition">

                    Kirim Pengaduan

                </button>

            </div>

        </form>

    </section>


    {{-- BOTTOM INFO --}}
    <div class="mt-5 bg-white border border-slate-200 rounded-xl px-5 py-4">

        <p class="text-sm text-slate-500">

            Pastikan ruangan yang dipilih sesuai dengan lokasi
            kerusakan. Foto kerusakan dapat membantu PIC
            memahami kondisi fasilitas dengan lebih jelas.

        </p>

    </div>

</main>


{{-- JAVASCRIPT KAMERA --}}
<script>

document.addEventListener('DOMContentLoaded', function () {

    const photoInput = document.getElementById('photo');

    const cameraVideo = document.getElementById('cameraPreview');

    const photoPreview = document.getElementById('photoPreview');

    const cameraPlaceholder = document.getElementById('cameraPlaceholder');

    const photoCanvas = document.getElementById('photoCanvas');

    const startCameraBtn = document.getElementById('startCameraBtn');

    const capturePhotoBtn = document.getElementById('capturePhotoBtn');

    const stopCameraBtn = document.getElementById('stopCameraBtn');

    const cameraStatus = document.getElementById('cameraStatus');


    let cameraStream = null;

    let previewUrl = null;


    // MENAMPILKAN PREVIEW FOTO
    function showPhotoPreview(file) {

        if (previewUrl) {
            URL.revokeObjectURL(previewUrl);
        }

        previewUrl = URL.createObjectURL(file);

        photoPreview.src = previewUrl;

        photoPreview.classList.remove('hidden');

        cameraVideo.classList.add('hidden');

        cameraPlaceholder.classList.add('hidden');

    }


    // MENUTUP KAMERA
    function stopCamera() {

        if (cameraStream) {

            cameraStream.getTracks().forEach(function (track) {
                track.stop();
            });

            cameraStream = null;

        }

        cameraVideo.srcObject = null;

        cameraVideo.classList.add('hidden');

        capturePhotoBtn.classList.add('hidden');

        stopCameraBtn.classList.add('hidden');

        startCameraBtn.classList.remove('hidden');


        // KEMBALIKAN PREVIEW FOTO SEBELUMNYA
        const selectedFile = photoInput.files[0];

        if (selectedFile) {

            showPhotoPreview(selectedFile);

            cameraStatus.textContent = 'Foto sudah dipilih dan siap dikirim.';

            startCameraBtn.textContent = 'Ambil Foto Ulang';

        } else {

            photoPreview.classList.add('hidden');

            cameraPlaceholder.classList.remove('hidden');

            cameraStatus.textContent = 'Kamera telah ditutup.';

            startCameraBtn.textContent = 'Buka Kamera';

        }

    }


    // MEMBUKA KAMERA
    async function startCamera() {

        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {

            cameraStatus.textContent =
                'Kamera tidak tersedia. Gunakan HTTPS atau localhost untuk mengakses kamera.';

            return;

        }

        try {

            cameraStatus.textContent = 'Menghubungkan ke kamera...';

            cameraStream = await navigator.mediaDevices.getUserMedia({

                video: {
                    facingMode: {
                        ideal: 'environment'
                    }
                },

                audio: false

            });


            cameraVideo.srcObject = cameraStream;

            await cameraVideo.play();


            // TAMPILKAN VIDEO KAMERA
            cameraVideo.classList.remove('hidden');

            photoPreview.classList.add('hidden');

            cameraPlaceholder.classList.add('hidden');


            // TAMPILKAN BUTTON
            startCameraBtn.classList.add('hidden');

            capturePhotoBtn.classList.remove('hidden');

            stopCameraBtn.classList.remove('hidden');


            cameraStatus.textContent =
                'Kamera aktif. Arahkan kamera ke bagian yang mengalami kerusakan.';

        } catch (error) {

            console.error('Kamera error:', error);

            if (error.name === 'NotAllowedError' ||
                error.name === 'PermissionDeniedError') {

                cameraStatus.textContent =
                    'Izin kamera ditolak. Silakan izinkan akses kamera pada browser.';

            } else if (error.name === 'NotFoundError') {

                cameraStatus.textContent =
                    'Kamera tidak ditemukan pada perangkat ini.';

            } else {

                cameraStatus.textContent =
                    'Tidak dapat membuka kamera. Pastikan kamera tidak sedang digunakan aplikasi lain dan halaman dibuka melalui HTTPS atau localhost.';

            }

            if (cameraStream) {

                cameraStream.getTracks().forEach(function (track) {
                    track.stop();
                });

                cameraStream = null;

            }

        }

    }


    // MENGAMBIL FOTO DARI KAMERA
    function capturePhoto() {

        if (!cameraVideo.videoWidth || !cameraVideo.videoHeight) {

            cameraStatus.textContent =
                'Kamera belum siap. Silakan tunggu sebentar.';

            return;

        }


        const context = photoCanvas.getContext('2d');


        // BATASI UKURAN FOTO AGAR FILE TIDAK TERLALU BESAR
        const maxWidth = 1280;

        const scale = Math.min(
            1,
            maxWidth / cameraVideo.videoWidth
        );

        const width = Math.round(cameraVideo.videoWidth * scale);

        const height = Math.round(cameraVideo.videoHeight * scale);


        photoCanvas.width = width;

        photoCanvas.height = height;


        // GAMBAR FRAME KAMERA KE CANVAS
        context.drawImage(
            cameraVideo,
            0,
            0,
            width,
            height
        );


        // UBAH HASIL FOTO MENJADI FILE JPG
        photoCanvas.toBlob(function (blob) {

            if (!blob) {

                cameraStatus.textContent =
                    'Gagal mengambil foto. Silakan coba lagi.';

                return;

            }


            // MAKSIMAL 2 MB
            if (blob.size > 2 * 1024 * 1024) {

                cameraStatus.textContent =
                    'Ukuran foto lebih dari 2 MB. Silakan ambil foto ulang.';

                return;

            }


            const file = new File(

                [blob],

                'foto-pengaduan-' + Date.now() + '.jpg',

                {
                    type: 'image/jpeg'
                }

            );


            // MASUKKAN FOTO KAMERA KE INPUT PHOTO
            const dataTransfer = new DataTransfer();

            dataTransfer.items.add(file);

            photoInput.files = dataTransfer.files;


            // TUTUP KAMERA DAN TAMPILKAN HASIL FOTO
            stopCamera();

            cameraStatus.textContent =
                'Foto berhasil diambil dan siap dikirim.';

        }, 'image/jpeg', 0.75);

    }


    // EVENT BUTTON BUKA KAMERA
    startCameraBtn.addEventListener('click', function () {

        startCamera();

    });


    // EVENT BUTTON AMBIL FOTO
    capturePhotoBtn.addEventListener('click', function () {

        capturePhoto();

    });


    // EVENT BUTTON TUTUP KAMERA
    stopCameraBtn.addEventListener('click', function () {

        stopCamera();

    });


    // EVENT KETIKA MEMILIH FOTO DARI GALERI
    photoInput.addEventListener('change', function () {

        const file = photoInput.files[0];

        if (!file) {
            return;
        }

        if (!file.type.startsWith('image/')) {

            cameraStatus.textContent =
                'File yang dipilih harus berupa gambar.';

            return;

        }


        // TUTUP KAMERA JIKA MASIH AKTIF
        stopCamera();


        // TAMPILKAN FOTO GALERI
        showPhotoPreview(file);

        cameraStatus.textContent =
            'Foto dari galeri berhasil dipilih.';

    });


    // PASTIKAN KAMERA DITUTUP SAAT MENINGGALKAN HALAMAN
    window.addEventListener('pagehide', function () {

        if (cameraStream) {

            cameraStream.getTracks().forEach(function (track) {
                track.stop();
            });

        }

    });

});

</script>

@endsection
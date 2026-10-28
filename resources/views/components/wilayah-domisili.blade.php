@props([
    'provinsi' => '',
    'kota' => '',
    'provinsiKota' => '',
    'kecamatan' => '',
    'kelurahan' => '',
    'rt' => '',
    'rw' => '',
    'label' => 'Wilayah domisili usaha',
    'idPrefix' => 'wilayah_' . uniqid(),
    'required' => false,
])

@php
    $initProvinsi = old('provinsi', $provinsi);
    $initKota = old('kota', $kota);
    $combinedPk = old('provinsi_kota', $provinsiKota);

    if (empty($initProvinsi) && !empty($combinedPk)) {
        if (str_contains($combinedPk, ',')) {
            $parts = explode(',', $combinedPk, 2);
            $initProvinsi = trim($parts[0]);
            $initKota = trim($parts[1]);
        } elseif (str_contains($combinedPk, ' - ')) {
            $parts = explode(' - ', $combinedPk, 2);
            $initProvinsi = trim($parts[0]);
            $initKota = trim($parts[1]);
        } elseif (str_contains($combinedPk, '/')) {
            $parts = explode('/', $combinedPk, 2);
            $initProvinsi = trim($parts[0]);
            $initKota = trim($parts[1]);
        } else {
            $initProvinsi = trim($combinedPk);
        }
    }
@endphp

<div class="space-y-3 wilayah-component" id="{{ $idPrefix }}_container">
    <div>
        <label class="block text-[14px] font-semibold text-[#161d1a] mb-2">
            {{ $label }} @if($required)<span class="text-red-500">*</span>@endif
        </label>

        <!-- Opsi Nyalakan Lokasi: Banner Interaktif yang Jelas & Terlihat -->
        <div class="mb-3.5 p-3 sm:p-3.5 rounded-xl bg-[#F2F8ED] border border-[#2D6B22]/30 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-xs">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-[#2D6B22] text-white flex items-center justify-center shrink-0 shadow-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 2v2m0 16v2m10-10h-2M4 12H2m15.071-7.071l-1.414 1.414M8.343 15.657l-1.414 1.414m12.142 0l-1.414-1.414M8.343 8.343L6.929 6.929M12 17a5 5 0 100-10 5 5 0 000 10z"/>
                    </svg>
                </div>
                <div>
                    <span class="text-[13px] font-bold text-[#15241C] block">Isi wilayah otomatis dari lokasi Anda?</span>
                    <span class="text-[11px] text-[#3E5445] block">Nyalakan GPS agar pilihan Provinsi & Kota terpilih akurat secara otomatis</span>
                </div>
            </div>
            <button type="button" 
                    id="{{ $idPrefix }}_btn_location"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-[#2D6B22] hover:bg-[#1E4A1A] text-white text-[12px] font-bold shadow-sm hover:shadow transition shrink-0 cursor-pointer w-full sm:w-auto">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span id="{{ $idPrefix }}_btn_text">Nyalakan Lokasi</span>
            </button>
        </div>

        <div id="{{ $idPrefix }}_location_msg" class="hidden text-[12px] py-2 px-3 rounded-xl mb-3 font-medium"></div>

        <!-- Preview Peta Google Maps Saat Lokasi GPS Ditemukan -->
        <div id="{{ $idPrefix }}_map_preview" class="hidden mb-3.5 rounded-xl overflow-hidden border border-[#2D6B22]/30 shadow-xs bg-[#f2f8ed]">
            <div class="px-3.5 py-2 bg-[#2D6B22] text-white flex items-center justify-between text-xs">
                <div class="flex items-center gap-2 font-bold">
                    <svg class="w-4 h-4 text-emerald-200 shrink-0" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>Titik Lokasi Terdeteksi (Google Maps)</span>
                </div>
                <div class="flex items-center gap-3">
                    <a id="{{ $idPrefix }}_gmaps_link" href="#" target="_blank" rel="noopener noreferrer" class="text-white/90 hover:text-white underline underline-offset-2 flex items-center gap-1 font-medium text-[11px]">
                        Buka di Google Maps
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                </div>
            </div>
            <div class="relative w-full h-44 sm:h-52 bg-[#e2e1d8]">
                <iframe id="{{ $idPrefix }}_gmaps_iframe" 
                        class="w-full h-full border-0" 
                        loading="lazy" 
                        allowfullscreen 
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="px-3.5 py-1.5 bg-[#f2f8ed] text-[11px] text-[#3E5445] flex items-center justify-between border-t border-[#2D6B22]/20">
                <span id="{{ $idPrefix }}_coords_text">Koordinat: -</span>
                <span class="text-emerald-700 font-semibold flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Titik GPS akurat
                </span>
            </div>
        </div>
        <!-- Grid Wilayah: Provinsi, Kota, Kecamatan, Kelurahan -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 sm:gap-4">
            <!-- Provinsi -->
            <div class="min-w-0">
                <label for="{{ $idPrefix }}_provinsi" class="block text-[13px] font-semibold text-[#161d1a] mb-1.5">
                    Provinsi @if($required)<span class="text-red-500">*</span>@endif
                </label>
                <select id="{{ $idPrefix }}_provinsi" 
                        name="provinsi"
                        class="w-full h-11 px-3.5 bg-white border border-[#e2e1d8] focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] rounded-[6px] text-[14px] text-[#161d1a] outline-none transition cursor-pointer">
                    <option value="">-- Pilih Provinsi --</option>
                </select>
            </div>

            <!-- Kota / Kabupaten -->
            <div class="min-w-0">
                <label for="{{ $idPrefix }}_kota" class="block text-[13px] font-semibold text-[#161d1a] mb-1.5 whitespace-nowrap">
                    Kota / Kabupaten @if($required)<span class="text-red-500">*</span>@endif
                </label>
                <select id="{{ $idPrefix }}_kota" 
                        name="kota"
                        class="w-full h-11 px-3.5 bg-white border border-[#e2e1d8] focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] rounded-[6px] text-[14px] text-[#161d1a] outline-none transition cursor-pointer">
                    <option value="">-- Pilih Kota / Kabupaten --</option>
                </select>
            </div>

            <!-- Kecamatan -->
            <div class="min-w-0">
                <label for="{{ $idPrefix }}_kecamatan" class="block text-[13px] font-semibold text-[#161d1a] mb-1.5 whitespace-nowrap">
                    Kecamatan
                </label>
                <select id="{{ $idPrefix }}_kecamatan" 
                        name="kecamatan"
                        class="w-full h-11 px-3.5 bg-white border border-[#e2e1d8] focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] rounded-[6px] text-[14px] text-[#161d1a] outline-none transition cursor-pointer">
                    <option value="">-- Pilih Kecamatan --</option>
                </select>
            </div>

            <!-- Kelurahan / Desa -->
            <div class="min-w-0">
                <label for="{{ $idPrefix }}_kelurahan" class="block text-[13px] font-semibold text-[#161d1a] mb-1.5 whitespace-nowrap">
                    Kelurahan / Desa
                </label>
                <select id="{{ $idPrefix }}_kelurahan" 
                        name="kelurahan"
                        class="w-full h-11 px-3.5 bg-white border border-[#e2e1d8] focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] rounded-[6px] text-[14px] text-[#161d1a] outline-none transition cursor-pointer">
                    <option value="">-- Pilih Kelurahan / Desa --</option>
                </select>
            </div>
        </div>

        <!-- Hidden input untuk kompatibilitas single string provinsi_kota -->
        <input type="hidden" 
               name="provinsi_kota" 
               id="{{ $idPrefix }}_provinsi_kota_final" 
               value="{{ $combinedPk }}">
    </div>

    <!-- Tambahan RT & RW -->
    <div class="pt-1.5">
        <label class="block text-[13px] font-semibold text-[#161d1a] mb-1.5">
            RT / RW (Rukun Tetangga & Rukun Warga)
        </label>
        <div class="grid grid-cols-2 gap-3.5 sm:gap-4 sm:max-w-md">
            <div>
                <div class="flex items-center h-11 rounded-[6px] border border-[#e2e1d8] focus-within:border-[#0b5a4a] focus-within:ring-1 focus-within:ring-[#0b5a4a] bg-white overflow-hidden transition">
                    <span class="h-full px-3.5 bg-[#f7f6f1] text-[13px] text-[#4b5551] font-semibold border-r border-[#e2e1d8] flex items-center justify-center select-none">RT</span>
                    <input type="text" 
                           name="rt" 
                           id="{{ $idPrefix }}_rt" 
                           value="{{ old('rt', $rt) }}" 
                           maxlength="5" 
                           inputmode="numeric" 
                           placeholder="01" 
                           class="w-full h-full px-3 text-[14px] text-[#161d1a] outline-none bg-transparent">
                </div>
            </div>

            <div>
                <div class="flex items-center h-11 rounded-[6px] border border-[#e2e1d8] focus-within:border-[#0b5a4a] focus-within:ring-1 focus-within:ring-[#0b5a4a] bg-white overflow-hidden transition">
                    <span class="h-full px-3.5 bg-[#f7f6f1] text-[13px] text-[#4b5551] font-semibold border-r border-[#e2e1d8] flex items-center justify-center select-none">RW</span>
                    <input type="text" 
                           name="rw" 
                           id="{{ $idPrefix }}_rw" 
                           value="{{ old('rw', $rw) }}" 
                           maxlength="5" 
                           inputmode="numeric" 
                           placeholder="03" 
                           class="w-full h-full px-3 text-[14px] text-[#161d1a] outline-none bg-transparent">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    // Database Master Wilayah Indonesia (Seluruh 38 Provinsi & 514 Kota/Kabupaten, murni dropdown)
    const databaseWilayah = {
        "Aceh": {
            "Kab. Aceh Barat": ["Johan Pahlawan", "Kaway XVI", "Meureubo", "Samatiga", "Woyla", "Bubon", "Arongan Lambalek"],
            "Kab. Aceh Barat Daya": ["Blangpidie", "Susoh", "Kuala Batee", "Manggeng", "Babahrot", "Tangan-Tangan", "Jeumpa"],
            "Kab. Aceh Besar": ["Kota Jantho", "Ingin Jaya", "Darul Imarah", "Montasik", "Lhoknga", "Kuta Baro", "Peukan Bada", "Baitussalam"],
            "Kab. Aceh Jaya": ["Calang", "Krueng Sabee", "Teunom", "Panga", "Sampoiniet", "Setia Bakti", "Jaya"],
            "Kab. Aceh Selatan": ["Tapaktuan", "Samadua", "Meukek", "Labuhan Haji", "Bakongan", "Kluet Utara", "Kluet Selatan"],
            "Kab. Aceh Singkil": ["Singkil", "Singkil Utara", "Gunung Meriah", "Simpang Kanan", "Danau Paris"],
            "Kab. Aceh Tamiang": ["Karang Baru", "Kuala Simpang", "Rantau", "Manyak Payed", "Kejuruan Muda", "Seruway"],
            "Kab. Aceh Tengah": ["Takengon", "Bebesen", "Lut Tawar", "Pegasing", "Bies", "Kebayakan", "Silih Nara"],
            "Kab. Aceh Tenggara": ["Kutacane", "Babussalam", "Badar", "Bambel", "Lawe Bulan", "Semadam"],
            "Kab. Aceh Timur": ["Idi Rayeuk", "Peureulak", "Simpang Ulim", "Julok", "Madat", "Ranto Peureulak"],
            "Kab. Aceh Utara": ["Lhoksukon", "Dewantara", "Muara Batu", "Syamtalira Aron", "Tanah Pasir", "Baktiya"],
            "Kab. Bener Meriah": ["Simpang Tiga Redelong", "Bukit", "Bandar", "Wih Pesam", "Pintu Rime Gayo"],
            "Kab. Bireuen": ["Kota Juang", "Peusangan", "Gandapura", "Samalanga", "Jeunieb", "Pandrah"],
            "Kab. Gayo Lues": ["Blangkejeren", "Kutapanjang", "Rikit Gaib", "Terangun", "Pining"],
            "Kab. Nagan Raya": ["Suka Makmue", "Kuala", "Darul Makmur", "Seunagan", "Tadu Raya"],
            "Kab. Pidie": ["Sigli", "Kota Sigli", "Mutiara", "Mutiara Timur", "Indrajaya", "Delima", "Padang Tiji"],
            "Kab. Pidie Jaya": ["Meureudu", "Bandar Dua", "Ulim", "Jangka Buya", "Trienggadeng", "Panteraja"],
            "Kab. Simeulue": ["Sinabang", "Simeulue Timur", "Simeulue Barat", "Teupah Selatan", "Teupah Barat"],
            "Kota Banda Aceh": ["Baiturrahman", "Kuta Alam", "Meuraxa", "Syiah Kuala", "Lueng Bata", "Banda Raya", "Jaya Baru", "Ulee Kareng"],
            "Kota Langsa": ["Langsa Kota", "Langsa Barat", "Langsa Timur", "Langsa Lama", "Langsa Baro"],
            "Kota Lhokseumawe": ["Banda Sakti", "Muara Dua", "Muara Satu", "Blang Mangat"],
            "Kota Sabang": ["Sukakarya", "Sukajaya", "Sukamakmue"],
            "Kota Subulussalam": ["Simpang Kiri", "Penanggalan", "Rundeng", "Sultan Daulat", "Longkib"]
        },
        "Bali": {
            "Kota Denpasar": ["Denpasar Barat", "Denpasar Selatan", "Denpasar Timur", "Denpasar Utara"],
            "Kab. Badung": ["Kuta", "Kuta Selatan", "Kuta Utara", "Mengwi", "Abiansemal", "Petang"],
            "Kab. Gianyar": ["Gianyar", "Ubud", "Sukawati", "Blahbatuh", "Tegallalang", "Payangan", "Tampaksiring"],
            "Kab. Tabanan": ["Tabanan", "Kediri", "Marga", "Baturiti", "Kerambitan", "Penebel", "Pupuan", "Selemadeg"],
            "Kab. Buleleng": ["Singaraja", "Buleleng", "Seririt", "Sukasada", "Banjar", "Gerokgak", "Kubutambahan", "Sawan", "Tejakula"],
            "Kab. Karangasem": ["Amlapura", "Karangasem", "Manggis", "Rendang", "Bebandem", "Kubur", "Abang", "Selat", "Sidemen"],
            "Kab. Klungkung": ["Klungkung", "Nusa Penida", "Banjarangkan", "Dawan"],
            "Kab. Bangli": ["Bangli", "Kintamani", "Susut", "Tembuku"],
            "Kab. Jembrana": ["Negara", "Mendoyo", "Melaya", "Pekutatan", "Jembrana"]
        },
        "Banten": {
            "Kota Cilegon": ["Cibeber", "Cilegon", "Citangkil", "Ciwandan", "Gerogol", "Jombang", "Pulomerak", "Purwakarta"],
            "Kota Serang": ["Serang", "Cipocok Jaya", "Curug", "Kasemen", "Taktakan", "Walantaka"],
            "Kota Tangerang": ["Tangerang", "Batuceper", "Benda", "Cibodas", "Ciledug", "Cipondoh", "Jatiuwung", "Karangtengah", "Karawaci", "Larangan", "Neglasari", "Periuk", "Pinang"],
            "Kota Tangerang Selatan": ["Serpong", "Serpong Utara", "Pondok Aren", "Ciputat", "Ciputat Timur", "Pamulang", "Setu"],
            "Kab. Lebak": ["Rangkasbitung", "Cibadak", "Malingping", "Bayah", "Cipanas", "Maja", "Warunggunung", "Leuwidamar"],
            "Kab. Pandeglang": ["Pandeglang", "Labuan", "Menes", "Cadasari", "Panimbang", "Carita", "Saketi"],
            "Kab. Serang": ["Ciruas", "Kragilan", "Anyar", "Cinangka", "Baros", "Cikande", "Kramatwatu", "Pontang", "Waringinkurung"],
            "Kab. Tangerang": ["Tigaraksa", "Balaraja", "Cikupa", "Curug", "Kelapa Dua", "Pasar Kemis", "Legok", "Teluknaga", "Kosambi", "Sepatan", "Rajeg"]
        },
        "Bengkulu": {
            "Kota Bengkulu": ["Gading Cempaka", "Kampung Melayu", "Muara Bangka Hulu", "Ratu Agung", "Ratu Samban", "Selebar", "Singaran Pati", "Sungai Serut", "Teluk Segara"],
            "Kab. Bengkulu Selatan": ["Kota Manna", "Manna", "Pasar Manna", "Kedurang", "Seginim", "Pino"],
            "Kab. Bengkulu Tengah": ["Karang Tinggi", "Talang Empat", "Pondok Kelapa", "Pagar Jati", "Taba Penanjung"],
            "Kab. Bengkulu Utara": ["Arga Makmur", "Lais", "Ketahun", "Padang Jaya", "Giri Mulya", "Batik Nau"],
            "Kab. Kaur": ["Kaur Selatan", "Kaur Tengah", "Kaur Utara", "Maje", "Nasal", "Semidang Gumay"],
            "Kab. Kepahiang": ["Kepahiang", "Ujan Mas", "Tebat Karai", "Bermani Ilir", "Merigi"],
            "Kab. Lebong": ["Tubei", "Lebong Atas", "Lebong Tengah", "Lebong Selatan", "Lebong Utara", "Rimbo Pengadang"],
            "Kab. Mukomuko": ["Kota Mukomuko", "Ipuh", "Lubuk Pinang", "Pondok Suguh", "Penarik"],
            "Kab. Rejang Lebong": ["Curup", "Curup Selatan", "Curup Tengah", "Curup Timur", "Curup Utara", "Bermani Ulu", "Selupu Rejang"],
            "Kab. Seluma": ["Pasar Talo", "Seluma", "Seluma Barat", "Seluma Selatan", "Seluma Timur", "Seluma Utara", "Sukaraja"]
        },
        "DI Yogyakarta": {
            "Kota Yogyakarta": ["Danurejan", "Gedongtengen", "Gondokusuman", "Gondomanan", "Jetis", "Kotagede", "Kraton", "Mantrijeron", "Mergangsan", "Ngampilan", "Pakualaman", "Tegalrejo", "Umbulharjo", "Wirobrajan"],
            "Kab. Bantul": ["Bantul", "Banguntapan", "Sewon", "Kasihan", "Piyungan", "Pleret", "Imogiri", "Jetis", "Kretek", "Sanden", "Srandakan", "Bambanglipuro", "Pandak", "Pajangan", "Sedayu", "Dlingo"],
            "Kab. Gunungkidul": ["Wonosari", "Playen", "Karangmojo", "Semin", "Patuk", "Rongkop", "Semanu", "Ponjong", "Nglipar", "Ngawen", "Panggang", "Tepus"],
            "Kab. Kulon Progo": ["Wates", "Sentolo", "Pengasih", "Galur", "Lendah", "Panjatan", "Temon", "Kokap", "Girimulyo", "Nanggulan", "Samigaluh", "Kalibawang"],
            "Kab. Sleman": ["Depok", "Mlati", "Gamping", "Ngaglik", "Kalasan", "Berbah", "Prambanan", "Sleman", "Tempel", "Turi", "Pakem", "Cangkringan", "Ngemplak", "Seyegan", "Godean", "Moyudan", "Minggir"]
        },
        "DKI Jakarta": {
            "Kota Jakarta Barat": ["Cengkareng", "Grogol Petamburan", "Kalideres", "Kebon Jeruk", "Kembangan", "Palmerah", "Taman Sari", "Tambora"],
            "Kota Jakarta Pusat": ["Cempaka Putih", "Gambir", "Johar Baru", "Kemayoran", "Menteng", "Sawah Besar", "Senen", "Tanah Abang"],
            "Kota Jakarta Selatan": ["Cilandak", "Jagakarsa", "Kebayoran Baru", "Kebayoran Lama", "Mampang Prapatan", "Pancoran", "Pasar Minggu", "Pesanggrahan", "Setiabudi", "Tebet"],
            "Kota Jakarta Timur": ["Cakung", "Cipayung", "Ciracas", "Duren Sawit", "Jatinegara", "Kramat Jati", "Makasar", "Matraman", "Pasar Rebo", "Pulo Gadung"],
            "Kota Jakarta Utara": ["Cilincing", "Kelapa Gading", "Koja", "Pademangan", "Penjaringan", "Tanjung Priok"],
            "Kab. Kepulauan Seribu": ["Kepulauan Seribu Selatan", "Kepulauan Seribu Utara"]
        },
        "Gorontalo": {
            "Kota Gorontalo": ["Kota Barat", "Kota Selatan", "Kota Tengah", "Kota Timur", "Kota Utara", "Dungingi", "Hulonthalangi"],
            "Kab. Boalemo": ["Tilamuta", "Botumoito", "Dulupi", "Mananggu", "Paguyaman", "Wonosari"],
            "Kab. Bone Bolango": ["Suwawa", "Kabila", "Bonepantai", "Tapa", "Bulango Selatan", "Tilongkabila"],
            "Kab. Gorontalo": ["Limboto", "Limboto Barat", "Telaga", "Tibawa", "Pulubala", "Boliyohuto", "Batudaa"],
            "Kab. Gorontalo Utara": ["Kwandang", "Anggrek", "Atinggola", "Sumalata", "Tolinggula"],
            "Kab. Pohuwato": ["Marisa", "Paguat", "Patilanggio", "Popayato", "Randangan", "Lemito"]
        },
        "Jambi": {
            "Kota Jambi": ["Danau Teluk", "Jambi Selatan", "Jambi Timur", "Jelutung", "Kota Baru", "Pasar Jambi", "Pelayangan", "Telanaipura", "Alam Barajo", "Paal Merah"],
            "Kota Sungai Penuh": ["Sungai Penuh", "Pesisir Bukit", "Hamparan Rawang", "Tanah Kampung", "Kumun Debai"],
            "Kab. Batanghari": ["Muara Bulian", "Mersam", "Muara Tembesi", "Maro Sebo Ulu", "Bajubang"],
            "Kab. Bungo": ["Muara Bungo", "Pasar Muara Bungo", "Rimbo Tengah", "Pelepat", "Tanah Sepenggal"],
            "Kab. Kerinci": ["Siulak", "Gunung Kerinci", "Kayu Aro", "Air Hangat", "Danau Kerinci"],
            "Kab. Merangin": ["Bangko", "Tabir", "Pamenang", "Muara Siau", "Jangkat"],
            "Kab. Muaro Jambi": ["Sengeti", "Jambi Luar Kota", "Maro Sebo", "Mestong", "Kumpeh"],
            "Kab. Sarolangun": ["Sarolangun", "Pelawan", "Singkut", "Pauh", "Mandiangin"],
            "Kab. Tanjung Jabung Barat": ["Kuala Tungkal", "Tungkal Ilir", "Tungkal Ulu", "Pengabuan", "Merlung"],
            "Kab. Tanjung Jabung Timur": ["Muara Sabak", "Muara Sabak Timur", "Kuala Jambi", "Nipah Panjang", "Rantau Rasau"],
            "Kab. Tebo": ["Muara Tebo", "Tebo Tengah", "Rimbo Bujang", "Rimbo Ilir", "Tebo Ilir"]
        },
        "Jawa Barat": {
            "Kota Bandung": ["Andir", "Antapani", "Arcamanik", "Astana Anyar", "Babakan Ciparay", "Bandung Kidul", "Bandung Kulon", "Bandung Wetan", "Batununggal", "Bojongloa Kaler", "Bojongloa Kidul", "Buahbatu", "Cibeunying Kaler", "Cibeunying Kidul", "Cibiru", "Cicendo", "Cidadap", "Cinambo", "Coblong", "Gedebage", "Kiaracondong", "Lengkong", "Mandalajati", "Panyileukan", "Rancasari", "Regol", "Sukajadi", "Sukasari", "Sumur Bandung", "Ujungberung"],
            "Kota Banjar": ["Banjar", "Langensari", "Pataruman", "Purwaharja"],
            "Kota Bekasi": ["Bantar Gebang", "Bekasi Barat", "Bekasi Selatan", "Bekasi Timur", "Bekasi Utara", "Jatiasih", "Jatisampurna", "Medan Satria", "Mustika Jaya", "Pondok Gede", "Pondok Melati", "Rawalumbu"],
            "Kota Bogor": ["Bogor Barat", "Bogor Selatan", "Bogor Tengah", "Bogor Timur", "Bogor Utara", "Tanah Sareal"],
            "Kota Cimahi": ["Cimahi Selatan", "Cimahi Tengah", "Cimahi Utara"],
            "Kota Cirebon": ["Harjamukti", "Kejaksan", "Kesambi", "Lemahwungkuk", "Pekalipan"],
            "Kota Depok": ["Beji", "Bojongsari", "Cilodong", "Cimanggis", "Cinere", "Cipayung", "Limo", "Pancoran Mas", "Sawangan", "Sukmajaya", "Tapos"],
            "Kota Sukabumi": ["Baros", "Cibeureum", "Cikole", "Citamiang", "Gunungpuyuh", "Lembursitu", "Warudoyong"],
            "Kota Tasikmalaya": ["Bungursari", "Cibeureum", "Cihideung", "Cipedes", "Indihiang", "Kawalu", "Mangkubumi", "Purbaratu", "Tamansari", "Tawang"],
            "Kab. Bandung": ["Baleendah", "Banjaran", "Bojongsoang", "Cangkuang", "Cicalengka", "Cikancung", "Cilengkrang", "Cileunyi", "Cimaung", "Cimenyan", "Ciparay", "Ciwidey", "Dayeuhkolot", "Ibun", "Katapang", "Kertasari", "Kutawaringin", "Majalaya", "Margaasih", "Margahayu", "Nagreg", "Pacet", "Pameungpeuk", "Pangalengan", "Paseh", "Pasirjambu", "Rancabali", "Rancaekek", "Solokanjeruk", "Soreang"],
            "Kab. Bandung Barat": ["Batujajar", "Cihampelas", "Cikalongwetan", "Cililin", "Cipatat", "Cipeundeuy", "Cipongkor", "Cisarua", "Gegerbitung", "Lembang", "Ngamprah", "Padalarang", "Parongpong", "Rongga", "Sindangkerta"],
            "Kab. Bekasi": ["Babelan", "Bojongmangu", "Cabangbungin", "Cibarusah", "Cibitung", "Cikarang Barat", "Cikarang Pusat", "Cikarang Selatan", "Cikarang Timur", "Cikarang Utara", "Karangbahagia", "Kedungwaringin", "Muara Gembong", "Pebayuran", "Serang Baru", "Setu", "Sukakarya", "Sukatani", "Sukawangi", "Tambelang", "Tambun Selatan", "Tambun Utara", "Tarumajaya"],
            "Kab. Bogor": ["Babakan Madang", "Bojonggede", "Caringin", "Cariu", "Ciampea", "Ciawi", "Cibinong", "Cibungbulang", "Cigombong", "Cigudeg", "Cijeruk", "Cileungsi", "Ciomas", "Cisarua", "Ciseeng", "Citeureup", "Dramaga", "Gunung Putri", "Gunung Sindur", "Jasinga", "Jonggol", "Kemang", "Klapanunggal", "Leuwiliang", "Leuwisadeng", "Megamendung", "Nanggung", "Pamijahan", "Parung", "Parung Panjang", "Ranca Bungur", "Rumpin", "Sukajaya", "Sukamakmur", "Sukaraja", "Tajurhalang", "Tamansari", "Tanjungsari", "Tenjo", "Tenjolaya"],
            "Kab. Ciamis": ["Ciamis", "Cikoneng", "Cihaurbeuti", "Kawali", "Panumbangan", "Rancah", "Sadananya", "Baregbeg"],
            "Kab. Cianjur": ["Cianjur", "Cipanas", "Pacet", "Sukaresmi", "Cikalongkulon", "Ciranjang", "Karangtengah", "Warungkondang"],
            "Kab. Cirebon": ["Sumber", "Arjawinangun", "Ciledug", "Klangenan", "Palimanan", "Plumbon", "Weru", "Kedawung", "Mundu"],
            "Kab. Garut": ["Garut Kota", "Tarogong Kaler", "Tarogong Kidul", "Karangpawitan", "Wanaraja", "Leles", "Kadungora", "Cilawu"],
            "Kab. Indramayu": ["Indramayu", "Jatibarang", "Karangampel", "Sindang", "Haurgeulis", "Kandanghaur", "Losarang"],
            "Kab. Karawang": ["Karawang Barat", "Karawang Timur", "Klari", "Telukjambe Barat", "Telukjambe Timur", "Rengasdengklok", "Cikampek", "Kotabaru"],
            "Kab. Kuningan": ["Kuningan", "Cilimus", "Cigugur", "Jalaksana", "Kramatmulya", "Kadugede", "Luragung"],
            "Kab. Majalengka": ["Majalengka", "Jatiwangi", "Kadipaten", "Kertajati", "Dawuan", "Cigasong", "Sukahaji"],
            "Kab. Pangandaran": ["Pangandaran", "Parigi", "Cijulang", "Kalipucang", "Sidamulih", "Padaherang"],
            "Kab. Purwakarta": ["Purwakarta", "Campaka", "Jatiluhur", "Plered", "Pasawahan", "Bungursari"],
            "Kab. Subang": ["Subang", "Kalijati", "Pamanukan", "Pagaden", "Cipunagara", "Jalan Cagak"],
            "Kab. Sukabumi": ["Palabuhanratu", "Cibadak", "Cisaat", "Cicurug", "Parungkuda", "Cikembar"],
            "Kab. Sumedang": ["Sumedang Utara", "Sumedang Selatan", "Jatinangor", "Tanjungsari", "Cimalaka", "Paseh"],
            "Kab. Tasikmalaya": ["Singaparna", "Ciawi", "Karangnunggal", "Manonjaya", "Rajapolah", "Leuwisari"]
        },
        "Jawa Tengah": {
            "Kab. Banjarnegara": ["Banjarnegara", "Batur", "Bawang", "Kalibening", "Karangkobar", "Madukara", "Mandiraja", "Pagentan", "Purwanegara", "Wanayasa", "Purwareja Klampok", "Rakit", "Sigaluh", "Susukan"],
            "Kab. Banyumas": ["Purwokerto Barat", "Purwokerto Selatan", "Purwokerto Timur", "Purwokerto Utara", "Ajibarang", "Banyumas", "Baturraden", "Cilongok", "Gumelar", "Jatilawang", "Kalibagor", "Karanglewas", "Kebasen", "Kedungbanteng", "Kembaran", "Kemranjen", "Lumbir", "Patikraja", "Pekuncen", "Rawalo", "Sokaraja", "Somagede", "Sumbang", "Sumpiuh", "Tambak", "Wangon"],
            "Kab. Batang": ["Batang", "Bandar", "Banyuputih", "Blado", "Gringsing", "Kandeman", "Limpung", "Pecalungan", "Reban", "Subah", "Tersono", "Tulis", "Warungasem", "Wonotunggal"],
            "Kab. Blora": ["Blora", "Banjarejo", "Bogorejo", "Cepu", "Japah", "Jati", "Jepon", "Kedungtuban", "Kradenan", "Kunduran", "Ngawen", "Randublatung", "Sambong", "Todanan", "Tunjungan"],
            "Kab. Boyolali": ["Boyolali", "Ampel", "Andong", "Banyudono", "Cepogo", "Gladagsari", "Juwangi", "Karanggede", "Klego", "Mojosongo", "Musuk", "Ngemplak", "Nogosari", "Sambi", "Sawit", "Selo", "Simo", "Tamansari", "Teras", "Wonosegoro"],
            "Kab. Brebes": ["Brebes", "Banjarharjo", "Bantarkawung", "Bulakamba", "Bumiayu", "Jatibarang", "Kersana", "Ketanggungan", "Larangan", "Losari", "Paguyangan", "Salem", "Sirampog", "Songgom", "Tanjung", "Tonjong", "Wanasari"],
            "Kab. Cilacap": ["Cilacap Selatan", "Cilacap Tengah", "Cilacap Utara", "Adipala", "Bantarsari", "Binangun", "Dayeuhluhur", "Gandrungmangu", "Jeruklegi", "Kampung Laut", "Karangpucung", "Kawunganten", "Kedungreja", "Kesugihan", "Kroya", "Majenang", "Maos", "Nusawungu", "Patimuan", "Sampang", "Sidareja", "Wanareja"],
            "Kab. Demak": {
                "Demak": ["Betokan", "Bintoro", "Bolo", "Cabean", "Donosari", "Kalicilik", "Katonsari", "Mangunjiwan", "Mulyorejo", "Raji", "Sedo", "Singorejo", "Turirejo", "Wonosari"],
                "Sayung": ["Banjarsari", "Bedono", "Bulusari", "Dombo", "Gemulak", "Kalosari", "Karangasem", "Pilangsari", "Prampelan", "Purwosari", "Sayung", "Sidogemah", "Sidorejo", "Sriwulan", "Timbulsloko", "Tugu"],
                "Karangtengah": ["Batu", "Donorejo", "Dukun", "Grogol", "Karangtengah", "Karangsari", "Kedunguter", "Klitih", "Pidodo", "Ploso", "Pulosari", "Rejosari", "Sampang", "Tambakbulusan", "Wonoagung"],
                "Mranggen": ["Banyumeneng", "Batursari", "Brumbung", "Candisari", "Jamus", "Kalitengah", "Kangkung", "Karangsono", "Kebonbatur", "Kembangarum", "Menur", "Mranggen", "Ngemplak", "Sumberejo", "Tamansari", "Tegalarum", "Warungturi"],
                "Karanganyar": ["Cangkring", "Cangkring Pos", "Karanganyar", "Ketanjung", "Kotakan", "Ngaluran", "Ngemplik Wetan", "Tugurejo", "Undaan Kidul", "Undaan Lor", "Wonoketingal"],
                "Bonang": ["Gebang", "Jatirogo", "Karangrejo", "Kembangan", "Margolinduk", "Morodemak", "Poncorejo", "Purworejo", "Serangan", "Sumberejo", "Tridonorejo", "Wonosari"],
                "Wedung": ["Babalan", "Buko", "Bungo", "Jungpasir", "Jungsemi", "Kedungkarang", "Mandung", "Mutih Kulon", "Mutih Wetan", "Ngawen", "Ruwit", "Tedunan", "Wedung"],
                "Guntur": ["Bakalrejo", "Banjarejo", "Blerong", "Bogosari", "Guntur", "Krandon", "Pamongan", "Sidoharjo", "Sidokumpul", "Sukorejo", "Tangkis", "Temuroso", "Tlogorejo", "Tlogoweru"],
                "Mijen": ["Bakung", "Banteng Mati", "Geneng", "Jatisono", "Mijen", "Mlaten", "Nglobar", "Ngegot", "Pasir", "Pecuk", "Rejosari"],
                "Gajah": ["Boyolali", "Gajah", "Gedangalas", "Kedondong", "Medini", "Mlatiharjo", "Mulyorejo", "Sambiroto", "Sambung", "Sari", "Surodadi", "Tambirejo"],
                "Karangawen": ["Brambang", "Bumirejo", "Junior", "Karangawen", "Kuripan", "Margohayu", "Pundenarum", "Rejosari", "Sido Rejo", "Teluk", "Wonosegoro"],
                "Wonosalam": ["Botorejo", "Doreng", "Getas", "Jogoloyo", "Karangrowo", "Kalianyar", "Keranjit", "Mojodemak", "Pilangrejo", "Sido Mulyo", "Tlogodowo", "Tlogorejo", "Trengguli", "Wonosalam"],
                "Dempet": ["Balerejo", "Baleromo", "Brakas", "Dempet", "Gempoldenok", "Harjowinangun", "Karangrejo", "Kedungori", "Keraton", "Kramat", "Kunir", "Sidomulyo"],
                "Kebonagung": ["Kebonagung", "Klithik", "Mangunrejo", "Megalabuan", "Mijen", "Pilangkenceng", "Prigi", "Sokopuluhan", "Solowire", "Tlogopandogan", "Wringinjajar"]
            },
            "Kab. Grobogan": ["Purwodadi", "Wirosari", "Godong", "Gubug", "Toroh", "Geyer", "Grobogan", "Tawangharjo", "Tegowanu", "Penawangan", "Karangrayung", "Kedungjati", "Brati", "Klambu", "Kradenan", "Pulokulon", "Tanggungharjo", "Ngaringan", "Gabus"],
            "Kab. Jepara": {
                "Jepara": ["Bapangan", "Bulukerto", "Demaan", "Jobokuto", "Karangkebagusan", "Kauman", "Krapyak", "Kuwasen", "Mulyoharjo", "Panggang", "Pengkol", "Potroyudan", "Saripan", "Ujungbatu", "Bandengan", "Kedungcino"],
                "Tahunan": ["Demangan", "Kecapi", "Krapyak", "Mantingan", "Ngabul", "Platar", "Semat", "Senenan", "Sukodono", "Tahunan", "Tegalsambi", "Telukawur"],
                "Batealit": ["Bantrung", "Batealit", "Bawu", "Bringin", "Geneng", "Mindahan", "Ngasem", "Pekalongan", "Raguklampitan", "Somopenganten"],
                "Pecangaan": ["Gerdu", "Kaliombo", "Karangrandu", "Krasak", "Lebuawu", "Ngeling", "Pecangaan Kulon", "Pecangaan Wetan", "Pulodarat", "Rengging", "Troso"],
                "Kalinyamatan": ["Bakalan", "Batukali", "Banyuputih", "Damarjati", "Kriyan", "Manyargading", "Margoyoso", "Pendosawalan", "Purwogondo", "Robayan", "Sendang"],
                "Kedung": ["Bugel", "Bulakbaru", "Dongos", "Jondang", "Kerso", "Kedungmalang", "Menganti", "Panggung", "Rau", "Sowan Kidul", "Sowan Lor", "Surodadi", "Tangbulsari", "Tedunan", "Wanusobo"],
                "Welahan": ["Brantaksekarjati", "Bugo", "Gidangelo", "Guwosobokerto", "Kalipucang Kulon", "Kalipucang Wetan", "Karanganyar", "Kedungsarimulyo", "Kendalrejo", "Ketilengsingolelo", "Sidigede", "Telukwetan", "Ujungpandan", "Welahan"],
                "Mayong": ["Bandung", "Buaran", "Bungu", "Datar", "Kuanyar", "Mayong Kidul", "Mayong Lor", "Ngroto", "Pancur", "Pelemkerep", "Rajekwesi", "Sengonbugel", "Singorojo", "Tigajuru"],
                "Nalumsari": ["Bategede", "Bendanpete", "Blimbingrejo", "Daren", "Dorang", "Gemiring Kidul", "Gemiring Lor", "Jatisari", "Karangnongko", "Ngetuk", "Pringtulis", "Tritis", "Tunggulpandean"],
                "Bangsri": ["Banjaragung", "Bangsri", "Banjaran", "Guyangan", "Jerukwangi", "Kedungleper", "Krasak", "Papasan", "Srikimin", "Tengguli", "Wedelan"],
                "Kembang": ["Baleromo", "Bucu", "Cepogo", "Dersalam", "Dudakawu", "Kaliaman", "Kancilan", "Pendem", "Sumanding", "Tubanan", "Watuaji"],
                "Mlonggo": ["Jambu", "Jambu Timur", "Karanggonso", "Mororejo", "Sekuro", "Sinanggul", "Srobyong", "Suwawal"],
                "Pakis Aji": ["Bulungan", "Kawunganten", "Lebak", "Mambak", "Pakis Aji", "Plajan", "Slagi", "Suwawal Timur", "Tanjung"],
                "Keling": ["Bumiharjo", "Damarwulan", "Gelang", "Kaligarang", "Kelet", "Keling", "Klepu", "Tempur", "Tunahan", "Watuwaji"],
                "Donorojo": ["Bandungharjo", "Banyumanis", "Blingoh", "Clering", "Jlegong", "Juglogo", "Sumber Rejo", "Tulakan", "Ujungwatu"],
                "Karimunjawa": ["Karimunjawa", "Kemojan", "Parang", "Nyamuk"]
            },
            "Kab. Karanganyar": ["Karanganyar", "Colomadu", "Gondangrejo", "Jaten", "Jatipuro", "Jatiyoso", "Jenawi", "Karangpandan", "Kebakkramat", "Kerjo", "Matesih", "Mojogedang", "Ngargoyoso", "Tasikmadu", "Tawangmangu"],
            "Kab. Kebumen": ["Kebumen", "Adimulyo", "Alian", "Ambal", "Ayah", "Bonorowo", "Buayan", "Buluspesantren", "Gombong", "Karanganyar", "Karanggayam", "Karangsambung", "Klakah", "Kutowinangun", "Kuwarasan", "Mirit", "Padureso", "Pejagoan", "Petanahan", "Prembun", "Puring", "Rowokele", "Sadang", "Sempor", "Sruweng"],
            "Kab. Kendal": ["Kendal", "Boja", "Brangsong", "Cepiring", "Gemuh", "Kaliwungu", "Kaliwungu Selatan", "Kangkung", "Limbangan", "Ngampel", "Patean", "Patebon", "Pegandon", "Plantungan", "Ringinarum", "Rowosari", "Singorojo", "Sukorejo", "Weleri"],
            "Kab. Klaten": ["Klaten Selatan", "Klaten Tengah", "Klaten Utara", "Bayat", "Cawas", "Ceper", "Delanggu", "Gantiwarno", "Jatinom", "Jogonalan", "Juwiring", "Kalikotes", "Karanganom", "Karangdowo", "Karangnongko", "Kebonarum", "Kemalang", "Manisrenggo", "Ngawen", "Pedan", "Polanharjo", "Prambanan", "Trucuk", "Tulung", "Wedi", "Wonosari"],
            "Kab. Kudus": {
                "Kota Kudus": ["Barongan", "Burikan", "Damaran", "Demaan", "Glantengan", "Janggalan", "Kaliputu", "Kauman", "Kramat", "Krandon", "Langgardalem", "Mlati Kidul", "Mlati Lor", "Nganguk", "Panjunan", "Purwosari", "Rendeng", "Singocandi", "Sunggingan", "Wergu Kulon", "Wergu Wetan"],
                "Jati": ["Getaspejaten", "Jati Kulon", "Jati Wetan", "Loram Kulon", "Loram Wetan", "Pasuruhan Kidul", "Pasuruhan Lor", "Ploso", "Tanjungkarang", "Tumpangkrasak"],
                "Bae": ["Bacin", "Bae", "Dersalam", "Gondangmanis", "Karangbener", "Ngembalrejo", "Peganjaran", "Purworejo"],
                "Gebog": ["Besito", "Getassrabi", "Gondosari", "Gribig", "Jurang", "Karangmalang", "Klumpit", "Menawan", "Padurenan", "Rahtawu"],
                "Dawe": ["Cendono", "Colo", "Cranggang", "Dukuhwaringin", "Glagah Kulon", "Japan", "Kajar", "Kandangmas", "Kuwukan", "Lau", "Margorejo", "Piji", "Puyoh", "Rejosari", "Samirejo", "Soco", "Ternadi"],
                "Kaliwungu": ["Bakalankrapyak", "Banget", "Blimbing Kidul", "Gamong", "Garung Kidul", "Garung Lor", "Kaliwungu", "Karangampel", "Kedungdowo", "Mijen", "Papringan", "Prambatan Kidul", "Prambatan Lor", "Setrokalangan", "Sidorekso"],
                "Mejobo": ["Golantepus", "Gulang", "Hadiwarno", "Jepang", "Jojo", "Kesambi", "Kirig", "Mejobo", "Payaman", "Temulus", "Tenggeles"],
                "Jekulo": ["Bulungcangkring", "Bulung Kulon", "Hadipolo", "Honggosoco", "Jekulo", "Klaling", "Pladen", "Sadang", "Sidomulyo", "Tanjungrejo", "Terban"],
                "Undaan": ["Berugenjang", "Kalirejo", "Karangrowo", "Lambangan", "Larikrejo", "Medini", "Ngemplak", "Sambung", "Terangmas", "Undaan Kidul", "Undaan Lor", "Undaan Tengah", "Wates", "Wonosoco"]
            },
            "Kab. Magelang": ["Borobudur", "Candimulyo", "Dukun", "Grabag", "Kajoran", "Kaliangkrik", "Mertoyudan", "Mungkid", "Muntilan", "Ngablak", "Ngluwar", "Salam", "Salaman", "Sawangan", "Secang", "Srumbung", "Tegalrejo", "Tempuran", "Windusari"],
            "Kab. Pati": {
                "Pati": ["Pati Lor", "Pati Kidul", "Pati Wetan", "Plangitan", "Puri", "Parenggan", "Sarirejo", "Ngarus", "Kalidoro", "Dengkek", "Gajahmati", "Blaru"],
                "Juwana": ["Bajomulyo", "Bakaran Kulon", "Bakaran Wetan", "Bendar", "Bumirejo", "Doropayung", "Dukutalit", "Gadingrejo", "Genengmulyo", "Growong Kidul", "Growong Lor", "Kauman", "Kebonsawahan", "Kedungpoh", "Kudukeras", "Langgenharjo", "Pajeksan", "Trimulyo"],
                "Tayu": ["Bendar", "Bulungan", "Dororejo", "Jepuro", "Jepat Kidul", "Jepat Lor", "Kalikalong", "Keboromo", "Kedungsari", "Kedungbang", "Luwang", "Margomulyo", "Pakis", "Purwokerto", "Sambiroto", "Sendangjan", "Tayu Kulon", "Tayu Wetan", "Tunggulsari"],
                "Batangan": ["Batursari", "Bumimulyo", "Gunungpanti", "Jembangan", "Kedalon", "Klayusiwalan", "Lengkong", "Manggarpasi", "Ngening", "Raci", "Talogorejo", "Tumpukrenteng"],
                "Wedarijaksa": ["Bangsalrejo", "Bumiayu", "Jatimulyo", "Jetak", "Margorejo", "Ngurenrejo", "Ngurensiti", "Pagerharjo", "Sukoharjo", "Suwaduk", "Tlogoharum", "Wedarijaksa"],
                "Trangkil": ["Asemmating", "Guyangan", "Kadilangu", "Kajar", "Karanglegi", "Karangwage", "Kertomulyo", "Mojo", "Pasucen", "Rejosari", "Sambiroto", "Tegalharjo", "Trangkil"],
                "Margoyoso": ["Bulumanis Kidul", "Bulumanis Lor", "Cebolek Kidul", "Kertomulyo", "Langgenharjo", "Mojo", "Ngemplak Kidul", "Ngemplak Lor", "Pangkalan", "Pohijo", "Purworejo", "Sekuro", "Semerak", "Sidomulyo", "Soneyan", "Tanjungrejo", "Tegalarum", "Waturoyo"],
                "Gabus": ["Babalan", "Banjarsari", "Bogotanjung", "Gabus", "Gebang", "Gempolsari", "Karaban", "Koripandriyo", "Kosekan", "Mintobasuki", "Mojolawaran", "Pantirejo", "Penanggungan", "Plumbungan", "Sambirejo", "Soko", "Sunggingwarno", "Tanjunganom", "Tanjungsekar", "Tlogoayu", "Woro"],
                "Kayen": ["Boloagung", "Brimo", "Durensawari", "Jatiroto", "Jimbaran", "Kayen", "Pasuruhan", "Pesagi", "Rogomulyo", "Slungkep", "Srikaton", "Sumbersari", "Sundolomanis", "Talun", "Trimulyo"],
                "Sukolilo": ["Baleadi", "Baturejo", "Cengkalsewu", "Gadudero", "Kedungwinong", "Kasiyan", "Kuawur", "Pakem", "Porangparing", "Prawoto", "Sukolilo", "Sumbersoko", "Tompegunung", "Wegil", "Wotan"],
                "Margorejo": ["Badegan", "Banyuurip", "Bumirejo", "Dadirejo", "Jambean Kidul", "Jimbaran", "Langse", "Margorejo", "Metaraman", "Muktiyoso", "Ngawen", "Pegandan", "Penambuhan", "Sadang", "Sukoharjo", "Sukokulon", "Wangunrejo"],
                "Gembong": ["Bageng", "Bermi", "Gembong", "Kedungbulus", "Klakah Kasihan", "Plukaran", "Pohgading", "Semirejo", "Sitiluhur"],
                "Tlogowungu": ["Cabak", "Gunungsari", "Guwo", "Klampok", "Lahardik", "Purwosari", "Regaloh", "Sambirejo", "Suwatu", "Tajungsari", "Tamansari", "Tlogorejo", "Tlogowungu", "Wonorejo"],
                "Cluwak": ["Bleber", "Gerit", "Karangsari", "Medani", "Mojo", "Ngablak", "Payak", "Plaosan", "Sentul", "Sirahan", "Sumur", "Wotgali"],
                "Gunungwungkal": ["Bancak", "Gadu", "Giling", "Gulungwungkal", "Jembulwunut", "Jepalo", "Jrahi", "Perdopo", "Pesagen", "Sidomulyo", "Sumberejo"],
                "Jaken": ["Arumanis", "Boto", "Kebonturi", "Lanjutan", "Manjang", "Mantingan", "Mojoluhur", "Ronggo", "Sidoluhur", "Sumberejo", "Triwikaton"],
                "Jakenan": ["Bungasrejo", "Dukuhmulyo", "Glonggong", "Jakenan", "Jatisari", "Kalimulyo", "Karangrowo", "Kedungmulyo", "Mantingan", "Ngastorejo", "Plosorejo", "Puluhan Tengah", "Sembaturagung", "Sendangsoko", "Sidoarum", "Sonorejo", "Tlogorejo", "Tombang"],
                "Pucakwangi": ["Bodeh", "Grogolsari", "Karangrejo", "Karangwotan", "Kepoh", "Kletek", "Lumbungmas", "Mencon", "Pelemgede", "Plosorejo", "Pucakwangi", "Sitimulyo", "Sokopuluhan", "Tanjungsekar", "Terteg", "Triguno", "Wapauwe"],
                "Tambakromo": ["Angkatan Kidul", "Angkatan Lor", "Karaban", "Karangawen", "Kebonagung", "Kedalingan", "Larangan", "Maitan", "Mangunsari", "Mojomulyo", "Pakis", "Pekalongan", "Sinomwidodo", "Sitirejo", "Tambahagung", "Tambaharjo", "Tambakromo", "Wukirsari"],
                "Winong": ["Beringin", "Bumiharjo", "Danyangmulyo", "Degan", "Godinho", "Gunungpanti", "Guyangan", "Karangkonang", "Karangsumber", "Kebolampang", "Kebowan", "Klecoregonang", "Kropak", "Kudakkrajan", "Mintorahayu", "Padangan", "Pagendisan", "Pekalongan", "Pohgading", "Pulorejo", "Sarimulyo", "Serutsadang", "Sumbermulyo", "Tanggel", "Tawangrejo", "Tlogorejo", "Winong", "Wirun"]
            },
            "Kab. Pekalongan": ["Kajen", "Bojong", "Buaran", "Doro", "Karanganyar", "Kedungwuni", "Kesesi", "Lebakbarang", "Paninggaran", "Petungkriyono", "Siwalan", "Sragi", "Talun", "Tirto", "Wiradesa", "Wonokerto", "Wonopringgo"],
            "Kab. Pemalang": ["Pemalang", "Ampelgading", "Bantarbolang", "Belik", "Bodeh", "Comal", "Moga", "Petarukan", "Pulosari", "Randudongkal", "Taman", "Ulujami", "Warungpring", "Watukumpul"],
            "Kab. Purbalingga": ["Purbalingga", "Bobotsari", "Bojongsari", "Bukateja", "Kaligondang", "Kalimanah", "Karanganyar", "Karangmoncol", "Karangreja", "Kejobong", "Kemangkon", "Kertanegara", "Kutasari", "Mrebet", "Padamara", "Pengadegan", "Rembang"],
            "Kab. Purworejo": ["Purworejo", "Bagelen", "Banyuurip", "Bayan", "Bener", "Bruno", "Butuh", "Gebang", "Grabag", "Kaligesing", "Kemiri", "Kutoarjo", "Loano", "Ngombol", "Pituruh", "Purwodadi"],
            "Kab. Rembang": ["Rembang", "Bulu", "Gunem", "Kaliori", "Kragan", "Lasem", "Pamotan", "Pancur", "Sale", "Sarang", "Sedan", "Sluke", "Sulang", "Sumber"],
            "Kab. Semarang": ["Ungaran Barat", "Ungaran Timur", "Ambarawa", "Bancak", "Bandungan", "Banyubiru", "Bawen", "Beragas", "Bringin", "Getasan", "Jambu", "Kaliwungu", "Pabelan", "Pringapus", "Sumowono", "Suruh", "Susukan", "Tengaran", "Tuntang"],
            "Kab. Sragen": ["Sragen", "Gemolong", "Gesi", "Gondang", "Jenar", "Kalijambe", "Karangmalang", "Kedawung", "Masaran", "Miri", "Mondokan", "Ngrampal", "Plupuh", "Sambirejo", "Sambungmacan", "Sidoharjo", "Sukodono", "Sumberlawang", "Tangen", "Tanon"],
            "Kab. Sukoharjo": ["Sukoharjo", "Baki", "Bendosari", "Bulul", "Gatak", "Grogol", "Kartasura", "Mojolaban", "Nguter", "Polokarto", "Tawangsari", "Weru"],
            "Kab. Tegal": ["Slawi", "Adiwerna", "Balapulang", "Bojong", "Bumijawa", "Dukuhturi", "Dukuhwaru", "Jatinegara", "Kedungbanteng", "Kramat", "Lebaksiu", "Margasari", "Pagerbarang", "Pangkah", "Suradadi", "Talang", "Tarub", "Warureja"],
            "Kab. Temanggung": ["Temanggung", "Bansari", "Bejen", "Bulul", "Candiroto", "Gemawang", "Jumo", "Kaloran", "Kandangan", "Kedu", "Kledung", "Kranggan", "Ngadirejo", "Parakan", "Pringsurat", "Selopampang", "Tembarak", "Tlogomulyo", "Tretep", "Wonoboyo"],
            "Kab. Wonogiri": ["Wonogiri", "Baturetno", "Batuwarno", "Bulukerto", "Eromoko", "Girimarto", "Giritontro", "Giriwoyo", "Jatipurno", "Jatiroto", "Jatisrono", "Karangtengah", "Kismantoro", "Manyaran", "Ngadirojo", "Nguntoronadi", "Paranggupito", "Pracimantoro", "Puhpelem", "Purwantoro", "Raden", "Selogiri", "Sidoharjo", "Slogohimo", "Tirtomoyo", "Wuryantoro"],
            "Kab. Wonosobo": ["Wonosobo", "Garung", "Kalibawang", "Kalikajar", "Kaliwiro", "Kejajar", "Kepil", "Kertek", "Leksono", "Mojotengah", "Sapuran", "Selomerto", "Sukoharjo", "Wadaslintang", "Watumalang"],
            "Kota Magelang": ["Magelang Selatan", "Magelang Tengah", "Magelang Utara"],
            "Kota Pekalongan": ["Pekalongan Barat", "Pekalongan Selatan", "Pekalongan Timur", "Pekalongan Utara"],
            "Kota Salatiga": ["Argomulyo", "Sidomukti", "Sidorejo", "Tingkir"],
            "Kota Semarang": {
                "Semarang Tengah": ["Bangunharjo", "Brumbungan", "Gabahan", "Jagalan", "Karangkidul", "Kauman", "Kembangsari", "Kranggan", "Miroto", "Pandansari", "Pekunden", "Pendrikan Kidul", "Pendrikan Lor", "Purwodinatan", "Sekayu"],
                "Semarang Barat": ["Bojongsalaman", "Bongsari", "Cabean", "Gisikdrono", "Kalibanteng Kidul", "Kalibanteng Kulon", "Karangayu", "Kembangarum", "Krapyak", "Krobokan", "Manyaran", "Ngemplak Simongan", "Salamanmloyo", "Tambakharjo", "Tawangmas", "Tawangsari"],
                "Semarang Timur": ["Bugangan", "Karangtempel", "Karangturi", "Kebonagung", "Kemijen", "Mlatibaru", "Mlatiharjo", "Rejomulyo", "Rejosari", "Sarirejo"],
                "Semarang Selatan": ["Barusari", "Bulustalan", "Lamper Kidul", "Lamper Lor", "Lamper Tengah", "Mugassari", "Peterongan", "Pleburan", "Randusari", "Wonodri"],
                "Semarang Utara": ["Bandarharjo", "Bulu Lor", "Dadapsari", "Kuningan", "Panggung Kidul", "Panggung Lor", "Plombokan", "Purwosari", "Tanjungmas"],
                "Banyumanik": ["Banyumanik", "Gedawang", "Jabungan", "Padangsari", "Pedurungan", "Pudakpayung", "Srondol Kulon", "Srondol Wetan", "Sumurboto", "Tinjomoyo"],
                "Pedurungan": ["Gemah", "Kalisegoro", "Muktiharjo Kidul", "Palebon", "Pedurungan Kidul", "Pedurungan Lor", "Pedurungan Tengah", "Penggaron Kidul", "Plamongan Sari", "Tlogomulyo", "Tlogosari Kulon", "Tlogosari Wetan"],
                "Tembalang": ["Bangkong", "Bulusan", "Jangli", "Kedungmundu", "Kramas", "Mangunsari", "Meteseh", "Rowosari", "Sambiroto", "Sendangguwo", "Sendangmulyo", "Tandang", "Tembalang"],
                "Ngaliyan": ["Bambankerep", "Bringin", "Gondoriyo", "Kalipancur", "Ngaliyan", "Podorejo", "Purwoyoso", "Tambakaji", "Wonoboyo", "Wonosari"],
                "Gunungpati": ["Cepoko", "Gunungpati", "Jatirejo", "Kalisidi", "Kandri", "Mangunsari", "Ngembalsari", "Nongkosawit", "Pakintelan", "Patemon", "Plalangan", "Pongangan", "Sadeng", "Sekaran", "Sukorejo"],
                "Candisari": ["Candi", "Jatingaleh", "Jomblang", "Kaliwiru", "Karanganyar Gunung", "Tegalsari", "Wonotingal"],
                "Gajahmungkur": ["Bendan Duwur", "Bendan Ngisor", "Bendungan", "Gajahmungkur", "Karangrejo", "Lempongsari", "Petompon", "Sampangan"],
                "Gayamsari": ["Gayamsari", "Kaligawe", "Pandean Lamper", "Sambirejo", "Sawah Besar", "Siwalan", "Tambakrejo"],
                "Genuk": ["Bangetayu Kulon", "Bangetayu Wetan", "Banjardowo", "Gebangsari", "Genuksari", "Karangroto", "Kudu", "Muktiharjo Lor", "Penggaron Lor", "Sembungharjo", "Terboyo Kulon", "Terboyo Wetan", "Trimulyo"],
                "Mijen": ["Cangkiran", "Jatibarang", "Jatisari", "Karangmalang", "Kedungpane", "Mijen", "Ngadirgo", "Pesantren", "Polaman", "Purwosari", "Tambangan", "Wonolopo", "Wonoplumbon"],
                "Tugu": ["Jerakah", "Karanganyar", "Mangkang Kulon", "Mangkang Wetan", "Mangunharjo", "Randu Garut", "Tugurejo"]
            },
            "Kota Surakarta": ["Banjarsari", "Jebres", "Laweyan", "Pasar Kliwon", "Serengan"],
            "Kota Tegal": ["Margadana", "Tegal Barat", "Tegal Selatan", "Tegal Timur"]
        },
        "Jawa Timur": {
            "Kota Surabaya": ["Tegalsari", "Genteng", "Bubutan", "Simokerto", "Pabean Cantian", "Semampir", "Krembangan", "Gubeng", "Gunung Anyar", "Sukolilo", "Tambaksari", "Mulyorejo", "Rungkut", "Tenggilis Mejoyo", "Benowo", "Pakal", "Asemrowo", "Sukomanunggal", "Tandes", "Sambikerep", "Lakarsantri", "Wonokromo", "Wonocolo", "Wiyung", "Karangpilang", "Jambangan", "Gayungan", "Dukuh Pakis", "Sawahan"],
            "Kota Malang": ["Blimbing", "Kedungkandang", "Klojen", "Lowokwaru", "Sukun"],
            "Kota Batu": ["Batu", "Bumiaji", "Junrejo"],
            "Kota Blitar": ["Kepanjenkidul", "Sananwetan", "Sukorejo"],
            "Kota Kediri": ["Kota", "Mojoroto", "Pesantren"],
            "Kota Madiun": ["Kartoharjo", "Manguharjo", "Taman"],
            "Kota Mojokerto": ["Kranggan", "Magersari", "Prajurit Kulon"],
            "Kota Pasuruan": ["Bugul Kidul", "Gadingrejo", "Panggungrejo", "Purworejo"],
            "Kota Probolinggo": ["Kademangan", "Kanigaran", "Kedopok", "Mayangan", "Wonoasih"],
            "Kab. Sidoarjo": ["Sidoarjo", "Buduran", "Candi", "Gedangan", "Jabon", "Krembung", "Krian", "Prambon", "Porong", "Sedati", "Sukodono", "Taman", "Tanggulangin", "Tarik", "Tulangan", "Waru", "Wonoayu"],
            "Kab. Gresik": ["Gresik", "Kebomas", "Manyar", "Menganti", "Driyorejo", "Cerme", "Bungah", "Benjeng", "Balongpanggang", "Duduksampeyan", "Kedamean", "Panceng", "Sidayu", "Ujungpangkah", "Wringinanom"],
            "Kab. Banyuwangi": ["Banyuwangi", "Genteng", "Rogojampi", "Muncar", "Kalipuro", "Glenmore", "Gambiran", "Kabat", "Srono"],
            "Kab. Bojonegoro": ["Bojonegoro", "Dander", "Kapas", "Kalitidu", "Padangan", "Balen", "Baureno", "Sumberejo"],
            "Kab. Jember": ["Kaliwates", "Patrang", "Sumbersari", "Ambulu", "Tanggul", "Balung", "Kencong", "Rambipuji", "Wuluhan"],
            "Kab. Lamongan": ["Lamongan", "Babat", "Paciran", "Tikung", "Deket", "Sukodadi", "Karanggeneng", "Brondong"],
            "Kab. Malang": ["Kepanjen", "Singosari", "Lawang", "Pakis", "Dau", "Turen", "Gondanglegi", "Pujon", "Wagir"],
            "Kab. Pasuruan": ["Bangil", "Pandaan", "Purwosari", "Gempol", "Prigen", "Beji", "Kraton", "Sukorejo"],
            "Kab. Tuban": ["Tuban", "Semanding", "Jenu", "Palang", "Rengel", "Merakurak", "Montong", "Widang"],
            "Kab. Jombang": ["Jombang", "Diwek", "Mojoagung", "Ploso", "Peterongan", "Sumobito", "Tembelang"],
            "Kab. Kediri": ["Pare", "Ngadiluwih", "Wates", "Gurah", "Kandangan", "Plosoklaten", "Mojo", "Plemahan"],
            "Kab. Mojokerto": ["Mojosari", "Trowulan", "Pacet", "Ngoro", "Jetis", "Puri", "Sooko", "Dlanggu"],
            "Kab. Bangkalan": ["Bangkalan", "Kamal", "Burneh", "Socah", "Arosbaya", "Klampis", "Sepulu", "Blega"],
            "Kab. Sampang": ["Sampang", "Torjun", "Camplong", "Ketapang", "Banyuates", "Kedungdung", "Tambelangan"],
            "Kab. Pamekasan": ["Pamekasan", "Pademawu", "Tlanakan", "Proppo", "Galis", "Larangan", "Pegantenan"],
            "Kab. Sumenep": ["Kota Sumenep", "Kalianget", "Saronggi", "Ambunten", "Gapura", "Lenteng", "Manding", "Pasongsongan"],
            "Kab. Lumajang": ["Lumajang", "Pasirian", "Tempeh", "Senduro", "Klakah", "Yosowilangun", "Sukodono"],
            "Kab. Bondowoso": ["Bondowoso", "Tamanan", "Wringin", "Prajekan", "Maesan", "Tapen", "Tenggarang"],
            "Kab. Situbondo": ["Situbondo", "Panji", "Besuki", "Asembagus", "Panarukan", "Banyuputih", "Suboh"],
            "Kab. Probolinggo": ["Kraksaan", "Paiton", "Dringu", "Gending", "Besuk", "Leces", "Tongas"],
            "Kab. Nganjuk": ["Nganjuk", "Kertosono", "Tanjunganom", "Berbek", "Loceret", "Bagor", "Prambon"],
            "Kab. Madiun": ["Mejayan", "Caruban", "Geger", "Wungu", "Balerejo", "Dolopo", "Jiwan", "Pilangkenceng"],
            "Kab. Magetan": ["Magetan", "Maospati", "Plaosan", "Kawedanan", "Bendo", "Barat", "Sukomoro"],
            "Kab. Ngawi": ["Ngawi", "Geneng", "Paron", "Kendal", "Jogorogo", "Widodaren", "Sine"],
            "Kab. Pacitan": ["Pacitan", "Arjosari", "Kebonagung", "Tulakan", "Ngadirojo", "Punung", "Pringkuku"],
            "Kab. Ponorogo": ["Ponorogo", "Babadan", "Siman", "Kauman", "Balong", "Jenangan", "Sambit", "Pulung"],
            "Kab. Trenggalek": ["Trenggalek", "Karangan", "Durenan", "Watulimo", "Panggul", "Tugu", "Gandusari"],
            "Kab. Tulungagung": ["Tulungagung", "Kedungwaru", "Boyolangu", "Ngunut", "Kauman", "Gondang", "Sumbergempol"],
            "Kab. Blitar": ["Kanigoro", "Wlingi", "Srengat", "Garum", "Sutojayan", "Talun", "Gandusari", "Kademangan"]
        },
        "Kalimantan Barat": {
            "Kota Pontianak": ["Pontianak Barat", "Pontianak Kota", "Pontianak Selatan", "Pontianak Tenggara", "Pontianak Timur", "Pontianak Utara"],
            "Kota Singkawang": ["Singkawang Barat", "Singkawang Selatan", "Singkawang Tengah", "Singkawang Timur", "Singkawang Utara"],
            "Kab. Bengkayang": ["Bengkayang", "Jagoi Babang", "Ledo", "Samalantan", "Sungai Raya"],
            "Kab. Kapuas Hulu": ["Putussibau Utara", "Putussibau Selatan", "Bika", "Embaloh Hulu", "Semitau"],
            "Kab. Kayong Utara": ["Sukadana", "Simpang Hilir", "Teluk Batang", "Seponti", "Pulau Maya"],
            "Kab. Ketapang": ["Delta Pawan", "Benua Kayong", "Muara Pawan", "Kendawangan", "Sandai"],
            "Kab. Kubu Raya": ["Sungai Raya", "Rasau Jaya", "Sungai Kakap", "Kuala Mandor B", "Teluk Pakedai"],
            "Kab. Landak": ["Ngabang", "Mandor", "Menjalin", "Sengah Temila", "Mempawah Hulu"],
            "Kab. Melawi": ["Nanga Pinoh", "Ella Hilir", "Belimbing", "Pinoh Selatan", "Sayan"],
            "Kab. Mempawah": ["Mempawah Hilir", "Mempawah Timur", "Sungai Pinyuh", "Siantan", "Segedong"],
            "Kab. Sambas": ["Sambas", "Pemangkat", "Teluk Keramat", "Tebas", "Jawai", "Paloh"],
            "Kab. Sanggau": ["Kapuas", "Parindu", "Tayan Hilir", "Tayan Hulu", "Entikong", "Beduai"],
            "Kab. Sekadau": ["Sekadau Hilir", "Sekadau Hulu", "Belitang", "Nanga Taman", "Nanga Mahap"],
            "Kab. Sintang": ["Sintang", "Sepauk", "Tempunak", "Kelam Permai", "Dedai", "Kayan Hilir"]
        },
        "Kalimantan Selatan": {
            "Kota Banjarbaru": ["Banjarbaru Selatan", "Banjarbaru Utara", "Cempaka", "Landasan Ulin", "Liang Anggang"],
            "Kota Banjarmasin": ["Banjarmasin Barat", "Banjarmasin Selatan", "Banjarmasin Tengah", "Banjarmasin Timur", "Banjarmasin Utara"],
            "Kab. Balangan": ["Paringin", "Paringin Selatan", "Batu Mandi", "Awayan", "Lampihong"],
            "Kab. Banjar": ["Martapura", "Martapura Barat", "Martapura Timur", "Kertak Hanyar", "Gambut", "Karang Intan", "Sungai Tabuk"],
            "Kab. Barito Kuala": ["Marabahan", "Alalak", "Mandastana", "Rantau Badauh", "Anjir Muara"],
            "Kab. Hulu Sungai Selatan": ["Kandangan", "Angkinang", "Daha Selatan", "Daha Utara", "Simpur"],
            "Kab. Hulu Sungai Tengah": ["Barabai", "Batu Benawa", "Haruyan", "Labuan Amas Selatan", "Pandawan"],
            "Kab. Hulu Sungai Utara": ["Amuntai Tengah", "Amuntai Selatan", "Amuntai Utara", "Danau Panggang", "Sungai Pandan"],
            "Kab. Kotabaru": ["Pulau Laut Utara", "Pulau Laut Sigam", "Kelumpang Hilir", "Pamukan Barat"],
            "Kab. Tabalong": ["Tanjung", "Murung Pudak", "Kelua", "Haruai", "Tanta"],
            "Kab. Tanah Bumbu": ["Batulicin", "Simpang Empat", "Kusan Hilir", "Satui", "Angsana"],
            "Kab. Tanah Laut": ["Pelaihari", "Bati-Bati", "Kintap", "Takisung", "Tambang Ulang"],
            "Kab. Tapin": ["Tapin Utara", "Bakarangan", "Binuang", "Lokpaikat", "Tapin Selatan"]
        },
        "Kalimantan Tengah": {
            "Kota Palangka Raya": ["Pahandut", "Jekan Raya", "Bukit Batu", "Sabangau", "Rakumpit"],
            "Kab. Barito Selatan": ["Dusun Selatan", "Dusun Utara", "Dusun Hilir", "Jenamas", "Gunung Bintang Awai"],
            "Kab. Barito Timur": ["Tamiang Layang", "Dusun Timur", "Benua Lima", "Awang", "Pematang Karau"],
            "Kab. Barito Utara": ["Muara Teweh", "Teweh Tengah", "Teweh Baru", "Teweh Selatan", "Montalat"],
            "Kab. Gunung Mas": ["Kuala Kurun", "Kurun", "Tewah", "Rungan", "Manuhing"],
            "Kab. Kapuas": ["Selat", "Kapuas Hilir", "Kapuas Barat", "Kapuas Murung", "Pulaun Petak"],
            "Kab. Katingan": ["Kasongan", "Katingan Hilir", "Katingan Tengah", "Tasik Payawan", "Sanaman Mantikei"],
            "Kab. Kotawaringin Barat": ["Pangkalan Bun", "Arut Selatan", "Kumai", "Kotawaringin Lama", "Pangkalan Lada"],
            "Kab. Kotawaringin Timur": ["Sampit", "Mentawa Baru Ketapang", "Baamang", "Kota Besi", "Parenggean"],
            "Kab. Lamandau": ["Nanga Bulik", "Bulik", "Sematu Jaya", "Lamandau", "Delang"],
            "Kab. Murung Raya": ["Puruk Cahu", "Murung", "Laung Tuhup", "Permata Intan", "Sumber Barito"],
            "Kab. Pulang Pisau": ["Kahayan Hilir", "Kahayan Tengah", "Pandih Batu", "Maliku", "Jabiren Raya"],
            "Kab. Seruyan": ["Kuala Pembuang", "Seruyan Hilir", "Seruyan Tengah", "Danau Sembuluh", "Hanau"],
            "Kab. Sukamara": ["Sukamara", "Balai Riam", "Jelai", "Pantai Lunci", "Permata Kecubung"]
        },
        "Kalimantan Timur": {
            "Kota Balikpapan": ["Balikpapan Barat", "Balikpapan Kota", "Balikpapan Selatan", "Balikpapan Tengah", "Balikpapan Timur", "Balikpapan Utara"],
            "Kota Bontang": ["Bontang Barat", "Bontang Selatan", "Bontang Utara"],
            "Kota Samarinda": ["Loa Janan Ilir", "Palaran", "Samarinda Ilir", "Samarinda Kota", "Samarinda Seberang", "Samarinda Ulu", "Samarinda Utara", "Sambutan", "Sungai Kunjang", "Sungai Pinang"],
            "Kab. Berau": ["Tanjung Redeb", "Sambaliung", "Gunung Tabur", "Teluk Bayur", "Biduk-Biduk"],
            "Kab. Kutai Barat": ["Sendawar", "Barong Tongkok", "Melak", "Damai", "Muara Pahu"],
            "Kab. Kutai Kartanegara": ["Tenggarong", "Tenggarong Seberang", "Loa Janan", "Loa Kulu", "Muara Badak", "Samboja", "Anggana", "Kota Bangun", "Sebulu"],
            "Kab. Kutai Timur": ["Sangatta Utara", "Sangatta Selatan", "Bengalon", "Kaliorang", "Muara Wahau"],
            "Kab. Mahakam Ulu": ["Ujoh Bilang", "Long Bagun", "Long Hubung", "Long Pahangai", "Laham"],
            "Kab. Paser": ["Tanah Grogot", "Kuaro", "Long Ikis", "Batu Sopang", "Muara Komam"],
            "Kab. Penajam Paser Utara": ["Penajam", "Sepaku", "Babulu", "Waru"]
        },
        "Kalimantan Utara": {
            "Kota Tarakan": ["Tarakan Barat", "Tarakan Tengah", "Tarakan Timur", "Tarakan Utara"],
            "Kab. Bulungan": ["Tanjung Selor", "Tanjung Palas", "Tanjung Palas Timur", "Tanjung Palas Utara", "Peso"],
            "Kab. Malinau": ["Malinau Kota", "Malinau Barat", "Malinau Utara", "Mentarang", "Kayan Hulu"],
            "Kab. Nunukan": ["Nunukan", "Nunukan Selatan", "Sebatik", "Sebatik Barat", "Sebatik Timur", "Sembakung"],
            "Kab. Tana Tidung": ["Tideng Pale", "Sesayap", "Sesayap Hilir", "Betayau", "Muruk Rian"]
        },
        "Kepulauan Bangka Belitung": {
            "Kota Pangkalpinang": ["Bukit Intan", "Gabek", "Gerunggang", "Girimaya", "Pangkal Balam", "Rangkui", "Taman Sari"],
            "Kab. Bangka": ["Sungailiat", "Belinyu", "Merawang", "Mendo Barat", "Pemali"],
            "Kab. Bangka Barat": ["Muntok", "Jebus", "Kelapa", "Parittiga", "Simpang Teritip"],
            "Kab. Bangka Selatan": ["Toboali", "Airgegas", "Lepar Pongok", "Payung", "Simpang Rimba"],
            "Kab. Bangka Tengah": ["Koba", "Lubuk Besar", "Namang", "Pangkalan Baru", "Simpang Katis", "Sungai Selan"],
            "Kab. Belitung": ["Tanjung Pandan", "Badau", "Membalong", "Sijuk", "Selat Nasik"],
            "Kab. Belitung Timur": ["Manggar", "Damar", "Gantung", "Kelapa Kampit", "Simpang Pesak"]
        },
        "Kepulauan Riau": {
            "Kota Batam": ["Batam Kota", "Batu Aji", "Batu Ampar", "Belakang Padang", "Bengkong", "Bulang", "Galang", "Lubuk Baja", "Nongsa", "Sagulung", "Sei Beduk", "Sekupang"],
            "Kota Tanjungpinang": ["Bukit Bestari", "Tanjungpinang Barat", "Tanjungpinang Kota", "Tanjungpinang Timur"],
            "Kab. Bintan": ["Bandar Seri Bentan", "Bintan Timur", "Bintan Utara", "Teluk Bintan", "Gunung Kijang", "Teluk Sebong"],
            "Kab. Karimun": ["Tanjung Balai Karimun", "Karimun", "Meral", "Meral Barat", "Tebing", "Kundur"],
            "Kab. Kepulauan Anambas": ["Tarempa", "Siantan", "Siantan Selatan", "Siantan Timur", "Palmatak", "Jemaja"],
            "Kab. Lingga": ["Daik", "Lingga", "Singkep", "Singkep Barat", "Senayang"],
            "Kab. Natuna": ["Ranai", "Bunguran Timur", "Bunguran Barat", "Bunguran Utara", "Midai", "Serasan"]
        },
        "Lampung": {
            "Kota Bandar Lampung": ["Bumi Waras", "Enggal", "Kedamaian", "Kedaton", "Kemiling", "Labuhan Ratu", "Langkapura", "Panjang", "Rajabasa", "Sukabumi", "Sukarame", "Tanjung Karang Barat", "Tanjung Karang Pusat", "Tanjung Karang Timur", "Tanjung Senang", "Teluk Betung Barat", "Teluk Betung Selatan", "Teluk Betung Timur", "Teluk Betung Utara", "Way Halim"],
            "Kota Metro": ["Metro Barat", "Metro Pusat", "Metro Selatan", "Metro Timur", "Metro Utara"],
            "Kab. Lampung Barat": ["Liwa", "Balik Bukit", "Sumber Jaya", "Belalau", "Way Tenong"],
            "Kab. Lampung Selatan": ["Kalianda", "Natar", "Jati Agung", "Sidomulyo", "Katibung", "Palas", "Penengahan"],
            "Kab. Lampung Tengah": ["Gunung Sugih", "Terbanggi Besar", "Seputih Banyak", "Kalirejo", "Padang Ratu"],
            "Kab. Lampung Timur": ["Sukadana", "Way Jepara", "Labuhan Maringgai", "Pekalongan", "Sekampung"],
            "Kab. Lampung Utara": ["Kotabumi", "Kotabumi Selatan", "Abung Selatan", "Sungai Sungkai", "Bukit Kemuning"],
            "Kab. Mesuji": ["Mesuji", "Simpang Pematang", "Tanjung Raya", "Way Serdang"],
            "Kab. Pesawaran": ["Gedong Tataan", "Negeri Katon", "Tegineneng", "Way Lima", "Padang Cermin"],
            "Kab. Pesisir Barat": ["Krui", "Pesisir Tengah", "Pesisir Selatan", "Lemong", "Karya Penggawa"],
            "Kab. Pringsewu": ["Pringsewu", "Gading Rejo", "Ambarawa", "Pagelaran", "Sukoharjo"],
            "Kab. Tanggamus": ["Kota Agung", "Kota Agung Timur", "Talang Padang", "Gisting", "Wonosobo", "Pugung"],
            "Kab. Tulang Bawang": ["Menggala", "Banjar Agung", "Dente Teladas", "Gedung Aji"],
            "Kab. Tulang Bawang Barat": ["Tulang Bawang Tengah", "Tumijajar", "Tulang Bawang Udik"],
            "Kab. Way Kanan": ["Blambangan Umpu", "Baradatu", "Banjit", "Kasui", "Pakuan Ratu"]
        },
        "Maluku": {
            "Kota Ambon": ["Baguala", "Leitimur Selatan", "Nusaniwe", "Sirimau", "Teluk Ambon"],
            "Kota Tual": ["Dullah Selatan", "Dullah Utara", "Tayando Tam", "Kur Selatan", "Pulau-Pulau Kur"],
            "Kab. Buru": ["Namlea", "Waeapo", "Air Buaya", "Batabual", "Lolong Guba"],
            "Kab. Buru Selatan": ["Namrole", "Ambalau", "Kepala Madan", "Leksula", "Waesama"],
            "Kab. Kepulauan Aru": ["Dobo", "Pulau-Pulau Aru", "Aru Selatan", "Aru Tengah", "Aru Utara"],
            "Kab. Kepulauan Tanimbar": ["Saumlaki", "Tanimbar Selatan", "Tanimbar Utara", "Wertamrian", "Wuar Labobar"],
            "Kab. Maluku Barat Daya": ["Tiakur", "Moa Lakor", "Damer", "Letti", "Mdona Hiera"],
            "Kab. Maluku Tengah": ["Masohi", "Amahai", "Banda", "Leihitu", "Salahutu", "Tehoru"],
            "Kab. Maluku Tenggara": ["Langgur", "Kei Kecil", "Kei Besar", "Kei Besar Selatan", "Manyeuw"],
            "Kab. Seram Bagian Barat": ["Piru", "Seram Barat", "Kairatu", "Taniwel", "Huamual"],
            "Kab. Seram Bagian Timur": ["Bula", "Geser", "Kilmury", "Seram Timur", "Wakorumba"]
        },
        "Maluku Utara": {
            "Kota Ternate": ["Pulau Ternate", "Ternate Barat", "Ternate Selatan", "Ternate Tengah", "Ternate Utara", "Moti"],
            "Kota Tidore Kepulauan": ["Tidore", "Tidore Selatan", "Tidore Timur", "Tidore Utara", "Oba", "Oba Selatan"],
            "Kab. Halmahera Barat": ["Jailolo", "Jailolo Selatan", "Ibu", "Sahu", "Loloda"],
            "Kab. Halmahera Tengah": ["Weda", "Weda Selatan", "Weda Tengah", "Weda Utara", "Patani"],
            "Kab. Halmahera Timur": ["Maba", "Maba Selatan", "Maba Tengah", "Maba Utara", "Wasile"],
            "Kab. Halmahera Selatan": ["Labuha", "Bacan", "Bacan Selatan", "Gane Barat", "Obi"],
            "Kab. Halmahera Utara": ["Tobelo", "Tobelo Selatan", "Tobelo Utara", "Galela", "Malifut"],
            "Kab. Kepulauan Sula": ["Sanana", "Sanana Utara", "Sulabesi Barat", "Mangoli Timur"],
            "Kab. Pulau Morotai": ["Daruba", "Morotai Selatan", "Morotai Timur", "Morotai Utara"],
            "Kab. Pulau Taliabu": ["Bobong", "Taliabu Barat", "Taliabu Selatan", "Lede"]
        },
        "Nusa Tenggara Barat (NTB)": {
            "Kota Bima": ["Asakota", "Mpunda", "Raba", "Rasanae Barat", "Rasanae Timur"],
            "Kota Mataram": ["Ampenan", "Cakranegara", "Mataram", "Sandubaya", "Sekarbela", "Selaparang"],
            "Kab. Bima": ["Woha", "Bolo", "Madapangga", "Monta", "Sape", "Wawo", "Belo"],
            "Kab. Dompu": ["Dompu", "Woja", "Kempo", "Kilo", "Manggelewa", "Hu'u", "Pekat"],
            "Kab. Lombok Barat": ["Gerung", "Batu Layar", "Gunung Sari", "Kediri", "Kuripan", "Labuapi", "Lembar", "Narmada", "Sekotong"],
            "Kab. Lombok Tengah": ["Praya", "Batuklik", "Janapria", "Jonggat", "Kopang", "Praya Barat", "Praya Timur", "Pringgarata", "Pujut"],
            "Kab. Lombok Timur": ["Selong", "Aikmel", "Jerowaru", "Keruak", "Labuhan Haji", "Masbagik", "Pringgabaya", "Sikur", "Sukamulia"],
            "Kab. Lombok Utara": ["Tanjung", "Bayan", "Gangga", "Kayangan", "Pemenang"],
            "Kab. Sumbawa": ["Sumbawa", "Alas", "Batu Lanteh", "Empang", "Labuhan Badas", "Plampang", "Rhee", "Utan"],
            "Kab. Sumbawa Barat": ["Taliwang", "Brang Ene", "Brang Rea", "Jereweh", "Maluk", "Poto Tano", "Sekongkang", "Seteluk"]
        },
        "Nusa Tenggara Timur (NTT)": {
            "Kota Kupang": ["Alak", "Kelapa Lima", "Kota Raja", "Kota Lama", "Maulafa", "Oebobo"],
            "Kab. Alor": ["Kalabahi", "Alor Barat Daya", "Alor Barat Laut", "Alor Selatan", "Alor Timur", "Pantar"],
            "Kab. Belu": ["Atambua", "Atambua Barat", "Atambua Selatan", "Tasifeto Barat", "Tasifeto Timur"],
            "Kab. Ende": ["Ende", "Ende Selatan", "Ende Tengah", "Ende Timur", "Ende Utara", "Detusoko", "Maurole"],
            "Kab. Flores Timur": ["Larantuka", "Adonara Barat", "Adonara Timur", "Solor Barat", "Wulanggitang"],
            "Kab. Kupang": ["Oelamasi", "Kupang Barat", "Kupang Tengah", "Kupang Timur", "Amarasi", "Semau"],
            "Kab. Lembata": ["Lewoleba", "Nubatukan", "Atadei", "Buyasuri", "Omesuri"],
            "Kab. Malaka": ["Betun", "Malaka Barat", "Malaka Tengah", "Malaka Timur", "Wewiku"],
            "Kab. Manggarai": ["Ruteng", "Langke Rembong", "Cibal", "Reok", "Wae Rii"],
            "Kab. Manggarai Barat": ["Labuan Bajo", "Komodo", "Boleng", "Lembor", "Kuwus", "Sanonggoang"],
            "Kab. Manggarai Timur": ["Borong", "Kota Komba", "Lamba Leda", "Poco Ranaka", "Sambi Rampas"],
            "Kab. Nagekeo": ["Mbay", "Aesesa", "Boawae", "Mauponggo", "Wolowae"],
            "Kab. Ngada": ["Bajawa", "Aimere", "Golewa", "Jerebuu", "Soa"],
            "Kab. Rote Ndao": ["Baa", "Lobalain", "Rote Barat", "Rote Tengah", "Rote Timur"],
            "Kab. Sabu Raijua": ["Sabu Barat", "Sabu Tengah", "Sabu Timur", "Raijua"],
            "Kab. Sikka": ["Maumere", "Alok", "Alok Barat", "Alok Timur", "Kewapante", "Nita"],
            "Kab. Sumba Barat": ["Waikabubak", "Kota Waikabubak", "Loli", "Wanokaka", "Lamboya"],
            "Kab. Sumba Barat Daya": ["Tambolaka", "Kota Tambolaka", "Kodi", "Wewewa Barat", "Wewewa Timur"],
            "Kab. Sumba Tengah": ["Waibakul", "Katikutana", "Mamboro", "Umbu Ratu Nggay"],
            "Kab. Sumba Timur": ["Waingapu", "Kota Waingapu", "Kambera", "Pandawai", "Rindi", "Lewa"],
            "Kab. Timor Tengah Selatan": ["Soe", "Kota Soe", "Amanuban Barat", "Amanatun Selatan", "Mollo Utara"],
            "Kab. Timor Tengah Utara": ["Kefamenanu", "Kota Kefamenanu", "Biboki Anleu", "Insana", "Miomaffo Barat"]
        },
        "Papua": {
            "Kota Jayapura": ["Abepura", "Heram", "Jayapura Selatan", "Jayapura Utara", "Muara Tami"],
            "Kab. Biak Numfor": ["Biak Kota", "Samofa", "Biak Barat", "Biak Timur", "Numfor Timur"],
            "Kab. Jayapura": ["Sentani", "Sentani Barat", "Sentani Timur", "Depapre", "Kemtuk", "Nimboran"],
            "Kab. Keerom": ["Waris", "Arso", "Arso Timur", "Skanto", "Senggi"],
            "Kab. Kepulauan Yapen": ["Serui", "Yapen Selatan", "Yapen Barat", "Yapen Timur", "Angkaisera"],
            "Kab. Mamberamo Raya": ["Burmeso", "Mamberamo Tengah", "Mamberamo Hilir", "Rufaer"],
            "Kab. Sarmi": ["Sarmi", "Sarmi Selatan", "Sarmi Timur", "Pantai Barat", "Tor Atas"],
            "Kab. Supiori": ["Sorendiweri", "Supiori Barat", "Supiori Selatan", "Supiori Timur", "Supiori Utara"],
            "Kab. Waropen": ["Oudate", "Waropen Bawah", "Masirei", "Risei Sayati"]
        },
        "Papua Barat": {
            "Kab. Fakfak": ["Fakfak", "Fakfak Barat", "Fakfak Tengah", "Fakfak Timur", "Kokas", "Karas"],
            "Kab. Kaimana": ["Kaimana", "Buruway", "Kambrauw", "Teluk Arguni", "Teluk Etna"],
            "Kab. Manokwari": ["Manokwari Barat", "Manokwari Selatan", "Manokwari Timur", "Manokwari Utara", "Prafi", "Warmare"],
            "Kab. Manokwari Selatan": ["Ransiki", "Momi Waren", "Neney", "Tahota", "Isim"],
            "Kab. Pegunungan Arfak": ["Anggi", "Anggi Gida", "Catubouw", "Hingk", "Membey", "Taige"],
            "Kab. Teluk Bintuni": ["Bintuni", "Aranday", "Babo", "Fafurwar", "Merdey"],
            "Kab. Teluk Wondama": ["Rasiei", "Wasior", "Roon", "Roswar", "Windesi"]
        },
        "Papua Barat Daya": {
            "Kota Sorong": ["Klaurung", "Malaimsimsa", "Maladum Mes", "Sorong", "Sorong Barat", "Sorong Kepulauan", "Sorong Kota", "Sorong Manoi", "Sorong Timur", "Sorong Utara"],
            "Kab. Maybrat": ["Kumurkek", "Aitinyo", "Aifat", "Ayamaru", "Ayamaru Timur"],
            "Kab. Raja Ampat": ["Waisai", "Kota Waisai", "Misool", "Salawati", "Waigeo Barat", "Waigeo Timur"],
            "Kab. Sorong": ["Aimas", "Salawati", "Mariat", "Mayamuk", "Klamono", "Beraur"],
            "Kab. Sorong Selatan": ["Teminabuan", "Inanwatan", "Moswaren", "Sawiat", "Seremuk"],
            "Kab. Tambrauw": ["Fef", "Miyah", "Moraid", "Sausapor", "Yembun"]
        },
        "Papua Pegunungan": {
            "Kab. Jayawijaya": ["Wamena", "Hubikiak", "Hubikosi", "Pelebaga", "Asologaima", "Kurulu"],
            "Kab. Lanny Jaya": ["Tiom", "Pirime", "Makki", "Gamelia", "Balingga"],
            "Kab. Mamberamo Tengah": ["Kobakma", "Kelila", "Eragayam", "Ilugwa", "Megambilis"],
            "Kab. Nduga": ["Kenyam", "Mapenduma", "Yigi", "Geselma", "Kora"],
            "Kab. Pegunungan Bintang": ["Oksibil", "Batom", "Kiwirok", "Okbibab", "Pepera"],
            "Kab. Tolikara": ["Karubaga", "Bokondini", "Kanggime", "Kubu", "Nabunage"],
            "Kab. Yahukimo": ["Dekai", "Kurima", "Angguruk", "Ninia", "Soba"],
            "Kab. Yalimo": ["Elelim", "Apalapsili", "Abalok", "Benawa", "Welarek"]
        },
        "Papua Selatan": {
            "Kab. Asmat": ["Agats", "Atsj", "Fayit", "Pantai Kasuari", "Sawa Erma", "Suru-Suru"],
            "Kab. Boven Digoel": ["Tanah Merah", "Mandobo", "Mindiptana", "Waropko", "Jair"],
            "Kab. Mappi": ["Kepi", "Obaa", "Assue", "Edera", "Mambioman Hay"],
            "Kab. Merauke": ["Merauke", "Muting", "Okaba", "Sota", "Kurik", "Semangga", "Tanah Miring"]
        },
        "Papua Tengah": {
            "Kab. Deiyai": ["Tigi", "Tigi Barat", "Tigi Timur", "Bowobado", "Kapiraya"],
            "Kab. Dogiyai": ["Kigamani", "Kamu", "Kamu Selatan", "Kamu Utara", "Mapia"],
            "Kab. Intan Jaya": ["Sugapa", "Agisiga", "Hitadipa", "Homeyo", "Wandai"],
            "Kab. Mimika": ["Timika", "Mimika Baru", "Kuala Kencana", "Tembagapura", "Agimuga", "Jila"],
            "Kab. Nabire": ["Nabire", "Nabire Barat", "Teluk Kimi", "Wanggar", "Yaur", "Uwapa"],
            "Kab. Paniai": ["Enarotali", "Paniai Timur", "Paniai Barat", "Bibida", "Aradide"],
            "Kab. Puncak": ["Ilaga", "Beoga", "Sinak", "Wangbe", "Pogoma"],
            "Kab. Puncak Jaya": ["Mulia", "Fawi", "Ilu", "Mewoluk", "Yamo"]
        },
        "Riau": {
            "Kota Dumai": ["Dumai Barat", "Dumai Kota", "Dumai Selatan", "Dumai Timur", "Bukit Kapur", "Medang Kampai", "Sungai Sembilan"],
            "Kota Pekanbaru": ["Bukit Raya", "Lima Puluh", "Marpoyan Damai", "Payung Sekaki", "Pekanbaru Kota", "Rumbai", "Rumbai Barat", "Rumbai Timur", "Sail", "Senapelan", "Sukajadi", "Tuah Madani", "Tenayan Raya"],
            "Kab. Bengkalis": ["Bengkalis", "Bantan", "Mandau", "Pinggir", "Bukit Batu", "Siak Kecil", "Rupat"],
            "Kab. Indragiri Hilir": ["Tembilahan", "Tembilahan Hulu", "Enok", "Kateman", "Kuala Indragiri", "Reteh"],
            "Kab. Indragiri Hulu": ["Rengat", "Rengat Barat", "Pasir Penyu", "Seberida", "Peranap"],
            "Kab. Kampar": ["Bangkinang Kota", "Bangkinang", "Kampar", "Kampar Kiri", "Siak Hulu", "Tambang", "Tapung"],
            "Kab. Kepulauan Meranti": ["Selatpanjang", "Tebing Tinggi", "Rangsang", "Merbau", "Tasik Putri Puyu"],
            "Kab. Kuantan Singingi": ["Teluk Kuantan", "Kuantan Tengah", "Kuantan Mudik", "Singingi", "Cerenti"],
            "Kab. Pelalawan": ["Pangkalan Kerinci", "Pelalawan", "Ukui", "Langgam", "Kuala Kampar"],
            "Kab. Rokan Hilir": ["Bagansiapiapi", "Bangko", "Bagan Sinembah", "Pujud", "Tanah Putih"],
            "Kab. Rokan Hulu": ["Pasir Pengaraian", "Rambah", "Ujung Batu", "Tambusai", "Tandun"],
            "Kab. Siak": ["Siak", "Siak Sri Indrapura", "Kandis", "Minas", "Tualang", "Sungai Apit"]
        },
        "Sulawesi Barat": {
            "Kab. Majene": ["Banggae", "Banggae Timur", "Pamboang", "Sendana", "Malunda", "Ulumanda"],
            "Kab. Mamasa": ["Mamasa", "Mambi", "Sumarorong", "Tanduk Kalua", "Pana", "Tabang"],
            "Kab. Mamuju": ["Mamuju", "Simboro", "Kalukku", "Tapalang", "Tommo", "Papalang"],
            "Kab. Mamuju Tengah": ["Tobadak", "Topoyo", "Budong-Budong", "Pangale", "Karossa"],
            "Kab. Pasangkayu": ["Pasangkayu", "Bambalamotu", "Baras", "Sarudu", "Tikke Raya"],
            "Kab. Polewali Mandar": ["Polewali", "Wonomulyo", "Campalagian", "Tinambung", "Binuang", "Luyo"]
        },
        "Sulawesi Selatan": {
            "Kota Makassar": ["Biringkanaya", "Bontoala", "Makassar", "Mamajang", "Manggala", "Mariso", "Panakkukang", "Rappocini", "Tallo", "Tamalanrea", "Tamalate", "Ujung Pandang", "Ujung Tanah", "Wajo"],
            "Kota Palopo": ["Bara", "Mungkajang", "Sendana", "Tellu Wanua", "Wara", "Wara Barat", "Wara Selatan", "Wara Timur", "Wara Utara"],
            "Kota Parepare": ["Bacukiki", "Bacukiki Barat", "Soreang", "Ujung"],
            "Kab. Bantaeng": ["Bantaeng", "Bissappu", "Eremerasa", "Pajukukang", "Tompobulu"],
            "Kab. Barru": ["Barru", "Balusu", "Mallusetasi", "Soppeng Riaja", "Tanete Rilau"],
            "Kab. Bone": ["Watampone", "Tanete Riattang", "Tanete Riattang Barat", "Tanete Riattang Timur", "Awangpone", "Barebbo"],
            "Kab. Bulukumba": ["Ujung Bulu", "Gantarang", "Bonto Bahari", "Bulukumpa", "Kajang"],
            "Kab. Enrekang": ["Enrekang", "Alla", "Anggeraja", "Baraka", "Maiwa"],
            "Kab. Gowa": ["Sungguminasa", "Somba Opu", "Pallangga", "Bajeng", "Barombong", "Tinggimoncong", "Parangloe"],
            "Kab. Jeneponto": ["Binamu", "Bontoramba", "Kelara", "Tamalatea", "Tarowang"],
            "Kab. Kepulauan Selayar": ["Benteng", "Bontoharu", "Bontomanai", "Pasimarannu", "Takabonerate"],
            "Kab. Luwu": ["Belopa", "Belopa Utara", "Bua", "Larompong", "Ponrang", "Walenrang"],
            "Kab. Luwu Timur": ["Malili", "Nuha", "Sorowako", "Tomoni", "Wotu"],
            "Kab. Luwu Utara": ["Masamba", "Baebunta", "Bone-Bone", "Sabbang", "Sukamaju"],
            "Kab. Maros": ["Turikale", "Bantimurung", "Camba", "Mandai", "Maros Baru", "Tanralili"],
            "Kab. Pangkajene dan Kepulauan": ["Pangkajene", "Balocci", "Bungoro", "Labakkang", "Minasatene", "Segeri"],
            "Kab. Pinrang": ["Watang Sawitto", "Duampanua", "Mattiro Bulu", "Patampanua", "Suppa"],
            "Kab. Sidenreng Rappang": ["Pangkajene Sidenreng", "Baranti", "Dua Pitue", "Maritengngae", "Watang Pulu"],
            "Kab. Sinjai": ["Sinjai Utara", "Sinjai Barat", "Sinjai Borong", "Sinjai Selatan", "Sinjai Timur"],
            "Kab. Soppeng": ["Watansoppeng", "Lalabata", "Donri Donri", "Lilirilau", "Marioriawa"],
            "Kab. Takalar": ["Pattallassang", "Galesong", "Galesong Selatan", "Galesong Utara", "Mangarabombang", "Polombangkeng Selatan"],
            "Kab. Tana Toraja": ["Makale", "Makale Selatan", "Makale Utara", "Mengkendek", "Sangalla"],
            "Kab. Toraja Utara": ["Rantepao", "Kesu", "Sanggalangi", "Tallunglipu", "Tikala"],
            "Kab. Wajo": ["Sengkang", "Tempe", "Bola", "Majauleng", "Maniangpajo", "Pitumpanua", "Tanasitolo"]
        },
        "Sulawesi Tengah": {
            "Kota Palu": ["Mantikulore", "Palu Barat", "Palu Selatan", "Palu Timur", "Palu Utara", "Tatanga", "Tawaeli", "Ulujadi"],
            "Kab. Banggai": ["Luwuk", "Luwuk Selatan", "Luwuk Utara", "Batui", "Kintom", "Bualemo", "Toili"],
            "Kab. Banggai Kepulauan": ["Salakan", "Tinangkung", "Buko", "Bulagi", "Totikum"],
            "Kab. Banggai Laut": ["Banggai", "Banggai Selatan", "Banggai Tengah", "Banggai Utara", "Bokan Kepulauan"],
            "Kab. Buol": ["Biau", "Bokat", "Bunobogu", "Lakea", "Momunu"],
            "Kab. Donggala": ["Banawa", "Banawa Selatan", "Banawa Tengah", "Dampelas", "Labuan", "Sindue", "Sirenja"],
            "Kab. Morowali": ["Bungku Tengah", "Bahodopi", "Bungku Barat", "Bungku Pesisir", "Bungku Timur"],
            "Kab. Morowali Utara": ["Kolonodale", "Petasia", "Lembo", "Mori Atas", "Mori Utara", "Soyo Jaya"],
            "Kab. Parigi Moutong": ["Parigi", "Ampibabo", "Kasimbar", "Moutong", "Tinombo", "Tomini"],
            "Kab. Poso": ["Poso Kota", "Poso Kota Selatan", "Poso Kota Utara", "Lage", "Pamona Puselemba", "Lore Utara"],
            "Kab. Sigi": ["Sigi Biromaru", "Dolo", "Dolo Selatan", "Kulawi", "Marawola", "Palolo"],
            "Kab. Tojo Una-Una": ["Ampana Kota", "Ampana Tete", "Una-Una", "Ulu Bongka", "Walea Kepulauan"],
            "Kab. Tolitoli": ["Baolan", "Dampal Selatan", "Dampal Utara", "Dondo", "Galang", "Tolitoli Utara"]
        },
        "Sulawesi Tenggara": {
            "Kota Bau-Bau": ["Betoambari", "Kadia", "Kapoala", "Murhum", "Sorawolio", "Wolio"],
            "Kota Kendari": ["Baruga", "Kadia", "Kambu", "Kendari", "Kendari Barat", "Mandonga", "Poasia", "Puuwatu", "Wua-Wua"],
            "Kab. Bombana": ["Rumbia", "Poleang", "Poleang Timur", "Kabaena", "Rumbia Tengah"],
            "Kab. Buton": ["Pasarwajo", "Kapontori", "Lasalimu", "Siotapina", "Wabula"],
            "Kab. Buton Selatan": ["Batauga", "Batu Atas", "Kadatua", "Sampolawa", "Siompu"],
            "Kab. Buton Tengah": ["Labungkari", "Gu", "Mawasangka", "Sangia Wambulu", "Talaga Raya"],
            "Kab. Buton Utara": ["Buranga", "Kulisusu", "Kulisusu Barat", "Kulisusu Utara", "Wakorumba Utara"],
            "Kab. Kolaka": ["Kolaka", "Latambaga", "Pomalaa", "Wundulako", "Watubangga"],
            "Kab. Kolaka Timur": ["Tirawuta", "Ladongi", "Loea", "Mowewe", "Poli Polia"],
            "Kab. Kolaka Utara": ["Lasusua", "Batu Putih", "Kodeoha", "Ngapa", "Pakue"],
            "Kab. Konawe": ["Unaaha", "Abuki", "Asera", "Lambuya", "Sampara", "Wawotobi"],
            "Kab. Konawe Kepulauan": ["Langara", "Wawonii Barat", "Wawonii Selatan", "Wawonii Tengah", "Wawonii Timur"],
            "Kab. Konawe Selatan": ["Andoolo", "Batu Putih", "Konda", "Moramo", "Ranomeeto"],
            "Kab. Konawe Utara": ["Wanggudu", "Asera", "Lasolo", "Molawe", "Oheo"],
            "Kab. Muna": ["Raha", "Katobu", "Batalaiworu", "Duruka", "Lohia", "Napabalano"],
            "Kab. Muna Barat": ["Laworo", "Kusambi", "Lawa", "Sawerigadi", "Tiworo Kepulauan"],
            "Kab. Wakatobi": ["Wangi-Wangi", "Wangi-Wangi Selatan", "Kaledupa", "Tomia", "Binongko"]
        },
        "Sulawesi Utara": {
            "Kota Bitung": ["Aertembaga", "Girian", "Lembeh Selatan", "Lembeh Utara", "Madidir", "Maesa", "Matuari", "Ranowulu"],
            "Kota Kotamobagu": ["Kotamobagu Barat", "Kotamobagu Selatan", "Kotamobagu Timur", "Kotamobagu Utara"],
            "Kota Manado": ["Bunaken", "Malalayang", "Mapanget", "Paal Dua", "Sario", "Singkil", "Tikala", "Tuminting", "Wanea", "Wenang"],
            "Kota Tomohon": ["Tomohon Barat", "Tomohon Selatan", "Tomohon Tengah", "Tomohon Timur", "Tomohon Utara"],
            "Kab. Bolaang Mongondow": ["Lolayan", "Lolak", "Bolaang", "Dumoga", "Poigar", "Sangtombolang"],
            "Kab. Bolaang Mongondow Selatan": ["Bolaang Uki", "Helumo", "Posigadan", "Pinolosian"],
            "Kab. Bolaang Mongondow Timur": ["Tutuyan", "Kotabunan", "Modayag", "Nuangan"],
            "Kab. Bolaang Mongondow Utara": ["Boroko", "Kaidipang", "Bintauna", "Bolangitang Barat"],
            "Kab. Kepulauan Sangihe": ["Tahuna", "Tahuna Barat", "Tahuna Timur", "Manganitu", "Tabukan Utara"],
            "Kab. Kepulauan Siau Tagulandang Biaro": ["Ondong Siau", "Siau Barat", "Siau Timur", "Tagulandang", "Biaro"],
            "Kab. Kepulauan Talaud": ["Melonguane", "Beo", "Rainis", "Essang", "Kabaruan", "Lirung"],
            "Kab. Minahasa": ["Tondano Barat", "Tondano Selatan", "Tondano Timur", "Tondano Utara", "Kakas", "Langowan", "Pineleng", "Tombariri"],
            "Kab. Minahasa Selatan": ["Amurang", "Amurang Barat", "Amurang Timur", "Modoinding", "Tenga", "Tumpaan"],
            "Kab. Minahasa Tenggara": ["Ratahan", "Belang", "Pusomaen", "Tombatu", "Touluaan"],
            "Kab. Minahasa Utara": ["Airmadidi", "Kalawat", "Kauditan", "Kema", "Likupang Selatan", "Likupang Timur"]
        },
        "Sumatera Barat": {
            "Kota Bukittinggi": ["Aur Birugo Tigo Baleh", "Guguk Panjang", "Mandiangin Koto Selayan"],
            "Kota Padang": ["Bungus Teluk Kabung", "Koto Tangah", "Kuranji", "Lubuk Begalung", "Lubuk Kilangan", "Nanggalo", "Padang Barat", "Padang Selatan", "Padang Timur", "Padang Utara", "Pauh"],
            "Kota Padang Panjang": ["Padang Panjang Barat", "Padang Panjang Timur"],
            "Kota Pariaman": ["Pariaman Selatan", "Pariaman Tengah", "Pariaman Timur", "Pariaman Utara"],
            "Kota Payakumbuh": ["Lamposi Tigo Nagori", "Payakumbuh Barat", "Payakumbuh Selatan", "Payakumbuh Timur", "Payakumbuh Utara"],
            "Kota Sawahlunto": ["Barangin", "Lembah Segar", "Silungkang", "Talawi"],
            "Kota Solok": ["Lubuk Sikarah", "Tanjung Harapan"],
            "Kab. Agam": ["Lubuk Basung", "Banuhampu", "Candung", "IV Koto", "Kamang Magek", "Matur", "Sungai Pua", "Tilatang Kamang"],
            "Kab. Dharmasraya": ["Pulau Punjung", "Koto Baru", "Sitiung", "Sungai Rumbai"],
            "Kab. Kepulauan Mentawai": ["Tuapejat", "Sipora Selatan", "Sipora Utara", "Siberut Selatan", "Siberut Utara"],
            "Kab. Lima Puluh Kota": ["Sarilamak", "Harau", "Guguak", "Payakumbuh", "Pangkalan Koto Baru", "Suliki"],
            "Kab. Padang Pariaman": ["Parit Malintang", "Batang Anai", "Lubuk Alung", "Nan Sabaris", "2x11 Enam Lingkung"],
            "Kab. Pasaman": ["Lubuk Sikaping", "Bonjol", "Panti", "Rao", "Mapat Tunggul"],
            "Kab. Pasaman Barat": ["Simpang Empat", "Pasaman", "Kinali", "Lembah Melintang", "Sungai Beremas"],
            "Kab. Pesisir Selatan": ["Painan", "IV Jurai", "Batang Kapas", "Bayang", "Lengayang", "Ranah Pesisir"],
            "Kab. Sijunjung": ["Muaro Sijunjung", "Sijunjung", "IV Nagari", "Kamang Baru", "Tanjung Gadang"],
            "Kab. Solok": ["Arosuka", "Gunung Talang", "Bukit Sundi", "Kubung", "Lembah Gumanti", "X Koto Singkarak"],
            "Kab. Solok Selatan": ["Padang Aro", "Sangir", "Koto Parik Gadang Diateh", "Sungai Pagu"],
            "Kab. Tanah Datar": ["Batusangkar", "Lima Kaum", "Pariangan", "Rambatan", "Sungayang", "X Koto"]
        },
        "Sumatera Selatan": {
            "Kota Lubuklinggau": ["Lubuklinggau Barat I", "Lubuklinggau Barat II", "Lubuklinggau Selatan I", "Lubuklinggau Selatan II", "Lubuklinggau Timur I", "Lubuklinggau Timur II", "Lubuklinggau Utara I", "Lubuklinggau Utara II"],
            "Kota Pagar Alam": ["Dempo Selatan", "Dempo Tengah", "Dempo Utara", "Pagar Alam Selatan", "Pagar Alam Utara"],
            "Kota Palembang": ["Alang-Alang Lebar", "Bukit Kecil", "Gandus", "Ilir Barat I", "Ilir Barat II", "Ilir Timur I", "Ilir Timur II", "Ilir Timur III", "Jakabaring", "Kalidoni", "Kemuning", "Kertapati", "Plaju", "Sako", "Seberang Ulu I", "Seberang Ulu II", "Sematang Borang", "Sukarami"],
            "Kota Prabumulih": ["Cambai", "Prabumulih Barat", "Prabumulih Selatan", "Prabumulih Timur", "Prabumulih Utara", "Rambang Kapak Tengah"],
            "Kab. Banyuasin": ["Pangkalan Balai", "Banyuasin I", "Banyuasin II", "Banyuasin III", "Betung", "Talang Kelapa", "Tanjung Lago"],
            "Kab. Empat Lawang": ["Tebing Tinggi", "Muara Pinang", "Pendopo", "Ulu Musi"],
            "Kab. Lahat": ["Lahat", "Jarai", "Kikim Barat", "Kikim Timur", "Kota Agung", "Merapi Barat"],
            "Kab. Muara Enim": ["Muara Enim", "Lawang Kidul", "Gelumbang", "Tanjung Agung", "Ujan Mas"],
            "Kab. Musi Banyuasin": ["Sekayu", "Babat Toman", "Bayung Lencir", "Sungai Lilin", "Lais"],
            "Kab. Musi Rawas": ["Muara Beliti", "Tugumulyo", "Megang Sakti", "Jayaloka", "STL Ulu Terawas"],
            "Kab. Musi Rawas Utara": ["Rupit", "Rawas Ilir", "Rawas Ulu", "Nibung"],
            "Kab. Ogan Ilir": ["Indralaya", "Indralaya Selatan", "Indralaya Utara", "Pemulutan", "Tanjung Batu", "Tanjung Raja"],
            "Kab. Ogan Komering Ilir": ["Kayu Agung", "Kota Kayu Agung", "Lempuing", "Mesuji", "Pedamaran", "Sirah Pulau Padang"],
            "Kab. Ogan Komering Ulu": ["Baturaja Barat", "Baturaja Timur", "Lubuk Batang", "Sosoh Buay Rayap", "Ulu Ogan"],
            "Kab. Ogan Komering Ulu Selatan": ["Muaradua", "Banding Agung", "Buay Pemaca", "Simpang"],
            "Kab. Ogan Komering Ulu Timur": ["Martapura", "Belitang", "Belitang Madang Raya", "Cempaka", "Madang Suku I"],
            "Kab. Penukal Abab Lematang Ilir": ["Talang Ubi", "Abab", "Penukal", "Penukal Utara", "Tanah Abang"]
        },
        "Sumatera Utara": {
            "Kota Binjai": ["Binjai Barat", "Binjai Kota", "Binjai Selatan", "Binjai Timur", "Binjai Utara"],
            "Kota Gunungsitoli": ["Gunungsitoli", "Gunungsitoli Barat", "Gunungsitoli Idanoi", "Gunungsitoli Selatan", "Gunungsitoli Utara"],
            "Kota Medan": ["Medan Amplas", "Medan Area", "Medan Barat", "Medan Baru", "Medan Belawan", "Medan Deli", "Medan Denai", "Medan Helvetia", "Medan Johor", "Medan Kota", "Medan Labuhan", "Medan Maimun", "Medan Marelan", "Medan Perjuangan", "Medan Petisah", "Medan Polonia", "Medan Selayang", "Medan Sunggal", "Medan Tembung", "Medan Timur", "Medan Tuntungan"],
            "Kota Padang Sidempuan": ["Padang Sidempuan Batunadua", "Padang Sidempuan Hutaimbaru", "Padang Sidempuan Selatan", "Padang Sidempuan Tenggara", "Padang Sidempuan Utara"],
            "Kota Pematangsiantar": ["Siantar Barat", "Siantar Marihat", "Siantar Marimbun", "Siantar Martoba", "Siantar Selatan", "Siantar Sitalasari", "Siantar Timur", "Siantar Utara"],
            "Kota Sibolga": ["Sibolga Kota", "Sibolga Sambas", "Sibolga Selatan", "Sibolga Utara"],
            "Kota Tanjungbalai": ["Datuk Bandar", "Datuk Bandar Timur", "Sei Tualang Raso", "Tanjungbalai Selatan", "Tanjungbalai Utara", "Teluk Nibung"],
            "Kota Tebing Tinggi": ["Bajenis", "Padang Hilir", "Padang Hulu", "Rambutan", "Tebing Tinggi Kota"],
            "Kab. Asahan": ["Kisaran Barat", "Kisaran Timur", "Air Joman", "Buntu Pane", "Meranti", "Simpang Empat"],
            "Kab. Batu Bara": ["Lima Puluh", "Air Putih", "Medang Deras", "Sei Balai", "Talawi", "Tanjung Tiram"],
            "Kab. Dairi": ["Sidikalang", "Berampu", "Parbuluan", "Siempat Nempu", "Sumbul"],
            "Kab. Deli Serdang": ["Lubuk Pakam", "Batang Kuis", "Beringin", "Deli Tua", "Galang", "Hamparan Perak", "Pancur Batu", "Percut Sei Tuan", "Sunggal", "Tanjung Morawa"],
            "Kab. Humbang Hasundutan": ["Dolok Sanggul", "Lintong Nihuta", "Onan Ganjang", "Pakkat", "Pollung"],
            "Kab. Karo": ["Kabanjahe", "Barusjahe", "Berastagi", "Merek", "Simpang Empat", "Tigapanah"],
            "Kab. Labuhanbatu": ["Rantau Prapat", "Rantau Utara", "Rantau Selatan", "Bilah Barat", "Bilah Hilir"],
            "Kab. Labuhanbatu Selatan": ["Kota Pinang", "Kampung Rakyat", "Sungai Kanan", "Torgamba"],
            "Kab. Labuhanbatu Utara": ["Aek Kanopan", "Kualuh Hilir", "Kualuh Hulu", "Kualuh Leidong", "Marbau"],
            "Kab. Langkat": ["Stabat", "Babalan", "Besitang", "Binjai", "Kuala", "Pangkalan Susu", "Secanggang", "Tanjung Pura"],
            "Kab. Mandailing Natal": ["Panyabungan", "Kotanopan", "Muara Sipongi", "Natal", "Siabu"],
            "Kab. Nias": ["Gido", "Bawolato", "Hiliduho", "Idanogawo", "Somolo-molo"],
            "Kab. Nias Barat": ["Lahomi", "Mandrehe", "Mandrehe Barat", "Mandrehe Utara", "Sirombu"],
            "Kab. Nias Selatan": ["Teluk Dalam", "Amandraya", "Gomo", "Lahusa", "Lolowau", "Pulau-Pulau Batu"],
            "Kab. Nias Utara": ["Lotu", "Alasa", "Afulu", "Lahewa", "Tuhemberua"],
            "Kab. Padang Lawas": ["Sibuhuan", "Barumun", "Barumun Selatan", "Huristak", "Sosa"],
            "Kab. Padang Lawas Utara": ["Gunung Tua", "Padang Bolak", "Dolok", "Halongonan", "Portibi"],
            "Kab. Pakpak Bharat": ["Salak", "Kerajaan", "Pagindar", "Siempat Rube", "Tinada"],
            "Kab. Samosir": ["Pangururan", "Harian", "Palipi", "Simanindo", "Sianjur Mula Mula"],
            "Kab. Serdang Bedagai": ["Sei Rampah", "Dolok Masihul", "Perbaungan", "Pantai Cermin", "Tebing Tinggi"],
            "Kab. Simalungun": ["Raya", "Bandar", "Bosar Maligas", "Girsang Sipangan Bolon", "Siantar", "Tanah Jawa"],
            "Kab. Tapanuli Selatan": ["Sipirok", "Batang Angkola", "Batang Toru", "Marancar", "Sayur Matinggi"],
            "Kab. Tapanuli Tengah": ["Pandan", "Barus", "Kolang", "Manduamas", "Sorkam", "Tapian Nauli"],
            "Kab. Tapanuli Utara": ["Tarutung", "Adian Koting", "Pahae Jae", "Pahae Julu", "Siborong-Borong", "Sipoholon"],
            "Kab. Toba": ["Balige", "Laguboti", "Porsea", "Silaen", "Sigumpar"]
        }
    };

    const prefix = "{{ $idPrefix }}";
    const provSelect = document.getElementById(prefix + '_provinsi');
    const kotaSelect = document.getElementById(prefix + '_kota');
    const kecSelect = document.getElementById(prefix + '_kecamatan');
    const kelSelect = document.getElementById(prefix + '_kelurahan');
    const pkFinal = document.getElementById(prefix + '_provinsi_kota_final');
    const rtInput = document.getElementById(prefix + '_rt');
    const rwInput = document.getElementById(prefix + '_rw');

    // Filter angka RT / RW
    [rtInput, rwInput].forEach(inp => {
        if (!inp) return;
        inp.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').slice(0, 5);
        });
    });

    if (!provSelect) return;

    // Helper sinkronisasi input string gabungan provinsi_kota
    function syncCombinedProvinsiKota() {
        const p = (provSelect.value || '').trim();
        const k = (kotaSelect.value || '').trim();
        if (p && k) {
            pkFinal.value = `${p}, ${k}`;
        } else if (k) {
            pkFinal.value = k;
        } else if (p) {
            pkFinal.value = p;
        } else {
            pkFinal.value = '';
        }
    }

    // Inisialisasi Opsi Provinsi: 1 List Murni Tanpa Optgroup / Pemisah
    function initProvinsiOptions() {
        provSelect.innerHTML = '<option value="">-- Pilih Provinsi --</option>';
        const listProv = Object.keys(databaseWilayah).sort();
        listProv.forEach(prov => {
            const opt = document.createElement('option');
            opt.value = prov;
            opt.textContent = prov;
            provSelect.appendChild(opt);
        });
    }

    initProvinsiOptions();

    // Nilai awal dari Blade
    const initialProv = ("{{ $initProvinsi }}").trim();
    const initialKota = ("{{ $initKota }}").trim();
    const initialKec = ("{{ old('kecamatan', $kecamatan) }}").trim();
    const initialKel = ("{{ old('kelurahan', $kelurahan) }}").trim();

    // Fungsi seleksi awal saat halaman dimuat
    function setInitialValues() {
        if (!initialProv) {
            if (initialKel) {
                selectKelurahanValue(initialKel);
            }
            return;
        }

        for (let i = 0; i < provSelect.options.length; i++) {
            const val = provSelect.options[i].value;
            if (val && (val.toLowerCase() === initialProv.toLowerCase() || 
                (initialProv.toLowerCase().includes('jawa tengah') && val === 'Jawa Tengah'))) {
                provSelect.selectedIndex = i;
                break;
            }
        }

        onProvinsiChange(false);
    }

    // Handler ketika Provinsi berubah
    function onProvinsiChange(isUserEvent = true) {
        const provVal = provSelect.value;
        syncCombinedProvinsiKota();

        // Reset Kota, Kecamatan, Kelurahan
        kotaSelect.innerHTML = '<option value="">-- Pilih Kota / Kabupaten --</option>';
        kecSelect.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
        kelSelect.innerHTML = '<option value="">-- Pilih Kelurahan / Desa --</option>';

        if (provVal && databaseWilayah[provVal]) {
            const kotaData = databaseWilayah[provVal];
            const kotaNames = Array.isArray(kotaData) ? kotaData : Object.keys(kotaData);
            kotaNames.sort().forEach(k => {
                const opt = document.createElement('option');
                opt.value = k;
                opt.textContent = k;
                kotaSelect.appendChild(opt);
            });

            if (!isUserEvent && initialKota) {
                for (let i = 0; i < kotaSelect.options.length; i++) {
                    const optVal = kotaSelect.options[i].value;
                    if (optVal && (optVal.toLowerCase() === initialKota.toLowerCase() || 
                        (initialKota.toLowerCase().includes('kudus') && optVal.includes('Kudus')))) {
                        kotaSelect.selectedIndex = i;
                        break;
                    }
                }
                onKotaChange(false);
            }
        }
    }

    // Handler ketika Kota / Kabupaten berubah
    function onKotaChange(isUserEvent = true) {
        const provVal = provSelect.value;
        const kotaVal = kotaSelect.value;
        syncCombinedProvinsiKota();

        kecSelect.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
        kelSelect.innerHTML = '<option value="">-- Pilih Kelurahan / Desa --</option>';

        if (provVal && databaseWilayah[provVal] && databaseWilayah[provVal][kotaVal]) {
            const kecData = databaseWilayah[provVal][kotaVal];
            const kecNames = Array.isArray(kecData) ? kecData : Object.keys(kecData);
            kecNames.sort().forEach(kec => {
                const opt = document.createElement('option');
                opt.value = kec;
                opt.textContent = kec;
                kecSelect.appendChild(opt);
            });

            if (!isUserEvent && initialKec) {
                for (let i = 0; i < kecSelect.options.length; i++) {
                    if (kecSelect.options[i].value.toLowerCase() === initialKec.toLowerCase()) {
                        kecSelect.selectedIndex = i;
                        break;
                    }
                }
                onKecamatanChange(false, initialKel);
            }
        }
    }

    let currentKelurahanAbortController = null;

    // Helper untuk memilih kelurahan secara akurat
    function selectKelurahanValue(targetVal) {
        if (!targetVal) return;
        const cleanTarget = targetVal.toLowerCase().trim();
        for (let i = 0; i < kelSelect.options.length; i++) {
            const optVal = kelSelect.options[i].value;
            if (optVal && optVal.toLowerCase().trim() === cleanTarget) {
                kelSelect.selectedIndex = i;
                return;
            }
        }
        // Jika tidak ada di daftar opsi yang dimuat, sisipkan opsi dan pilih
        const opt = document.createElement('option');
        opt.value = targetVal;
        opt.textContent = targetVal;
        // Sisipkan sebelum opsi custom (jika ada)
        const customOpt = kelSelect.querySelector('option[value="__custom__"]');
        if (customOpt) {
            kelSelect.insertBefore(opt, customOpt);
        } else {
            kelSelect.appendChild(opt);
        }
        kelSelect.value = targetVal;
    }

    // Handler ketika Kecamatan berubah (Dukungan database lokal & fetch otomatis se-Indonesia)
    function onKecamatanChange(isUserEvent = true, autoSelectedKel = null) {
        const provVal = provSelect.value;
        const kotaVal = kotaSelect.value;
        const kecVal = kecSelect.value;
        const kelToSelect = autoSelectedKel || (!isUserEvent ? initialKel : null);

        kelSelect.innerHTML = '<option value="">-- Pilih Kelurahan / Desa --</option>';

        if (!provVal || !kotaVal || !kecVal) {
            return;
        }

        // 1. Cek apakah ada data lokal instan (seperti Demak, Jepara, Kudus, Pati, Semarang)
        if (databaseWilayah[provVal] && 
            databaseWilayah[provVal][kotaVal] && 
            !Array.isArray(databaseWilayah[provVal][kotaVal]) && 
            databaseWilayah[provVal][kotaVal][kecVal]) {
            
            const kelList = databaseWilayah[provVal][kotaVal][kecVal];
            kelList.slice().sort().forEach(kel => {
                const opt = document.createElement('option');
                opt.value = kel;
                opt.textContent = kel;
                kelSelect.appendChild(opt);
            });

            // Opsi ketik mandiri jika diperlukan
            const manualOpt = document.createElement('option');
            manualOpt.value = '__custom__';
            manualOpt.textContent = '+ Ketik Kelurahan Lainnya...';
            kelSelect.appendChild(manualOpt);

            if (kelToSelect) {
                selectKelurahanValue(kelToSelect);
            }
            return;
        }

        // 2. Jika tidak ada di memori lokal, ambil otomatis via API backend ber-cache
        if (currentKelurahanAbortController) {
            currentKelurahanAbortController.abort();
        }
        currentKelurahanAbortController = new AbortController();

        kelSelect.innerHTML = '<option value="">-- Memuat Kelurahan / Desa... --</option>';
        kelSelect.disabled = true;

        fetch(`/api/wilayah/kelurahan?provinsi=${encodeURIComponent(provVal)}&kota=${encodeURIComponent(kotaVal)}&kecamatan=${encodeURIComponent(kecVal)}`, {
            signal: currentKelurahanAbortController.signal
        })
        .then(res => res.json())
        .then(res => {
            kelSelect.disabled = false;
            kelSelect.innerHTML = '<option value="">-- Pilih Kelurahan / Desa --</option>';

            if (res && res.success && Array.isArray(res.data) && res.data.length > 0) {
                res.data.forEach(kel => {
                    const opt = document.createElement('option');
                    opt.value = kel;
                    opt.textContent = kel;
                    kelSelect.appendChild(opt);
                });
            }

            // Opsi alternatif ketik mandiri
            const manualOpt = document.createElement('option');
            manualOpt.value = '__custom__';
            manualOpt.textContent = '+ Ketik Kelurahan Lainnya...';
            kelSelect.appendChild(manualOpt);

            if (kelToSelect) {
                selectKelurahanValue(kelToSelect);
            }
        })
        .catch(err => {
            if (err.name === 'AbortError') return;
            kelSelect.disabled = false;
            kelSelect.innerHTML = '<option value="">-- Pilih Kelurahan / Desa --</option>';

            if (kelToSelect) {
                selectKelurahanValue(kelToSelect);
            }

            const manualOpt = document.createElement('option');
            manualOpt.value = '__custom__';
            manualOpt.textContent = '+ Ketik Kelurahan Lainnya...';
            kelSelect.appendChild(manualOpt);
        });
    }

    // Listener jika pengguna memilih opsi '+ Ketik Kelurahan Lainnya...'
    kelSelect.addEventListener('change', function() {
        if (this.value === '__custom__') {
            const userInput = prompt('Masukkan nama Kelurahan / Desa Anda:');
            if (userInput && userInput.trim().length > 0) {
                const cleanInput = userInput.trim();
                const opt = document.createElement('option');
                opt.value = cleanInput;
                opt.textContent = cleanInput;
                this.insertBefore(opt, this.lastElementChild);
                this.value = cleanInput;
            } else {
                this.value = '';
            }
        }
    });

    // Event Listeners
    provSelect.addEventListener('change', () => onProvinsiChange(true));
    kotaSelect.addEventListener('change', () => onKotaChange(true));
    kecSelect.addEventListener('change', () => onKecamatanChange(true));

    // ==========================================
    // HANDLER NYALAKAN LOKASI (GEOLOCATION GPS)
    // ==========================================
    const btnLocation = document.getElementById('{{ $idPrefix }}_btn_location');
    const btnText = document.getElementById('{{ $idPrefix }}_btn_text');
    const locationMsg = document.getElementById('{{ $idPrefix }}_location_msg');

    function showLocationMessage(text, isError = false) {
        if (!locationMsg) return;
        locationMsg.className = 'text-[12px] py-1.5 px-3 rounded-[6px] mb-2 font-medium ' + 
            (isError 
                ? 'bg-amber-50 text-amber-900 border border-amber-200' 
                : 'bg-[#f2f8ed] text-[#2D6B22] border border-[#c8bfb0]/70');
        locationMsg.textContent = text;
        locationMsg.classList.remove('hidden');
    }

    function findMatchingOption(selectEl, searchStr) {
        if (!searchStr) return -1;
        const cleanSearch = searchStr.toLowerCase()
            .replace(/^(provinsi|prov\.|daerah khusus ibukota|daerah istimewa|d\.i\.|kota administrasi|kota|kabupaten|kab\.)\s+/i, '')
            .trim();

        // 1. Exact match setelah pembersihan prefiks
        for (let i = 0; i < selectEl.options.length; i++) {
            const optVal = selectEl.options[i].value;
            if (!optVal) continue;
            const cleanOpt = optVal.toLowerCase()
                .replace(/^(provinsi|prov\.|daerah khusus ibukota|daerah istimewa|d\.i\.|kota administrasi|kota|kabupaten|kab\.)\s+/i, '')
                .trim();
            if (cleanOpt === cleanSearch) {
                return i;
            }
        }

        // 2. Substring match
        for (let i = 0; i < selectEl.options.length; i++) {
            const optVal = selectEl.options[i].value;
            if (!optVal) continue;
            const optLower = optVal.toLowerCase();
            if (optLower.includes(cleanSearch) || (cleanSearch.length > 3 && cleanSearch.includes(optLower.replace(/^(kab\.|kota)\s+/i, '')))) {
                return i;
            }
        }
        return -1;
    }

    if (btnLocation) {
        btnLocation.addEventListener('click', function() {
            if (!navigator.geolocation) {
                showLocationMessage('Peramban web tidak mendukung deteksi lokasi otomatis.', true);
                return;
            }

            const originalBtnHtml = btnText.innerHTML;
            btnText.innerHTML = '<span class="inline-block animate-spin mr-1">↻</span> Mendeteksi...';
            btnLocation.disabled = true;
            btnLocation.classList.add('opacity-75');

            navigator.geolocation.getCurrentPosition(
                async function(position) {
                    const lat = position.coords.latitude;
                    const lon = position.coords.longitude;

                    // Tampilkan Google Maps interaktif agar pengguna dapat memverifikasi titik lokasi
                    const mapPreview = document.getElementById('{{ $idPrefix }}_map_preview');
                    const gmapsIframe = document.getElementById('{{ $idPrefix }}_gmaps_iframe');
                    const gmapsLink = document.getElementById('{{ $idPrefix }}_gmaps_link');
                    const coordsText = document.getElementById('{{ $idPrefix }}_coords_text');

                    if (mapPreview && gmapsIframe) {
                        gmapsIframe.src = `https://maps.google.com/maps?q=${lat},${lon}&hl=id&z=16&output=embed`;
                        if (gmapsLink) {
                            gmapsLink.href = `https://www.google.com/maps?q=${lat},${lon}`;
                        }
                        if (coordsText) {
                            coordsText.textContent = `Koordinat GPS: ${lat.toFixed(6)}, ${lon.toFixed(6)}`;
                        }
                        mapPreview.classList.remove('hidden');
                    }

                    try {
                        let geoData = null;

                        // 1. Coba reverse geocode OpenStreetMap Nominatim
                        try {
                            const res = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lon}&addressdetails=1`, {
                                headers: { 'Accept-Language': 'id' }
                            });
                            if (res.ok) {
                                const d = await res.json();
                                if (d && d.address) {
                                    geoData = {
                                        provinsi: d.address.state || d.address.region || '',
                                        kota: d.address.city || d.address.county || d.address.town || d.address.city_district || '',
                                        kecamatan: d.address.suburb || d.address.municipality || d.address.district || '',
                                        kelurahan: d.address.village || d.address.quarter || d.address.neighbourhood || ''
                                    };
                                }
                            }
                        } catch (e) {
                            // Abaikan error jaringan OSM, lanjut fallback
                        }

                        // 2. Fallback BigDataCloud client API
                        if (!geoData || !geoData.provinsi) {
                            const res2 = await fetch(`https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=${lat}&longitude=${lon}&localityLanguage=id`);
                            if (res2.ok) {
                                const d2 = await res2.json();
                                geoData = {
                                    provinsi: d2.principalSubdivision || '',
                                    kota: d2.city || '',
                                    kecamatan: d2.locality || '',
                                    kelurahan: ''
                                };
                            }
                        }

                        if (geoData && geoData.provinsi) {
                            // Cocokkan Provinsi
                            const provIdx = findMatchingOption(provSelect, geoData.provinsi);
                            if (provIdx > 0) {
                                provSelect.selectedIndex = provIdx;
                                onProvinsiChange(false);

                                // Cocokkan Kota / Kabupaten
                                setTimeout(() => {
                                    const kotaIdx = findMatchingOption(kotaSelect, geoData.kota);
                                    if (kotaIdx > 0) {
                                        kotaSelect.selectedIndex = kotaIdx;
                                        onKotaChange(false);

                                        // Cocokkan Kecamatan jika tersedia, lalu muat & pilih Kelurahan
                                        setTimeout(() => {
                                            if (geoData.kecamatan) {
                                                const kecIdx = findMatchingOption(kecSelect, geoData.kecamatan);
                                                if (kecIdx > 0) {
                                                    kecSelect.selectedIndex = kecIdx;
                                                    onKecamatanChange(false, geoData.kelurahan);
                                                } else if (geoData.kelurahan) {
                                                    onKecamatanChange(false, geoData.kelurahan);
                                                }
                                            } else if (geoData.kelurahan) {
                                                onKecamatanChange(false, geoData.kelurahan);
                                            }
                                        }, 80);
                                    }
                                }, 80);

                                const detectedStr = [geoData.kelurahan, geoData.kecamatan, geoData.kota, geoData.provinsi].filter(Boolean).join(', ');
                                showLocationMessage(`✓ Lokasi terdeteksi akurat: ${detectedStr}`);
                            } else {
                                showLocationMessage(`Lokasi terdeteksi (${geoData.provinsi}), silakan sesuaikan dropdown provinsi.`);
                            }
                        } else {
                            showLocationMessage('Nama wilayah tidak teridentifikasi untuk titik ini. Silakan pilih secara manual.', true);
                        }
                    } catch (err) {
                        showLocationMessage('Layanan geocoding peta sedang sibuk. Silakan pilih secara manual.', true);
                    } finally {
                        btnText.innerHTML = originalBtnHtml;
                        btnLocation.disabled = false;
                        btnLocation.classList.remove('opacity-75');
                    }
                },
                function(err) {
                    btnText.innerHTML = originalBtnHtml;
                    btnLocation.disabled = false;
                    btnLocation.classList.remove('opacity-75');

                    if (err.code === 1) {
                        showLocationMessage('Izin akses lokasi tidak diizinkan di peramban. Silakan pilih wilayah secara manual.', true);
                    } else {
                        showLocationMessage('Titik GPS tidak dapat dibaca. Silakan pilih wilayah secara manual.', true);
                    }
                },
                { enableHighAccuracy: true, timeout: 8000, maximumAge: 60000 }
            );
        });
    }

    // Jalankan inisialisasi awal
    setInitialValues();
})();
</script>

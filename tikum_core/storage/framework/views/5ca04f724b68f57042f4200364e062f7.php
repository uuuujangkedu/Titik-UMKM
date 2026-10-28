<!-- MODAL UBAH FOTO PROFIL PENGGUNA -->
<div id="modal-edit-foto-profil" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl border border-[#E8E6DF] relative animate-fade-in">
        <!-- Close Button -->
        <button type="button" onclick="closeModalEditFotoProfil()" class="absolute top-5 right-5 w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 flex items-center justify-center text-sm font-bold transition">
            ✕
        </button>

        <div class="text-center mb-6">
            <h3 class="text-lg font-black text-[#1A202C]">Ubah Foto Profil</h3>
            <p class="text-xs text-gray-500 mt-1">Perbarui foto identitas akun Anda di platform DAYA UMKM</p>
        </div>

        <form id="form-edit-foto-profil" action="<?php echo e(route('profil.foto.update')); ?>" method="POST" enctype="multipart/form-data" class="space-y-5" onsubmit="return handleModalFotoSubmit(event)">
            <?php echo csrf_field(); ?>
            <div class="flex flex-col items-center justify-center">
                <!-- Preview Foto Bulat -->
                <div class="w-24 h-24 rounded-full bg-[#f7f6f1] border-2 border-dashed border-[#0F433C]/40 overflow-hidden flex items-center justify-center shrink-0 mb-3 relative shadow-inner">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Auth::user() && Auth::user()->avatar): ?>
                        <img id="preview-modal-foto" src="<?php echo e(Auth::user()->avatar); ?>" alt="Preview" class="w-full h-full object-cover">
                    <?php else: ?>
                        <img id="preview-modal-foto" src="" alt="Preview" class="w-full h-full object-cover hidden">
                        <span id="placeholder-modal-foto" class="text-3xl text-[#0F433C]">📷</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <!-- File Input Trigger Explicitly Linked via for -->
                <div class="flex flex-col items-center">
                    <label for="input-modal-foto" class="cursor-pointer px-4 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-800 text-xs font-bold transition inline-flex items-center gap-2 border border-gray-200 shadow-sm active:scale-95">
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>Pilih Foto dari Komputer</span>
                    </label>
                    <input type="file" 
                           id="input-modal-foto" 
                           name="foto_profil" 
                           accept="image/png,image/jpeg,image/webp,image/jpg" 
                           class="sr-only" 
                           onchange="previewModalFoto(this)">
                </div>

                <span id="selected-modal-filename" class="text-[11px] text-[#0F433C] font-semibold hidden mt-2 truncate max-w-[280px]"></span>
                <p class="text-[11px] text-gray-400 mt-1">Mendukung format JPG, PNG, WEBP. Maks 5MB.</p>
                
                <!-- Pesan Notifikasi Sukses / Gagal -->
                <p id="error-modal-foto" class="text-[11px] text-rose-600 font-bold hidden mt-2 text-center bg-rose-50 px-3 py-1.5 rounded-lg border border-rose-200 w-full"></p>
                <p id="success-modal-foto" class="text-[11px] text-emerald-700 font-bold hidden mt-2 text-center bg-emerald-50 px-3 py-1.5 rounded-lg border border-emerald-200 w-full"></p>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeModalEditFotoProfil()" class="px-4 py-2.5 rounded-xl border border-gray-300 text-gray-700 text-xs font-bold hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit" id="btn-submit-modal-foto" class="px-5 py-2.5 rounded-xl bg-[#0F433C] hover:bg-[#19584F] text-white text-xs font-bold transition shadow flex items-center justify-center min-w-[140px]">
                    Simpan Foto Profil
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModalEditFotoProfil() {
        const modal = document.getElementById('modal-edit-foto-profil');
        if (modal) {
            modal.classList.remove('hidden');
            const errorEl = document.getElementById('error-modal-foto');
            const successEl = document.getElementById('success-modal-foto');
            if (errorEl) errorEl.classList.add('hidden');
            if (successEl) successEl.classList.add('hidden');
        }
    }

    function closeModalEditFotoProfil() {
        const modal = document.getElementById('modal-edit-foto-profil');
        if (modal) {
            modal.classList.add('hidden');
        }
    }

    function previewModalFoto(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const filenameEl = document.getElementById('selected-modal-filename');
            const errorEl = document.getElementById('error-modal-foto');
            const successEl = document.getElementById('success-modal-foto');

            if (filenameEl) {
                filenameEl.textContent = 'File dipilih: ' + file.name;
                filenameEl.classList.remove('hidden');
            }
            if (errorEl) errorEl.classList.add('hidden');
            if (successEl) successEl.classList.add('hidden');

            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('preview-modal-foto');
                const placeholder = document.getElementById('placeholder-modal-foto');
                if (preview) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                }
                if (placeholder) {
                    placeholder.classList.add('hidden');
                }
            };
            reader.readAsDataURL(file);
        }
    }

    function handleModalFotoSubmit(e) {
        e.preventDefault();
        const form = document.getElementById('form-edit-foto-profil');
        const input = document.getElementById('input-modal-foto');
        const errorEl = document.getElementById('error-modal-foto');
        const successEl = document.getElementById('success-modal-foto');
        const submitBtn = document.getElementById('btn-submit-modal-foto');

        if (!input || !input.files || input.files.length === 0) {
            if (errorEl) {
                errorEl.textContent = 'Silakan pilih file foto terlebih dahulu.';
                errorEl.classList.remove('hidden');
            }
            return false;
        }

        const file = input.files[0];
        if (file.size > 5 * 1024 * 1024) {
            if (errorEl) {
                errorEl.textContent = 'Ukuran file foto maksimal 5MB.';
                errorEl.classList.remove('hidden');
            }
            return false;
        }

        if (errorEl) errorEl.classList.add('hidden');
        if (successEl) successEl.classList.add('hidden');

        const originalBtnText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="inline-block animate-pulse">Menyimpan Foto...</span>';

        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(async response => {
            const data = await response.json().catch(() => null);
            if (!response.ok) {
                let msg = 'Gagal menyimpan foto profil.';
                if (data && data.errors && data.errors.foto_profil) {
                    msg = data.errors.foto_profil[0];
                } else if (data && data.message) {
                    msg = data.message;
                }
                throw new Error(msg);
            }
            return data;
        })
        .then(data => {
            if (successEl) {
                successEl.textContent = data.message || 'Foto profil berhasil disimpan!';
                successEl.classList.remove('hidden');
            }
            submitBtn.innerHTML = '✓ Tersimpan!';

            const newUrl = data.avatar_url;
            if (newUrl) {
                document.querySelectorAll('.user-avatar-target').forEach(el => {
                    el.innerHTML = '<img src="' + newUrl + '" alt="Avatar" class="w-full h-full object-cover">';
                });
            }

            setTimeout(() => {
                window.location.reload();
            }, 600);
        })
        .catch(err => {
            if (errorEl) {
                errorEl.textContent = err.message || 'Terjadi kendala saat mengunggah foto.';
                errorEl.classList.remove('hidden');
            }
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        });

        return false;
    }
</script>
<?php /**PATH C:\laragon\laragon\www\tikum_core\tikum_core\resources\views/components/modal-edit-foto-profil.blade.php ENDPATH**/ ?>
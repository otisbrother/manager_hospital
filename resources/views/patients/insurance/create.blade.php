@extends('layouts.app')

@section('content')
<div class="min-h-screen py-6">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <!-- Header với icon và gradient -->
        <div class="mb-8 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-green-400 to-blue-500 rounded-full mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Đăng ký hồ sơ BHYT</h1>
            <p class="text-gray-600">Vui lòng điền đầy đủ thông tin để đăng ký hồ sơ BHYT</p>
        </div>

        <!-- Progress indicator -->
        <div class="mb-8">
            <div class="flex items-center justify-center space-x-4">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center text-sm font-semibold">1</div>
                    <span class="ml-2 text-sm font-medium text-green-600">Điền thông tin</span>
                </div>
                <div class="w-16 h-0.5 bg-gray-300"></div>
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-gray-300 text-gray-500 rounded-full flex items-center justify-center text-sm font-semibold">2</div>
                    <span class="ml-2 text-sm font-medium text-gray-500">Xác nhận</span>
                </div>
                <div class="w-16 h-0.5 bg-gray-300"></div>
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-gray-300 text-gray-500 rounded-full flex items-center justify-center text-sm font-semibold">3</div>
                    <span class="ml-2 text-sm font-medium text-gray-500">Hoàn thành</span>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <form action="{{ route('insurance-applications.store') }}" method="POST" enctype="multipart/form-data" id="insuranceForm">
                    @csrf
                    
                    <!-- Mã BHYT -->
                    <div class="mb-6">
                        <label for="insurance_id" class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="text-red-500">*</span> Mã BHYT (nếu có)
                        </label>
                        <input type="text" 
                               id="insurance_id" 
                               name="insurance_id" 
                               value="{{ old('insurance_id', $patient->insurance_id ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                               placeholder="Nhập mã BHYT (không bắt buộc)">
                        @error('insurance_id')
                            <div class="mt-2 flex items-center text-sm text-red-600">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Mức hỗ trợ BHYT -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="text-red-500">*</span> Mức hỗ trợ BHYT
                        </label>
                        <div class="relative">
                            <button type="button" 
                                    id="supportLevelBtn"
                                    class="w-full px-4 py-3 text-left border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 bg-white">
                                <span id="selectedLevel">Chọn mức hỗ trợ</span>
                                <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <input type="hidden" name="support_level" id="supportLevelInput" required>
                        </div>
                        @error('support_level')
                            <div class="mt-2 flex items-center text-sm text-red-600">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Ảnh chứng minh -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Ảnh chứng minh (nếu cần)
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition duration-200">
                            <input type="file" 
                                   name="proof_images[]" 
                                   multiple
                                   accept="image/*"
                                   id="proofImages"
                                   class="hidden">
                            <label for="proofImages" class="cursor-pointer">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <p class="mt-2 text-sm text-gray-600">Click để chọn ảnh hoặc kéo thả vào đây</p>
                                <p class="mt-1 text-xs text-gray-500">Hỗ trợ: JPG, PNG. Tối đa 2MB mỗi ảnh</p>
                            </label>
                        </div>
                        <div id="imagePreview" class="mt-4 grid grid-cols-2 md:grid-cols-3 gap-4 hidden"></div>
                        @error('proof_images')
                            <div class="mt-2 flex items-center text-sm text-red-600">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Submit button -->
                    <div class="flex justify-end space-x-4">
                        <button type="button" 
                                onclick="window.history.back()"
                                class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 transition duration-200">
                            Quay lại
                        </button>
                     <button type="submit" 
        class="px-8 py-3 bg-gradient-to-r from-green-500 to-blue-600 text-black rounded-lg hover:from-green-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-200 font-medium flex items-center justify-center whitespace-nowrap">
    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
    </svg>
    Gửi hồ sơ đăng ký
</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal cho mức hỗ trợ -->
<div id="supportLevelModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Chọn mức hỗ trợ BHYT</h3>
                    <button type="button" id="closeModal" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="space-y-3">
                    <div class="support-option p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition duration-200" data-value="80">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-medium text-gray-900">80% chi phí</h4>
                                <p class="text-sm text-gray-600">Nhóm phổ thông</p>
                            </div>
                            <div class="w-5 h-5 border-2 border-gray-300 rounded-full"></div>
                        </div>
                    </div>
                    <div class="support-option p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition duration-200" data-value="95">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-medium text-gray-900">95% chi phí</h4>
                                <p class="text-sm text-gray-600">Hộ cận nghèo</p>
                            </div>
                            <div class="w-5 h-5 border-2 border-gray-300 rounded-full"></div>
                        </div>
                    </div>
                    <div class="support-option p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition duration-200" data-value="100">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-medium text-gray-900">100% chi phí</h4>
                                <p class="text-sm text-gray-600">Hộ nghèo, người có công</p>
                            </div>
                            <div class="w-5 h-5 border-2 border-gray-300 rounded-full"></div>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" id="cancelSelection" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                        Hủy
                    </button>
                    <button type="button" id="confirmSelection" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Xác nhận
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('supportLevelModal');
    const btn = document.getElementById('supportLevelBtn');
    const closeBtn = document.getElementById('closeModal');
    const cancelBtn = document.getElementById('cancelSelection');
    const confirmBtn = document.getElementById('confirmSelection');
    const selectedLevelSpan = document.getElementById('selectedLevel');
    const supportLevelInput = document.getElementById('supportLevelInput');
    const options = document.querySelectorAll('.support-option');
    const imageInput = document.getElementById('proofImages');
    const imagePreview = document.getElementById('imagePreview');

    let selectedValue = '';

    // Modal functionality
    btn.addEventListener('click', () => {
        modal.classList.remove('hidden');
    });

    function closeModal() {
        modal.classList.add('hidden');
    }

    closeBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);

    // Option selection
    options.forEach(option => {
        option.addEventListener('click', () => {
            options.forEach(opt => {
                opt.classList.remove('border-blue-500', 'bg-blue-50');
                opt.querySelector('.w-5').classList.remove('bg-blue-500', 'border-blue-500');
                opt.querySelector('.w-5').classList.add('border-gray-300');
            });
            
            option.classList.add('border-blue-500', 'bg-blue-50');
            const radio = option.querySelector('.w-5');
            radio.classList.remove('border-gray-300');
            radio.classList.add('bg-blue-500', 'border-blue-500');
            
            selectedValue = option.dataset.value;
        });
    });

    confirmBtn.addEventListener('click', () => {
        if (selectedValue) {
            selectedLevelSpan.textContent = `${selectedValue}% chi phí`;
            supportLevelInput.value = selectedValue;
            closeModal();
        }
    });

    // Image preview
    imageInput.addEventListener('change', function(e) {
        imagePreview.innerHTML = '';
        imagePreview.classList.add('hidden');
        
        if (this.files.length > 0) {
            imagePreview.classList.remove('hidden');
            
            Array.from(this.files).forEach((file, index) => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    const previewDiv = document.createElement('div');
                    previewDiv.className = 'relative';
                    
                    reader.onload = function(e) {
                        previewDiv.innerHTML = `
                            <img src="${e.target.result}" class="w-full h-32 object-cover rounded-lg">
                            <button type="button" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600" onclick="removeImage(${index})">
                                ×
                            </button>
                        `;
                    };
                    
                    reader.readAsDataURL(file);
                    imagePreview.appendChild(previewDiv);
                }
            });
        }
    });

    // Form validation
    document.getElementById('insuranceForm').addEventListener('submit', function(e) {
        const supportLevel = supportLevelInput.value;
        console.log('Support level:', supportLevel); // Debug
        
        if (!supportLevel) {
            e.preventDefault();
            alert('Vui lòng chọn mức hỗ trợ BHYT');
            return false;
        }
        
        console.log('Form submitting...'); // Debug
    });
});

function removeImage(index) {
    const input = document.getElementById('proofImages');
    const dt = new DataTransfer();
    
    Array.from(input.files).forEach((file, i) => {
        if (i !== index) {
            dt.items.add(file);
        }
    });
    
    input.files = dt.files;
    input.dispatchEvent(new Event('change'));
}
</script>
@endsection 
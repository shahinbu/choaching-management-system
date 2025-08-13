@extends('layouts.app')

@section('title', 'Share Question Set')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Share Question Set</h1>
            <p class="text-gray-600 dark:text-gray-400">Share "{{ $questionSet->name }}" with others</p>
        </div>
        <a href="{{ route('partner.question-sets.index') }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
            Back to Question Sets
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Question Set Preview -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Question Set Preview</h2>
            
            <div class="space-y-4">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $questionSet->name }}</h3>
                    <p class="text-gray-600 dark:text-gray-400">{{ $questionSet->description }}</p>
                </div>

                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="bg-blue-50 dark:bg-blue-900/20 p-3 rounded-lg">
                        <div class="font-medium text-blue-900 dark:text-blue-100">Questions</div>
                        <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $questionSet->total_questions }}</div>
                    </div>
                    <div class="bg-green-50 dark:bg-green-900/20 p-3 rounded-lg">
                        <div class="font-medium text-green-900 dark:text-green-100">Total Marks</div>
                        <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $questionSet->total_marks }}</div>
                    </div>
                    <div class="bg-purple-50 dark:bg-purple-900/20 p-3 rounded-lg">
                        <div class="font-medium text-purple-900 dark:text-purple-100">Time Limit</div>
                        <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $questionSet->formatted_time_limit }}</div>
                    </div>
                    <div class="bg-orange-50 dark:bg-orange-900/20 p-3 rounded-lg">
                        <div class="font-medium text-orange-900 dark:text-orange-100">Difficulty</div>
                        <div class="text-2xl font-bold text-orange-600 dark:text-orange-400">{{ $questionSet->difficulty_text }}</div>
                    </div>
                </div>

                <div class="border-t pt-4">
                    <h4 class="font-medium text-gray-900 dark:text-white mb-2">Question Distribution</h4>
                    @php
                        $difficultyStats = $questionSet->getQuestionsByDifficulty();
                        $subjectStats = $questionSet->getQuestionsBySubject();
                    @endphp
                    
                    @if(!empty($difficultyStats))
                        <div class="mb-3">
                            <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">By Difficulty:</div>
                            <div class="flex gap-2 text-xs">
                                @foreach($difficultyStats as $level => $count)
                                    <span class="px-2 py-1 rounded-full
                                        @if($level == 1) bg-green-100 text-green-800
                                        @elseif($level == 2) bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ $level == 1 ? 'Easy' : ($level == 2 ? 'Medium' : 'Hard') }}: {{ $count }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if(!empty($subjectStats))
                        <div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">By Subject:</div>
                            <div class="flex flex-wrap gap-1 text-xs">
                                @foreach($subjectStats as $subject => $count)
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full">
                                        {{ $subject }}: {{ $count }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sharing Options -->
        <div class="space-y-6">
            <!-- Public Link -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Public Link</h2>
                
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium mb-2">Share URL</label>
                        <div class="flex">
                            <input type="text" id="shareUrl" value="{{ $shareData['url'] }}" readonly
                                   class="flex-1 rounded-l-md border border-r-0 p-2 bg-gray-50 dark:bg-gray-700">
                            <button onclick="copyToClipboard('shareUrl')" 
                                    class="bg-primaryGreen hover:bg-green-600 text-white px-4 py-2 rounded-r-md">
                                Copy
                            </button>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ $shareData['url'] }}" target="_blank" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm">
                            Preview Public View
                        </a>
                        <button onclick="generateQRCode()" 
                                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm">
                            Generate QR Code
                        </button>
                    </div>
                </div>

                <!-- QR Code Container -->
                <div id="qrCodeContainer" class="hidden mt-4 text-center">
                    <div id="qrCode" class="inline-block"></div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Scan to access question set</p>
                </div>
            </div>

            <!-- Social Media Sharing -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Social Media</h2>
                
                <div class="grid grid-cols-2 gap-3">
                    <!-- Facebook -->
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareData['url']) }}&quote={{ urlencode($shareData['title'] . ' - ' . $shareData['description']) }}" 
                       target="_blank" 
                       class="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-md transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        Facebook
                    </a>

                    <!-- Twitter -->
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode($shareData['url']) }}&text={{ urlencode($shareData['title'] . ' - ' . $shareData['description']) }}" 
                       target="_blank" 
                       class="flex items-center justify-center gap-2 bg-sky-500 hover:bg-sky-600 text-white px-4 py-3 rounded-md transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                        Twitter
                    </a>

                    <!-- LinkedIn -->
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($shareData['url']) }}" 
                       target="_blank" 
                       class="flex items-center justify-center gap-2 bg-blue-700 hover:bg-blue-800 text-white px-4 py-3 rounded-md transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                        LinkedIn
                    </a>

                    <!-- WhatsApp -->
                    <a href="https://wa.me/?text={{ urlencode($shareData['title'] . ' - ' . $shareData['description'] . ' ' . $shareData['url']) }}" 
                       target="_blank" 
                       class="flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white px-4 py-3 rounded-md transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                        </svg>
                        WhatsApp
                    </a>
                </div>
            </div>

            <!-- Email Sharing -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Email</h2>
                
                <a href="mailto:?subject={{ urlencode($shareData['title']) }}&body={{ urlencode('Check out this question set: ' . $shareData['description'] . '\n\n' . $shareData['url']) }}" 
                   class="flex items-center justify-center gap-2 bg-gray-600 hover:bg-gray-700 text-white px-4 py-3 rounded-md transition-colors w-full">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Share via Email
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>
<script>
function copyToClipboard(elementId) {
    const element = document.getElementById(elementId);
    element.select();
    element.setSelectionRange(0, 99999);
    document.execCommand('copy');
    
    // Show feedback
    const button = element.nextElementSibling;
    const originalText = button.textContent;
    button.textContent = 'Copied!';
    button.classList.add('bg-green-600');
    button.classList.remove('bg-primaryGreen');
    
    setTimeout(() => {
        button.textContent = originalText;
        button.classList.remove('bg-green-600');
        button.classList.add('bg-primaryGreen');
    }, 2000);
}

function generateQRCode() {
    const container = document.getElementById('qrCodeContainer');
    const qrCodeDiv = document.getElementById('qrCode');
    
    // Clear existing QR code
    qrCodeDiv.innerHTML = '';
    
    // Generate new QR code
    QRCode.toCanvas(qrCodeDiv, '{{ $shareData["url"] }}', {
        width: 200,
        margin: 2,
        color: {
            dark: '#000000',
            light: '#FFFFFF'
        }
    }, function (error) {
        if (error) {
            console.error(error);
            qrCodeDiv.innerHTML = '<p class="text-red-500">Error generating QR code</p>';
        }
    });
    
    container.classList.remove('hidden');
}
</script>
@endpush
@endsection

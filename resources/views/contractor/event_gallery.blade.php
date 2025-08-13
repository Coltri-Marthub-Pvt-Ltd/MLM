@extends('layouts.contractor')

@section('title', 'Gallery Images')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">Gallery Images</h2>

    @if($data->count() > 0)
        <div class="gallery-grid">
            @foreach($data as $event)
                <!-- Featured Image -->
                @if($event->featured_image && file_exists(public_path($event->featured_image)))
                    <div class="gallery-item">
                        <div class="card shadow-sm">
                            <img
                                src="{{ asset($event->featured_image) }}"
                                class="card-img-top img-fluid gallery-img"
                                alt="Featured Image - {{ $event->title }}"
                                loading="lazy"
                                data-bs-toggle="modal"
                                data-bs-target="#imageModal"
                                data-img-src="{{ asset($event->featured_image) }}"
                            >
                            <div class="card-body text-center p-2">
                                <p class="card-text small mb-0">{{ $event->title }} (Featured)</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Gallery Images -->
                @if(!empty($event->gallery) && is_array($event->gallery))
                    @foreach($event->gallery as $image)
                        @if(file_exists(public_path($image)))
                            <div class="gallery-item">
                                <div class="card shadow-sm">
                                    <img
                                        src="{{ asset($image) }}"
                                        class="card-img-top img-fluid gallery-img"
                                        alt="Gallery Image - {{ $event->title }}"
                                        loading="lazy"
                                        data-bs-toggle="modal"
                                        data-bs-target="#imageModal"
                                        data-img-src="{{ asset($image) }}"
                                    >
                                    <div class="card-body text-center p-2">
                                        <p class="card-text small mb-0">{{ $event->title }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>
    @else
        <div class="alert alert-info text-center">
            No events found with gallery images.
        </div>
    @endif
</div>

<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header border-0">
        <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center position-relative p-0">
        <button id="prevBtn" class="btn btn-secondary position-absolute top-50 start-0 translate-middle-y" style="z-index: 1050;">‹</button>
        <img id="modalImage" src="" class="img-fluid" alt="Full Image" loading="lazy" style="object-fit: contain; max-height: 90vh;">
        <button id="nextBtn" class="btn btn-secondary position-absolute top-50 end-0 translate-middle-y" style="z-index: 1050;">›</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
.gallery-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
}
.gallery-item .card-img-top {
    height: 100px;
    object-fit: cover;
    cursor: pointer;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const images = Array.from(document.querySelectorAll('.gallery-img'));
    const modalImage = document.getElementById('modalImage');
    const modal = document.getElementById('imageModal');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    let currentIndex = 0;

    if (images.length > 0) {
        function showImage(index) {
            if (index < 0 || index >= images.length) return;
            currentIndex = index;
            const imgSrc = images[currentIndex].getAttribute('data-img-src');
            modalImage.src = imgSrc;
            document.getElementById('imageModalLabel').textContent =
                images[currentIndex].alt || 'Image Preview';
        }

        images.forEach((img, index) => {
            img.addEventListener('click', function () {
                showImage(index);
            });
        });

        prevBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            if (currentIndex > 0) {
                showImage(currentIndex - 1);
            }
        });

        nextBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            if (currentIndex < images.length - 1) {
                showImage(currentIndex + 1);
            }
        });

        document.addEventListener('keydown', function (e) {
            if (!modal.classList.contains('show')) return;
            if (e.key === 'ArrowLeft') prevBtn.click();
            if (e.key === 'ArrowRight') nextBtn.click();
            if (e.key === 'Escape') {
                const modalInstance = bootstrap.Modal.getInstance(modal);
                modalInstance.hide();
            }
        });
    }
});
</script>
@endpush

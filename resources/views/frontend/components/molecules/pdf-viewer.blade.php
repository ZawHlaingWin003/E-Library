
<div class="pdf-wrapper">
    <div class="link-title">
        <a href="#{{ $book->slug }}" class="title">
            <i class="fa-solid fa-link"></i>
            <span>
                {{ $book->name }}
            </span>
        </a>
    </div>
    <iframe src="{{ $book->pdf_file }}#toolbar=0" id="{{ $book->slug }}" class="pdf"
        style="scroll-margin-top: 10px">
        This browser does not support PDFs. Please download the PDF to view it: Download PDF.
    </iframe>
</div>
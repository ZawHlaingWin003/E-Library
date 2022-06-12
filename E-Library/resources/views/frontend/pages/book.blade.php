@extends('frontend.layouts.app')

@section('title', $book->name)

@section('custom_style')
<style>

.book-section{
    font-family: bodyRegularFont;
}
.book-cover img{
    width: 100%;
    height: 300px;
    object-fit: contain;
}

.pdf-wrapper{
    width: 100%;
    margin: 100px auto;
    text-align: center;
}
.pdf{
    width: 80%;
    height: 100vh;
    margin: 0 auto;
}


/* Heart Btn */
.heart-btn{
    display: inline-block;
}
.heart-btn .content{
    padding: 10px 15px;
    border: 2px solid #000;
    border-radius: 5px;
    cursor: pointer;
    position: relative;
}
.likeBtn.heart-active{
    border-color: #E2264D;
}
.heart-btn .heart{
    position: absolute;
    background: url('{{ asset('frontend/assets/images/heart-btn.png') }}') no-repeat;
    background-position: left;
    background-size: 2900%;
    height: 90px;
    width: 90px;
    top: 50%;
    left: 10%;
    transform: translate(-50%,-50%);
}
.heart-btn .text{
    color: #000;
    margin-left: 1.5rem;
}
.heart-btn .likeCount{
    margin-left: .2rem;
    color: #000;
}
.likeCount.heart-active, .text.heart-active{
    color: #E2264D;
}
.heart.heart-active{
    animation: animate .8s steps(28) 1;
    background-position: right;
}
@keyframes animate {
    0%{
        background-position: left;
    }
    100%{
        background-position: right;
    }
}

</style>

@endsection

@section('content')

<section class='book-section container'>
    <a href="{{ route('books.index') }}" class="btn btn-primary primary-btn mb-5"><i class="fa fa-arrow-left"></i> To Library</a>
    <div class='book-detail'>
        <div class="row">
            <div class="col-md-5 border-top">
                <div class='image'>
                    <div class='content'>
                        <div class='book-cover p-3'>
                            <img alt='Card Image' src='{{ asset('covers/'.$book->cover) }}' class="img-fluid">
                        </div>
                    </div>
                    <div class="book-meta d-flex justify-content-center gap-5 mt-3 text-center">
                        <div class="reads meta-item">
                            <small>
                                <i class="fa fa-eye"></i>
                                <span class='text'>
                                    32 reads
                                </span>
                            </small>
                        </div>
                        <div class="likes meta-item">
                            <small>
                                <i class='fa fa-thumbs-up'></i>
                                <span class='text'>
                                    81 likes
                                </span>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7 p-5 pe-2 border-top border-start">
                <div class='text book-text'>
                    <span class='genre text-primary'>
                        @foreach ($book->genres as $genre)
                            {{ $genre->name }} |
                        @endforeach
                    </span>
                    <h1 class='title my-3'>
                        {{ $book->name }}
                    </h1>
                    <div class='author'>
                        by {{ $book->author->name }}
                    </div>

                    <div class='published_at'>
                        <i class="fa fa-calender"></i>
                        {{ $book->published_at->format('d-m-Y') }}
                    </div>

                    <article class='description my-3'>
                        {{ $book->excerpt }}
                    </article>
                    <a href="#">Start Reading</a>
                </div>
            </div>
        </div>


        <div class="pdf-wrapper">
            <iframe src="{{ asset('pdf_files/'.$book->pdf_file) }}" class="pdf">
                This browser does not support PDFs. Please download the PDF to view it: Download PDF.
            </iframe>
        </div>

        <hr>
        <div class="blog-loveBtn">
            <h3>Do you recommend this book?</h3>
            <div class="heart-btn">
                <div class="likeBtn content">
                    <span class="heart"></span>
                    <span class="text">Love This Book</span>
                    <span class="likeCount">13</span>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection


@section('custom_script')

<script>
    const likeBtn = document.querySelector(".likeBtn");
    const likeCount = document.querySelector(".likeCount");
    const text = document.querySelector(".text");
    const heart = document.querySelector(".heart");

    let clicked = false;

    likeBtn.addEventListener("click", function () {
        if (!clicked) {
            clicked = true;
            likeCount.textContent++;
            this.classList.add("heart-active");
            text.classList.add("heart-active");
            heart.classList.add("heart-active");
            likeCount.classList.add("heart-active");
        } else {
            clicked = false;
            this.classList.remove("heart-active");
            text.classList.remove("heart-active");
            heart.classList.remove("heart-active");
            likeCount.classList.remove("heart-active");
            likeCount.textContent--;
        }
    });
</script>
@endsection

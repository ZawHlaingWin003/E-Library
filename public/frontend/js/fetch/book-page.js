
$(document).ready(function () {
    // HTML codes which we want to render in page after fetch data
    const renderBooksHTML = (response) => {
        let output = '';

        if (response.length == 0) {
            output += `
            <div class="w-100">
                <img src="/frontend/assets/images/404-page.png" class="w-100" alt="404 Page">
                <h3 class="text-danger text-center"><strong>Sorry 🙁, No Data Here ...</strong></h3>
            </div>
            `;
        } else {
            $.each(response, function (index, data) {
                output += `
                <div class="col-md-6">
                    <div class="book-card border">
                        <div class="card p-3 border-0">
                            <img src="${data.cover}" alt="Book-Cover" class="book-cover">
                            <hr>
                            <h3 class="book-title text-center"><a href="books/${data.slug}">${data.name}</a></h3>
                            <p class="book-author text-center mt-3">
                                By : 
                                <a href="/authors/${data.author.id}">
                                    ${data.author.name}
                                </a>
                            </p>
                            <a href="books/${data.slug}" class="btn btn-primary primary-btn">
                                Read More
                            </a>
                        </div>
                    </div>
                </div>
                `
            });
        }

        return output;
    }

    // data that we want to pass to request server
    let data = {};

    // Get All Books
    const getBooks = (page = 1, perPage = 2) => {
        const loaderHTML = `<div class="vh-100 d-flex justify-content-center align-items-center" id="book-section-loader">
            <div class="custom-loader section-loader"></div>
        </div>
        `;

        const elementContainer = $('#book-list');
        const url = "/books/get-books";

        data.page = page;
        data.perPage = perPage

        fetchData(elementContainer, loaderHTML, url, data)
            .then((response) => {
                console.log(response)
                elementContainer.html(renderBooksHTML(response.data.data))
                renderPaginationHTML(response.data)
            })
    };

    // After fetching books from api, Add pagination HTML along the data.
    function renderPaginationHTML(response) {
        let currentPage = response.current_page;
        let lastPage = response.last_page;

        // If there is only one pagination link
        if (currentPage == lastPage && !response.prev_page_url) {
            $('#pagination-container').html('');
            return;
        }

        let paginationHTML = ''
        let perviousButton = ''
        let nextButton = ''
        let paginationButtons = ''

        // Create the previous page link
        if (currentPage > 1) {
            perviousButton +=
                `<li class="page-item"><a class="page-link" href="#" data-id="${currentPage - 1}">Previous</a></li>`;
        }

        // Create the next page link
        if (currentPage < lastPage) {
            nextButton +=
                `<li class="page-item"><a class="page-link" href="#" data-id="${currentPage + 1}">Next</a></li>`;
        }

        // Create the page number links
        for (var i = 1; i <= lastPage; i++) {
            if (i === currentPage) {
                paginationButtons +=
                    `<li class="page-item active"><a class="page-link" href="#" data-id="${i}">${i}</a></li>`;
            } else {
                paginationButtons +=
                    `<li class="page-item"><a class="page-link" href="#" data-id="${i}">${i}</a></li>`;
            }
        }

        paginationHTML += `
        <nav>
            <ul class="pagination">
                ${perviousButton}
                ${paginationButtons}
                ${nextButton}
            </ul>
        </nav>
        `;

        // Display the pagination links
        $('#pagination-container').html(paginationHTML);
    }

    // Click pagination links
    $(document).on('click', ".page-link", function () {
        $(window).scrollTop(0);
        getBooks($(this).attr('data-id'))
    })

    // Filter Books By Search
    $('#search-book-form').submit(function (e) {
        e.preventDefault();
        $(window).scrollTop(0);
        // Remove the "active" class from all author-items
        let authorItems = document.querySelectorAll('#author-item');
        $.each(authorItems, function (index, value) {
            value.classList.remove('active');
        });

        // Remove the "active" class from all genre-items
        let genreItems = document.querySelectorAll('#genre-item');
        $.each(genreItems, function (index, value) {
            value.classList.remove('active');
        });

        data = {}
        data.search = $('#search-book').val();
        getBooks()
    })

    // Filter Books By Genre
    $(document).on('click', '#genre-item', function () {
        $(window).scrollTop(0);
        // Remove Book Search Input Value
        $('#search-book').val('')

        // Remove the "active" class from all genre-items
        let genreItems = document.querySelectorAll("#author-item");
        $.each(genreItems, function (index, value) {
            value.classList.remove('active');
        });

        // Remove active class from other author-item elements.
        $(this).siblings().removeClass('active');
        $(this).addClass('active')

        // Remove previous url parameters and add new parameters that we want to pass.
        data = {}
        data.genre = $(this).attr('data-id')

        getBooks();
    })

    // Filter Books By Author
    $(document).on('click', '#author-item', function () {
        $(window).scrollTop(0);
        // Remove Book Search Input Value
        $('#search-book').val('')

        // Remove the "active" class from all author-items
        let genreItems = document.querySelectorAll('#genre-item');
        $.each(genreItems, function (index, value) {
            value.classList.remove('active');
        });

        // Remove active class from other author-item elements.
        // But our author-item elements are not siblings. So we have to use vanilla js.
        let authorItems = document.querySelectorAll("#author-item");
        $.each(authorItems, function (index, value) {
            value.classList.remove('active');
        });
        
        // Add active class to clicked element
        $(this).addClass('active')

        // Remove previous url parameters and add new parameters that we want to pass.
        data = {}
        data.author = $(this).attr('data-id')

        getBooks();
    })

    getBooks();
})
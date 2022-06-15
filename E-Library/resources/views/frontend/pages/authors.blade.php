@extends('frontend.layouts.app')

@section('title', 'Author List')

@section('custom_style')
<style>
    .search_list .profile{
        width: 100px;
        height: 100px;
        overflow: hidden;
        border: 1px solid gray;
        border-radius: 50%;
        margin: 0 auto;
    }
    .search_list .profile img{
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
</style>
@endsection

@section('content')
<section class="authors">
    <div class="container">
        <div class="form-group mb-4">
            <h1 class="text-primary mb-4">Search with Author Name</h1>
            <input type="text" name="search" id="search" class="form-control" autocomplete="off" placeholder="Search Author..." onfocus="this.value=''">
        </div>
        <div id="not_found">
            <div class="row search_list" id="search_list">
                @foreach ($authors as $key => $author)
                    <div class="col-md-3 my-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="profile">
                                    <img src="{{ asset('profiles/'.$author->profile) }}" alt="" class="img-fluid">
                                </div>
                            </div>
                            <div class="card-footer">
                                <p><a href="{{ route('authors.show', $author->id) }}">{{ $author->name }}</a></p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection

@section('custom_script')
<script>
    $(document).ready(function(){
        $('#search').on('keyup', function(){
            $query = $(this).val();
            // console.log($query)
            $.ajax({
                url:"search",
                type:"GET",
                data:{'search':$query},
                success:function(data){
                    // console.log(data);
                    if(data.length > 0){
                        $('#search_list').html(data);
                    }else{
                        $not_found = `
                            <div class="my-3">
                                <h3>There is no author which named  >> <span class="text-danger"> ${$query} </span></h3>
                            </div>
                        `;
                        $('#search_list').html($not_found);
                    }

                }
            });
        });
    });
</script>
@endsection

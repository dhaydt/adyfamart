    <style>
    .cat-wrapper {
        display: flex;
        flex-wrap: nowrap;
        height: 135px;
        overflow-x: auto;
    }
    .cat-wrapper::-webkit-scrollbar {
        display: none !important;
    }
    .cat-item {
        flex: 0 0 auto;
        max-width: 98px;
        min-width: 98px;
        margin-right: 0;
        max-height: 98px;
        min-height: 98px;
    }

    .cat-item a img{
        min-width: 98px;
        width: 98px;
    }

    @media(max-width: 500px){
        .cat-item {
        flex: 0 0 auto;
        max-width: 60px;
        min-width: 60px;
        margin-right: 0;
        max-height: 60px;
        min-height: 60px;
    }

    .cat-item a img{
        min-width: 60px;
        width: 60px;
    }
    }
    </style>
<div class="row cat-wrapper">
    @foreach ($categories as $category)
    <div class="col-md-4 col-12 h-100 w-100 cat-item">
        <a href="{{route('products',['id'=> $category['id'],'data_from'=>'category','page'=>1])}}" class="cat-link">
            <img style=""
                             onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                             src="{{asset("storage/app/public/category/$category->icon")}}"
                             alt="{{$category->name}}">
                             <p class="text-center">{{Str::limit($category->name, 17)}}</p>
        </a>
    </div>
    @endforeach
</div>

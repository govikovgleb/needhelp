@extends('layouts.app')

@section('content')
<script>
    $().ready(function() {
        $('.to-basket').click(function() {
            let basket_id = $(this).data('id');            
            deleteFromBasket($(this), basket_id);
        })

        $('.get-user-basket').click(function() {
            let user_id = $(this).data('id');            
            getUserBasket($(this), user_id);
        })
    })

    
    function getUserBasket(cur_btn, user_id) {
        $.ajax({
            url: "{{route('getUserBasket')}}",
            type: "POST",
            data: {
                id: user_id                    
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                $('#needhelp_basket > tbody').html(data.basket);
                if (data.total_cost) {
                    $('.total_cost').toggle();
                    $('.total_cost').text(data.total_cost);
                } else {
                    $('.total_cost').toggle();
                }            
                console.log(data)
            },
            error: (data) => {
                console.log(data)
            }
        });
    }

    function deleteFromBasket(cur_btn, basket_id) {
        $.ajax({
            url: "{{route('deleteFromBasket')}}",
            type: "POST",
            data: {
                id: basket_id                    
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                if (data) {
                    cur_btn.text('Deleted')
                    cur_btn.removeClass('btn-outline-success')
                    cur_btn.addClass('btn-outline-dark')                    
                }                    
                console.log(data)
            },
            error: (data) => {
                console.log(data)
            }
        });
    }
 
</script>

<!-- <body> -->
    <div class="container">
        <div class="row">            
            @if($user->id === 1)            
            <div class="col-2">
            <table class="table table-bordered" id="needhelp_users">
                    <thead>
                        <tr>
                            <th>Users</th>                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user_list as $user)
                        <tr>                            
                            <td><div class="get-user-basket btn btn-outline-success" data-id="{{$user->id }}">{{$user->name }}</div></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-10">
                @else
            <div class="col-12">
                @endif
                <table class="table table-bordered" id="needhelp_basket">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Cost</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($basket as $basket_id => $product)
                        <tr>
                            <td>{{ $product->title }}</td>
                            <td>{{ $product->cost }}</td>
                            <td><div class="to-basket btn btn-outline-success" data-id="{{$basket_id }}">Delete</div></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($total_cost)
                <div class="total_cost">Total cost: {{$total_cost}}</div>
                @endif
            </div>

        </div> 
        <div class="row">
            <div class="nav-item">
                <a class="nav-link" href="{{ route('productList') }}">Product List</a>
            </div>
        </div>       
    </div>
    @endsection
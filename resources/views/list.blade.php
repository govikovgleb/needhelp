@extends('layouts.app')

@section('content')
<script>
    $().ready(function() {
        $('.to-basket').click(function() {
            let product_id = $(this).data('id');            
            addToBasket($(this), product_id);
        })

        function addToBasket(cur_btn, product_id) {
            $.ajax({
                url: "{{route('addToBasket')}}",
                type: "POST",
                data: {
                    id: product_id                    
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (data) => {
                    if (data) {
                        cur_btn.text('In basket')
                        cur_btn.removeClass('btn-outline-success')
                        cur_btn.addClass('btn-outline-dark')
                    } else {
                        cur_btn.text('In basket')
                        alert('Product is already in basket')
                    }                    
                    console.log(data)
                },
                error: (data) => {
                    console.log(data)
                }
            });
        }
    })
</script>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered" id="needhelp_products">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Cost</th>
                            @auth
                            <th></th>
                            @endauth                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $product->title }}</td>
                            <td>{{ $product->cost }}</td>
                            @auth
                            <td><div class="to-basket btn btn-outline-success" data-id="{{$product->id }}">To basket</div></td>
                            @endauth
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
            </div>
        </div>
        <div class="row">
        <div class="d-flex justify-content-center">
                    {!! $products->links() !!}
                </div>
        </div>
    </div>
    @endsection
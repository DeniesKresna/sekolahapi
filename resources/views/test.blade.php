@if(!empty($shop->shop_products))
    <?php $i=1; ?>
    @foreach($shop->shop_products as $shop_product)
        <tr class="odd gradeX">
            <td>{{!empty($shop_product->product) ? $shop_product->product->name : "N/A"}}</td>
            <td>{{!empty($shop_product->product) ? $shop_product->product->price : "N/A"}}</td>
            <td>{{$shop_product->stocks}}</td>
            <td>
                <form action="{{route("admin.shop_product.update")}}" method="post" id="stock-{{$shop_product->id}}">
                    <input class="form-control hidden" name="id" value="{{$shop_product->id}}">
                    <div class="input-group">
                        <input class="form-control" name="stocks" value="{{$shop_product->stocks}}">
                        <span class="input-group-addon" style="background: white!important;cursor: pointer" onclick="$('#stock-{{$shop_product->id}}').submit()"><i class="fa fa-edit"></i></span>
                    </div>
                </form>
            </td>
            <td>
                <div class="input-group" style="width: 120px!important;">
                    <a class="confirm-delete" style="color: white; text-decoration: none" href="{{route('admin.shop_product.delete',["id"=>$shop_product->id])}}"><button type="button" class="btn btn-danger"><i class="fa fa-trash-o"></i></button></a>
                </div>
            </td>
        </tr>
    @endforeach
@endif

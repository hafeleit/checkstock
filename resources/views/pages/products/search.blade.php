<table class="table align-items-center mb-0">
    <thead>
        <tr>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ITEM CODE</th>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">ITEM NAME</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ITEM STATUS</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ITEM INVENTORY CODE</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ITEM REPL TIME</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ITEM GRADE CODE 1</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ITEM UOM CODE</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">PACK CONV FACTOR</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">PACK PARENT UOM CODE</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">LOCN CODE</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">LOCN NAME</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">FREESTOCK</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">RATE</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($products as $product)
        <tr>
          <td>
            <div class="d-flex px-2 py-1"> <div> <img src="/img/products/495.60.072.jpg" class="avatar avatar-sm me-3" alt="user1"> </div> <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0 text-sm"><a href="{{ route('products.index') .'/'. $product->ITEM_CODE }} ">{{ $product->ITEM_CODE}}</a></h6> </div> </div>
          </td>
          <td> <p class="text-xs font-weight-bold mb-0">{{ $product->ITEM_NAME}}</p> </td>
          <td class="align-middle text-center"> <span class="text-xs font-weight-bold">{{ $product->ITEM_STATUS}}</span> </td>
          <td class="align-middle text-center"> <span class="text-xs font-weight-bold">{{ $product->ITEM_INVENTORY_CODE}}</span> </td>
          <td class="align-middle text-center"> <span class="text-xs font-weight-bold">{{ $product->ITEM_REPL_TIME}}</span> </td>
          <td class="align-middle text-center"> <span class="text-xs font-weight-bold">{{ $product->ITEM_GRADE_CODE_1}}</span> </td>
          <td class="align-middle text-center"> <span class="text-xs font-weight-bold">{{ $product->ITEM_UOM_CODE}}</span> </td>
          <td class="align-middle text-center"> <span class="text-xs font-weight-bold">{{ $product->PACK_CONV_FACTOR}}</span> </td>
          <td class="align-middle text-center"> <span class="text-xs font-weight-bold">{{ $product->PACK_PARENT_UOM_CODE}}</span> </td>
          <td class="align-middle text-center"> <span class="text-xs font-weight-bold">{{ $product->LOCN_CODE}}</span> </td>
          <td class="align-middle text-center"> <span class="text-xs font-weight-bold">{{ $product->LOCN_NAME}}</span> </td>
          <td class="align-middle text-center"> <span class="text-xs font-weight-bold">{{ $product->FREESTOCK}}</span> </td>
          <td class="align-middle text-center"> <span class="text-xs font-weight-bold">{{ $product->RATE}}</span> </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="card-footer pb-0">
  {!! $products->links('pagination::bootstrap-4') !!}
</div>

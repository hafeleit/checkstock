<table class="table align-items-center mb-0">
    <thead>
      <tr>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="padding-left: 90px;">ITEM CODE</th>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">ITEM NAME</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ITEM UOM CODE</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ITEM STATUS</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">STOCK IN HAND</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">PENDING SO</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ABALABLE STOCK</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NEW ITEM</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">RATE</th>
      </tr>
    </thead>
    <tbody>
        @if(count($products) > 0)
        @foreach ($products as $product)
        <tr>
            <td>
              <a href="{{ route('products.index') .'/'. $product->ITEM_CODE }} ">
                <div class="d-flex px-2 py-1">
                  <div>
                    <?php
                      $image = '/storage/img/products/' . $product->ITEM_CODE . '.jpg';
                      if (file_exists( public_path() . $image )) {
                          echo '<img src="/storage/img/products/'.$product->ITEM_CODE.'.jpg" class="avatar avatar-sm me-3" alt="user1">';
                      } else {
                          echo '<img src="/storage/img/coming_soon.jpg" class="avatar avatar-sm me-3" alt="user1">';
                      }
                     ?>
                   </div>
                <div class="d-flex flex-column justify-content-center">
                  <h6 class="mb-0 text-sm">
                    <span class="btn btn-link text-danger text-gradient px-3 mb-0">{{ $product->ITEM_CODE}}</span>
                  </h6>
                </div>
              </div>
            </a>
            </td>
            <td><a href="{{ route('products.index') .'/'. $product->ITEM_CODE }} "> <p class="text-xs font-weight-bold mb-0">{{ $product->ITEM_NAME}}</p></a></td>
            <td class="align-middle text-center"> <span class="text-xs font-weight-bold">{{ $product->ITEM_UOM_CODE}}</span></td>
            <td class="align-middle text-center"> <span class="text-xs font-weight-bold">{{ $product->ITEM_STATUS}}</span></td>
            <td class="align-middle text-center"> <span class="text-xs font-weight-bold">{{ $product->STOCK_IN_HAND}}</span></td>
            <td class="align-middle text-center"> <span class="text-xs font-weight-bold">{{ $product->PENDING_SO}}</span></td>
            <td class="align-middle text-center"> <span class="text-xs font-weight-bold">{{ $product->AVAILABLE_STOCK}}</span></td>
            <td class="align-middle text-center"> <span class="text-xs font-weight-bold">{{ $product->NEW_ITEM}}</span></td>
            <td class="align-middle text-center"> <span class="text-xs font-weight-bold">{{ ($product->RATE != '' ? number_format($product->RATE) : '')}}</span></td>
        </tr>
        @endforeach
        @ELSE
          <tr>
            <td colspan="9" style=" text-align: center;">NO DATA.</td>
          </tr>
        @ENDIF
    </tbody>
</table>

<?php /*<div class="card-footer pb-0">
  {!! $products->links('pagination::bootstrap-4') !!}
</div>*/ ?>

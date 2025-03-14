<table class="table align-items-center mb-0">
    <thead>
      <tr>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="padding-left: 90px;">ITEM CODE</th>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">ITEM NAME</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ITEM UOM CODE</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ITEM STATUS</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">STOCK IN HAND</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">PENDING SO</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">AVAILABLE STOCK</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NEW ITEM</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">PRICE LIST UOM</th>
          <th class="text-end text-secondary text-xxs font-weight-bolder opacity-7">PRICE (Incl.VAT)</th>
      </tr>
    </thead>
    <tbody>
        @if(count($products) > 0)
        @foreach ($products as $product)
        <tr>
            <td>
              <a href="{{ route('products.index') .'/'. $product->ITEM_CODE .'?view='.request()->input('view') }} ">
                <div class="d-flex px-2 py-1">
                  <div>
                    <?php
                      $image = '/storage/img/products/' . $product->ITEM_CODE . '.jpg';
                      $image2 = '/storage/img/products/' . $product->ITEM_CODE . '.JPG';
                      if (file_exists( public_path() . $image )) {
                          echo '<img src="'.$image.'" class="avatar avatar-sm me-3" alt="user1">';
                      }elseif(file_exists( public_path() . $image2 )){
                          echo '<img src="'.$image2.'" class="avatar avatar-sm me-3" alt="user1">';
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
            <td><a href="{{ route('products.index') .'/'. $product->ITEM_CODE .'?view='.request()->input('view') }} "> <p class="text-xs font-weight-bold mb-0">{{ $product->ITEM_NAME}}</p></a></td>
            <td class="align-middle text-center"> <span class="text-xs font-weight-bold">{{ $product->ITEM_UOM_CODE}}</span></td>
            <td class="align-middle text-center"> <span class="text-xs font-weight-bold">{{ $product->ITEM_STATUS}}</span></td>
            <td class="align-middle text-center"> <span class="text-xs font-weight-bold">{{ $product->STOCK_IN_HAND != '' ? number_format($product->STOCK_IN_HAND) : '0'}}</span></td>
            <td class="align-middle text-center"> <span class="text-xs font-weight-bold">{{ $product->PENDING_SO != '' ? number_format($product->PENDING_SO) : '0'}}</span></td>
            <td class="align-middle text-center"> <span class="text-xs font-weight-bold">{{ $product->AVAILABLE_STOCK != '' ? number_format($product->AVAILABLE_STOCK) : '0'}}</span></td>
            <td class="align-middle text-center"> <span class="text-xs font-weight-bold">{{ $product->NEW_ITEM}}</span></td>
            <td class="align-middle text-center"> <span class="text-xs font-weight-bold">{{ $product->PRICE_LIST_UOM}}</span></td>
            <td class="align-middle text-end" style="padding-right: 20px;"> <span class="text-xs font-weight-bold">{{ ($product->RATE7 != '' ? number_format($product->RATE7, 2) : '')}}</span></td>
        </tr>
        @endforeach
        @ELSE
          <tr>
            <td colspan="10" style="text-align: center;">NO DATA.</td>
          </tr>
        @ENDIF
    </tbody>
</table>

<?php /*<div class="card-footer pb-0">
  {!! $products->links('pagination::bootstrap-4') !!}
</div>*/ ?>

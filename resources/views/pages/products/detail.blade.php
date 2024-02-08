@extends('layouts.appguest', ['class' => 'g-sidenav-show bg-gray-100'])
<div class="position-absolute w-100 min-height-300 top-0"
    style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/profile-layout-header.jpg'); background-position-y: 50%;">
    <span class="mask bg-primary opacity-6"></span>
</div>
@section('content')
<script src="/assets/js/plugins/photoswipe.min.js"></script>
<script src="/assets/js/plugins/photoswipe-ui-default.min.js"></script>
<div class="container-fluid py-4">
  <style media="screen">
  .icon-flipped {
    transform: scaleX(-1);
    -moz-transform: scaleX(-1);
    -webkit-transform: scaleX(-1);
    -ms-transform: scaleX(-1);
  }
  </style>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('products.index') .'?view='.request()->input('view') }}">
                      <div class="icon icon-shape bg-gradient-primary shadow text-center mb-4">
                        <i class="ni ni-curved-next opacity-10 icon-flipped" aria-hidden="true"></i>
                      </div>
                    </a>
                    <div class="row">

                        <div class="col-xl-5 col-lg-6 text-center">
                          <?php
                            $image = '/storage/img/products/' . $product[0]->ITEM_CODE . '.jpg';
                            $image2 = '/storage/img/products/' . $product[0]->ITEM_CODE . '.JPG';
                            $img_d = '/storage/img/products/' . $product[0]->ITEM_CODE . '_D.jpg';
                            $img_f = '/storage/img/products/' . $product[0]->ITEM_CODE . '_F.jpg';
                            $img_l = '/storage/img/products/' . $product[0]->ITEM_CODE . '_L.jpg';
                            $img_p = '/storage/img/products/' . $product[0]->ITEM_CODE . '_P.jpg';
                            $img_s = '/storage/img/products/' . $product[0]->ITEM_CODE . '_S.jpg';
                            if (file_exists( public_path() . $image )) {
                                $img = $image;
                                echo '<img src="'.$image.'" alt="Image placeholder" class="w-100 border-radius-lg shadow-lg mx-auto">';
                            }elseif(file_exists( public_path() . $image2 )){
                                $img = $image2;
                                echo '<img src="'.$image2.'" alt="Image placeholder" class="w-100 border-radius-lg shadow-lg mx-auto">';
                            } else {
                              $img = "/storage/img/coming_soon.jpg";
                                echo '<img src="/storage/img/coming_soon.jpg" alt="Image placeholder" class="w-100 border-radius-lg shadow-lg mx-auto">';
                            }
                           ?>
                            <div class="my-gallery d-flex mt-4 pt-2" itemscope="" itemtype="" data-pswp-uid="1">
                                <figure class="ms-2 me-3" itemprop="associatedMedia" itemscope="" itemtype="">
                                    <a href="{{ $img }}" itemprop="contentUrl" data-size="500x600">
                                        <img class="w-100 min-height-100 max-height-100 border-radius-lg shadow" src="{{ $img }}" alt="Image description">
                                    </a>
                                </figure>
                                @if (file_exists( public_path() . $img_d ))
                                <figure class="ms-2 me-3" itemprop="associatedMedia" itemscope="" itemtype="">
                                    <a href="{{ $img_d }}" itemprop="contentUrl" data-size="500x600">
                                        <img class="w-100 min-height-100 max-height-100 border-radius-lg shadow" src="{{ $img_d }}" alt="Image description">
                                    </a>
                                </figure>
                                @endif
                                @if (file_exists( public_path() . $img_f ))
                                <figure class="ms-2 me-3" itemprop="associatedMedia" itemscope="" itemtype="">
                                    <a href="{{ $img_f }}" itemprop="contentUrl" data-size="500x600">
                                        <img class="w-100 min-height-100 max-height-100 border-radius-lg shadow" src="{{ $img_f }}" alt="Image description">
                                    </a>
                                </figure>
                                @endif
                                @if (file_exists( public_path() . $img_l ))
                                <figure class="ms-2 me-3" itemprop="associatedMedia" itemscope="" itemtype="">
                                    <a href="{{ $img_l }}" itemprop="contentUrl" data-size="500x600">
                                        <img class="w-100 min-height-100 max-height-100 border-radius-lg shadow" src="{{ $img_l }}" alt="Image description">
                                    </a>
                                </figure>
                                @endif
                                @if (file_exists( public_path() . $img_p ))
                                <figure class="ms-2 me-3" itemprop="associatedMedia" itemscope="" itemtype="">
                                    <a href="{{ $img_p }}" itemprop="contentUrl" data-size="500x600">
                                        <img class="w-100 min-height-100 max-height-100 border-radius-lg shadow" src="{{ $img_p }}" alt="Image description">
                                    </a>
                                </figure>
                                @endif
                                @if (file_exists( public_path() . $img_s ))
                                <figure class="ms-2 me-3" itemprop="associatedMedia" itemscope="" itemtype="">
                                    <a href="{{ $img_s }}" itemprop="contentUrl" data-size="500x600">
                                        <img class="w-100 min-height-100 max-height-100 border-radius-lg shadow" src="{{ $img_s }}" alt="Image description">
                                    </a>
                                </figure>
                                @endif
                            </div>

                            <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

                                <div class="pswp__bg"></div>

                                <div class="pswp__scroll-wrap">

                                    <div class="pswp__container" style="transform: translate3d(0px, 0px, 0px);">
                                        <div class="pswp__item" style="display: block; transform: translate3d(-2131px, 0px, 0px);">
                                            <div class="pswp__zoom-wrap" style="transform: translate3d(722px, 44px, 0px) scale(1);">

                                            </div>
                                        </div>
                                        <div class="pswp__item" style="transform: translate3d(0px, 0px, 0px);">
                                            <div class="pswp__zoom-wrap" style="transform: translate3d(813.594px, 215.875px, 0px) scale(0.217786);">

                                            </div>
                                        </div>
                                        <div class="pswp__item" style="display: block; transform: translate3d(2131px, 0px, 0px);">
                                            <div class="pswp__zoom-wrap" style="transform: translate3d(722px, 44px, 0px) scale(1);">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="pswp__ui pswp__ui--fit pswp__ui--hidden">
                                        <div class="pswp__top-bar" style="z-index: 99999999;position: absolute;top: 8%;left: 50%;margin-right: -50%;transform: translate(-50%, -50%);">
                                            <div class="pswp__counter">5 / 5</div>
                                            <button class="btn btn-white btn-sm pswp__button pswp__button--close">Close(Esc)</button>
                                            <!--<button class="btn btn-white btn-sm pswp__button pswp__button--fs">Fullscreen</button>-->
                                            <button class="btn btn-white btn-sm pswp__button pswp__button--arrow--left">Prev</button>
                                            <button class="btn btn-white btn-sm pswp__button pswp__button--arrow--right">Next</button>
                                            <div class="pswp__preloader">
                                                <div class="pswp__preloader__icn">
                                                    <div class="pswp__preloader__cut">
                                                        <div class="pswp__preloader__donut"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                                            <div class="pswp__share-tooltip"></div>
                                        </div>
                                        <div class="pswp__caption">
                                            <div class="pswp__caption__center"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 mx-auto">
                            <h3 class="mt-lg-0 mt-4">{{ $product[0]['ITEM_NAME'] }}</h3>
                            <div class="rating">
                                <i class="fas fa-star" aria-hidden="true"></i>
                                <i class="fas fa-star" aria-hidden="true"></i>
                                <i class="fas fa-star" aria-hidden="true"></i>
                                <i class="fas fa-star" aria-hidden="true"></i>
                                <i class="fas fa-star-half-alt" aria-hidden="true"></i>
                            </div>
                            <br>
                            <h6 class="mb-0 mt-3">Price</h6>
                            <h5>฿{{ ($product[0]->RATE7 != '' ? number_format($product[0]->RATE7, 2) : '')}}</h5>
                            @if($product[0]['STOCK_IN_HAND'] != '')

                              @if(number_format($product[0]['STOCK_IN_HAND']) > 0)
                                <span class="badge badge-success">In Stock</span>
                              @else
                                <span class="badge badge-danger">No Stock</span>
                              @endif
                            @else
                              <span class="badge badge-danger">No Stock</span>
                            @endif

                            <br>
                            <h6 class="mt-4">Description</h6>

                            <ul class="list-group">
                                <li class="list-group-item border-0 d-flex p-3 mb-2  border-radius-lg">
                                    <div class="d-flex flex-column">
                                      <span class="mb-2 text-sm">ITEM CODE:
                                        <span class="text-danger font-weight-bold ms-sm-2">{{ $product[0]['ITEM_CODE'] }}</span>
                                      </span>
                                      <!--<span class="mb-2 text-sm">ITEM NAME EN:
                                        <span class="text-dark font-weight-bold ms-sm-2">{{ $product[0]['ITEM_NAME'] }}</span>
                                      </span>-->
                                      <span class="mb-2 text-sm">ITEM STATUS:
                                        <span class="text-dark font-weight-bold ms-sm-2">{{ $product[0]['ITEM_STATUS'] }}</span>
                                      </span>
                                      <span class="mb-2 text-sm">ITEM INVENTORY CODE:
                                        <span class="text-dark font-weight-bold ms-sm-2">{{ $product[0]['ITEM_INVENTORY_CODE'] }}</span>
                                      </span>
                                      <span class="mb-2 text-sm">ITEM REPL TIME:
                                        <span class="text-dark font-weight-bold ms-sm-2">{{ $product[0]['ITEM_REPL_TIME'] }}</span> (Days)
                                      </span>
                                      <span class="mb-2 text-sm">ITEM GRADE CODE 1:
                                        <span class="text-dark font-weight-bold ms-sm-2">{{ $product[0]['ITEM_GRADE_CODE_1'] }}</span>
                                      </span>
                                      <span class="mb-2 text-sm">ITEM UOM CODE:
                                        <span class="text-dark font-weight-bold ms-sm-2">{{ $product[0]['ITEM_UOM_CODE'] }}</span>
                                      </span>

                                      <span class="mb-2 text-sm">FREE STOCK:
                                        <span class="text-dark font-weight-bold ms-sm-2">{{ ($product[0]['STOCK_IN_HAND'] != '') ? number_format($product[0]['STOCK_IN_HAND']) : 0 }}</span>
                                      </span>
                                      <span class="mb-2 text-sm">PROJECT ITEM:
                                        <a href="{{ route('products.index').'/'.$product[0]['PROJECT_ITEM'].'?view='.request()->view }}"><span class="text-dark font-weight-bold ms-sm-2">{{ $product[0]['PROJECT_ITEM'] }}</span></a>
                                      </span>
                                      <span class="mb-2 text-sm">PRICE LIST UOM:
                                        <span class="text-dark font-weight-bold ms-sm-2">{{ $product[0]['PRICE_LIST_UOM'] }}</span>
                                      </span>
                                      <span class="mb-2 text-sm">PACK CONV FACTOR:
                                        <span class="text-dark font-weight-bold ms-sm-2">{{ $product[0]['PACK_CONV_FACTOR'] }}</span>
                                      </span>
                                      <span class="mb-2 text-sm">LIST PRICE EXCLUDE VAT:
                                        <span class="text-danger font-weight-bolder ms-sm-2">{{ ($product[0]->RATE != '' ? number_format($product[0]->RATE, 2) : '')}}</span>
                                      </span>
                                      <span class="mb-2 text-sm">LIST PRICE INCLUDE VAT:
                                        <span class="text-danger font-weight-bolder ms-sm-2">{{ ($product[0]->RATE7 != '' ? number_format($product[0]->RATE7, 2) : '')}}</span>

                                        @if(request()->input('admin') == 'admin')
                                        {{ ' / '. $product[0]['CURRWAC'] }}
                                        @endif
                                      </span>
                                      @if(request()->input('view') == 'supervisor')
                                      <span class="mb-2 text-sm">CURRENT WAC:
                                        <span class="text-warning font-weight-bolder ms-sm-2">{{ ($product[0]->CURRWAC != '' ? number_format($product[0]->CURRWAC, 2) : '')}}</span>
                                      </span>
                                      <span class="mb-2 text-sm">NEW WAC:
                                        <span class="text-warning font-weight-bolder ms-sm-2">{{ ($product[0]->NEWWAC != '' ? number_format($product[0]->NEWWAC, 2) : '')}}</span>
                                      </span>
                                      @endif
                                      <span class="mb-2 text-sm">NEW ITEM:
                                        <a href="{{ route('products.index').'/'.$product[0]['NEW_ITEM'].'?view='.request()->view }}"><span class="text-dark font-weight-bold ms-sm-2">{{ $product[0]['NEW_ITEM'] }}</span></a>
                                      </span>

                                      <span class="text-danger text-lg">ก่อนทำการสั่งซื้อกรุณาตรวจสอบข้อมูลกับพนักงานขายอีกครั้ง</span>
                                      <span class="text-danger text-lg">(Kindly contact the salesperson before ordering.)</span>
                                    </div>
                              </li>
                            </ul>
                            @if(request()->input('view') == 'sales')
                            <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                <div class="d-flex flex-column">
                                    <h6 class="mb-3 text-sm">More specific details</h6>
                                    <span class="mb-2 text-sm">ITEM NAME TH:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ $product[0]['ITEM_NAME_TH'] }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">ITEM BRAND:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ $product[0]['ITEM_BRAND'] }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">PENDING SO:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ ($product[0]['PENDING_SO'] != '') ? number_format($product[0]['PENDING_SO']) : 0 }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">AVAILABLE STOCK:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ ($product[0]['AVAILABLE_STOCK'] != '') ? number_format($product[0]['AVAILABLE_STOCK']) : 0 }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">ITEM GRADE CODE 2:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ $product[0]['ITEM_GRADE_CODE_2'] }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">PRODUCT CATEGORY:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ $product[0]['PRODUCT_CATEGORY'] }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">PRODUCT GROUP:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ $product[0]['PRODUCT_GROUP'] }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">PRODUCT AIS:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ $product[0]['PRODUCT_AIS'] }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">PURCHASER NAME:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ $product[0]['PURCHASER_NAME'] }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">PM NAME:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ $product[0]['PM_NAME'] }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">SALES CATEGORY:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ $product[0]['SALES_CATEGORY'] }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">PACK CONV FACTOR:
                                      <span class="text-dark font-weight-bold ms-sm-2">{{ $product[0]['PACK_CONV_FACTOR'] }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">PRICE CLR(Incl.VAT):
                                      <span class="text-danger font-weight-bolder ms-sm-2">{{ ($product[0]['PRICE_CLR'] != '') ? number_format($product[0]['PRICE_CLR']) : 0 }}</span>
                                    </span>
                                    <span class="mb-2 text-sm">STOCK CLR:
                                      <span class="text-danger font-weight-bolder ms-sm-2">{{ ($product[0]['STOCK_CLR'] != '') ? number_format($product[0]['STOCK_CLR_CAL']) : 0 }}</span>
                                    </span>
                                </div>
                              </li>
                              @endif
                            <?php
                              $user_manual = '';
                              if($product[0]['USER_MANUAL'] != ''){
                                $user_manual = '/storage/img/user_manual/' . $product[0]['USER_MANUAL'];
                                if (file_exists( public_path() . $user_manual )) {
                            ?>
                            <div class="row mt-4">
                                <div class="col-lg-5">
                                    <a href="{{ $user_manual }}" target="_blank">
                                        <button class="btn btn-icon btn-outline-primary ms-2 export" data-type="csv" type="button" onclick="show_user_manual()">
                                          <span class="btn-inner--icon"><i class="ni ni-folder-17"></i></span>
                                          <span class="btn-inner--text">User Manual (PDF)</span>
                                        </button>
                                    </a>
                                </div>
                            </div>
                            <?php
                                }
                              }
                             ?>


                        </div>
                    </div>
                    @if(count($orther_product) > 0 )
                    <div class="row mt-5">
                        <div class="col-12">
                            <h5 class="ms-3">Other Products</h5>
                            <div class="table table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Item Code</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Item Name</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"> LIST PRICE INCLUDE VAT</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"> FREE STOCK</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"></th>
                                        </tr>
                                    </thead>


                                    <?php
                                      $image = '/storage/img/products/' . $product[0]->ITEM_CODE . '.jpg';
                                      $image2 = '/storage/img/products/' . $product[0]->ITEM_CODE . '.JPG';
                                      if (file_exists( public_path() . $image )) {
                                          $img = $image;
                                      }elseif(file_exists( public_path() . $image2 )){
                                          $img = $image2;
                                      } else {
                                        $img = "/storage/img/coming_soon.jpg";
                                      }
                                     ?>


                                    <tbody>
                                        @foreach($orther_product as $value)
                                        <?php
                                          $image = '/storage/img/products/' . $value->ITEM_CODE . '.jpg';
                                          $image2 = '/storage/img/products/' . $value->ITEM_CODE . '.JPG';
                                          if (file_exists( public_path() . $image )) {
                                              $img = $image;
                                          }elseif(file_exists( public_path() . $image2 )){
                                              $img = $image2;
                                          } else {
                                            $img = "/storage/img/coming_soon.jpg";
                                          }
                                         ?>
                                        <tr>
                                            <td>
                                                <a href="{{ route('products.index').'/'.$value->ITEM_CODE.'?view='.request()->view }}">
                                                  <div class="d-flex px-2 py-1">
                                                      <div>
                                                          <img src="{{ $img }}" class="avatar avatar-md me-3" alt="table image">
                                                      </div>
                                                      <div class="d-flex flex-column justify-content-center">
                                                          <h6 class="mb-0 text-sm">{{ $value->ITEM_CODE ?? '' }}</h6>
                                                      </div>
                                                  </div>
                                                </a>
                                            </td>
                                            <td>

                                                  <p class="text-sm text-secondary mb-0">{{ $value->ITEM_NAME ?? '' }}</p>

                                            </td>
                                            <td>
                                                <p class="text-sm text-secondary mb-0">฿{{ ($value->RATE7 != '' ? number_format($value->RATE7, 2) : '')}}</p>
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-secondary text-sm">{{ ($value->STOCK_IN_HAND != '') ? number_format($value->STOCK_IN_HAND) : 0 }}</span>
                                            </td>
                                            <td class="align-middle">
                                              @if($value->STOCK_IN_HAND != '')
                                                @if(number_format($value->STOCK_IN_HAND) > 0)
                                                  <span class="badge badge-success badge-sm">In Stock</span>
                                                @else
                                                  <span class="badge badge-danger badge-sm">No Stock</span>
                                                @endif
                                              @else
                                                <span class="badge badge-danger badge-sm">No Stock</span>
                                              @endif

                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
                    <a href="{{ route('products.index') .'?view='.request()->input('view') }}">
                      <div class="icon icon-shape bg-gradient-primary shadow text-center mb-4 mt-5">
                        <i class="ni ni-curved-next opacity-10 icon-flipped" aria-hidden="true"></i>
                      </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
  $(function(){
    //$('#modal-user-manual').modal('show');
  });

    // Products gallery
    var initPhotoSwipeFromDOM = function(gallerySelector) {

        // parse slide data (url, title, size ...) from DOM elements
        // (children of gallerySelector)
        var parseThumbnailElements = function(el) {
            var thumbElements = el.childNodes,
                numNodes = thumbElements.length,
                items = [],
                figureEl,
                linkEl,
                size,
                item;

            for (var i = 0; i < numNodes; i++) {

                figureEl = thumbElements[i]; // <figure> element
                // include only element nodes
                if (figureEl.nodeType !== 1) {
                    continue;
                }

                linkEl = figureEl.children[0]; // <a> element

                size = linkEl.getAttribute('data-size').split('x');

                // create slide object
                item = {
                    src: linkEl.getAttribute('href'),
                    w: parseInt(size[0], 10),
                    h: parseInt(size[1], 10)
                };

                if (figureEl.children.length > 1) {
                    // <figcaption> content
                    item.title = figureEl.children[1].innerHTML;
                }

                if (linkEl.children.length > 0) {
                    // <img> thumbnail element, retrieving thumbnail url
                    item.msrc = linkEl.children[0].getAttribute('src');
                }

                item.el = figureEl; // save link to element for getThumbBoundsFn
                items.push(item);
            }

            return items;
        };

        // find nearest parent element
        var closest = function closest(el, fn) {
            return el && (fn(el) ? el : closest(el.parentNode, fn));
        };

        // triggers when user clicks on thumbnail
        var onThumbnailsClick = function(e) {
            e = e || window.event;
            e.preventDefault ? e.preventDefault() : e.returnValue = false;

            var eTarget = e.target || e.srcElement;

            // find root element of slide
            var clickedListItem = closest(eTarget, function(el) {
                return (el.tagName && el.tagName.toUpperCase() === 'FIGURE');
            });

            if (!clickedListItem) {
                return;
            }

            // find index of clicked item by looping through all child nodes
            // alternatively, you may define index via data- attribute
            var clickedGallery = clickedListItem.parentNode,
                childNodes = clickedListItem.parentNode.childNodes,
                numChildNodes = childNodes.length,
                nodeIndex = 0,
                index;

            for (var i = 0; i < numChildNodes; i++) {
                if (childNodes[i].nodeType !== 1) {
                    continue;
                }

                if (childNodes[i] === clickedListItem) {
                    index = nodeIndex;
                    break;
                }
                nodeIndex++;
            }



            if (index >= 0) {
                // open PhotoSwipe if valid index found
                openPhotoSwipe(index, clickedGallery);
            }
            return false;
        };

        // parse picture index and gallery index from URL (#&pid=1&gid=2)
        var photoswipeParseHash = function() {
            var hash = window.location.hash.substring(1),
                params = {};

            if (hash.length < 5) {
                return params;
            }

            var vars = hash.split('&');
            for (var i = 0; i < vars.length; i++) {
                if (!vars[i]) {
                    continue;
                }
                var pair = vars[i].split('=');
                if (pair.length < 2) {
                    continue;
                }
                params[pair[0]] = pair[1];
            }

            if (params.gid) {
                params.gid = parseInt(params.gid, 10);
            }

            return params;
        };

        var openPhotoSwipe = function(index, galleryElement, disableAnimation, fromURL) {
            var pswpElement = document.querySelectorAll('.pswp')[0],
                gallery,
                options,
                items;

            items = parseThumbnailElements(galleryElement);

            // define options (if needed)
            options = {

                // define gallery index (for URL)
                galleryUID: galleryElement.getAttribute('data-pswp-uid'),

                getThumbBoundsFn: function(index) {
                    // See Options -> getThumbBoundsFn section of documentation for more info
                    var thumbnail = items[index].el.getElementsByTagName('img')[0], // find thumbnail
                        pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                        rect = thumbnail.getBoundingClientRect();

                    return {
                        x: rect.left,
                        y: rect.top + pageYScroll,
                        w: rect.width
                    };
                }

            };

            // PhotoSwipe opened from URL
            if (fromURL) {
                if (options.galleryPIDs) {
                    // parse real index when custom PIDs are used
                    // http://photoswipe.com/documentation/faq.html#custom-pid-in-url
                    for (var j = 0; j < items.length; j++) {
                        if (items[j].pid == index) {
                            options.index = j;
                            break;
                        }
                    }
                } else {
                    // in URL indexes start from 1
                    options.index = parseInt(index, 10) - 1;
                }
            } else {
                options.index = parseInt(index, 10);
            }

            // exit if index not found
            if (isNaN(options.index)) {
                return;
            }

            if (disableAnimation) {
                options.showAnimationDuration = 0;
            }

            // Pass data to PhotoSwipe and initialize it
            gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
            gallery.init();
        };

        // loop through all gallery elements and bind events
        var galleryElements = document.querySelectorAll(gallerySelector);

        for (var i = 0, l = galleryElements.length; i < l; i++) {
            galleryElements[i].setAttribute('data-pswp-uid', i + 1);
            galleryElements[i].onclick = onThumbnailsClick;
        }

        // Parse URL and open gallery if it contains #&pid=3&gid=1
        var hashData = photoswipeParseHash();
        if (hashData.pid && hashData.gid) {
            openPhotoSwipe(hashData.pid, galleryElements[hashData.gid - 1], true, true);
        }
    };

    // execute above function
    initPhotoSwipeFromDOM('.my-gallery');
</script>
@endsection

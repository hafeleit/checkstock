@if($count > 0)
<ul class="list-group">
    @foreach($data as $value)


    <li class="list-group-item border-2 d-flex justify-content-between mb-2 border-radius-lg">
        <div class="d-flex flex-column">

            <span class="mb-2 text-xs">Serial No.: <span class="text-dark ms-sm-2 font-weight-bold">{{ $value->serial_no }}</span></span>
            <span class="mb-2 text-xs">Register Date: <span class="text-dark ms-sm-2 font-weight-bold">{{$value->created_at}}</span></span>
            <span class="mb-2 text-xs">Phone number: <span class="text-dark ms-sm-2 font-weight-bold">{{$value->tel}}</span></span>
            <?php /* ?><span class="mb-2 text-xs">Address: <span class="text-dark ms-sm-2 font-weight-bold">{{$value->addr}}</span></span> <?php */ ?>
            <span class="mb-2 text-xs">Order channel: <span class="text-dark ms-sm-2 font-weight-bold">{{$value->order_channel}}</span></span>
            <span class="mb-2 text-xs">Order number: <span class="text-dark ms-sm-2 font-weight-bold">{{$value->order_number}}</span></span>
        </div>
        <div class="d-flex align-items-center text-sm">
            <div class="btn btn-link">
              <?php
                $image = '/storage/img/warranty/' . $value->file_name;
                $image2 = $value->file_name;
                if (file_exists( public_path() . $image )) {
                    echo '<img src="'.$image.'" class="img" alt="" width="100">';
                }elseif(file_exists( public_path() . $image2 )){
                    echo '<img src="'.$image2.'" class="img" alt="" width="100">';
                }
               ?>
            </div>
        </div>
    </li>
    @endforeach
</ul>
@else
<ul class="list-group">
    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
        <div class="d-flex flex-column">
            <h6 class="mb-1 text-danger font-weight-bold text-sm">No data</h6>
        </div>
    </li>
</ul>
@endif

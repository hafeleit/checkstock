@if($count > 0)
<ul class="list-group">
    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
        <div class="d-flex flex-column">

            <span class="mb-2 text-xs">Serial No.: <span class="text-dark ms-sm-2 font-weight-bold">{{ $data->serial_no }}</span></span>
            <span class="mb-2 text-xs">Register Date: <span class="text-dark ms-sm-2 font-weight-bold">{{$data->created_at}}</span></span>
            <span class="mb-2 text-xs">Phone number: <span class="text-dark ms-sm-2 font-weight-bold">{{$data->tel}}</span></span>
            <span class="mb-2 text-xs">Address: <span class="text-dark ms-sm-2 font-weight-bold">{{$data->addr}}</span></span>
            <span class="mb-2 text-xs">Order channel: <span class="text-dark ms-sm-2 font-weight-bold">{{$data->order_channel}}</span></span>
            <span class="mb-2 text-xs">Order number: <span class="text-dark ms-sm-2 font-weight-bold">{{$data->order_number}}</span></span>
        </div>
        <div class="d-flex align-items-center text-sm">
            <div class="btn btn-link">
              <?php
                $image = '/storage/img/warranty/' . $data->file_name;
                $image2 = $data->file_name;
                if (file_exists( public_path() . $image )) {
                    echo '<img src="'.$image.'" class="img" alt="" width="100">';
                }else{
                    echo '<img src="'.$image2.'" class="img" alt="" width="100">';
                }
               ?>
            </div>
        </div>
    </li>
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

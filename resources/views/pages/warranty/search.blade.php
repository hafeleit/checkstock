@if($count > 0)
<ul class="list-group">
    @foreach($data as $value)
        <li class="list-group-item border-2 d-flex justify-content-between mb-2 border-radius-lg">
            <div class="d-flex flex-column">

                <span class="mb-2 text-xs">Serial No.: <span class="text-dark ms-sm-2 font-weight-bold text-lg">{{ $value->serial_no }}</span></span>
                <span class="mb-2 text-xs">Register Date: <span class="text-dark ms-sm-2 font-weight-bold text-lg">{{ $value->created_at->format('d M Y') }}</span></span>
                <span class="mb-2 text-xs">Phone number: <span class="text-dark ms-sm-2 font-weight-bold text-lg">{{ $value->tel }}</span></span>
                <span class="mb-2 text-xs">Order channel: <span class="text-dark ms-sm-2 font-weight-bold text-lg">{{ $value->order_channel }}</span></span>
                @if ($value->other_channel)
                    <span class="mb-2 text-xs">Other channel: <span class="text-dark ms-sm-2 font-weight-bold text-lg">{{ $value->other_channel }}</span></span>
                @endif
                <span class="mb-2 text-xs">Order number: <span class="text-dark ms-sm-2 font-weight-bold text-lg">{{ $value->order_number }}</span></span>

                <span>
                    @if($value->file_name && file_exists(storage_path('app/warranty/' . $value->file_name)))
                    <?php $image = route('warranty.image', $value->file_name); ?>
                    <a href="{{ $image }}" target="_blank"><img src="{{ $image }}" class="img shadow mx-1" alt="" width="50"></a>
                    @endif

                    @if($value->file_name2 && file_exists(storage_path('app/warranty/' . $value->file_name2)))
                    <?php $image = route('warranty.image', $value->file_name2); ?>
                    <a href="{{ $image }}" target="_blank"><img src="{{ $image }}" class="img shadow mx-1" alt="" width="50"></a>
                    @endif

                    @if($value->file_name3 && file_exists(storage_path('app/warranty/' . $value->file_name3)))
                    <?php $image = route('warranty.image', $value->file_name3); ?>
                    <a href="{{ $image }}" target="_blank"><img src="{{ $image }}" class="img shadow mx-1" alt="" width="50"></a>
                    @endif

                    @if($value->file_name4 && file_exists(storage_path('app/warranty/' . $value->file_name4)))
                    <?php $image = route('warranty.image', $value->file_name4); ?>
                    <a href="{{ $image }}" target="_blank"><img src="{{ $image }}" class="img shadow mx-1" alt="" width="50"></a>
                    @endif

                    @if($value->file_name5 && file_exists(storage_path('app/warranty/' . $value->file_name5)))
                    <?php $image = route('warranty.image', $value->file_name5); ?>
                    <a href="{{ $image }}" target="_blank"><img src="{{ $image }}" class="img shadow mx-1" alt="" width="50"></a>
                    @endif
                </span>
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
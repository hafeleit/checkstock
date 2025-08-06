@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'ยอดรวม Commission ราย Sales Rep'])
<div id="alert">
    @include('components.alert')
</div>

<div class="container-fluid py-4">
  @if ($errors->any())
      <div class="alert alert-danger">
          <ul class="mb-0">
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
  @endif
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Commission</p>
                                <h5 class="font-weight-bolder">
                                    {{ number_format( $totalCommissions, 2 ) }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Commission ID: {{ $commission->sub_id }}</h5>
                        <small class="text-muted">Status: {{ $commission->status }}</small>
                    </div>

                    <a href="{{ route('commissions.index') }}" class="btn bg-gradient-secondary btn-sm">
                        ← ย้อนกลับ
                    </a>
                </div>

                <div class="card-body pt-3">
                    <form method="GET" class="row g-2 mb-4">
                        <div class="col-md-10 col-sm-12">
                            <input type="text" name="search" class="form-control" placeholder="ค้นหา Sales Rep หรือ Sales Name" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2 col-sm-12 text-end">
                            <button type="submit" class="btn bg-gradient-success w-100">
                                <i class="fas fa-search me-1"></i> ค้นหา
                            </button>
                        </div>
                    </form>
                    <div class="col-lg-12 col-md-3 col-sm-6 d-flex ">

                          <button type="button"
                                  class="btn btn-sm bg-gradient-info px-3 me-2"
                                  id="export-btn"
                                  data-url="{{ route('commissions.summary-export', $commission->id) }}">
                              <i class="fas fa-file-export me-1"></i> Export
                          </button>

                      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                      <script>
                      document.getElementById('export-btn')?.addEventListener('click', function () {
                          const url = this.getAttribute('data-url');

                          Swal.fire({
                              title: 'กำลังส่งออกข้อมูล...',
                              text: 'ระบบกำลังสร้างไฟล์ Excel',
                              allowOutsideClick: false,
                              allowEscapeKey: false,
                              didOpen: () => {
                                  Swal.showLoading();
                              }
                          });

                          fetch(url, {
                              headers: {
                                  'X-Requested-With': 'XMLHttpRequest',
                                  'Accept': 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                              }
                          })
                          .then(response => {
                              if (!response.ok) throw new Error('ไม่สามารถส่งออกไฟล์ได้');

                              // ✅ ดึงชื่อไฟล์จาก Content-Disposition
                              const disposition = response.headers.get('Content-Disposition');
                              let filename = 'commissions_export.xlsx';

                              if (disposition && disposition.indexOf('filename=') !== -1) {
                                  const filenameRegex = /filename[^;=\n]*=(['"]?)([^'"\n]*)\1?/;
                                  const matches = filenameRegex.exec(disposition);
                                  if (matches != null && matches[2]) {
                                      filename = decodeURIComponent(matches[2]);
                                  }
                              }

                              return response.blob().then(blob => ({ blob, filename }));
                          })
                          .then(({ blob, filename }) => {
                              const link = document.createElement('a');
                              const url = window.URL.createObjectURL(blob);
                              link.href = url;
                              link.download = filename;
                              document.body.appendChild(link);
                              link.click();

                              // ทำความสะอาด
                              link.remove();
                              window.URL.revokeObjectURL(url);

                              Swal.close();
                          })
                          .catch(error => {
                              Swal.fire('เกิดข้อผิดพลาด', error.message, 'error');
                          });

                      });
                      </script>


                    </div>
                    <div class="table-responsive">

                        <table class="table table-hover align-items-center">
                            <thead>
                                <tr>
                                    <th>Sales Rep</th>
                                    <th>Sales Name</th>
                                    <th>Division</th>
                                    <th>Total Commissions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($summary as $item)
                                    <tr>
                                        <td>{{ $item->sales_rep }}</td>
                                        <td>{{ $item->name_en }}</td>
                                        <td>{{ $item->division }}</td>
                                        <td>{{ number_format($item->total_commissions,2) }}</td>

                                    </tr>
                                @empty
                                    <tr><td colspan="7" class="text-center text-muted">ไม่มีข้อมูล</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

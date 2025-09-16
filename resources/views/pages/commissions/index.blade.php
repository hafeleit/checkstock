@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Commissions'])
    <div>
        @include('components.alert')
    </div>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Commissions List</h5>
                @can('Commissions Import')
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#importModal">
                    <i class="fas fa-file-upload me-1"></i> Import
                </button>
                @endcan
            </div>

            <div class="table-responsive p-3">
                <table class="table table-hover align-items-center mb-0">
                    <thead class="bg-light">
                        <tr>
                          <th>ID</th>
                          <th>Month</th>
                          <th>Status</th>
                          @cannot('Commissions Check')
                          <th>Schema ID</th>
                          <th>HR Comment</th>
                          <th>FIN Comment</th>
                          <th>Create By</th>
                          @endcan
                          <th>Date Create</th>
                          <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      @forelse ($commissions as $c)
                          <tr>
                              <td>{{ $c->sub_id }}</td>
                              <td>{{ \Carbon\Carbon::createFromFormat('Ym', substr($c->sub_id, 0, 6))->format('F Y') }}</td>

                              <td>
                                <small class="badge
                                    {{ stripos($c->status, 'Reject') !== false ? 'bg-danger' :'bg-success' }}">
                                    {{ $c->status }}
                                </small>
                              </td>
                              @cannot('Commissions Check')
                              <td>{{ $c->schema_id }}</td>
                              <td>{{ $c->hr_comment }}</td>
                              <td>{{ $c->fin_comment }}</td>
                              <td>{{ $c->creator ? $c->creator->username : 'ไม่พบชื่อผู้ใช้' }}</td>
                              @endcan
                              <td>{{ $c->created_at->format('Y-m-d H:i') }}</td>
                              <td>
                                  @can('Commissions AR-View')
                                  <a href="{{ route('commissions.show', $c->id) }}" class="btn btn-info btn-sm">
                                      <i class="fas fa-file-alt me-1"></i> ดูรายละเอียด
                                  </a>
                                  @endcan
                                  @can('Commissions Summary-View')
                                  <a href="{{ route('commissions.sales-summary', $c->id) }}" class="btn btn-sm btn-primary">
                                      <i class="fas fa-chart-bar me-1"></i> ดูยอดรวม
                                  </a>
                                  @endcan
                                  @if(in_array($c->status, ['Summary Confirmed', 'Summary Approved', 'Final Approved']))
                                    @can('Commissions Check')
                                      <a href="javascript:void(0)" class="btn btn-sm btn-success commissions-link" data-id="{{ $c->id }}">
                                          <i class="fas fa-check-circle me-1"></i> ตรวจสอบ Commission
                                      </a>
                                      <script>
                                      document.querySelectorAll('.commissions-link').forEach(function(button) {
                                      button.addEventListener('click', function() {
                                          const commissionId = this.dataset.id; // ดึงจาก data-id
                                          Swal.fire({
                                              title: 'Confirm Password',
                                              input: 'password',
                                              inputLabel: 'Password',
                                              inputPlaceholder: 'Enter your password',
                                              inputAttributes: {
                                                  autocapitalize: 'off',
                                                  autocorrect: 'off',
                                                  autocomplete: 'off',
                                              },
                                              showCancelButton: true,
                                              confirmButtonText: 'Confirm',
                                              showLoaderOnConfirm: true,
                                              inputValidator: (value) => {
                                                  if (!value) {
                                                      return 'กรุณากรอกรหัสผ่านก่อน';
                                                  }
                                              },
                                              preConfirm: (password) => {
                                                  return fetch('{{ route("commission.verify-password") }}', {
                                                      method: 'POST',
                                                      headers: {
                                                          'Content-Type': 'application/json',
                                                          'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                      },
                                                      body: JSON.stringify({ password: password })
                                                  })
                                                  .then(async response => {
                                                      const data = await response.json();
                                                      if (!response.ok) {
                                                          throw new Error(data.error || 'เกิดข้อผิดพลาด');
                                                      }
                                                      return data;
                                                  })
                                                  .catch(error => {
                                                      Swal.showValidationMessage(error.message);
                                                  });
                                              },
                                              allowOutsideClick: () => !Swal.isLoading()
                                          }).then((result) => {
                                              if (result.isConfirmed && result.value.success) {
                                                  window.location.href = '/commissions/' + commissionId + '/check';
                                              } else if(result.isConfirmed) {
                                                  Swal.fire('Error', 'Incorrect password', 'error');
                                              }
                                          });
                                      });
                                  });

                                      </script>
                                    @endcan
                                  @endif
                                  @can('Commissions Delete')
                                    @if(in_array($c->status, ['imported', 'calculated','Summary Rejected']))
                                    <form method="POST" action="{{ route('commissions.destroy', $c->id) }}" class="delete-form d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-delete">
                                            <i class="fas fa-trash-alt me-1"></i> ลบ
                                        </button>
                                    </form>
                                    @endif
                                  @endcan
                              </td>
                          </tr>
                      @empty
                          <tr>
                              <td colspan="8" class="text-center">ยังไม่มีข้อมูล</td>
                          </tr>
                      @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Import Modal -->
        <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="importForm" action="{{ route('commissions.import') }}" method="POST" enctype="multipart/form-data" class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="importModalLabel">Import Commission Files</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="file1" class="form-label">Upload File (Commission AR)</label>
                            <input type="file" class="form-control" id="file1" name="file1">
                        </div>
                        <!--
                        <div class="mb-3">
                            <label for="file2" class="form-label">Upload File 2 (Commission CN)</label>
                            <input type="file" class="form-control" id="file2" name="file2">
                        </div>
                        <div class="text-muted small">
                            * สามารถเลือกไฟล์ใดไฟล์หนึ่ง หรือทั้งสองไฟล์ได้
                        </div>-->
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Import</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script>
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function () {
            Swal.fire({
                title: 'คุณแน่ใจหรือไม่?',
                text: "คุณจะไม่สามารถกู้คืนข้อมูลนี้ได้!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'ใช่, ลบเลย!',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    // ส่ง form
                    this.closest('form').submit();
                }
            })
        });
    });

    document.getElementById('importForm').addEventListener('submit', function(e) {
        // แสดง loading popup ด้วย SweetAlert2
        Swal.fire({
            title: 'กำลังประมวลผล...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading()
            }
        });
    });
    </script>

@endsection

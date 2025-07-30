@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Commissions'])
    <div id="alert">
        @include('components.alert')
    </div>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Commissions List</h5>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#importModal">
                    <i class="fas fa-file-upload me-1"></i> Import
                </button>
            </div>

            <div class="table-responsive p-3">
                <table class="table table-hover align-items-center mb-0">
                    <thead class="bg-light">
                        <tr>
                          <th>#</th>
                          <th>Sub ID</th>
                          <th>Status</th>
                          <th>HR Comment</th>
                          <th>FIN Comment</th>
                          <th>Create By</th>
                          <th>Date Create</th>
                          <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      @forelse ($commissions as $c)
                          <tr>
                              <td>{{ $c->id }}</td>
                              <td>{{ $c->sub_id }}</td>
                              <td>{{ $c->status }}</td>
                              <td>{{ $c->hr_comment }}</td>
                              <td>{{ $c->fin_comment }}</td>

                              <td>{{ $c->creator ? $c->creator->username : 'ไม่พบชื่อผู้ใช้' }}</td>
                              <td>{{ $c->created_at->format('Y-m-d H:i') }}</td>
                              <td>
                                  <a href="{{ route('commissions.show', $c->id) }}" class="btn btn-info btn-sm">ดูรายละเอียด</a>
                                  <form method="POST" action="{{ route('commissions.destroy', $c->id) }}" class="delete-form d-inline">
                                      @csrf
                                      @method('DELETE')
                                      <button type="button" class="btn btn-danger btn-sm btn-delete">ลบ</button>
                                  </form>
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
                            <label for="file1" class="form-label">Upload File 1 (Commission AR)</label>
                            <input type="file" class="form-control" id="file1" name="file1">
                        </div>
                        <div class="mb-3">
                            <label for="file2" class="form-label">Upload File 2 (Commission CN)</label>
                            <input type="file" class="form-control" id="file2" name="file2">
                        </div>
                        <div class="text-muted small">
                            * สามารถเลือกไฟล์ใดไฟล์หนึ่ง หรือทั้งสองไฟล์ได้
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Import</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

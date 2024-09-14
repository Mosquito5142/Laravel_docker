@extends('layout')
@section('title', 'Blog')
@section('content')
    <h2>บทความทั้งหมด</h2>
    <hr>
    
    <!-- SweetAlert Trigger -->
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                html: '<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
            });
        </script>
    @endif

        @if (count($blogs)>0)
        <div class="table-responsive">
            <table class="table table-striped table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>หัวข้อ</th>
                        <th>เนื้อหา</th>
                        <th>สถานะ</th>
                        <th>จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($blogs as $item)
                        <tr>
                            <td>{{ $item->title }}</td>
                            <td>{{ Str::limit($item->content, 10) }}</td>
                            <td>
                                @if ($item->status == true)
                                    <a class="btn btn-success" href="{{ route('change', $item->id) }}" onclick="showLoading()">เผยแพร่</a>
                                @else
                                    <a class="btn btn-danger" href="{{ route('change', $item->id) }}" onclick="showLoading()">ฉบับร่าง</a>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-warning" onclick="openModal('{{ $item->id }}', '{{ $item->title }}', '{{ $item->content }}')">แก้ไข</button>
                                <a href="{{ route('delete', $item->id) }}" class="btn btn-danger" onclick="return confirmDelete('{{ $item->title }}')">ลบ</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{$blogs->links()}}
        @else
            <h2>ไม่มีบทความ</h2>
        @endif

    <!-- Modal -->
    <div class="modal fade" id="dynamicEditModal" tabindex="-1" aria-labelledby="dynamicEditModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="dynamicEditModalLabel">แก้ไขบทความ</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="editForm" onsubmit="showLoading()">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="dynamicTitle" class="form-label">ชื่อบทความ</label>
                            <input type="text" class="form-control" id="dynamicTitle" name="title">
                        </div>
                        <div class="mb-3">
                            <label for="dynamicContent" class="form-label">เนื้อหาบทความ</label>
                            <textarea class="form-control" id="dynamicContent" name="content" rows="3"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModal(id, title, content) {
            // ใส่ข้อมูลในฟอร์ม
            document.getElementById('dynamicTitle').value = title;
            document.getElementById('dynamicContent').value = content;
            document.getElementById('editForm').action = `/update/${id}`;
            
            // แสดง Modal
            var modal = new bootstrap.Modal(document.getElementById('dynamicEditModal'));
            modal.show();
        }

        function showLoading() {
            Swal.fire({
                title: 'กำลังดำเนินการ...',
                text: 'โปรดรอสักครู่',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });
        }

        function confirmDelete(title) {
            return Swal.fire({
                title: 'คุณแน่ใจหรือไม่?',
                text: `คุณต้องการลบบทความ "${title}" ใช่หรือไม่`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่, ลบเลย!',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    showLoading();
                    return true;
                } else {
                    return false;
                }
            });
        }
    </script>
@endsection
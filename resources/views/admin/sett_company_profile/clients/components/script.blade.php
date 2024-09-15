<script>
    // Tambahkan event listener untuk tombol "Delete"
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-button');
        deleteButtons.forEach((button) => {
            button.addEventListener('click', function() {
                const id = button.getAttribute('data-id');
                Swal.fire({
                    title: 'Delete Confirmation',
                    text: 'Do you want to delete this client?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika pengguna mengonfirmasi, kirimkan permintaan penghapusan
                        const form = document.createElement('form');
                        form.setAttribute('action',
                            "{{ route('clients.destroy', '') }}" + '/' + id);
                        form.setAttribute('method', 'POST');
                        form.innerHTML = `
                            @csrf
                            @method('DELETE')
                        `;
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });
    });
</script>
<script>
    $(document).on('click', '.clientUpdate', function() {
        var _this = $(this).parents('tr');

        // Mengisi input dengan data dari tabel
        $('#e_id_client').val(_this.find('.id_client').text());
        $('#e_client_name').val(_this.find('.client_name').text());

        // Mengambil URL gambar dari elemen dengan kelas .image (misalnya src dari img tag atau atribut data)
        var imageUrl = _this.find('.image img').attr('src');

        // Menampilkan pratinjau gambar jika ada
        if (imageUrl) {
            $('#image_preview').attr('src', imageUrl).show();
        } else {
            $('#image_preview').hide();
        }
    });

    // Mengubah pratinjau gambar saat gambar baru dipilih
    $('#e_image').change(function() {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#image_preview').attr('src', e.target.result).show();
        }
        reader.readAsDataURL(this.files[0]);
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const perPageValue = document.querySelector('select[name="per_page"]').value;

        document.querySelectorAll('form').forEach(form => {
            let perPageInput = form.querySelector('input[name="per_page"]');
            if (!perPageInput) {
                perPageInput = document.createElement('input');
                perPageInput.type = 'hidden';
                perPageInput.name = 'per_page';
                form.appendChild(perPageInput);
            }
            perPageInput.value = perPageValue;
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#perPageSelect').change(function() {
            var perPage = $(this).val();
            var searchQuery = $('#searchQuery').val();
            var filteringMonth = '{{ request('filteringMonth') }}';
            var filterDate = '{{ request('filterDate') }}';

            $.ajax({
                url: '{{ route('clients.index') }}',
                type: 'GET',
                data: {
                    per_page: perPage,
                    q: searchQuery,
                    filteringMonth: filteringMonth,
                    filterDate: filterDate
                },
                success: function(data) {
                    $('#clientTableContainer').html($(data).find('#clientTableContainer')
                        .html());
                }
            });
        });
    });
</script>

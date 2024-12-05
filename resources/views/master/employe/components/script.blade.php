<script>
    // Tambahkan event listener untuk tombol "Delete"
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-button');
        deleteButtons.forEach((button) => {
            button.addEventListener('click', function() {
                const id = button.getAttribute('data-id');
                Swal.fire({
                    title: 'Delete Confirmation',
                    text: 'Do you want to delete this employe?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika pengguna mengonfirmasi, kirimkan permintaan penghapusan
                        const form = document.createElement('form');
                        form.setAttribute('action',
                            "{{ route('employe.destroy', '') }}" + '/' + id);
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
    $(document).on('click', '.employeUpdate', function() {
        let _this = $(this).parents('tr');

        // Ambil data dari baris tabel
        let code_employe = _this.find('.code_employe').text().trim();
        let name_group = _this.find('.name_group').text().trim();
        let name = _this.find('.name').text().trim();

        // Isi data ke dalam modal
        $('#e_hidden_code_employe').val(code_employe); // hidden input untuk code_employe
        $('#e_code_employe').val(code_employe); // field disabled
        $('#e_name').val(name);
        $('#e_id_group option').filter(function() {
            return $(this).text().trim() === name_group;
        }).prop('selected', true);
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
            let perPage = $(this).val();
            let searchQuery = $('#searchQuery').val();
            let filteringMonth = '{{ request('filteringMonth') }}';
            let filterDate = '{{ request('filterDate') }}';

            $.ajax({
                url: '{{ route('employe.index') }}',
                type: 'GET',
                data: {
                    per_page: perPage,
                    q: searchQuery,
                    filteringMonth: filteringMonth,
                    filterDate: filterDate
                },
                success: function(data) {
                    $('#employeTableContainer').html($(data).find('#employeTableContainer')
                        .html());
                }
            });
        });
    });
</script>
